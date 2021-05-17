# Changelog

## 1.7
*   Added "Call Vendor" button to driver's order details in `ddwc-pro-dokan-settings.php`
*   Added error message if activated without DDWC activated first in `delivery-drivers-for-woocommerce-pro.php`
*   Added trigger for 'driver assigned' email when driver updated manually on the Edit Order screen in ` delivery-drivers-for-woocommerce-pro.php`
*   Bugfix order completed email not sending to administrator due to Twilio SMS conflict `emails/class-wc-order-completed.php`
*   Bugfix driver assignd email not sending to driver due to Twilio SMS conflict `emails/class-wc-order-driver-assigned.php`
*   Bugfix out for delivery email not sending to customer due to Twilio SMS conflict `emails/class-wc-order-out-for-delivery.php`
*   Updated text strings for localization in `languages/ddwc-pro.pot`
*   General code cleanup in various areas throughout the plugin

## 1.6
*   Added `ddwc_pro_driver_dashboard_unclaimed_orders_button_url` filter in `ddwc-pro-dashboard-shortcode.php`
*   Added `ddwc_pro_driver_dashboard_unclaimed_orders_table_address` filter in `ddwc-pro-dashboard-shortcode.php`
*   Added `ddwc_pro_my_account_endpoint_title_unclaimed_orders` filter in `ddwc-pro-woocomerce-account-tab.php`
*   Updated the `ddwc_pro_unclaimed_orders_link` filter in `delivery-drivers-for-woocommerce-pro.php`
*   Updated the `ddwc_pro_claim_order_redirect_url` filter in `ddwc-pro-dashboard-shortcode.php`
*   Updated the `ddwc_pro_back_to_driver_dashboard_link` filter in `ddwc-pro-dashboard-shortcode.php`
*   Updated checkout to only display SMS checkbox if SMS message types setting is selected in `delivery-drivers-for-woocommerce-pro.php`
*   Updated text strings for localization in `languages/ddwc-pro.pot`
*   General code cleanup in various areas throughout the plugin

## 1.5
*   Added support for Dokan multivendor plugin that includes vendor addresses as waypoints in driver dashboard order details in `ddwc-pro-dokan-settings.php`
*   Added the "Driver Dashboard" link to My Account menu items if Driver Application is on in `delivery-drivers-for-woocommerce-pro.php`
*   Added `ddwc_pro_assign_driver_drivers_array` filter in `delivery-drivers-for-woocommerce-pro.php`
*   Added `ddwc_pro_unclaimed_orders_table_before` action hook in `ddwc-pro-dashboard-shortcode.php`
*   Added `ddwc_pro_unclaimed_orders_table_tbody_before` action hook in `ddwc-pro-dashboard-shortcode.php`
*   Added `ddwc_pro_driver_dashboard_unclaimed_orders_button_text` filter in `ddwc-pro-dashboard-shortcode.php`
*   Added `ddwc_pro_unclaimed_orders_table_tbody_after` action hook in `ddwc-pro-dashboard-shortcode.php`
*   Added `ddwc_pro_back_to_driver_dashboard_buton` filter in `ddwc-pro-dashboard-shortcode.php`
*   Added `ddwc_pro_unclaimed_orders_table_after` action hook in `ddwc-pro-dashboard-shortcode.php`
*   Added `ddwc_pro_assign_drivers_order_statuses` filter in `delivery-drivers-for-woocommerce-pro.php`
*   Added `ddwc_pro_my_account_check_user_role_array` filter in `delivery-drivers-for-woocommerce-pro.php`
*   Added `car_color`, `car_model` and `transportation_type` to the driver endpoint data in `delivery-drivers-for-woocommerce-pro.php`
*   Added `post_parent` to args for orders list, which stops sub-orders (from multivendor plugins) from showing in `ddwc-pro-dashboard-shortcode.php`
*   Bugfix updated the `billing_phone` and `billing_email` for driver details used when sending order info in `emails/class-wc-order-driver-assigned.php`
*   Bugfix removes requirement that customer checks yes for SMS messages when sending to admin in `emails/class-wc-order-completed.php`
*   Bugfix removes requirement that customer checks yes for SMS messages when sending to driver in `emails/class-wc-order-driver-assigned.php`
*   Bugfix use billing_phone instead of phone_number for driver endpoint data in `delivery-drivers-for-woocommerce-pro.php`
*   Updated auto-assigning driver array to only add driver if their availability is on in `delivery-drivers-for-woocommerce-pro.php`
*   Updated access denied message to `echo` instead of `return` in `ddwc-pro-dashboard-shortcode.php`
*   General code cleanup in various areas throughout the plugin

## 1.4
*   Added 6 new filters for the driver dashboard in `admin/ddwc-pro-dashboard-shortcode.php`
*   Added 2 new action hooks for the driver dashboard in `admin/ddwc-pro-dashboard-shortcode.php`
*   Added `ddwc_pro_my_account_menu_item_unclaimed_orders` filter in `ddwc-pro-woocommerce-account-tab.php`
*   Updated title text on Delivery Drivers WooCommerce Settings page in `ddwc-pro-dashboard-shortcode.php`
*   Updated `.pot` file for localization in `languages/ddwc-pro.pot`
*   Updated text strings for localization in various files throughout the plugin
*   General code cleanup in various areas throughout the plugin

## 1.3
*   Added required files for Twilio in `vendors/twilio/`
*   Added `ddwc_pro_unclaimed_orders` filter in `delivery-drivers-for-woocommerce-pro.php`
*   Added `ddwc_pro_order_completed_sms_admin_phone` filter in `emails/class-wc-order-completed.php`
*   Added `ddwc_pro_order_completed_sms_message` filter in `emails/class-wc-order-completed.php`
*   Added `ddwc_pro_order_driver_assigned_sms_message` filter in `emails/class-wc-order-driver-assigned.php`
*   Added `ddwc_pro_order_out_for_delivery_sms_message` filter in `emails/class-wc-order-out-for-delivery.php`
*   Added message type and Twilio SMS WooCommerce Settings in `delivery-drivers-for-woocommerce-pro.php`
*   Added checkout setting to receive SMS updates in `delivery-drivers-for-woocommerce-pro.php`
*   Updated addressess in Unclaimed Orders list to remove country in `ddwc-pro-dashboard-shortcode.php`
*   Updated empty driver ID to display Unclaimed Orders in `ddwc-pro-dashboard-shortcode.php`
*   Updated WooCommerce email to send SMS if settings are active in `emails/class-wc-order-completed.php`
*   Updated WooCommerce email to send SMS if settings are active in `emails/class-wc-order-driver-assigned.php`
*   Updated WooCommerce email to send SMS if settings are active in `emails/class-wc-order-out-for-delivery.php`
*   WordPress Coding Standards updates in various files throughout the plugin
*   Updated `.pot` file for localization in `languages/ddwc-pro.pot`

## 1.2.1
*   Added the completed orders table function to new DDWC action hook in `delivery-drivers-for-woocommerce-pro.php`
*   Added filter for a back to Driver Dashboard link on the Unclaimed Orders page in `ddwc-pro-dashboard-shortcode.php`
*   Updated text strings for localization in `ddwc-pro-dashboard-shortcode.php`
*   Updated `.pot` file for localization in `languages/ddwc-pro.pot`
*   General code cleanup in various areas throughout the plugin

## 1.2
*   Added WooCommerce account tab codes for `Unclaimed Orders` in `ddwc-pro-woocommerce-account-tab.php`
*   Added `Unclaimed Orders` tab shortcode in `ddwc-pro-dashboard-shortcode.php`
*   Add `Unclaimed Orders` link to Driver Dashoard in `delivery-drivers-for-woocommerce-pro.php`
*   Updated `.pot` for localization in `languages/ddwc-pro.pot`

## 1.1
*   Added Customer's "Out for Delivery" email setup with other WooCommerce Emails in `delivery-drivers-for-woocommerce-pro.php`
*   Added "Order delivered" email when order status is changed from "out for delivery" to "completed" by driver in `delivery-drivers-for-woocommerce-pro.php`
*   Added "Order assigned" email sent to delivery driver when they're assigned an order in `delivery-drivers-for-woocommerce-pro.php`
*   Updated code to remove the auto-assign function's email sending via wp_mail in `delivery-drivers-for-woocommerce-pro.php`
*   Updated description text for WooCommerce settings in `delivery-drivers-for-woocommerce-pro.php`
*   Updated text strings for localization in `delivery-drivers-for-woocommerce-pro.php`
*   Updated `.pot` for localization in `languages/ddwc-pro.pot`
*   General code cleanup in various areas throughout the plugin

## 1.0
*   Initial release
