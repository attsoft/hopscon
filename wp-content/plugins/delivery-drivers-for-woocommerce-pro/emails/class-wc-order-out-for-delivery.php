<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines Out for Delivery Class.
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
 * Class WC_Order_Out_For_Delivery
 *
 * @since 1.1
 */
class WC_Order_Out_For_Delivery extends WC_Email {
	/**
	 * Create an instance of the class.
	 *
	 * @access public
	 * @return void
	 */
	function __construct() {
    // Email slug we can use to filter other data.
		$this->id          = 'ddwc_pro_order_out_for_delivery';
		$this->title       = __( 'DDWC Out for Delivery', 'ddwc-pro' );
		$this->description = __( 'An email sent to the customer when an order is out for delivery.', 'ddwc-pro' );

    // For admin area to let the user know we are sending this email to customers.
		$this->customer_email = true;
		$this->heading        = __( 'Out for Delivery', 'ddwc-pro' );

    // translators: placeholder is {blogname}, a variable that will be substituted when email is sent out
		$this->subject = sprintf( _x( '[%s] Your order is out for delivery', 'default email subject for out for delivery emails sent to the customer', 'ddwc-pro' ), '{blogname}' );

    // Template paths.
		$this->template_html  = 'emails/wc-order-out-for-delivery.php';
		$this->template_plain = 'emails/plain/wc-order-out-for-delivery.php';
		$this->template_base  = DDWC_PRO_EMAIL_PATH . 'templates/';

		// Action to which we hook onto to send the email.
		add_action( 'woocommerce_order_status_driver-assigned_to_out-for-delivery', array( $this, 'trigger' ), 9 );
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
			// Get order details.
			$this->object = wc_get_order( $order_id );

			// Get customer email.
			if ( version_compare( '3.0.0', WC()->version, '>' ) ) {
	        $order_email = $this->object->billing_email;
	        $order_phone = $this->object->billing_phone;
	    } else {
	        $order_email = $this->object->get_billing_email();
	        $order_phone = $this->object->get_billing_phone();
			}

			// Get order link.
			$order_link = $this->object->get_view_order_url();

			// Customer email.
			$this->recipient = $order_email;

			// Customer phone number.
			$this->phone = $order_phone;

			if ( ! $this->is_enabled() || ! $this->get_recipient() ) {
	        return;
			}

			// Message type (email/SMS).
			$message_type = get_option( 'ddwc_pro_settings_message_types' );

			if ( ! empty( $message_type ) && 'sms' == $message_type && '1' == get_post_meta( $order_id, 'ddwc_pro_user_sms_updates_checkbox', TRUE ) ) {
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
						'body' => apply_filters( 'ddwc_pro_order_out_for_delivery_sms_message', get_bloginfo( 'name' ) . ': ' . __( 'Order', 'ddwc-pro' ) . ' #' . $order_id . __( ' is out for delivery', 'ddwc-pro' ) . ' - ' . $order_link )
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
			'sent_to_admin' => false,
			'plain_text'    => true,
			'email'			=> $this
		), '', $this->template_base );
  }

}
