(function ($) {
    'use strict';
    var G5ERE_Advanced_Properties_Locations_Handler = function ($scope, $) {
        new G5CORE_Animation($scope);
        var options_default = {
            slidesToScroll: 1,
            slidesToShow: 1,
            adaptiveHeight: true,
            arrows: true,
            dots: true,
            autoplay: false,
            autoplaySpeed: 3000,
            centerMode: false,
            centerPadding: "50px",
            draggable: true,
            fade: false,
            focusOnSelect: false,
            infinite: false,
            pauseOnHover: false,
            responsive: [],
            rtl: false,
            speed: 300,
            vertical: false,
            prevArrow: '<div class="slick-prev" aria-label="Previous"><i class="fas fa-chevron-left"></i></div>',
            nextArrow: '<div class="slick-next" aria-label="Next"><i class="fas fa-chevron-right"></i></div>',
            customPaging: function(slider, i) {
                return $('<span></span>');
            }
        };
        var $slider_wrapper = $scope.find('.ube-slider');
        $slider_wrapper.each(function () {
            var $this = $(this);
            if (!$this.hasClass('slick-initialized')) {
                var options = $this.data('slick-options');
                options = $.extend({}, options_default, options);
                $this.slick(options);

                $this.on('setPosition', function (event, slick) {
                    var max_height = 0;
                    slick.$slides.each(function () {
                        var $slide = $(this);
                        if ($slide.hasClass('slick-active')) {
                            if (slick.options.adaptiveHeight && (slick.options.slidesToShow > 1) && (slick.options.vertical === false)) {
                                if (max_height < $slide.outerHeight()) {
                                    max_height = $slide.outerHeight();
                                }
                            }
                        }
                    });
                    if (max_height !== 0) {
                        $this.find('> .slick-list').animate({
                            height: max_height
                        }, 500);
                    }
                });
            }
        });


    };
    window.addEventListener( 'elementor/frontend/init', () => {
        elementorFrontend.hooks.addAction('frontend/element_ready/g5-advanced-properties-locations.default', G5ERE_Advanced_Properties_Locations_Handler);
    });

})(jQuery);