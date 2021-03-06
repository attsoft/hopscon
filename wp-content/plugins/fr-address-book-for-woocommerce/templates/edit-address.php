<?php
/**
 * Edit address form.
 *
 * This template can be overridden by copying it to your-theme/fr-address-book-for-woocommerce/edit-address.php.
 *
 * However, on occasion we will need to update template files and you (the theme 
 * developer) will need to copy the new files to your theme to maintain 
 * compatibility. 
 *
 * @since 1.0.0
 * @version 1.0.0 Markup based on woocommerce/myaccount/form-edit-address.php@3.3.0
 * @author Fahri Rusliyadi <fahri.rusliyadi@gmail.com>
 */

if (!defined('ABSPATH')) {
    exit;
}

?>



<div class="fabfw-edit-address-container">
    <form method="post">
        <div class="woocommerce-address-fields dfd">
            <div class="woocommerce-address-fields__field-wrapper">
                <?php
                foreach ($address_fields as $key => $field) {
                    if (isset($field['country_field'], $address_fields[$field['country_field']])) {
                        $field['country'] = wc_get_post_data_by_key($field['country_field'], $address_fields[$field['country_field']]['value']);
                    }

                    woocommerce_form_field($key, $field, wc_get_post_data_by_key($key, $field['value']));
                }
                ?>
            </div>

            <p>
                <button type="submit" class="button"><?php esc_html_e('Save address', 'fr-address-book-for-woocommerce') ?></button>
                <input type="hidden" name="address_id" value="<?php echo (int) $address_id ?>">
                <?php wp_nonce_field('fabfw_edit_address', 'fabfw_edit_address') ?>
            </p>
        </div>
    </form>
</div>