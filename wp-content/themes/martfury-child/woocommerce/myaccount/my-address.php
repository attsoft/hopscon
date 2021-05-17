<?php
/**
 * My Addresses
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-address.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.6.0
 */

defined( 'ABSPATH' ) || exit;

$customer_id = get_current_user_id();
$saved_addresses = json_decode (get_user_meta($customer_id, 'mwb_woo_multiple_shipping_addr_saved', true));


if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array(
			'billing'  => __( 'Billing address', 'woocommerce' ),
			'shipping' => __( 'Default Shipping address', 'woocommerce' ),
		),
		$customer_id
	);
} else {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array(
			'billing' => __( 'Billing address', 'woocommerce' ),
		),
		$customer_id
	);
}

$oldcol = 1;
$col    = 1;
?>

<p>
	<?php echo apply_filters( 'woocommerce_my_account_my_address_description', esc_html__( 'The following recipients will be used on the checkout page by default.', 'woocommerce' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
</p>

<?php if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) : ?>
	<div class="u-columns woocommerce-Addresses col2-set addresses">
<?php endif; ?>

<?php foreach ( $get_addresses as $name => $address_title ) : ?>
	<?php
		$address = wc_get_account_formatted_address( $name );
		$col     = $col * -1;
		$oldcol  = $oldcol * -1;
	?>

	<div class="u-column<?php echo $col < 0 ? 1 : 2; ?> col-<?php echo $oldcol < 0 ? 1 : 2; ?> woocommerce-Address">
		<header class="woocommerce-Address-title title">
			<h3><?php echo esc_html( $address_title ); ?></h3>
			<a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address', $name ) ); ?>" class="edit"><?php echo $address ? esc_html__( 'Edit', 'woocommerce' ) : esc_html__( 'Add', 'woocommerce' ); ?></a>
		</header>
		<address>
			<?php
				echo $address ? wp_kses_post( $address ) : esc_html_e( 'You have not set up this type of address yet.', 'woocommerce' );
			?>
		</address>
	</div>

<?php endforeach; ?>

<?php if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) : ?>
	</div>
	<?php
endif;


		global $current_user,$woocommerce;
		$user_id = $current_user->ID;
		$mwb_woo_msa_general_settings = get_option('mwb_woocommerce_multiple_shipping_address_enable_plugin');

		if(is_user_logged_in()){

			$mwb_woo_msa_user_save_addresses = get_user_meta($user_id,'mwb_woo_multiple_shipping_addr_saved',true);
			$mwb_woo_msa_user_save_addresses = json_decode($mwb_woo_msa_user_save_addresses,true);

			if(is_array($mwb_woo_msa_user_save_addresses) && !empty($mwb_woo_msa_user_save_addresses)){
				?>
				<div class="mwb_woo_msa_user_saved_address_wrapper_myac">
                <h3 style="margin-top:30px; margin-bottom:15px;">Other Shipping address</h3>
					<table class="mwb_woo_msa_user_address_collection_wrapper shop_table">
						<thead>
							<th><?php _e('Address','mwb-woocommerce-multiple-shipping-address'); ?></th>
							<th style="min-width: 160px; "><?php _e('Street Address','mwb-woocommerce-multiple-shipping-address'); ?></th>
							<th><?php _e('Town/City','mwb-woocommerce-multiple-shipping-address'); ?></th>
							<th><?php _e('Country','mwb-woocommerce-multiple-shipping-address'); ?></th>
							<th><?php _e('State','mwb-woocommerce-multiple-shipping-address'); ?></th>
							<th><?php _e('Zip','mwb-woocommerce-multiple-shipping-address'); ?></th>
							<th><?php _e('Action','mwb-woocommerce-multiple-shipping-address'); ?></th>
						</thead>
						<tbody>
							<?php
							foreach ($mwb_woo_msa_user_save_addresses as $saved_key => $saved_value) {
								?>
								<tr class="mwb_woo_msa_user_address_collections">
									<td data-label="Address" class="mwb_woo_address1"><?php echo $saved_value['address1']; ?></td>
									<td data-label="Street Address" class="mwb_woo_address2"><?php echo $saved_value['address2']; ?></td>
									<td data-label="Town/City" class="mwb_woo_town"><?php echo $saved_value['town']; ?></td>
									<td data-label="Country" class="mwb_woo_countries"><?php echo WC()->countries->countries[ $saved_value['country']]; ?></td>
									<td data-label="State" class="mwb_woo_state"><?php echo WC()->countries->get_states()[ $saved_value['country']][$saved_value['state']]; ?></td>
									<td data-label="Zip" class="mwb_woo_zip"><?php echo $saved_value['zip']; ?></td>
									<td data-label="Action"><a href="javascript:;" data-edit_addr="<?php echo $saved_key; ?>" class="mwb_woo_msa_edit_addr" data-selected_country="<?php echo $saved_value['country']; ?>" data-selected_state="<?php echo $saved_value['state']; ?>"><?php _e('Edit','mwb-woocommerce-multiple-shipping-address'); ?></a>
										<a href="javascript:;" data-delete_addr="<?php echo $saved_key; ?>" class="mwb_woo_delete_address"><?php _e('Delete','mwb-woocommerce-multiple-shipping-address'); ?></a>
									</td>
								</tr>
								<?php
							}
							?>
						</tbody>
					</table>
				</div>
				<?php
			}
			$MwbWooMsaObject = new WC_Checkout();

		$user_id = $current_user->ID;
			
            if(is_user_logged_in()){
			?>
			<div class="woocommerce-info">
				<span><?php _e('Want To Ship Your Item To Different Addresses, Click On " Add Different Shipping Address" Button','mwb-woocommerce-multiple-shipping-address'); ?></span>
			</div>
			<input type="button" name="mwb_woo_msa_open_modal_button" class="mwb_woo_msa_open_modal_button button alt" value="<?php _e('Add Different Shipping Address','mwb-woocommerce-multiple-shipping-address'); ?>">	
			
	<?php	} ?>
			<div class="mwb_woo_multiple_shipping_address" id="mwb_woo_msa_hide_popup">
				<div class="mwb_woo_msa_enable_multiple_shipping">
					<div id="mwb_woo_msa_enable_multiple_shipping_checkbox_wrapper">
						<div class="mwb_woo_msa_close_modal">&times;</div>
						<div class="mwb_woo_msa_user_address_form">
							<form action="" method="POST" class="mwb_woo_msa_address_form">
								<div class="woocommerce-billing-fields__field-wrapper" id="mwb_woo_msa_address_fields">
									<label><?php _e('Address','mwb-woocommerce-multiple-shipping-address'); ?></label>
                                    <input type="hidden" name="form_type" value="save_add_myac">
									<input type="text" name="mwb_woo_msa_user_address" id="mwb_woo_msa_user_address" value="" placeholder="<?php _e('Enter Address','mwb-woocommerce-multiple-shipping-address'); ?>" required>
									<input type="text" name="mwb_woo_msa_user_address2" id="mwb_woo_msa_user_address2" value="" placeholder="<?php _e('Enter Street Address ','mwb-woocommerce-multiple-shipping-address'); ?>" required>
								</div>

								<div class="woocommerce-billing-fields__field-wrapper" id="mwb_woo_msa_town_city_fields">
									<label><?php _e('Town/City','mwb-woocommerce-multiple-shipping-address'); ?></label>
									<input type="text" name="mwb_woo_msa_user_town" id="mwb_woo_msa_user_town" value="" placeholder="<?php _e('Enter Town/City Name','mwb-woocommerce-multiple-shipping-address'); ?>" required>
								</div>

								<div class="woocommerce-billing-fields__field-wrapper" id="mwb_woo_msa_country_fields">
									<?php
									$fields = $MwbWooMsaObject->get_checkout_fields( 'billing' );
									woocommerce_form_field( 'billing_country', $fields['billing_country'], $MwbWooMsaObject->get_value( 'billing_country' ) );
									woocommerce_form_field( 'billing_state', $fields['billing_state'], $MwbWooMsaObject->get_value( 'billing_state' ) );
									?>
								</div>

								<div class="woocommerce-billing-fields__field-wrapper" id="mwb_woo_msa_postal_fields">
									<?php
									$fields = $MwbWooMsaObject->get_checkout_fields( 'billing' );
									woocommerce_form_field( 'billing_postcode', $fields['billing_postcode'], $MwbWooMsaObject->get_value( 'billing_postcode' ) );
									?>
								</div>
								
								<input type="hidden" name="mwb_woo_msa_nonce" id="mwb_woo_msa_nonce" value="<?php echo wp_create_nonce('mwb-woo-msa-guest-nonce'); ?>">

								<div class="woocommerce-billing-fields__field-wrapper" id="mwb_woo_msa_submit">
									<input type="submit" name="mwb_woo_msa_user_data_submit" id="mwb_woo_msa_user_data_submit" value="<?php _e('Save Details','mwb-woocommerce-multiple-shipping-address'); ?>" class="button alt">
								</div>
							</form>

						</div>
					</div>
				</div>
			</div>
		<?php	
		}