<?php
/**
 * Custom Checkout Fields for WooCommerce - All Products Section Settings - Field
 *
 * @version 1.1.0
 * @since   1.0.0
 * @author  Algoritmika Ltd.
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_CCF_Settings_Field' ) ) :

class Alg_WC_CCF_Settings_Field extends Alg_WC_CCF_Settings_Section {

	/**
	 * Constructor.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function __construct( $field_nr ) {
		$this->id       = 'field_' . $field_nr;
		$this->desc     = __( 'Field', 'custom-checkout-fields-for-woocommerce' ) . ' #' . $field_nr;
		$this->field_nr = $field_nr;
		parent::__construct();
	}

	/**
	 * get_settings.
	 *
	 * @version 1.1.0
	 * @since   1.0.0
	 */
	function get_settings() {
		$options  = alg_get_wc_ccf_options();
		$settings = array();
		foreach ( $options as $option ) {
			if ( 'field_general_options' === $option['id'] && 'title' === $option['type'] ) {
				$option['title'] .= ' #' . $this->field_nr;
				$option['desc']  .= ' <code>' .
					'_' . alg_wc_ccf_get_field_option( 'section', $this->field_nr, 'billing' ) . '_' . ALG_WC_CCF_KEY . '_' . $this->field_nr . '</code>.' . '</em>';
			}
			$option['id'] = $option['id'] . '_' . $this->field_nr;
			$settings[] = $option;
		}
		return $settings;
	}

}

endif;
