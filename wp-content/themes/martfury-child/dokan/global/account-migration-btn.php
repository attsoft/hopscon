<?php
/**
 * Dokan Account Migration Button Template
 *
 * @since 2.4
 *
 * @package dokan
 */

$current_user_id = get_current_user_id();

$selected_role = get_user_meta($current_user_id,'selected_role',true);


if ($selected_role == 'vendor' || $selected_role == 'customer') { ?>

<p>&nbsp;</p>

<ul class="dokan-account-migration-lists">
    <li>
        <div class="dokan-w8 left-content">
            <p><strong><?php _e( 'Want to become a HoPscan Vendor?', 'dokan' ) ?></strong></p>
            <p><?php _e( '<strong>HoPscan</strong> vendors sell products to <strong>HoPscan</strong> registerd buyers.', 'dokan' ) ?></p>
        </div>
        <div class="dokan-w4 right-content">
            <a href="<?php echo esc_url( dokan_get_page_url( 'myaccount', 'woocommerce' ) . 'account-migration' ); ?>" class="btn btn-primary"><?php _e( 'Become a Vendor', 'dokan' ); ?></a>
        </div>
        <div class="dokan-clearfix"></div>
    </li>

    <?php do_action( 'dokan_customer_account_migration_list' ); ?>
</ul>
<?php } ?>