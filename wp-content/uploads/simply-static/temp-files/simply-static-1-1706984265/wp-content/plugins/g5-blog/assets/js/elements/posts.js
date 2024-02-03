(function ($) {
	'use strict';
	var G5_Post_Handler = function ($scope, $) {
		new G5CORE_Animation($scope);
	};
	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/ube-g5-posts.default', G5_Post_Handler);
	});

})(jQuery);