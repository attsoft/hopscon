<?php

/**
 * Provide a public-facing view
 *
 * This file is used to markup the public-facing aspects for filter form.
 *
* @link       http://ideas.echopointer.com
 * @since      1.0.6
 *
 * @package    Kas_Dvf
 * @subpackage Kas_Dvf/public/templates
 */
?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php 
		
		if (isset($_GET['kas_country']) && !empty($_GET['kas_country'])) {
			$kas_country = $_GET['kas_country'];
		}else {
			$kas_country = '';
		}
		if (isset($_GET['kas_state']) && !empty($_GET['kas_state'])) {
			$kas_state = $_GET['kas_state'];
		}else{
			$kas_state = '';
		}
		if (isset($_GET['kas_city']) && !empty($_GET['kas_city'])) {
			$kas_city = $_GET['kas_city'];
		}else {
			$kas_city = '';
		}
		if (isset($_GET['kas_zip']) && !empty($_GET['kas_zip'])) {
			$kas_zip = $_GET['kas_zip'];
		}else {
			$kas_zip = '';
		}
		
		echo '<script type="text/javascript">';
		if (get_option('kas-enable-select2') == 1) {
			echo 'var kas_select2_01 = 1; ';
		}elseif (get_option('kas-enable-select2') == 2){
			echo 'var kas_select2_01 = 2; ';
		}elseif (get_option('kas-enable-select2') == 3){
			echo 'var kas_select2_01 = 3; ';
		}else{
			echo 'var kas_select2_01 = 0; ';
		}
		echo '</script>';
		
		// check if bootstrap enable
		if (get_option('kas-enable-bootstrap') == 1){
			$css_main_form = 'form-inline';
			$css_select_class = 'form-control';
			$css_form_group = 'form-group';
			$btn_css ="dokan-btn dokan-btn-theme";
		}else{
			$css_main_form = 'kas-search';
			$css_select_class = 'kas-control';
			$css_form_group = 'kas-group';
			$btn_css = 'dokan-btn dokan-btn-theme';
		}

?>


		
		<form id="kas_search_aio" method="get" class="<?php echo $css_main_form; ?> kas_center kas_search_aio" action="<?php echo get_option('kas-result-pagelink'); ?>">
		
		<div class="<?php echo $css_form_group; ?>">
			<select id="kas_aio" name="kas_aio"
				class="<?php echo $css_select_class;?> kas_aio">
				<option value=""><?php _e('Search Store...', $this->kas_filter);?></option>
				<?php 
					foreach ($args as $address){
						$kas_address_srt = '';
						$kas_address_val = '';
						if (!empty($address['country']) && get_option('kas-show-country-s') == 1) {
							if (!empty($kas_address_srt)) {
								$kas_address_srt .= ', '.$address['country'];
								$kas_address_val .= '&kas_country='.$address['country'];
							}else{
								$kas_address_srt .= $address['country'];
								$kas_address_val .= 'kas_country='.$address['country'];
							}
						}
						if (!empty($address['state']) && get_option('kas-show-state-s') == 1) {
							if (!empty($kas_address_srt)) {
								$kas_address_srt .= ', '.$address['state'];
								$kas_address_val .= '&kas_state='.$address['state'];
							}else{
								$kas_address_srt .= $address['state'];
								$kas_address_val .= 'kas_state='.$address['state'];
							}
						}
						if (!empty($address['city']) && get_option('kas-show-city-s') == 1) {
							if (!empty($kas_address_srt)) {
								$kas_address_srt .= ', '.$address['city'];
								$kas_address_val .= '&kas_city='.$address['city'];
							}else{
								$kas_address_srt .= $address['city'];
								$kas_address_val .= 'kas_city='.$address['city'];
							}
						}
						if (!empty($address['zip']) && get_option('kas-show-zip-s') == 1) {
							if (!empty($kas_address_srt)) {
								$kas_address_srt .= ', '.$address['zip'];
								$kas_address_val .= '&kas_zip='.$address['zip'];
							}else{
								$kas_address_srt .= $address['zip'];
								$kas_address_val .= 'kas_zip='.$address['zip'];
							}
						}
						
						if (!empty($address['store_name'])  && get_option('kas-show-store-s') == 1) {
							$kas_address_srt .= ' - '.$address['store_name'];
							$kas_address_val = $address['store_link'];
						}else{
							$kas_address_val = get_option('kas-result-pagelink') . $kas_address_val;
						}
						
						echo '<option value="'.$kas_address_val.'">'.$kas_address_srt.'</option>';
					}
				
				?>
				
	
			</select>
		</div>
		
		</form>
		<div class="kas_loader">
			<div class="bounce1"></div>
  			<div class="bounce2"></div>
  			<div class="bounce3"></div>
  		</div>
