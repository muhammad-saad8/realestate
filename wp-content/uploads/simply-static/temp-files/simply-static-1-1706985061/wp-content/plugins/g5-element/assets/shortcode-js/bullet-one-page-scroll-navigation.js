(function ($) {
	"use strict";
	$(document).ready(function () {
		var $body = $('body');
		var $window = $(window);
		var adminBarHeight = 0;
		if ($body.hasClass('admin-bar')) {
			var $adminBar = $('#wpadminbar');
			if ($adminBar.css('position') === 'fixed') {
				adminBarHeight = $adminBar.outerHeight();
			}
		}
		var offset = 300 + adminBarHeight;
		$('.nav-link').tooltip({
			placement: 'left'
		});
		$body.scrollspy({
			target: '#g5element-main-nav',
			offset: offset
		});
		var $nav = $('.g5element-nav');
		var $nav_link = $nav.find('.nav-link');
		var $active_element = $nav.find('.nav-link.active');
		var ids = [];
		$nav_link.each(function () {
			ids.push($(this).attr('href'));
		});
		if ($active_element.length < 1) {
			$nav.hide();
		} else {
			$nav.show();
		}
		toggle_skin_class($nav);
		$window.on('activate.bs.scrollspy', function (e, obj) {
			toggle_skin_class($nav);
		});

		$window.on('scroll', function (e) {
			e.preventDefault();
			var $active_element = $nav.find('.nav-link.active');
			if ($active_element.length < 1) {
				$nav.hide();
			} else {
				$nav.show();
			}
			var $first_section = $(ids[0]);
			var last_section = $(ids[ids.length - 1]);
			if ($first_section.position().top > $(document).scrollTop() && ($first_section.position().top + $first_section.outerHeight()) > $(document).scrollTop()) {
				$nav.hide();
			} else {
				$nav.show();
			}
			var is_end = $(this).scrollTop() + $(this).height() > last_section.offset().top + last_section.height() + 250;
			if (is_end) {
				$nav.hide();
			} else {
				$nav.show();
			}

		});
		$('a[href*=#]:not([href=#])').click(function () {
			if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
				var target = $(this.hash);
				target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
				if (target.length) {
					$('html, body').animate({
						scrollTop: target.offset().top
					}, 500);
					return false;
				}
			}
		});

		function toggle_skin_class($nav) {
			$nav.removeClass('nav-dark');
			$nav.removeClass('nav-light');
			var $active_element = $nav.find('.nav-link.active');
			var $skin = $active_element.data('skin');
			$nav.addClass('nav-' + $skin);
		}

	});
})(jQuery);
