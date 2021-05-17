<?php
add_action('wp_ajax_upDateOrderDriver', 'upDateOrderDriver');
add_action('wp_ajax_nopriv_upDateOrderDriver', 'upDateOrderDriver');
function upDateOrderDriver()
{	
	$driver_id = $_POST['driver_id'];
	$order_id = $_POST['order_id'];
	if($order_id && $driver_id){
		update_post_meta( $order_id, 'ddwc_driver_id', $driver_id );
		$order = new WC_Order( $order_id );
		$order->update_status( 'driver-assigned' );
		$redirect_url = home_url().'/dashboard/orders';
		$status = 1;
	}else{
		$status = 0;
		$redirect_url = home_url().'/dashboard/orders';	
	}
	echo json_encode(array('status'=>$status, 'redirect'=>$redirect_url,));
	exit;
}

function update_yourregistrationfield( $user_id ) {
		$county_code = $_POST['xoo-ml-user-reg-phone-cc'];
		if ( isset( $_POST['phone_number'] ) ) {
			$full_num = $county_code . $_POST['phone_number'];
			update_user_meta( $user_id, 'xoo_ml_phone_display', $full_num );
			update_user_meta( $user_id, 'billing_phone', $full_num );
			update_user_meta( $user_id, 'xoo_ml_phone_no', $_POST['phone_number'] );
			update_user_meta( $user_id, 'xoo_ml_phone_code', $county_code );
		}
	}
	
add_action( 'user_register', 'update_yourregistrationfield' );


 if ( isset( $_POST['dokan_migration'] ) && isset( $_POST['shopname'] ) && isset( $_POST['shopurl'] ) && wp_verify_nonce( $_POST['dokan_nonce'], 'account_migration' ) ) {
			
		 if(isset($_POST['address'])){	
			   $dokan_settings = $_POST['address'];
			   update_user_meta(  get_current_user_id(), 'dokan_profile_settings', $dokan_settings );
		 }
		
		$county_code = $_POST['migrate_phcd'];
		if ( isset( $_POST['phone'] ) ) {
			$full_num = $county_code . $_POST['phone'];
			update_user_meta( $user_id, 'xoo_ml_phone_display', $full_num );
			update_user_meta( $user_id, 'billing_phone', $full_num );
			update_user_meta( $user_id, 'xoo_ml_phone_no', $_POST['phone'] );
			update_user_meta( $user_id, 'xoo_ml_phone_code', $county_code );
		}
		
}


//Add Extra tab to Vendor dashboard for driver 

add_filter( 'dokan_query_var_filter', 'dokan_load_document_menu' );
function dokan_load_document_menu( $query_vars ) {
    $query_vars['vendor-driver'] = 'vendor-driver';
    return $query_vars;
}
add_filter( 'dokan_get_dashboard_nav', 'dokan_add_help_menu' );
function dokan_add_help_menu( $urls ) {
    $urls['vendor-driver'] = array(
        'title' => __( ' Drivers', 'dokan'),
        'icon'  => '<i class="fa fa-truck" aria-hidden="true"></i>',
        'url'   => dokan_get_navigation_url( 'vendor-driver' ),
        'pos'   => 51
    );
    return $urls;
}
add_action( 'dokan_load_custom_template', 'dokan_load_template' );
function dokan_load_template( $query_vars ) {
    if ( isset( $query_vars['vendor-driver'] ) ) {
        require_once dirname( __FILE__ ). '/vendor-driver.php';
       }
}


function prefix_save_about_settings() {
    $vendor_id   = dokan_get_current_user_id();
	
   	$post_data = wp_unslash( $_POST );
	
	
	
	$nonce     = isset( $post_data['_wpnonce'] ) ? $post_data['_wpnonce'] : '';
    // Bail if another settings tab is being saved
    if ( ! wp_verify_nonce( $nonce, 'dokan_about_settings_nonce' ) ) {
      return;
    }
	
	
    $dr_fname       = sanitize_text_field( $post_data['dr_fname'] );
	$dr_lname       = sanitize_text_field( $post_data['dr_lname'] );
    $dr_email       = sanitize_text_field( $post_data['dr_email'] );
	$dr_phone_cd    = sanitize_text_field( $post_data['dr_phone_cd'] );
    $dr_phone 		= sanitize_text_field( $post_data['dr_phone'] );
	
	
	$drvr_country   = sanitize_text_field( $post_data['drvr_country'] );
	$dr_street      = sanitize_text_field( $post_data['dr_street'] );
    $dr_street2     = sanitize_text_field( $post_data['dr_street2'] );
    $dr_city 		= sanitize_text_field( $post_data['dr_city'] );
	$dr_state       = sanitize_text_field( $post_data['dr_state'] );
    $dr_zips 		= sanitize_text_field( $post_data['dr_zips'] );
	
	
	$license_plate      = sanitize_text_field( $post_data['ddwc_driver_license_plate'] );
	$trans_type       	= sanitize_text_field( $post_data['ddwc_driver_transportation_type'] );
    $vehical_mdl       	= sanitize_text_field( $post_data['ddwc_driver_vehicle_model'] );
    $vehical_clr 		= sanitize_text_field( $post_data['ddwc_driver_vehicle_color'] );
	$licance_num 		= sanitize_text_field( $post_data['ddwc_driver_license_number'] );
	$driver_id_number 		= sanitize_text_field( $post_data['ddwc_driver_id_number'] );
	$driver_id_type 		= sanitize_text_field( $post_data['ddwc_driver_id_type'] );

	$ddwc_driver_picture 	= $_POST['ddwc_driver_picture'];
	$ddwc_driver_id_picture 	= $_POST['ddwc_driver_id_picture'];
	$ddwc_driver_licence_picture 	= $_POST['ddwc_driver_licence_picture'];



	if ( empty( $dr_fname ) || empty( $dr_lname ) || empty( $dr_email )|| empty( $dr_phone ) || empty( $drvr_country ) || empty( $dr_street ) || empty( $dr_city )|| empty( $dr_state ) || empty( $dr_zips ) || empty($driver_id_type) || empty($driver_id_number) || empty($ddwc_driver_picture) || empty($ddwc_driver_id_picture) || empty($ddwc_driver_licence_picture) ) {
		wp_send_json_error( __( 'All Required Fields should not be blank!' ) );
	}
    if ( 4 > strlen( $dr_fname ) ) {
   		wp_send_json_error( __( 'First Name too short. At least 4 characters is required' ) );
	}
	
	if ( !is_email( $dr_email ) ) {
    	wp_send_json_error( __( 'Email is not valid' ));
	}
	
	if ( email_exists( $dr_email ) ) {
    	wp_send_json_error( __( 'Email Already in use' ));
	}
	
	$username = preg_replace('/([^@]*).*/', '$1', $dr_email);
	if ( username_exists( $username ) ){
    	$username = $username.'1';
	}
	
	$password = wp_generate_password(12, true);
	
        $userdata = array(
        'user_login'    =>   $username,
        'user_email'    =>   $dr_email,
        'user_pass'     =>   $password,
        'display_name'  =>   $dr_fname.' '.$dr_lname,
      
        );
       $user_id = wp_insert_user( $userdata );
 	 
		
		$county_code = $dr_phone_cd;
		if ( isset( $dr_phone ) ) {
			$full_num = $county_code . $dr_phone;
			update_user_meta( $user_id, 'xoo_ml_phone_display', $full_num );
			update_user_meta( $user_id, 'billing_phone', $full_num );
			update_user_meta( $user_id, 'xoo_ml_phone_no', $dr_phone );
			update_user_meta( $user_id, 'xoo_ml_phone_code', $county_code );
		}
		
		
		update_user_meta( $user_id, 'ddwc_driver_availability', 'on');
		update_user_meta( $user_id, 'phone', $dr_phone );
		
		update_user_meta( $user_id, 'first_name', $dr_fname );
		update_user_meta( $user_id, 'last_name', $dr_lname );
		update_user_meta( $user_id, 'ddwc_driver_license_plate', $license_plate );
		update_user_meta( $user_id, 'ddwc_driver_transportation_type', $trans_type );
		update_user_meta( $user_id, 'ddwc_driver_vehicle_model', $vehical_mdl );
		update_user_meta( $user_id, 'ddwc_driver_vehicle_color', $vehical_clr );
		update_user_meta( $user_id, 'ddwc_driver_license_number', $licance_num );
		update_user_meta( $user_id, 'ddwc_driver_id_type', $driver_id_type );
		update_user_meta( $user_id, 'ddwc_driver_id_number', $driver_id_number );
		
		
		update_user_meta( $user_id, 'phone-cd', $dr_phone_cd );
		update_user_meta( $user_id, 'country', $drvr_country );
		update_user_meta( $user_id, 'billing_country', $drvr_country );
		update_user_meta( $user_id, 'rs_billing_address_1', $dr_street );
		update_user_meta( $user_id, 'rs_billing_address_2', $dr_street2 );
		update_user_meta( $user_id, 'rs_billing_city', $dr_city );
		update_user_meta( $user_id, 'rs_billing_state', $dr_state );
		update_user_meta( $user_id, 'rs_billing_postcode', $dr_zips );
        update_user_meta( $user_id, 'ddwc_driver_picture', $ddwc_driver_picture );
        update_user_meta( $user_id, 'ddwc_driver_id_picture', $ddwc_driver_id_picture );
        update_user_meta( $user_id, 'ddwc_driver_licence_picture', $ddwc_driver_licence_picture );
        
		
		//update_user_meta( $user_id, 'billing_phone', $dr_phone );
		
		$existing = get_user_meta( $vendor_id, 'my_drivers', true );
		if($existing){
		 array_push($existing, $user_id);
		}else{
			$existing = array($user_id);  
		}
		$result = array_unique($existing);
		
		update_user_meta( $vendor_id, 'my_drivers', $result);
		
		$existing_vendor = get_user_meta( $user_id, 'driver_vendor', true );
		if($existing_vendor){
		 array_push($existing_vendor, $vendor_id);
		}else{
			$existing_vendor = array($vendor_id);  
		}
		$result_vendor = array_unique($existing_vendor);
		update_user_meta( $user_id, 'driver_vendor',$result_vendor);
		
	   	wp_update_user( array ('ID' => $user_id, 'role' => 'driver') ) ;
		 
		add_filter( 'wp_mail_content_type', 'set_html_content_type' );
			
		$message .='<div style="background-color: rgb(255,255,255); overflow: hidden; border-style: solid; border-width: 1.0px; border-color: rgb(222,222,222); border-radius: 3.0px; padding: 0 20px; max-width: 90%; margin: 20px auto;">';
		
		$message .='<p>Hi '.$dr_fname.' '.$dr_lname.',';
		
		$message .='<p>Thank you for registering on HoPscan as a Delivery Driver. Your user name is '.$username.' and your temporally password is '.$password.' You can access your account and change your password here:</p>';
		
		//$message .='<p><strong>Username : '.$username.' </strong></p> ';	
		
		//$message .='<p><strong>Password : '.$password.' </strong></p> ';	
		
		//$message .='<p>Please Login using below link. </p> ';
		
		$message .='<div class=""><a href="'.home_url('my-account').'" style="background-color: #66ae3d;font-size: 18px;color: #fff;font-weight: 600;padding: 10px;width: 110px;display: block;text-align: center;border-radius: 4px;text-decoration: none;">LOGIN</a></div> ';	
		
		$message .='<p>Thanks for connecting with HoPscan.</p> ';	
		
		$message .='<div style="padding: 0;border: 0; text-align: center;font-size: 12px;font-family: Helvetica Neue, Helvetica, Roboto, Arial, sans-serif; font-weight: 400;color: #555555;padding-top: 0px;padding-bottom: 0px">
														<p style="color: #555555">© 2021 HoPscan. All Rights Reserved</p>
													</div>';
		$message .='</div>';											
													
		
		
		$email = wp_mail( $dr_email, 'HoPscan driver account created', $message );
		
		if($email != 1){
				wp_send_json_error( __( 'Email not send for '.$username.',  Plase send Account password Mannually Password : '.$password ));
			}
		
		remove_filter( 'wp_mail_content_type', 'set_html_content_type' );	
		
    wp_send_json_success( array(
        'msg' => __( 'Driver Registerd successfully!' ),
    ) );
}
add_action( 'wp_ajax_dokan_settings', 'prefix_save_about_settings', 5 );

function set_html_content_type() {
return 'text/html';
}

add_action('wp_ajax_deactivet_driver_for_vendor', 'deactivet_driver_for_vendor');
add_action('wp_ajax_nopriv_deactivet_driver_for_vendor', 'deactivet_driver_for_vendor');
function deactivet_driver_for_vendor()
{	

	$option_val = $_POST['option_value'];
	$user_id = $_POST['user_id'];
	if($user_id){
		update_user_meta($user_id, 'vendor_needs', $option_val);
	
		echo 'Success';
	}else{
		echo 'failed';
		}
		
	exit;
}


add_action( 'wp_ajax_sraech_drivers', 'sraech_drivers' );
add_action( 'wp_ajax_nopriv_sraech_drivers', 'sraech_drivers' );
function sraech_drivers(){
	
	$vendor_id = $_POST['vendor_id'];
	$search_txt = $_POST['drtext'];
	$users_query = new WP_User_Query( array( 
								 'search'=> "*{$search_txt}*",
								'search_columns' => array(
											'user_login',
											'user_email',
								),
								'fields' => 'all_with_meta', 
								'role' => 'driver',  
								'orderby' => 'display_name',	
								
							'meta_query' => array(
								'relation' => 'OR',
								array(
									'key' => 'ddwc_driver_availability',
									'value' => 'on',
									'compare' => 'LIKE',
								),
							)

            ) ); 
      	$results = $users_query->get_results();
		$error_msg = '';
			if($results){		   
				$res .='<select name="dr_selected">';
				foreach ( $results as $user => $data ) {
					$dr_id = $data->data->ID;
					$existing = get_user_meta( $dr_id, 'driver_vendor', true );
					if (in_array($vendor_id, $existing))
					  {
						  $error_msg = '<span>Driver already added.</span>';
					  }
					else
					  {
					  	$dr_name = $data->data->display_name;
						$res .='<option value="'.$dr_id.'">'.$dr_name.'</option>';	
					  }
					
													 
				}
				$res .='</select>';
			}else{
				$res ='<span>No Driver Found! </span>';
				}
	if(empty($error_msg)){
		echo $res;
		}else{
			echo $error_msg;
			}			
	
	exit;
	
};

if(isset($_POST['dokan_add_driver'])){
	$new_dr =  $_POST['dr_selected'];
 	$vendor_id = get_current_user_id(); 
	$existing = get_user_meta( $vendor_id, 'my_drivers', true );
	
	$existing_vendor = get_user_meta( $new_dr, 'driver_vendor', true );
	
	if($existing_vendor){
		 array_push($existing_vendor, $vendor_id);
		}else{
			$existing_vendor = array($vendor_id);  
		}
	$result_dr = array_unique($existing_vendor);
	
	
	if($existing){
		 array_push($existing, $new_dr);
		}else{
			$existing = array($new_dr);  
		}
		$result = array_unique($existing);
		
		update_user_meta( $vendor_id, 'my_drivers', $result);
		update_user_meta( $new_dr, 'driver_vendor', $result_dr );
		
}

add_action( 'wp_ajax_show_driver_details', 'show_driver_details' );
add_action( 'wp_ajax_nopriv_show_driver_details', 'show_driver_details' );
function show_driver_details(){
	
	$driver_id = $_POST['driver_id'];
	
    $user = get_userdata($driver_id);
	$driver_image = get_user_meta($driver_id, 'ddwc_driver_picture', true);
	
	
	if(empty($driver_image)){
		$driver_image_url = get_stylesheet_directory_uri().'/image/default-user-icon.jpg';
	}else{
		$driver_image_url = $driver_image['url'];
		}
	
	$userdata = get_user_meta($driver_id);
		
	if($user){		   
		$res .='<div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" onclick="close_popup();"><i class="fa fa-times">&nbsp;</i></button>
        <h4 class="modal-title" id="myModalLabel">More About '.$user->data->display_name.'</h4>
      </div>
      <div class="modal-body">
        <center>
          <img src="'.$driver_image_url.'" name="aboutme" width="140" height="140" border="0" class="img-circle">
          <h3 class="media-heading">'.$userdata['first_name'][0].' '.$userdata['last_name'][0].'</h3>
		</center>  
        <div style="text-align: left;"><span><strong>License Plate Number : </strong></span><span class="label label-success">'.$userdata['ddwc_driver_license_plate'][0].'</span></div>
		<div style="text-align: left;"><span><strong>Transportation Type : </strong></span><span class="label label-success">'.$userdata['ddwc_driver_transportation_type'][0].'</span></div>
		<div style="text-align: left;"><span><strong>Vehicle Model : </strong></span><span class="label label-success">'.$userdata['ddwc_driver_vehicle_model'][0].'</span></div>
		<div style="text-align: left;"><span><strong>Vehicle Color : </strong></span><span class="label label-success">'.$userdata['ddwc_driver_vehicle_color'][0].'</span></div>
        
        <hr>
        <!--<center>
          <p class="text-left"><strong>Bio: </strong><br>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sem dui, tempor sit amet commodo a, vulputate vel tellus.</p>
          <br>
        </center>-->
      </div>
      <!--<div class="modal-footer">
        <center>
          <button type="button" class="btn btn-default" data-dismiss="modal">I\'ve heard enough about Joe</button>
        </center>
      </div>-->
    </div>';
	}else{
		$res ='No Drivers details Found!';
		}
	echo $res;
	
	exit;
	
};


add_action( 'wp_ajax_removeDriverFromList', 'removeDriverFromList' );
add_action( 'wp_ajax_nopriv_removeDriverFromList', 'removeDriverFromList' );
function removeDriverFromList(){
	
	$driver_id = $_POST['driver_id'];
	$vendor_id = get_current_user_id();
	
	$existing = get_user_meta( $vendor_id, 'my_drivers', true );
	$existing_vendors = get_user_meta( $driver_id, 'driver_vendor', true );
	
	$orders_ids = get_orders_ids_by_product_id( $driver_id );
	$cr_vendor_ord = array();
	if($orders_ids){
		foreach($orders_ids as $ord_id){
			if(dokan_get_seller_id_by_order( $ord_id ) == $vendor_id){
				$cr_vendor_ord[] = $ord_id;
			}
		}
	}
	
	if($cr_vendor_ord){
			$dr_name = get_user_meta($driver_id, 'first_name', true).' '.get_user_meta($driver_id, 'last_name', true);
			$List = implode(', ', $cr_vendor_ord);
		echo 'Driver '.$dr_name.' have this orders ( '.$List.' ) active now so please wait till order complete or change order driver!';
		
	}else{
		if($driver_id){
			if (in_array($driver_id, $existing)) 
			{
				unset($existing[array_search($driver_id, $existing)]);
			}
			update_user_meta( $vendor_id, 'my_drivers', $existing);
			if (in_array($vendor_id, $existing_vendors)) 
			{
				unset($existing_vendors[array_search($vendor_id, $existing_vendors)]);
			}
			update_user_meta( $driver_id, 'driver_vendor', $existing_vendors);
			echo 'Driver removed';
		}
	}
	exit;
}

function get_orders_ids_by_product_id( $driver_id, $order_status = array( 'wc-completed' ) ){
    global $wpdb;
	
	
	$order_ids = $wpdb->get_col( "
					SELECT DISTINCT ID
					FROM {$wpdb->prefix}posts o
					INNER JOIN {$wpdb->prefix}postmeta om
						ON o.ID = om.post_id
					WHERE o.post_type = 'shop_order'
					AND o.post_status IN ('wc-on-hold','wc-driver-assigned','wc-out-for-delivery','wc-order-returned')
					AND om.meta_key = 'ddwc_driver_id'
					AND om.meta_value LIKE '$driver_id'
	");
    return $order_ids;
}




/*Extra field on the seller settings and show the value on the store banner -Dokan*/

// Add extra field in seller settings
add_filter( 'dokan_settings_form_bottom', 'extra_fields', 10, 2);
function extra_fields( $current_user, $profile_info ){
$dd_range= isset( $profile_info['dd_range'] ) ? $profile_info['dd_range'] : '';
$local_range= isset( $profile_info['local_range'] ) ? $profile_info['local_range'] : '';
$pm_cat= isset( $profile_info['pm_cat'] ) ? $profile_info['pm_cat'] : '';
$dr_assign= isset( $profile_info['dr_assign'] ) ? $profile_info['dr_assign'] : '';

$cost_per_dis= isset( $profile_info['cost_per_dis'] ) ? $profile_info['cost_per_dis'] : '';
$distance_unit= isset( $profile_info['distance_unit'] ) ? $profile_info['distance_unit'] : '';
if(empty($distance_unit)){
	$distance_unit = 'metric';
	}
?>
 <div class="gregcustom dokan-form-group">
        <label class="dokan-w3 dokan-control-label" for="setting_address">
            <?php _e( 'Primary category', 'dokan' ); ?>
        </label>
        <div class="dokan-w5">
            <select class="dokan-select2 dokan-form-control" name="pm_cat" id="pm_cat" data-placeholder="Store Categories">
            <?php 
				foreach($profile_info['categories'] as $terms){
					if($terms->name != 'All Shop'){
					?>
				 <option value="<?php echo $terms->name; ?>" selected="<?php if($pm_cat == $terms->name){ echo 'selected';}else{echo '';}?>"><?php echo $terms->name; ?></option>
               <?php }
				}
			?>
            
                            <!--<option value="Grocery" selected="<?php //if($pm_cat == 'Grocery'){ echo 'selected';}else{echo '';}?>">Grocery</option>
                            <option value="Pharmacy and Beauty" selected="<?php //if($pm_cat == 'Pharmacy and Beauty'){ echo 'selected';}else{echo '';}?>">Pharmacy and Beauty</option>
                            <option value="Saloon Products and Services" selected="<?php //if($pm_cat == 'Saloon Products and Services'){ echo 'selected';}else{echo '';}?>">Saloon Products and Services</option>-->
                    </select>
        </div>
    </div>
<?php 
if($distance_unit =='metric'){
	$place = 'KM';
	}else{
		$place = 'Miles';
		}
?>
<?php 
if($distance_unit =='metric'){
	$place_per_distance = 'Cost/km';
	}else{
		$place_per_distance = 'Cost/miles';
		}
?>
<div class="gregcustom dokan-form-group">
        <label class="dokan-w3 dokan-control-label" for="setting_address">
            <?php _e( 'Distance Unit', 'dokan' ); ?>
        </label>
        <div class="dokan-w5 radio_btns">
            <span><input type="radio" id="dr_assign_auto" name="distance_unit" value="metric" <?php if($distance_unit =='metric'){echo 'checked';}else{echo '';}?> >
            <label for="dr_assign_auto">KM</label>
            <input type="radio" id="dr_assign_mn" name="distance_unit" value="imperial" <?php if($distance_unit =='imperial'){echo 'checked';}else{echo '';}?> >
            <label for="dr_assign_mn">Miles</label></span>
        </div>
    </div> 

 <div class="gregcustom dokan-form-group">
        <label class="dokan-w3 dokan-control-label" for="setting_address">
            <?php _e( 'Driver delivery range', 'dokan' ); ?>
        </label>
        <div class="dokan-w5">
            <input type="number" class="dokan-form-control input-md valid" placeholder="<?php echo $place; ?>" name="dd_range" id="reg_dd_range" value="<?php echo $dd_range; ?>" />
        </div>
    </div>
  
  <div class="gregcustom dokan-form-group">
        <label class="dokan-w3 dokan-control-label" for="setting_address">
            <?php _e( 'Loacl Pickup Range', 'dokan' ); ?>
        </label>
        <div class="dokan-w5">
            <input type="number" class="dokan-form-control input-md valid" placeholder="<?php echo $place; ?>" name="local_range" id="reg_local_range" value="<?php echo $local_range; ?>" />
        </div>
    </div>  
    
 <div class="gregcustom dokan-form-group">
        <label class="dokan-w3 dokan-control-label" for="setting_address">
            <?php _e( 'Cost per distance', 'dokan' ); ?>
        </label>
        <div class="dokan-w5">
            <input type="number" class="dokan-form-control input-md valid" placeholder="<?php echo $place_per_distance; ?>" name="cost_per_dis" id="cost_per_dis" value="<?php echo $cost_per_dis; ?>" />
        </div>
    </div>
        
   
    
     <div class="gregcustom dokan-form-group">
        <label class="dokan-w3 dokan-control-label" for="setting_address">
            <?php _e( 'Driver assignment on order', 'dokan' ); ?>
        </label>
        <div class="dokan-w5 radio_btns">
            <span><input type="radio" id="dr_assign_auto" name="dr_assign" value="auto" <?php if($dr_assign =='auto'){echo 'checked';}else{echo '';}?> >
            <label for="dr_assign_auto">Auto</label>
            <input type="radio" id="dr_assign_mn" name="dr_assign" value="manual" <?php if($dr_assign =='manual'){echo 'checked';}else{echo '';}?> >
            <label for="dr_assign_mn">Manually</label></span>
        </div>
    </div>
    <?php
}

//save the field value
add_action( 'dokan_store_profile_saved', 'save_extra_fields', 15 );
function save_extra_fields( $store_id ) {
    $dokan_settings = dokan_get_store_info($store_id);
    if ( isset( $_POST['dd_range'] ) ) {
        $dokan_settings['dd_range'] = $_POST['dd_range'];
    }
	if ( isset( $_POST['local_range'] ) ) {
        $dokan_settings['local_range'] = $_POST['local_range'];
    }
	if ( isset( $_POST['pm_cat'] ) ) {
        $dokan_settings['pm_cat'] = $_POST['pm_cat'];
    }
	if ( isset( $_POST['dr_assign'] ) ) {
        $dokan_settings['dr_assign'] = $_POST['dr_assign'];
    }
	
	if ( isset( $_POST['distance_unit'] ) ) {
        $dokan_settings['distance_unit'] = $_POST['distance_unit'];
    }
	if ( isset( $_POST['cost_per_dis'] ) ) {
        $dokan_settings['cost_per_dis'] = $_POST['cost_per_dis'];
    }
	if ( isset( $_POST['phone_cd'] ) ) {
        $dokan_settings['phone_cd'] = $_POST['phone_cd'];
    }
	
	
	
	
 update_user_meta( $store_id, 'dokan_profile_settings', $dokan_settings );
}

//Become a Vendor First Email
 
add_action('shutdown', 'shutdown_send_vendor_email');
function shutdown_send_vendor_email(){
	
		if(is_user_logged_in() && isset($_GET['page'])){
		$user = wp_get_current_user();	
		
		//$vendor_id = get_current_user_id();
		$messagestatus = get_user_meta($user->ID, 'welcome_email', true);
		if($_GET['page'] == 'dokan-seller-setup' && empty($messagestatus)){
		
		add_filter( 'wp_mail_content_type', 'set_html_content_type' );
			
		$message .='<div style="background-color: rgb(255,255,255); overflow: hidden; border-style: solid; border-width: 1.0px; border-color: rgb(222,222,222); border-radius: 3.0px; padding: 0 20px; max-width: 90%; margin: 20px auto;">';
		
		$message .='<p>Congratulations '.$user->data->display_name.',';
		
		$message .='<p>Your account is upgraded to vendor account but wating for admin approval. Your account will be approved soon.</p>';
		
		$message .='<p><strong>Now you will be able to update your shop info or store address. </strong></p> ';	
		
		$message .='<p>Please Login using link below. </p> ';
		
		$message .='<div class=""><a href="'.home_url('my-account').'" style="background-color: #66ae3d;font-size: 18px;color: #fff;font-weight: 600;padding: 10px;width: 110px;display: block;text-align: center;border-radius: 4px;text-decoration: none;">LOGIN</a></div> ';	
		
		$message .='<p>Thanks for connecting with HoPscan.</p> ';	
		
		$message .='<div style="padding: 0;border: 0; text-align: center;font-size: 12px;font-family: Helvetica Neue, Helvetica, Roboto, Arial, sans-serif; font-weight: 400;color: #555555;padding-top: 0px;padding-bottom: 0px">
														<p style="color: #555555">© 2020 HoPscan. All Rights Reserved</p>
													</div>';
		$message .='</div>';											
													
		
		
		$email = wp_mail( $user->data->user_email, 'HoPscan vendor account created', $message );
		
		if($email != 1){
				wp_send_json_error( __( 'Email not send for '.$user->data->user_email ));
		}else{
			
			update_user_meta($user->ID, 'welcome_email', 'sended');
		
				
		}
			
		
		remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
		
		
		}
		}
	
}
//add_action ('set_user_role', 'my_profile_update', 20, 3);  
  
  
//add_action( 'profile_update', 'my_profile_update', 10, 2 );
function my_profile_update( $user_id, $role  , $old_role ) {
     echo '<pre>Profile Update';
	print_r($user_id);
	echo '</pre>';
	
	 echo '<pre>Old Data ';
	print_r($role);
	echo '</pre>';
	
	 echo '<pre>POST ';
	print_r($old_role);
	echo '</pre>';
	
	exit;   
}



