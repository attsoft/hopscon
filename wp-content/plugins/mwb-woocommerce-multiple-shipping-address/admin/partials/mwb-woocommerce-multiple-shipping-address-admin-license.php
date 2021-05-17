<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Mwb_Woocommerce_Multiple_Shipping_Address
 * @subpackage Mwb_Woocommerce_Multiple_Shipping_Address/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="mwb-woocommerce-multiple-shipping-address-license-sec">

	<h3><?php _e('Enter your License', 'mwb-woocommerce-multiple-shipping-address' ) ?></h3>

    <p>
    	<?php _e('This is the License Activation Panel. After purchasing extension from ', 'mwb-woocommerce-multiple-shipping-address' ); ?>
    	<span>
            <a href="https://makewebbetter.com/" target="_blank" ><?php _e('MakeWebBetter',  'mwb-woocommerce-multiple-shipping-address' ); ?></a>
        </span>&nbsp;

        <?php _e('you will get the purchase code of this extension. Please verify your purchase below so that you can use the features of this plugin.', 'mwb-woocommerce-multiple-shipping-address' ); ?>
    </p>

	<form id="mwb-woocommerce-multiple-shipping-address-license-form">

	    <label><b><?php _e('Purchase Code : ', 'mwb-woocommerce-multiple-shipping-address' )?></b></label>

	    <input type="text" id="mwb-woocommerce-multiple-shipping-address-license-key" placeholder="<?php _e('Enter your code here.', 'mwb-woocommerce-multiple-shipping-address' )?>" required="">

	    <div id="mwb-woocommerce-multiple-shipping-address-ajax-loading-gif"><img src="<?php echo 'images/spinner.gif'; ?>"></div>
	    
	    <p id="mwb-woocommerce-multiple-shipping-address-license-activation-status"></p>

	    <button type="submit" class="button-primary"  id="mwb-woocommerce-multiple-shipping-address-license-activate"><?php _e('Activate', 'mwb-woocommerce-multiple-shipping-address' )?></button>
	    
	    <?php wp_nonce_field( 'mwb-woocommerce-multiple-shipping-address-license-nonce-action', 'mwb-woocommerce-multiple-shipping-address-license-nonce' ); ?>

	</form>

</div>