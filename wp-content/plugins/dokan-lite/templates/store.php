<?php
/**
 * The Template for displaying all single posts.
 *
 * @package dokan
 * @package dokan - 2014 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$store_user   = dokan()->vendor->get( get_query_var( 'author' ) );
$store_info   = $store_user->get_shop_info();
$map_location = $store_user->get_location();
$store_tabs    = dokan_get_store_tabs( $store_user->get_id() );

get_header( 'shop' );

if ( function_exists( 'yoast_breadcrumb' ) ) {
    yoast_breadcrumb( '<p id="breadcrumbs">', '</p>' );
}
?>

	<?php dokan_get_template_part( 'store-header' ); ?>
	
    <?php do_action( 'woocommerce_before_main_content' ); ?>

    <?php dokan_get_template_part( 'store', 'sidebar', array( 'store_user' => $store_user, 'store_info' => $store_info, 'map_location' => $map_location ) ); ?>

    <div id="dokan-primary" class="dokan-single-store dokan-w8 demodemo">
        <div id="dokan-content" class="store-page-wrap woocommerce" role="main">
        
        <?php if ( $store_tabs ) { ?>
    <div class="dokan-store-tabs<?php echo esc_attr( $no_banner_class_tabs ); ?>">
        <ul class="dokan-list-inline">
			<?php foreach ( $store_tabs as $key => $tab ) { ?>
				<?php if ( $tab['url'] ): ?>
                    <li><a href="<?php echo esc_url( $tab['url'] ); ?>"><?php echo esc_html( $tab['title'] ); ?></a>
                    </li>
				<?php endif; ?>
			<?php } ?>
			<?php do_action( 'dokan_after_store_tabs', $store_user->get_id() ); ?>
        </ul>
    </div>
<?php } ?>

            
  
            <?php do_action( 'dokan_store_profile_frame_after', $store_user->data, $store_info ); ?>

            <?php if ( have_posts() ) { ?>

                <div class="seller-items">

                    <?php woocommerce_product_loop_start(); ?>

                        <?php while ( have_posts() ) : the_post(); ?>

                            <?php wc_get_template_part( 'content', 'product' ); ?>

                        <?php endwhile; // end of the loop. ?>

                    <?php woocommerce_product_loop_end(); ?>

                </div>

                <?php dokan_content_nav( 'nav-below' ); ?>

            <?php } else { ?>

                <p class="dokan-info"><?php esc_html_e( 'No products were found of this vendor!', 'dokan-lite' ); ?></p>

            <?php } ?>
        </div>

    </div><!-- .dokan-single-store -->

    <div class="dokan-clearfix"></div>

    <?php do_action( 'woocommerce_after_main_content' ); ?>

<?php get_footer( 'shop' ); ?>
