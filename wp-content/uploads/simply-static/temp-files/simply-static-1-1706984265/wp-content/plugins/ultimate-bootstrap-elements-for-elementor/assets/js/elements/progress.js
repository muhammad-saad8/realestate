(function ($) {
	'use strict';
	var UbeProgressHandler = function ($scope, $) {
		var $progressbar = $scope.find('.progress-bar');
		$.each($progressbar, function () {
			var settings = $(this).data("settings"),
				length = settings.progress_value,
				speed = settings.speed;
			$(this).css({"opacity": "1", "width": length + "%","transition-duration":speed +"ms"});
		});
	};

	var UbeProgressScrollWidgetHandler = function ($scope, $) {
		elementorFrontend.waypoint($scope, function () {
			UbeProgressHandler($(this), $);
		}, {
			offset: Waypoint.viewportHeight(),
			triggerOnce: true
		});
	};

	 window.addEventListener( 'elementor/frontend/init', () => {
		if (elementorFrontend.isEditMode()) {
			elementorFrontend.hooks.addAction(
				"frontend/element_ready/ube-progress.default", UbeProgressHandler);
		} else {
			elementorFrontend.hooks.addAction(
				"frontend/element_ready/ube-progress.default", UbeProgressScrollWidgetHandler);
		}
	});

})(jQuery);
