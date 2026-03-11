<?php
/**
 * Plugin Name: Deise Dynamic Slide Background Style
 * Description: An Elementor widget that injects a CSS background-image from an ACF field into .swiper-slide-bg.
 * Version: 1.0.0
 * Author: Deise
 * Text Domain: deise-dynamic-slide-bg
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'DEISE_SLIDE_BG_PATH', plugin_dir_path( __FILE__ ) );

add_action( 'elementor/widgets/register', function( $widgets_manager ) {
	require_once DEISE_SLIDE_BG_PATH . 'widgets/deise-dynamic-slide-bg-widget.php';
	$widgets_manager->register( new \Deise_Dynamic_Slide_BG_Widget() );
} );
