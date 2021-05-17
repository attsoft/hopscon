<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Kas_Dvf_Activation {

	public static function activate() {		

		
		    // Require Dokan plugin
	    if (is_plugin_active( 'dokan/dokan.php' ) and current_user_can( 'activate_plugins' )) {
			add_option( 'kas-show-country', 1, '', 'yes' );
			add_option( 'kas-show-state', 1, '', 'yes' );
			add_option( 'kas-show-city', 1, '', 'yes' );
			add_option( 'kas-show-zip', 1, '', 'yes' );
			add_option( 'kas-show-store', 1, '', 'yes' );
			add_option( 'kas-show-ratting', 1, '', 'yes' );
			add_option( 'kas-show-category', 0, '', 'yes' );
			add_option( 'kas-show-frating', 0, '', 'yes' );
			add_option( 'kas-show-country-s', 1, '', 'yes' );
			add_option( 'kas-show-state-s', 1, '', 'yes' );
			add_option( 'kas-show-city-s', 1, '', 'yes' );
			add_option( 'kas-show-zip-s', 1, '', 'yes' );
			add_option( 'kas-show-store-s', 1, '', 'yes' );
			add_option( 'kas-show-country-w', 1, '', 'yes' );
			add_option( 'kas-show-state-w', 1, '', 'yes' );
			add_option( 'kas-show-city-w', 1, '', 'yes' );
			add_option( 'kas-show-zip-w', 1, '', 'yes' );
			add_option( 'kas-show-store-w', 1, '', 'yes' );
			add_option( 'kas-show-category-w', 0, '', 'yes' );
			add_option( 'kas-show-frating-w', 0, '', 'yes' );
			add_option( 'kas-show-mapview', 0, '', 'yes' );
			add_option( 'kas-map-zoom', 12, '', 'yes' );
			add_option( 'kas-map-height', 400, '', 'yes' );
			add_option( 'kas-enable-bootstrap', 1, '', 'yes' );	 
			add_option( 'kas-enable-select2', 2, '', 'yes' );    
			add_option( 'kas-products-perpage', 10, '', 'yes' );   
			add_option( 'kas-products-maxprice', 100000, '', 'yes' );	
		    
		    // Create post object
		    $kas_results_page = array(
		      'post_title'    => 'Vendors',
		      'post_content'  => '[kas_dokan_vendor_filter]<br>[kas_dokan_vendor_filter_results]',
		      'post_status'   => 'publish',
		      'post_author'   => get_current_user_id(),
		      'post_type'     => 'page',
		    );
		
		    // Insert the post into the database
		    $page_id = wp_insert_post( $kas_results_page, '' );
		
		    // link to page
			$result_link = get_permalink($page_id);
			add_option('kas-result-page-id',$page_id,'','yes');
			add_option( 'kas-result-pagelink', $result_link, '', 'yes' );
	    }elseif (is_plugin_active( 'dokan-lite/dokan.php' ) and current_user_can( 'activate_plugins' ) ){
			add_option( 'kas-show-country', 1, '', 'yes' );
			add_option( 'kas-show-state', 1, '', 'yes' );
			add_option( 'kas-show-city', 1, '', 'yes' );
			add_option( 'kas-show-zip', 1, '', 'yes' );
			add_option( 'kas-show-store', 1, '', 'yes' );
			add_option( 'kas-show-ratting', 1, '', 'yes' );
			add_option( 'kas-show-category', 0, '', 'yes' );
			add_option( 'kas-show-frating', 0, '', 'yes' );
			add_option( 'kas-show-country-s', 1, '', 'yes' );
			add_option( 'kas-show-state-s', 1, '', 'yes' );
			add_option( 'kas-show-city-s', 1, '', 'yes' );
			add_option( 'kas-show-zip-s', 1, '', 'yes' );
			add_option( 'kas-show-store-s', 1, '', 'yes' );
			add_option( 'kas-show-country-w', 1, '', 'yes' );
			add_option( 'kas-show-state-w', 1, '', 'yes' );
			add_option( 'kas-show-city-w', 1, '', 'yes' );
			add_option( 'kas-show-zip-w', 1, '', 'yes' );
			add_option( 'kas-show-store-w', 1, '', 'yes' );
			add_option( 'kas-show-frating-w', 0, '', 'yes' );
			add_option( 'kas-show-category-w', 0, '', 'yes' );
			add_option( 'kas-show-mapview', 0, '', 'yes' );
			add_option( 'kas-map-zoom', 12, '', 'yes' );
			add_option( 'kas-map-height', 400, '', 'yes' );
			add_option( 'kas-enable-bootstrap', 1, '', 'yes' );	 
			add_option( 'kas-enable-select2', 2, '', 'yes' ); 
			add_option( 'kas-products-perpage', 10, '', 'yes' ); 
			add_option( 'kas-products-maxprice', 100000, '', 'yes' );	    	
		    
		    // Create post object
		    $kas_results_page = array(
		      'post_title'    => 'Vendors',
		      'post_content'  => '[kas_dokan_vendor_filter]<br>[kas_dokan_vendor_filter_results]',
		      'post_status'   => 'publish',
		      'post_author'   => get_current_user_id(),
		      'post_type'     => 'page',
		    );
		
		    // Insert the post into the database
		    $page_id = wp_insert_post( $kas_results_page, '' );
		
		    // link to page
			$result_link = get_permalink($page_id);
			add_option('kas-result-page-id',$page_id,'','yes');
			add_option( 'kas-result-pagelink', $result_link, '', 'yes' );
	    }else{
	    	// Stop activation redirect and show error
	        wp_die('Sorry, but this plugin requires the Dokan - Multi-vendor Marketplace/Dokan Lite Plugin to be installed and active. <br><a href="' . admin_url( 'plugins.php' ) . '">&laquo; Return to Plugins</a>');
	    
	    }	
		
	}

}