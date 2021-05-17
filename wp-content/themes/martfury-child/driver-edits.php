<?php
add_action('wp_ajax_update_account_todriver', 'update_account_todriver');
add_action('wp_ajax_nopriv_update_account_todriver', 'update_account_todriver');
function update_account_todriver()
{	
	$user_id = $_POST['userid'];
	if($user_id){
		$user = new WP_User( $user_id );
		$user->set_role( 'driver' );	
		$status = 1;
		$url = home_url('my-account/driver-dashboard');
	}else{
		$status = 0;
		$url = home_url('my-account');	
	}
	echo json_encode(array('status'=>$status, 'redirect'=>$url,));
	exit;
}


function ddwc_pro_access_denied2( $access_denied ) {
	  if ( false !== get_option( 'ddwc_pro_settings_driver_application' ) && 'yes' == get_option( 'ddwc_pro_settings_driver_application' ) ) {
	    if ( false !== get_option( 'ddwc_pro_settings_contact_page' ) && 'none' !== get_option( 'ddwc_pro_settings_contact_page' ) ) {
	        $contact_link = home_url('my-account/become-a-driver');
	    } else {
	        $contact_link = 'mailto:' . apply_filters( 'ddwc_pro_settings_contact_page_link_email_address', get_option( 'admin_email' ) );
	    }
	    $access_denied  = "<h3 class='ddwc access-denied'>" . __( 'Apply to become a driver', 'ddwc-pro' ) . "</h3>";
	    $access_denied .= "<p>" . __( 'Want to become a HoPscan delivery Driver?', 'ddwc-pro' ) . "</p>";
	    $access_denied .= "<p><a href='" . $contact_link . "' class='button become_drvr'>" . __( 'Apply to become a driver', 'ddwc-pro' ) . "</a></p>";
	  } else {
	    // Do nothing.
	  }

	  return $access_denied;
}
add_filter( 'ddwc_access_denied', 'ddwc_pro_access_denied2', 10, 3 );


function wpuf_update_profile_makedr( $post_id ) {
	if($_POST['form_id'] == 4113){
		$user = get_user_by( 'email', $_POST['user_email'] );
		$user_id = $user->ID;
		if($user){
			$user->set_role( 'driver' );
			update_user_meta( $user->ID, 'wpuf_user_status', 'pending' );
			
			add_filter( 'wp_mail_content_type', 'set_html_content_type' );
			
			$admin_email = get_option('admin_email');
			$admin_name = get_option('blogname');
			
		$message .='<div style="background-color: rgb(255,255,255); overflow: hidden; border-style: solid; border-width: 1.0px; border-color: rgb(222,222,222); border-radius: 3.0px; padding: 0 20px; max-width: 90%; margin: 20px auto;">';
		
		$message .='<p>Hi '.$admin_name.',';
		
		$message .='<p>New user ( '.$_POST["user_email"].' ) upgraded his account to HoPscan Driver. Please visit to admin panel or approve that.</p>';
		
		$message .='<p><strong>Note : New driver account don\'t abel to accept deliverys till account not approved.</strong></p> ';	
		
		$message .='<p>Verify Driver account using following url. </p> ';
		
		$message .='<div class=""><a href="'.home_url('wp-admin/users.php?role=driver').'" style="background-color: #66ae3d;font-size: 18px;color: #fff;font-weight: 600;padding: 10px;width: 185px;display: block;text-align: center;border-radius: 4px;text-decoration: none;">VISIT ADMIN PANEL</a></div> ';	
		
		$message .='<p>Thanks.</p> ';	
		
		$message .='<div style="padding: 0;border: 0; text-align: center;font-size: 12px;font-family: Helvetica Neue, Helvetica, Roboto, Arial, sans-serif; font-weight: 400;color: #555555;padding-top: 0px;padding-bottom: 0px">
														<p style="color: #555555">© 2020 HoPscan. All Rights Reserved</p>
													</div>';
		$message .='</div>';											
													
		
		
		$email = wp_mail( $admin_email, 'HoPscan New driver account upgraded', $message );
		
		if($email != 1){
				wp_send_json_error( __( 'Email not send for '.$admin_email.', Plase send Mannually'));
			}
		
		remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
				
			
			$status = 1;
		}else{
			$status = 0;
		}
	}
}

add_action( 'wpuf_update_profile', 'wpuf_update_profile_makedr' );


add_action( 'wp_ajax_check_otp', 'check_otp' );
add_action( 'wp_ajax_nopriv_check_otp', 'check_otp' );
function check_otp(){
    
	$order_id = $_REQUEST['order'];
	$otp = $_REQUEST['otp'];
	$otp_existin = get_post_meta( $order_id, 'otp', true);
 	$order = wc_get_order( $order_id );
 	//wp_send_json($order);
	$otp_existin = get_post_meta( $order_id, 'otp', true);
	if($otp == $otp_existin )
	{
		$order->update_status('wc-completed');
		echo 'success';
	}else 
	{
		echo 'wrong';
	}
	exit;
}


add_action( 'wp_ajax_witout_check_otp', 'witout_check_otp' );
add_action( 'wp_ajax_nopriv_witout_check_otp', 'witout_check_otp' );
function witout_check_otp(){
	$order_id = $_REQUEST['order'];
 	$order = new WC_Order($order_id);
	//$order->update_status('wc-completed');
	echo 'success';
	exit;
}

