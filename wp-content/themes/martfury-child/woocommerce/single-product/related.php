<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see           https://docs.woocommerce.com/document/template-structure/
 * @author        WooThemes
 * @package       WooCommerce/Templates
 * @version       3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$related_title = martfury_get_option( 'product_related_title' );
$columns       = intval( martfury_get_option( 'related_products_columns' ) );
$container_class = martfury_get_product_layout() == '6' ? 'martfury-container' : 'container';

    global $product, $post;

    if ( $seller_id == 0 ) {
        $seller_id = $post->post_author;
    } 
        $args = array(
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'orderby'        => 'rand',
        'post__not_in'   => array( $post->ID ),
        'author'         => $seller_id,
    );

    $products = new WP_Query( $args );

    ?>

	<section class="related products" data-columns="<?php echo esc_attr( $columns ); ?>">
		<div class="<?php echo esc_attr($container_class); ?>">
			<div class="related-content">
				<h2 class="related-title"><?php echo esc_html( $related_title ); ?></h2>

				<?php if ( $products->have_posts() ) { 
					woocommerce_product_loop_start(); 
						while ( $products->have_posts() ) {
            				$products->the_post();
            				wc_get_template_part( 'content', 'product' );
        				}
        				woocommerce_product_loop_end();
        			} else {
        				esc_html_e( 'No product has been found!', 'dokan-lite' );
    				}
					?>
			</div>
		</div>
	</section>

<?php

wp_reset_postdata();
