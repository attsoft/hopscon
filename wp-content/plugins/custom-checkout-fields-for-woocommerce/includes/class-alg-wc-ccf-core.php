<?php
/**
 * Custom Checkout Fields for WooCommerce - Core Class
 *
 * @version 1.4.8
 * @since   1.0.0
 * @author  Algoritmika Ltd.
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_CCF_Core' ) ) :

class Alg_WC_CCF_Core {

	/**
	 * Constructor.
	 *
	 * @version 1.4.8
	 * @since   1.0.0
	 * @todo    [maybe] text domain: remove 'woocommerce' *everywhere*
	 */
	function __construct() {
		if ( 'yes' === alg_wc_ccf_get_option( 'enabled', 'yes' ) ) {
			require_once( 'class-alg-wc-ccf-frontend.php' );
			require_once( 'class-alg-wc-ccf-scripts.php' );
			require_once( 'class-alg-wc-ccf-customer-details.php' );
			require_once( 'class-alg-wc-ccf-order-details.php' );
			require_once( 'class-alg-wc-ccf-shortcodes.php' );
			require_once( 'class-alg-wc-ccf-compatibility.php' );
		}
	}

}

endif;

return new Alg_WC_CCF_Core();
