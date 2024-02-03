var G5CORE = G5CORE || {},
	G5CORE_Animation = window.G5CORE_Animation || {};
(function ($) {
	"use strict";

	var $body = $('body'),
		$window = $(window),
		$siteWrapper = $('#site-wrapper'),
		$document = $(document),
		changeMediaResponsive = false,
		beforeMedia = '',
		isRTL = $body.hasClass('rtl'),
		_init = false;

	G5CORE.isHeaderMobile = function () {
		var responsive_breakpoint = 991;
		if ($('#site-header').data('responsive-breakpoint')) {
			responsive_breakpoint = $('#site-header').data('responsive-breakpoint');
		}
		return window.matchMedia('(max-width: ' + (responsive_breakpoint) + 'px)').matches;
	};

	G5CORE.getAdminBarHeight = function () {
		var adminBarHeight = 0;
		if ($body.hasClass('admin-bar')) {
			var $adminBar = $('#wpadminbar');
			if ($adminBar.css('position') === 'fixed') {
				adminBarHeight = $adminBar.outerHeight();
			}
		}

		return adminBarHeight;
	};

	G5CORE.lazyLoader = {
		instanceImage : null,
		instanceBackground : null,
		init: function () {
			if (typeof LazyLoad === 'undefined') {
				return;
			}

			var _self = this;

			$('.g5core__lazy-image').each(function () {
				var $parent = $(this).closest('.g5core__lazy-image').parent();
				$parent.addClass('fs-0');
			});

			this.handleLazyImages();
			this.handleLazyBackgrounds();
			setTimeout(function () {
				_self.update();
			},1000);
		},

		handleLazyImages: function() {
			this.instanceImage = new LazyLoad({
				// Your custom settings go here
				elements_selector: ".g5core__ll-image",
				use_native: true,
				callback_loaded: function ($el) {
					$( $el ).unwrap( '.g5core__lazy-image' );
					$($el).parent().removeClass('fs-0');
				},
				callback_error: function ($el) {
					console.log($el);
				}
			});
		},
		handleLazyBackgrounds: function() {
			this.instanceBackground = new LazyLoad({
				elements_selector: ".g5core__ll-background",
				callback_loaded: function ($el) {
					$( $el ).removeClass( 'g5core__ll-background' );
				}
			});
		},
		update: function () {
			$('.g5core__lazy-image').each(function () {
				var $parent = $(this).closest('.g5core__lazy-image').parent();
				$parent.addClass('fs-0');
			});

			if (this.instanceImage !== null ) {
				this.instanceImage.update();
			}

			if (this.instanceBackground !== null ) {
				this.instanceBackground.update();
			}
		}
	};

	G5CORE.util = {
		init: function () {
			this.slickSlider();
			this.mfpEvent();
			this.backToTop();
			this.tooltip();
			this.svgIcon();
			$body.on('g5core_pagination_ajax_success g5core_pagination_ajax_before_update_sidebar', function (event, _data, $ajaxHTML, target, loadMore) {
				setTimeout(function () {
					G5CORE.util.mfpEvent();
					G5CORE.util.svgIcon();
					G5CORE.util.slickSlider();
					G5CORE.util.mfpEvent();
					G5CORE.util.tooltip();
					G5CORE.lazyLoader.update();
				}, 5);
			});
		},
		svgIcon: function ($wrap) {
			if (typeof $wrap === "undefined") {
				$wrap = $('body');
			}

			$wrap.find('.svg-icon').each(function () {
				var $this = $(this),
					_class = $this.attr('class'),
					id = _class.replace('svg-icon svg-icon-', ''),
					_html = '<svg class="' + _class + '" aria-hidden="true" role="img"> <use href="#' + id + '" xlink:href="#' + id + '"></use> </svg>';
				$this.html(_html);
			});
		},
		mfpEvent: function () {
			$('.gel-slider-container').each(function () {
				var $this = $(this),
					$images = $this.find('.wpb_single_image [data-g5core-mfp]');
				if ($images.length) {
					var galleryId = new Date().getTime();
					$images.each(function () {
						$(this).attr('data-gallery-id', galleryId);
					});
				}
			});

			$('[data-g5core-mfp]').each(function () {
				var $this = $(this),
					defaults = {
						type: 'image',
						closeOnBgClick: true,
						closeBtnInside: false,
						//alignTop: true,
						mainClass: 'mfp-zoom-in',
						midClick: true,
						removalDelay: 500,
						callbacks: {
							beforeOpen: function () {
								// just a hack that adds mfp-anim class to markup
								switch (this.st.type) {
									case 'image':
										this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
										break;
									case 'iframe' :
										this.st.iframe.markup = this.st.iframe.markup.replace('mfp-iframe-scaler', 'mfp-iframe-scaler mfp-with-anim');
										break;
								}
							},
							beforeClose: function () {
								this.container.trigger('g5core_mfp_beforeClose');
							},
							close: function () {
								this.container.trigger('g5core_mfp_close');
							},
							change: function () {
								var _this = this;
								if (this.isOpen) {
									this.wrap.removeClass('mfp-ready');
									setTimeout(function () {
										_this.wrap.addClass('mfp-ready');
									}, 10);
								}
							}
						}
					},
					mfpConfig = $.extend({}, defaults, $this.data("mfp-options"));

				var galleryId = $this.data('gallery-id'),
					gallery = $this.data('gallery');
				if ((typeof (galleryId) !== "undefined") || (typeof (gallery) !== "undefined")) {
					var items = [],
						items_src = [];

					if (typeof (galleryId) !== "undefined") {
						var $imageLinks = $('[data-gallery-id="' + galleryId + '"]');
						$imageLinks.each(function () {
							var src = $(this).attr('href');
							if (items_src.indexOf(src) < 0) {
								items_src.push(src);
								items.push({
									src: src
								});
							}
						});
					} else {
						for (var i = 0; i < gallery.length; i++) {
							var src = gallery[i];
							if (items_src.indexOf(src) < 0) {
								items_src.push(src);
								items.push({
									src: src
								});
							}
						}
					}

					mfpConfig.items = items;
					mfpConfig.gallery = {
						enabled: true
					};
					mfpConfig.callbacks.beforeOpen = function () {
						switch (this.st.type) {
							case 'image':
								this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
								break;
							case 'iframe' :
								this.st.iframe.markup = this.st.iframe.markup.replace('mfp-iframe-scaler', 'mfp-iframe-scaler mfp-with-anim');
								break;
						}
						if (typeof (galleryId) !== "undefined") {
							var index = items_src.indexOf(this.st.el[0].href);
							if (-1 !== index) {
								this.goTo(index);
							}
						}
					};
				}

				$this.magnificPopup(mfpConfig);
			});
		},
		tooltip: function () {
			$('[data-toggle="tooltip"]').each(function () {
				var configs = {
					container: $(this).parent()
				};
				if ($(this).closest('.g5core__tooltip-wrap').length) {
					configs = $.extend({}, configs, $(this).closest('.g5core__tooltip-wrap').data('tooltip-options'));
				}
				$(this).tooltip(configs);
			});

		},
		backToTop: function () {
			var $backToTop = $('.g5core-back-to-top');
			if ($backToTop.length > 0) {
				$backToTop.on('click', function (event) {
					event.preventDefault();
					$('html,body').animate({scrollTop: '0px'}, 800);
				});
				$window.on('scroll', function (event) {
					var scrollPosition = $window.scrollTop(),
						windowHeight = $window.height() / 2;
					if (scrollPosition > windowHeight) {
						$backToTop.addClass('in');
					} else {
						$backToTop.removeClass('in');
					}
				});
			}
		},

		slickSlider: function ($wrapper) {
			if (typeof $wrapper === 'undefined') {
				$wrapper = $body;
			}
			var options_default = {
				slidesToScroll: 1,
				slidesToShow: 1,
				adaptiveHeight: true,
				arrows: true,
				dots: true,
				autoplay: false,
				autoplaySpeed: 3000,
				centerMode: false,
				centerPadding: "50px",
				draggable: true,
				fade: false,
				focusOnSelect: false,
				infinite: false,
				pauseOnHover: false,
				responsive: [],
				rtl: false,
				speed: 300,
				vertical: false,
				prevArrow: '<div class="slick-prev" aria-label="Previous"><i class="fas fa-chevron-left"></i></div>',
				nextArrow: '<div class="slick-next" aria-label="Next"><i class="fas fa-chevron-right"></i></div>',
				customPaging: function (slider, i) {
					return $('<span></span>');
				}
			};

			$('.slick-slider:not(.manual)', $wrapper).each(function () {
				var $this = $(this);
				if (!$this.hasClass('slick-initialized')) {
					var options = $this.data('slick-options');
					options = $.extend({}, options_default, options);
					$this.slick(options);
					$this.on('setPosition', function (event, slick) {
						var max_height = 0;
						slick.$slides.each(function () {
							var $slide = $(this);
							if ($slide.hasClass('slick-active')) {
								if (slick.options.adaptiveHeight && (slick.options.slidesToShow > 1) && (slick.options.vertical === false)) {
									if (max_height < $slide.outerHeight()) {
										max_height = $slide.outerHeight();
									}
								}
							}
						});
						if (max_height !== 0) {
							$this.find('> .slick-list').animate({
								height: max_height
							}, 500);
						}
					});


					setTimeout(function () {
						G5CORE.util.mfpEvent();
						G5CORE.util.tooltip();
					}, 10);

					$this.on('breakpoint', function (event, slick, breakpoint) {
						setTimeout(function () {
							G5CORE.util.mfpEvent();
							G5CORE.util.tooltip();
						}, 10);

					});

				}
			});
		},
	};

	G5CORE.page = {
		init: function () {
			this.pageLoading();
		},
		pageLoading: function () {
			var that = this;
			$window.on('load', function () {
				that.fadePageIn();
			});
			setTimeout(function () {
				that.fadePageIn();
			}, 2000);
		},
		fadePageIn: function () {
			if ($body.hasClass('g5core-page-loading')) {
				var preloadTime = 1000,
					$loading = $('.g5core-site-loading');
				$loading.animate({
					opacity: 0,
					delay: 200
				}, preloadTime, "linear", function () {
					$loading.css('display', 'none');
				});
			}
		},
	};

	G5CORE.header = {
		init: function () {
			this.menuPopupEvent();
			this.onePage();
		},
		menuPopupEvent: function () {
			$('.g5core-menu-popup .menu-item-has-children').find(' > a').on('click', function (event) {
				var $this = $(this);
				if (($this.attr('href') !== '#')) {
					return;
				}
				event.preventDefault();
				$this.parent().find(' > .sub-menu').slideToggle();
			});
		},
		onePage: function () {
			if (typeof ($().onePageNav) === 'function') {
				$('.g5core-menu-one-page').onePageNav({
					currentClass: 'menu-current',
					changeHash: false,
					scrollSpeed: 750,
					scrollThreshold: 0,
					filter: '',
					easing: 'swing'
				});
			}
		}
	};

	G5CORE.searchAjax = {
		timeOutSearch: null,
		xhrSearchAjax: null,

		init: function () {
			$('.g5core-search-ajax').each(function () {
				var $this = $(this),
					$input = $this.find('input[type="search"]'),
					$result = $this.find('.result'),
					$icon = $this.find('button > i'),
					$remove = $this.find('.remove');

				$remove.on('click', function () {
					$input.val('').focus();
					$result.html('');
					$remove.removeClass('in');
					$this.removeClass('in');
				});

				$input.on('keyup', function (event) {
					if (event.altKey || event.ctrlKey || event.shiftKey || event.metaKey) {
						return;
					}
					var keys = ["Control", "Alt", "Shift"];
					if (keys.indexOf(event.key) != -1) return;
					switch (event.which) {
						case 27:	// ESC
							$input.val('');
							$result.html('');
							$remove.removeClass('in');
							$this.removeClass('in');
							break;
						case 38:
						case 40:
						case 13:
							break;
						default:
							clearTimeout(G5CORE.searchAjax.timeOutSearch);
							G5CORE.searchAjax.timeOutSearch = setTimeout(G5CORE.searchAjax.search, 500, $this, $input, $icon, $remove, $result);
							break;
					}
				});

				$this.on('submit', function (event) {
					event.preventDefault();
					$(':input[name="action"]', $(this)).attr('disabled', true);
					$(':input[name="_g5core_search_nonce"]', $(this)).attr('disabled', true);
					$(this).unbind('submit').submit(); // continue the submit unbind preventDefault
				})


			});

		},
		search: function ($this, $input, $icon, $remove, $result) {
			var keyword = $input.val();

			if (keyword.length < 1) {
				$result.html('');
				$remove.removeClass('in');
				$this.removeClass('in');
				return;
			}

			$icon.addClass('fa-spinner fa-spin');
			$icon.removeClass('fa-search');

			if (G5CORE.searchAjax.xhrSearchAjax) {
				G5CORE.searchAjax.xhrSearchAjax.abort();
			}


			G5CORE.searchAjax.xhrSearchAjax = $.ajax({
				type: 'POST',
				data: $this.serialize(),
				url: g5_variable.ajax_url,
				dataType: 'html',
				success: function (response) {
					$icon.removeClass('fa-spinner fa-spin');
					$icon.addClass('fa-search');

					$result.html(response);
					$remove.addClass('in');
					$this.addClass('in');
				},
				error: function (response) {
					if (response.statusText == 'abort') {
						return;
					}
					$icon.removeClass('fa-spinner fa-spin');
					$icon.addClass('fa-search');
				}
			});
		}
	};

	G5CORE.offCanvas = {
		init: function () {
			$('[data-off-canvas-target]').on('click', function () {
				var moveStyle = 'from-right';
				if ($($(this).data('off-canvas-target')).hasClass('from-left')) {
					moveStyle = 'from-left';
				}
				$body.toggleClass('g5core-off-canvas-in').toggleClass('g5core-off-canvas-in-' + moveStyle);
			});
			$('.off-canvas-close').on('click', function () {
				$body.removeClass('g5core-off-canvas-in').removeClass('g5core-off-canvas-in-from-left').removeClass('g5core-off-canvas-in-from-right');
			});
			$('.g5core-off-canvas-wrapper > .off-canvas-overlay').on('click', function (event) {
				$body.removeClass('g5core-off-canvas-in').removeClass('g5core-off-canvas-in-from-left').removeClass('g5core-off-canvas-in-from-right');
			});
		}
	};

	G5CORE.login = {
		_isSubmitting: false,
		$loginPopup: $('#g5core_login_popup'),

		init: function () {
			this.formEvent();
		},

		formEvent: function () {
			jQuery('[data-parsley-validate]').each(function () {
				var $form = jQuery(this);
				var instance = $form.parsley();
				instance.refresh();
			});

			var $loginPopup = $('#g5core_login_popup'),
				$loginWrap = $loginPopup.find('.popup-login-wrap'),
				$forgotWrap = $loginPopup.find('.popup-forgot-wrap'),
				$popupRegisterWrap = $loginPopup.find('.popup-register-wrap'),
				$back = $loginPopup.find('.back');
			$loginPopup.find('.forgot-pass-link').on('click', function () {
				$loginWrap.hide();
				$back.show();
				$forgotWrap.fadeIn();
			});

			$loginPopup.find('.popup-btn-register').on('click', function () {
				$loginWrap.hide();
				$back.show();
				$popupRegisterWrap.fadeIn();
			});

			$back.on('click', function () {
				$forgotWrap.hide();
				$popupRegisterWrap.hide();
				$back.hide();
				$loginWrap.fadeIn();
			});

			$loginPopup.find('form').on('submit', function (event) {
				event.preventDefault();
				if (G5CORE.login._isSubmitting) {
					return false;
				}
				G5CORE.login._isSubmitting = true;
				var formData = new FormData(this),
					$currentForm = $(this).closest('.g5core-login-popup-inner'),
					$button = $currentForm.find('button'),
					btnLadda = $button.ladda();
				btnLadda.ladda('start');
				$.ajax({
					type: "POST",
					url: this.action,
					data: formData,
					processData: false,
					contentType: false,
					success: function (response) {
						if (response.success) {
							$currentForm.find('.popup-login-error').html('<div class="alert alert-success">' + response.data + '</div>');
							if ($currentForm.hasClass('popup-login-wrap')) {
								window.location.reload();
							}
						} else {
							$currentForm.find('.popup-login-error').html('<div class="alert alert-danger">' + response.data + '</div>');
						}
					},
					complete: function () {
						btnLadda.ladda('stop');
						G5CORE.login._isSubmitting = false;
					}
				});
				return false;
			});

			$document.on('g5core_mfp_beforeClose', function (event) {
				var $loginPopup = $(event.target).find('.g5core-login-popup');
				if ($loginPopup.length) {
					setTimeout(function () {
						$loginPopup.find('form').each(function () {
							this.reset();
							var instance = $(this).parsley().reset();
						});
						$loginPopup.find('.popup-login-error').html('');
					}, 1000);
				}
			});
		}
	};

	G5CORE.headerSticky = {
		scroll_offset_before: 0,

		init: function () {
			this.sticky();
			this.scroll();
			this.resize();
			this.processSticky();
		},
		sticky: function () {
			$('.header-sticky .sticky-area').each(function () {
				var $this = $(this);
				if (!$this.is(':visible')) {
					return;
				}
				if (!$this.parent().hasClass('sticky-area-wrap')) {
					$this.wrap('<div class="sticky-area-wrap"></div>');
				}
				var $wrap = $this.parent();
				if ($wrap.attr('style') === undefined) {
					$wrap.css('height', $this.css('height'));
				}

			});
		},
		resize: function () {
			$window.resize(function () {
				G5CORE.headerSticky.sticky();
				G5CORE.headerSticky.processSticky();
			});
		},

		scroll: function () {
			$window.on('scroll', function () {
				G5CORE.headerSticky.processSticky();
			});
		},
		processSticky: function () {
			var current_scroll_top = $window.scrollTop();

			$('.header-sticky .sticky-area').each(function () {
				var $this = $(this);
				if (!$this.is(':visible')) {
					return;
				}

				var $wrap = $this.parent(),
					sticky_top = G5CORE.getAdminBarHeight(),
					sticky_current_top = $wrap.offset().top;

				sticky_top += parseInt($body.css('border-top-width'));

				if (sticky_current_top - sticky_top < current_scroll_top) {
					$this.css('position', 'fixed');
					$this.css('top', sticky_top + 'px');
					$wrap.addClass('sticky');
				} else {
					if ($wrap.hasClass('sticky')) {
						$this.css('position', '').css('top', '');
						$wrap.removeClass('sticky');
					}
				}
			});

			if (G5CORE.headerSticky.scroll_offset_before > current_scroll_top) {
				$('.header-sticky-smart .sticky-area').each(function () {
					if ($(this).hasClass('header-hidden')) {
						$(this).removeClass('header-hidden');
					}
				});
			} else {
				// down
				$('.header-sticky-smart .sticky-area').each(function () {
					var $wrapper = $(this).parent();
					if ($wrapper.length) {
						if ((G5CORE.headerSticky.scroll_offset_before > ($wrapper.offset().top + $(this).outerHeight())) && !$(this).hasClass('header-hidden')) {
							$(this).addClass('header-hidden');
						}
					}

				});
			}
			G5CORE.headerSticky.scroll_offset_before = current_scroll_top;
		}
	};

	G5CORE.menuMobile = {
		init: function () {
			$('.g5core-menu-mobile .menu-item-has-children > a').on('click', function (event) {
				var $this = $(this);
				if (($this.attr('href') === '#') || $(event.target).closest('.x-caret').length) {
					event.preventDefault();
					var $sub = $this.parent().find(' > .sub-menu');
					if ($sub.is(':visible')) {
						$this.parent().find(' > .sub-menu').slideUp();
					} else {
						$this.parent().parent().find(' > li > .sub-menu').slideUp();
						$this.parent().find(' > .sub-menu').slideDown();
					}
					$this.find('.x-caret').toggleClass('in');

				}
			});
		}
	};

	G5CORE.sidebarSticky = {
		init: function () {
			var header_sticky_height = 0;
			if ($('#site-header.header-sticky').length > 0) {
				header_sticky_height = 60;
			}
			$('.primary-sidebar.sidebar-sticky > .primary-sidebar-inner').hcSticky({
				stickTo: '#sidebar',
				top: G5CORE.getAdminBarHeight() + header_sticky_height + 30
			});
		}
	};

	G5CORE.sticky = {
		init: function () {
			this.initSticky();
		},
		initSticky: function ($wrapper) {
			if (!$.fn.hcSticky) {
				return;
			}

			if (typeof $wrapper === 'undefined') {
				$wrapper = $body;
			}

			var header_sticky_height = 0;
			if ($('#site-header.header-sticky').length > 0) {
				header_sticky_height = 60;
			}

			var defaults = {
				top: G5CORE.getAdminBarHeight() + header_sticky_height + 30
			};

			$('.g5core-sticky').each(function () {
				var $this = $(this);
				var config = $.extend({}, defaults, $this.data("sticky-options"));
				$this.hcSticky(config);
			});

		}
	};


	G5CORE.footer = {
		init: function () {
			this.footer_fixed();
			this.resize();
		},
		footer_fixed: function () {
			var $footer_boxed = $('.g5core-site-footer-fixed');
			if ($footer_boxed.length) {
				if (window.matchMedia('(min-width: 992px)').matches) {
					var $footer_height = $footer_boxed.outerHeight();
					var $header_sticky = $('.g5core-site-header.header-sticky .sticky-area'),
						body_border_width = parseInt($body.css('border-bottom-width'));
					if ($footer_height + G5CORE.getAdminBarHeight() + $header_sticky.outerHeight() + body_border_width * 2 >= $window.height()) {
						$siteWrapper.css('margin-bottom', '');
						$footer_boxed.addClass('static');
					} else {
						$siteWrapper.css('margin-bottom', $footer_boxed.css('height'));
					}
				} else {
					$siteWrapper.css('margin-bottom', '');
				}
			}
		},
		resize: function () {
			$window.resize(function () {
				G5CORE.footer.footer_fixed();
			});
		}
	};

	G5CORE.isotope = {
		config_default: {
			isOriginLeft: !isRTL
		},
		init: function ($wrapper) {
			if (typeof $wrapper === 'undefined') {
				$wrapper = $body;
			}
			var _that = this;
			$('.isotope', $wrapper).each(function () {
				var $this = $(this);
				$this.imagesLoaded({background: true}, function () {
					var config = $.extend({}, _that.config_default, $this.data('isotope-options')),
						columns_gutter = $this.attr('class').match(/g5core__gutter-(\d{0,2})/);

					if (columns_gutter !== null) {
						columns_gutter = parseInt(columns_gutter[1]);
					} else {
						columns_gutter = 0;
					}


					if ((typeof (config.masonry) !== 'undefined')
						&& (typeof (config.masonry.columnWidth) !== 'undefined')
						&& (config.masonry.columnWidth === '.g5core__col-base')) {

						if ($this.closest('.g5element__gallery').length) {
							$this.append('<div class="g5element__gallery-item g5core__col-base"></div>');
						} else {
							$this.append('<article class="g5core__col-base"></article>');
						}
					}

					if ((typeof (config.masonry) !== 'undefined')
						&& (typeof (config.masonry.columnWidth) !== 'undefined')
						&& (typeof (config.metro) !== 'undefined')) {
						config = $.extend({}, config, {
							masonry: {
								columnWidth: _that.metro_width($this, columns_gutter)
							},
							resize: false
						});
					}

					if (G5CORE.ELEMENTOR.isEditor()) {
						setTimeout(function () {
							$this.isotope(config);
						}, G5CORE.ELEMENTOR.editorTimeout);
					} else {
						$this.isotope(config);
					}
				});
			});

			$window.on('resize', function () {
				$('.isotope', $wrapper).each(function () {
					var $this = $(this),
						config = $.extend({}, _that.config_default, $this.data("isotope-options")),
						columns_gutter = $this.attr('class').match(/g5core__gutter-(\d{0,2})/);

					if (columns_gutter !== null) {
						columns_gutter = parseInt(columns_gutter[1]);
					} else {
						columns_gutter = 0;
					}

					if ((typeof (config.masonry) !== 'undefined')
						&& (typeof (config.masonry.columnWidth) !== 'undefined')
						&& (typeof (config.metro) !== 'undefined')) {
						config = $.extend({}, config, {
							masonry: {
								columnWidth: _that.metro_width($this, columns_gutter)
							},
							resize: false
						});
						$this.isotope(config);
					}
					_that.layout($this);
				});
			});


		},
		layout: function ($target) {
			if ($target.data('isotope')) {
				$target.isotope('layout');
			}
			setTimeout(function () {
				if ($target.data('isotope')) {
					$target.isotope('layout');
				}
			}, 500);
			setTimeout(function () {
				if ($target.data('isotope')) {
					$target.isotope('layout');
				}
			}, 1000);
		},
		metro_width: function ($target, columns_gutter) {
			var _that = this,
				options = $target.data("isotope-options"),
				$container = $target.closest('[data-isotope-wrapper]'),
				baseColumns = 1,
				imageSizeBase = $target.data('image-size-base'),
				ratioBase = 1;
			if (imageSizeBase) {
				imageSizeBase = imageSizeBase.split('x');
				ratioBase = parseInt(imageSizeBase[1], 10) / parseInt(imageSizeBase[0], 10);
				if (isNaN(ratioBase)) {
					ratioBase = 1;
				}
			}
			$target.find(options.itemSelector).each(function () {
				var $item = $(this),
					multiplier_w = _that.get_multiplier_width($item),
					columns = 1;
				if (multiplier_w != 0) {
					columns = 60 / multiplier_w;
				}
				if (baseColumns < columns) {
					baseColumns = columns;
				}
			});


			var baseWidth = ($container.width() - columns_gutter * (baseColumns - 1)) / baseColumns,
				baseHeight = Math.floor(baseWidth * ratioBase);

			$target.find(options.itemSelector).each(function () {
				var $item = $(this),
					$itemInner = $item.find(' > [data-ratio]'),
					ratio = $itemInner.data('ratio');

				var _multiplier_w = $item.data('multiplier_w');
				if (_multiplier_w === 60) {
					ratio = '1x1';
				}

				if (ratio) {
					ratio = ratio.split('x');
					var ratioH = ratio[1],
						height = baseHeight * ratioH + Math.ceil((ratioH - 1)) * columns_gutter,
						$image = $itemInner.find('.g5core__entry-thumbnail');
					$image.addClass('g5core__thumbnail-size-none').css('height', height);
				}

			});

			return options.masonry.columnWidth;
		},
		get_multiplier_width: function ($item) {
			var multiplier_w = 60;
			if ($item.is('[class]') && !$item.hasClass('g5core__col-base')) {
				var _class = $item.attr('class'),
					multiplier_mb_w = _class.match(/col-(\d{1,2})/),
					multiplier_xs_w = _class.match(/col-sm-(\d{1,2})/),
					multiplier_sm_w = _class.match(/col-md-(\d{1,2})/),
					multiplier_md_w = _class.match(/col-lg-(\d{1,2})/),
					multiplier_lg_w = _class.match(/col-xl-(\d{1,2})/);

				if (_class.match(/col-12-5/)) {
					multiplier_w = 12;
				} else if (multiplier_mb_w !== null) {
					multiplier_w = multiplier_mb_w[1] * 5;
				}

				if (window.matchMedia('(min-width: 576px)').matches) {
					if (_class.match(/col-sm-12-5/)) {
						multiplier_w = 12;
					} else if (multiplier_xs_w !== null) {
						multiplier_w = multiplier_xs_w[1] * 5;
					}
				}

				if (window.matchMedia('(min-width: 768px)').matches) {
					if (_class.match(/col-md-12-5/)) {
						multiplier_w = 12;
					} else if (multiplier_sm_w !== null) {
						multiplier_w = multiplier_sm_w[1] * 5;
					}

				}

				if (window.matchMedia('(min-width: 992px)').matches) {
					if (_class.match(/col-lg-12-5/)) {
						multiplier_w = 12;
					} else if (multiplier_md_w !== null) {
						multiplier_w = multiplier_md_w[1] * 5;
					}
				}

				if (window.matchMedia('(min-width: 1200px)').matches) {
					if (_class.match(/col-xl-12-5/)) {
						multiplier_w = 12;
					} else if (multiplier_lg_w !== null) {
						multiplier_w = multiplier_lg_w[1] * 5;
					}
				}
			}

			$item.data('multiplier_w', multiplier_w);

			return multiplier_w;
		}
	};

	G5CORE.modernGrid = {
		init: function ($wrapper) {
			if (typeof $wrapper === 'undefined') {
				$wrapper = $body;
			}
			var _that = this;

			$('[data-modern-grid]', $wrapper).each(function () {
				var $this = $(this);
				$this.imagesLoaded({background: true}, function () {
					_that.layout($this);
				});
			});

			$window.off('resize.mordern.grid').on('resize.mordern.grid', function () {
				$('[data-modern-grid]', $wrapper).each(function () {
					var $this = $(this);
					$this.imagesLoaded({background: true}, function () {
						_that.layout($this);
						if ($this.closest('.slick-slider').length) {
							$this.closest('.slick-slider').slick('refresh');
						}
					});
				});
			});

			$body.on('g5core_pagination_ajax_success', function (event, _data, $ajaxHTML, target, loadMore) {
				$('[data-modern-grid]', $wrapper).each(function () {
					var $this = $(this);
					$this.imagesLoaded({background: true}, function () {
						_that.layout($this);
					});
				});
			});
		},
		layout: function ($target) {
			var _that = this,
				options = $target.data('modern-options'),
				baseColumns = 1,
				imageSizeBase = options['image_size_base'],
				ratioBase = 1,
				columns_gutter = parseInt(options['columns_gutter'], 10),
				total_item = $target.find(options.itemSelector).length;
			if (imageSizeBase) {
				imageSizeBase = imageSizeBase.split('x');
				ratioBase = parseInt(imageSizeBase[1], 10) / parseInt(imageSizeBase[0], 10);
				if (isNaN(ratioBase)) {
					ratioBase = 1;
				}
			}

			if (total_item === 0) return;
			if (total_item === 1) {
				$target.find(options.itemSelector).each(function () {
					var $item = $(this),
						$itemInner = $item.find(' > [data-ratio]'),
						$image = $itemInner.find('.g5core__entry-thumbnail');
					$image.removeClass('g5core__thumbnail-size-none').css('height', '');

				});
			} else {
				$target.find(options.itemSelector).each(function () {
					var $item = $(this),
						multiplier_w = _that.get_multiplier_width($item),
						columns = 12 / multiplier_w;
					if (baseColumns < columns) {
						baseColumns = columns;
					}
				});


				var baseWidth = ($target.width() - columns_gutter * (baseColumns - 1)) / baseColumns,
					baseHeight = Math.floor(baseWidth * ratioBase);


				$target.find(options.itemSelector).each(function () {
					var $item = $(this),
						$itemInner = $item.find(' > [data-ratio]'),
						ratio = $itemInner.data('ratio'),
						$image = $itemInner.find('.g5core__entry-thumbnail'),
						multiplier_w = _that.get_multiplier_width($item);
					if (baseColumns === 1 || multiplier_w === 12) {
						$image.removeClass('g5core__thumbnail-size-none').css('height', '');
					} else if (ratio) {
						ratio = ratio.split('x');
						var ratioH = ratio[1],
							height = baseHeight * ratioH + Math.ceil((ratioH - 1)) * columns_gutter;
						$image.addClass('g5core__thumbnail-size-none').css('height', height);
					}

				});
			}
		},
		get_multiplier_width: function ($item) {
			var multiplier_w = 12,
				$itemInner = $item.find('.g5core__post-item-inner'),
				$col = $item.closest('.g5core__modern-grid-col'),
				_class = '';

			if ($itemInner.is('[data-class]')) {
				_class = $itemInner.data('class');
			} else if ($col.length > 0) {
				_class = $col.attr('class');
			}

			if (_class !== '') {
				var multiplier_mb_w = _class.match(/col-(\d{1,2})/),
					multiplier_xs_w = _class.match(/col-sm-(\d{1,2})/),
					multiplier_sm_w = _class.match(/col-md-(\d{1,2})/),
					multiplier_md_w = _class.match(/col-lg-(\d{1,2})/),
					multiplier_lg_w = _class.match(/col-xl-(\d{1,2})/);

				if (multiplier_mb_w !== null) {
					multiplier_w = multiplier_mb_w[1];
				}

				if (window.matchMedia('(min-width: 576px)').matches) {
					if (multiplier_xs_w !== null) {
						multiplier_w = multiplier_xs_w[1];
					}
				}

				if (window.matchMedia('(min-width: 768px)').matches) {
					if (multiplier_sm_w !== null) {
						multiplier_w = multiplier_sm_w[1];
					}

				}

				if (window.matchMedia('(min-width: 992px)').matches) {
					if (multiplier_md_w !== null) {
						multiplier_w = multiplier_md_w[1];
					}
				}

				if (window.matchMedia('(min-width: 1200px)').matches) {
					if (multiplier_lg_w !== null) {
						multiplier_w = multiplier_lg_w[1];
					}
				}
			}
			return multiplier_w;
		}
	};

	G5CORE.justifiedGallery = {
		config_default: {
			border: 0,
			captions: false
		},
		init: function ($wrapper) {
			if (typeof $wrapper === 'undefined') {
				$wrapper = $body;
			}
			var self = this;

			$('.g5core__justified-gallery', $wrapper).each(function () {
				var $this = $(this);
				$this.imagesLoaded({background: true}, function () {
					var config = $.extend({}, self.config_default, $this.data('justified-options'));
					$this.justifiedGallery(config);
				});
			});

		}
	};

	G5CORE.paginationAjax = {
		cache: {},
		ajax: false,
		prefix: 'g5_ajax_pagination_',
		timeOutLoadPost: null,
		paging: {
			pagination: 'pagination',
			paginationAjax: 'pagination-ajax',
			loadMore: 'load-more',
			nextPrev: 'next-prev',
			infiniteScroll: 'infinite-scroll'
		},
		addCache: function (key, value, group) {
			if (typeof this.cache[group] === 'undefined') {
				this.cache[group] = {};
			}
			if (typeof this.cache[group][key] !== 'undefined') return;
			this.cache[group][key] = value;

		},
		getCache: function (key, group) {
			if ((typeof this.cache[group] !== 'undefined') && (typeof this.cache[group][key] !== 'undefined')) {
				return this.cache[group][key];
			}
			return '';
		},
		getVariable: function (settingId) {
			var varName = this.prefix + settingId;
			if (typeof window[varName] !== 'undefined') {
				return window[varName];
			}
			return '';
		},
		showLoading: function ($wrapper, _data, target) {
			var _that = this;
			if (_that.ajax) return;
			_that.ajax = true;
			var $container = $wrapper.find('[data-items-container]'),
				$wrapper_height = $wrapper.outerHeight(),
				$loading = $wrapper.children('.g5-loading'),
				itemSelector = _data.settings['itemSelector'],
				loadMore = (($(target).closest('[data-items-paging]').length > 0) && ((_data.settings['post_paging'] === _that.paging.loadMore) || (_data.settings['post_paging'] === _that.paging.infiniteScroll)));

			if (($(target).closest('.x-mega-sub-menu').length === 0)
				//&& (typeof _data.settings['isMainQuery'] !== 'undefined' && _data.settings['isMainQuery'] === true)
				&& (loadMore === false)
			) {
				var wrapperOffset = $wrapper.offset().top - 100;
				var bodyTop = document.documentElement['scrollTop'] || document.body['scrollTop'],
					delta = bodyTop - wrapperOffset,
					scrollSpeed = Math.abs(delta) / 2;
				if (scrollSpeed < 800) scrollSpeed = 800;

				$('html,body').animate({scrollTop: wrapperOffset}, scrollSpeed, 'easeInOutCubic');
			}

			if (loadMore === false) {
				var $top = ($container.offset().top - $wrapper.offset().top);
				$loading.css('top', ($top + 100));
				$wrapper.css('height', $wrapper_height).addClass('loading');
				$container.find(itemSelector).animate({opacity: 0}, 500, 'easeOutQuad');
				$wrapper.find('[data-items-paging]').animate({opacity: 0}, 500, 'easeOutQuad');
			} else {
				if (_data.settings['post_paging'] === _that.paging.loadMore) {
					var l = $(target).ladda();
					l.ladda('start');
				} else {
					var $top = $wrapper.height();
					$loading.css('top', $top);
					$wrapper.css('height', $wrapper_height).addClass('loading');
				}
			}

		},
		hideLoading: function ($wrapper) {
			var _that = this;
			setTimeout(function () {
				$wrapper.removeClass('loading').css('height', '');
				_that.ajax = false;
			}, 500);
		},
		getCurrentPage: function ($this, pagination) {
			var _that = this,
				url = $this.attr('href'),
				paged = 1;

			if (pagination === _that.paging.paginationAjax) {
				if (/[\?&amp;]paged=\d+/gi.test(url)) {
					paged = /[\?&amp;]paged=\d+/gi.exec(url)[0];
					paged = parseInt(/\d+/gi.exec(paged)[0], 10);
				} else if (/page\/\d+/gi.test(url)) {
					paged = /page\/\d+/gi.exec(url)[0];
					paged = parseInt(/\d+/gi.exec(paged)[0], 10);
				}
			} else if ((pagination === _that.paging.infiniteScroll)
				|| (pagination === _that.paging.nextPrev)
				|| (pagination === _that.paging.loadMore)
			) {
				paged = parseInt($this.data('paged'), 10);
			}
			return {
				paged: paged,
				url: url
			};
		},
		setPushState: function (url) {
			var title = document.title;
			if (typeof (window.history.pushState) === 'function') {
				window.history.pushState(null, title, url);
			}
		},
		init: function () {
			var _that = this;
			// add item to cache
			$('[data-items-paging="pagination-ajax"],[data-items-paging="next-prev"],[data-items-tabs],[data-items-cate]').each(function () {
				var settingId = $(this).data('id'),
					_data = _that.getVariable(settingId);
				if (_data !== '') {
					var paged = typeof _data.query['paged'] !== 'undefined' ? _data.query['paged'] : 1,
						$wrapper = (_data.settings['isMainQuery'] && $(this).closest('#wrapper-content').length) ? $(this).closest('#wrapper-content') : $('[data-items-wrapper="' + settingId + '"]'),
						_html = $wrapper[0].outerHTML,
						$currentCate = $wrapper.find('[data-items-cate] > li.active a'),
						cat = $currentCate.length > 0 ? parseInt($currentCate.data('id'), 10) : -1,
						cacheKey = cat + '_' + paged;

					if (_that.getCache(cacheKey, settingId) === '') {
						_that.addCache(cacheKey, _html, settingId);
					}
				}
			});

			// init loading
			$('[data-items-wrapper]').each(function () {
				if ($(this).find('.g5-loading').length === 0) {
					$(this).prepend('<div class="g5-loading"><div class="g5-loading-inner"></div></div>');
				}
			});


			// pagination and load-more
			$(document).on('click', '[data-items-paging="pagination-ajax"] a,[data-items-paging="load-more"] > a,[data-items-paging="next-prev"] > a,[data-items-paging="infinite-scroll"] > a', function (event) {
				event.preventDefault();
				var $this = $(this),
					$pagingWrapper = $this.closest('[data-items-paging]'),
					settingId = $pagingWrapper.data('id');
				_that.loadPosts(settingId, this);
			});

			if ($('[data-items-paging="infinite-scroll"]').length > 0) {
				$window.on('scroll', function (event) {
					$('[data-items-paging="infinite-scroll"]').each(function () {
						var $navigation = $(this);
						if ($navigation.length === 0 || _that.ajax) return;
						if (($window.scrollTop() + $window.height()) > $navigation.offset().top) {
							var $this = $('> a', $navigation);
							$this.trigger('click');
						}
					});
				});
			}

			// category filter
			$(document).on('click', '[data-items-cate] li:not(.dropdown) > a', function (event) {
				event.preventDefault();
				var _this = this,
					settingId = $(this).closest('[data-items-cate]').data('id');
				_that.loadPosts(settingId, _this);
			});

			// tab filter
			$(document).on('click', '[data-items-tabs] li:not(.dropdown) > a', function (event) {
				event.preventDefault();
				var $this = $(this),
					settingId = $this.data('id'),
					$tabs = $this.closest('[data-items-tabs]'),
					$currentTab = $tabs.find('li.active:not(.dropdown) > a'),
					currentSettingId = $currentTab.data('id'),
					$wrapper = $('[data-items-wrapper="' + currentSettingId + '"]');

				if ($this.closest('li.active:not(.dropdown)').length) return;
				$wrapper.attr('data-items-wrapper', settingId);
				_that.loadPosts(settingId, this);
			});

			$body.on('g5core_pagination_ajax_success', function (event, _data, $ajaxHTML, target, loadMore) {
				_that.updatePageTitle(_data, $ajaxHTML, target, loadMore);
				_that.updateSideBar(_data, $ajaxHTML, target, loadMore);
				_that.updateCategory(_data, $ajaxHTML, target, loadMore);
				_that.updateCustomCss(_data, $ajaxHTML, target, loadMore);
			});
		},
		loadPosts: function (settingId, target, _urlRequest) {
			if ($(target).hasClass('active') || $(target).hasClass('disable') || $(target).parent().hasClass('active') || $(target).hasClass('dropdown-toggle')) return;


			var _that = this,
				_data = _that.getVariable(settingId);
			if (_data === '') return;
			var type = ($(target).closest('[data-items-paging]').length > 0) ? 'paging' : (($(target).closest('[data-items-cate]').length > 0) ? 'cat' : (($(target).closest('[data-items-tabs]').length > 0) ? 'tab' : '')),
				$wrapper = $('[data-items-wrapper="' + settingId + '"]'),
				$currentCate = $wrapper.find('[data-items-cate] > li.active a'),
				paged = 1,
				cat = $currentCate.length > 0 ? parseInt($currentCate.data('id'), 10) : -1,
				cat_slug = '',
				taxonomy = typeof _data.settings['taxonomy'] !== 'undefined' ? _data.settings['taxonomy'] : 'category';

			_that.showLoading($wrapper, _data, target);
			if (type === 'paging') {
				var pagination = typeof _data.settings['post_paging'] !== 'undefined' ? _data.settings['post_paging'] : _that.paging.pagination,
					currentPage = _that.getCurrentPage($(target), pagination);
				paged = currentPage.paged;
				_data.settings['currentPage'] = currentPage;
				if (pagination === _that.paging.loadMore || pagination === _that.paging.infiniteScroll) {
					_data.settings['index'] = $wrapper.find(_data.settings['itemSelector']).not('.g5core__col-base').length;
				} else {
					delete _data.settings['index'];
				}
				if ((typeof (_data.settings.cat) !== 'undefined') && (_data.settings.cat !== '') && ((typeof (_data.settings.current_cat) === 'undefined') || (_data.settings.current_cat === -1))) {
					if (_data.settings['post_type'] === 'post') {
						delete _data.query['category_name'];
						delete _data.query['cat'];
					} else {
						delete _data.query['term'];
						delete _data.query[taxonomy];
						delete _data.query['taxonomy'];
						_data.query['post_type'] = _data.settings['post_type'];
					}
				}
			} else if (type === 'cat') {
				currentPage = _that.getCurrentPage($(target), '');
				_data.settings['currentPage'] = currentPage;
				paged = 1;
				cat = parseInt($(target).data('id'), 10);
				cat_slug = $(target).data('name');

				if (cat > 0) {
					_data.settings['current_cat'] = cat;
					//delete _data.query['tax_query'];
					delete _data.query['s'];
					delete _data.query['search_terms_count'];
					delete _data.query['search_terms'];

					if (_data.settings['post_type'] === 'post') {
						_data.query['category_name'] = cat_slug;
						_data.query['cat'] = cat;
					} else {
						_data.query[taxonomy] = cat_slug;
						_data.query['term'] = cat_slug;
						_data.query['taxonomy'] = taxonomy;
					}
					delete _data.query['post_type'];


				} else {
					_data.settings['current_cat'] = -1;
					if (_data.settings['post_type'] === 'post') {
						delete _data.query['category_name'];
						delete _data.query['cat'];
					} else {
						delete _data.query['term'];
						delete _data.query[taxonomy];
						delete _data.query['taxonomy'];
						_data.query['post_type'] = _data.settings['post_type'];
					}
				}
			} else if (type === 'tab') {
				if (_data.settings['post_type'] === 'post') {
					delete _data.query['category_name'];
					delete _data.query['cat'];
				} else {
					delete _data.query['term'];
					delete _data.query[taxonomy];
					delete _data.query['taxonomy'];
					_data.query['post_type'] = _data.settings['post_type'];
				}
			} else {
				if (_data.settings['post_type'] === 'post') {
					delete _data.query['category_name'];
					delete _data.query['cat'];
				} else {
					delete _data.query['term'];
					delete _data.query[taxonomy];
					delete _data.query['taxonomy'];
					_data.query['post_type'] = _data.settings['post_type'];
				}
			}
			if (type === '') {
				if (typeof _urlRequest === 'undefined') {
					currentPage = _that.getCurrentPage($(target), '');
				} else {
					currentPage = {
						paged: 1,
						url: _urlRequest
					}
				}
				_data.settings['currentPage'] = currentPage;
				delete _data.settings['current_cat'];
			}

			var cacheKey = cat + '_' + paged;
			if (_data.settings['isMainQuery']) {
				if (typeof _urlRequest !== 'undefined') {
					cacheKey = _urlRequest
				} else {
					cacheKey = $(target).attr('href');
				}
			}
			var cacheData = _that.getCache(cacheKey, settingId);
			if (cacheData !== '') {
				_that.ajax = true;
				_that.onSuccess(cacheData, _data, target, type, $wrapper);
				_that.ajax = false;
			} else {
				if (typeof _urlRequest === 'undefined') {
					_urlRequest = g5_variable.ajax_url;
					if (_data.settings['isMainQuery']) {
						_urlRequest = $(target).attr('href');
					}
				}

				_data.action = 'pagination_ajax';
				_data.query['paged'] = paged;
				_data.settings['settingId'] = settingId;


				if ($(target).closest('.g5shop__switch-layout').length) {
					_data.view = $(target).data('layout');
				}

				if ($(target).closest('.g5ere__switch-layout').length) {
					_data.view = $(target).data('layout');
				}

				_that.ajax = $.ajax({
					type: 'POST',
					data: _data,
					url: _urlRequest,
					dataType: 'text',
					success: function (response) {
						_that.addCache(cacheKey, response, settingId);
						_that.onSuccess(response, _data, target, type, $wrapper);
						_that.ajax = false;
					},
					error: function (XMLHttpRequest, textStatus, errorThrown) {
						_that.hideLoading($wrapper);
						_that.ajax = false;
					}
				});
			}
		},
		onSuccess: function (response, _data, target, type, $wrapper) {
			if (type === 'cat') {
				$(target).closest('[data-items-cate]').find('li').removeClass('active');
				$(target).closest('li').addClass('active');
				$(target).closest('.dropdown').addClass('active');
			}

			if (type === 'tab') {
				$(target).closest('[data-items-tabs]').find('li').removeClass('active');
				$(target).closest('li').addClass('active');
				$(target).closest('.dropdown').addClass('active');
			}


			var _that = this,
				$container = $wrapper.find('[data-items-container]'),
				$paging = $wrapper.find('[data-items-paging]'),
				$ajaxHTML = $('<div>' + response + '</div>'),
				itemSelector = _data.settings['itemSelector'],

				$resultWrapper = (_data.settings['isMainQuery']) ? $ajaxHTML.find('[data-archive-wrapper]') : $ajaxHTML,

				$resultElements = $resultWrapper.find(itemSelector),
				resultElementsLength = $resultElements.length,
				$resultPaging = $resultWrapper.find('[data-items-paging]'),
				loadMore = (($(target).closest('[data-items-paging]').length > 0) && ((_data.settings['post_paging'] === _that.paging.loadMore) || (_data.settings['post_paging'] === _that.paging.infiniteScroll))),
				isotope = $container.hasClass('isotope'),
				slick = $container.hasClass('slick-slider'),
				justified = $container.hasClass('justified-gallery'),
				animation = (typeof _data.settings['post_animation'] !== 'undefined') ? _data.settings['post_animation'] : 'none';

			_that.hideLoading($wrapper);
			if (resultElementsLength === 0) {
				if (typeof _data.settings['noFoundSelector'] !== 'undefined') {
					$resultElements = $ajaxHTML.find(_data.settings['noFoundSelector']);
				}
			}

			if (isotope) {
				var config = $container.data("isotope-options");
				if (loadMore) {
					$container
						.append($resultElements)
						.isotope('appended', $resultElements);

					if (animation !== 'none') {
						new G5CORE_Animation($wrapper);
					}

					$wrapper.trigger('g5core_pagination_ajax_success', [_data, $ajaxHTML, target, loadMore]);
				} else {
					$container.find(itemSelector).animate({opacity: 0}, 500, 'easeOutQuad');

					if (animation === 'none') {
						$resultElements.css({opacity: 0});
					}

					setTimeout(function () {
						$container.html($resultElements);
						if ((typeof (config) !== 'undefined') &&
							(typeof (config.masonry) !== 'undefined')
							&& (typeof (config.masonry.columnWidth) !== 'undefined')
							&& (config.masonry.columnWidth === '.g5core__col-base')) {
							$container.append('<article class="g5core__col-base"></article>');
						}
						$container
							.isotope('reloadItems')
							.isotope();

						if (animation === 'none') {
							$container.find(itemSelector).animate({opacity: 1}, 500, 'easeOutQuad');
						} else {
							new G5CORE_Animation($wrapper);
						}


						$wrapper.trigger('g5core_pagination_ajax_success', [_data, $ajaxHTML, target, loadMore]);
					}, 500);
				}
				G5CORE.isotope.layout($container);

				if ((typeof (config) !== 'undefined') &&
					(typeof (config.masonry) !== 'undefined')
					&& (typeof (config.masonry.columnWidth) !== 'undefined')
					&& (config.masonry.columnWidth === '.g5core__col-base')) {
					$(window).trigger('resize');
				}


			} else if (slick) {
				var $slick = $container.slick('getSlick');
				$slick.unslick();
				if (loadMore) {
					$container.append($resultElements).addClass('slick-slider');
				} else {
					$container.html($resultElements).addClass('slick-slider');
				}
				G5CORE.util.slickSlider();

				if (animation !== 'none') {
					new G5CORE_Animation($wrapper);
				}

				$wrapper.trigger('g5core_pagination_ajax_success', [_data, $ajaxHTML, target, loadMore]);

			} else if (justified) {
				if (loadMore) {
					$container
						.append($resultElements)
						.justifiedGallery('norewind');
				} else {
					$container.find(itemSelector).animate({opacity: 0}, 500, 'easeOutQuad');
					$container
						.justifiedGallery('destroy')
						.html($resultElements);

					G5CORE.justifiedGallery.init($wrapper);
				}

				if (animation !== 'none') {
					new G5CORE_Animation($wrapper);
				}

			} else {
				if (loadMore) {

					if (animation === 'none') {
						$resultElements.css({opacity: 0});
					}
					$container
						.append($resultElements);

					G5CORE.isotope.init($container);

					if (animation === 'none') {
						$resultElements.animate({opacity: 1}, 500, 'easeInQuad');
					} else {
						new G5CORE_Animation($wrapper, 100);
					}
					$wrapper.trigger('g5core_pagination_ajax_success', [_data, $ajaxHTML, target, loadMore]);
				} else {
					$container.find(itemSelector).animate({opacity: 0}, 500, 'easeOutQuad');
					if (animation === 'none') {
						$resultElements.css({opacity: 0});
					}

					setTimeout(function () {
						$container
							.html($resultElements);

						G5CORE.isotope.init($container);
						if (animation === 'none') {
							$resultElements.animate({opacity: 1}, 500, 'easeInQuad');
						} else {
							new G5CORE_Animation($wrapper, 100);
						}

						$wrapper.trigger('g5core_pagination_ajax_success', [_data, $ajaxHTML, target, loadMore]);
					}, 500);

				}
			}

			if (!loadMore) {
				if (typeof _data.settings['isMainQuery'] !== 'undefined' && _data.settings['isMainQuery'] === true) {
					_that.setPushState(_data.settings['currentPage'].url);
				}
			}


			if ($paging.length > 0) {
				$paging.remove();
			}
			$wrapper.append($resultPaging);

		},
		updatePageTitle: function (_data, $ajaxHTML, target, loadMore) {
			var $pageTitle = $('.g5core-page-title');
			if ($pageTitle.length && !loadMore && (typeof _data.settings['isMainQuery'] !== 'undefined')) {
				var $resultPageTitle = $ajaxHTML.find('.g5core-page-title');
				if ($resultPageTitle.length) {
					$pageTitle.replaceWith($resultPageTitle.prop('outerHTML'));
					if ("function" == typeof window.vc_js) {
						vc_js();
					}

					if (typeof elementorModules === 'object' && typeof elementorFrontend === 'object') {
						$('.elementor-section-stretched', '.g5core-page-title').each(function () {
							var $element = $(this);
							var stretchElement = new elementorModules.frontend.tools.StretchElement({
								element: $element,
								selectors: {
									container: elementorFrontend.getKitSettings('stretched_section_container') || window
								}
							});
							stretchElement.stretch();
							$window.resize(function () {
								stretchElement.stretch();
							});
						});
					}


					$body.trigger('g5core_pagination_ajax_before_update_page_title', [_data, $ajaxHTML, target, loadMore]);
				}
			}
		},
		updateSideBar: function (_data, $ajaxHTML, target, loadMore) {
			var $sidebar = $('.primary-sidebar');
			if ($sidebar.length && !loadMore && (typeof _data.settings['isMainQuery'] !== 'undefined')) {
				var $resultSidebar = $ajaxHTML.find('.primary-sidebar');
				if ($resultSidebar.length) {
					$sidebar.replaceWith($resultSidebar.prop('outerHTML'));
					$body.trigger('g5core_pagination_ajax_before_update_sidebar', [_data, $ajaxHTML, target, loadMore]);
					G5CORE.sidebarSticky.init();
				}
			}
		},
		updateCategory: function (_data, $ajaxHTML, target, loadMore) {
			var settingId = _data.settings.settingId,
				$resultWrapper = (_data.settings['isMainQuery'] && $ajaxHTML.find('[data-archive-wrapper]').length) ? $ajaxHTML.find('[data-archive-wrapper]') : $ajaxHTML,
				$resultCategory = $resultWrapper.find('[data-items-cate]');

			if (($resultCategory.length) && ($resultCategory.closest('.g5shop__shop-toolbar').length === 0) && ($resultCategory.closest('.g5ere__property-toolbar').length === 0)) {
				var $wrapper = $('[data-items-wrapper="' + settingId + '"]'),
					$category = $wrapper.find('[data-items-cate]');

				if ($category.length === 0) {
					$category = $('[data-items-cate][data-id="' + _data.settings.settingId + '"]');
					if ($category.length) {
						$category.remove();
					}
					$wrapper.prepend($resultCategory);
					$('.g5core__pretty-tabs').g5core__PrettyTabs();
				}
			}
		},
		updateCustomCss: function (_data, $ajaxHTML, target, loadMore) {
			if (!loadMore && (typeof _data.settings['isMainQuery'] !== 'undefined')) {
				var $custom_css = $ajaxHTML.find('#g5core_custom_css_data');
				if ($custom_css.length > 0) {
					eval($custom_css.html());
				}
			}
		}
	};


	G5CORE_Animation = function ($wrapper, delay) {
		if (typeof $wrapper !== 'undefined') {
			$wrapper = $body;
		}
		this.$wrapper = $wrapper;
		this.init(delay);
	};

	G5CORE_Animation.prototype = {
		itemQueue: [],
		delay: 100,
		queueTimer: null,
		init: function (delay) {
			var _self = this;
			_self.itemQueue = [];
			_self.queueTimer = null;
			if (typeof delay !== 'undefined') {
				_self.delay = delay;
			}
			setTimeout(function () {
				_self.registerAnimation();
			}, 200);
		},
		registerAnimation: function () {
			var _self = this;

			$('.g5core__animate-when-almost-visible:not(.animated)', _self.$wrapper).waypoint(function () {
				// Fix for different ver of waypoints plugin.
				var $this = this.element ? this.element : $(this);
				_self.itemQueue.push($this);
				_self.processItemQueue();
			}, {
				offset: '90%',
				triggerOnce: true
			});
		},
		processItemQueue: function () {
			var _self = this;
			if (_self.queueTimer) return; // We're already processing the queue
			_self.queueTimer = window.setInterval(function () {
				if (_self.itemQueue.length) {
					$(_self.itemQueue.shift()).addClass('animated');
					_self.processItemQueue();
				} else {
					window.clearInterval(_self.queueTimer);
					_self.queueTimer = null
				}
			}, _self.delay)
		}
	};

	G5CORE.ELEMENTOR = {
		editorTimeout: 10000,
		isActive: function () {
			return $body.hasClass('elementor-page');
		},
		isEditor: function () {
			return $body.hasClass('elementor-editor-active');
		}
	};

	G5CORE.init = function () {
		if (_init === false) {
			_init = true;
			G5CORE.util.init();
			G5CORE.header.init();
			G5CORE.footer.init();
			G5CORE.searchAjax.init();
			G5CORE.offCanvas.init();
			G5CORE.login.init();
			G5CORE.headerSticky.init();
			G5CORE.menuMobile.init();
			G5CORE.sidebarSticky.init();
			G5CORE.isotope.init();
			G5CORE.paginationAjax.init();
			G5CORE.modernGrid.init();
			G5CORE.justifiedGallery.init();
			G5CORE.sticky.init();
			G5CORE.page.init();
			new G5CORE_Animation();
			G5CORE.lazyLoader.init();
		}

	};


	if (G5CORE.ELEMENTOR.isActive()) {
		window.addEventListener( 'elementor/frontend/init', () => {
			//elementorFrontend.hooks.addAction('frontend/element_ready/widget', G5CORE.init);
			G5CORE.init();
		});
	}

	$document.ready(function () {
		G5CORE.init();
	});
})(jQuery);
