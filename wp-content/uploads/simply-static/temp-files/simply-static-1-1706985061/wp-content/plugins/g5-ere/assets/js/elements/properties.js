(function ($) {
	'use strict';
	var G5ERE_Property_Handler = function ($scope, $) {
		new G5CORE_Animation($scope);
		G5CORE.isotope.init($scope);
		G5CORE.modernGrid.init($scope);

	};
	window.addEventListener( 'elementor/frontend/init', () => {
		elementorFrontend.hooks.addAction('frontend/element_ready/g5-properties.default', G5ERE_Property_Handler);
	});

})(jQuery);