<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! class_exists( 'HOMEID_CORE_AGENCY' ) ) {
	class HOMEID_CORE_AGENCY {
		private static $_instance;

		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init() {
			add_action( 'template_redirect', array( $this, 'demo_single_layout' ), 15 );
		}

		public function demo_single_layout() {
			if ( ! function_exists( 'G5CORE' ) || ! function_exists( 'G5ERE' ) ) {
				return;
			}
			if (!g5ere_is_single_agency()) {
				return;
			}

			$layout = isset( $_GET['single_agency_layout'] ) ? $_GET['single_agency_layout'] : '';
			if ($layout === 'layout-01') {
				G5ERE()->options()->set_option( 'single_agency_layout', 'layout-1' );
			} elseif ($layout === 'layout-02') {
				G5ERE()->options()->set_option( 'single_agency_layout', 'layout-2' );
				G5ERE()->options()->set_option( 'single_agency_content_blocks', array(
					'enable'  => array(
						'tabs'   => esc_html__( 'Tabs content', 'homeid' )
					),
					'disable' => array(
						'overview' => esc_html__( 'Overview', 'homeid' ),
						'listing'  => esc_html__( 'Listing', 'homeid' ),
						'agents'   => esc_html__( 'Agents', 'homeid' ),
						'map'      => esc_html__( 'Map', 'homeid' ),
					),
				) );
				G5ERE()->options()->set_option( 'single_agency_tabs_content_blocks', array(
					'enable'  => array(
						'overview' => esc_html__( 'Overview', 'homeid' ),
						'listing'  => esc_html__( 'Listing', 'homeid' ),
						'agents'   => esc_html__( 'Agents', 'homeid' ),
						'map'      => esc_html__( 'Map', 'homeid' ),
					),
					'disable' => array(),
				) );
			}

		}

	}
}