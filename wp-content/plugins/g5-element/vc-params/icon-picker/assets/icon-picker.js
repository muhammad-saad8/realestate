(function ($) {
	"use strict";

	vc.atts.g5element_icon_picker = {
		init: function (param, $field) {
			var $iconField = $field.find('.g5element_icon_picker_field');

			$field.find('.g5element-add-icon').on('click',function() {
				GSF_ICON_POPUP.open($iconField.val(), function(icon) {
					$iconField.val(icon);
					$field.find('.selected-icon > i').attr('class',icon);
                    $field.find('.g5element-remove-icon').show();
                    $iconField.trigger('change');
					GSF_ICON_POPUP.svg_icon($field);
				});
			});

            $field.find('.g5element-remove-icon').on('click',function() {
                $iconField.val('');
                $field.find('.selected-icon > i').attr('class','');
                $(this).hide();
                $iconField.trigger('change');
            });

			GSF_ICON_POPUP.svg_icon($field);
		}
	}
})(jQuery);