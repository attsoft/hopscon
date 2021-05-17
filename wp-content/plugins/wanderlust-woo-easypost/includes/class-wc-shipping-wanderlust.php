<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
require_once('lib/easypost.php');
/**
 * WC_Shipping_wanderlust class.
 *
 * @extends WC_Shipping_Method
 */
class WC_Shipping_wanderlust extends WC_Shipping_Method {
	private $default_boxes;
	private $found_rates;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->id = 'easypostshippingtool';
		$this->method_title = __( 'Wanderlust Shipping Tool', 'wc_wanderlust' );
		$this->method_description = __( 'The <strong>Wanderlust Shipping Tool</strong> extension obtains rates dynamically from the Easypost API during cart/checkout.', 'wc_wanderlust' );
		$this->default_boxes = include( 'data/data-box-sizes.php' );
		$this->init();
	}

    /**
     * init function.
     */
    private function init() {
    	global $woocommerce;
		// Load the settings.
		$this->init_form_fields();
		$this->init_settings();

		// Define user set variables
		$this->title           = $this->get_option( 'title', $this->method_title );
		$this->availability    = $this->get_option( 'availability', 'all' );
		$this->countries       = $this->get_option( 'countries', array() );
		$this->origin          = $this->get_option( 'zip' );
		$this->filter_rates    = explode(",", $this->get_option( 'filter_rates' ));
		$this->order_rates = $this->get_option( 'order_rates' );
		$this->show_fedex_rates = $this->get_option( 'show_fedex_rates' );
		$this->show_usps_rates = $this->get_option( 'show_usps_rates' );
		$this->show_ups_rates = $this->get_option( 'show_ups_rates' );
		$this->show_dhl_rates = $this->get_option( 'show_dhl_rates' );
		$this->show_canada_rates = $this->get_option( 'show_canada_rates' );
		$this->extrachargefedex     = $this->get_option( 'extrachargefedex' );
		$this->extrachargeusps     = $this->get_option( 'extrachargeusps' );
		$this->extrachargeups     = $this->get_option( 'extrachargeups' );
		$this->extrachargecanada     = $this->get_option( 'extrachargecanada' );	
		$this->extrachargedhl     = $this->get_option( 'extrachargedhl' );		
		$this->debug           = ( $bool = $this->get_option( 'debug' ) ) && $bool == 'yes' ? true : false;
		$this->insure_contents = ( $bool = $this->get_option( 'insure_contents' ) ) && $bool == 'yes' ? true : false;
		$this->packing_method  = $this->get_option( 'packing_method', 'per_item' );
		$this->boxes           = $this->get_option( 'boxes', array( ));
		$this->residential     = ( $bool = $this->get_option( 'residential' ) ) && $bool == 'yes' ? true : false;
		$this->shipment_signature = $this->get_option( 'shipment_signature' );
		add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
		//add_action('woocommerce_checkout_order_processed', array(&$this, 'purchase_order' ));
	}

    /**
     * Output a message
     */
    public function debug( $message, $type = 'notice' ) {
    	if ( $this->debug ) {
    		if ( version_compare( WOOCOMMERCE_VERSION, '2.1', '>=' ) ) {
    			wc_add_notice( $message, $type );
    		} else {
    			global $woocommerce;

    			$woocommerce->add_message( $message );
    		}
		}
    }

	/**
	 * environment_check function.
	 */
	private function environment_check() {
		global $woocommerce;

            $weight_unit = get_option('woocommerce_weight_unit');     
            $dimension_unit = get_option('woocommerce_dimension_unit' );
		if ( ! in_array( get_woocommerce_currency(), array( 'USD', 'CAD' ) ) || ! in_array( $woocommerce->countries->get_base_country(), array( 'US', 'CA' ) ) ) {
	 
		} elseif ( ! $this->origin && $this->enabled == 'yes' ) {
			echo '<div class="error">
				<p>' . __( 'wanderlust is enabled, but the origin postcode has not been set.', 'wc_wanderlust' ) . '</p>
			</div>';
		}
	}

	/**
	 * admin_options function.
	 */
	public function admin_options() {
		// Check users environment supports this method
		$this->environment_check();

		// Show settings
		parent::admin_options();
	}

    /**
     * init_form_fields function.
     */
    public function init_form_fields() {
	    $this->form_fields  = include( 'data/data-settings.php' );
    }

	/**
	 * generate_box_packing_html function.
	 */
	public function generate_box_packing_html() {
		ob_start();
		include( 'views/html-box-packing.php' );
		return ob_get_clean();
	}

	/**
	 * validate_box_packing_field function.
	 *
	 * @param mixed $key
	 */
	public function validate_box_packing_field( $key ) {
 		$boxes_name     = isset( $_POST['boxes_name'] ) ? $_POST['boxes_name'] : array();
		$boxes_length     = isset( $_POST['boxes_length'] ) ? $_POST['boxes_length'] : array();
		$boxes_width      = isset( $_POST['boxes_width'] ) ? $_POST['boxes_width'] : array();
		$boxes_height     = isset( $_POST['boxes_height'] ) ? $_POST['boxes_height'] : array();
		$boxes_box_weight = isset( $_POST['boxes_box_weight'] ) ? $_POST['boxes_box_weight'] : array();
		$boxes_max_weight = isset( $_POST['boxes_max_weight'] ) ? $_POST['boxes_max_weight'] :  array();
		$boxes_enabled    = isset( $_POST['boxes_enabled'] ) ? $_POST['boxes_enabled'] : array();

		$boxes = array();

		if ( ! empty( $boxes_length ) && sizeof( $boxes_length ) > 0 ) {
			for ( $i = 0; $i <= max( array_keys( $boxes_length ) ); $i ++ ) {

				if ( ! isset( $boxes_length[ $i ] ) )
					continue;

				if ( $boxes_length[ $i ] && $boxes_width[ $i ] && $boxes_height[ $i ] ) {
 					$boxes[] = array(
 						'name'     =>  $boxes_name[ $i ] ,
						'length'     => floatval( $boxes_length[ $i ] ),
						'width'      => floatval( $boxes_width[ $i ] ),
						'height'     => floatval( $boxes_height[ $i ] ),
						'box_weight' => floatval( $boxes_box_weight[ $i ] ),
						'max_weight' => floatval( $boxes_max_weight[ $i ] ),
						'enabled'    => isset( $boxes_enabled[ $i ] ) ? true : false
					);
				}
			}
			foreach ( $this->default_boxes as $box ) {
				$boxes[ $box['id'] ] = array(
					'enabled' => isset( $boxes_enabled[ $box['id'] ] ) ? true : false
				);
			}
		}
		return $boxes;
	}

	 

    /**
     * Get packages - divide the WC package into packages/parcels suitable for a wanderlust quote
     */
    public function get_wanderlust_packages( $package ) {
    	switch ( $this->packing_method ) {
	    	case 'box_packing' :
	    		return $this->box_shipping( $package );
	    	break;
	    	case 'per_item' :
	    	default :
	    		return $this->per_item_shipping( $package );
	    	break;
    	}
    }


    /**
     * per_item_shipping function.
     *
     * @access private
     * @param mixed $package
     * @return array
     */
    private function per_item_shipping( $package ) {
    	global $woocommerce;

 		$weight_unit = get_option('woocommerce_weight_unit');     
 		$dimension_unit = get_option('woocommerce_dimension_unit' );
	    $to_ship  = array();
	    $group_id = 1;


    	// Get weight of order
    	foreach ( $package['contents'] as $item_id => $values ) {

    		if ( ! $values['data']->needs_shipping() ) {
    			$this->debug( sprintf( __( 'Product # is virtual. Skipping.', 'wc_wanderlust' ), $item_id ), 'error' );
    			continue;
    		}

    		if ( ! $values['data']->get_weight() ) {
	    		$this->debug( sprintf( __( 'Product # is missing weight. Aborting.', 'wc_wanderlust' ), $item_id ), 'error' );
	    		return;
    		}

    		$group = array();
 
    		$group = array(
				'GroupNumber'       => $group_id,
				'GroupPackageCount' => $values['quantity'],
				'Weight' => array(
					'Value' => max( '0.5', round( woocommerce_get_weight( $values['data']->get_weight(), $weight_unit ), 2 ) ),
					'Units' => $weight_unit
		    	),
		    	'packed_products' => array( $values['data'] )
    		);

			if ( $values['data']->length && $values['data']->height && $values['data']->width ) {

				$dimensions = array( $values['data']->length, $values['data']->width, $values['data']->height );

				sort( $dimensions );
 				$dimension_unit = esc_attr( get_option('woocommerce_dimension_unit' ));

				$group['Dimensions'] = array(
					'Length' => max( 1, round( woocommerce_get_dimension( $dimensions[2], $dimension_unit ), 2 ) ),
					'Width'  => max( 1, round( woocommerce_get_dimension( $dimensions[1], $dimension_unit ), 2 ) ),
					'Height' => max( 1, round( woocommerce_get_dimension( $dimensions[0], $dimension_unit ), 2 ) ),
					'Units'  => $dimension_unit
				);
			}

			$group['InsuredValue'] = array( 
				'Amount'   => round( $values['data']->get_price() * $values['quantity'] ), 
				'Currency' => get_woocommerce_currency() 
			);

			$to_ship[] = $group;

			$group_id++;
    	}
 		return $to_ship;
    }

    /**
     * box_shipping function.
     *
     * @access private
     * @param mixed $package
     * @return array
     */
    private function box_shipping( $package ) {
    	global $woocommerce;

 		$weight_unit = get_option('woocommerce_weight_unit');     
 		$dimension_unit = get_option('woocommerce_dimension_unit' );
	  	if ( ! class_exists( 'WC_Boxpack' ) )
	  		include_once 'box-packer/class-wc-boxpack.php';

	    $boxpack = new WC_Boxpack();

	    // Merge default boxes
	    foreach ( $this->default_boxes as $key => $box ) {
	    	$box['enabled'] = isset( $this->boxes[ $box['id'] ]['enabled'] ) ? $this->boxes[ $box['id'] ]['enabled'] : true;
		 	$this->boxes[] = $box;
	    }

	    // Define boxes
		foreach ( $this->boxes as $key => $box ) {
			if ( ! is_numeric( $key ) )
				continue;

			if ( ! $box['enabled'] )
				continue;

			$newbox = $boxpack->add_box( $box['length'], $box['width'], $box['height'], $box['box_weight'] );

			if ( isset( $box['id'] ) )
				$newbox->set_id( $box['id'] );

			if ( $box['max_weight'] )
				$newbox->set_max_weight( $box['max_weight'] );
		}

		// Add items
		foreach ( $package['contents'] as $item_id => $values ) {

			if ( ! $values['data']->needs_shipping() ) {
    			$this->debug( sprintf( __( 'Product # is virtual. Skipping.', 'wc_wanderlust' ), $item_id ), 'error' );
    			continue;
    		}

			if ( $values['data']->length && $values['data']->height && $values['data']->width && $values['data']->weight ) {

				$dimensions = array( $values['data']->length, $values['data']->height, $values['data']->width );
 				$dimension_unit = esc_attr( get_option('woocommerce_dimension_unit' ));

				for ( $i = 0; $i < $values['quantity']; $i ++ ) {
					$boxpack->add_item(
						woocommerce_get_dimension( $dimensions[2], $dimension_unit ),
						woocommerce_get_dimension( $dimensions[1], $dimension_unit ),
						woocommerce_get_dimension( $dimensions[0], $dimension_unit ),
						woocommerce_get_weight( $values['data']->get_weight(), $weight_unit ),
						$values['data']->get_price(),
						array(
							'data' => $values['data']
						)
					);
				}

			} else {
				$this->debug( sprintf( __( 'Product # is missing dimensions. Aborting.', 'wc_wanderlust' ), $item_id ), 'error' );
				return;
			}
		}

		// Pack it
		$boxpack->pack();

		// Get packages
		$packages = $boxpack->get_packages();
		$to_ship  = array();
		$group_id = 1;

		foreach ( $packages as $package ) {

			$dimensions = array( $package->length, $package->width, $package->height );

			sort( $dimensions );

    		$group = array(
				'GroupNumber'       => $group_id,
				'GroupPackageCount' => 1,
				'Weight' => array(
					'Value' => max( '0.5', round( $package->weight, 2 ) ),
					'Units' => $weight_unit
		    	),
		    	'Dimensions'        => array(
					'Length' => max( 1, round( $dimensions[2], 2 ) ),
					'Width'  => max( 1, round( $dimensions[1], 2 ) ),
					'Height' => max( 1, round( $dimensions[0], 2 ) ),
					'Units'  => $dimension_unit
				),
				'InsuredValue'      => array( 
					'Amount'   => round( $package->value ), 
					'Currency' => get_woocommerce_currency() 
				),
				'packed_products' => array()
    		);
 			//print_r($group);

    		foreach ( $package->packed as $packed ) {
    			$group['packed_products'][] = $packed->get_meta( 'data' );
    		}

    		$to_ship[] = $group;

    		$group_id++;
		}
		if($this->debug == 'yes') {	echo '<pre style="height:200px;">' . print_r( $to_ship, true ) . '</pre>'; }

		return $to_ship;
    }

    

 
    /**
     * get_wanderlust_requests function.
     *
     * @access private
     * @return void
     */
    private function get_wanderlust_requests( $wanderlust_packages, $package ) {
	   	global $woocommerce, $wpdb;
			session_start();
			foreach($woocommerce->cart->get_cart() as $cart_item ){
				$product_id = $cart_item['product_id'];
			}
			$author_id = get_post_field ('post_author', $product_id);
			$vendor_data = get_user_meta($author_id, 'dokan_profile_settings', true);
			
			//$vendor_data[address][street_1]
			
 			$weight_unit = get_option('woocommerce_weight_unit');     
 			$dimension_unit = get_option('woocommerce_dimension_unit' );
 			$woocommerce_easypost_test = get_option( 'pvit_easypostwanderlust_shipper_test' );
			$woocommerce_easypost_test_api_key = get_option( 'pvit_easypostwanderlust_testkey' );
			$woocommerce_easypost_live_api_key = get_option( 'pvit_easypostwanderlust_livekey' );
			$woocommerce_easypost_customs_info_description = get_option( 'pvit_easypostwanderlust_customsdescription' );
			$woocommerce_easypost_customs_info_hs_tariff_number = get_option( 'pvit_easypostwanderlust_customshs' );
			$woocommerce_easypost_customs_info_contents_type = get_option( 'pvit_easypostwanderlust_customstype' );
			
			if($vendor_data[address][street_2]){
				$address = $vendor_data[address][street_1].','.$vendor_data[address][street_2];
				}else{
					$address = $vendor_data[address][street_1];
					}
			if($vendor_data){
				
				$woocommerce_easypost_company = $vendor_data[store_name]; 
				$woocommerce_easypost_street1 = $address;
				$woocommerce_easypost_city = $vendor_data[address][city];
				$woocommerce_easypost_state = $vendor_data[address][state];
				$woocommerce_easypost_zip = $vendor_data[address][zip];
				$woocommerce_easypost_phone = $vendor_data[phone];
				$woocommerce_easypost_country = $vendor_data[address][country];
			
			}else{
			
				$woocommerce_easypost_company = get_option( 'pvit_easypostwanderlust_sender_company' ); 
				$woocommerce_easypost_street1 = get_option( 'pvit_easypostwanderlust_sender_address1' );
				$woocommerce_easypost_city = get_option( 'pvit_easypostwanderlust_shipper_city' );
				$woocommerce_easypost_state = get_option( 'pvit_easypostwanderlust_sender_state' );
				$woocommerce_easypost_zip = get_option( 'pvit_easypostwanderlust_shipper_zipcode' );
				$woocommerce_easypost_phone = get_option( 'pvit_easypostwanderlust_shipper_phone' );
				$woocommerce_easypost_country = get_option( 'pvit_easypostwanderlust_shipper_country' );
			}
			$woocommerce_easypost_insurance = get_option( 'pvit_easypostwanderlust_autoinsurance_cost' );		
			$woocommerce_currency = get_woocommerce_currency();
 
 		if ($woocommerce_easypost_test =='1') { \EasyPost\EasyPost::setApiKey($woocommerce_easypost_test_api_key);} else {\EasyPost\EasyPost::setApiKey($woocommerce_easypost_live_api_key);} 
 
	    $customer = $woocommerce->customer;
 					
	    try {
			if (empty($customer->shipping_country)){
					$to_address =  \EasyPost\Address::create(array(
						  "street1" => $customer->get_address(),
						  "street2" => $customer->get_address_2(),
						  "city"    => $customer->get_city(),
						  "state"   => $customer->get_state(),
						  "zip"     => $customer->get_postcode(),
						  "country"  => $customer->get_country(),				
						)
					  );		
			} else {
					$to_address =  \EasyPost\Address::create(array(
						  "street1" => $customer->get_shipping_address(),
						  "street2" => $customer->get_shipping_address_2(),
						  "city"    => $customer->get_shipping_city(),
						  "state"   => $customer->get_shipping_state(),
						  "zip"     => $customer->get_shipping_postcode(),
						  "country"  => $customer->get_shipping_country(),				
						)
					  );		
			}	
		if(!empty($to_address->zip)){	
			if(!empty($to_address->street1)){
				if($to_address->country == 'US') { 
					//$to_address = $to_address->verify(); 
				}
 			}
			
			
		if($vendor_data){
				
				$from_address = \EasyPost\Address::create(
					array(
					  "company" =>  $vendor_data[store_name],
					  "street1" => $vendor_data[address][street_1],
					  "street2" => $vendor_data[address][street_2],
					  "city"    => $vendor_data[address][city],
					  "state"   => $vendor_data[address][state],
					  "zip"     => $vendor_data[address][zip],
					  "country" => $woocommerce_easypost_country,
					  "phone"   => $vendor_data[phone]
					)
				  );
				
			}else{
			
				$from_address = \EasyPost\Address::create(
					array(
					  "company" => $this->get_option( 'company' ),
					  "street1" => $this->get_option( 'street1' ),
					  "street2" => $this->get_option( 'street2' ),
					  "city"    => $this->get_option( 'city' ),
					  "state"   => $this->get_option( 'state' ),
					  "zip"     => $this->get_option( 'zip' ),
					  "country" => $woocommerce_easypost_country,
					  "phone"   => $this->get_option( 'phone' )
					)
				  );
			}	
			
	    
		$weight_unitsa = $wanderlust_packages[0]['Weight']['Units'];		
 		$sum = 0;
		if ($weight_unitsa=='lbs') { $sum = 16;}
		if ($weight_unitsa=='oz') { $sum = 1;}
		if ($weight_unitsa=='g') { $sum =  0.035274;}
		if ($weight_unitsa=='kg') { $sum = 35.274;}
			
		$dimension_unit = esc_attr( get_option('woocommerce_dimension_unit' ));
 		$dimensionmul = 0;
		if ($dimension_unit == 'in') { $dimensionmul = 1;}
 		if ($dimension_unit == 'm') { $dimensionmul =  39.3701;}
 		if ($dimension_unit == 'cm') { $dimensionmul =  0.393701;}
 		if ($dimension_unit == 'mm') { $dimensionmul =  0.0393701;}
 		if ($dimension_unit == 'yd') { $dimensionmul =  36;}
			
		$residential = $this->residential; if($residential == 1){$residential_to_address = 'true';} else {$residential_to_address = 'false';}
		$shipment_signature = $this->shipment_signature;
			
		$ordervalue = $woocommerce->cart;
 		$cart_weight = $woocommerce->cart->cart_contents_weight;
		$str =  preg_replace( '#[^\d.]#', '', $woocommerce->cart->get_cart_total()  );
		$amount = substr($str, 2);
		if($woocommerce_easypost_insurance == '1'){
			$insurancecost = $amount * 0.01;
		}	
		
		$customs_item = array();
		foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $values ) {
 			$_product = $values['data'];
			$productid = $values['product_id']; 
 			$variation = $values['variation_id'];
 			$productidweight  = get_post_meta($productid, '_weight' ); 	
 			$hs_number  = get_post_meta($productid, '_hs_number', true ); 	
 			if(empty($hs_number)){$hs_number = $woocommerce_easypost_customs_info_hs_tariff_number;}

			$pweight = $productidweight[0] * $values['quantity'];
			$product_weight = $pweight;
			if ( ! empty( $variation) ) { 	
 				$productidweight2  = get_post_meta($productid, '_weight' ); 
 				$pweightb = $productidweight2[0] * $values['quantity'];			
				if(!empty( $pweightb)) { $product_weight = $pweightb; }
			}
			
			$customs_item[] = 
 			\EasyPost\CustomsItem::create( 
				array(
 					"description" => $woocommerce_easypost_customs_info_description,
 					"quantity" => $values['quantity'],  
 					"weight" => $product_weight * $sum,
 					"value" => $values['line_total'],
 					"hs_tariff_number" => $hs_number,
 					"origin_country" => $woocommerce_easypost_country, 				
				)
			);
					 
 			}
						
		
 			
		$customs_info = \EasyPost\CustomsInfo::create(array(
		  "eel_pfc" => 'NOEEI 30.37(a)',
		  "customs_certify" => false,
		  "contents_type" => $woocommerce_easypost_customs_info_contents_type,
		  "contents_explanation" => '',
		  "restriction_type" => 'none',
		  "non_delivery_option" => 'return',
		  "customs_items" =>  $customs_item,
		));				
			
		$boxes = array();	
		foreach($wanderlust_packages as $singlebox){
		$quantity = $singlebox['GroupPackageCount'];
		$lenght = $singlebox['Dimensions']['Length'] * $dimensionmul * $quantity;
		$width = $singlebox['Dimensions']['Width'] * $dimensionmul * $quantity;
		$height = $singlebox['Dimensions']['Height'] * $dimensionmul * $quantity;
		$weight = $singlebox['Weight']['Value'] * $sum * $quantity;
			$boxes[] = 
				array(
					"parcel" => array("length" => $lenght, "width" => $width, "height" => $height, "weight" => $weight),
					"options" => array(
						'delivery_confirmation' => $shipment_signature, 
						'residential_to_address' => $residential_to_address,
						'currency' => $woocommerce_currency
					),
 					"customs_info" => $customs_info,

				);				
			
		}	
		
			
 		$order = \EasyPost\Order::create(array(
 			"from_address" => $from_address,
 			"to_address" => $to_address,
 			"shipments" => $boxes,
			"customs_info" => $customs_info,
 		));
				

 		$_SESSION['multilabel'] = $order->id; //save easypost orderid	
						
 		if($this->debug == 'yes') {	echo '<pre style="height:200px;">' . print_r( $boxes, true ) . '</pre>'; }
	
		$woocommerce_easypost_custom_names_ups = get_option( 'pvit_easypostwanderlust_ups_service' );
 		$woocommerce_easypost_custom_names_usps = get_option( 'pvit_easypostwanderlust_usps_service' );
 		$woocommerce_easypost_custom_names_fedex = get_option( 'pvit_easypostwanderlust_fedex_service' );
 		$woocommerce_easypost_custom_names_dhl = get_option( 'pvit_easypostwanderlust_dhl_service' );			
						
 			$newrates = array();
			foreach($order['rates'] as $r)  {
				
				$newrates[] = array(
					 'rate' => $r->rate, 
					 'carrier' => $r->carrier, 
					 'service' => $r->service,
					);
					
  			}
 		if($this->order_rates == 'yes') { array_multisort($newrates, SORT_ASC, $order['rates']);  } 	
			
	      foreach($newrates as $r) {
					if ($r['carrier'] == 'FedEx'){	
						if($this->show_fedex_rates == 'yes') {
							$fedexservice = $r['service'];
								if($woocommerce_easypost_custom_names_fedex =='1'){	
									$easypostwanderlust_fedex_service_ground = get_option( 'pvit_easypostwanderlust_fedex_service_ground' );			
									$easypostwanderlust_fedex_service_twoday = get_option( 'pvit_easypostwanderlust_fedex_service_twoday' );			
									$easypostwanderlust_fedex_service_twodayam = get_option( 'pvit_easypostwanderlust_fedex_service_twodayam' );			
									$easypostwanderlust_fedex_service_express = get_option( 'pvit_easypostwanderlust_fedex_service_express' );			
									$easypostwanderlust_fedex_service_standard = get_option( 'pvit_easypostwanderlust_fedex_service_standard' );			
									$easypostwanderlust_fedex_service_first = get_option( 'pvit_easypostwanderlust_fedex_service_first' );			
									$easypostwanderlust_fedex_service_priority = get_option( 'pvit_easypostwanderlust_fedex_service_priority' );			
									$easypostwanderlust_fedex_service_inteconomy = get_option( 'pvit_easypostwanderlust_fedex_service_inteconomy' );			
									$easypostwanderlust_fedex_service_intfirst = get_option( 'pvit_easypostwanderlust_fedex_service_intfirst' );			
									$easypostwanderlust_fedex_service_intpriority = get_option( 'pvit_easypostwanderlust_fedex_service_intpriority' );			
									$easypostwanderlust_fedex_service_groundhome = get_option( 'pvit_easypostwanderlust_fedex_service_groundhome' );			

									if($fedexservice =='FEDEX_GROUND'){	if(!empty($easypostwanderlust_fedex_service_ground)){$fedexservice = $easypostwanderlust_fedex_service_ground;}	}	
									if($fedexservice =='FEDEX_2_DAY'){if(!empty($easypostwanderlust_fedex_service_twoday)){$fedexservice = $easypostwanderlust_fedex_service_twoday;}	}
									if($fedexservice =='FEDEX_2_DAY_AM'){if(!empty($easypostwanderlust_fedex_service_twodayam)){$fedexservice = $easypostwanderlust_fedex_service_twodayam;}	}
									if($fedexservice =='FEDEX_EXPRESS_SAVER'){if(!empty($easypostwanderlust_fedex_service_express)){$fedexservice = $easypostwanderlust_fedex_service_express;}	}
									if($fedexservice =='STANDARD_OVERNIGHT'){if(!empty($easypostwanderlust_fedex_service_standard)){$fedexservice = $easypostwanderlust_fedex_service_standard;}	}
									if($fedexservice =='FIRST_OVERNIGHT'){if(!empty($easypostwanderlust_fedex_service_first)){$fedexservice = $easypostwanderlust_fedex_service_first;}	}
									if($fedexservice =='PRIORITY_OVERNIGHT'){if(!empty($easypostwanderlust_fedex_service_priority)){$fedexservice = $easypostwanderlust_fedex_service_priority;}	}
									if($fedexservice =='INTERNATIONAL_ECONOMY'){if(!empty($easypostwanderlust_fedex_service_inteconomy)){$fedexservice = $easypostwanderlust_fedex_service_inteconomy;}	}
									if($fedexservice =='INTERNATIONAL_FIRST'){if(!empty($easypostwanderlust_fedex_service_intfirst)){$fedexservice = $easypostwanderlust_fedex_service_intfirst;}	}
									if($fedexservice =='INTERNATIONAL_PRIORITY'){if(!empty($easypostwanderlust_fedex_service_intpriority)){$fedexservice = $easypostwanderlust_fedex_service_intpriority;}	}
									if($fedexservice =='GROUND_HOME_DELIVERY'){if(!empty($easypostwanderlust_fedex_service_groundhome)){$fedexservice = $easypostwanderlust_fedex_service_groundhome;}	}

								} else {
									$fedexservice = $r['service'];
								}
								$percc = $this->extrachargefedex;$rate = $r['rate'];
								if (strpos($percc,'%') !== false) {$perc = str_replace("%","",$percc);$perc = $perc / 100;$ratesper = $rate * $perc; $cost = $rate + $ratesper;} else { $cost = $r['rate'] + $this->extrachargefedex;}
							$rate = array(
											'id' => sprintf("%s-%s", $r['carrier'], $r['service']),
											'label' => sprintf("%s %s", $r['carrier'] , $fedexservice),
											'cost' => $cost + $insurancecost,
											'calc_tax' => 'per_order'
									);		
						}	
					} else if($r['carrier'] == 'USPS'){
						if($this->show_usps_rates == 'yes') {
							$uspsservice = $r['service'];
								if($woocommerce_easypost_custom_names_usps =='1'){	
									$easypostwanderlust_usps_service_first = get_option( 'pvit_easypostwanderlust_usps_service_first' );			
									$easypostwanderlust_usps_service_priority = get_option( 'pvit_easypostwanderlust_usps_service_priority' );			
									$easypostwanderlust_usps_service_express = get_option( 'pvit_easypostwanderlust_usps_service_express' );			
									$easypostwanderlust_usps_service_parcel = get_option( 'pvit_easypostwanderlust_usps_service_parcel' );			
									$easypostwanderlust_usps_service_critical = get_option( 'pvit_easypostwanderlust_usps_service_critical' );			
									$easypostwanderlust_usps_service_first_international = get_option( 'pvit_easypostwanderlust_usps_service_first_international' );			
									$easypostwanderlust_usps_service_first_pkg_international = get_option( 'pvit_easypostwanderlust_usps_service_first_pkg_international' );			
									$easypostwanderlust_usps_service_priority_international = get_option( 'pvit_easypostwanderlust_usps_service_priority_international' );			
									$easypostwanderlust_usps_service_expres_international = get_option( 'pvit_easypostwanderlust_usps_service_expres_international' );			

									if($uspsservice =='First'){	if(!empty($easypostwanderlust_usps_service_first)){$uspsservice = $easypostwanderlust_usps_service_first;}	}	
									if($uspsservice =='Priority'){if(!empty($easypostwanderlust_usps_service_priority)){$uspsservice = $easypostwanderlust_usps_service_priority;}	}
									if($uspsservice =='Express'){if(!empty($easypostwanderlust_usps_service_express)){$uspsservice = $easypostwanderlust_usps_service_express;}	}
									if($uspsservice =='ParcelSelect'){if(!empty($easypostwanderlust_usps_service_parcel)){$uspsservice = $easypostwanderlust_usps_service_parcel;}	}
									if($uspsservice =='CriticalMail'){if(!empty($easypostwanderlust_usps_service_critical)){$uspsservice = $easypostwanderlust_usps_service_critical;}	}
									if($uspsservice =='FirstClassMailInternational'){if(!empty($easypostwanderlust_usps_service_first_international)){$uspsservice = $easypostwanderlust_usps_service_first_international;}	}
									if($uspsservice =='FirstClassPackageInternational'){if(!empty($easypostwanderlust_usps_service_first_pkg_international)){$uspsservice = $easypostwanderlust_usps_service_first_pkg_international;}	}
									if($uspsservice =='PriorityMailInternational'){if(!empty($easypostwanderlust_usps_service_priority_international)){$uspsservice = $easypostwanderlust_usps_service_priority_international;}	}
									if($uspsservice =='ExpressMailInternational'){if(!empty($easypostwanderlust_usps_service_expres_international)){$uspsservice = $easypostwanderlust_usps_service_expres_international;}	}

								} else {
									$uspsservice = $r['service'];
								}					

								$percc = $this->extrachargeusps;$rate = $r['rate'];
								if (strpos($percc,'%') !== false) {	$perc = str_replace("%","",$percc);$perc = $perc / 100;	$ratesper = $rate * $perc; $cost = $rate + $ratesper;} else { $cost = $r['rate'] + $this->extrachargeusps;}
							$rate = array(
											'id' => sprintf("%s-%s", $r['carrier'], $r['service']),
											'label' => sprintf("%s %s", $r['carrier'] , $uspsservice),
											'cost' => $cost + $insurancecost,
											'calc_tax' => 'per_item'
									);	
						}
					} else if($r['carrier'] == 'UPS'){
						if($this->show_ups_rates == 'yes') {
							$upsservice = $r['service'];
								if($woocommerce_easypost_custom_names_ups =='1'){	
									$easypostwanderlust_ups_service = get_option( 'pvit_easypostwanderlust_ups_service' );			
									$easypostwanderlust_ups_service_ground = get_option( 'pvit_easypostwanderlust_ups_service_ground' );			
									$easypostwanderlust_ups_service_standards = get_option( 'pvit_easypostwanderlust_ups_service_standards' );			
									$easypostwanderlust_ups_service_saver = get_option( 'pvit_easypostwanderlust_ups_service_saver' );			
									$easypostwanderlust_ups_service_expres = get_option( 'pvit_easypostwanderlust_ups_service_expres' );			
									$easypostwanderlust_ups_service_expresplus = get_option( 'pvit_easypostwanderlust_ups_service_expresplus' );			
									$easypostwanderlust_ups_service_expedited = get_option( 'pvit_easypostwanderlust_ups_service_expedited' );
									$easypostwanderlust_ups_service_nda = get_option( 'pvit_easypostwanderlust_ups_service_nda' );			
									$easypostwanderlust_ups_service_ndas = get_option( 'pvit_easypostwanderlust_ups_service_ndas' );
									$easypostwanderlust_ups_service_ndaea = get_option( 'pvit_easypostwanderlust_ups_service_ndaea' );			
									$easypostwanderlust_ups_service_2da = get_option( 'pvit_easypostwanderlust_ups_service_2da' );						
									$easypostwanderlust_ups_service_2daa = get_option( 'pvit_easypostwanderlust_ups_service_2daa' );			
									$easypostwanderlust_ups_service_3ds = get_option( 'pvit_easypostwanderlust_ups_service_3ds' );			

									if($upsservice =='Ground'){	if(!empty($easypostwanderlust_ups_service_ground)){$upsservice = $easypostwanderlust_ups_service_ground;}	}	
									if($upsservice =='UPSStandards'){if(!empty($easypostwanderlust_ups_service_standards)){$upsservice = $easypostwanderlust_ups_service_standards;}	}
									if($upsservice =='UPSSaver'){if(!empty($easypostwanderlust_ups_service_saver)){$upsservice = $easypostwanderlust_ups_service_saver;}	}
									if($upsservice =='Express'){if(!empty($easypostwanderlust_ups_service_expres)){$upsservice = $easypostwanderlust_ups_service_expres;}	}
									if($upsservice =='ExpressPlus'){if(!empty($easypostwanderlust_ups_service_expresplus)){$upsservice = $easypostwanderlust_ups_service_expresplus;}	}
									if($upsservice =='Expedited'){if(!empty($easypostwanderlust_ups_service_expedited)){$upsservice = $easypostwanderlust_ups_service_expedited;}	}
									if($upsservice =='NextDayAir'){if(!empty($easypostwanderlust_ups_service_nda)){$upsservice = $easypostwanderlust_ups_service_nda;}	}
									if($upsservice =='NextDayAirSaver'){if(!empty($easypostwanderlust_ups_service_ndas)){$upsservice = $easypostwanderlust_ups_service_ndas;}	}
									if($upsservice =='NextDayAirEarlyAM'){if(!empty($easypostwanderlust_ups_service_ndaea)){$upsservice = $easypostwanderlust_ups_service_ndaea;}	}
									if($upsservice =='2ndDayAir'){if(!empty($easypostwanderlust_ups_service_2da)){$upsservice = $easypostwanderlust_ups_service_2da;}	}
									if($upsservice =='2ndDayAirAM'){if(!empty($easypostwanderlust_ups_service_2daa)){$upsservice = $easypostwanderlust_ups_service_2daa;}	}
									if($upsservice =='3DaySelect'){if(!empty($easypostwanderlust_ups_service_3ds)){$upsservice = $easypostwanderlust_ups_service_3ds;}	}

								} else {
									$upsservice = $r['service'];
								}	

								$percc = $this->extrachargeups;$rate = $r['rate'];
								if (strpos($percc,'%') !== false) {	$perc = str_replace("%","",$percc);$perc = $perc / 100;	$ratesper = $rate * $perc; $cost = $rate + $ratesper;} else { $cost = $r['rate'] + $this->extrachargeups;}
								$rate = array(
									'id' => sprintf("%s-%s", $r['carrier'], $r['service']),
									'label' => sprintf("%s %s", $r['carrier'] , $upsservice),
									'cost' => $cost + $insurancecost,
									'calc_tax' => 'per_item'
								);	
						}
					} else if($r['carrier'] == 'CanadaPost'){
						if($this->show_canada_rates == 'yes') {
								$percc = $this->extrachargecanada;$rate = $r['rate'];
								if (strpos($percc,'%') !== false) {$perc = str_replace("%","",$percc);$perc = $perc / 100;$ratesper = $rate * $perc; $cost = $rate + $ratesper;} else { $cost = $r['rate'] + $this->extrachargecanada;}
							$rate = array(
											'id' => sprintf("%s-%s", $r['carrier'], $r['service']),
											'label' => sprintf("%s %s", $r['carrier'] , $r['service']),
											'cost' => $cost + $insurancecost,
											'calc_tax' => 'per_item'
									);	
						}
					} else if($r['carrier'] == 'DHLExpress'){
						if($this->show_dhl_rates == 'yes') {
							$dhlservice = $r['service'];
								if($woocommerce_easypost_custom_names_dhl =='1'){	
									$easypostwanderlust_dhl_service_expressww = get_option( 'pvit_easypostwanderlust_dhl_service_expressww' );	
									$easypostwanderlust_dhl_service_expresswwnondoc = get_option( 'pvit_easypostwanderlust_dhl_service_expresswwnondoc' );
									$easypostwanderlust_dhl_service_medicalexpnondoc = get_option( 'pvit_easypostwanderlust_dhl_service_medicalexpnondoc' );	 									
									if($dhlservice =='ExpressWorldwide'){	if(!empty($easypostwanderlust_dhl_service_expressww)){$dhlservice = $easypostwanderlust_dhl_service_expressww;}	}
									if($dhlservice =='ExpressWorldwideNonDoc'){	if(!empty($easypostwanderlust_dhl_service_expresswwnondoc)){$dhlservice = $easypostwanderlust_dhl_service_expresswwnondoc;}	}
									if($dhlservice =='MedicalExpressNonDoc'){	if(!empty($easypostwanderlust_dhl_service_medicalexpnondoc)){$dhlservice = $easypostwanderlust_dhl_service_medicalexpnondoc;}	}	
								} else {
									$dhlservice = $r['service'];
								}				
								$percc = $this->extrachargedhl;$rate = $r['rate'];
								if (strpos($percc,'%') !== false) {$perc = str_replace("%","",$percc);$perc = $perc / 100;$ratesper = $rate * $perc; $cost = $rate + $ratesper;} else { $cost = $r['rate'] + $this->extrachargedhl;}
							$rate = array(
											'id' => sprintf("%s-%s", 'DHL Express', $r['service']),
											'label' => sprintf("%s %s", 'DHL Express' , $dhlservice),
											'cost' => $cost + $insurancecost,
											'calc_tax' => 'per_item'
									);				
						}	
					} else if ($r['carrier'] == 'DHLGlobalMail'){
							if($this->show_dhl_rates == 'yes') {
									$dhlservice = $r['service'];
									$percc = $this->extrachargedhl;
									$rate = $r['rate'];
									if (strpos($percc,'%') !== false) {$perc = str_replace("%","",$percc);$perc = $perc / 100;$ratesper = $rate * $perc; $cost = $rate + $ratesper;} else { $cost = $r['rate'] + $this->extrachargedhl;}
									$rate = array(
													'id' => sprintf("%s-%s", 'DHL Global Mail', $r['service']),
													'label' => sprintf("%s %s", 'DHL Global Mail' , $dhlservice),
													'cost' => $cost,
													'calc_tax' => 'per_item'
											);			
							}	
					} else if ($r['carrier'] == 'AustraliaPost'){
									$dhlservice = $r['service'];
									$percc = $this->extrachargedhl;
									$rate = $r['rate'];
									if (strpos($percc,'%') !== false) {$perc = str_replace("%","",$percc);$perc = $perc / 100;$ratesper = $rate * $perc; $cost = $rate + $ratesper;} else { $cost = $r['rate'] + $this->extrachargedhl;}
									$rate = array(
													'id' => sprintf("%s-%s", 'Australia Post', $r['service']),
													'label' => sprintf("%s %s", 'Australia Post' , $dhlservice),
													'cost' => $cost,
													'calc_tax' => 'per_item'
											);			
					} else {
										$rate = array(
													'id' => sprintf("%s-%s", $r['carrier'], $r['service']),
													'label' => sprintf("%s %s", $r['carrier'], $r['service']),
													'cost' => $r['rate'],
													'calc_tax' => 'per_item'
											);			
					}  
			  
	        $filter_out = !empty($this->filter_rates) ? $this->filter_rates : array('LibraryMail', 'MediaMail');
	        
			  	{
	          if (!in_array($r['service'], $filter_out)){
	            // Register the rate
	            $this->add_rate( $rate );
	          }
	        } 
 		  }
 		}
 	} catch (Exception $e) {
 		//echo 'Caught exception: ',  $e->getMessage(), "\n";
 	}
		 

    	return $requests;
    }

    

    /**
     * calculate_shipping function.
     *
     * @param mixed $package
     */
    public function calculate_shipping( $package ) {
    	// Clear rates
    	$this->found_rates = array();

    	// Debugging
    	$this->debug( __( 'wanderlust debug mode is on - to hide these messages, turn debug mode off in the settings.', 'wc_wanderlust' ) );

		// Get requests		
		$wanderlust_packages    = $this->get_wanderlust_packages( $package );
		$wanderlust_requests    = $this->get_wanderlust_requests( $wanderlust_packages, $package );
 		
 
		// Ensure rates were found for all packages
		$packages_to_quote_count = sizeof( $wanderlust_requests );

		if ( $this->found_rates ) {
			foreach ( $this->found_rates as $key => $value ) {
				if ( $value['packages'] < $packages_to_quote_count )
					unset( $this->found_rates[ $key ] );
			}
		}

    }     
}