<?php
add_filter( 'woocommerce_shipping_fields', 'woocommerce_shipping_fields_phone' );
 
function woocommerce_shipping_fields_phone( $fields ) {
	
	$fields['shipping_phone_code']   = array(
		'label'        => '',
		//'required'     => true,
		'class'        => array( '', 'country_code' ),
		'priority'     => 90,
		'placeholder'  => '',
		'custom_attributes' => array('readonly' => 'readonly'),
	);
	 
	$fields['shipping_phone']   = array(
		'label'        => 'Phone',
		'required'     => true,
		'class'        => array( 'form-row-wide', 'my-custom-class' ),
		'priority'     => 90,
		'placeholder'  => '',
	);
	
	$fields['shipping_email']   = array(
		'label'        => 'Email address',
		'required'     => true,
		'class'        => array( 'form-row-wide', 'my-custom-class' ),
		'priority'     => 90,
		'placeholder'  => '',
	);
 
	return $fields;
 
}

add_filter( 'woocommerce_billing_fields', 'woocommerce_billing_fields_phone' );
 
function woocommerce_billing_fields_phone( $fields ) {
	
	$fields['billing_phone_code']   = array(
		'label'        => '',
		//'required'     => true,
		'class'        => array( '', 'country_code' ),
		'priority'     => 90,
		'placeholder'  => '',
		'autocomplete'      => 'off',
		'readonly'      => true,
		'custom_attributes' => array('readonly' => 'readonly'),
	);
	
	
	return $fields;
 
}

add_action( 'woocommerce_admin_order_data_after_shipping_address', 'edit_woocommerce_checkout_page', 10, 1 );
function edit_woocommerce_checkout_page($order){
    global $post_id;
    $order = new WC_Order( $post_id );
	
	echo '<p><strong style="display: block;">'.__('Email address').':</strong> <a href="mailto:' . get_post_meta($order->get_id(), '_shipping_email', true ) . '">' . get_post_meta($order->get_id(), '_shipping_email', true ) . '</a></p>';
	
    echo '<p><strong style="display: block;">'.__('Phone').':</strong> <a href="tel:' . get_post_meta($order->get_id(), '_shipping_phone_code', true ).get_post_meta($order->get_id(), '_shipping_phone', true ) . '">' . get_post_meta($order->get_id(), '_shipping_phone_code', true ).get_post_meta($order->get_id(), '_shipping_phone', true ) . '</a></p>';
	
}


add_filter( 'woocommerce_account_menu_items', 'hoge_woocommerce_account_menu_items', 10, 2 );
function hoge_woocommerce_account_menu_items( $items, $endpoints ){
	
    $items['edit-address'] = 'Recipients';
    return $items;
}

add_filter( 'woocommerce_ship_to_different_address_checked', '__return_true' );




function sv_wc_add_my_account_orders_column( $columns ) {

    $new_columns = array();
	
    foreach ( $columns as $key => $name ) {

        $new_columns[ $key ] = $name;

        // add ship-to after order status column
        if ( 'order-number' === $key ) {  //this is the line!
            $new_columns['recipient'] = __( 'Recipient', 'woocommerce' );
			$new_columns['delivery_date'] = __( 'Delivery Date', 'woocommerce' );
        }
    }

    return $new_columns;
}
add_filter( 'woocommerce_my_account_my_orders_columns', 'sv_wc_add_my_account_orders_column' );

add_action( 'woocommerce_my_account_my_orders_column_recipient', 'add_account_orders_column_rows' );
function add_account_orders_column_rows( $order ) {

	$user_id = get_current_user_id();

	$user_f_name = $order->get_data('shipping')['shipping']['first_name'];
	$user_l_name = $order->get_data('shipping')['shipping']['last_name'];

    // Example with a custom field
    if ( $value = $order->get_meta( '_shipping_address_name' ) ) {
        echo esc_html( $value );
    }else{
    	echo esc_html( $user_f_name.' '.$user_l_name );
    }
}

add_action( 'woocommerce_my_account_my_orders_column_delivery_date', 'add_account_orders_column_rows_dd' );
function add_account_orders_column_rows_dd( $order ) {
    // Example with a custom field
   // if ( $value = $order->get_meta( '_shipping_address_name' ) ) {
        echo esc_html( '-' );
    //}
}

add_filter( 'woocommerce_my_account_my_orders_actions', 'add_my_account_my_orders_custom_action', 10, 2 );
function add_my_account_my_orders_custom_action( $actions, $order ) {
    $action_slug = 'track_order';
	$action_slug2 = 'product_review';
	foreach ( $order->get_items() as $item_id => $item ) {
   		$product_id = $item->get_product_id();
	}
    $actions[$action_slug] = array(
        'url'  => home_url('/track-your-orde/'),
        'name' => 'Track Order',
    );
	$actions[$action_slug2] = array(
        'url'  => get_the_permalink($product_id).'#tab-title-reviews',
        'name' => 'Write a product review',
    );
    return $actions;
}

add_action( 'woocommerce_save_account_details', 'action_woocommerce_customer_save_address', 10, 1 );
function action_woocommerce_customer_save_address($user_id) {
		$county_code = $_POST['phone-cd'];
		if ( isset( $_POST['phone'] ) ) {
			$full_num = $county_code . $_POST['phone'];
			update_user_meta( $user_id, 'xoo_ml_phone_display', $full_num );
			update_user_meta( $user_id, 'billing_phone', $full_num );
			update_user_meta( $user_id, 'xoo_ml_phone_no', $_POST['phone'] );
			update_user_meta( $user_id, 'xoo_ml_phone_code', $county_code );
		} 
		if(isset($_POST['country'])){
			update_user_meta($user_id, 'country', $_POST['country'] ); 
		}

}

function send_otp_to_recipients($order_id) {
	$order = wc_get_order( $order_id );
	$seller = dokan_get_seller_id_by_order( $order_id );
	$store_info  = dokan_get_store_info( $seller ); // Get the store data
    $store_phone  = $store_info['phone'];
	$store_name  = $store_info['store_name'];
	$address1  = $store_info['address']['street_1'];
	$address2  = $store_info['address']['city'];
	$address3  = $store_info['address']['state'];
	$address4  = $store_info['address']['zip'];
	$address5  = $store_info['address']['country'];
	 
	
	$recipuent_pcode = get_post_meta($order_id, '_shipping_phone_code', true);
	$recipuent_phone = get_post_meta($order_id, '_shipping_phone', true);
    $user_phone = $recipuent_pcode.$recipuent_phone;
    
    $current_user_id = get_current_user_id();
    $phone1 = get_user_meta($current_user_id,'billing_phone_code',true);
    $phone2 = get_user_meta($current_user_id,'billing_phone',true);
    $phone12 = $phone1.$phone2;
    
    $fname1 = get_user_meta($current_user_id,'first_name',true);
    $lname2 = get_user_meta($current_user_id,'last_name',true);
    $name12 = $fname1.$lname2;
	//$user_phone = get_user_meta($user->data->ID, 'xoo_ml_phone_display', true);
	if($user_phone){
			$otp = rand(100000,999999);
			$args = array( 
    			'number_to' => $user_phone,
    			'message' => '[HoPscan]-You have received an order #'.$order_id.' from '.$fname1.' '.$lname2.' | One Time Password: '.$otp.'|Seller: '.$store_name.' / '.$address1.' '.$address2.' '.$address3.' '.$address4.' '.$address5.'|', 
     		); 
        	$sms = twl_send_sms($args);
        	$args1 = array(
        			'number_to' => $phone12,
        			'message' => '[HoPscan]-Order #'.$order_id.'| Your One Time Password (OTP) is '.$otp.'|It is also shared with your recipient to confirm delivery reception or Pick-Up from the Seller.',
         		); 
        	$sms1 = twl_send_sms($args1);
        	$args2 = array(
        			'number_to' => $store_phone,
        			'message' => '[HoPscan]-You have received an order #'.$otp.'',
         		); 
        	$sms2 = twl_send_sms($args2);
	if(is_wp_error($sms)){
		$note = 'OTP failed due to following error :'.$sms->get_error_message();
		$order->add_order_note( $note );
		update_post_meta($order_id, 'otp', $otp);
	}else{
		
		//$note = 'Order OTP is :'.$otp;
		//$order->add_order_note( $note );
		update_post_meta($order_id, 'otp', $otp);
	}
	
}

	
}
//add_action( 'woocommerce_order_status_driver-assigned', 'send_otp_to_recipients');
add_action( 'woocommerce_order_status_local-pickup', 'send_otp_to_recipients');
add_action( 'woocommerce_order_status_on-hold', 'send_otp_to_recipients');

// Register new status
function register_local_pickup_order_status() {
    register_post_status( 'wc-local-pickup', array(
        'label'                     => 'Local Pickup',
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Local Pickup (%s)', 'Local Pickup (%s)' )
    ) );
}
add_action( 'init', 'register_local_pickup_order_status' );

// Add to list of WC Order statuses
function add_local_pickup_to_order_statuses( $order_statuses ) {
 
    $new_order_statuses = array();
 
    // add new order status after processing
    foreach ( $order_statuses as $key => $status ) {
 
        $new_order_statuses[ $key ] = $status;
 
        if ( 'wc-processing' === $key ) {
            $new_order_statuses['wc-local-pickup'] = 'Local Pickup';
        }
    }
 
    return $new_order_statuses;
}
add_filter( 'wc_order_statuses', 'add_local_pickup_to_order_statuses' );


/**
 *  Add Extra Account fields
 */
add_action( 'woocommerce_edit_account_form', 'misha_add_field_edit_account_form' );
// or add_action( 'woocommerce_edit_account_form_start', 'misha_add_field_edit_account_form' );
function misha_add_field_edit_account_form() {
	$userid = get_current_user_id();
	$phone = get_user_meta($userid, 'xoo_ml_phone_no', true);
	$phone_code = get_user_meta($userid, 'xoo_ml_phone_code', true);
	$fullphone = get_user_meta($userid, 'xoo_ml_phone_display', true);
	$countryvl = get_user_meta($userid, 'country', true);
	$rs_billing_company = get_user_meta($userid, 'rs_billing_company', true);
	
	$selected_country = $countryvl;
	$url = get_stylesheet_directory_uri().'/country.json';
  	$str = file_get_contents($url);
  	$country_array = json_decode($str, true);
	$key = array_search($selected_country, array_column($country_array, 'code'));
	$country_telcode = $country_array[$key]['telcode'];
 	
	echo '<fieldset class="myac-extra">
		<legend>Residence Address</legend>';
		
	?>
    <?php $countries_obj   = new WC_Countries();
    $countries   = $countries_obj->__get('countries');
?>   
<p class="form-row form-row-wide" id="billing_company_field" data-priority="30">
	<label for="billing_company" class="">Company name&nbsp;<span class="optional">(optional)</span></label>
    <span class="woocommerce-input-wrapper"><input type="text" class="input-text " name="rs_billing_company" id="rs_billing_company" placeholder="" value="<?php echo esc_attr( $rs_billing_company ); ?>" autocomplete="organization"></span>
</p>

    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<label for="country"><?php esc_html_e( 'Country', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
        <select name="country" id="country" class="woocommerce-Input woocommerce-Input--country input-text" onchange="get_country(this)">
        		<option value="">Select Country</option>
                <?php
				foreach($countries as $key => $val){
					if($countryvl == $key){
						echo '<option value="'.$key.'" selected="selected">'.$val.'</option>';	
					}else{
						echo '<option value="'.$key.'">'.$val.'</option>';	
					}
				}
				?>
                
        </select>
	</p>
    
    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<label for="account_phone"><?php esc_html_e( 'Phone', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
        <input type="text" class="woocommerce-Input woocommerce-Input--phone-cd input-text" name="phone-cd" id="phone-cd" value="<?php echo esc_attr( $country_telcode ); ?>" readonly/>
		<input type="number" class="woocommerce-Input woocommerce-Input--phone input-text" name="phone" id="phone" autocomplete="phone" value="<?php echo esc_attr( $phone ); ?>" />
	</p><div style="clear:both;"></div>
    <?php	
		
	
	woocommerce_form_field(
		'rs_billing_address_1',
		array(
			'type'        => 'text',
			'required'    => true, // remember, this doesn't make the field required, just adds an "*"
			'label'       => 'Street address',
			'description' => '',
			'priority' => '1', 
		),
		get_user_meta( get_current_user_id(), 'rs_billing_address_1', true ) // get the data
	);
	
	woocommerce_form_field(
		'rs_billing_address_2',
		array(
			'type'        => 'text',
			'required'    => false, // remember, this doesn't make the field required, just adds an "*"
			'label'       => 'Apartment, suite, unit, etc.',
			'description' => '',
			'priority' => '0', 
		),
		get_user_meta( get_current_user_id(), 'rs_billing_address_2', true ) // get the data
	);
	
	woocommerce_form_field(
		'rs_billing_city',
		array(
			'type'        => 'text',
			'required'    => true, // remember, this doesn't make the field required, just adds an "*"
			'label'       => 'Town / City',
			'description' => '',
			'priority' => '0', 
		),
		get_user_meta( get_current_user_id(), 'rs_billing_city', true ) // get the data
	);
	
	woocommerce_form_field(
		'rs_billing_state',
		array(
			'type'        => 'text',
			'required'    => true, // remember, this doesn't make the field required, just adds an "*"
			'label'       => 'State',
			'description' => 'Enter state code for e.g. Texas = TX',
			'priority' => '0', 
			'placeholder' => 'Enter state code for e.g. Texas = TX',
		),
		get_user_meta( get_current_user_id(), 'rs_billing_state', true ) // get the data
	);
	
	woocommerce_form_field(
		'rs_billing_postcode',
		array(
			'type'        => 'text',
			'required'    => true, // remember, this doesn't make the field required, just adds an "*"
			'label'       => 'Postcode / ZIP',
			'description' => '',
			'priority' => '0', 
		),
		get_user_meta( get_current_user_id(), 'rs_billing_postcode', true ) // get the data
	);
 echo '</fieldset>';
 $diff_bill = get_user_meta( get_current_user_id(), 'diffrent_bill', true );
 $checked = '';
 if($diff_bill == 'no'){
	 $style = "display:block;";
	 $checkedno = 'checked';
	  $checkedyes = '';
	 }else{
		  $style = "display:none;";
		  $checkedno = '';
		  $checkedyes = 'checked';
		 }
 echo '<!--<fieldset class="myac-extra"><h3 id="different-address-bill">
			<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
			 <span>Use same billing address as residence address?</span>
				<div class="wpuf-fields" data-required="yes" data-type="radio" id="account_different_billing">
					<label class="wpuf-radio-inline">
                            <input name="diffrent_bill" class="wpuf_email_marketing_question_3788" type="radio" value="yes" '.$checkedyes.'>
                            Yes </label>
                        
                        <label class="wpuf-radio-inline">
                            <input name="diffrent_bill" class="wpuf_email_marketing_question_3788" type="radio" value="no" '.$checkedno.'>
                            No                        </label>
                        
                
            </div>
			</label>
			<span class="bill_note"><em>(The Billing address as this one is going to be used on checkout.)</em></span>
		</h3></fieldset>-->'; 
		
	/*echo '<fieldset class="myac-extra myac-extra-billing" style="'.$style.'">
		<legend>Billing Address</legend>';
	
	woocommerce_form_field(
		'billing_address_1',
		array(
			'type'        => 'text',
			'required'    => true, // remember, this doesn't make the field required, just adds an "*"
			'label'       => 'Street address',
			'description' => '',
			'priority' => '1', 
		),
		get_user_meta( get_current_user_id(), 'billing_address_1', true ) // get the data
	);
	
	woocommerce_form_field(
		'billing_address_2',
		array(
			'type'        => 'text',
			'required'    => false, // remember, this doesn't make the field required, just adds an "*"
			'label'       => 'Apartment, suite, unit, etc.',
			'description' => '',
			'priority' => '0', 
		),
		get_user_meta( get_current_user_id(), 'billing_address_2', true ) // get the data
	);
	
	woocommerce_form_field(
		'billing_city',
		array(
			'type'        => 'text',
			'required'    => true, // remember, this doesn't make the field required, just adds an "*"
			'label'       => 'Town / City',
			'description' => '',
			'priority' => '0', 
		),
		get_user_meta( get_current_user_id(), 'billing_city', true ) // get the data
	);
	
	woocommerce_form_field(
		'billing_state',
		array(
			'type'        => 'text',
			'required'    => true, // remember, this doesn't make the field required, just adds an "*"
			'label'       => 'State',
			'description' => '',
			'priority' => '0', 
		),
		get_user_meta( get_current_user_id(), 'billing_state', true ) // get the data
	);
	
	woocommerce_form_field(
		'billing_postcode',
		array(
			'type'        => 'text',
			'required'    => true, // remember, this doesn't make the field required, just adds an "*"
			'label'       => 'Postcode / ZIP',
			'description' => '',
			'priority' => '0', 
		),
		get_user_meta( get_current_user_id(), 'billing_postcode', true ) // get the data
	);
 echo '</fieldset>';*/	
}


add_action( 'woocommerce_save_account_details', 'misha_save_account_details' );
function misha_save_account_details( $user_id ) {
 
	update_user_meta( $user_id, 'billing_first_name', sanitize_text_field( $_POST['account_first_name'] ) );
	update_user_meta( $user_id, 'billing_last_name', sanitize_text_field( $_POST['account_last_name'] ) );
	update_user_meta( $user_id, 'billing_email', sanitize_text_field( $_POST['account_email'] ) );
	
	update_user_meta( $user_id, 'billing_country', sanitize_text_field( $_POST['country'] ) );
	update_user_meta( $user_id, 'billing_phone_code', sanitize_text_field( $_POST['phone-cd'] ) );
	update_user_meta( $user_id, 'billing_phone', sanitize_text_field( $_POST['phone'] ) );
	

	update_user_meta( $user_id, 'rs_billing_address_1', sanitize_text_field( $_POST['rs_billing_address_1'] ) );
	update_user_meta( $user_id, 'rs_billing_address_2', sanitize_text_field( $_POST['rs_billing_address_2'] ) );
	update_user_meta( $user_id, 'rs_billing_city', sanitize_text_field( $_POST['rs_billing_city'] ) );
	update_user_meta( $user_id, 'rs_billing_state', sanitize_text_field( $_POST['rs_billing_state'] ) );
	update_user_meta( $user_id, 'rs_billing_postcode', sanitize_text_field( $_POST['rs_billing_postcode'] ) );
	update_user_meta( $user_id, 'rs_billing_company', sanitize_text_field( $_POST['rs_billing_company'] ) );
	
	
	
	update_user_meta( $user_id, 'diffrent_bill', sanitize_text_field( $_POST['diffrent_bill'] ) );
	
	/*if($_POST['diffrent_bill'] == 'no'){
		update_user_meta( $user_id, 'billing_address_1', sanitize_text_field( $_POST['billing_address_1'] ) );
		update_user_meta( $user_id, 'billing_address_2', sanitize_text_field( $_POST['billing_address_2'] ) );
		update_user_meta( $user_id, 'billing_city', sanitize_text_field( $_POST['billing_city'] ) );
		update_user_meta( $user_id, 'billing_state', sanitize_text_field( $_POST['billing_state'] ) );
		update_user_meta( $user_id, 'billing_postcode', sanitize_text_field( $_POST['billing_postcode'] ) );
	}else{
		update_user_meta( $user_id, 'billing_address_1', sanitize_text_field( $_POST['rs_billing_address_1'] ) );
		update_user_meta( $user_id, 'billing_address_2', sanitize_text_field( $_POST['rs_billing_address_2'] ) );
		update_user_meta( $user_id, 'billing_city', sanitize_text_field( $_POST['rs_billing_city'] ) );
		update_user_meta( $user_id, 'billing_state', sanitize_text_field( $_POST['rs_billing_state'] ) );
		update_user_meta( $user_id, 'billing_postcode', sanitize_text_field( $_POST['rs_billing_postcode'] ) );
		}*/
}
 
add_filter('woocommerce_save_account_details_required_fields', 'misha_make_field_required');
function misha_make_field_required( $required_fields ){
 
	$required_fields['country'] = 'Country';
	$required_fields['phone'] = 'Phone';
	//$required_fields['billing_address_1'] = 'Address';
	//$required_fields['billing_city'] = 'City';
	//$required_fields['billing_state'] = 'State';
	//$required_fields['billing_postcode'] = 'Zip';
	return $required_fields;
 
}


//update order status to Local pickup if Shipping is Local Pickup
//add_action('woocommerce_thankyou', 'enroll_student', 10, 1);
function enroll_student( $order_id ) {


	if ( ! $order_id ){
        return;
	}
	$order = wc_get_order( $order_id );
	foreach ( $order->get_items() as $item_id => $item ) {
   			$product_id = $item->get_product_id();
			$author_id = get_post_field ('post_author', $product_id);
	}
	$shop_info    = get_user_meta( $author_id, 'dokan_profile_settings', true );
	
	$search = 'Home Delivery';
    if($order->get_shipping_method() == 'Local Pickup'){
    // Allow code execution only once 
		if( ! get_post_meta( $order_id, '_thankyou_action_done', true ) ) {
			$order->update_status('wc-local-pickup');
			$order->update_meta_data( '_thankyou_action_done', true );
			$order->save();
		}
	}
	else if(preg_match("/{$search}/i", $order->get_shipping_method()) && $shop_info['dr_assign'] == 'auto') {
		$all_drivers = get_user_meta($author_id, 'my_drivers', true);
		if ( ! $all_drivers ){
        	return;
		}
		
		$active_drivers = array();
		foreach($all_drivers as $driver){
				if(get_user_meta($driver, 'vendor_needs', true) == 'active'){
					array_push($active_drivers, $driver);	
				}
			}
	
		shuffle($active_drivers);
		$driver_id = $active_drivers[0];
		if($driver_id){
			update_post_meta( $order_id, 'ddwc_driver_id', $driver_id );
			$order->update_status( 'driver-assigned' );
			$order->update_meta_data( '_thankyou_action_done', true );
			$order->save();
		}
		
	}
	
}

/*
 * Step 1. Add Link (Tab) to My Account menu
 */
add_filter ( 'woocommerce_account_menu_items', 'misha_log_history_link', 40 );
function misha_log_history_link( $menu_links ){
 
	$menu_links = array_slice( $menu_links, 0, 5, true ) 
	+ array( 'become-a-driver' => 'Become a Driver' )
	+ array_slice( $menu_links, 5, NULL, true );
 
	return $menu_links;
 
}

add_action( 'init', 'misha_add_endpoint' );
function misha_add_endpoint() {
 
	// WP_Rewrite is my Achilles' heel, so please do not ask me for detailed explanation
	add_rewrite_endpoint( 'become-a-driver', EP_PAGES );
 
}

add_action( 'woocommerce_account_become-a-driver_endpoint', 'misha_my_account_endpoint_content' );
function misha_my_account_endpoint_content() {
 
	// of course you can print dynamic content here, one of the most useful functions here is get_current_user_id()
	
	echo '<div class="my-head"><h2 style="font-size: 18px; font-weight: 600;">Become a Driver</h2>
<div class="dokan-w4 right-content-shop">
            <a href="'.home_url().'" class="btn btn-primary" id="go_shop">Go To Shop</a>
        </div></div><div class="driver_fm">';
	echo do_shortcode('[wpuf_profile type="profile" id="4113"]');
 	echo '</div>';
}

//Disable shipping from cart page
function disable_shipping_calc_on_cart( $show_shipping ) {
    if( is_cart() ) {
        return false;
    }
    return $show_shipping;
}
add_filter( 'woocommerce_cart_ready_to_calc_shipping', 'disable_shipping_calc_on_cart', 99 );

add_action( 'woocommerce_before_checkout_billing_form', 'ts_before_checkout_billing_form', 10 );
function ts_before_checkout_billing_form(){
	
	if (is_user_logged_in()) {
			
		echo '<div class="shipping_rsbl"> 
			 <span class="woocommerce-input-wrapper">
			  <label class="checkbox ">
				Use same billing address as residence address?
				<input type="checkbox" class="input-checkbox " name="use_rsasbl" id="use_rsasbl" value="1">
			  </label><span id="loading_rsad" class="loading_dr" style="display:none; "><img src="'.home_url().'/wp-content/themes/martfury-child/image/preloader.gif" width="30px"></span>
			 </span> 
			</div>';

		}	
}


add_action( 'wp_ajax_update_billing_address', 'update_billing_address' );
add_action( 'wp_ajax_nopriv_update_billing_address', 'update_billing_address' );
function update_billing_address(){
	
	$valueis = $_POST['value'];
	$user_id = get_current_user_id();
	
	$residance_address = get_user_meta( $user_id );

	$wp_user =  new WP_User($user_id);

	$address = array();
	$address['billing_first_name'] = $residance_address['first_name'];
	$address['billing_last_name'] = $residance_address['billing_last_name'];
	$address['billing_email'][0] = $wp_user->user_email;
	$address['billing_address_1'] = $residance_address['rs_billing_address_1'];
	$address['billing_address_2'] = $residance_address['rs_billing_address_2'];
	$address['billing_city']      = $residance_address['rs_billing_city'];
	$address['billing_state']     = $residance_address['rs_billing_state'];
	$address['billing_postcode']  = $residance_address['rs_billing_postcode'];
	
	$address['billing_country'] = $residance_address['country'];
	$address['billing_phone_code'] = $residance_address['xoo_ml_phone_code'];
	$address['billing_phone']      = $residance_address['xoo_ml_phone_no'];
	$address['billing_company']     = $residance_address['rs_billing_company'];

	echo json_encode($address);
	exit;
}

add_action( 'wp_ajax_update_billing_address_again', 'update_billing_address_again' );
add_action( 'wp_ajax_nopriv_update_billing_address_again', 'update_billing_address_again' );
function update_billing_address_again(){
	
	$valueis = $_POST['value'];
	$user_id = get_current_user_id();
	
	$residance_address = get_user_meta( $user_id );
	$address = array();
	$address['billing_address_1'] = $residance_address['billing_address_1'];
	$address['billing_address_2'] = $residance_address['billing_address_2'];
	$address['billing_city']      = $residance_address['billing_city'];
	$address['billing_state']     = $residance_address['billing_state'];
	$address['billing_postcode']  = $residance_address['billing_postcode'];

	echo json_encode($address);
	exit;
}



//add_action('woocommerce_add_order_item_meta','wdm_add_values_to_order_item_meta',1,2);
if(!function_exists('wdm_add_values_to_order_item_meta'))
{
  function wdm_add_values_to_order_item_meta($item_id, $cart_item)
  {		
  
  $item_data = array();
  $flat = false;
  global $woocommerce,$wpdb;

	// Variation values are shown only if they are not found in the title as of 3.0.
	// This is because variation titles display the attributes.
	if ( $cart_item['data']->is_type( 'variation' ) && is_array( $cart_item['variation'] ) ) {
		foreach ( $cart_item['variation'] as $name => $value ) {
			$taxonomy = wc_attribute_taxonomy_name( str_replace( 'attribute_pa_', '', urldecode( $name ) ) );

			if ( taxonomy_exists( $taxonomy ) ) {
				// If this is a term slug, get the term's nice name.
				$term = get_term_by( 'slug', $value, $taxonomy );
				if ( ! is_wp_error( $term ) && $term && $term->name ) {
					$value = $term->name;
				}
				$label = wc_attribute_label( $taxonomy );
			} else {
				// If this is a custom option slug, get the options name.
				$value = apply_filters( 'woocommerce_variation_option_name', $value, null, $taxonomy, $cart_item['data'] );
				$label = wc_attribute_label( str_replace( 'attribute_', '', $name ), $cart_item['data'] );
			}

			// Check the nicename against the title.
			if ( '' === $value || wc_is_attribute_in_product_name( $value, $cart_item['data']->get_name() ) ) {
				continue;
			}

			$item_data[] = array(
				'key'   => $label,
				'value' => $value,
			);
		}
	}

	// Filter item data to allow 3rd parties to add more to the array.
	$item_data = apply_filters( 'woocommerce_get_item_data', $item_data, $cart_item );

	// Format item data ready to display.
	foreach ( $item_data as $key => $data ) {
		// Set hidden to true to not display meta on cart.
		if ( ! empty( $data['hidden'] ) ) {
			unset( $item_data[ $key ] );
			continue;
		}
		$item_data[ $key ]['key']     = ! empty( $data['key'] ) ? $data['key'] : $data['name'];
		$item_data[ $key ]['display'] = ! empty( $data['display'] ) ? $data['display'] : $data['value'];
	}

	// Output flat or in list format.
	if ( count( $item_data ) > 0 ) {
		foreach ( $item_data as $data ) {
			if($data['key'] == 'Warranty'){
				wc_add_order_item_meta($item_id, $data['key'], $data['display']);
			} 
		}
}    
  }
}

//add_filter( 'woocommerce_default_address_fields' , 'custom_override_default_address_fields' );

// Our hooked in function - $address_fields is passed via the filter!
function custom_override_default_address_fields( $address_fields ) {
     $address_fields['shipping_postcode']['required'] = false;
	 $address_fields['billing_postcode']['required'] = false;

     return $address_fields;
}

//add_action('check_admin_referer', 'logout_without_confirm', 10, 2);
function logout_without_confirm($action, $result)
{
   if ( 'log-out' === $action && $_GET['_wpnonce'] == '') {
	   
	   $previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}
	   
	   $html = '<div>';
		$html .= sprintf(
			/* translators: %s: Site title. */
			__( 'You are attempting to log out of %s' ),
			get_bloginfo( 'name' )
		);
		$html       .= '</p><p>';
		$redirect_to = isset( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '';
		
		$html       .= sprintf(
			/* translators: %s: Logout URL. */
			__( '<a href="%s" style=" background-color: #66ae3d; color: #fff; font-size: 15px !important; font-weight: 500; padding: 8px 30px; text-decoration: none; margin-right: 25px;">Cancel</a>' ),
			$previous
		);
		$html       .= sprintf(
			/* translators: %s: Logout URL. */
			__( '<a href="%s" style=" background-color: #66ae3d; color: #fff; font-size: 15px !important; font-weight: 500; padding: 8px 30px; text-decoration: none; margin-right: 25px;">log out</a>' ),
			wp_logout_url( $redirect_to )
		);
		$html .= '</div> <style>#error-page {
    margin-top: 50px;
    border: 3px solid #159615;
}</style>';
	} else {
		
		$redirect_to = isset($_REQUEST['redirect_to']) ? $_REQUEST['redirect_to'] : 'url-you-want-to-redirect';
        $location = str_replace('&amp;', '&', wp_logout_url($redirect_to));
       
		header("Location: $redirect_to");
die();
		
		//$html = __( 'The link you followed has expired.' );
//		if ( wp_get_referer() ) {
//			$html .= '</p><p>';
//			$html .= sprintf(
//				'<a href="%s">%s</a>',
//				esc_url( remove_query_arg( 'updated', wp_get_referer() ) ),
//				__( 'Please try again.' )
//			);
//		}
	}

	wp_die( $html, __( 'Something went wrong.' ), 403 );
}


add_action('woocommerce_order_status_completed', 'woocs_payment_complete', 1);
add_action('woocommerce_payment_complete', 'woocs_payment_complete');
 
function so_payment_complete($order_id) {
    if (class_exists('WOOCS')) {
        global $WOOCS;
        $WOOCS->recalculate_order($order_id);
    }
}
 
add_filter('wp_head', function() {
    if (is_page('dashboard')) {
        if (class_exists('WOOCS')) {
            global $WOOCS;
            $WOOCS->reset_currency();
        }
    }
});