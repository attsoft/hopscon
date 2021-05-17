<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://ideas.echopointer.com
 * @since      1.0.0
 *
 * @package    Kas_Dvf
 * @subpackage Kas_Dvf/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Kas_Dvf
 * @subpackage Kas_Dvf/admin
 * @author     Syed Muhammad Shafiq <shafiq_shaheen@hotmail.com>
 */
class Kas_Dvf_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $kas_filter    The ID of this plugin.
	 */
	private $kas_filter;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $kas_filter       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $kas_filter, $version ) {

		$this->kas_filter = $kas_filter;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Kas_Dvf_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Kas_Dvf_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->kas_filter, plugin_dir_url( __FILE__ ) . 'css/kas-dvf-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Kas_Dvf as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Kas_Dvf will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->kas_filter, plugin_dir_url( __FILE__ ) . 'js/kas-dvf-admin.js', array( 'jquery' ), $this->version, false );

	}


	/**
	 * Register the administration menu into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_kas_admin_menu() {
		/*
		 * Add a settings page to the Settings menu.
		 *
		 * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
		 *
		 *        Administration Menus: http://codex.wordpress.org/Administration_Menus
		 *
		 */
		add_submenu_page( 'dokan', __( 'Dokan Vendor Filter',  $this->kas_filter  ), __( 'Vendor Filter' ), 'manage_options', $this->kas_filter, array( $this, 'display_plugin_setup_page' ) );
	}

	 /**
	 * Add settings action link page.
	 *
	 * @since    1.0.0
	 */
	public function add_action_links( $links = array() ) {
		/*
		*  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
		    */
		$settings_link = array(
			'<a href="' . admin_url( 'admin.php?page=' . $this->kas_filter ) . '">' . __('Settings', $this->kas_filter) . '</a>',
		);
		return array_merge(  $settings_link, $links );

	}

	/**
	 * Render the settings page.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_setup_page() {
		include_once( 'partials/kas-dvf-display.php' );
	}

	/**
	*  Save the plugin options
	*
	*
	* @since    1.0.0
	*/
	public function options_update() {
		//register_setting( $this->kas_filter, $this->kas_filter, array($this, 'validate') );
		
		// general
		register_setting( $this->kas_filter.'-general', 'kas-result-pagelink' );
		
		// forms
		register_setting( $this->kas_filter.'-forms', 'kas-show-country' );
		register_setting( $this->kas_filter.'-forms', 'kas-show-state' );
		register_setting( $this->kas_filter.'-forms', 'kas-show-city' );	
		register_setting( $this->kas_filter.'-forms', 'kas-show-store' );
		register_setting( $this->kas_filter.'-forms', 'kas-show-zip' );
		register_setting( $this->kas_filter.'-forms', 'kas-show-category' );
		register_setting( $this->kas_filter.'-forms', 'kas-show-frating' );
		register_setting( $this->kas_filter.'-forms', 'kas-show-searchtype' );
		//all in one field
		register_setting( $this->kas_filter.'-forms', 'kas-show-country-s' );
		register_setting( $this->kas_filter.'-forms', 'kas-show-state-s' );
		register_setting( $this->kas_filter.'-forms', 'kas-show-city-s' );	
		register_setting( $this->kas_filter.'-forms', 'kas-show-store-s' );
		register_setting( $this->kas_filter.'-forms', 'kas-show-zip-s' );
		//all in one widget
		register_setting( $this->kas_filter.'-forms', 'kas-show-country-w' );
		register_setting( $this->kas_filter.'-forms', 'kas-show-state-w' );
		register_setting( $this->kas_filter.'-forms', 'kas-show-city-w' );	
		register_setting( $this->kas_filter.'-forms', 'kas-show-store-w' );
		register_setting( $this->kas_filter.'-forms', 'kas-show-zip-w' );
		register_setting( $this->kas_filter.'-forms', 'kas-show-category-w' );
		register_setting( $this->kas_filter.'-forms', 'kas-show-frating-w' );
		register_setting( $this->kas_filter.'-forms', 'kas-show-searchtype-w' );
		
		//scripts
		register_setting( $this->kas_filter.'-scripts', 'kas-show-ratting' );
		register_setting( $this->kas_filter.'-scripts', 'kas-show-mapview' );
		register_setting( $this->kas_filter.'-scripts', 'kas-map-zoom' );	
		register_setting( $this->kas_filter.'-scripts', 'kas-map-height' );	
		register_setting( $this->kas_filter.'-scripts', 'kas-enable-bootstrap' );	
		register_setting( $this->kas_filter.'-scripts', 'kas-enable-select2' );	
		register_setting( $this->kas_filter.'-scripts', 'kas-products-perpage' );
		register_setting( $this->kas_filter.'-scripts', 'kas-products-maxprice' );
		
	}


	/**
	 * Validate all options fields
	 *
	 * @since    1.0.0
	 */
	public function validate($input) {
		// All checkboxes inputs
		$valid = array();

		//Cleanup
		//$valid['kas-result-pagelink'] = (isset($input['kas-result-pagelink']) && !empty($input['kas-result-pagelink'])) ? 1 : 0;


		return $valid;
	}


}
