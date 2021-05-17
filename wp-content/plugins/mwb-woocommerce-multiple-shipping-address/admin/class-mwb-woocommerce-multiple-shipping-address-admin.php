<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Mwb_Woocommerce_Multiple_Shipping_Address
 * @subpackage Mwb_Woocommerce_Multiple_Shipping_Address/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mwb_Woocommerce_Multiple_Shipping_Address
 * @subpackage Mwb_Woocommerce_Multiple_Shipping_Address/admin
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Mwb_Woocommerce_Multiple_Shipping_Address_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles( $hook ) {

		// Enqueue styles only on this plugin's menu page.
		if( $hook != 'toplevel_page_mwb_woocommerce_multiple_shipping_address_menu' ){

			return;
		}

		wp_enqueue_style( $this->plugin_name, MWB_WOOCOMMERCE_MULTIPLE_SHIPPING_ADDRESS_DIR_URL . 'admin/css/mwb-woocommerce-multiple-shipping-address-admin.css', array(), $this->version, 'all' );

		// Enqueue style for using WooCommerce Tooltip.
		wp_enqueue_style( 'woocommerce_admin_styles', WC()->plugin_url() . '/assets/css/admin.css', array(), WC_VERSION );

		wp_enqueue_style('select2');
		wp_enqueue_style('wp-color-picker');

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts( $hook ) {

		// Enqueue scripts only on this plugin's menu page.
		if( $hook != 'toplevel_page_mwb_woocommerce_multiple_shipping_address_menu' ){

			return;
		}

		wp_enqueue_script( $this->plugin_name . 'admin-js', MWB_WOOCOMMERCE_MULTIPLE_SHIPPING_ADDRESS_DIR_URL . 'admin/js/mwb-woocommerce-multiple-shipping-address-admin.js', array( 'jquery','select2','wp-color-picker' ), $this->version, false );

		wp_localize_script( $this->plugin_name . 'admin-js', 'license_ajax_object', array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'reloadurl' => admin_url( 'admin.php?page=mwb_woocommerce_multiple_shipping_address_menu' ),
			'license_nonce' => wp_create_nonce( 'mwb-woocommerce-multiple-shipping-address-license-nonce-action' ),
			) 
		);

		// Enqueue and Localize script for using WooCommerce Tooltip.
		
		wp_enqueue_script( 'woocommerce_admin', WC()->plugin_url() . '/assets/js/admin/woocommerce_admin.js', array( 'jquery', 'jquery-blockui', 'jquery-ui-sortable', 'jquery-ui-widget', 'jquery-ui-core', 'jquery-tiptip', 'wc-enhanced-select' ), WC_VERSION );

		$params = array(
			'strings' => '',
			'urls' => '',
			);

		wp_localize_script( 'woocommerce_admin', 'woocommerce_admin', $params );

	}

	/**
	 * Adding settings menu for MWB Woocommerce Multiple Shipping Address.
	 *
	 * @since    1.0.0
	 */
	public function add_options_page() {

		add_menu_page(
			__( 'MWB Woocommerce Multiple Shipping Address', 'mwb-woocommerce-multiple-shipping-address' ),
			__( 'MWB WOO Multiple Shipping Addresses', 'mwb-woocommerce-multiple-shipping-address' ),
			'manage_options',
			'mwb_woocommerce_multiple_shipping_address_menu',
			array( $this, 'options_menu_html' ),
			'',
			85
			);
	}

	/**
	 * MWB Woocommerce Multiple Shipping Address admin menu page.
	 *
	 * @since    1.0.0
	 */
	public function options_menu_html() {

		// Check user capabilities.
		if ( ! current_user_can( 'manage_options' ) ) {

			return;
		}

		$callname_lic = Mwb_Woocommerce_Multiple_Shipping_Address::$lic_callback_function;
		$callname_lic_initial = Mwb_Woocommerce_Multiple_Shipping_Address::$lic_ini_callback_function;
		$day_count = Mwb_Woocommerce_Multiple_Shipping_Address::$callname_lic_initial();

		?>

		<div class="mwb-woocommerce-multiple-shipping-address-wrap">

			<?php

			// Condition for Warning notification.
			if ( ! Mwb_Woocommerce_Multiple_Shipping_Address::$callname_lic() && 0 <= $day_count ):

				$day_count_warning = floor( $day_count );

			$day_string = sprintf( _n( '%s day', '%s days', $day_count_warning, 'mwb-woocommerce-multiple-shipping-address' ), number_format_i18n( $day_count_warning ) );

			$day_string = '<span id="mwb-woocommerce-multiple-shipping-address-day-count" >'.$day_string.'</span>';

			?>

			<div id="mwb-woocommerce-multiple-shipping-address-thirty-days-notify" class="notice notice-warning">
				<p>
					<strong><a href="?page=mwb_woocommerce_multiple_shipping_address_menu&tab=license"><?php _e( 'Activate', 'mwb-woocommerce-multiple-shipping-address' ); ?></a><?php printf( __( ' the license key before %s or you may risk losing data and the plugin will also become dysfunctional.', 'mwb-woocommerce-multiple-shipping-address' ), $day_string ); ?></strong>
				</p>
			</div>

			<?php

			endif;

			?>

			<h2><?php _e('MWB Woocommerce Multiple Shipping Address', 'mwb-woocommerce-multiple-shipping-address' ); ?></h2>

			<?php

			// Condition for validating.
			if( Mwb_Woocommerce_Multiple_Shipping_Address::$callname_lic() || 0 <= $day_count ) {

				$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'general_settings';

		     	// Redirect to default when tab value is not one of the valid ones.
				if( $active_tab != 'general_settings' && $active_tab != 'license' && $active_tab != 'about_us' && $active_tab != 'help') {

					wp_redirect( admin_url( 'admin.php?page=mwb_woocommerce_multiple_shipping_address_menu' ) );
					exit;
				}
				?>

				<h2 class="nav-tab-wrapper">

					<a href="?page=mwb_woocommerce_multiple_shipping_address_menu&tab=general" class="nav-tab <?php echo $active_tab == 'general_settings' ? 'nav-tab-active' : ''; ?>"><?php _e('General Options', 'mwb-woocommerce-multiple-shipping-address' ); ?></a>

					<?php if( ! Mwb_Woocommerce_Multiple_Shipping_Address::$callname_lic() ): ?>

						<a href="?page=mwb_woocommerce_multiple_shipping_address_menu&tab=license" class="nav-tab <?php echo $active_tab == 'license' ? 'nav-tab-active' : ''; ?>"><?php _e('License Activation', 'mwb-woocommerce-multiple-shipping-address' ); ?></a>

					<?php endif; ?>

					<a href="?page=mwb_woocommerce_multiple_shipping_address_menu&tab=help" class="nav-tab <?php echo $active_tab == 'help' ? 'nav-tab-active' : ''; ?>"><?php _e('Help', 'mwb-woocommerce-multiple-shipping-address' ); ?></a>

					<a href="?page=mwb_woocommerce_multiple_shipping_address_menu&tab=about_us" class="nav-tab <?php echo $active_tab == 'about_us' ? 'nav-tab-active' : ''; ?>"><?php _e('About Us', 'mwb-woocommerce-multiple-shipping-address' ); ?></a>

				</h2>

				<?php

				if( $active_tab == 'general_settings' ) {

		    		// Menu HTML and PHP code for General Options goes here.

					echo '<form action="options.php" method="post">';

					settings_errors();

					settings_fields( 'mwb_woocommerce_multiple_shipping_address_gen_menu' );

					do_settings_sections( 'mwb_woocommerce_multiple_shipping_address_gen_menu' );

					submit_button( __('Save Options', 'mwb-woocommerce-multiple-shipping-address' ) );

					echo '</form>';

				}// endif General Options tab.

				elseif( $active_tab == 'help' ) {

		    		// Menu HTML and PHP code for Help Section goes here.

					require_once MWB_WOOCOMMERCE_MULTIPLE_SHIPPING_ADDRESS_DIR_PATH . 'admin/partials/mwb-woocommerce-multiple-shipping-address-admin-help.php';

				}// endif Help Section tab.

				elseif( $active_tab == 'about_us' ) {

		    		// Menu HTML and PHP code for COntact Us Section goes here.

					require_once MWB_WOOCOMMERCE_MULTIPLE_SHIPPING_ADDRESS_DIR_PATH . 'admin/partials/mwb-woocommerce-multiple-shipping-address-admin-about_us.php';

				}// endif Contact Us Section tab.

				elseif( $active_tab == 'license' && ! Mwb_Woocommerce_Multiple_Shipping_Address::$callname_lic() ) {

		    		// Menu HTML and PHP code for License Activation goes here.

					require_once MWB_WOOCOMMERCE_MULTIPLE_SHIPPING_ADDRESS_DIR_PATH . 'admin/partials/mwb-woocommerce-multiple-shipping-address-admin-license.php';

				}// endif License Activation tab.

			}

			else{

				require_once MWB_WOOCOMMERCE_MULTIPLE_SHIPPING_ADDRESS_DIR_PATH . 'admin/partials/mwb-woocommerce-multiple-shipping-address-admin-license.php';
			}

			?>

		</div> <!-- mwb-woocommerce-multiple-shipping-address-wrap -->

		<?php
	}

	/**
	 * Using Settings API for settings menu.
	 *
	 * @since    1.0.0
	 */
	public function settings_api() {

		register_setting( 'mwb_woocommerce_multiple_shipping_address_gen_menu', 'mwb_woocommerce_multiple_shipping_address_enable_plugin' );

		add_settings_section(
			'mwb_woocommerce_multiple_shipping_address_gen_menu_sec',
			null,
			null,
			'mwb_woocommerce_multiple_shipping_address_gen_menu'
			);

		add_settings_field(
			'mwb_woocommerce_multiple_shipping_address_enable',
			__( 'Enable Plugin', 'mwb-woocommerce-multiple-shipping-address' ),
			array( $this, 'enable_plugin_general_cb' ),
			'mwb_woocommerce_multiple_shipping_address_gen_menu',
			'mwb_woocommerce_multiple_shipping_address_gen_menu_sec',
			'enable_plugins'
			);

		add_settings_field(
			'mwb_woocommerce_multiple_shipping_address_enable_guest',
			__( 'Enable Multiple Shipping Addresses For Guest Users', 'mwb-woocommerce-multiple-shipping-address' ),
			array( $this, 'enable_plugin_general_cb' ),
			'mwb_woocommerce_multiple_shipping_address_gen_menu',
			'mwb_woocommerce_multiple_shipping_address_gen_menu_sec',
			'enable_guest_users'
			);

		add_settings_field(
			'mwb_woocommerce_multiple_shipping_address_guest_cookie',
			__( 'Set Time Duration For Guest Users To Save their Addresses', 'mwb-woocommerce-multiple-shipping-address' ),
			array( $this, 'enable_plugin_general_cb' ),
			'mwb_woocommerce_multiple_shipping_address_gen_menu',
			'mwb_woocommerce_multiple_shipping_address_gen_menu_sec',
			'cookie_set'
			);

	}

    /**
	 * Callback for Enable Plugin option.
	 * @since    1.0.0
	 * @param    caharacter    $arguement  		 character.
	 */
    public function enable_plugin_general_cb($arguement) 
    {
    	$mwb_woo_msd_general_settings = get_option('mwb_woocommerce_multiple_shipping_address_enable_plugin');
    	
    	$mwb_woo_msd_cookies_options = array(
    		'day'=>__('Days','mwb-woocommerce-multiple-shipping-address'),
    		'week'=>__('Weeks','mwb-woocommerce-multiple-shipping-address'),
    		'month'=>__('Months','mwb-woocommerce-multiple-shipping-address'),
    		'year'=>__('Years','mwb-woocommerce-multiple-shipping-address')
    		);
    		?>
    		<div class="mwb-woocommerce-multiple-shipping-address-option-sec">
    			<?php 
    			if(isset($arguement) && $arguement == 'enable_plugins'){
    				$tip_description = __( 'Enable the checkbox if you want this extension to work.', 'mwb-woocommerce-multiple-shipping-address' );
    				echo wc_help_tip( $tip_description ); 
    				?>
    				<label for="mwb_woocommerce_multiple_shipping_address_enable_default_plugin">
    					<input type="checkbox" id="mwb_woocommerce_multiple_shipping_address_enable_default_plugin" name="mwb_woocommerce_multiple_shipping_address_enable_plugin[enable]" <?php if(isset($mwb_woo_msd_general_settings['enable'])){
    						checked('on', $mwb_woo_msd_general_settings['enable'] ); }?> >
    						<?php _e( 'Enable Multiple Shipping Addresses Plugin.', 'mwb-woocommerce-multiple-shipping-address' ); ?>	
    					</label>
    					<?php
    				}
    				if(isset($arguement) && $arguement == 'enable_guest_users'){
    					$tip_description = __( 'Enable the checkbox if you want this extension to work for guest users also.', 'mwb-woocommerce-multiple-shipping-address' );
    					echo wc_help_tip( $tip_description ); 
    					?>
    					<label for="mwb_woocommerce_multiple_shipping_address_guest">
    						<input type="checkbox" id="mwb_woocommerce_multiple_shipping_address_guest" name="mwb_woocommerce_multiple_shipping_address_enable_plugin[guest_users]" <?php if(isset($mwb_woo_msd_general_settings['guest_users'])){
    							checked('on', $mwb_woo_msd_general_settings['guest_users'] ); }?>>
    							<?php _e( 'Enable Multiple Shipping Addresses For Guest Users For Enter Multiple Addresses.', 'mwb-woocommerce-multiple-shipping-address' ); ?>	
    						</label>
    						<?php
    					}
    					if(isset($arguement) && $arguement == 'cookie_set'){
    						$tip_description = __( 'Enter the cookies value if you want to save guest users addresses.', 'mwb-woocommerce-multiple-shipping-address' );
    						echo wc_help_tip( $tip_description ); 
    						?>
    						<label for="mwb_woocommerce_multiple_shipping_address_set_cookies">

    							<input type="text" id="mwb_woocommerce_multiple_shipping_address_set_cookies" name="mwb_woocommerce_multiple_shipping_address_enable_plugin[cookie_value]" value="<?php if(isset($mwb_woo_msd_general_settings['cookie_value'])){ echo $mwb_woo_msd_general_settings['cookie_value']; }?>" placeholder="<?php _e("Enter Time Value","mwb-woocommerce-multiple-shipping-address");?>">

    							<select name="mwb_woocommerce_multiple_shipping_address_enable_plugin[cookie_duration]" id="mwb_woocommerce_multiple_shipping_address_set_cookies_duration">
    								<?php
    								if(is_array($mwb_woo_msd_cookies_options) && !empty($mwb_woo_msd_cookies_options)){
    									foreach($mwb_woo_msd_cookies_options as $wookey => $woovalue){
    										?>
    										<option value="<?php echo $wookey; ?>" <?php if(isset($mwb_woo_msd_general_settings['cookie_duration'])){ selected($wookey,$mwb_woo_msd_general_settings['cookie_duration']); }?>><?php echo $woovalue; ?></option>
    										<?php
    									}	
    								}
    								?>
    							</select>
    						</label>
    						<?php
    					}
    					?>
    				</div>
    				<?php
    			}

	/**
	 * Validate license.
	 *
	 * @since    1.0.0
	 */
	public function validate_license_handle() {

		// First check the nonce, if it fails the function will break
		check_ajax_referer( 'mwb-woocommerce-multiple-shipping-address-license-nonce-action', 'mwb-woocommerce-multiple-shipping-address-license-nonce' );

		$mwb_license_key = !empty( $_POST['mwb_woocommerce_multiple_shipping_address_purchase_code'] ) ? sanitize_text_field( $_POST['mwb_woocommerce_multiple_shipping_address_purchase_code'] ) : '';

    	// API query parameters
		$api_params = array(
			'slm_action' => 'slm_activate',
			'secret_key' => MWB_WOOCOMMERCE_MULTIPLE_SHIPPING_ADDRESS_SPECIAL_SECRET_KEY,
			'license_key' => $mwb_license_key,
			'registered_domain' => $_SERVER['SERVER_NAME'],
			'item_reference' => urlencode( MWB_WOOCOMMERCE_MULTIPLE_SHIPPING_ADDRESS_ITEM_REFERENCE ),
			);

		// Send query to the license manager server
		$query = esc_url_raw( add_query_arg( $api_params, MWB_WOOCOMMERCE_MULTIPLE_SHIPPING_ADDRESS_SERVER_URL ) );

		$response = wp_remote_get( $query, array( 'timeout' => 20, 'sslverify' => false ) );

		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		if( isset( $license_data->result ) && 'success' === $license_data->result ) {

			update_option( 'mwb_woocommerce_multiple_shipping_address_lcns_key', $mwb_license_key );
			update_option( 'mwb_woocommerce_multiple_shipping_address_lcns_status', 'true' );

			echo json_encode( array( 'status' => true, 'msg' =>__( 'Successfully Verified...', 'mwb-woocommerce-multiple-shipping-address' ) ) );
		}
		else{

			$error_message = !empty( $license_data->message ) ? $license_data->message : __( 'License Verification Failed.', 'mwb-woocommerce-multiple-shipping-address' );

			echo json_encode( array( 'status' => false, 'msg' => $error_message ) );
		}

		wp_die();
	}

    /**
     * Validate License daily.
     *
     * @since 1.0.0
     */
    public function validate_license_daily() {

    	$mwb_license_key = get_option( 'mwb_woocommerce_multiple_shipping_address_lcns_key', '' );

		// API query parameters
    	$api_params = array(
    		'slm_action' => 'slm_check',
    		'secret_key' => MWB_WOOCOMMERCE_MULTIPLE_SHIPPING_ADDRESS_SPECIAL_SECRET_KEY,
    		'license_key' => $mwb_license_key,
    		'registered_domain' => $_SERVER['SERVER_NAME'],
    		'item_reference' => urlencode( MWB_WOOCOMMERCE_MULTIPLE_SHIPPING_ADDRESS_ITEM_REFERENCE ),
    		);

    	$query = esc_url_raw( add_query_arg( $api_params, MWB_WOOCOMMERCE_MULTIPLE_SHIPPING_ADDRESS_SERVER_URL ) );

    	$mwb_response = wp_remote_get( $query, array( 'timeout' => 20, 'sslverify' => false ) );

    	$license_data = json_decode( wp_remote_retrieve_body( $mwb_response ) );

    	if( isset( $license_data->result ) && 'success' === $license_data->result && isset( $license_data->status ) && 'active' === $license_data->status ) {

    		update_option( 'mwb_woocommerce_multiple_shipping_address_lcns_key', $mwb_license_key );
    		update_option( 'mwb_woocommerce_multiple_shipping_address_lcns_status', 'true' );
    	}

    	else {

    		delete_option( 'mwb_woocommerce_multiple_shipping_address_lcns_key' );
    		update_option( 'mwb_woocommerce_multiple_shipping_address_lcns_status', 'false' );
    	}
    }
}
