<?php

function adswth_woocommerce_setup() {
	// Theme support for default WC gallery.
	if ( adswth_option( 'product_gallery_woocommerce') ) {
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
	}
	// Remove default row and column options.
	remove_theme_support( 'product_grid' );
}
add_action( 'after_setup_theme', 'adswth_woocommerce_setup', 90 );

function adswth_woocommerce_cart_item_thumbnail( $image, $cart_item, $cart_item_key ) {

	$result = '<div class="cart-image-wrap"><div class="cart-image-inner">' . $image . '</div></div>';

	return $result;
}
add_filter( 'woocommerce_cart_item_thumbnail', 'adswth_woocommerce_cart_item_thumbnail', 10, 3 );

function adswth_woocommerce_cross_sells_columns( $columns ){

	return 4;
}
add_filter( 'woocommerce_cross_sells_columns', 'adswth_woocommerce_cross_sells_columns', 10, 1 );

function adswth_woocommerce_cross_sells_total( $limit ) {

	return 4;
}
add_filter( 'woocommerce_cross_sells_total', 'adswth_woocommerce_cross_sells_total', 10, 1 );

if ( ! function_exists( 'adswth_header_cart' ) ) {
	/**
	 * Header Cart button element
	 */
	function adswth_header_cart() {

		global $woocommerce;

		$link = adswth_option( 'use_minicart' ) && !is_cart() && !is_checkout() && !is_checkout_pay_page() ? '#' : wc_get_cart_url();
		$class = adswth_option( 'use_minicart' ) ? 'cart-popup' : '';
		$count = $woocommerce->cart->cart_contents_count;

		?>
		<a href="<?php echo $link ?>" class="btn-cart btn btn-primary <?php echo $class; ?>">
            <div class="btn-cart-inner h-100 align-items-center justify-content-center d-flex">
                <i class="icon-basket"></i>
                <?php if( $count > 0 ){ ?>
                <span class="cart-count"><?php echo $count; ?></span>&nbsp;<span class="cart-label"><?php echo _n( 'item', 'items', $count, 'davinciwoo' ) ?></span>
                <?php } //endif; ?>
            </div>
		</a>
	<?php }
}
add_action( 'adswth_main_cart', 'adswth_header_cart', 20 );

function adswth_woocommerce_btn_cart_count( $fragments ) {

    global $woocommerce;

	$count = $woocommerce->cart->cart_contents_count;

	ob_start();
	?>
        <div class="btn-cart-inner h-100 align-items-center justify-content-center d-flex">
            <i class="icon-basket"></i>
	        <?php if( $count > 0 ){ ?>
            <span class="cart-count"><?php echo $count; ?></span>&nbsp;<span class="cart-label"><?php echo _n( 'item', 'items', $count, 'davinciwoo' ) ?></span>
	        <?php } //endif; ?>
        </div>
	<?php

	$fragments['.btn-cart-inner'] = ob_get_clean();

	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'adswth_woocommerce_btn_cart_count' );

if( is_woocommerce_activated() && adswth_option( 'use_minicart' )  ){
	add_action( 'wp_footer', 'adswth_popup_cart' );
}
function adswth_popup_cart(){

    if( !is_cart() && !is_checkout() && !is_checkout_pay_page() ) { ?>

    <div id="cart-sidebar" class="cart-sidenav">
        <div class="cart-header">
            <h2><?php _e('Shopping cart', 'davinciwoo');?></h2>
            <a href="javascript:;" class="cart-close-btn">&times;</a>
        </div>
        <div class="widget_shopping_cart_content">
	        <?php woocommerce_mini_cart(); ?>
        </div>
    </div>
    <div id="cart-sidebar-overlay"></div>

    <?php }
}
function woocommerce_widget_shopping_cart_button_view_cart() {
    echo '<a href="' . esc_url( wc_get_cart_url() ) . '" class="btn btn-white-bordered btn-big w-100 text-uppercase">' . esc_html__( 'View cart', 'woocommerce' ) . '</a>';
}
function woocommerce_widget_shopping_cart_proceed_to_checkout() {
    echo '<a href="' . esc_url( wc_get_checkout_url() ) . '" class="btn btn-primary btn-big w-100 text-uppercase">' . esc_html__( 'Checkout', 'woocommerce' ) . '</a>';
}

function adswth_comment_form_submit_field_add_image( $submit_button, $args ){

    if( !is_adsw_activated() ){
        return $submit_button;
    }
    $result = '<div class="w-100 d-flex align-items-stretch justify-content-center order-5 text-center">' .
                '<div class="d-inline-block comment-form-image">' .
                    $submit_button .
                    '<input id="image" class="comment-form-image-input" name="comment_image" type="file" accept="image/*" />'.
                    '<label for="image" class="comment-form-image-label btn btn-secondary mb-0 ml-1">'.
                    '<i class="icon icon-attach"></i>'.
                    '</label>'.
                '</div>'.
            '</div>'.
            '<div id="file-upload-filename" class="d-block w-100 text-center order-10 mt-1"></div>';

    return $result;
}
add_filter( 'comment_form_submit_button', 'adswth_comment_form_submit_field_add_image', 10, 2 );

/**
 * Upload a File With WordPress
 */
add_action( 'comment_post', function( $comment_ID, $comment_approved, $commentdata ){

    if ( isset( $_FILES['comment_image']['name'] ) && ( $_FILES['comment_image']['name'] !='' ) ){

        $upload = wp_upload_bits( $_FILES['comment_image']['name'], null, file_get_contents( $_FILES['comment_image']['tmp_name'] ) );

        if( $upload['error'] ){
            echo _( 'Error', 'adswth') . ': '. $upload['error'];
            return $commentdata;
        } else{
            $wp_filetype = wp_check_filetype( basename( $upload['file'] ), null );

            $wp_upload_dir = wp_upload_dir();

            if( $wp_filetype['type'] ) {
                $attachment = array(
                    'guid' => $wp_upload_dir['baseurl'] . _wp_relative_upload_path($upload['file']), // Возвращает относительный путь к загруженному файлу.
                    'post_mime_type' => $wp_filetype['type'],
                    'post_title' => preg_replace('/\.[^.]+$/', '', basename($upload['file'])),
                    'post_content' => '',
                    'post_status' => 'inherit'
                );

                $attach_id = wp_insert_attachment($attachment, $upload['file'], get_the_ID());

                require_once(ABSPATH . 'wp-admin/includes/image.php');

                $attach_data = wp_generate_attachment_metadata($attach_id, $upload['file']);

                wp_update_attachment_metadata($attach_id, $attach_data);

                update_comment_meta($comment_ID, 'images', (array)$attach_id);
            }
        }
    }

}, 100, 3 );
