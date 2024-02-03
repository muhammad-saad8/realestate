<?php
if ( ! class_exists( 'G5Core_Options_Abstract', false ) ) {
	G5CORE()->load_file(G5CORE()->plugin_dir('inc/abstract/options.class.php'));
}
if (!class_exists('G5Core_Options_Layout')) {
	class G5Core_Options_Layout extends G5Core_Options_Abstract {
		//protected $option_name = 'g5core_layout_options';

		private static $_instance;
		public static function getInstance() {
			if (self::$_instance == NULL) { self::$_instance = new self(); }
			return self::$_instance;
		}

		public function __construct() {
			$this->option_name = G5Core_Config_Layout_Options::getInstance()->options_name();
		}

		public function init_default() {
			return array (
				'site_style' => 'wide',
				'boxed_background_color' =>
					array (
						'background_color' => '#eee',
						'background_image_id' => 0,
						'background_image_url' => '',
						'background_repeat' => 'repeat',
						'background_size' => 'contain',
						'background_position' => 'center center',
						'background_attachment' => 'scroll',
					),
				'bordered_color' => '#eee',
				'bordered_width' =>
					array (
						'width' => 30,
						'height' => '',
					),
				'site_layout' => 'right',
				'sidebar' => 'sidebar-blog',
				'content_padding' =>
					array (
						'left' => '',
						'right' => '',
						'top' => 50,
						'bottom' => 50,
					),
				'sidebar_sticky_enable' => '',
				'mobile_sidebar_enable' => 'on',
				'pages_single__site_layout' => '',
				'pages_single__sidebar' => '',
				'pages_single__content_padding' =>
					array (
						'left' => '',
						'right' => '',
						'top' => '',
						'bottom' => '',
					),
				'post_single__site_layout' => '',
				'post_single__sidebar' => '',
				'post_single__content_padding' =>
					array (
						'left' => '',
						'right' => '',
						'top' => '',
						'bottom' => '',
					),
				'post_archive__site_layout' => '',
				'post_archive__sidebar' => '',
				'post_archive__content_padding' =>
					array (
						'left' => '',
						'right' => '',
						'top' => '',
						'bottom' => '',
					),
			);
		}
	}
}