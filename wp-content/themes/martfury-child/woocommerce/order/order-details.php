<?php
/**
 * Order details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

$order = wc_get_order( $order_id ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited

if ( ! $order ) {
	return;
}

$order_items           = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );
$show_purchase_note    = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) );
$show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();
$downloads             = $order->get_downloadable_items();
$show_downloads        = $order->has_downloadable_item() && $order->is_download_permitted();

if ( $show_downloads ) {
	wc_get_template(
		'order/order-downloads.php',
		array(
			'downloads'  => $downloads,
			'show_title' => true,
		)
	);
}
?>
<section class="woocommerce-order-details fgfg">
	<?php do_action( 'woocommerce_order_details_before_order_table', $order ); ?>
    <div class="orderdeail">
    <div class="left_tit">
	<h2 class="woocommerce-order-details__title"><?php esc_html_e( 'Order details', 'woocommerce' ); ?></h2>
    </div>
    <div class="right_btns">
        <?php 
        $orderkey = $order->get_order_key(); 
        $order_id = $order->get_id();
		foreach ( $order->get_items() as $item_id => $item ) {
		   $product_id = $item->get_product_id();
		}
		
		$author_id  = get_post_field( 'post_author', $product_id );
			
			$author_id  = get_post_field( 'post_author', $product_id );
	
            if ( empty( $store_id ) ) {
            $store_user = get_post_field( 'post_author', $product_id );
        }

        if ( is_user_logged_in() ) {
            $user_logged_in = 'user_logged';
        } else {
            $user_logged_in = 'user_logged_out';
        }
        $disabled = '';

        $store_info = dokan_get_store_info( $author_id );

        if ( isset( $store_info['show_support_btn'] ) && $store_info['show_support_btn'] == 'no' ) {
            return;
        }

        $support_text = isset( $store_info['support_btn_name'] ) && !empty( $store_info['support_btn_name'] ) ? $store_info['support_btn_name'] : __( 'Get Support', 'dokan' );
        ?>
        
        <?php if ($order->get_status() != 'completed' && $order->get_status() != 'cancelled') { 
        	echo $nonce = $_REQUEST['_wpnonce'];?>

         <!-- <a href="https://hopscan-stg.com/cart/?cancel_order=true&amp;order=<?php echo $order->order_key; ?>&amp;order_id=<?php echo $order_id; ?>&amp;redirect=http%3A%2F%2Fhopscan-stg.com%2Fmy-account%2F&amp;_wpnonce=$nonce" class="woocommerce-button button cancel custom-tooltip view_cancel_order">Cancel Order</a> -->
         <?php  
         $redirect_url = home_url().'/my-account/orders/';

         ?>
            <button class="cancel_order" id="myBtn">Cancel order</button>
			<!-- The Modal -->
			<div id="myModal" class="modal">
			  <!-- Modal content -->
			  <div class="modal-content">
			    <span class="close">&times;</span>
			    	<p>If you want really cancel this order, click on cancel button !</p>
			     <a href="<?php echo get_site_url(); ?>cart/?cancel_order=true&amp;order=<?php echo $orderkey; ?>&amp;order_id=<?php echo $order_id;?>&amp;redirect=<?php echo get_site_url(); ?>%2Fmy-account%2Forders%2F&amp;_wpnonce=<?php echo wp_create_nonce( 'woocommerce-cancel_order' ); ?>" class="woocommerce-button button cancel custom-tooltip view_cancel_order">Cancel Order</a>
			  </div>
			</div>
    	<?php } ?>
        <button data-store_id="<?php echo $author_id; ?>" class="get_support_view_order dokan-store-support-btn dokan-btn dokan-btn-theme dokan-btn-sm <?php echo $user_logged_in ?>">
            <?php echo esc_html( $support_text ); ?>
        </button> 
   
	<a href="<?php echo home_url()?>/my-account/orders/" class="woocommerce-order-backbtn btn"><?php esc_html_e( 'Back to orders', 'woocommerce' ); ?></a>
    
    <?php $allowed_status = dokan_get_option( 'rma_order_status', 'dokan_rma', 'wc-completed' ); 
		if ( $allowed_status == 'wc-' . $order->get_status() ) {
			 $url = esc_url_raw( wc_get_account_endpoint_url( 'request-warranty' ) . $order->get_id() ) ;
           ?>
            <a href="<?php echo $url; ?>" class="woocommerce-order-backbtn btn"><?php esc_html_e( 'Request Warranty / Refund', 'woocommerce' ); ?></a>
  
           <?php
        }
	
	?>
    </div>
    
   
    </div>

	<table class="woocommerce-table woocommerce-table--order-details shop_table order_details">

		<thead>
			<tr>
				<th class="woocommerce-table__product-name product-name"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
				<th class="woocommerce-table__product-table product-total"><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
			</tr>
		</thead>

		<tbody>
			<?php
			do_action( 'woocommerce_order_details_before_order_table_items', $order );

			foreach ( $order_items as $item_id => $item ) {
				$product = $item->get_product();

				wc_get_template(
					'order/order-details-item.php',
					array(
						'order'              => $order,
						'item_id'            => $item_id,
						'item'               => $item,
						'show_purchase_note' => $show_purchase_note,
						'purchase_note'      => $product ? $product->get_purchase_note() : '',
						'product'            => $product,
					)
				);
			}

			do_action( 'woocommerce_order_details_after_order_table_items', $order );
			?>
		</tbody>

		<tfoot>
			<?php
			foreach ( $order->get_order_item_totals() as $key => $total ) {
				
				?>
					<tr>
						<th scope="row">
						
						<?php 
						// echo "<pre>";
						// print_r($order);
						// echo "</pre>";
						if($total['label'] == 'Shipping:'){

								$result = explode(':',$total['label']);
								echo esc_html( $result[0].' via '.$order->get_shipping_method().' :');
								}else{

									echo esc_html( $total['label'] );

								}
						 ?> 
                        
                        </th>
						<td><?php echo ( 'payment_method' === $key ) ? esc_html( $total['value'] ) : wp_kses_post( $total['value'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
					</tr>
					<?php
			}
			?>
			<?php if ( $order->get_customer_note() ) : ?>
				<tr>
					<th><?php esc_html_e( 'Note:', 'woocommerce' ); ?></th>
					<td><?php echo wp_kses_post( nl2br( wptexturize( $order->get_customer_note() ) ) ); ?></td>
				</tr>
			<?php endif; ?>
		</tfoot>
	</table>

	<?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>
</section>

<?php
if ( $show_customer_details ) {
	wc_get_template( 'order/order-details-customer.php', array( 'order' => $order ) );
}
