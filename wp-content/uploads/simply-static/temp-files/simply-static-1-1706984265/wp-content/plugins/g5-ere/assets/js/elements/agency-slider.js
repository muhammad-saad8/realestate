(function ($) {
    'use strict';
    var G5ERE_Agency_Slider_Handler = function ($scope, $) {
        G5CORE.util.slickSlider($scope);
        new G5CORE_Animation($scope);
    };
    window.addEventListener( 'elementor/frontend/init', () => {
        elementorFrontend.hooks.addAction('frontend/element_ready/g5-agency-slider.default', G5ERE_Agency_Slider_Handler);
    });

})(jQuery);