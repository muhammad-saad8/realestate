(function ($) {
	"use strict";
	vc.atts.g5element_responsive = {
		init: function (param, $field) {
			var $inputField = $field.find('.g5element_responsive_field');
			$field.find('.g5element-vc-responsive-field').on('change',function(){
				var value = '';
				$field.find('.g5element-vc-responsive-field').each(function(){
					if ($(this).is(':checked')) {
						if (value === '') {
							value += $(this).attr('name');
						} else  {
							value += ' ' + $(this).attr('name');
						}
					}
				});
				$inputField.val(value);
			});
		}

	}
})(jQuery);
