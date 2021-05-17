(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	 var ajaxurl = mwb_woo_msa_param.ajax_url;

	 $(document).ready(function(){
	 	// console.log($('.mwb_woocommerce_msa_address_wrapper').next());
	 	var div = $('.mwb_woocommerce_msa_address_wrapper');
	 	var next = $('.mwb_woocommerce_msa_address_wrapper').next();
	 	$(".mwb_woocommerce_msa_address_wrapper").each(function(index) {
	 		$(this).next("a").andSelf().wrapAll("<div class='mwb_woo_msa_cart_item_wrapper' />");
	 	});
	 	$('.mwb_woo_msa_cart_item_address').select2();

	 	$("#billing_postcode").keypress(function (e) {
	 		if (e.which != 8 && e.which != 0 && String.fromCharCode(e.which) != '.' && (e.which < 48 || e.which > 57)) {
	 			return false;
	 		}
	 	});
	 	$("#mwb_woo_msa_guest_user_post_code").keypress(function (e) {
	 		if (e.which != 8 && e.which != 0 && String.fromCharCode(e.which) != '.' && (e.which < 48 || e.which > 57)) {
	 			return false;
	 		}
	 	});

	 });

	 $(document).on('click',function(e){
	 	if(e.target.id == 'mwb_woo_msa_hide_popup')
	 	{
	 		$(document).find('#mwb_woo_msa_hide_popup').removeClass('mwb_woo_msa_modal_open');
	 		$(document).find('.mwb_woo_msa_edit_addr').each(function(){
	 			if($(this).html() == mwb_woo_msa_param.updated_button){
	 				$(this).html(mwb_woo_msa_param.edit_button);
	 			}
	 		});
	 		$(document).find('.mwb_woo_msa_guest_edit_addr').each(function(){
	 			if($(this).html() == mwb_woo_msa_param.updated_button){
	 				$(this).html(mwb_woo_msa_param.edit_button);
	 			}
	 		});
	 	}
	 });


	 $(document).on('click','.mwb_woocommerce_msa_saved_address',function(){
	 	$(document).find('.mwb_woo_msa_user_saved_address_wrapper').toggleClass('mwb_woo_show');
	 	
	 	if($(this).val() == mwb_woo_msa_param.toggle_button_value){

	 		$(this).val(mwb_woo_msa_param.toggle_show);
	 	}else{

	 		$(this).val(mwb_woo_msa_param.toggle_button_value);
	 	}
	 });



	 $(document).on('click','.mwb_woo_msa_open_modal_button',function(){

	 	$(document).find('.mwb_woo_multiple_shipping_address').addClass('mwb_woo_msa_modal_open');
	 });

	 $(document).on('click','.mwb_woo_msa_close_modal',function(){

	 	$(document).find('.mwb_woo_multiple_shipping_address').removeClass('mwb_woo_msa_modal_open');
	 	$(document).find('.mwb_woo_msa_edit_addr').each(function(){
	 		if($(this).html() == mwb_woo_msa_param.updated_button){
	 			$(this).html(mwb_woo_msa_param.edit_button);
	 		}
	 	});
	 	$(document).find('.mwb_woo_msa_guest_edit_addr').each(function(){
	 		if($(this).html() == mwb_woo_msa_param.updated_button){
	 			$(this).html(mwb_woo_msa_param.edit_button);
	 		}
	 	});
	 });

	 $(document).on('click','#mwb_woo_msa_guest_user_data_submit',function(){

	 	var mwb_woo_msa_addr1 = $(document).find('#mwb_woo_msa_guest_user_address').val();
	 	var mwb_woo_msa_addr2 = $(document).find('#mwb_woo_msa_guest_user_address2').val();
	 	var mwb_woo_msa_town =  $(document).find('#mwb_woo_msa_guest_user_town').val();
	 	var mwb_woo_msa_country =  $(document).find('#billing_country').val();
	 	var mwb_woo_msa_state  =  $(document).find('#billing_state').val();
	 	var mwb_woo_msa_zip  =  $(document).find('#billing_postcode').val();

	 	if(mwb_woo_msa_addr1 == ''){
	 		$(document).find('#mwb_woo_msa_guest_user_address').attr('placeholder',mwb_woo_msa_param.validation_msg);
	 		$(document).find('#mwb_woo_msa_guest_user_address').css('background-color','#f1baba','important');
	 		return false;
	 	}
	 	if(mwb_woo_msa_addr2 == ''){
	 		$(document).find('#mwb_woo_msa_guest_user_address2').attr('placeholder',mwb_woo_msa_param.validation_msg);
	 		$(document).find('#mwb_woo_msa_guest_user_address2').css('background-color','#f1baba','important');
	 		return false;
	 	}
	 	if(mwb_woo_msa_town == ''){
	 		$(document).find('#mwb_woo_msa_guest_user_town').attr('placeholder',mwb_woo_msa_param.validation_msg);
	 		$(document).find('#mwb_woo_msa_guest_user_town').css('background-color','#f1baba','important');
	 		return false;
	 	}
	 	if(mwb_woo_msa_country == ''){
	 		$(document).find('#billing_country').attr('placeholder',mwb_woo_msa_param.validation_msg);
	 		$(document).find('#billing_country').css('background-color','#f1baba','important');
	 		return false;
	 	}

	 	if(mwb_woo_msa_state == ''){
	 		$(document).find('#billing_state').attr('placeholder',mwb_woo_msa_param.validation_msg);
	 		$(document).find('#billing_state').css('background-color','#f1baba','important');
	 		return false;
	 	}
	 	if(mwb_woo_msa_zip == ''){
	 		$(document).find('#billing_postcode').attr('placeholder',mwb_woo_msa_param.validation_msg);
	 		$(document).find('#billing_postcode').css('background-color','#f1baba','important');
	 		return false;
	 	}


	 	block($(document).find('.mwb_woo_multiple_shipping_address'));
	 	$.ajax({
	 		url : ajaxurl,
	 		type : 'POST',
	 		cache : false,
	 		data : {
	 			action : 'mwb_woo_msa_set_guest_user_address_in_cookies',
	 			MwbWooMsaAddr : mwb_woo_msa_addr1,
	 			MwbWooMsaAddr2 : mwb_woo_msa_addr2,
	 			MwbWooMsaTown : mwb_woo_msa_town,
	 			MwbWooMsaCountry : mwb_woo_msa_country,
	 			MwbWooMsaState : mwb_woo_msa_state,
	 			MwbWooMsaZip : mwb_woo_msa_zip
	 		},success : function(response){
	 			console.log(response);
	 			if(response == 'success'){
	 				unblock($(document).find('.mwb_woo_multiple_shipping_address'));
	 				window.location.reload();
	 			}
	 			else{
	 				unblock($(document).find('.mwb_woo_multiple_shipping_address'));
	 				window.location.reload();
	 			}
	 		}
	 	});
	 });


	 $(document).on('click','.mwb_woo_delete_address',function(){
	 	var user_ask_confirm = window.confirm("Are you sure you want to delete this record ?");
	 	if(user_ask_confirm){
	 		var mwb_woo_delete_address_index = $(this).attr('data-delete_addr');
	 		block($(document).find('.mwb_woo_msa_user_saved_address_wrapper'));
	 		$.ajax({
	 			url : ajaxurl,
	 			type : 'POST',
	 			cache : false,
	 			data : {
	 				action : 'mwb_woo_msa_delete_address',
	 				Mwb_Woo_Msa_Delete_Address : mwb_woo_delete_address_index
	 			},success : function(response){
	 				console.log(response);
	 				if(response == 'success'){
	 					unblock($(document).find('.mwb_woo_msa_user_saved_address_wrapper'));
	 					window.location.reload();
	 				}
	 				else{
	 					unblock($(document).find('.mwb_woo_msa_user_saved_address_wrapper'));
	 					window.location.reload();
	 				}
	 			}
	 		});
	 	}
	 });

	 
	 $(document).on('click','.mwb_woo_guest_delete_address',function(){
	 	
	 	var mwb_woo_delete_address_index = $(this).attr('data-delete_addr');
	 	var user_ask_confirm = window.confirm("Are you sure you want to delete this record ?");
	 	if(user_ask_confirm){
	 		block($(document).find('.mwb_woo_msa_user_saved_address_wrapper'));
	 		$.ajax({
	 			url : ajaxurl,
	 			type : 'POST',
	 			cache : false,
	 			data : {
	 				action : 'mwb_woo_msa_delete_address',
	 				Mwb_Woo_Msa_Delete_Address : mwb_woo_delete_address_index
	 			},success : function(response){
	 				console.log(response);
	 				if(response == 'success'){
	 					unblock($(document).find('.mwb_woo_msa_user_saved_address_wrapper'));
	 					window.location.reload();
	 				}else{

	 					unblock($(document).find('.mwb_woo_msa_user_saved_address_wrapper'));
	 					window.location.reload();
	 				}
	 			}
	 		});
	 	}
	 });


	 $(document).on('click','.mwb_woo_msa_edit_addr',function(){
	 	
	 	var mwb_wmsa_update_addr = $(this).attr('data-edit_addr');
	 	var mwb_wmsa_update_country = $(this).attr('data-selected_country');
	 	var mwb_wmsa_update_state = $(this).attr('data-selected_state');

	 	if($(this).html() == mwb_woo_msa_param.edit_button){
	 		$(this).html(mwb_woo_msa_param.updated_button);
	 		
	 		$(document).find('.mwb_woo_multiple_shipping_address').addClass('mwb_woo_msa_modal_open');
	 		$(document).find('#mwb_woo_msa_user_address').val($(this).parent().siblings('.mwb_woo_address1').text());
	 		
	 		$(document).find('#mwb_woo_msa_user_address2').val($(this).parent().siblings('.mwb_woo_address2').text());
	 		
	 		$(document).find('#mwb_woo_msa_user_town').val($(this).parent().siblings('.mwb_woo_town').text());
	 		$(document).find('#billing_country').val(mwb_wmsa_update_country);
	 		$(document).find('#billing_country').trigger('change');

	 		$(document).find('#billing_state').val(mwb_wmsa_update_state);
	 		$(document).find('#billing_state').trigger('change');
	 		
	 		$(document).find('#billing_postcode').val($(this).parent().siblings('.mwb_woo_zip').text());
	 		
	 		$(document).find('#mwb_woo_msa_user_data_submit').attr('name','');

	 		$(document).find('#mwb_woo_msa_user_data_submit').attr('id','mwb_woo_msa_edit_submit');
	 		$(document).find('#mwb_woo_msa_edit_submit').attr('name','mwb_woo_msa_edit_submit');
	 		$(document).find('#mwb_woo_msa_edit_submit').attr('data-edit_index',mwb_wmsa_update_addr);
	 		
	 	}else{
	 		$(this).html(mwb_woo_msa_param.edit_button);
	 	}
	 });


	 $(document).on('click','.mwb_woo_msa_guest_edit_addr',function(){
	 	var mwb_wmsa_update_addr = $(this).attr('data-edit_addr');
	 	var mwb_wmsa_update_country = $(this).attr('data-selected_country');
	 	var mwb_wmsa_update_state = $(this).attr('data-selected_state');
	 	
	 	if($(this).html() == mwb_woo_msa_param.edit_button){
	 		$(this).html(mwb_woo_msa_param.updated_button);
	 		
	 		$(document).find('.mwb_woo_multiple_shipping_address').addClass('mwb_woo_msa_modal_open');
	 		$(document).find('#mwb_woo_msa_guest_user_address').val($(this).parent().siblings('.mwb_woo_address1').text());
	 		$(document).find('#mwb_woo_msa_guest_user_address2').val($(this).parent().siblings('.mwb_woo_address2').text());
	 		$(document).find('#mwb_woo_msa_guest_user_town').val($(this).parent().siblings('.mwb_woo_town').text());

	 		$(document).find('#billing_country').val(mwb_wmsa_update_country);
	 		$(document).find('#billing_country').trigger('change');

	 		$(document).find('#billing_state').val(mwb_wmsa_update_state);
	 		$(document).find('#billing_state').trigger('change');

	 		$(document).find('#billing_postcode').val($(this).parent().siblings('.mwb_woo_zip').text());
	 		$(document).find('#mwb_woo_msa_guest_user_data_submit').attr('name','mwb_woo_msa_edit_submit');

	 		$(document).find('#mwb_woo_msa_guest_user_data_submit').attr('id','mwb_woo_msa_edit_submit');
	 		$(document).find('#mwb_woo_msa_edit_submit').attr('data-edit_index',mwb_wmsa_update_addr);	

	 	}else{
	 		$(this).html(mwb_woo_msa_param.edit_button);
	 	}
	 });





	 $(document).on('click','#mwb_woo_msa_edit_submit',function(){
	 	var mwb_wmsa_update_index = $(this).attr('data-edit_index');
	 	
	 	if($(document).find('form.mwb_woo_msa_address_form').length > 0){
	 		$(document).find('form.mwb_woo_msa_address_form').submit(function(e){
	 			e.preventDefault();
	 			var formData = {
	 				'address1' : $('input[name=mwb_woo_msa_user_address]').val(),
	 				'address2' : $('input[name=mwb_woo_msa_user_address2]').val(),
	 				'town'     : $('input[name=mwb_woo_msa_user_town]').val(),
	 				'country'  : $(document).find('#billing_country :selected').val(),
	 				'state'    : $(document).find('#billing_state :selected').val(),
	 				'zip'      : $(document).find('#billing_postcode').val()
	 			};
	 			block($(document).find('.mwb_woo_multiple_shipping_address'));
	 		// console.log(formData);
	 		$.ajax({
	 			url : ajaxurl,
	 			type : 'POST',
	 			cache : false,
	 			data : {
	 				action : 'mwb_wmsa_update_address',
	 				mwb_woo_all_form_data : formData,
	 				mwb_wmsa_update_index : mwb_wmsa_update_index
	 			},success : function(response){
	 				console.log(response);
	 				if(response == 'success'){
	 					unblock($(document).find('.mwb_woo_multiple_shipping_address'));
	 					window.location.reload();
	 				}
	 				else{
	 					unblock($(document).find('.mwb_woo_multiple_shipping_address'));
	 					window.location.reload();
	 				}
	 			}
	 		});
	 	});
	 	}
	 	else{

	 		var formData = {
	 			'address1' : $('input[name=mwb_woo_msa_guest_user_address]').val(),
	 			'address2' : $('input[name=mwb_woo_msa_guest_user_address2]').val(),
	 			'town'     : $('input[name=mwb_woo_msa_guest_user_town]').val(),
	 			'country'  : $(document).find('#billing_country :selected').val(),
	 			'state'    : $(document).find('#billing_state :selected').val(),
	 			'zip'      : $(document).find('#billing_postcode').val()
	 		};
	 		block($(document).find('.mwb_woo_multiple_shipping_address'));
	 		$.ajax({
	 			url : ajaxurl,
	 			type : 'POST',
	 			cache : false,
	 			data : {
	 				action : 'mwb_wmsa_update_address',
	 				mwb_woo_all_form_data : formData,
	 				mwb_wmsa_update_index : mwb_wmsa_update_index
	 			},success : function(response){
	 				console.log(response);
	 				if(response == 'success'){
	 					unblock($(document).find('.mwb_woo_multiple_shipping_address'));
	 					window.location.reload();
	 				}
	 				else
	 				{
	 					unblock($(document).find('.mwb_woo_multiple_shipping_address'));
	 					window.location.reload();
	 				}
	 			}
	 		});
	 	}
	 });


	 $(document).on('change','.mwb_woo_msa_cart_item_address',function(){
	 	
	 	var mwb_woo_selected_address = $(this).val();
	 	var mwb_woo_cart_item_key = $(this).attr('data-cart_item_key');
	 	var mwb_woo_cart_item_user_id = $(this).attr('data-customer_id');
	 	
	 	var mwb_woo_msa_save_item_addr = {
	 		'cart_item_key' : mwb_woo_cart_item_key,
	 		'cart_selected_address' : mwb_woo_selected_address,
	 		'current_user_id'	: mwb_woo_cart_item_user_id
	 	};
	 	block($(document).find('.shop_table'));
	 	$.ajax({
	 		url : ajaxurl,
	 		type : 'POST',
	 		cache : false,
	 		data : {
	 			action : "mwb_woo_msa_saved_address_in_items",
	 			mwb_woo_msa_all_item_data : mwb_woo_msa_save_item_addr
	 		},success : function(response){
	 			if(response == 'success'){
	 				console.log(response);
	 				unblock($(document).find('.shop_table'));
	 			}
	 		}
	 	});

	 });





	 // for opening a loader
	 var block = function( $node ) {
	 	if ( ! is_blocked( $node ) ) {
	 		$node.addClass( 'processing' ).block( {
	 			message: null,
	 			overlayCSS: {
	 				background: '#fff',
	 				opacity: 0.6
	 			}
	 		} );
	 	}
	 };
	 var is_blocked = function( $node ) {
	 	return $node.is( '.processing' ) || $node.is( '.processing' ).length;
	 };
	 var unblock = function( $node ) {
	 	$node.removeClass( 'processing' ).unblock();
	 		// $("html, body").animate({ scrollTop: '#mwb_woo_sms_show_cookie_notice' }, 100);
	 	};

	 })( jQuery );
