<?php
if ( ! class_exists( 'G5Core_Options_Abstract', false ) ) {
	G5CORE()->load_file( G5CORE()->plugin_dir( 'inc/abstract/options.class.php' ) );
}
if ( ! class_exists( 'G5Core_Options_Color' ) ) {
	class G5Core_Options_Color extends G5Core_Options_Abstract {
		//protected $option_name = G5CORE()->options_color_name();

		private static $_instance;

		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function __construct() {
			$this->option_name = G5Core_Config_Color_Options::getInstance()->options_name();
		}

		public function init_default() {
			return array(
				'site_background_color'   => array(
					'background_color' => '#fff'
				),
				'site_text_color'         => '#777',
				'accent_color'            => '#d7aa82',
				'link_color'              => '#0073aa',
				'border_color'            => '#eee',
				'heading_color'           => '#222',
				'caption_color'           => '#ababab',
				'placeholder_color'       => '#b6b6b6',
				'primary_color'           => '#d64c35',
				'secondary_color'         => '#35b0d6',
				'dark_color'              => '#222',
				'light_color'             => '#fafafa',
				'gray_color'              => '#7b7b7b',
			);
		}
	}
}