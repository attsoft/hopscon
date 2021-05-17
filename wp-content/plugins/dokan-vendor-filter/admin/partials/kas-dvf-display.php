<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://ideas.echopointer.com
 * @since      1.0.0
 *
 * @package    Kas_Dokan_Vendor_Filter
 * @subpackage Kas_Dokan_Vendor_Filter/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">

<h2><?php _e('Dokan Vendor Filter ' . $this->version , $this->kas_filter);?></h2>
<?php
settings_errors();
if( isset( $_GET[ 'tab' ] ) ) {
	$active_tab = $_GET[ 'tab' ];
}else{
	$active_tab = 'general';
} // end if
?>

<h2 class="nav-tab-wrapper"><a
	href="?page=<?php echo $this->kas_filter;?>&tab=general"
	class="nav-tab <?php echo $active_tab == 'general' ? 'nav-tab-active' : ''; ?>">General</a>
<a href="?page=<?php echo $this->kas_filter;?>&tab=forms"
	class="nav-tab <?php echo $active_tab == 'forms' ? 'nav-tab-active' : ''; ?>">Forms</a>
<a href="?page=<?php echo $this->kas_filter;?>&tab=scripts"
	class="nav-tab <?php echo $active_tab == 'scripts' ? 'nav-tab-active' : ''; ?>">Scripts</a>
</h2>
<form method="post" action="options.php" method="post">

<table class="form-table">

	<!--  General settings start -->
<?php if( $active_tab == 'general' ){?>
<?php settings_fields($this->kas_filter.'-general'); ?>
<?php do_settings_sections($this->kas_filter.'-general'); ?>
	<tr valign="top">
		<td colspan="2">
		<h2><?php _e('ShortCodes & Description', $this->kas_filter);?></h2>
		<h4>[kas_dokan_vendor_filter]</h4>
		<p><?php _e('Above ShortCode is to show Filter form on any page you want.', $this->kas_filter);?></p>
		<h4>[kas_dokan_vendor_filter_aio]</h4>
		<p><?php _e('Above ShortCode is to show Filter All-In-One Filed form on any page you want.', $this->kas_filter);?></p>
		<h4>[kas_dokan_vendor_filter_results]</h4>
		<p><?php _e('Above ShortCode is to show all the results, results page already get generated once you install this plugin in case to show results on new page you also need to change results link in below field to the page where you using this ShortCode, or you can add this shortcode to show all vendors on any page any place on your website set map if you want to show all vendors on Google Map.', $this->kas_filter);?></p>
		<strong><?php _e('Result Page Link: ', $this->kas_filter);?></strong><input
			style="width: 300px;" type="text" name="kas-result-pagelink"
			value="<?php echo esc_attr( get_option('kas-result-pagelink') ); ?>" />

		</td>
	</tr>
	<?php }?>
	<!--  General settings end -->

	<!-- Forms Settings start -->
	<?php if( $active_tab == 'forms' ){?>
	<?php settings_fields($this->kas_filter.'-forms'); ?>
	<?php do_settings_sections($this->kas_filter.'-forms'); ?>
	<tr valign="top">
		<td colspan="2">
		<h2><?php _e('Saperate Fields form settings', $this->kas_filter);?></h2>
		<p>Use this <strong>[kas_dokan_vendor_filter]</strong> Shortcode for
		Saperate Fields form on any page.</p>
		</td>
	</tr>
	<!-- Full filter fields start -->
	<tr valign="top">

		<th scope="row"><?php _e('Enable/Disable Fields', $this->kas_filter);?></th>


		<td>
		<table class="form-table">
			<tr valign="top">
				<td><strong><?php _e('Show Country: ', $this->kas_filter);?></strong>&nbsp;&nbsp;
				<label class="radio-inline"> <input type="radio"
					name="kas-show-country" id="kas-show-country" value="1"
					<?php echo esc_attr( get_option('kas-show-country') ) == 1 ? 'checked="checked"' : '' ?>>
				Yes </label> <label class="radio-inline"> <input type="radio"
					name="kas-show-country" id="kas-show-country" value="0"
					<?php echo esc_attr( get_option('kas-show-country') ) == 0 ? 'checked="checked"' : '' ?>>
				No </label></td>


				<td><strong><?php _e('Show State: ', $this->kas_filter);?></strong>&nbsp;&nbsp;
				<label class="radio-inline"> <input type="radio"
					name="kas-show-state" id="kas-show-state" value="1"
					<?php echo esc_attr( get_option('kas-show-state') ) == 1 ? 'checked="checked"' : '' ?>>
				Yes </label> <label class="radio-inline"> <input type="radio"
					name="kas-show-state" id="kas-show-state" value="0"
					<?php echo esc_attr( get_option('kas-show-state') ) == 0 ? 'checked="checked"' : '' ?>>
				No </label></td>

			</tr>


			<tr valign="top">

				<td><strong><?php _e('Show City: ', $this->kas_filter);?></strong>&nbsp;&nbsp;
				<label class="radio-inline"> <input type="radio"
					name="kas-show-city" id="kas-show-city" value="1"
					<?php echo esc_attr( get_option('kas-show-city') ) == 1 ? 'checked="checked"' : '' ?>>
				Yes </label> <label class="radio-inline"> <input type="radio"
					name="kas-show-city" id="kas-show-city" value="0"
					<?php echo esc_attr( get_option('kas-show-city') ) == 0 ? 'checked="checked"' : '' ?>>
				No </label></td>


				<td><strong><?php _e('Show Stores: ', $this->kas_filter);?></strong>&nbsp;&nbsp;
				<label class="radio-inline"> <input type="radio"
					name="kas-show-store" id="kas-show-store" value="1"
					<?php echo esc_attr( get_option('kas-show-store') ) == 1 ? 'checked="checked"' : '' ?>>
				Yes </label> <label class="radio-inline"> <input type="radio"
					name="kas-show-store" id="kas-show-store" value="0"
					<?php echo esc_attr( get_option('kas-show-store') ) == 0 ? 'checked="checked"' : '' ?>>
				No </label></td>

			</tr>	
				
				
				<tr valign="top">
					
					<td>
					<strong><?php _e('Show ZIP Code: ', $this->kas_filter);?></strong>&nbsp;&nbsp;
					<label class="radio-inline"> <input type="radio"
						name="kas-show-zip" id="kas-show-zip" value="1"
						<?php echo esc_attr( get_option('kas-show-zip') ) == 1 ? 'checked="checked"' : '' ?>>
					Yes </label> <label class="radio-inline"> <input type="radio"
						name="kas-show-zip" id="kas-show-zip" value="0"
						<?php echo esc_attr( get_option('kas-show-zip') ) == 0 ? 'checked="checked"' : '' ?>>
					No </label></td>
					
					
					<td><strong><?php _e('Show Categories: ', $this->kas_filter);?></strong>&nbsp;&nbsp;
					<label class="radio-inline"> <input type="radio"
						name="kas-show-category" id="kas-show-category" value="1"
						<?php echo esc_attr( get_option('kas-show-category') ) == 1 ? 'checked="checked"' : '' ?>>
					Yes </label> <label class="radio-inline"> <input type="radio"
						name="kas-show-category" id="kas-show-category" value="0"
						<?php echo esc_attr( get_option('kas-show-category') ) == 0 ? 'checked="checked"' : '' ?>>
					No </label></td>		
					
				</tr>	
				
				
				<tr valign="top">
					
					
					<td><strong><?php _e('Show Search Type: ', $this->kas_filter);?></strong>&nbsp;&nbsp;
					<label class="radio-inline"> <input type="radio"
						name="kas-show-searchtype" id="kas-show-searchtype" value="1"
						<?php echo esc_attr( get_option('kas-show-searchtype') ) == 1 ? 'checked="checked"' : '' ?>>
					Yes </label> <label class="radio-inline"> <input type="radio"
						name="kas-show-searchtype" id="kas-show-searchtype" value="0"
						<?php echo esc_attr( get_option('kas-show-searchtype') ) == 0 ? 'checked="checked"' : '' ?>>
					No </label></td>
					
					<td><strong><?php _e('Show Rating: ', $this->kas_filter);?></strong>&nbsp;&nbsp;
					<label class="radio-inline"> <input type="radio"
						name="kas-show-frating" id="kas-show-frating" value="1"
						<?php echo esc_attr( get_option('kas-show-frating') ) == 1 ? 'checked="checked"' : '' ?>>
					Yes </label> <label class="radio-inline"> <input type="radio"
						name="kas-show-frating" id="kas-show-frating" value="0"
						<?php echo esc_attr( get_option('kas-show-frating') ) == 0 ? 'checked="checked"' : '' ?>>
					No </label>
					<p><?php _e('Only works with Dokan Pro', $this->kas_filter);?></p>
					</td>		
					
				</tr>



		</table>
		</td>

		<td>&nbsp;</td>

	</tr>
	
	<tr valign="top">
		<td colspan="2">
		<h2><?php _e('Widget Fields form settings', $this->kas_filter);?></h2>
		</td>
	</tr>
	
	<!-- widget filter fields start -->
	<tr valign="top">

		<th scope="row"><?php _e('Enable/Disable Fields', $this->kas_filter);?></th>


		<td>
		<table class="form-table">
			<tr valign="top">
				<td><strong><?php _e('Show Country: ', $this->kas_filter);?></strong>&nbsp;&nbsp;
				<label class="radio-inline"> <input type="radio"
					name="kas-show-country-w" id="kas-show-country-w" value="1"
					<?php echo esc_attr( get_option('kas-show-country-w') ) == 1 ? 'checked="checked"' : '' ?>>
				Yes </label> <label class="radio-inline"> <input type="radio"
					name="kas-show-country-w" id="kas-show-country-w" value="0"
					<?php echo esc_attr( get_option('kas-show-country-w') ) == 0 ? 'checked="checked"' : '' ?>>
				No </label></td>


				<td><strong><?php _e('Show State: ', $this->kas_filter);?></strong>&nbsp;&nbsp;
				<label class="radio-inline"> <input type="radio"
					name="kas-show-state-w" id="kas-show-state-w" value="1"
					<?php echo esc_attr( get_option('kas-show-state-w') ) == 1 ? 'checked="checked"' : '' ?>>
				Yes </label> <label class="radio-inline"> <input type="radio"
					name="kas-show-state-w" id="kas-show-state-w" value="0"
					<?php echo esc_attr( get_option('kas-show-state-w') ) == 0 ? 'checked="checked"' : '' ?>>
				No </label></td>

			</tr>


			<tr valign="top">

				<td><strong><?php _e('Show City: ', $this->kas_filter);?></strong>&nbsp;&nbsp;
				<label class="radio-inline"> <input type="radio"
					name="kas-show-city-w" id="kas-show-city-w" value="1"
					<?php echo esc_attr( get_option('kas-show-city-w') ) == 1 ? 'checked="checked"' : '' ?>>
				Yes </label> <label class="radio-inline"> <input type="radio"
					name="kas-show-city-w" id="kas-show-city-w" value="0"
					<?php echo esc_attr( get_option('kas-show-city-w') ) == 0 ? 'checked="checked"' : '' ?>>
				No </label></td>


				<td><strong><?php _e('Show Stores: ', $this->kas_filter);?></strong>&nbsp;&nbsp;
				<label class="radio-inline"> <input type="radio"
					name="kas-show-store-w" id="kas-show-store-w" value="1"
					<?php echo esc_attr( get_option('kas-show-store-w') ) == 1 ? 'checked="checked"' : '' ?>>
				Yes </label> <label class="radio-inline"> <input type="radio"
					name="kas-show-store-w" id="kas-show-store-w" value="0"
					<?php echo esc_attr( get_option('kas-show-store-w') ) == 0 ? 'checked="checked"' : '' ?>>
				No </label></td>

			</tr>	
				
				
				<tr valign="top">
					
					<td>
					<strong><?php _e('Show ZIP Code: ', $this->kas_filter);?></strong>&nbsp;&nbsp;
					<label class="radio-inline"> <input type="radio"
						name="kas-show-zip-w" id="kas-show-zip-w" value="1"
						<?php echo esc_attr( get_option('kas-show-zip-w') ) == 1 ? 'checked="checked"' : '' ?>>
					Yes </label> <label class="radio-inline"> <input type="radio"
						name="kas-show-zip-w" id="kas-show-zip-w" value="0"
						<?php echo esc_attr( get_option('kas-show-zip-w') ) == 0 ? 'checked="checked"' : '' ?>>
					No </label></td>
					
					
					<td><strong><?php _e('Show Categories: ', $this->kas_filter);?></strong>&nbsp;&nbsp;
					<label class="radio-inline"> <input type="radio"
						name="kas-show-category-w" id="kas-show-category-w" value="1"
						<?php echo esc_attr( get_option('kas-show-category-w') ) == 1 ? 'checked="checked"' : '' ?>>
					Yes </label> <label class="radio-inline"> <input type="radio"
						name="kas-show-category-w" id="kas-show-category-w" value="0"
						<?php echo esc_attr( get_option('kas-show-category-w') ) == 0 ? 'checked="checked"' : '' ?>>
					No </label></td>		
					
				</tr>
				
				
				<tr valign="top">
					
					
					<td><strong><?php _e('Show Search Type: ', $this->kas_filter);?></strong>&nbsp;&nbsp;
					<label class="radio-inline"> <input type="radio"
						name="kas-show-searchtype-w" id="kas-show-searchtype-w" value="1"
						<?php echo esc_attr( get_option('kas-show-searchtype-w') ) == 1 ? 'checked="checked"' : '' ?>>
					Yes </label> <label class="radio-inline"> <input type="radio"
						name="kas-show-searchtype-w" id="kas-show-searchtype-w" value="0"
						<?php echo esc_attr( get_option('kas-show-searchtype-w') ) == 0 ? 'checked="checked"' : '' ?>>
					No </label></td>
					
					<td><strong><?php _e('Show Rating: ', $this->kas_filter);?></strong>&nbsp;&nbsp;
					<label class="radio-inline"> <input type="radio"
						name="kas-show-frating-w" id="kas-show-frating-w" value="1"
						<?php echo esc_attr( get_option('kas-show-frating-w') ) == 1 ? 'checked="checked"' : '' ?>>
					Yes </label> <label class="radio-inline"> <input type="radio"
						name="kas-show-frating-w" id="kas-show-frating-w" value="0"
						<?php echo esc_attr( get_option('kas-show-frating-w') ) == 0 ? 'checked="checked"' : '' ?>>
					No </label>
					<p><?php _e('Only works with Dokan Pro', $this->kas_filter);?></p>
					</td>		
					
				</tr>	



		</table>
		</td>

		<td>&nbsp;</td>

	</tr>	
	
	

	<!-- single filter start -->
	<tr valign="top">
		<td colspan="2">
		<h2><?php _e('All-In-One Field form settings', $this->kas_filter);?></h2>
		<p>Use this <strong>[kas_dokan_vendor_filter_aio]</strong> Shortcode
		for single field form on any page.</p>
		</td>
	</tr>

	<tr valign="top">

		<th scope="row"><?php _e('Enable/Disable Fields', $this->kas_filter);?></th>


		<td>
		<table class="form-table">
			<tr valign="top">
				<td><strong><?php _e('Show Country: ', $this->kas_filter);?></strong>&nbsp;&nbsp;
				<label class="radio-inline"> <input type="radio"
					name="kas-show-country-s" id="kas-show-country-s" value="1"
					<?php echo esc_attr( get_option('kas-show-country-s') ) == 1 ? 'checked="checked"' : '' ?>>
				Yes </label> <label class="radio-inline"> <input type="radio"
					name="kas-show-country-s" id="kas-show-country-s" value="0"
					<?php echo esc_attr( get_option('kas-show-country-s') ) == 0 ? 'checked="checked"' : '' ?>>
				No </label></td>


				<td><strong><?php _e('Show State: ', $this->kas_filter);?></strong>&nbsp;&nbsp;
				<label class="radio-inline"> <input type="radio"
					name="kas-show-state-s" id="kas-show-state-s" value="1"
					<?php echo esc_attr( get_option('kas-show-state') ) == 1 ? 'checked="checked"' : '' ?>>
				Yes </label> <label class="radio-inline"> <input type="radio"
					name="kas-show-state-s" id="kas-show-state-s" value="0"
					<?php echo esc_attr( get_option('kas-show-state-s') ) == 0 ? 'checked="checked"' : '' ?>>
				No </label></td>

			</tr>


			<tr valign="top">

				<td><strong><?php _e('Show City: ', $this->kas_filter);?></strong>&nbsp;&nbsp;
				<label class="radio-inline"> <input type="radio"
					name="kas-show-city-s" id="kas-show-city-s" value="1"
					<?php echo esc_attr( get_option('kas-show-city') ) == 1 ? 'checked="checked"' : '' ?>>
				Yes </label> <label class="radio-inline"> <input type="radio"
					name="kas-show-city-s" id="kas-show-city-s" value="0"
					<?php echo esc_attr( get_option('kas-show-city-s') ) == 0 ? 'checked="checked"' : '' ?>>
				No </label></td>


				<td><strong><?php _e('Show Stores: ', $this->kas_filter);?></strong>&nbsp;&nbsp;
				<label class="radio-inline"> <input type="radio"
					name="kas-show-store-s" id="kas-show-store-s" value="1"
					<?php echo esc_attr( get_option('kas-show-store-s') ) == 1 ? 'checked="checked"' : '' ?>>
				Yes </label> <label class="radio-inline"> <input type="radio"
					name="kas-show-store-s" id="kas-show-store-s" value="0"
					<?php echo esc_attr( get_option('kas-show-store-s') ) == 0 ? 'checked="checked"' : '' ?>>
				No </label></td>

			</tr>	
				
				
				<tr valign="top">
					
					<td>
					<strong><?php _e('Show ZIP Code: ', $this->kas_filter);?></strong>&nbsp;&nbsp;
					<label class="radio-inline"> <input type="radio"
						name="kas-show-zip-s" id="kas-show-zip-s" value="1"
						<?php echo esc_attr( get_option('kas-show-zip-s') ) == 1 ? 'checked="checked"' : '' ?>>
					Yes </label> <label class="radio-inline"> <input type="radio"
						name="kas-show-zip-s" id="kas-show-zip-s" value="0"
						<?php echo esc_attr( get_option('kas-show-zip-s') ) == 0 ? 'checked="checked"' : '' ?>>
					No </label></td>
					
					
					<td>&nbsp;</td>		
					
				</tr>	


		</table>
		</td>

		<td>&nbsp;</td>

	</tr>
	<?php }?>
	<!-- single filter end -->
	<!-- Form settings end -->



	<!-- scripts Settings start -->
	<?php if( $active_tab == 'scripts' ){?>
	<?php settings_fields($this->kas_filter.'-scripts'); ?>
	<?php do_settings_sections($this->kas_filter.'-scripts'); ?>
	<tr valign="top">
		<td colspan="2">
		<h2><?php _e('Scripts & Other settings', $this->kas_filter);?></h2>
		</td>
	</tr>
	<tr valign="top">

		<th scope="row"><?php _e('Enable/Disable', $this->kas_filter);?></th>


		<td>
		<table class="form-table">
			<tr valign="top">


				<td><strong><?php _e('Bootstrap: ', $this->kas_filter);?></strong>&nbsp;&nbsp;
				<label class="radio-inline"> <input type="radio"
					name="kas-enable-bootstrap" id="kas-enable-bootstrap" value="1"
					<?php echo esc_attr( get_option('kas-enable-bootstrap') ) == 1 ? 'checked="checked"' : '' ?>>
				Yes </label> <label class="radio-inline"> <input type="radio"
					name="kas-enable-bootstrap" id="kas-enable-bootstrap" value="0"
					<?php echo esc_attr( get_option('kas-enable-bootstrap') ) == 0 ? 'checked="checked"' : '' ?>>
				No </label><br>
				<p><?php _e('Enable only if your theme have bootstrap already!', $this->kas_filter);?></p>
				</td>



				<td><strong><?php _e('Select2: ', $this->kas_filter);?></strong>&nbsp;&nbsp;
				<label class="radio-inline"> <input type="radio"
					name="kas-enable-select2" id="kas-enable-select2" value="1"
					<?php echo esc_attr( get_option('kas-enable-select2') ) == 1 ? 'checked="checked"' : '' ?>>
				Classic&nbsp;&nbsp;</label> <label class="radio-inline"> <input
					type="radio" name="kas-enable-select2" id="kas-enable-select2"
					value="2"
					<?php echo esc_attr( get_option('kas-enable-select2') ) == 2 ? 'checked="checked"' : '' ?>>
				Bootstrap&nbsp;&nbsp;</label> <label class="radio-inline"> <input
					type="radio" name="kas-enable-select2" id="kas-enable-select2"
					value="3"
					<?php echo esc_attr( get_option('kas-enable-select2') ) == 3 ? 'checked="checked"' : '' ?>>
				Custom</label> <label class="radio-inline"> <input type="radio"
					name="kas-enable-select2" id="kas-enable-select2" value="0"
					<?php echo esc_attr( get_option('kas-enable-select2') ) == 0 ? 'checked="checked"' : '' ?>>
				None</label><br>
				<p><?php _e('IF your Theme or Plugin already has Select2 and conflict select "none"', $this->kas_filter);?></p>
				</td>

			</tr>
			<tr valign="top">


				<td><strong><?php _e('Show Ratting: ', $this->kas_filter);?></strong>&nbsp;&nbsp;
				<label class="radio-inline"> <input type="radio"
					name="kas-show-ratting" id="kas-show-ratting" value="1"
					<?php echo esc_attr( get_option('kas-show-ratting') ) == 1 ? 'checked="checked"' : '' ?>>
				Yes </label> <label class="radio-inline"> <input type="radio"
					name="kas-show-ratting" id="kas-show-ratting" value="0"
					<?php echo esc_attr( get_option('kas-show-ratting') ) == 0 ? 'checked="checked"' : '' ?>>
				No </label><br>
				<p><?php _e('If you want to Show Ratting count Next to Store Name check above radio to YES.', $this->kas_filter);?></p>
				</td>



				<td><strong><?php _e('Map View: ', $this->kas_filter);?></strong>&nbsp;&nbsp;
				<label class="radio-inline"> <input type="radio"
					name="kas-show-mapview" id="kas-show-mapview" value="1"
					<?php echo esc_attr( get_option('kas-show-mapview') ) == 1 ? 'checked="checked"' : '' ?>>
				Map Only </label> <label class="radio-inline"> <input type="radio"
					name="kas-show-mapview" id="kas-show-mapview" value="2"
					<?php echo esc_attr( get_option('kas-show-mapview') ) == 2 ? 'checked="checked"' : '' ?>>
				Both </label> <label class="radio-inline"> <input type="radio"
					name="kas-show-mapview" id="kas-show-mapview" value="0"
					<?php echo esc_attr( get_option('kas-show-mapview') ) == 0 ? 'checked="checked"' : '' ?>>
				No </label><br>
				<p><?php _e('If you want to show results on Google Map.', $this->kas_filter);?></p>
				</td>

			</tr>


			<tr valign="top">


				<td><strong><?php _e('Google Map Zoom: ', $this->kas_filter);?></strong><input
					type="text" name="kas-map-zoom"
					value="<?php echo esc_attr( get_option('kas-map-zoom') ); ?>" /><br>
				<p><?php _e('Set numeric value only best fit is 12.', $this->kas_filter);?></p>
				</td>



				<td><strong><?php _e('Google Map Height: ', $this->kas_filter);?></strong><input
					type="text" name="kas-map-height"
					value="<?php echo esc_attr( get_option('kas-map-height') ); ?>" />px<br>
				<p><?php _e('Set numeric value only px already set example: "400".', $this->kas_filter);?></p>
				</td>

			</tr>


			<tr valign="top">


				<td><strong><?php _e('Products Per Page: ', $this->kas_filter);?></strong><input
					type="text" name="kas-products-perpage"
					value="<?php echo esc_attr( get_option('kas-products-perpage') ); ?>" /><br>
				<p><?php _e('Set numeric value only best fit is 10.', $this->kas_filter);?></p>
				</td>



				<td><strong><?php _e('Maximum Price: ', $this->kas_filter);?></strong><input
					type="text" name="kas-products-maxprice"
					value="<?php echo esc_attr( get_option('kas-products-maxprice') ); ?>" /><br>
				<p><?php _e('Set numeric value only.', $this->kas_filter);?></p>
				</td>

			</tr>

		</table>
		</td>

		<td>&nbsp;</td>

	</tr>
	<?php }?>
	<!-- scripts Settings start -->

</table>

	<?php submit_button('Save all changes', 'primary','submit', TRUE); ?></form>

</div>
