<?php
/*
 * Plugin Name: Dokan Vendor Filter
 * Plugin URI: https://codecanyon.net/item/dokan-vendor-filter/19664049?ref=kas5986
 * Description: add-on for Dokan - Multi-vendor Marketplace allow you to filter Store by Location and more...
 * Version: 1.2.6
 * Author: Echo Pointer Ideas
 * Author URI: http://ideas.echopointer.com
 * License: GPL v2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: kas-dvf
 * Domain Path: /languages
 */
 
 if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * The code that runs during plugin activation.
 */
function activate_kas_dvf() {
	require_once plugin_dir_path( __FILE__ ) . 'classes/class-kas-dvf-activation.php';
	Kas_Dvf_Activation::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_kas_dvf() {
	require_once plugin_dir_path( __FILE__ ) . 'classes/class-kas-dvf-deactivation.php';
	Kas_Dvf_Deactivation::deactivate();
}


register_activation_hook( __FILE__, 'activate_kas_dvf' );
register_deactivation_hook( __FILE__, 'deactivate_kas_dvf' );

/**
 * Load all the function file for overall files
 */
require plugin_dir_path( __FILE__ ) . 'includes/functions.php';

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'classes/class-kas-dvf.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_kas_dvf() {

	$plugin = new Kas_Dvf();
	$plugin->run();

}
run_kas_dvf();


