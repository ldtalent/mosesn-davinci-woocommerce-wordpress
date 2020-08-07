<?php

function adswst_register_widgets() {
	
	register_widget( 'ADSWST_Facebook_Likebox_Widget' );
	register_widget( 'ADSWST_Instagram_Widget' );
	register_widget( 'ADSWST_Social_Icons_Widget' );
}
add_action( 'widgets_init', 'adswst_register_widgets' );

function adswst_social_icons_widget_shortcode ( $atts ){

	global $wp_widget_factory;

	$args = shortcode_atts( [
		'title'          => '',
		'id'             => '',
		'facebook_link'  => '',
		'instagram_link' => '',
		'twitter_link'   => '',
		'pinterest_link' => '',
		'youtube_link'   => '',
		'icon_color'                  => '#FFFFFF',
		'icon_color_hover'            => '#FFFFFF',
		'icon_color_background'       => '#333333',
		'icon_color_background_hover' => '#626262',
		'icon_font_size'              => '14',
		'padding'                     => '5',
		'border_radius'               => '2'
	], $atts );

	ob_start();
	
	the_widget( 'ADSWST_Social_Icons_Widget', $args, []);
	
	$output = ob_get_contents();
	ob_end_clean();
	
	return '<span>' . $output . '</span>';
}
add_shortcode( 'adswst_social_icons','adswst_social_icons_widget_shortcode' );

function adswst_instagram_widget_shortcode ( $atts ){

	global $wp_widget_factory;

	$args = shortcode_atts( [
		'username'  => '',
		'size'      => 'small',
		'number'    => 6,
		'target'    => '_blank',
		'shortcode' => true,
	], $atts);

	ob_start();
	
	the_widget( 'ADSWST_Instagram_Widget', $args, [] );
	
	$output = ob_get_contents();
	ob_end_clean();
	
	return '<div class="adswst-instagram-wide">' . $output . '</div>';
}
add_shortcode( 'adswst_instagram','adswst_instagram_widget_shortcode' );