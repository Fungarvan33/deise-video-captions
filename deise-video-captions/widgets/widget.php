<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Deise_Video_Captions_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'deise_video_captions';
	}

	public function get_title() {
		return esc_html__( 'Deise Video Captions', 'deise-video-captions' );
	}

	public function get_icon() {
		return 'eicon-video-playlist';
	}

	public function get_categories() {
		return array( 'general' );
	}

	public function get_style_depends() {
		return array( 'deise-video-captions' );
	}

	public function get_script_depends() {
		return array( 'deise-video-captions' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_video',
			array(
				'label' => esc_html__( 'Video', 'deise-video-captions' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'video_file',
			array(
				'label'       => esc_html__( 'Video File', 'deise-video-captions' ),
				'type'        => \Elementor\Controls_Manager::MEDIA,
				'media_types' => array( 'video' ),
			)
		);

		$this->add_control(
			'poster_image',
			array(
				'label' => esc_html__( 'Poster Image', 'deise-video-captions' ),
				'type'  => \Elementor\Controls_Manager::MEDIA,
			)
		);

		$this->add_control(
			'playback_note',
			array(
				'type'            => \Elementor\Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'For reliable autoplay in browsers, keep the video muted.', 'deise-video-captions' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			)
		);

		$this->add_control(
			'autoplay',
			array(
				'label'        => esc_html__( 'Autoplay', 'deise-video-captions' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'loop',
			array(
				'label'        => esc_html__( 'Loop', 'deise-video-captions' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'muted',
			array(
				'label'        => esc_html__( 'Muted', 'deise-video-captions' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'playsinline',
			array(
				'label'        => esc_html__( 'Plays Inline', 'deise-video-captions' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'show_audio_icon',
			array(
				'label'        => esc_html__( 'Audio Toggle Icon', 'deise-video-captions' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'no',
				'description'  => esc_html__( 'Show a mute/unmute button in the bottom-right corner.', 'deise-video-captions' ),
			)
		);

		$this->add_responsive_control(
			'video_height',
			array(
				'label'      => esc_html__( 'Video Height', 'deise-video-captions' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'vh' ),
				'range'      => array(
					'px' => array(
						'min' => 120,
						'max' => 1200,
					),
					'vh' => array(
						'min' => 10,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => 'vh',
					'size' => 60,
				),
				'tablet_default' => array(
					'unit' => 'vh',
					'size' => 50,
				),
				'mobile_default' => array(
					'unit' => 'vh',
					'size' => 40,
				),
				'selectors'  => array(
					'{{WRAPPER}} .deise-video-captions' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_captions',
			array(
				'label' => esc_html__( 'Captions', 'deise-video-captions' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'caption_content',
			array(
				'label'   => esc_html__( 'Caption', 'deise-video-captions' ),
				'type'    => \Elementor\Controls_Manager::WYSIWYG,
				'default' => '<p>' . esc_html__( 'Your caption text', 'deise-video-captions' ) . '</p>',
			)
		);

		$repeater->add_control(
			'start_time',
			array(
				'label'       => esc_html__( 'Start Time (seconds)', 'deise-video-captions' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'default'     => 0,
				'min'         => 0,
				'step'        => 0.1,
			)
		);

		$repeater->add_control(
			'end_time',
			array(
				'label'       => esc_html__( 'End Time (seconds)', 'deise-video-captions' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'default'     => 3,
				'min'         => 0,
				'step'        => 0.1,
			)
		);

		$repeater->add_control(
			'preview_active',
			array(
				'label'        => esc_html__( 'Show in Editor Preview', 'deise-video-captions' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'captions',
			array(
				'label'       => esc_html__( 'Captions', 'deise-video-captions' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ caption_content ? caption_content.replace(/<[^>]*>/g, "").substring(0, 30) : "Caption" }}}',
				'default'     => array(
					array(
						'caption_content' => '<p>' . esc_html__( 'Caption one', 'deise-video-captions' ) . '</p>',
						'start_time'      => 0,
						'end_time'        => 3,
					),
					array(
						'caption_content' => '<p>' . esc_html__( 'Caption two', 'deise-video-captions' ) . '</p>',
						'start_time'      => 3.5,
						'end_time'        => 6.5,
					),
				),
			)
		);

		$this->add_control(
			'entry_animation',
			array(
				'label'   => esc_html__( 'Entry Animation', 'deise-video-captions' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'fly-up',
				'options' => array(
					'fly-up'    => esc_html__( 'Fly Up', 'deise-video-captions' ),
					'fly-down'  => esc_html__( 'Fly Down', 'deise-video-captions' ),
					'fly-left'  => esc_html__( 'Fly Left', 'deise-video-captions' ),
					'fly-right' => esc_html__( 'Fly Right', 'deise-video-captions' ),
					'fade'      => esc_html__( 'Fade', 'deise-video-captions' ),
				),
			)
		);

		$this->add_control(
			'exit_animation',
			array(
				'label'   => esc_html__( 'Exit Animation', 'deise-video-captions' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'fade',
				'options' => array(
					'fly-up'    => esc_html__( 'Fly Up', 'deise-video-captions' ),
					'fly-down'  => esc_html__( 'Fly Down', 'deise-video-captions' ),
					'fly-left'  => esc_html__( 'Fly Left', 'deise-video-captions' ),
					'fly-right' => esc_html__( 'Fly Right', 'deise-video-captions' ),
					'fade'      => esc_html__( 'Fade', 'deise-video-captions' ),
				),
			)
		);

		$this->add_control(
			'transition_speed',
			array(
				'label'      => esc_html__( 'Transition Speed (ms)', 'deise-video-captions' ),
				'type'       => \Elementor\Controls_Manager::NUMBER,
				'default'    => 600,
				'min'        => 100,
				'max'        => 5000,
				'step'       => 50,
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_caption_style',
			array(
				'label' => esc_html__( 'Captions', 'deise-video-captions' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'caption_text_color',
			array(
				'label'     => esc_html__( 'Text Colour', 'deise-video-captions' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .deise-video-captions__caption' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'     => 'caption_background',
				'selector' => '{{WRAPPER}} .deise-video-captions__caption',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'caption_typography',
				'selector' => '{{WRAPPER}} .deise-video-captions__caption, {{WRAPPER}} .deise-video-captions__caption p, {{WRAPPER}} .deise-video-captions__caption h1, {{WRAPPER}} .deise-video-captions__caption h2, {{WRAPPER}} .deise-video-captions__caption h3, {{WRAPPER}} .deise-video-captions__caption h4, {{WRAPPER}} .deise-video-captions__caption h5, {{WRAPPER}} .deise-video-captions__caption h6',
			)
		);

		$this->add_responsive_control(
			'caption_max_width',
			array(
				'label'      => esc_html__( 'Max Width', 'deise-video-captions' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'vw' ),
				'range'      => array(
					'px' => array( 'min' => 100, 'max' => 1600 ),
					'%'  => array( 'min' => 10, 'max' => 100 ),
					'vw' => array( 'min' => 10, 'max' => 100 ),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 700,
				),
				'selectors'  => array(
					'{{WRAPPER}} .deise-video-captions__caption' => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'caption_padding',
			array(
				'label'      => esc_html__( 'Padding', 'deise-video-captions' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em', 'rem' ),
				'selectors'  => array(
					'{{WRAPPER}} .deise-video-captions__caption' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'caption_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'deise-video-captions' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .deise-video-captions__caption' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'caption_box_shadow',
				'selector' => '{{WRAPPER}} .deise-video-captions__caption',
			)
		);

		$this->add_responsive_control(
			'caption_horizontal_align',
			array(
				'label'   => esc_html__( 'Horizontal Position', 'deise-video-captions' ),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'options' => array(
					'flex-start' => array(
						'title' => esc_html__( 'Left', 'deise-video-captions' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Centre', 'deise-video-captions' ),
						'icon'  => 'eicon-text-align-center',
					),
					'flex-end' => array(
						'title' => esc_html__( 'Right', 'deise-video-captions' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'center',
				'selectors' => array(
					'{{WRAPPER}} .deise-video-captions__overlay' => 'justify-content: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'caption_text_align',
			array(
				'label'   => esc_html__( 'Text Alignment', 'deise-video-captions' ),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'options' => array(
					'left' => array(
						'title' => esc_html__( 'Left', 'deise-video-captions' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Centre', 'deise-video-captions' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'deise-video-captions' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'center',
				'selectors' => array(
					'{{WRAPPER}} .deise-video-captions__caption' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'caption_vertical_position',
			array(
				'label'   => esc_html__( 'Vertical Position', 'deise-video-captions' ),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'options' => array(
					'flex-start' => array(
						'title' => esc_html__( 'Top', 'deise-video-captions' ),
						'icon'  => 'eicon-v-align-top',
					),
					'center' => array(
						'title' => esc_html__( 'Middle', 'deise-video-captions' ),
						'icon'  => 'eicon-v-align-middle',
					),
					'flex-end' => array(
						'title' => esc_html__( 'Bottom', 'deise-video-captions' ),
						'icon'  => 'eicon-v-align-bottom',
					),
				),
				'default'   => 'flex-end',
				'selectors' => array(
					'{{WRAPPER}} .deise-video-captions__overlay' => 'align-items: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'caption_overlay_padding',
			array(
				'label'      => esc_html__( 'Overlay Padding', 'deise-video-captions' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'vw', 'vh' ),
				'selectors'  => array(
					'{{WRAPPER}} .deise-video-captions__overlay' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// ── Audio Icon Style ───────────────────────────────────────────────────

		$this->start_controls_section(
			'section_audio_icon_style',
			array(
				'label'     => esc_html__( 'Audio Icon', 'deise-video-captions' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array( 'show_audio_icon' => 'yes' ),
			)
		);

		$this->add_control(
			'audio_icon_size',
			array(
				'label'      => esc_html__( 'Icon Size', 'deise-video-captions' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array( 'min' => 12, 'max' => 80 ),
				),
				'default'    => array( 'unit' => 'px', 'size' => 24 ),
				'selectors'  => array(
					'{{WRAPPER}} .deise-video-captions__audio-btn svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'audio_icon_color',
			array(
				'label'     => esc_html__( 'Icon Colour', 'deise-video-captions' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .deise-video-captions__audio-btn' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'     => 'audio_icon_background',
				'selector' => '{{WRAPPER}} .deise-video-captions__audio-btn',
			)
		);

		$this->add_responsive_control(
			'audio_icon_padding',
			array(
				'label'      => esc_html__( 'Padding', 'deise-video-captions' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .deise-video-captions__audio-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'audio_icon_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'deise-video-captions' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .deise-video-captions__audio-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'audio_icon_opacity',
			array(
				'label'      => esc_html__( 'Opacity', 'deise-video-captions' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 1, 'step' => 0.05 ),
				),
				'default'    => array( 'size' => 0.8 ),
				'selectors'  => array(
					'{{WRAPPER}} .deise-video-captions__audio-btn' => 'opacity: {{SIZE}};',
				),
			)
		);

		$this->add_responsive_control(
			'audio_icon_bottom',
			array(
				'label'      => esc_html__( 'Bottom Offset', 'deise-video-captions' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 200 ),
					'%'  => array( 'min' => 0, 'max' => 100 ),
				),
				'default'    => array( 'unit' => 'px', 'size' => 16 ),
				'selectors'  => array(
					'{{WRAPPER}} .deise-video-captions__audio-btn' => 'bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'audio_icon_right',
			array(
				'label'      => esc_html__( 'Right Offset', 'deise-video-captions' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 200 ),
					'%'  => array( 'min' => 0, 'max' => 100 ),
				),
				'default'    => array( 'unit' => 'px', 'size' => 16 ),
				'selectors'  => array(
					'{{WRAPPER}} .deise-video-captions__audio-btn' => 'right: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$video_url       = ! empty( $settings['video_file']['url'] ) ? $settings['video_file']['url'] : '';
		$poster_url      = ! empty( $settings['poster_image']['url'] ) ? $settings['poster_image']['url'] : '';
		$captions        = ! empty( $settings['captions'] ) ? $settings['captions'] : array();
		$is_editor       = \Elementor\Plugin::$instance->editor->is_edit_mode();
		$show_audio_icon = ! empty( $settings['show_audio_icon'] ) && 'yes' === $settings['show_audio_icon'];

		$uid = 'dvc-' . $this->get_id();

		$data = array(
			'entryAnimation' => ! empty( $settings['entry_animation'] ) ? $settings['entry_animation'] : 'fly-up',
			'exitAnimation'  => ! empty( $settings['exit_animation'] ) ? $settings['exit_animation'] : 'fade',
			'transitionSpeed'=> ! empty( $settings['transition_speed'] ) ? (int) $settings['transition_speed'] : 600,
			'isEditor'       => $is_editor,
		);

		$this->add_render_attribute( 'wrapper', 'class', 'deise-video-captions' );
		$this->add_render_attribute( 'wrapper', 'id', esc_attr( $uid ) );
		$this->add_render_attribute( 'wrapper', 'data-settings', wp_json_encode( $data ) );

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<div class="deise-video-captions__media">
				<?php if ( $video_url ) : ?>
					<video
						class="deise-video-captions__video"
						<?php echo ( 'yes' === $settings['autoplay'] ) ? 'autoplay' : ''; ?>
						<?php echo ( 'yes' === $settings['loop'] ) ? 'loop' : ''; ?>
						<?php echo ( 'yes' === $settings['muted'] ) ? 'muted' : ''; ?>
						<?php echo ( 'yes' === $settings['playsinline'] ) ? 'playsinline' : ''; ?>
						preload="metadata"
						<?php echo $poster_url ? 'poster="' . esc_url( $poster_url ) . '"' : ''; ?>
					>
						<source src="<?php echo esc_url( $video_url ); ?>" type="video/mp4">
					</video>
				<?php elseif ( $poster_url ) : ?>
					<div class="deise-video-captions__poster-fallback" style="background-image:url('<?php echo esc_url( $poster_url ); ?>');"></div>
				<?php else : ?>
					<div class="deise-video-captions__placeholder"><?php esc_html_e( 'Choose a video in the widget settings.', 'deise-video-captions' ); ?></div>
				<?php endif; ?>
			</div>

			<div class="deise-video-captions__overlay">
				<?php foreach ( $captions as $index => $caption ) : ?>
					<?php
					$start = isset( $caption['start_time'] ) ? (float) $caption['start_time'] : 0;
					$end   = isset( $caption['end_time'] ) ? (float) $caption['end_time'] : 0;
					$show_in_editor = ! isset( $caption['preview_active'] ) || 'yes' === $caption['preview_active'];
					$editor_class = ( $is_editor && 0 === $index && $show_in_editor ) ? ' is-editor-preview' : '';
					?>
					<div
						class="deise-video-captions__caption<?php echo esc_attr( $editor_class ); ?>"
						data-start="<?php echo esc_attr( $start ); ?>"
						data-end="<?php echo esc_attr( $end ); ?>"
						data-preview="<?php echo $show_in_editor ? '1' : '0'; ?>"
					>
						<div class="deise-video-captions__caption-inner">
							<?php echo wp_kses_post( $caption['caption_content'] ); ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>

			<?php if ( $show_audio_icon ) : ?>
				<button
					class="deise-video-captions__audio-btn<?php echo ( 'yes' === $settings['muted'] ) ? ' is-muted' : ''; ?>"
					aria-label="<?php echo ( 'yes' === $settings['muted'] ) ? esc_attr__( 'Unmute', 'deise-video-captions' ) : esc_attr__( 'Mute', 'deise-video-captions' ); ?>"
					type="button"
				>
					<!-- Muted icon (speaker with slash) -->
					<svg class="deise-video-captions__audio-icon deise-video-captions__audio-icon--muted" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
						<path d="M3.63 3.63a.996.996 0 000 1.41L7.29 8.7 7 9H4c-.55 0-1 .45-1 1v4c0 .55.45 1 1 1h3l3.29 3.29c.63.63 1.71.18 1.71-.71v-4.17l4.18 4.18c-.49.37-1.02.68-1.6.91-.36.14-.58.53-.58.92 0 .72.73 1.18 1.39.91.8-.33 1.55-.77 2.22-1.31l1.34 1.34a.996.996 0 101.41-1.41L5.05 3.63c-.39-.39-1.02-.39-1.42 0zM19 12c0 .82-.15 1.61-.41 2.34l1.53 1.53c.56-1.17.88-2.48.88-3.87 0-3.83-2.4-7.11-5.78-8.4-.59-.23-1.22.23-1.22.86v.19c0 .38.25.71.61.85C17.18 6.54 19 9.06 19 12zm-8.71-6.29l-.17.17L12 7.76V6.41c0-.89-1.08-1.34-1.71-.71zM16.5 12A4.5 4.5 0 0014 7.97v1.79l2.48 2.48c.01-.08.02-.16.02-.24z"/>
					</svg>
					<!-- Unmuted icon (speaker with waves) -->
					<svg class="deise-video-captions__audio-icon deise-video-captions__audio-icon--unmuted" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
						<path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z"/>
					</svg>
				</button>
			<?php endif; ?>
		</div>
		<?php
	}
}
