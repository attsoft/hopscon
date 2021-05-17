<?php

/**
 * Fired during plugin activation
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Mwb_Woocommerce_Multiple_Shipping_Address
 * @subpackage Mwb_Woocommerce_Multiple_Shipping_Address/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Mwb_Woocommerce_Multiple_Shipping_Address
 * @subpackage Mwb_Woocommerce_Multiple_Shipping_Address/includes
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Mwb_Woocommerce_Multiple_Shipping_Address_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		$timestamp = get_option( 'mwb_woocommerce_multiple_shipping_address_lcns_thirty_days', 'not_set' );

		if( 'not_set' === $timestamp ){

			$current_time = current_time( 'timestamp' );

			$thirty_days =  strtotime( '+30 days', $current_time );

			update_option( 'mwb_woocommerce_multiple_shipping_address_lcns_thirty_days', $thirty_days );
		}

		// Validate license daily cron.
		wp_schedule_event( time(), 'daily', 'mwb_woocommerce_multiple_shipping_address_license_daily' );

	}

}
