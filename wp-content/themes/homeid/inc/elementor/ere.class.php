<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if (! class_exists('HOMEID_ELEMENTOR_ERE')) {
	class HOMEID_ELEMENTOR_ERE {
		private static $_instance;

		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init() {
			$this->property()->init();
			$this->agent()->init();
		}


		/**
		 * @return HOMEID_ELEMENTOR_PROPERTY
		 */
		public function property() {
			return HOMEID_ELEMENTOR_PROPERTY::getInstance();
		}

		/**
		 * @return HOMEID_ELEMENTOR_AGENT
		 */
		public function agent() {
			return HOMEID_ELEMENTOR_AGENT::getInstance();
		}
	}
}