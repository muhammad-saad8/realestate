<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if (! class_exists('HOMEID_ELEMENTOR_AGENT')) {
	class HOMEID_ELEMENTOR_AGENT {
		private static $_instance;

		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function init() {
			add_filter('g5ere_elementor_agent_layout',array($this,'change_agent_layout'));
			add_filter('g5ere_elementor_agent_skins', array($this, 'change_agent_skins'));
		}

		public function change_agent_layout($config)
		{
			return wp_parse_args(array(
				'creative' => array(
					'label' => esc_html__('Creative', 'homeid'),
					'priority' => 30,
				),
			), $config);
		}

		public function change_agent_skins($layout)
		{
			return wp_parse_args(array(
				'skin-02' => array(
					'label' => esc_html__('Skin 02', 'homeid'),
					'priority' => 20,
				),
				'skin-03' => array(
					'label' => esc_html__('Skin 03', 'homeid'),
					'priority' => 30,
				),
				'skin-04' => array(
					'label' => esc_html__('Skin 04', 'homeid'),
					'priority' => 40,
				),
				'skin-05' => array(
					'label' => esc_html__('Skin 05', 'homeid'),
					'priority' => 50,
				),
				'skin-06' => array(
					'label' => esc_html__('Skin 06', 'homeid'),
					'priority' => 60,
				),
				'skin-07' => array(
					'label' => esc_html__('Skin 07', 'homeid'),
					'priority' => 70,
				),
			), $layout);
		}


	}
}