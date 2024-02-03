(function ($) {
	"use strict";
	vc.atts.g5element_number_responsive = {
		init: function (param, $field) {
			var $inputField = $field.find('.g5element_number_responsive_field');
			$field.find('.g5element-vc-number-responsive-field').on('change',function(){
				var value = '';
				$field.find('.g5element-vc-number-responsive-field').each(function(){
                    if (value === '') {
                        value += $(this).val();
                    } else  {
                        value += '|' + $(this).val();
                    }
				});
				$inputField.val(value);
			});
		}

	}
})(jQuery);
