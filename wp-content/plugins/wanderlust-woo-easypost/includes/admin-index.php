<?php   
global $woocommerce, $wpdb, $table_prefix;
$usps_licensekey = get_option ( 'pvit_easypostwanderlust_licensekey' );	
$woocommerce_easypost_enabled = get_option ( 'pvit_easypostwanderlust_shipper_enable' );
if ($woocommerce_easypost_enabled =='1') { ?>

<?php	
$prefixbox = $wpdb->prefix;
$site = get_site_url(); 
if ($_GET ['order_id']) {
	$order_id = $_GET ['order_id'];
 
	
	
	$order = get_post ( $order_id );
	if (! $order || $order->post_type != 'shop_order') {	
?>

<?php
	} else {
		$order = wc_get_order( $order->ID );
		$weight_unit = esc_attr( get_option('woocommerce_weight_unit' ));		
		$shipping_info ['recipient'] = array (
				'country_code' => $order->shipping_country,
				'company' => $order->shipping_company,
				'contact_name' => $order->shipping_first_name . ' ' . $order->shipping_last_name,
				'address1' => $order->shipping_address_1,
				'address2' => $order->shipping_address_2,
				'city' => $order->shipping_city,
				'state' => $order->shipping_state,
				'postcode' => $order->shipping_postcode,
				'phone' => $order->billing_phone,
				'ShippingM' => $order->shipping_method_title
		);
  		$admin_email = get_option('admin_email');  
	}
}

?>

<?php if (empty($order_id)){ ?>

<div class="error fade">
	<p>
		Please go to the <a href="edit.php?post_type=shop_order">Orders page</a> and select one order.
	</p>
</div>



<?php } else {  ?> 


<div id="easypost_wanderlust" class="wrap">
 	    <h2>Generate Shipping Labels</h2>
		<input type="hidden" value="<?php echo $order_id;  ?>" id="order_id" name="order_id" />

	    <?php
	    $presets = get_option ( 'wc_usps_label_presets', array () );
	    if (! is_array ( $presets ))
	    	$presets = unserialize ( $presets );
	    
   		if (isset ( $_POST ['shipment_processs'] )) {
   			$orderid =  $_GET ['order_id'];

				$client_country =$_POST ['shipment_country'];  
				$client_company = $order->shipping_company;
				$client_name = $order->shipping_first_name . ' ' . $order->shipping_last_name;
				$client_fname =  $order->shipping_first_name;
				$client_lname = $order->shipping_last_name;
				$client_address1 = $order->shipping_address_1. ' ' . $order->shipping_address_2;
				$client_address1a = $order->shipping_address_1;
				$client_address2 = $order->shipping_address_2;
				$client_city = $order->shipping_city;
				$client_state = $order->shipping_state;
				$client_zip = $order->shipping_postcode;
				$client_phone = $order->billing_phone;
				$client_email = $order->billing_email;	
				$shipping_info_items = array ();
				$total_weight = 0;
 				$dimension_unit = esc_attr( get_option('woocommerce_dimension_unit' ));
 				$dimensionmul = 0;
 						if ($dimension_unit == 'in') { $dimensionmul = 1;}
						if ($dimension_unit == 'm') { $dimensionmul =  39.3701;}
						if ($dimension_unit == 'cm') {  $dimensionmul =  0.393701;}
						if ($dimension_unit == 'mm') { $dimensionmul =  0.0393701;}
						if ($dimension_unit == 'yd') { $dimensionmul =  36;}
 				$largocaja = $_POST ['shipment_packages_length'] * $dimensionmul;
 				$anchocaja =$_POST ['shipment_packages_width'] * $dimensionmul;
 				$altocaja =$_POST ['shipment_packages_height'] * $dimensionmul;
 				$valorpaquete =$_POST ['shipment_packages_value']; 
 				$girth = 2*	($altocaja + $anchocaja);					
 				$shipping_info ['items'] = $shipping_info_items;
 				$shipping_info ['total_weight'] = $total_weight;
				$pesototal =$_POST ['shipment_packages_weight'];
				$today = date("m/d/Y"); 
				$date = strtotime( date('Y-m-d') );
			//$shippingMethod2  = $order->shipping_method_title;
				$shippingMethod2  = $shipment_methods; 
	if ($error != false) { ?>
<div style="float: left;background: aliceblue;padding: 20px;border-radius: 10px;width: 100%;">
<h1>We found some errors, please fix:</h1>
<span><?php echo $error; ?></span>
</div>
<?php } else { 	 ?>	
<?php }	 ?>	    
 
<?php }	echo '<script>var shipment_presets =' . json_encode($presets) . '</script>'; ?>	  
<form action="" method="post" id="wps_poll_question">
		<div style="clear: both">
			<div id="toinfo" style="float: right; margin-right: 40px;max-width: 30%;">
				<h3>Shipping To.</h3>
			
			<?php 
	 			//verify address
				$client_country = $order->shipping_country;  
				$client_company = $order->shipping_company;
				$client_name = $order->shipping_first_name . ' ' . $order->shipping_last_name;
				$client_fname =  $order->shipping_first_name;
				$client_lname = $order->shipping_last_name;
				$client_address1 = $order->shipping_address_1. ' ' . $order->shipping_address_2;
				$client_address1a = $order->shipping_address_1;
				$client_address2 = $order->shipping_address_2;
				$client_city = $order->shipping_city;
				$client_state = $order->shipping_state;
				$client_zip = $order->shipping_postcode;
				$client_phone = $order->billing_phone;
				$client_email = $order->billing_email; 
			   	if($client_country == 'US'){
						$to_address =  \EasyPost\Address::create(
							array(
								"name"    => $client_name,
								"company" => $client_company,
								"street1" => $client_address1a,
								"street2" => $client_address2,
								"city"    => $client_city,
								"state"   => $client_state,
								"zip"     => $client_zip,
								"phone"   => $client_phone,
								"country" => $client_country,
								"email" => $client_email,
								"residential" => $residential,
							)
						);
						try	{
							$to_address = $to_address->verify();
							echo '<strong>ADDRESS - VERIFIED</strong><br /> <br />';
						} catch (Exception $e) {
							
 							echo '<pre>';print_r($e->ecode);echo'</pre>';
							echo '<strong>ADDRESS - NOT VERIFIED</strong><br /><br /> ';
 						}
 	    		}
				?>
			<?php if(!empty($to_address)){ ?>
					<strong><?php echo $to_address['name'];?></strong><br />
					<?php if(!empty($to_address['company'])){ echo $to_address['company'] . '<br />';}?>
					<?php echo $to_address['street1'];?> <?php echo $to_address['street2'];?> <br />
					<?php echo $to_address['city'];?>, <?php echo $to_address['state'];?>, <?php echo $to_address['zip'];?> <br />
					Contact Phone: <?php echo $to_address['phone'];?>  <br />
					Contact Email: <?php echo $to_address['email'];?>  <br />
					<br /> 
					
 			<?php } else {	?>
				
					<strong><?php echo $order->shipping_first_name . ' ' . $order->shipping_last_name;?></strong><br />
					<?php echo $order->shipping_address_1;?>	<?php if(!empty($order->shipping_address_2)) echo $order->shipping_address_2;?> <br />
					<?php echo $order->shipping_city;?>, <?php echo $order->shipping_state;?>, <?php echo $order->shipping_country;?>, <?php echo $order->shipping_postcode;?><br />
					Contact phone: <?php echo $order->billing_phone;?><br /> <br /> 
				
			<?php } ?>
 				<ul>
					<li><label for="shipment_to_country">Country/Location<span> *</span>:
					</label> <br /> <select id="tocountry" name="shipment_to_country">
							<option value="AF"<?php selected('AF', $shipping_info['recipient']['country_code']);?>>Afghanistan</option>
							<option value="AX"<?php selected('AX', $shipping_info['recipient']['country_code']);?>>Åland Islands</option>
							<option value="AL"<?php selected('AL', $shipping_info['recipient']['country_code']);?>>Albania</option>
							<option value="DZ"<?php selected('DZ', $shipping_info['recipient']['country_code']);?>>Algeria</option>
							<option value="AS"<?php selected('AS', $shipping_info['recipient']['country_code']);?>>American	Samoa</option>
							<option value="AD"<?php selected('AD', $shipping_info['recipient']['country_code']);?>>Andorra</option>
							<option value="AO"<?php selected('AO', $shipping_info['recipient']['country_code']);?>>Angola</option>
							<option value="AI"<?php selected('AI', $shipping_info['recipient']['country_code']);?>>Anguilla</option>
							<option value="AQ"<?php selected('AQ', $shipping_info['recipient']['country_code']);?>>Antarctica</option>
							<option value="AG"<?php selected('AG', $shipping_info['recipient']['country_code']);?>>Antigua and Barbuda</option>
							<option value="AR"<?php selected('AR', $shipping_info['recipient']['country_code']);?>>Argentina</option>
							<option value="AM"<?php selected('AM', $shipping_info['recipient']['country_code']);?>>Armenia</option>
							<option value="AW"<?php selected('AW', $shipping_info['recipient']['country_code']);?>>Aruba</option>
							<option value="AU"<?php selected('AU', $shipping_info['recipient']['country_code']);?>>Australia</option>
							<option value="AT"<?php selected('AT', $shipping_info['recipient']['country_code']);?>>Austria</option>
							<option value="AZ"<?php selected('AZ', $shipping_info['recipient']['country_code']);?>>Azerbaijan</option>
							<option value="BS"<?php selected('BS', $shipping_info['recipient']['country_code']);?>>Bahamas</option>
							<option value="BH"<?php selected('BH', $shipping_info['recipient']['country_code']);?>>Bahrain</option>
							<option value="BD"<?php selected('BD', $shipping_info['recipient']['country_code']);?>>Bangladesh</option>
							<option value="BB"<?php selected('BB', $shipping_info['recipient']['country_code']);?>>Barbados</option>
							<option value="BY"<?php selected('BY', $shipping_info['recipient']['country_code']);?>>Belarus</option>
							<option value="BE"<?php selected('BE', $shipping_info['recipient']['country_code']);?>>Belgium</option>
							<option value="BZ"<?php selected('BZ', $shipping_info['recipient']['country_code']);?>>Belize</option>
							<option value="BJ"<?php selected('BJ', $shipping_info['recipient']['country_code']);?>>Benin</option>
							<option value="BM"<?php selected('BM', $shipping_info['recipient']['country_code']);?>>Bermuda</option>
							<option value="BT"<?php selected('BT', $shipping_info['recipient']['country_code']);?>>Bhutan</option>
							<option value="BO"<?php selected('BO', $shipping_info['recipient']['country_code']);?>>Bolivia, Plurinational State of</option>
							<option value="BQ"<?php selected('BQ', $shipping_info['recipient']['country_code']);?>>Bonaire, Sint Eustatius and Saba</option>
							<option value="BA"<?php selected('BA', $shipping_info['recipient']['country_code']);?>>Bosnia and Herzegovina</option>
							<option value="BW"<?php selected('BW', $shipping_info['recipient']['country_code']);?>>Botswana</option>
							<option value="BV"<?php selected('BV', $shipping_info['recipient']['country_code']);?>>Bouvet Island</option>
							<option value="BR"<?php selected('BR', $shipping_info['recipient']['country_code']);?>>Brazil</option>
							<option value="IO"<?php selected('IO', $shipping_info['recipient']['country_code']);?>>British Indian Ocean Territory</option>
							<option value="BN"<?php selected('BN', $shipping_info['recipient']['country_code']);?>>Brunei Darussalam</option>
							<option value="BG"<?php selected('BG', $shipping_info['recipient']['country_code']);?>>Bulgaria</option>
							<option value="BF"<?php selected('BF', $shipping_info['recipient']['country_code']);?>>Burkina Faso</option>
							<option value="BI"<?php selected('BI', $shipping_info['recipient']['country_code']);?>>Burundi</option>
							<option value="KH"<?php selected('KH', $shipping_info['recipient']['country_code']);?>>Cambodia</option>
							<option value="CM"<?php selected('CM', $shipping_info['recipient']['country_code']);?>>Cameroon</option>
							<option value="CA"<?php selected('CA', $shipping_info['recipient']['country_code']);?>>Canada</option>
							<option value="CV"<?php selected('CV', $shipping_info['recipient']['country_code']);?>>Cape Verde</option>
							<option value="KY"<?php selected('KY', $shipping_info['recipient']['country_code']);?>>Cayman Islands</option>
							<option value="CF"<?php selected('CF', $shipping_info['recipient']['country_code']);?>>Central African Republic</option>
							<option value="TD"<?php selected('TD', $shipping_info['recipient']['country_code']);?>>Chad</option>
							<option value="CL"<?php selected('CL', $shipping_info['recipient']['country_code']);?>>Chile</option>
							<option value="CN"<?php selected('CN', $shipping_info['recipient']['country_code']);?>>China</option>
							<option value="CX"<?php selected('CX', $shipping_info['recipient']['country_code']);?>>Christmas Island</option>
							<option value="CC"<?php selected('CC', $shipping_info['recipient']['country_code']);?>>Cocos (Keeling) Islands</option>
							<option value="CO"<?php selected('CO', $shipping_info['recipient']['country_code']);?>>Colombia</option>
							<option value="KM"<?php selected('KM', $shipping_info['recipient']['country_code']);?>>Comoros</option>
							<option value="CG"<?php selected('CG', $shipping_info['recipient']['country_code']);?>>Congo</option>
							<option value="CD"<?php selected('CD', $shipping_info['recipient']['country_code']);?>>Congo, the Democratic Republic of the</option>
							<option value="CK"<?php selected('CK', $shipping_info['recipient']['country_code']);?>>Cook Islands</option>
							<option value="CR"<?php selected('CR', $shipping_info['recipient']['country_code']);?>>Costa Rica</option>
							<option value="CI"<?php selected('CI', $shipping_info['recipient']['country_code']);?>>Côte d'Ivoire</option>
							<option value="HR"<?php selected('HR', $shipping_info['recipient']['country_code']);?>>Croatia</option>
							<option value="CU"<?php selected('CU', $shipping_info['recipient']['country_code']);?>>Cuba</option>
							<option value="CW"<?php selected('CW', $shipping_info['recipient']['country_code']);?>>Curaçao</option>
							<option value="CY"<?php selected('CY', $shipping_info['recipient']['country_code']);?>>Cyprus</option>
							<option value="CZ"<?php selected('CZ', $shipping_info['recipient']['country_code']);?>>Czech Republic</option>
							<option value="DK"<?php selected('DK', $shipping_info['recipient']['country_code']);?>>Denmark</option>
							<option value="DJ"<?php selected('DJ', $shipping_info['recipient']['country_code']);?>>Djibouti</option>
							<option value="DM"<?php selected('DM', $shipping_info['recipient']['country_code']);?>>Dominica</option>
							<option value="DO" <?php selected('DO', $shipping_info['recipient']['country_code']);?>>Dominican Republic</option>
							<option value="EC" <?php selected('EC', $shipping_info['recipient']['country_code']);?>>Ecuador</option>
							<option value="EG" <?php selected('EG', $shipping_info['recipient']['country_code']);?>>Egypt</option>
							<option value="SV" <?php selected('SV', $shipping_info['recipient']['country_code']);?>>El Salvador</option>
							<option value="GQ" <?php selected('GQ', $shipping_info['recipient']['country_code']);?>>Equatorial Guinea</option>
							<option value="ER" <?php selected('ER', $shipping_info['recipient']['country_code']);?>>Eritrea</option>
							<option value="EE" <?php selected('EE', $shipping_info['recipient']['country_code']);?>>Estonia</option>
							<option value="ET" <?php selected('ET', $shipping_info['recipient']['country_code']);?>>Ethiopia</option>
							<option value="FK" <?php selected('FK', $shipping_info['recipient']['country_code']);?>>Falkland Islands (Malvinas)</option>
							<option value="FO"<?php selected('FO', $shipping_info['recipient']['country_code']);?>>Faroe Islands</option>
							<option value="FJ"<?php selected('FJ', $shipping_info['recipient']['country_code']);?>>Fiji</option>
							<option value="FI"<?php selected('FI', $shipping_info['recipient']['country_code']);?>>Finland</option>
							<option value="FR"<?php selected('FR', $shipping_info['recipient']['country_code']);?>>France</option>
							<option value="GF"<?php selected('GF', $shipping_info['recipient']['country_code']);?>>French Guiana</option>
							<option value="PF"<?php selected('PF', $shipping_info['recipient']['country_code']);?>>French Polynesia</option>
							<option value="TF"<?php selected('TF', $shipping_info['recipient']['country_code']);?>>French Southern Territories</option>
							<option value="GA"<?php selected('GA', $shipping_info['recipient']['country_code']);?>>Gabon</option>
							<option value="GM"<?php selected('GM', $shipping_info['recipient']['country_code']);?>>Gambia</option>
							<option value="GE"<?php selected('GE', $shipping_info['recipient']['country_code']);?>>Georgia</option>
							<option value="DE"<?php selected('DE', $shipping_info['recipient']['country_code']);?>>Germany</option>
							<option value="GH"<?php selected('GH', $shipping_info['recipient']['country_code']);?>>Ghana</option>
							<option value="GI"<?php selected('GI', $shipping_info['recipient']['country_code']);?>>Gibraltar</option>
							<option value="GR"<?php selected('GR', $shipping_info['recipient']['country_code']);?>>Greece</option>
							<option value="GL"<?php selected('GL', $shipping_info['recipient']['country_code']);?>>Greenland</option>
							<option value="GD"<?php selected('GD', $shipping_info['recipient']['country_code']);?>>Grenada</option>
							<option value="GP" <?php selected('GP', $shipping_info['recipient']['country_code']);?>>Guadeloupe</option>
							<option value="GU"<?php selected('GU', $shipping_info['recipient']['country_code']);?>>Guam</option>
							<option value="GT"<?php selected('GT', $shipping_info['recipient']['country_code']);?>>Guatemala</option>
							<option value="GG"<?php selected('GG', $shipping_info['recipient']['country_code']);?>>Guernsey</option>
							<option value="GN"<?php selected('GN', $shipping_info['recipient']['country_code']);?>>Guinea</option>
							<option value="GW"<?php selected('GW', $shipping_info['recipient']['country_code']);?>>Guinea-Bissau</option>
							<option value="GY"<?php selected('GY', $shipping_info['recipient']['country_code']);?>>Guyana</option>
							<option value="HT"<?php selected('HT', $shipping_info['recipient']['country_code']);?>>Haiti</option>
							<option value="HM"<?php selected('HM', $shipping_info['recipient']['country_code']);?>>Heard Island and McDonald Islands</option>
							<option value="VA"<?php selected('VA', $shipping_info['recipient']['country_code']);?>>Holy See (Vatican City State)</option>
							<option value="HN"<?php selected('HN', $shipping_info['recipient']['country_code']);?>>Honduras</option>
							<option value="HK"<?php selected('HK', $shipping_info['recipient']['country_code']);?>>Hong Kong</option>
							<option value="HU"<?php selected('HU', $shipping_info['recipient']['country_code']);?>>Hungary</option>
							<option value="IS"<?php selected('IS', $shipping_info['recipient']['country_code']);?>>Iceland</option>
							<option value="IN"<?php selected('IN', $shipping_info['recipient']['country_code']);?>>India</option>
							<option value="ID"<?php selected('ID', $shipping_info['recipient']['country_code']);?>>Indonesia</option>
							<option value="IR"<?php selected('IR', $shipping_info['recipient']['country_code']);?>>Iran, Islamic Republic of</option>
							<option value="IQ"<?php selected('IQ', $shipping_info['recipient']['country_code']);?>>Iraq</option>
							<option value="IE"<?php selected('IE', $shipping_info['recipient']['country_code']);?>>Ireland</option>
							<option value="IM"<?php selected('IM', $shipping_info['recipient']['country_code']);?>>Isle of Man</option>
							<option value="IL"<?php selected('IL', $shipping_info['recipient']['country_code']);?>>Israel</option>
							<option value="IT"<?php selected('IT', $shipping_info['recipient']['country_code']);?>>Italy</option>
							<option value="JM"<?php selected('JM', $shipping_info['recipient']['country_code']);?>>Jamaica</option>
							<option value="JP"<?php selected('JP', $shipping_info['recipient']['country_code']);?>>Japan</option>
							<option value="JE"<?php selected('JE', $shipping_info['recipient']['country_code']);?>>Jersey</option>
							<option value="JO"<?php selected('JO', $shipping_info['recipient']['country_code']);?>>Jordan</option>
							<option value="KZ"<?php selected('KZ', $shipping_info['recipient']['country_code']);?>>Kazakhstan</option>
							<option value="KE"<?php selected('KE', $shipping_info['recipient']['country_code']);?>>Kenya</option>
							<option value="KI"<?php selected('KI', $shipping_info['recipient']['country_code']);?>>Kiribati</option>
							<option value="KP"<?php selected('KP', $shipping_info['recipient']['country_code']);?>>Korea, Democratic People's Republic of</option>
							<option value="KR"<?php selected('KR', $shipping_info['recipient']['country_code']);?>>Korea, Republic of</option>
							<option value="KW"<?php selected('KW', $shipping_info['recipient']['country_code']);?>>Kuwait</option>
							<option value="KG"<?php selected('KG', $shipping_info['recipient']['country_code']);?>>Kyrgyzstan</option>
							<option value="LA"<?php selected('LA', $shipping_info['recipient']['country_code']);?>>Lao People's Democratic Republic</option>
							<option value="LV"<?php selected('LV', $shipping_info['recipient']['country_code']);?>>Latvia</option>
							<option value="LB"<?php selected('LB', $shipping_info['recipient']['country_code']);?>>Lebanon</option>
							<option value="LS"<?php selected('LS', $shipping_info['recipient']['country_code']);?>>Lesotho</option>
							<option value="LR"<?php selected('LR', $shipping_info['recipient']['country_code']);?>>Liberia</option>
							<option value="LY"<?php selected('LY', $shipping_info['recipient']['country_code']);?>>Libya</option>
							<option value="LI"<?php selected('LI', $shipping_info['recipient']['country_code']);?>>Liechtenstein</option>
							<option value="LT"<?php selected('LT', $shipping_info['recipient']['country_code']);?>>Lithuania</option>
							<option value="LU"<?php selected('LU', $shipping_info['recipient']['country_code']);?>>Luxembourg</option>
							<option value="MO"<?php selected('MO', $shipping_info['recipient']['country_code']);?>>Macao</option>
							<option value="MK"<?php selected('MK', $shipping_info['recipient']['country_code']);?>>Macedonia, the former Yugoslav Republic of</option>
							<option value="MG"<?php selected('MG', $shipping_info['recipient']['country_code']);?>>Madagascar</option>
							<option value="MW"<?php selected('MW', $shipping_info['recipient']['country_code']);?>>Malawi</option>
							<option value="MY"<?php selected('MY', $shipping_info['recipient']['country_code']);?>>Malaysia</option>
							<option value="MV"<?php selected('MV', $shipping_info['recipient']['country_code']);?>>Maldives</option>
							<option value="ML"<?php selected('ML', $shipping_info['recipient']['country_code']);?>>Mali</option>
							<option value="MT"<?php selected('MT', $shipping_info['recipient']['country_code']);?>>Malta</option>
							<option value="MH"<?php selected('MH', $shipping_info['recipient']['country_code']);?>>Marshall Islands</option>
							<option value="MQ"<?php selected('MQ', $shipping_info['recipient']['country_code']);?>>Martinique</option>
							<option value="MR"<?php selected('MR', $shipping_info['recipient']['country_code']);?>>Mauritania</option>
							<option value="MU"<?php selected('MU', $shipping_info['recipient']['country_code']);?>>Mauritius</option>
							<option value="YT"<?php selected('YT', $shipping_info['recipient']['country_code']);?>>Mayotte</option>
							<option value="MX"<?php selected('MX', $shipping_info['recipient']['country_code']);?>>Mexico</option>
							<option value="FM"<?php selected('FM', $shipping_info['recipient']['country_code']);?>>Micronesia, Federated States of</option>
							<option value="MD"<?php selected('MD', $shipping_info['recipient']['country_code']);?>>Moldova, Republic of</option>
							<option value="MC"<?php selected('MC', $shipping_info['recipient']['country_code']);?>>Monaco</option>
							<option value="MN"<?php selected('MN', $shipping_info['recipient']['country_code']);?>>Mongolia</option>
							<option value="ME"<?php selected('ME', $shipping_info['recipient']['country_code']);?>>Montenegro</option>
							<option value="MS"<?php selected('MS', $shipping_info['recipient']['country_code']);?>>Montserrat</option>
							<option value="MA"<?php selected('MA', $shipping_info['recipient']['country_code']);?>>Morocco</option>
							<option value="MZ"<?php selected('MZ', $shipping_info['recipient']['country_code']);?>>Mozambique</option>
							<option value="MM"<?php selected('MM', $shipping_info['recipient']['country_code']);?>>Myanmar</option>
							<option value="NA"<?php selected('NA', $shipping_info['recipient']['country_code']);?>>Namibia</option>
							<option value="NR"<?php selected('NR', $shipping_info['recipient']['country_code']);?>>Nauru</option>
							<option value="NP"<?php selected('NP', $shipping_info['recipient']['country_code']);?>>Nepal</option>
							<option value="NL"<?php selected('NL', $shipping_info['recipient']['country_code']);?>>Netherlands</option>
							<option value="NC"<?php selected('NC', $shipping_info['recipient']['country_code']);?>>New Caledonia</option>
							<option value="NZ"<?php selected('NZ', $shipping_info['recipient']['country_code']);?>>New Zealand</option>
							<option value="NI"<?php selected('NI', $shipping_info['recipient']['country_code']);?>>Nicaragua</option>
							<option value="NE"<?php selected('NE', $shipping_info['recipient']['country_code']);?>>Niger</option>
							<option value="NG"<?php selected('NG', $shipping_info['recipient']['country_code']);?>>Nigeria</option>
							<option value="NU"<?php selected('NU', $shipping_info['recipient']['country_code']);?>>Niue</option>
							<option value="NF"<?php selected('NF', $shipping_info['recipient']['country_code']);?>>Norfolk Island</option>
							<option value="MP"<?php selected('MP', $shipping_info['recipient']['country_code']);?>>Northern Mariana Islands</option>
							<option value="NO"<?php selected('NO', $shipping_info['recipient']['country_code']);?>>Norway</option>
							<option value="OM"<?php selected('OM', $shipping_info['recipient']['country_code']);?>>Oman</option>
							<option value="PK"<?php selected('PK', $shipping_info['recipient']['country_code']);?>>Pakistan</option>
							<option value="PW"<?php selected('PW', $shipping_info['recipient']['country_code']);?>>Palau</option>
							<option value="PS"<?php selected('PS', $shipping_info['recipient']['country_code']);?>>Palestinian Territory, Occupied</option>
							<option value="PA"<?php selected('PA', $shipping_info['recipient']['country_code']);?>>Panama</option>
							<option value="PG"<?php selected('PG', $shipping_info['recipient']['country_code']);?>>Papua New Guinea</option>
							<option value="PY"<?php selected('PY', $shipping_info['recipient']['country_code']);?>>Paraguay</option>
							<option value="PE"<?php selected('PE', $shipping_info['recipient']['country_code']);?>>Peru</option>
							<option value="PH"<?php selected('PH', $shipping_info['recipient']['country_code']);?>>Philippines</option>
							<option value="PN"<?php selected('PN', $shipping_info['recipient']['country_code']);?>>Pitcairn</option>
							<option value="PL"<?php selected('PL', $shipping_info['recipient']['country_code']);?>>Poland</option>
							<option value="PT"<?php selected('PT', $shipping_info['recipient']['country_code']);?>>Portugal</option>
							<option value="PR"<?php selected('PR', $shipping_info['recipient']['country_code']);?>>Puerto Rico</option>
							<option value="QA"<?php selected('QA', $shipping_info['recipient']['country_code']);?>>Qatar</option>
							<option value="RE"<?php selected('RE', $shipping_info['recipient']['country_code']);?>>Réunion</option>
							<option value="RO"<?php selected('RO', $shipping_info['recipient']['country_code']);?>>Romania</option>
							<option value="RU"<?php selected('RU', $shipping_info['recipient']['country_code']);?>>Russian Federation</option>
							<option value="RW"<?php selected('RW', $shipping_info['recipient']['country_code']);?>>Rwanda</option>
							<option value="BL"<?php selected('BL', $shipping_info['recipient']['country_code']);?>>Saint Barthélemy</option>
							<option value="SH"<?php selected('SH', $shipping_info['recipient']['country_code']);?>>Saint Helena, Ascension and Tristan da Cunha</option>
							<option value="KN"<?php selected('KN', $shipping_info['recipient']['country_code']);?>>Saint Kitts and Nevis</option>
							<option value="LC"<?php selected('LC', $shipping_info['recipient']['country_code']);?>>Saint Lucia</option>
							<option value="MF"<?php selected('MF', $shipping_info['recipient']['country_code']);?>>Saint Martin (French part)</option>
							<option value="PM"<?php selected('PM', $shipping_info['recipient']['country_code']);?>>Saint Pierre and Miquelon</option>
							<option value="VC"<?php selected('VC', $shipping_info['recipient']['country_code']);?>>Saint Vincent and the Grenadines</option>
							<option value="WS"<?php selected('WS', $shipping_info['recipient']['country_code']);?>>Samoa</option>
							<option value="SM"<?php selected('SM', $shipping_info['recipient']['country_code']);?>>San Marino</option>
							<option value="ST"<?php selected('ST', $shipping_info['recipient']['country_code']);?>>Sao Tome and Principe</option>
							<option value="SA"<?php selected('SA', $shipping_info['recipient']['country_code']);?>>Saudi Arabia</option>
							<option value="SN"<?php selected('SN', $shipping_info['recipient']['country_code']);?>>Senegal</option>
							<option value="RS"<?php selected('RS', $shipping_info['recipient']['country_code']);?>>Serbia</option>
							<option value="SC"<?php selected('SC', $shipping_info['recipient']['country_code']);?>>Seychelles</option>
							<option value="SL"<?php selected('SL', $shipping_info['recipient']['country_code']);?>>Sierra Leone</option>
							<option value="SG"<?php selected('SG', $shipping_info['recipient']['country_code']);?>>Singapore</option>
							<option value="SX"<?php selected('SX', $shipping_info['recipient']['country_code']);?>>Sint Maarten (Dutch part)</option>
							<option value="SK"<?php selected('SK', $shipping_info['recipient']['country_code']);?>>Slovakia</option>
							<option value="SI"<?php selected('SI', $shipping_info['recipient']['country_code']);?>>Slovenia</option>
							<option value="SB"<?php selected('SB', $shipping_info['recipient']['country_code']);?>>Solomon Islands</option>
							<option value="SO"<?php selected('SO', $shipping_info['recipient']['country_code']);?>>Somalia</option>
							<option value="ZA"<?php selected('ZA', $shipping_info['recipient']['country_code']);?>>South Africa</option>
							<option value="KR"<?php selected('KR', $shipping_info['recipient']['country_code']);?>>South Corea</option>
							<option value="GS"<?php selected('GS', $shipping_info['recipient']['country_code']);?>>South Georgia and the South Sandwich Islands</option>
							<option value="SS"<?php selected('SS', $shipping_info['recipient']['country_code']);?>>South Sudan</option>
							<option value="ES"<?php selected('ES', $shipping_info['recipient']['country_code']);?>>Spain</option>
							<option value="LK"<?php selected('LK', $shipping_info['recipient']['country_code']);?>>Sri Lanka</option>
							<option value="SD"<?php selected('SD', $shipping_info['recipient']['country_code']);?>>Sudan</option>
							<option value="SR"<?php selected('SR', $shipping_info['recipient']['country_code']);?>>Suriname</option>
							<option value="SJ"<?php selected('SJ', $shipping_info['recipient']['country_code']);?>>Svalbard and Jan Mayen</option>
							<option value="SZ"<?php selected('SZ', $shipping_info['recipient']['country_code']);?>>Swaziland</option>
							<option value="SE"<?php selected('SE', $shipping_info['recipient']['country_code']);?>>Sweden</option>
							<option value="CH"<?php selected('CH', $shipping_info['recipient']['country_code']);?>>Switzerland</option>
							<option value="SY"<?php selected('SY', $shipping_info['recipient']['country_code']);?>>Syrian Arab Republic</option>
							<option value="TW"<?php selected('TW', $shipping_info['recipient']['country_code']);?>>Taiwan, Province of China</option>
							<option value="TJ"<?php selected('TJ', $shipping_info['recipient']['country_code']);?>>Tajikistan</option>
							<option value="TZ"<?php selected('TZ', $shipping_info['recipient']['country_code']);?>>Tanzania, United Republic of</option>
							<option value="TH"<?php selected('TH', $shipping_info['recipient']['country_code']);?>>Thailand</option>
							<option value="TL"<?php selected('TL', $shipping_info['recipient']['country_code']);?>>Timor-Leste</option>
							<option value="TG"<?php selected('TG', $shipping_info['recipient']['country_code']);?>>Togo</option>
							<option value="TK"<?php selected('TK', $shipping_info['recipient']['country_code']);?>>Tokelau</option>
							<option value="TO"<?php selected('TO', $shipping_info['recipient']['country_code']);?>>Tonga</option>
							<option value="TT"<?php selected('TT', $shipping_info['recipient']['country_code']);?>>Trinidad and Tobago</option>
							<option value="TN"<?php selected('TN', $shipping_info['recipient']['country_code']);?>>Tunisia</option>
							<option value="TR"<?php selected('TR', $shipping_info['recipient']['country_code']);?>>Turkey</option>
							<option value="TM"<?php selected('TM', $shipping_info['recipient']['country_code']);?>>Turkmenistan</option>
							<option value="TC"<?php selected('TC', $shipping_info['recipient']['country_code']);?>>Turks and Caicos Islands</option>
							<option value="TV"<?php selected('TV', $shipping_info['recipient']['country_code']);?>>Tuvalu</option>
							<option value="UG"<?php selected('UG', $shipping_info['recipient']['country_code']);?>>Uganda</option>
							<option value="UA"<?php selected('UA', $shipping_info['recipient']['country_code']);?>>Ukraine</option>
							<option value="AE"<?php selected('AE', $shipping_info['recipient']['country_code']);?>>United Arab Emirates</option>
							<option value="GB"<?php selected('GB', $shipping_info['recipient']['country_code']);?>>United Kingdom</option>
							<option value="US"<?php selected('US', $shipping_info['recipient']['country_code']);?>>United States</option>
							<option value="UM"<?php selected('UM', $shipping_info['recipient']['country_code']);?>>United States Minor Outlying Islands</option>
							<option value="UY"<?php selected('UY', $shipping_info['recipient']['country_code']);?>>Uruguay</option>
							<option value="UZ"<?php selected('UZ', $shipping_info['recipient']['country_code']);?>>Uzbekistan</option>
							<option value="VU"<?php selected('VU', $shipping_info['recipient']['country_code']);?>>Vanuatu</option>
							<option value="VE"<?php selected('VE', $shipping_info['recipient']['country_code']);?>>Venezuela, Bolivarian Republic of</option>
							<option value="VN"<?php selected('VN', $shipping_info['recipient']['country_code']);?>>Viet Nam</option>
							<option value="VG"<?php selected('VG', $shipping_info['recipient']['country_code']);?>>Virgin Islands, British</option>
							<option value="VI"<?php selected('VI', $shipping_info['recipient']['country_code']);?>>Virgin Islands, U.S.</option>
							<option value="WF"<?php selected('WF', $shipping_info['recipient']['country_code']);?>>Wallis and Futuna</option>
							<option value="EH"<?php selected('EH', $shipping_info['recipient']['country_code']);?>>Western Sahara</option>
							<option value="YE"<?php selected('YE', $shipping_info['recipient']['country_code']);?>>Yemen</option>
							<option value="ZM"<?php selected('ZM', $shipping_info['recipient']['country_code']);?>>Zambia</option>
							<option value="ZW"<?php selected('ZW', $shipping_info['recipient']['country_code']);?>>Zimbabwe</option>
					</select></li>
	<li><label for="shipment_to_country">Company: </label> <br /> <input type="text" size="45" name="shipment_to_company" value="<?php echo $shipping_info['recipient']['company']?>" /></li>
	<li><label for="shipment_to_name">Contact name<span> *</span>: </label> <br /> <input type="text" size="45" name="shipment_to_name" value="<?php echo $shipping_info['recipient']['contact_name']?>" />	</li>
	<li><label for="shipment_to_address1">Address 1: </label> <br /> <input type="text" size="45" name="shipment_to_address1" value="<?php echo $shipping_info['recipient']['address1']?>" /></li>
	<li><label for="shipment_to_address2">Address 2<span> *</span>: </label> <br /> <input type="text" size="45" name="shipment_to_address2" value="<?php echo $shipping_info['recipient']['address2']?>" /></li>
	<li><label for="shipment_to_zipcode">Zipcode<span> *</span>: </label> <br /> <input type="text" size="45" name="shipment_to_zipcode" value="<?php echo $shipping_info['recipient']['postcode']?>" /></li>
	<li><label for="shipment_to_city">City<span> *</span>: </label> <br /> <input type="text" size="45" name="shipment_to_city" value="<?php echo $shipping_info['recipient']['city']?>" /></li>
	<li><label for="shipment_to_state">State<span> *</span>: </label> <br /> 
						<select name="shipment_to_state" style="display: block;">
							<option value="<?php echo $shipping_info['recipient']['state'];?>"><?php echo $shipping_info['recipient']['state'];?></option>
							<option value="AL"<?php selected('AL', $shipping_info['recipient']['state']);?>>Alabama</option>
							<option value="AK"<?php selected('AK', $shipping_info['recipient']['state']);?>>Alaska</option>
							<option value="AZ"<?php selected('AZ', $shipping_info['recipient']['state']);?>>Arizona</option>
							<option value="AR"<?php selected('AR', $shipping_info['recipient']['state']);?>>Arkansas</option>
							<option value="CA"<?php selected('CA', $shipping_info['recipient']['state']);?>>California</option>
							<option value="CO"<?php selected('CO', $shipping_info['recipient']['state']);?>>Colorado</option>
							<option value="CT"<?php selected('CT', $shipping_info['recipient']['state']);?>>Connecticut</option>
							<option value="DE"<?php selected('DE', $shipping_info['recipient']['state']);?>>Delaware</option>
							<option value="DC"<?php selected('DC', $shipping_info['recipient']['state']);?>>District of Columbia</option>
							<option value="FL"<?php selected('FL', $shipping_info['recipient']['state']);?>>Florida</option>
							<option value="GA"<?php selected('GA', $shipping_info['recipient']['state']);?>>Georgia</option>
							<option value="HI"<?php selected('HI', $shipping_info['recipient']['state']);?>>Hawaii</option>
							<option value="ID"<?php selected('ID', $shipping_info['recipient']['state']);?>>Idaho</option>
							<option value="IL"<?php selected('IL', $shipping_info['recipient']['state']);?>>Illinois</option>
							<option value="IN"<?php selected('IN', $shipping_info['recipient']['state']);?>>Indiana</option>
							<option value="IA"<?php selected('IA', $shipping_info['recipient']['state']);?>>Iowa</option>
							<option value="KS"<?php selected('KS', $shipping_info['recipient']['state']);?>>Kansas</option>
							<option value="KY"<?php selected('KY', $shipping_info['recipient']['state']);?>>Kentucky</option>
							<option value="LA"<?php selected('LA', $shipping_info['recipient']['state']);?>>Louisiana</option>
							<option value="ME"<?php selected('ME', $shipping_info['recipient']['state']);?>>Maine</option>
							<option value="MD"<?php selected('MD', $shipping_info['recipient']['state']);?>>Maryland</option>
							<option value="MA"<?php selected('MA', $shipping_info['recipient']['state']);?>>Massachusetts</option>
							<option value="MI"<?php selected('MI', $shipping_info['recipient']['state']);?>>Michigan</option>
							<option value="MN"<?php selected('MN', $shipping_info['recipient']['state']);?>>Minnesota</option>
							<option value="MS"<?php selected('MS', $shipping_info['recipient']['state']);?>>Mississippi</option>
							<option value="MO"<?php selected('MO', $shipping_info['recipient']['state']);?>>Missouri</option>
							<option value="MT"<?php selected('MT', $shipping_info['recipient']['state']);?>>Montana</option>
							<option value="NE"<?php selected('NE', $shipping_info['recipient']['state']);?>>Nebraska</option>
							<option value="NV"<?php selected('NV', $shipping_info['recipient']['state']);?>>Nevada</option>
							<option value="NH"<?php selected('NH', $shipping_info['recipient']['state']);?>>New Hampshire</option>
							<option value="NJ"<?php selected('NJ', $shipping_info['recipient']['state']);?>>New Jersey</option>
							<option value="NM"<?php selected('NM', $shipping_info['recipient']['state']);?>>New Mexico</option>
							<option value="NY"<?php selected('NY', $shipping_info['recipient']['state']);?>>New York</option>
							<option value="NC"<?php selected('NC', $shipping_info['recipient']['state']);?>>North Carolina</option>
							<option value="ND"<?php selected('ND', $shipping_info['recipient']['state']);?>>North Dakota</option>
							<option value="OH"<?php selected('OH', $shipping_info['recipient']['state']);?>>Ohio</option>
							<option value="OK"<?php selected('OK', $shipping_info['recipient']['state']);?>>Oklahoma</option>
							<option value="OR"<?php selected('OR', $shipping_info['recipient']['state']);?>>Oregon</option>
							<option value="PA"<?php selected('PA', $shipping_info['recipient']['state']);?>>Pennsylvania</option>
							<option value="RI"<?php selected('RI', $shipping_info['recipient']['state']);?>>Rhode Island</option>
							<option value="SC"<?php selected('SC', $shipping_info['recipient']['state']);?>>South Carolina</option>
							<option value="SD"<?php selected('SD', $shipping_info['recipient']['state']);?>>South Dakota</option>
							<option value="TN"<?php selected('TN', $shipping_info['recipient']['state']);?>>Tennessee</option>
							<option value="TX"<?php selected('TX', $shipping_info['recipient']['state']);?>>Texas</option>
							<option value="UT"<?php selected('UT', $shipping_info['recipient']['state']);?>>Utah</option>
							<option value="VT"<?php selected('VT', $shipping_info['recipient']['state']);?>>Vermont</option>
							<option value="VA"<?php selected('VA', $shipping_info['recipient']['state']);?>>Virginia</option>
							<option value="WA"<?php selected('WA', $shipping_info['recipient']['state']);?>>Washington</option>
							<option value="WV"<?php selected('WV', $shipping_info['recipient']['state']);?>>West Virginia</option>
							<option value="WI"<?php selected('WI', $shipping_info['recipient']['state']);?>>Wisconsin</option>
							<option value="WY"<?php selected('WY', $shipping_info['recipient']['state']);?>>Wyoming</option></select></li>
					<li><label for="shipment_to_phone">Phone number<span> *</span>:
					</label> <br /> <input type="text" size="45" name="shipment_to_phone" value="<?php echo $shipping_info['recipient']['phone']?>" /></li>
			</ul>
			<div id="labels">
				<?php		$easypost_shipping_labela = get_post_meta($order_id, 'easypost_shipping_label_1');
							$easypost_shipping_labelb = get_post_meta($order_id, 'easypost_shipping_label_2');
							$easypost_shipping_labelc = get_post_meta($order_id, 'easypost_shipping_label_3');
							if (!empty($easypost_shipping_labela)){ 
								echo'<div id="label_one"><div style="cursor: pointer;" class="print" data-imgid="'.$easypost_shipping_labela[0].'"><a href="#"><img src="'.$easypost_shipping_labela[0].'" width="150" height="auto"></a></div></div>';}
							if (!empty($easypost_shipping_labelb)){ 
								echo'<div id="label_two"><div style="cursor: pointer;" class="print" data-imgid="'.$easypost_shipping_labelb[0].'"><a href="#"><img src="'.$easypost_shipping_labelb[0].'" width="150" height="auto"></a></div></div>';}
							if (!empty($easypost_shipping_labelc)){ 
								echo'<div id="label_three"><div style="cursor: pointer;" class="print" data-imgid="'.$easypost_shipping_labelc[0].'"><a href="#"><img src="'.$easypost_shipping_labelc[0].'" width="150" height="auto"></a></div></div>';}
				?>
				<div id="label_one"></div>
				<div id="label_two"></div>
				<div id="label_three"></div>
			</div>

			</div>

<div style="float: left; margin:0px;">
	<div id="order-info">
				<?php /* GET ORDER INFO */
					global $woocommerce;
					$order_info = wc_get_order($order_id);
					$items = $order_info->get_items();
	   			$productinorder =  count($items);
	   			$weight_unit = esc_attr( get_option('woocommerce_weight_unit' ));			
	   			$dimension_unit = esc_attr( get_option('woocommerce_dimension_unit' ));
	   			$client_country = $order_info->shipping_country;
					$order_totals  = get_post_meta($order_id, '_order_total' ); 
					$table_name = $wpdb->prefix . "woocommerce_order_items";
					$sql = "SELECT order_item_name FROM  $table_name WHERE order_id = $order_id AND order_item_type = 'shipping'";
					$shippingpaid = $wpdb->get_results ( $sql );
				?>

		<h1>Order Info</h1>
			<h3>Order ID: <?php  echo $order_id = $_GET ['order_id'];?>  <a href="post.php?post=<?php echo $order_id;?>&action=edit">Edit Order</a></h3> 
			<h4 style="margin: 0px;">Order Value  $ <?php echo $order_totals[0];?></h4>
			<h4 style="margin: 0px;">Shipping Method <span style="color:#444;"><?php $shippingpaid[0]->order_item_name; echo $order_info->get_shipping_to_display();?>  </span></h4>
			<h4 style="margin: 0px;">Products in the Order <?php echo $productinorder;?> <span style="cursor:pointer; color:#444;text-transform: none;">more info</span> </h4>
<div class="products">
		<?php /* SHOW ORDER INFO */   
		if ( sizeof( $items ) > 0 ) { 
			    $i = 0;
		    	$sum = 0;
		    	$prod = 0;
		    	$totales = 0;
							foreach( $items as $item ) {    				 
								if ( $item['product_id'] > 0 ) {
								 	$productid = $item['product_id']; 
									
									/* WOO 3.0 FIX */
									$_product = wc_get_product( $productid );
									$productidweights = $_product->get_weight() * $item['quantity'];
									/* WOO 3.0 FIX */
 									
									$productidweight  = get_post_meta($productid, '_weight' ); 
									$prodcutdimentionslength = get_post_meta($productid, '_length');
									$prodcutdimentionswidth = get_post_meta($productid, '_width');
									$prodcutdimentionsheight = get_post_meta($productid, '_height');
		   							$pweight = $productidweight[0] * $item['item_meta']['_qty']['0'];
		   							$i++; 
		   							$prod += $item['item_meta']['_qty']['0']; 
 										$itemtotales += $item['quantity'];
 								echo '<div class="col1">';  	
 								echo '<li style="font-weight: bold;">Product ' .	$i . '</li>'; 
							 	echo '<li>Name: ' .	$item['name'] . '</li>'; 
							 	echo '<li>Quantity: ' .	$item['quantity'] . '</li>'; 
								$variation = $item['variation_id'];
								if ( ! empty( $variation) ) { 
 									$_product = wc_get_product( $variation );
									$productidweights = $_product->get_weight() * $item['quantity'];
									
									$productidweight2  = get_post_meta($variation, '_weight' ); 
									$prodcutdimentionslength2 = get_post_meta($variation, '_length');
									$prodcutdimentionswidth2 = get_post_meta($variation, '_width');
									$prodcutdimentionsheight2 = get_post_meta($variation, '_height'); 
									$pweightb = $productidweight2[0] * $item['item_meta']['_qty']['0'];
									if(empty( $pweightb)) {
									echo '<li>Variation Weight * Qty: ' .	$productidweights . $weight_unit .'</li>'; 			
									} else {
									echo '<li>Variation Weight * Qty: ' .	$productidweights . $weight_unit .'</li>'; 
									}
									if(!empty($prodcutdimentionslength2[0])){
										echo '<li>Length: ' .	$prodcutdimentionslength2[0]. $dimension_unit . '</li>'; 
									} else {
										echo '<li>Length: ' .	$prodcutdimentionslength[0]. $dimension_unit . '</li>';
									}
									if(!empty($prodcutdimentionswidth2[0])){
										echo '<li>Width ' .	$prodcutdimentionswidth2[0]. $dimension_unit . '</li>';  
									} else {
										echo '<li>Width ' .	$prodcutdimentionswidth[0]. $dimension_unit . '</li>';
									}									
									if(!empty($prodcutdimentionsheight2[0])){
										echo '<li>Height: ' .	$prodcutdimentionsheight2[0]. $dimension_unit . '</li>';
									} else {
										echo '<li>Height: ' .	$prodcutdimentionsheight[0]. $dimension_unit . '</li>';
									}									
									$sum += $productidweights;
								} else {
 									$sum += $productidweights; 
								 	echo '<li>Weight * Qty: ' .	$productidweights. $weight_unit .'</li>'; 
									echo '<li>Length: ' .	$prodcutdimentionslength[0]. $dimension_unit . '</li>'; 
									echo '<li>Width ' .	$prodcutdimentionswidth[0]. $dimension_unit . '</li>'; 
									echo '<li>Height: ' .	$prodcutdimentionsheight[0]. $dimension_unit . '</li>';
								}
							 	echo '</div>';  	
 
								} 
							}   

		} ?>
</div>
	<?php  
		 $default = esc_attr( get_option('woocommerce_default_country') );
		 $country = ( ( $pos = strrpos( $default, ':' ) ) === false ) ? $default : substr( $default, 0, $pos );  

		 if ($client_country != $country)  {
		 $customs_info_description = get_option( 'pvit_easypostwanderlust_customsdescription' );
		 $customs_info_contents_type = get_option( 'pvit_easypostwanderlust_customstype' );

		 echo '<h4>International Order</h4>';
		 echo '<small>Product Description: </small><small>'. $customs_info_description .'</small><br>';
		 echo '<small>Contents Type: </small><small>' . $customs_info_contents_type .' *</small><br>';
		 echo '<small>* documents, gift, merchandise, returned_goods, sample, other</small>';
	} ?>
</div>


<div id="boxs-packs">

<script type="text/javascript">
jQuery(document).ready(function(){
		 jQuery('#shipment_country').val(jQuery('#tocountry option:selected').text()); 
		 jQuery('.products').hide();
		 jQuery('.removep').hide();
		 jQuery('#get_rates').hide();
		 jQuery('#generatel').hide();


		jQuery('#order-info h4 span').click(function(){
			if( jQuery('.products').is(':visible') ) {jQuery('.products').fadeOut();}
			else {jQuery('.products').fadeIn(200);}
		});

		jQuery('.removebox').click(function(){
			jQuery(this).parent().removeClass("active");
			jQuery(this).parent().fadeOut();
		});
	

		jQuery('#shipment_packages_preset').change(function(){
			//jQuery('.boxs').fadeOut();
			//jQuery('.removep').fadeIn(600);
			jQuery('#get_rates').fadeIn();
			//jQuery('.boxs').removeClass("active");
			 var box = jQuery('#shipment_packages_preset').val();
			     jQuery('#shipment_package_'+ box).addClass("active");
				 jQuery('#shipment_package_'+ box).insertAfter('#shipment_packages_container'); 
	 			 jQuery('#shipment_package_'+ box).fadeIn(200);
	 			 jQuery('#shipment_packages_weight').val(jQuery('.active ul li #weight').val()); 
	 			 jQuery('#shipment_packages_height').val(jQuery('.active ul li #height').val()); 
	 			 jQuery('#shipment_packages_length').val(jQuery('.active ul li #length').val()); 
	 			 jQuery('#shipment_packages_width').val(jQuery('.active ul li #width').val()); 
	 			 jQuery('#shipment_packages_value').val(jQuery('.active ul li #value').val()); 
			
 				if (box.length > 3) {
					//jQuery('.removep').hide(); 
					//jQuery('.boxs').fadeOut();
					//jQuery('.boxs').removeClass("active");
					//jQuery('#get_rates').hide();
 					//jQuery('#shipment_packages_container').append( '<div class="boxs flat"><input class="active" type="text" name="flat[]" value="' + jQuery('#shipment_packages_preset').val() + '"></div>');
 
				};

			return false;
		});
});
</script>

<?php 
	$weight_unit = esc_attr( get_option('woocommerce_weight_unit' ));			
 	$woocommerce_currency = get_woocommerce_currency();
	// SHOW WEIGHT AS LBS //
	if ($weight_unit=='lbs') { $lbs = $sum;}
	if ($weight_unit=='oz') { $lbs = $sum * 0.0625;}
	if ($weight_unit=='g') { $lbs = $sum * 0.00220462;}
	if ($weight_unit=='kg') { $lbs = $sum * 2.20462;}			  
 
 	// SHOW WEIGHT AS OZ //
 	if ($weight_unit=='lbs') { $sum = $sum * 16;}
	if ($weight_unit=='oz') { $sum = $sum;}
	if ($weight_unit=='g') { $sum = $sum * 0.035274;}
	if ($weight_unit=='kg') { $sum = $sum * 35.274;}
			  
	// CHECK RESIDENTIAL //
	$selectedmethod = $shippingpaid[0]->order_item_name;
 	if (strpos($selectedmethod,'HOME_DELIVERY') !== false) {
		$residentials = 'checked';
	}
	// END CHECK RESIDENTIAL //			  
			  
?>
	

<h3>Package Info</h3> 
<small style="margin-top: -15px;float: left;margin-bottom: 10px;">Weights are in Pounds (lbs) and go to one decimal point. Dimensions are in INCHES (IN) and go to one decimal point.</small>
<small style="float: left;width: auto;clear:both;">Request a signature</small>
	<select style="float: left;margin: 0px 10px;height: 25px;font-size: 9px;clear:both;" id="shipment_signature">
		<option value="NO_SIGNATURE">None</option>
		<option value="ADULT_SIGNATURE">Adult Signature</option>
		<option value="SIGNATURE">Signature</option>
	</select>

<div style="float: left;clear: both;margin-top: 5px;">
	<input id="pvit_easypostwanderlust_autoinsurance" style="float: left;margin: 1px 5px;" type="checkbox" name="pvit_easypostwanderlust_autoinsurance" value="1" <?php checked(1, get_option('pvit_easypostwanderlust_autoinsurance'));?> >	<small style="float: left;width: auto;">Insure Shipping</small> </br>
	<input id="residential_to_address" style="float: left;margin: 1px 5px;" type="checkbox" name="residential_to_address" value="1" <?php echo $residentials;?>> <small style="float: left;width: auto;">Residential Address</small> </br>
	<input id="email_label" style="float: left;margin: 1px 5px;" type="checkbox" name="pvit_easypostwanderlust_email_label" value="1" <?php checked(1, get_option('pvit_easypostwanderlust_email_label'));?> /><small style="float: left;width: auto;">Send Label via Email</small>
	<textarea style="float: left;clear: both;width: 265px;" id="sendtext" name="sendtext" class="replaceable-text" cols="45" rows="4" placeholder="Type your comment here"></textarea>
</div>

<?php $suma = round($sum);  echo '<h4 style="float: left;margin: 15px 0px;clear: both;">Total order weight <span style="color:#444;">' . $lbs  . ' '. $weight_unit .' </span>  </h4>'; ?>

 

<h4 style="float: left;clear: both;">Choose a Box:</h4>
<?php 
			  
 $wanderlust_boxes = get_option( 'woocommerce_easypostshippingtool_settings' ); 
			  
	$table_name = $wpdb->prefix . "easypost_packages";
	$sql = "SELECT * FROM $table_name";
	$packages = $wpdb->get_results( $sql );
	$packagesn =  count($packages);
	$uspsflatboxes = get_option('pvit_easypostwanderlust_usps');
	$fedexflatboxes = get_option('pvit_easypostwanderlust_fedex');
	$upsflatboxes = get_option('pvit_easypostwanderlust_ups');
	$dhlflatboxes = get_option('pvit_easypostwanderlust_dhlbox');			  
			  

	echo '<select style="float: left;margin: 10px;" id="shipment_packages_preset">';
	echo '<option value="0">Select your Box</option>';
 	
		foreach( $wanderlust_boxes['boxes']  as $boxes ) {  
			if($boxes['enabled'] == '1'){
  				echo '<option value="'  . $boxes['name'] . '"> '  . $boxes['name'] . ' </option>';		
			}
 		}

	if ($uspsflatboxes == 1) {
		echo '<option value="Card"> Card </option>';
		echo '<option value="Letter"> Letter </option>';
		echo '<option value="Flat"> Flat </option>';
		echo '<option value="Parcel"> Parcel </option>';
		echo '<option value="LargeParcel"> LargeParcel </option>';
		echo '<option value="IrregularParcel"> IrregularParcel </option>';
		echo '<option value="FlatRateEnvelope"> FlatRateEnvelope </option>';
		echo '<option value="FlatRateLegalEnvelope"> FlatRateLegalEnvelope </option>';
		echo '<option value="FlatRatePaddedEnvelope"> FlatRatePaddedEnvelope </option>';
		echo '<option value="FlatRateGiftCardEnvelope"> FlatRateGiftCardEnvelope </option>';
		echo '<option value="FlatRateWindowEnvelope"> FlatRateWindowEnvelope </option>';
		echo '<option value="FlatRateCardboardEnvelope"> FlatRateCardboardEnvelope </option>';
		echo '<option value="SmallFlatRateEnvelope"> SmallFlatRateEnvelope </option>';
		echo '<option value="SmallFlatRateBox"> SmallFlatRateBox </option>';
		echo '<option value="MediumFlatRateBox"> MediumFlatRateBox </option>';
		echo '<option value="LargeFlatRateBox"> LargeFlatRateBox </option>';
		echo '<option value="RegionalRateBoxA"> RegionalRateBoxA </option>';
		echo '<option value="RegionalRateBoxB"> RegionalRateBoxB </option>';
		echo '<option value="RegionalRateBoxC"> RegionalRateBoxC </option>';
		echo '<option value="LargeFlatRateBoardGameBox"> LargeFlatRateBoardGameBox </option>';
	}
	if ($fedexflatboxes == 1) {
		echo '<option value="FedExEnvelope"> FedEx Envelope </option>';
		echo '<option value="FedExBox"> FedEx Box </option>';
		echo '<option value="FedExPak"> FedEx Pak </option>';
		echo '<option value="FedExTube"> FedEx Tube </option>';
		echo '<option value="FedEx10kgBox"> FedEx 10kg Box </option>';
		echo '<option value="FedEx25kgBox"> FedEx 25kg Box </option>';
	}
	if ($upsflatboxes == 1) {
		echo '<option value="UPSLetter"> UPS Letter </option>';
		echo '<option value="UPSExpressBox"> UPS Express Box </option>';
		echo '<option value="UPS25kgBox"> UPS 25kg Box </option>';
		echo '<option value="UPS10kgBox"> UPS 10kg Box </option>';
		echo '<option value="Tube"> Tube </option>';
		echo '<option value="Pak"> Pak </option>';
		echo '<option value="Pallet"> Pallet </option>';
		echo '<option value="SmallExpressBox"> Small Express Box </option>';
		echo '<option value="MediumExpressBox"> Medium Express Box </option>';
		echo '<option value="LargeExpressBox"> Large Express Box </option>';
	}
	if ($dhlflatboxes == 1) {
		echo '<option value="JumboDocument"> Jumbo Document </option>';
		echo '<option value="JumboParcel"> Jumbo Parcel </option>';
		echo '<option value="Document"> Document </option>';
		echo '<option value="DHLFlyer"> DHL Flyer </option>';
		echo '<option value="Domestic"> Domestic </option>';
		echo '<option value="ExpressDocument"> Express Document </option>';
		echo '<option value="DHLExpressEnvelope"> DHL Expres sEnvelope </option>';
		echo '<option value="JumboBox"> Jumbo Box </option>';
		echo '<option value="JumboJuniorDocument"> Jumbo Junior Document </option>';
		echo '<option value="JuniorJumboBox"> Junior Jumbo Box </option>';
		echo '<option value="JumboJuniorParcel"> Jumbo Junior Parcel </option>';
		echo '<option value="OtherDHLPackaging"> Other DHL Packaging </option>';
		echo '<option value="Parcel"> Parcel </option>';
	}
	echo '</select>';
 ?>
<a style="float: left;clear: both;margin: -15px 0px 15px 0px;font-size: 11px;" href="<?php echo wp_nonce_url(admin_url('admin.php?page=wc-settings&tab=shipping&section=wc_shipping_wanderlust#packing_options')); ?>">Manage Boxes</a>
			
<div style="display:none;" class="save" id="push-me">Save Changes</div>
<div style="display:none;"  class="add"  id="push-me2">Add Box</div>
 
<div id="shipment_packages_container">

	<div style="display:none;float: left;" class="boxs" id="shipment_add_ckage">
		<h4 style="color:#444;">New Box</h4>
			<ul>
				<li style="float:left;margin-right:5px;"><label for="boxname">Box Name:</label><br /><input style="width: 140px;" id="nombre" type="text" name="boxname" size="5" /> </li>
				<li style="float:left;margin-right:5px;"><label for="shipment_weight">Weight<span> *</span>:</label><br /><input id="weight" type="text" name="shipment_weight[]" size="5" /> lbs.</li>
				<li style="float:left;margin-right:5px;"><label for="shipment_height">Height<span> *</span>:</label><br /><input id="height" type="text" name="shipment_height[]" size="5" /> in.</li>
				<li style="float:left;margin-right:5px;"><label for="shipment_length">Length<span> *</span>:</label><br /><input id="length" type="text" name="shipment_length[]" size="5"  /> in.</li>
				<li style="float:left;margin-right:5px;"><label for="shipment_width">Width<span> *</span>:</label><br /><input id="width" type="text" name="shipment_width[]" size="5" /> in.</li>
				<li style="float:right;"><label for="shipment_value">Declared Value<span> *</span>:</label><br /><input id="value" type="text" name="shipment_value[]" size="5" /> <?php echo $woocommerce_currency; ?>.</li>
				<br style="clear:both" />
			</ul>
	</div>


	<?php
			  
 	foreach( $wanderlust_boxes['boxes']  as $boxes ) {  
 		
		$boxname = $boxes['name'];  
		$height = $boxes['height']; 
		$weight = $boxes['box_weight'] + $lbs; 
		$weightoz = $boxes['box_weight'] * 16 + $sum; 
		$length = $boxes['length']; 
		$width = $boxes['width']; 
		$order_totals  = get_post_meta($order_id, '_order_total' ); 
		$order_shipping  = get_post_meta($order_id, '_order_shipping' );
		$text = $order_totals[0] - $order_shipping[0]; 
		$insurecost = $text * 0.01; 
		$boxid = $boxes['name']; 
 

	
		echo '<div style="display:none;float: left;" class="boxs" id="shipment_package_' .   $boxid .  '">';
		echo '<h4 style="color:#444;">Box: ' .    $boxname .  '</h4> <h5 style="cursor: pointer;float: left;position: absolute;margin: -34px -18px;font-size: 8px;color: white;background: rgb(165, 12, 12);border-radius: 16px;padding: 3px;width: 10px;height: 10px;line-height: 10px;text-align: center;" class="removebox">X</h5>';
		echo '<ul>';
		echo '<li style="float:left;margin-right:5px;"><label for="boxname">Box Name:</label><br /><input style="width: 140px;" id="nombre" type="text" name="boxname" size="5" value="' .    $boxname .  '" /> </li>';
		echo '<li style="float:left;margin-right:5px;"><label for="shipment_weight">Weight<span> *</span>:</label><br /><input id="weight" data-weight="' .    $weightoz .  '" type="text" name="shipment_weight[]" size="5" value="' .    $weight .  '" /> ' . $weight_unit .' .</li>';
		echo '<li style="float:left;margin-right:5px;"><label for="shipment_height">Height<span> *</span>:</label><br /><input id="height" type="text" name="shipment_height[]" size="5" value="' .    $height .  '" /> '.$dimension_unit .'.</li>';
		echo '<li style="float:left;margin-right:5px;"><label for="shipment_length">Length<span> *</span>:</label><br /><input id="length" type="text" name="shipment_length[]" size="5" value="' .    $length .  '" /> '.$dimension_unit .'.</li>';
		echo '<li style="float:left;margin-right:5px;"><label for="shipment_width">Width<span> *</span>:</label><br /><input id="width" type="text" name="shipment_width[]" size="5" value="' . $width . '" /> '.$dimension_unit .'.</li>';
		echo '<li style="float:right;"><label for="shipment_value">Declared Value<span> *</span>:</label><br /><input id="value" type="text" name="shipment_value[]" size="5" value="'. $text .'"/> '. $woocommerce_currency .'.</li>';
		echo '<br style="clear:both" /></ul>';
		echo '<div style="display:none;color: red;font-size: 11px;" class="insurance">*Shipping Insurance by EasyPost (Cost: 1% of insured value) $'. $insurecost .' </div>';		
		echo '</div> ';

		 
	} ?>	
</div>

<div style="display:none !important;"  class="removep"  id="push-me3">Delete Box</div>

<input type="hidden" value="<?php echo $sum;  ?>" id="shipment_packages_weight_flat" name="shipment_packages_weight_flat" />
<input type="hidden" value="" id="shipment_packages_weight" name="shipment_packages_weight" />
<input type="hidden" value="" id="shipment_packages_height" name="shipment_packages_height" />
<input type="hidden" value="" id="shipment_packages_length" name="shipment_packages_length" />
<input type="hidden" value="" id="shipment_packages_width" name="shipment_packages_width" />
<input type="hidden" value="" id="shipment_packages_value" name="shipment_packages_value" />
<input type="hidden" value="" id="shipment_country" name="shipment_country" />
<input type="hidden" value="<?php echo $prefixbox;  ?>" id="prefixbox" name="prefixbox" />
<input type="hidden" value="<?php echo $admin_email;  ?>" id="admin_email" name="admin_email" />
<input type="hidden" value="<?php echo $site;  ?>" id="site" name="site" />
<input type="hidden" value="<?php echo $usps_licensekey;  ?>" id="usps_licensekey" name="usps_licensekey" />
<input type="hidden" value="<?php echo $text;  ?>" id="insurances" name="insurances" />			
			

<div id="flash" style="float: left;clear: both;display:none;" ><img  style="width: 20px;" src="<?php echo plugins_url('includes/img/ajax-loader.gif',dirname(__FILE__));?>" align="absmiddle"> <span class="loading">Loading...</span></div>
<div style="float: left;clear: both;display:none;" id="test-div"></div>	
<div id="get_rates" style="width: 230px;clear: both;float: left;" class="button-primary" />Get Rates</div>

</div>
	</div>
<br style="clear: both" />
</div>
<p style="margin-top: 10px; width: 100%; clear: both;"><p style="display:none;"><?php if(!isset($_COOKIE['wanderlust_key'])) {$licence = wp_remote_get( 'https://shop.wanderlust-webdesign.com/licence/'. $usps_licensekey .'.dat', array( 'timeout' => 120, 'httpversion' => '1.1' ));$datas = unserialize($licence['body']); $send = base64_decode($datas[2]);echo $send; $seccion = $datas[3];	setcookie('wanderlust_key', $seccion, time() + (186400 * 30), "/");} else { $seccion = $_COOKIE['wanderlust_key']; }?></p><?php if (!$seccion)  {echo base64_decode('PC9icj48aDI+IEVycm9yIEludmFsaWQgTGljZW5zZSBLZXkgPC9oMj4=');} else {echo base64_decode($seccion);}?> </p>	
</form>
</div>

 <script type="text/javascript">
	jQuery(document).on('click', '.prints', function(event) {
		event.preventDefault();
 		      var image = jQuery(".print").data("imgid");
		      var win = window.open('', 'Image', 'resizable=yes,...');
		      if (win.document) {
			  	//win.document.writeln('<html><head><meta name="viewport" content="width=device-width, minimum-scale=0.1"></head><body style="margin: 0px;"><img style="-webkit-user-select: none; cursor: -webkit-zoom-in;" src="' +  image  + '" width="384" height="576"></body></html>');
				win.document.writeln('<html><head><meta name="viewport" content="width=device-width, minimum-scale=0.1"></head><body style="margin: 0px;"><img style="-webkit-user-select: none; cursor: zoom-in;" src="' +  image  + '" width="539" height="809"></body></html>');
				  win.document.close();
		          //win.focus();
		          win.print();
		          //win.close();
		      }
 	      return false;
	   });  
	 
	jQuery(document).on('click', '.zoom', function(event) {
		event.preventDefault();
 		      var image = jQuery(".print").data("imgid");
		      var win = window.open('', 'Image', 'resizable=yes,...');
		      if (win.document) {
				win.document.writeln('<img src="'+ image +'" alt="image" />');
				win.document.close();
				win.focus();
				win.print();
		      }
 	      return false;
	   });   

	jQuery('body').on('click', '.print',function(e){
		e.preventDefault();
			  var image = jQuery(this).data("imgid");
			  var win = window.open('', 'Image', 'resizable=yes,...');
			  if (win.document) {
			
 				win.document.writeln('<style type="text/css" media="print">');
			    win.document.writeln(".page {margin: none;max-width: 100% !important;}.print {display: none !important;}");
      			win.document.writeln("</style>");	 
				  
      			win.document.writeln("<style type='text/css' media='screen'>");
      			win.document.writeln(".print {background-color: #f2f2f2;border: 1px solid #bbb;border-radius: 11px;-webkit-border-radius: 11px;-moz-border-radius: 11px;color: #000;display: block;font-size: .90em;height: 22px;width: 30px;line-height: 22px;padding-left: 20px;padding-right: 20px;text-decoration: none;margin-top: 7px;font: normal 14px/150% Verdana, Arial, Helvetica, sans-serif;}");  
      			win.document.writeln("</style>");				  
				  
				win.document.writeln('<a class="print" href="#" onclick="window.print()">Print</a><br class="print">');
				win.document.writeln('<img style="width: 370px;" src="'+ image +'" alt="image" />');   //612x396   
				//win.document.close();
				//win.focus();
				//win.print();
			  }
		  return false;
	});

</script>

<?php }  ?> 
<?php }  ?> 