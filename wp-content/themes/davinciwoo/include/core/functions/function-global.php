<?php

function adswth_option( $option ) {
	// Get options
	return get_theme_mod( $option, adswth_defaults( $option ) );
}

function adswth_get_template_field( $pagename ) {

	$file = ADSW_THEME_PATH . '/template-parts/defaults_template/' . $pagename . '.php';

	if ( file_exists( $file ) ) {

		ob_start();

		include( $file );
		$text = ob_get_contents();

		ob_end_clean();

		return $text;
	}

	return '';
}

function adswth_get_site_domain() {

	$site_url = get_site_url();

	$find_h = '#^http(s)?://#';
	$find_w = '/^www\./';

	$domain = preg_replace( $find_h, '', $site_url );
	$domain = preg_replace( $find_w, '', $domain );

	return $domain;
}

function adswth_get_icon( $name = '' ){

	if( $name != '' )
		return '<i class="icon-' . $name . '"></i>';
}

function adswth_get_template_color() {

	$accent_color = adswth_option( 'template_color' );

	if( ! $accent_color ) {
		$accent_color = '#3C5460';
	}

	return $accent_color;
}

add_shortcode( 'get-icon', function( $attr ) {

	$args = shortcode_atts( [
		'icon' => 0,
		'color' => adswth_get_template_color(),
	], $attr );

	return adswth_get_svg_icon( $args[ 'icon' ], $args[ 'color' ] );
} );

function adswth_get_svg_icon( $name, $color ) {

	$file = ADSW_THEME_PATH . '/assets/images/svg-icons/' . $name . '.svg';

	if ( file_exists( $file ) ) {

		ob_start();

		include( $file );
		$text = ob_get_contents();

		ob_end_clean();

		return $text;
	}

	return '';
}

