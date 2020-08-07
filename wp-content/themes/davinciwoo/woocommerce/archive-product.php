<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20 // removed in  /include/woocommerce/structure-wc-category-page.php
 * @hooked adswth_breadcrumbs - 20 // added in  /include/woocommerce/structure-wc-category-page.php
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

do_action( 'adswth_before_main_content' );
?>
<header class="woocommerce-products-header row no-gutters justify-content-between align-items-center">
	<?php
	/**
	 * Hook: adswth_after_shop_title.
	 *
	 */
	do_action( 'adswth_before_shop_title' );
	?>
	<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) { ?>
		<h1 class="woocommerce-products-header__title page-title col-xl-auto col-12 mr-xl-auto">
            <?php woocommerce_page_title(); ?>
            <span class="woocommerce-products-header__count text-muted">(<?php echo wc_get_loop_prop( 'total' )?>)</span>
        </h1>
    <?php } //endif; ?>
    <?php
    /**
     * Hook: adswth_after_shop_title.
     *
     * @hooked adswth_shop_sidebar_button - 20 - added in /include/woocommerce/structure-wc-category-page.php
     * @hooked woocommerce_catalog_ordering - 30 - added in /include/woocommerce/structure-wc-category-page.php
     */
    do_action( 'adswth_after_shop_title' );
    ?>
</header>

<?php if ( woocommerce_product_loop() ) {

    /**
     * Hook: woocommerce_before_shop_loop.
     *
     * @hooked adswth_before_before_shop_loop -5
     * @hooked wc_print_notices - 10
     * @hooked woocommerce_result_count - 20 - removed in /include/woocommerce/structure-wc-category-page.php
     * @hooked woocommerce_catalog_ordering - 30 - removed in /include/woocommerce/structure-wc-category-page.php
     * @hooked adswth_after_before_shop_loop - 100
     */
    do_action( 'woocommerce_before_shop_loop' );

	woocommerce_product_loop_start();

	if ( wc_get_loop_prop( 'total' ) ) {
		while ( have_posts() ) {
			the_post();

			/**
			 * Hook: woocommerce_shop_loop.
			 *
			 * @hooked WC_Structured_Data::generate_product_data() - 10
			 */
			do_action( 'woocommerce_shop_loop' );

			wc_get_template_part( 'content', 'product-cat' );
		}
	}

	woocommerce_product_loop_end();

	/**
	 * Hook: woocommerce_after_shop_loop.
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	do_action( 'woocommerce_after_shop_loop' );
} else {
	/**
	 * Hook: woocommerce_no_products_found.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	do_action( 'woocommerce_no_products_found' );
}

do_action( 'adswth_after_main_content' );

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
//do_action( 'woocommerce_sidebar' );

get_footer( 'shop' );
