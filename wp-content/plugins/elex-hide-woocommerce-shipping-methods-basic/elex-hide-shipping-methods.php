<?php

/*
 * Plugin Name: ELEX Hide WooCommerce Shipping Methods (BASIC)
 * Plugin URI: https://elextensions.com/plugin/elex-hide-woocommerce-shipping-methods-plugin-free-version/
 * Description: Hide WooCommerce Shipping Methods based on certain conditions set. Set conditions based on Shipping Class, Order Total Weight, Certain Shipping Methods, etc.
 * Version: 1.1.6
 * Author: ELEXtensions
 * Author URI: https://elextensions.com/plugin/elex-hide-woocommerce-shipping-methods-plugin-free-version/
 * Developer: ELEXtensions
 * Developer URI: https://elextensions.com
 * Text Domain: elex-hide-shipping-methods
 * WC requires at least: 2.6
 * WC tested up to: 5.2
 */

if (!defined('ABSPATH')) {
    exit;
}
// Check if woocommerce is active
$active_plugins = (array) get_option( 'active_plugins', array() );
if ( is_multisite() ) {
	$active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins' ), array() );
}
if ( ! ( in_array( 'woocommerce/woocommerce.php', $active_plugins ) || array_key_exists( 'woocommerce/woocommerce.php', $active_plugins ) ) ) {
	add_action( 'admin_notices', 'elex_hs_woocommerce_inactive_notice' );
	return;
}
function elex_hs_woocommerce_inactive_notice() {
	?>
	<div id="message" class="error">
		<p>
		<?php	echo( esc_html__( 'WooCommerce plugin is not Activated.', 'elex-hide-shipping-methods' ) ); ?>
		</p>
	</div>
	<?php
}




if (!defined('ELEX_HIDE_SHIPPING_METHODS_PLUGIN_PATH')) {
    define('ELEX_HIDE_SHIPPING_METHODS_PLUGIN_PATH', plugin_dir_path(__FILE__));
}
if (!defined('ELEX_HIDE_SHIPPING_METHODS_TEMPLATE_PATH')) {
    define('ELEX_HIDE_SHIPPING_METHODS_TEMPLATE_PATH', ELEX_HIDE_SHIPPING_METHODS_PLUGIN_PATH . 'templates');
}
if (!defined('ELEX_HIDE_SHIPPING_METHODS_MAIN_URL_PATH')) {
    define('ELEX_HIDE_SHIPPING_METHODS_MAIN_URL_PATH', plugin_dir_url(__FILE__));
}

add_action('admin_menu', 'elex_hs_add_menu');

function elex_hs_add_menu() {
    add_menu_page('ELEX Hide Shipping', 'ELEX Hide Shipping', 'manage_options', 'elex-hide-shipping', 'elex_hs_template_display');
}

//include files for admin access
function elex_hs_template_display() {
    include_once( 'includes/elex-hide-shipping-settings.php' );
    //remove below lines to remove licencing
    $plugin_name = 'elex-hide-shipping-methods';
}

//show message for the first installation
add_action('admin_notices', 'elex_hs_plugin_admin_notices');
function elex_hs_plugin_admin_notices() {
    if (!get_option("elex_hs_first_installation_msg")) {
        if ( in_array( 'elex-hide-shipping-methods-basic/elex-hide-shipping-methods.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
            echo "<div class='updated'><strong>ELEX Hide Shipping Methods</strong> is activated. Go to <a href=".admin_url( 'admin.php?page=elex-hide-shipping' ).">Settings</a> to configure.</div>";
        }
        update_option("elex_hs_first_installation_msg",TRUE);
    }
}

add_action('init', 'elex_hs_include_file');

function elex_hs_include_file() {
    include_once 'includes/elex-hs-ajax-functions.php';
    //remove below line to remove licencing
}

add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'elex_hs_action_links');

function elex_hs_action_links($links) {
    $plugin_links = array(
        '<a href="' . admin_url('admin.php?page=elex-hide-shipping') . '">' . __('Settings', 'elex-hide-shipping-methods') . '</a>',
        '<a href="https://elextensions.com/knowledge-base/how-to-set-up-elex-woocommerce-hide-woocommerce-shipping-methods-plugin/" target="_blank">' . __('Documentation', 'elex-hide-shipping-methods') . '</a>',
        '<a href="https://elextensions.com/support/" target="_blank">' . __('Support', 'elex-hide-shipping-methods') . '</a>',
        '<a href="https://elextensions.com/plugin/hide-woocommerce-shipping-methods/" target="_blank">' . __('Premium Upgrade', 'elex-hide-shipping-methods') . '</a>'
    );
    return array_merge($plugin_links, $links);
}
function elex_hs_load_plugin_textdomain() {
    load_plugin_textdomain( 'elex-hide-shipping-methods', FALSE, basename( dirname( __FILE__ ) ) . '/lang/' );
}
add_action( 'plugins_loaded', 'elex_hs_load_plugin_textdomain' );