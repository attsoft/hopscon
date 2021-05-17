<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://makewebbetter.com/
 * @since             1.0.0
 * @package           Mwb_Woocommerce_Multiple_Shipping_Address
 *
 * @wordpress-plugin
 * Plugin Name:       MWB Woocommerce Multiple Shipping Addresses
 * Plugin URI:        https://makewebbetter.com/product/mwb-woocommerce-multiple-shipping-address/
 * Description:       This plugin will let your customers to provide different shipping addresses for different products in the 					 order.
 * Version:           1.0.0
 * Author:            makewebbetter
 * Author URI:        https://makewebbetter.com/
 * Text Domain:       mwb-woocommerce-multiple-shipping-address
 * Domain Path:       /languages
 *
 * Requires at least:        4.6
 * Tested up to: 	         4.9.5
 * WC requires at least:     3.2
 * WC tested up to:          3.3.4
 *
 * License:           Makewebbetter License.
 * License URI:       https://makewebbetter.com/license-agreement.txt
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

// To Activate plugin only when WooCommerce is active.
$activated = true;

// Check if WooCommerce is active.
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) ) {

	$activated = false;
}

if ( $activated ) {

	// Plugin Auto Update.
	function mwb_woocommerce_multiple_shipping_address_auto_update() {

		$license_key = get_option( 'mwb_woocommerce_multiple_shipping_address_lcns_key', '' );
		define( 'MWB_WOOCOMMERCE_MULTIPLE_SHIPPING_ADDRESS_LICENSE_KEY', $license_key );
		define( 'MWB_WOOCOMMERCE_MULTIPLE_SHIPPING_ADDRESS_BASE_FILE', __FILE__ );
		$update_check = "https://makewebbetter.com/pluginupdates/mwb-woocommerce-multiple-shipping-address/update.php";
		require_once( 'mwb-woocommerce-multiple-shipping-address-update.php' );
	}

	// Define plugin constants.
	function define_mwb_woocommerce_multiple_shipping_address_constants() {

		mwb_woocommerce_multiple_shipping_address_constants( 'MWB_WOOCOMMERCE_MULTIPLE_SHIPPING_ADDRESS_VERSION', '1.0.0' );
		mwb_woocommerce_multiple_shipping_address_constants( 'MWB_WOOCOMMERCE_MULTIPLE_SHIPPING_ADDRESS_DIR_PATH', plugin_dir_path( __FILE__ ) );
		mwb_woocommerce_multiple_shipping_address_constants( 'MWB_WOOCOMMERCE_MULTIPLE_SHIPPING_ADDRESS_DIR_URL', plugin_dir_url( __FILE__ ) );

		// For License Validation.
		mwb_woocommerce_multiple_shipping_address_constants( 'MWB_WOOCOMMERCE_MULTIPLE_SHIPPING_ADDRESS_SPECIAL_SECRET_KEY', '59f32ad2f20102.74284991' );
		mwb_woocommerce_multiple_shipping_address_constants( 'MWB_WOOCOMMERCE_MULTIPLE_SHIPPING_ADDRESS_SERVER_URL', 'https://makewebbetter.com' );
		mwb_woocommerce_multiple_shipping_address_constants( 'MWB_WOOCOMMERCE_MULTIPLE_SHIPPING_ADDRESS_ITEM_REFERENCE', 'MWB Woocommerce Multiple Shipping Address' );
	}

	// Callable function for defining plugin constants.
	function mwb_woocommerce_multiple_shipping_address_constants( $key, $value ) {

		if( ! defined( $key ) ) {
			
			define( $key, $value );
		}
	}

	/**
	 * The code that runs during plugin activation.
	 * This action is documented in includes/class-mwb-woocommerce-multiple-shipping-address-activator.php
	 */
	function activate_mwb_woocommerce_multiple_shipping_address() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-mwb-woocommerce-multiple-shipping-address-activator.php';
		Mwb_Woocommerce_Multiple_Shipping_Address_Activator::activate();

		// Create transient data.
    	set_transient( 'mwb_woocommerce_multiple_shipping_address_transient_user_exp_notice', true, 5 );
	}

	// Add admin notice only on plugin activation.
	add_action( 'admin_notices', 'mwb_woocommerce_multiple_shipping_address_user_exp_notice' );	

	// Facebook setup notice on plugin activation.
	function mwb_woocommerce_multiple_shipping_address_user_exp_notice() {

		/**
		 * Check transient.
		 * If transient available display notice.
		 */
		if( get_transient( 'mwb_woocommerce_multiple_shipping_address_transient_user_exp_notice' ) ):

			?>

			<div class="notice notice-info is-dismissible">
				<p><strong><?php _e( 'Welcome to MWB Woocommerce Multiple Shipping Address', 'mwb-woocommerce-multiple-shipping-address' ); ?></strong><?php _e( ' – < Here try to explain the Next Process after plugin activation. >', 'mwb-woocommerce-multiple-shipping-address' ); ?></p>
				<p class="submit"><a href="<?php echo admin_url( 'admin.php?page=mwb_woocommerce_multiple_shipping_address_menu' ); ?>" class="button-primary"><?php _e( '< Next Process Link >', 'mwb-woocommerce-multiple-shipping-address' ); ?></a></p>
			</div>

			<?php

			delete_transient( 'mwb_woocommerce_multiple_shipping_address_transient_user_exp_notice' );

		endif;
	}

	/**
	 * The code that runs during plugin deactivation.
	 * This action is documented in includes/class-mwb-woocommerce-multiple-shipping-address-deactivator.php
	 */
	function deactivate_mwb_woocommerce_multiple_shipping_address() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-mwb-woocommerce-multiple-shipping-address-deactivator.php';
		Mwb_Woocommerce_Multiple_Shipping_Address_Deactivator::deactivate();
	}

	register_activation_hook( __FILE__, 'activate_mwb_woocommerce_multiple_shipping_address' );
	register_deactivation_hook( __FILE__, 'deactivate_mwb_woocommerce_multiple_shipping_address' );

	/**
	 * The core plugin class that is used to define internationalization,
	 * admin-specific hooks, and public-facing site hooks.
	 */
	require plugin_dir_path( __FILE__ ) . 'includes/class-mwb-woocommerce-multiple-shipping-address.php';

	/**
	 * Begins execution of the plugin.
	 *
	 * Since everything within the plugin is registered via hooks,
	 * then kicking off the plugin from this point in the file does
	 * not affect the page life cycle.
	 *
	 * @since    1.0.0
	 */
	function run_mwb_woocommerce_multiple_shipping_address() {

		define_mwb_woocommerce_multiple_shipping_address_constants();
		mwb_woocommerce_multiple_shipping_address_auto_update();

		$plugin = new Mwb_Woocommerce_Multiple_Shipping_Address();
		$plugin->run();

	}
	run_mwb_woocommerce_multiple_shipping_address();

	// Add settings link on plugin page.
	add_filter( 'plugin_action_links_'.plugin_basename(__FILE__), 'mwb_woocommerce_multiple_shipping_address_settings_link' );

	// Settings link.
	function mwb_woocommerce_multiple_shipping_address_settings_link( $links ) {

	    $my_link = array(
	    		'<a href="' . admin_url( 'admin.php?page=mwb_woocommerce_multiple_shipping_address_menu' ) . '">' . __( 'Settings', 'mwb-woocommerce-multiple-shipping-address' ) . '</a>',
	    	);
	    return array_merge( $my_link, $links );
	}
}

else {

	// WooCommerce is not active so deactivate this plugin.
	add_action( 'admin_init', 'mwb_woocommerce_multiple_shipping_address_activation_failure' );

	// Deactivate this plugin.
	function mwb_woocommerce_multiple_shipping_address_activation_failure() {

		deactivate_plugins( plugin_basename( __FILE__ ) );
	}

	// Add admin error notice.
	add_action( 'admin_notices', 'mwb_woocommerce_multiple_shipping_address_activation_failure_admin_notice' );

	// This function is used to display admin error notice when WooCommerce is not active.
	function mwb_woocommerce_multiple_shipping_address_activation_failure_admin_notice() {

		// to hide Plugin activated notice.
		unset( $_GET['activate'] );

	    ?>

	    <div class="notice notice-error is-dismissible">
	        <p><?php _e( 'WooCommerce is not activated, Please activate WooCommerce first to activate MWB Woocommerce Multiple Shipping Address.' ); ?></p>
	    </div>

	    <?php
	}
}




