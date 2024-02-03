(function ($) {
	"use strict";
	vc.atts.g5element_image_set = {
		init: function (param, $field) {
			var $inputField = $field.find('.g5element_image_set_field');
			$field.find('.g5element-vc-image-set-wrapper').on('click', '.g5element-vc-image-set-item', function(){
				var $this = $(this);
				if($this.hasClass('current')) {
					return false;
				}
				var value = $this.attr('data-value');
				$this.parent().children('.current').removeClass('current');
				$this.addClass('current');

				$inputField.val(value);
				$inputField.trigger('change');
			});
		}
	}
})(jQuery);
