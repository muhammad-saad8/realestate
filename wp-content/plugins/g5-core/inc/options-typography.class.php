<?php
if ( ! class_exists( 'G5Core_Options_Abstract', false ) ) {
	G5CORE()->load_file( G5CORE()->plugin_dir( 'inc/abstract/options.class.php' ) );
}
if ( ! class_exists( 'G5Core_Options_Typography' ) ) {
	class G5Core_Options_Typography extends G5Core_Options_Abstract {
		//protected $option_name = 'g5core_typography_options';

		private static $_instance;

		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function __construct() {
			$this->option_name = G5Core_Config_Typography_Options::getInstance()->options_name();
		}

		public function init_default() {
			return array (
				'body_font' =>
					array (
						'font_family' => 'Nunito Sans',
						'font_size' => '1rem',
						'font_weight' => '400',
						'font_style' => '',
						'align' => '',
						'transform' => 'none',
						'line_height' => '',
						'letter_spacing' => '0',
						'color' => '',
					),
				'primary_font' =>
					array (
						'font_family' => 'Libre Baskerville'
					),
				'h1_font' =>
					array (
						'font_family' => 'Libre Baskerville',
						'font_size' => '2.5rem',
						'font_weight' => '700',
						'font_style' => '',
						'align' => '',
						'transform' => 'none',
						'line_height' => '',
						'letter_spacing' => '0',
						'color' => '',
					),
				'h2_font' =>
					array (
						'font_family' => 'Libre Baskerville',
						'font_size' => '2rem',
						'font_weight' => '700',
						'font_style' => '',
						'align' => '',
						'transform' => 'none',
						'line_height' => '',
						'letter_spacing' => '0',
						'color' => '',
					),
				'h3_font' =>
					array (
						'font_family' => 'Libre Baskerville',
						'font_size' => '1.75rem',
						'font_weight' => '700',
						'font_style' => '',
						'align' => '',
						'transform' => 'none',
						'line_height' => '',
						'letter_spacing' => '0',
						'color' => '',
					),
				'h4_font' =>
					array (
						'font_family' => 'Libre Baskerville',
						'font_size' => '1.5rem',
						'font_weight' => '700',
						'font_style' => '',
						'align' => '',
						'transform' => 'none',
						'line_height' => '',
						'letter_spacing' => '0',
						'color' => '',
					),
				'h5_font' =>
					array (
						'font_family' => 'Libre Baskerville',
						'font_size' => '1.25rem',
						'font_weight' => '700',
						'font_style' => '',
						'align' => '',
						'transform' => 'none',
						'line_height' => '',
						'letter_spacing' => '0',
						'color' => '',
					),
				'h6_font' =>
					array (
						'font_family' => 'Libre Baskerville',
						'font_size' => '1rem',
						'font_weight' => '700',
						'font_style' => '',
						'align' => '',
						'transform' => 'none',
						'line_height' => '',
						'letter_spacing' => '0',
						'color' => '',
					),
				'display_1' =>
					array (
						'font_family' => 'Libre Baskerville',
						'font_size' => '4rem',
						'font_weight' => '700',
						'font_style' => '',
						'align' => '',
						'transform' => 'none',
						'line_height' => '',
						'letter_spacing' => '0',
						'color' => '',
					),
				'display_2' =>
					array (
						'font_family' => 'Libre Baskerville',
						'font_size' => '3rem',
						'font_weight' => '700',
						'font_style' => '',
						'align' => '',
						'transform' => 'none',
						'line_height' => '',
						'letter_spacing' => '0',
						'color' => '',
					),
				'display_3' =>
					array (
						'font_family' => 'Libre Baskerville',
						'font_size' => '2rem',
						'font_weight' => '700',
						'font_style' => '',
						'align' => '',
						'transform' => 'none',
						'line_height' => '',
						'letter_spacing' => '0',
						'color' => '',
					),
				'display_4' =>
					array (
						'font_family' => 'Libre Baskerville',
						'font_size' => '1rem',
						'font_weight' => '700',
						'font_style' => '',
						'align' => '',
						'transform' => 'none',
						'line_height' => '',
						'letter_spacing' => '0',
						'color' => '',
					),
			);
		}
	}
}