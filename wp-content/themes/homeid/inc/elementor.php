<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if (!class_exists('HOMEID_ELEMENTOR')) {
	class HOMEID_ELEMENTOR {
		private static $_instance;

		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}
		public function __construct() {
			spl_autoload_register(array($this, 'autoload'));
		}

		public function init(){
			add_action('g5blog_init',array($this->blog(),'init'));
			add_action('g5ere_init',array($this->ere(),'init'));
		}

		public function autoload($class) {
			$file_name = preg_replace('/^HOMEID_ELEMENTOR_/', '', $class);
			if ($file_name !== $class) {
				$file_name = strtolower($file_name);
				$file_name = str_replace('_', '-', $file_name);
				$this->loadFile($this->themeDir("inc/elementor/{$file_name}.class.php"));
			}
		}

		public function loadFile($path) {
			if ( $path && is_readable($path) ) {
				include_once($path);
				return true;
			}
			return false;
		}

		public function themeDir($path = '') {
			return trailingslashit(get_template_directory()) . $path;
		}

		/**
		 * @return HOMEID_ELEMENTOR_BLOG
		 */
		public function blog() {
			return HOMEID_ELEMENTOR_BLOG::getInstance();
		}

		/**
		 * @return HOMEID_ELEMENTOR_ERE
		 */
		public function ere() {
			return HOMEID_ELEMENTOR_ERE::getInstance();
		}
	}
	function HOMEID_ELEMENTOR() {
		return HOMEID_ELEMENTOR::getInstance();
	}
	HOMEID_ELEMENTOR()->init();
}