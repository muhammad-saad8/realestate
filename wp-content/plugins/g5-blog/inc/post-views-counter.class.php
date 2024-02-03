<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! class_exists( 'G5Blog_Post_Views_Counter' ) ) {
	class G5Blog_Post_Views_Counter {
		private static $_instance;

		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init() {
			add_filter('pvc_shortcode_filter_hook',array($this,'change_pvc_shortcode_filter_hook'));
		}

		public function change_pvc_shortcode_filter_hook() {
			return 'manual';
		}
	}
}