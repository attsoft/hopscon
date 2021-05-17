<?php
/**
 * The Template for update customer to seller.
 *
 * @package dokan
 * @package dokan - 2014 1.0
 */
$user_id = get_current_user_id();

$f_name = get_user_meta( $user_id, 'first_name', true );
$l_name = get_user_meta( $user_id, 'last_name', true );

if ( $f_name == '' ) {
    if ( isset( $_POST['fname'] ) ) {
        $f_name = $_POST['fname'];
    }
}

if ( $l_name == '' ) {
    if ( isset( $_POST['lname'] ) ) {
        $l_name = $_POST['lname'];
    }
}
$cu_slug = get_user_meta( $user_id, 'nickname', true );
?>


<h2 style="font-size: 18px; font-weight: 600;"><?php _e( 'Become a vendor', 'dokan' ); ?></h2>
<div class="dokan-w4 right-content-shop">
            <a href="<?php echo home_url();?>" class="btn btn-primary" id="go_shop">Go To Shop</a>
        </div>
        <div class="dokan-clearfix"></div>
<form method="post" action="" class="register">

    <div class="dokan-become-seller">

        <div class="split-row form-row-wide">
            <p class="form-row form-group">
                <label for="first-name"><?php _e( 'First Name', 'dokan' ); ?> <span class="required">*</span></label>
                <input type="text" class="input-text form-control" name="fname" id="first-name" value="<?php if ( ! empty( $f_name ) ) echo esc_attr( $f_name ); ?>" required="required" />
            </p>

            <p class="form-row form-group">
                <label for="last-name"><?php _e( 'Last Name', 'dokan' ); ?> <span class="required">*</span></label>
                <input type="text" class="input-text form-control" name="lname" id="last-name" value="<?php if ( ! empty( $l_name ) ) echo esc_attr( $l_name ); ?>" required="required" />
            </p>
        </div>

        <p class="form-row form-group form-row-wide">
            <label for="company-name"><?php _e( 'Shop Name', 'dokan' ); ?> <span class="required">*</span></label>
            <input type="text" class="input-text form-control" name="shopname" id="company-name" value="<?php if ( ! empty( $_POST['shopname'] ) ) echo esc_attr( $_POST['shopname'] ); ?>" required="required" />
        </p>

        <p class="form-row form-group form-row-wide">
            <label for="seller-url" class="pull-left"><?php _e( 'Shop URL', 'dokan' ); ?> <span class="required">*</span></label>
            <strong id="url-alart-mgs" class="pull-right"></strong>
            <input type="text" class="input-text form-control" name="shopurl" id="seller-url" value="<?php if ( empty ( $cu_slug ) ) { if ( ! empty( $_POST['shopurl'] ) ) echo esc_attr( $_POST['shopurl'] );}else echo esc_attr( $cu_slug ); ?>" required="required" />
            <small><?php echo home_url() . '/' . dokan_get_option( 'custom_store_url', 'dokan_general', 'store' ); ?>/<strong id="url-alart"></strong></small>
        </p>

<?php 
global $woocommerce;
    $countries_obj   = new WC_Countries();
    $countries   = $countries_obj->__get('countries');
?>

<?php /*?><p class="form-row form-group form-row-wide">
            <label for="country" class="pull-left"><?php _e( 'Country', 'dokan' ); ?> <span class="required">*</span></label>
            <strong id="url-alart-mgs" class="pull-right"></strong>
             <select required="" name="country" class="country_to_state dokan-form-control" id="dokan_address_country">
    <option value="">- Country -</option>
    <?php foreach($countries as $key=>$val){ ?>
    <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
    <?php } ?>
  </select>
        </p><?php */?>
        
      
      
      <div class="dokan-form-group">

    <p class="form-row form-group form-row-wide street_hide">
                <label class="dokan-w3 control-label" for="address[street_1]">Street                                     </label>
                <input id="address[street_1]" value="" name="address[street_1]" placeholder="Street address" class="input-text form-control" type="text">
   </p>
    <p class="form-row form-group form-row-wide street2_hide">
                <label class="dokan-w3 control-label" for="address[street_2]">Street 2                                    </label>
                <input id="address[street_2]" value="" name="address[street_2]" placeholder="Apartment, suite, unit etc. (optional)" class="input-text form-control" type="text">
     </p>
     <p class="form-row form-group form-row-wide city_hide">
      
                        <label class="control-label" for="address[city]">City                                                    </label>
                        <input id="address[city]" value="" name="address[city]" placeholder="Town / City" class="input-text form-control" type="text">
    </p>
    <p class="form-row form-group form-row-wide postcode_hide">
                        <label class="control-label" for="address[zip]">Post/ZIP Code                                                    </label>
                        <input id="address[zip]" value="" name="address[zip]" placeholder="Postcode / Zip" class="input-text form-control postcode_input" type="text">
    </p>
                                <div class="dokan-clearfix"></div>

   <p class="form-row form-group form-row-wide migrationfm">
                <label class="control-label" for="address[country]">Country<span class="required"> *</span></label>
                  <select required="" name="address[country]" class="country_to_state input-text form-control" id="dokan_address_country">
    <option value="">- Country -</option>
    <?php foreach($countries as $key=>$val){ ?>
    <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
    <?php } ?>
  </select>   
                    
                        </p>
</div>
      


       <?php /*?><p class="form-row form-group form-row-wide" style="display:none;">
            <label for="seller-address"><?php _e( 'Address', 'dokan' ); ?><span class="required">*</span></label>
            <textarea type="text" id="seller-address" name="address" class="form-control input" required="required">address</textarea>
        </p><?php */?>

        <p class="form-row form-group form-row-wide phone_migblc">
            <label for="shop-phone"><?php _e( 'Phone Number', 'dokan' ); ?><span class="required">*</span></label>
            <input type="text" id="migrate_phcd" value="" readonly="readonly" name="migrate_phcd"/><input type="text" class="input-text form-control" name="phone" id="shop-phone" value="<?php if ( ! empty( $_POST['phone'] ) ) echo esc_attr( $_POST['phone'] ); ?>" required="required" />
        </p>

        <?php

            /**
             * Hook for adding fields after vendor migration
             *
             * @since 2.6.7
             */
            do_action( 'dokan_after_seller_migration_fields' );
        ?>

        <?php
       // $show_toc = dokan_get_option( 'enable_tc_on_reg', 'dokan_general' );

        if ( $show_toc == 'on' ) {
            $toc_page_id = dokan_get_option( 'reg_tc_page', 'dokan_pages' );
            if ( $toc_page_id != -1 ) {
                $toc_page_url = get_permalink( $toc_page_id );
                ?>
                <p class="form-row form-group form-row-wide">
                    <input class="tc_check_box" type="checkbox" id="tc_agree" name="tc_agree" required="required">
                    <label style="display: inline" for="tc_agree"><?php echo sprintf( __( 'I have read and agree to the <a target="_blank" href="%s">Terms &amp; Conditions</a>.', 'dokan' ), $toc_page_url ); ?></label>
                </p>
            <?php } ?>
        <?php } ?>
		<p class="form-row">
        <label>
        By registering you accept HoPscan's <a href="<?php echo home_url('term-conditions'); ?>" target="_blank"> Terms and Conditions</a> and <a href="<?php echo home_url('policy'); ?>" target="_blank">Privacy Policy</a> and allow HoPscan to contact you and send you marketing communications using the contact details you have provided to us.                </label>
        </p>
        <p class="form-row">
        <?php wp_nonce_field( 'account_migration', 'dokan_nonce' ); ?>
            <input type="hidden" name="user_id" value="<?php echo $user_id ?>">
            <input type="submit" class="dokan-btn dokan-btn-default dokan_migration_sub" name="dokan_migration" value="<?php _e( 'Become a Vendor', 'dokan' ); ?>" />
        </p>
    </div>
</form>
