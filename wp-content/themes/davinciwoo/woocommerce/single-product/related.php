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
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $related_products ) : ?>

	<section class="related mt-px-20">

        <div class="block-title-wrap d-flex align-items-center mb-px-25">
            <h3 class="text-uppercase block-title" ><?php esc_html_e( 'Related products', 'woocommerce' ); ?></h3>
            <div class="block-title-divider d-xl-none"></div>
        </div>

		<?php woocommerce_product_loop_start(); ?>

        <div class="three-item">
            <div class="row no-gutters product-slider" data-flickity-options='{
                                                              "cellAlign": "left",
                                                              "wrapAround": false,
                                                              "autoPlay": false,
                                                              "prevNextButtons": false,
                                                              "percentPosition": true,
                                                              "imagesLoaded": true,
                                                              "lazyLoad": 1,
                                                              "pageDots": true,
                                                              "contain": true,
                                                              "groupCells": "100%",
                                                              "watchCSS": true
                                                          }'>

            <?php foreach ( $related_products as $related_product ) : ?>

                <?php
                    $post_object = get_post( $related_product->get_id() );

                    setup_postdata( $GLOBALS['post'] =& $post_object );
                ?>
                <div class="col-xl-12 col-lg-4 col-md-6">

                    <?php wc_get_template_part( 'content', 'product' ); ?>

                </div>

            <?php endforeach; ?>

            </div>
        </div>

		<?php woocommerce_product_loop_end(); ?>

	</section>

<?php endif;

wp_reset_postdata();
