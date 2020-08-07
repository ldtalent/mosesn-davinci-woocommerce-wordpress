<?php $val = adswth_option( 'woo_product_cat_mob' );?>

<div class="<?php echo ( $val === '2' ) ? 'col col-6 col-sm two-per-row ' : 'col col-12 '; ?> product-cat-wrap">
	<?php wc_get_template_part( 'content', 'product' ); ?>
</div>
