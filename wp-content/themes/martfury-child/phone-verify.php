<?php
add_action('wp_ajax_upDateMobileCountryCode', 'upDateMobileCountryCode');
add_action('wp_ajax_nopriv_upDateMobileCountryCode', 'upDateMobileCountryCode');
function upDateMobileCountryCode()
{	
	
	
	$selected_country = $_POST['country'];
	$url = get_stylesheet_directory_uri().'/country.json';
  	$str = file_get_contents($url);
  	$country_array = json_decode($str, true);
	$key = array_search($selected_country, array_column($country_array, 'code'));
	$country_telcode = $country_array[$key]['telcode'];
	
	echo json_encode(array('status'=>1, 'countrycode'=>$country_telcode));
	exit;
}

add_action('wp_ajax_send_otp_tophone', 'send_otp_tophone');
add_action('wp_ajax_nopriv_send_otp_tophone', 'send_otp_tophone');
function send_otp_tophone()
{	
	
	$phone = $_POST['phone_num'];
	$type = 'customer';
	if(empty($phone)){
		$phone = $_POST['venodrphone_num'];
		$type = 'vendor';
		}
	$otp = rand(100000,999999);
	$args = array(
    'number_to' => $phone,
    'message' => 'HoPsCan : Your Otp for Registration verification is '.$otp,
     );
    $sms = twl_send_sms($args);
	if(is_wp_error($sms)){
		$status = 0;
		$scmsg = 'Failed';	
	}else{
		
		setcookie('sended_otp', $otp, time()+600, '/', $_SERVER['HTTP_HOST']);
		$status = 1;
		$scmsg = 'Success';	
	}
	echo json_encode(array('status'=>$status, 'msg'=>$scmsg, 'otp'=>$otp, 'type'=>$type));
	exit;
}

add_action('wp_ajax_verify_otp', 'verify_otp');
add_action('wp_ajax_nopriv_verify_otp', 'verify_otp');
function verify_otp()
{	
	$otp_sended = $_COOKIE['sended_otp'];
	$otp = $_POST['otp_customer'];
	if(empty($otp)){
			$otp = $_POST['otp_vendor'];	
		}
	if($otp_sended == $otp){
		$status = 1;
		$scmsg = 'Verified';	
	}else{
		$status = 0;
		$scmsg = 'Failed';		
	}
	echo json_encode(array('status'=>$status, 'msg'=>$scmsg,));
	exit;
}
