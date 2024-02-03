<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if (! class_exists('HOMEID_ELEMENTOR_PROPERTY')) {
	class HOMEID_ELEMENTOR_PROPERTY {
		private static $_instance;

		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function init() {
			add_filter('g5ere_elementor_property_skins', array($this,'change_property_skins'));

			add_filter('g5ere_elementor_property_list_skins',array($this,'change_property_list_skins'));

			add_filter( 'g5ere_elementor_property_layout', array( $this, 'change_property_layout' ) );

		}

		public function change_property_layout( $config ) {
			return wp_parse_args( array(
				'creative' => array(
					'label' => esc_html__( 'Creative', 'homeid' ),
					'priority' => 21,
				),
				'metro'    => array(
					'label' => esc_html__( 'Metro 01', 'homeid' ),
					'priority' => 22,
				),
				'metro-2'    => array(
					'label' => esc_html__( 'Metro 02', 'homeid' ),
					'priority' => 23,
				),
				'metro-3'    => array(
					'label' => esc_html__( 'Metro 03', 'homeid' ),
					'priority' => 24,
				),
			), $config );
		}


		public function change_property_skins($layout) {
			return wp_parse_args( array(
				'skin-02' => array(
					'label' => esc_html__( 'Skin 02', 'homeid' ),
					'priority' => 11,
				),
				'skin-03' => array(
					'label' => esc_html__( 'Skin 03', 'homeid' ),
					'priority' => 12,
				),
				'skin-04' => array(
					'label' => esc_html__( 'Skin 04', 'homeid' ),
					'priority' => 13,
				),
				'skin-05' => array(
					'label' => esc_html__( 'Skin 05', 'homeid' ),
					'priority' => 14,
				),
				'skin-06' => array(
					'label' => esc_html__( 'Skin 06', 'homeid' ),
					'priority' => 15,
				),
				'skin-07' => array(
					'label' => esc_html__( 'Skin 07', 'homeid' ),
					'priority' => 16,
				),
				'skin-08' => array(
					'label' => esc_html__( 'Skin 08', 'homeid' ),
					'priority' => 17,
				),
				'skin-09' => array(
					'label' => esc_html__( 'Skin 09', 'homeid' ),
					'priority' => 18,
				),
				'skin-10' => array(
					'label' => esc_html__( 'Skin 10', 'homeid' ),
					'priority' => 19,
				),
			), $layout );
		}

		public function change_property_list_skins($layout) {
			return wp_parse_args( array(
				'skin-list-02' => array(
					'label' => esc_html__( 'Skin 02', 'homeid' ),
					'priority' => 11,
				),
				'skin-list-03' => array(
					'label' => esc_html__( 'Skin 03', 'homeid' ),
					'priority' => 12,
				),
				'skin-list-04' => array(
					'label' => esc_html__( 'Skin 04', 'homeid' ),
					'priority' => 13,
				),
			), $layout );
		}
	}
}