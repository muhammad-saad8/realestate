(function ($) {
	"use strict";

	var GF_Widget_Areas = {
		init : function() {
			$('.g5core-sidebars-wrap .g5core-sidebars-remove-item').on('click', function () {
				var $this = $(this);
				if (confirm(g5core_widget_areas_variable.confirm_delete)) {
					var widget_name = $this.data('id');

					$.ajax({
						type: "POST",
						url: g5core_widget_areas_variable.ajax_url,
						data: {
							name: widget_name
						},
						success: function (response) {
							if (response.trim() == 'widget-area-deleted') {
								$this.closest('tr').slideUp(200).remove();
							}
						}
					});
				}
			});
		}
	};

	$(function () {
		GF_Widget_Areas.init();
	});
})(jQuery);
