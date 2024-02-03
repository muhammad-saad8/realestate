<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if (!class_exists('G5ERE_Map_Google')) {
	class G5ERE_Map_Google {
		private static $_instance;

		private $api_key;

		private $feature_types;

		private $countries;

		private $zoom;

		private $skin;

		private $skin_custom;

		private $cluster_markers;

		public static function get_instance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init() {
			$this->api_key = G5ERE()->options()->get_option('googlemap_api_key');
			$this->feature_types = G5ERE()->options()->get_option('googlemap_autocomplete_types','geocode');
			$this->countries = G5ERE()->options()->get_option('googlemap_autocomplete_locations',array());
			$this->zoom = G5ERE()->options()->get_option('map_zoom_level',12);
			$this->skin = G5ERE()->options()->get_option('google_map_skin','skin1');
			$this->skin_custom = G5ERE()->options()->get_option('google_map_skin_custom');
			$this->cluster_markers = G5ERE()->options()->get_option('map_pin_cluster','yes');

			add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'),1);
			add_action('admin_enqueue_scripts', array($this, 'enqueue_assets'),1);

			add_action('init',array($this,'register_assets'),7);
		}

		public function register_assets() {
			// Google Maps config.
			$args = [];
			$args['key'] = $this->api_key;
			$args['libraries'] = 'places';
			$args['v'] = 3;
			// Load Google Maps.
			wp_register_script( 'google-map', sprintf( 'https://maps.googleapis.com/maps/api/js?%s', http_build_query( $args ) ),array(), null, true );

			if ($this->cluster_markers === 'yes') {
				wp_register_script('markerclustererplus', G5ERE()->asset_url('assets/vendors/markerclustererplus/markerclusterer.min.js'), array('jquery','google-map'), '2.1.11', true);
			}

			wp_register_script('infobox', G5ERE()->asset_url('assets/vendors/infobox/infobox.min.js'), array('google-map'), '1.1.19', true);
		}

		public function enqueue_assets() {

			wp_enqueue_script('google-map');
			if ($this->cluster_markers === 'yes') {
				wp_enqueue_script('markerclustererplus');
			}

			wp_enqueue_script('infobox');

			// Load Maps assets.
			wp_enqueue_script(G5ERE()->assets_handle('google-map'), G5ERE()->asset_url('assets/js/map/google-map.min.js'), array('jquery','underscore'), G5ERE()->plugin_ver(), true);
			wp_enqueue_style(G5ERE()->assets_handle('google-map'),  G5ERE()->asset_url('assets/css/map/google-map.min.css'), array(), G5ERE()->plugin_ver());

			wp_localize_script(G5ERE()->assets_handle('google-map'),'g5ere_map_config',array(
				'zoom' => $this->zoom,
				'cluster_markers' => $this->cluster_markers === 'yes',
				'marker' => G5ERE()->map()->get_marker(),
				'skin' => $this->skin,
				'skin_custom' => $this->skin_custom,
				'types' => $this->feature_types,
				'countries' => $this->countries,
				'coordinate_default' => G5ERE()->map()->get_coordinate_default()
			));

		}
	}
}
