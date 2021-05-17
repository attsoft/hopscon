<?php
/**
 * Custom Checkout Fields for WooCommerce - General Section Settings
 *
 * @version 1.3.0
 * @since   1.0.0
 * @author  Algoritmika Ltd.
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_CCF_Settings_General' ) ) :

class Alg_WC_CCF_Settings_General extends Alg_WC_CCF_Settings_Section {

	/**
	 * Constructor.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function __construct() {
		$this->id   = '';
		$this->desc = __( 'General', 'custom-checkout-fields-for-woocommerce' );
		parent::__construct();
	}

	/**
	 * message_replaced_values.
	 *
	 * @version 1.1.0
	 * @since   1.0.0
	 */
	function message_replaced_values( $values ) {
		return sprintf( __( 'Placeholders: %s', 'custom-checkout-fields-for-woocommerce' ), '<code>' . implode( '</code>, <code>', $values ) . '</code>' );
	}

	/**
	 * get_settings.
	 *
	 * @version 1.3.0
	 * @since   1.0.0
	 * @todo    [later] (feature) add optional different fields settings view (i.e. by option types, instead of by fields)
	 */
	function get_settings() {
		$settings = array(
			array(
				'title'    => __( 'Custom Checkout Fields Options', 'custom-checkout-fields-for-woocommerce' ),
				'type'     => 'title',
				'id'       => 'options',
			),
			array(
				'title'    => __( 'Custom Checkout Fields', 'custom-checkout-fields-for-woocommerce' ),
				'desc'     => '<strong>' . __( 'Enable plugin', 'custom-checkout-fields-for-woocommerce' ) . '</strong>',
				'desc_tip' => __( 'WooCommerce Custom Checkout Fields.', 'custom-checkout-fields-for-woocommerce' ),
				'id'       => 'enabled',
				'default'  => 'yes',
				'type'     => 'checkbox',
			),
			array(
				'title'    => __( 'Custom fields number', 'custom-checkout-fields-for-woocommerce' ),
				'desc_tip' => __( 'Click "Save changes" after you set this number - new settings subsections will be added for each field.',
					'custom-checkout-fields-for-woocommerce' ),
				'id'       => 'total_number',
				'default'  => 1,
				'type'     => 'number',
				'desc'     => apply_filters( 'alg_wc_ccf_settings', '<br>' . sprintf( 'You will need %s plugin to add more than one custom field.',
					'<a target="_blank" href="https://wpfactory.com/item/custom-checkout-fields-for-woocommerce/">' . 'Custom Checkout Fields for WooCommerce Pro' . '</a>' ),
					'button' ),
				'custom_attributes' => apply_filters( 'alg_wc_ccf_settings', array( 'min' => '1', 'max' => '1' ), 'atts' ),
				'css'      => 'width:100px;',
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'options',
			),
			array(
				'title'    => __( 'General Options', 'custom-checkout-fields-for-woocommerce' ),
				'type'     => 'title',
				'id'       => 'general_options',
			),
			array(
				'title'    => __( 'Add all fields to admin emails', 'custom-checkout-fields-for-woocommerce' ),
				'desc'     => __( 'Add', 'custom-checkout-fields-for-woocommerce' ),
				'id'       => 'email_all_to_admin',
				'default'  => 'yes',
				'type'     => 'checkbox',
			),
			array(
				'title'    => __( 'Add all fields to customers emails', 'custom-checkout-fields-for-woocommerce' ),
				'desc'     => __( 'Add', 'custom-checkout-fields-for-woocommerce' ),
				'id'       => 'email_all_to_customer',
				'default'  => 'yes',
				'type'     => 'checkbox',
			),
			array(
				'desc'     => __( 'Before the fields', 'custom-checkout-fields-for-woocommerce' ),
				'id'       => 'emails_template_before',
				'default'  => '',
				'type'     => 'textarea',
			),
			array(
				'desc'     => __( 'Each field', 'custom-checkout-fields-for-woocommerce' ) . '. ' . $this->message_replaced_values( array( '%label%', '%value%' ) ),
				'id'       => 'emails_template_field',
				'default'  => '<p><strong>%label%:</strong> %value%</p>',
				'type'     => 'textarea',
			),
			array(
				'desc'     => __( 'After the fields', 'custom-checkout-fields-for-woocommerce' ),
				'id'       => 'emails_template_after',
				'default'  => '',
				'type'     => 'textarea',
			),
			array(
				'title'    => __( 'Add all fields to "Order Received" (i.e. "Thank You") and "View Order" pages', 'custom-checkout-fields-for-woocommerce' ),
				'desc'     => __( 'Add', 'custom-checkout-fields-for-woocommerce' ),
				'id'       => 'add_to_order_received',
				'default'  => 'yes',
				'type'     => 'checkbox',
			),
			array(
				'desc'     => __( 'Before the fields', 'custom-checkout-fields-for-woocommerce' ),
				'id'       => 'order_received_template_before',
				'default'  => '',
				'type'     => 'textarea',
			),
			array(
				'desc'     => __( 'Each field', 'custom-checkout-fields-for-woocommerce' ) . '. ' . $this->message_replaced_values( array( '%label%', '%value%' ) ),
				'id'       => 'order_received_template_field',
				'default'  => '<p><strong>%label%:</strong> %value%</p>',
				'type'     => 'textarea',
			),
			array(
				'desc'     => __( 'After the fields', 'custom-checkout-fields-for-woocommerce' ),
				'id'       => 'order_received_template_after',
				'default'  => '',
				'type'     => 'textarea',
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'general_options',
			),
			array(
				'title'    => __( 'Advanced Options', 'custom-checkout-fields-for-woocommerce' ),
				'type'     => 'title',
				'id'       => 'advanced_options',
			),
			array(
				'title'    => __( 'Force fields sort by priority', 'custom-checkout-fields-for-woocommerce' ),
				'desc'     => __( 'Enable', 'custom-checkout-fields-for-woocommerce' ),
				'desc_tip' => __( 'Enable this if you are having theme related issues with "Priority (i.e. order)" options.', 'custom-checkout-fields-for-woocommerce' ),
				'type'     => 'checkbox',
				'id'       => 'force_sort_by_priority',
				'default'  => 'no',
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'advanced_options',
			),
		);
		return $settings;
	}

}

endif;

return new Alg_WC_CCF_Settings_General();
