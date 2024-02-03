(function ($) {
	"use strict";
	window.InlineShortcodeView_g5element_slider_container1 = vc.shortcode_view.extend( {
		render: function ( e ) {
			$('.gel-slider-container',this.$el).each(function () {
				//var $slick = $(this).slick('getSlick');
				//console.log($slick);
				//vc.frame_window.G5CORE.util.unSlick($(this));
			});


		/*	var $slick = $('.slick-initialized',this.$el).slick('getSlick');
			console.log($slick);*/
			console.log('render');


			var _self = this,
				model = this.model;

			if (model.get('slider_activity') === true) {
				console.log(5555);
				vc.frame_window.G5CORE.util.unSlickSlider(this.$el);
			}


			window.InlineShortcodeView_g5element_slider_container.__super__.render.call( this, e );

			_self.$el.find('.vc_container-anchor').remove();


			//this.initSliderJs( true );


			if (model.get('slider_activity') !== true) {
				vc.frame_window.vc_iframe.addActivity( function () {
					console.log('addActivity');
					this.G5CORE.util.slickSlider(_self.$el);
					model.set( 'slider_activity', true );
				});
			}

			return this;
		},
		remove: function() {
			console.log('remove');
			//window.InlineShortcodeView_g5element_slider_container.__super__.remove.call( this );
		},
		/*parentChanged: function () {
			window.InlineShortcodeView_g5element_slider_container.__super__.parentChanged.call( this );
			console.log('parentChanged');
			//vc.frame_window.G5CORE.util.slickSlider();
			this.initSliderJs();
		},*/
		initSliderJs: function (useAddActivity) {
			var model = this.model,
				_self = this,
				$slider = _self.$el.find('.gel-slider-container');

			console.clear();
			console.log(model.get( 'grid_activity' ));
			_self.$el.find('.vc_container-anchor').remove();
			if ( true === model.get( 'grid_activity' ) ) {
				return false;
			}
			model.set( 'grid_activity', true );


			console.log('initSliderJs');
			if ( true === useAddActivity ) {
				vc.frame_window.vc_iframe.addActivity( function () {
					//this.vc_iframe.gridInit( model.get( 'id' ) );
					var _that = this;
					this.G5CORE.util.slickSlider(_self.$el);


					console.log('addActivity');
					model.set( 'grid_activity', false );
				} );
			} else {
				//vc.frame_window.vc_iframe.gridInit( model.get( 'id' ) );
				console.log('parentChanged');
				model.set( 'grid_activity', false );
			}
		}
	} );

	window.InlineShortcodeView_g5element_slider_container = window.InlineShortcodeView.extend( {
		render: function () {
			var model_id = this.model.get( 'id' );
			window.InlineShortcodeView_g5element_slider_container.__super__.render.call( this );
			console.log('render');

			vc.frame_window.vc_iframe.addActivity( function () {
				//this.vc_iframe.vc_postsSlider( model_id );
				console.log('addActivity');
			} );

			return this;
		},
		remove: function () {
			console.log('remove');
		}
	} );




})(jQuery);