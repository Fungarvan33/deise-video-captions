<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Deise_Event_Year_Archive_List_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'deise_event_year_archive_list';
	}

	public function get_title() {
		return 'Event Year Archive List';
	}

	public function get_icon() {
		return 'eicon-bullet-list';
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
			'base_url',
			[
				'label'       => 'Base URL',
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => 'https://www.mrii.ie',
				'placeholder' => 'https://www.example.com',
				'label_block' => true,
			]
		);

		$this->add_control(
			'category_id',
			[
				'label'   => 'Category ID',
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 26,
				'min'     => 1,
			]
		);

		$this->add_control(
			'start_year',
			[
				'label'   => 'Start Year',
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 2014,
				'min'     => 2000,
				'max'     => (int) date( 'Y' ),
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings     = $this->get_settings_for_display();
		$base_url     = rtrim( esc_url( $settings['base_url'] ), '/' );
		$category_id  = absint( $settings['category_id'] );
		$start_year   = absint( $settings['start_year'] );
		$current_year = (int) date( 'Y' );

		if ( $start_year < 2000 || $start_year > $current_year ) {
			return;
		}

		echo '<ul>';
		for ( $year = $current_year; $year >= $start_year; $year-- ) {
			$url = $base_url . '/' . $year . '/?cat=' . $category_id;
			echo '<li><a href="' . esc_url( $url ) . '">' . esc_html( $year ) . '</a></li>';
		}
		echo '</ul>';
	}
}
