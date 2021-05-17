<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$allowed_html = array(
	'a' => array(
		'href' => array(),
	),
);

$selected_role = get_user_meta($current_user->ID,'selected_role',true);

?>

<p>
	<?php
	$author_name  = $current_user->user_firstname. " " .$current_user->user_lastname;
	if(empty($current_user->user_firstname)){
		$author_name  = $current_user->display_name;
		}
	$logout_witoutnonce = home_url().'/wp-login.php?action=logout&redirect_to='.home_url().'/my-account';
	printf(
		/* translators: 1: user display name 2: logout url */
		wp_kses( __( 'Hello %1$s (not %1$s?) <a href="%2$s">Log out</a>', 'woocommerce' ), $allowed_html ),
		'<strong>' . esc_html( $author_name ) . '</strong>',
		esc_url( $logout_witoutnonce )
	);
	?>
</p>

<p>
	<?php
	/* translators: 1: Orders URL 2: Address URL 3: Account URL. */
	$dashboard_desc = __( 'From your account dashboard you can view your <a href="%1$s">recent orders</a>, manage your <a href="'.home_url().'/my-account/edit-address/">recipients</a> and <a href="'.home_url().'/my-account/edit-account/">billing address</a>, edit your <a href="%3$s">password</a> and <a href="%3$s">account details</a>.', 'woocommerce' );
	if ( wc_shipping_enabled() ) {
		/* translators: 1: Orders URL 2: Addresses URL 3: Account URL. */
		$dashboard_desc = __( 'From your account dashboard you can view your <a href="%1$s">recent orders</a>, manage your <a href="'.home_url().'/my-account/edit-address/">recipients</a> and <a href="'.home_url().'/my-account/edit-account/">billing address</a>, edit your <a href="%3$s">password</a> and <a href="%3$s">account details</a>.', 'woocommerce' );
	}
	printf(
		wp_kses( $dashboard_desc, $allowed_html ),
		esc_url( wc_get_endpoint_url( 'orders' ) ),
		esc_url( wc_get_endpoint_url( 'edit-address' ) ),
		esc_url( wc_get_endpoint_url( 'edit-account' ) ),
		esc_url( wc_get_endpoint_url( 'edit-account' ) )
	);
	?>
</p>
<?php 

	if($_GET['dr_req'] == 'send'){ ?>
	<ul class="dokan-account-migration-lists sumit_done">
    	<li> Your Application for become a HoPscan Driver will be submited. We will get back to you soon.</li>
    </ul>
		<?php }
if($current_user->roles[0] == 'customer'){	

if ($selected_role == 'driver' || $selected_role == 'customer') {
?>
<ul class="dokan-account-migration-lists">
    <li>
        <div class="dokan-w8 left-content">
            <p><strong>Want to become a HoPscan Driver?</strong></p>
            <p><strong>HoPscan</strong> Drivers earn money delevering products to the recipients from <strong>HoPscan</strong> registerd Vendors.</p>
        </div>
        <div class="dokan-w4 right-content">
            <a href="<?php echo home_url('my-account/become-a-driver');?>" class="btn btn-primary" id="driver_migration" data-userid="<?php echo $current_user->ID;?>">Become a Driver</a>
        </div>
        <div class="dokan-clearfix"></div>
    </li>

    </ul>
<?php			
		}		
?>
  
<script>
//jQuery("#driver_migration").click(function(){
//	var userid = jQuery(this).attr('data-userid');
//    jQuery.ajax({
//		type: 'POST',
//		dataType: "json",
//		url :  '<?php  //echo admin_url( 'admin-ajax.php' ); ?>',
//		data : {
//			userid: userid,
//			action: 'update_account_todriver',
//		}, 
//		success : function(response){
//		if(response.status) {
//			window.location.replace(response.redirect);	
//		}else{
//			window.location.replace(response.redirect);	
//		}
//	   } 
//   });
//});</script><?php }
	/**
	 * My Account dashboard.
	 *
	 * @since 2.6.0
	 */
	do_action( 'woocommerce_account_dashboard' );
	/**
	 * Deprecated woocommerce_before_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_before_my_account' );
	/**
	 * Deprecated woocommerce_after_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_after_my_account' );
	?>
    <ul class="dokan-account-migration-lists">
    <li>
        <div class="dokan-w4 right-content">
            <a href="<?php echo home_url();?>" class="btn btn-primary" id="go_shop">Go To Shop</a>
        </div>
        <div class="dokan-clearfix"></div>
    </li>

    </ul>
    <?php

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
