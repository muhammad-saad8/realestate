var G5ERE_FRONTEND = G5ERE_FRONTEND || {};
(function ($) {
	"use strict";
	var $window = $(window),
		$body = $('body'),
		isRTL = $body.hasClass('rtl');

	G5ERE_FRONTEND = {
		init: function () {
			this.ordering();
			this.switchLayout();
			this.updateAjaxSuccess();
			this.toolbar();
			this.singleBottomBar();
			this.removeFavouriteSuccess();
			this.review();
			this.singleTabs();
			this.contact();
			this.saveSearch();
			this.calculateMortgage();
			this.activeTabLoginRegister();
			this.showHidePassword();
		},
		ordering: function () {
			var $formOrdering = $('.g5ere__ordering');

			$formOrdering.off('change').on('change', 'select.g5ere__orderby', function () {
				$(this).closest('form').submit();
			});

			$formOrdering.off('submit').on('submit', function (e) {
				e.preventDefault();
				var currentURL = window.location.href.split('?')[0];// + '?' + $(this).serialize();
				var pattern = /page\/\d+\//ig;
				if (pattern.test(currentURL)) {
					currentURL = currentURL.replace(pattern, '');
				}
				currentURL = currentURL + '?' + $(this).serialize();

				pattern = /&paged=\d+/ig;
				if (pattern.test(currentURL)) {
					currentURL = currentURL.replace(pattern, '');
				}

				pattern = /paged=\d+/ig;
				if (pattern.test(currentURL)) {
					currentURL = currentURL.replace(pattern, '');
				}


				var $wrapper = $('[data-archive-wrapper]');
				if ($wrapper.length > 0) {
					var settingId = $wrapper.data('items-wrapper');
					G5CORE.paginationAjax.loadPosts(settingId, this, currentURL);
				}
			});


		},
		switchLayout: function () {
			$(document).on('click', '.g5ere__switch-layout > a', function (event) {
				event.preventDefault();
				var $wrapper = $('[data-archive-wrapper]');
				if ($wrapper.length > 0) {
					var settingId = $wrapper.data('items-wrapper');
					G5CORE.paginationAjax.loadPosts(settingId, this);
				}
			});
		},
		updateAjaxSuccess: function () {
			var self = this;
			$body.on('g5core_pagination_ajax_success', function (event, _data, $ajaxHTML, target, loadMore) {
				if (_data.settings['post_type'] === 'property' || _data.settings['post_type'] === 'taxonomy_agency' || _data.settings['post_type'] === 'agent') {
					var $toolbar = $('.g5ere__toolbar');
					if ($toolbar.length && !loadMore && (typeof _data.settings['isMainQuery'] !== 'undefined')) {
						var $result_toolbar = $ajaxHTML.find('.g5ere__toolbar');
						if ($result_toolbar.length) {
							$toolbar.replaceWith($result_toolbar.removeAttr('hidden').prop('outerHTML'));
							$('.g5ere__ordering').off('change').on('change', 'select.g5ere__orderby', function () {
								$(this).closest('form').submit();
							});


							if ($().g5core__PrettyTabs) {
								$('.g5core__pretty-tabs').g5core__PrettyTabs();
							}

							if ($().selectpicker) {
								$('.g5ere__orderby').selectpicker();
							}

							var $switch_layout = $('.g5ere__switch-layout');
							if ($switch_layout.length) {
								var $resultWrapper = $ajaxHTML.find('[data-items-wrapper]'),
									resultWrapperClass = $resultWrapper.attr('class');
								$(event.target).attr('class', resultWrapperClass);
							}
							self.ordering();
						} else {
							$toolbar.html('');
						}
					}
				}
			});

			$body.on('g5core_pagination_ajax_before_update_sidebar', function (event, _data, $ajaxHTML, target, loadMore) {
				if ($().selectpicker) {
					$('.primary-sidebar').find('.selectpicker').selectpicker();
				}

			});

			$body.on('g5core_pagination_ajax_before_update_sidebar', function (event, _data, $ajaxHTML, target, loadMore) {
				if ($().selectpicker) {
					$('.primary-sidebar').find('.selectpicker').selectpicker();
				}
			});

			$body.on('g5core_pagination_ajax_before_update_page_title', function (event, _data, $ajaxHTML, target, loadMore) {
				if ($().selectpicker) {
					$('.g5core-page-title').find('.selectpicker').selectpicker();
				}
			});


		},
		toolbar: function () {
			var $wrapper = $('.g5ere__toolbar'),
				$primary_content = $('#primary-content');

			if ($('.g5ere__property-halt-map').length > 0) {
				$primary_content = $('.g5ere__property-halt-map');
			}

			if ($wrapper.length) {
				if ($wrapper.hasClass('stretched') || $wrapper.hasClass('stretched_content')) {
					$wrapper.detach().insertBefore($primary_content);
				}

				if ($().g5core__PrettyTabs) {
					$('.g5core__pretty-tabs', $wrapper).g5core__PrettyTabs();
				}

				$wrapper.removeAttr('hidden');
			}
		},
		singleBottomBar: function () {
			var $single_bottom_bar = $('.g5ere__single-bottom-bar');
			if ($single_bottom_bar.length > 0) {
				$window.on('scroll', function (event) {
					var scrollPosition = $window.scrollTop(),
						pageHeight = $(document).height(),
						windowHeight = $window.height(),
						breakHeight = pageHeight - windowHeight;
					if (scrollPosition < breakHeight) {
						$single_bottom_bar.removeClass('out');
					} else {
						$single_bottom_bar.addClass('out');
					}
				});
			}
		},
		removeFavouriteSuccess: function () {
			$(".g5ere__property-my-favorite").on('click', function (e) {
				var $parent = $(this).parents('.ere-my-favorite-item');
				e.preventDefault();
				if (!$(this).hasClass('on-handle')) {
					var $this = $(this).addClass('on-handle'),
						property_inner = $this.closest('.property-inner').addClass('property-active-hover'),
						property_id = $this.attr('data-property-id');
					$.ajax({
						type: 'post',
						url: g5ere_vars.ajax_url,
						dataType: 'json',
						data: {
							'action': 'ere_favorite_ajax',
							'property_id': property_id
						},
						beforeSend: function () {
							$this.children('i').removeClass('fa-trash-alt');
							$this.children('i').addClass('fa-spinner fa-spin');
						},
						success: function (data) {
							if ((typeof (data.added) == 'undefined') || (data.added === -1)) {
								ERE.login_modal();
							}
							if (data.added === 0) {
								$parent.remove();
							}
							$this.children('i').removeClass('fa-spinner fa-spin');
							$this.removeClass('on-handle');
							property_inner.removeClass('property-active-hover');
						},
						error: function () {
							$this.children('i').removeClass('fa-spinner fa-spin');
							$this.children('i').addClass('fa-trash-alt');
							$this.removeClass('on-handle');
							property_inner.removeClass('property-active-hover');
						}
					});
				}
			});

		},
		review: function () {
			$(document).on('click', '.g5ere__submit-rating', function (e) {
				e.preventDefault();
				var $this = $(this),
					$form = $this.closest('form'),
					$wrap = $this.closest('.g5ere__single-block');

				if ($form[0].checkValidity() === false) {
					$form.addClass('was-validated');
					return;
				}

				if (G5ERE_FRONTEND.LOADING.isLoading) {
					return;
				}

				G5ERE_FRONTEND.LOADING.add($wrap);

				$.ajax({
					type: 'POST',
					url: g5ere_vars.ajax_url,
					data: $form.serialize(),
					dataType: 'json',
					success: function () {
						window.location.reload();
					},
					complete: function () {
						G5ERE_FRONTEND.LOADING.remove($wrap);
					}
				});
			});
		},
		contact: function () {
			$(document).on('click', '.g5ere__submit-contact-agent', function (e) {
				e.preventDefault();
				var $this = $(this),
					$form = $this.closest('form'),
					$wrap = $this.closest('.g5ere__contact-form-wrapper');

				if ($form[0].checkValidity() === false) {
					$form.addClass('was-validated');
					return;
				}

				if (G5ERE_FRONTEND.LOADING.isLoading) {
					return;
				}

				G5ERE_FRONTEND.LOADING.add($wrap);

				$.ajax({
					type: 'post',
					url: g5ere_vars.ajax_url,
					dataType: 'json',
					data: $form.serialize(),
					success: function (response) {
						var _html = $("#g5ere__message_template").html().replace("{{message}}", response.message);
						if (response.success) {
							_html = _html.replace("{{type}}", 'success');
						} else {
							if (typeof ere_reset_recaptcha == 'function') {
								ere_reset_recaptcha();
							}
							_html = _html.replace("{{type}}", 'warning');
						}
						$('.g5ere__contact-form-messages', $form).html(_html);
						G5ERE_FRONTEND.LOADING.remove($wrap);
					}
				});
			});
		},
		singleTabs: function () {
			$('.g5ere__tabs-container a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
				var $currentTab = $(e.target),
					$previousTab = $(e.relatedTarget),
					$currentPanel = $('.g5ere__panels-container').find($currentTab.attr('href')),
					$previousPanel = $('.g5ere__panels-container').find($previousTab.attr('href'));

				$currentPanel.find('.collapse').addClass('show');
				$previousPanel.find('.collapse').removeClass('show');
				$currentPanel.find('.g5core__pretty-tabs').g5core__PrettyTabs();
				$currentPanel.find('.slick-slider').slick('refresh');

				var $map = $currentPanel.find('.g5ere__map-canvas');
				if ($map.length > 0) {
					var map_id = $map.attr('id');
					var map = G5ERE_MAP.getInstance(map_id).instance;
					setTimeout(function () {
						map.refresh();
					}, 50);
				}

			});

			$('.g5ere__panels-container .collapse').on('shown.bs.collapse', function (e) {
				var $currentPanel = $(e.target).closest('.tab-pane'),
					$currentTab = $('.g5ere__tabs-container').find('.' + $currentPanel.attr('id'));

				$('.g5ere__tabs-container').find('a').removeClass('active');
				$('.g5ere__panels-container').find('.tab-pane').removeClass('show active');
				$currentPanel.addClass('show active');
				$currentTab.addClass('active');
				$currentPanel.find('.g5core__pretty-tabs').g5core__PrettyTabs();
				$currentPanel.find('.slick-slider').slick('refresh');

				var $map = $currentPanel.find('.g5ere__map-canvas');
				if ($map.length > 0) {
					var map_id = $map.attr('id');
					var map = G5ERE_MAP.getInstance(map_id).instance;
					setTimeout(function () {
						map.refresh();
					}, 50);
				}
			})
		},
		saveSearch: function () {
			$(document).on('click', '#g5ere_save_search', function (e) {
				e.preventDefault();
				var $this = $(this);
				var $form = $('#g5ere_save_search_form');
				if ($form[0].checkValidity() === false) {
					$form.addClass('was-validated');
					return;
				}
				$.ajax({
					url: g5ere_vars.ajax_url,
					data: $form.serialize(),
					method: $form.attr('method'),
					dataType: 'JSON',
					beforeSend: function () {
						$this.children('i').remove();
						$this.append('<i class="fa fa-spinner fa-spin"></i>');
					},
					success: function (response) {
						if (typeof (response.success) == 'undefined') {
							ERE.login_modal();
						}
						if (response.success) {
							$this.children('i').removeClass('fa-spinner fa-spin');
							$this.children('i').addClass('fa-check');
						}
					},
					error: function () {
						$this.children('i').removeClass('fa-spinner fa-spin');
						$this.children('i').addClass('fa-exclamation-triangle');
					},
					complete: function () {
						$this.children('i').removeClass('fa-spinner fa-spin');
					}
				});
			});

		},
		calculateMortgage: function () {
			$('#g5ere_btn_mc').on('click', function (e) {
				e.preventDefault();

				var sale_price = $('#g5ere_mc_sale_price').val();
				var precent_down = $('#g5ere_mc_down_payment').val();
				var term_years = parseInt($('#g5ere_mc_term_years').val(), 10);
				var interest_rate = parseFloat($('#g5ere_mc_interest_rate').val(), 10) / 100;

				var interest_rate_month = interest_rate / 12;
				var interest_rate_bi_weekly = interest_rate / 26;
				var interest_rate_weekly = interest_rate / 52;

				var number_of_payments_month = term_years * 12;
				var number_of_payments_bi_weekly = term_years * 26;
				var number_of_payments_weekly = term_years * 52;

				var loan_amount = sale_price - precent_down;
				var monthly_payment = parseFloat((loan_amount * interest_rate_month) / (1 - Math.pow(1 + interest_rate_month, -number_of_payments_month))).toFixed(2);
				var bi_weekly_payment = parseFloat((loan_amount * interest_rate_bi_weekly) / (1 - Math.pow(1 + interest_rate_bi_weekly, -number_of_payments_bi_weekly))).toFixed(2);
				var weekly_payment = parseFloat((loan_amount * interest_rate_weekly) / (1 - Math.pow(1 + interest_rate_weekly, -number_of_payments_weekly))).toFixed(2);

				if (monthly_payment === 'NaN') {
					monthly_payment = 0;
				}
				if (bi_weekly_payment === 'NaN') {
					bi_weekly_payment = 0;
				}
				if (weekly_payment === 'NaN') {
					weekly_payment = 0;
				}


				var _html = $("#g5ere__mortgage_calculator_output").html().replace("{{loan_amount}}", loan_amount);
				_html = _html.replace("{{term_years}}", term_years);
				_html = _html.replace("{{monthly_payment}}", monthly_payment);
				_html = _html.replace("{{bi_weekly_payment}}", bi_weekly_payment);
				_html = _html.replace("{{weekly_payment}}", weekly_payment);
				$('.g5ere_mc-output').html(_html);

			});

		},
		activeTabLoginRegister: function () {
			$('.g5ere__login-register-modal .g5ere_card-title').hide();
			$('.g5ere__login-register-modal .g5ere__card-text').hide();

		},
		showHidePassword: function () {
			$('.g5ere-show-password').on('click', function (e) {
				e.preventDefault();
				var input_pass = $('.g5ere-password');
				var $icon = $(this).find('.far');
				if (input_pass.attr('type') === 'password') {
					input_pass.attr('type', 'text');
					$icon.removeClass('fa-eye');
					$icon.addClass('fa-eye-slash');

				} else {
					input_pass.attr('type', 'password');
					$icon.removeClass('fa-eye-slash');
					$icon.addClass('fa-eye');
				}

			})

		}
	};

	G5ERE_FRONTEND.LOADING = {
		isLoading: false,
		add: function ($selector) {
			this.isLoading = true;
			if ($selector.find('.g5ere__loading').length === 0) {
				$selector.addClass('g5ere__loading-wrap');
				$selector.append('<div class="g5ere__loading"><span></span></div>');
			}
		},
		remove: function ($selector) {
			$selector.find('.g5ere__loading').remove();
			$selector.removeClass('g5ere__loading-wrap');
			this.isLoading = false;
		},
	};

	G5ERE_FRONTEND.EXPLOPRE = {
		id: 'g5ere__property_explore_map',
		map: null,
		init: function () {
			var self = this;
			this.markerActive();
			this.updateAjaxSuccess();
			this.halfMap();
		},
		initMap: function () {
			this.setupMap();
			this.updateMap();
		},
		setupMap: function () {
			var t = G5ERE_MAP.getInstance(this.id);
			this.map = t.instance;
		},
		updateMap: function () {
			var self = this;
			if (self.map) {
				self.map.removeMarkers();
				self.map.trigger("updating_markers");
				$('[data-archive-wrapper] .g5ere__property-item').each(function () {
					var $this = $(this),
						location = $this.data('location');
					if (location && location.position) {
						var marker_option = {
							position: new G5ERE_MAP.LatLng(location.position.lat, location.position.lng),
							map: self.map,
							template: {
								id: location.id,
								marker: location.marker === false ? g5ere_map_config.marker : location.marker
							}
						};
						if (self.map.options._popup) {
							var template = wp.template('g5ere__map_popup_template');
							var content_popup = template(location);
							marker_option.popup = new G5ERE_MAP.Popup({
								content: content_popup
							});
						}

						var marker = new G5ERE_MAP.Marker(marker_option);
						self.map.markers.push(marker);
						self.map.bounds.extend(marker.getPosition());
					}
				});

				if (self.map.markers.length < 1) {
					var position = new G5ERE_MAP.LatLng(g5ere_map_config.coordinate_default.lat, g5ere_map_config.coordinate_default.lng);
					self.map.setCenter(position);
				}

				if (self.map.markers.length === 1) {
					self.map.setCenter(self.map.markers[0].getPosition());
				}

				if (self.map.markers.length > 1) {
					self.map.fitBounds(self.map.bounds);
				}

				self.map.trigger("updated_markers");
			}
		},
		markerActive: function () {
			var self = this;
			var timeOutActive = null;
			$(document).on({
				mouseenter: function () {
					if (self.map) {
						var $this = $(this),
							id = $this.data('id'),
							location = $this.data('location');
						if (location && location.position) {
							var position = new G5ERE_MAP.LatLng(location.position.lat, location.position.lng);
							self.map.setCenter(position);
							clearTimeout(this.timeout);
							this.timeout = setTimeout(function () {
								self.map.activeMarker(id);
							}, 100);
						}
					}

				},
				mouseleave: function () {
					if (self.map) {
						self.map.deactiveMarker();
					}
				}
			}, ".g5ere__property-halt-map [data-archive-wrapper] .g5ere__property-item"); //pass the element as an argument to .on


		},
		updateAjaxSuccess: function () {
			var self = this;
			$body.on('g5core_pagination_ajax_success', function (event, _data, $ajaxHTML, target, loadMore) {
				if (_data.settings['post_type'] === 'property') {
					self.updateMap();
				}
			});
		},
		halfMap: function () {
			$('.g5ere__property-halt-map .g5ere__property-explore-map-inner').hcSticky({});
			$('#g5ere__advanced_search_header .g5ere__sf-bottom-wrap').on('hidden.bs.collapse shown.bs.collapse', function () {
				$('.g5ere__property-halt-map .g5ere__property-explore-map-inner').hcSticky('refresh');
			})

		}
	};

	G5ERE_FRONTEND.SEARCH = {
		cacheStatus: {},
		ajax: false,
		_location : [],
		init: function () {
			this.getCountryData();
			this.getStatesData();
			this.getCityData();
			this.getNeighborhoodData();
			//this.selectLocationFilter();
			this.filterLocationDropdown();
			this.rangeSlider();
			this.statusTab();
			this.search();
			var _self = this;
			$body.on('g5core_pagination_ajax_before_update_sidebar', function (event, _data, $ajaxHTML, target, loadMore) {
				var $primary_sidebar = $('.primary-sidebar');
				_self.rangeSlider($primary_sidebar);
				_self.initLocationDropdown('country',$primary_sidebar);
				_self.initLocationDropdown('state',$primary_sidebar);
				_self.initLocationDropdown('city',$primary_sidebar);
				_self.initLocationDropdown('neighborhood',$primary_sidebar);
			});

		},
		getLocationData: function (type) {
			var _self = this;
			$.ajax({
				type: "GET",
				url: g5ere_vars.ajax_url,
				data: {
					'action': 'g5ere_get_location_data',
					'type' : type
				},
				success: function (response) {
					if (response.success) {
						_self._location[type] = response.data;
						//_self._states = response.data;
						_self.initLocationDropdown(type);
					}
				}
			});
		},
		initLocationDropdown: function (type, $wrap) {
			if (typeof $wrap === "undefined") {
				$wrap = $body;
			}
			var _self = this;
			$('.g5ere__search-field [name="'+ type +'"]',$wrap).each(function (){
				var $this = $(this),
					$wrapper = $this.closest('form'),
					current_value = $this.data('current-value');
				G5ERE_FRONTEND.LOADING.add($wrapper);
				$this.html('');
				_self._location[type].forEach(function (element){
					var option = '';
					if (current_value === element.value) {
						option = '<option selected data-belong="'+ element.belong +'" data-subtext="'+ element.subtext +'" value="'+ element.value +'">'+ element.label +'</option>';
					} else {
						option = '<option data-belong="'+ element.belong +'" data-subtext="'+ element.subtext +'" value="'+ element.value +'">'+ element.label +'</option>';
					}
					$this.append(option);
				});

				if ($().selectpicker) {
					$this.selectpicker('destroy');
					$this.selectpicker();
					//$this.selectpicker('refresh');
				}

				G5ERE_FRONTEND.LOADING.remove($wrapper);
			});
		},
		getCountryData: function () {
			var _self = this;
			if ($('.g5ere__search-field [name="country"]').length) {
				_self.getLocationData('country');
			}
		},
		getStatesData: function () {
			var _self = this;
			if ($('.g5ere__search-field [name="state"]').length) {
				_self.getLocationData('state');
			}
		},
		getCityData: function () {
			var _self = this;
			if ($('.g5ere__search-field [name="city"]').length) {
				_self.getLocationData('city');
			}
		},
		getNeighborhoodData: function () {
			var _self = this;
			if ($('.g5ere__search-field [name="neighborhood"]').length) {
				_self.getLocationData('neighborhood');
			}
		},
		filterLocationDropdown: function () {
			var _self = this;
			$(document).on('change', '[data-toggle="g5ere__select_location_filter"]', function () {
				var $wrapper = $(this).closest('form'),
					$target = $wrapper.find($(this).data('target') + ' select'),
					current_value = $(this).val();
				if ($target.length) {
					G5ERE_FRONTEND.LOADING.add($wrapper);
					var type = $target.attr('name'),
						 options = '';

					_self._location[type].forEach(function (element){
						if (element.value === '') {
							options += '<option selected data-belong="'+ element.belong +'" data-subtext="'+ element.subtext +'" value="'+ element.value +'">'+ element.label +'</option>';
						} else if (element.belong === current_value || current_value === '') {
							options += '<option data-belong="'+ element.belong +'" data-subtext="'+ element.subtext +'" value="'+ element.value +'">'+ element.label +'</option>';
						}
					});

					$target.html(options);

					if ($().selectpicker) {
						$target.selectpicker('destroy');
						$target.selectpicker();
						//$target.selectpicker('refresh');
					}
					G5ERE_FRONTEND.LOADING.remove($wrapper);

					$target.trigger('change');
				}

			});
		},
		selectLocationFilter: function () {
			$(document).on('change', '[data-toggle="g5ere__select_location_filter"]', function () {
				var $current_form = $(this).closest('form'),
					$target = $current_form.find($(this).data('target') + ' select'),
					current_value = $(this).val();
				if ($target.length === 1) {
					if ($().selectpicker) {
						$target.selectpicker('val', '');
					}

					if ((current_value !== '')
						&& (current_value !== undefined)
					) {
						$target.find('option').each(function () {
							var belong = $(this).data('belong');
							if ($(this).val() !== '') {
								$(this).css('display', 'none');
								$(this).attr('disabled', 'disabled');
							}
							if (belong === current_value) {
								$(this).css('display', 'block');
								$(this).removeAttr('disabled');
							}
						});
					} else {
						$target.find('option').each(function () {
							$(this).css('display', 'block');
							$(this).removeAttr('disabled');
						});
					}
					if ($().selectpicker) {
						$target.selectpicker('refresh');
					}

				}
			});
		},
		rangeSlider: function ($wrap) {
			if (typeof $wrap === "undefined") {
				$wrap = $body;
			}
			$('[data-toggle="g5ere__range-slider"]', $wrap).each(function () {
				var $this = $(this),
					$slider = $this.find('.g5ere__rs-slider'),
					min_text = '',
					max_text = '',
					x, y,
					defaults = {
						range: true,
						slide: function (event, ui) {
							x = ui.values[0];
							y = ui.values[1];
							$this.find('.g5ere__rsi-min').val(x);
							$this.find('.g5ere__rsi-max').val(y);

							min_text = ERE.number_format(x);
							max_text = ERE.number_format(y);
							if ($this.closest('.g5ere__sf-price-range').length > 0) {
								if (ere_main_vars.currency_position === 'before') {
									min_text = ere_main_vars.currency + min_text;
									max_text = ere_main_vars.currency + max_text;
								} else {
									min_text = min_text + ere_main_vars.currency;
									max_text = max_text + ere_main_vars.currency;
								}
							}
							$this.find('.g5ere__rst-min').html(min_text);
							$this.find('.g5ere__rst-max').html(max_text);
						}
					},
					config = $.extend({}, defaults, $this.data("options"));
				if ($().slider) {
					$slider.slider(config);
				}
			});

		},
		statusTab: function () {
			var _self = this;
			$('.g5ere__search-tabs li a').on('click', function (e) {
				e.preventDefault();
				var $this = $(this),
					status = $this.data('val'),
					$parent = $('.g5ere__sf-tabs-wrap');
				$parent.find('[name="status"]').val(status);
				_self.changeFieldPriceOnStatusChange($this, status)


			});
		},
		changeFieldPriceOnStatusChange: function ($target, status) {
			var _self = this;
			if (_self.ajax) return;
			var $wrapper = $target.closest('.g5ere__search-form'),
				price_is_slider = $wrapper.find('.g5ere__sf-price-range').length > 0,
				cacheKey = 'g5ere_status' + status;

			if (typeof _self.cacheStatus[cacheKey] !== 'undefined') {
				var cacheData = _self.cacheStatus[cacheKey];
				_self.changeFieldPriceOnStatusChangeSuccess(cacheData, price_is_slider, $wrapper);
			} else {
				_self.ajax = $.ajax({
					type: 'POST',
					url: g5ere_vars.ajax_url,
					dataType: 'json',
					data: {
						'action': 'g5ere_get_price_on_status_change',
						'status': status,
						'price_is_slider': price_is_slider
					},
					success: function (response) {
						_self.changeFieldPriceOnStatusChangeSuccess(response, price_is_slider, $wrapper);
						_self.cacheStatus[cacheKey] = response;
						_self.ajax = false;
					}
				});
			}
		},
		changeFieldPriceOnStatusChangeSuccess: function (response, price_is_slider, $wrapper) {
			var _self = this;
			if (price_is_slider) {
				var price_slider_range_html = $(response.price_slider_range_html).find('.g5ere__range-slider-wrap');
				$wrapper.find('.g5ere__sf-price-range').html(price_slider_range_html);
				_self.rangeSlider($wrapper);
			} else {
				var max_price_html = $(response.max_price_html).find('select').html(),
					min_price_html = $(response.min_price_html).find('select').html();
				$wrapper.find('.g5ere__sf-max-price select').html(max_price_html);
				$wrapper.find('.g5ere__sf-min-price select').html(min_price_html);
				if ($().selectpicker) {
					$wrapper.find('.g5ere__sf-max-price select').selectpicker('destroy').selectpicker();
					$wrapper.find('.g5ere__sf-min-price select').selectpicker('destroy').selectpicker();
				}
			}
		},
		search: function () {
			$(document).on('submit', '.g5ere__search-form form', function (e) {
				e.preventDefault();
				var currentURL = $(this).attr('action');
				var formDataArr = $(this).serializeArray().filter(function (i) {
						return (i.value || i.name === 's');
					}),
					features = '';
				formDataArr.forEach(function (i) {
					if (i.name === 'feature') {
						features += i.value + ';';
					}
				});

				if (features !== '') {
					formDataArr = formDataArr.filter(function (i) {
						return i.name !== 'feature';
					});

					features = features.substring(0, features.length - 1);
					formDataArr.push({
						name: "feature",
						value: features
					});
				}

				currentURL = currentURL + '?' + $.param(formDataArr);
				$body.on('g5core_pagination_ajax_success', function (event, _data, $ajaxHTML, target, loadMore) {
					var $popoup = $('#ere_save_search_modal');
					if ($popoup.length && !loadMore && (typeof _data.settings['isMainQuery'] !== 'undefined')) {
						var $resultPopup = $ajaxHTML.find('#ere_save_search_modal');
						if ($resultPopup.length) {
							$popoup.replaceWith($resultPopup.prop('outerHTML'));
						}
					}

				});

				var $wrapper = $('[data-archive-wrapper]');
				if ($wrapper.length > 0) {
					var settingId = $wrapper.data('items-wrapper');
					G5CORE.paginationAjax.loadPosts(settingId, this, currentURL);
				} else {
					window.location.href = currentURL;
				}
			});
		}
	};
	G5ERE_FRONTEND.AUTO_COMPLETE = {
		timeOutSearch: null,
		xhrSearchAjax: null,
		init: function () {
			$(document).on('keyup', '.g5ere__sf-auto-complete input[name="keyword"]', function (event) {
				if (event.altKey || event.ctrlKey || event.shiftKey || event.metaKey) {
					return;
				}
				var keys = ["Control", "Alt", "Shift"];
				if (keys.indexOf(event.key) != -1) return;

				var $input = $(this),
					$wrap = $(this).closest('.g5ere__sf-auto-complete'),
					$result = $wrap.find('.g5ere__sf-auto-complete-result'),
					$icon = $wrap.find('.g5ere__sf-icon-submit > i');

				switch (event.which) {
					case 27:	// ESC
						$input.val('');
						$result.html('');
						$wrap.removeClass('in');
						break;
					case 38:
					case 40:
					case 13:
						break;
					default:
						clearTimeout(G5ERE_FRONTEND.AUTO_COMPLETE.timeOutSearch);
						G5ERE_FRONTEND.AUTO_COMPLETE.timeOutSearch = setTimeout(G5ERE_FRONTEND.AUTO_COMPLETE.search, 500, $wrap, $input, $icon, $result);
						break;
				}
			});

			$(document).on('click', function (event) {
				if ($(event.target).closest('.g5ere__sf-auto-complete-result').length === 0) {
					$('.g5ere__sf-auto-complete').each(function () {
						var $wrap = $(this),
							$result = $wrap.find('.g5ere__sf-auto-complete-result'),
							$icon = $wrap.find('.g5ere__sf-icon-submit > i');

						$result.html('');
						$wrap.removeClass('in');
						$icon.removeClass('fa-spinner fa-spin');
						$icon.addClass('fa-search');
					});
				}
			});
		},
		search: function ($wrap, $input, $icon, $result) {
			var keyword = $.trim($input.val());
			if (keyword.length < 3) {
				$result.html('');
				$wrap.removeClass('in');
				$icon.removeClass('fa-spinner fa-spin');
				$icon.addClass('fa-search');
				return;
			}

			$icon.addClass('fa-spinner fa-spin');
			$icon.removeClass('fa-search');

			if (G5ERE_FRONTEND.AUTO_COMPLETE.xhrSearchAjax) {
				G5ERE_FRONTEND.AUTO_COMPLETE.xhrSearchAjax.abort();
			}

			var $form = $input.closest('form');
			var _data = $form.serializeArray().reduce(function(obj, item) {
				if (item.value !== '') {
					obj[item.name] = item.value;
				}
				return obj;
			}, {});
			var _url = $form.data('url');
			G5ERE_FRONTEND.AUTO_COMPLETE.xhrSearchAjax = $.ajax({
				type: 'POST',
				url: _url,
				data: _data,
				dataType: 'html',
				success: function (response) {
					$icon.removeClass('fa-spinner fa-spin');
					$icon.addClass('fa-search');

					$result.html(response);
					$wrap.addClass('in');
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

	G5ERE_FRONTEND.HEADER_SEARCH_STICKY = {
		scroll_offset_before: 0,
		init: function () {
			this.sticky();
			this.resize();
			this.scroll();
			this.processSticky();
			this.advancedSearchButton();
		},
		sticky: function () {
			$('.g5ere__ash-sticky .g5ere__ash-sticky-area').each(function () {
				var $this = $(this);
				if (!$this.is(':visible')) {
					return;
				}
				if (!$this.parent().hasClass('g5ere__ash-sticky-area-wrap')) {
					$this.wrap('<div class="g5ere__ash-sticky-area-wrap"></div>');
				}
				var $wrap = $this.parent();
				if ($wrap.attr('style') === undefined) {
					$wrap.css('height', $this.css('height'));
				}
				setTimeout(function () {
					$wrap.css('height', $this.css('height'));
				}, 500);

			});
		},
		resize: function () {
			var _self = this;
			$window.resize(function () {
				_self.sticky();
				_self.processSticky();
			});
		},
		scroll: function () {
			var _self = this;
			$window.on('scroll', function () {
				_self.processSticky();
			});
		},
		processSticky: function () {
			var _self = this,
				current_scroll_top = $window.scrollTop();

			$('.g5ere__ash-sticky .g5ere__ash-sticky-area').each(function () {
				var $this = $(this);
				if (!$this.is(':visible')) {
					return;
				}

				var $wrap = $this.parent(),
					sticky_top = G5CORE.getAdminBarHeight(),
					sticky_current_top = $wrap.offset().top;

				sticky_top += parseInt($body.css('border-width'));

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

			if (_self.scroll_offset_before > current_scroll_top) {
				$('.g5ere__ash-sticky-smart .g5ere__ash-sticky-area').each(function () {
					if ($(this).hasClass('g5ere__ash-sticky-hidden')) {
						$(this).removeClass('g5ere__ash-sticky-hidden');
					}
				});
			} else {
				// down
				$('.g5ere__ash-sticky-smart .g5ere__ash-sticky-area').each(function () {
					var $wrapper = $(this).parent();
					if ($wrapper.length) {
						if ((_self.scroll_offset_before > ($wrapper.offset().top + $(this).outerHeight())) && !$(this).hasClass('g5ere__ash-sticky-hidden')) {
							$(this).addClass('g5ere__ash-sticky-hidden');
						}
					}

				});
			}
			_self.scroll_offset_before = current_scroll_top;
		},
		advancedSearchButton: function () {
			$('.g5ere__sf-bottom-wrap').on('show.bs.collapse', function (e) {
				var $target = $(e.target),
					$stickyWrap = $target.closest('.g5ere__ash-sticky-area-wrap');
				if (!$target.hasClass('g5ere__sf-bottom-wrap')) {
					return;
				}
				if ($stickyWrap.length > 0) {
					var stickyWrapHeight = $stickyWrap.css('height');
					if ($stickyWrap.attr('data-height') === undefined) {
						$stickyWrap.attr('data-height', stickyWrapHeight);
					}

					$stickyWrap.css('height', 'auto');
				}
			});

			$('.g5ere__sf-bottom-wrap').on('hidden.bs.collapse', function (e) {
				var $target = $(e.target),
					$stickyWrap = $target.closest('.g5ere__ash-sticky-area-wrap');
				if (!$target.hasClass('g5ere__sf-bottom-wrap')) {
					return;
				}
				if ($stickyWrap.length > 0) {
					var stickyWrapHeight = $stickyWrap.attr('data-height');
					$stickyWrap.css('height', stickyWrapHeight);
				}
			});
		}
	};

	G5ERE_FRONTEND.SINGLE_PROPERTY = {
		init: function () {
			this.switchGalleryMap();
			this.print();
		},
		switchGalleryMap: function () {
			var self = this;
			$('.g5ere__spg-nav .nav-link').on('shown.bs.tab', function (e) {
				var $parent = $(e.target).closest('.g5ere__single-property-galleries');
				if ($parent.length === 0) {
					$parent = $(e.target).closest('.g5ere__single-property-featured');
				}
				if ($parent.length === 0) return;
				var $map = $parent.find('.g5ere__map-canvas');
				if ($map.length > 0) {
					var map_id = $map.attr('id');
					var map = G5ERE_MAP.getInstance(map_id).instance;
					setTimeout(function () {
						map.refresh();
					}, 50);
				}
			});

			$('.g5ere__spg-nav .nav-link').on('shown.bs.tab', function (e) {
				var $parent = $(e.target).closest('.g5ere__single-property-galleries');
				if ($parent.length === 0) return;
				setTimeout(function () {
					$parent.find('.slick-initialized').slick('refresh');
				}, 10);

			});
		},
		print: function () {
			$('.g5ere__single-property-print').on('click', function () {
				var property_id = $(this).data('property-id'),
					property_print_window = window.open('', g5ere_vars.i18n.property_print_window, 'scrollbars=0,menubar=0,resizable=1,width=991 ,height=800');
				$.ajax({
					type: 'POST',
					url: g5ere_vars.ajax_url,
					data: {
						'action': 'property_print_ajax',
						'property_id': property_id,
						'isRTL': $('body').hasClass('rtl') ? 'true' : 'false'
					},
					success: function (html) {
						property_print_window.document.write(html);
						property_print_window.document.close();
						property_print_window.focus();
					}
				});
			});
		},
	};

	G5ERE_FRONTEND.NEARBY_PLACES = {
		location: null,
		$element: null,
		options: null,
		init: function () {
			if (typeof google === "undefined") {
				return;
			}
			this.$element = $('[data-toggle="nearby-places"]');
			if (this.$element.length === 0) {
				return;
			}
			this.options = this.$element.data('options');
			if (this.options.location === false) {
				return;
			}
			this.$container = this.$element.find('.g5ere__nearby-places-details');

			this.location = new google.maps.LatLng(this.options.location.lat, this.options.location.lng);
			this.getNearbyPlace();
		},
		getNearbyPlace: function () {
			var self = this;
			$.each(self.options.request.categories, function ($k, $v) {
				var $blockEl = $("#g5ere__google_nearby_place_block_template");
				var _html_block = $($blockEl.html().replace("{{category}}", $v));
				self.$element.append(_html_block);
				self.renderNearByPlace($k, $v, _html_block);
			});
		},
		renderNearByPlace: function (category_Id, category_title, _html_block) {
			var self = this,
				request = {
					location: self.location,
					radius: self.options.request.radius,
					type: [category_Id]
				};
			if (self.options.request.rank === 'distance') {
				request = {
					location: self.location,
					type: [category_Id],
					rankBy: google.maps.places.RankBy.DISTANCE
				};
			}
			var nearPlaces = new google.maps.places.PlacesService(_html_block.find('.cat-block-content')[0]);
			nearPlaces.nearbySearch(request, function (results, status) {
				if (status === google.maps.places.PlacesServiceStatus.OK) {
					$.each(results, function (index) {
						if (index < self.options.request.limit) {
							_html_block.find('.cat-block-content').append(self.renderPlace(this));
						}
					});

				}
			});
		},

		renderPlace: function (result) {
			var self = this;
			var rating = 0;
			if (typeof result.rating !== "undefined") {
				rating = result.rating;
			}

			var total_reviews = 0;
			if (typeof result.user_ratings_total !== "undefined") {
				total_reviews = result.user_ratings_total;
			}

			var image_url = self.options.placeholder;
			if (typeof result.photos !== "undefined") {
				image_url = result.photos[0].getUrl();
			}
			var name = result.name;
			var address = result.vicinity;

			var link = '//maps.google.com/?q=' + address;

			var distance = this.distance(result.geometry.location.lat(), result.geometry.location.lng());

			var _html_rating = '';
			if (rating !== 0) {
				var _html_star = '';
				for (var j = 0; j < 5; j++) {
					var class_name = 'far';
					if (j < parseFloat(rating)) {
						class_name = 'fa';
					}
					_html_star += $("#g5ere__google_nearby_place_star_template").html().replace("{{class}}", class_name);

				}
				_html_rating = $("#g5ere__google_nearby_place_rating_template").html().replace("{{total_review}}", total_reviews);
				_html_rating = _html_rating.replace("{{rating}}", _html_star);
			}
			var _html_items = $("#g5ere__google_nearby_place_items_template").html();
			_html_items = _html_items.replaceAll("{{link}}", link);
			_html_items = _html_items.replaceAll("{{image_url}}", image_url);
			_html_items = _html_items.replaceAll("{{name}}", name);
			_html_items = _html_items.replaceAll("{{distance}}", distance);
			_html_items = _html_items.replaceAll("{{address}}", address);
			_html_items = _html_items.replaceAll("{{html_rating}}", _html_rating);

			return _html_items;
		},
		distance: function (latitude, longitude) {
			var lat1 = this.location.lat();
			var lng1 = this.location.lng();
			var lat2 = latitude;
			var lng2 = longitude;
			var radlat1 = Math.PI * lat1 / 180;
			var radlat2 = Math.PI * lat2 / 180;
			var theta = lng1 - lng2;
			var radtheta = Math.PI * theta / 180;
			var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
			dist = Math.acos(dist);
			dist = dist * 180 / Math.PI;
			dist = dist * 60 * 1.1515;
			if (this.options.dist_unit === "kilometers") {
				dist = dist * 1.609344;
			}
			dist = Math.round(dist * 100) / 100;
			return (dist + ' ' + this.options.dist_unit_text);
		}

	};

	$(document).ready(function () {
		G5ERE_FRONTEND.init();
		G5ERE_FRONTEND.EXPLOPRE.init();
		G5ERE_FRONTEND.SEARCH.init();
		G5ERE_FRONTEND.AUTO_COMPLETE.init();
		G5ERE_FRONTEND.HEADER_SEARCH_STICKY.init();
		G5ERE_FRONTEND.SINGLE_PROPERTY.init();
		G5ERE_FRONTEND.NEARBY_PLACES.init();
	});

	$(document).on('maps:loaded', function () {
		G5ERE_FRONTEND.EXPLOPRE.initMap();
	});

})(jQuery);