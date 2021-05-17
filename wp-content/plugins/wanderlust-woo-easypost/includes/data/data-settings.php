<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $woocommerce, $wpdb;

$default = esc_attr( get_option('woocommerce_default_country') );
$country = ( ( $pos = strrpos( $default, ':' ) ) === false ) ? $default : substr( $default, 0, $pos );  
$woocommerce_easypost_test = get_option( 'pvit_easypostwanderlust_shipper_test' );
$woocommerce_easypost_test_api_key = get_option( 'pvit_easypostwanderlust_testkey' );
$woocommerce_easypost_live_api_key = get_option( 'pvit_easypostwanderlust_livekey' );
$woocommerce_easypost_customs_info_description = get_option( 'pvit_easypostwanderlust_customsdescription' );
$woocommerce_easypost_customs_info_hs_tariff_number = get_option( 'pvit_easypostwanderlust_customshs' );
$woocommerce_easypost_customs_info_contents_type = get_option( 'pvit_easypostwanderlust_customstype' );
$woocommerce_easypost_company = get_option( 'pvit_easypostwanderlust_sender_company' ); 
$woocommerce_easypost_street1 = get_option( 'pvit_easypostwanderlust_sender_address1' );
$woocommerce_easypost_city = get_option( 'pvit_easypostwanderlust_shipper_city' );
$woocommerce_easypost_state = get_option( 'pvit_easypostwanderlust_sender_state' );
$woocommerce_easypost_zip = get_option( 'pvit_easypostwanderlust_shipper_zipcode' );
$woocommerce_easypost_phone = get_option( 'pvit_easypostwanderlust_shipper_phone' );
$woocommerce_easypost_country = get_option( 'pvit_easypostwanderlust_shipper_country' );
/**
 * Array of settings
 */
return array(
	'enabled'          => array(
		'title'           => __( 'Enable Wanderlust Shipping Tool', 'wc_wanderlust' ),
		'type'            => 'checkbox',
		'label'           => __( 'Enable this shipping method', 'wc_wanderlust' ),
		'default'         => 'no'
	),
	'debug'      => array(
		'title'           => __( 'Debug Mode', 'wc_wanderlust' ),
		'label'           => __( 'Enable debug mode', 'wc_wanderlust' ),
		'type'            => 'checkbox',
		'default'         => 'no',
		'description'     => __( 'Enable debug mode to show debugging information on the cart/checkout.', 'wc_wanderlust' )
	),
	    'sender_info'              => array(
		'title'           => __( 'Sender Info', 'wc_wanderlust' ),
		'type'            => 'title',
		'description'     => __( 'Insert your info.', 'wc_wanderlust' ),
    ),
      'company' => array(
        'title' => "Company",
        'type' => 'text',
        'label' => __( 'Company', 'woocommerce' ),
        'default' => $woocommerce_easypost_company
      ),
      'street1' => array(
        'title' => 'Address',
        'type' => 'text',
        'label' => __( 'Address', 'woocommerce' ),
        'default' => $woocommerce_easypost_street1
      ),
      'street2' => array(
        'title' => 'Address2',
        'type' => 'text',
        'label' => __( 'Address2', 'woocommerce' ),
        'default' => ''
      ),
      'city' => array(
        'title' => 'City',
        'type' => 'text',
        'label' => __( 'City', 'woocommerce' ),
        'default' => $woocommerce_easypost_city
      ),
      'state' => array(
        'title' => 'State',
        'type' => 'text',
        'label' => __( 'State', 'woocommerce' ),
        'default' => $woocommerce_easypost_state
      ),
      'zip' => array(
        'title' => 'Zip',
        'type' => 'text',
        'label' => __( 'ZipCode', 'woocommerce' ),
        'default' => $woocommerce_easypost_zip
      ),
      'phone' => array(
        'title' => 'Phone',
        'type' => 'text',
        'label' => __( 'Phone', 'woocommerce' ),
        'default' => $woocommerce_easypost_phone
      ),
	'origin'           => array(
		'title'           => __( 'Origin Postcode', 'wc_wanderlust' ),
		'type'            => 'text',
		'description'     => __( 'Enter the postcode for the <strong>sender</strong>.', 'wc_wanderlust' ),
		'default'         => $woocommerce_easypost_zip,
		'desc_tip'        => true
    ),
    'availability'  => array(
		'title'           => __( 'Method Availability', 'wc_wanderlust' ),
		'type'            => 'select',
		'default'         => 'all',
		'class'           => 'availability',
		'options'         => array(
			'all'            => __( 'All Countries', 'wc_wanderlust' ),
			'specific'       => __( 'Specific Countries', 'wc_wanderlust' ),
		),
	),
	'countries'        => array(
		'title'           => __( 'Specific Countries', 'wc_wanderlust' ),
		'type'            => 'multiselect',
		'class'           => 'chosen_select',
		'css'             => 'width: 450px;',
		'default'         => '',
		'options'         => $woocommerce->countries->get_allowed_countries(),
	),
	'filter_rates' => array(
        'title' => __( 'Filter these rates', 'woocommerce' ),
        'type' => 'text',
        'label' => __( 'Fitler (Comma Seperated)', 'woocommerce' ),
        'default' => ('LibraryMail,MediaMail'),
      ),
	'shippingratescheckout'           => array(
		'title'           => __( 'Shipping Rates', 'wc_wanderlust' ),
		'type'            => 'title',
		'description'     => __( 'The following settings determine the shipping rates you want to display on cart/checkout', 'wc_wanderlust' ),
    ),		
	'order_rates'      => array(
		'title'           => __( 'Order Rates', 'wc_wanderlust' ),
		'label'           => __( 'Enable', 'wc_wanderlust' ),
		'type'            => 'checkbox',
		'default'         => 'no',
		'description'     => __( 'Order Shippgin Rates from cheapper to highest on the cart/checkout.', 'wc_wanderlust' )
	),	
	'show_fedex_rates'      => array(
		'title'           => __( 'Show Fedex Rates', 'wc_wanderlust' ),
		'label'           => __( 'Enable', 'wc_wanderlust' ),
		'type'            => 'checkbox',
		'default'         => 'no'
	),		
	'show_usps_rates'      => array(
		'title'           => __( 'Show USPS Rates', 'wc_wanderlust' ),
		'label'           => __( 'Enable', 'wc_wanderlust' ),
		'type'            => 'checkbox',
		'default'         => 'yes'
	),		
	'show_ups_rates'      => array(
		'title'           => __( 'Show UPS Rates', 'wc_wanderlust' ),
		'label'           => __( 'Enable', 'wc_wanderlust' ),
		'type'            => 'checkbox',
		'default'         => 'no'
	),	
	'show_dhl_rates'      => array(
		'title'           => __( 'Show DHL Rates', 'wc_wanderlust' ),
		'label'           => __( 'Enable', 'wc_wanderlust' ),
		'type'            => 'checkbox',
		'default'         => 'no'
	),		
	'show_canada_rates'      => array(
		'title'           => __( 'Show Canada Post Rates', 'wc_wanderlust' ),
		'label'           => __( 'Enable', 'wc_wanderlust' ),
		'type'            => 'checkbox',
		'default'         => 'no'
	),	
	'extracharges'           => array(
		'title'           => __( 'Handling Charges', 'wc_wanderlust' ),
		'type'            => 'title',
		'description'     => __( 'The following settings determine handling charges, you can use fixed value or %. (Ex.  4% or 4.00)', 'wc_wanderlust' ),
    ),	
	'extrachargefedex'           => array(
		'title'           => __( 'Handling Charge for FedEx', 'wc_wanderlust' ),
		'type'            => 'text',
		'description'     => __( 'Enter extra charge to rates.', 'wc_wanderlust' ),
		'default'         => '0.00',
		'desc_tip'        => true
    ),
	'extrachargeusps'           => array(
		'title'           => __( 'Handling Charge for USPS', 'wc_wanderlust' ),
		'type'            => 'text',
		'description'     => __( 'Enter extra charge to rates.', 'wc_wanderlust' ),
		'default'         => '0.00',
		'desc_tip'        => true
    ),	
	'extrachargeups'           => array(
		'title'           => __( 'Handling Charge for UPS', 'wc_wanderlust' ),
		'type'            => 'text',
		'description'     => __( 'Enter extra charge to rates.', 'wc_wanderlust' ),
		'default'         => '0.00',
		'desc_tip'        => true
    ),		
	'extrachargecanada'           => array(
		'title'           => __( 'Handling Charge for Canada Post', 'wc_wanderlust' ),
		'type'            => 'text',
		'description'     => __( 'Enter extra charge to rates.', 'wc_wanderlust' ),
		'default'         => '0.00',
		'desc_tip'        => true
    ),		
	'extrachargedhl'           => array(
		'title'           => __( 'Handling Charge for DHL', 'wc_wanderlust' ),
		'type'            => 'text',
		'description'     => __( 'Enter extra charge to rates.', 'wc_wanderlust' ),
		'default'         => '0.00',
		'desc_tip'        => true
    ),	
	'packing'           => array(
		'title'           => __( 'Packages', 'wc_wanderlust' ),
		'type'            => 'title',
		'description'     => __( 'The following settings determine how items are packed before being sent to wanderlust.', 'wc_wanderlust' ),
    ),
	'packing_method'   => array(
		'title'           => __( 'Parcel Packing Method', 'wc_wanderlust' ),
		'type'            => 'select',
		'default'         => '',
		'class'           => 'packing_method',
		'options'         => array(
			'per_item'       => __( 'Default: Pack items individually', 'wc_wanderlust' ),
			'box_packing'    => __( 'Recommended: Pack into boxes with weights and dimensions', 'wc_wanderlust' ),
		),
	),
	'boxes'  => array(
		'type'            => 'box_packing'
	),
    'rates'           => array(
		'title'           => __( 'Rates and Services', 'wc_wanderlust' ),
		'type'            => 'title',
		'description'     => __( 'The following settings determine the rates you offer your customers.', 'wc_wanderlust' ),
    ),
    'residential'      => array(
		'title'           => __( 'Residential', 'wc_wanderlust' ),
		'label'           => __( 'Default to residential delivery', 'wc_wanderlust' ),
		'type'            => 'checkbox',
		'default'         => 'no',
		'description'     => __( 'Enables residential flag. If you account has Address Validation enabled, this will be turned off/on automatically.', 'wc_wanderlust' )
	),
	'shipment_signature'  => array(
		'title'           => __( 'Shipment Signature', 'wc_wanderlust' ),
		'type'            => 'select',
		'default'         => 'NO_SIGNATURE',
		'class'           => 'availability',
		'options'         => array(
			'NO_SIGNATURE'            => __( 'NO SIGNATURE', 'wc_wanderlust' ),
			'SIGNATURE'       => __( 'SIGNATURE', 'wc_wanderlust' ),
			'ADULT_SIGNATURE'       => __( 'ADULT SIGNATURE', 'wc_wanderlust' ),
		),
	),
 /*   'insure_contents'      => array(
		'title'           => __( 'Insurance', 'wc_wanderlust' ),
		'label'           => __( 'Enable Insurance', 'wc_wanderlust' ),
		'type'            => 'checkbox',
		'default'         => 'yes',
		'description'     => __( 'Sends the package value to Easypost API for insurance.', 'wc_wanderlust' )
	),
 */
);