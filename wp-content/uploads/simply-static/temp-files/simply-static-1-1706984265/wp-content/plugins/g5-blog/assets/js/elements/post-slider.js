(function ($) {
	'use strict';
	var G5PostSliderHandler = function ($scope, $) {
		G5CORE.util.slickSlider($scope);
		new G5CORE_Animation($scope);
	};
	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/ube-g5-posts-slider.default', G5PostSliderHandler);
	});

})(jQuery);