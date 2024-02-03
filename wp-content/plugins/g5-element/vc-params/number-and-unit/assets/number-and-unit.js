(function ($) {
	"use strict";
	vc.atts.g5element_number_and_unit = {
		init: function (param, $field) {
			var $inputField = $field.find('.g5element_number_and_unit_field');
			$field.find('.g5element-vc-number-and-unit-field').on('change',function(){
				var value = '';
				$field.find('.g5element-vc-number-and-unit-field').each(function(){
                    if (value === '') {
                        value += $(this).val();
                    } else  {
                        value += $(this).val();
                    }
				});
				$inputField.val(value);
			});
		}

	}
})(jQuery);
