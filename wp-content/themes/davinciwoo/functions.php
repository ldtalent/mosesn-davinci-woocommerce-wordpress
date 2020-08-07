<?php
/**
 * DavinciWoo functions and definitions
 *
 * @package davinciwoo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( !defined('ADSW_THEME_VERSION') ) define( 'ADSW_THEME_VERSION', wp_get_theme('davinciwoo')->get( 'Version' ) );
if ( !defined('ADSW_THEME_PATH') ) define( 'ADSW_THEME_PATH', get_template_directory() );
if ( !defined('ADSW_THEME_URL') ) define( 'ADSW_THEME_URL', get_template_directory_uri() );
if ( !defined('ADSW_THEME_MIN') ) define( 'ADSW_THEME_MIN', '.min' ); // Production ADD .MIN

add_action( 'init', function() {
	load_theme_textdomain( 'davinciwoo' );
} );

require ADSW_THEME_PATH . '/include/core/core.php';
require ADSW_THEME_PATH . '/include/init.php';

/**
 * Note: It's not recommended to add any custom code here. Please use a child theme so that your customizations aren't lost during updates.
 * Learn more here: http://codex.wordpress.org/Child_Themes
 */