<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if (!class_exists('HOMEID_CORE')) {
	class HOMEID_CORE {
		private static $_instance;

		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function __construct() {
			spl_autoload_register(array($this, 'autoload'));
			add_action('g5blog_init',array($this->blog(),'init'));
			add_action('g5element_init',array($this->element(),'init'));
			add_action('g5ere_init',array($this->ere(),'init'));

			add_filter('g5core_theme_info',array($this,'change_theme_info'));

			$this->init();
		}

		public function init() {
			$this->loadFile($this->themeDir('inc/core/template-hooks.php'));
		}


		public function autoload($class) {
			$file_name = preg_replace('/^HOMEID_CORE_/', '', $class);
			if ($file_name !== $class) {
				$file_name = strtolower($file_name);
				$file_name = str_replace('_', '-', $file_name);
				$this->loadFile($this->themeDir("inc/core/{$file_name}.class.php"));
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

		public function change_theme_info($info) {
			return wp_parse_args(array(
				'docs'    => 'https://docs.g5plus.net/homeid/',
				'video_tutorials_url' => 'https://www.youtube.com/watch?v=zwHtJEVDhcA&list=PL_DzVbdOfv7FbYcx55t-9SWeK35HWkZGz',
				'changelog' => 'https://homeid.g5plus.net/changelog.html',
			),$info);
		}

		/**
		 * @return HOMEID_CORE_BLOG
		 */
		public function blog() {
			return HOMEID_CORE_BLOG::getInstance();
		}

		/**
		 * @return HOMEID_CORE_ELEMENT
		 */
		public function element() {
			return HOMEID_CORE_ELEMENT::getInstance();
		}


		/**
		 * @return HOMEID_CORE_ERE
		 */
		public function ere() {
			return HOMEID_CORE_ERE::getInstance();
		}



	}
	function HOMEID_CORE() {
		return HOMEID_CORE::getInstance();
	}
	HOMEID_CORE()->init();
}