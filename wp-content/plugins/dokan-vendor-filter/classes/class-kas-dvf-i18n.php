<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * Register all actions and filters for the plugin
 *
 * @link       http://ideas.echopointer.com
 * @since      1.0.0
 *
 * @package    Kas_Dvf
 * @subpackage Kas_Dvf/classes
 */

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    Kas_Dvf
 * @subpackage Kas_Dvf/classes
 * @author     Syed Muhammad Shafiq <shafiq_shaheen@hotmail.com>
 */

class Kas_Dvf_i18n {

	/**
	 * The domain specified.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $domain    The domain identifier.
	 */
	private $domain;

	/**
	 * Load text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_textdomain() {

		load_plugin_textdomain(
			$this->domain,
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}

	/**
	 * Set the domain equal to that of the specified domain.
	 *
	 * @since    1.0.0
	 * @param    string    $domain    The domain that represents the locale of this plugin.
	 */
	public function set_domain( $domain ) {
		$this->domain = $domain;
	}

}
