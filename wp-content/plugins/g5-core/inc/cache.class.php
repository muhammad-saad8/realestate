<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (!class_exists('G5Core_Cache')) {
	class G5Core_Cache {
		private static $_instance;
		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function init() {
			add_action( 'the_post', array( $this,'flush_cache_listing'));
		}

		private $_global_cache = array();
		public function set($key, $value) {
			$this->_global_cache[$key] = $value;
		}
		public function get($key, $default = null) {
			return isset($this->_global_cache[$key]) ? $this->_global_cache[$key] : $default;
		}
		public function exists($key) {
			return isset($this->_global_cache[$key]);
		}
		public function clear() {
			$this->_global_cache = array();
		}


        public function get_cache_listing( $key, $default = null ) {
            global $g5core_listing_cache;
            return isset( $g5core_listing_cache[ $key ] ) ? $g5core_listing_cache[ $key ] : $default;
        }

        public function set_cache_listing( $key, $data ) {
            global $g5core_listing_cache;
            $g5core_listing_cache[ $key ] = $data;
        }

        public function flush_cache_listing() {
            global $g5core_listing_cache;
            $g5core_listing_cache = null;
        }
	}
}