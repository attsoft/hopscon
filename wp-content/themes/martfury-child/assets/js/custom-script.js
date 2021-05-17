//Custom Scripts By Devloper
var siteurl = WP_SITE_URLS.siteurl;


jQuery(document).ready(function($){
    var address = '';
    $('.customeditlnk').click(function()
    {
        address = $('#full_address_for_rwanda').val();
        send_address_to_function_file(address);
    })
    
    $('#full_address_for_rwanda').change(function(){
        address = localStorage.address;
        send_address_to_function_file(address);
       
    });
    
    function send_address_to_function_file(address)
    {
        // console.log(address);
        var data = {
          'action'  : 'user_address_from_rw',
          'address' : address
        };
        
        $.ajax({
            type: 'POST',
            url: WP_SITE_URLS.siteurl,
            data: data,
            dataType:'json',
            success: function(data) {
                console.log(data)
                // window.location.reload();
            }
        });
    }
})


jQuery( document ).ready(function($) {
		
jQuery('.woocommerce-MyAccount-navigation-link--rma-requests a, .woocommerce-orders-table__cell-order-actions a').addClass('custom-tooltip');	
jQuery('.woocommerce-MyAccount-navigation-link--rma-requests a').append( '<span class="tooltiptext">Return Merchandise Authorization</span>' );	

jQuery('.woocommerce-orders-table__cell-order-actions a.view').append( '<span class="tooltiptext">View Order</span>' );	
jQuery('.woocommerce-orders-table__cell-order-actions a.request_warranty').append( '<span class="tooltiptext">Request Warranty/Refund</span>' );	
jQuery('.woocommerce-orders-table__cell-order-actions a.invoice').append( '<span class="tooltiptext">Invoice</span>' );	
jQuery('.woocommerce-orders-table__cell-order-actions a.track_order').append( '<span class="tooltiptext">Track Order</span>' );	
jQuery('.woocommerce-orders-table__cell-order-actions a.product_review').append( '<span class="tooltiptext">Write a review</span>' );	
jQuery('.woocommerce-orders-table__cell-order-actions a.cancel').append( '<span class="tooltiptext">Cancel Order</span>' );	

		
//jQuery("#billing_phone_code_field input").prop('disabled', true);	
//jQuery("#shipping_phone_code_field input").prop('disabled', true);
			
jQuery('#reg_email, #user_email_3788').bind('copy',function(e) {
  e.preventDefault();
});	
jQuery('#confirm_email, #confirm_email_address_3788, #password_3788_2').bind('copy paste cut',function(e) {
  e.preventDefault();
});	
			
		jQuery('.wpuf-column-fields .password .wpuf-fields').append('<span toggle="#password_3788_1" class="fa fa-fw fa-eye field-icon toggle-password"></span>');
		jQuery('.wpuf-column-fields .confirm_password .wpuf-fields').append('<span toggle="#password_3788_2" class="fa fa-fw fa-eye field-icon toggle-password"></span>');
		
		
		
		jQuery(".toggle-password").click(function() {

		  jQuery(this).toggleClass("fa-eye fa-eye-slash");
		  var input = $($(this).attr("toggle"));
		  if (input.attr("type") == "password") {
			input.attr("type", "text");
		  } else {
			input.attr("type", "password");
		  }
		});
		
		jQuery(".close_icn").click(function() {
			jQuery(".otpmatch").css('display', 'none');
		
		});
		
		

	    $('.wpuf-submit .wpuf-submit-button').click(function(){ 
	    	//
		    var email = $.trim($('#user_email_3788').val());
		    var con_email = $.trim($('#confirm_email_address_3788').val());
		    //alert(email);
		    if (email != con_email) { 
		        $('.confirm_email_address .wpuf-fields').append('<li class="has-error confirm_email_address_error">Confirm Email address not match.</li>'); 
		       return false; // stops the form submitting. 
		    }
		});

	    $('.cus_wc_regiester').click(function(){ 
	    	//
	    	var email = $.trim($('#reg_email').val());
		    var con_email = $.trim($('#confirm_email').val());
			var otp_check = $('#sendedotp').val();
		    //alert(email);
			if(email && con_email){
		    	if (email != con_email) { 
		        	$('.confirm_email_address_user').append('<span class="has-error confirm_email_address_error">Confirm Email address not match.</span>'); 
		       		return false; // stops the form submitting. 
		    	} 
			}
			/*if(otp_check != 'yes'){
				$('.vefify_otp_row').append('<span class="has-error otp_verify_error" style="color:red">Phone number must be Verifed.</span>'); 
		       return false;
				}*/
	    });
	    
		$('#dokan_store_phone').keyup(function(e){

		  	/*var phoneno = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
		  	console.log($(this).val());
  			if(($(this).val().match(phoneno)) ) {
  				console.log($(this).val());
  			}*/
  			
		});
	    
});

//Get Country Phone Code
function get_country(selected_country){
	var siteurl = WP_SITE_URLS.siteurl;
	jQuery("#customer-phone").val('');
	var selected_country = selected_country.value;
	jQuery(".loading_icn").css('display', 'block');	
		jQuery.ajax({
                type: 'POST',
                dataType: "json",
                url :  siteurl,
                data : {
                    country: selected_country,
                    action: 'upDateMobileCountryCode',
                }, 
                success : function(response){
				if(response.status) {
						jQuery('.xoo-ml-phone-cc').val(response.countrycode); // Change the value or make some change to the internal state
						jQuery('.xoo-ml-phone-cc').trigger('change.select2'); // Notify only Select2 of changes
						jQuery('.xoo-ml-reg-phone-cc-hid').val(response.countrycode);
						jQuery('#phone-cd').val(response.countrycode);
						jQuery(".loading_icn").css('display', 'none');
                }
               } 
       });
}

//function country_drcode(selected_country){ 


jQuery( "#drvr_country" ).change(function() {
	var siteurl = WP_SITE_URLS.siteurl;
	//jQuery("#dr_phone_cd").val('');
	var selected_country = jQuery(this).find(":selected").val();
	//jQuery(".loading_icn").css('display', 'block');	
		jQuery.ajax({
                type: 'POST',
                dataType: "json",
                url :  siteurl,
                data : {
                    country: selected_country,
					form_id: 'Old_fm',
                    action: 'upDateMobileCountryCode',
                }, 
                success : function(response){
				if(response.status) {
						jQuery('#dr_phone_cd').val(response.countrycode); // Change the value or make some change to the internal state
						//jQuery(".loading_icn").css('display', 'none');
						return false;
                }
               } 
       });
});


jQuery( ".vendor_country select" ).change(function() {
  var siteurl = WP_SITE_URLS.siteurl;
  jQuery('#phone_number_3788').val('');
  var selected_country = jQuery(this).find(":selected").val();
  
	jQuery(".loading_icn").css('display', 'block');	
		jQuery.ajax({
                type: 'POST',
                dataType: "json",
                url :  siteurl,
                data : {
                    country: selected_country,
                    action: 'upDateMobileCountryCode',
                }, 
				
                success : function(response){
					
				if(response.status) {
						jQuery('#xoo-ml-user-reg-phone-cc_3788').val(response.countrycode);
						jQuery(".loading_icn").css('display', 'none');
                }
               } 
       });
});

jQuery( "#dokan_address_country" ).change(function() {
   var siteurl = WP_SITE_URLS.siteurl;
  jQuery('#migrate_phcd').val('');
  var selected_country = jQuery(this).find(":selected").val();
		jQuery.ajax({
                type: 'POST',
                dataType: "json",
                url :  siteurl,
                data : {
                    country: selected_country,
                    action: 'upDateMobileCountryCode',
                }, 
				
                success : function(response){
					
				if(response.status) {
						jQuery('#migrate_phcd').val(response.countrycode);
						jQuery('#setting_phone_cd').val(response.countrycode);
						jQuery(".loading_icn").css('display', 'none');
                }
               } 
       });
});

jQuery( "#billing_country" ).change(function() {
   var siteurl = WP_SITE_URLS.siteurl;
  jQuery('#billing_phone_code').val('');
  var selected_country = jQuery(this).find(":selected").val();
 
		jQuery.ajax({
                type: 'POST',
                dataType: "json",
                url :  siteurl,
                data : {
                    country: selected_country,
                    action: 'upDateMobileCountryCode',
                }, 
				
                success : function(response){
					
				if(response.status) {
						jQuery('#billing_phone_code').val(response.countrycode);
						jQuery(".loading_icn").css('display', 'none');
                }
               } 
       });
});

jQuery( "#shipping_country" ).change(function() {
   var siteurl = WP_SITE_URLS.siteurl;
  jQuery('#shipping_phone_code').val('');
  var selected_country = jQuery(this).find(":selected").val();
 
		jQuery.ajax({
                type: 'POST',
                dataType: "json",
                url :  siteurl,
                data : {
                    country: selected_country,
                    action: 'upDateMobileCountryCode',
                }, 
				
                success : function(response){
					
				if(response.status) {
						jQuery('#shipping_phone_code').val(response.countrycode);
						jQuery(".loading_icn").css('display', 'none');
                }
               } 
       });
});


//Send OTP to Phone

//function get_otp(otp){
//	 var siteurl = WP_SITE_URLS.siteurl;
//	var phone_num = jQuery("#customer-phone").val();
//	var venodrphone_num = jQuery("#phone_number_3788").val();
//	var venodrphone_cuntrycd = jQuery("#xoo-ml-user-reg-phone-cc_3788").val();
//	venodrphone_num = "" + venodrphone_cuntrycd + venodrphone_num ; 
//	if(phone_num || venodrphone_num){
//	jQuery(".loading_icn").css('display', 'block');	
//		jQuery.ajax({
//                type: 'POST',
//                dataType: "json",
//                url :  siteurl,
//                data : {
//                    phone_num: phone_num,
//					venodrphone_num: venodrphone_num,
//                    action: 'send_otp_tophone',
//                }, 
//                success : function(response){
//				if(response.status) {
//					
//					jQuery('.otp_msg').text(response.msg);
//					jQuery('.otp_msg').css('color','green');
//					//jQuery('#sendedotp').val(response.otp);
//					jQuery(".loading_icn").css('display', 'none');
//						
//                }else{
//					jQuery('.otp_msg').text(response.msg);
//					jQuery('.otp_msg').css('color','red');
//					jQuery(".loading_icn").css('display', 'none');
//				}
//               } 
//       });
//	}
//}


//Verify OTP
//function verify_otp(otp){
//	 var siteurl = WP_SITE_URLS.siteurl;
//	//var otp_sended = jQuery("#sendedotp").val();
//	var otp_customer = jQuery("#vefify_otp").val();
//	var otp_vendor = jQuery("#verify_otp_3788").val();
//	
//	if(otp_customer || otp_vendor){
//	jQuery(".loading_icn_vr").css('display', 'block');	
//		jQuery.ajax({
//                type: 'POST',
//                dataType: "json",
//                url :  siteurl,
//                data : {
//                  
//					otp_customer: otp_customer,
//					otp_vendor: otp_vendor,
//                    action: 'verify_otp',
//                }, 
//                success : function(response){
//				if(response.status) {
//					jQuery('.very_msg').text(response.msg);
//					jQuery('.very_msg').css('color','green');
//					jQuery(".loading_icn_vr").css('display', 'none');
//					jQuery('#vefify_otp').prop('required',false);
//					jQuery('#sendedotp').val('yes');
//					jQuery('.otp_verify_error').css('display', 'none');
//					jQuery('#verify_otp_3788').attr('data-required', 'no')
//					
//					
//					
//                }else{
//					jQuery('.very_msg').text(response.msg);
//					jQuery('.very_msg').css('color','red');
//					jQuery(".loading_icn_vr").css('display', 'none');
//				}
//               } 
//       });
//	}
//}

//Assign Order Driver by Vendor

jQuery( ".driver_list" ).change(function() {
   var siteurl = WP_SITE_URLS.siteurl;
  var selecteddriver = jQuery(this).find(":selected").val();
  var orderid = jQuery(this).attr('data-orderid');
  jQuery("#loading-"+orderid).css('display', 'block');	
  jQuery.ajax({
                type: 'POST',
                dataType: "json",
                url :  siteurl,
                data : {
                    driver_id: selecteddriver,
					order_id: orderid,
                    action: 'upDateOrderDriver',
                }, 
                success : function(response){
				if(response.status) {
                 	window.location = response.redirect;
					jQuery(".loading_dr").css('display', 'none');
                }else{
					alert('There was an error on your driver assign please try after some time..');
					window.location = response.redirect;
					
				}
         } 
    });
});

// 2Fector Authantication 
//(function($,W,D){
// var siteurl = WP_SITE_URLS.siteurl;		
//var JQUERY4U = {};
//JQUERY4U.UTIL =
//{
// setupFormValidation: function()
// {
//  //form validation rules
//  $("#woo_login_form").validate({
//   rules: {
//		username : {
//			required: true,
//		},	
//		password    : {
//			required: true,
//		},
//	},
//	messages: {
//		username: {
//			required: "Please enter your email",
//		},
//  
//		password    : {
//			required: "Please enter valid email address",
//		},
//	},
//	   submitHandler: function(form) {
//		  $.ajax({
//                type: 'POST',
//				dataType: "json",
//                url :  siteurl,
//                data : {
//					username: jQuery("input#username").val(),
//					password: jQuery("input#password").val(),
//                    action: 'verify_and_send_otp',
//                }, 
//                success : function(response){
//				if(response.status) {
//					jQuery("#popup_otp").css('display', 'block');
//					jQuery("#mobile_num").text(response.phone);
//					return false;
//                }else{
//					form.submit();
//				}
//           } 
//       });
//        
//			
//	  }
//  });
// }
//}
//$(D).ready(function($) {
// JQUERY4U.UTIL.setupFormValidation();
//});
//
//})(jQuery, window, document);

/*jQuery("form#mo_validate_form").submit(function(e){
	e.preventDefault(e);
	var otp_val = jQuery('#mo_otp_token').val();
	
	jQuery.ajax({
                type: 'POST',
                dataType: "json",
                url :  siteurl,
                data : {
                  
					otp: otp_val,
                    action: 'otp_token_authanticate',
                }, 
                success : function(response){
				if(response.status) {
					window.location.href = "http://hopscan-stg.com/my-account/";
				return false;
                }else{
					
					jQuery('.invalid_otp').css('display','block');
					return false;
				}
               } 
       });
	
	});
*/	

//Hide Otp Error
jQuery( "#mo_otp_token" ).keyup(function() {
  jQuery('.error').css('display','none');
});	


//Resend Autantication OTP
function mo_otp_verification_resend(){
	var siteurl = WP_SITE_URLS.siteurl;
	jQuery.ajax({
		type: 'POST',
		dataType: "json",
		url :  siteurl,
		data : {
			action: 'resend_login_otp',
		}, 
		success : function(response){
		if(response.status) {
			//alert('New OTP Sended to your number Please Check.');
			jQuery(".resend_done").text("Notification sent. This may take a minute to arrive. If needed, you may request a new notification in 25 second(s)."); 
			
		}else{
			
			jQuery('.invalid_otp').css('display','block');
			return false;
		}
	   } 
       });
	}

//Refresh Login Page	
jQuery(document).ready(function(){
	jQuery(".refresh_pp a").click(function(){
		jQuery('#popup_otp').css('display','none');
		location.reload(true);
	});
	
	jQuery(".Complete_btn").click(function(){
		jQuery('.otpmatch').css('display', 'none');
		var product_id = jQuery(this).children().attr('data-orderid');
		jQuery('#otpmatch-' + product_id).css('display', 'block');
		jQuery( '.complite_btn' ).prop( 'disabled', true );
	return false;
});
	
});	


//Close Navigation On Mobile Crose Click
jQuery('.close-mobile-nav').click(function(){
	jQuery('body').removeClass('display-mobile-menu');
});	 


//Vendor Deactivet Driver for Order list
jQuery(".forspacificvd input").change(function() {
    if(this.checked) {
		var option_val = 'active';
    }else{
		var option_val = 'inactive';	
	}
	var user_id = jQuery(this).attr("data-id");
	var siteurl = WP_SITE_URLS.siteurl;
	jQuery.ajax({
		type: 'POST',
		dataType: "json",
		url :  siteurl,
		data : {
			user_id : user_id,
			option_value : option_val,
			action: 'deactivet_driver_for_vendor',
		}, 
		success : function(response){
		if(response.status) {
			//alert('New OTP Sended to your number Please Check.');
			
		}else{
			alert('No Driver status updated Please try after some time.');
			return false;
		}
	   } 
       });
	
});

jQuery('form.driver_updateorder input#ordercompleted').on('click', function(event) {
    event.preventDefault();
    jQuery('.otpmatch').css('display', 'block');
	jQuery( "#ordercompleted" ).prop( "disabled", true );
    //this.submit(); 
});



jQuery('.otpsubmit').click(function(){
	   jQuery('.loding_icon').css('display', 'block');	
	   var otp = jQuery('#order_otp').val();
	   var order_idn = jQuery(this).attr('data-orderid');
	    var order_id = jQuery('#otporder').val();
		var data={
			 "action": "check_otp",
			 "otp": otp,
			 "order": order_id,
 			  };
				jQuery('.delivery_noti').append('<span class="dokan-loading"> </span>');
				jQuery(".delivery_noti a").attr('disabled','disabled');
				jQuery.ajax({
				  type: "POST",
				  url: dokan.ajaxurl, 
				  data: data,
				  
				  success: function(data) {
				      //console.log(data);
					jQuery('span.dokan-loading').remove();
				  if(data == 'success'){
				      
				    alert('Order Completed');  
					location.reload();
				  } 
				  else
				  {
					  jQuery('.otpmatch').hide();
					  jQuery( "#ordercompleted" ).prop( "disabled", false );
					  alert('Otp Not Match');
					  jQuery('.loding_icon').css('display', 'none');	
				  }
 				  }
				});
		      return false;
 });

jQuery('.withoutotpsubmit').click(function(){
	   jQuery('.loding_icon').css('display', 'block');	
	   jQuery('#order_otp').removeAttr('required');
	    var order_id = jQuery('#otporder').val();
		var data={
			 "action": "witout_check_otp",
			 "order": order_id,
 			  };
				jQuery('.delivery_noti').append('<span class="dokan-loading"> </span>');
				jQuery(".delivery_noti a").attr('disabled','disabled');
				jQuery.ajax({
				  type: "POST",
				  url: dokan.ajaxurl, 
				  data: data,
				  success: function(data) {
					jQuery('span.dokan-loading').remove();
				  if(data == 'success'){
					location.reload();
				  } 
				  else
				  {
					  jQuery('.otpmatch').hide();
					  jQuery( "#ordercompleted" ).prop( "disabled", false );
					  alert('Otp Not Match');
					  jQuery('.loding_icon').css('display', 'none');	
				  }
 				  }
				});
		      return false;
 }); 
 
//Change Contact Form Success Message 
document.addEventListener( 'wpcf7mailsent', function( event ) {
   jQuery(".wpcf7-form").append("<div class='wpcf7-response-output-custom custom_msg'> Thanks for contacting <strong>HoPscan</strong>. We\'ll get back to your as soon as possible.</div>");
}, false );

//Show hide billing fields on my account edit page

jQuery('input[name=diffrent_bill]').change(function(){
var value_ch = jQuery( 'input[name=diffrent_bill]:checked' ).val();
 if(value_ch == 'no') {
        jQuery(".myac-extra-billing").show();
    } else {
        jQuery(".myac-extra-billing").hide();
    }
});

//Set Residence address as billing 
jQuery(document).ready(function() {
	
	
		 jQuery('.checkout-billing #billing_first_name').val('');
		 jQuery('.checkout-billing #billing_last_name').val('');
		 jQuery('.checkout-billing #billing_email').val('');
		 jQuery('.checkout-billing #billing_address_1').val('');
		 jQuery('.checkout-billing #billing_address_2').val('');
		 jQuery('.checkout-billing #billing_city').val('');
		 jQuery('.checkout-billing #billing_state').val('');
		 jQuery('.checkout-billing #billing_state').trigger('change.select2');
		 jQuery('.checkout-billing #billing_postcode').val('');
		 
		 jQuery('.checkout-billing #billing_company').val('');
		 jQuery('.checkout-billing #billing_phone_code').val('');
		 jQuery('.checkout-billing #billing_phone').val('');
		 jQuery('.checkout-billing #billing_country').val('default');
		 jQuery('.checkout-billing #billing_country').trigger('change.select2');
	
	
    jQuery('#use_rsasbl').change(function() { 
	if(this.checked) {
		jQuery('#loading_rsad').css('display', 'block');
		var data={
			"action": "update_billing_address",		
		};
		jQuery.ajax({
		  type: "POST",
		  url: dokan.ajaxurl, 
		  data: data,
		  success: function(data) {
			  var obj = JSON.parse(data);
			  if (obj.billing_first_name === null) {
			 		jQuery('#billing_first_name').val('');
				}else{
			 		jQuery('#billing_first_name').val(obj.billing_first_name[0]);
				}
			 if (obj.billing_last_name === null) {
			 		jQuery('#billing_last_name').val('');
				}else{
			 		jQuery('#billing_last_name').val(obj.billing_last_name[0]);
				}
			 if (obj.billing_email === null) {
			 		jQuery('#billing_email').val('');
				}else{
			 		jQuery('#billing_email').val(obj.billing_email[0]);
				}
			 if (obj.billing_company === null) {
			 		jQuery('#billing_company').val('');
				}else{
			 		jQuery('#billing_company').val(obj.billing_company[0]);
				}
			 if (obj.billing_company === null) {
			 		jQuery('#billing_company').val('');
				}else{
			 		jQuery('#billing_company').val(obj.billing_company[0]);
				}
			 if (obj.billing_phone_code === null) {
			 		jQuery('#billing_phone_code').val('');
				}else{
			 		jQuery('#billing_phone_code').val(obj.billing_phone_code[0]);
				}
			 if (obj.billing_phone === null) {
			 		jQuery('#billing_phone').val('');
				}else{
			 		jQuery('#billing_phone').val(obj.billing_phone[0]);
				}
			 if (obj.billing_country === null) {
				 
				}else{
			 		jQuery('#billing_country').val(obj.billing_country[0]);
				}
			 if (obj.billing_address_1 === null) {
			 		jQuery('#billing_address_1').val('');
			    }else{
			 		jQuery('#billing_address_1').val(obj.billing_address_1[0]);
			    }
			 jQuery('#billing_country').trigger('change.select2');

			 if (obj.billing_address_2 === null) {
			 		jQuery('#billing_address_2').val('');
			    }else{
			 		jQuery('#billing_address_2').val(obj.billing_address_2[0]);
			    }
			 if (obj.billing_city === null) {
			 		jQuery('#billing_city').val('');
			    }else{
			 		jQuery('#billing_city').val(obj.billing_city[0]);
			    } 
			 if (obj.billing_state === null) {
			 		jQuery('#billing_state').val('');
			    }else{
			 		jQuery('#billing_state').val(obj.billing_state[0]);
			    }
			 if (obj.billing_postcode === null) {
			 		jQuery('#billing_postcode').val('');
			    }else{
			 		jQuery('#billing_postcode').val(obj.billing_postcode[0]);
			    }
			 jQuery('#billing_state').trigger('change.select2');
		
			jQuery('#loading_rsad').css('display', 'none');
			
		  }
		});
	}else{
		
		 jQuery('#loading_rsad').css('display', 'block');
		 jQuery('.checkout-billing #billing_first_name').val('');
		 jQuery('.checkout-billing #billing_last_name').val('');
		 jQuery('.checkout-billing #billing_email').val('');
		 jQuery('#billing_address_1').val('');
		 jQuery('#billing_address_2').val('');
		 jQuery('#billing_city').val('');
		 jQuery('#billing_state').val('');
		 jQuery('#billing_state').trigger('change.select2');
		 jQuery('#billing_postcode').val('');
		 
		 jQuery('#billing_company').val('');
		 jQuery('#billing_phone_code').val('');
		 jQuery('#billing_phone').val('');
		 jQuery('#billing_country').val('default');
		 jQuery('#billing_country').trigger('change.select2');
		 jQuery('#loading_rsad').css('display', 'none'); 
		
		
		//var data={
//			"action": "update_billing_address_again",		
//		};
//		jQuery.ajax({
//		  type: "POST",
//		  url: dokan.ajaxurl, 
//		  data: data,
//		  success: function(data) {
//			  var obj = JSON.parse(data);
//			 jQuery('#billing_address_1').val(obj.billing_address_1[0]);
//			 jQuery('#billing_address_2').val(obj.billing_address_2[0]);
//			 jQuery('#billing_city').val(obj.billing_city[0]);
//			 jQuery('#billing_state').val(obj.billing_state[0]);
//			 jQuery('#billing_postcode').val(obj.billing_postcode[0]);
//			//location.reload();
//			jQuery('#loading_rsad').css('display', 'none');
//			
//		  }
//		});
	}
		});
}); 

	