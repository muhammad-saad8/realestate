<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! class_exists( 'G5ERE_Admin_Property' ) ) {
	class G5ERE_Admin_Property {
		/*
		* loader instances
		*/
		private static $_instance;

		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init() {
			add_filter( 'gsf_term_meta_config', array( $this, 'config_term_meta' ), 11 );
			add_filter( 'ere_register_meta_boxes_property', array( $this, 'change_config_location' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );
			add_action( 'save_post', array( $this, 'save_property_map' ), 10, 2 );
			add_filter( 'ere_submit_property_map_address', array( $this, 'change_property_map_address' ), 10, 1 );
		}

		public function change_property_map_address( $property_map_address ) {
			if ( isset( $_POST['property_search_address'] ) ) {
				$property_map_address = $_POST['property_search_address'];
			}
			return $property_map_address;
		}

		public function enqueue_assets() {
			$screen    = get_current_screen();
			$screen_id = $screen ? $screen->id : '';
			if ( $screen_id === 'property' ) {
				wp_enqueue_style( G5ERE()->assets_handle( 'admin-map' ));
				wp_enqueue_script( G5ERE()->assets_handle( 'admin-map' ));
			}
		}


		public function config_term_meta( $configs ) {

			if ( isset( $configs['property-type-settings'] ) ) {
				unset( $configs['property-type-settings'] );
			}

			$prefix                         = G5ERE()->meta_prefix;
			$configs['g5ere_property_type'] = array(
				'name'     => esc_html__( 'Map Marker', 'g5-ere' ),
				'layout'   => 'horizontal',
				'taxonomy' => 'property-type',
				'fields'   => array(
					array(
						'id'      => "{$prefix}marker_type",
						'title'   => esc_html__( 'Marker Type', 'g5-ere' ),
						'type'    => 'button_set',
						'options' => G5ERE()->settings()->get_map_marker_type( true ),
						'default' => '',
					),
					array(
						'id'       => "{$prefix}marker_icon",
						'title'    => esc_html__( 'Marker Icon', 'g5-ere' ),
						'subtitle' => esc_html__( 'Select icon for map marker', 'g5-ere' ),
						'type'     => 'icon',
						'default'  => 'fal fa-map-marker-alt',
						'required' => array( "{$prefix}marker_type", '=', 'icon' ),
					),
					array(
						'id'       => "{$prefix}marker_image",
						'type'     => 'image',
						'title'    => esc_html__( 'Marker Image', 'g5-ere' ),
						'subtitle' => esc_html__( 'Select image for map marker', 'g5-ere' ),
						'default'  => '',
						'required' => array( "{$prefix}marker_type", '=', 'image' ),
					),
				)
			);

			return $configs;

		}

		public function change_config_location( $configs ) {
			$meta_prefix = ERE_METABOX_PREFIX;
			$location    = &g5ere_get_array_by_path( $configs, "section/{$meta_prefix}location_tab/fields/{$meta_prefix}property_location" );

			$location = array(
				'id'       => 'g5ere_property_location',
				'type'     => 'custom',
				'template' => G5ERE()->plugin_dir( 'inc/admin/views/map.php' )

			);

			return $configs;
		}

		/**
		 * @param $post_ID int
		 * @param $post WP_Post
		 */
		public function save_property_map( $post_ID, $post ) {
			if ( $post->post_type !== 'property' || empty( $_POST ) || ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], "update-post_{$post_ID}" ) ) {
				return;
			}

			$meta_keys   = array(
				'property_location',
				'map_lock_pin',
			);
			$meta_prefix = ERE_METABOX_PREFIX;
			foreach ( $meta_keys as $meta_key ) {
				$meta_key = $meta_prefix . $meta_key;
				if ( isset( $_POST[ $meta_key ] ) ) {
					update_post_meta( $post_ID, $meta_key, $_POST[ $meta_key ] );
				}
			}
		}

	}

}