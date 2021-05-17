<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Mwb_Woocommerce_Multiple_Shipping_Address
 * @subpackage Mwb_Woocommerce_Multiple_Shipping_Address/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Mwb_Woocommerce_Multiple_Shipping_Address
 * @subpackage Mwb_Woocommerce_Multiple_Shipping_Address/public
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Mwb_Woocommerce_Multiple_Shipping_Address_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		include_once WP_CONTENT_DIR.'/plugins/woocommerce/includes/class-wc-checkout.php';
		include_once WP_CONTENT_DIR.'/plugins/woocommerce/includes/class-wc-validation.php';

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, MWB_WOOCOMMERCE_MULTIPLE_SHIPPING_ADDRESS_DIR_URL . 'public/css/mwb-woocommerce-multiple-shipping-address-public.css', array(), $this->version, 'all' );
		wp_enqueue_style('select2');

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_register_script( $this->plugin_name, MWB_WOOCOMMERCE_MULTIPLE_SHIPPING_ADDRESS_DIR_URL . 'public/js/
			mwb-woocommerce-multiple-shipping-address-public.js', array( 'jquery','select2' ), $this->version, false );
		wp_localize_script($this->plugin_name,'mwb_woo_msa_param',array('ajax_url' => admin_url('admin-ajax.php'),'toggle_button_value' => __('Hide Saved Shipping Addresses','mwb-woocommerce-multiple-shipping-address'),'toggle_show' => __('Show Saved Shipping Addresses','mwb-woocommerce-multiple-shipping-address'),'edit_button'=> __('Edit','mwb-woocommerce-multiple-shipping-address'),'updated_button' => __('Update','mwb-woocommerce-multiple-shipping-address'),'validation_msg' => __('Field is Required','mwb-woocommerce-multiple-shipping-address')),$this->version,false);
		wp_enqueue_script($this->plugin_name);

	}


	/**
	 * Function For Displaying the address form and save data for both logged in as well as guest users on cart page.
	 *
	 * @since    1.0.0
	 */
	public function mwb_woo_msa_add_address_section(){

		global $current_user;
		$mwb_woo_msa_user_save_addresses = array();
		$mwb_woo_msa_general_settings = get_option('mwb_woocommerce_multiple_shipping_address_enable_plugin');

		$MwbWooMsaObject = new WC_Checkout();

		$user_id = $current_user->ID;

		if(isset($_POST['mwb_woo_msa_user_data_submit'])){
		
			if(wp_verify_nonce($_REQUEST['mwb_woo_msa_nonce'],'mwb-woo-msa-guest-nonce')){

				$MwbWooMsaUserAddess  = $_POST['mwb_woo_msa_user_address'];
				$MwbWooMsaUserAddess2 = $_POST['mwb_woo_msa_user_address2'];
				$MwbWooMsaUserTown    = $_POST['mwb_woo_msa_user_town'];
				$MwbWooMsaUserCountry = $_POST['billing_country'];
				$MwbWooMsaUserState   = $_POST['billing_state'];
				$MwbWooMsaUserPostal  = $_POST['billing_postcode'];

				$MwbWooMsaPostValidateObject = WC_Validation::is_postcode($MwbWooMsaUserPostal,$MwbWooMsaUserCountry);

				if( $MwbWooMsaPostValidateObject )
				{

					$mwb_woo_msa_user_save_addresses = get_user_meta($user_id,'mwb_woo_multiple_shipping_addr_saved',true);
					$mwb_woo_msa_user_save_addresses = json_decode($mwb_woo_msa_user_save_addresses,true);

					if(is_array($mwb_woo_msa_user_save_addresses) && !empty($mwb_woo_msa_user_save_addresses)){
						$flag = true;
						$mwb_woo_msa_user_address_data = array(
							'address1'  =>  $MwbWooMsaUserAddess,
							'address2'  =>  $MwbWooMsaUserAddess2,
							'town'      =>  $MwbWooMsaUserTown,
							'country'   =>  $MwbWooMsaUserCountry,
							'state'     =>  $MwbWooMsaUserState,
							'zip'       =>  $MwbWooMsaUserPostal,
							);
						foreach ($mwb_woo_msa_user_save_addresses as $addrkey => $addrvalue) {
							if($addrvalue == $mwb_woo_msa_user_address_data){
								$flag = false;
							}
						}

						if($flag){

							array_push($mwb_woo_msa_user_save_addresses, $mwb_woo_msa_user_address_data);
							$mwb_woo_msa_user_save_addresses = json_encode($mwb_woo_msa_user_save_addresses);
							update_user_meta($user_id,'mwb_woo_multiple_shipping_addr_saved',$mwb_woo_msa_user_save_addresses);
							$success 	=  __( 'Your Address has been added', 'mwb-woocommerce-multiple-shipping-address' );
							?>
							<div class="woocommerce-message" role="alert">
								<?php echo $success; ?>
							</div>
							<?php
						}
						else{
							$success_msg = __('Address Already Exists','mwb-woocommerce-multiple-shipping-address');
							?>
							<div class="woocommerce-error" role="alert">
								<?php echo $success_msg; ?>
							</div>
							<?php
						}
					}
					else{
						$mwb_woo_msa_user_address_data[] = array(
							'address1'  =>  $MwbWooMsaUserAddess,
							'address2'  =>  $MwbWooMsaUserAddess2,
							'town'      =>  $MwbWooMsaUserTown,
							'country'   =>  $MwbWooMsaUserCountry,
							'state'     =>  $MwbWooMsaUserState,
							'zip'       =>  $MwbWooMsaUserPostal,
							);

						$mwb_woo_msa_user_address_data = json_encode($mwb_woo_msa_user_address_data);
						update_user_meta($user_id,'mwb_woo_multiple_shipping_addr_saved',$mwb_woo_msa_user_address_data);
						$success 	=  __( 'Your Address has been added', 'mwb-woocommerce-multiple-shipping-address' );
						?>
						<div class="woocommerce-message" role="alert">
							<?php echo $success; ?>
						</div>
						<?php
					}
				}
				else
				{
					$error 	=  __( 'Please Enter valid Zip Code', 'mwb-woocommerce-multiple-shipping-address' );
					?>
					<div class="woocommerce-error" role="alert">
						<?php echo $error; ?>
					</div>
					<?php
				}
			}
		}
		if(is_user_logged_in()){
			?>
			<div class="woocommerce-info">
				<span><?php _e('Want To Ship Your Item To Different Addresses, Click On " Add Different Shipping Address" Button','mwb-woocommerce-multiple-shipping-address'); ?></span>
			</div>
			<input type="button" name="mwb_woo_msa_open_modal_button" class="mwb_woo_msa_open_modal_button button alt" value="<?php _e('Add Different Shipping Address','mwb-woocommerce-multiple-shipping-address'); ?>">	
			<?php
		}
		elseif(isset($mwb_woo_msa_general_settings['guest_users']) && $mwb_woo_msa_general_settings['guest_users'] == 'on' ){
			?>
			<div class="woocommerce-info">
				<span><?php _e('Want To Ship Your Item To Different Addresses, Click On " Add Different Shipping Address" Button','mwb-woocommerce-multiple-shipping-address'); ?></span>
			</div>
			<input type="button" name="mwb_woo_msa_open_modal_button" class="mwb_woo_msa_open_modal_button button alt" value="<?php _e('Add Different Shipping Address','mwb-woocommerce-multiple-shipping-address'); ?>">	
			<?php
		}	

		if(is_user_logged_in()){
			?>
			<div class="mwb_woo_multiple_shipping_address" id="mwb_woo_msa_hide_popup">
				<div class="mwb_woo_msa_enable_multiple_shipping">
					<div id="mwb_woo_msa_enable_multiple_shipping_checkbox_wrapper">
						<div class="mwb_woo_msa_close_modal">&times;</div>
						<div class="mwb_woo_msa_user_address_form">
							<form action="" method="POST" class="mwb_woo_msa_address_form">
								<div class="woocommerce-billing-fields__field-wrapper" id="mwb_woo_msa_address_fields">
									<label><?php _e('Address','mwb-woocommerce-multiple-shipping-address'); ?></label>
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
		elseif(isset($mwb_woo_msa_general_settings['guest_users']) && $mwb_woo_msa_general_settings['guest_users'] == 'on' ){
			?>
			<div class="mwb_woo_multiple_shipping_address" id="mwb_woo_msa_hide_popup">
				<div class="mwb_woo_msa_enable_multiple_shipping">
					<div id="mwb_woo_msa_enable_multiple_shipping_checkbox_wrapper">
						<div class="mwb_woo_msa_close_modal">&times;</div>
						<div class="mwb_woo_msa_user_address_form">
							<div class="woocommerce-billing-fields__field-wrapper" id="mwb_woo_msa_address_fields">
								<label><?php _e('Address','mwb-woocommerce-multiple-shipping-address'); ?></label>
								<input type="text" name="mwb_woo_msa_guest_user_address" id="mwb_woo_msa_guest_user_address" value="" placeholder="<?php _e('Enter Address','mwb-woocommerce-multiple-shipping-address'); ?>">
								<input type="text" name="mwb_woo_msa_guest_user_address2" id="mwb_woo_msa_guest_user_address2" value="" placeholder="<?php _e('Enter Street Address ','mwb-woocommerce-multiple-shipping-address'); ?>">
							</div>

							<div class="woocommerce-billing-fields__field-wrapper" id="mwb_woo_msa_town_city_fields">
								<label><?php _e('Town/City','mwb-woocommerce-multiple-shipping-address'); ?></label>
								<input type="text" name="mwb_woo_msa_guest_user_town" id="mwb_woo_msa_guest_user_town" value="" placeholder="<?php _e('Enter Town/City Name','mwb-woocommerce-multiple-shipping-address'); ?>">
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

							<div class="woocommerce-billing-fields__field-wrapper" id="mwb_woo_msa_submit">
								<input type="button" name="mwb_woo_msa_guest_user_data_submit" id="mwb_woo_msa_guest_user_data_submit" value="<?php _e('Save Details','mwb-woocommerce-multiple-shipping-address'); ?>" class="button alt">
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
	}

	/**
	 * Function displaying table for logged-in and guest user saved address on cart page.
	 *
	 * @since    1.0.0
	*/
	public function mwb_woo_msa_saved_users_address(){
		
		global $current_user,$woocommerce;
		$user_id = $current_user->ID;
		$mwb_woo_msa_general_settings = get_option('mwb_woocommerce_multiple_shipping_address_enable_plugin');

		if(is_user_logged_in()){

			$mwb_woo_msa_user_save_addresses = get_user_meta($user_id,'mwb_woo_multiple_shipping_addr_saved',true);
			$mwb_woo_msa_user_save_addresses = json_decode($mwb_woo_msa_user_save_addresses,true);

			if(is_array($mwb_woo_msa_user_save_addresses) && !empty($mwb_woo_msa_user_save_addresses)){
				?>
				<input type="button" name="mwb_woocommerce_msa_saved_address" class="mwb_woocommerce_msa_saved_address button alt" value="<?php _e('Show Saved Shipping Addresses','mwb-woocommerce-multiple-shipping-address'); ?>">
				<div class="mwb_woo_msa_user_saved_address_wrapper">
					<table class="mwb_woo_msa_user_address_collection_wrapper shop_table">
						<thead>
							<th><?php _e('Address','mwb-woocommerce-multiple-shipping-address'); ?></th>
							<th><?php _e('Street Address','mwb-woocommerce-multiple-shipping-address'); ?></th>
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
		}
		elseif(isset($mwb_woo_msa_general_settings['guest_users']) && $mwb_woo_msa_general_settings['guest_users'] == 'on' && isset($_COOKIE['mwb_woo_msa_guest_user_addr'])){
			// print_r(unserialize(base64_decode($_COOKIE['mwb_woo_msa_guest_user_addr'])));die("-->hello");
			$mwb_woo_msa_user_save_addresses = unserialize(base64_decode($_COOKIE['mwb_woo_msa_guest_user_addr']));

			if(is_array($mwb_woo_msa_user_save_addresses) && !empty($mwb_woo_msa_user_save_addresses)){
				?>
				<input type="button" name="mwb_woocommerce_msa_saved_address" class="mwb_woocommerce_msa_saved_address button alt" value="<?php _e('Show Saved Shipping Addresses','mwb-woocommerce-multiple-shipping-address'); ?>">
				<div class="mwb_woo_msa_user_saved_address_wrapper">
					<table class="mwb_woo_msa_user_address_collection_wrapper shop_table">
						<thead>
							<th><?php _e('Address','mwb-woocommerce-multiple-shipping-address'); ?></th>
							<th><?php _e('Street Address','mwb-woocommerce-multiple-shipping-address'); ?></th>
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
									<td data-label="Action"><a href="javascript:;" data-edit_addr="<?php echo $saved_key; ?>" class="mwb_woo_msa_guest_edit_addr" data-selected_country="<?php echo $saved_value['country']; ?>" data-selected_state="<?php echo $saved_value['state']; ?>"><?php _e('Edit','mwb-woocommerce-multiple-shipping-address'); ?></a>
										<a href="javascript:;" data-delete_addr="<?php echo $saved_key; ?>" class="mwb_woo_guest_delete_address"><?php _e('Delete','mwb-woocommerce-multiple-shipping-address'); ?></a>
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
		}
	}

	/**
	 * Function for showing address dropdown on each cart item after adding the address by user.
	 * @since    1.0.0.
	 * @param    integer    	 $product_quantity   Product Quantity.
	 * @param    integer    	 $cart_item_key  	 Cart Item Key.
	 * @param    array object    $cart_item  		 Cart Item Object.
	 * @return   integer    	 $product_quantity	 Product Quantity.
	*/
	public function mwb_woo_msa_add_dropdown_on_cart_item($product_quantity, $cart_item_key, $cart_item){
		if(is_cart()){
			global $current_user;
			$user_id = $current_user->ID;
			$mwb_woo_msa_cart_item_key = $cart_item_key['key'];
			if(is_user_logged_in()){
				$mwb_woo_msa_saved_all_addresses = get_user_meta($user_id,'mwb_woo_multiple_shipping_addr_saved',true);
				$mwb_woo_msa_saved_all_addresses = json_decode($mwb_woo_msa_saved_all_addresses,true);

				$mwb_woomsa_item_selected_address = get_user_meta($user_id,'mwb_woocommerce_msa_saved_item_address',true);
				$mwb_woomsa_item_selected_address = json_decode($mwb_woomsa_item_selected_address,true);

				if(is_array($mwb_woomsa_item_selected_address) && !empty($mwb_woomsa_item_selected_address) && array_key_exists($mwb_woo_msa_cart_item_key, $mwb_woomsa_item_selected_address)){
					$itemaddress = $mwb_woomsa_item_selected_address[$mwb_woo_msa_cart_item_key]['item_address'];
				}

				if(is_array($mwb_woo_msa_saved_all_addresses) && !empty($mwb_woo_msa_saved_all_addresses)){
					?>
					<div class="mwb_woocommerce_msa_address_wrapper">
						<select name=<?php echo "mwb_woo_msa_cart_item_address[$mwb_woo_msa_cart_item_key][address]"; ?> class="mwb_woo_msa_cart_item_address" data-cart_item_key="<?php echo $mwb_woo_msa_cart_item_key; ?>" data-customer_id="<?php echo $user_id; ?>">
							<option value="505"><?php _e('Select Address','mwb-woocommerce-multiple-shipping-address'); ?></option>
							<?php
							foreach($mwb_woo_msa_saved_all_addresses as $useraddkey => $useraddrvalue){

								$defaultadd = $useraddrvalue['address1'].' '.$useraddrvalue['address2'].' '.$useraddrvalue['town'].' '.WC()->countries->countries[$useraddrvalue['country']].' '.WC()->countries->get_states()[ $useraddrvalue['country']][$useraddrvalue['state']].' '.$useraddrvalue['zip'];
								?>
								<option value="<?php echo $defaultadd; ?>"<?php if(isset($itemaddress)){ selected($itemaddress,$defaultadd); } ?>><?php echo $defaultadd; ?></option>
								<?php
							}
							?>
						</select>
					</div>
					<?php
				}
			}
			else{
				if(isset($_COOKIE['mwb_woo_msa_guest_user_addr']) && !empty($_COOKIE['mwb_woo_msa_guest_user_addr'])){
					$mwb_woo_msa_saved_all_addresses = unserialize(base64_decode($_COOKIE['mwb_woo_msa_guest_user_addr']));
					if(is_array($mwb_woo_msa_saved_all_addresses) && !empty($mwb_woo_msa_saved_all_addresses)){

						$mwb_woomsa_item_selected_address = isset($_COOKIE['mwb_woocommerce_msa_saved_guest_item_address']) ? unserialize(base64_decode($_COOKIE['mwb_woocommerce_msa_saved_guest_item_address'])) : '';

						if(is_array($mwb_woomsa_item_selected_address) && !empty($mwb_woomsa_item_selected_address) && array_key_exists($mwb_woo_msa_cart_item_key, $mwb_woomsa_item_selected_address)){
							$itemaddress = $mwb_woomsa_item_selected_address[$mwb_woo_msa_cart_item_key]['item_address'];
						}
						?>
						<div class="mwb_woocommerce_msa_address_wrapper">
							<select name=<?php echo "mwb_woo_msa_cart_item_address[$mwb_woo_msa_cart_item_key][address]"; ?>  class="mwb_woo_msa_cart_item_address" data-cart_item_key="<?php echo $mwb_woo_msa_cart_item_key; ?>" data-customer_id="<?php echo $user_id; ?>">
								<option value="505"><?php _e('Select Address','mwb-woocommerce-multiple-shipping-address'); ?></option>
								<?php
								foreach($mwb_woo_msa_saved_all_addresses as $guesuseraddrkey => $guestuseraddrvalue){

									$defaultadd = $guestuseraddrvalue['address1'].' '.$guestuseraddrvalue['address2'].' '.$guestuseraddrvalue['town'].' '.WC()->countries->countries[$guestuseraddrvalue['country']].' '.WC()->countries->get_states()[ $guestuseraddrvalue['country']][$guestuseraddrvalue['state']].' '.$guestuseraddrvalue['zip'];
									?>
									<option value="<?php echo $defaultadd; ?>" <?php if(isset($itemaddress)){  selected($itemaddress,$defaultadd); }?>><?php echo $defaultadd; ?></option>
									<?php
								}
								?>
							</select>
						</div>
						<?php
					}
				}
			}
			return $product_quantity;
		}
		else{
			return $product_quantity;
		}
	}

	/**
	 * Function for saving guest user address in cookies.
	 *
	 * @since    1.0.0
	 */
	public function mwb_woo_msa_set_guest_user_address_in_cookies(){

		$MwbWooMsaGuestUserAddess  = isset($_POST['MwbWooMsaAddr']) ? $_POST['MwbWooMsaAddr'] : '';
		$MwbWooMsaGuestUserAddess2 = isset($_POST['MwbWooMsaAddr2']) ? $_POST['MwbWooMsaAddr2'] : '';
		$MwbWooMsaGuestUserTown    = isset($_POST['MwbWooMsaTown']) ? $_POST['MwbWooMsaTown'] : '';
		$MwbWooMsaGuestUserCountry = isset($_POST['MwbWooMsaCountry']) ? $_POST['MwbWooMsaCountry'] : '';
		$MwbWooMsaGuestUserState   = isset($_POST['MwbWooMsaState']) ? $_POST['MwbWooMsaState'] : '';
		$MwbWooMsaGuestUserPostal  = isset($_POST['MwbWooMsaZip']) ? $_POST['MwbWooMsaZip'] : '';
		$MwbWooMsaPostValidateObject = WC_Validation::is_postcode($MwbWooMsaGuestUserPostal,$MwbWooMsaGuestUserCountry);

		if($MwbWooMsaPostValidateObject){

			if(!isset($_COOKIE['mwb_woo_msa_guest_user_addr'])){

				$mwb_woo_msa_user_address_data[] = array(
					'address1'  =>  $MwbWooMsaGuestUserAddess,
					'address2'  =>  $MwbWooMsaGuestUserAddess2,
					'town'      =>  $MwbWooMsaGuestUserTown,
					'country'   =>  $MwbWooMsaGuestUserCountry,
					'state'     =>  $MwbWooMsaGuestUserState,
					'zip'       =>  $MwbWooMsaGuestUserPostal,
					);
				$mwb_woocommerce_msa_set_addr = $this->mwb_woo_msa_set_cookies_time($mwb_woo_msa_user_address_data,'save');
				if($mwb_woocommerce_msa_set_addr){
					$success 	=  __( 'Your Address has been added', 'mwb-woocommerce-multiple-shipping-address' );
					$notice 	= wc_add_notice ( $success );
					echo "success";
				}
				else{
					$success 	=  __( 'Your address has not been added', 'mwb-woocommerce-multiple-shipping-address' );
					$notice 	= wc_add_notice ( $success,'error');
					echo "failed";
				}
			}
			elseif(isset($_COOKIE['mwb_woo_msa_guest_user_addr'])){
				$flagguest = true;
				$mwb_woo_msa_user_address_data = array(
					'address1'  =>  $MwbWooMsaGuestUserAddess,
					'address2'  =>  $MwbWooMsaGuestUserAddess2,
					'town'      =>  $MwbWooMsaGuestUserTown,
					'country'   =>  $MwbWooMsaGuestUserCountry,
					'state'     =>  $MwbWooMsaGuestUserState,
					'zip'       =>  $MwbWooMsaGuestUserPostal,
					);

				$mwb_woo_msa_user_save_addresses = unserialize(base64_decode($_COOKIE['mwb_woo_msa_guest_user_addr']));
				foreach ($mwb_woo_msa_user_save_addresses as $addrguestkey => $addrguestvalue) {
					if($addrguestvalue == $mwb_woo_msa_user_address_data){
						$flagguest = false;
					}
				}
				if($flagguest){

					array_push($mwb_woo_msa_user_save_addresses, $mwb_woo_msa_user_address_data);

					$mwb_woocommerce_msa_set_addr = $this->mwb_woo_msa_set_cookies_time($mwb_woo_msa_user_save_addresses,'save');
					if($mwb_woocommerce_msa_set_addr){
						$success 	=  __( 'Your Address has been added', 'mwb-woocommerce-multiple-shipping-address' );
						$notice 	= wc_add_notice ( $success );
						echo "success";
					}
					else{
						$success 	=  __( 'Your address has not been added', 'mwb-woocommerce-multiple-shipping-address' );
						$notice 	= wc_add_notice ( $success,'error');
						echo "failed";
					}
				}
				else{
					$success 	=  __( 'Your address already exists', 'mwb-woocommerce-multiple-shipping-address' );
					$notice 	= wc_add_notice ( $success,'error');
					echo "failed";
				}
			}
		}
		else
		{
			$success 	=  __( 'Please Enter Valid Zip Code', 'mwb-woocommerce-multiple-shipping-address' );
			$notice 	= wc_add_notice ( $success,'error');
			echo "failed";
		}

		wp_die();
	}


	/**
	 * Function for showing message while entering the address and left the fields blank.
	 *
	 * @since    1.0.0
	*/
	public function mwb_woo_msa_set_guest_user_address_in_cookies_empty(){
		$success 	=  __( 'No fields can be left blank', 'mwb-woocommerce-multiple-shipping-address' );
		$notice 	= wc_add_notice ( $success,'error');
		echo "success";
	}

	/**
	 * Function for adding address button.
	 * @since    1.0.0.
	 * @param    href    	$item_link  		 Cart Item Link.
	 * @param    varchar    $cart_item_key  	 Cart Item Key.
	 * @return   href    	$cart_link  	 	 Cart Item Link.
	*/
	public function mwb_woo_msa_add_address_button($item_link, $cart_item_key){
		?>
		<input type="button" name="mwb_woo_msa_open_modal_button" class="mwb_woo_msa_open_modal_button button alt" value="<?php _e('Add Address','mwb-woocommerce-multiple-shipping-address'); ?>">	
		<?php
		return $item_link;
	}


	/**
	 * Function for deleting the aved address for users.
	 *
	 * @since    1.0.0
	 */
	public function mwb_woo_msa_delete_address(){

		global $current_user;
		$user_id = $current_user->ID;
		$mwb_woo_msa_general_settings = get_option('mwb_woocommerce_multiple_shipping_address_enable_plugin');

		$mwb_woo_msa_address_delete_index = isset($_POST['Mwb_Woo_Msa_Delete_Address']) ? $_POST['Mwb_Woo_Msa_Delete_Address'] : '';
		if($mwb_woo_msa_address_delete_index != '' || $mwb_woo_msa_address_delete_index != null){
			if(is_user_logged_in()){
				$mwb_woo_msa_saved_all_addresses = get_user_meta($user_id,'mwb_woo_multiple_shipping_addr_saved',true);
				$mwb_woo_msa_saved_all_addresses = json_decode($mwb_woo_msa_saved_all_addresses,true);
				if(is_array($mwb_woo_msa_saved_all_addresses) && !empty($mwb_woo_msa_saved_all_addresses)){
					unset($mwb_woo_msa_saved_all_addresses[$mwb_woo_msa_address_delete_index]);
					$mwb_woo_msa_saved_all_addresses = json_encode($mwb_woo_msa_saved_all_addresses);
					update_user_meta($user_id,'mwb_woo_multiple_shipping_addr_saved',$mwb_woo_msa_saved_all_addresses);
					$success 	=  __( 'Your address has been deleted', 'mwb-woocommerce-multiple-shipping-address' );
					$notice 	= wc_add_notice ( $success );
					echo "success";
				}
				else{
					$success 	=  __( 'Your address has not been deleted', 'mwb-woocommerce-multiple-shipping-address' );
					$notice 	= wc_add_notice ( $success,'error');
					echo "failed";
				}
			}
			elseif(isset($mwb_woo_msa_general_settings['guest_users']) && $mwb_woo_msa_general_settings['guest_users'] == 'on' && isset($_COOKIE['mwb_woo_msa_guest_user_addr'])){

				$mwb_woo_msa_saved_all_addresses = unserialize(base64_decode($_COOKIE['mwb_woo_msa_guest_user_addr']));

				if(is_array($mwb_woo_msa_saved_all_addresses) && !empty($mwb_woo_msa_saved_all_addresses)){

					unset($mwb_woo_msa_saved_all_addresses[$mwb_woo_msa_address_delete_index]);

					if(empty($mwb_woo_msa_saved_all_addresses)){
						$mwb_woo_msa_saved_all_addresses = '';
						$mwb_woocommerce_msa_set_addr = $this->mwb_woo_msa_set_cookies_time($mwb_woo_msa_saved_all_addresses,'save');
					}
					else{
						// $mwb_woo_msa_saved_all_addresses = base64_encode(serialize($mwb_woo_msa_saved_all_addresses));
						$mwb_woocommerce_msa_set_addr = $this->mwb_woo_msa_set_cookies_time($mwb_woo_msa_saved_all_addresses,'save');
					}

					if($mwb_woocommerce_msa_set_addr){
						$success 	=  __( 'Your address has been deleted', 'mwb-woocommerce-multiple-shipping-address' );
						$notice 	= wc_add_notice ( $success );
						echo "success";
					}else{
						$success 	=  __( 'Your address has not been deleted', 'mwb-woocommerce-multiple-shipping-address' );
						$notice 	= wc_add_notice ( $success,'error');
						echo "failed";
					}
				}
				else{
					$success 	=  __( 'Your address does not exists in your browser', 'mwb-woocommerce-multiple-shipping-address' );
					$notice 	= wc_add_notice ( $success,'error');
					echo "failed";
				}
			}
		}
		else{
			$success 	=  __( 'No address has been selected', 'mwb-woocommerce-multiple-shipping-address' );
			$notice 	= wc_add_notice ( $success,'error');
			echo "failed";
		}
		wp_die();
	}



	/**
	 * Function for update the saved address by user.
	 *
	 * @since    1.0.0
	 */
	public function mwb_wmsa_update_address(){
		global $current_user,$woocommerce;
		$user_id = $current_user->ID;
		$mwb_woo_msa_general_settings = get_option('mwb_woocommerce_multiple_shipping_address_enable_plugin');

		$mwb_wmsa_all_form_data = isset($_POST['mwb_woo_all_form_data']) ? $_POST['mwb_woo_all_form_data'] : '';

		$mwb_wmsa_edit_index = isset($_POST['mwb_wmsa_update_index']) ? $_POST['mwb_wmsa_update_index'] : '';


		if(isset($mwb_wmsa_edit_index) && ($mwb_wmsa_edit_index != '' || $mwb_wmsa_edit_index != null)){
			if(is_array($mwb_wmsa_all_form_data) && !empty($mwb_wmsa_all_form_data)){

				$MwbWooMsaPostValidateObject = WC_Validation::is_postcode($mwb_wmsa_all_form_data['zip'],$mwb_wmsa_all_form_data['country']);

				if($MwbWooMsaPostValidateObject){

					if(is_user_logged_in()){

						$mwb_woo_msa_saved_all_addresses = get_user_meta($user_id,'mwb_woo_multiple_shipping_addr_saved',true);
						$mwb_woo_msa_saved_all_addresses = json_decode($mwb_woo_msa_saved_all_addresses,true);
						

						if(is_array($mwb_woo_msa_saved_all_addresses) && !empty($mwb_woo_msa_saved_all_addresses)){
							foreach($mwb_woo_msa_saved_all_addresses as $update_addr_key => $update_addr_value){

								if($update_addr_key == $mwb_wmsa_edit_index){
									$mwb_woo_msa_saved_all_addresses[$update_addr_key] = $mwb_wmsa_all_form_data;
									$mwb_woo_msa_saved_all_addresses = json_encode($mwb_woo_msa_saved_all_addresses);
									update_user_meta($user_id,'mwb_woo_multiple_shipping_addr_saved',$mwb_woo_msa_saved_all_addresses);
									$success 	=  __( 'Your Address has been updated', 'mwb-woocommerce-multiple-shipping-address' );
									$notice 	= wc_add_notice ( $success );
									echo "success";
									wp_die();
								}
							}
						}
						else{
							$success 	=  __( 'Your address has not been updated', 'mwb-woocommerce-multiple-shipping-address' );
							$notice 	= wc_add_notice ( $success,'error');
							echo "failed";
							wp_die();
						}
					}
					elseif(isset($mwb_woo_msa_general_settings['guest_users']) && $mwb_woo_msa_general_settings['guest_users'] == 'on' && isset($_COOKIE['mwb_woo_msa_guest_user_addr'])){
						$mwb_woo_msa_saved_all_addresses = unserialize(base64_decode($_COOKIE['mwb_woo_msa_guest_user_addr']));
						//print_r($mwb_woo_msa_saved_all_addresses);die("-->hell");
						if(is_array($mwb_woo_msa_saved_all_addresses) && !empty($mwb_woo_msa_saved_all_addresses)){
							foreach($mwb_woo_msa_saved_all_addresses as $update_addr_key => $update_addr_value){
								if($update_addr_key == $mwb_wmsa_edit_index){
									$mwb_woo_msa_saved_all_addresses[$update_addr_key] = $mwb_wmsa_all_form_data;
									$mwb_woocommerce_msa_edit_addr = $this->mwb_woo_msa_set_cookies_time($mwb_woo_msa_saved_all_addresses,'save');
									if($mwb_woocommerce_msa_edit_addr){
										$success 	=  __( 'Your Address has been updated', 'mwb-woocommerce-multiple-shipping-address' );
										$notice 	= wc_add_notice ( $success );
										echo "success";
										wp_die();
									}
								}
							}
						}
						else{
							$success 	=  __( 'Your address has not been updated', 'mwb-woocommerce-multiple-shipping-address' );
							$notice 	= wc_add_notice ( $success,'error');
							echo "failed";
							wp_die();
						}
					}
				}
				else
				{
					$success 	=  __( 'Please Enter Valid Postal/Zip Code', 'mwb-woocommerce-multiple-shipping-address' );
					$notice 	= wc_add_notice ( $success,'error');
					echo "failed";
					wp_die();
				}
			}
		}
		wp_die();
	}

	/**
	 * Function for saved corresponding address to the items.
	 *
	 * @since    1.0.0
	 */
	public function mwb_woo_msa_saved_address_in_items(){
		global $woocommerce, $current_user;
		$user_id = $current_user->ID;
		$cart = WC()->cart->get_cart();

		$mwb_woo_msa_general_settings = get_option('mwb_woocommerce_multiple_shipping_address_enable_plugin');

		$mwb_wmsa_selected_address = isset($_POST['mwb_woo_msa_all_item_data']) ? $_POST['mwb_woo_msa_all_item_data'] : '';

		if(is_array($mwb_wmsa_selected_address) && !empty($mwb_wmsa_selected_address)){

			$order_item_key = $mwb_wmsa_selected_address['cart_item_key'];

			$mwb_woo_msa_line_item_address = $mwb_wmsa_selected_address['cart_selected_address'];

			if(isset($cart) && !empty($cart)){
				foreach($cart as $cart_key => $cart_value){
					if($cart_key == $order_item_key){
						
						if(is_user_logged_in()){
							if(isset($mwb_woo_msa_line_item_address) && $mwb_woo_msa_line_item_address != '505'){
								$mwb_woomsa_item_selected_address = get_user_meta($user_id,'mwb_woocommerce_msa_saved_item_address',true);
								$mwb_woomsa_item_selected_address = json_decode($mwb_woomsa_item_selected_address,true);

								if(is_array($mwb_woomsa_item_selected_address) && !empty($mwb_woomsa_item_selected_address)){

									if(array_key_exists($order_item_key, $mwb_woomsa_item_selected_address)){
										$mwb_woomsa_item_selected_address[$order_item_key]['item_address'] = $mwb_woo_msa_line_item_address;
									}else{
										$mwb_woomsa_item_selected_address[$order_item_key] = array('item_address'=>$mwb_woo_msa_line_item_address);
									}

									$mwb_woomsa_item_selected_address = json_encode($mwb_woomsa_item_selected_address);
									update_user_meta($user_id,'mwb_woocommerce_msa_saved_item_address',$mwb_woomsa_item_selected_address);
									echo "success";
								}
								else{

									$mwb_wmsa_saved_item_array[$order_item_key] = array('item_address'=>$mwb_woo_msa_line_item_address);

									$mwb_wmsa_saved_item_array = json_encode($mwb_wmsa_saved_item_array);
									update_user_meta($user_id,'mwb_woocommerce_msa_saved_item_address',$mwb_wmsa_saved_item_array);
									echo "success";
								}
							}
							else
							{
								$mwb_woomsa_item_selected_address = get_user_meta($user_id,'mwb_woocommerce_msa_saved_item_address',true);
								$mwb_woomsa_item_selected_address = json_decode($mwb_woomsa_item_selected_address,true);

								if(is_array($mwb_woomsa_item_selected_address) && !empty($mwb_woomsa_item_selected_address) && array_key_exists($order_item_key, $mwb_woomsa_item_selected_address)){

									unset($mwb_woomsa_item_selected_address[$order_item_key]);
									$mwb_woomsa_item_selected_address = json_encode($mwb_woomsa_item_selected_address);
									update_user_meta($user_id,'mwb_woocommerce_msa_saved_item_address',$mwb_woomsa_item_selected_address);
									echo "success";

								}
							}
						}
						elseif(isset($mwb_woo_msa_general_settings['guest_users']) && $mwb_woo_msa_general_settings['guest_users'] == 'on' && isset($_COOKIE['mwb_woo_msa_guest_user_addr'])){

							if(isset($mwb_woo_msa_line_item_address) && $mwb_woo_msa_line_item_address != '505'){

								if(!isset($_COOKIE['mwb_woocommerce_msa_saved_guest_item_address'])){

									$mwb_wmsa_saved_item_array[$order_item_key] = array('item_address' => $mwb_woo_msa_line_item_address);
									$mwb_wmsa_saved_item_address_cookie = $this->mwb_woo_msa_set_cookies_time($mwb_wmsa_saved_item_array,'initial');
									if($mwb_wmsa_saved_item_address_cookie){
										echo "success";
									}
								}
								elseif(isset($_COOKIE['mwb_woocommerce_msa_saved_guest_item_address'])){

									$mwb_woomsa_item_selected_address = unserialize(base64_decode($_COOKIE['mwb_woocommerce_msa_saved_guest_item_address']));

									if(is_array($mwb_woomsa_item_selected_address) && !empty($mwb_woomsa_item_selected_address)){


										if(array_key_exists($order_item_key, $mwb_woomsa_item_selected_address)){
											$mwb_woomsa_item_selected_address[$order_item_key]['item_address'] = $mwb_woo_msa_line_item_address;
										}else{
											$mwb_woomsa_item_selected_address[$order_item_key] = array('item_address'=>$mwb_woo_msa_line_item_address);
										}

										$mwb_wmsa_saved_item_address_cookie = $this->mwb_woo_msa_set_cookies_time($mwb_woomsa_item_selected_address,'item');
										if($mwb_wmsa_saved_item_address_cookie){
											echo "success";
										}
									}
									else{
										$mwb_wmsa_saved_item_array[$order_item_key] = array('item_address' => $mwb_woo_msa_line_item_address);

										$mwb_wmsa_saved_item_address_cookie = $this->mwb_woo_msa_set_cookies_time($mwb_wmsa_saved_item_array,'item');

										if($mwb_wmsa_saved_item_address_cookie){
											echo "success";
										}
									}
								}

							}
							else
							{
								$mwb_woomsa_item_selected_address = unserialize(base64_decode($_COOKIE['mwb_woocommerce_msa_saved_guest_item_address']));

								if(is_array($mwb_woomsa_item_selected_address) && !empty($mwb_woomsa_item_selected_address) && array_key_exists($order_item_key, $mwb_woomsa_item_selected_address)){

									unset($mwb_woomsa_item_selected_address[$order_item_key]);

									$mwb_guest_cookie_delete = $this->mwb_woo_msa_set_cookies_time($mwb_woomsa_item_selected_address,'item');
									if($mwb_guest_cookie_delete){
										echo "success";
									}
								}
							}
						}
					}
				}
			}
			wp_die();
		}
	}

	/**
	 * Function for displaying the saved address on checkout page for each items.
	 * @since    1.0.0
	 * @param    html   		 $html  		 Saved Address Html.
	 * @param    array object    $cart_item  	 Cart Item Object.
	 * @param    varchar    	 $cart_item_key  Cart Item key.
	 * @return   html    		 $html  		 html.
	*/
	public function mwb_woo_msa_display_address_on_checkout($html, $cart_item, $cart_item_key){

		global $woocommerce, $current_user;
		$cart = $woocommerce->cart->get_cart();
		$user_id = $current_user->ID;
		$mwb_woo_msa_general_settings = get_option('mwb_woocommerce_multiple_shipping_address_enable_plugin');
		
		if(is_user_logged_in()){

			if(isset($cart) && !empty($cart)){
				$mwb_woomsa_item_selected_address = get_user_meta($user_id,'mwb_woocommerce_msa_saved_item_address',true);
				$mwb_woomsa_item_selected_address = json_decode($mwb_woomsa_item_selected_address,true);
				
				if(array_key_exists($cart_item_key, $mwb_woomsa_item_selected_address)){
					$woocommerce->cart->cart_contents[$cart_item_key]['item_shipping_address'] = array('value' =>$mwb_woomsa_item_selected_address[$cart_item_key]['item_address']);
					$html .= "<div class='mwb_woo_msa_saved_address_item'>".$mwb_woomsa_item_selected_address[$cart_item_key]['item_address']."</div>";

				}
			}
		}
		elseif(isset($mwb_woo_msa_general_settings['guest_users']) && $mwb_woo_msa_general_settings['guest_users'] == 'on' && isset($_COOKIE['mwb_woocommerce_msa_saved_guest_item_address']))
		{
			$mwb_woomsa_item_selected_address = unserialize(base64_decode($_COOKIE['mwb_woocommerce_msa_saved_guest_item_address']));
			
			if(isset($cart) && !empty($cart)){

				if(array_key_exists($cart_item_key, $mwb_woomsa_item_selected_address)){
					$woocommerce->cart->cart_contents[$cart_item_key]['item_shipping_address'] = array('value' =>$mwb_woomsa_item_selected_address[$cart_item_key]['item_address']);
					$html .= "<div class='mwb_woo_msa_saved_address_item'>".$mwb_woomsa_item_selected_address[$cart_item_key]['item_address']."</div>";
				}
			}
		}
		
		return $html;
	}



	/**
	 * Function for saving item address.
	 * @since    1.0.0
	 * @param    integer    $order_id  				 Order Id.
	 * @param    array object    $posted_data  		 product posted data.
	*/
	public function mwb_woo_msa_save_address_on_each_item($order_id, $posted_data, $order){

		global $current_user;
		$user_id = $current_user->ID;
		$mwb_woo_msa_general_settings = get_option('mwb_woocommerce_multiple_shipping_address_enable_plugin');
		if(isset($order)){
			$order_items = $order->get_items();
			if(is_array($order_items) && !empty($order_items)){
				foreach($order_items as $item_key => $item_values){
					$product = $item_values->get_data();
					$productId = $product['product_id'];

					if(is_user_logged_in()){

						$mwb_woomsa_item_selected_address = get_user_meta($user_id,'mwb_woocommerce_msa_saved_item_address',true);
						$mwb_woomsa_item_selected_address = json_decode($mwb_woomsa_item_selected_address,true);

						if(is_array($mwb_woomsa_item_selected_address) && !empty($mwb_woomsa_item_selected_address)){
							if(array_key_exists($productId, $mwb_woomsa_item_selected_address)){

								$address = $mwb_woomsa_item_selected_address[$productId]['item_address'];
								$address = json_encode($address);
								update_post_meta($productId,'mwb_woo_multiple_address_for_item',$address);
							}
						}
					}
					elseif(isset($mwb_woo_msa_general_settings['guest_users']) && $mwb_woo_msa_general_settings['guest_users'] == 'on' && isset($_COOKIE['mwb_woocommerce_msa_saved_guest_item_address'])){

						$mwb_woomsa_item_selected_address = unserialize(base64_decode($_COOKIE['mwb_woocommerce_msa_saved_guest_item_address']));

						if(is_array($mwb_woomsa_item_selected_address) && !empty($mwb_woomsa_item_selected_address)){
							if(array_key_exists($productId, $mwb_woomsa_item_selected_address)){

								$address = $mwb_woomsa_item_selected_address[$productId]['item_address'];
								$address = json_encode($address);
								update_post_meta($productId,'mwb_woo_multiple_address_for_item',$address);
							}
						}
					}
				}
			}
		}
	}

	/**
	 * Function for saving order line items address while placing the orders.
	 * @since    1.0.0
	 * @param    array object    $item  		 	 Cart Item Object.
	 * @param    varchar    	 $cart_item_key  	 Cart Item Key.
	 * @param    array object    $values  		 	 Cart Item values.
	 * @param    array object    $order  			 Order Object.
	*/
	public function mwb_msa_saved_order_line_item_address($item, $cart_item_key, $values, $order){
		global $current_user;
		$user_id = $current_user->ID;
		$mwb_woo_msa_general_settings = get_option('mwb_woocommerce_multiple_shipping_address_enable_plugin');
		$product = $item->get_data();

		if(is_user_logged_in()){
			$mwb_woomsa_item_selected_address = get_user_meta($user_id,'mwb_woocommerce_msa_saved_item_address',true);
			$mwb_woomsa_item_selected_address = json_decode($mwb_woomsa_item_selected_address,true);

			if(is_array($mwb_woomsa_item_selected_address) && !empty($mwb_woomsa_item_selected_address) && 	array_key_exists($cart_item_key, $mwb_woomsa_item_selected_address)){

				$item->add_meta_data( __( 'Shipping Address', 'mwb-woocommerce-multiple-shipping-address' ),$mwb_woomsa_item_selected_address[$cart_item_key]['item_address'] );
			}

		}
		elseif(isset($mwb_woo_msa_general_settings['guest_users']) && $mwb_woo_msa_general_settings['guest_users'] == 'on' && isset($_COOKIE['mwb_woocommerce_msa_saved_guest_item_address'])){

			$mwb_woomsa_item_selected_address = unserialize(base64_decode($_COOKIE['mwb_woocommerce_msa_saved_guest_item_address']));

			if(is_array($mwb_woomsa_item_selected_address) && !empty($mwb_woomsa_item_selected_address)){
				if(array_key_exists($cart_item_key, $mwb_woomsa_item_selected_address)){

					$item->add_meta_data( __( 'Shipping Address', 'mwb-woocommerce-multiple-shipping-address' ), $mwb_woomsa_item_selected_address[$cart_item_key]['item_address'] );
				}
			}
		}
	}


	/**
	 * Function for set cookies time duration for saving the guest user saved address.
	 * @since    1.0.0
	 * @param    array object    $mwb_woo_msa_user_address_data  	Users saved address data.
	 * @param    character    	 $purpose  							Saved Purpose.
	 * @param    array object    $cookie time 			  		 	Saved cookies data.
	*/
	public function mwb_woo_msa_set_cookies_time($mwb_woo_msa_user_address_data, $purpose){

		$mwb_woo_msa_general_settings = get_option('mwb_woocommerce_multiple_shipping_address_enable_plugin');

		if(isset($purpose) && $purpose == 'save'){

			if(isset($mwb_woo_msa_user_address_data) && ($mwb_woo_msa_user_address_data == '' || $mwb_woo_msa_user_address_data == null)){
				return setcookie('mwb_woo_msa_guest_user_addr','',time()+(86400*365),"/");
			}
			else{

				if(isset($mwb_woo_msa_general_settings['cookie_duration']) && $mwb_woo_msa_general_settings['cookie_duration'] == 'day' ){
					if(isset($mwb_woo_msa_general_settings['cookie_value']) && ($mwb_woo_msa_general_settings['cookie_value'] != '' || $mwb_woo_msa_general_settings['cookie_value'] != null)){

						return setcookie('mwb_woo_msa_guest_user_addr',base64_encode(serialize($mwb_woo_msa_user_address_data)),time()+(86400*$mwb_woo_msa_general_settings['cookie_value']),"/");
					}
					else{

						return setcookie('mwb_woo_msa_guest_user_addr',base64_encode(serialize($mwb_woo_msa_user_address_data)),time()+(86400*365),"/");
					}
				}
				elseif(isset($mwb_woo_msa_general_settings['cookie_duration']) && $mwb_woo_msa_general_settings['cookie_duration'] == 'week' ){
					if(isset($mwb_woo_msa_general_settings['cookie_value']) && ($mwb_woo_msa_general_settings['cookie_value'] != '' || $mwb_woo_msa_general_settings['cookie_value'] != null)){

						return setcookie('mwb_woo_msa_guest_user_addr',base64_encode(serialize($mwb_woo_msa_user_address_data)),time()+(86400*(7*$mwb_woo_msa_general_settings['cookie_value'])),"/");
					}
					else{
						return setcookie('mwb_woo_msa_guest_user_addr',base64_encode(serialize($mwb_woo_msa_user_address_data)),time()+(86400*365),"/");
					}
				}
				elseif(isset($mwb_woo_msa_general_settings['cookie_duration']) && $mwb_woo_msa_general_settings['cookie_duration'] == 'month' ){
					if(isset($mwb_woo_msa_general_settings['cookie_value']) && ($mwb_woo_msa_general_settings['cookie_value'] != '' || $mwb_woo_msa_general_settings['cookie_value'] != null)){

						return setcookie('mwb_woo_msa_guest_user_addr',base64_encode(serialize($mwb_woo_msa_user_address_data)),time()+(86400*(30*$mwb_woo_msa_general_settings['cookie_value'])),"/");
					}
					else{
						return setcookie('mwb_woo_msa_guest_user_addr',base64_encode(serialize($mwb_woo_msa_user_address_data)),time()+(86400*365),"/");
					}
				}
				elseif(isset($mwb_woo_msa_general_settings['cookie_duration']) && $mwb_woo_msa_general_settings['cookie_duration'] == 'year' ){
					if(isset($mwb_woo_msa_general_settings['cookie_value']) && ($mwb_woo_msa_general_settings['cookie_value'] != '' || $mwb_woo_msa_general_settings['cookie_value'] != null)){

						return setcookie('mwb_woo_msa_guest_user_addr',base64_encode(serialize($mwb_woo_msa_user_address_data)),time()+(86400*(365*$mwb_woo_msa_general_settings['cookie_value'])),"/");
					}
					else{
						return setcookie('mwb_woo_msa_guest_user_addr',base64_encode(serialize($mwb_woo_msa_user_address_data)),time()+(86400*365),"/");
					}
				}
				else{
					return setcookie('mwb_woo_msa_guest_user_addr',base64_encode(serialize($mwb_woo_msa_user_address_data)),time()+(86400*365),"/");
				}
			}
		}
		elseif(isset($purpose) && $purpose == 'item'){


			if(isset($mwb_woo_msa_user_address_data) && ($mwb_woo_msa_user_address_data == '' || $mwb_woo_msa_user_address_data == null)){
				return setcookie('mwb_woocommerce_msa_saved_guest_item_address','',time()+(86400*365),"/");
			}
			else{

				if(isset($mwb_woo_msa_general_settings['cookie_duration']) && $mwb_woo_msa_general_settings['cookie_duration'] == 'day' ){
					if(isset($mwb_woo_msa_general_settings['cookie_value']) && ($mwb_woo_msa_general_settings['cookie_value'] != '' || $mwb_woo_msa_general_settings['cookie_value'] != null)){

						return setcookie('mwb_woocommerce_msa_saved_guest_item_address',base64_encode(serialize($mwb_woo_msa_user_address_data)),time()+(86400*$mwb_woo_msa_general_settings['cookie_value']),"/");
					}
					else{

						return setcookie('mwb_woocommerce_msa_saved_guest_item_address',base64_encode(serialize($mwb_woo_msa_user_address_data)),time()+(86400*365),"/");
					}
				}
				elseif(isset($mwb_woo_msa_general_settings['cookie_duration']) && $mwb_woo_msa_general_settings['cookie_duration'] == 'week' ){
					if(isset($mwb_woo_msa_general_settings['cookie_value']) && ($mwb_woo_msa_general_settings['cookie_value'] != '' || $mwb_woo_msa_general_settings['cookie_value'] != null)){

						return setcookie('mwb_woocommerce_msa_saved_guest_item_address',base64_encode(serialize($mwb_woo_msa_user_address_data)),time()+(86400*(7*$mwb_woo_msa_general_settings['cookie_value'])),"/");
					}
					else{
						return setcookie('mwb_woocommerce_msa_saved_guest_item_address',base64_encode(serialize($mwb_woo_msa_user_address_data)),time()+(86400*365),"/");
					}
				}
				elseif(isset($mwb_woo_msa_general_settings['cookie_duration']) && $mwb_woo_msa_general_settings['cookie_duration'] == 'month' ){
					if(isset($mwb_woo_msa_general_settings['cookie_value']) && ($mwb_woo_msa_general_settings['cookie_value'] != '' || $mwb_woo_msa_general_settings['cookie_value'] != null)){

						return setcookie('mwb_woocommerce_msa_saved_guest_item_address',base64_encode(serialize($mwb_woo_msa_user_address_data)),time()+(86400*(30*$mwb_woo_msa_general_settings['cookie_value'])),"/");
					}
					else{
						return setcookie('mwb_woocommerce_msa_saved_guest_item_address',base64_encode(serialize($mwb_woo_msa_user_address_data)),time()+(86400*365),"/");
					}
				}
				elseif(isset($mwb_woo_msa_general_settings['cookie_duration']) && $mwb_woo_msa_general_settings['cookie_duration'] == 'year' ){
					if(isset($mwb_woo_msa_general_settings['cookie_value']) && ($mwb_woo_msa_general_settings['cookie_value'] != '' || $mwb_woo_msa_general_settings['cookie_value'] != null)){

						return setcookie('mwb_woocommerce_msa_saved_guest_item_address',base64_encode(serialize($mwb_woo_msa_user_address_data)),time()+(86400*(365*$mwb_woo_msa_general_settings['cookie_value'])),"/");
					}
					else{
						return setcookie('mwb_woocommerce_msa_saved_guest_item_address',base64_encode(serialize($mwb_woo_msa_user_address_data)),time()+(86400*365),"/");
					}
				}
				else{
					return setcookie('mwb_woocommerce_msa_saved_guest_item_address',base64_encode(serialize($mwb_woo_msa_user_address_data)),time()+(86400*365),"/");
				}
			}
		}

		elseif(isset($purpose) && $purpose == 'initial'){

			if(isset($mwb_woo_msa_general_settings['cookie_duration']) && $mwb_woo_msa_general_settings['cookie_duration'] == 'day' ){
				if(isset($mwb_woo_msa_general_settings['cookie_value']) && ($mwb_woo_msa_general_settings['cookie_value'] != '' || $mwb_woo_msa_general_settings['cookie_value'] != null)){

					return setcookie('mwb_woocommerce_msa_saved_guest_item_address',base64_encode(serialize($mwb_woo_msa_user_address_data)),time()+(86400*$mwb_woo_msa_general_settings['cookie_value']),"/");
				}
				else{

					return setcookie('mwb_woocommerce_msa_saved_guest_item_address',base64_encode(serialize($mwb_woo_msa_user_address_data)),time()+(86400*365),"/");
				}
			}
			elseif(isset($mwb_woo_msa_general_settings['cookie_duration']) && $mwb_woo_msa_general_settings['cookie_duration'] == 'week' ){
				if(isset($mwb_woo_msa_general_settings['cookie_value']) && ($mwb_woo_msa_general_settings['cookie_value'] != '' || $mwb_woo_msa_general_settings['cookie_value'] != null)){

					return setcookie('mwb_woocommerce_msa_saved_guest_item_address',base64_encode(serialize($mwb_woo_msa_user_address_data)),time()+(86400*(7*$mwb_woo_msa_general_settings['cookie_value'])),"/");
				}
				else{
					return setcookie('mwb_woocommerce_msa_saved_guest_item_address',base64_encode(serialize($mwb_woo_msa_user_address_data)),time()+(86400*365),"/");
				}
			}
			elseif(isset($mwb_woo_msa_general_settings['cookie_duration']) && $mwb_woo_msa_general_settings['cookie_duration'] == 'month' ){
				if(isset($mwb_woo_msa_general_settings['cookie_value']) && ($mwb_woo_msa_general_settings['cookie_value'] != '' || $mwb_woo_msa_general_settings['cookie_value'] != null)){

					return setcookie('mwb_woocommerce_msa_saved_guest_item_address',base64_encode(serialize($mwb_woo_msa_user_address_data)),time()+(86400*(30*$mwb_woo_msa_general_settings['cookie_value'])),"/");
				}
				else{
					return setcookie('mwb_woocommerce_msa_saved_guest_item_address',base64_encode(serialize($mwb_woo_msa_user_address_data)),time()+(86400*365),"/");
				}
			}
			elseif(isset($mwb_woo_msa_general_settings['cookie_duration']) && $mwb_woo_msa_general_settings['cookie_duration'] == 'year' ){
				if(isset($mwb_woo_msa_general_settings['cookie_value']) && ($mwb_woo_msa_general_settings['cookie_value'] != '' || $mwb_woo_msa_general_settings['cookie_value'] != null)){

					return setcookie('mwb_woocommerce_msa_saved_guest_item_address',base64_encode(serialize($mwb_woo_msa_user_address_data)),time()+(86400*(365*$mwb_woo_msa_general_settings['cookie_value'])),"/");
				}
				else{
					return setcookie('mwb_woocommerce_msa_saved_guest_item_address',base64_encode(serialize($mwb_woo_msa_user_address_data)),time()+(86400*365),"/");
				}
			}
			else{
				return setcookie('mwb_woocommerce_msa_saved_guest_item_address',base64_encode(serialize($mwb_woo_msa_user_address_data)),time()+(86400*365),"/");
			}
		}
	}
}
?>
