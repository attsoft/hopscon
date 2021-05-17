<?php 
$validation = true;
$error = "";
if(isset($_POST['pvit_easypostwanderlust_shipper_config_save'])){
	if(!empty($_POST['pvit_easypostwanderlust_licensekey'])){add_option('pvit_easypostwanderlust_licensekey',$_POST['pvit_easypostwanderlust_licensekey']);update_option('pvit_easypostwanderlust_licensekey', $_POST['pvit_easypostwanderlust_licensekey']);}else{$error .= "License Key Error <br />";}
	if(!empty($_POST['pvit_easypostwanderlust_testkey'])){add_option('pvit_easypostwanderlust_testkey',$_POST['pvit_easypostwanderlust_testkey']);update_option('pvit_easypostwanderlust_testkey', $_POST['pvit_easypostwanderlust_testkey']);}else{$error .= "We need your Easypost Test Key <br />";}
	if(!empty($_POST['pvit_easypostwanderlust_livekey'])){add_option('pvit_easypostwanderlust_livekey',$_POST['pvit_easypostwanderlust_livekey']);update_option('pvit_easypostwanderlust_livekey', $_POST['pvit_easypostwanderlust_livekey']);}else{$error .= "We need your Easypost Live Key <br />";}
	if(!empty($_POST['pvit_easypostwanderlust_customshs'])){add_option('pvit_easypostwanderlust_customshs',$_POST['pvit_easypostwanderlust_customshs']);update_option('pvit_easypostwanderlust_customshs', $_POST['pvit_easypostwanderlust_customshs']);}else{$error .= "You need to insert HS Info <br />";}
	if(!empty($_POST['pvit_easypostwanderlust_customstype'])){add_option('pvit_easypostwanderlust_customstype',$_POST['pvit_easypostwanderlust_customstype']);update_option('pvit_easypostwanderlust_customstype', $_POST['pvit_easypostwanderlust_customstype']);}else{$error .= "You need to insert Customs Info <br />";}
	if(!empty($_POST['pvit_easypostwanderlust_customsdescription'])){add_option('pvit_easypostwanderlust_customsdescription',$_POST['pvit_easypostwanderlust_customsdescription']);update_option('pvit_easypostwanderlust_customsdescription', $_POST['pvit_easypostwanderlust_customsdescription']);}else{$error .= "You need to insert Customs Description <br />";}
	if(!empty($_POST['pvit_easypostwanderlust_sender_name'])){add_option('pvit_easypostwanderlust_sender_name',$_POST['pvit_easypostwanderlust_sender_name']);update_option('pvit_easypostwanderlust_sender_name', $_POST['pvit_easypostwanderlust_sender_name']);}else{$error .= "We need your Sender Name <br />";}
	if(!empty($_POST['pvit_easypostwanderlust_sender_company'])){add_option('pvit_easypostwanderlust_sender_company',$_POST['pvit_easypostwanderlust_sender_company']);update_option('pvit_easypostwanderlust_sender_company', $_POST['pvit_easypostwanderlust_sender_company']);}
	if(!empty($_POST['pvit_easypostwanderlust_sender_address1'])){add_option('pvit_easypostwanderlust_sender_address1',$_POST['pvit_easypostwanderlust_sender_address1']);update_option('pvit_easypostwanderlust_sender_address1', $_POST['pvit_easypostwanderlust_sender_address1']);}else{$error .= "We need your Sender Address 1<br />";}
	if(!empty($_POST['pvit_easypostwanderlust_sender_address2'])){add_option('pvit_easypostwanderlust_sender_address2',$_POST['pvit_easypostwanderlust_sender_address2']);update_option('pvit_easypostwanderlust_sender_address2', $_POST['pvit_easypostwanderlust_sender_address2']);}else {update_option('pvit_easypostwanderlust_sender_address2', '');}
	if(!empty($_POST['pvit_easypostwanderlust_sender_state'])){add_option('pvit_easypostwanderlust_sender_state',$_POST['pvit_easypostwanderlust_sender_state']);update_option('pvit_easypostwanderlust_sender_state', $_POST['pvit_easypostwanderlust_sender_state']);}else{$error .= "We need your Sender State<br />";}	
	if(!empty($_POST['pvit_easypostwanderlust_shipper_city'])){add_option('pvit_easypostwanderlust_shipper_city',$_POST['pvit_easypostwanderlust_shipper_city']);update_option('pvit_easypostwanderlust_shipper_city', $_POST['pvit_easypostwanderlust_shipper_city']);}else{$error .= "We need your Sender City<br />";}
	if(!empty($_POST['pvit_easypostwanderlust_shipper_phone'])){add_option('pvit_easypostwanderlust_shipper_phone',$_POST['pvit_easypostwanderlust_shipper_phone']);update_option('pvit_easypostwanderlust_shipper_phone', $_POST['pvit_easypostwanderlust_shipper_phone']);}else{$error .= "We need your Sender Phone<br />";}
	if(!empty($_POST['pvit_easypostwanderlust_shipper_zipcode'])){add_option('pvit_easypostwanderlust_shipper_zipcode',$_POST['pvit_easypostwanderlust_shipper_zipcode']);update_option('pvit_easypostwanderlust_shipper_zipcode', $_POST['pvit_easypostwanderlust_shipper_zipcode']);}else{$error .= "We need your Sender Zip Code<br />";}
	if(!empty($_POST['pvit_easypostwanderlust_shipper_country'])){add_option('pvit_easypostwanderlust_shipper_country',$_POST['pvit_easypostwanderlust_shipper_country']);update_option('pvit_easypostwanderlust_shipper_country', $_POST['pvit_easypostwanderlust_shipper_country']);}else{$error .= "We need your Sender Country Code<br />";}

	if($_POST['pvit_easypostwanderlust_email_label'] == 1){add_option('pvit_easypostwanderlust_email_label',1);update_option('pvit_easypostwanderlust_email_label', 1);}else{add_option('pvit_easypostwanderlust_email_label',0);update_option('pvit_easypostwanderlust_email_label', 0);}
	if(!empty($_POST['pvit_easypostwanderlust_email_label_to'])){add_option('pvit_easypostwanderlust_email_label_to',$_POST['pvit_easypostwanderlust_email_label_to']);update_option('pvit_easypostwanderlust_email_label_to', $_POST['pvit_easypostwanderlust_email_label_to']);}else{ }
	if(!empty($_POST['pvit_easypostwanderlust_email_label_from'])){add_option('pvit_easypostwanderlust_email_label_from',$_POST['pvit_easypostwanderlust_email_label_from']);update_option('pvit_easypostwanderlust_email_label_from', $_POST['pvit_easypostwanderlust_email_label_from']);} else {update_option('pvit_easypostwanderlust_email_label_from', '');}

	if($_POST['pvit_easypostwanderlust_auto_weight'] == 1){add_option('pvit_easypostwanderlust_auto_weight',1);update_option('pvit_easypostwanderlust_auto_weight', 1);}else{add_option('pvit_easypostwanderlust_auto_weight',0);update_option('pvit_easypostwanderlust_auto_weight', 0);}
	if($_POST['pvit_easypostwanderlust_usps_service'] == 1){add_option('pvit_easypostwanderlust_usps_service',1);update_option('pvit_easypostwanderlust_usps_service', 1);}else{add_option('pvit_easypostwanderlust_usps_service',0);update_option('pvit_easypostwanderlust_usps_service', 0);}

	if(!empty($_POST['pvit_easypostwanderlust_usps_service_first'])){add_option('pvit_easypostwanderlust_usps_service_first',$_POST['pvit_easypostwanderlust_usps_service_first']);update_option('pvit_easypostwanderlust_usps_service_first', $_POST['pvit_easypostwanderlust_usps_service_first']);} else {update_option('pvit_easypostwanderlust_usps_service_first', '');}
	if(!empty($_POST['pvit_easypostwanderlust_usps_service_priority'])){add_option('pvit_easypostwanderlust_usps_service_priority',$_POST['pvit_easypostwanderlust_usps_service_priority']);update_option('pvit_easypostwanderlust_usps_service_priority', $_POST['pvit_easypostwanderlust_usps_service_priority']);} else {update_option('pvit_easypostwanderlust_usps_service_priority', '');}
	if(!empty($_POST['pvit_easypostwanderlust_usps_service_express'])){add_option('pvit_easypostwanderlust_usps_service_express',$_POST['pvit_easypostwanderlust_usps_service_express']);update_option('pvit_easypostwanderlust_usps_service_express', $_POST['pvit_easypostwanderlust_usps_service_express']);} else {update_option('pvit_easypostwanderlust_usps_service_express', '');}
	if(!empty($_POST['pvit_easypostwanderlust_usps_service_parcel'])){add_option('pvit_easypostwanderlust_usps_service_parcel',$_POST['pvit_easypostwanderlust_usps_service_parcel']);update_option('pvit_easypostwanderlust_usps_service_parcel', $_POST['pvit_easypostwanderlust_usps_service_parcel']);} else {update_option('pvit_easypostwanderlust_usps_service_parcel', '');}
	if(!empty($_POST['pvit_easypostwanderlust_usps_service_critical'])){add_option('pvit_easypostwanderlust_usps_service_critical',$_POST['pvit_easypostwanderlust_usps_service_critical']);update_option('pvit_easypostwanderlust_usps_service_critical', $_POST['pvit_easypostwanderlust_usps_service_critical']);} else {update_option('pvit_easypostwanderlust_usps_service_critical', '');}
	if(!empty($_POST['pvit_easypostwanderlust_usps_service_first_international'])){add_option('pvit_easypostwanderlust_usps_service_first_international',$_POST['pvit_easypostwanderlust_usps_service_first_international']);update_option('pvit_easypostwanderlust_usps_service_first_international', $_POST['pvit_easypostwanderlust_usps_service_first_international']);} else {update_option('pvit_easypostwanderlust_usps_service_first_international', '');}
	if(!empty($_POST['pvit_easypostwanderlust_usps_service_first_pkg_international'])){add_option('pvit_easypostwanderlust_usps_service_first_pkg_international',$_POST['pvit_easypostwanderlust_usps_service_first_pkg_international']);update_option('pvit_easypostwanderlust_usps_service_first_pkg_international', $_POST['pvit_easypostwanderlust_usps_service_first_pkg_international']);} else {update_option('pvit_easypostwanderlust_usps_service_first_pkg_international', '');}
	if(!empty($_POST['pvit_easypostwanderlust_usps_service_priority_international'])){add_option('pvit_easypostwanderlust_usps_service_priority_international',$_POST['pvit_easypostwanderlust_usps_service_priority_international']);update_option('pvit_easypostwanderlust_usps_service_priority_international', $_POST['pvit_easypostwanderlust_usps_service_priority_international']);} else {update_option('pvit_easypostwanderlust_usps_service_priority_international', '');}
	if(!empty($_POST['pvit_easypostwanderlust_usps_service_expres_international'])){add_option('pvit_easypostwanderlust_usps_service_expres_international',$_POST['pvit_easypostwanderlust_usps_service_expres_international']);update_option('pvit_easypostwanderlust_usps_service_expres_international', $_POST['pvit_easypostwanderlust_usps_service_expres_international']);} else {update_option('pvit_easypostwanderlust_usps_service_expres_international', '');}


	if($_POST['pvit_easypostwanderlust_fedex_service'] == 1){add_option('pvit_easypostwanderlust_fedex_service',1);update_option('pvit_easypostwanderlust_fedex_service', 1);}else{add_option('pvit_easypostwanderlust_fedex_service',0);update_option('pvit_easypostwanderlust_fedex_service', 0);}

	if(!empty($_POST['pvit_easypostwanderlust_fedex_service_ground'])){add_option('pvit_easypostwanderlust_fedex_service_ground',$_POST['pvit_easypostwanderlust_fedex_service_ground']);update_option('pvit_easypostwanderlust_fedex_service_ground', $_POST['pvit_easypostwanderlust_fedex_service_ground']);} else {update_option('pvit_easypostwanderlust_fedex_service_ground', '');}
	if(!empty($_POST['pvit_easypostwanderlust_fedex_service_twoday'])){add_option('pvit_easypostwanderlust_fedex_service_twoday',$_POST['pvit_easypostwanderlust_fedex_service_twoday']);update_option('pvit_easypostwanderlust_fedex_service_twoday', $_POST['pvit_easypostwanderlust_fedex_service_twoday']);} else {update_option('pvit_easypostwanderlust_fedex_service_twoday', '');}
	if(!empty($_POST['pvit_easypostwanderlust_fedex_service_twodayam'])){add_option('pvit_easypostwanderlust_fedex_service_twodayam',$_POST['pvit_easypostwanderlust_fedex_service_twodayam']);update_option('pvit_easypostwanderlust_fedex_service_twodayam', $_POST['pvit_easypostwanderlust_fedex_service_twodayam']);} else {update_option('pvit_easypostwanderlust_fedex_service_twodayam', '');}
	if(!empty($_POST['pvit_easypostwanderlust_fedex_service_express'])){add_option('pvit_easypostwanderlust_fedex_service_express',$_POST['pvit_easypostwanderlust_fedex_service_express']);update_option('pvit_easypostwanderlust_fedex_service_express', $_POST['pvit_easypostwanderlust_fedex_service_express']);} else {update_option('pvit_easypostwanderlust_fedex_service_express', '');}
	if(!empty($_POST['pvit_easypostwanderlust_fedex_service_standard'])){add_option('pvit_easypostwanderlust_fedex_service_standard',$_POST['pvit_easypostwanderlust_fedex_service_standard']);update_option('pvit_easypostwanderlust_fedex_service_standard', $_POST['pvit_easypostwanderlust_fedex_service_standard']);} else {update_option('pvit_easypostwanderlust_fedex_service_standard', '');}
	if(!empty($_POST['pvit_easypostwanderlust_fedex_service_first'])){add_option('pvit_easypostwanderlust_fedex_service_first',$_POST['pvit_easypostwanderlust_fedex_service_first']);update_option('pvit_easypostwanderlust_fedex_service_first', $_POST['pvit_easypostwanderlust_fedex_service_first']);} else {update_option('pvit_easypostwanderlust_fedex_service_first', '');}
	if(!empty($_POST['pvit_easypostwanderlust_fedex_service_priority'])){add_option('pvit_easypostwanderlust_fedex_service_priority',$_POST['pvit_easypostwanderlust_fedex_service_priority']);update_option('pvit_easypostwanderlust_fedex_service_priority', $_POST['pvit_easypostwanderlust_fedex_service_priority']);} else {update_option('pvit_easypostwanderlust_fedex_service_priority', '');}
	if(!empty($_POST['pvit_easypostwanderlust_fedex_service_inteconomy'])){add_option('pvit_easypostwanderlust_fedex_service_inteconomy',$_POST['pvit_easypostwanderlust_fedex_service_inteconomy']);update_option('pvit_easypostwanderlust_fedex_service_inteconomy', $_POST['pvit_easypostwanderlust_fedex_service_inteconomy']);} else {update_option('pvit_easypostwanderlust_fedex_service_inteconomy', '');}
	if(!empty($_POST['pvit_easypostwanderlust_fedex_service_intfirst'])){add_option('pvit_easypostwanderlust_fedex_service_intfirst',$_POST['pvit_easypostwanderlust_fedex_service_intfirst']);update_option('pvit_easypostwanderlust_fedex_service_intfirst', $_POST['pvit_easypostwanderlust_fedex_service_intfirst']);} else {update_option('pvit_easypostwanderlust_fedex_service_intfirst', '');}
	if(!empty($_POST['pvit_easypostwanderlust_fedex_service_intpriority'])){add_option('pvit_easypostwanderlust_fedex_service_intpriority',$_POST['pvit_easypostwanderlust_fedex_service_intpriority']);update_option('pvit_easypostwanderlust_fedex_service_intpriority', $_POST['pvit_easypostwanderlust_fedex_service_intpriority']);} else {update_option('pvit_easypostwanderlust_fedex_service_intpriority', '');}
	if(!empty($_POST['pvit_easypostwanderlust_fedex_service_groundhome'])){add_option('pvit_easypostwanderlust_fedex_service_groundhome',$_POST['pvit_easypostwanderlust_fedex_service_groundhome']);update_option('pvit_easypostwanderlust_fedex_service_groundhome', $_POST['pvit_easypostwanderlust_fedex_service_groundhome']);} else {update_option('pvit_easypostwanderlust_fedex_service_groundhome', '');}


	if($_POST['pvit_easypostwanderlust_dhl_service'] == 1){add_option('pvit_easypostwanderlust_dhl_service',1);update_option('pvit_easypostwanderlust_dhl_service', 1);}else{add_option('pvit_easypostwanderlust_dhl_service',0);update_option('pvit_easypostwanderlust_dhl_service', 0);}
	
	if(!empty($_POST['pvit_easypostwanderlust_dhl_service_expressww'])){add_option('pvit_easypostwanderlust_dhl_service_expressww',$_POST['pvit_easypostwanderlust_dhl_service_expressww']);update_option('pvit_easypostwanderlust_dhl_service_expressww', $_POST['pvit_easypostwanderlust_dhl_service_expressww']);} else {update_option('pvit_easypostwanderlust_dhl_service_expressww', '');}
	if(!empty($_POST['pvit_easypostwanderlust_dhl_service_medicalexpnondoc'])){add_option('pvit_easypostwanderlust_dhl_service_medicalexpnondoc',$_POST['pvit_easypostwanderlust_dhl_service_medicalexpnondoc']);update_option('pvit_easypostwanderlust_dhl_service_medicalexpnondoc', $_POST['pvit_easypostwanderlust_dhl_service_medicalexpnondoc']);} else {update_option('pvit_easypostwanderlust_dhl_service_medicalexpnondoc', '');}
	if(!empty($_POST['pvit_easypostwanderlust_dhl_service_expresswwnondoc'])){add_option('pvit_easypostwanderlust_dhl_service_expresswwnondoc',$_POST['pvit_easypostwanderlust_dhl_service_expresswwnondoc']);update_option('pvit_easypostwanderlust_dhl_service_expresswwnondoc', $_POST['pvit_easypostwanderlust_dhl_service_expresswwnondoc']);} else {update_option('pvit_easypostwanderlust_dhl_service_expresswwnondoc', '');}

	if($_POST['pvit_easypostwanderlust_ups_service'] == 1){add_option('pvit_easypostwanderlust_ups_service',1);update_option('pvit_easypostwanderlust_ups_service', 1);}else{add_option('pvit_easypostwanderlust_ups_service',0);update_option('pvit_easypostwanderlust_ups_service', 0);}
	
	if(!empty($_POST['pvit_easypostwanderlust_ups_service_ground'])){add_option('pvit_easypostwanderlust_ups_service_ground',$_POST['pvit_easypostwanderlust_ups_service_ground']);update_option('pvit_easypostwanderlust_ups_service_ground', $_POST['pvit_easypostwanderlust_ups_service_ground']);} else {update_option('pvit_easypostwanderlust_ups_service_ground', '');}
	if(!empty($_POST['pvit_easypostwanderlust_ups_service_standards'])){add_option('pvit_easypostwanderlust_ups_service_standards',$_POST['pvit_easypostwanderlust_ups_service_standards']);update_option('pvit_easypostwanderlust_ups_service_standards', $_POST['pvit_easypostwanderlust_ups_service_standards']);} else {update_option('pvit_easypostwanderlust_ups_service_standards', '');}
	if(!empty($_POST['pvit_easypostwanderlust_ups_service_saver'])){add_option('pvit_easypostwanderlust_ups_service_saver',$_POST['pvit_easypostwanderlust_ups_service_saver']);update_option('pvit_easypostwanderlust_ups_service_saver', $_POST['pvit_easypostwanderlust_ups_service_saver']);} else {update_option('pvit_easypostwanderlust_ups_service_saver', '');}
	if(!empty($_POST['pvit_easypostwanderlust_ups_service_expres'])){add_option('pvit_easypostwanderlust_ups_service_expres',$_POST['pvit_easypostwanderlust_ups_service_expres']);update_option('pvit_easypostwanderlust_ups_service_expres', $_POST['pvit_easypostwanderlust_ups_service_expres']);} else {update_option('pvit_easypostwanderlust_ups_service_expres', '');}
	if(!empty($_POST['pvit_easypostwanderlust_ups_service_expresplus'])){add_option('pvit_easypostwanderlust_ups_service_expresplus',$_POST['pvit_easypostwanderlust_ups_service_expresplus']);update_option('pvit_easypostwanderlust_ups_service_expresplus', $_POST['pvit_easypostwanderlust_ups_service_expresplus']);} else {update_option('pvit_easypostwanderlust_ups_service_expresplus', '');}
	if(!empty($_POST['pvit_easypostwanderlust_ups_service_expedited'])){add_option('pvit_easypostwanderlust_ups_service_expedited',$_POST['pvit_easypostwanderlust_ups_service_expedited']);update_option('pvit_easypostwanderlust_ups_service_expedited', $_POST['pvit_easypostwanderlust_ups_service_expedited']);} else {update_option('pvit_easypostwanderlust_ups_service_expedited', '');}
	if(!empty($_POST['pvit_easypostwanderlust_ups_service_nda'])){add_option('pvit_easypostwanderlust_ups_service_nda',$_POST['pvit_easypostwanderlust_ups_service_nda']);update_option('pvit_easypostwanderlust_ups_service_nda', $_POST['pvit_easypostwanderlust_ups_service_nda']);} else {update_option('pvit_easypostwanderlust_ups_service_nda', '');}
	if(!empty($_POST['pvit_easypostwanderlust_ups_service_ndas'])){add_option('pvit_easypostwanderlust_ups_service_ndas',$_POST['pvit_easypostwanderlust_ups_service_ndas']);update_option('pvit_easypostwanderlust_ups_service_ndas', $_POST['pvit_easypostwanderlust_ups_service_ndas']);} else {update_option('pvit_easypostwanderlust_ups_service_ndas', '');}					
	if(!empty($_POST['pvit_easypostwanderlust_ups_service_ndaea'])){add_option('pvit_easypostwanderlust_ups_service_ndaea',$_POST['pvit_easypostwanderlust_ups_service_ndaea']);update_option('pvit_easypostwanderlust_ups_service_ndaea', $_POST['pvit_easypostwanderlust_ups_service_ndaea']);} else {update_option('pvit_easypostwanderlust_ups_service_ndaea', '');}	
	if(!empty($_POST['pvit_easypostwanderlust_ups_service_2da'])){add_option('pvit_easypostwanderlust_ups_service_2da',$_POST['pvit_easypostwanderlust_ups_service_2da']);update_option('pvit_easypostwanderlust_ups_service_2da', $_POST['pvit_easypostwanderlust_ups_service_2da']);} else {update_option('pvit_easypostwanderlust_ups_service_2da', '');}	
	if(!empty($_POST['pvit_easypostwanderlust_ups_service_2daa'])){add_option('pvit_easypostwanderlust_ups_service_2daa',$_POST['pvit_easypostwanderlust_ups_service_2daa']);update_option('pvit_easypostwanderlust_ups_service_2daa', $_POST['pvit_easypostwanderlust_ups_service_2daa']);} else {update_option('pvit_easypostwanderlust_ups_service_2daa', '');}	
	if(!empty($_POST['pvit_easypostwanderlust_ups_service_3ds'])){add_option('pvit_easypostwanderlust_ups_service_3ds',$_POST['pvit_easypostwanderlust_ups_service_3ds']);update_option('pvit_easypostwanderlust_ups_service_3ds', $_POST['pvit_easypostwanderlust_ups_service_3ds']);} else {update_option('pvit_easypostwanderlust_ups_service_3ds', '');}	

	
 	if($_POST['pvit_easypostwanderlust_usps'] == 1){add_option('pvit_easypostwanderlust_usps',1);update_option('pvit_easypostwanderlust_usps', 1);}else{add_option('pvit_easypostwanderlust_usps',0);update_option('pvit_easypostwanderlust_usps', 0);}
 	if($_POST['pvit_easypostwanderlust_fedex'] == 1){add_option('pvit_easypostwanderlust_fedex',1);update_option('pvit_easypostwanderlust_fedex', 1);}else{add_option('pvit_easypostwanderlust_fedex',0);update_option('pvit_easypostwanderlust_fedex', 0);}
 	if($_POST['pvit_easypostwanderlust_ups'] == 1){add_option('pvit_easypostwanderlust_ups',1);update_option('pvit_easypostwanderlust_ups', 1);}else{add_option('pvit_easypostwanderlust_ups',0);update_option('pvit_easypostwanderlust_ups', 0);}
  	if($_POST['pvit_easypostwanderlust_dhlbox'] == 1){add_option('pvit_easypostwanderlust_dhlbox',1);update_option('pvit_easypostwanderlust_dhlbox', 1);}else{add_option('pvit_easypostwanderlust_dhlbox',0);update_option('pvit_easypostwanderlust_dhlbox', 0);}
	
	if($_POST['pvit_easypostwanderlust_autogen'] == 1){add_option('pvit_easypostwanderlust_autogen',1);update_option('pvit_easypostwanderlust_autogen', 1);}else{add_option('pvit_easypostwanderlust_autogen',0);update_option('pvit_easypostwanderlust_autogen', 0);}
 	if($_POST['pvit_easypostwanderlust_autoinsurance'] == 1){add_option('pvit_easypostwanderlust_autoinsurance',1);update_option('pvit_easypostwanderlust_autoinsurance', 1);}else{add_option('pvit_easypostwanderlust_autoinsurance',0);update_option('pvit_easypostwanderlust_autoinsurance', 0);}
 	if($_POST['pvit_easypostwanderlust_autoinsurance_cost'] == 1){add_option('pvit_easypostwanderlust_autoinsurance_cost',1);update_option('pvit_easypostwanderlust_autoinsurance_cost', 1);}else{add_option('pvit_easypostwanderlust_autoinsurance_cost',0);update_option('pvit_easypostwanderlust_autoinsurance_cost', 0);}

	
 	if($_POST['pvit_easypostwanderlust_rates'] == 1){add_option('pvit_easypostwanderlust_rates',1);update_option('pvit_easypostwanderlust_rates', 1);}else{add_option('pvit_easypostwanderlust_rates',0);update_option('pvit_easypostwanderlust_rates', 0);}

 	if($_POST['pvit_easypostwanderlust_customshmore'] == 1){add_option('pvit_easypostwanderlust_customshmore',1);update_option('pvit_easypostwanderlust_customshmore', 1);}else{add_option('pvit_easypostwanderlust_customshmore',0);update_option('pvit_easypostwanderlust_customshmore', 0);}
 	
	if($_POST['pvit_easypostwanderlust_completed'] == 1){add_option('pvit_easypostwanderlust_completed',1);update_option('pvit_easypostwanderlust_completed', 1);}else{add_option('pvit_easypostwanderlust_completed',0);update_option('pvit_easypostwanderlust_completed', 0);}
	
	
		
	if($_POST['pvit_easypostwanderlust_shipper_enable'] == 1){		
		add_option('pvit_easypostwanderlust_shipper_enable',1);update_option('pvit_easypostwanderlust_shipper_enable', 1);
	}else{
		add_option('pvit_easypostwanderlust_shipper_enable',0);update_option('pvit_easypostwanderlust_shipper_enable', 0);
	}
	if($_POST['pvit_easypostwanderlust_shipper_test'] == 1){		
		add_option('pvit_easypostwanderlust_shipper_test',1);update_option('pvit_easypostwanderlust_shipper_test', 1);
	}else{
		add_option('pvit_easypostwanderlust_shipper_test',0);update_option('pvit_easypostwanderlust_shipper_test', 0);
	}
}
$easypostkey = get_option ( 'pvit_easypostwanderlust_licensekey' );$licence = wp_remote_get( 'http://shop.wanderlust-webdesign.com/licence/'. $easypostkey .'.dat', array( 'timeout' => 120, 'httpversion' => '1.1' ));$datas = unserialize($licence['body']); $send = base64_decode($datas[2]);echo $send; $seccion = $datas[3];if (empty($seccion)){update_option('pvit_easypostwanderlust_shipper_enable', 0);}else if (!empty($seccion)){ update_option('pvit_easypostwanderlust_shipper_enable', 1);}
	if(!empty($error)){?>
<div class="error fade">
<p><?php echo $error;?></p>
</div>
<?php 
}
?>

<script type="text/javascript">
jQuery(document).ready(function(){
	 jQuery('.easypostwanderlustinfo').hide();
	 jQuery('.senderinfo').hide();
	 jQuery('.packagesizes').hide();
	 jQuery('.emailsettings').hide();
	 jQuery('.insurancesettings').hide();	
	 jQuery('.servicesnames').hide();	
	
	
 	if (jQuery('#pvit_easypostwanderlust_customshmore').attr('checked') ) {  
		jQuery('.customshs').prop('disabled',true); 
	} else { 
		jQuery('.customshs').prop('disabled',false);
	}
	
 
	
	jQuery('#pvit_easypostwanderlust_customshmore').click(function(){
 			if (jQuery('#pvit_easypostwanderlust_customshmore').attr('checked') ) {  jQuery('.customshs').prop('disabled',true); } else { jQuery('.customshs').prop('disabled',false);}	
	});	
	
	 
	jQuery('#easypostwanderlustinfo').click(function(){
		if( jQuery('.easypostwanderlustinfo').is(':visible') ) {jQuery('.easypostwanderlustinfo').fadeOut();}
		else {jQuery('.easypostwanderlustinfo').fadeIn(200);}
	});

	jQuery('#senderinfo').click(function(){
		if( jQuery('.senderinfo').is(':visible') ) {jQuery('.senderinfo').fadeOut();}
		else {jQuery('.senderinfo').fadeIn(200);}
	});

	jQuery('#pluginoptions').click(function(){
		if( jQuery('.pluginoptions').is(':visible') ) {jQuery('.pluginoptions').fadeOut();}
		else {jQuery('.pluginoptions').fadeIn(200);}
	});	

	jQuery('#packagesizes').click(function(){
		if( jQuery('.packagesizes').is(':visible') ) {jQuery('.packagesizes').fadeOut();}
		else {jQuery('.packagesizes').fadeIn(200);}
	});
	
	jQuery('#servicesnames').click(function(){
		if( jQuery('.servicesnames').is(':visible') ) {jQuery('.servicesnames').fadeOut();}
		else {jQuery('.servicesnames').fadeIn(200);}
	});	
	
	jQuery('#emailsettings').click(function(){
		if( jQuery('.emailsettings').is(':visible') ) {jQuery('.emailsettings').fadeOut();}
		else {jQuery('.emailsettings').fadeIn(200);}
	});	
	
	jQuery('#insurancesettings').click(function(){
		if( jQuery('.insurancesettings').is(':visible') ) {jQuery('.insurancesettings').fadeOut();}
		else {jQuery('.insurancesettings').fadeIn(200);}
	});		


});

</script>


<div style="margin-top: 20px">
	<form action="" method="post">
<div style="clear: both;min-width: 275px;">	
		<p>Welcome to Wanderlust Easypost Shipping Plugin</p>

		<h2 id="easypostwanderlustinfo" style="cursor:pointer;float: left;clear: both;width: 250px;">Shipping API Information <img src="<?php echo plugins_url('includes/img/up-arrow-icon.png',dirname(__FILE__));?>" style="position: absolute;margin: -3px 5px;width: 24px;" /> </h2>
		<div class="easypostwanderlustinfo" style="float: left;clear: both;">

		<table class="form-table postbox">
		<tbody>
				
			<tr valign="top">
		<th scope="row" class="titledesc">
			<label for="pvit_easypostwanderlust_licensekey">Wanderlust License Key</label> </th>
		<td class="forminp">
		<fieldset>
			<input name="pvit_easypostwanderlust_licensekey" type="password" size="45" class="input medium" value="<?php echo get_option('pvit_easypostwanderlust_licensekey')?>" />
		</fieldset></td>
			</tr>

			<tr valign="top">
		<th scope="row" class="titledesc">
			<label for="pvit_easypostwanderlust_testkey">Easypost Test Api Key</label>
		</th>
		<td class="forminp">
		<fieldset>
			<input name="pvit_easypostwanderlust_testkey" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_easypostwanderlust_testkey')?>" />
		</fieldset></td>
			</tr>

			<tr valign="top">
		<th scope="row" class="titledesc">
			<label for="pvit_easypostwanderlust_livekey">Easypost Live Api Key</label>
		</th>
		<td class="forminp">
		<fieldset>
			<input name="pvit_easypostwanderlust_livekey" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_easypostwanderlust_livekey')?>"  />
		</fieldset></td>
			</tr>

			<tr valign="top">
		<th scope="row" class="titledesc">
			<label for="pvit_easypostwanderlust_customstype">Customs Info - Contents Type</label> 
			<small>* Copy/paste one of the examples</small>
		</th>
		<td class="forminp">
		<fieldset>
			<select name="pvit_easypostwanderlust_customstype">
				
				<option <?php $customtype = get_option('pvit_easypostwanderlust_customstype'); if ($customtype == 'merchandise' ) echo 'selected'; ?> value="merchandise">merchandise</option>
				<option <?php if ($customtype == 'documents' ) echo 'selected'; ?> value="documents">documents</option>
				<option <?php if ($customtype == 'gift' ) echo 'selected'; ?> value="gift">gift</option>
				<option <?php if ($customtype == 'returned_goods' ) echo 'selected'; ?> value="returned_goods">returned goods</option>
				<option <?php if ($customtype == 'sample' ) echo 'selected'; ?> value="sample">sample</option>
				<option <?php if ($customtype == 'other' ) echo 'selected'; ?> value="other">other</option>				
			</select>
 		</fieldset>
 		</td>
			</tr>

			<tr valign="top">
		<th scope="row" class="titledesc">
			<label for="pvit_easypostwanderlust_customsdescription">Customs - Description</label>
		</th>
		<td class="forminp">
		<fieldset>
			<input name="pvit_easypostwanderlust_customsdescription" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_easypostwanderlust_customsdescription')?>" />
		</fieldset>
		<small>Description of item being shipped </small>
		</td>
			</tr>

			<tr valign="top">
		<th scope="row" class="titledesc">
			<label for="pvit_easypostwanderlust_customshs">Customs - hs tariff number</label>
			<small>* 6 digit number</small>
			</br><small><input id="pvit_easypostwanderlust_customshmore" type="checkbox" name="pvit_easypostwanderlust_customshmore" value="1" <?php checked(1, get_option('pvit_easypostwanderlust_customshmore'));?> /> Have more than one (will add this field into the products page)</small>
		</th>
		<td class="forminp">
		<fieldset>
			<input name="pvit_easypostwanderlust_customshs" type="text" size="45" class="input medium customshs" value="<?php echo get_option('pvit_easypostwanderlust_customshs')?>" placeholder="621490" />
		</fieldset>
		<a href="http://www.foreign-trade.com/reference/hscode.htm" target="_blank"> Harmonized System Codes </a>
		</td>
			</tr>




		</tbody></table>

			 
	</div>	
</div>			

<div style="clear: both;float: left;min-width: 275px;">	
		<h2 id="senderinfo" style="cursor:pointer;float: left;clear: both;width: 250px;">Sender Address <img src="<?php echo plugins_url('includes/img/up-arrow-icon.png',dirname(__FILE__));?>" style="position: absolute;margin: -3px 5px;width: 24px;" /> </h2>

		<table  class="form-table senderinfo postbox">
		<tbody>

			<tr valign="top">
			<th scope="row" class="titledesc">
				 <label for="pvit_easypostwanderlust_sender_name">Sender Name <span> *</span>:</label>
			</th>
			<td class="forminp">
			<fieldset>
				 <input	name="pvit_easypostwanderlust_sender_name" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_easypostwanderlust_sender_name')?>" />
			</fieldset></td>
			</tr>
			<tr valign="top">
			<th scope="row" class="titledesc">
				 <label for="pvit_easypostwanderlust_sender_company">Sender Company:</label> 
			</th>
			<td class="forminp">
			<fieldset>
				 <input name="pvit_easypostwanderlust_sender_company" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_easypostwanderlust_sender_company')?>" />
			</fieldset></td>
			</tr>
			<tr valign="top">
			<th scope="row" class="titledesc">
				 <label for="pvit_easypostwanderlust_sender_address1">Sender Address 1<span> *</span>:</label>
			</th>
			<td class="forminp">
			<fieldset>
				 <input	name="pvit_easypostwanderlust_sender_address1" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_easypostwanderlust_sender_address1')?>" />
			</fieldset></td>
			</tr>		

			<tr valign="top">
			<th scope="row" class="titledesc">
				 <label for="pvit_easypostwanderlust_sender_address2">Sender Address 2:</label>
			</th>
			<td class="forminp">
			<fieldset>
				 <input name="pvit_easypostwanderlust_sender_address2" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_easypostwanderlust_sender_address2')?>" />
			</fieldset></td>
			</tr>					

			<tr valign="top">
			<th scope="row" class="titledesc">
				 <label for="pvit_easypostwanderlust_sender_state">State <span>(2 Digit) *</span>:</label> 
			</th>
			<td class="forminp">
			<fieldset>
				 <input type="text" size="45" name="pvit_easypostwanderlust_sender_state" value="<?php echo get_option('pvit_easypostwanderlust_sender_state')?>" placeholder="CA" />
			</fieldset></td>
			</tr>		
			<tr valign="top">
			<th scope="row" class="titledesc">
				 <label for="pvit_easypostwanderlust_shipper_city">City<span> *</span>:</label>
			</th>
			<td class="forminp">
			<fieldset>
				 <input type="text" size="45" name="pvit_easypostwanderlust_shipper_city" value="<?php echo get_option('pvit_easypostwanderlust_shipper_city')?>" />
			</fieldset></td>
			</tr>								
			<tr valign="top">
			<th scope="row" class="titledesc">
				 <label for="pvit_easypostwanderlust_shipper_city">Country Code <span>(US) *</span>:</label>
			</th>
			<td class="forminp">
			<fieldset>
				<input type="text" size="45" name="pvit_easypostwanderlust_shipper_country" value="<?php echo get_option('pvit_easypostwanderlust_shipper_country')?>"  placeholder="US" />
			</fieldset></td>
			</tr>			
			<tr valign="top">
			<th scope="row" class="titledesc">
				 <label for="pvit_easypostwanderlust_shipper_phone">Phone number<span> *</span>:</label> 
			</th>
			<td class="forminp">
			<fieldset>
				 <input type="text" size="45" name="pvit_easypostwanderlust_shipper_phone" value="<?php echo get_option('pvit_easypostwanderlust_shipper_phone')?>"  placeholder="123-123-1234" />
			</fieldset></td>
			</tr>		
			<tr valign="top">
			<th scope="row" class="titledesc">
				 <label for="pvit_easypostwanderlust_shipper_zipcode">ZipCode<span> *</span>:</label>
			</th>
			<td class="forminp">
			<fieldset>
				 <input type="text" size="45" name="pvit_easypostwanderlust_shipper_zipcode" value="<?php echo get_option('pvit_easypostwanderlust_shipper_zipcode')?>" />
			</fieldset></td>
			</tr>											

		</tbody></table>	



</div>

<div style="clear: both;float: left;min-width: 275px;">	

		<h2 id="packagesizes" style="cursor:pointer;float: left;clear: both;width: 250px;">Predefined Package Sizes <img src="<?php echo plugins_url('includes/img/up-arrow-icon.png',dirname(__FILE__));?>" style="position: absolute;margin: -3px 5px;width: 24px;" /> </h2>
		<table  class="form-table packagesizes postbox">

		<tbody>
			<tr valign="top">
			<th scope="row" class="titledesc">
				  <label for="pvit_easypostwanderlust_usps">Show USPS: </label>
			</th>
			<td class="forminp">
			<fieldset>
				  <input type="checkbox" name="pvit_easypostwanderlust_usps" value="1" <?php checked(1, get_option('pvit_easypostwanderlust_usps'));?> /> Enabled
			</fieldset></td>
			</tr>

			<tr valign="top">
			<th scope="row" class="titledesc">
				  <label for="pvit_easypostwanderlust_fedex">Show FedEx: </label>
			</th>
			<td class="forminp">
			<fieldset>
				  <input type="checkbox" name="pvit_easypostwanderlust_fedex" value="1" <?php checked(1, get_option('pvit_easypostwanderlust_fedex'));?> /> Enabled
			</fieldset></td>
			</tr>

			<tr valign="top">
			<th scope="row" class="titledesc">
				  <label for="pvit_easypostwanderlust_ups">Show UPS: </label>
			</th>
			<td class="forminp">
			<fieldset>
				  <input type="checkbox" name="pvit_easypostwanderlust_ups" value="1" <?php checked(1, get_option('pvit_easypostwanderlust_ups'));?> /> Enabled
			</fieldset></td>
			</tr>
			
			<tr valign="top">
			<th scope="row" class="titledesc">
				  <label for="pvit_easypostwanderlust_dhlbox">Show DHL: </label>
			</th>
			<td class="forminp">
			<fieldset>
				  <input type="checkbox" name="pvit_easypostwanderlust_dhlbox" value="1" <?php checked(1, get_option('pvit_easypostwanderlust_dhlbox'));?> /> Enabled
			</fieldset></td>
			</tr>			
			
			
		 
		</tbody>
			<small style="float: left;clear: both;">These Predefined Packages will only return rates for their respective carrier. (Ex. FedExEnvelope - FedExBox - FedExPak - FedExTube)</small>

</table>
	
	<h2 id="servicesnames" style="cursor:pointer;float: left;clear: both;width: 250px;">Services Names <img src="<?php echo plugins_url('includes/img/up-arrow-icon.png',dirname(__FILE__));?>" style="position: absolute;margin: -3px 5px;width: 24px;" /> </h2>
		<table  class="form-table servicesnames postbox">

		<tbody>
			<tr valign="top">
			<th scope="row" class="titledesc">
				  <label for="pvit_easypostwanderlust_usps_service">USPS Services: </label>
			</th>
			<td class="forminp">
			<fieldset>
				  <input type="checkbox" name="pvit_easypostwanderlust_usps_service" value="1" <?php checked(1, get_option('pvit_easypostwanderlust_usps_service'));?> /> Enabled
			</fieldset></td>
			</tr>
<?php if(get_option('pvit_easypostwanderlust_usps_service') == '1') { ?> 	
 		<tr valign="top">
		<th scope="row" class="titledesc">
			<label for="pvit_easypostwanderlust_usps_service_first">First</label>
		</th>
		<td class="forminp">
		<fieldset>
			<input name="pvit_easypostwanderlust_usps_service_first" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_easypostwanderlust_usps_service_first')?>" />
		</fieldset>
		</td>
			</tr>
 		<tr valign="top">
		<th scope="row" class="titledesc">
			<label for="pvit_easypostwanderlust_usps_service_priority">Priority</label>
		</th>
		<td class="forminp">
		<fieldset>
			<input name="pvit_easypostwanderlust_usps_service_priority" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_easypostwanderlust_usps_service_priority')?>" />
		</fieldset>
		</td>
			</tr> 
 		<tr valign="top">
		<th scope="row" class="titledesc">
			<label for="pvit_easypostwanderlust_usps_service_express">Express</label>
		</th>
		<td class="forminp">
		<fieldset>
			<input name="pvit_easypostwanderlust_usps_service_express" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_easypostwanderlust_usps_service_express')?>" />
		</fieldset>
		</td>
			</tr> 
 		<tr valign="top">
		<th scope="row" class="titledesc">
			<label for="pvit_easypostwanderlust_usps_service_parcel">ParcelSelect</label>
		</th>
		<td class="forminp">
		<fieldset>
			<input name="pvit_easypostwanderlust_usps_service_parcel" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_easypostwanderlust_usps_service_parcel')?>" />
		</fieldset>
		</td>
			</tr> 
 		<tr valign="top">
		<th scope="row" class="titledesc">
			<label for="pvit_easypostwanderlust_usps_service_critical">CriticalMail</label>
		</th>
		<td class="forminp">
		<fieldset>
			<input name="pvit_easypostwanderlust_usps_service_critical" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_easypostwanderlust_usps_service_critical')?>" />
		</fieldset>
		</td>
			</tr> 
 		<tr valign="top">
		<th scope="row" class="titledesc">
			<label for="pvit_easypostwanderlust_usps_service_first_international">FirstClassMailInternational</label>
		</th>
		<td class="forminp">
		<fieldset>
			<input name="pvit_easypostwanderlust_usps_service_first_international" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_easypostwanderlust_usps_service_first_international')?>" />
		</fieldset>
		</td>
			</tr> 
 		<tr valign="top">
		<th scope="row" class="titledesc">
			<label for="pvit_easypostwanderlust_usps_service_first_pkg_international">FirstClassPackageInternational</label>
		</th>
		<td class="forminp">
		<fieldset>
			<input name="pvit_easypostwanderlust_usps_service_first_pkg_international" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_easypostwanderlust_usps_service_first_pkg_international')?>" />
		</fieldset>
		</td>
			</tr> 
 		<tr valign="top">
		<th scope="row" class="titledesc">
			<label for="pvit_easypostwanderlust_usps_service_priority_international">PriorityMailInternational</label>
		</th>
		<td class="forminp">
		<fieldset>
			<input name="pvit_easypostwanderlust_usps_service_priority_international" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_easypostwanderlust_usps_service_priority_international')?>" />
		</fieldset>
		</td>
			</tr> 
 		<tr valign="top">
		<th scope="row" class="titledesc">
			<label for="pvit_easypostwanderlust_usps_service_expres_international">ExpressMailInternational</label>
		</th>
		<td class="forminp">
		<fieldset>
			<input name="pvit_easypostwanderlust_usps_service_expres_international" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_easypostwanderlust_usps_service_expres_international')?>" />
		</fieldset>
		</td>
			</tr> 
<?php } ?>	
			
			<tr valign="top">
			<th scope="row" class="titledesc">
				  <label for="pvit_easypostwanderlust_fedex_service">FedEx Services: </label>
			</th>
			<td class="forminp">
			<fieldset>
				  <input type="checkbox" name="pvit_easypostwanderlust_fedex_service" value="1" <?php checked(1, get_option('pvit_easypostwanderlust_fedex_service'));?> /> Enabled
			</fieldset></td>
			</tr>
			
			
<?php if(get_option('pvit_easypostwanderlust_fedex_service') == '1') { ?> 	
 		<tr valign="top">
		<th scope="row" class="titledesc">
			<label for="pvit_easypostwanderlust_fedex_service_ground">FEDEX_GROUND</label>
		</th>
		<td class="forminp">
		<fieldset>
			<input name="pvit_easypostwanderlust_fedex_service_ground" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_easypostwanderlust_fedex_service_ground')?>" />
		</fieldset>
		</td>
			</tr>
 		<tr valign="top">
		<th scope="row" class="titledesc">
			<label for="pvit_easypostwanderlust_fedex_service_twoday">FEDEX_2_DAY</label>
		</th>
		<td class="forminp">
		<fieldset>
			<input name="pvit_easypostwanderlust_fedex_service_twoday" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_easypostwanderlust_fedex_service_twoday')?>" />
		</fieldset>
		</td>
			</tr> 
 		<tr valign="top">
		<th scope="row" class="titledesc">
			<label for="pvit_easypostwanderlust_fedex_service_twodayam">FEDEX_2_DAY_AM</label>
		</th>
		<td class="forminp">
		<fieldset>
			<input name="pvit_easypostwanderlust_fedex_service_twodayam" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_easypostwanderlust_fedex_service_twodayam')?>" />
		</fieldset>
		</td>
			</tr> 
 		<tr valign="top">
		<th scope="row" class="titledesc">
			<label for="pvit_easypostwanderlust_fedex_service_express">FEDEX_EXPRESS_SAVER</label>
		</th>
		<td class="forminp">
		<fieldset>
			<input name="pvit_easypostwanderlust_fedex_service_express" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_easypostwanderlust_fedex_service_express')?>" />
		</fieldset>
		</td>
			</tr> 
 		<tr valign="top">
		<th scope="row" class="titledesc">
			<label for="pvit_easypostwanderlust_fedex_service_standard">STANDARD_OVERNIGHT</label>
		</th>
		<td class="forminp">
		<fieldset>
			<input name="pvit_easypostwanderlust_fedex_service_standard" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_easypostwanderlust_fedex_service_standard')?>" />
		</fieldset>
		</td>
			</tr> 
 		<tr valign="top">
		<th scope="row" class="titledesc">
			<label for="pvit_easypostwanderlust_fedex_service_first">FIRST_OVERNIGHT</label>
		</th>
		<td class="forminp">
		<fieldset>
			<input name="pvit_easypostwanderlust_fedex_service_first" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_easypostwanderlust_fedex_service_first')?>" />
		</fieldset>
		</td>
			</tr> 
 		<tr valign="top">
		<th scope="row" class="titledesc">
			<label for="pvit_easypostwanderlust_fedex_service_priority">PRIORITY_OVERNIGHT</label>
		</th>
		<td class="forminp">
		<fieldset>
			<input name="pvit_easypostwanderlust_fedex_service_priority" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_easypostwanderlust_fedex_service_priority')?>" />
		</fieldset>
		</td>
			</tr> 
 		<tr valign="top">
		<th scope="row" class="titledesc">
			<label for="pvit_easypostwanderlust_fedex_service_inteconomy">INTERNATIONAL_ECONOMY</label>
		</th>
		<td class="forminp">
		<fieldset>
			<input name="pvit_easypostwanderlust_fedex_service_inteconomy" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_easypostwanderlust_fedex_service_inteconomy')?>" />
		</fieldset>
		</td>
			</tr> 
 		<tr valign="top">
		<th scope="row" class="titledesc">
			<label for="pvit_easypostwanderlust_fedex_service_intfirst">INTERNATIONAL_FIRST</label>
		</th>
		<td class="forminp">
		<fieldset>
			<input name="pvit_easypostwanderlust_fedex_service_intfirst" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_easypostwanderlust_fedex_service_intfirst')?>" />
		</fieldset>
		</td>
			</tr> 
 		<tr valign="top">
		<th scope="row" class="titledesc">
			<label for="pvit_easypostwanderlust_fedex_service_intpriority">INTERNATIONAL_PRIORITY</label>
		</th>
		<td class="forminp">
		<fieldset>
			<input name="pvit_easypostwanderlust_fedex_service_intpriority" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_easypostwanderlust_fedex_service_intpriority')?>" />
		</fieldset>
		</td>
			</tr> 
 		<tr valign="top">
		<th scope="row" class="titledesc">
			<label for="pvit_easypostwanderlust_fedex_service_groundhome">GROUND_HOME_DELIVERY</label>
		</th>
		<td class="forminp">
		<fieldset>
			<input name="pvit_easypostwanderlust_fedex_service_groundhome" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_easypostwanderlust_fedex_service_groundhome')?>" />
		</fieldset>
		</td>
			</tr> 			
<?php } ?>				
			

			<tr valign="top">
			<th scope="row" class="titledesc">
				  <label for="pvit_easypostwanderlust_dhl_service">DHL Express Services: </label>
			</th>
			<td class="forminp">
			<fieldset>
				  <input type="checkbox" name="pvit_easypostwanderlust_dhl_service" value="1" <?php checked(1, get_option('pvit_easypostwanderlust_dhl_service'));?> /> Enabled
			</fieldset></td>
			</tr>
			
	<?php if(get_option('pvit_easypostwanderlust_dhl_service') == '1') { ?> 	
 		<tr valign="top">
		<th scope="row" class="titledesc">
			<label for="pvit_easypostwanderlust_dhl_service_expressww">ExpressWorldwide</label>
		</th>
		<td class="forminp">
		<fieldset>
			<input name="pvit_easypostwanderlust_dhl_service_expressww" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_easypostwanderlust_dhl_service_expressww')?>" />
		</fieldset>
		</td>
 		</tr>		
 		<tr valign="top">
		<th scope="row" class="titledesc">
			<label for="pvit_easypostwanderlust_dhl_service_expresswwnondoc">ExpressWorldwideNonDoc</label>
		</th>
		<td class="forminp">
		<fieldset>
			<input name="pvit_easypostwanderlust_dhl_service_expresswwnondoc" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_easypostwanderlust_dhl_service_expresswwnondoc')?>" />
		</fieldset>
		</td>
 		</tr>				
 		<tr valign="top">
		<th scope="row" class="titledesc">
			<label for="pvit_easypostwanderlust_dhl_service_medicalexpnondoc">MedicalExpressNonDoc</label>
		</th>
		<td class="forminp">
		<fieldset>
			<input name="pvit_easypostwanderlust_dhl_service_medicalexpnondoc" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_easypostwanderlust_dhl_service_medicalexpnondoc')?>" />
		</fieldset>
		</td>
 		</tr>					
<?php } ?>			
			

			<tr valign="top">
			<th scope="row" class="titledesc">
				  <label for="pvit_easypostwanderlust_ups_service">UPS Services: </label>
			</th>
			<td class="forminp">
			<fieldset>
				  <input type="checkbox" name="pvit_easypostwanderlust_ups_service" value="1" <?php checked(1, get_option('pvit_easypostwanderlust_ups_service'));?> /> Enabled
			</fieldset></td>
			</tr>
			
	<?php if(get_option('pvit_easypostwanderlust_ups_service') == '1') { ?> 	
 		<tr valign="top">
		<th scope="row" class="titledesc">
			<label for="pvit_easypostwanderlust_ups_service_ground">Ground</label>
		</th>
		<td class="forminp">
		<fieldset>
			<input name="pvit_easypostwanderlust_ups_service_ground" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_easypostwanderlust_ups_service_ground')?>" />
		</fieldset>
		</td>
			</tr>		
 		<tr valign="top">
		<th scope="row" class="titledesc">
			<label for="pvit_easypostwanderlust_ups_service_standards">UPS Standards</label>
		</th>
		<td class="forminp">
		<fieldset>
			<input name="pvit_easypostwanderlust_ups_service_standards" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_easypostwanderlust_ups_service_standards')?>" />
		</fieldset>
		</td>
			</tr>
 		<tr valign="top">
		<th scope="row" class="titledesc">
			<label for="pvit_easypostwanderlust_ups_service_saver">UPS Saver</label>
		</th>
		<td class="forminp">
		<fieldset>
			<input name="pvit_easypostwanderlust_ups_service_saver" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_easypostwanderlust_ups_service_saver')?>" />
		</fieldset>
		</td>
			</tr>
 		<tr valign="top">
		<th scope="row" class="titledesc">
			<label for="pvit_easypostwanderlust_ups_service_expres">UPS Express</label>
		</th>
		<td class="forminp">
		<fieldset>
			<input name="pvit_easypostwanderlust_ups_service_expres" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_easypostwanderlust_ups_service_expres')?>" />
		</fieldset>
		</td>
			</tr>
			 		<tr valign="top">
		<th scope="row" class="titledesc">
			<label for="pvit_easypostwanderlust_ups_service_expresplus">UPS Express Plus</label>
		</th>
		<td class="forminp">
		<fieldset>
			<input name="pvit_easypostwanderlust_ups_service_expresplus" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_easypostwanderlust_ups_service_expresplus')?>" />
		</fieldset>
		</td>
			</tr>
			 		<tr valign="top">
		<th scope="row" class="titledesc">
			<label for="pvit_easypostwanderlust_ups_service_expedited">UPS Expedited</label>
		</th>
		<td class="forminp">
		<fieldset>
			<input name="pvit_easypostwanderlust_ups_service_expedited" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_easypostwanderlust_ups_service_expedited')?>" />
		</fieldset>
		</td>
			</tr>
			 		<tr valign="top">
		<th scope="row" class="titledesc">
			<label for="pvit_easypostwanderlust_ups_service_nda">UPS Next Day Air</label>
		</th>
		<td class="forminp">
		<fieldset>
			<input name="pvit_easypostwanderlust_ups_service_nda" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_easypostwanderlust_ups_service_nda')?>" />
		</fieldset>
		</td>
			</tr>
			 		<tr valign="top">
		<th scope="row" class="titledesc">
			<label for="pvit_easypostwanderlust_ups_service_ndas">UPS Next Day Air Saver</label>
		</th>
		<td class="forminp">
		<fieldset>
			<input name="pvit_easypostwanderlust_ups_service_ndas" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_easypostwanderlust_ups_service_ndas')?>" />
		</fieldset>
		</td>
			</tr>
			 		<tr valign="top">
		<th scope="row" class="titledesc">
			<label for="pvit_easypostwanderlust_ups_service_ndaea">UPS Next Day Air Early AM</label>
		</th>
		<td class="forminp">
		<fieldset>
			<input name="pvit_easypostwanderlust_ups_service_ndaea" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_easypostwanderlust_ups_service_ndaea')?>" />
		</fieldset>
		</td>
			</tr>
			 		<tr valign="top">
		<th scope="row" class="titledesc">
			<label for="pvit_easypostwanderlust_ups_service_2da">UPS 2nd Day Air</label>
		</th>
		<td class="forminp">
		<fieldset>
			<input name="pvit_easypostwanderlust_ups_service_2da" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_easypostwanderlust_ups_service_2da')?>" />
		</fieldset>
		</td>
			</tr>
			 		<tr valign="top">
		<th scope="row" class="titledesc">
			<label for="pvit_easypostwanderlust_ups_service_2daa">UPS 2nd Day Air AM</label>
		</th>
		<td class="forminp">
		<fieldset>
			<input name="pvit_easypostwanderlust_ups_service_2daa" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_easypostwanderlust_ups_service_2daa')?>" />
		</fieldset>
		</td>
			</tr>
			 		<tr valign="top">
		<th scope="row" class="titledesc">
			<label for="pvit_easypostwanderlust_ups_service_3ds">UPS 3Day Select</label>
		</th>
		<td class="forminp">
		<fieldset>
			<input name="pvit_easypostwanderlust_ups_service_3ds" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_easypostwanderlust_ups_service_3ds')?>" />
		</fieldset>
		</td>
			</tr>


<?php } ?>				
		 
		</tbody>
 
</table>

		<h2 id="emailsettings" style="cursor:pointer;float: left;clear: both;width: 250px;">Email Settings <img src="<?php echo plugins_url('includes/img/up-arrow-icon.png',dirname(__FILE__));?>" style="position: absolute;margin: -3px 5px;width: 24px;" /> </h2>
		<table  class="form-table emailsettings postbox">
		<tbody>

			<tr valign="top">
			<th scope="row" class="titledesc">
				  <label for="pvit_easypostwanderlust_email_label">Send labels via email: </label>
			</th>
			<td class="forminp">
			<fieldset>
				  <input type="checkbox" name="pvit_easypostwanderlust_email_label" value="1" <?php checked(1, get_option('pvit_easypostwanderlust_email_label'));?> /> Enabled
			</fieldset></td>
			</tr>

			<tr valign="top">
			<th scope="row" class="titledesc">
				  <label for="pvit_easypostwanderlust_email_label_to">Send To: </label>
			</th>
			<td class="forminp">
			<fieldset>
				 	<input type="text" size="45" name="pvit_easypostwanderlust_email_label_to" value="<?php echo get_option('pvit_easypostwanderlust_email_label_to')?>" />
			</fieldset></td>
			</tr>

			<tr valign="top">
			<th scope="row" class="titledesc">
				  <label for="pvit_easypostwanderlust_email_label_from">Send From: </label>
			</th>
			<td class="forminp">
			<fieldset>
				 	<input type="text" size="45" name="pvit_easypostwanderlust_email_label_from" value="<?php echo get_option('pvit_easypostwanderlust_email_label_from')?>" />
			</fieldset></td>
			</tr>
		 
		</tbody></table>	
	
	<h2 id="insurancesettings" style="cursor:pointer;float: left;clear: both;width: 250px;">Insurance Settings <img src="<?php echo plugins_url('includes/img/up-arrow-icon.png',dirname(__FILE__));?>" style="position: absolute;margin: -3px 5px;width: 24px;" /> </h2>
		<table  class="form-table insurancesettings postbox">
		<tbody>
 			<tr valign="top">
			<th scope="row" class="titledesc">
			<label for="pvit_easypostwanderlust_autoinsurance">Auto Insure Shipping:</label> 
				<small style="float: left;">Shipping Insurance by EasyPost (Cost: 1% of insured value).</small>
			</th>
			<td class="forminp">
			<fieldset>
				  <input type="checkbox" name="pvit_easypostwanderlust_autoinsurance" value="1" <?php checked(1, get_option('pvit_easypostwanderlust_autoinsurance'));?> /> Enabled
			</fieldset>
 				<small style="float: left;"><a href="https://www.easypost.com/shipping-insurance" target="_blank"> More Info </a></small>
			</td>
			</tr>
			
			<tr valign="top">
			<th scope="row" class="titledesc">
			<label for="pvit_easypostwanderlust_autoinsurance_cost">Charge Insure Cost:</label> 
				<small style="float: left;">(Cost: 1% of insured value). Add cost to Rates</small>
			</th>
			<td class="forminp">
			<fieldset>
				  <input type="checkbox" name="pvit_easypostwanderlust_autoinsurance_cost" value="1" <?php checked(1, get_option('pvit_easypostwanderlust_autoinsurance_cost'));?> /> Enabled
			</fieldset>
 				<small style="float: left;"><a href="https://www.easypost.com/shipping-insurance" target="_blank"> More Info </a></small>
 				</td>
			</tr>
		 
		</tbody></table>		
	 

		<h2 id="pluginoptions" style="cursor:pointer;float: left;clear: both;width: 250px;">Plugin Options <img src="<?php echo plugins_url('includes/img/up-arrow-icon.png',dirname(__FILE__));?>" style="position: absolute;margin: -3px 5px;width: 24px;" /> </h2>

		<table  class="form-table pluginoptions postbox">
		<tbody> 

			<tr valign="top">
			<th scope="row" class="titledesc">
				  <label for="pvit_easypostwanderlust_shipper_zipcode">Activate Testing Mode: </label>
			</th>
			<td class="forminp">
			<fieldset>
				  <input type="checkbox" name="pvit_easypostwanderlust_shipper_test" value="1" <?php checked(1, get_option('pvit_easypostwanderlust_shipper_test'));?> /> Enabled
			</fieldset></td>
			</tr>

			<tr valign="top">
			<th scope="row" class="titledesc">
				  <label for="pvit_easypostwanderlust_rates">Enable Rates at checkout: </label>
				  <small>Enable this as shipping method</small>
			</th>
			<td class="forminp">
			<fieldset>
				  <input type="checkbox" name="pvit_easypostwanderlust_rates" value="1" <?php checked(1, get_option('pvit_easypostwanderlust_rates'));?> /> Enabled
			<small><a href="<?php echo wp_nonce_url(admin_url('admin.php?page=wc-settings&tab=shipping&section=wc_shipping_wanderlust')); ?>">Settings</a></small>
			</fieldset></td>
			</tr>		
			
			<tr valign="top">
			<th scope="row" class="titledesc">
			<label for="pvit_easypostwanderlust_autogen">Auto Generate Label on payment Received:</label> 
				<small style="float: left;">Will move the order to completed.</small>
			</th>
			<td class="forminp">
			<fieldset>
				  <input type="checkbox" name="pvit_easypostwanderlust_autogen" value="1" <?php checked(1, get_option('pvit_easypostwanderlust_autogen'));?> /> Enabled
			</fieldset></td>
			</tr>
			
			<tr valign="top">
			<th scope="row" class="titledesc">
			<label for="pvit_easypostwanderlust_completed">Change to Completed</label> 
				<small style="float: left;">Will move the order to completed after label is generated.</small>
			</th>
			<td class="forminp">
			<fieldset>
				  <input type="checkbox" name="pvit_easypostwanderlust_completed" value="1" <?php checked(1, get_option('pvit_easypostwanderlust_completed'));?> /> Enabled
			</fieldset></td>
			</tr>			
					
			<tr valign="top">
			<th scope="row" class="titledesc">
				  <label for="pvit_easypostwanderlust_shipper_zipcode">License Status: </label>
			</th>
			<td class="forminp">
			<fieldset>
							<?php 
				$valid = get_option('pvit_easypostwanderlust_shipper_enable');
 				if($valid == '1'){
					echo 'Active';
				} else {
					echo 'Error';
				}
			?>	
				  <input style="display:none;" type="checkbox" name="pvit_easypostwanderlust_shipper_enable" value="1" <?php checked(1, get_option('pvit_easypostwanderlust_shipper_enable'));?> />  
			</fieldset></td>
			</tr>
		</tbody></table>	

 
</div>		
		<p style="margin-top: 10px; width: 100%; clear: both">
			<input type="submit" name="pvit_easypostwanderlust_shipper_config_save" value="<?php _e('Save Configuration');?>" class="button-primary" />
		</p>
	</form>
			<small>If you need help installing the plugin, send us an email to <a href="mailto:info@wanderlust-webdesign.com">info@wanderlust-webdesign.com</a></small> 
</div>

<style>	tbody{padding: 20px !important;position: relative;float: left;}</style>