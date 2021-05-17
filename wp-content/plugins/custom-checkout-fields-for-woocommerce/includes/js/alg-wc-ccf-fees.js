/**
 * alg-wc-ccf-fees.js
 *
 * @version 1.2.0
 * @since   1.2.0
 * @author  Algoritmika Ltd.
 */

jQuery( 'body' ).on( 'change', alg_wc_ccf_fees_fields, function() {
	jQuery( 'body' ).trigger( 'update_checkout' );
} );
