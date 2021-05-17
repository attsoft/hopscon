<?php
	
	function quickbuy() { 
 		$wooorder = new WC_Order($_POST['shippingid']);
 		$method = $wooorder->get_shipping_methods();
 		$method = array_values($method);
 		$shipping_method = $method[0]['method_id'];
 		$ship_arr = explode('|',$shipping_method);
 		$ship_arrb = explode('-',$ship_arr[0]);
		$order = \EasyPost\Order::retrieve($_POST['shiporder']);	  											  
  				
		$from_address = \EasyPost\Address::retrieve($order->from_address->id);
 		$to_address = \EasyPost\Address::retrieve($order->to_address->id);
		$customs_info = \EasyPost\CustomsInfo::retrieve($order->customs_info->id);
				  
 		$order->to_address->name = sprintf("%s %s", $wooorder->shipping_first_name, $wooorder->shipping_last_name);
		$order->to_address->phone = $wooorder->billing_phone;

 		$name = str_replace("\'","'", $order->to_address->name);
 		$company = str_replace("\'","'", $order->to_address->company);
		$street1 = str_replace("\'","'", $order->to_address->street1);
		$street2 = str_replace("\'","'", $order->to_address->street2);
		$city = str_replace("\'","'", $order->to_address->city);
				  
				$to_address =  \EasyPost\Address::create(array(
					"name"    => $name,
					"company" => $company,
					"street1" => $street1,
					"street2" => $street2,
					"city"    => $city,
					"state"   => $order->to_address->state,
					"zip"     => $order->to_address->zip,
					"phone"   => $order->to_address->phone,
					"country" => $order->to_address->country,
					"email" => $order->to_address->email,
					"residential" => null,
				)
				);		
 		if($order->to_address->country == 'US') { $to_address = $to_address->verify(); }

				$boxes = array();
 				foreach($order->shipments as $box){
 					$retrieved = \EasyPost\Parcel::retrieve($box->parcel->id);
						$shipment_signature = $box['options']['delivery_confirmation'];
						$residential_to_address = $box['options']['residential_to_address'];
 						$woocommerce_currency = $box['options']['currency'];
						//print_r($shipment_signature); print_r($residential_to_address); print_r($woocommerce_currency);
						$boxes[] = 
								 array(
									 "parcel" => $retrieved,
									 "options" => array(
										  'delivery_confirmation' => $shipment_signature, 
										  'residential_to_address' => $residential_to_address,
										  'invoice_number' => $_POST['shippingid'],
										  'print_custom_1' => 'Order #' . $_POST['shippingid'],
										  'currency' => $woocommerce_currency
									 ),
								 );	
				}

				$order = \EasyPost\Order::create(array(
					"from_address" => $from_address,
					"to_address" => $to_address,
					"shipments" => $boxes,
 					"customs_info" => $customs_info,
				));

 				$order->buy(array("carrier" => $ship_arrb[0], "service" => $ship_arrb[1])); 
				$countlabels = 0;
					// CHECK ALL SHIMPMENTS -- STARTS
					foreach($order['shipments'] as $shipment)  {
						$countlabels++; 

						// UPDATE ORDER INFO -- STARTS
						$date = strtotime( date('Y-m-d') );
						$tracking_provider = strtolower($shipment->selected_rate->carrier);
						update_post_meta($_POST['shippingid'], 'easypost_shipping_label_' . $countlabels, $shipment->postage_label->label_url); 
						update_post_meta($_POST['shippingid'], '_tracking_number',  $shipment->tracking_code);
						update_post_meta($_POST['shippingid'], '_tracking_provider', $tracking_provider );   
						update_post_meta($_POST['shippingid'], '_date_shipped', $date);
 						update_post_meta($_POST['shippingid'], '_wanderlustshipid', $shipment->id);
						update_post_meta($_POST['shippingid'], '_wanderlustshiporderid', $_POST['shiporder']);	
						$wooorder->update_status('completed', 'order_note'); //check this			

						$wooorder->add_order_note(
							sprintf(
							  "Shipping label available at: '%s'",
							  $shipment->postage_label->label_url
							)
						);

						$wooorder->add_order_note(
							sprintf(
							  "Tracking Code: '%s'",
							  $shipment->tracking_code
							)
						);	
						// UPDATE ORDER INFO -- ENDS

						// SEND VIA EMAIL -- STARTS
						if ($_SESSION['send_email'] == 1) {
							$sendto = get_option( 'pvit_easypostwanderlust_email_label_to' );  
								if (!empty($sendto)){ 
									$sendfrom = get_option( 'pvit_easypostwanderlust_email_label_from' );
									$mesage = $sendtext;
									$mailer = new AttachMailer($sendfrom, $sendto, "Shipping Label", $mesage);
									$mailer->attachFile($shipment->postage_label->label_url);
									$mailer->send() ? "envoye": "probleme envoi";
								}  
						}   
						// SEND VIA EMAIL -- ENDS

						// SAVE LABEL ON FTP -- STARTS
						$save_path = plugin_dir_path ( __FILE__ ) . 'generated_labels/';
						$save_url = plugin_dir_url(dirname(__FILE__)) . 'mod/generated_labels/';
						$fp = fopen($save_path . $shipment->tracking_code . '.png', 'wb'); //Create PNG or PDF file
						$content = file_get_contents($shipment->postage_label->label_url);
						fwrite($fp, $content); 
						fclose($fp);
						// SAVE LABEL ON FTP -- ENDS

						// SHOW LABEL IMAGES -- STARTS
						echo  '<div style="cursor: pointer;" class="print"  data-imgid="'. $save_url . $shipment->tracking_code .'.png"><a href="#"><img src="'. $save_url . $shipment->tracking_code .'.png" width="150" height="auto" alt="'. $shipment->selected_rate->service .'" title="'. $shipment->selected_rate->service .'"></a></div>';
						// SHOW LABEL IMAGES -- ENDS
					}
					// CHECK ALL SHIMPMENTS -- ENDS 
		die();
	}

	function insurepackage($shipsid, $packagevalue) { 
			$woocommerce_easypost_test = get_option( 'pvit_easypostwanderlust_shipper_test' );
			$woocommerce_easypost_test_api_key = get_option( 'pvit_easypostwanderlust_testkey' );
			$woocommerce_easypost_live_api_key = get_option( 'pvit_easypostwanderlust_livekey' );
			if ($woocommerce_easypost_test == 1) { \EasyPost\EasyPost::setApiKey($woocommerce_easypost_test_api_key); } else { \EasyPost\EasyPost::setApiKey($woocommerce_easypost_live_api_key); } 
			if (empty($shipsid)){
				$shipsid = $_POST ['shippingid']; 
			}

			$shipment = \EasyPost\Shipment::retrieve($shipsid);
			$shipment->insure(array('amount' => $packagevalue));	

			echo '</br>Insured for: $' . $shipment->insurance;

			die($results);
	}	
	
	function labelpackageinfo($order_id) { 	
		$woocommerce_easypost_test = get_option( 'pvit_easypostwanderlust_shipper_test' );
		$woocommerce_easypost_test_api_key = get_option( 'pvit_easypostwanderlust_testkey' );
		$woocommerce_easypost_live_api_key = get_option( 'pvit_easypostwanderlust_livekey' );
		if ($woocommerce_easypost_test == 1) { \EasyPost\EasyPost::setApiKey($woocommerce_easypost_test_api_key); } else { \EasyPost\EasyPost::setApiKey($woocommerce_easypost_live_api_key); } 

		$_SESSION['shippingid'] = $_POST ['shippingid']; 
		if(empty($_SESSION['shippingid'])){
			$easypost_shipping_id = get_post_meta($order_id, '_wanderlustshipid');		
			$easypost_shipping_orderid = get_post_meta($order_id, '_wanderlustshiporderid');
			$_SESSION['shippingid'] = $easypost_shipping_id[0];
		}
		$order = $_POST ['shiporder']; 
		$shipment = \EasyPost\Shipment::retrieve($_SESSION['shippingid']);
		$selected_rate = $shipment->selected_rate->rate;
		$carrier = $shipment->selected_rate->carrier;
		$service = $shipment->selected_rate->service;
		$delivery_days = $shipment->selected_rate->delivery_days;
		$created_at = $shipment->parcel->created_at;
		$delivery_date = $shipment->selected_rate->delivery_date;
		$height = $shipment->parcel->height;
		$length = $shipment->parcel->length;
		$width = $shipment->parcel->width;
		$weight	= $shipment->parcel->weight;
		$predefined_package = $shipment->parcel->predefined_package;
		$insurancecost = $shipment->insurance * 0.01; 

		$_SESSION['datashiporderid'] = $_POST ['datashiporderid']; 
		if(!empty($_SESSION['datashiporderid'])){
			$datashiporderid = \EasyPost\Order::retrieve($_SESSION['datashiporderid']);
			echo 'Insurance: $' . $datashiporderid['shipments'][0]->insurance;
			echo '</br>Insurance Cost: $' . $datashiporderid['shipments'][0]->insurance * 0.01; 
			echo '</br>';
		} else {
			echo 'Insurance: $' . $shipment->insurance;
			echo '</br>Insurance Cost: $' . $insurancecost;
			echo '</br>'; //check this for each shipment
		}

		if($carrier == 'FedEx'){echo 'Cost: $'.$selected_rate. ' </br>Service: '.$service. '</br>Delivery Days: '.$delivery_days. ' </br>Created on: ' .$created_at .'</br>Delivery Date: '.$delivery_date. ' </br>Height: ' .$height.' in. </br>Lenght: '.$length.' in. </br> Width: '.$width.' in. </br> Weight: '.$weight.' oz. </br> Pred. Package: '.$predefined_package; 
		} else {
		echo 'Cost: $'.$selected_rate. ' </br>Service: '.$service. ' </br>Created on: ' .$created_at .' </br>Height: ' .$height.' in. </br>Lenght: '.$length.' in. </br> Width: '.$width.' in. </br> Weight: '.$weight.' oz. </br> Pred. Package: '.$predefined_package; 
		}

		//print($shipment.insurance);
		//die($results);
	}
	add_action('wanderlust_label_info_hook', 'labelpackageinfo');

	function labelinfo($order_id) { 	
		$woocommerce_easypost_test = get_option( 'pvit_easypostwanderlust_shipper_test' );
		$woocommerce_easypost_test_api_key = get_option( 'pvit_easypostwanderlust_testkey' );
		$woocommerce_easypost_live_api_key = get_option( 'pvit_easypostwanderlust_livekey' );
		if ($woocommerce_easypost_test == 1) { \EasyPost\EasyPost::setApiKey($woocommerce_easypost_test_api_key); } else { \EasyPost\EasyPost::setApiKey($woocommerce_easypost_live_api_key); } 

		$_SESSION['shippingid'] = $_POST ['shippingid']; 
		if(empty($_SESSION['shippingid'])){
 			$easypost_shipping_id = get_post_meta($order_id, '_wanderlustshipid');		
			$easypost_shipping_orderid = get_post_meta($order_id, '_wanderlustshiporderid');
			$_SESSION['shippingid'] = $easypost_shipping_id[0];
		}
		$order = $_POST ['shiporder']; 
		$shipment = \EasyPost\Shipment::retrieve($_SESSION['shippingid']);
 		$tracking = $shipment->tracker->tracking_details;

		 foreach ($tracking as $key) {
 			 echo '<h4>Message</h4>';
		 	 echo $key['message'];
		 	 echo ' - at <span style="font-size:11px;font-style: italic;">';
		 	 echo $key['datetime'];
		 	 echo '</br>';
			 //echo '</br><h4>Status</h4>';
			 //echo $key['status'];
		 }

		//$order = new WC_Order( $order );
		//$order->add_order_note(  sprintf( "Tracking Status: '%s'",  $message ) ); 
		//die($results);
	}
	add_action('wanderlust_label_tracking_hook', 'labelinfo');

	function check_label($order_id){
 		$woocommerce_easypost_test = get_option( 'pvit_easypostwanderlust_shipper_test' );
		$woocommerce_easypost_test_api_key = get_option( 'pvit_easypostwanderlust_testkey' );
		$woocommerce_easypost_live_api_key = get_option( 'pvit_easypostwanderlust_livekey' );
		if ($woocommerce_easypost_test == 1) { \EasyPost\EasyPost::setApiKey($woocommerce_easypost_test_api_key); } else { \EasyPost\EasyPost::setApiKey($woocommerce_easypost_live_api_key); } 

		$easypost_shipping_label = get_post_meta($order_id, 'easypost_shipping_label_1');
		$easypost_shipping_id = get_post_meta($order_id, '_wanderlustshipid');		
		$easypost_shipping_orderid = get_post_meta($order_id, '_wanderlustshiporderid');
		
 			$shipment = \EasyPost\Shipment::retrieve($easypost_shipping_id[0]);
			$selected_rate = $shipment->selected_rate->rate;				 
			print_r($selected_rate);
	}	
	add_action('wanderlust_label_price_hook', 'check_label');