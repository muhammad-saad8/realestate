<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! class_exists( 'G5ERE_Map_Osm' ) ) {
	class G5ERE_Map_Osm {
		private static $_instance;

		private $zoom;

		private $cluster_markers;

		public static function get_instance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init() {

			$this->zoom            = G5ERE()->options()->get_option( 'map_zoom_level', 12 );
			$this->cluster_markers = G5ERE()->options()->get_option( 'map_pin_cluster', 'yes' );
			add_action( 'wp_enqueue_scripts', array( $this, 'frontend_enqueue' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'frontend_enqueue' ) );
			add_action( 'wp_print_scripts', array( $this, 'frontend_dequeue' ), 100 );
		}

		public function frontend_enqueue() {
			// Enqueue leaflet CSS
			wp_enqueue_style( 'leaflet', G5ERE()->asset_url( 'assets/vendors/leaflet/leaflet.min.css' ), array(), '1.3.4' );

			// Enqueue leaflet JS
			wp_enqueue_script( 'leaflet', G5ERE()->asset_url( 'assets/vendors/leaflet/leaflet.min.js' ), array(), '1.3.4', true );

			wp_enqueue_script( 'supercluster', G5ERE()->asset_url( 'assets/vendors/supercluster/supercluster.min.js' ), array(
				'jquery',
				'leaflet'
			), '6.0.1', true );
			// Enqueue Control.Geocoder CSS
			wp_enqueue_style( G5ERE()->assets_handle( 'leftlet_geocoder' ), G5ERE()->asset_url( 'assets/vendors/leaflet-control-geocoder/Control.Geocoder.min.css' ), array(), '1.3.4' );
			// Enqueue Control.Geocoder JS
			wp_enqueue_script( G5ERE()->assets_handle( 'leftlet_geocoder' ), G5ERE()->asset_url( 'assets/vendors/leaflet-control-geocoder/Control.Geocoder.min.js' ), array(), '1.3.4', true );

			// Load Maps assets.
			wp_enqueue_script( G5ERE()->assets_handle( 'osm' ), G5ERE()->asset_url( 'assets/js/map/osm.min.js' ), array( 'jquery','underscore' ), G5ERE()->plugin_ver(), true );
			wp_enqueue_style( G5ERE()->assets_handle( 'osm' ), G5ERE()->asset_url( 'assets/css/map/mapbox.min.css' ), array(), G5ERE()->plugin_ver() );

			wp_localize_script( G5ERE()->assets_handle( 'osm' ), 'g5ere_map_config', array(
				'zoom'            => $this->zoom,
				'cluster_markers' => $this->cluster_markers === 'yes',
				'marker'          => G5ERE()->map()->get_marker(),
				'attribution' => sprintf(__('&copy; <a href="%s">OpenStreetMap</a> contributors','g5-ere'),'https://www.openstreetmap.org/copyright'),
				'coordinate_default' => G5ERE()->map()->get_coordinate_default()
			) );


		}

		public function frontend_dequeue() {
			wp_deregister_script( 'google-map' );
			wp_dequeue_script( 'google-map' );;
		}
	}
}
