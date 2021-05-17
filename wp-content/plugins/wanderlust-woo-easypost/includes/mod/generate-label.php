<?php
	function buylabel(){
		$woocommerce_easypost_enabled = get_option ( 'pvit_easypostwanderlust_shipper_enable' );
		if ($woocommerce_easypost_enabled =='1') { 

			$default = esc_attr( get_option('woocommerce_default_country') );
			$country = ( ( $pos = strrpos( $default, ':' ) ) === false ) ? $default : substr( $default, 0, $pos );  
			$woocommerce_easypost_test = get_option( 'pvit_easypostwanderlust_shipper_test' );
			$woocommerce_easypost_test_api_key = get_option( 'pvit_easypostwanderlust_testkey' );
			$woocommerce_easypost_live_api_key = get_option( 'pvit_easypostwanderlust_livekey' );
			$woocommerce_easypost_customs_info_description = get_option( 'pvit_easypostwanderlust_customsdescription' );
			$woocommerce_easypost_customs_info_hs_tariff_number = get_option( 'pvit_easypostwanderlust_customshs' );
			$woocommerce_easypost_customs_info_contents_type = get_option( 'pvit_easypostwanderlust_customstype' );
			$woocommerce_easypost_company = get_option( 'pvit_easypostwanderlust_sender_company' ); 
			$woocommerce_easypost_street1 = get_option( 'pvit_easypostwanderlust_sender_address1' );
			$woocommerce_easypost_city = get_option( 'pvit_easypostwanderlust_shipper_city' );
			$woocommerce_easypost_state = get_option( 'pvit_easypostwanderlust_sender_state' );
			$woocommerce_easypost_zip = get_option( 'pvit_easypostwanderlust_shipper_zipcode' );
			$woocommerce_easypost_phone = get_option( 'pvit_easypostwanderlust_shipper_phone' );
			$woocommerce_easypost_country = get_option( 'pvit_easypostwanderlust_shipper_country' );
			$easypostwanderlust_completed = get_option( 'pvit_easypostwanderlust_completed' );
			
			if ($woocommerce_easypost_test =='1') { \EasyPost\EasyPost::setApiKey($woocommerce_easypost_test_api_key);} else {\EasyPost\EasyPost::setApiKey($woocommerce_easypost_live_api_key);} 


			$order_id =  $_POST ['orderid'];
			$orders = wc_get_order( $order_id  );

			$sendtext = $_POST ['sendtext'];
			session_start();
			$_SESSION['carrier'] = $_POST ['carrier'];
			$_SESSION['shipservice'] = $_POST ['shipservice'];
			$_SESSION['send_email'] = $_POST ['send_email']; 
			$_SESSION['shippingid'] = $_POST ['shippingid']; 
			$residential_to_address = $_SESSION['residential_to_address'];
			$_SESSION['valorpaquete'] = $_POST ['valuenuevo']; 		

			try {
				
				if(!empty($_SESSION['shippingid']) && empty($_SESSION['multilabel'])){ //IF IS FLAT BOX
					$shipment = \easypost\Shipment::retrieve($_SESSION['shippingid']);
					$shipment->buy($shipment->lowest_rate(array($_SESSION['carrier']), array($_SESSION['shipservice'])));
					
					  $date = strtotime( date('Y-m-d') );
					  $tracking_provider = strtolower($shipment->selected_rate->carrier);
					  update_post_meta($order_id, 'easypost_shipping_label_1', $shipment->postage_label->label_url); 
					  update_post_meta($order_id, '_tracking_number',  $shipment->tracking_code);
					  update_post_meta($order_id, '_tracking_provider', $tracking_provider );   
					  update_post_meta($order_id, '_date_shipped', $date);
					  update_post_meta($order_id, '_wanderlustshipid', $shipment->id);
					  if($easypostwanderlust_completed == '1') {$orders->update_status('completed', 'order_note');}
					  
						$orders->add_order_note(
						  sprintf(
							  "Shipping label available at: '%s'",
							  $shipment->postage_label->label_url
						  )
						);

						$orders->add_order_note(
						  sprintf(
							  "Tracking Code: '%s'",
							  $shipment->tracking_code
						  )
						);

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

	
						$save_path = plugin_dir_path ( __FILE__ ) . 'generated_labels/';
						$save_url = plugin_dir_url(dirname(__FILE__)) . 'mod/generated_labels/';
	
						$fp = fopen($save_path . $shipment->tracking_code . '.png', 'wb');
						$content = file_get_contents($shipment->postage_label->label_url);
						fwrite($fp, $content); //Create PNG or PDF file
						fclose($fp);
	
						echo '<h3>Shipping Label</h3>';   
						echo  '<div style="cursor: pointer;" class="print"  data-imgid="'. $save_url . $shipment->tracking_code .'.png"><a href="#"><img src="'. $save_url .  $shipment->tracking_code .'.png" width="150" height="auto" alt="'. $shipment->selected_rate->service .'" title="'. $shipment->selected_rate->service .'"></a></div>';
	
				} else {  //IF IS REGULAR ORDER
 					$order = \easypost\Order::retrieve($_SESSION['multilabel']);	
					$order->buy(array("carrier" => $_SESSION['carrier'], "service" => $_SESSION['shipservice']));
 
					echo '<h3>Shipping Label</h3>';  

					$countlabels = 0;
					// CHECK ALL SHIMPMENTS -- STARTS
					foreach($order['shipments'] as $shipment)  {
						$countlabels++; 
						//print_r($order['to_address']['country']);
						if($shipment->selected_rate->service == 'Xpresspost'){
							
							// SAVE LABEL ON FTP -- STARTS
							$save_path = plugin_dir_path ( __FILE__ ) . 'generated_labels/';
							$save_url = plugin_dir_url(dirname(__FILE__)) . 'mod/generated_labels/';
							$fp = fopen($save_path . $shipment->tracking_code . '.png', 'wb'); //Create PNG or PDF file
							$content = file_get_contents($shipment->postage_label->label_url);
							fwrite($fp, $content); 
							fclose($fp);
							$locallabel = $save_url . $shipment->tracking_code .'.png';
							// SAVE LABEL ON FTP -- ENDS	
							
							$easyposturl = 'http://assets.geteasypost.com/postage_labels/labels/';
							$labelname = str_replace($easyposturl,'',$shipment->postage_label->label_url);
							$labelnameb = str_replace('.png','',$labelname);
							
							$stamp = $save_url . 'stamp.png';

							$im = imagecreatefrompng($locallabel);
							$stamp = imagecreatefrompng($stamp);
							$marge_right = 1215;
							$marge_bottom = 1568;
							$sx = imagesx($stamp);
							$sy = imagesy($stamp);
							imagecopymerge($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp), 100);

							// Save the image to file and free memory
							imagepng($im, $stamp = $save_path . $shipment->tracking_code .'.png');
							imagedestroy($im);											
							
							
 							// SHOW LABEL IMAGES -- STARTS
							echo  '<div style="cursor: pointer;" class="print"  data-imgid="'. $locallabel .'"><a href="#"><img src="'. $locallabel .'" width="150" height="auto" alt="'. $shipment->selected_rate->service .'" title="'. $shipment->selected_rate->service .'"></a></div>';
			
							// SHOW LABEL IMAGES -- ENDS	
							
							// UPDATE ORDER INFO -- STARTS
							$today = date("m/d/Y"); 
							$date = strtotime( date('Y-m-d') );
							$tracking_provider = strtolower($shipment->selected_rate->carrier);
							
							update_post_meta($order_id, 'easypost_shipping_label_1', $locallabel); 	
							
							update_post_meta($order_id, '_tracking_number',  $shipment->tracking_code);
							update_post_meta($order_id, '_tracking_provider', $tracking_provider );   
							update_post_meta($order_id, '_date_shipped', $date);
							update_post_meta($order_id, '_wanderlustshipid', $shipment->id);
							update_post_meta($order_id, '_wanderlustshiporderid', $_SESSION['multilabel']);				
							if($easypostwanderlust_completed == '1') {$orders->update_status('completed', 'order_note');}

							$orders->add_order_note(
								sprintf(
								  "Shipping label available at: '%s'",
								  $shipment->postage_label->label_url
								)
							);

							$orders->add_order_note(
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
							
						} else if($shipment->selected_rate->service == 'PriorityMailInternational'){
							
							// SAVE LABEL ON FTP -- STARTS
							$save_path = plugin_dir_path ( __FILE__ ) . 'generated_labels/';
							$save_url = plugin_dir_url(dirname(__FILE__)) . 'mod/generated_labels/';
							$fp = fopen($save_path . $shipment->tracking_code . '.png', 'wb'); //Create PNG or PDF file
							$content = file_get_contents($shipment->postage_label->label_url);
							fwrite($fp, $content); 
							fclose($fp);
							$locallabel = $save_url . $shipment->tracking_code .'.png';
							// SAVE LABEL ON FTP -- ENDS	
							
							$easyposturl = 'http://assets.geteasypost.com/postage_labels/labels/';
							$labelname = str_replace($easyposturl,'',$shipment->postage_label->label_url);
							$labelnameb = str_replace('.png','',$labelname);
												
							$image = imagecreatefrompng($locallabel);
							$filename_a = $labelnameb . '_a.png';
							$filename_b = $labelnameb . '_b.png';
							$filename_c = $labelnameb . '_c.png';
							$filename_d = $labelnameb . '_d.png';
 
							$thumb_width = 1798;
							$thumb_height = 1200;

							$width = imagesx($image);
							$height = imagesy($image);

							$original_aspect = $width / $height;
							$thumb_aspect = $thumb_width / $thumb_height;

							if ( $original_aspect >= $thumb_aspect ) {
							   // If image is wider than thumbnail (in aspect ratio sense)
							   $new_height = $thumb_height;
							   $new_width = $width / ($height / $thumb_height);
							} else {
							   // If the thumbnail is wider than the image
							   $new_width = $thumb_width;
							   $new_height = $height / ($width / $thumb_width);
							}

							$thumb_a = imagecreatetruecolor( $thumb_width, $thumb_height );
							$thumb_b = imagecreatetruecolor( $thumb_width, $thumb_height );
							$thumb_c = imagecreatetruecolor( $thumb_width, $thumb_height );
							$thumb_d = imagecreatetruecolor( $thumb_width, $thumb_height );

							// Resize and crop
							imagecopyresampled($thumb_a, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
							imagecopyresampled($thumb_b, $image, 0, 0, 1798, 0, $new_width, $new_height, $width, $height);
							imagecopyresampled($thumb_c, $image, 0, 0, 3599, 0, $new_width, $new_height, $width, $height);
							imagecopyresampled($thumb_d, $image, 0, 0, 5399, 0, $new_width, $new_height, $width, $height);



							imagepng($thumb_a, $filename_a, 9);
							imagepng($thumb_b, $filename_b, 9);
							imagepng($thumb_c, $filename_c, 9);
							imagepng($thumb_d, $filename_d, 9);	
							
 							// SHOW LABEL IMAGES -- STARTS
							echo  '<div style="cursor: pointer;" class="print"  data-imgid="'. $filename_a .'"><a href="#"><img src="'. $filename_a .'" width="150" height="auto" alt="'. $shipment->selected_rate->service .'" title="'. $shipment->selected_rate->service .'"></a></div>';
							echo  '<div style="cursor: pointer;" class="print"  data-imgid="'. $filename_b .'"><a href="#"><img src="'. $filename_b .'" width="150" height="auto" alt="'. $shipment->selected_rate->service .'" title="'. $shipment->selected_rate->service .'"></a></div>';
							echo  '<div style="cursor: pointer;" class="print"  data-imgid="'. $filename_c .'"><a href="#"><img src="'. $filename_c .'" width="150" height="auto" alt="'. $shipment->selected_rate->service .'" title="'. $shipment->selected_rate->service .'"></a></div>';
							echo  '<div style="cursor: pointer;" class="print"  data-imgid="'. $filename_d .'"><a href="#"><img src="'. $filename_d .'" width="150" height="auto" alt="'. $shipment->selected_rate->service .'" title="'. $shipment->selected_rate->service .'"></a></div>';

							// SHOW LABEL IMAGES -- ENDS	
							
							// UPDATE ORDER INFO -- STARTS
							$today = date("m/d/Y"); 
							$date = strtotime( date('Y-m-d') );
							$tracking_provider = strtolower($shipment->selected_rate->carrier);
							
							update_post_meta($order_id, 'easypost_shipping_label_1', $filename_a); 
							update_post_meta($order_id, 'easypost_shipping_label_2', $filename_b); 
 							update_post_meta($order_id, 'easypost_shipping_label_3', $filename_c); 
 							update_post_meta($order_id, 'easypost_shipping_label_4', $filename_d); 	
							
							update_post_meta($order_id, '_tracking_number',  $shipment->tracking_code);
							update_post_meta($order_id, '_tracking_provider', $tracking_provider );   
							update_post_meta($order_id, '_date_shipped', $date);
							update_post_meta($order_id, '_wanderlustshipid', $shipment->id);
							update_post_meta($order_id, '_wanderlustshiporderid', $_SESSION['multilabel']);				
							if($easypostwanderlust_completed == '1') {$orders->update_status('completed', 'order_note');}

							$orders->add_order_note(
								sprintf(
								  "Shipping label available at: '%s'",
								  $shipment->postage_label->label_url
								)
							);

							$orders->add_order_note(
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
							
						} else {
							// UPDATE ORDER INFO -- STARTS
							$today = date("m/d/Y"); 
							$date = strtotime( date('Y-m-d') );
							$tracking_provider = strtolower($shipment->selected_rate->carrier);
							update_post_meta($order_id, 'easypost_shipping_label_' . $countlabels, $shipment->postage_label->label_url); 
							update_post_meta($order_id, '_tracking_number',  $shipment->tracking_code);
							update_post_meta($order_id, '_tracking_provider', $tracking_provider );   
							update_post_meta($order_id, '_date_shipped', $date);
							update_post_meta($order_id, '_wanderlustshipid', $shipment->id);
							update_post_meta($order_id, '_wanderlustshiporderid', $_SESSION['multilabel']);				
							if($easypostwanderlust_completed == '1') {$orders->update_status('completed', 'order_note');}

							/*
							$shipment = \easypost\Shipment::retrieve($shipment->id);
							$shipment->label(array('file_format' => 'zpl'));
							print $shipment->postage_label->label_zpl_url;

							$shipment = \easypost\Shipment::retrieve($shipment->id);
							$shipment->label(array('file_format' => 'pdf'));
							print $shipment->postage_label->label_pdf_url;
							*/
							$orders->add_order_note(
								sprintf(
								  "Shipping label available at: '%s'",
								  $shipment->postage_label->label_url
								)
							);

							$orders->add_order_note(
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
					}
					// CHECK ALL SHIMPMENTS -- ENDS
 				} 		

				// INSURE PACKAGE -- STARTS
 				if($_POST ['insurance']  == '1'){
 					$shipsid = $_SESSION['shippingid'];
 					$packagevalue = $_SESSION['valorpaquete'];
 					insurepackage($shipsid, $packagevalue);
 				}
				// INSURE PACKAGE -- ENDS

			} catch (Exception $e) {
				echo 'Caught exception: ',  $e->getMessage(), "\n"; // ERRORS -- STARTS/ENDS
			}	
		die($results);
		}
	} // END FUNCTION //
	add_action('buylabel_hook', 'buylabel');
?>