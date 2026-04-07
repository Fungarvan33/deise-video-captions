(function($){
	'use strict';

	function initVideoCaptions($scope) {
		var $widgets = $scope.find('.lcp-video-captions');
		if (!$widgets.length && $scope.hasClass('lcp-video-captions')) {
			$widgets = $scope;
		}

		$widgets.each(function(){
			var $widget = $(this);
			if ($widget.data('dvc-init')) {
				return;
			}
			$widget.data('dvc-init', true);

			var $video    = $widget.find('.lcp-video-captions__video').first();
			var $captions = $widget.find('.lcp-video-captions__caption');
			var settings  = $widget.data('settings') || {};
			var speed     = parseInt(settings.transitionSpeed || 600, 10);
			var entryAnim = settings.entryAnimation || 'fly-up';
			var exitAnim  = settings.exitAnimation  || 'fade';
			var isEditor  = !!settings.isEditor;

			// Calculate transforms from the actual container dimensions so
			// captions always start/end at the real edge of the widget.
			function entryTransform() {
				var h = $widget.outerHeight();
				var w = $widget.outerWidth();
				switch (entryAnim) {
					case 'fly-up':    return 'translate3d(0, '  + h  + 'px, 0)';
					case 'fly-down':  return 'translate3d(0, -'  + h  + 'px, 0)';
					case 'fly-left':  return 'translate3d('  + w  + 'px, 0, 0)';
					case 'fly-right': return 'translate3d(-' + w  + 'px, 0, 0)';
					default:          return 'translate3d(0, 0, 0)'; // fade
				}
			}

			function exitTransform() {
				var h = $widget.outerHeight();
				var w = $widget.outerWidth();
				switch (exitAnim) {
					case 'fly-up':    return 'translate3d(0, -'  + h  + 'px, 0)';
					case 'fly-down':  return 'translate3d(0, '   + h  + 'px, 0)';
					case 'fly-left':  return 'translate3d(-' + w  + 'px, 0, 0)';
					case 'fly-right': return 'translate3d('  + w  + 'px, 0, 0)';
					default:          return 'translate3d(0, 0, 0)'; // fade
				}
			}

			// Editor preview: show the first previewable caption at rest.
			if (isEditor) {
				$captions.each(function(index){
					var $caption = $(this);
					if ($caption.attr('data-preview') === '1' && index === 0) {
						$caption.addClass('is-active').css({
							'transform': 'translate3d(0, 0, 0)',
							'opacity':   '1'
						});
					}
				});
			}

			function hideCaption($caption) {
				if (!$caption.hasClass('is-active') || $caption.hasClass('is-exiting')) {
					return;
				}
				$caption.addClass('is-exiting');
				$caption.css({
					'transition-duration': speed + 'ms',
					'transform':           exitTransform(),
					'opacity':             '0'
				});
				var timer = window.setTimeout(function(){
					$caption.removeClass('is-active is-exiting').css({
						'transition-duration': '',
						'transform':           '',
						'opacity':             ''
					});
				}, speed);
				$caption.data('dvc-exit-timer', timer);
			}

			function showCaption($caption) {
				if ($caption.hasClass('is-active')) {
					return;
				}
				// Cancel any in-progress exit on this caption.
				if ($caption.hasClass('is-exiting')) {
					window.clearTimeout($caption.data('dvc-exit-timer'));
					$caption.removeClass('is-exiting');
				}
				// Place the caption at its off-screen starting position instantly.
				$caption.css({
					'transition-duration': '0ms',
					'transform':           entryTransform(),
					'opacity':             '0'
				}).addClass('is-active');
				// Force a reflow so the browser registers the start position
				// before we begin the transition.
				void $caption[0].offsetHeight;
				// Animate to the resting position.
				$caption.css({
					'transition-duration': speed + 'ms',
					'transform':           'translate3d(0, 0, 0)',
					'opacity':             '1'
				});
			}

			function updateCaptions(currentTime) {
				$captions.each(function(){
					var $caption = $(this);
					var start = parseFloat($caption.attr('data-start') || 0);
					var end   = parseFloat($caption.attr('data-end')   || 0);

					if (currentTime >= start && currentTime < end) {
						showCaption($caption);
					} else {
						hideCaption($caption);
					}
				});
			}

			// Fade out the poster image once the video begins playing.
			var $poster = $widget.find('.lcp-video-captions__poster');
			if ($poster.length && $video.length) {
				var vid = $video[0];
				function hidePoster() {
					$poster.addClass('is-hidden');
				}
				if (!vid.paused || vid.currentTime > 0) {
					hidePoster();
				} else {
					$video.one('playing', hidePoster);
				}
			}

			if ($video.length) {
				$video.on('timeupdate', function(){
					updateCaptions(this.currentTime || 0);
				});

				$video.on('seeked ended', function(){
					updateCaptions(this.currentTime || 0);
				});
			}

			// Audio toggle icon
			var $audioBtn = $widget.find('.lcp-video-captions__audio-btn');
			if ($audioBtn.length && $video.length) {
				function syncAudioIcon() {
					if ($video[0].muted) {
						$audioBtn.addClass('is-muted').attr('aria-label', 'Unmute');
					} else {
						$audioBtn.removeClass('is-muted').attr('aria-label', 'Mute');
					}
				}

				$audioBtn.on('click', function(){
					$video[0].muted = !$video[0].muted;
					syncAudioIcon();
				});

				syncAudioIcon();
			}
		});
	}

	$(window).on('elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction('frontend/element_ready/lcp_video_captions.default', initVideoCaptions);
	});

	$(function(){
		initVideoCaptions($(document));
	});
})(jQuery);
