<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines Order Completed Class.
 *
 * @link       https://www.deviodigital.com
 * @since      1.1
 *
 * @package    DDWC
 * @author     Devio Digital <deviodigital@gmail.com>
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'WC_Email' ) ) {
	return; // Exit if WooCommerce isn't active.
}

// Twilio client used in trigger below.
use Twilio\Rest\Client;

/**
 * Class WC_Order_Completed
 *
 * @since 1.1
 */
class WC_Order_Completed extends WC_Email {
	/**
	 * Create an instance of the class.
	 *
	 * @access public
	 * @return void
	 */
	function __construct() {
    // Email slug we can use to filter other data.
		$this->id          = 'ddwc_pro_order_completed';
		$this->title       = __( 'DDWC Order Delivered', 'ddwc-pro' );
		$this->description = __( 'An email sent to the administrator when an order is marked completed by delivery driver.', 'ddwc-pro' );

		// For admin area to let the user know we are not sending this email to customers.
		$this->customer_email = false;
		$this->heading        = __( 'Order Delivered', 'ddwc-pro' );

    // translators: placeholder is {blogname}, a variable that will be substituted when email is sent out
		$this->subject = sprintf( _x( '[%s] Order delivered', 'default email subject for order completed notice sent to administrator', 'ddwc-pro' ), '{blogname}' );

    // Template paths.
		$this->template_html  = 'emails/wc-order-completed.php';
		$this->template_plain = 'emails/plain/wc-order-completed.php';
		$this->template_base  = DDWC_PRO_EMAIL_PATH . 'templates/';

		// Action to which we hook onto to send the email.
		add_action( 'woocommerce_order_status_out-for-delivery_to_completed', array( $this, 'trigger' ), 9 );
		parent::__construct();

		if ( ! $this->recipient ) {
			$this->recipient = get_option( 'admin_email' );
		}
	}

  /**
   * Trigger Function that will send this email to the customer.
   *
   * @access public
   * @return void
   */
  function trigger( $order_id ) {
		// Order ID.
		$this->object = wc_get_order( $order_id );

		// Admin email.
		$this->recipient = get_option( 'admin_email' );

		// Admin details.
		$admin_user = get_user_by( 'email', get_option( 'admin_email' ) );

		// Admin phone.
		$this->phone = apply_filters( 'ddwc_pro_order_completed_sms_admin_phone', $admin_user->phone_number );

		if ( ! $this->is_enabled() || ! $this->get_recipient() ) {
        return;
		}

		// Message type (email/SMS).
		$message_type = get_option( 'ddwc_pro_settings_message_types' );

		if ( ! empty( $message_type ) && 'sms' == $message_type ) {
			// Admin details for Twilio.
			$account_sid   = get_option( 'ddwc_pro_settings_twilio_account_sid' );
			$auth_token    = get_option( 'ddwc_pro_settings_twilio_auth_token' );
			$twilio_number = get_option( 'ddwc_pro_settings_twilio_phone_number' );
			// Create new Twilio client.
			$client = new Client( $account_sid, $auth_token );
			// Send Twilio SMS message.
			$client->messages->create(
				$this->phone, // Admin phone.
				array(
					'from' => $twilio_number,
					'body' => apply_filters( 'ddwc_pro_order_completed_sms_message', get_bloginfo( 'name' ) . ': ' . __( 'Completed - Order', 'ddwc-pro' ) . ' #' . $order_id )
				)
			);
		} else {
			// Send email.
			$this->send( $this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments() );
		}
	}

  /**
	 * Get content html.
	 *
	 * @access public
	 * @return string
	 */
	public function get_content_html() {
		return wc_get_template_html( $this->template_html, array(
			'order'         => $this->object,
			'email_heading' => $this->get_heading(),
			'sent_to_admin' => true,
			'plain_text'    => false,
			'email'			=> $this
		), '', $this->template_base );
  }

	/**
	 * Get content plain.
	 *
	 * @return string
	 */
	public function get_content_plain() {
		return wc_get_template_html( $this->template_plain, array(
			'order'         => $this->object,
			'email_heading' => $this->get_heading(),
			'sent_to_admin' => true,
			'plain_text'    => true,
			'email'			=> $this
		), '', $this->template_base );
  }

}
