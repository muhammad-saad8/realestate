<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'G5Core_Setup' ) ) {
	class G5Core_Setup {
		private static $_instance;

		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init() {
			add_action( 'init', array( $this, 'init_setup_data' ), 5);
		}

		public function init_setup_data() {
			// Font default
			add_filter( 'gsf_theme_font_default', array( $this, 'font_default' ), 5 );
		}

		public function font_default($fonts) {
			return apply_filters('g5core_theme_font_default', array(
				array(
					'family' => "Nunito Sans",
					'kind'   => 'webfonts#webfont'
				),
				array(
					'family' => "Libre Baskerville",
					'kind'   => 'webfonts#webfont'
				),
			));
		}
	}
}