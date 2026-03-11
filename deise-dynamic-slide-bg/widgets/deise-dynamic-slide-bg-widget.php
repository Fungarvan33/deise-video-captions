<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Deise_Dynamic_Slide_BG_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'deise_dynamic_slide_bg';
	}

	public function get_title() {
		return 'Deise Dynamic Slide Background Style';
	}

	public function get_icon() {
		return 'eicon-slider-push';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => 'Settings',
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'info',
			[
				'type'            => \Elementor\Controls_Manager::RAW_HTML,
				'raw'             => 'This widget reads the <strong>slide_background</strong> ACF field on the current page and injects a <code>.swiper-slide-bg { background-image }</code> CSS rule. The Elementor Slide object doesn\'t allow the image to be set dynamically.',
				'content_classes' => 'elementor-descriptor',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$post_id = get_the_ID();

		if ( ! function_exists( 'get_field' ) ) {
			return;
		}

		$image_url = get_field( 'slide_background', $post_id );

		// ACF image fields can return an array or a URL depending on the return format.
		if ( is_array( $image_url ) ) {
			$image_url = ! empty( $image_url['url'] ) ? $image_url['url'] : '';
		}

		if ( empty( $image_url ) ) {
			return;
		}

		$image_url = esc_url( $image_url );
		?>
		<style>.swiper-slide-bg { background-image: url('<?php echo $image_url; ?>') !important; }</style>
		<?php
	}
}
