<?php
/**
 * Custom Checkout Fields for WooCommerce - Customer Details Class
 *
 * @version 1.3.0
 * @since   1.0.0
 * @author  Algoritmika Ltd.
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_CCF_Customer_Details' ) ) :

class Alg_WC_CCF_Customer_Details {

	/**
	 * Constructor.
	 *
	 * @version 1.3.0
	 * @since   1.0.0
	 */
	function __construct() {
		add_filter( 'woocommerce_customer_meta_fields', array( $this, 'add_checkout_custom_fields_customer_meta_fields' ), PHP_INT_MAX );
		for ( $i = 1; $i <= apply_filters( 'alg_wc_ccf_total_fields', 1 ); $i++ ) {
			if ( 'yes' === alg_wc_ccf_get_field_option( 'enabled', $i, 'no' ) ) {
				add_filter( 'default_checkout_' . alg_wc_ccf_get_field_option( 'section', $i, 'billing' ) . '_' . ALG_WC_CCF_KEY . '_' . $i,
					array( $this, 'add_default_checkout_custom_fields' ), PHP_INT_MAX, 2 );
			}
		}
	}

	/**
	 * add_checkout_custom_fields_customer_meta_fields.
	 *
	 * @version 1.3.0
	 * @since   1.0.0
	 */
	function add_checkout_custom_fields_customer_meta_fields( $fields ) {
		for ( $i = 1; $i <= apply_filters( 'alg_wc_ccf_total_fields', 1 ); $i++ ) {
			if ( 'yes' === alg_wc_ccf_get_field_option( 'enabled', $i, 'no' ) ) {
				if ( 'no' === alg_wc_ccf_get_field_option( 'customer_meta_fields', $i, 'yes' ) ) {
					continue;
				}
				$section = alg_wc_ccf_get_field_option( 'section', $i, 'billing' );
				$fields[ $section ]['fields'][ $section . '_' . ALG_WC_CCF_KEY . '_' . $i ] = array(
					'label'       => alg_wc_ccf_get_field_option( 'label', $i, '' ),
					'description' => alg_wc_ccf_get_field_option( 'description', $i, '' ),
				);
			}
		}
		return $fields;
	}

	/**
	 * add_default_checkout_custom_fields.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @todo    [maybe] remove this, as I'm not sure it's doing anything at all
	 */
	function add_default_checkout_custom_fields( $default_value, $field_key ) {
		if ( is_user_logged_in() ) {
			$current_user = wp_get_current_user();
			if ( $meta = get_user_meta( $current_user->ID, $field_key, true ) ) {
				return $meta;
			}
		}
		return $default_value;
	}

}

endif;

return new Alg_WC_CCF_Customer_Details();
