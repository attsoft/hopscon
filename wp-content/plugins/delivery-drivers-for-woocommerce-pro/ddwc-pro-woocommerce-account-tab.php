<?php

/**
 * WooCommerce Account Tab - Drivers
 *
 * @link       https://www.deviodigital.com
 * @since      1.0.0
 *
 * @package    DDWC
 * @subpackage DDWC/admin
 */

/**
 * Register new endpoint to use inside My Account page.
 *
 * @see https://developer.wordpress.org/reference/functions/add_rewrite_endpoint/
 */
function ddwc_pro_endpoints() {
	add_rewrite_endpoint( 'unclaimed-orders', EP_ROOT | EP_PAGES );
}
add_action( 'init', 'ddwc_pro_endpoints' );

/**
 * Add new query var.
 *
 * @param array $vars
 * @return array
 *
 * @since 1.2
 */
add_filter( 'woocommerce_get_query_vars', function ( $vars ) {
    foreach ( ['unclaimed-orders'] as $e ) {
        $vars[$e] = $e;
    }
    return $vars;
} );

// Flush rewrite rules.
function ddwc_pro_flush_rewrite_rules() {
	add_rewrite_endpoint( 'unclaimed-orders', EP_ROOT | EP_PAGES );
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'ddwc_pro_flush_rewrite_rules' );

/**
 * Insert the new endpoint into the My Account menu.
 *
 * @param array $items
 * @return array
 */
function ddwc_pro_my_account_menu_items( $items ) {
	// Get customer-logout menu item.
	$logout = $items['customer-logout'];
	// Remove the customer-logout menu item.
	unset( $items['customer-logout'] );
	// Insert the unclaimed-orders endpoint.
	$items['unclaimed-orders'] = apply_filters( 'ddwc_pro_my_account_menu_item_unclaimed_orders', __( 'Unclaimed Orders', 'ddwc-pro' ) );
	// Insert back the customer-logout item.
	$items['customer-logout'] = $logout;

	return $items;
}
//add_filter( 'woocommerce_account_menu_items', 'ddwc_pro_my_account_menu_items' );

/**
 * Endpoint HTML content.
 */
function ddwc_pro_endpoint_content() {
	echo do_shortcode( '[ddwc_pro_dashboard]' );
}
add_action( 'woocommerce_account_unclaimed-orders_endpoint', 'ddwc_pro_endpoint_content' );

/**
 * Change endpoint title.
 *
 * @param string $title
 * @return string
 */
function ddwc_pro_endpoint_title( $title, $id ) {

	if ( is_wc_endpoint_url( 'unclaimed-orders' ) && in_the_loop() ) {
		$title = apply_filters( 'ddwc_pro_my_account_endpoint_title_unclaimed_orders', esc_attr__( 'Unclaimed Orders', 'ddwc-pro' ) );
	}
	return $title;
}
add_filter( 'the_title', 'ddwc_pro_endpoint_title', 10, 2 );
