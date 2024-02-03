<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! class_exists( 'G5ERE_Admin_Agency' ) ) {
	class G5ERE_Admin_Agency {
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
			add_filter( 'ere_register_term_meta', array( $this, 'add_map_address' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );
			add_action( 'edit_agency', array( $this, 'save_agency_map' ), 10, 2 );
			add_action( 'create_agency', array( $this, 'add_agency_map' ), 10, 2 );
		}

		public function enqueue_assets() {
			$screen    = get_current_screen();
			$screen_id = $screen ? $screen->id : '';
			if ( $screen_id === 'edit-agency' ) {
				wp_enqueue_style( G5ERE()->assets_handle( 'admin-map' ));
				wp_enqueue_script( G5ERE()->assets_handle( 'agency-admin-map' ));
			}
		}


		public function config_term_meta( $configs ) {
			if ( isset( $configs['agency-settings']['fields'][4] ) ) {
				unset( $configs['agency-settings']['fields'][4] );
			}

			return $configs;

		}

		public function add_map_address( $configs ) {
			$configs['agency-settings']['fields'][] = array(
				'type'   => 'row',
				'col'    => '6',
				'fields' => array(
					array(
						'title'    => __( 'Map', 'g5-ere' ),
						'id'       => "g5ere_agency_location",
						'type'     => 'custom',
						'template' => G5ERE()->plugin_dir( 'inc/admin/views/agency-map.php' ),
					),
				)

			);

			return $configs;
		}

		public function save_agency_map( $term_id, $tag_id ) {
			if ( ! isset( $_POST['taxonomy'] ) || $_POST['taxonomy'] != 'agency' || ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], "update-tag_{$tag_id}" ) ) {
				return;
			}
			$address_arr = isset( $_POST['real_estate_agency_location'] ) ? $_POST['real_estate_agency_location'] : '';
			$is_lock_pin = isset( $_POST['g5ere_agency_map_lock_pin'] ) ? $_POST['g5ere_agency_map_lock_pin'] : 'no';
			update_term_meta( $term_id, 'agency_map_address', $address_arr );
			update_term_meta( $term_id, 'g5ere_agency_map_lock_pin', $is_lock_pin );

		}

		public function add_agency_map( $term_id, $tag_id ) {
			if ( ! isset( $_POST['taxonomy'] ) || $_POST['taxonomy'] != 'agency' || ! isset( $_POST['_wpnonce_add-tag'] ) || ! wp_verify_nonce( $_POST['_wpnonce_add-tag'], "add-tag" ) ) {
				return;
			}
			$address_arr = isset( $_POST['real_estate_agency_location'] ) ? $_POST['real_estate_agency_location'] : '';
			$is_lock_pin = isset( $_POST['g5ere_agency_map_lock_pin'] ) ? $_POST['g5ere_agency_map_lock_pin'] : 'no';
			update_term_meta( $term_id, 'agency_map_address', $address_arr );
			update_term_meta( $term_id, 'g5ere_agency_map_lock_pin', $is_lock_pin );

		}

	}

}