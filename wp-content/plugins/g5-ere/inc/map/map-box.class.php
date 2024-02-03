<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! class_exists( 'G5ERE_Map_Box' ) ) {
	class G5ERE_Map_Box {
		private static $_instance;
		private $access_tokens;

		private $feature_types;

		private $countries;

		private $zoom;

		private $skin;

		private $skin_custom;

		private $cluster_markers;

		public static function get_instance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init() {

			$this->access_tokens   = G5ERE()->options()->get_option( 'mapbox_api_access_token' );
			$this->feature_types   = G5ERE()->options()->get_option( 'mapbox_autocomplete_types', array() );
			$this->countries       = G5ERE()->options()->get_option( 'mapbox_autocomplete_locations', array() );
			$this->zoom            = G5ERE()->options()->get_option( 'map_zoom_level', 12 );
			$this->skin            = G5ERE()->options()->get_option( 'mapbox_skin', 'skin1' );
			$this->skin_custom     = G5ERE()->options()->get_option( 'mapbox_skin_custom' );
			$this->cluster_markers = G5ERE()->options()->get_option( 'map_pin_cluster', 'yes' );
			add_action( 'wp_enqueue_scripts', array( $this, 'frontend_enqueue' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'frontend_enqueue' ) );
			add_action( 'wp_print_scripts', array( $this, 'frontend_dequeue' ), 100 );
		}

		public function frontend_enqueue() {
			wp_enqueue_script( 'mapbox-gl', 'https://api.mapbox.com/mapbox-gl-js/v3.0.1/mapbox-gl.js', array(), '3.0.1', true );
			wp_enqueue_style( 'mapbox-gl', 'https://api.mapbox.com/mapbox-gl-js/v3.0.1/mapbox-gl.css', array(), '3.0.1' );

			wp_enqueue_script( 'supercluster', G5ERE()->asset_url( 'assets/vendors/supercluster/supercluster.min.js' ), array(
				'jquery',
				'mapbox-gl'
			), '6.0.1', true );

			// Load Maps assets.
			wp_enqueue_script( G5ERE()->assets_handle( 'mapbox' ), G5ERE()->asset_url( 'assets/js/map/mapbox.min.js' ), array( 'jquery','underscore' ), G5ERE()->plugin_ver(), true );
			wp_enqueue_style( G5ERE()->assets_handle( 'mapbox' ), G5ERE()->asset_url( 'assets/css/map/mapbox.min.css' ), array(), G5ERE()->plugin_ver() );

			wp_localize_script( G5ERE()->assets_handle( 'mapbox' ), 'g5ere_map_config', array(
				'accessToken'     => $this->access_tokens,
				'zoom'            => $this->zoom,
				'cluster_markers' => $this->cluster_markers === 'yes',
				'marker'          => G5ERE()->map()->get_marker(),
				'skin'            => $this->skin,
				'skin_custom'     => $this->skin_custom,
				'types'           => $this->feature_types,
				'countries'       => $this->countries,
				'coordinate_default' => G5ERE()->map()->get_coordinate_default()
			) );


		}

		public function frontend_dequeue() {
			wp_deregister_script( 'google-map' );
			wp_dequeue_script( 'google-map' );;
		}
	}
}
