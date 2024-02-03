<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! class_exists( 'HOMEID_CORE_ERE' ) ) {
	class HOMEID_CORE_ERE {
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
			$this->agency()->init();
		}
		/**
		 * @return HOMEID_CORE_AGENT
		 */
		public function agent() {
			return HOMEID_CORE_AGENT::getInstance();
		}

		/**
		 * @return HOMEID_CORE_PROPERTY
		 */
		public function property() {
			return HOMEID_CORE_PROPERTY::getInstance();
		}

		/**
		 * @return HOMEID_CORE_AGENCY
		 */
		public function agency() {
			return HOMEID_CORE_AGENCY::getInstance();
		}

	}
}