<?php
/**
 * Plugin Name: Deise : Event Year Archive List
 * Description: An Elementor widget that displays a bullet list of year archive links.
 * Version: 1.0.0
 * Author: Martin Whelan
 * Text Domain: deise-event-year-archive-list
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'DEISE_EYAL_PATH', plugin_dir_path( __FILE__ ) );

add_action( 'elementor/widgets/register', function( $widgets_manager ) {
	require_once DEISE_EYAL_PATH . 'widgets/event-year-archive-list.php';
	$widgets_manager->register( new \Deise_Event_Year_Archive_List_Widget() );
} );
