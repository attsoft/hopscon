<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Martfury
 */
?>
<?php do_action( 'martfury_before_site_content_close' ); ?>
</div><!-- #content -->
<?php do_action( 'martfury_before_footer' ) ?>
<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) {
	?>
    <footer id="colophon" class="site-footer">
        
		<?php do_action( 'martfury_footer' ) ?>
    </footer><!-- #colophon -->
	<?php do_action( 'martfury_after_footer' ) ?>
<?php } ?>
</div><!-- #page -->
<div class="checking"></div>
<?php wp_footer(); ?>       
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<style type="text/css">

/*input#billing_phone_code, input#shipping_phone_code {
    pointer-events: none;
}*/
 
table.ddwc-dashboard tbody tr td.fontinc {
    font-size: 15px;
}
a.woocommerce-order-backbtn {
    padding: 0 10px !important;
    height: 35px !important;
    line-height: 35px !important;
    font-size: 14px !important;
    font-weight: 600 !important;
    border-radius: 3px !important;
    color: #fff;
}
section.woocommerce-order-details .ddwc-driver-details h2 {
    padding-right: 6px !important;
}
/*.orderdeail {
    display: flex;
    align-items: center;
    justify-content: space-between;
}*/

.orderdeail a.woocommerce-order-backbtn {
    padding: 10px 15px !important;
}
.orderdeail a.woocommerce-order-backbtn.btn:hover {
    color: #fff;
}

	.wpuf-fields input, .wpuf-fields select, #my_country_field {
	    padding: 10px !important;
	    border: 1px solid rgba(102, 102, 102, .25) !important;
	    border-radius: 4px;
	    box-shadow: none !important;
	}
	#my_country_field {
	 	width: 100%;
	 	padding: 14px 12px !important;
	}
	.wpuf-fields select {
	    height: 38px !important;
	    width: 100%;
	}
	.wpuf-wordlimit-message {
	    display: none !important;
	}
	input.wpuf-submit-button {
    border: none !important;
    background: #66ae3d !important;
    box-shadow: none !important;
    text-shadow: none !important;
    padding: 10px 25px !important;
    font-size: 14px !important;
    line-height: 15px !important;
    height: 34px !important;
}
	/*form > ul.form-label-above > li:last-child {
	    display: none !important;
	}*/
	.vendor_identity_id  {
		margin-top: 42px;
	}

	.phone_verify .wpuf-numeric_text_holder, .verify_otp .wpuf-fields, .send_otp_msg_row, .vefify_otp_row{
		position: relative;
	}
	#dokan_store_phone {
		padding-right: 85px !important;
	}
	.send_otp_msg, .send_otp_verify{
		color: #66ae3d;
	    float: right;
	    position: absolute;
	    /*width: 65px;*/
	    right: 0;
	    top: 7px;
	    z-index: 99;
	    margin-right: 16px;
	    font-weight: 600;
	    font-size: 16px;
	    cursor: pointer;
	}

	.send_otp_msg_row .send_otp_msg, .vefify_otp_row .send_otp_verify {
    	top: 43px;
	}
	input#dokan_store_phone::-webkit-outer-spin-button,
	input#dokan_store_phone::-webkit-inner-spin-button {
	  -webkit-appearance: none;
	  margin: 0;
	}

	/* Firefox */
	input#dokan_store_phone[type=number] {
	  -moz-appearance: textfield;
	}

	.confirm_email_address_error ~ .confirm_email_address_error {
		display: none;
	}

	.dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu li {
	    border-bottom: 1px solid #4593cc;
	}
	.dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu li.dokan-common-links a {
	    border-right: 1px solid #4593cc;
	}

	.customer_phone {
		padding-right: 85px !important;
	}

	.cus-menu-extra-login {
		float: left !important;
	    padding-left: 0 !important;
	    padding-top: 28px !important;
	    font-weight: 500 !important;
	} 
	.cus-menu-extra-login > .icon-user {
		top: 4px !important;
	    font-size: 24px !important;
	    left: 7px !important;
	}

	.cus-item-register {
		float: left !important;
	    padding-left: 0 !important;
	    padding-top: 28px !important;
	    font-weight: 500 !important;
	}
	.cus-item-register > .sign-up-icon {
		border-radius: 0 !important;
	    float: left;
	    position: absolute;
	    top: 3px;
	    height: 25px;
	    left: 10px;
	}
span.loading_icn, .loading_icn_vr {
    position: absolute;
    top: 40px;
    left: 8px;
}
.phone_verify span.loading_icn {
    top: 36px;
    left: -42px;
}
.vendor_otp .loading_icn_vr {
    top: 4px;
    left: 4px;
}
span.otp_msg, .very_msg {
    float: right;
}
a.btn.btn-primary {
    color: #fff;
    font-size: 16px;
	border-radius: 3px;
}
.send_otp_msg{
    top: 38px;
}
.checkout_succ a.btn-shop i.icon-arrow-left {
    font-size: 16px;
    font-weight: 600;
    margin-right: 4px;
    position: relative;
    top: 2px;
}
.checkout_succ a.btn-shop {
    color: #fff !important;
    background: #66ae3d;
    padding: 12px 20px;
    border-radius: 3px;
    font-weight: 600;
}
section.woocommerce-customer-details.checkoutpg {
    width: 85%;
    float: left;
}
.checkout_succ {
    float: left;
    width: 15%;
    padding-top: 65px;
}
.custom-tooltip {
  position: relative;
  display: inline-block;
}

.custom-tooltip .tooltiptext {
  visibility: hidden;
 width: 160px;
    background-color: #000000f2;
    color: #fff;
    text-align: center;
    padding: 8px 4px;
    border-radius: 4px;
    position: absolute;
    z-index: 1;
    font-weight: 400;
    text-transform: capitalize;
    top: -60px;
    left: -20px;
    line-height: 18px;
    font-size: 13px;
}
.custom-tooltip:hover .tooltiptext {
  visibility: visible;
}
.woocommerce-MyAccount-content script ~ p {
    display: none;
}
.migrationfm select#dokan_address_country {
    width: 100%;
}
input[type="submit"].dokan-btn-default, input[type="submit"].dokan-btn-default:hover, a.dokan-btn-default, a.dokan-btn-default:hover, .dokan-btn-default, .dokan-btn-default:hover, input[type="submit"].dokan-btn-default:active, input[type="submit"].dokan-btn-default:focus, input[type="submit"].dokan-btn-default.disabled, a.dokan-btn-default.disabled, .dokan-btn-default.disabled, input[type="submit"].dokan-btn-theme.disabled, a.dokan-btn-theme.disabled, .dokan-btn-theme.disabled, .dokan-btn-default.disabled:hover, input[type="submit"].dokan-btn-default[disabled], input[type="submit"].dokan-btn-default[disabled]:hover, input[type="submit"].dokan-btn-theme[disabled], input[type="submit"].dokan-btn-theme[disabled]:hover { 
    color: #fff;
    background-color: #66ae3d;
    border-color: #66ae3d;
}
.dokan_migration_sub {
    padding: 10px 20px !important;
    border-radius: 3px !important;
}
.dokan-w4.right-content-shop {
    float: right;
    position: absolute;
    right: 15px;
    text-align: right;
    top: 96px;
}
.right-content-shop a#go_shop {
    padding: 12px 25px;
    border-radius: 3px;
}
input#migrate_phcd {
    max-width: 65px;
    float: left;
    display: inline;
    background: #eaeaea;
    border-radius: 3px 0px 0px 3px;
    padding: 13px;
}
input#shop-phone {
    width: calc(100% - 65px);
    border-radius: 0px 3px 3px 0px;
}
.form-row .radio[for=fabfw_address_billing_id_new], h3#ship-to-different-address {
    display: none !important;
}
#fabfw_address_shipping_id_field label:not(.radio) {
    display: block !important;
}
#fabfw_address_shipping_id_field label:not(.radio) {
    display: block !important;
    font-size: 20px;
    margin-bottom: 5px;
    font-weight: 600;
    margin-top: 0;
    color: #000;
}
.woocommerce-checkout form.checkout h3 {
    margin-bottom: 20px;
}
span.claimed {
    color: #66ae3d;
    font-size: 18px;
    font-weight: 500;
    float: left;
    margin-right: 20px;
	padding-top: 4px;
}
.ddwc-orders h3.ddwc {
    padding-top: 8px;
}
.myac-password .field-icon.toggle-password {
    top: 63px;
    position: absolute;
    right: 15px;
}
.myac-password p.woocommerce-form-row.woocommerce-form-row--wide.form-row.form-row-wide {
    position: relative;
}
select#country {
    width: 100%;
}
input#phone-cd {
    width: 9%;
    float: left;
    border-bottom-right-radius: 0;
    border-right: 0;
    border-top-right-radius: 0;
	background: #f3f3f3;
}
input#phone {
    width: 91%;
    float: left;
    border-bottom-left-radius: 0;
    border-top-left-radius: 0;
}
#fabfw_address_shipping_id_field span.select2.select2-container.select2-container--default.select2-container--below, #fabfw_address_shipping_id_field select {
    width: 100%;
    min-width: 100%;
}
#fabfw_address_shipping_id_field .select2-container .select2-selection--single .select2-selection__arrow {
    top: 8px;
}
.fabfw-select-address-container .form-row .fabfw-edit.customeditlnk {
    display: block !important;
    margin-top: 8px;
    color: #66ae3d;
    text-align: right;
    font-weight: 500;
}
#dokan-seller-listing-wrap ul#home_seller_slider {
    list-style: none;
    margin: 20px 0px;
    padding: 0 15px;
}
.dokan-seller-wrap button.slick-next.slick-arrow:before {
    content: "\e93b";
    font-size: 20px;
    font-family: 'Linearicons' !important;
    speak: none;
    font-style: normal;
    font-variant: normal;
    text-transform: none;
    margin-left: -4px;
    font-weight: bold;
}

.dokan-seller-wrap button.slick-prev.slick-arrow:before {
    content: "\e93c";
    font-size: 20px;
    font-family: 'Linearicons' !important;
    speak: none;
    font-style: normal;
    font-variant: normal;
    text-transform: none;
    margin-left: -4px;
    font-weight: bold;
}

.dokan-seller-wrap button.slick-next.slick-arrow, .dokan-seller-wrap button.slick-prev.slick-arrow {
    background-color: rgba(255, 255, 255, 0.9);
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
    border-radius: 50%;
    width: 40px;
    height: 40px;
    line-height: 25px;
    text-align: center;
    color: #333;
    z-index: 99;
    font-size: 0;
}
.dokan-seller-wrap button.slick-prev.slick-arrow {
    z-index: 999;
    right: 0;
}
#dokan-seller-listing-wrap.grid-view .store-content .store-data-container .featured-favourite .featured-label {
    background: #66ae3d;
}
#dokan-seller-listing-wrap .seller-listing-content .dokan-seller-wrap .dokan-single-seller .store-wrapper .store-data h2 {
    margin: 13px 0;
}
.gregcustom span.select2-selection.select2-selection--single {
    text-align: left;
}
.dokan-store .dokan-store-support-btn {
    margin-top: 0px;
}
.dokan-store div#content {
    padding-top: 0;
}
.profile-frame {
    margin: 20px 0;
    padding: 0 15px;
}
.profile-info-head {
    display: inline-block;
    float: left;
    width: 17%;
}
.profile-info {
    float: left;
    width: 83%;
    text-align: left;
}
.profile-img img {
    border-radius: 4px;
}
h1.store-name {
    margin-top: 0px;
    font-size: 25px;
    margin-bottom: 0px !important;
}
ul.dokan-store-info {
    padding-left: 0;
}
ul.dokan-store-info {
    padding-left: 0;
    padding-top: 0;
    margin-top: 7px;
    margin-bottom: 0;
}
.dokan-store-info li {
    margin-bottom: 2px;
}
.dokan-store-info li::marker, ul.store-social li::marker {
    display: none;
    content: none;
}
.dokan-store-rating i.fa.fa-star {
    float: left;
    padding-top: 3px;
}
.seller-rating span.star-rating {
    float: left;
    margin: 2px 7px;
}
.dokan-single-store .dokan-store-tabs {
    margin-top: 0px;
}
.profile-info-img-outer {
    border: 1px solid #ececec;
    margin: 0 auto;
    text-align: center;
    border-left: unset;
    border-right: unset;
}
.profile-info-img.dummy-image {
    height: 40px !important;
}
.dokan-store .widget .widget-title {
    margin-bottom: 10px;
}
ul.store-social li {
    display: inline-block;
    margin-right: 2px;
}
.store-social li a {
    font-size: 22px;
}
ul.store-social {
    padding-left: 0;
}
.dokan-store-info li a {
    color: #656565;
}
.dokan-w5.radio_btns {
    text-align: left;
}
p.shp_mthd {
    margin-bottom: 0;
    text-align: center;
    font-weight: 600;
    padding-top: 8px;
}
a.button.invoice, a.button.packing-slip {
    margin-top: 8px !important;
    display: inline-block;
}
span.search_btn {
    position: absolute;
    background: #ccc;
    right: 1px;
    padding: 1px 8px;
    font-size: 22px;
    cursor: pointer;
    color: #000;
}
.driver_fm {
    border: 1px solid #d3ced2;
    padding: 20px;
    margin: 3em 0;
    text-align: left;
    border-radius: 5px;
}
.driver_fm ul.wpuf-form li .wpuf-label {
    color: #666 !important;
    font-size: 14px;
    font-family: 'Work Sans', Arial, sans-serif;
    text-transform: unset !important;
    font-weight: 500;
}
.driver_fm ul.wpuf-form li {
    margin-bottom: 20px !important;
}
.woocommerce-MyAccount-navigation li.woocommerce-MyAccount-navigation-link.woocommerce-MyAccount-navigation-link--become-a-driver {
    display: none !important;
} 

@media only screen and (max-width: 768px) { 
.profile-info {
    float: left;
    width: 80%;
    text-align: left;
    margin-left: 3%;
} 
}
table.wc_bookings_calendar.widefat .bookings {
    overflow-y: scroll;
}
.driver_fm .wpuf-form-add.wpuf-form-layout3 ul.wpuf-form li .wpuf-fields select {
    width: 95%;
 }
 .martfury-newletter .form-area {
    padding-right: 15px !important;
}
td.diviader {
    display: none;
}
@media only screen and (max-width: 538px) and (min-width: 388px) { 
ul.dokan-list-inline li:nth-child(1) {
    flex: 0 50%;
}
ul.dokan-list-inline li:nth-child(2) {
    flex: 0 50%;
}
}
@media only screen and (max-width: 767px) { 
.dokan-dashboard-content.dokan-booking-wrapper.dokan-product-edit .wrap.woocommerce {
    overflow: scroll;
}
table.dokan-table td.dokan-order-action a {
	margin-left: 5px;
}
table.dokan-table td.dokan-order-action {
    display: flex;
}
.dokan-form-group.store-open-close-time .dokan-w3 {
    width: 34%;
    text-align: right;
    padding-right: 10px;
}
.store-open-close label.day.control-label {
    width: 40%;
    padding-right: 25px;
}
.dokan-dashboard-content.dokan-settings-content label.dokan-w3.dokan-control-label {
     width: 35%; 
}
.dokan-dashboard-content.dokan-settings-content .dokan-w5.dokan-text-left {
     width: 60%; 
}
.dokan-dashboard-wrap .dokan-support-topic-wrapper .dokan-support-topics-list {
    overflow: scroll;
}
.dokan-dashboard-wrap .dokan-support-topic-wrapper .dokan-support-topics-list table.dokan-table.dokan-support-table {
    width: 768px;
}
.profile-info-head {
    display: inline-block;
    float: unset;
    width: 100%;
    text-align: center;
    margin-bottom: 20px;
}
.profile-info {
    width: 96%;
}
.dokan-dashboard header.dokan-dashboard-header h1{
	margin: 0 0 45px 0;
}
.dokan-dashboard header.dokan-dashboard-header .dokan-add-product-link .dokan-btn{
	margin-top: 20px;
}
.woocommerce.shop-view-list ul.products li.product:not(.slick-slider) .mf-product-details{
	margin-top: 10px;
}
article.dokan-settings-area .dokan-form-group.store-open-close {
    overflow: scroll;
}
}
/*---------------------------------*/
#dokan-store-listing-filter-form-wrap .apply-filter #cancel-filter-btn{
	display: block;
}
article.dokan-settings-area span.select2.select2-container.select2-container--default {
    width: 100% !important;
}
/*article.dokan-settings-area .dokan-form-group.store-open-close {
    overflow: scroll;
}*/
article.dokan-settings-area .dokan-form-group.store-open-close label.time {
    min-width: 50%;
}
.dokan-rma-request-area table.rma-request-listing-table tbody tr td.details .row-actions{
    visibility: visible;
}
.dokan-rma-request-area table.table.table-striped.rma-request-listing-table td {
    padding: 20px 5px 20px 5px;
}
form#order-filter {
    overflow: scroll;
}
.dokan-table > thead:first-child > tr:first-child > th {
    border: 1px solid #d1d1d1!important;
}
.dokan-dashboard-content.dokan-coupon-content span.left-header-content.dokan-right {
    padding-top: 10px;
}
.dokan-dashboard-content.dokan-staffs-content span.left-header-content.dokan-right {
    padding-top: 10px;
} 
@media only screen and (max-width: 500px){
	.woocommerce-account .woocommerce .account-info .account-name{
		margin-top: 10px;
	}
}
@media only screen and (max-width: 430px) {
.dokan-rma-request-area ul.request-statuses-filter{
	flex-wrap: wrap;
}
.dokan-rma-request-area ul.request-statuses-filter li{
	flex: 0 50%;
}
article.dokan-settings-area form#dokan-store-rma-form .dokan-form-group {
    margin-left: 0px !important;
}
article.dokan-settings-area form#dokan-store-seo-form .dokan-form-group {
    margin-left: 0px !important;
}
article.dokan-settings-area .dokan-form-group.show_if_addon_warranty{
	overflow: scroll;
}
article.dokan-settings-area .dokan-form-group.show_if_addon_warranty label.dokan-w3.dokan-control-label {
    width: 100%;
    text-align: left;
    margin-bottom: 10px;
    margin-top: 10px;
}
article.dokan-settings-area .dokan-form-group.show_if_addon_warranty table.dokan-table.dokan-rma-addon-warranty-table td:nth-child(3) {
    display: flex;
}
article.dokan-settings-area .dokan-form-group.show_if_addon_warranty table.dokan-table.dokan-rma-addon-warranty-table td:nth-child(3) {
    margin-right: flex;
}
article.dokan-settings-area .dokan-form-group.show_if_addon_warranty .dokan-table{
	width: 430px;
}
article.dokan-settings-area .dokan-w5.radio_btns {
    width: 50% !important;
}
article.dokan-settings-area .gregcustom.dokan-form-group label.dokan-w3.dokan-control-label {
    width: 50% !important;
}
article.dokan-settings-area label.dokan-w3.control-label {
    width: 34%;
}
.dokan-dashboard-wrap .dokan-booking-wrapper h1.entry-title {
    text-align: center;
}
.dokan-dashboard-content.dokan-staffs-content span.left-header-content.dokan-right {
    float: right !important;
    padding-top: 10px;
}
.dokan-dashboard-content.dokan-coupon-content span.left-header-content.dokan-right {
    float: right !important;
    padding-top: 0px;
}
div#Home .add_driverblock form#settings-form label.dokan-w3.dokan-control-label {
    width: 40%;
}
div#Home .add_driverblock form#settings-form .dokan-w5 {
    width: 60%;
}
.dokan-dashboard .dokan-product-listing .dokan-product-listing-area .dokan-product-search-form {
    width: 100%;
    margin-bottom: 15px;
}
.dokan-product-listing .dokan-product-listing-area form.dokan-product-search-form button[name="product_listing_search"]{
    order: 3;
}
}
@media only screen and (max-width: 450px) {
.dokan-dashboard .dokan-dash-sidebar #dokan-navigation > #mobile-menu-icon{
	z-index: 99 !important;
} 
.dokan-reviews-area form#dokan_comments-form {
    padding-bottom: 20px;
}
.dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu li{
    display: block !important;
}
.dokan-dashboard .dokan-orders-content .dokan-orders-area ul.order-statuses-filter li {
    width: 49%;
}
}
span.close_icon {
    position: absolute;
    right: -3px;
    font-size: 38px;
    font-weight: bold;
    top: -11px;
    transform: rotate(-45deg);
    padding: 0 8px;
    cursor: pointer;
}
span#close_icon {
    font-weight: 500;
    top: -15px;
    right: 10px;
}
</style>

<script>
	//alert('sdf');
jQuery( document ).ready(function($) {
		jQuery('.phone_verify .wpuf-fields').append('<span class="send_otp_msg" onclick="get_otp(this);">Get OTP <span class="otp_hover">One Time Password to validate your phone number.</span> </span> <span class="loading_icn" style="display: none;"><img src="<?php echo get_stylesheet_directory_uri(); ?>/image/preloader.gif" width="30px"></span> <span class="otp_msg"></span> <input type="hidden" name="sendedotp" id="sendedotp" value="">');
		jQuery('.verify_otp .wpuf-fields').append('<span class="send_otp_verify" onclick="verify_otp(this);">Verify</span> <span class="loading_icn_vr" style="display:none;"><img src=" <?php 
		echo get_stylesheet_directory_uri().'/image/preloader.gif'; ?>" width="30px"></span><span class="very_msg"></span>');
		
});
	
//Change logout url of my acocunt page LOGOUT
jQuery(document).ready(function($){
    jQuery(".woocommerce-MyAccount-navigation-link--customer-logout a").attr("href", "http://ewt.webdesigntexas.us/hopscan/wp-login.php?action=logout&redirect_to=http://ewt.webdesigntexas.us/hopscan/my-account");
	
	var needship = jQuery("#_disable_shipping").val();
	if(needship == 'no'){
		jQuery(".dokan-shipping-dimention-options input").prop('required',true);
	}
	
	 jQuery("#_disable_shipping").change(function() {
        if(jQuery(this).is(":checked")) {
            jQuery(".dokan-shipping-dimention-options input").prop('required',true);
        }else{
			jQuery(".dokan-shipping-dimention-options input").prop('required',false);
		}
        
    });
});	
jQuery(".page-id-3534  .dokan-warranty-request-wrap .dokan-rma-order-item-table th").eq(2).text("Unit Price");
// jQuery("#fabfw_address_shipping_id_field .woocommerce-input-wrapper select#sector_fields_1").change(function(){
//    jQuery('body').trigger('update_checkout');
// });
jQuery('#home_seller_slider').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    dots: false,
	arrows: true,
});
jQuery('.seller_slider_cat').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    dots: false,
	arrows: true,
}); 


jQuery('.slect_recipients').on('change', function (e) {
   if(this.value =='new'){
	   jQuery('.woocommerce-shipping-fields__field-wrapper input').val('');
	   jQuery('.woocommerce-shipping-fields__field-wrapper select').val('default').change();
	   }
});

jQuery('input[name=distance_unit]').change(function(){
var value = jQuery( 'input[name=distance_unit]:checked' ).val();
if(value == 'metric'){
 jQuery('#reg_dd_range, #cost_per_dis, #reg_local_range').attr("placeholder", "KM");
}else{
	 jQuery('#reg_dd_range, #cost_per_dis, #reg_local_range').attr("placeholder", "Miles");
	}
});

jQuery('input[name=distance_unit]').change(function(){
var distance_unit = jQuery( 'input[name=distance_unit]:checked' ).val();
if(distance_unit == 'metric'){
 jQuery('#cost_per_dis').attr("placeholder", "Cost/km");
}else{
     jQuery('#cost_per_dis').attr("placeholder", "Cost/miles");
    }
});

jQuery("#dokan_add_driver").click(function(){
jQuery("#search-driverfm").delay("1000").append('<p class="dr-success">Driver Added Successfully</p>');
});  
jQuery("#search-driverfm").keypress(
  function(event){
    if (event.which == '13') {
      event.preventDefault();
    }
});
jQuery(".btn-adddr").click(function(){
if (jQuery('.searched_data select').length){
        jQuery("#dokan_add_driver").show();
}else{
    jQuery("#dokan_add_driver").hide();
}
});
jQuery(document).ready(function(){

jQuery(".woocommerce-form-register .donate-now input").click(function(){

var select_role = jQuery(this).val();

jQuery("#selected_role").val(select_role);

})


var link = jQuery(".dokan-dashboard-wrap #woocommerce-order-items .name a").attr("href");
if (link !== null) {

jQuery(".dokan-dashboard-wrap #woocommerce-order-items .thumb a").attr("href",link);
jQuery(".dokan-dashboard-wrap #woocommerce-order-items .thumb a").attr("target","_blank");
}

jQuery(".checkout-shipping .woocommerce-input-wrapper option:eq(0)").removeAttr("selected");
jQuery(".checkout-shipping .woocommerce-input-wrapper option:eq(0)").removeAttr("data-select2-id"); 
// jQuery('.slect_recipients option:eq(1)').attr('selected', 'selected');
//jQuery('.slect_recipients option[value="3209"]').attr("selected", "selected");
if (jQuery('.slect_recipients option:eq(0)').is(':selected')){
            jQuery('a.fabfw-edit.customeditlnk').hide();
    }
jQuery('.fabfw-select-address-container select').change(function(){
if (jQuery('.slect_recipients option:eq(0)').is(':selected')){
            jQuery('a.fabfw-edit.customeditlnk').hide();
    }else{

        jQuery('a.fabfw-edit.customeditlnk').show();
}
});
});	
jQuery(document).ready(function(){

	jQuery("button.do-manual-refund").click(function(){

		setTimeout(function() {
			
	    location.reload();
	    }, 5000);

	});


	setTimeout(function() {
			
	    jQuery(".mf-preloader .martfury-preloader").fadeOut();
	    jQuery("#nprogress").fadeOut();

	    }, 2000);

    jQuery(document).ready(function(){
        jQuery('img[src=""]').hide();
        jQuery('img:not([src=""])').show();
    });
});
jQuery( document ).ajaxComplete(function() {
jQuery('ul#shipping_method li label').html(
    function (index, oldHtml) {
        return oldHtml.replace(":", "");
    }
 );
});
</script>
<script>
jQuery(document).ready(function(){
    jQuery('.showregister').click(function(){
        //jQuery('.tabs-panel.checkout_register_form').toggle('slow');
        //jQuery( ".tabs-panel.checkout_register_form" ).toggle();
        jQuery(".register.checkout_register_form").slideToggle(500);
        //jQuery('#order_review').css({'position': 'absolute','bottom': '100%','display':'block','margin-bottom':'50px'});
        //jQuery('h3#order_review_heading').css({'position': 'absolute','z-index': '99999','top':'-42em'});
  });
    jQuery(".showlogin").click(function(){
    jQuery(".checkout_register_form ").hide();
    }); 
    jQuery(".showregister").click(function(){
    jQuery("form.woocommerce-form.woocommerce-form-login.login").hide();
    });

});
</script>
<script>
    jQuery(".martfury-login-tabs #my_country_field").prepend("<option selected>Choose a country</option>");
    jQuery(".col-form-register .checkout_register_form.woocommerce-form-register #my_country_field_field #my_country_field").prepend("<option selected>Choose a country</option>");

</script>
<script>
jQuery(document).ready(function(){
    var coll = document.getElementsByClassName("widget-title");
    var i;
for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.display === "block") {
      content.style.display = "none";
    } else {
      content.style.display = "block";
    }
  });
}
});
jQuery('#nav_menu-7').click(function() {
    jQuery('.menu-footer-widget-1-container').toggleClass("active");
});
jQuery('#nav_menu-8').click(function() {
    jQuery('.menu-footer-link-6-container').toggleClass("active");
});
jQuery('#nav_menu-9').click(function() {
    jQuery('.menu-footer-widget-2-container').toggleClass("active");
});
</script>
<?php

if ($_GET['register'] == 'vendor') {
	?>
	<script>
		jQuery(document).ready(function(){
			jQuery('.page-id-3534 ul.donate-now li:first-child input').click();
		});
	</script>
	<?php
}elseif($_GET['register'] == 'driver') {
	?>
	<script>
		jQuery(document).ready(function(){
			jQuery('.page-id-3534 ul.donate-now li:nth-child(2) input').click();
		});
	</script>
	<?php
}else{
}
?>
<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
/*
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}*/
</script>
<script>
jQuery(document).ready(function(){

	jQuery('#ordercompleted').click(function(){
	jQuery(".otpmatch").css('display', 'block');
});
	jQuery('.otpmatch .otpmatch_section label').append('<span id="close_icon" class="close_icon">+</span>');
});
jQuery(document).ready(function(){
	jQuery(".close_icon").click(function() {
	jQuery(".otpmatch").css('display', 'none');
	jQuery( "#ordercompleted" ).prop( "disabled", false );
});
});

</script>

<script> 
   
jQuery(document).ready(function(){

    // Checkout load fileds hide/show

    jQuery('body').trigger('update_checkout');

    var select_location = jQuery('.page-id-3416 #shipping_country').val();

    if (select_location == 'RW') {

        var shipping_address_1_val = jQuery("#shipping_address_1").val();
        
        jQuery("#full_address_for_rwanda").val(shipping_address_1_val);

        jQuery('.page-id-3416 #shipping_postcode_field').hide();

        jQuery('.page-id-3416 input#shipping_postcode').val('00000');
        jQuery('.page-id-3416 input#shipping_postcode').attr('readonly','readonly');

        jQuery('.page-id-3416 #shipping_postcode_field').hide();
        jQuery('.page-id-3416 #shipping_address_1_field').hide();
        jQuery('.page-id-3416 #shipping_address_2_field').hide();
        jQuery('.page-id-3416 #shipping_city_field').hide();
        jQuery('.page-id-3416 #shipping_state_field').hide();

        jQuery('.page-id-3416 #full_address_for_rwanda_field input').show();
        jQuery('.page-id-3416 #full_address_for_rwanda_field label').show();   


    }else{

        jQuery('.page-id-3416 #shipping_postcode_field').show();
        jQuery('.page-id-3416 #shipping_address_1_field').show();
        jQuery('.page-id-3416 #shipping_address_2_field').show();
        jQuery('.page-id-3416 #shipping_city_field').show();
        jQuery('.page-id-3416 #shipping_state_field').show();

        jQuery('.page-id-3416 #full_address_for_rwanda_field input').hide();
        jQuery('.page-id-3416 #full_address_for_rwanda_field label').hide();

    }
    
    
        //jQuery('.page-id-3534 #rs_billing_postcode').hide()
        
  

    // Add Recipients load fileds hide/show

    var bil_select_location = jQuery('.page-id-3534 #billing_country').val();

    if (bil_select_location == 'RW') {

        jQuery('.page-id-3534 #billing_postcode_field').hide();

        jQuery('.page-id-3534 input#billing_postcode').val('00000');
        jQuery('.page-id-3534 input#billing_postcode').attr('readonly','readonly');
        jQuery('.page-id-3534 #billing_city').val('');
        jQuery('.page-id-3534 #billing_state').val('');

        jQuery('.page-id-3534 #billing_postcode_field').hide();
        jQuery('.page-id-3534 #billing_address_1_field').hide();
        jQuery('.page-id-3534 #billing_address_2_field').hide();
        jQuery('.page-id-3534 #billing_city_field').hide();
        jQuery('.page-id-3534 #billing_state_field').hide();

        jQuery('.page-id-3534 #full_address_for_rwanda_field input').show();
        jQuery('.page-id-3534 #full_address_for_rwanda_field label').show();   
 

    }else{
        
        jQuery('#billing_postcode').removeAttr('readonly');
        jQuery('.page-id-3534 #billing_postcode_field').show();
        jQuery('.page-id-3534 #billing_address_1_field').show();
        jQuery('.page-id-3534 #billing_address_2_field').show();
        jQuery('.page-id-3534 #billing_city_field').show();
        jQuery('.page-id-3534 #billing_state_field').show();

        jQuery('.page-id-3534 #full_address_for_rwanda_field input').hide();
        jQuery('.page-id-3534 #full_address_for_rwanda_field label').hide();

    }

});


jQuery(document).ready(function(){

    jQuery(".woocommerce-checkout #shipping_country").select2();
    jQuery('.woocommerce-shipping-fields__field-wrapper input').focusout(function(){
        var input_name = jQuery(this).attr('name');
        if (input_name!= 'shipping_postcode') {
            jQuery(document.body).trigger("update_checkout");
        }

        var shipping_address_1 = jQuery('#shipping_address_1').val();
        var shipping_state = jQuery('#shipping_state').val();
        var ajaxurl = "<?php //echo admin_url('admin-ajax.php'); ?>";        
        var shipping_country = jQuery('#shipping_country').val();

            jQuery.ajax({
             type : "post",
             url : ajaxurl,
             dataType: "json",
             data : {
             action: "get_distance_by_address", 
             shipping_address_1 : shipping_address_1,
             shipping_state : shipping_state,
             shipping_country : shipping_country,
             },
             success: function(data) {
               
                // jQuery('.distance_shipping').val(data.distance);
                // jQuery('.distance_rate_shipping').val(data.distance_rate);
             }
          })

    });



});


jQuery(document).ready(function(){

    // Checkout on change shipping_country   

    jQuery('.page-id-3416 .slect_recipients').on('change',function(){


        var shipping_address_1_val = jQuery("#shipping_address_1").val();

        jQuery("#full_address_for_rwanda").val(shipping_address_1_val);


    });

    jQuery('.woocommerce-shipping-fields__field-wrapper #shipping_country').on('change',function(){
        jQuery('#shipping_address_1').val('');
        jQuery('#shipping_address_2_field').val('');
        jQuery('#shipping_city').val('');
        jQuery('#shipping_state').val('');
        jQuery('#shipping_postcode').val('');

        var select_location = jQuery('.page-id-3416 #shipping_country').val();

        if (select_location == 'RW') {



            jQuery('.page-id-3416 input#shipping_postcode').val('00000');
            jQuery('.page-id-3416 input#shipping_postcode').attr('readonly','readonly');

            jQuery('.page-id-3416 #shipping_postcode_field input').hide();
            jQuery('.page-id-3416 #shipping_postcode_field label').hide();

            jQuery('.page-id-3416 #shipping_address_1_field input').hide();
            jQuery('.page-id-3416 #shipping_address_1_field label').hide();

            jQuery('.page-id-3416 #shipping_address_2_field input').hide();
            jQuery('.page-id-3416 #shipping_address_2_field label').hide();

            jQuery('.page-id-3416 #shipping_city_field input').hide();
            jQuery('.page-id-3416 #shipping_city_field label').hide();

            jQuery('.page-id-3416 #shipping_state_field input').hide();
            jQuery('.page-id-3416 #shipping_state_field span').hide();
            jQuery('.page-id-3416 #shipping_state_field label').hide();

            jQuery('.page-id-3416 #full_address_for_rwanda_field input').show();
            jQuery('.page-id-3416 #full_address_for_rwanda_field input').val('');
            jQuery('.page-id-3416 #full_address_for_rwanda_field label').show();


        }else{

            jQuery('.page-id-3416 #shipping_postcode_field input').show();
            jQuery('.page-id-3416 #shipping_postcode_field label').show();

            jQuery('.page-id-3416 #shipping_address_1_field input').show();
            jQuery('.page-id-3416 #shipping_address_1_field label').show();

            jQuery('.page-id-3416 #shipping_address_2_field input').show();
            jQuery('.page-id-3416 #shipping_address_2_field label').show();

            jQuery('.page-id-3416 #shipping_city_field input').show();
            jQuery('.page-id-3416 #shipping_city_field label').show();

            jQuery('.page-id-3416 #shipping_state_field input').show();
            jQuery('.page-id-3416 #shipping_state_field span').show();
            jQuery('.page-id-3416 #shipping_state_field label').show();

            jQuery('.page-id-3416 #full_address_for_rwanda_field input').hide();
            jQuery('.page-id-3416 #full_address_for_rwanda_field input').val('Null');
            jQuery('.page-id-3416 #full_address_for_rwanda_field label').hide();

        }



    });

    // Add Recipients on change billing_country   

    jQuery('.page-id-3534 #billing_country').on('change',function(){

        jQuery('#billing_address_1').val('');
        jQuery('#billing_address_2_field').val('');
        jQuery('#billing_city').val('');
        jQuery('#billing_state').val('');
        jQuery('#billing_postcode').val('');

        var select_location = jQuery(this).val(); 

        if (select_location == 'RW') { 
 
            jQuery('.page-id-3534 #billing_city').val('citybilling');
            jQuery('.page-id-3534 #billing_state').val('statebilling');

            jQuery('.page-id-3534 input#billing_postcode').val('00000');
            jQuery('.page-id-3534 input#billing_postcode').attr('readonly','readonly');

            jQuery('.page-id-3534 #billing_postcode_field input').hide();
            jQuery('.page-id-3534 #billing_postcode_field label').hide();

            jQuery('.page-id-3534 #billing_address_1_field input').hide();
            jQuery('.page-id-3534 #billing_address_1_field label').hide();

            jQuery('.page-id-3534 #billing_address_2_field input').hide();
            jQuery('.page-id-3534 #billing_address_2_field label').hide();

            jQuery('.page-id-3534 #billing_city_field input').hide();
            jQuery('.page-id-3534 #billing_city_field label').hide();

            jQuery('.page-id-3534 #billing_state_field input').hide();
            jQuery('.page-id-3534 #billing_state_field span').hide();
            jQuery('.page-id-3534 #billing_state_field label').hide();

            jQuery('.page-id-3534 #full_address_for_rwanda_field input').show();
            jQuery('.page-id-3534 #full_address_for_rwanda_field input').val('');
            jQuery('.page-id-3534 #full_address_for_rwanda_field label').show();


        }else{
            
            jQuery('.page-id-3534 #billing_postcode').val('');
            jQuery('.page-id-3534 #billing_postcode').removeAttr('readonly');

            jQuery('.page-id-3534 #billing_postcode_field input').show();
            jQuery('.page-id-3534 #billing_postcode_field label').show();

            jQuery('.page-id-3534 #billing_address_1_field input').show();
            jQuery('.page-id-3534 #billing_address_1_field label').show();

            jQuery('.page-id-3534 #billing_address_2_field input').show();
            jQuery('.page-id-3534 #billing_address_2_field label').show();

            jQuery('.page-id-3534 #billing_city_field input').show();
            jQuery('.page-id-3534 #billing_city_field label').show();

            jQuery('.page-id-3534 #billing_state_field input').show();
            jQuery('.page-id-3534 #billing_state_field span').show();
            jQuery('.page-id-3534 #billing_state_field label').show();

            jQuery('.page-id-3534 #full_address_for_rwanda_field input').hide();
            jQuery('.page-id-3534 #full_address_for_rwanda_field input').val('Null');
            jQuery('.page-id-3534 #full_address_for_rwanda_field label').hide();

        }



    });

    jQuery("#full_address_for_rwanda").focusout(function(){



        var full_address_for_rwanda = jQuery(this).val();

        jQuery("#billing_address_1").val(full_address_for_rwanda);
        jQuery("#shipping_address_1").val(full_address_for_rwanda);

        jQuery('body').trigger('update_checkout');

    });

    jQuery("#full_address_for_rwanda").keydown(function(){



        var full_address_for_rwanda = jQuery(this).val();

        jQuery("#billing_address_1").val(full_address_for_rwanda);
        jQuery("#shipping_address_1").val(full_address_for_rwanda);

        jQuery('body').trigger('update_checkout');

    });


    jQuery("select#dokan_address_country").on('change',function(){
            
  
            var dokan_address_country = jQuery(this).val();
    
             
            jQuery("input[name='dokan_address[street_1]']").val("");
            jQuery("input[name='dokan_address[city]']").val("");
            jQuery("input[name='dokan_address[zip]']").val("");
            jQuery("input[name='dokan_address[state]']").val("");
            jQuery("#dokan_address_state").val("");
            
             
            if (dokan_address_country == "RW") {
                
             
            jQuery('.statefield_clean').attr( "name","" );
            jQuery('.removename').attr( "name","dokan_address[state]" );
            jQuery('.statefield_clean').val("");
            jQuery('.removename').val("");
            jQuery(".showstateinput").show();
            jQuery(".hidestateinput").hide();
            jQuery(".dokan-address-zip").val("0000");
            jQuery(".dokan-address-zip").closest(".dokan-form-group").hide();
            jQuery(".rwanda_address_notice").show();;
            jQuery('label[for="dokan_address[state]"]').css('width','100px');
            jQuery('label[for="dokan_address[street_1]"]').html('Street address or Sector/District');
            jQuery('label[for="dokan_address[state]"]').html('State/Province');
            jQuery('label[for="dokan_address[city]"]').html('City/District');
            jQuery('<a class="address_sector_tooltip" href="#" data-toggle="tooltip" title="Please Enter Street address or Sector/District"><i class="fa fa-question-circle" aria-hidden="true"></i></a>').insertAfter('label[for="dokan_address[street_1]');
            jQuery('<a class="address_state_tooltip" href="#" data-toggle="tooltip" title="Please Enter State/Province"><i class="fa fa-question-circle" aria-hidden="true"></i></a>').insertAfter('label[for="dokan_address[state]');
            jQuery('<a class="address_city_tooltip" href="#" data-toggle="tooltip" title="Please Enter City/District"><i class="fa fa-question-circle" aria-hidden="true"></i></a>').insertAfter('label[for="dokan_address[city]');
            jQuery('.cityyhide').hide();
            jQuery('.cityshow').show();
            jQuery('.cityshow select').attr( "name","dokan_address[city]" );
            jQuery('.dokan-address-fields fieldset').css('border','1px solid #ccc');
            jQuery('.dokan-address-fields legend').css('display','block');
            
                
            }else{ 
            
            
            jQuery('.removename').attr( "name","" );
            jQuery('.statefield_clean').attr( "name","dokan_address[state]" );
            jQuery('.removename').val("");
            jQuery('.statefield_clean').val("");
            jQuery(".showstateinput").hide();
            jQuery(".hidestateinput").show();
            jQuery(".dokan-address-zip").closest(".dokan-form-group").show();
            jQuery(".rwanda_address_notice").hide();
            jQuery('.cityyhide').show();
            jQuery('.cityshow').hide();
            jQuery('.cityshow select').removeAttr( "name" );
            jQuery('.address_sector_tooltip').css( "display",'none' );
            jQuery('.address_state_tooltip').css( "display",'none' );
            jQuery('.address_city_tooltip').css( "display",'none' );
            jQuery('label[for="dokan_address[state]"]').html('State');
            jQuery('label[for="dokan_address[city]"]').html('City');
            jQuery('label[for="dokan_address[street_1]"]').html('Street');
            jQuery('.dokan-address-fields fieldset').css('border','0px');
            jQuery('.dokan-address-fields legend').css('display','none');
            
            }
            
            

    });
 
 
    var dokan_address_country = jQuery("select#dokan_address_country").val();

            if (dokan_address_country == "RW") {
           
            jQuery('.statefield_clean').attr( "name","" );
            jQuery(".showstateinput").show();
            jQuery(".hidestateinput").hide();
            jQuery(".dokan-address-zip").val("0000");
            jQuery(".dokan-address-zip").closest(".dokan-form-group").hide();
            jQuery(".rwanda_address_notice").show();
            jQuery('label[for="dokan_address[state]"]').css('width','100px');
            jQuery('label[for="dokan_address[street_1]"]').html('Street address or Sector/District');
            jQuery('label[for="dokan_address[state]"]').html('State/Province');
            jQuery('label[for="dokan_address[city]"]').html('City/District');
            jQuery('.page-id-13 input#dokan_address\[street_2\]').hide();
            jQuery('.dokan-left').css('width','100%');
            jQuery('<a class="address_sector_tooltip" href="#" data-toggle="tooltip" title="Please Enter Street address or Sector/District"><i class="fa fa-question-circle" aria-hidden="true"></i></a>').insertAfter('label[for="dokan_address[street_1]');
            jQuery('<a class="address_state_tooltip" href="#" data-toggle="tooltip" title="Please Enter State/Province"><i class="fa fa-question-circle" aria-hidden="true"></i></a>').insertAfter('label[for="dokan_address[state]');
            jQuery('<a class="address_city_tooltip" href="#" data-toggle="tooltip" title="Please Enter City/District"><i class="fa fa-question-circle" aria-hidden="true"></i></a>').insertAfter('label[for="dokan_address[city]');
            jQuery('.cityyhide').hide();
            jQuery('.cityshow').show();
            jQuery('.cityshow select').attr( "name","dokan_address[city]" );
            jQuery('.dokan-address-fields fieldset').css('border','1px solid #ccc');
            jQuery('.dokan-address-fields legend').css('display','block');
                 
            }else{ 
            
            jQuery('.removename').attr( "name","" );
            jQuery(".showstateinput").hide();
            jQuery(".hidestateinput").show();
            jQuery(".dokan-address-zip").closest(".dokan-form-group").show();
            jQuery(".rwanda_address_notice").hide();
            jQuery('.cityyhide').show();
            jQuery('.cityshow').hide();
            jQuery('label[for="dokan_address[state]"]').html('State');
            jQuery('label[for="dokan_address[city]"]').html('City');
            jQuery('label[for="dokan_address[street_1]"]').html('Street');
            jQuery('.cityshow select').removeAttr( "name" );
            jQuery('.address_sector_tooltip').css( "display",'none' );
            jQuery('.address_state_tooltip').css( "display",'none' );
            jQuery('.address_city_tooltip').css( "display",'none' );
            jQuery('.dokan-address-fields fieldset').css('border','0px');
            jQuery('.dokan-address-fields legend').css('display','none');

            }

});


</script>
<script>
jQuery(document).ready(function(){
    jQuery(".page-id-3534 #billing_state_field").removeClass("validate-required");
    jQuery(".page-id-3534 #billing_state_field").removeClass("validate-state");
    
    jQuery('#full_address_for_rwanda').val(jQuery('#billing_address_1').val());
});
</script>
<?php
if (strpos($_SERVER['REQUEST_URI'], "checkout") !== false){ ?>     
    <?php if ( !is_user_logged_in() ) { ?>
    
    <style>
        .checkout-shipping {
    display: none;
}
p#order_comments_field {
    display: none;
}
/*h3#order_review_heading {
    position: absolute;
    z-index: 99999;
    top: -40.5em;
}*/
/*
.woocommerce-form-register-toggle {
    display: none;
}*/
/*div#order_review {
    position: absolute;
    bottom: 100%;
}*/
h3#order_review_headinggg {
    margin: 0px;
    font-size: 19px;
}
    </style>
<?php } }
 ?>
<?php
if (strpos($_SERVER['REQUEST_URI'], "address-book-edit") !== false){ ?> 
 <script>
     var df = jQuery.noConflict();
     df(document).ready(function(){
    df('#full_address_for_rwanda').addClass('expand_location');
 });
 </script>
<?php } ?> 
<?php
if (strpos($_SERVER['REQUEST_URI'], "/my-account/edit-account/") !== false){ ?>
<script>
    //jQuery('.page-id-3534 #country').each(function(){
    var select_option = jQuery('.page-id-3534 #country').val();
    
        if (select_option == 'RW') { 
        jQuery('.page-id-3534 #rs_billing_postcode_field').hide();

        jQuery('.page-id-3534 input#rs_billing_postcode').val('00000');
        jQuery('.page-id-3534 input#rs_billing_postcode').attr('readonly','readonly');
        
        jQuery('.page-id-3534 #rs_billing_address_2_field').hide();
        jQuery('.page-id-3534 #rs_billing_city_field').hide();
        jQuery('.page-id-3534 #rs_billing_state_field').hide();
        
        jQuery('.page-id-3534 #rs_billing_address_1_field label').html('Enter Full Address');
        
        
        
    }else{
        
        jQuery('.page-id-3534 #rs_billing_postcode_field').show();
        
        jQuery('.page-id-3534 #rs_billing_address_1_field').show();
        jQuery('.page-id-3534 #rs_billing_address_2_field').show();
        jQuery('.page-id-3534 #rs_billing_city_field').show();
        jQuery('.page-id-3534 #rs_billing_state_field').show();
        
    }
    
    jQuery('.page-id-3534 #country').change(function(){
        
        if(jQuery(this).val() == 'RW'){
        
            
        jQuery('.page-id-3534 #rs_billing_postcode_field').hide();

        jQuery('.page-id-3534 input#rs_billing_postcode').val('00000');
        jQuery('.page-id-3534 input#rs_billing_postcode').attr('readonly','readonly');
        
        jQuery('.page-id-3534 #rs_billing_address_2_field').hide();
        jQuery('.page-id-3534 #rs_billing_city_field').hide();
        jQuery('.page-id-3534 #rs_billing_state_field').hide();
        
        jQuery('.page-id-3534 #rs_billing_address_1_field label').html('Enter Full Address');
        
        }else{
            
            jQuery('.page-id-3534 #rs_billing_postcode_field').show();
        
            jQuery('.page-id-3534 #rs_billing_address_1_field').show();
            jQuery('.page-id-3534 #rs_billing_address_2_field').show();
            jQuery('.page-id-3534 #rs_billing_city_field').show();
            jQuery('.page-id-3534 #rs_billing_state_field').show();
            
        }
    });
</script>
<?php } ?>
<?php
if (strpos($_SERVER['REQUEST_URI'], "/dashboard/edit-account/") !== false){ ?>
<script>
    //jQuery('.page-id-3534 #country').each(function(){
    var select_option = jQuery('.page-id-13 #country').val();
    
        if (select_option == 'RW') { 
        jQuery('.page-id-13 #rs_billing_postcode_field').hide();

        jQuery('.page-id-13 input#rs_billing_postcode').val('00000');
        jQuery('.page-id-13 input#rs_billing_postcode').attr('readonly','readonly');
        
        jQuery('.page-id-13 #rs_billing_address_2_field').hide();
        jQuery('.page-id-13 #rs_billing_city_field').hide();
        jQuery('.page-id-13 #rs_billing_state_field').hide();
        
        jQuery('.page-id-13 #rs_billing_address_1_field label').html('Enter Full Address');
        
        
        
    }else{
        
        jQuery('.page-id-13 #rs_billing_postcode_field').show();
        
        jQuery('.page-id-13 #rs_billing_address_1_field').show();
        jQuery('.page-id-13 #rs_billing_address_2_field').show();
        jQuery('.page-id-13 #rs_billing_city_field').show();
        jQuery('.page-id-13 #rs_billing_state_field').show();
        
    }
    
    jQuery('.page-id-13 #country').change(function(){
        
        if(jQuery(this).val() == 'RW'){
        
            
        jQuery('.page-id-13 #rs_billing_postcode_field').hide();

        jQuery('.page-id-13 input#rs_billing_postcode').val('00000');
        jQuery('.page-id-13 input#rs_billing_postcode').attr('readonly','readonly');
        
        jQuery('.page-id-13 #rs_billing_address_2_field').hide();
        jQuery('.page-id-13 #rs_billing_city_field').hide();
        jQuery('.page-id-13 #rs_billing_state_field').hide();
        
        jQuery('.page-id-13 #rs_billing_address_1_field label').html('Enter Full Address');
        
        }else{
            
            jQuery('.page-id-13 #rs_billing_postcode_field').show();
        
            jQuery('.page-id-13 #rs_billing_address_1_field').show();
            jQuery('.page-id-13 #rs_billing_address_2_field').show();
            jQuery('.page-id-13 #rs_billing_city_field').show();
            jQuery('.page-id-13 #rs_billing_state_field').show();
            
        }
    });
</script>
<?php } ?>



<?php
if (strpos($_SERVER['REQUEST_URI'], "/dashboard/vendor-driver/") !== false){ ?>
<script>
    //jQuery('.page-id-3534 #country').each(function(){
    var select_option = jQuery('.page-id-13 #drvr_country').val();
    
        if (select_option == 'RW') { 
        jQuery('.page-id-13 #drr_postcode').hide();

        jQuery('.page-id-13 input#dr_zips').val('00000');
        jQuery('.page-id-13 input#dr_zips').attr('readonly','readonly');
        
        jQuery('.page-id-13 #dr_state').attr('value','_');
        jQuery('.page-id-13 #dr_city').attr('value','_');
        
        jQuery('.page-id-13 #drr_street_2').hide();
        jQuery('.page-id-13 #drr_city').hide();
        jQuery('.page-id-13 #drr_state').hide();
        
        jQuery('.page-id-13 #drr_street_1 label').html('Enter Full Address');
        
        
        
    }else{
        
        jQuery('.page-id-13 #drr_postcode').show();
        
        
        
        jQuery('.page-id-13 #drr_street_1').show();
        jQuery('.page-id-13 #drr_street_2').show();
        jQuery('.page-id-13 #drr_city').show();
        jQuery('.page-id-13 #drr_state').show();
        
    }
    
    jQuery('.page-id-13 #drvr_country').change(function(){
        
        //alert(jQuery(this).val());
        
        if(jQuery(this).val() == 'RW'){
        
            
        jQuery('.page-id-13 #drr_postcode').hide();

        jQuery('.page-id-13 input#dr_zips').val('00000');
        jQuery('.page-id-13 input#dr_zips').attr('readonly','readonly');
        
        jQuery('.page-id-13 #drr_street_2').hide();
        jQuery('.page-id-13 #drr_city').hide();
        jQuery('.page-id-13 #dr_state').attr('value','_');
        jQuery('.page-id-13 #dr_city').attr('value','_');
        jQuery('.page-id-13 #drr_state').hide();
        
        jQuery('.page-id-13 #drr_street_1 label').html('Enter Full Address');
        
        }else{
            
            jQuery('.page-id-13 #drr_postcode').show();
            
            jQuery('.page-id-13 input#dr_zips').val('');
            jQuery('.page-id-13 input#dr_zips').removeAttr('readonly');
            
            jQuery('.page-id-13 #dr_state').attr('value','');
            jQuery('.page-id-13 #dr_city').attr('value','');
        
            jQuery('.page-id-13 #drr_street_1').show();
            jQuery('.page-id-13 #drr_street_2').show();
            jQuery('.page-id-13 #drr_city').show();
            jQuery('.page-id-13 #drr_state').show();
            
        }
    });
</script>
<?php } ?>
<script>

    jQuery(document).ready(function(){
        
        function set_address_recipent()
        {
            var id =jQuery("#fabfw_address_shipping_id_field select").val();
            console.log(fabfw_select_address.addresses[id]['address_1']);
            jQuery('#shipping_address_1').val(fabfw_select_address.addresses[id]['address_1']);
            jQuery('#full_address_for_rwanda').val(fabfw_select_address.addresses[id]['address_1']);
            jQuery('body').trigger('update_checkout');
            // var data = {
            //     'action'    :   'get_selected_address',
            //     'id'    : id
                
            // };
            // jQuery.ajax({ 
            //     type: 'POST',
            //     url: ajax_object.ajaxurl,
            //     data: data,
            //     dataType:'json',
            //     success: function(data) {
            //         console.log(data);
            //         console.log(typeof(data));
            //         jQuery('#shipping_address_1').val(data.address_1);
            //         jQuery('#full_address_for_rwanda').val(data.address_1);
            //         // jQuery('body').trigger('update_checkout');
            //     }
                
            // });
        }
        set_address_recipent();
        // jQuery('.fabfw-edit').click(function(){
        jQuery('.slect_recipients').change(function(){
            
            
            set_address_recipent();

//var current_address =jQuery('.address-'+id).text();
 
//jQuery('#shipping_address_1').val(current_address);
//jQuery('#full_address_for_rwanda').val(current_address);


        })
    });
     
</script>
<script>
    jQuery(document).ready(function(){
    jQuery('.showregister').click(function(){
      jQuery('#order_review').toggleClass('toggle_shift');
      jQuery('#order_review_heading').toggleClass('toggle_shift_qw')
    })
    });
</script>
<?php
if (strpos($_SERVER['REQUEST_URI'], "/my-account/edit-address/") !== false){ ?>
<script>
var s = document.body.innerHTML;
document.body.innerHTML = s.replace(/(\<br[\s]*\/?\>[\s]*)+/g, '<br/>');
</script>
<?php } ?>

<script>
jQuery(document).ready(function(){
  jQuery('[data-toggle="tooltip"]').tooltip();   
});
</script>

<style>
   .toggle_shift{
       position: absolute;
       bottom: 100%;
       display:block;
       margin-bottom:50px;
   }
    .toggle_shift_qw{
    position: absolute;
    z-index: 99999;
    top:-42em;}
    
    #store-form input#dokan_address\[street_2\] {
    display: none;
}
label[for="dokan_address[street_2]"] {
    display: none;
}
</style> 
<script>
jQuery(document).ready(function(){
    // Change text of button element
    jQuery(".dokan-store-support-btn").html("Order Support");
});
</script>
<script>
jQuery(document).ready(function(){
        jQuery(".elementor-element-3f72fbed").append('<li class="dokan-store-support-btn-wrap dokan-right"><button data-toggle="modal" data-target="#myModal" class="dokan-chat-support-btn dokan-btn dokan-btn-theme dokan-btn-sm user_logged">Chat</button></li>');
});
</script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" style="height:auto;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" style="border:0px solid #ccc;">&times;</button>
        <?php
        if ( is_user_logged_in() ) { ?>
        <h4 class="modal-title">Support Chat Ticket</h4>
        <?php } else{ ?>
        <h4 class="modal-title">Send a Enquiry Mail to us</h4>
        <?php } ?>
      </div>
      <div class="modal-body">
        <?php
        if ( is_user_logged_in() ) { ?>
        <?php 
        global $wpdb;
        global $wp;
        $current_slug = add_query_arg( array(), $wp->request );
        $slug = explode("/",$current_slug);
        $rtyu = $slug[1];
        $results = $wpdb->get_results("SELECT `user_id` FROM `wp_usermeta` WHERE `meta_value` = '$rtyu'");
         ?>
        <form class="dokan-form-container" id="dokan-chat-form" style="display: flow-root;" action="#" method="post">
            <div class="dokan-form-group">
                <label class="dokan-form-label" for="dokan-chat-subject">Subject :</label>
                <input required="" class="dokan-form-control" type="text" name="dokan-chat-subject" id="dokan-support-subject">
            </div>
            <input class="dokan-form-control" type="hidden" value="<?php $num = mt_rand(100000,999999); echo $num; ?>" name="dokan-chat-ticket-number">
            <input class="dokan-form-control" type="hidden" value="<?php echo $user_ids = get_current_user_id();  ?>" name="dokan-chat-user-id">
            <input class="dokan-form-control" type="hidden" value="<?php echo $results[0]->user_id; ?>" name="dokan-chat-vendor-id">
            <div class="dokan-form-group">
                <label class="dokan-form-label" for="dokan-chat-msg">Message :</label>
                <textarea required="" class="dokan-form-control" name="dokan-chat-msg" rows="5" id="dokan-support-msg"></textarea>
            </div>

            <div class="dokan-form-group">
                <input id="support-submit-btn" type="submit" value="Submit" name="Submit" class="dokan-w5 dokan-btn dokan-btn-theme">
            </div>
        </form>
        <?php }else { 
        echo "<div class='form_chat_not_logged_user'>";    
        echo do_shortcode( '[contact-form-7 id="7074" title="Chat Support Not Logged IN"]' );
        echo "</div>";
        } ?>
        
      </div>
    </div>

  </div>
</div>
<?php
if ( isset( $_POST['Submit'] ) ){
    global $wpdb;

    $chat_id = $_POST['dokan-chat-ticket-number'];
    $user_id = $_POST['dokan-chat-user-id'];
    $vendor_id = $_POST['dokan-chat-vendor-id'];
    $topic = $_POST['dokan-chat-subject'];
    $message = $_POST['dokan-chat-msg'];

    $sql = $wpdb->prepare( "INSERT INTO chat_support (id, chat_id, user_id, vendor_id, topic,message) VALUES ( '','$chat_id','$user_id','$vendor_id','$topic','$message' )");
    $wpdb->query($sql);
}
?>

<style>
    .form_chat_not_logged_user form {
    display: inline-block;
}
.form_chat_not_logged_user form p {
    width: 100%;
}
.form_chat_not_logged_user p span {
    margin-bottom: 0px !important;
}
.form_chat_not_logged_user form textarea {
    height: 110px;
}
.form_chat_not_logged_user .wpcf7-response-output
{
    display:inline-block;
}
.form_chat_not_logged_user .wpcf7-response-output-custom
{
    display:inline-block;
}
</style>
<script>
/*
     jQuery('#billing_phone').val(jQuery('#shipping_phone').val())
    jQuery('#shipping_phone').change(function(){
        var phone = jQuery(this).val()
        jQuery('#billing_phone').val(phone)
    });
    jQuery('#billing_phone_code').val(jQuery('#shipping_phone_code').val())
    jQuery('#shipping_phone_code').change(function(){
        var phone = jQuery(this).val()
        jQuery('#billing_phone_code').val(phone)
    });
    jQuery('#billing_country').val(jQuery('#shipping_country').val())
    jQuery('#shipping_country').change(function(){
        var phone = jQuery(this).val()
        jQuery('#billing_country').val(phone)
    });
    */
</script>
<style>
  /*  #billing_phone_code_field
    {
        display:none;
    }*/
</style> 
<script>
jQuery(document).ready(function(){
    // Change text of button element
    jQuery("form#kas_search").attr('action', 'http://ewt.webdesigntexas.us/hopscan/vendors/');
});
</script>
<script>
/*
jQuery(document).ready(function(){
        if(jQuery(".banner_field_require").val() == '' ){
            jQuery('#_wpnonce').removeAttr( "name" );
            jQuery('input[value="/hopscan/dashboard/settings/store/"]').removeAttr( "name" );
            
        }else{
            jQuery('#_wpnonce').attr( "name","_wpnonce" );
            jQuery('input[value="/hopscan/dashboard/settings/store/"]').attr( "name","_wp_http_referer" );
        }
    });*/
 jQuery(document).ready(function(){
    jQuery("#update_submit_vendor").click(function(){
     if(jQuery("[name='dokan_banner']").val()==""){
         
        alert("Select Banner Image,  Banner size is (1500x450) pixels.");
        
        }else if(jQuery("[name='dokan_gravatar']").val()==""){
            
            alert("Select Profile Picture,  Profile Image size is (150x150) pixels.");
            
            }else{ 
                
          jQuery("#store-form").submit();  
        }
    });  
    
    /*jQuery("#store-form").submit(function(e){
        if(jQuery("[name='dokan_banner']").val()==""){
        e.preventDefault();    
        alert("Image Required");
        return false;
        }
    });*/ 
 });
</script>
<?php
$current_user_id = get_current_user_id();
$phone1 = get_user_meta($current_user_id,'billing_phone_code',true);
$phone2 = get_user_meta($current_user_id,'billing_phone',true);
?>
<script>
    jQuery(document).ready(function(){
        jQuery("#billing_phone_code").val('<?php echo $phone1; ?>');
        jQuery("#billing_phone").val('<?php echo $phone2; ?>');
    });
</script>
<style>
    .profile-info-img-outer img {
    width: 100%;
}
.elementor-element-3f72fbed {
    display: inline-flex;
}
li.dokan-store-support-btn-wrap.dokan-right {
    list-style: none;
    margin: 3px;
}
li.dokan-store-support-btn-wrap.dokan-right button {
    background: #F05025;
    border: 0px;
    height: 33px;
    font-weight: 600;
}
.compare-button.mf-compare-button {
    display: none;
}
label[for="full_address_for_rwanda"] .optional {
    display: none;
}
</style> 
</script>
</body>
</html>
