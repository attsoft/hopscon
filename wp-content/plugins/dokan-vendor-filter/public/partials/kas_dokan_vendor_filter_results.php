<?php

/**
 * Provide a public-facing view
 *
 * This file is used to markup the public-facing aspects for filter form.
 *
* @link       http://ideas.echopointer.com
 * @since      1.0.6
 *
 * @package    Kas_Dokan_Vendor_Filter
 * @subpackage Kas_Dokan_Vendor_Filter/public/partials
 */
?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php 

		// check if bootstrap enable
		if (get_option('kas-enable-bootstrap') == 1){
			
			$css_row = 'row';
			$css_col = 'col-sm-6 col-md-4';
			$css_thumb = 'thumbnail';
			$btn_css ="btn btn-primary ";
			$css_image = 'img-responsive';
			$css_capt = 'caption';
		}else{
			$css_row = 'kas_row';
			$css_col = 'kas_col';
			$css_thumb = 'kas_thumbnail';
			$btn_css = 'kas_submit';
			$css_image = 'img-responsive';
			$css_capt = 'caption';
		}	

if ($_GET['query_type'] == 'vendors' || !isset($_GET['query_type']) || empty($_GET['query_type'])){		

	if ( $args['id']) {	
		$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
		$pagination_base = str_replace( $post->ID, '%#%', esc_url( get_pagenum_link( $post->ID ) ) );
		$limit        = 10;
		$offset       = ( $paged - 1 ) * $limit;		
		
	    $template_args = array(
	        'sellers'         => $args,
	        'limit'           => $limit,
	        'offset'          => $offset,
	        'paged'           => $paged,
	        'search_query'    => '',
	        'pagination_base' => $pagination_base,
	        'per_row'         => $per_row,
	        'search_enabled'  => 'no',
	        'image_size'      => '',
	    );
	    
	    echo dokan_get_template_part( 'store-lists-loop', false, $template_args );	
	}
}

if ($_GET['query_type'] == 'products') {

	if ( $args['id']) {	
?>

				<?php 
				$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
				$count = count($args['id']);
				$author_ids = array();
				$kas_category = (isset($_GET['kas_category']) ? $_GET['kas_category'] : '');
				if (isset($_GET['kas_range']) && !empty($_GET['kas_range'])) {
					$kas_range = explode('-',$_GET['kas_range']);
					$kas_range_min = $kas_range[0];
					$kas_range_max = $kas_range[1];
				}else {
					$kas_range = array(0,esc_attr(get_option('kas-products-maxprice')));
					$kas_range_min = $kas_range[0];
					$kas_range_max = $kas_range[1];
				}
				for ($i = 0; $i < $count; $i++) {
					array_push($author_ids,$args['id'][$i]['id']);
				}

					// get vendor products
		            $args = array(
		            	'author__in' => $author_ids,
					    'post_type'  => array('product', 'product_variation'),
		             	'post_status' => 'publish',
        				'product_cat'    => $kas_category,
        				'posts_per_page' => esc_attr(get_option('kas-products-perpage')),
      					'paged' => $paged,
    					'orderby' => 'date',
				        'order'       => 'DESC' ,
					    'meta_query' => array(
					        array(
					            'key' => '_price',
					            'value' => array($kas_range_min, $kas_range_max),
					            'compare' => 'BETWEEN',
					            'type' => 'NUMERIC'
					        )
					    )
					);
					$loop = new WP_Query( $args );
					?>
					<?php if ( $loop->have_posts() ) : ?>
					    <?php do_action('woocommerce_before_shop_loop'); // woocommerce sorting ?>
					
					    <div class="clear"></div>					
	                    <?php woocommerce_product_loop_start(); ?>
	
	                        <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
								<?php do_action( 'woocommerce_before_shop_loop' ); ?>
	                            <?php wc_get_template_part( 'content', 'product' ); ?>
	
	                        <?php endwhile; // end of the loop. ?>
	                    <?php wp_reset_postdata(); ?>
	                    <?php woocommerce_product_loop_end(); ?>    <div class="clear"></div>
	
	    				<?php do_action('woocommerce_after_shop_loop'); // woocommerce pagination   ?>
						<?php if($loop->max_num_pages > 1){?>                    	
						    <nav class="woocommerce-pagination">
						        <ul class="page-numbers">
						            <li><?php previous_posts_link( '&laquo; PREV', $loop->max_num_pages) ?></li> 
						            <li><?php next_posts_link( 'NEXT &raquo;', $loop->max_num_pages) ?></li>
						        </ul>
						    </nav>
						<?php }?>
					<?php else : ?>
						<?php do_action( 'woocommerce_no_products_found' ); ?>
					<?php endif; ?>
    <?php  } else { ?>
	    <p class="dokan-error"><?php _e( 'No product found!',$this->kas_filter); ?></p>
<?php }
}
?>		