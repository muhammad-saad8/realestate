(function ($) {
    'use strict';
    var G5ERE_Agency_Handler = function ($scope, $) {
        new G5CORE_Animation($scope);
    };
    window.addEventListener( 'elementor/frontend/init', () => {
        elementorFrontend.hooks.addAction('frontend/element_ready/g5-agency.default', G5ERE_Agency_Handler);
    });

})(jQuery);