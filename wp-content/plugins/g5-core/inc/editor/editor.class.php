<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! class_exists( 'G5Core_Editor' ) ) {
	class G5Core_Editor {
		private static $_instance;

		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init() {
			global $pagenow;
			if ( is_admin() && ( in_array( $pagenow, array( 'post-new.php', 'post.php' ) ) ) ) {
				add_action( 'load-post.php', array( $this, 'enqueue' ) );
				add_action( 'load-post-new.php', array( $this, 'enqueue' ) );
			}

		}

		public function enqueue(){
			wp_enqueue_script( G5CORE()->assets_handle('editor-post-layout'));
		}

	}
}