<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if ( ! class_exists( 'G5Core_Fields' ) ) {
	class G5Core_Fields {
		/*
		 * loader instances
		 */
		private static $_instance;

		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function get_config_toggle( $args = array(), $inherit = false ) {

			if ( ! $inherit ) {
				$defaults = array(
					'type' => 'switch'
				);
			} else {
				$defaults = array(
					'type'    => 'button_set',
					'options' => G5CORE()->settings()->get_toggle( $inherit ),
					'default' => '',
				);
			}
			$defaults = wp_parse_args( $args, $defaults );

			return $defaults;
		}

		public function get_config_site_layout( $args = array(), $inherit = false ) {
			$defaults = array(
				'title'   => esc_html__( 'Site Layout', 'g5-core' ),
				'type'    => 'image_set',
				'options' => G5CORE()->settings()->get_site_layout( $inherit ),
				'default' => $inherit ? '' : 'right'
			);

			$defaults = wp_parse_args( $args, $defaults );

			return $defaults;
		}

		public function get_config_sidebar( $args = array() ) {
			$defaults = array(
				'title'       => esc_html__( 'Sidebar', 'g5-core' ),
				'type'        => 'selectize',
				'placeholder' => esc_html__( 'Select Sidebar', 'g5-core' ),
				'data'        => 'sidebar',
				'allow_clear' => true,
				'default'     => ''
			);

			$defaults = wp_parse_args( $args, $defaults );

			return $defaults;
		}
	}
}