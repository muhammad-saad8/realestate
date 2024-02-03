<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if (!class_exists('G5Core_Dashboard_Install_Demo')) {
	class  G5Core_Dashboard_Install_Demo {
		/*
		 * loader instances
		 */
		private static $_instance;

		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init() {
			add_filter('g5core_dashboard_menu',array($this,'dashboard_menu'));
			add_filter('gid_install_demo_page_parent',array($this,'change_install_demo_page_parent'));
			add_action('gid_demo_page_before',array($this,'add_tabs'));
		}

		public function change_install_demo_page_parent() {
			return 'g5core_welcome';
		}

		public function add_tabs() {
			G5CORE()->get_plugin_template("inc/dashboard/templates/tab.php", array(
				'current_page' => 'gid_install_demo'
			));
		}

		public function dashboard_menu($page_configs) {
			$page_configs['gid_install_demo'] = array(
				'page_title'      => esc_html__( 'Install Demo', 'g5-core' ),
				'menu_title'      => esc_html__( 'Install Demo', 'g5-core' ),
				'priority'        => 25,
				'link' => admin_url('admin.php?page=gid_install_demo')
			);
			return $page_configs;
		}
	}
}