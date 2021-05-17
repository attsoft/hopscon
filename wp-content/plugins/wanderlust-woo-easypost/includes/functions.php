<?php
	global $woocommerce, $wpdb, $table_prefix;
	session_start();

	add_action( 'wp_ajax_nopriv_myAjaxeasy', 'myAjaxeasy' );
	add_action( 'wp_ajax_nopriv_myAjaxseasy', 'myAjaxseasy' );
	add_action( 'wp_ajax_myAjaxseasy', 'myAjaxseasy' );
	add_action( 'wp_ajax_myAjaxeasy', 'myAjaxeasy' );
	add_action( 'wp_ajax_nopriv_getrates', 'getrates' );
	add_action( 'wp_ajax_getrates', 'getrates' );
	add_action( 'wp_ajax_nopriv_buylabel', 'buylabel' );
	add_action( 'wp_ajax_buylabel', 'buylabel' );
	add_action( 'wp_ajax_nopriv_labelinfo', 'labelinfo' );
	add_action( 'wp_ajax_labelinfo', 'labelinfo' );
	add_action( 'wp_ajax_nopriv_labelpackageinfo', 'labelpackageinfo' );
	add_action( 'wp_ajax_labelpackageinfo', 'labelpackageinfo' );
	add_action( 'wp_ajax_nopriv_insurepackage', 'insurepackage' );
	add_action( 'wp_ajax_insurepackage', 'insurepackage' );
	add_action( 'wp_ajax_nopriv_pickup', 'pickup' );
	add_action( 'wp_ajax_pickup', 'pickup' );
	add_action( 'wp_ajax_nopriv_quickbuy', 'quickbuy' );
	add_action( 'wp_ajax_quickbuy', 'quickbuy' );
	add_action( 'wp_ajax_nopriv_myAjaxs', 'myAjaxs' );
	add_action( 'wp_ajax_myAjaxs', 'myAjaxs' );
	add_action( 'wp_ajax_nopriv_easypost_wanderlust_getscanform', 'easypost_wanderlust_getscanform' );
	add_action( 'wp_ajax_easypost_wanderlust_getscanform', 'easypost_wanderlust_getscanform' );

	require_once('lib/easypost.php');
	$woocommerce_easypost_test = get_option( 'pvit_easypostwanderlust_shipper_test' );
	$woocommerce_easypost_test_api_key = get_option( 'pvit_easypostwanderlust_testkey' );
	$woocommerce_easypost_live_api_key = get_option( 'pvit_easypostwanderlust_livekey' );

	if ($woocommerce_easypost_test =='1') { 
		\EasyPost\EasyPost::setApiKey($woocommerce_easypost_test_api_key);
	} else {
		\EasyPost\EasyPost::setApiKey($woocommerce_easypost_live_api_key);
	} 

	require_once('mod/get-rates-backend.php');
	require_once('mod/generate-label.php');
	require_once('mod/auto-generate.php');
	require_once('mod/email_label.php');
	require_once('mod/order-package-info.php');


function easypost_wanderlust_getscanform() {
	require_once('lib/easypost.php');
	$woocommerce_easypost_test = get_option( 'pvit_easypostwanderlust_shipper_test' );
	$woocommerce_easypost_test_api_key = get_option( 'pvit_easypostwanderlust_testkey' );
	$woocommerce_easypost_live_api_key = get_option( 'pvit_easypostwanderlust_livekey' );

	if ($woocommerce_easypost_test =='1') { 
		\EasyPost\EasyPost::setApiKey($woocommerce_easypost_test_api_key);
	} else {
		\EasyPost\EasyPost::setApiKey($woocommerce_easypost_live_api_key);
	} 	
 	
	if(!empty($_POST['orders_ready'])){
		foreach($_POST['orders_ready'] as $order_id){
			$order = wc_get_order( $order_id );
 			$easypost_order_id = get_post_meta( $order_id, '_wanderlustshiporderid', true);
 			$easypost_shipping_id = get_post_meta($order_id, '_wanderlustshipid', true);			
			try {
 				$easypost_order = \easypost\Shipment::retrieve($easypost_shipping_id);
				$shipments[] = $easypost_order;

			} catch (Exception $e) {
						 
 			}	
		}
		
		if(!empty($shipments)){
			// create a scan form
			try {
				$scan_form = \EasyPost\ScanForm::create(array(
						"shipments" => $shipments
				));
 			} catch (Exception $e) {
						 
 			}	
			// inspect scanform
			if(!empty($scan_form)){
				//var_dump($scan_form->id);
				if($scan_form->status == 'created'){
					
					$easypost_scan_forms = get_option( 'wanderlust_easypost_scan' );
					$easypost_scan_forms_decoded = json_decode($easypost_scan_forms);
					if(empty($easypost_scan_forms_decoded)){
 						$form_info[] = array(
 							"form_id"  => $scan_form->id,
 							"created_at" => $scan_form->updated_at,
 							"tracking_codes" => $scan_form->tracking_codes,
 						);						
						$add_form = $form_info;
						$easypost_scan_forms_encoded = json_encode($add_form);
					} else {
 						$form_info = array(
 							"form_id"  => $scan_form->id,
 							"created_at" => $scan_form->updated_at,
 							"tracking_codes" => $scan_form->tracking_codes,
 						);							
						array_push($easypost_scan_forms_decoded, $form_info);
						$easypost_scan_forms_encoded = json_encode($easypost_scan_forms_decoded);
					}
 
					update_option( 'wanderlust_easypost_scan', $easypost_scan_forms_encoded );

					echo '<h3>FORM CREATED</h3></br>';
					echo '<a href="'.$scan_form->form_url.'" target="_blank">Print Form</a>';
					
					foreach($_POST['orders_ready'] as $order_id){
						$get_tracking = get_post_meta($order_id,'_tracking_number',true);
						foreach($scan_form->tracking_codes as $trackings){
							if($trackings == $get_tracking){
								update_post_meta($order_id, 'scan_form', $scan_form->batch_id );
							}
						}
						
					}
				 
				}
			}
 			
			
 		}
 
	} else {
		echo 'You need to add orders into the form';
	}
 	die();
}
 

$woocommerce_easypost_autogen = get_option( 'pvit_easypostwanderlust_autogen' ); //check if auto label is enabled
if($woocommerce_easypost_autogen == 1){
	add_action( 'woocommerce_order_status_processing', 'purchase_order');
}
 

function myAjaxeasy(){global $wpdb;$update = $_POST['updatess'];$bodytag = str_replace("\'", "'", $update);$update2  = $wpdb->query($bodytag);$results = "Saved";$results = '<META HTTP-EQUIV="refresh" CONTENT="1">';die($results);}
function myAjaxseasy(){global $wpdb;$update = $_POST['updatess'];$bodytag = str_replace("\'", "'", $update);$update2  = $wpdb->query($bodytag);$results = "Saved";die($results);}
function myAjaxs(){global $wpdb;$update = $_POST['updatess'];$bodytag = str_replace("\'", "'", $update);$update2  = $wpdb->query($bodytag);$results = "Saved";$results = '<META HTTP-EQUIV="refresh" CONTENT="1">';die($results);}

add_action('woocommerce_checkout_update_order_meta', 'easypost_wanderlust_autogen_order_meta');
function easypost_wanderlust_autogen_order_meta( $order_id ) {
    update_post_meta( $order_id, '_easypost_shipping_id', esc_attr($_SESSION['multilabel']));
}

$custom_hs = get_option('pvit_easypostwanderlust_customshmore');
if($custom_hs == '1'){
	add_action( 'woocommerce_product_options_shipping', 'woo_add_easypostwanderlust_customshs_fields' );
	add_action( 'woocommerce_process_product_meta', 'woo_add_easypostwanderlust_customshs_fields_save' );

	function woo_add_easypostwanderlust_customshs_fields() {
	  global $woocommerce, $post;
	  echo '<div class="options_group">';
		woocommerce_wp_text_input( 
			array( 
				'id'          => '_hs_number', 
				'label'       => __( 'HS Tariff Number ', 'woocommerce' ), 
				'placeholder' => '123456',
				'desc_tip'    => 'true',
				'default' 	  => '123456',
				'description' => __( 'Harmonized System Codes', 'woocommerce' ) ,
			)
		);
	  echo '</div>';
	}

	function woo_add_easypostwanderlust_customshs_fields_save( $post_id ){
		$woocommerce_text_field = $_POST['_hs_number'];
		if( !empty( $woocommerce_text_field ) )
			update_post_meta( $post_id, '_hs_number', esc_attr( $woocommerce_text_field ) );
	}
}