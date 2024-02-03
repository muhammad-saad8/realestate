(function ($) {
	"use strict";
	vc.atts.g5element_slider = {
		init: function (param, $field) {
			var $slider = $field.find('.g5element-vc-slider-place'),
				slider = $slider[0],
				$input = $field.find('input'),
				options = $slider.data('options'),
				config = {
					step: options['step'],
					start: $input.val(),
					connect: [true, false],
					range: {
						min: options['min'],
						max: options['max']
					}
				};

			noUiSlider.create(slider, config);

			slider.noUiSlider.on('update', function( values, handle ) {
				if ($($input[handle]).hasClass('g5element-slider-init-done')) {
					$input[handle].value = vc.atts.g5element_slider.getValue(values[handle], parseFloat(options['step']));
				}
				else {
					$($input[handle]).addClass('g5element-slider-init-done');
				}
			});

			$input.on('change', function () {
				slider.noUiSlider.set(this.value);
			});
		},
		getValue: function(value, step) {
			if (Math.round(step) == step) {
				return Math.round(value);
			}
			if (Math.round(step*10) == step * 10) {
				return Math.round(value*10)/10;
			}
			return value;
		}
	}
})(jQuery);
