<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines Driver Assigned Class.
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

use Twilio\Rest\Client;

/**
 * Class WC_Order_Driver_Assigned
 *
 * @since 1.1
 */
class WC_Order_Driver_Assigned extends WC_Email {
	/**
	 * Create an instance of the class.
	 *
	 * @access public
	 * @return void
	 */
	function __construct() {
    // Email slug we can use to filter other data.
		$this->id          = 'ddwc_pro_driver_assigned';
		$this->title       = __( 'DDWC Driver Assigned', 'ddwc-pro' );
		$this->description = __( 'An email sent to the delivery driver when they get assigned a new order', 'ddwc-pro' );

    // For admin area to let the user know we are not sending this email to customers.
		$this->customer_email = false;
		$this->heading        = __( 'Order Assigned', 'ddwc-pro' );

    // translators: placeholder is {blogname}, a variable that will be substituted when email is sent out
		$this->subject = sprintf( _x( '[%s] Order assigned', 'default email subject for drivers when they get assigned a new order', 'ddwc-pro' ), '{blogname}' );

    // Template paths.
		$this->template_html  = 'emails/wc-order-driver-assigned.php';
		$this->template_plain = 'emails/plain/wc-order-driver-assigned.php';
		$this->template_base  = DDWC_PRO_EMAIL_PATH . 'templates/';

		// Action to which we hook onto to send the email.
		add_action( 'woocommerce_order_status_processing_to_driver-assigned', array( $this, 'trigger' ), 9 );
		parent::__construct();

		if ( ! $this->recipient ) {
			//$this->recipient = get_option( 'admin_email' );
		}
	}

  /**
   * Trigger Function that will send this email to the customer.
   *
   * @access public
   * @return void
   */
  function trigger( $order_id ) {
		$this->object = wc_get_order( $order_id );

		// Get driver attached to order.
		$driver_id = get_post_meta( $order_id, 'ddwc_driver_id', TRUE );

		// Get driver's email address.
		$driver_info = get_userdata( $driver_id );

		// Set the recipient.
		$this->recipient = $driver_info->billing_email;

		// Set the recipient phone number.
		$this->phone = $driver_info->billing_phone;

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
				$this->phone, // Customer phone.
				array(
					'from' => $twilio_number,
					'body' => apply_filters( 'ddwc_pro_order_driver_assigned_sms_message', get_bloginfo( 'name' ) . ': ' . __( 'You have been assigned order', 'ddwc-pro' ) . ' #' . $order_id . ' - ' . get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) . '/driver-dashboard/?orderid=' . $order_id )
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
			'sent_to_admin' => false,
			'plain_text'    => false,
			'email'			    => $this
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
			'sent_to_admin' => false,
			'plain_text'    => true,
			'email'         => $this
		), '', $this->template_base );
  }

}
