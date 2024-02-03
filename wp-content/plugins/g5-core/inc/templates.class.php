<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! class_exists( 'G5Core_Templates' ) ) {
	class G5Core_Templates {
		private static $_instance;

		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init() {
			$this->remove_theme_template();
			$this->add_theme_template();
			$this->set_header_vertical();
		}

		public function remove_theme_template() {
			/**
			 * Remove header template
			 */
			remove_action( G5CORE_CURRENT_THEME . '_before_page_wrapper_content', G5CORE_CURRENT_THEME . '_template_header', 10 );
		}

		public function add_theme_template() {
			add_action( G5CORE_CURRENT_THEME . '_before_page_wrapper_content', array( $this, 'header_template' ), 10 );
		}

		public function set_header_vertical() {
			add_filter('body_class', array($this, 'header_vertical'));
		}

		public function header_vertical($classes) {
			$header_style_vertical = G5CORE()->settings()->header_vertical_style(G5CORE()->options()->header()->get_option( 'header_style' ));
			if ($header_style_vertical !== null && $header_style_vertical != false) {
				$classes[] = 'g5core-is-header-vertical';
				if (isset($header_style_vertical['location'])) {
					$classes[] = 'g5core-is-header-vertical-' .  $header_style_vertical['location'];
				}
				if (isset($header_style_vertical['size'])) {
					$classes[] = 'g5core-is-header-vertical-' . $header_style_vertical['size'];
				}

			}
			return $classes;
		}

		public function header_template() {
			G5CORE()->get_template( 'header.php' );
		}

		public function menu_popup() {
			G5CORE()->get_template( 'header/desktop/menu-popup.php' );
		}

		public function canvas_sidebar() {
			G5CORE()->get_template( 'header/customize/canvas-sidebar.php' );
		}

		public function search_popup() {
			G5CORE()->get_template( 'header/customize/search-popup.php' );
		}

		public function login_popup() {
			G5CORE()->get_template( 'header/customize/login-popup.php' );
		}

		public function menu_mobile() {
			G5CORE()->get_template( 'header/mobile/menu.php' );
		}
	}
}