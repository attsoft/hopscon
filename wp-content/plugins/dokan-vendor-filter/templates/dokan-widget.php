<?php

/**
 * Provide a public-facing view
 *
 * This file is used to markup the public-facing aspects for filter form.
 *
* @link       http://ideas.echopointer.com
 * @since      1.2.4
 *
 * @package    Kas_Dokan_Vendor_Filter
 * @subpackage Kas_Dokan_Vendor_Filter/public/partials
 */
?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php 


		if (isset($_GET['kas_country']) && !empty($_GET['kas_country'])) {
			$kas_country = urlencode($_GET['kas_country']);
		}else {
			$kas_country = '';
		}
		if (isset($_GET['kas_state']) && !empty($_GET['kas_state'])) {
			$kas_state = urlencode($_GET['kas_state']);
		}else{
			$kas_state = '';
		}
		if (isset($_GET['kas_city']) && !empty($_GET['kas_city'])) {
			$kas_city = urlencode($_GET['kas_city']);
		}else {
			$kas_city = '';
		}
		if (isset($_GET['kas_zip']) && !empty($_GET['kas_zip'])) {
			$kas_zip = urlencode($_GET['kas_zip']);
		}else {
			$kas_zip = '';
		}
		if (isset($_GET['kas_category']) && !empty($_GET['kas_category'])) {
			$kas_category = $_GET['kas_category'];
		}else {
			$kas_category = '';
		}
		if (isset($_GET['query_type']) && !empty($_GET['query_type'])) {
			$query_type = $_GET['query_type'];
		}else {
			$query_type = '';
		}

		echo  '<script type="text/javascript"> var kas_searchList = '.json_encode($args['data'], JSON_PRETTY_PRINT).';';
		//echo (get_option('kas-enable-select2') > 0 ? 'var kas_select2_01 = true; ' : 'var kas_select2_01 = false;');
		
		// 
		if (get_option('kas-enable-select2') == 1) {
			echo 'var kas_select2_01 = 1; ';
		}elseif (get_option('kas-enable-select2') == 2){
			echo 'var kas_select2_01 = 2; ';
		}elseif (get_option('kas-enable-select2') == 3){
			echo 'var kas_select2_01 = 3; ';
		}else{
			echo 'var kas_select2_01 = 0; ';
		}
		echo 'var st_country = "'.$kas_country.'"; var st_state = "'.$kas_state.'"; var st_city = "'.$kas_city.'"; var st_zip = "'.$kas_zip.'"; var st_category = "'.$kas_category.'";';
		
		echo '</script>';
		
		// check if bootstrap enable
		if (get_option('kas-enable-bootstrap') == 1){
			$css_main_form = 'form-horizontal';
			$css_select_class = 'form-control';
			$css_form_group = 'form-group';
			$btn_css ="dokan-btn dokan-btn-theme";
		}else{
			$css_main_form = 'kas-form-horizontal';
			$css_select_class = 'kas-control';
			$css_form_group = 'kas-group';
			$btn_css = 'dokan-btn dokan-btn-theme';
		}
				

?>


		
		<form id="kas_search" method="get" class="<?php echo $css_main_form; ?> kas_center kas_search 22" action="<?php echo get_option('kas-result-pagelink'); ?>">
		<?php if (get_option('kas-show-country-w') == 1){?>
		<div class="<?php echo $css_form_group;?> "><select id="kas_country" name="kas_country"
			class="<?php echo $css_select_class;?> kas_country">
			<option value=""><?php _e('Country..', $this->kas_filter);?></option>
			<?php
			foreach ($args['countries'] as $country) {
				if($kas_country == $country){
					echo '<option selected value="'.$country.'">'.$country.'</option>';
				}else{
					echo '<option value="'.$country.'">'.$country.'</option>';
				}
			}
			?>
		</select></div>
		<?php }?> 
		<?php if (get_option('kas-show-state-w') == 1){?>
		<div class="<?php echo $css_form_group;?>"><select id="kas_state" name="kas_state"
			class="<?php echo $css_select_class;?> kas_state">
			<option value=""><?php _e('State..', $this->kas_filter);?></option>
			<?php
			foreach ($args['states'] as $state) {
				if($kas_state == $state){
					echo '<option selected value="'.$state.'">'.$state.'</option>';
				}else{
					echo '<option value="'.$state.'">'.$state.'</option>';
				}
			}
			?>
		
		</select></div>
		<?php }?> 
		<?php if (get_option('kas-show-city-w') == 1){?>
		<div class="<?php echo $css_form_group;?>"><select id="kas_city" name="kas_city"
			class="<?php echo $css_select_class;?> kas_city">
			<option value=""><?php _e('City..', $this->kas_filter);?></option>
			<?php
			foreach ($args['cities'] as $city) {
				if($kas_city == $city){
					echo '<option selected value="'.$city.'">'.$city.'</option>';
				}else{
					echo '<option value="'.$city.'">'.$city.'</option>';
				}
			}
			?>
		
		</select></div>
		<?php }?>
		
		<?php if (get_option('kas-show-zip-w') == 1){?>
		<div class="<?php echo $css_form_group;?>"><select id="kas_zip" name="kas_zip"
			class="<?php echo $css_select_class;?> kas_zip">
			<option value=""><?php _e('Zip..', $this->kas_filter);?></option>
			<?php
			foreach ($args['zips'] as $zip) {
				if($kas_zip == $zip){
					echo '<option selected value="'.$zip.'">'.$zip.'</option>';
				}else{
					echo '<option value="'.$zip.'">'.$zip.'</option>';
				}
			}
			?>
		
		</select></div>
		<?php }?>
		
		<?php if (get_option('kas-show-category-w') == 1){?>
		<div class="<?php echo $css_form_group; ?>"><select id="kas_category" name="kas_category"
			class="<?php echo $css_select_class; ?> kas_category">
			<option value=""><?php _e('Vendor Category..', $this->kas_filter);?></option>
			<?php
			foreach ($args['categories'] as $category) {
				$cat_array = explode(',', $category);
				foreach ($cat_array as $kas_cat){
					if($kas_category == $kas_cat && !empty($kas_category)){
						echo '<option selected value="'.$kas_cat.'">'.$kas_cat.'</option>';
					}else{
						echo '<option value="'.$kas_cat.'">'.$kas_cat.'</option>';
					}
				}
			}
			?>
		</select></div>
		<?php }?>
		
		<?php if (get_option('kas-show-frating-w') == 1){?>
		<div class="<?php echo $css_form_group; ?>"><select id="kas_rating" name="kas_rating"
			class="<?php echo $css_select_class; ?> kas_rating">
			<option value=""><?php _e('Rating..', $this->kas_filter);?></option>
			<?php
			sort($args['ratings']);
			foreach ($args['ratings'] as $rating) {
				if($kas_rating == $rating){
					echo '<option selected value="'.$rating.'">'.$rating.'</option>';
				}else{
					echo '<option value="'.$rating.'">'.$rating.'</option>';
				}
			}
			?>
		</select></div>
		<?php }?>

		<?php if (get_option('kas-show-searchtype-w') == 1){?>
		<div class="<?php echo $css_form_group;?>"><select id="query_type" name="query_type"
			class="<?php echo $css_select_class;?> query_type">
				<option value=""><?php _e('Looking for..', $this->kas_filter);?></option>
				<?php 
					$vendor_lable = __('Store', $this->kas_filter);
					$product_lable = __('Products', $this->kas_filter);
				
				if($query_type == 'vendors' && isset($query_type)){
					echo '<option selected value="'.$query_type.'">'. $vendor_lable .'</option>';
					echo '<option value="products">'. $product_lable .'</option>';
				}elseif ($query_type == 'products' && isset($query_type)){
					echo '<option value="vendors">'. $vendor_lable .'</option>';
					echo '<option selected value="'.$query_type.'">'. $product_lable .'</option>';
				}else {
					echo '<option value="vendors">'. $vendor_lable .'</option>';
					echo '<option value="products">'. $product_lable .'</option>';
				}			
				?>
			
		</select></div>
		<?php }?>
		
		<?php if (get_option('kas-show-store-w') == 1 && get_option('kas-show-searchtype-w') != 1){?>
		<div class="<?php echo $css_form_group;?>"><select id="kas_store" name="kas_store"
			class="<?php echo $css_select_class;?> kas_store">
			<option value=""><?php _e('Store Name..', $this->kas_filter);?></option>
			<?php
			foreach ($args['stores'] as $store) {
				echo '<option value="'.$store[0].'">'.$store[1].'</option>';
			}
			?>
		</select></div>
		<?php }?>
		
		<button type="submit" class="<?php echo $btn_css; ?> kas_full_width"><?php _e('Go', $this->kas_filter);?></button>
		
		</form>
		<div class="kas_loader">
			<div class="bounce1"></div>
  			<div class="bounce2"></div>
  			<div class="bounce3"></div>
  		</div>
