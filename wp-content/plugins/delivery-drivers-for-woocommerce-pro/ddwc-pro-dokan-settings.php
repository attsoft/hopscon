<?php

/**
 * Dokan Multi-vendor support
 *
 * @link       https://www.deviodigital.com
 * @since      1.5.0
 *
 * @package    DDWC
 * @subpackage DDWC/admin
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Google Maps Waypoints
 *
 * Updates the Google Map displayed on the Driver's Order details page
 *
 * @since 1.5
 */
function ddwc_pro_driver_dashboard_waypoints_google_map( $google_map, $delivery_address, $store_address ) {
    // Get Order ID.
    $order_items     = wc_get_order( $_GET['orderid'] );
    $currency_code   = $order_items->get_currency();
    $currency_symbol = get_woocommerce_currency_symbol( $currency_code );

    if ( ! empty( $order_items ) ) {
        // Waypoints.
        $waypoints = '';

        // Counter.
        $counter = 0;

        // The loop to get the order items which are WC_Order_Item_Product objects since WC 3+
        foreach( $order_items->get_items() as $item_id=>$item_product ) {

            // Get the author ID (the vendor ID).
            $vendor_id = get_post_field( 'post_author', $item_product['product_id'] );

            // Get the WP_User object (the vendor) from author ID.
            $vendor = new WP_User( $vendor_id );

            // Vendor address.
            $store_info = dokan_get_store_info( $vendor_id );
            $address    = $store_info['address']['street_1'];
            $address2   = $store_info['address']['street_2'];
            $postcode   = $store_info['address']['zip'];
            $city       = $store_info['address']['city'];
            $state      = $store_info['address']['state'];
            $country    = $store_info['address']['country'];

            // Vendor location.
            $map_location = ! empty( $store_info['location'] ) ? esc_attr( $store_info['location'] ) : $address . ' ' . $address2 . ' ' . $city . ' ' . $postcode . ' ' . $country . ' ' . $state;

            // Waypoints separator.
            if ( 0 == $counter ) {
                $sep = '';
            } else {
                $sep = '|';
            }

            // Add address to string.
            $waypoints .= $sep . $map_location;
            // Add to counter.
            $counter = $counter + 1;
        }

        // Get the google map with waypoints for each vendor.
        $google_map = '<iframe width="600" height="450" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/directions?origin=' . apply_filters( 'ddwc_google_maps_origin_address', $store_address ) . '&destination=' . apply_filters( 'ddwc_google_maps_delivery_address', $delivery_address ) . '&key=' . get_option( 'ddwc_settings_google_maps_api_key' ) . '&waypoints=' . $waypoints . '" allowfullscreen></iframe>';

    } else {
        // Do nothing.
    }

    return $google_map;
}
add_action( 'ddwc_delivery_address_google_map', 'ddwc_pro_driver_dashboard_waypoints_google_map', 10, 3 );

/**
 * Add a CALL VENDOR button to the order details screen for delivery drivers
 *
 * @since 1.7
 * @param string $phone_numbers
 * @return string
 */
function ddwc_pro_driver_dashboard_call_vendor_button( $phone_numbers ) {

    // Order data.
    $order_items = wc_get_order( $_GET['orderid'] );
    // Loop through order items.
    if ( ! empty( $order_items ) ) {
        // The loop to get the order items which are WC_Order_Item_Product objects since WC 3+
        foreach( $order_items->get_items() as $item_id=>$item_product ) {
            // Get the author ID (the vendor ID).
            $vendor_id = get_post_field( 'post_author', $item_product['product_id'] );
            // Get the WP_User object (the vendor) from author ID.
            $vendor = new WP_User( $vendor_id );
            // Vendor address.
            $store_info = dokan_get_store_info( $vendor_id );
            // Add vendor phone number button to driver dashboard order details.
			
		if ($store_info['phone']) {
            $phone_numbers .= '<a href="tel:' . $store_info['phone'] . '" class="button ddwc-button vendor">' . esc_attr__( 'Call', 'ddwc' ) . ' ' . $store_info['store_name']  . '</a> ';
           }
		}
		
    }
    return $phone_numbers;
}
add_filter( 'ddwc_driver_dashboard_phone_numbers', 'ddwc_pro_driver_dashboard_call_vendor_button' );
