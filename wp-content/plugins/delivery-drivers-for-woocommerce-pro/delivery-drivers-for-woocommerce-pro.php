<?php
/**
 * The plugin bootstrap file
 *
 * @link              https://www.deviodigital.com
 * @since             1.0.0
 * @package           DDWCP
 *
 * @wordpress-plugin
 * Plugin Name:       Delivery Drivers for WooCommerce Pro
 * Plugin URI:        https://www.deviodigital.com/product/delivery-drivers-for-woocommerce-pro/
 * Description:       Driver management for delivery services
 * Version:           1.7
 * Author:            Devio Digital
 * Author URI:        https://www.deviodigital.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ddwc-pro
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Current plugin version.
 */
define( 'DDWC_PRO_VERSION', '1.7' );

/**
 * Verify DDWC is active
 *
 * Display an error notice if the free version of this plugin is not installed
 * and activated before DDWC Pro is allowed to be activated.
 *
 * @since 1.7
 */
function ddwc_pro_is_ddwc_active() {
    if ( is_admin() && current_user_can( 'activate_plugins' ) &&  ! is_plugin_active( 'delivery-drivers-for-woocommerce/delivery-drivers-for-woocommerce.php' ) ) {
        add_action( 'admin_notices', 'ddwc_pro_ddwc_not_active_notice' );

        deactivate_plugins( plugin_basename( __FILE__ ) );

        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }
    }
}
add_action( 'admin_init', 'ddwc_pro_is_ddwc_active' );

/**
 * Error notice - Runs if DDWC is not active.
 *
 * @see ddwc_pro_is_ddwc_active()
 * @since 1.7
 */
function ddwc_pro_ddwc_not_active_notice() {
	$ddwc_link = '<a href="https://www.wordpress.org/plugins/delivery-drivers-for-woocommerce" target="_blank">Delivery Drivers for WooCommerce</a>';
	$error     = sprintf( esc_html__( 'Please activate the %1$s plugin before activating the pro version.', 'ddwc' ), $ddwc_link );
	echo '<div class="error"><p>' . $error . '</p></div>';
}

// Unclaimed orders WooCommerce settings.
include_once( dirname( __FILE__ ) . '/ddwc-pro-woocommerce-account-tab.php' );

// Unclaimed orders shortcode.
include_once( dirname( __FILE__ ) . '/ddwc-pro-dashboard-shortcode.php' );

// Twilio.
include_once( dirname( __FILE__ ) . '/vendors/twilio/Twilio/autoload.php' );

// Dokan settings.
if ( in_array( 'dokan-lite/dokan.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) ) {
    // Dokan settings.
    include_once( dirname( __FILE__ ) . '/ddwc-pro-dokan-settings.php' );
}

/**
 * Add custom WooCommerce email actions.
 *
 * @param array $email_actions
 *
 * @return array
 *
 * @since 1.1
 */
function ddwc_pro_add_email_actions( $email_actions ) {
    $email_actions[] = 'woocommerce_order_status_driver-assigned';
    $email_actions[] = 'woocommerce_order_status_out-for-delivery';
    $email_actions[] = 'woocommerce_order_status_processing_to_driver-assigned';
    $email_actions[] = 'woocommerce_order_status_driver-assigned_to_out-for-delivery';
    $email_actions[] = 'woocommerce_order_status_out-for-delivery_to_completed';

    return $email_actions;
}
add_filter( 'woocommerce_email_actions', 'ddwc_pro_add_email_actions' );

/**
 * Class Delivery_Drivers_WC_Emails
 *
 * @since 1.1
 */
class Delivery_Drivers_WC_Emails {
	/**
	 * Delivery_Drivers_WC_Emails constructor.
	 */
	public function __construct() {
    // Filtering the emails and adding our own email.
		add_filter( 'woocommerce_email_classes', array( $this, 'register_emails' ), 15, 1 );
    // Absolute path to the plugin folder.
		define( 'DDWC_PRO_EMAIL_PATH', plugin_dir_path( __FILE__ ) );
  }

  /**
   * Register emails
   *
	 * @param array $emails
	 *
	 * @return array
	 */
	public function register_emails( $emails ) {
    // Email classes.
    require_once 'emails/class-wc-order-driver-assigned.php';
    require_once 'emails/class-wc-order-out-for-delivery.php';
    require_once 'emails/class-wc-order-completed.php';

    // Register emails.
    $emails['WC_Order_Driver_Assigned']  = new WC_Order_Driver_Assigned();
    $emails['WC_Order_Out_For_Delivery'] = new WC_Order_Out_For_Delivery();
    $emails['WC_Order_Completed']        = new WC_Order_Completed();

    return $emails;
  }

}
new Delivery_Drivers_WC_Emails();

/**
 * Driver Dashboard - Access Denied Filter
 *
 * @param string $access_denied
 *
 * @return string
 *
 * @since 1.0
 */
function ddwc_pro_access_denied( $access_denied ) {
	  if ( false !== get_option( 'ddwc_pro_settings_driver_application' ) && 'yes' == get_option( 'ddwc_pro_settings_driver_application' ) ) {
	    if ( false !== get_option( 'ddwc_pro_settings_contact_page' ) && 'none' !== get_option( 'ddwc_pro_settings_contact_page' ) ) {
	        $contact_link = get_permalink( get_option( 'ddwc_pro_settings_contact_page' ) );
	    } else {
	        $contact_link = 'mailto:' . apply_filters( 'ddwc_pro_settings_contact_page_link_email_address', get_option( 'admin_email' ) );
	    }
	    $access_denied  = "<h3 class='ddwc access-denied'>" . __( 'Apply to become a driver', 'ddwc-pro' ) . "</h3>";
	    $access_denied .= "<p>" . __( 'Want to become a delivery driver for our company?', 'ddwc-pro' ) . "</p>";
	    $access_denied .= "<p><a href='" . $contact_link . "' class='button'>" . __( 'Contact Us', 'ddwc-pro' ) . "</a></p>";
	  } else {
	    // Do nothing.
	  }

	  return $access_denied;
}
add_filter( 'ddwc_access_denied', 'ddwc_pro_access_denied', 10, 3 );

/**
 * Add settings to the specific section we created before
 *
 * @since 1.0
 */
function ddwc_pro_all_settings( $settings ) {
		// Get loop of all Pages.
		$args = array(
			'sort_column'  => 'post_title',
			'hierarchical' => 1,
			'post_type'    => 'page',
			'post_status'  => 'publish'
		);
		$pages = get_pages( $args );

		// Create data array.
		$pages_array = array( 'none' => '' );

		// Loop through pages.
		foreach ( $pages as $page ) {
			$pages_array[ $page->ID ] = $page->post_title;
		}

		// Add Title to the Settings.
		$settings[] = array( 'name' => __( 'DDWC Pro Settings', 'ddwc-pro' ), 'type' => 'title', 'desc' => __( 'The following options are used to configure DDWC Pro settings', 'ddwc-pro' ), 'id' => 'ddwc_pro_title' );

    // Add auto-assign drivers checkbox.
		$settings[] = array(
			'name'     => __( 'Auto-assign Drivers', 'ddwc-pro' ),
			'desc_tip' => __( 'Let the plugin auto-assign a random driver with each new order', 'ddwc-pro' ),
			'id'       => 'ddwc_pro_settings_auto_assign_drivers',
			'type'     => 'checkbox',
      'css'      => 'min-width:300px;',
      'default'  => 'yes',
			'desc'     => __( 'Enable auto-assign drivers', 'ddwc-pro' ),
		);

    // Add driver application checkbox.
		$settings[] = array(
			'name'     => __( 'Driver Application', 'ddwc-pro' ),
			'desc_tip' => __( 'Allow users to apply to become a delivery driver through the Driver Dashboard', 'ddwc-pro' ),
			'id'       => 'ddwc_pro_settings_driver_application',
			'type'     => 'checkbox',
			'css'      => 'min-width:300px;',
			'desc'     => __( 'Enable driver applications', 'ddwc-pro' ),
		);

    // Add driver application contact link select box.
		$settings[] = array(
			'name'    => __( 'Driver Application Contact Link', 'ddwc-pro' ),
			'id'      => 'ddwc_pro_settings_contact_page',
      'type'    => 'select',
      'options' => $pages_array,
      'default' => 'none',
			'desc'    => __( 'If no page is selected, the contact button will link to the administrator email address', 'ddwc-pro' ),
		);

    // Message type.
		$settings[] = array(
			'name'    => __( 'Message type', 'ddwc-pro' ),
			'id'      => 'ddwc_pro_settings_message_types',
      'type'    => 'select',
      'options' => array(
          'email'     => 'Email (default)',
          'sms'       => 'Twilio SMS',
          //'burst_sms' => 'Burst SMS',
      ),
      'default' => 'email',
			'desc'    => __( 'Choose how you would like messages sent to admins, drivers & customers', 'ddwc-pro' ),
		);

    // Add section end.
		$settings[] = array( 'type' => 'sectionend', 'id' => 'ddwc_pro_section_end' );

    // Add Title to the Twilio (SMS) Settings.
		$settings[] = array( 'name' => __( 'Twilio SMS Settings', 'ddwc-pro' ), 'type' => 'title', 'desc' => __( 'The following options are used to configure SMS integration with', 'ddwc-pro' ) . ' <a href="https://www.twilio.com" target="_blank">Twilio</a>', 'id' => 'ddwc_pro_twilio_title' );

    // Add Twilio Phone Number.
		$settings[] = array(
			'name' => __( 'Twilio Phone Number', 'ddwc-pro' ),
			'id'   => 'ddwc_pro_settings_twilio_phone_number',
			'type' => 'text',
			'desc' => __( 'Add a Twilio number you own with SMS capabilities', 'ddwc-pro' ),
		);

    // Add Twilio Account SID.
		$settings[] = array(
			'name' => __( 'Twilio Account SID', 'ddwc-pro' ),
			'id'   => 'ddwc_pro_settings_twilio_account_sid',
			'type' => 'text',
			'desc' => __( 'Add your Twilio Account SID', 'ddwc-pro' ),
		);

    // Add Twilio Auth Token.
		$settings[] = array(
			'name' => __( 'Twilio Auth Token', 'ddwc-pro' ),
			'id'   => 'ddwc_pro_settings_twilio_auth_token',
			'type' => 'text',
			'desc' => __( 'Add your Twilio Auth Token', 'ddwc-pro' ),
		);

    // Add section end.
		$settings[] = array( 'type' => 'sectionend', 'id' => 'ddwc_pro_section_end' );

    /*
    // Add Title to the Burst SMS Settings.
		$settings[] = array( 'name' => __( 'Burst SMS Settings', 'ddwc-pro' ), 'type' => 'title', 'desc' => __( 'The following options are used to configure SMS integration with', 'ddwc-pro' ) . ' <a href="https://www.burstsms.com.au/" target="_blank">Burst SMS</a>', 'id' => 'ddwc_pro_burst_sms_title' );

    // Add Burst SMS API Key.
		$settings[] = array(
			'name' => __( 'Burst SMS API Key', 'ddwc-pro' ),
			'id'   => 'ddwc_pro_settings_burst_sms_api_key',
			'type' => 'text',
			'desc' => __( 'Add your Burst SMS API Key', 'ddwc-pro' ),
		);

    // Add Burst SMS API Secret.
		$settings[] = array(
			'name' => __( 'Burst SMS API Secret', 'ddwc-pro' ),
			'id'   => 'ddwc_pro_settings_burst_sms_api_secret',
			'type' => 'text',
			'desc' => __( 'Add your Burst SMS API Secret', 'ddwc-pro' ),
        );

    // Add section end.
		$settings[] = array( 'type' => 'sectionend', 'id' => 'ddwc_pro_section_end' );
    */

    return $settings;
}
add_filter( 'ddwc_woocommerce_settings', 'ddwc_pro_all_settings', 10, 2 );

/**
 * Run codes after order has been submitted by customer
 *
 * - change order status from Processing to Driver Assigned
 * - auto-assign a Driver
 *
 * @since 1.0
 */
function ddwc_pro_woocommerce_thankyou_change_order_status( $order_id ) {
    if ( ! $order_id ) return;

    // Check if the Auto-Assign Drivers checkbox has been selected.
    if ( 'no' !== get_option( 'ddwc_pro_settings_auto_assign_drivers' ) ) {

        // Get Order Details.
        $order = wc_get_order( $order_id );

        // Get Drivers.
        $args = array(
            'blog_id' => $GLOBALS['blog_id'],
            'role'    => 'driver',
        );
        $drivers = get_users( $args );

        // Create Drivers array.
        $drivers_array = array();

        // Add Drivers to array.
        foreach ( $drivers as $driver ) {
            // Driver ID.
            $driver_id = $driver->ID;
            // Add driver to array if driver is available.
            if ( 'on' == get_user_meta( $driver_id, 'ddwc_driver_availability', TRUE ) ) {
                $drivers_array[ $driver_id ] = $driver_id;
            }
        }

        // Filter drivers array.
        $drivers_array = apply_filters( 'ddwc_pro_assign_driver_drivers_array', $drivers_array );

        // Get random driver ID.
        $driver_id = array_rand( $drivers_array );

        // If order status is Processing (default).
        if ( in_array( $order->get_status(), apply_filters( 'ddwc_pro_assign_drivers_order_statuses', array( 'processing' ) ) ) ) {
            // Assign a Driver.
            update_post_meta( $order_id, 'ddwc_driver_id', $driver_id );
            // Update Order Status.
            $order->update_status( 'driver-assigned' );
        }

    } else {
        // Do nothing.
    }

}
add_action( 'woocommerce_thankyou', 'ddwc_pro_woocommerce_thankyou_change_order_status', 10, 1 );

/**
 * Add Unclaimed Orders link to Driver Dashboard.
 *
 * @since 1.2
 */
function ddwc_pro_completed_orders_table_after() {
	$user_id = get_current_user_id();
	if(get_user_meta( $user_id, 'wpuf_user_status', true ) != 'pending'){
	
    $str  = "<h4 class='ddwc assigned-orders'>" . __( 'Unclaimed Orders', 'ddwc-pro' ) . "</h4>";
    $str .= "<a href='" . apply_filters( 'ddwc_pro_unclaimed_orders_link', get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) . 'unclaimed-orders' ) . "' class='button'>" . __( 'View', 'ddwc-pro' ) . "</a>";

    echo apply_filters( 'ddwc_pro_unclaimed_orders', $str );
	
	}
}

//add_action( 'ddwc_completed_orders_table_after', 'ddwc_pro_completed_orders_table_after' );
//add_action( 'ddwc_assigned_orders_empty_after', 'ddwc_pro_completed_orders_table_after' );

/**
 * Receive order updates via text messages.
 *
 * @since 1.3
 */
function ddwc_pro_user_sms_updates_checkbox( $checkout ) {
    if ( 'sms' == get_option( 'ddwc_pro_settings_message_types' ) ) {
        echo '<div class="ddwc-pro-sms-updates"><h3>' . __( 'SMS Updates', 'ddwc-pro' ) . '</h3>';
        woocommerce_form_field( 'ddwc_pro_user_sms_updates_checkbox', array(
            'type'     => 'checkbox',
            'label'    => __( 'Receive order updates via text', 'ddwc-pro' ),
            'required' => false,
        ), $checkout->get_value( 'ddwc_pro_user_sms_updates_checkbox' ) );
        echo '</div>';
    }
}
add_action( 'woocommerce_after_order_notes', 'ddwc_pro_user_sms_updates_checkbox' );

/**
 * Save the SMS checkbox data with other checkout order meta.
 *
 * @since 1.3
 */
function ddwc_pro_user_sms_updates_checkbox_order_meta( $order_id ) {
    if ( 'sms' == get_option( 'ddwc_pro_settings_message_types' ) ) {
        if ( $_POST['ddwc_pro_user_sms_updates_checkbox'] ) update_post_meta( $order_id, 'ddwc_pro_user_sms_updates_checkbox', esc_attr( $_POST['ddwc_pro_user_sms_updates_checkbox'] ) );
    }
}
add_action( 'woocommerce_checkout_update_order_meta', 'ddwc_pro_user_sms_updates_checkbox_order_meta' );

/**
 * Add DRIVER endpoint to the Orders REST API data
 *
 * @since 1.4
 * @return array $response
 */
function ddwc_pro_wc_rest_prepare_order_object( $response, $object, $request ) {
	  // Get ID or Parent ID - for sub-orders.
	  if ( 0 == $object->get_parent_id() ) {
	      $orderid = $object->get_id();
	  } else {
	      $orderid = $object->get_parent_id();
	  }

	  // Get driver ID.
	  $driver_id = get_post_meta( $orderid, 'ddwc_driver_id', true );

	  // Get the driver data.
	  $driver = get_userdata( $driver_id );

	  // Get driver picture.
	  $driver_pic = get_user_meta( $driver_id, 'ddwc_driver_picture', true );

	  // Create empty array.
	  $driver_details = array();

	  // Add driver ID to array.
	  $driver_details['driver_id'] = $driver->ID;

	  // Add driver name to array.
	  $driver_details['driver_name'] = $driver->user_firstname . ' ' .  $driver->user_lastname;

	  // Add driver avatar to array.
	  $driver_details['driver_image'] = $driver_pic['url'];

	  // Add driver phone number to array.
	  $driver_details['phone_number'] = get_user_meta( $driver_id, 'billing_phone', true );

	  // Add driver transportation type to array.
	  $driver_details['transportation_type'] = get_user_meta( $driver_id, 'ddwc_driver_transportation_type', true );

	  // Add driver car color to array.
	  $driver_details['car_color'] = get_user_meta( $driver_id, 'ddwc_driver_car_color', true );

	  // Add driver car model to array.
	  $driver_details['car_model'] = get_user_meta( $driver_id, 'ddwc_driver_car_model', true );

	  // Add driver license plate to array.
	  $driver_details['license_plate'] = get_user_meta( $driver_id, 'ddwc_driver_license_plate', true );

	  // Add driver rating to array.
	  $driver_details['driver_rating'] = get_post_meta( $orderid, 'ddwc_delivery_rating', true );

	  // Add driver endpoint.
		$response->data['driver'] = apply_filters( 'ddwc_pro_order_object_driver_details', $driver_details );

		return $response;
}
add_filter( 'woocommerce_rest_prepare_shop_order_object', 'ddwc_pro_wc_rest_prepare_order_object', 10, 3 );

/**
 * Add "Driver Dashboard" link to additional roles.
 *
 * @param     array $roles
 * @return    array
 * @since     1.4
 */
function ddwc_pro_my_account_check_user_role_array( $roles ) {
    // Set new roles.
    $roles = apply_filters( 'ddwc_pro_my_account_check_user_role_array', array( 'administrator', 'customer', 'driver' ) );

    return $roles;
}

// Update user roles if driver application setting is turned on.
if ( false !== get_option( 'ddwc_pro_settings_driver_application' ) && 'yes' == get_option( 'ddwc_pro_settings_driver_application' ) ) {
    // Update user roles for Driver Dashboard to include 'customer' and 'administrator'.
    add_filter( 'ddwc_my_account_check_user_role_array', 'ddwc_pro_my_account_check_user_role_array' );
}

/**
 * Send 'assigned order' email to delivery driver when an order is edited, saved,
 * and the delivery driver is newly assigned.
 *
 * @return    void
 * @since     1.7
 */
function ddwc_pro_send_email_to_driver_on_order_save( $post_id, $post ) {
		// Bail early if not in admin.
		if ( ! is_admin() ) return;
		// Bail early if this is an autosave.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		// Bail early if the current user can't edit posts.
		if ( ! current_user_can( 'edit_post', $post_id ) ) return;

		// Run only if post is not a revision and a new driver ID is being saved.
	  if ( $post->post_type !== 'revision' && isset( $_POST['ddwc_driver_id'] ) ) {
				// get last saved driver ID (if any).
				$driver_id_old = get_post_meta( $post_id, 'ddwc_driver_id', true );
				// Only run if old driver ID is available and driver ID is updated.
				if ( $_POST['ddwc_driver_id'] != $driver_id_old  && false != $_POST['ddwc_driver_id'] ) {
						// Get order.
						$order = new WC_Order( $post_id );
						$order->update_status( 'driver-assigned' );

						// Get driver data.
						$driver_info  = get_userdata( $_POST['ddwc_driver_id'] );
						$driver_email = $driver_info->user_email;

						if ( false == $_POST['ddwc_driver_id'] ) {
								$order->update_status( 'processing' );
						}

				}
		}
}
add_action( 'save_post_shop_order', 'ddwc_pro_send_email_to_driver_on_order_save', 10, 2 );
