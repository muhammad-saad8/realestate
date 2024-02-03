<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! class_exists( 'G5ERE_Admin' ) ) {
	class G5ERE_Admin {
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

		public function init() {
			$this->property()->init();
			$this->agency()->init();
			add_filter( 'ere_page_setup_config', array( $this, 'change_ere_page_setup_config' ) );
		}

		/**
		 * @return G5ERE_Admin_Property
		 */
		public function property() {
			return G5ERE_Admin_Property::getInstance();
		}

		public function agency() {
			return G5ERE_Admin_Agency::getInstance();
		}

		public function change_ere_page_setup_config( $config ) {
			$config['dashboard'] = array(
				'title'    => _x( 'Dashboard', 'Default page title (wizard)', 'g5-ere' ),
				'desc'     => esc_html__( 'This is dashboard page.', 'g5-ere' ),
				'content'  => '[g5element_ere_dashboards]',
				'priority' => 150,
			);

			$config['agency'] = array(
				'title'    => _x( 'Agency', 'Default page title (wizard)', 'g5-ere' ),
				'desc'     => esc_html__( 'This page display agency listing.', 'g5-ere' ),
				'content'  => '',
				'priority' => 160,
			);
			$config['review'] = array(
				'title'    => _x( 'Review', 'Default page title (wizard)', 'g5-ere' ),
				'desc'     => esc_html__( 'This page display review listing.', 'g5-ere' ),
				'content'  => '[g5element_ere_reviews]',
				'priority' => 170,
			);

			return $config;
		}


	}
}