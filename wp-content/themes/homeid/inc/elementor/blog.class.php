<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if (! class_exists('HOMEID_ELEMENTOR_BLOG')) {
	class HOMEID_ELEMENTOR_BLOG {
		private static $_instance;

		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function init() {
			add_filter('g5blog_elementor_post_layout',array($this,'change_post_layout'));

			add_filter('g5blog_elementor_post_slider_layout',array($this,'change_post_slider_layout'));
		}

		public function change_post_layout($layout) {
			unset($layout['masonry']);
			return wp_parse_args(array(
				'grid-2' => array(
					'label' => esc_html__('Grid 2', 'homeid'),
					'priority' => 31,
				),
				'grid-3' => array(
					'label' => esc_html__('Grid 3', 'homeid'),
					'priority' => 32,
				),
				'grid-4' => array(
					'label' => esc_html__('Grid 4', 'homeid'),
					'priority' => 33,
				),
				'medium-image-2' => array(
					'label' => esc_html__('Medium Image 2', 'homeid'),
					'priority' => 21,
				),
				'list' => array(
					'label' => esc_html__('List', 'homeid'),
					'priority' => 50,
				),
			),$layout);
		}

		public function change_post_slider_layout($layout) {
			return wp_parse_args(array(
				'grid-2' => array(
					'label' => esc_html__('Grid 2', 'homeid'),
					'priority' => 11,
				),
				'grid-3' => array(
					'label' => esc_html__('Grid 3', 'homeid'),
					'priority' => 12,
				),
				'grid-4' => array(
					'label' => esc_html__('Grid 4', 'homeid'),
					'priority' => 13,
				),
			),$layout);
		}
	}
}