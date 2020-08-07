<?php

function adswth_woocommerce_breadcrumb_defaults( $args ){

	$args[  'delimiter' ]  = '<i class="icon-right-open"></i>';
	$args[ 'wrap_before' ] = '<nav class="adswth-breadcrumb">';

	return $args;
}
add_filter( 'woocommerce_breadcrumb_defaults', 'adswth_woocommerce_breadcrumb_defaults',  10, 1 );

function adswth_add_percentage_to_sale_badge( $html, $post, $product ) {

	if( ! adswth_option( 'discount_show' ) )
		return '';

	if( $product->is_type('variable')){
		$percentages = array();

		// Get all variation prices
		$prices = $product->get_variation_prices();

		// Loop through variation prices
		foreach( $prices['price'] as $key => $price ){
			// Only on sale variations
			if( $prices['regular_price'][$key] !== $price ){
				// Calculate and set in the array the percentage for each variation on sale
				$percentages[] = round(100 - ($prices['sale_price'][$key] / $prices['regular_price'][$key] * 100));
			}
		}
		// We keep the highest value
		$percentage = max($percentages) . '%';
	} else {
		$regular_price = (float) $product->get_regular_price();
		$sale_price    = (float) $product->get_sale_price();

		$percentage    = round(100 - ($sale_price / $regular_price * 100)) . '%';
	}
	return '<div class="onsale"><span><strong>' . $percentage . '</strong> ' . esc_html__( 'off', 'davinciwoo' ) . '</span></div>';
}
add_filter( 'woocommerce_sale_flash', 'adswth_add_percentage_to_sale_badge', 20, 3 );

function adswth_woocommerce_product_categories_widget_args( $args ) {

	$args[ 'show_count' ] = adswth_option( 'menu_product_cat_show_count' );

	return $args;
}
add_filter( 'woocommerce_product_categories_widget_args', 'adswth_woocommerce_product_categories_widget_args' , 99, 1);

function adswth_checkout_breadcrumb_class( $endpoint ){
	$classes = [];
	if( $endpoint == 'cart' && is_cart() ||
	    $endpoint == 'checkout' && is_checkout() && !is_wc_endpoint_url( 'order-received' ) ||
	    $endpoint == 'order-received' && is_wc_endpoint_url( 'order-received' ) ) {
		$classes[] = 'current';
	} else{
		$classes[] = 'hide-for-small';
	}
	return implode( ' ', $classes );
}

/**
 * Track product views.
 */
function adswth_wc_track_product_view() {
	if ( ! is_singular( 'product' ) || is_active_widget( false, false, 'woocommerce_recently_viewed_products', true ) ) {
		return;
	}

	global $post;

	if ( empty( $_COOKIE['woocommerce_recently_viewed'] ) ) { // @codingStandardsIgnoreLine.
		$viewed_products = array();
	} else {
		$viewed_products = wp_parse_id_list( (array) explode( '|', wp_unslash( $_COOKIE['woocommerce_recently_viewed'] ) ) ); // @codingStandardsIgnoreLine.
	}

	// Unset if already in viewed products list.
	$keys = array_flip( $viewed_products );

	if ( isset( $keys[ $post->ID ] ) ) {
		unset( $viewed_products[ $keys[ $post->ID ] ] );
	}

	$viewed_products[] = $post->ID;

	if ( count( $viewed_products ) > 15 ) {
		array_shift( $viewed_products );
	}

	// Store for session only.
	wc_setcookie( 'woocommerce_recently_viewed', implode( '|', $viewed_products ) );
}

add_action( 'template_redirect', 'adswth_wc_track_product_view', 20 );

/**
 * Remove all of the hooks from an action.
 */
//add_action( 'wp_head', 'adswth_remove_action', 999 );
function adswth_remove_action(){
    remove_all_actions( 'woocommerce_after_add_to_cart_quantity' );
}