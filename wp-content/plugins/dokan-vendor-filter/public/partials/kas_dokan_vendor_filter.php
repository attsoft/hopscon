<?php

/**
 * Provide a public-facing view
 *
 * This file is used to markup the public-facing aspects for filter form.
 *
* @link       http://ideas.echopointer.com
 * @since      1.0.6
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
		if (isset($_GET['kas_rating']) && !empty($_GET['kas_rating'])) {
			$kas_rating = $_GET['kas_rating'];
		}else {
			$kas_rating = '';
		}
		if (isset($_GET['query_type']) && !empty($_GET['query_type'])) {
			$query_type = $_GET['query_type'];
			if ($query_type == 'products') {
				$range_display = 'block';
			}else{
				$range_display = 'none';
			}
			
		}else {
			$query_type = '';
			$range_display = 'none';
		}
		if (isset($_GET['kas_range']) && !empty($_GET['kas_range'])) {
			$kas_range = explode('-',$_GET['kas_range']);
			$kas_range_min = $kas_range[0];
			$kas_range_max = $kas_range[1];
		}else {
			$kas_range = array(0,esc_attr(get_option('kas-products-maxprice')));
			$kas_range_min = $kas_range[0];
			$kas_range_max = $kas_range[1];
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
		echo 'var st_country = "'.$kas_country.'"; var st_state = "'.$kas_state.'"; var st_city = "'.$kas_city.'"; var st_zip = "'.$kas_zip.'"; var st_category = "'.$kas_category.'"; var st_rating = "'.$kas_rating.'";';
		
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

<script type="text/javascript">
jQuery( function() {
    jQuery( "#slider-range" ).slider({
      range: true,
      min: 0,
      max: <?php echo esc_attr(get_option('kas-products-maxprice'));?>,
      values: [ <?php echo $kas_range_min; ?>, <?php echo $kas_range_max;?> ],
      slide: function( event, ui ) {
        jQuery( "#amount" ).val(  ui.values[ 0 ] + "-" + ui.values[ 1 ] );
      }
    });
    jQuery( "#amount" ).val( jQuery( "#slider-range" ).slider( "values", 0 ) +
      "-" + jQuery( "#slider-range" ).slider( "values", 1 ) );
	
  } );
</script>
		
		<form id="kas_search" method="get" class="<?php echo $css_main_form; ?> kas_center kas_search 33" action="<?php echo get_option('kas-result-pagelink'); ?>">
       
		<?php 

			$url = get_stylesheet_directory_uri().'/country.json';
  			$str = file_get_contents($url);
  			$country_array = json_decode($str, true);

		if (get_option('kas-show-country') == 1){?>
		<div class="<?php echo $css_form_group;?> "><select id="kas_country" name="kas_country"
			class="<?php echo $css_select_class;?> kas_country">
			<option value=""><?php _e('Choose a country you want to buy from', $this->kas_filter);?></option>
			<?php
			foreach ($args['countries'] as $country) {

				$key = array_search($country, array_column($country_array, 'code'));
	
				if($kas_country == $country){
					echo '<option selected value="'.$country.'">'.$country_array[$key]['name'].'</option>';
				}else{
					echo '<option value="'.$country.'">'.$country_array[$key]['name'].'</option>';
				}
			}
			?>
		</select></div>
		<?php }?> 
		<?php if (get_option('kas-show-state') == 1){?>
		<div class="<?php echo $css_form_group;?>"><select id="kas_state" name="kas_state"
			class="<?php echo $css_select_class;?> kas_state">
			<option value=""><?php _e('State', $this->kas_filter);?></option>
			<?php
			foreach ($args['states'] as $state) {
				
				if($state){
				
					if($kas_state == $state){
						echo '<option selected value="'.$state.'">'.$state.'</option>';
					}else{
						echo '<option value="'.$state.'">'.$state.'</option>';
					}
				}
			}
			?>
		
		</select></div>
		<?php }?> 
		<?php if (get_option('kas-show-city') == 1){?>
		<div class="<?php echo $css_form_group;?>"><select id="kas_city" name="kas_city"
			class="<?php echo $css_select_class;?> kas_city">
			<option value=""><?php _e('City', $this->kas_filter);?></option>
			<?php
			foreach ($args['cities'] as $city) {
				if($city){
					if($kas_city == $city){
						echo '<option selected value="'.$city.'">'.$city.'</option>';
					}else{
						echo '<option value="'.$city.'">'.$city.'</option>';
					}
				}
			}
			?>
		
		</select></div>
		<?php }?>
		
		<?php if (get_option('kas-show-zip') == 1){?>
		<div class="<?php echo $css_form_group;?>"><select id="kas_zip" name="kas_zip"
			class="<?php echo $css_select_class;?> kas_zip">
			<option value=""><?php _e('Zip Code', $this->kas_filter);?></option>
			<?php
			foreach ($args['zips'] as $zip) {
				if($zip){
					if($kas_zip == $zip){
						echo '<option selected value="'.$zip.'">'.$zip.'</option>';
					}else{
						echo '<option value="'.$zip.'">'.$zip.'</option>';
					}
				}
			}
			?>
		
		</select></div>
		<?php }?>
		
		<?php if (get_option('kas-show-category') == 1){?>
		<div class="<?php echo $css_form_group; ?>"><select id="kas_category" name="kas_category"
			class="<?php echo $css_select_class; ?> kas_category">
			<option value=""><?php _e('Vendor Category..', $this->kas_filter);?></option>
			<?php
			foreach ($args['categories'] as $category) {
				if($kas_category == $category){
					echo '<option selected value="'.$category.'">'.$category.'</option>';
				}else{
					echo '<option value="'.$category.'">'.$category.'</option>';
				}
			}
			?>
		</select></div>
		<?php }?>
		
		<?php if (get_option('kas-show-frating') == 1){?>
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
		
		<?php if (get_option('kas-show-searchtype') == 1){?>
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
			<?php if (empty($query_type) || $query_type == 'products'){?>	
				<div class="<?php echo $css_form_group;?>" style="margin-bottom: 2px !important;">
					
						<span class="kas_price_range"  id="kas_price_range" style="display: <?php echo $range_display;?>">
						  <label for="amount"><?php _e('Price range : ' . get_woocommerce_currency_symbol(), $this->kas_filter);?></label>
						  <input name="kas_range" type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold; padding: 0 !important;">
						</span>
						 
						<div id="slider-range" style="display: <?php echo $range_display;?>"></div>	
						
				</div>
			<?php }?>
		<?php }?>

		
		<?php if (get_option('kas-show-store') == 1 && get_option('kas-show-searchtype') != 1){?>
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
		

		
		<button type="submit" class="<?php echo $btn_css; ?>"><?php _e('Search stores', $this->kas_filter);?></button>
		
		</form>
		<div class="kas_loader">
			<div class="bounce1"></div>
  			<div class="bounce2"></div>
  			<div class="bounce3"></div>
  		</div>
