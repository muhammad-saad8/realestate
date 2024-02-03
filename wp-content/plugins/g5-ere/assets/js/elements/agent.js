(function ($) {
	'use strict';
	var G5ERE_Agent_Handler = function ($scope, $) {
		new G5CORE_Animation($scope);
	};
	window.addEventListener( 'elementor/frontend/init', () => {
		elementorFrontend.hooks.addAction('frontend/element_ready/g5-agent.default', G5ERE_Agent_Handler);
	});

})(jQuery);