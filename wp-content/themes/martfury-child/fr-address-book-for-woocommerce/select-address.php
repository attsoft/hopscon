<?php
/**
 * Select address field.
 *
 * This template can be overridden by copying it to your-theme/fr-address-book-for-woocommerce/select-address.php.
 *
 * However, on occasion we will need to update template files and you (the theme 
 * developer) will need to copy the new files to your theme to maintain 
 * compatibility. 
 *
 * @since 1.0.0
 * @version 1.2.2
 * @author Fahri Rusliyadi <fahri.rusliyadi@gmail.com>
 */

/* @var $type string */
/* @var $addresses array */
/* @var $saved_address_id int */

$field_options  = array();

/*foreach ($addresses as $id => $value) {
    $field_options[$id] = isset($value['address_name']) && $value['address_name'] 
                        ? sprintf('<strong class="fabfw-address-name">%s</strong><br>', $value['address_name']) 
                        : '';
    $field_options[$id] .= wc()->countries->get_formatted_address($value);
    $field_options[$id] .= sprintf('<br><a href="#" class="fabfw-edit">%s</a>', __('Edit', 'fr-address-book-for-woocommerce'));
}*/

foreach ($addresses as $id => $value) {

	
    $field_options[$id] = isset($value['address_name']) && $value['address_name'] 
                        ? sprintf('<strong class="fabfw-address-name">%s</strong><br>', $value['address_name']) 
                        : $value['first_name'].' '.$value['last_name'];
   // $field_options[$id] .= ' '.wc()->countries->get_formatted_address($value);
   // $field_options[$id] .= sprintf('<br><a href="#" class="fabfw-edit">%s</a>', __('Edit', 'fr-address-book-for-woocommerce'));
}

if (count($addresses) < fr_address_book_for_woocommerce()->max_addresses) {
    $field_options['new'] = sprintf('<a class="button">%s</a>', __('Add new recipient', 'fr-address-book-for-woocommerce'));
}
?>

<div class="fabfw-select-address-container">         


            
    <?php if ($addresses) : 
		$count = 0;
		
		//echo 'Saved Address '.$saved_address_id;
		
	?>
        <p class="form-row" id="<?php echo "fabfw_address_{$type}_id_field" ?>">
           <?php if($type == 'shipping'){?>
           
           
           
            <label class="recap_ship"><?php esc_html_e('Add/Select a Recipient', 'fr-address-book-for-woocommerce') ?></label>
            
          

            <span class="woocommerce-input-wrapper">
            
            <select name="<?php echo "fabfw_address_{$type}_id" ?>" id="<?php echo "fabfw_address_{$type}_id_{$id}" ?>" class="slect_recipients"  data-placeholder="Select a recipient" data-input-classes="" tabindex="-1" aria-hidden="true" data-select2-id="<?php echo "select2-data-fabfw_address_{$type}_id" ?>">
				<option value="<?php echo '0'; ?>">Add/ Select Recipients</option>
                <?php 
                
                $pre_Id = get_user_meta(get_current_user_id(),'last_order_recipient_id',ture);

				foreach ($field_options as $id => $label){ 
                    if ($pre_Id == $id) {
                        $selected = 'selected="selected"';
                    }else{
                        $selected = '';
                    }
                 ?>
                    <option value="<?php echo $id ?>" <?php echo $selected; ?>> <?php echo $label ?></option>
                <?php } ?>
            </select>
                <div class="add_showedit">
                    <ul class="show_addbl">
                        <?php 
                            $count = 0;
                            foreach ($addresses as $id => $value) {
                                    if ($pre_Id != $id) {
                                        $show = 'display:none';
                                    }else{
                                        $show = '';
                                    }
                                    if ($value['country'] == 'RW') {
                                        echo '<li class="address-'.$id.'" style="'.$show.'">'.$value['address_1'].'</li>';
                                    }else{
                            		echo '<li class="address-'.$id.'" style="'.$show.'">'.str_replace('00000','',wc()->countries->get_formatted_address($value)).'</li>';
                                     }
                            $count++;
                            }
                        ?>
                    </ul>

                <a href="#" class="fabfw-edit customeditlnk">Edit Address</a>
                </div>             
                <?php /*?><?php foreach ($field_options as $id => $label) : 
				
						 ?>
					<input 
                        type="radio" 
                        class="input-radio <?php echo $count;?>" 
                        value="<?php echo $id ?>" 
                        name="<?php echo "fabfw_address_{$type}_id" ?>" 
                        id="<?php echo "fabfw_address_{$type}_id_{$id}" ?>"
                        <?php checked($id, $saved_address_id) ?>
                    />
                    <label for="<?php echo "fabfw_address_{$type}_id_{$id}" ?>" class="radio">
                        <?php echo $label ?>
                    </label>
                <?php 
							
						
						
					
				endforeach ?><?php */?>
            </span>
            <?php } ?>
        </p>
    <?php 
        // Hide the field if no addresses saved yet.
        else : ?>
        <input type="hidden" id="<?php echo "fabfw_address_{$type}_id" ?>" name="<?php echo "fabfw_address_{$type}_id" ?>" value="new">
       
    <?php endif ?>
    
</div>
<script>
jQuery(document).ready(function($){
    jQuery('.slect_recipients').select2();
    // jQuery('.slect_recipients option:eq(1)').attr('selected', 'selected');
	<?php if(count($addresses) > 0){ ?>
		jQuery('.woocommerce-shipping-fields__field-wrapper').addClass('hidden');
	<?php } ?>
	
	
   jQuery('.slect_recipients').change(function(){
        var selectedadd = jQuery(this).children("option:selected").val();
		jQuery('.show_addbl li').css('display', 'none'); 
        jQuery('.show_addbl .address-'+selectedadd).css('display', 'block');

        var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
        var recipient_id = jQuery('.slect_recipients option').filter(':selected').val();

        jQuery.ajax({
         type : "post",
         url : ajaxurl,
         data : {
         action: "checkout_shipping_recepient_id", 
         recipient_id : recipient_id,
         },
         success: function(response) {
         }
      })  
    });

	
});
</script>	