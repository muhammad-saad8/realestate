<?php
if ( ! class_exists( 'G5Core_Options_Abstract', false ) ) {
	G5CORE()->load_file(G5CORE()->plugin_dir('inc/abstract/options.class.php'));
}
if (!class_exists('G5Core_Options_Page_Title')) {
	class G5Core_Options_Page_Title extends G5Core_Options_Abstract {
		//protected $option_name = 'g5core_page_title_options';

		private static $_instance;
		public static function getInstance() {
			if (self::$_instance == NULL) { self::$_instance = new self(); }
			return self::$_instance;
		}

		public function __construct() {
			$this->option_name = G5Core_Config_Page_Title_Options::getInstance()->options_name();
		}

		public function init_default() {
			return array (
				'page_title_enable' => 'on',
				'page_title_content_block' => '',
				'page_title_layout' => 'boxed',
				'breadcrumb_enable' => 'on',
				'breadcrumb_show_categories' => 'on',
				'breadcrumb_show_post_type_archive' => '',
				'post_single__page_title_enable' => 'off',
				'post_single__page_title_content_block' => '',
				'post_single__breadcrumb_enable' => '',
				'post_archive__page_title_enable' => '',
				'post_archive__page_title_content_block' => '',
				'post_archive__breadcrumb_enable' => '',
			);
		}
	}
}