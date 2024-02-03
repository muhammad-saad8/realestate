<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! class_exists( 'G5ERE_Widget' ) ) {
	class G5ERE_Widget {
		private static $_instance;

		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init() {
			add_action( 'widgets_init', array( $this, 'register_widgets' ) );
		}

		public function register_widgets() {
			register_widget( 'G5ERE_Widget_Property' );
			register_widget( 'G5ERE_Widget_Property_Search' );
			register_widget( 'G5ERE_Widget_Agent_Search' );
			register_widget( 'G5ERE_Widget_Agency_Search' );
			register_widget( 'G5ERE_Widget_Contact_Agent' );
			register_widget( 'G5ERE_Widget_Contact_Agency' );
			register_widget( 'G5ERE_Widget_Agent_Info' );
		}
	}
}