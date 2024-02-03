var HOMEID = HOMEID || {};
(function ($) {
	"use strict";

	HOMEID = {
		init: function () {
			this.search();
			this.mobileEvent();
			this.menuPopupTransition();
			this.ParallaxImg();
			this.slicktabs();
		},
		isMobile: function () {
			var responsive_breakpoint = 991;
			return window.matchMedia('(max-width: ' + responsive_breakpoint + 'px)').matches;
		},
		search: function () {
			$('.search-form-wrapper .search-icon').on('click', function () {
				$(this).closest('.search-form-wrapper').find('.search-form').toggle();
			});

			$(document).on('click', function (event) {
				if ($(event.target).closest('.search-form-wrapper').length === 0) {
					$('.search-form-wrapper .search-form').hide();
				}
			});
		},
		mobileEvent: function () {
			$('.site-header .menu-toggle-button').on('click', function () {
				var $this = $(this);
				if ($this.hasClass('in')) {
					$this.removeClass('in');
					$('.site-navigation').slideUp();
				}
				else {
					$this.addClass('in');
					$('.site-navigation').slideDown();
				}

			});

			$('.main-menu a').on('click', function (event) {
				if (HOMEID.isMobile()) {
					if ($(event.target).closest('.caret').length !== 0) {
						event.preventDefault();
					}
				}

			});
			$('.main-menu .menu-item-has-children .caret').on('click', function () {
				if (HOMEID.isMobile()) {
					var $this = $(this);
					$this.closest('li').find(' > .sub-menu').slideToggle();
					$this.toggleClass('in');
				}
			});
		},
		menuPopupTransition: function () {
			$('.g5core-menu-popup .main-menu > li > a').each(function (index) {
				$(this).css('transition-delay', (index * 200) + 'ms');
			});

			$('.g5core-menu-popup .main-menu li').on('click', function () {
				$(this).css('height','auto');
			})
		},
		ParallaxImg: function () {
			var image_wrapper = $(".custom-parallax-single-image");

			image_wrapper.mousemove(function (e) {
				e.preventDefault();

				var wx = $(window).width();
				var wy = $(window).height();

				var x = e.pageX - this.offsetLeft;
				var y = e.pageY - this.offsetTop;

				var newx = x - wx / 2;
				var newy = y - wy / 2;


				$.each(image_wrapper.find('.vc_single_image-wrapper'), function (index) {
					var speed = 0.01 + index / 100;
					TweenMax.to($(this), 1, {x: (1 - newx * speed), y: (1 - newy * speed)});

				});
			});
			image_wrapper.on('mouseleave', (function (e) {
				e.preventDefault();
				$.each(image_wrapper.find('.vc_single_image-wrapper'), function () {
					TweenMax.to($(this), 1, {x: 0, y: 0});

				});

			}));
		},
		slicktabs: function () {
			$('.vc_tta-panel').on("click",function () {
				setTimeout(function() {
					$('.gel-slider-container').slick("refresh");
				});
			});
		}
	};

	$(document).ready(function () {
		HOMEID.init();
	});
	$(window).resize(function () {
		if (!HOMEID.isMobile()) {
			$('.site-header .menu-toggle-button').removeClass('in');
			$('.main-menu .menu-item-has-children .caret').removeClass('in');
			$('.site-navigation').css('display', '');
			$('.main-menu .menu-item-has-children > .sub-menu').css('display', '');
		}
	});

})(jQuery);

