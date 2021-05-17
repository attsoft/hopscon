<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Kas_Dvf_Deactivation {

	public static function deactivate() {
		delete_option( 'kas-show-country' );
		delete_option( 'kas-show-state' );
		delete_option( 'kas-show-city' );
		delete_option( 'kas-show-zip' );
		delete_option( 'kas-show-frating' );
		delete_option( 'kas-show-store' );
		delete_option( 'kas-show-ratting' );
		delete_option( 'kas-show-category' );
		delete_option( 'kas-show-country-s' );
		delete_option( 'kas-show-state-s' );
		delete_option( 'kas-show-city-s' );
		delete_option( 'kas-show-zip-s' );
		delete_option( 'kas-show-store-s' );
		delete_option( 'kas-show-ratting-s' );
		delete_option( 'kas-show-country-w' );
		delete_option( 'kas-show-state-w' );
		delete_option( 'kas-show-city-w' );
		delete_option( 'kas-show-zip-w' );
		delete_option( 'kas-show-frating-w' );
		delete_option( 'kas-show-store-w' );
		delete_option( 'kas-show-category-w' );
		delete_option( 'kas-show-mapview' );
		delete_option( 'kas-map-zoom' );
		delete_option( 'kas-map-height' );
		delete_option( 'kas-result-pagelink' );
		delete_option( 'kas-enable-bootstrap' );	
		delete_option( 'kas-enable-select2' );	
		delete_option( 'kas-products-perpage' );
		delete_option( 'kas-products-maxprice' );
		wp_delete_post( get_option('kas-result-page-id'), true );
		delete_option( 'kas-result-page-id' );
	}

}