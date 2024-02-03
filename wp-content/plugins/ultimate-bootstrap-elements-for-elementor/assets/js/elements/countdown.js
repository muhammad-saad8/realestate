(function ($) {
	'use strict';
	var UBE_CountDown = function ($wrapper) {
		this.onInit($wrapper);
	};
	UBE_CountDown.prototype = {
		cache: null,

		cacheElements: function ($scope) {
			var $countDown = $scope.find('.ube-countdown');
			var endTime = new Date();
			var timeRemaining = $countDown.data('date');
			var loop = $countDown.data('loop');
			endTime.setSeconds(endTime.getSeconds() + parseInt(timeRemaining) - 1);

			this.cache = {
				$countDown: $countDown,
				timeInterval: null,
				elements: {
					$countdown: $countDown,
					$daysSpan: $countDown.find('.ube-countdown-days'),
					$hoursSpan: $countDown.find('.ube-countdown-hours'),
					$minutesSpan: $countDown.find('.ube-countdown-minutes'),
					$secondsSpan: $countDown.find('.ube-countdown-seconds'),
					$expireMessage: $countDown.parent().find('.ube-countdown-expire-message')
				},
				data: {
					id: $countDown.data('id'),
					endTime: endTime,
					actions: $countDown.data('expire-actions'),
					showSetting: $countDown.data('show-setting'),
					timeRemaining: timeRemaining,
					endTimeLoop: loop,
				}
			};
		},

		onInit: function (scope) {
			this.cacheElements(scope);
			this.initializeClock();
		},

		updateClock: function () {
			var self = this,
				timeRemaining = this.getTimeRemaining(this.cache.data.endTime, this.cache.data.showSetting);
			jQuery.each(timeRemaining.parts, function (timePart) {
				var $element = self.cache.elements['$' + timePart + 'Span'];
				var partValue = this.toString();

				if (1 === partValue.length) {
					partValue = 0 + partValue;
				}

				if ($element.length) {
					$element.text(partValue);
				}
			});

			if (timeRemaining.total <= 0) {
				clearInterval(this.cache.timeInterval);
				this.runActions();
			}
		},

		initializeClock: function () {
			var self = this;
			this.updateClock();

			this.cache.timeInterval = setInterval(function () {
				self.updateClock();
			}, 1000);

		},

		runActions: function () {
			var self = this;

			// Trigger general event for 3rd patry actions

			if (!this.cache.data.actions) {
				return;
			}
			switch (this.cache.data.actions.type) {
				case 'hide':
					self.cache.$countDown.hide();
					break;
				case 'redirect':
					if (this.cache.data.actions.redirect_url) {
						window.location.href = this.cache.data.actions.redirect_url;
					}
					break;
				case 'message':
					self.cache.elements.$expireMessage.show();
					break;
				case 'loop':
					var endTime = new Date();
					endTime.setSeconds(endTime.getSeconds() + parseInt(self.cache.data.endTimeLoop) - 1);
					self.cache.data.endTime = endTime;
					self.initializeClock();
					break;
			}
		},

		getTimeRemaining: function (endTime, setting) {
			var timeRemaining = endTime - new Date();
			var seconds = Math.floor(timeRemaining / 1000 % 60),
				minutes = Math.floor(timeRemaining / 1000 / 60 % 60),
				hours = Math.floor(timeRemaining / (1000 * 60 * 60) % 24),
				days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
			if (setting.show_days === '') {
				hours = hours + days * 24;
			}
			if (setting.show_days === '' && setting.show_hours === '') {
				minutes = hours * 60 + minutes;
			}
			if (setting.show_days !== '' && setting.show_hours === '') {
				minutes = hours * 60 + minutes;
			}
			if (setting.show_days === '' && setting.show_hours === '' && setting.show_minutes === '') {
				seconds = minutes * 60 + seconds;
			}
			if (setting.show_days !== '' && setting.show_hours === '' && setting.show_minutes === '') {
				seconds = hours * 60 * 60 + seconds;
			}
			if (setting.show_days !== '' && setting.show_hours !== '' && setting.show_minutes === '') {
				seconds = minutes * 60 + seconds;
			}

			if (days < 0 || hours < 0 || minutes < 0) {
				seconds = minutes = hours = days = 0;

			}

			return {
				total: timeRemaining,
				parts: {
					days: days,
					hours: hours,
					minutes: minutes,
					seconds: seconds
				}
			};
		},
	};
	var UbeCountdownHandler = function ($scope, $) {
		new UBE_CountDown($scope);
	};

	 window.addEventListener( 'elementor/frontend/init', () => {
		elementorFrontend.hooks.addAction('frontend/element_ready/ube-countdown.default', UbeCountdownHandler);
	});

})(jQuery);