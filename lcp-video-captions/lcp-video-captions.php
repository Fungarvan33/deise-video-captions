<?php
/**
 * Plugin Name: LCP Video Captions
 * Description: Elementor widget for background videos with timed flying captions.
 * Version: 1.1.0
 * Author: Martin Whelan
 * Text Domain: lcp-video-captions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class LCP_Video_Captions_Plugin {
	const VERSION = '1.1.0';

	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}

	public function init() {
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_missing_elementor' ) );
			return;
		}

		add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );
		add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'register_assets' ) );
		add_action( 'elementor/frontend/after_register_scripts', array( $this, 'register_assets' ) );
		add_action( 'elementor/frontend/after_register_styles', array( $this, 'register_assets' ) );
		add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );
	}

	public function register_assets() {
		wp_register_style(
			'lcp-video-captions',
			plugin_dir_url( __FILE__ ) . 'assets/css/style.css',
			array(),
			self::VERSION
		);

		wp_register_script(
			'lcp-video-captions',
			plugin_dir_url( __FILE__ ) . 'assets/js/captions.js',
			array( 'jquery', 'elementor-frontend' ),
			self::VERSION,
			true
		);
	}

	public function register_widgets( $widgets_manager ) {
		require_once __DIR__ . '/widgets/widget.php';
		$widgets_manager->register( new \LCP_Video_Captions_Widget() );
	}

	public function admin_notice_missing_elementor() {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		echo '<div class="notice notice-warning is-dismissible"><p><strong>LCP Video Captions</strong> requires Elementor to be installed and active.</p></div>';
	}
}

new LCP_Video_Captions_Plugin();
