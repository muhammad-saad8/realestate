<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if (!class_exists('G5ERE_Custom_Css')) {
	class G5ERE_Custom_Css {
		private static $_instance;
		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function init() {
			if ( ! is_admin() ) {
				add_action( 'template_redirect', array( $this, 'global_custom_css' ), 100 );
			}
		}

		public function global_custom_css() {
			G5CORE()->custom_css()->addCss( $this->header_advanced_search_responsive_css(), 'g5ere_header_search_responsive' );
			G5CORE()->custom_css()->addCss( $this->header_advanced_search_color(), 'g5ere_header_search_color' );
			G5CORE()->custom_css()->addCss( $this->header_advanced_search_mobile_color(), 'g5ere_header_search_mobile_color' );
			G5CORE()->custom_css()->addCss($this->single_property_head_spacing(),'g5ere__single_property_head_spacing');
			G5CORE()->custom_css()->addCss($this->header_customize_css(),'g5ere__header_customize_css');
		}

		public function header_advanced_search_responsive_css() {
			$responsive_break_point = G5CORE()->options()->header()->get_option( 'header_responsive_breakpoint', '991' );
			$responsive_break_point_2 = $responsive_break_point + 1;
			return <<<CUSTOM_CSS
@media screen and (max-width: {$responsive_break_point}px) {
	#g5ere__advanced_search_header {
		display: none;
	}
	#g5ere__advanced_search_header_mobile {
		display: block;
	}
}
CUSTOM_CSS;

		}

		public function header_advanced_search_color() {
			$background_color = G5CORE()->options()->header()->get_option( 'advanced_search_background_color' );
			$text_color       = G5CORE()->options()->header()->get_option( 'advanced_search_text_color' );
			$text_hover_color       = G5CORE()->options()->header()->get_option( 'advanced_search_text_hover_color' );
			$form_field_background_color = G5CORE()->options()->header()->get_option( 'advanced_search_form_field_background_color' );
			$form_field_text_color = G5CORE()->options()->header()->get_option( 'advanced_search_form_field_text_color' );
			$form_field_placeholder_text_color = G5CORE()->options()->header()->get_option( 'advanced_search_form_field_placeholder_text_color' );
			$form_field_border_color = G5CORE()->options()->header()->get_option( 'advanced_search_form_field_border_color' );



			return <<<CUSTOM_CSS
#g5ere__advanced_search_header .g5ere__ash-sticky-area {
	background-color: {$background_color};
	color: {$text_color};
}


#g5ere__advanced_search_header .g5ere__search-form .input-group-text,
#g5ere__advanced_search_header .g5ere__search-form .bootstrap-select > .dropdown-toggle,
#g5ere__advanced_search_header .g5ere__search-form .bootstrap-select > .dropdown-toggle.bs-placeholder,
#g5ere__advanced_search_header .g5ere__search-form .bootstrap-select > .dropdown-toggle.bs-placeholder:hover,
#g5ere__advanced_search_header .g5ere__search-form .bootstrap-select > .dropdown-toggle.bs-placeholder:focus,
#g5ere__advanced_search_header .g5ere__search-form .bootstrap-select > .dropdown-toggle.bs-placeholder:active,
#g5ere__advanced_search_header .g5ere__search-form .form-control:focus,
#g5ere__advanced_search_header .g5ere__search-form .form-control {
	color: {$form_field_text_color};
	background-color: {$form_field_background_color};
	border-color: {$form_field_border_color}
}


#g5ere__advanced_search_header .g5ere__search-form .form-control:-moz-placeholder{
  color: {$form_field_placeholder_text_color};
}
#g5ere__advanced_search_header .g5ere__search-form .form-control::-moz-placeholder{
  color: {$form_field_placeholder_text_color};
}
#g5ere__advanced_search_header .g5ere__search-form .form-control:-ms-input-placeholder{
  color: {$form_field_placeholder_text_color};
}
#g5ere__advanced_search_header .g5ere__search-form .form-control::-webkit-input-placeholder{
  color: {$form_field_placeholder_text_color};
}

#g5ere__advanced_search_header .g5ere__search-form .custom-control-label:hover,
#g5ere__advanced_search_header .g5ere__search-form .g5ere__btn-features-list:hover {
	color: {$text_hover_color};
}


#g5ere__advanced_search_header .g5ere__search-form .input-group-text {
	border-color: {$form_field_border_color}
}

CUSTOM_CSS;

		}

		public function header_advanced_search_mobile_color() {
			$background_color = G5CORE()->options()->header()->get_option( 'advanced_search_mobile_background_color' );
			$text_color       = G5CORE()->options()->header()->get_option( 'advanced_search_mobile_text_color' );
			$text_hover_color       = G5CORE()->options()->header()->get_option( 'advanced_search_mobile_text_hover_color' );
			$form_field_background_color = G5CORE()->options()->header()->get_option( 'advanced_search_mobile_form_field_background_color' );
			$form_field_text_color = G5CORE()->options()->header()->get_option( 'advanced_search_mobile_form_field_text_color' );
			$form_field_placeholder_text_color = G5CORE()->options()->header()->get_option( 'advanced_search_mobile_form_field_placeholder_text_color' );
			$form_field_border_color = G5CORE()->options()->header()->get_option( 'advanced_search_mobile_form_field_border_color' );

			return <<<CUSTOM_CSS
#g5ere__advanced_search_header_mobile .g5ere__ash-sticky-area {
	background-color: {$background_color};
	color: {$text_color};
}


#g5ere__advanced_search_header_mobile .g5ere__search-form .input-group-text,
#g5ere__advanced_search_header_mobile .g5ere__search-form .bootstrap-select > .dropdown-toggle,
#g5ere__advanced_search_header_mobile .g5ere__search-form .bootstrap-select > .dropdown-toggle.bs-placeholder,
#g5ere__advanced_search_header_mobile .g5ere__search-form .bootstrap-select > .dropdown-toggle.bs-placeholder:hover,
#g5ere__advanced_search_header_mobile .g5ere__search-form .bootstrap-select > .dropdown-toggle.bs-placeholder:focus,
#g5ere__advanced_search_header_mobile .g5ere__search-form .bootstrap-select > .dropdown-toggle.bs-placeholder:active,
#g5ere__advanced_search_header_mobile .g5ere__search-form .form-control:focus,
#g5ere__advanced_search_header_mobile .g5ere__search-form .form-control {
	color: {$form_field_text_color};
	background-color: {$form_field_background_color};
	border-color: {$form_field_border_color}
}


#g5ere__advanced_search_header_mobile .g5ere__search-form .form-control:-moz-placeholder{
  color: {$form_field_placeholder_text_color};
}
#g5ere__advanced_search_header_mobile .g5ere__search-form .form-control::-moz-placeholder{
  color: {$form_field_placeholder_text_color};
}
#g5ere__advanced_search_header_mobile .g5ere__search-form .form-control:-ms-input-placeholder{
  color: {$form_field_placeholder_text_color};
}
#g5ere__advanced_search_header_mobile .g5ere__search-form .form-control::-webkit-input-placeholder{
  color: {$form_field_placeholder_text_color};
}

#g5ere__advanced_search_header_mobile .g5ere__search-form .custom-control-label:hover,
#g5ere__advanced_search_header_mobile .g5ere__search-form .g5ere__btn-features-list:hover {
	color: {$text_hover_color};
}


#g5ere__advanced_search_header_mobile .g5ere__search-form .input-group-text {
	border-color: {$form_field_border_color}
}

CUSTOM_CSS;

		}

		public function single_property_head_spacing() {
			$content_padding = wp_parse_args( G5CORE()->options()->layout()->get_option( 'content_padding' ), array(
				'top'    => '0',
				'bottom' => '0',
			) );

			if (isset($content_padding['top']) && ($content_padding['top'] !== '')) {
				return <<<CSS
            .g5core-page-title + .g5ere__single-property-head{
                padding-top: {$content_padding['top']}px;
            }
CSS;

			}
			return '';
		}

		public function header_customize_css() {
			$header_mobile_border_color     = G5CORE()->options()->header()->get_option( 'header_mobile_border_color' );
			$header_mobile_text_hover_color = G5CORE()->options()->header()->get_option( 'header_mobile_text_hover_color' );
			$header_mobile_sticky_text_hover_color = G5CORE()->options()->header()->get_option( 'header_mobile_sticky_text_hover_color' );


			$header_border_color     = G5CORE()->options()->header()->get_option( 'header_border_color' );
			$header_text_hover_color = G5CORE()->options()->header()->get_option( 'header_text_hover_color' );

			$navigation_border_color     = G5CORE()->options()->header()->get_option( 'navigation_border_color' );
			$navigation_text_hover_color = G5CORE()->options()->header()->get_option( 'navigation_text_hover_color' );

			$header_sticky_border_color     = G5CORE()->options()->header()->get_option( 'header_sticky_border_color');
			if ($header_sticky_border_color == '') {
				$header_sticky_border_color = 'transparent';
			}
			$header_sticky_text_hover_color = G5CORE()->options()->header()->get_option( 'header_sticky_text_hover_color' );
			$header_mobile_sticky_border_color     = G5CORE()->options()->header()->get_option( 'header_mobile_sticky_border_color' );
			return <<<CSS
			
			.g5core-header-desktop-wrapper .g5core-header-customize .g5core-hc-button-add-listing .btn-listing {
			  border-color: {$header_border_color};
			}
			
			
			.g5core-header-desktop-wrapper .g5ere__user-dropdown .g5ere__user-display-name:hover,
			.g5core-header-desktop-wrapper .g5ere__login-button a:hover,
			.g5core-header-desktop-wrapper .g5ere__btn-my-favourite:hover,
			.g5core-header-desktop-wrapper .g5core-header-customize .g5core-hc-button-add-listing .btn-listing:hover{
				color: $header_text_hover_color;
			}

			.g5core-header-navigation .g5ere__user-dropdown .g5ere__user-display-name:hover,
			.g5core-header-navigation .g5ere__login-button a:hover,
			.g5core-header-navigation .g5ere__btn-my-favourite:hover,
			.g5core-header-navigation .g5core-header-customize .g5core-hc-button-add-listing .btn-listing:hover{
				color: $navigation_text_hover_color;
			}
			
			.g5core-header-navigation .g5core-header-customize .g5core-hc-button-add-listing .btn-listing {
			  border-color: {$navigation_border_color};
			}
			


			.sticky-area-wrap.sticky .g5ere__user-dropdown .g5ere__user-display-name:hover,
			.sticky-area-wrap.sticky .g5ere__login-button a:hover,
			.sticky-area-wrap.sticky .g5ere__btn-my-favourite:hover,
			.sticky-area-wrap.sticky .g5core-header-customize .g5core-hc-button-add-listing .btn-listing:hover{
				color: $header_sticky_text_hover_color;
			}
			
			.sticky-area-wrap.sticky .g5core-header-customize .g5core-hc-button-add-listing .btn-listing {
			  border-color: {$header_sticky_border_color};
			}

			.g5core-mobile-header-wrapper .g5ere__user-dropdown .g5ere__user-display-name:hover,
			.g5core-mobile-header-wrapper .g5ere__login-button a:hover,
			.g5core-mobile-header-wrapper .g5ere__btn-my-favourite:hover,
			.g5core-mobile-header-wrapper .g5core-header-customize .g5core-hc-button-add-listing .btn-listing:hover{
				color: $header_mobile_text_hover_color;
			}
			
			.g5core-mobile-header-wrapper .g5core-header-customize .g5core-hc-button-add-listing .btn-listing {
			  border-color: {$header_mobile_border_color};
			}
			
			
			.sticky-area-wrap.sticky .g5core-mobile-header-wrapper.sticky-area .g5ere__user-dropdown .g5ere__user-display-name:hover,
			.sticky-area-wrap.sticky .g5core-mobile-header-wrapper.sticky-area .g5ere__login-button a:hover,
			.sticky-area-wrap.sticky .g5core-mobile-header-wrapper.sticky-area .g5ere__btn-my-favourite:hover,
			.sticky-area-wrap.sticky .g5core-mobile-header-wrapper.sticky-area .g5core-header-customize .g5core-hc-button-add-listing .btn-listing:hover{
				color: $header_mobile_sticky_text_hover_color;
			}

			.sticky-area-wrap.sticky .g5core-mobile-header-wrapper.sticky-area .g5core-header-customize .g5core-hc-button-add-listing .btn-listing {
						  border-color: {$header_mobile_sticky_border_color};
			}
CSS;

		}

	}
}
