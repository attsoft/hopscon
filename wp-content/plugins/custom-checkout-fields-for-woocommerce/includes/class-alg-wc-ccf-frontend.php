<?php
/**
 * Custom Checkout Fields for WooCommerce - Frontend Class
 *
 * @version 1.5.0
 * @since   1.0.0
 * @author  Algoritmika Ltd.
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_CCF_Frontend' ) ) :

class Alg_WC_CCF_Frontend {

	/**
	 * Constructor.
	 *
	 * @version 1.4.0
	 * @since   1.0.0
	 */
	function __construct() {
		add_filter( 'woocommerce_checkout_fields',                array( $this, 'add_custom_checkout_fields' ), PHP_INT_MAX );
		add_filter( 'woocommerce_form_field_' . 'text',           array( $this, 'woocommerce_form_field_type_convert' ), PHP_INT_MAX, 4 );
		add_action( 'woocommerce_checkout_update_order_meta',     array( $this, 'update_custom_checkout_fields_order_meta' ) );
		add_action( 'woocommerce_cart_calculate_fees',            array( $this, 'add_fees' ), PHP_INT_MAX );
		add_filter( 'woocommerce_get_country_locale',             array( $this, 'get_country_locale' ), PHP_INT_MAX );
		add_filter( 'woocommerce_country_locale_field_selectors', array( $this, 'country_locale_field_selectors' ), PHP_INT_MAX );
	}

	/**
	 * country_locale_field_selectors.
	 *
	 * @version 1.4.0
	 * @since   1.4.0
	 */
	function country_locale_field_selectors( $locale_fields ) {
		for ( $i = 1; $i <= apply_filters( 'alg_wc_ccf_total_fields', 1 ); $i++ ) {
			if ( 'yes' === alg_wc_ccf_get_field_option( 'enabled', $i, 'no' ) ) {
				$countries = alg_wc_ccf_get_field_option( 'countries', $i, array() );
				if ( ! empty( $countries ) ) {
					$section = alg_wc_ccf_get_field_option( 'section', $i, 'billing' );
					$field   = ALG_WC_CCF_KEY . '_' . $i;
					$locale_fields[ $field ] = "#{$section}_{$field}_field";
				}
			}
		}
		return $locale_fields;
	}

	/**
	 * get_country_locale.
	 *
	 * @version 1.4.0
	 * @since   1.4.0
	 * @todo    [later] (important) maybe rewrite `show` action part, e.g. see `woocommerce_get_country_locale_default` filter
	 */
	function get_country_locale( $country_locale ) {
		for ( $i = 1; $i <= apply_filters( 'alg_wc_ccf_total_fields', 1 ); $i++ ) {
			if ( 'yes' === alg_wc_ccf_get_field_option( 'enabled', $i, 'no' ) ) {
				$countries = alg_wc_ccf_get_field_option( 'countries', $i, array() );
				if ( ! empty( $countries ) ) {
					if ( 'show' === alg_wc_ccf_get_field_option( 'countries_action', $i, 'hide' ) ) {
						$all_countries = WC()->countries->get_countries();
						$countries     = array_diff( array_keys( $all_countries ), $countries );
					}
					foreach ( $countries as $country ) {
						if ( ! isset( $country_locale[ $country ] ) ) {
							$country_locale[ $country ] = array();
						}
						$field = ALG_WC_CCF_KEY . '_' . $i;
						$country_locale[ $country ][ $field ] = array(
							'required' => false,
							'hidden'   => true,
						);
					}
				}
			}
		}
		return $country_locale;
	}

	/**
	 * add_fees.
	 *
	 * @version 1.3.0
	 * @since   1.2.0
	 * @todo    [later] check why `get_cart_contents_total()` returns wrong value (e.g. `100` -> `99.99`)
	 * @todo    [maybe] (feature) percent fee: optionally add taxes to `$total` (i.e. `get_subtotal_tax()`, `get_cart_contents_tax()`, `get_shipping_tax()`)
	 * @todo    [maybe] (feature) customizable `tax_class`
	 */
	function add_fees( $cart ) {
		$fees_to_add = array();
		// Gather fees
		for ( $i = 1; $i <= apply_filters( 'alg_wc_ccf_total_fields', 1 ); $i++ ) {
			if ( 'yes' === alg_wc_ccf_get_field_option( 'enabled', $i, 'no' ) ) {
				$fee_value = alg_wc_ccf_get_field_option( 'fee_value', $i, 0 );
				if ( 0 != $fee_value ) {
					$field_id = alg_wc_ccf_get_field_option( 'section', $i, 'billing' ) . '_' . ALG_WC_CCF_KEY . '_' . $i;
					// Post data
					if ( isset( $post_data ) || isset( $_REQUEST['post_data'] ) ) {
						if ( ! isset( $post_data ) ) {
							$post_data = array();
							parse_str( $_REQUEST['post_data'], $post_data );
						}
						if ( empty( $post_data[ $field_id ] ) ) {
							continue;
						}
					} elseif ( empty( $_REQUEST[ $field_id ] ) ) {
						continue;
					}
					// Gathering data
					$fee_type    = alg_wc_ccf_get_field_option( 'fee_type',    $i, 'fixed' );
					$fee_title   = alg_wc_ccf_get_field_option( 'fee_title',   $i, '' );
					$fee_taxable = alg_wc_ccf_get_field_option( 'fee_taxable', $i, 'yes' );
					if ( 'percent' === $fee_type ) {
						// Getting cart total
						$total = ( 'subtotal' === alg_wc_ccf_get_field_option( 'fee_percent_total', $i, 'cart_contents_total' ) ?
							$cart->get_subtotal() : $cart->get_cart_contents_total() );
						if ( 'yes' === alg_wc_ccf_get_field_option( 'fee_percent_shipping', $i, 'no' ) ) {
							$total += $cart->get_shipping_total();
						}
						// Calculating final fee amount
						$fee_value = $total * $fee_value / 100;
					}
					// Adding fee
					$fees_to_add[] = array(
						'name'      => $fee_title,
						'amount'    => $fee_value,
						'taxable'   => ( isset( $taxable ) ? ( 'yes' === $taxable ) : true ),
						'tax_class' => 'standard',
					);
				}
			}
		}
		// Add fees
		if ( ! empty( $fees_to_add ) ) {
			foreach ( $fees_to_add as $fee_to_add ) {
				$cart->add_fee( $fee_to_add['name'], $fee_to_add['amount'], $fee_to_add['taxable'], $fee_to_add['tax_class'] );
			}
		}
	}

	/**
	 * get_field.
	 *
	 * @version 1.5.0
	 * @since   1.0.0
	 * @todo    [next] use `$field['placeholder']` instead of `alg_wc_ccf_get_field_option( 'placeholder', $field_nr, '' )`?
	 * @todo    [next] code refactoring: do we really need to check for `array() != $excludedays` etc.
	 * @todo    [maybe] (important) sanitize keys for `select` and `radio` (`alg_wc_ccf_get_select_options()`) - `default` also needs to be sanitized then
	 * @todo    [later] (feature) default values for datepicker, timepicker etc. (e.g. `today`, `today + 3 days` etc.)
	 * @todo    [later] (feature) add option for "not pre-populate"
	 * @todo    [maybe] (feature) select: multi-select
	 */
	function get_field( $field_nr ) {
		$type = alg_wc_ccf_get_field_option( 'type', $field_nr, 'text' );
		$custom_attributes = array();
		if ( in_array( $type, array( 'datepicker', 'weekpicker', 'timepicker', 'number', 'color', 'search', 'url', 'range' ) ) ) {
			if ( 'datepicker' === $type || 'weekpicker' === $type ) {
				$custom_attributes['display']           = ( 'datepicker' === $type ) ? 'date' : 'week';
				$custom_attributes['dateformat']        = alg_wc_ccf_date_format_php_to_js(
					( '' == ( $date_format = alg_wc_ccf_get_field_option( 'type_datepicker_format', $field_nr, '' ) ) ? alg_wc_ccf_get_default_date_format() : $date_format ) );
				$custom_attributes['mindate']           = ( 0 == ( $mindate = alg_wc_ccf_get_field_option( 'type_datepicker_mindate',  $field_nr, -365 ) ) ? 'zero' : $mindate );
				$custom_attributes['maxdate']           = ( 0 == ( $maxdate = alg_wc_ccf_get_field_option( 'type_datepicker_maxdate',  $field_nr,  365 ) ) ? 'zero' : $maxdate );
				$custom_attributes['firstday']          = alg_wc_ccf_get_field_option( 'type_datepicker_firstday', $field_nr, 0 );
				if ( 'yes' === alg_wc_ccf_get_field_option( 'type_datepicker_changeyear', $field_nr, 'no' ) ) {
					$custom_attributes['changeyear']    = 1;
					$custom_attributes['yearrange']     = alg_wc_ccf_get_field_option( 'type_datepicker_yearrange', $field_nr, 'c-10:c+10' );
				}
				if ( array() != ( $excludedays = alg_wc_ccf_get_field_option( 'type_datepicker_excludedays', $field_nr, array() ) ) ) {
					$custom_attributes['excludedays']   = implode( ',', $excludedays );
				}
				if ( array() != ( $excludemonths = alg_wc_ccf_get_field_option( 'type_datepicker_excludemonths', $field_nr, array() ) ) ) {
					$custom_attributes['excludemonths'] = implode( ',', $excludemonths );
				}
				if ( '' != ( $excludedates = alg_wc_ccf_get_field_option( 'type_datepicker_excludedates', $field_nr, '' ) ) ) {
					$custom_attributes['excludedates']  = $excludedates;
				}
				if ( 'yes' === alg_wc_ccf_get_field_option( 'type_datepicker_timepicker_addon', $field_nr, 'no' ) ) {
					$custom_attributes['addon']         = 'time';
					if ( '' != ( $mintime = alg_wc_ccf_get_field_option( 'type_datepicker_timepicker_addon_mintime', $field_nr, '' ) ) ) {
						$custom_attributes['mintime']   = $mintime;
					}
					if ( '' != ( $maxtime = alg_wc_ccf_get_field_option( 'type_datepicker_timepicker_addon_maxtime', $field_nr, '' ) ) ) {
						$custom_attributes['maxtime']   = $maxtime;
					}
					$custom_attributes['timeformat']    = alg_wc_ccf_get_field_option( 'type_datepicker_timepicker_addon_timeformat', $field_nr, 'HH:mm' );
					if ( 'yes' === alg_wc_ccf_get_field_option( 'type_datepicker_timepicker_addon_is_i18n', $field_nr, 'no' ) ) {
						foreach ( alg_wc_ccf_get_datepicker_timepicker_addon_i18n_options() as $i18n_key => $i18n_value ) {
							$custom_attributes[ $i18n_key ] = alg_wc_ccf_get_field_option( "type_datepicker_timepicker_addon_{$i18n_key}", $field_nr, $i18n_value );
						}
					}
				}
			} elseif ( 'timepicker' === $type ) {
				$custom_attributes['display']           = 'time';
				$custom_attributes['timeformat']        = alg_wc_ccf_get_field_option( 'type_timepicker_format', $field_nr, 'hh:mm p' );
				$custom_attributes['interval']          = alg_wc_ccf_get_field_option( 'type_timepicker_interval', $field_nr, 15 );
				$custom_attributes['mintime']           = alg_wc_ccf_get_field_option( 'type_timepicker_mintime', $field_nr, '' );
				$custom_attributes['maxtime']           = alg_wc_ccf_get_field_option( 'type_timepicker_maxtime', $field_nr, '' );
			} else { // 'number', 'color', 'search', 'url', 'range'
				$custom_attributes['display']           = $type;
			}
			$type = 'text';
		}
		if ( '' !== ( $min = alg_wc_ccf_get_field_option( 'min', $field_nr, '' ) ) ) {
			$custom_attributes['min'] = $min;
		}
		if ( '' !== ( $max = alg_wc_ccf_get_field_option( 'max', $field_nr, '' ) ) ) {
			$custom_attributes['max'] = $max;
		}
		if ( '' !== ( $step = alg_wc_ccf_get_field_option( 'step', $field_nr, '' ) ) ) {
			$custom_attributes['step'] = $step;
		}
		$field = array(
			'type'              => $type,
			'label'             => alg_wc_ccf_get_field_option( 'label', $field_nr, '' ),
			'placeholder'       => alg_wc_ccf_get_field_option( 'placeholder', $field_nr, '' ),
			'required'          => ( 'yes' === alg_wc_ccf_get_field_option( 'required', $field_nr, 'no' ) ),
			'custom_attributes' => $custom_attributes,
			'class'             => array( alg_wc_ccf_get_field_option( 'class', $field_nr, 'form-row-wide' ) ),
			'default'           => alg_wc_ccf_get_field_option( 'default', $field_nr, '' ),
			'description'       => alg_wc_ccf_get_field_option( 'description', $field_nr, '' ),
			'priority'          => alg_wc_ccf_get_field_option( 'priority', $field_nr, 0 ),
			'maxlength'         => alg_wc_ccf_get_field_option( 'maxlength', $field_nr, 0 ),
			'label_class'       => alg_wc_ccf_get_field_option( 'label_class', $field_nr, '' ),
			'input_class'       => array( alg_wc_ccf_get_field_option( 'input_class', $field_nr, '' ) ),
			'autofocus'         => ( 'yes' === alg_wc_ccf_get_field_option( 'autofocus', $field_nr, 'no' ) ),
			'autocomplete'      => alg_wc_ccf_get_field_option( 'autocomplete', $field_nr, 'no' ),
		);
		if ( 'select' === $type || 'radio' === $type ) {
			$type_select_options = alg_wc_ccf_get_select_options( alg_wc_ccf_get_field_option( 'type_select_options', $field_nr, '' ) );
			if ( 'select' === $type ) {
				$placeholder = alg_wc_ccf_get_field_option( 'placeholder', $field_nr, '' );
				if ( '' != $placeholder ) {
					$type_select_options = array_replace( array( '' => $placeholder ), $type_select_options );
				}
			}
			$field['options'] = $type_select_options;
		}
		return $field;
	}

	/**
	 * add_custom_checkout_fields.
	 *
	 * @version 1.4.1
	 * @since   1.0.0
	 */
	function add_custom_checkout_fields( $fields ) {
		for ( $i = 1; $i <= apply_filters( 'alg_wc_ccf_total_fields', 1 ); $i++ ) {
			if ( 'yes' === alg_wc_ccf_get_field_option( 'enabled', $i, 'no' ) ) {
				if ( ! $this->is_visible( $i ) ) {
					continue;
				}
				$section = alg_wc_ccf_get_field_option( 'section', $i, 'billing' );
				$fields[ $section ][ $section . '_' . ALG_WC_CCF_KEY . '_' . $i ] = $this->get_field( $i );
			}
		}
		if ( 'yes' === alg_wc_ccf_get_option( 'force_sort_by_priority', 'no' ) ) {
			$field_sets = array( 'billing', 'shipping', 'account', 'order' );
			foreach ( $field_sets as $field_set ) {
				if ( isset( $fields[ $field_set ] ) ) {
					uasort( $fields[ $field_set ], array( $this, 'sort_by_priority' ) );
				}
			}
		}
		return $fields;
	}

	/**
	 * sort_by_priority.
	 *
	 * @version 1.4.1
	 * @since   1.0.0
	 */
	function sort_by_priority( $a, $b ) {
		$a = ( ! empty( $a['priority'] ) ? $a['priority'] : 0 );
		$b = ( ! empty( $b['priority'] ) ? $b['priority'] : 0 );
		if ( $a == $b ) {
			return 0;
		}
		return ( $a < $b ) ? -1 : 1;
	}

	/**
	 * maybe_get_product_id_wpml.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function maybe_get_product_id_wpml( $product_id ) {
		if ( function_exists( 'icl_object_id' ) ) {
			global $sitepress;
			$product_id = icl_object_id( $product_id, 'product', true, $sitepress->get_default_language() );
		}
		return $product_id;
	}

	/**
	 * check_products_terms.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function check_products_terms( $products, $terms, $taxonomy ) {
		foreach ( $products as $product_id ) {
			$product_terms = get_the_terms( $product_id, $taxonomy );
			if ( empty( $product_terms ) ) {
				continue;
			}
			foreach( $product_terms as $product_term ) {
				if ( in_array( $product_term->term_id, $terms ) ) {
					return true;
				}
			}
		}
		return false;
	}

	/**
	 * check_products.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function check_products( $products, $_products ) {
		foreach ( $products as $product_id ) {
			if ( in_array( $product_id, $_products ) ) {
				return true;
			}
		}
		return false;
	}

	/**
	 * check_shipping_classes.
	 *
	 * @version 1.1.0
	 * @since   1.1.0
	 */
	function check_shipping_classes( $products, $shipping_classes ) {
		foreach ( $products as $product_id ) {
			if ( $product = wc_get_product( $product_id ) ) {
				$shipping_class_id = ( 0 != ( $shipping_class_id = $product->get_shipping_class_id() ) ? $shipping_class_id : -1 );
				if ( in_array( $shipping_class_id, $shipping_classes ) ) {
					return true;
				}
			}
		}
		return false;
	}

	/**
	 * check_product_option.
	 *
	 * @version 1.2.1
	 * @since   1.2.1
	 */
	function check_product_option( $products, $option, $option_value ) {
		$is_product_in_cart = false;
		foreach ( $products as $product_id ) {
			if ( $product = wc_get_product( $product_id ) ) {
				if ( ( 'virtual' === $option && $product->is_virtual() ) || ( 'downloadable' === $option && $product->is_downloadable() ) ) {
					$is_product_in_cart = true;
					break;
				}
			}
		}
		if ( ( 'require' === $option_value && ! $is_product_in_cart ) || ( 'exclude' === $option_value && $is_product_in_cart ) ) {
			return false;
		}
		return true;
	}

	/**
	 * is_visible.
	 *
	 * @version 1.2.1
	 * @since   1.0.0
	 */
	function is_visible( $i ) {
		if ( apply_filters( 'alg_wc_custom_checkout_fields_always_visible_on_empty_cart', false ) && WC()->cart->is_empty() ) {
			// Added for "One Page Checkout" plugin compatibility
			return true;
		}
		// Getting options
		$categories_in         = alg_wc_ccf_get_field_option( 'categories_in', $i, '' );
		$tags_in               = alg_wc_ccf_get_field_option( 'tags_in', $i, '' );
		$products_in           = alg_wc_ccf_get_field_option( 'products_in', $i, '' );
		$shipping_classes_in   = alg_wc_ccf_get_field_option( 'shipping_classes_in', $i, '' );
		$virtual_products      = alg_wc_ccf_get_field_option( 'virtual_products', $i, '' );
		$downloadable_products = alg_wc_ccf_get_field_option( 'downloadable_products', $i, '' );
		if ( ! empty( $categories_in ) || ! empty( $tags_in ) || ! empty( $products_in ) || ! empty( $shipping_classes_in ) || '' != $virtual_products || '' != $downloadable_products ) {
			// Getting cart product ids
			$products = array();
			foreach ( WC()->cart->get_cart() as $cart_item_key => $values ) {
				$products[] = $this->maybe_get_product_id_wpml( $values['product_id'] );
			}
			// Checking categories
			if ( ! empty( $categories_in ) ) {
				if ( ! $this->check_products_terms( $products, $categories_in, 'product_cat' ) ) {
					return false;
				}
			}
			// Checking tags
			if ( ! empty( $tags_in ) ) {
				if ( ! $this->check_products_terms( $products, $tags_in, 'product_tag' ) ) {
					return false;
				}
			}
			// Checking products
			if ( ! empty( $products_in ) ) {
				if ( ! $this->check_products( $products, $products_in ) ) {
					return false;
				}
			}
			// Checking shipping classes
			if ( ! empty( $shipping_classes_in ) ) {
				if ( ! $this->check_shipping_classes( $products, $shipping_classes_in ) ) {
					return false;
				}
			}
			// Checking virtual products
			if ( '' != $virtual_products ) {
				if ( ! $this->check_product_option( $products, 'virtual', $virtual_products ) ) {
					return false;
				}
			}
			// Checking downloadable products
			if ( '' != $downloadable_products ) {
				if ( ! $this->check_product_option( $products, 'downloadable', $downloadable_products ) ) {
					return false;
				}
			}
		}
		// Checking user roles
		$user_roles_in = alg_wc_ccf_get_field_option( 'user_roles_in', $i, '' );
		if ( ! empty( $user_roles_in ) ) {
			if ( ! alg_wc_ccf_is_user_role( $user_roles_in ) ) {
				return false;
			}
		}
		// Checking min/max cart amount
		$cart_total = false;
		if ( ( $min_cart_amount = alg_wc_ccf_get_field_option( 'min_cart_amount', $i, 0 ) ) > 0 ) {
			WC()->cart->calculate_totals();
			$cart_total = WC()->cart->total;
			if ( $cart_total < $min_cart_amount ) {
				return false;
			}
		}
		if ( ( $max_cart_amount = alg_wc_ccf_get_field_option( 'max_cart_amount', $i, 0 ) ) > 0 ) {
			if ( false === $cart_total ) {
				WC()->cart->calculate_totals();
				$cart_total = WC()->cart->total;
			}
			if ( $cart_total > $max_cart_amount ) {
				return false;
			}
		}
		// All passed
		return true;
	}

	/**
	 * woocommerce_form_field_type_number.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @todo    [maybe] `'woocommerce_form_field_' . 'number'` etc. instead of `'woocommerce_form_field_' . 'text'`
	 */
	function woocommerce_form_field_type_convert( $field, $key, $args, $value ) {
		if ( isset( $args['custom_attributes']['display'] ) && in_array( $args['custom_attributes']['display'], array( 'number', 'color', 'search', 'url', 'range' ) ) ) {
			$field = str_replace( '<input type="text" class="input-text ', '<input type="' . $args['custom_attributes']['display'] . '" class="', $field );
		}
		return $field;
	}

	/**
	 * get_checkbox_display_value.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function get_checkbox_display_value( $value, $field_nr ) {
		return ( $value ?
			alg_wc_ccf_get_field_option( 'type_checkbox_yes', $field_nr, __( 'Yes', 'custom-checkout-fields-for-woocommerce' ) ) :
			alg_wc_ccf_get_field_option( 'type_checkbox_no',  $field_nr, __( 'No', 'custom-checkout-fields-for-woocommerce' ) )
		);
	}

	/**
	 * update_custom_checkout_fields_order_meta.
	 *
	 * @version 1.5.0
	 * @since   1.0.0
	 * @todo    [maybe] customizable `$value_meta_key`?
	 * @todo    [maybe] save all options instead, i.e. `$field_data = alg_get_field_data( $i );`
	 */
	function update_custom_checkout_fields_order_meta( $order_id ) {
		$fields_data = array();
		for ( $i = 1; $i <= apply_filters( 'alg_wc_ccf_total_fields', 1 ); $i++ ) {
			if ( 'yes' === alg_wc_ccf_get_field_option( 'enabled', $i, 'no' ) ) {
				$section     = alg_wc_ccf_get_field_option( 'section', $i, 'billing' );
				$type        = alg_wc_ccf_get_field_option( 'type', $i, 'text' );
				$option_name = $section . '_' . ALG_WC_CCF_KEY . '_' . $i;
				if ( isset( $_POST[ $option_name ] ) || ( 'checkbox' === $type && $this->is_visible( $i ) ) ) {
					$value = ( 'checkbox' === $type ? $this->get_checkbox_display_value( isset( $_POST[ $option_name ] ), $i ) : wc_clean( $_POST[ $option_name ] ) );
					$value_meta_key = '_' . $option_name;
					update_post_meta( $order_id, $value_meta_key, $value );
					$field_data = array(
						'section'              => $section,
						'type'                 => $type,
						'label'                => alg_wc_ccf_get_field_option( 'label', $i, '' ),
						'type_select_options'  => alg_wc_ccf_get_field_option( 'type_select_options', $i, '', 'update_order_meta' ),
						'type_checkbox_no'     => $this->get_checkbox_display_value( false, $i ),
						'type_checkbox_yes'    => $this->get_checkbox_display_value( true,  $i ),
						'_key'                 => ALG_WC_CCF_KEY,
						'_value_meta_key'      => $value_meta_key,
						'_field_nr'            => $i,
						'_value'               => $value,
						'_version'             => ALG_WC_CCF_VERSION,
					);
					$fields_data[] = $field_data;
				}
			}
		}
		if ( ! empty( $fields_data ) ) {
			alg_wc_ccf_update_order_fields_data( $order_id, $fields_data );
		}
	}

}

endif;

return new Alg_WC_CCF_Frontend();
