<?php
if ( ! class_exists( 'G5Core_Options_Abstract', false ) ) {
	G5CORE()->load_file( G5CORE()->plugin_dir( 'inc/abstract/options.class.php' ) );
}
if ( ! class_exists( 'G5Core_Options_Header' ) ) {
	class G5Core_Options_Header extends G5Core_Options_Abstract {
		//protected $option_name = 'g5core_header_options';

		private static $_instance;

		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function __construct() {
			$this->option_name = G5Core_Config_Header_Options::getInstance()->options_name();
		}

		public function init_default() {
			return array(
				'header_enable'                          => 'on',
				'header_responsive_breakpoint'           => '991',
				'header_style'                           => 'layout-01',
				'header_layout'                          => 'boxed',
				'header_sticky'                          => '',
				'header_float'                           => 'off',
				'header_border_enable'                   => 'off',
				'header_css_classes'                     => '',
				'top_bar_desktop_enable'                 => 'off',
				'top_bar_desktop_items'                  => G5CORE()->settings()->top_bar_customize_items(),
				'top_bar_desktop_items_custom_html_1'    => '',
				'top_bar_desktop_items_custom_html_2'    => '',
				'top_bar_desktop_border_bottom'          => 'off',
				'logo'                                   =>
					array(
						'id'  => 0,
						'url' => '',
					),
				'logo_sticky'                            =>
					array(
						'id'  => 0,
						'url' => '',
					),
				'logo_max_height'                        =>
					array(
						'width'  => '',
						'height' => '',
					),
                'logo_sticky_max_height'                        =>
                    array(
                        'width'  => '',
                        'height' => '',
                    ),
				'before_logo_customize'                  =>
					array(),
				'before_logo_customize_custom_html'      => '',
				'after_logo_customize'                   =>
					array(),
				'after_logo_customize_custom_html'       => '',
				'navigation_border_enable'               => 'off',
				'menu_spacing'                           =>
					array(
						'width'  => '',
						'height' => '',
					),
				'submenu_transition'                     => 'x-fadeInUp',
				'before_menu_customize'                  =>
					array(),
				'before_menu_customize_custom_html'      => '',
				'after_menu_customize'                   =>
					array(),
				'after_menu_customize_custom_html'       => '',
				'logo_font'                              =>
					array(
						'font_family'    => 'Libre Baskerville',
						'font_size'      => '2rem',
						'font_weight'    => '700',
						'font_style'     => '',
						'align'          => '',
						'transform'      => 'none',
						'line_height'    => '',
						'letter_spacing' => '0',
					),
				'top_bar_font'                           =>
					array(
						'font_family'    => 'Nunito Sans',
						'font_size'      => '0.75rem',
						'font_weight'    => '700',
						'font_style'     => '',
						'transform'      => 'uppercase',
						'line_height'    => '',
						'letter_spacing' => '0.03',
					),
				'menu_font'                              =>
					array(
						'font_family'    => 'Nunito Sans',
						'font_size'      => '0.875rem',
						'font_weight'    => '700',
						'font_style'     => '',
						'transform'      => 'uppercase',
						'line_height'    => '',
						'letter_spacing' => '0.03',
					),
				'sub_menu_font'                          =>
					array(
						'font_family'    => 'Nunito Sans',
						'font_size'      => '0.625rem',
						'font_weight'    => '700',
						'font_style'     => '',
						'transform'      => 'uppercase',
						'line_height'    => '',
						'letter_spacing' => '0.03',
					),
				'header_scheme'                          => 'light',
				'header_background_color'                => '#fff',
				'header_text_color'                      => '#1b1b1b',
				'header_text_hover_color'                => '#999',
				'header_border_color'                    => '#eee',
				'header_disable_color'                   => '#888',
				'header_sticky_scheme'                   => 'light',
				'header_sticky_background_color'         => '#fff',
				'header_sticky_text_color'               => '#1b1b1b',
				'header_sticky_text_hover_color'         => '#999',
				'header_sticky_border_color'             => '#eee',
				'header_sticky_disable_color'            => '#888',
				'top_bar_scheme'                         => 'light',
				'top_bar_background_color'               => '#f6f6f6',
				'top_bar_text_color'                     => '#1b1b1b',
				'top_bar_text_hover_color'               => '#999',
				'top_bar_border_color'                   => '#eee',
				'navigation_scheme'                      => 'light',
				'navigation_background_color'            => '#fff',
				'navigation_text_color'                  => '#1b1b1b',
				'navigation_text_hover_color'            => '#999',
				'navigation_border_color'                => '#eee',
				'navigation_disable_color'               => '#888',
				'submenu_scheme'                         => 'light',
				'submenu_background_color'               => '#fff',
				'submenu_heading_color'                  => '#222',
				'submenu_text_color'                     => '#1b1b1b',
				'submenu_item_bg_hover_color'            => 'transparent',
				'submenu_text_hover_color'               => '#999',
				'submenu_border_color'                   => '#eee',
				'header_mobile_top_bar_color_scheme'     => 'light',
				'header_mobile_top_bar_background_color' => '#f6f6f6',
				'header_mobile_top_bar_text_color'       => '#1b1b1b',
				'header_mobile_top_bar_text_hover_color' => '#999',
				'header_mobile_top_bar_border_color'     => '#eee',
				'header_mobile_color_scheme'             => 'light',
				'header_mobile_background_color'         => '#fff',
				'header_mobile_text_color'               => '#1b1b1b',
				'header_mobile_text_hover_color'         => '#999',
				'header_mobile_border_color'             => '#eee',
				'header_mobile_sticky_color_scheme'      => 'light',
				'header_mobile_sticky_background_color'  => '#fff',
				'header_mobile_sticky_text_color'        => '#1b1b1b',
				'header_mobile_sticky_text_hover_color'  => '#999',
				'header_mobile_sticky_border_color'      => '#eee',
				'mobile_header_style'                    => 'layout-01',
				'mobile_navigation_skin'                 => 'dark',
				'mobile_header_float_enable'             => 'off',
				'mobile_header_sticky'                   => '',
				'mobile_logo'                            =>
					array(
						'id'  => 0,
						'url' => '',
					),
				'mobile_sticky_logo'                     =>
					array(
						'id'  => 0,
						'url' => '',
					),
				'mobile_logo_max_height'                 =>
					array(
						'width'  => '',
						'height' => '',
					),
                'mobile_sticky_logo_max_height'                 =>
                    array(
                        'width'  => '',
                        'height' => '',
                    ),
				'top_bar_mobile_enable'                  => 'off',
				'top_bar_mobile_border_bottom'           => 'off',
				'top_bar_mobile_items'                   => G5CORE()->settings()->top_bar_customize_items(),
				'top_bar_mobile_items_custom_html_1'     => '',
				'top_bar_mobile_items_custom_html_2'     => '',
				'header_mobile_customize'                =>
					array(
						'search-button' => 'search-button',
					),
				'header_mobile_customize_custom_html'    => '',
				'mobile_header_css_classes'              => '',
			);
		}
	}
}