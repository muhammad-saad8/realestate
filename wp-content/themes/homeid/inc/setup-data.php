<?php
add_filter('g5core_theme_font_default', 'homeid_font_default');
function homeid_font_default()
{
	return array(
		array(
			'family'   => 'Poppins',
			'kind'     => 'webfonts#webfont',
			'variants' => array(
				"400italic",
				"400",
				"500italic",
				"500",
				"600italic",
				"600",
				"700italic",
				"700",
				"900italic",
				"900",
			),
		)
	);
}



if (!class_exists('HOMEID_SETUP_DATA')) {
	class HOMEID_SETUP_DATA {
		private static $_instance;

		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init() {
			add_filter('g5core_default_options_homeid_typography_options', array($this, 'change_default_options_g5core_typography_options'));

			add_filter('g5core_default_options_homeid_color_options', array($this, 'change_default_options_g5core_color_options'));

			add_filter( 'g5core_default_options_homeid_layout_options', array($this, 'change_default_options_g5core_layout_options') );

			add_filter('g5core_default_options_homeid_header_options', array($this, 'change_default_options_g5core_header_options'));

			add_filter('g5core_header_options', array($this, 'change_g5core_header_options_config'), 20);

			add_filter('g5core_color_options_name',array($this,'change_g5core_color_options_name'));

			add_filter('g5core_header_options_name', array($this,'change_g5core_header_options_name'));

			add_filter('g5core_layout_options_name', array($this,'change_g5core_layout_options_name'));

			add_filter('g5core_typography_options_name', array($this,'change_g5core_typography_options_name'));

			add_filter('g5core_options_name', array($this,'change_g5core_options_name'));

			add_filter('gid_options_key_change_theme_options',array($this,'change_options_key_change_theme_options'));

			add_filter('g5dev_option_key_for_setting_file',array($this,'change_option_key_for_setting_file'));

		}

		public function change_option_key_for_setting_file($options_key) {
			return wp_parse_args(array(
				'homeid_%' => 'like',
			),$options_key);
		}

		public function change_g5core_options_name() {
			return 'homeid_options';
		}

		public function change_g5core_color_options_name() {
			return 'homeid_color_options';
		}

		public function change_g5core_header_options_name() {
			return 'homeid_header_options';
		}

		public function change_g5core_layout_options_name() {
			return 'homeid_layout_options';
		}

		public function change_g5core_typography_options_name() {
			return 'homeid_typography_options';
		}

		public function change_options_key_change_theme_options($option_keys) {
			$option_keys['homeid_%'] = 'like';
			return $option_keys;
		}


		public function change_default_options_g5core_typography_options($defaults) {
			return wp_parse_args(array(
				'body_font' =>
					array(
						'font_family' => 'Poppins',
						'font_size'   => '14px',
						'font_weight' => '400',
						'transform' => 'none',
						'line_height' => 1.86
					),
				'primary_font' => array(
					'font_family' => 'Poppins'
				),
				'h1_font' =>
					array (
						'font_family' => 'Poppins',
						'font_size' => '48px',
						'font_weight' => '500',
						'transform'      => 'none',
						'letter_spacing' => '0',
						'line_height'    => 1.2
					),
				'h2_font' =>
					array (
						'font_family' => 'Poppins',
						'font_size' => '44px',
						'font_weight' => '500',
						'transform'      => 'none',
						'letter_spacing' => '0',
						'line_height'    => 1.2
					),
				'h3_font' =>
					array (
						'font_family' => 'Poppins',
						'font_size' => '36px',
						'font_weight' => '500',
						'transform'      => 'none',
						'letter_spacing' => '0',
						'line_height'    => 1.2
					),
				'h4_font' =>
					array (
						'font_family' => 'Poppins',
						'font_size' => '24px',
						'font_weight' => '500',
						'transform'      => 'none',
						'letter_spacing' => '0',
						'line_height'    => 1.2
					),
				'h5_font' =>
					array (
						'font_family' => 'Poppins',
						'font_size' => '16px',
						'font_weight' => '500',
						'transform'      => 'none',
						'letter_spacing' => '0',
						'line_height'    => 1.2
					),
				'h6_font' =>
					array (
						'font_family' => 'Poppins',
						'font_size' => '14px',
						'font_weight' => '500',
						'transform'      => 'none',
						'letter_spacing' => '0',
						'line_height'    => 1.2
					),
				'display_1' => array(
					'font_family' => 'Poppins',
					'font_size' => '14px',
				),
				'display_2' => array(
					'font_family' => 'Poppins',
					'font_size' => '14px',
				),
				'display_3' => array(
					'font_family' => 'Poppins',
					'font_size' => '14px',
				),
				'display_4' => array(
					'font_family' => 'Poppins',
					'font_size' => '14px',
				),
			), $defaults);
		}

		public function change_default_options_g5core_color_options($defaults) {
			return wp_parse_args(array(
				'site_text_color'   => '#696969',
				'accent_color'      => '#0ec6d5',
				'link_color'        => '#0ec6d5',
				'border_color'      => '#eee',
				'heading_color'     => '#333',
				'caption_color'     => '#9b9b9b',
				'placeholder_color' => '#ababab',
				'primary_color'     => '#1e1d85',
				'secondary_color'   => '#eff6f7',
				'dark_color'        => '#333',
				'light_color'       => '#fafafa',
				'gray_color'        => '#8f8f8f',
			), $defaults);
		}

		public function change_default_options_g5core_layout_options($defaults) {
			return wp_parse_args(array(
				'content_padding' =>
					array (
						'left' => '',
						'right' => '',
						'top' => 80,
						'bottom' => 80,
					),
			),$defaults);
		}

		public function change_default_options_g5core_header_options($defaults)
		{

			$defaults = wp_parse_args( array(
				'logo_font' =>
					array(
						'font_family'    => 'Poppins',
						'font_size'      => '24px',
						'font_weight'    => '500',
						'font_style'     => '',
						'align'          => '',
						'transform'      => 'uppercase',
						'line_height'    => '',
						'letter_spacing' => '0',
					),

				'top_bar_font' =>
					array(
						'font_family'    => 'Poppins',
						'font_size'      => '12px',
						'font_weight'    => '500',
						'font_style'     => '',
						'transform'      => '',
						'line_height'    => '',
						'letter_spacing' => '',
					),

				'menu_font' =>
					array(
						'font_family'    => 'Poppins',
						'font_size'      => '14px',
						'font_weight'    => '500',
						'font_style'     => '',
						'transform'      => 'none',
						'line_height'    => '',
						'letter_spacing' => '',
					),

				'sub_menu_font' =>
					array(
						'font_family'    => 'Poppins',
						'font_size'      => '14px',
						'font_weight'    => '400',
						'font_style'     => '',
						'transform'      => 'none',
						'line_height'    => '',
						'letter_spacing' => '',
					),

				'header_background_color' => '#fff',
				'header_text_color'       => '#333',
				'header_text_hover_color' => '#0ec6d5',
				'header_border_color'     => '#eee',
				'header_disable_color'    => '#ababab',

				'header_sticky_background_color' => '#fff',
				'header_sticky_text_color'       => '#333',
				'header_sticky_text_hover_color' => '#0ec6d5',
				'header_sticky_border_color'     => '#eee',
				'header_sticky_disable_color'    => '#ababab',


				'navigation_background_color' => '#fff',
				'navigation_text_color'       => '#333',
				'navigation_text_hover_color' => '#333',
				'navigation_border_color'     => '#eee',
				'navigation_disable_color'    => '#ababab',

				'submenu_background_color'    => '#fff',
				'submenu_heading_color'       => '#333',
				'submenu_text_color'          => '#696969',
				'submenu_item_bg_hover_color' => '#fff',
				'submenu_text_hover_color'    => '#0ec6d5',
				'submenu_border_color'        => '#fff',


				'header_mobile_background_color' => '#fff',
				'header_mobile_text_color'       => '#333',
				'header_mobile_text_hover_color' => '#0ec6d5',
				'header_mobile_border_color'     => '#eee',

				'header_mobile_sticky_background_color' => '#fff',
				'header_mobile_sticky_text_color'       => '#333',
				'header_mobile_sticky_text_hover_color' => '#0ec6d5',
				'header_mobile_sticky_border_color'     => '#eee',

				'header_style' => 'layout-02',

			), $defaults );


			return $defaults;
		}

		public function change_g5core_header_options_config($options_config)
		{


			$options_config['section_color']['fields']['top_bar_group']['fields']['top_bar_scheme']['preset'] = array(
				array(
					'op'     => '=',
					'value'  => 'light',
					'fields' => array(
						array( 'top_bar_background_color', '#f6f6f6' ),
						array( 'top_bar_text_color', '#1b1b1b' ),
						array( 'top_bar_text_hover_color', '#999' ),
						array( 'top_bar_border_color', '#ececec' ),
					)
				),
				array(
					'op'     => '=',
					'value'  => 'dark',
					'fields' => array(
						array( 'top_bar_background_color', '#222' ),
						array( 'top_bar_text_color', '#fff' ),
						array( 'top_bar_text_hover_color', '#b20f0f' ),
						array( 'top_bar_border_color', '#353535' ),
					)
				),
			);

			$options_config['section_color']['fields']['header_desktop_color_group']['fields']['header_scheme']['preset'] = array(
				array(
					'op'     => '=',
					'value'  => 'light',
					'fields' => array(
						array( 'header_background_color', '#fff' ),
						array( 'header_text_color', '#333' ),
						array( 'header_text_hover_color', '#0ec6d5' ),
						array( 'header_border_color', '#eee' ),
						array( 'header_disable_color', '#ababab' ),
					)
				),
				array(
					'op'     => '=',
					'value'  => 'dark',
					'fields' => array(
						array( 'header_background_color', '#222222' ),
						array( 'header_text_color', '#ababab' ),
						array( 'header_text_hover_color', '#fff' ),
						array( 'header_border_color', 'rgba(255,255,255,0.2)' ),
						array( 'header_disable_color', '#8f8f8f' ),
					)
				),
			);

			$options_config['section_color']['fields']['header_desktop_color_group']['fields']['header_sticky_scheme']['preset'] = array(
				array(
					'op'     => '=',
					'value'  => 'light',
					'fields' => array(
						array( 'header_sticky_background_color', '#fff' ),
						array( 'header_sticky_text_color', '#333' ),
						array( 'header_sticky_text_hover_color', '#0ec6d5' ),
						array( 'header_sticky_border_color', '#eee' ),
						array( 'header_sticky_disable_color', '#ababab' ),
					)
				),
				array(
					'op'     => '=',
					'value'  => 'dark',
					'fields' => array(
						array( 'header_sticky_background_color', '#222222' ),
						array( 'header_sticky_text_color', '#ababab' ),
						array( 'header_sticky_text_hover_color', '#fff' ),
						array( 'header_sticky_border_color', 'rgba(255,255,255,0.2)' ),
						array( 'header_sticky_disable_color', '#8f8f8f' ),
					)
				),
			);

			$options_config['section_color']['fields']['menu_color_group']['fields']['submenu_scheme']['preset'] = array(
				array(
					'op'     => '=',
					'value'  => 'light',
					'fields' => array(
						array('submenu_background_color', '#fff'),
						array('submenu_heading_color', '#333'),
						array('submenu_text_color', '#696969'),
						array('submenu_item_bg_hover_color', '#fff'),
						array('submenu_text_hover_color', '#0ec6d5'),
						array('submenu_border_color', '#fff'),
					)
				),
				array(
					'op'     => '=',
					'value'  => 'dark',
					'fields' => array(
						array('submenu_background_color', '#222222'),
						array('submenu_heading_color', '#fff'),
						array('submenu_text_color', '#ababab'),
						array('submenu_item_bg_hover_color', '#222222'),
						array('submenu_text_hover_color', '#fff'),
						array('submenu_border_color', '#222222'),
					)
				),
			);

			$options_config['section_color']['fields']['navigation_color_group']['fields']['navigation_scheme']['preset'] = array(
				array(
					'op'     => '=',
					'value'  => 'light',
					'fields' => array(
						array('navigation_background_color', '#fff'),
						array('navigation_text_color', '#333'),
						array('navigation_text_hover_color', '#0ec6d5'),
						array('navigation_border_color', '#eee'),
						array('navigation_disable_color', '#ababab'),
					)
				),
				array(
					'op'     => '=',
					'value'  => 'dark',
					'fields' => array(
						array('navigation_background_color', '#222222'),
						array('navigation_text_color', '#ababab'),
						array('navigation_text_hover_color', '#b20f0f'),
						array('navigation_border_color', 'rgba(255,255,255,0.2)'),
						array('navigation_disable_color', '#8f8f8f'),
					)
				),
			);

			$options_config['section_color']['fields']['header_mobile_group']['fields']['header_mobile_color_scheme']['preset'] = array(
				array(
					'op'     => '=',
					'value'  => 'light',
					'fields' => array(
						array( 'header_mobile_background_color', '#fff' ),
						array( 'header_mobile_text_color', '#333' ),
						array( 'header_mobile_text_hover_color', '#0ec6d5' ),
						array( 'header_mobile_border_color', '#eee' ),
					)
				),
				array(
					'op'     => '=',
					'value'  => 'dark',
					'fields' => array(
						array( 'header_mobile_background_color', '#222222' ),
						array( 'header_mobile_text_color', '#ababab' ),
						array( 'header_mobile_text_hover_color', '#fff' ),
						array( 'header_mobile_border_color', 'rgba(255,255,255,0.2)' ),
					)
				),
			);

			$options_config['section_color']['fields']['header_mobile_group']['fields']['header_mobile_sticky_color_scheme']['preset'] = array(
				array(
					'op'     => '=',
					'value'  => 'light',
					'fields' => array(
						array( 'header_mobile_sticky_background_color', '#fff' ),
						array( 'header_mobile_sticky_text_color', '#333' ),
						array( 'header_mobile_sticky_text_hover_color', '#0ec6d5' ),
						array( 'header_mobile_sticky_border_color', '#eee' ),
					)
				),
				array(
					'op'     => '=',
					'value'  => 'dark',
					'fields' => array(
						array( 'header_mobile_sticky_background_color', '#222222' ),
						array( 'header_mobile_sticky_text_color', '#ababab' ),
						array( 'header_mobile_sticky_text_hover_color', '#fff' ),
						array( 'header_mobile_sticky_border_color', 'rgba(255,255,255,0.2)' ),
					)
				),
			);

			return $options_config;
		}
	}

	function HOMEID_SETUP_DATA() {
		return HOMEID_SETUP_DATA::getInstance();
	}

	HOMEID_SETUP_DATA()->init();
}




