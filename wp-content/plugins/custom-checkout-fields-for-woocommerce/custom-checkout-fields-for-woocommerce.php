<?php
/*
Plugin Name: Custom Checkout Fields for WooCommerce
Plugin URI: https://wpfactory.com/item/custom-checkout-fields-for-woocommerce/
Description: Add custom fields to WooCommerce checkout page.
Version: 1.5.0
Author: Algoritmika Ltd
Author URI: https://algoritmika.com
Text Domain: custom-checkout-fields-for-woocommerce
Domain Path: /langs
Copyright: © 2021 Algoritmika Ltd.
WC tested up to: 4.8
License: GNU General Public License v3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Constants
if ( ! defined( 'ALG_WC_CCF_VERSION' ) ) {
	define( 'ALG_WC_CCF_VERSION', '1.5.0' );
}
if ( ! defined( 'ALG_WC_CCF_ID' ) ) {
	define( 'ALG_WC_CCF_ID',      'alg_wc_ccf' );
}
if ( ! defined( 'ALG_WC_CCF_KEY' ) ) {
	define( 'ALG_WC_CCF_KEY',     'alg_wc_checkout_field' );
}

if ( ! function_exists( 'alg_wc_ccf_get_option' ) ) {
	/**
	 * alg_wc_ccf_get_option.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function alg_wc_ccf_get_option( $option, $default = false ) {
		return get_option( ALG_WC_CCF_ID . '_' . $option, $default );
	}
}

if ( ! function_exists( 'alg_wc_ccf_get_field_option' ) ) {
	/**
	 * alg_wc_ccf_get_field_option.
	 *
	 * @version 1.5.0
	 * @since   1.0.0
	 * @todo    [next] move this to `alg-wc-ccf-functions.php` (and also `alg_wc_ccf_get_option()` function)
	 * @todo    [maybe] add more fields to `do_shortcode()`, e.g. `type_select_options`, `type_select_select2_i18n_no_matches` etc.?
	 */
	function alg_wc_ccf_get_field_option( $option, $field_nr, $default = false, $context = '' ) {
		$result = alg_wc_ccf_get_option( $option . '_' . $field_nr, $default );
		if ( in_array( $option, array(
			'label',
			'placeholder',
			'default',
			'description',
			'fee_title',
			'type_checkbox_yes',
			'type_checkbox_no',
		) ) ) {
			$result = do_shortcode( $result );
		}
		return apply_filters( 'alg_wc_ccf_get_field_option', $result, $option, $field_nr, $default, $context );
	}
}

if ( ! class_exists( 'Alg_WC_CCF' ) ) :

/**
 * Main Alg_WC_CCF Class
 *
 * @class   Alg_WC_CCF
 * @version 1.5.0
 * @since   1.0.0
 */
final class Alg_WC_CCF {

	/**
	 * @var   Alg_WC_CCF The single instance of the class
	 * @since 1.0.0
	 */
	protected static $_instance = null;

	/**
	 * Main Alg_WC_CCF Instance
	 *
	 * Ensures only one instance of Alg_WC_CCF is loaded or can be loaded.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @static
	 * @return  Alg_WC_CCF - Main instance
	 */
	static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Alg_WC_CCF Constructor.
	 *
	 * @version 1.5.0
	 * @since   1.0.0
	 * @access  public
	 * @todo    [later] (feature) settings reset (options and/or order meta)
	 */
	function __construct() {

		// Check for active plugins
		if (
			! $this->is_plugin_active( 'woocommerce/woocommerce.php' ) ||
			( 'custom-checkout-fields-for-woocommerce.php' === basename( __FILE__ ) && $this->is_plugin_active( 'custom-checkout-fields-for-woocommerce-pro/custom-checkout-fields-for-woocommerce-pro.php' ) )
		) {
			return;
		}

		// Set up localisation
		add_action( 'init', array( $this, 'localize' ) );

		// Pro
		if ( 'custom-checkout-fields-for-woocommerce-pro.php' === basename( __FILE__ ) ) {
			require_once( 'includes/pro/class-alg-wc-ccf-pro.php' );
		}

		// Include required files
		$this->includes();

		// Admin
		if ( is_admin() ) {
			$this->admin();
		}
	}

	/**
	 * is_plugin_active.
	 *
	 * @version 1.4.0
	 * @since   1.4.0
	 */
	function is_plugin_active( $plugin ) {
		return ( function_exists( 'is_plugin_active' ) ? is_plugin_active( $plugin ) :
			(
				in_array( $plugin, apply_filters( 'active_plugins', ( array ) get_option( 'active_plugins', array() ) ) ) ||
				( is_multisite() && array_key_exists( $plugin, ( array ) get_site_option( 'active_sitewide_plugins', array() ) ) )
			)
		);
	}

	/**
	 * localize.
	 *
	 * @version 1.5.0
	 * @since   1.5.0
	 */
	function localize() {
		load_plugin_textdomain( 'custom-checkout-fields-for-woocommerce', false, dirname( plugin_basename( __FILE__ ) ) . '/langs/' );
	}

	/**
	 * Include required core files used in admin and on the frontend.
	 *
	 * @version 1.1.0
	 * @since   1.0.0
	 */
	function includes() {
		// Functions
		require_once( 'includes/alg-wc-ccf-functions.php' );
		// Core
		$this->core = require_once( 'includes/class-alg-wc-ccf-core.php' );
	}

	/**
	 * admin.
	 *
	 * @version 1.4.0
	 * @since   1.1.0
	 */
	function admin() {
		// Action links
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'action_links' ) );
		// Settings
		add_filter( 'woocommerce_get_settings_pages', array( $this, 'add_woocommerce_settings_tab' ) );
		// Version update
		if ( alg_wc_ccf_get_option( 'version', '' ) !== ALG_WC_CCF_VERSION ) {
			add_action( 'admin_init', array( $this, 'version_updated' ) );
		}
	}

	/**
	 * Show action links on the plugin screen.
	 *
	 * @version 1.4.1
	 * @since   1.0.0
	 * @param   mixed $links
	 * @return  array
	 */
	function action_links( $links ) {
		$custom_links = array();
		$custom_links[] = '<a href="' . admin_url( 'admin.php?page=wc-settings&tab=' . ALG_WC_CCF_ID ) . '">' . __( 'Settings', 'woocommerce' ) . '</a>';
		if ( 'custom-checkout-fields-for-woocommerce.php' === basename( __FILE__ ) ) {
			$custom_links[] = '<a target="_blank" style="font-weight: bold; color: green;" href="https://wpfactory.com/item/custom-checkout-fields-for-woocommerce/">' .
				__( 'Go Pro', 'custom-checkout-fields-for-woocommerce' ) . '</a>';
		}
		return array_merge( $custom_links, $links );
	}

	/**
	 * Add Custom Checkout Fields settings tab to WooCommerce settings.
	 *
	 * @version 1.1.0
	 * @since   1.0.0
	 */
	function add_woocommerce_settings_tab( $settings ) {
		$settings[] = require_once( 'includes/settings/class-alg-wc-settings-ccf.php' );
		return $settings;
	}

	/**
	 * version_updated.
	 *
	 * @version 1.4.0
	 * @since   1.1.0
	 */
	function version_updated() {
		update_option( ALG_WC_CCF_ID . '_' . 'version', ALG_WC_CCF_VERSION );
	}

	/**
	 * Get the plugin url.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @return  string
	 */
	function plugin_url() {
		return untrailingslashit( plugin_dir_url( __FILE__ ) );
	}

	/**
	 * Get the plugin path.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @return  string
	 */
	function plugin_path() {
		return untrailingslashit( plugin_dir_path( __FILE__ ) );
	}

}

endif;

if ( ! function_exists( 'alg_wc_custom_checkout_fields' ) ) {
	/**
	 * Returns the main instance of Alg_WC_CCF to prevent the need to use globals.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @return  Alg_WC_CCF
	 */
	function alg_wc_custom_checkout_fields() {
		return Alg_WC_CCF::instance();
	}
}

alg_wc_custom_checkout_fields();
