<?php
if ( ! class_exists( 'G5Core_Options_Abstract', false ) ) {
    G5CORE()->load_file(G5CORE()->plugin_dir('inc/abstract/options.class.php'));
}
if (!class_exists('G5ERE_Options')) {
	class G5ERE_Options extends G5Core_Options_Abstract {
		private static $_instance;
		public static function getInstance() {
			if (self::$_instance == NULL) { self::$_instance = new self(); }
			return self::$_instance;
		}

		public function __construct() {
			$this->option_name = G5ERE()->config_options()->options_name();
		}

		public function init_default() {
			return array (
            );
		}
	}
}