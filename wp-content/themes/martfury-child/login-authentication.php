<?php 
//add_action('shutdown', 'shutdown_test_function1');
function shutdown_test_function1(){
	
	$user = apply_filters( 'authenticate', null, 'manoj', 'manoj1' );
	echo '<pre>';
	print_r($user);
	echo '</pre>';
	//setcookie('login_otp', '', time()+600, '/', $_SERVER['HTTP_HOST']);
	
}
//add_filter( 'authenticate', 'myplugin_auth_signon', 30, 3 );
function myplugin_auth_signon( $user, $username, $password ) {

	if($user == 'null' || $user->roles[0] == 'administrator'){
		return $user;
	}else{
        $user_phone = get_user_meta($user->data->ID, 'xoo_ml_phone_display', true);
		if($user_phone){
			$otp = rand(100000,999999);
			$args = array(
    			'number_to' => $user_phone,
    			'message' => 'HoPsCan : Your Otp for Login Autantication is '.$otp,
     		);
    	$sms = twl_send_sms($args);
		
	if(is_wp_error($sms)){
		$status = 0;
		$scmsg = 'Failed';
		setcookie('auth_status', 'otp_failed', time()+600, '/', $_SERVER['HTTP_HOST']);	
	}else{
		
		setcookie('login_otp', $otp, time()+600, '/', $_SERVER['HTTP_HOST']);
		setcookie('auth_status', 'otp_send', time()+600, '/', $_SERVER['HTTP_HOST']);
		setcookie('username', $username, time()+600, '/', $_SERVER['HTTP_HOST']);
		setcookie('password', $password, time()+600, '/', $_SERVER['HTTP_HOST']);
		setcookie('phone_num', $user_phone, time()+600, '/', $_SERVER['HTTP_HOST']);
		$status = 1;
		$scmsg = 'Success';	
		wp_safe_redirect( 'https://hopscan-stg.com/my-account/' );
		exit();
	}
	//echo json_encode(array('status'=>$status, 'msg'=>$scmsg, 'otp'=>$otp, 'type'=>$type));
	
		}else{
			
			setcookie('auth_status', 'no_phonenum', time()+600, '/', $_SERVER['HTTP_HOST']);
			
			}
	}
}


function add_login_auth_forms() {
	
	$login_otp = $_COOKIE['login_otp'];
	$auth_status = $_COOKIE['auth_status'];
	
	$username = $_COOKIE['username'];
	$password = $_COOKIE['password'];
	$phone_num = $_COOKIE['phone_num'];
	
  ?>
  <div class="mo-modal-backdrop" id="popup_otp" style="display:none;">
  <div class="mo_customer_validation-modal" tabindex="-1" role="dialog" id="mo_site_otp_form">
    <div class="mo_customer_validation-modal-backdrop"></div>
    <div class="mo_customer_validation-modal-dialog mo_customer_validation-modal-md">
    <div class="otp-logo">
        <a href="<?php echo home_url(); ?>">
            <img class="site-logo" alt="Hops Can" src="<?php echo home_url(); ?>/wp-content/uploads/2020/09/hopscan_logo.png">
			        </a>
    </div>
      <div class="login mo_customer_validation-modal-content">
        <div class="mo_customer_validation-modal-header">
        <div class="envolope_icon">
            <img class="site-logo" alt="Hops Can" src="<?php echo get_stylesheet_directory_uri();?>/image/msg-icon.jpg">
    </div>
        </div>
        <div class="mo_customer_validation-modal-body center">
       
        
          <div><h2>To continue, enter the OTP sent to you</h2></div>
          <div class="mob">Mobile number <span id="mobile_num"></span></div>
          <br>
          <div class="mo_customer_validation-login-container">
            <form id="mo_validate_form" name="f" method="post" action="">
            
            <!--<div>A new security system has been enabled for you. Please register your phone to continue.</div>
		  <input type="text" name="mo_phone_number" autofocus="" placeholder="" id="mo_phone_number" required="" class="mo_customer_validation-textbox" pattern="^[\+]\d{1,4}\d{7,12}$|^[\+]\d{1,4}[\s]\d{7,12}$" title="{{PHONE_NUMBER_TITLE}}">	-->
            
              <input type="number" name="mo_otp_token" id="mo_otp_token" autofocus="" placeholder="" required class="mo_customer_validation-textbox" pattern="[0-9]{4,8}" title="Only digits within range 4-8 are allowed.">
              <span class="error invalid_otp" style="display:none;">Incorrect Otp Value</span>
              <br>
              <input type="submit" name="miniorange_otp_token_submit" id="miniorange_otp_token_submit" class="miniorange_otp_token_submit" value="Validate OTP">
              <input type="hidden" name="otp_type" value="phone">
              <input type="hidden" id="from_both" name="from_both" value="false">
              <input type="hidden" name="username" value=" <?php echo $username; ?>">
              <input type="hidden" name="password" value="<?php echo $password; ?>">
              <input type="hidden" name="woocommerce-login-nonce" value="9cff5aea3d">
              <input type="hidden" name="_wp_http_referer" value="/my-account/">
              <input type="hidden" name="login" value="Log in">
              <input type="hidden" name="option" value="miniorange-validate-otp-form">
              <div class="resend_div">
              <span class="resend_head">Didn't receive it?</span>
              <a style="cursor: pointer;" onclick="mo_otp_verification_resend();">Resend notification</a>
              <div class="resend_done"></div>
              </div>
            </form>
            <div class="refresh_pp">Did you already respond?
						<a href="#">Click here to refresh the page.</a>
                        
            <h4>Need help? Please Contact <a href="#">Customer Service.</a></h4>            
</div>
            <div id="mo_message" hidden="" style="background-color:#f7f6f7;padding:1em 2em 1em 1.5em;color:#000">
              <div style="display:table;text-align:center;"><img src="<?php echo get_stylesheet_directory_uri();?>/images/loader.gif"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
      
     <?php 
	
	 
	 
	 /*?> Add Phone Number<?php */?>
      
      <?php /*?> <div class="mo-modal-backdrop"  style="display:none;">
  <div class="mo_customer_validation-modal" tabindex="-1" role="dialog" id="mo_site_otp_form">
    <div class="mo_customer_validation-modal-backdrop"></div>
    <div class="mo_customer_validation-modal-dialog mo_customer_validation-modal-md">
      <div class="login mo_customer_validation-modal-content">
        <div class="mo_customer_validation-modal-header"><b>Validate OTP (One Time Passcode)</b> <a class="close" href="#" onclick="mo_validation_goback();">← Go Back</a></div>
        <div class="mo_customer_validation-modal-body center">
          <div>A new security system has been enabled for you. Please register your phone to continue.</div>
		  <input type="text" name="mo_phone_number" autofocus="" placeholder="" id="mo_phone_number" required="" class="mo_customer_validation-textbox" pattern="^[\+]\d{1,4}\d{7,12}$|^[\+]\d{1,4}[\s]\d{7,12}$" title="{{PHONE_NUMBER_TITLE}}">
          <br>
          <div class="mo_customer_validation-login-container">
            <form id="mo_validate_form" name="f" method="post" action="">
              <input type="hidden" name="option" value="mo_ajax_form_validate">
              <input type="text" name="mo_phone_number" autofocus="" placeholder="" id="mo_phone_number" required="" class="mo_customer_validation-textbox" pattern="^[\+]\d{1,4}\d{7,12}$|^[\+]\d{1,4}[\s]\d{7,12}$" title="{{PHONE_NUMBER_TITLE}}">
              <div id="mo_message" hidden="" style="background-color:#f7f6f7;padding:1em 2em 1em 1.5em;color:#000"></div>
              <br>
              <div id="mo_validate_otp" hidden="">Verify Code:
                <input type="number" name="mo_otp_token" autofocus="" placeholder="" id="mo_otp_token" required="" class="mo_customer_validation-textbox" pattern="[0-9]{4,8}">
              </div>
              <input type="button" hidden="" id="validate_otp" name="otp_token_submit" class="miniorange_otp_token_submit" value="Validate">
              <input type="button" id="send_otp" class="miniorange_otp_token_submit" value="Send OTP">
              <input type="hidden" name="username" value="rizwan.qureshi">
              <input type="hidden" name="password" value="rizwan.qureshi">
              <input type="hidden" name="woocommerce-login-nonce" value="9cff5aea3d">
              <input type="hidden" name="_wp_http_referer" value="/my-account/">
              <input type="hidden" name="login" value="Log in">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div><?php */?>



<?php
}
if(!is_user_logged_in()){
//add_action('wp_footer', 'add_login_auth_forms');
}

add_action('wp_ajax_otp_token_authanticate', 'otp_token_authanticate');
add_action('wp_ajax_nopriv_otp_token_authanticate', 'otp_token_authanticate');
function otp_token_authanticate()
{	

	$otp = $_POST['otp'];
	$login_otp = $_COOKIE['login_otp'];
	$username = $_COOKIE['username'];
	$password = $_COOKIE['password'];
	$phone_num = $_COOKIE['phone_num'];
	

	if($otp == $login_otp){
		
	$user = get_user_by('login', $username );
	if(empty($user)){
			$user = get_user_by('email', $username );		
		}
	
	// Redirect URL //
	if ( $user->data->ID ) 
	{
		setcookie('login_otp', '', time()+600, '/', $_SERVER['HTTP_HOST']);
		setcookie('auth_status', 'success', time()+600, '/', $_SERVER['HTTP_HOST']);	
		
		wp_clear_auth_cookie();
		wp_set_current_user ( $user->ID );
		wp_set_auth_cookie  ( $user->ID );
		$status = 1;
		$login = 'success';
	}
			
	}else{
		$status = 0;
		$login = 'notmatched';
		}
	
	echo json_encode(array('status'=>$status, 'login'=>$login));
	exit;
}
add_action('wp_ajax_verify_and_send_otp', 'verify_and_send_otp');
add_action('wp_ajax_nopriv_verify_and_send_otp', 'verify_and_send_otp');
function verify_and_send_otp()
{	
		$username = $_POST['username'];
		$password = $_POST['password'];
		//$username = sanitize_user( $username );
    	//$password = trim( $password );
		//$user = wp_authenticate($username, $username);
		$user = apply_filters( 'authenticate', null, $username, $password);
		
		if ( null == $user ) {
		$status = 0;	
        $user = new WP_Error( 'authentication_failed', __( '<strong>Error</strong>: Invalid username, email address or incorrect password.' ) );
		header("Content-Type: application/json");
		echo json_encode(array('status'=>$status, 'user_id'=>'no_valid'));
    	exit;
		}else{
			$user_id = $user->data->ID;
			
			$user_phone = get_user_meta($user_id, 'xoo_ml_phone_display', true);
			if($user_phone){
				$otp = rand(100000,999999);
				$args = array(
					'number_to' => $user_phone,
					'message' => 'HoPsCan : Your Otp for Login Autantication is '.$otp,
				);
			$sms = twl_send_sms($args);
			
		if(is_wp_error($sms)){
			$status = 0;
			$scmsg = 'Failed';
			setcookie('auth_status', 'otp_failed', time()+600, '/', $_SERVER['HTTP_HOST']);	
		}else{
			$status = 1;
			setcookie('login_otp', $otp, time()+600, '/', $_SERVER['HTTP_HOST']);
			setcookie('username', $username, time()+600, '/', $_SERVER['HTTP_HOST']);
			setcookie('password', $password, time()+600, '/', $_SERVER['HTTP_HOST']);
			setcookie('phone_num', $user_phone, time()+600, '/', $_SERVER['HTTP_HOST']);
			$status = 1;
			$scmsg = 'Success';	
			$formated_phone = str_repeat('*', strlen($user_phone) - 2) . substr($user_phone, -2);
			echo json_encode(array('status'=>$status, 'otp'=>$otp, 'user_id'=>$user_id, 'phone'=>$formated_phone));
			exit();
	}
	//echo json_encode(array('status'=>$status, 'msg'=>$scmsg, 'otp'=>$otp, 'type'=>$type));
	
		}else{
			$status = 1;
			setcookie('auth_status', 'no_phonenum', time()+600, '/', $_SERVER['HTTP_HOST']);
			echo json_encode(array('status'=>$status, 'user_id'=>$user_id, 'phone'=>'no'));
			exit();
			
			}
	
		
		}
		
		exit;

}
add_action('wp_ajax_resend_login_otp', 'resend_login_otp');
add_action('wp_ajax_nopriv_resend_login_otp', 'resend_login_otp');
function resend_login_otp()
{
	$phone = $_COOKIE['phone_num'];
	if($phone){
				$otp = rand(100000,999999);
				$args = array(
					'number_to' => $phone,
					'message' => 'HoPsCan : Your Otp for Login Autantication is '.$otp,
				);
		$sms = twl_send_sms($args);
			
		if(is_wp_error($sms)){
			$status = 0;
			$scmsg = 'Failed';
			setcookie('auth_status', 'otp_failed', time()+600, '/', $_SERVER['HTTP_HOST']);	
		}else{
			$status = 1;
			setcookie('login_otp', $otp, time()+600, '/', $_SERVER['HTTP_HOST']);
			$status = 1;
			$scmsg = 'Success';	
			echo json_encode(array('status'=>$status, 'otp'=>$otp, 'phone'=>$phone));
			exit();
		}
	}
}