<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! class_exists( 'G5ERE_Map' ) ) {
	class G5ERE_Map {
		private static $_instance;

		public static function get_instance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init() {
			add_action( 'wp_footer', array( $this, 'include_templates' ) );
			add_action( 'admin_footer', array( $this, 'include_templates' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );
			$map_services = G5ERE()->options()->get_option( 'map_service', 'google' );
			switch ( $map_services ) {
				case 'google':
					$this->google()->init();
					break;
				case 'mapbox':
					$this->mapbox()->init();
					break;
				case 'osm':
					$this->osm()->init();
					break;
			}
			do_action( 'g5ere_map_init', $map_services );
		}

		public function include_templates() {
			G5ERE()->get_template( 'map/marker.php' );
			G5ERE()->get_template( 'map/popup.php' );
		}

		public function enqueue_assets() {
			wp_enqueue_style( G5ERE()->assets_handle( 'maps' ), G5ERE()->asset_url( 'assets/css/map/map.min.css' ), array(), G5ERE()->plugin_ver() );
		}

		public function get_marker() {
			$marker_html = '';
			$marker_type = G5ERE()->options()->get_option( 'marker_type', 'icon' );
			if ( $marker_type === 'icon' ) {
				$marker_icon = G5ERE()->options()->get_option( 'marker_icon', 'fal fa-map-marker-alt' );
				if ( ! empty( $marker_icon ) ) {
					$marker_html = sprintf( '<i class="%s"></i>', esc_attr( $marker_icon ) );
				}
			} else {
				$marker_image = G5ERE()->options()->get_option( 'marker_image' );
				if ( is_array( $marker_image ) && isset( $marker_image['url'] ) && ! empty( $marker_image['url'] ) ) {
					$marker_html = sprintf( '<img src="%s" />', esc_url( $marker_image['url'] ) );
				}
			}

			if ( empty( $marker_html ) ) {
				$marker_type = 'icon';
				$marker_html = apply_filters( 'g5ere_marker_html_default', '<i class="fal fa-map-marker-alt"></i>' );
			}

			return array(
				'type' => $marker_type,
				'html' => $marker_html
			);
		}

		public function get_coordinate_default() {
			$coordinate_default = G5ERE()->options()->get_option( 'coordinate_default', '-33.868419,151.193245' );
			$coordinate_default_lat = '-33.868419';
			$coordinate_default_lng = '151.193245';
			if (strpos($coordinate_default,',' ) > 0) {
				$coordinate_default_arr    = explode( ',', $coordinate_default );
				$coordinate_default_lat               = isset( $coordinate_default_arr[0] ) ? str_replace(' ', '', $coordinate_default_arr[0])  : '';
				$coordinate_default_lng               = isset( $coordinate_default_arr[1] ) ?  str_replace(' ','', $coordinate_default_arr[1])  : '';
			}
			return array(
				'lat' => $coordinate_default_lat,
				'lng' => $coordinate_default_lng
			);
		}

		/**
		 * @return G5ERE_Map_Google
		 */
		public function google() {
			return G5ERE_Map_Google::get_instance();
		}

		/**
		 * @return G5ERE_Map_Box
		 */
		public function mapbox() {
			return G5ERE_Map_Box::get_instance();
		}

		/**
		 * @return G5ERE_Map_Osm
		 */
		public function osm() {
			return G5ERE_Map_Osm::get_instance();
		}


	}
}