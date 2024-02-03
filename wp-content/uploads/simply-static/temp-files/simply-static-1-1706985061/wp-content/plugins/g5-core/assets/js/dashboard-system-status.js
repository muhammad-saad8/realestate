(function ($) {
	"use strict";
	var GF_Dashboard_System_Status = function() {
		this.init();
	};
	GF_Dashboard_System_Status.prototype = {
		init: function() {
			this.tooltips();
			this.get_status_report();
			this.copy();
			this.textarea_click();
		},
		tooltips: function() {
			if ($().powerTip) {
				var options = {};
				$('.g5core-tooltip').powerTip(options);
			}
		},
		get_status_report : function() {
			var self = this;
			$('.g5core-debug-report').on('click', function (event) {
				event.preventDefault();
				var $wrap = $(this).closest('.g5core-system-status-info'),
					$parent = $(this).closest('.g5core-system-info'),
					$info = $wrap.find('.g5core-system-report');

				var report = '';
				$('.g5core-box:not(.g5core-copy-system-status)', '.g5core-dashboard-content').each(function () {
					var $heading = $(this).find('.g5core-box-head'),
						$system_status = $(this).find('.g5core-system-status-list');
					report += "\n### " + $.trim($heading.text()) + " ###\n\n";

					$('li', $system_status).each(function () {
						var $label = $(this).find('.g5core-label'),
							$info = $(this).find('.g5core-info'),
							the_name = $.trim($label.text()).replace(/(<([^>]+)>)/ig, ''),
							the_value = $.trim($info.text()).replace(/(<([^>]+)>)/ig, '');

						report += '' + the_name + ': ' + the_value + "\n";

					});

				});
				$('.g5core-system-report textarea[name="system-report"]').val(report);

				$parent.slideUp("slow", function () {
					$info.slideDown('slow',function() {
						self.select_all();
					});
				});
			});
		},
		select_all : function() {
			$('.g5core-system-report textarea[name="system-report"]').focus().select();
		},
		copy : function() {
			var self = this;
			$(".g5core-copy-system-report").on('click', function (e) {
				e.preventDefault();
				self.select_all();
				document.execCommand('copy');
			});
		},
		textarea_click: function () {
			var self = this;
			$('.g5core-system-report textarea[name="system-report"]').on('click',function () {
				self.select_all();
			});
		}

	};

	$(document).ready(function(){
		new GF_Dashboard_System_Status();
	});
})(jQuery);
