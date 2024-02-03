(function ($) {
	"use strict";
	vc.atts.g5element_switch = {
		init: function (param, $field) {
			$field.find('.g5element_switch_field').on('change', function(){
				var $this = $(this);
				if($this.is(':checked')) {
					$this.attr('value', 'on');
				} else {
                    $this.attr('value', '');
				}
			});
		}
	}
})(jQuery);
