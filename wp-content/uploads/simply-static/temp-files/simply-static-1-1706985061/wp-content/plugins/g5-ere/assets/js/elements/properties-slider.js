(function ($) {
	'use strict';
	var G5ERE_Property_Slider_Handler = function ($scope, $) {
		G5ERE_SC_PROPERTIES_SLIDER.setHeight($scope);
	};
	window.addEventListener( 'elementor/frontend/init', () => {
		elementorFrontend.hooks.addAction('frontend/element_ready/g5-properties-slider.default', G5ERE_Property_Slider_Handler);
	});
})(jQuery);