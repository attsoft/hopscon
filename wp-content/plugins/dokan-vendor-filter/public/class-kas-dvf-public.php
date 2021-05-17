<?php

/**
 * The public-facing functionality of Kas Dokan Vendor Filter.
 *
 * @link       http://ideas.echopointer.com
 * @since      1.0.0
 *
 * @package    Kas_Dvf
 * @subpackage Kas_Dvf/public
 */

/**
 * The public-facing functionality of Kas Dokan Vendor Filter.
 *
 * Defines the name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Kas_Dvf
 * @subpackage Kas_Dvf/public
 * @author     Syed Muhammad Shafiq <shafiq_shaheen@hotmail.com>
 */
class Kas_Dvf_Public {

	/**
	 * The Identifier Kas Dokan Vendor Filter.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $kas_filter    The Identifier.
	 */
	private $kas_filter;

	/**
	 * The version of Kas Dokan Vendor Filter.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of Kas Dokan Vendor Filter.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $kas_filter       The name of Kas Dokan Vendor Filter.
	 * @param      string    $version    The version of Kas Dokan Vendor Filter.
	 */
	public function __construct( $kas_filter, $version ) {

		$this->kas_filter = $kas_filter;
		$this->version = $version;
		$this->load_dependencies();

	}
	
	

	/**
	 * Load the required dependencies for this class.
	 *
	 * Include the following files :
	 * 
	 * - Kas_Dokan_Vendor_Filter_DokanData. Collect and get all required Dokan saller information.
	 *
	 *
	 * @since    1.0.6
	 * @access   private
	 */
	private function load_dependencies() {
		/**
		 * The class responsible for getting dokan data to menupulate fields
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/class-kas-dvf-dokandata.php';
		/**
		 * The class responsible for widget form
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/class-kas-dvf-widget.php';

	}	

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Kas_Dokan_Vendor_Filter as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Kas_Dokan_Vendor_Filter will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->kas_filter, plugin_dir_url( __FILE__ ) . 'css/kas-dvf-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->kas_filter, plugin_dir_url( __FILE__ ) . 'css/dokan.css', array(), $this->version, 'all' );
        wp_enqueue_script('jquery-ui-core');//enables UI

		if (get_option('kas-enable-select2') > 0){
			wp_enqueue_style( 'select2', plugin_dir_url( __FILE__ ) . 'assets/select2/css/select2.min.css', array(), $this->version, 'all' );
			wp_enqueue_style( 'select2-bootstrap', plugin_dir_url( __FILE__ ) . 'assets/select2/css/select2-bootstrap.css', array(), $this->version, 'all' );
			wp_enqueue_style( 'select2-custom', plugin_dir_url( __FILE__ ) . 'css/kas-dvf-select2-custom.css', array(), $this->version, 'all' );
		}else {
			//doSomething...
		}
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_script( $this->kas_filter, plugin_dir_url( __FILE__ ) . 'js/kas-dvf-public.js', array( 'jquery' ), $this->version, false );
		
		if (get_option('kas-enable-select2') > 0){
			wp_enqueue_script( 'select2', plugin_dir_url( __FILE__ ) . 'assets/select2/js/select2.min.js', array( 'jquery' ), $this->version, false );
		}
		
		if (get_option('kas-show-mapview') > 0){
			
			if( isset($_SERVER['HTTPS'] ) ) {
				wp_enqueue_script( 'google-map', 'https://maps.googleapis.com/maps/api/js?key='.dokan_get_option('gmap_api_key','dokan_general','store').'&libraries=geometry', array( 'jquery' ), $this->version, false );
			}else {
				wp_enqueue_script( 'google-map', 'http://maps.google.com/maps/api/js?key='.dokan_get_option('gmap_api_key','dokan_general','store').'&libraries=geometry', array( 'jquery' ), $this->version, false );
			}
		}
	}


	/**
	 * Render Dokan vendor filter html.
	 *
	 * @since    1.0.6
	 */
		public function kas_shortcode_temp($name = '', $args) {
			switch ($name) {
				case 'form':
					include_once( 'partials/kas_dokan_vendor_filter.php' );
					break;
				case 'form_aio':
					include_once( 'partials/kas_dokan_vendor_filter_aio.php' );
					break;
				case 'result':
					include_once( 'partials/kas_dokan_vendor_filter_results.php' );
					break;
				case 'map':
					include_once( 'partials/kas_dokan_vendor_filter_map.php' );
					break;
				default:
					include_once( 'partials/kas_dokan_vendor_filter.php' );
					break;
			}
		}
		

	/**
	 * Add ShortCode Functions for Dokan Vendor Filter Form.
	 *
	 * @since    1.0.0
	 */
	public function kas_shortcode_dvf() {
		
		$dokan_data = new Kas_Dvf_DokanData($this->kas_filter, $this->version);
		
		$kas_dokan_data = $dokan_data->kas_dokan_data();
		$kas_dokan_countries = $dokan_data->kas_dokan_countries();
		$kas_dokan_states = $dokan_data->kas_dokan_states();
		$kas_dokan_cities = $dokan_data->kas_dokan_cities();
		$kas_dokan_zips = $dokan_data->kas_dokan_zips();
		$kas_dokan_categories = $dokan_data->kas_dokan_category();
		$kas_dokan_ratings = $dokan_data->kas_dokan_ratings();
		$kas_dokan_stores = $dokan_data->kas_dokan_stores();
		
		$args = array(
			'data'	=> $kas_dokan_data,
            'countries' => $kas_dokan_countries,
            'states' => $kas_dokan_states,
            'cities' => $kas_dokan_cities,
			'zips'	=> $kas_dokan_zips,
			'categories'	=> $kas_dokan_categories,
			'ratings'	=> $kas_dokan_ratings,
            'stores' => $kas_dokan_stores,
		);
		
		$this->kas_shortcode_temp('form',$args);
	}
		

	/**
	 * Add ShortCode Functions for Dokan Vendor Filter all in one field.
	 *
	 * @since    1.2.0
	 */
	public function kas_shortcode_dvf_aio() {
		
		$dokan_data = new Kas_Dvf_DokanData($this->kas_filter, $this->version);
		
		$kas_dokan_address = $dokan_data->kas_dokan_data();
		
		$this->kas_shortcode_temp('form_aio',$kas_dokan_address);
	}	
	
	 /**
	 * Add ShortCode Functions for Dokan Vendor Filter Results page.
	 *
	 * @since    1.0.2
	 */
	public function kas_shortcode_dvf_results() {

		$dokan_data = new Kas_Dvf_DokanData($this->kas_filter, $this->version);
		
		$kas_dokan_data = $dokan_data->kas_dokan_data();		
		
			$kas_country = (isset($_GET['kas_country']) ? $_GET['kas_country'] : '');
			$kas_state = (isset($_GET['kas_state']) ? $_GET['kas_state'] : '');
			$kas_city = (isset($_GET['kas_city']) ? $_GET['kas_city'] : '');
			$kas_zip = (isset($_GET['kas_zip']) ? $_GET['kas_zip'] : '');
			$kas_category = (isset($_GET['kas_category']) ? $_GET['kas_category'] : '');
			$kas_rating = (isset($_GET['kas_rating']) ? $_GET['kas_rating'] : '');
			$query_type = (isset($_GET['query_type']) ? $_GET['query_type'] : '');
			
			$search_query = '';
			
			$kas_sorted = array();
			
			// if country, state, city, zip, category			
			if (!empty($kas_country) && !empty($kas_state) && !empty($kas_city) && !empty($kas_zip) && !empty($kas_category)){
				$sort_country = kas_search_in_array($kas_country, 'country', $kas_dokan_data);
				$sort_state = kas_search_in_array($kas_state, 'state', $sort_country);
				$sort_city = kas_search_in_array($kas_city, 'city', $sort_state);
				$sort_zip = kas_search_in_array($kas_zip, 'zip', $sort_city);
				$sort_category = kas_search_in_array($kas_category, 'category', $sort_zip);
				$kas_sorted = $sort_category;
				
				// Search Result heading...
				$search_query .= $kas_country . ' ' . $kas_state . ' ' . $kas_city . ' '. $kas_zip . ' '. $kas_category;
				
			}
			
			// if country, state, city, not zip and category			
			elseif (!empty($kas_country) && !empty($kas_state) && !empty($kas_city) && empty($kas_zip) && empty($kas_category)){
				$sort_country = kas_search_in_array($kas_country, 'country', $kas_dokan_data);
				$sort_state = kas_search_in_array($kas_state, 'state', $sort_country);
				$sort_city = kas_search_in_array($kas_city, 'city', $sort_state);
				$kas_sorted = $sort_city;
				
				// Search Result heading...
				$search_query .= $kas_country . ' ' . $kas_state . ' ' . $kas_city;
				
			}
			
			// if country, state, city, rating and not category			
			elseif (!empty($kas_country) && !empty($kas_state) && !empty($kas_city) && !empty($kas_zip) && !empty($kas_rating) && empty($kas_category)){
				$sort_country = kas_search_in_array($kas_country, 'country', $kas_dokan_data);
				$sort_state = kas_search_in_array($kas_state, 'state', $sort_country);
				$sort_city = kas_search_in_array($kas_city, 'city', $sort_state);
				$sort_rating = kas_search_in_array($kas_rating, 'rating', $sort_city);
				$kas_sorted = $sort_rating;
				
				// Search Result heading...
				$search_query .= $kas_country . ' ' . $kas_state . ' ' . $kas_city . ' ' . $kas_zip;
				
			}
			
			// if country, state, city, zip not category			
			elseif (!empty($kas_country) && !empty($kas_state) && !empty($kas_city) && !empty($kas_zip) && empty($kas_category)){
				$sort_country = kas_search_in_array($kas_country, 'country', $kas_dokan_data);
				$sort_state = kas_search_in_array($kas_state, 'state', $sort_country);
				$sort_city = kas_search_in_array($kas_city, 'city', $sort_state);
				$sort_zip = kas_search_in_array($kas_zip, 'zip', $sort_city);
				$kas_sorted = $sort_zip;
				
				// Search Result heading...
				$search_query .= $kas_country . ' ' . $kas_state . ' ' . $kas_city . ' '. $kas_zip;
				
			}
			// if state, city, zip, catagory not country
			elseif (!empty($kas_state) && !empty($kas_city) && !empty($kas_zip) && !empty($kas_category) && empty($kas_country)){
				
				$sort_state = kas_search_in_array($kas_country, 'country', $kas_dokan_data);
				$sort_city = kas_search_in_array($kas_city, 'city', $sort_state);
				$sort_zip = kas_search_in_array($kas_zip, 'zip', $sort_city);
				$sort_category = kas_search_in_array($kas_category, 'category', $sort_zip);
				$kas_sorted = $sort_category;
				
				// Search Result heading...
				$search_query .= $kas_state . ' ' . $kas_city . ' '. $kas_zip . ' '. $kas_category;				
			
			}
			// if city, zip, catagory not country and state
			elseif (!empty($kas_city) && !empty($kas_zip) && !empty($kas_category) && empty($kas_country) && empty($kas_state)){
				
				$sort_city = kas_search_in_array($kas_city, 'city', $kas_dokan_data);
				$sort_zip = kas_search_in_array($kas_zip, 'zip', $sort_city);
				$sort_category = kas_search_in_array($kas_category, 'category', $sort_zip);
				$kas_sorted = $sort_category;
				
				// Search Result heading...
				$search_query .= $kas_city . ' '. $kas_zip . ' '. $kas_category;				
			}
			// if zip and category not country, state and city
			elseif (!empty($kas_zip) && !empty($kas_category) && empty($kas_country) && empty($kas_state) && empty($kas_city)){
				
				$sort_zip = kas_search_in_array($kas_zip, 'zip', $kas_dokan_data);
				$sort_category = kas_search_in_array($kas_category, 'category', $sort_zip);
				$kas_sorted = $sort_category;
				
				// Search Result heading...
				$search_query .= $kas_zip . ' '. $kas_category;				
			}
			// if catagory not country, state,city and zip
			elseif (!empty($kas_category) && empty($kas_country) && empty($kas_state) && empty($kas_city) && empty($kas_zip)){
				
				$sort_category = kas_search_in_array($kas_category, 'category', $kas_dokan_data);
				$kas_sorted = $sort_category;
				
				// Search Result heading...
				$search_query .= $kas_category;				
			}
			// if country, city,zip and catagory not state
			elseif (!empty($kas_country) && !empty($kas_city) && !empty($kas_zip) && empty($kas_category) && empty($kas_state)){
				
				$sort_country = kas_search_in_array($kas_country, 'country', $kas_dokan_data);
				$sort_city = kas_search_in_array($kas_city, 'city', $sort_country);
				$sort_zip = kas_search_in_array($kas_zip, 'zip', $sort_city);
				$kas_sorted = $sort_zip;
				
				// Search Result heading...
				$search_query .= $kas_city . ' '. $kas_zip . ' '. $kas_category;				
			}
			// if country, zip and category not state and city
			elseif (!empty($kas_country) && !empty($kas_zip) && empty($kas_category) && empty($kas_state) && empty($kas_city)){
				
				$sort_country = kas_search_in_array($kas_country, 'country', $kas_dokan_data);
				$sort_zip = kas_search_in_array($kas_zip, 'zip', $sort_country);
				$kas_sorted = $sort_zip;
				
				// Search Result heading...
				$search_query .= $kas_country . ' '. $kas_zip;				
			}
			// if country, city and category not state and zip - 1.2.5 fixes
			elseif (!empty($kas_country) && !empty($kas_city) && !empty($kas_category) && empty($kas_state) && empty($kas_zip)){
				
				$sort_country = kas_search_in_array($kas_country, 'country', $kas_dokan_data);
				$sort_city = kas_search_in_array($kas_city, 'city', $sort_country);
				$sort_category = kas_search_in_array($kas_category, 'category', $sort_city);
				$kas_sorted = $sort_category;
				
				// Search Result heading...
				$search_query .= $kas_country . ' '. $kas_city.' '. $kas_category;				
			}
			// if country and category not state, city, and zip
			elseif (!empty($kas_country) && !empty($kas_category) && empty($kas_state) && empty($kas_city) && empty($kas_zip)){
				$sort_country = kas_search_in_array($kas_country, 'country', $kas_dokan_data);
				$sort_category = kas_search_in_array($kas_category, 'category', $sort_country);
				$kas_sorted = $sort_category;
				
				// Search Result heading...
				$search_query .= $kas_country . ' '. $kas_category;				
			}
			// if country not state, city, zip and category
			elseif (!empty($kas_country) && empty($kas_state) && empty($kas_city) && empty($kas_zip) && empty($kas_category)){
				$sort_country = kas_search_in_array($kas_country, 'country', $kas_dokan_data);
				$kas_sorted = $sort_country;
				
				// Search Result heading...
				$search_query .= $kas_country;				
			}
			// if state, zip, category not country and city
			elseif (!empty($kas_state) && !empty($kas_zip) && !empty($kas_category) && empty($kas_country) && empty($kas_city)){
				$sort_state = kas_search_in_array($kas_state, 'state', $kas_dokan_data);
				$sort_zip = kas_search_in_array($kas_zip, 'zip', $sort_state);
				$sort_category = kas_search_in_array($kas_category, 'category', $sort_zip);
				$kas_sorted = $sort_category;
				
				// Search Result heading...
				$search_query .= $kas_state. ' '. $kas_zip. ' '. $kas_category;				
			}
			// if state and category not country, city and zip
			elseif (!empty($kas_state) && !empty($kas_category) && empty($kas_country) && empty($kas_city) && empty($kas_zip)){
				$sort_state = kas_search_in_array($kas_state, 'state', $kas_dokan_data);
				$sort_category = kas_search_in_array($kas_category, 'category', $sort_state);
				$kas_sorted = $sort_category;
				
				// Search Result heading...
				$search_query .= $kas_state. ' '. $kas_category;			
			}
			// if state not country, city,zip and category
			elseif (!empty($kas_state) && empty($kas_country) && empty($kas_city) && empty($kas_zip) && empty($kas_category)){
				$sort_state = kas_search_in_array($kas_state, 'state', $kas_dokan_data);
				$kas_sorted = $sort_state;
				
				// Search Result heading...
				$search_query .= $kas_state;				
			}
			// if city and category not country, state and zip
			elseif (!empty($kas_city) && !empty($kas_category) && empty($kas_country) && empty($kas_state) && empty($kas_zip)){
				$sort_city = kas_search_in_array($kas_city, 'city', $kas_dokan_data);
				$sort_category = kas_search_in_array($kas_category, 'category', $sort_city);
				$kas_sorted = $sort_category;
				
				// Search Result heading...
				$search_query .= $kas_city. ' '. $kas_category;				
			}
			// if zip not country, state, city and category
			elseif (!empty($kas_zip) && empty($kas_country) && empty($kas_state) && empty($kas_city) && empty($kas_category)){
				$sort_zip = kas_search_in_array($kas_zip, 'zip', $kas_dokan_data);
				$kas_sorted = $sort_zip;
				
				// Search Result heading...
				$search_query .= $kas_zip;				
			}
			// if category not country, state, city and zip
			elseif (!empty($kas_category) && empty($kas_country) && empty($kas_state) && empty($kas_city) && empty($kas_zip)){
				
				$sort_category = kas_search_in_array($kas_category, 'category', $kas_dokan_data);
				$kas_sorted = $sort_category;
				
				// Search Result heading...
				$search_query .= $kas_category;				
			}
			// if country and state not city, zip and category
			elseif (!empty($kas_country) && !empty($kas_state) && empty($kas_city) && empty($kas_zip) && empty($kas_category)){
				$sort_country = kas_search_in_array($kas_country, 'country', $kas_dokan_data);
				$sort_state = kas_search_in_array($kas_state, 'state', $sort_country);
				$kas_sorted = $sort_state;
				
				// Search Result heading...
				$search_query .= $kas_country. ' '. $kas_state;				
			}
			// if state and city not country, zip and category
			elseif (!empty($kas_state) && !empty($kas_city) && empty($kas_country) && empty($kas_zip) && empty($kas_category)){
				$sort_state = kas_search_in_array($kas_state, 'state', $kas_dokan_data);
				$sort_city = kas_search_in_array($kas_city, 'city', $sort_state);
				$kas_sorted = $sort_city;
				
				// Search Result heading...
				$search_query .= $kas_state. ' '. $kas_city;				
			}
			// if city and zip not country, state and category
			elseif (!empty($kas_city) && !empty($kas_zip) && empty($kas_country) && empty($kas_state) && empty($kas_category)){
				$sort_city = kas_search_in_array($kas_city, 'city', $kas_dokan_data);
				$sort_zip = kas_search_in_array($kas_zip, 'zip', $sort_city);
				$kas_sorted = $sort_zip;
				
				// Search Result heading...
				$search_query .= $kas_city. ' '. $kas_zip;				
			}
			
			// if noting is set....
			else{
				$kas_sorted = $kas_dokan_data;
			}	
			add_image_size( 'kas_vendor_image', 300, 144 );
			$sellers = array();
			foreach ($kas_sorted as $vendor){
				$seller = get_user_by( 'id', $vendor['id'] );
				array_push($sellers,$seller);
			}
			$temp_args = array(
				'id'	=> $kas_sorted,
				'users' => $sellers,
				'count'	=> count($sellers),
			);
			
			// set heading for result page ....
	        if ( ! empty( $search_query ) ) {
            	printf( '<h2 class="store_found">' . __( 'Search Results for: %s', $this->kas_filter ) . '</h2>', $search_query );
        	}else{
        		
        		if (!empty($query_type) && $query_type == 'vendors') {
        			printf( '<h2 style="text-align: center;">' . __( 'Result Stores', $this->kas_filter ) . '</h2>' );
        		}elseif (!empty($query_type) && $query_type == 'products'){
        			//printf( '<h2 style="text-align: center;">' . __( 'Result Products', $this->kas_filter ) . '</h2>' );
        		}else {
        			printf( '<h2 style="text-align: center;">' . __( 'Result Stores', $this->kas_filter ) . '</h2>' );
        		}
        	}		
			
			// set template to render results...
			if (get_option('kas-show-mapview') == 1) {
				$this->kas_shortcode_temp('map',$temp_args);
			}elseif (get_option('kas-show-mapview') == 2) {
				$this->kas_shortcode_temp('map',$temp_args);
				$this->kas_shortcode_temp('result',$temp_args);
			}else {
				$this->kas_shortcode_temp('result',$temp_args);
			}	
	}	
		

	/**
	 * Add Filter widgets.
	 *
	 * @since    1.2.4
	 */
	public function kas_dvf_widget() {
		
		$dokan_widget = new Kas_Dvf_Widget($this->kas_filter, $this->version);
		
		register_widget( $dokan_widget );
		
	}	
		

	/**
	 * Add Filter product.
	 *
	 * @since    1.2.6
	 */
	public function kas_vendor_filter_products() {
		// doSomething..
		
	}		
	
	
}
