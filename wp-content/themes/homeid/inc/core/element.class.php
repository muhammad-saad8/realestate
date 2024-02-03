<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! class_exists( 'HOMEID_CORE_ELEMENT' ) ) {
	class HOMEID_CORE_ELEMENT {
		private static $_instance;

		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init() {
			add_filter( 'g5element_settings_gallery_layout', array( $this, 'change_gallery_layout' ) );

		}

		public function change_gallery_layout( $layout ) {
			return wp_parse_args( array(
				'metro-4' => array(
					'label' => esc_html__( 'Metro 04', 'homeid' ),
					'img'   => get_parent_theme_file_uri( 'assets/images/gallery-layout-metro-04.png' ),
				),
				'metro-5' => array(
					'label' => esc_html__( 'Metro 05', 'homeid' ),
					'img'   => get_parent_theme_file_uri( 'assets/images/gallery-layout-metro-05.png' ),
				),
			), $layout );
		}
	}
}