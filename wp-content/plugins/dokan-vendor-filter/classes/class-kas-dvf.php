<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://ideas.echopointer.com
 * @since      1.0.0
 *
 * @package    Kas_Dvf
 * @subpackage Kas_Dvf/classes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Kas_Dvf
 * @subpackage Kas_Dvf/classes
 * @author     Syed Muhammad Shafiq <shafiq_shaheen@hotmail.com>
 */
class Kas_Dvf {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Kas_Dokan_Vendor_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $kas_filter    The string used to uniquely identify this plugin.
	 */
	protected $kas_filter;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->kas_filter = 'kas-dvf';
		$this->version = '1.2.7';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Kas_Dvf_Loader. Orchestrates the hooks of the plugin.
	 * - Kas_Dvf_i18n. Defines internationalization functionality.
	 * - Kas_Dvf_Admin. Defines all hooks for the admin area.
	 * - Kas_Dvf_Public. Defines all hooks for the public side of the site.
	 * - Kas_Dvf_DokanData. Collect and get all required Dokan saller information.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/class-kas-dvf-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/class-kas-dvf-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-kas-dvf-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-kas-dvf-public.php';

		$this->loader = new Kas_Dvf_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Kas_Dvf_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$kas_i18n = new Kas_Dvf_i18n();
		$kas_i18n->set_domain( $this->get_kas_filter() );

		$this->loader->add_action( 'plugins_loaded', $kas_i18n, 'load_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Kas_Dvf_Admin( $this->get_kas_filter(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		// Save/Update our plugin options
		$this->loader->add_action( 'admin_init', $plugin_admin, 'options_update');

		// Add menu item
		$this->loader->add_action( 'dokan_admin_menu', $plugin_admin, 'add_kas_admin_menu' );

		// Add Settings link
		$plugin_basename = plugin_basename( plugin_dir_path( __DIR__ ) . $this->kas_filter . '.php' );
		$this->loader->add_filter( 'plugin_action_links_' . $plugin_basename, $plugin_admin, 'add_action_links' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$kas_public = new Kas_Dvf_Public( $this->get_kas_filter(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $kas_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $kas_public, 'enqueue_scripts' );
		$this->loader->add_action( 'widgets_init', $kas_public, 'kas_dvf_widget' );
		
		add_shortcode('kas_dokan_vendor_filter', array($kas_public, 'kas_shortcode_dvf'));
		add_shortcode('kas_dokan_vendor_filter_aio', array($kas_public, 'kas_shortcode_dvf_aio'));
		add_shortcode('kas_dokan_vendor_filter_results', array($kas_public, 'kas_shortcode_dvf_results'));


	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_kas_filter() {
		return $this->kas_filter;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Kas_Dokan_Vendor_Filter_Loader    Orchestrates the hooks.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
