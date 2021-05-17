<?php
/**
 * The Unclaimed Orders Shortcode.
 *
 * @link       https://www.deviodigital.com
 * @since      1.0.0
 *
 * @package    DDWC_Pro
 * @subpackage DDWC_Pro/admin
 */
function ddwc_pro_dashboard_shortcode() {

	// Check if user is logged in.
	if ( is_user_logged_in() ) {
		// Get the user ID.
		$user_id = get_current_user_id();

		// Get the user object.
		$user_meta = get_userdata( $user_id );

		// If user_id doesn't equal zero.
		if ( 0 != $user_id ) {

			// If claim delivery button is pushed.
			if ( ! empty( $_GET['claim_delivery'] ) ) {

				// Get deliver ID to claim.
				$claim_delivery = $_GET['claim_delivery'];

				// Update order status.
				$order = wc_get_order( $claim_delivery );
				$order->update_status( 'driver-assigned' );

				// Update order with driver ID.
				update_post_meta( $claim_delivery, 'ddwc_driver_id', $user_id, -1 );

				// Redirect URL.
				$redirect_url = apply_filters( 'ddwc_pro_claim_order_redirect_url', get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) . '/driver-dashboard/?orderid=' . $claim_delivery.'&claim=claimed', $claim_delivery );

				// Redirect driver to the order details.
				wp_redirect( $redirect_url );
			}

			// Get all the user roles as an array.
			$user_roles = $user_meta->roles;

			// Check if the role you're interested in, is present in the array.
			if ( in_array( 'driver', $user_roles, true ) ) {

				// Set variable for driver ID.
				if ( isset( $_GET['orderid'] ) && ( '' != $_GET['orderid'] ) ) {
					$driver_id = get_post_meta( $_GET['orderid'], 'ddwc_driver_id', true );
				}

				/**
				 * Args for Orders with no driver ID attached.
				 */
				$args = array(
					'post_type'      => 'shop_order',
					'posts_per_page' => -1,
					'post_status'    => 'any',
					'post_parent'    => 0
				);

				/**
				 * Get Orders with Driver ID attached
				 */
				$unclaimed_orders = get_posts( $args );

				/**
				 * If there are orders to loop through.
				 */
				if ( $unclaimed_orders ) {

					// Total for table thead.
					$total_title = '<td>' . esc_attr__( 'Total', 'ddwc' ) . '</td>';

					do_action( 'ddwc_pro_unclaimed_orders_table_before' );
					echo '<h3 class="ddwc assigned-orders">Unclaimed Orders</h3>';
					echo '<table class="ddwc-dashboard">';
					echo '<thead><tr><td>' . esc_attr__( 'Date', 'ddwc-pro' ) . '</td><td>' . esc_attr__( 'Address', 'ddwc-pro' ) . '</td>' . apply_filters( 'ddwc_pro_driver_dashboard_unclaimed_orders_total_title', $total_title ) . '<td></td></tr></thead>';
					echo '<tbody>';

					do_action( 'ddwc_pro_unclaimed_orders_table_tbody_before' );

					foreach ( $unclaimed_orders as $driver_order ) {

						// Get Driver ID (if set).
						$driver_id_setting = get_post_meta( $driver_order->ID, 'ddwc_driver_id', TRUE );

						// Get an instance of the WC_Order object.
						$order = wc_get_order( $driver_order->ID );

						// Get the required order data.
						$order_data         = $order->get_data();
						$currency_code      = $order_data['currency'];
						$currency_symbol    = get_woocommerce_currency_symbol( $currency_code );
						$order_id           = $order_data['id'];
						$order_status       = $order_data['status'];
						$order_date_created = $order_data['date_created']->date( 'm-d-Y' );

						## CART INFORMATION:

						$order_total = $order_data['total'];

						## BILLING INFORMATION:

						$order_billing_city     = $order_data['billing']['city'];
						$order_billing_state    = $order_data['billing']['state'];
						$order_billing_postcode = $order_data['billing']['postcode'];

						## SHIPPING INFORMATION:

						$order_shipping_city     = $order_data['shipping']['city'];
						$order_shipping_state    = $order_data['shipping']['state'];
						$order_shipping_postcode = $order_data['shipping']['postcode'];

						// Create address to use in the table.
						$address = $order_billing_city . ' ' . $order_billing_state . ', ' . $order_billing_postcode;

						// Set address to shipping (if available).
						if ( isset( $order_shipping_city ) ) {
							$address = $order_shipping_city . ' ' . $order_shipping_state . ', ' . $order_shipping_postcode;
						}

						// Allowed statuses.
						$status_array = apply_filters( 'ddwc_pro_driver_dashboard_unclaimed_orders_status_array', array( 'processing' ) );

						// Display unassigned orders.
						if ( in_array( $order_status, $status_array ) && ( -1 == $driver_id_setting || '' === $driver_id_setting ) ) {
							echo '<tr>';

							echo '<td>' . $order_date_created . '</td>';
							echo '<td>' . apply_filters( 'ddwc_pro_driver_dashboard_unclaimed_orders_table_address', $address ) . '</td>';

							if ( isset( $order_total ) ) {
								$order_total = '<td>'  . $currency_symbol . $order_total . '</td>';
								echo apply_filters( 'ddwc_pro_driver_dashboard_unclaimed_orders_total', $order_total );
							} else {
								echo '<td>-</td>';
							}

							echo '<td><a href="' . apply_filters( 'ddwc_pro_driver_dashboard_unclaimed_orders_button_url', '?claim_delivery=' . $order_id, $order_id ) . '" class="button">' . apply_filters( 'ddwc_pro_driver_dashboard_unclaimed_orders_button_text', __( 'CLAIM', 'ddwc-pro' ) ) . '</a></td>';

							echo '</tr>';
						} else {
							// Do nothing.
						}
					}

					do_action( 'ddwc_pro_unclaimed_orders_table_tbody_after' );

					echo '</tbody>';
					echo '</table>';

					do_action( 'ddwc_pro_unclaimed_orders_table_after' );

					// Driver dashboard button.
					$dashboard_button = '<a href="' . apply_filters( 'ddwc_pro_back_to_driver_dashboard_link', get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) . 'driver-dashboard/' ) . '">&larr; ' . __( 'Driver Dashboard', 'ddwc-pro' ) . '</a>';

					// Filter "Driver Dashboard" button.
					echo apply_filters( 'ddwc_pro_back_to_driver_dashboard_button', $dashboard_button );

				} else {

					do_action( 'ddwc_pro_assigned_orders_empty_before' );

					// Message - No assigned orders.
					$empty  = '<h3 class="ddwc assigned-orders">' . __( 'Assigned Orders', 'ddwc-pro' ) . '</h3>';
					$empty .= '<p>' . __( 'You do not have any assigned orders.', 'ddwc-pro' ) . '</p>';

					echo apply_filters( 'ddwc_pro_assigned_orders_empty', $empty );

					do_action( 'ddwc_pro_assigned_orders_empty_after' );

				}
			} else {

				// Set the Access Denied page text.
				$access_denied = '<h3 class="ddwc access-denied">' . __( 'Access Denied', 'ddwc-pro' ) . '</h3><p>' . __( 'Sorry, but you are not able to view this page.', 'ddwc-pro' ) . '</p>';

				// Filter Access Denied text.
				echo apply_filters( 'ddwc_access_denied', $access_denied );
			}

		} else {
			// Do nothing.
		}
	} else {
		apply_filters( 'ddwc_pro_dashboard_login_form', wp_login_form() );
	}
}
add_shortcode( 'ddwc_pro_dashboard', 'ddwc_pro_dashboard_shortcode' );
