<?php
/*
	Plugin Name: Wanderlust EasyPost Shipping Tool
	Plugin URI: https://shop.wanderlust-webdesign.com/shop/print-usps-fedex-ups-shipping-labels-via-woocommerce/
	Description: Provides an integration for EasyPost for Woocommerce by Wanderlust Web Design. 
	Version: 4.5
	Author: Wanderlust Web Design
	Author URI: https://wanderlust-webdesign.com
	WC tested up to: 3.5.3
	Copyright: 2007-2019 wanderlust-webdesign.com.
	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/


/**
 * Required functions
 */
	require_once( 'woo-includes/woo-functions.php' );


/**
 * Plugin page links
 */
	function wc_wanderlust_plugin_links( $links ) {

		$plugin_links = array(
			'<a href="https://wanderlust-webdesign.com/contact/">' . __( 'Support', 'wc_wanderlust' ) . '</a>',
			'<a href="https://shop.wanderlust-webdesign.com/">' . __( 'More Plugins', 'wc_wanderlust' ) . '</a>',
		);

		return array_merge( $plugin_links, $links );
	}

	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'wc_wanderlust_plugin_links' );

/**
 * Check if WooCommerce is active
 */
if ( is_woocommerce_active() ) {

	$showrates = get_option('pvit_easypostwanderlust_rates');
	if ($showrates == 1) {
		/**
		 * woocommerce_init_shipping_table_rate function.
		 *
		 * @access public
		 * @return void
		 */
		function wc_wanderlust_init() {
			include_once( 'includes/class-wc-shipping-wanderlust.php' );
		}

		add_action( 'woocommerce_shipping_init', 'wc_wanderlust_init' );

		/**
		 * wc_wanderlust_add_method function.
		 *
		 * @access public
		 * @param mixed $methods
		 * @return void
		 */
		function wc_wanderlust_add_method( $methods ) {
			$methods[] = 'WC_Shipping_wanderlust';
			return $methods;
		}

		add_filter( 'woocommerce_shipping_methods', 'wc_wanderlust_add_method' );
		add_filter( 'woocommerce_shipping_calculator_enable_city', '__return_true' );

		/**
		 * wc_wanderlust_scripts function.
		 */
		function wc_wanderlust_scripts() {
			wp_enqueue_script( 'jquery-ui-sortable' );
		}

		add_action( 'admin_enqueue_scripts', 'wc_wanderlust_scripts' );

	}

 	// Order of Plugin Loading Requires this line, should not be necessary
 	require_once(dirname(__FILE__) . '/includes/functions.php');

	function wanderlust_install() {
	   global $wpdb;
	   $table_name = $wpdb->prefix . "easypost_packages";
	   if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
		   $sql = "CREATE TABLE $table_name (id mediumint(9) NOT NULL AUTO_INCREMENT,name tinytext NOT NULL,text text NOT NULL,height VARCHAR(55) DEFAULT '' NOT NULL,width VARCHAR(55) DEFAULT '' NOT NULL,length VARCHAR(55) DEFAULT '' NOT NULL,weight VARCHAR(55) DEFAULT '' NOT NULL,url VARCHAR(55) DEFAULT '' NOT NULL,UNIQUE KEY id (id));";
		   $sql2 = "INSERT INTO $table_name (id, name, text, url, height, width, length, weight) VALUES (NULL, 'normal-demo', '2', '2', '2', '2', '2', '2')";       
		   require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		   dbDelta( $sql );
		   dbDelta( $sql2 );
	   }
	}
	register_activation_hook( __FILE__, 'wanderlust_install' );


	add_action( 'add_meta_boxes', 'wanderlust_add_boxes');
	add_filter('manage_edit-shop_order_columns', 'cw_add_order_wanderlusteasypost_column_header');
	add_action( 'manage_shop_order_posts_custom_column', 'cw_add_order_wanderlusteasypost_column_content' );
	
	function cw_add_order_wanderlusteasypost_column_header($columns){
			$new_columns = array();
			foreach ($columns as $column_name => $column_info) {
					$new_columns[$column_name] = $column_info;
					if ('order_total' === $column_name) {
							$new_columns['order_easypostwanderlust'] = 'Easypost Labels';
					}
			}
			return $new_columns;
	}


	function cw_add_order_wanderlusteasypost_column_content( $column ) {
			global $post;

			if ( 'order_easypostwanderlust' === $column ) {
				$easypost_shipping_labela = get_post_meta($post->ID, 'easypost_shipping_label_1', true);	
				
				if (empty($easypost_shipping_labela)){ 
  					echo '<a class="button" href="'. admin_url('admin.php?page=easypost-create-shipment&order_id='.$post->ID) . '>Generate Label</a>';
 				}
			}
	}

	function wanderlust_add_boxes(){
	 	add_meta_box( 'easypost_data', __( 'Shipping Label', 'woocommerce' ), 'woocommerce_wanderlust_meta_box', 'shop_order', 'normal', 'low' );
	}

	function woocommerce_wanderlust_meta_box($post){
	 	print sprintf("<a href='%2\$s' style='text-align:center;display:block;'><img style='max-width:%1\$s' src='%2\$s' ></a>",'450px', get_post_meta( $post->ID, 'easypost_shipping_label_1', true));
	}

	function easypost_label_load_admin_js(){
		add_action( 'admin_enqueue_scripts', 'easypost_label_enqueue_admin_js' );
	}

	function easypost_label_enqueue_admin_js(){	
		wp_enqueue_script( 'easypost-label-admin-script', plugins_url('includes/js/admin.js',__FILE__), array( 'jquery' ) );
		wp_enqueue_script( 'easypost-label-admin-print', plugins_url('includes/js/print.js',__FILE__), array( 'jquery' ) );
	}


	function wanderlust_labels_admin() {
		$my_page = add_submenu_page( 'woocommerce','Wanderlust Labels', 'Generate Label', 'manage_woocommerce', 'easypost-create-shipment', 'easypost_create_shipment' );
 		add_action( 'load-' . $my_page, 'easypost_label_load_admin_js' );
		$my_page = add_submenu_page( 'woocommerce','Wanderlust Labels', 'Batch Labels', 'manage_woocommerce', 'easypost-create-batch', 'easypost_create_batch' );
 		add_action( 'load-' . $my_page, 'easypost_label_load_admin_js' );		
		$my_page = add_submenu_page( 'woocommerce','Wanderlust Labels', 'Scan Forms', 'manage_woocommerce', 'easypost-create-scanform', 'easypost_create_scanform' );
 		add_action( 'load-' . $my_page, 'easypost_label_load_admin_js' );		
 		$my_page = add_submenu_page( 'woocommerce','Wanderlust Shipping Tool Settings', 'Wanderlust Shipping Tool Settings', 'manage_woocommerce', 'easypost-config', 'easypost_config' );
		add_action( 'load-' . $my_page, 'easypost_label_load_admin_js' );
		wp_register_style( 'wanderlustStylesheet', plugins_url('includes/css/style.css', __FILE__) );
		wp_enqueue_style( 'wanderlustStylesheet' );
		wp_enqueue_script( 'easypost-label-admin-script', plugins_url('includes/js/admin.js',__FILE__), array( 'jquery' ) );

  	}
	add_action( 'admin_menu', 'wanderlust_labels_admin' );
	
  function remove_menu_pages() {
    $remove_submenu = remove_submenu_page('woocommerce', 'manage_woocommerce');
    remove_submenu_page( 'woocommerce' ,'easypost-create-shipment' );
  }
	
	function easypost_create_scanform() {
		if ( !current_user_can( 'manage_woocommerce' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
		require_once(dirname(__FILE__) . '/includes/admin-forms.php');
		
	}
	
	function easypost_create_batch() {
		if ( !current_user_can( 'manage_woocommerce' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
		require_once(dirname(__FILE__) . '/includes/admin-batch.php');
	}
	
	function easypost_create_shipment() {
		if ( !current_user_can( 'manage_woocommerce' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
		require_once(dirname(__FILE__) . '/includes/admin-index.php');
	}

 	function easypost_config(){
		if ( !current_user_can( 'manage_woocommerce' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}	
		require_once(dirname(__FILE__) . '/includes/admin-config.php');
	}


	function woocommerce_pvit_easypost_label_create_box_content($column) {
		global $post;
	 	$order = wc_get_order( $post->ID );
	    
	    switch ($column) {
	      case "order_actions" :

	  			?>
				<?php $easypost_shipping_labela = get_post_meta($post->ID, 'easypost_shipping_label_1');	
				if (empty($easypost_shipping_labela)){ ?>
	  				<a class="button" href="<?php echo wp_nonce_url(admin_url('admin.php?page=easypost-create-shipment&order_id='.$post->ID), 'print-easypost-label'); ?>"><?php _e('Generate Label', 'woocommerce-pvit-easypost'); ?></a>
				<?php } else { ?>
	  				<a class="button" href="<?php echo wp_nonce_url(admin_url('admin.php?page=easypost-create-shipment&order_id='.$post->ID), 'print-easypost-label'); ?>"><?php _e('Generate Label', 'woocommerce-pvit-easypost'); ?></a>
				<?php } ?>
	 	<?php
	  		  break;
	    }
	}
	
	add_action('manage_shop_order_posts_custom_column', 'woocommerce_pvit_easypost_label_create_box_content', 4);	
	add_action('add_meta_boxes', 'woocommerce_easypost_box_add_box');


	function woocommerce_easypost_box_add_box() {
		add_meta_box( 'woocommerce-easypost-box', __( 'Wanderlust Shipping Labels', 'woocommerce-easypost' ), 'woocommerce_easypost_box_create_box_content', 'shop_order', 'side', 'default' );
	}

	function woocommerce_easypost_box_create_box_content() {
		global $post;
		  $order = wc_get_order( $post->ID );
		  $shipid = get_post_meta($post->ID, '_wanderlustshipid', true);
		  $shiporderid = get_post_meta($post->ID, '_wanderlustshiporderid', true);
		if (empty($shipid)){ echo'<style>#label-package-info, #label-info{display:none;} </style>';}

		?>
 		<div class="easypost-single">
			<?php $easypost_shipping_labela = get_post_meta($post->ID, 'easypost_shipping_label_1', true);
			if (!empty($easypost_shipping_labela)){ 
				echo'<h3>Label 1</h3><div id="label_one"><div style="cursor: pointer;text-align: center;" class="print" data-imgid="'.$easypost_shipping_labela.'"><a href="#"><img src="'.$easypost_shipping_labela.'" width="150" height="auto"></a></div></div>'; 
			} ?>
			<?php $easypost_shipping_labelb = get_post_meta($post->ID, 'easypost_shipping_label_2', true);
			if (!empty($easypost_shipping_labelb)){ 
				echo'</br><h3>Label 2</h3><div id="label_one"><div style="cursor: pointer;text-align: center;" class="print" data-imgid="'.$easypost_shipping_labelb.'"><a href="#"><img src="'.$easypost_shipping_labelb.'" width="150" height="auto"></a></div></div>'; 
			} ?>	
			<?php $easypost_shipping_labelc = get_post_meta($post->ID, 'easypost_shipping_label_3', true);
			if (!empty($easypost_shipping_labelc)){ 
				echo'</br><h3>Label 3</h3><div id="label_one"><div style="cursor: pointer;text-align: center;" class="print" data-imgid="'.$easypost_shipping_labelc.'"><a href="#"><img src="'.$easypost_shipping_labelc.'" width="150" height="auto"></a></div></div>'; 
			} ?>			
					
			<?php 
				$easypost_shipping_labela = get_post_meta($post->ID, 'easypost_shipping_label_1', true);	
				$site = get_site_url();  
				if (empty($easypost_shipping_labela)){ ?>
				
					<a style="display:none;" class="button" href="<?php echo wp_nonce_url(admin_url('admin.php?page=easypost-create-shipment&order_id='.$post->ID), 'print-easypost-label'); ?>">
						<?php _e('Generate Label', 'woocommerce-pvit-easypost'); ?>
					</a>

					<div class="one_click_label" style=" ">	
					<?php	
						$label = get_post_meta( $post->ID, 'easypost_shipping_label_1', true);
						if(empty($label)){
							$shipping_id = get_post_meta( $post->ID, '_easypost_shipping_id', true); 
							$i = 1;
							if(!empty($shipping_id)){
								$order = \EasyPost\Order::retrieve($shipping_id);
								echo '<h3 style="padding-left: 0px;">Paid parcel: </h3>';
								foreach($order['shipments'] as $singleshipment){
									echo '<strong>Package '. $i .'</strong></br>';
									$parcel = \EasyPost\Parcel::retrieve($singleshipment['parcel']['id']);
									echo 'Length.: ' . $parcel['length'] . ' in. </br>'; 
									echo 'Width.: ' .  $parcel['width'] . ' in. </br>';
									echo 'Height.: ' .  $parcel['height'] . ' in. </br>'; 
									echo 'Weight.: ' .  $parcel['weight'] . ' oz. </br></br>'; 
								}
							$woorder = wc_get_order( $post->ID );
			 				echo $woorder->get_shipping_to_display();
			 				echo '<div id="quick_buy" style=" " class="button-primary" data-shiporder="' . $shipping_id .'"  data-shiporderid="' . $post->ID .'" />Buy Label</div>';
							}
						}
					?>
		</div>	
		<?php } ?>
							
			<a style="display:none;" id="insure-package" data-url="<?php echo $site; ?>" data-shiporderid="<?php echo $shiporderid; ?>" data-shiporder="<?php echo $post->ID; ?>" data-shipid="<?php echo $shipid; ?>" class="button" href="#">
				<?php _e('Insure Package', 'woocommerce-pvit-easypost'); ?>
			</a>
		<a id="label-package-info" data-url="<?php echo $site; ?>" data-shiporder="<?php echo $post->ID; ?>" data-shiporderid="<?php echo $shiporderid; ?>" data-shipid="<?php echo $shipid; ?>" class="button" href="#">
			<?php _e('Get Package Info', 'woocommerce-pvit-easypost'); ?>
		</a>
		<a id="label-info" data-url="<?php echo $site; ?>" data-shiporder="<?php echo $post->ID; ?>" data-shiporderid="<?php echo $shiporderid; ?>" data-shipid="<?php echo $shipid; ?>" class="button" href="#">
			<?php _e('Get Tracking Status', 'woocommerce-pvit-easypost'); ?>
		</a>
			<div style="padding-top: 10px;" id="easypost-results"></div>
		</div>	
		 <script type="text/javascript">
		 	jQuery('body').on('click', '.print',function(e){
		   		e.preventDefault();
				var image = jQuery(this).data("imgid");
		   		var target = e.currentTarget; 
		   		var img = jQuery(target).parent().find('img');
		   		var imgid = jQuery(target).attr('imgid');
		    	var thePopup = window.open( image, "", "menubar=0,location=0" );
		    	setTimeout(function(){thePopup.print()}, 500);
			});
		</script>
 		<?php
	}
}