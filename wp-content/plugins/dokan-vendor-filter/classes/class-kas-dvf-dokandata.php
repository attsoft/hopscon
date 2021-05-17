<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Get all required data from Dokan and woocommerce
 *
 *
 * @link       http://ideas.echopointer.com
 * @since      1.0.6
 *
 * @package    Kas_Dvf
 * @subpackage Kas_Dvf/classes
 */

/**
 * The core plugin class.
 *
 *
 * @since      1.0.6
 * @package    Kas_Dvf
 * @subpackage Kas_Dvf/classes
 * @author     Syed Muhammad Shafiq <shafiq_shaheen@hotmail.com>
 */
class Kas_Dvf_DokanData {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.6
	 * @access   private
	 * @var      string    $kas_filter    The ID of this plugin.
	 */
	private $kas_filter;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.6
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.6
	 * @param      string    $kas_filter       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */


	public function __construct( $kas_filter, $version ) {

		$this->kas_filter = $kas_filter;
		$this->version = $version;

	}

	/**
	 * Collect all required dokan seller data in assosiative array.
	 *
	 * @since    1.0.6
	 */
	public function kas_dokan_data() {
		$data = array();
		// args to get all users
		$args = array(
	            'role' => '',
	            'meta_key' => '',
	            'meta_value' => '',
	            'meta_compare' => '',
	            'meta_query' => array(),
	            'date_query' => array(),
	            'include' => array(),
	            'exclude' => array(),
	            'orderby' => 'login',
	            'order' => 'ASC',
	            'offset' => '',
	            'search' => '',
	            'number' => '',
	            'count_total' => false,
	            'fields' => 'all',
	            'who' => ''
	            );

	            if (isset($role) AND ! empty($role)){
	            	$args['role'] = $role;
	            }

	            $kas_authors = get_users($args);

	            foreach ($kas_authors as $user){
	            	$kas_store_info   = dokan_get_store_info($user->data->ID);
	            	$store_url  = dokan_get_store_url($user->data->ID);

	            	 
	            	if (!empty($kas_store_info['address']['country'])) {
	            		
		            	// get vendor products
		            	$args = array(
						    'author'     =>  $user->data->ID,
						    'post_type'  => 'product',
		            	 	'post_status' => 'publish',
						);
						
						$author_posts = get_posts( $args );
						
						// sort categories 
						$category = array();
						foreach ( $author_posts as $post ) {
							
							$terms = get_the_terms( $post->ID, 'product_cat' );
							if(is_array($terms) || is_object($terms)){
								foreach ($terms as $term){
									if (!empty($term->name)) {
										if (!in_array($term->name, $category)) {
											array_push($category,$term->name);
										}
									}
								}
							}
							
						}
						
		            	if (get_option('kas-show-ratting') == 1){
		            		$kas_rattings = dokan_get_seller_rating($user->data->ID);
		            		if ($kas_rattings['count']) {
		            			$kas_rating = ' '.$kas_rattings['rating'];
		            		}else {
		            			$kas_rating = '';
		            		}
		            	}else{
		            		$kas_rating = '';
		            	}	            		
	            		
	            		
	            		// create array of select values
	            		array_push($data, array(
			                'id' => $user->data->ID,
			            	'state' => $kas_store_info['address']['state'],
			            	'country' => $kas_store_info['address']['country'],
			                'city' => $kas_store_info['address']['city'],
			                'zip' => $kas_store_info['address']['zip'],
			                'rating' => $kas_rating,
	            			'category' => implode(',',$category),
			                'store_name' => $kas_store_info['store_name'].$kas_rating,
			            	'store_link' => $store_url
	            		));
	            	}

	            }
	            return $data;
	}


	/**
	 * Collect all countries and in unique format.
	 *
	 * @since    1.0.6
	 */
	public function kas_dokan_countries() {
		$countries = array();
		$data = $this->kas_dokan_data();
			
		foreach ($data as $detail){
			// sort country
			if (!in_array($detail['country'], $countries)) {
				array_push($countries,$detail['country']);
			}
		}
		return $countries;
	}

	/**
	 * Collect all states and in unique format.
	 *
	 * @since    1.0.6
	 */
	public function kas_dokan_states() {
		$states = array();
		$data = $this->kas_dokan_data();
			
		foreach ($data as $detail){
			// sort country
			if (!in_array($detail['state'], $states)) {
				array_push($states,$detail['state']);
			}
		}
		return $states;
	}


	/**
	 * Collect all cities and in unique format.
	 *
	 * @since    1.0.6
	 */
	public function kas_dokan_cities() {
		$cities = array();
		$data = $this->kas_dokan_data();
			
		foreach ($data as $detail){
			// sort country
			if (!in_array($detail['city'], $cities)) {
				array_push($cities,$detail['city']);
			}
		}
		return $cities;
	}


	/**
	 * Collect all zip and in unique format.
	 *
	 * @since    1.2.3
	 */
	public function kas_dokan_zips() {
		$zips = array();
		$data = $this->kas_dokan_data();
			
		foreach ($data as $detail){
			// sort country
			if (!in_array($detail['zip'], $zips)) {
				array_push($zips,$detail['zip']);
			}
		}
		return $zips;
	}


	/**
	 * Collect all ratting and in unique format.
	 *
	 * @since    1.2.6
	 */
	public function kas_dokan_ratings() {
		$ratings = array();
		$data = $this->kas_dokan_data();
			
		foreach ($data as $detail){
			// sort country
			if (!in_array($detail['rating'], $ratings)) {
				if (!empty($detail['rating'])) {
					array_push($ratings,$detail['rating']);
				}
			}
		}
		return $ratings;
	}


	/**
	 * Collect all category and in unique format.
	 *
	 * @since    1.2.4
	 */
	public function kas_dokan_category() {
		$categories = array();
		$data = $this->kas_dokan_data();
		
		foreach ($data as $detail){
			
			if (!empty($detail['category'])) {
				$catag = explode( ',',$detail['category']);
				array_unique($catag);
				foreach ($catag as $cat){
						
					// sort country
					if (!in_array($cat, $categories)) {
						array_push($categories,$cat);
					}						
						
				}
			}				
		}
		return $categories;
	}


	/**
	 * Collect all cities and in unique format.
	 *
	 * @since    1.0.6
	 */
	public function kas_dokan_stores() {
		$stores = array();
		$data = $this->kas_dokan_data();
		if (get_option('kas-show-ratting') == 1){	
			foreach ($data as $detail){
				array_push($stores,array($detail['store_link'],$detail['store_name']));
			}
		}else{
			foreach ($data as $detail){
				array_push($stores,array($detail['store_link'],$detail['store_name']));
			}		
		}
		return $stores;
	}
}