<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (!class_exists('G5Element_Vc_Params')) {
	class G5Element_Vc_Params {
		private static $_instance;
		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function init() {
			//add_filter( 'vc_map_get_param_defaults', array($this, 'vc_param_typography_param_defaults'), 10, 2 );
			add_action('vc_after_init', array($this, 'custom_params'));
        }

		public function custom_params()
		{
			G5ELEMENT()->load_file(G5ELEMENT()->plugin_dir('vc-params/button-set/button-set.php'));
			G5ELEMENT()->load_file(G5ELEMENT()->plugin_dir('vc-params/datetime-picker/datetime-picker.php'));
			G5ELEMENT()->load_file(G5ELEMENT()->plugin_dir('vc-params/icon-picker/icon-picker.php'));
			G5ELEMENT()->load_file(G5ELEMENT()->plugin_dir('vc-params/image-set/image-set.php'));
			G5ELEMENT()->load_file(G5ELEMENT()->plugin_dir('vc-params/number/number.php'));
			G5ELEMENT()->load_file(G5ELEMENT()->plugin_dir('vc-params/number-and-unit/number-and-unit.php'));
			G5ELEMENT()->load_file(G5ELEMENT()->plugin_dir('vc-params/number-responsive/number-responsive.php'));
			G5ELEMENT()->load_file(G5ELEMENT()->plugin_dir('vc-params/responsive/responsive.php'));
			G5ELEMENT()->load_file(G5ELEMENT()->plugin_dir('vc-params/selectize/selectize.php'));
			G5ELEMENT()->load_file(G5ELEMENT()->plugin_dir('vc-params/slider/slider.php'));
			G5ELEMENT()->load_file(G5ELEMENT()->plugin_dir('vc-params/switch/switch.php'));
			G5ELEMENT()->load_file(G5ELEMENT()->plugin_dir('vc-params/typography/typography.php'));
			G5ELEMENT()->load_file(G5ELEMENT()->plugin_dir('vc-params/color/color.php'));
		}

		public function get_typography_default($std = array()) {
			if (!is_array($std)) {
				$std = array();
			}
			$std = wp_parse_args( $std, array(
				'font_family'    => '',
				'font_weight'    => '',
				'font_style'     => '',
				'font_size_lg'   => '',
				'font_size_md'   => '',
				'font_size_sm'   => '',
				'font_size_xs'   => '',
				'align'          => '',
				'text_transform' => '',
				'line_height'    => '',
				'letter_spacing' => '',
				'color'          => '',
				'hover_color'    => ''
			));
			return rawurlencode( wp_json_encode( $std ) );
		}

		/**
		 * @param $value
		 * @param $param
		 * @return string
		 */
		public function vc_param_typography_param_defaults( $value, $param ) {
			if ( 'g5element_typography' === $param['type']) {
				$value = json_decode( urldecode($value), true );
				if (!is_array($value)) {
					$value = array();
				}
				$value = wp_parse_args( $value, array(
					'font_family'    => '',
					'font_weight'    => '',
					'font_style'     => '',
					'font_size_lg'   => '',
					'font_size_md'   => '',
					'font_size_sm'   => '',
					'font_size_xs'   => '',
					'align'          => '',
					'text_transform' => '',
					'line_height'    => '',
					'letter_spacing' => '',
					'color'          => '',
					'hover_color'    => ''
				));
				$value = rawurlencode( wp_json_encode( $value ) );
			}
			return $value;
		}
	}
}