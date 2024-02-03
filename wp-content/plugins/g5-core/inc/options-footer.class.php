<?php
if ( ! class_exists( 'G5Core_Options_Abstract', false ) ) {
	G5CORE()->load_file(G5CORE()->plugin_dir('inc/abstract/options.class.php'));
}
if (!class_exists('G5Core_Options_Footer')) {
	class G5Core_Options_Footer extends G5Core_Options_Abstract {
		//protected $option_name = 'g5core_footer_options';

		private static $_instance;
		public static function getInstance() {
			if (self::$_instance == NULL) { self::$_instance = new self(); }
			return self::$_instance;
		}

		public function __construct() {
			$this->option_name = G5Core_Config_Footer_Options::getInstance()->options_name();
		}

		public function init_default() {
			return array(
				'footer_enable' => 'on',
				'footer_layout' => 'boxed',
				'footer_content_block' => '',
				'footer_fixed_enable' => 'off',
			);
		}
	}
}