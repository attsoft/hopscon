<?php
include_once 'phone-verify.php'; 
include_once 'driver-edits.php';
include_once 'vendor-edits.php';
include_once 'login-authentication.php';
include_once 'woocommerce-edits.php';
include_once 'theme-functions.php';
add_action( 'wp_enqueue_scripts', 'martfury_child_enqueue_scripts', 20 );
function martfury_child_enqueue_scripts() {
	wp_enqueue_style( 'martfury-child-style', get_stylesheet_uri() );
	if ( is_rtl() ) {
		wp_enqueue_style( 'martfury-rtl', get_template_directory_uri() . '/rtl.css', array(), '20180105' );
	}
	
	if (strpos($_SERVER['REQUEST_URI'], "/my-account/address-book-edit/") !== false){
	    wp_dequeue_script('google-map');
	    wp_dequeue_script('dokan-maps');
	    wp_dequeue_script('google-maps');
	}
		if (strpos($_SERVER['REQUEST_URI'], "address-book-add") !== false){
	    wp_dequeue_script('google-map');
	    wp_dequeue_script('dokan-maps');
	    wp_dequeue_script('google-maps');
	}
	if (strpos($_SERVER['REQUEST_URI'], "edit-account") !== false){
	    wp_dequeue_script('google-map');
	    wp_dequeue_script('dokan-maps');
	} 
	if (strpos($_SERVER['REQUEST_URI'], "vendor-driver") !== false){
	    wp_dequeue_script('google-map');
	    wp_dequeue_script('dokan-maps');
	} 
	if (strpos($_SERVER['REQUEST_URI'], "checkout") !== false){
	    wp_dequeue_script('google-maps');
	} 
	if (strpos($_SERVER['REQUEST_URI'], "/dashboard/settings/store/") !== false){
	    wp_dequeue_script('google-map');
	    wp_dequeue_script('dokan-maps');
	    wp_dequeue_script('google-maps');
	} 
	
}

//update_option( 'admin_email', 'attsoftwarenimda@gmail.com' );
//update_option( 'new_admin_email', 'attsoftwarenimda@gmail.com' );

//Custom JS Script Enqueue
function wpb_adding_scripts() {
wp_register_script('custom-script', get_stylesheet_directory_uri() . '/assets/js/custom-script.js', array('jquery'),'1.1', true);
wp_enqueue_script('custom-script');
wp_localize_script('custom-script', 'WP_SITE_URLS', array('siteurl' => admin_url('admin-ajax.php') ,

    ));
}
add_action( 'wp_enqueue_scripts', 'wpb_adding_scripts' );

//Logout Redirect
add_action('wp_logout','ps_redirect_after_logout');
function ps_redirect_after_logout(){
         wp_redirect(home_url('my-account'));
         //exit();
}

function update_your_registrationfield( $user_id ) {
	/*echo "<pre>"; print_r($user_id); echo "</pre>";
	exit;*/
	if ( isset( $_POST['vendor_identity_id'] ) ) {
		update_user_meta( $user_id, 'vendor_identity_id', $_POST['vendor_identity_id'] );
	}
	if ( isset( $_POST['email_marketing_question'] ) ) {
		update_user_meta( $user_id, 'email_marketing_question', $_POST['email_marketing_question'] );
	}
}
add_action( 'wpuf_after_register', 'update_your_registrationfield' );


function wooc_extra_register_fields() { 
	?>
        <p class="form-row form-group">
			<label for="first-name"><?php esc_html_e( 'First Name', 'martfury' ); ?>
				<span class="required">*</span></label>
			<input type="text" class="input-text form-control" name="fname" id="first-name" value="<?php if ( ! empty( $_POST['fname'] ) ) {
				echo esc_attr( $_POST['fname'] );
			} ?>" required="required" />
		</p>

		<p class="form-row form-group">
			<label for="last-name"><?php esc_html_e( 'Last Name', 'martfury' ); ?>
				<span class="required">*</span></label>
			<input type="text" class="input-text form-control" name="lname" id="last-name" value="<?php if ( ! empty( $_POST['lname'] ) ) {
				echo esc_attr( $_POST['lname'] );
			} ?>" required="required" />
		</p>
		
       <div class="clear"></div>
       <?php
 }
 add_action( 'woocommerce_register_form_start', 'wooc_extra_register_fields' );


 function woocommerce_edit_my_account_page() {
 	//
 	$countries_obj   = new WC_Countries();
    $countries   = $countries_obj->__get('countries');
	$onchange = array(
                'onchange' => 'get_country(this)',
	);
    return apply_filters( 'woocommerce_forms_field', array(
    	'my_country_field' => array(
			'type'        => 'select',
			'class'       => array( 'my_country' ),
			'label'       => __( 'Country', 'my_country' ),
			'placeholder' => __( 'Choose a country', 'my_country' ),
			'options'     => $countries,
			'required'    => true,
			'custom_attributes' => $onchange,
    	),
    ) );

}
function edit_my_account_page_woocommerce() {
    $fields = woocommerce_edit_my_account_page();
    foreach ( $fields as $key => $field_args ) {
        woocommerce_form_field( $key, $field_args );
    }
}
add_action( 'woocommerce_register_form', 'edit_my_account_page_woocommerce', 5 );


add_action( 'user_register', 'user_register_function', 10000,3);
function user_register_function($user_id) {
	//echo $user_id.'-sdfdsfs';
	//$var = get_userdata($user_id);
	wp_update_user([
	    'ID' => $user_id, // this is the ID of the user you want to update.
	    'first_name' => $_POST['fname'],
	    'last_name' => $_POST['lname'],
	]);
	if(isset($_POST['my_country_field'])){
		update_user_meta($user_id, 'country', $_POST['my_country_field']);
		update_user_meta($user_id, 'billing_country', $_POST['my_country_field']);
	}
	
}	

 


//Address Update from My Account
//if(is_page(3534)){
global $current_user;
global $woocommerce;
$mwb_woo_msa_user_save_addresses = array();
$mwb_woo_msa_general_settings = get_option('mwb_woocommerce_multiple_shipping_address_enable_plugin');

$MwbWooMsaObject = new WC_Checkout();

$user_id = $current_user->ID;

if(isset($_POST['mwb_woo_msa_user_data_submit'])){
	if($_POST['form_type']){
	if(wp_verify_nonce($_REQUEST['mwb_woo_msa_nonce'],'mwb-woo-msa-guest-nonce')){

		$MwbWooMsaUserAddess  = $_POST['mwb_woo_msa_user_address'];
		$MwbWooMsaUserAddess2 = $_POST['mwb_woo_msa_user_address2'];
		$MwbWooMsaUserTown    = $_POST['mwb_woo_msa_user_town'];
		$MwbWooMsaUserCountry = $_POST['billing_country'];
		$MwbWooMsaUserState   = $_POST['billing_state'];
		$MwbWooMsaUserPostal  = $_POST['billing_postcode'];

		$MwbWooMsaPostValidateObject = WC_Validation::is_postcode($MwbWooMsaUserPostal,$MwbWooMsaUserCountry);
		
		if( $MwbWooMsaPostValidateObject )
		{

			$mwb_woo_msa_user_save_addresses = get_user_meta($user_id,'mwb_woo_multiple_shipping_addr_saved',true);
			$mwb_woo_msa_user_save_addresses = json_decode($mwb_woo_msa_user_save_addresses,true);

			if(is_array($mwb_woo_msa_user_save_addresses) && !empty($mwb_woo_msa_user_save_addresses)){
				$flag = true;
				$mwb_woo_msa_user_address_data = array(
					'address1'  =>  $MwbWooMsaUserAddess,
					'address2'  =>  $MwbWooMsaUserAddess2,
					'town'      =>  $MwbWooMsaUserTown,
					'country'   =>  $MwbWooMsaUserCountry,
					'state'     =>  $MwbWooMsaUserState,
					'zip'       =>  $MwbWooMsaUserPostal,
					);
				foreach ($mwb_woo_msa_user_save_addresses as $addrkey => $addrvalue) {
					if($addrvalue == $mwb_woo_msa_user_address_data){
						$flag = false;
					}
				}
				
				if($flag){

					array_push($mwb_woo_msa_user_save_addresses, $mwb_woo_msa_user_address_data);
					
					$mwb_woo_msa_user_save_addresses = json_encode($mwb_woo_msa_user_save_addresses);
					update_user_meta($user_id,'mwb_woo_multiple_shipping_addr_saved',$mwb_woo_msa_user_save_addresses);
					$success 	=  __( 'Your Address has been added', 'mwb-woocommerce-multiple-shipping-address' );
					//$success 	=  __( 'Your address has been deleted', 'mwb-woocommerce-multiple-shipping-address' );
					$notice 	= wc_add_notice ( $success, 'success' );
					
					?>
					<?php /*?><div class="woocommerce-message" role="alert">
						<?php echo $success; ?>
					</div><?php */?>
					<?php
				}
				else{
					$success_msg = __('Address Already Exists','mwb-woocommerce-multiple-shipping-address');
					$notice 	= wc_add_notice ( $success_msg,'error' );
					?>
					<?php /*?><div class="woocommerce-error" role="alert">
						<?php echo $success_msg; ?>
					</div><?php */?>
					<?php
				}
			}
			else{
				$mwb_woo_msa_user_address_data[] = array(
					'address1'  =>  $MwbWooMsaUserAddess,
					'address2'  =>  $MwbWooMsaUserAddess2,
					'town'      =>  $MwbWooMsaUserTown,
					'country'   =>  $MwbWooMsaUserCountry,
					'state'     =>  $MwbWooMsaUserState,
					'zip'       =>  $MwbWooMsaUserPostal,
					);

				$mwb_woo_msa_user_address_data = json_encode($mwb_woo_msa_user_address_data);
				update_user_meta($user_id,'mwb_woo_multiple_shipping_addr_saved',$mwb_woo_msa_user_address_data);
				$success 	=  __( 'Your Address has been added', 'mwb-woocommerce-multiple-shipping-address' );
				$notice 	= wc_add_notice ( $success,'success' );
				?>
			<?php /*?>	<div class="woocommerce-message" role="alert">
					<?php echo $success; ?>
				</div><?php */?>
				<?php
			}
		}
		else
		{
			$error 	=  __( 'Please Enter valid Zip Code', 'mwb-woocommerce-multiple-shipping-address' );
			$notice 	= wc_add_notice ( $error ,'error');
			?>
			<?php /*?><div class="woocommerce-error" role="alert">
				<?php echo $error; ?>
			</div><?php */?>
			<?php
			}
		}
	}
}
class Dokan_Setup_Wizard_Override extends Dokan_Seller_Setup_Wizard {

    /**
     * Introduction step.
     */
    public function dokan_setup_introduction() {
        $dashboard_url = dokan_get_navigation_url();
        ?>
        <h1><?php esc_attr_e( 'Welcome to HoPscan Marketplace!', 'dokan-lite' ); ?></h1>
        <p><?php echo wp_kses( __( 'Thank you for choosing HoPscan Marketplace to power your online business! This quick setup wizard will help you configure th basic settings. <strong>I shouldn\'t take longer than two minutes for you to get started.</strong>', 'dokan-lite' ), [ 'strong' => [] ] ); ?></p>
        <p><?php esc_attr_e( 'No time right now? If you don\'t want to go through the wizard, you can skip and return to the store!', 'dokan-lite' ); ?></p>
        <p class="wc-setup-actions step">
            <a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button-primary button button-large button-next lets-go-btn dokan-btn-theme"><?php esc_attr_e( 'Let\'s Go!', 'dokan-lite' ); ?></a>
            <a href="<?php echo esc_url( $dashboard_url ); ?>" class="button button-large not-right-now-btn dokan-btn-theme"><?php esc_attr_e( 'Not right now', 'dokan-lite' ); ?></a>
        </p>
        <?php
        do_action( 'dokan_seller_wizard_introduction', $this );
		
		
    } 
}

new Dokan_Setup_Wizard_Override;

function featured_vender() {

$args = array(
'role' => 'seller',
'order' => 'ASC',
'offset' => 0,
//'include' => $users,
'number' =>100,
);
$sellers = get_users( $args );
$users1 = array();
foreach ( $sellers as $seller ) {
$vendor = dokan()->vendor->get( $seller->ID );
$is_store_featured = $vendor->is_featured();
$location = WC_Geolocation::geolocate_ip();
$currentcountry = $location['country'];
if($is_store_featured)
{
	$user_con = get_user_meta($seller->ID, 'dokan_profile_settings', true);
	if($user_con['address']['country'] == $currentcountry){
		$users1[]=$seller->ID;
	}
}
}	

	
    $args = array(
        'role'    => 'seller',
        'order'   => 'ASC',
        'offset'   => 0,
        'include' =>$users1,
        'number'  => 8,
    );
    $sellers = get_users( $args );
	
	
	
    $html .='<div id="dokan-seller-listing-wrap" class="grid-view">
                <div class="seller-listing-content">
				<ul id="home_seller_slider" class="dokan-seller-wrap">';
    foreach ( $sellers  as $seller ) {
		
		
		
         ob_start();
         $vendor            = dokan()->vendor->get( $seller->ID );
		 $store_cat = wp_get_object_terms( $seller->ID, 'store_category' );
		
        $store_banner_id   = $vendor->get_banner_id();
        $store_name        = $vendor->get_shop_name();
        $store_url         = $vendor->get_shop_url();
        $store_rating      = $vendor->get_rating();
        $store_phone       = $vendor->get_phone();
        $store_info        = dokan_get_store_info( $seller->ID );
        $store_address     = dokan_get_seller_short_address( $seller->ID );
        $store_banner_url  = $store_banner_id ? wp_get_attachment_image_src( $store_banner_id, $image_size ) : DOKAN_PLUGIN_ASSEST . '/images/default-store-banner.png';
        $is_store_featured = $vendor->is_featured();
        if(is_array( $store_banner_url )){
            $store_banner_url = $store_banner_url[0];
        }
        else {
            $store_banner_url = $store_banner_url; 
        }
        if($is_store_featured=="1"){
			
            $html .='<li class="slick-slide dokan-single-seller woocommerce coloum-31 ">';
                         $html .='<div class="store-wrapper">
                            <div class="store-header">
                                <div class="store-banner">
                                    <a href="'.$store_url .'">
                                        <img src="'.$store_banner_url.'">
                                    </a>
                                    <a class="home_wrapper_link" href="'.$store_url .'">
                                    </a>
                                </div>
                            </div>
                             <div class="store-content ">
                                <div class="store-data-container">
                                    <div class="featured-favourite">';
                                     if ( $is_store_featured ) {
                                      $html .='<div class="featured-label">Featured</div>';
                                      }
                                     $html .='</div>
                                     <div class="store-data">
                                        <h2><a href="'.esc_attr( $store_url ).'">'.esc_html( $store_name ).'</a></h2>';
                                       if ( !empty( $store_rating['count'] ) ){
                                             $html .='<div class="dokan-seller-rating" title="'. sprintf( esc_attr__( 'Rated %s out of 5', 'dokan-lite' ), esc_attr( $store_rating['rating'] ) ).'">
                                                '.wp_kses_post( dokan_generate_ratings( $store_rating['rating'], 5 ) ).'
                                                <p class="rating">
                                                    '.esc_html( sprintf( __( '%s out of 5', 'dokan-lite' ), $store_rating['rating'] ) ).'
                                                </p>
                                            </div>';
                                        }
                                        if ( ! dokan_is_vendor_info_hidden( 'address' ) && $store_address ){
                                             $allowed_tags = array(
                                                    'span' => array(
                                                        'class' => array(),
                                                    ),
                                                    'br' => array()
                                                );
                                        
                              $html .='<p class="store-address">'.wp_kses( $store_address, $allowed_tags ).'</p>';
                          }
                          if ( ! dokan_is_vendor_info_hidden( 'phone' ) && $store_phone ) {
                               $html .='<p class="store-phone"><i class="fa fa-phone" aria-hidden="true"></i>'.esc_html( $store_phone ).'</p>';
                          }
                                    $html .=' </div>
                                </div>
                            </div>
                             <div class="store-footer">
                                <div class="seller-avatar">
                                    '.get_avatar( $seller->ID, 150 ).'                                </div>
                                <a href="'.esc_url( $store_url ).'" title="'.esc_attr_e( 'Visit Store', 'dokan-lite' ).'">
                                 <span class="dashicons dashicons-arrow-right-alt2 dokan-btn-theme dokan-btn-round"></span>
                                    
                                </a>'; 
                    $html .='</div>
                        </div>
                    </li>';          
                    }
                    ob_end_clean();
                    }
            $html .='
                </ul></div></div>';

	//echo 'No seller found your area see here <a href="'.get_the_permalink(4043).'">All Store</a>';


return $html;
}
add_shortcode('vender_featured','featured_vender');

function featured_vender_withcat($attbs) {
	
 	$location = WC_Geolocation::geolocate_ip();
	$currentcountry = $location['country'];
	
	
$args = array(
'role' => 'seller',
'order' => 'ASC',
'offset' => 0,
//'include' => $users,
'number' =>100,
);
$sellers = get_users( $args );
$users1 = array();
foreach ( $sellers as $seller ) {
$vendor = dokan()->vendor->get( $seller->ID );

$location = WC_Geolocation::geolocate_ip();
$currentcountry = $location['country'];

$user_con = get_user_meta($seller->ID, 'dokan_profile_settings', true);
if($user_con['address']['country'] == $currentcountry){
	$users1[]=$seller->ID;
}

}
	
	
	
  $args = array(
        'role'    => 'seller',
        'order'   => 'ASC',
        'offset'   => 0,
        'include' =>$users1,
        'number'  => 10,
    );
    $sellers = get_users( $args );
    $html .='<div id="dokan-seller-listing-wrap" class="grid-view">
                <div class="seller-listing-content">
				<ul class="dokan-seller-wrap seller_slider_cat">';
    foreach ( $sellers  as $seller ) {
		
		$user_con = get_user_meta($seller->ID, 'dokan_profile_settings', true);
		
         ob_start();
         $vendor            = dokan()->vendor->get( $seller->ID );
		 $dokan_settings = dokan_get_store_info($seller->ID);
		 $primary_cat = $dokan_settings['pm_cat'];
		 $store_cat = wp_get_object_terms( $seller->ID, 'store_category' );
		 
        $store_banner_id   = $vendor->get_banner_id();
        $store_name        = $vendor->get_shop_name();
        $store_url         = $vendor->get_shop_url();
        $store_rating      = $vendor->get_rating();
        $store_phone       = $vendor->get_phone();
        $store_info        = dokan_get_store_info( $seller->ID );
        $store_address     = dokan_get_seller_short_address( $seller->ID );
        $store_banner_url  = $store_banner_id ? wp_get_attachment_image_src( $store_banner_id, $image_size ) : DOKAN_PLUGIN_ASSEST . '/images/default-store-banner.png';
        $is_store_featured = $vendor->is_featured();
        if(is_array( $store_banner_url )){
            $store_banner_url = $store_banner_url[0];
        }
        else {
            $store_banner_url = $store_banner_url; 
        }
		//&& $primary_cat == $attbs['cat']
       if(in_array_r($attbs['cat'], $store_cat) && $primary_cat == $attbs['cat']){
            $html .='<li class="slick-slide dokan-single-seller woocommerce coloum-31 ">';
                         $html .='<div class="store-wrapper">
                            <div class="store-header">
                                <div class="store-banner">
                                    <a href="'.$store_url .'">
                                        <img src="'.$store_banner_url.'">
                                    </a>
                                    <a class="home_wrapper_link" href="'.$store_url .'">
                                    </a>
                                </div>
                            </div>
                             <div class="store-content ">
                                <div class="store-data-container">
                                    <div class="featured-favourite">';
                                     if ( $is_store_featured ) {
                                      $html .='<div class="featured-label">Featured</div>';
                                      }
                                     $html .='</div>
                                     <div class="store-data">
                                        <h2><a href="'.esc_attr( $store_url ).'">'.esc_html( $store_name ).'</a></h2>';
                                       if ( !empty( $store_rating['count'] ) ){
                                             $html .='<div class="dokan-seller-rating" title="'. sprintf( esc_attr__( 'Rated %s out of 5', 'dokan-lite' ), esc_attr( $store_rating['rating'] ) ).'">
                                                '.wp_kses_post( dokan_generate_ratings( $store_rating['rating'], 5 ) ).'
                                                <p class="rating">
                                                    '.esc_html( sprintf( __( '%s out of 5', 'dokan-lite' ), $store_rating['rating'] ) ).'
                                                </p>
                                            </div>';
                                        }
                                        if ( ! dokan_is_vendor_info_hidden( 'address' ) && $store_address ){
                                             $allowed_tags = array(
                                                    'span' => array(
                                                        'class' => array(),
                                                    ),
                                                    'br' => array()
                                                );
                                        
                              $html .='<p class="store-address">'.wp_kses( $store_address, $allowed_tags ).'</p>';
                          }
                          if ( ! dokan_is_vendor_info_hidden( 'phone' ) && $store_phone ) {
                               $html .='<p class="store-phone"><i class="fa fa-phone" aria-hidden="true"></i>'.esc_html( $store_phone ).'</p>';
                          }
                                    $html .=' </div>
                                </div>
                            </div>
                             <div class="store-footer">
                                <div class="seller-avatar">
                                    '.get_avatar( $seller->ID, 150 ).'                                </div>
                                <a href="'.esc_url( $store_url ).'" title="'.esc_attr_e( 'Visit Store', 'dokan-lite' ).'">
                                 <span class="dashicons dashicons-arrow-right-alt2 dokan-btn-theme dokan-btn-round"></span>
                                    
                                </a>'; 
                    $html .='</div>
                        </div>
                    </li>';          
                   }
                    ob_end_clean();
                    }
            $html .='
                </ul></div></div>';

	//echo 'No seller found your area see here <a href="'.get_the_permalink(4043).'">All Store</a>';


return  $html;
}
add_shortcode('store_withcats','featured_vender_withcat');

function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $key => $item) {
		
        if (($strict ? $item->name === $needle : $item->name == $needle) || (is_array($item->name) && in_array_r($needle, $item->name, $strict))) {
            return true;
        }
    }

    return false;
}
add_filter('use_block_editor_for_post', '__return_false', 10);



//add_action('shutdown', 'shutdown_test_function');
function shutdown_test_function(){


$userdt = get_user_meta(122, 'ddwc_driver_picture', true);
echo '<pre>';
print_r($userdt);
echo '</pre>';

}


function bbloomer_use_geolocated_user_country(){
 
		
// echo '<pre>';
// print_r($user_con);
// echo '</pre>'; 
// $args = array(
//     'role'    => 'customer',
//     'order'   => 'ASC'
// );
// $users = get_users( $args );


// foreach ( $users as $user ) {

	$usermeta = get_user_meta(207,'ddwc_driver_picture',true);

	// if (empty($usermeta)) {
		// update_user_meta($user->ID,'selected_role','customer');
	echo "<pre>";
	print_r(wp_get_attachment_url($usermeta));
	echo "</pre>";
	// }

// }

//$user_con['address']['country']

//wpuf_user_status
}
 
// add_action( 'shutdown', 'bbloomer_use_geolocated_user_country' );

function shop_page_redirect_home() {

    if( is_shop() && WC()->cart->is_empty()){
        wp_redirect( home_url() );
    }
}
add_action( 'template_redirect', 'shop_page_redirect_home' );


// Function to change email address
function wpb_sender_email_hopscan( $original_email_address ) {
    return 'aimable.karangwa@gmail.com';
} 
// Function to change sender name
function wpb_sender_name_hopscan( $original_email_from ) {
    return 'HoPsCan';
}
// Hooking up our functions to WordPress filters 
add_filter( 'wp_mail_from', 'wpb_sender_email_hopscan' );
add_filter( 'wp_mail_from_name', 'wpb_sender_name_hopscan' );

function wooc_save_extra_register_fields_role( $customer_id ) {
    if ( isset( $_POST['selected_role'] ) ) {
                 // Phone input filed which is used in WooCommerce
                 update_user_meta( $customer_id, 'selected_role', sanitize_text_field( $_POST['selected_role'] ) );
        }
}
add_action( 'woocommerce_created_customer', 'wooc_save_extra_register_fields_role' );


// function insert_attachment_driver_images($file_handler, $user_id, $setthumb=false) {
//     // check to make sure its a successful upload

// 	echo "<pre>";
// 	print_r($file_handler);
// 	echo "</pre>";

//     // changes start
//     if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) {
//         return __return_false();
//     }
//     // changes end

//     require_once(ABSPATH . "wp-admin" . '/includes/image.php');
//     require_once(ABSPATH . "wp-admin" . '/includes/file.php');
//     require_once(ABSPATH . "wp-admin" . '/includes/media.php');

//     $attach_id = media_handle_upload( $file_handler, $post_id );

//     if ($setthumb)
//         update_post_meta($post_id, '_thumbnail_id', $attach_id);
//     return $attach_id;
// }


add_action('wp_enqueue_scripts', 'images_driver_uploaded');
function images_driver_uploaded()
{
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_enqueue_script('driver-images-upload-js', get_stylesheet_directory_uri(). '/assets/js/upload.js');
}

if( ! function_exists( 'yith_wcwl_disable_title_editing' ) ){
	function yith_wcwl_disable_title_editing( $params ) {
		$params['can_user_edit_title'] = false;

		return $params;
	}
	add_filter( 'yith_wcwl_wishlist_params', 'yith_wcwl_disable_title_editing' );
}

function add_custom_css_on_head(){
	if ($_GET['page'] == 'dokan-seller-setup') {
			
		?>
		<style>
			.select2-container--open .select2-dropdown {
			    left: 20px;
			}
		</style>
		<?php

	}
}
add_action('wp_head','add_custom_css_on_head');


function is_user_vendor_redirect(){

$current_user_role = wp_get_current_user()->roles;
$current_url = site_url().''.$_SERVER['REQUEST_URI'];
$check_url = site_url().'/my-account/account-migration/'; 


if ($current_user_role[0] == 'seller' && $current_url == site_url().'/my-account/account-migration/') {

	wp_redirect(site_url().'/dashboard/');
}

}
add_action('init','is_user_vendor_redirect');


function logout_user_register_form(){

	if (!is_user_logged_in()) {
		?>
		<div class="col-xs-12 col-sm-12 col-md-7 col-form-register">

	<div class="woocommerce-form-register-toggle">

		<!-- <?php wc_print_notice( apply_filters( 'woocommerce_checkout_login_message', esc_html__( 'New customer?', 'martfury' ) ) . ' <a href="#" class="showregister">' . esc_html__( 'Create a new account', 'martfury' ) . '</a>', 'notice' ); ?> -->
		<div class="woocommerce-info">
		New customer? <a href="javascript:void(0)" class="showregister">Create a new account</a>	</div>
	</div>

						<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>
                        <!-- <div  class="tabs-panel checkout_register_form<?php echo esc_attr( $register_class ); ?>"> -->

                           <form style="display: none;" method="post" class="checkout_register_form register woocommerce-form woocommerce-form-register">
                               <h3 id="order_review_headinggg">Register To Proceed</h3>
								<p>If you are a new customer, please enter your details in the boxes below.</p>
                                <div style="clear:both; padding-top: 10px;"></div>

                                
								<?php do_action( 'woocommerce_register_form_start' ); ?>

                <input type="hidden" id="selected_role" name="selected_role" value="customer" />

								<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

                                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                        <input type="text" required 
                                               class="woocommerce-Input woocommerce-Input--text input-text"
                                               placeholder="<?php esc_attr_e( 'Username', 'martfury' ); ?>"
                                               name="username" id="reg_username" autocomplete="username"
                                               value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( $_POST['username'] ) : ''; ?>"/>
                                    </p>

								<?php endif; ?>

                                <p class="form-row form-group">
                                  <label for="reg_email"><?php esc_html_e( 'Email address', 'martfury' ); ?>
                                    <span class="required">*</span>
                                  </label>
                                  <input type="email" required class="woocommerce-Input woocommerce-Input--text input-text" placeholder="<?php esc_attr_e( 'Email address', 'martfury' ); ?>" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( $_POST['email'] ) : ''; ?>"/>
                                </p>

                                <p class="form-row form-group confirm_email_address_user">
                                  <label for="confirm_email"><?php esc_html_e( 'Confirm Email address', 'martfury' ); ?>
                                    <span class="required">*</span>
                                  </label>
                                  <input type="email" required class="woocommerce-Input woocommerce-Input--text input-text" placeholder="<?php esc_attr_e( 'Confirm Email address', 'martfury' ); ?>" name="confirm_email" id="confirm_email" autocomplete="confirm_email" value="<?php echo ( ! empty( $_POST['confirm_email'] ) ) ? esc_attr( $_POST['confirm_email'] ) : ''; ?>"/>
                                </p>

								<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

                                <p class="form-row form-group">
                                  <label for="password"><?php esc_html_e( 'Password', 'martfury' ); ?>
                                    <span class="required">*</span>
                                  </label>
                                  <input type="password" required
                                               placeholder="<?php esc_attr_e( 'Password', 'martfury' ); ?>"
                                               class="woocommerce-Input woocommerce-Input--text input-text"
                                               autocomplete="new-password"
                                               name="password" id="reg_password"/>
                                </p>

								<?php else : ?>

                                    <p><?php esc_html_e( 'A password will be sent to your email address.', 'martfury' ); ?></p>

								<?php endif; ?>

                

                

								<?php do_action( 'woocommerce_register_form' ); ?>
                  
                  
                   <p class="form-row form-group term_cond">
                     
                      <label for="question1"><!--<input type="checkbox" id="cus_termcon" name="cus_termcon" value="cus_termcon" required>--> 
                      By registering you accept HoPscan's <a href="<?php echo home_url(); ?>/term-conditions/" target="_blank"> Terms and Conditions</a> and <a href="<?php echo home_url(); ?>/policy/" target="_blank">Privacy Policy</a> and allow HoPscan to contact you and send you marketing communications using the contact details you have provided to us.</label>
                  </p>
					


                                <p class="woocommerce-form-row form-row register_sub">
									<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                                    <button type="submit" class="woocommerce-Button button cus_wc_regiester" name="register"
                                            value="<?php esc_attr_e( 'Register', 'martfury' ); ?>"><?php esc_html_e( 'Register', 'martfury' ); ?></button>
                                       
                                </p>
<p style="clear:both;"></p>
								<?php do_action( 'woocommerce_register_form_end' ); ?>

                            </form>
                        <!-- </div> -->
					<?php endif; ?>
</div>
		<?php		
		// do_action( 'woocommerce_register_form' );
	}
}
add_action( 'woocommerce_before_checkout_form', 'logout_user_register_form' );

add_filter( 'woocommerce_account_menu_items', 'custom_my_account_menu_items', 50 );
function custom_my_account_menu_items($items) {
    $items['rma-requests'] = __("Return request", "dokan");
    return $items;
}

add_filter( 'woocommerce_valid_order_statuses_for_cancel', 'custom_valid_order_statuses_for_cancel', 10, 2 );
function custom_valid_order_statuses_for_cancel( $statuses, $order ){

    // Set HERE the order statuses where you want the cancel button to appear
    $custom_statuses    = array('driver-assigned', 'pending', 'processing', 'on-hold', 'failed' );

    // Set HERE the delay (in days)
    $duration = 90; // 90 days

    // UPDATE: Get the order ID and the WC_Order object
    if( isset($_GET['order_id']))
        $order = wc_get_order( absint( $_GET['order_id'] ) );

    $delay = $duration*24*60*60; // (duration in seconds)
    $date_created_time  = strtotime($order->get_date_created()); // Creation date time stamp
    $date_modified_time = strtotime($order->get_date_modified()); // Modified date time stamp
    $now = strtotime("now"); // Now  time stamp

    // Using Creation date time stamp
    if ( ( $date_created_time + $delay ) >= $now ) return $custom_statuses;
    else return $statuses;
}

add_action( 'woocommerce_after_order_notes', 'custom_checkout_script', 9999 );
function custom_checkout_script() {
    ?>
    <script type="text/javascript">
        (function($){

            $( 'form.checkout' ).on( 'change', '#shipping_country', function() {

                var location = $('#shipping_country option:selected').val();

                if( location == 'RW' ) {

                    $('input#shipping_postcode').val('00000');
                    $('input#shipping_postcode').attr('readonly','readonly');
	
                    

                }else{

                    $('input#shipping_postcode').val('');
                    $('input#shipping_postcode').removeAttr('readonly');

                    

                }
            });



             $( 'form.checkout' ).on( 'change', '#billing_country', function() {
                var location_billing = $('#billing_country option:selected').val();
                if( location_billing == 'RW' ) {
                    $('input#billing_postcode').val('000000');
                    $('input#billing_postcode').attr('readonly','readonly');
                    $('#shipping_postcode_field').hide();
        			//$('#billing_postcode_field').css('display','none');
                } else if( location_billing != 'RW' && $('input#billing_postcode').val() == '00000' ) {
        			//$('#billing_postcode_field').css('display','block');
                    $('input#billing_postcode').val('');
                    $('#shipping_postcode_field').show();
                }
            });
        })(jQuery);
        </script>
    <?php
}

function checkout_shipping_recepient_id(){
	$recipient_id = $_REQUEST['recipient_id'];
 
 	if ($recipient_id && get_current_user_id()) {
 		update_user_meta(get_current_user_id(),'last_order_recipient_id',$recipient_id);
 		echo "success";
 	}else{
 		update_user_meta(get_current_user_id(),'last_order_recipient_id','');
 		echo "unsuccess";

 	}

	//exit;
}
add_action("wp_ajax_checkout_shipping_recepient_id", "checkout_shipping_recepient_id");
add_action("wp_ajax_nopriv_checkout_shipping_recepient_id", "checkout_shipping_recepient_id");


// Remove billing form fields from checkout and form //

add_filter( 'woocommerce_checkout_fields', 'checkout_billing_state_field' );
add_filter( 'woocommerce_billing_fields', 'checkout_billing_state_field' );

function checkout_billing_state_field( $checkout_fields ) {

	   unset($checkout_fields['billing']['billing_company']);

	   unset($checkout_fields['billing']['billing_first_name']);

	   unset($checkout_fields['billing']['billing_last_name']);

       unset($checkout_fields['billing']['billing_address_1']);

       unset($checkout_fields['billing']['billing_address_2']);

       unset($checkout_fields['billing']['billing_city']);

       unset($checkout_fields['billing']['billing_postcode']);

       unset($checkout_fields['billing']['billing_country']);

       unset($checkout_fields['billing']['billing_state']);

       //unset($checkout_fields['billing']['billing_phone']);
 
       unset($checkout_fields['billing']['billing_email']);

       //unset($checkout_fields['billing']['billing_phone_code_field']);

       unset($checkout_fields['billing']['sector_fields_1']);

       unset($checkout_fields['billing']['district_fields_1']); 

       unset($checkout_fields['billing']['province_fields_1']);

       unset($checkout_fields['billing']['full_address_for_rwanda']);
       
       //unset($checkout_fields['shipping']['shipping_city']); 
       //unset($checkout_fields['shipping']['shipping_state']);
       
      // unset($checkout_fields['shipping']['shipping_phone']);

       //unset($checkout_fields['shipping']['shipping_phone_code_field']);

	return $checkout_fields;
}

// Change order reviewe page title //

function change_order_review_page_title( $title, $id ) {
	if ( is_order_received_page() && get_the_ID() === $id ) {
		$title = "Thank you for shopping with us";
	}

	return $title;
}

add_filter( 'the_title', 'change_order_review_page_title', 10, 2 );

// function to get  the address
function get_lat_long($address){

    $address = str_replace(" ", "+", $address);
    $region = '';
    $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=Rwanda&key=AIzaSyAxgDaX1gpSApyPJwNLYIKmNO0enbwSjIU");
    $json = json_decode($json);

    $location['lat'] = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
    $location['long'] = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};


    return $location;
}

// get distance by address 

function get_distance_by_address(){

	global $woocommerce;

	$address = $_REQUEST['shipping_address_1'];
	$address .= ' '.$_REQUEST['shipping_state'];
	$shipping_country = $_REQUEST['shipping_country'];

	foreach( WC()->cart->get_cart() as $cart_item ){

	    $product_id = $cart_item['product_id'];
	}

	$vendor_id = get_post_field( 'post_author', $product_id );

	$dokan_profile_settings = get_user_meta($vendor_id,'dokan_profile_settings',true)['location'];

	$location = explode(',', $dokan_profile_settings);

	$unit = 'M';

	$lat1 = $location[0];
	$lon1 = $location[1];


	$address = str_replace(" ", "+", $address);
    $region = '';
    $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=Rwanda&key=AIzaSyAxgDaX1gpSApyPJwNLYIKmNO0enbwSjIU");
    $json = json_decode($json);

    $lat2 = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
    $lon2 = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};



	if (($lat1 == $lat2) && ($lon1 == $lon2)) {
		echo 0;
	}else{

		$theta = $lon1 - $lon2;
		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		$dist = acos($dist);
		$dist = rad2deg($dist);
		$miles = $dist * 60 * 1.1515;
		$unit = strtoupper($unit);

		if ($unit == "K") {
		  $distance = $miles * 1.609344;
		} else if ($unit == "N") {
		  $distance = $miles * 0.8684;
		} else {
		  $distance = $miles;
		}
	}

	$distance = number_format($distance, 1, '.', '');

	$dokan_settings = get_user_meta( $vendor_id, 'dokan_profile_settings', true );
	
	$cost_per_dis = $dokan_settings['cost_per_dis'];

	$distance_rate = $distance*$cost_per_dis;

	if (!empty($distance) && !empty($distance_rate) && $shipping_country == 'RW') {

		// update_user_meta(get_current_user_id() ,'select_checkout_shipping_address',$country);	
		// update_user_meta(get_current_user_id() ,'distance_rate', $distance_rate);	
		// update_user_meta(get_current_user_id() ,'distance', $distance);	

		echo json_encode(array('distance'=> $distance, 'distance_rate'=> $distance_rate));
	
	}else{

		echo '';
	}





//	exit;


}
add_action('wp_ajax_get_distance_by_address','get_distance_by_address');
add_action('wp_ajax_get_distance_by_address','get_distance_by_address');


add_filter( 'woocommerce_billing_fields', 'custom_shipping_fields_checkout' );
add_filter( 'woocommerce_shipping_fields', 'custom_shipping_fields_checkout' );
// add_filter( 'woocommerce_checkout_fields', 'custom_shipping_fields_checkout' );
 
function custom_shipping_fields_checkout( $fields ) {

	$fields['full_address_for_rwanda'] = array(
        'label'     => __('Enter full address(Enter Sector, followed by District name)', 'woocommerce'),
	    'placeholder'   => _x('Enter full address', 'placeholder', 'woocommerce'),
	    'required'  => false,
		'class'        => array('form-row-wide','select2','address-field','validate-state' ),
		'priority'     => 80,
	    'clear'     => true,
	    'type'      => 'text',//end of options
	     );
 
	return $fields;
 
}

// Remove postcode required for rwanda

add_action( 'woocommerce_checkout_order_processed', 'remove_postcode_for_rwanda',10,1);
 
function remove_postcode_for_rwanda( $order_id ) {
   	
	$shipping_country = get_post_meta($order_id,'_shipping_country',true);

	if ($shipping_country == 'RW') {

		update_post_meta($order_id,'_shipping_postcode','');
		update_post_meta($order_id,'_shipping_city','');
		update_post_meta($order_id,'_shipping_state','');

	}
  	 
}

// Select option value for Rwanda 

function select_option_dropdown(){

	$rwanda_address['address'] = array(
								'kigali' => array('Kicukiro' => array('Kagarama','Niboye','Gatenga','Gikondo','Gahanga','Kanombe','Nyarugunga','Kigarama','Masaka'),

												  'Gasabo'=> array('Bumbogo','Gatsata','Jali','Gikomero','Gisozi','Jabana','Kinyinya','Ndera','Nduba','Rusororo','Rutunga','Kacyiru','Kimihurura','Kimironko','Remera',),

												  'Nyarugenge'=> array('Gitega','Kanyinya','Kigali','Kimisagara','Mageragere','Muhima','Nyakabanda','Nyamirambo','Nyarugenge','Rwezamenyo',),
												),
								'Northern Province' => array('Burera' => array('Bungwe','Butaro'),
												),
							);

	return $rwanda_address;

}
add_action('init','select_option_dropdown');

function district_fields_value(){

	$province = $_REQUEST['province'];

	$address_fields = select_option_dropdown();

	foreach ($address_fields['address'] as $districts => $district) {
		if ($districts == $province) {

			$html = '<option value="">Select District</option>';

			foreach ($district as $key => $value) { 


			if ($key) {

					$html .= '<option value="'.$key.'">'.$key.'</option>';

				}
			}

		}
	}

	echo json_encode(array('html'=>$html,'province'=>$province));

	//exit;


}


add_action("wp_ajax_district_fields_value", "district_fields_value",20);
add_action("wp_ajax_nopriv_district_fields_value", "district_fields_value",20);


function sector_fields_value(){

	$province = $_REQUEST['province'];
	$district = $_REQUEST['district'];

	$address_fields = select_option_dropdown();

	foreach ($address_fields['address'] as $sectors => $sector) {
		if ($sectors == $province) {

			foreach ($sector as $key => $value) { 

				if ($key == $district) {
							
					$html = '<option value="">Select Sector</option>';
					
					foreach ($value as $key => $val) {


						if ($val) {

							$html .= '<option value="'.$val.'">'.$val.'</option>';

						}
						
					}
					
				}

			}

		}
	}

	echo json_encode(array('html'=>$html,'province'=>$province,'district'=>$district));

	//exit;


}
add_action("wp_ajax_sector_fields_value", "sector_fields_value",20);
add_action("wp_ajax_nopriv_sector_fields_value", "sector_fields_value",20);




function get_google_sugg_fields(){

?>
<script>

var autocomplete;


function initAutocomplete() {
    
 autocomplete = new google.maps.places.Autocomplete(document.getElementById('full_address_for_rwanda'), {types: ['geocode']});
  
//   new google.maps.places.Autocomplete(
    //   /** @type {!HTMLInputElement} */(),
    //   {types: ['geocode']});
  autocomplete.setComponentRestrictions( {'country': 'rw'});
  autocomplete.addListener('place_changed', fillInAddress);
  
}

function fillInAddress() {
  var place = autocomplete.getPlace();
console.log(place.formatted_address);
    localStorage.setItem("address", place.formatted_address);
jQuery('#full_address_for_rwanda').val(place.formatted_address)
  var address = '';
  
  for (var i = 0; i < place.address_components.length; i++) {
    var addressType = place.address_components[i].types[0];
    switch (addressType){
      case 'subpremise':
        address = place.address_components[i]['short_name'] + '/' + address;
      break;
      case 'street_number':
        address = address + place.address_components[i]['short_name'] + ' ';
      break;
      case 'route':
        address += place.address_components[i]['long_name'];
      break;
      case 'locality':
        jQuery('#shipping_city').val(place.address_components[i]['long_name']);
        jQuery('#billing_city').val(place.address_components[i]['long_name']);
      case 'administrative_area_level_1':
        jQuery('#shipping_state').val(place.address_components[i]['short_name']);
        jQuery('#billing_state').val(place.address_components[i]['short_name']);
      break;
    }
  }
 
  var full_address_for_rwanda = jQuery("#full_address_for_rwanda").val();
//   var full_address_for_rwanda = document.getElementById('full_address_for_rwanda').value 
//   document.getElementById('shipping_address_1').value = full_address_for_rwanda
  jQuery('#billing_address_1').val(full_address_for_rwanda);
  //jQuery('#shipping_address_1').val(place.formatted_address);
 
 
} 

// jQuery("#full_address_for_rwanda").keypress(function(){
//   if (navigator.geolocation) {
//     navigator.geolocation.getCurrentPosition(function(position) {
//       var geolocation = {
//         lat: position.coords.latitude,
//         lng: position.coords.longitude
//       };
//       var circle = new google.maps.Circle({
//         center: geolocation,
//         radius: position.coords.accuracy
//       });
//       autocomplete.setBounds(circle.getBounds());
//     });
//   }
// });	
function initAutocompletess()
{
    setTimeout(function(){ initAutocomplete(); }, 3000);
}
</script> 


<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAxgDaX1gpSApyPJwNLYIKmNO0enbwSjIU&libraries=places&callback=initAutocomplete"></script>

<?php

}
add_action('wp_footer','get_google_sugg_fields');


add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
add_filter( 'woocommerce_billing_fields' , 'custom_override_billing_fields' );

function custom_override_checkout_fields( $fields ) {
  unset($fields['billing']['billing_postcode']);
  unset($fields['billing']['billing_state']);
  unset($fields['billing']['billing_city']);
  return $fields;
}

function custom_override_billing_fields( $fields ) {
  unset($fields['billing_postcode']);
  unset($fields['billing_state']);
  unset($fields['billing_city']);
  //unset($fields['full_address_for_rwanda']);
  return $fields;
}




function flat_shipping_method_init() {
    if ( ! class_exists( 'WC_Your_Shipping_Method' ) ) {
        
        class WC_flat_Shipping_Method extends WC_Shipping_Method {

            private $user_address = '';
            /*----------------------------------------------------------------
                    Constructor for your shipping class 
            ----------------------------------------------------------------*/
            public function __construct() {
                $this->id                 = 'flat_shipping_method'; // Id for your shipping method. Should be uunique.
                $this->method_title       = __( 'flat Shipping Method' );  // Title shown in admin
                $this->method_description = __( 'Description of flat shipping method' ); // Description shown in admin

                $this->enabled            = "yes"; // This can be added as an setting but for this example its forced enabled
                $this->title              = "My Shipping Method"; // This can be added as an setting but for this example its forced.
                $this->user_address = $_SESSION['user_address_checkout'];
                $this->init();
            }

            /*----------------------------------------------------------------
                Init your settings
            ----------------------------------------------------------------*/
            function init() {
                // Load the settings API
                $this->init_form_fields(); // This is part of the settings API. Override the method to add your own settings
                $this->init_settings(); // This is part of the settings API. Loads settings you previously init.

                // Save settings in admin if you have any defined
                add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
            }

            /*----------------------------------------------------------------
                calculate_shipping function.
            ----------------------------------------------------------------*/

            public function calculate_shipping( $package ) {
                global $woocommerce;
                global $product;
                
                $carttotal = 5;
                
                foreach( WC()->cart->get_cart() as $cart_item ){
                    $product_id = $cart_item['product_id'];
                    $post_obj    = get_post( $cart_item['product_id'] ); // The WP_Post object
                    $post_author = $post_obj->post_author; // <=== The post author ID
                }
                

                $vendor = new WP_User($post_author);
            
                $address     = $vendor->billing_address_1;

                $store_info  = dokan_get_store_info( $post_author ); // Get the store data
                $store_named1  = $store_info['address']['street_1'];
                $store_named2  = $store_info['address']['city'];
               
                $explode_address_vendor = explode(',',$store_named1);
                
                $explode_address_vendor = array_map('trim',$explode_address_vendor);
                
                $explode_address_vendor = array_map(function($el){
                    return sprintf("'%s'",$el); 
                },$explode_address_vendor);
                
                $explode_address_vendor1 = implode(',',$explode_address_vendor);
                
                
                
                parse_str($_POST['post_data'],$result);
                
                $address_user = $result['full_address_for_rwanda'];
                
                $explode_address_user = explode(',',$address_user);
                
                $explode_address_user = array_map('trim',$explode_address_user);
                
                $explode_address_user = array_map(function($el){
                    return sprintf("'%s'",$el);  
                },$explode_address_user);
                
                $explode_address_user1 = implode(',',$explode_address_user);
                
  
                global $wpdb;
                
                //$resultsss = $wpdb->get_results("SELECT *  FROM sectors as usectors INNER JOIN sectors as vsectors ON usectors.rw_sector = vsectors.rw_sector  WHERE usectors.rw_sector IN ($explode_address_user1) AND vsectors.rw_sector IN ($explode_address_vendor1)",'ARRAY_A'); 
                
                //print_r($resultsss);
                //die;
               
    
                /*
                if($carttotal > 20){
                    $cost = 54;//Free delivery for above 20 packs
                }else if($carttotal >= 16 && $carttotal <= 20){
                    $cost = 20000;
                }else if($carttotal >= 11 && $carttotal <= 15){
                    $cost = 15000;
                }else if($carttotal >= 6 && $carttotal <= 10){
                    $cost = 10000;
                }else if($carttotal <= 5 && $carttotal >= 1){
                    $cost = 5000;
                }*/ 
                
                $new_cost  = get_field('flat_fee_rate', 'option');
                
                $rate = array(
                    'id' => $this->id,
                    'label' => 'Home Delivery(Flat Rate)',
                    'cost' => $new_cost,
                );
                
                $shipping_methods = WC()->shipping->get_shipping_methods();
                //print_r($shipping_methods);
                //die;
                //$store_named1  $address_user
                if($store_named1 == $address_user){
                // Register the rate
                $this->add_rate( $rate );
                }
                /*
                if(!empty($resultsss)){
                // Register the rate
                $this->add_rate( $rate );
                }*/
    
            } 
        }
    }
}

add_action( 'woocommerce_shipping_init', 'flat_shipping_method_init' );

function add_flat_shipping_method( $methods ) {
    $methods['flat_shipping_method'] = 'WC_flat_Shipping_Method';
    return $methods;
}

add_filter( 'woocommerce_shipping_methods', 'add_flat_shipping_method' );

function add_flat_shipping_methods($rates){
    if(in_array('flat_shipping_method',array_keys($rates))){
        unset( $rates['distance_rate:11'] );
    }
    return $rates;
}
add_filter('woocommerce_package_rates','add_flat_shipping_methods',1000);
/*
function user_address_from_rw()
{
    $address = $_POST['address'];
    $_SESSION['user_address_checkout'] = $addresss;
    // echo 'helo';die;
    echo wp_send_json($_POST);
}
add_action( 'wp_ajax_user_address_from_rw', 'user_address_from_rw'); // we admin
add_action( 'wp_ajax_nopriv_user_address_from_rw', 'user_address_from_rw'); // we will for frontend
*/


if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Theme General Settings',
		'menu_title'	=> 'Theme Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
	
} 

/*
add_filter( 'dokan_query_var_filter', 'dokan_load_guide_menu' );
function dokan_load_guide_menu( $query_vars ) {
$query_vars['guide'] = 'guide';
return $query_vars; 
}

add_filter( 'dokan_get_dashboard_nav', 'dokan_add_guide_menu' );
function dokan_add_guide_menu( $urls ) {
$urls['guide'] = array(
'title' => __( 'Guide', 'dokan'),
'icon' => '<i class=”fa fa-user”></i>',
'url' => dokan_get_navigation_url( 'guide' ),
'pos' => 51
);
return $urls;
}


function dokan_load_templatefff() {
if ( isset( $query_vars['guide'] ) ) {
require_once dirname( __FILE__ ). '/guide.php';
}
}
add_action( 'dokan_load_custom_template', 'dokan_load_templatefff' );
*/


add_filter( 'dokan_query_var_filter', 'dokan_load_document_menue' );
function dokan_load_document_menue( $query_vars ) {
    $query_vars['chat'] = 'chat';
    return $query_vars;
}
add_filter( 'dokan_get_dashboard_nav', 'dokan_add_chat_menue' );
function dokan_add_chat_menue( $urls ) {
    $urls['chat'] = array(
        'title' => __( 'Chat Support', 'dokan'),
        'icon'  => '<i class="fa fa-user"></i>',
        'url'   => dokan_get_navigation_url( 'chat' ),
        'pos'   => 51
    );
    return $urls;
}

function dokan_load_templatee( $query_vars ) {
    if ( isset( $query_vars['chat'] ) ) {
        require_once dirname( __FILE__ ). '/chat.php';
       }
}
add_action( 'dokan_load_custom_template', 'dokan_load_templatee' );



function wk_userchat_endpoint() {
  add_rewrite_endpoint( 'userchat', EP_ROOT | EP_PAGES );
}
 
add_action( 'init', 'wk_userchat_endpoint' );

add_filter( 'woocommerce_account_menu_items', 'wk_new_menu_items' );

/**
* Insert the new endpoint into the My Account menu.
*
* @param array $items
* @return array
*/
function wk_new_menu_items( $items ) {
	$items[ 'userchat' ] = __( 'Chat Support', 'webkul' );
	return $items;
}

$endpoint = 'userchat';

add_action( 'woocommerce_account_' . $endpoint .  '_endpoint', 'wk_endpoint_content' );

function wk_endpoint_content() {
    //content goes here
    include('user-chat.php');    
}

add_filter( 'wp_get_nav_menu_items', 'nav_remove_empty_category_menu_item',10, 3 );
function nav_remove_empty_category_menu_item ( $items, $menu, $args ) {
    if ( ! is_admin() ) { 
        global $wpdb;
        $nopost = $wpdb->get_col( "SELECT term_taxonomy_id FROM $wpdb->term_taxonomy WHERE count = 0" );
        foreach ( $items as $key => $item ) {
            if ( ( 'taxonomy' == $item->type ) && ( in_array( $item->object_id, $nopost ) ) ) {
                unset( $items[$key] );
            }
        }
    }
    return $items;
 
}

add_action( 'woocommerce_thankyou', 'bbloomer_checkout_save_user_meta' );
 
function bbloomer_checkout_save_user_meta( $order_id ) {
    $order = wc_get_order( $order_id );
    $recipuent_pcode = get_post_meta($order_id, '_shipping_phone_code', true);
    $recipuent_phone = get_post_meta($order_id, '_shipping_phone', true);
    $user_phone = $recipuent_pcode.$recipuent_phone;
    
    $current_user_id = get_current_user_id();
    $phone1 = get_user_meta($current_user_id,'billing_phone_code',true);
    $phone2 = get_user_meta($current_user_id,'billing_phone',true);
    $phone12 = $phone1.$phone2;
    
    update_post_meta($order_id, '_billing_phone', $phone12);
}


/*prevent any orders from autocompleting*/

add_action( 'woocommerce_thankyou', 'stop_auto_complete_order' );
function stop_auto_complete_order( $order_id ) { 
    if ( ! $order_id ) {
        return;
    }

    $order = wc_get_order( $order_id );
    $order->update_status( 'processing' );
} 

function ace_make_checkout_fields_optional( $fields ) {
	$fields['billing']['billing_phone']['required'] = false;
	$fields['billing']['billing_phone_code']['required'] = false;
	$fields['shipping']['shipping_address_1']['required'] = false;
	$fields['billing']['full_address_for_rwanda']['required'] = false;
	$fields['shipping']['full_address_for_rwanda']['required'] = false;
	
	$fields['billing']['billing_postcode']['required'] = false;
	$fields['billing']['billing_state']['required'] = false;
	$fields['billing']['billing_city']['required'] = false;

	return $fields;
}
add_filter( 'woocommerce_checkout_fields', 'ace_make_checkout_fields_optional' );
    

function get_selected_address()
{
  global $wpdb;
  $id =intval($_REQUEST['id']);
  $data = $wpdb->get_row("SELECT*FROM wp_usermeta WHERE umeta_id =$id");
  wp_send_json(maybe_unserialize($data->meta_value)); 
  die;
}
    

add_action( 'wp_ajax_get_selected_address', 'get_selected_address'); // we admin
add_action( 'wp_ajax_nopriv_get_selected_address', 'get_selected_address'); // we will for frontend

