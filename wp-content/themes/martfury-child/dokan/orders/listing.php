<?php
global $woocommerce;

$seller_id      = dokan_get_current_user_id();
$limit          = 10;
$customer_id    = isset( $_GET['customer_id'] ) ? sanitize_key( $_GET['customer_id'] ) : null;
$order_status   = isset( $_GET['order_status'] ) ? sanitize_key( $_GET['order_status'] ) : 'all';
$paged          = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
$order_date     = isset( $_GET['order_date'] ) ? sanitize_key( $_GET['order_date'] ) : NULL;
$order_statuses = apply_filters( 'dokan_bulk_order_statuses', [
                    '-1'            => __( 'Bulk Actions', 'dokan-lite' ),
                    'wc-on-hold'    => __( 'Change status to on-hold', 'dokan-lite' ),
                    'wc-processing' => __( 'Change status to processing', 'dokan-lite' ),
                    'wc-completed'  => __( 'Change status to completed', 'dokan-lite' )
                ] );

$user_orders  = dokan()->vendor->get( $seller_id )->get_orders( [
                    'customer_id' => $customer_id,
                    'status'      => $order_status,
                    'paged'       => $paged,
                    'limit'       => $limit,
                    'date'        => $order_date
                ] );

if ( $user_orders ) {
    ?>
    <form id="order-filter" method="POST" class="dokan-form-inline">
        <?php if( dokan_get_option( 'order_status_change', 'dokan_selling', 'on' ) == 'on' ) : ?>
            <!--<div class="dokan-form-group">
                <label for="bulk-order-action-selector" class="screen-reader-text"><?php esc_html_e( 'Select bulk action', 'dokan-lite' ); ?></label>

                <select name="status" id="bulk-order-action-selector" class="dokan-form-control chosen">
                    <?php //foreach ( $order_statuses as $key => $value ) : ?>
                        <option class="bulk-order-status" value="<?php //echo esc_attr( $key ) ?>"><?php //echo esc_attr( $value ); ?></option>
                    <?php// endforeach; ?>
                </select>
            </div>

            <div class="dokan-form-group">
                <?php // wp_nonce_field( 'bulk_order_status_change', 'security' ); ?>
                <input type="submit" name="bulk_order_status_change" id="bulk-order-action" class="dokan-btn dokan-btn-theme" value="<?php //esc_attr_e( 'Apply', 'dokan-lite' ); ?>">
            </div>-->
        <?php endif; ?>
        <table class="dokan-table dokan-table-striped">
            <thead>
                <tr>
                    <th id="cb" class="manage-column column-cb check-column">
                        <label for="cb-select-all"></label>
                        <input id="cb-select-all" class="dokan-checkbox" type="checkbox">
                    </th>
                    <th><?php esc_html_e( 'Order', 'dokan-lite' ); ?></th>
                    <th><?php esc_html_e( 'Order Total', 'dokan-lite' ); ?></th>
                    <th><?php esc_html_e( 'Earning', 'dokan-lite' ); ?></th>
                    <th><?php esc_html_e( 'Status', 'dokan-lite' ); ?></th>
                    <th><?php esc_html_e( 'Customer', 'dokan-lite' ); ?></th>
                    <th><?php esc_html_e( 'Date', 'dokan-lite' ); ?></th>
                    <th><?php esc_html_e( 'Driver', 'dokan-lite' ); ?></th>
                    <?php if ( current_user_can( 'dokan_manage_order' ) ): ?>
                        <th width="17%"><?php esc_html_e( 'Action', 'dokan-lite' ); ?></th>
                    <?php endif ?>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($user_orders as $order) {
                    ?>
                    <tr >
                        <td class="dokan-order-select">
                            <label for="cb-select-<?php echo esc_attr( $order->get_id() ); ?>"></label>
                            <input class="cb-select-items dokan-checkbox" type="checkbox" name="bulk_orders[]" value="<?php echo esc_attr( $order->get_id() ); ?>">
                        </td>
                        <td class="dokan-order-id" data-title="<?php esc_attr_e( 'Order', 'dokan-lite' ); ?>" >
                            <?php if ( current_user_can( 'dokan_view_order' ) ): ?>
                                <?php echo '<a href="' . esc_url( wp_nonce_url( add_query_arg( array( 'order_id' => dokan_get_prop( $order, 'id' ) ), dokan_get_navigation_url( 'orders' ) ), 'dokan_view_order' ) ) . '"><strong>' . sprintf( __( 'Order %s', 'dokan-lite' ), esc_attr( $order->get_order_number() ) ) . '</strong></a>'; ?>
                            <?php else: ?>
                                <?php echo '<strong>' . sprintf( __( 'Order %s', 'dokan-lite' ), esc_attr( $order->get_order_number() ) ) . '</strong>'; ?>
                            <?php endif ?>
                        </td>
                        <td class="dokan-order-total" data-title="<?php esc_attr_e( 'Order Total', 'dokan-lite' ); ?>" >
                            <?php echo $order->get_formatted_order_total(); ?>
                        </td>
                        <td class="dokan-order-earning" data-title="<?php esc_attr_e( 'Earning', 'dokan-lite' ); ?>" >
                            <?php echo wp_kses_post( wc_price( dokan()->commission->get_earning_by_order( $order ) ) ); ?>
                        </td>
                        <td class="dokan-order-status" data-title="<?php esc_attr_e( 'Status', 'dokan-lite' ); ?>" >
                        	
                            <?php if(empty(dokan_get_order_status_class( dokan_get_prop( $order, 'status' )))){
								echo '<span class="dokan-label dokan-label-default">' . dokan_get_prop( $order, 'status' ). '</span>';
								}else{
                        			echo '<span class="dokan-label dokan-label-' . dokan_get_order_status_class( dokan_get_prop( $order, 'status' ) ) . '">' . dokan_get_order_status_translated( dokan_get_prop( $order, 'status' ) ) . '</span>'; ?>
                            <?php } ?>
                        </td>
                        <td class="dokan-order-customer" data-title="<?php esc_attr_e( 'Customer', 'dokan-lite' ); ?>" >
                            <?php
                            $user_info = '';

                            if ( $order->get_user_id() ) {
                                $user_info = get_userdata( $order->get_user_id() );
                            }

                            if ( !empty( $user_info ) ) {

                                $user = '';

                                if ( $user_info->first_name || $user_info->last_name ) {
                                    $user .= esc_html( $user_info->first_name . ' ' . $user_info->last_name );
                                } else {
                                    $user .= esc_html( $user_info->display_name );
                                }

                            } else {
                                $user = __( 'Guest', 'dokan-lite' );
                            }

                            echo esc_html( $user );
                            ?>
                        </td>
                        <td class="dokan-order-date" data-title="<?php esc_attr_e( 'Date', 'dokan-lite' ); ?>" >
                            <?php
                            if ( '0000-00-00 00:00:00' == dokan_get_date_created( $order ) ) {
                                $t_time = $h_time = __( 'Unpublished', 'dokan-lite' );
                            } else {
                                $t_time    = get_the_time( 'Y/m/d g:i:s A', dokan_get_prop( $order, 'id' ) );
                                $gmt_time  = strtotime( dokan_get_date_created( $order ) . ' UTC' );
                                $time_diff = current_time( 'timestamp', 1 ) - $gmt_time;

                                if ( $time_diff > 0 && $time_diff < 24 * 60 * 60 ) {
                                    $h_time = sprintf( __( '%s ago', 'dokan-lite' ), human_time_diff( $gmt_time, current_time( 'timestamp', 1 ) ) );
                                } else {
                                    $h_time = get_the_time( 'Y/m/d', dokan_get_prop( $order, 'id' ) );
                                }
                            }

                            echo '<abbr title="' . esc_attr( dokan_date_time_format( $t_time ) ) . '">' . esc_html( apply_filters( 'post_date_column_time', dokan_date_time_format( $h_time, true ) , dokan_get_prop( $order, 'id' ) ) ) . '</abbr>';
                            ?>
                        </td>
                        <td class="select_driverbl">
                        <?php 
						$order = wc_get_order( dokan_get_prop( $order, 'id' ) );
							foreach ( $order->get_items() as $item_id => $item ) {
									$product_id = $item->get_product_id();
									$author_id = get_post_field ('post_author', $product_id);
							}
							$shop_info_n    = get_user_meta( $author_id, 'dokan_profile_settings', true );
							
							$search = 'Home Delivery';
							$search2 = 'Distance Rate';
						if(preg_match("/{$search}/i", $order->get_shipping_method()) || preg_match("/{$search2}/i", $order->get_shipping_method())) {
							
						
						$vendor_id   = dokan_get_current_user_id();
						$assigned_driverid = get_post_meta( dokan_get_prop( $order, 'id' ), 'ddwc_driver_id', true );
						$args = array(
							'role'    => 'driver',
							'orderby' => 'user_nicename',
							'order'   => 'ASC',
							'meta_key' => 'driver_vendor', 
							'meta_value' => $vendor_id,
							'meta_compare' => "LIKE",
						);
						$users = get_users( $args );
						$available_drivers = array();
						foreach ( $users as $user ) {
							if ( get_user_meta( $user->ID, 'ddwc_driver_availability', true ) && get_user_meta( $user->ID, 'vendor_needs', true ) == 'active' ) {
							// Add driver to availabile list.
								$available_drivers[$user->ID] = $user->display_name;
							
							}
						}
						
						?>
                        
                        <?php if($available_drivers) {?>
                        <select class="driver_list dokan-form-control dokan-select2 select2-hidden-accessible" data-orderid="<?php echo dokan_get_prop( $order, 'id' ); ?>">
                        <option>-Select Driver-</option>
                        <?php 
						foreach ( $available_drivers as $key => $val ) {
							if($assigned_driverid == $key){
									echo '<option value="' . $key . '" selected="selected"> ' . $val . '</option>';
								}else{
    								echo '<option value="' . $key . '"> ' . $val . '</option>';
							}
						}
						?>
                        </select>
                        <span id="loading-<?php echo dokan_get_prop( $order, 'id' ); ?>"class="loading_dr" style="display:none;"><img src="<?php echo get_site_url(); ?>/wp-content/themes/martfury-child/image/preloader.gif" width="30px"></span>
                        <?php } 
						}else{
							
							echo '<p class="shp_mthd">'.$order->get_shipping_method().'</p>';
							
							}
						?>
                        
                        
                        
                        </td>
                        <?php if ( current_user_can( 'dokan_manage_order' ) ): ?>
                            <td class="dokan-order-action" width="17%" data-title="<?php esc_attr_e( 'Action', 'dokan-lite' ); ?>" >
                                <?php
                                do_action( 'woocommerce_admin_order_actions_start', $order );

                                $actions = array();

                                if ( dokan_get_option( 'order_status_change', 'dokan_selling', 'on' ) == 'on' ) {
                                    if ( in_array( dokan_get_prop( $order, 'status' ), array( 'pending', 'on-hold' ) ) ) {
                                        $actions['processing'] = array(
                                            'url' => wp_nonce_url( admin_url( 'admin-ajax.php?action=dokan-mark-order-processing&order_id=' . dokan_get_prop( $order, 'id' ) ), 'dokan-mark-order-processing' ),
                                            'name' => __( 'Processing', 'dokan-lite' ),
                                            'action' => "processing",
                                            'icon' => '<i class="fa fa-clock-o">&nbsp;</i>'
                                        );
                                    }

                                    if ( in_array( dokan_get_prop( $order, 'status' ), array( 'local-pickup', 'pending', 'on-hold', 'processing' ) ) ) {
                                        $actions['complete'] = array(
                                            'url' => wp_nonce_url( admin_url( 'admin-ajax.php?action=dokan-mark-order-complete&order_id=' . dokan_get_prop( $order, 'id' ) ), 'dokan-mark-order-complete' ),
                                            'name' => __( 'Complete', 'dokan-lite' ),
                                            'action' => "complete",
                                            'icon' => '<i class="fa fa-check">&nbsp;</i>'
                                        );
                                    }

                                }

                                $actions['view'] = array(
                                    'url' => wp_nonce_url( add_query_arg( array( 'order_id' => dokan_get_prop( $order, 'id' ) ), dokan_get_navigation_url( 'orders' ) ), 'dokan_view_order' ),
                                    'name' => __( 'View', 'dokan-lite' ),
                                    'action' => "view",
                                    'icon' => '<i class="fa fa-eye">&nbsp;</i>'
                                );

                                $actions = apply_filters( 'woocommerce_admin_order_actions', $actions, $order );

                                foreach ($actions as $action) {
                                    $icon = ( isset( $action['icon'] ) ) ? $action['icon'] : '';
									
                                    if($order->get_shipping_method() == 'In-store-pick-up'){
									printf( '<span class="'.esc_attr( $action['name'] ).'_btn"><a class="dokan-btn dokan-btn-default dokan-btn-sm tips" href="%s" data-toggle="tooltip" data-orderid="'. dokan_get_prop( $order, 'id' ).'"data-placement="top" title="%s">%s</a></span> ', esc_url( $action['url'] ), esc_attr( $action['name'] ), $icon );
									}else{
									if($action['name'] != 'Complete'){
										printf( '<span class="simple_btn"><a class="dokan-btn dokan-btn-default dokan-btn-sm tips" href="%s" data-toggle="tooltip" data-orderid="'. dokan_get_prop( $order, 'id' ).'"data-placement="top" title="%s">%s</a></span> ', esc_url( $action['url'] ), esc_attr( $action['name'] ), $icon );
									}
									}
									
									  
                                }

                                do_action( 'woocommerce_admin_order_actions_end', $order );
                                ?>
                                
                                <?php $status_otp = dokan_get_order_status_class( dokan_get_prop( $order, 'status' ) ); 
                                $ship_status = $order->get_shipping_method(); ?>
                                
                               
                                
                                <div class="otpmatch" id="otpmatch-<?php echo dokan_get_prop( $order, 'id' );?>" style="display: none;">
                                    <!--<span id="close_icn" class="close_icn">+</span>-->
                                    <div class="loding_icon" style="display:none;">
                                        <img class="loding_img" src="<?php echo get_stylesheet_directory_uri().'/image/preloader.gif'?>" />
                                    </div>
                                    <div class="otpmatch_section">
                                        <form action="#" method="post">
                                          <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
                                            <label for="order_otp">Enter OTP<span class="required">*</span></label>
                                            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="order_otp" id="order_otp" autocomplete="given-name" value="" required="">
                                            <input type="hidden" value="<?php echo dokan_get_prop( $order, 'id' );?>" id="otporder" name="otporder">
                                          </p>
                                          <button type="submit" data-orderid="<?php echo dokan_get_prop( $order, 'id' ); ?>" class="woocommerce-Button button otpsubmit" name="save_account_details" value="Save changes">Submit</button>
                                        </form>
                                    </div>
                                </div>
                                
                            </td>
                        <?php endif ?>
                        <!--<td class="diviader"></td>-->
                    </tr>

                <?php } ?>

            </tbody>

        </table>
    </form>
    
  <!-- <div class="otpmatch" style="display:none;"><div class="otpmatch_section">
	<form action="#" method="post">
<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
<label for="order_otp">Enter OTP<span class="required">*</span></label>
<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="order_otp" id="order_otp" autocomplete="given-name" value="" required>
</p>
<button type="submit" class="woocommerce-Button button otpsubmit" name="save_account_details" value="Save changes">Submit</button>
</form>
</div>
</div>-->

    <?php
    $order_count = dokan_get_seller_orders_number( $seller_id, $order_status );

    // if date is selected then calculate number_of_pages accordingly otherwise calculate number_of_pages =  ( total_orders / limit );
    if ( ! is_null( $order_date ) ) {
        if ( count( $user_orders ) >= $limit ) {
            $num_of_pages = ceil ( ( ( $order_count + count( $user_orders ) ) - count( $user_orders ) ) / $limit );
        } else {
            $num_of_pages = ceil( count( $user_orders ) / $limit );
        }
    } else {
        $num_of_pages = ceil( $order_count / $limit );
    }


    $base_url  = dokan_get_navigation_url( 'orders' );

    if ( $num_of_pages > 1 ) {
        echo '<div class="pagination-wrap">';
        $page_links = paginate_links( array(
            'current'   => $paged,
            'total'     => $num_of_pages,
            'base'      => $base_url. '%_%',
            'format'    => '?pagenum=%#%',
            'add_args'  => false,
            'type'      => 'array',
        ) );

        echo "<ul class='pagination'>\n\t<li>";
        echo join("</li>\n\t<li>", $page_links);
        echo "</li>\n</ul>\n";
        echo '</div>';
    }
    ?>

<?php } else { ?>

    <div class="dokan-error">
        <?php esc_html_e( 'No orders found', 'dokan-lite' ); ?>
    </div>

<?php } ?>

<script>
    (function($){
        $(document).ready(function(){
            $('.datepicker').datepicker({
                dateFormat: 'yy-m-d'
            });
        });
    })(jQuery);
</script>
