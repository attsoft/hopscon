<?php
/**
 * Output a single payment method
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/payment-method.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<li class="wc_payment_method payment_method_<?php echo esc_attr( $gateway->id ); ?>">
	<input id="payment_method_<?php echo esc_attr( $gateway->id ); ?>" type="radio" class="input-radio" name="payment_method" value="<?php echo esc_attr( $gateway->id ); ?>" <?php checked( $gateway->chosen, true ); ?> data-order_button_text="<?php echo esc_attr( $gateway->order_button_text ); ?>" />

	<label for="payment_method_<?php echo esc_attr( $gateway->id ); ?>">
		<?php echo $gateway->get_title(); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?> <?php echo $gateway->get_icon(); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?>
	</label>
	<?php if ( $gateway->has_fields() || $gateway->get_description() ) : ?>
		<div class="payment_box payment_method_<?php echo esc_attr( $gateway->id ); ?>" <?php if ( ! $gateway->chosen ) : /* phpcs:ignore Squiz.ControlStructures.ControlSignature.NewlineAfterOpenBrace */ ?>style="display:none;"<?php endif; /* phpcs:ignore Squiz.ControlStructures.ControlSignature.NewlineAfterOpenBrace */ ?>>
			<?php $gateway->payment_fields(); ?>
		</div>
	<?php endif; ?>

	<!--Account Details in checkout page -->
<?php if ($gateway->title == "Direct bank transfer") { ?>
	<div class="payment_box payment_method_<?php echo esc_attr( $gateway->id ); ?>" 
		<?php if ( ! $gateway->chosen ) :?>style="display:none;"<?php endif ?>>
		<div class="account_details" style="color:#000">
		<?php 
				// Loop over $cart items
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {

				  $product = $cart_item['data'];
				  $product_id = $cart_item['product_id'];

				  $author_id  = get_post_field( 'post_author', $product_id );

				  $vendor_details = get_user_meta($author_id, 'dokan_profile_settings', true);
				  $vendor_bank = $vendor_details['payment']['bank'];
				   // $quantity = $cart_item['quantity'];
				   // $price = WC()->cart->get_product_price( $product );
				   // $subtotal = WC()->cart->get_product_subtotal( $product, $cart_item['quantity'] );
				   // $link = $product->get_permalink( $cart_item );
				   // Anything related to $product, check $product tutorial
				  $ac_name = $vendor_bank['ac_name'];
				  $ac_number = $vendor_bank['ac_number'];
				  $bank_name = $vendor_bank['bank_name'];
				  $routing_number = $vendor_bank['routing_number'];
				  $iban = $vendor_bank['iban'];
				  $swift = $vendor_bank['swift'];
			}
				if (! empty($vendor_bank)) {
				  	echo "Account Name : ".$ac_name. '<br>';
					echo "Account Number : ".$ac_number. '<br>';
				   	echo "Bank Name : ".$bank_name;
				   	//echo "Account Name : ".$routing_number;
				   	//echo "Account Name : ".$iban;
				   	//echo "Account Name : ".$swift;				  	
				}else{

				}
		?>
		</div>
	</div>
<?php } ?>
</li>
