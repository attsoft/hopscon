<?php
/**
 * Custom Checkout Fields for WooCommerce - Shortcodes Class
 *
 * @version 1.4.8
 * @since   1.4.8
 * @author  Algoritmika Ltd.
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_CCF_Shortcodes' ) ) :

class Alg_WC_CCF_Shortcodes {

	/**
	 * Constructor.
	 *
	 * @version 1.4.8
	 * @since   1.4.8
	 */
	function __construct() {
		add_shortcode( 'alg_wc_ccf_translate', array( $this, 'language_shortcode' ) );
	}

	/**
	 * language_shortcode.
	 *
	 * @version 1.4.8
	 * @since   1.4.8
	 */
	function language_shortcode( $atts, $content = '' ) {
		// E.g.: `[alg_wc_ccf_translate lang="EN,DE" lang_text="Text for EN & DE" not_lang_text="Text for other languages"]`
		if ( isset( $atts['lang_text'] ) && isset( $atts['not_lang_text'] ) && ! empty( $atts['lang'] ) ) {
			return ( ! defined( 'ICL_LANGUAGE_CODE' ) || ! in_array( strtolower( ICL_LANGUAGE_CODE ), array_map( 'trim', explode( ',', strtolower( $atts['lang'] ) ) ) ) ) ?
				$atts['not_lang_text'] : $atts['lang_text'];
		}
		// E.g.: `[alg_wc_ccf_translate lang="EN,DE"]Text for EN & DE[/alg_wc_ccf_translate][alg_wc_ccf_translate not_lang="EN,DE"]Text for other languages[/alg_wc_ccf_translate]`
		return (
			( ! empty( $atts['lang'] )     && ( ! defined( 'ICL_LANGUAGE_CODE' ) || ! in_array( strtolower( ICL_LANGUAGE_CODE ), array_map( 'trim', explode( ',', strtolower( $atts['lang'] ) ) ) ) ) ) ||
			( ! empty( $atts['not_lang'] ) &&     defined( 'ICL_LANGUAGE_CODE' ) &&   in_array( strtolower( ICL_LANGUAGE_CODE ), array_map( 'trim', explode( ',', strtolower( $atts['not_lang'] ) ) ) ) )
		) ? '' : $content;
	}

}

endif;

return new Alg_WC_CCF_Shortcodes();
