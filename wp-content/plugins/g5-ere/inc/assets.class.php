<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! class_exists( 'G5ERE_Assets' ) ) {
	class G5ERE_Assets {
		private static $_instance;

		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init() {
			add_action( 'init', array( $this, 'register_assets' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'dequeue_assets' ), 40 );
			add_filter( 'g5element_shortcode_assets', array( $this, 'change_assets_google_map' ) );
			add_filter( 'g5ere_data_localize_script', array( $this, 'add_profile_localize_script' ) );
		}


		public function register_assets() {
			wp_register_script( G5ERE()->assets_handle( 'admin-map' ), G5ERE()->asset_url( 'assets/js/admin/map.min.js' ), array(
				'jquery',
			), G5ERE()->plugin_ver(), true );
			wp_register_style( G5ERE()->assets_handle( 'admin-map' ), G5ERE()->asset_url( 'assets/css/admin/map.min.css' ), array(), G5ERE()->plugin_ver() );

			wp_register_script( G5ERE()->assets_handle( 'agency-admin-map' ), G5ERE()->asset_url( 'assets/js/admin/agency-map.min.js' ), array( 'jquery' ), G5ERE()->plugin_ver(), true );

			$coordinate_default =  G5ERE()->map()->get_coordinate_default();

			wp_localize_script( G5ERE()->assets_handle( 'admin-map' ), 'g5ere_admin_map_vars', array(
				'coordinate_default' => $coordinate_default
			) );


			wp_localize_script( G5ERE()->assets_handle( 'agency-admin-map' ), 'g5ere_admin_agency_map_vars', array(
				'coordinate_default' => $coordinate_default
			) );

			wp_register_script( G5ERE()->assets_handle( 'frontend' ), G5ERE()->asset_url( 'assets/js/frontend.min.js' ), array(
				'jquery',
				'jquery-ui-slider',
				'ere_main'
			), G5ERE()->plugin_ver(), true );

			//Profile
			wp_register_script( G5ERE()->assets_handle( 'profile' ), G5ERE()->asset_url( 'assets/js/ere-profile.min.js' ), array(
				'jquery',
				'plupload',
				'jquery-validate'
			), G5ERE()->plugin_ver(), true );
			wp_register_style( 'bootstrap-datepicker', G5ERE()->asset_url( 'assets/vendors/bootstrap-datepicker/css/bootstrap-datepicker.min.css' ), array(), 'v1.9.0' );
			wp_register_script( 'bootstrap-datepicker', G5ERE()->asset_url( 'assets/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js' ), array(
				'jquery',
			), 'v1.9.0', true );

			wp_localize_script( G5ERE()->assets_handle( 'frontend' ), 'g5ere_vars', $this->get_data_localize_script() );

			wp_register_style( G5ERE()->assets_handle( 'frontend' ), G5ERE()->asset_url( 'assets/scss/frontend.min.css' ), array(), G5ERE()->plugin_ver() );
			wp_register_style( G5ERE()->assets_handle( 'property-print' ), G5ERE()->asset_url( 'assets/css/print.min.css' ), array(), G5ERE()->plugin_ver() );
		}

		public function dequeue_assets() {

		}

		public function get_data_localize_script() {


			$localize_script = array(
				'ajax_url'     => admin_url( 'admin-ajax.php' ),
				'loading_text' => esc_html__( 'Processing, Please wait...', 'g5-ere' ),
				'i18n'         => $this->get_data_i18n_localize_script()
			);

			return apply_filters( 'g5ere_data_localize_script', $localize_script );
		}

		public function get_data_i18n_localize_script() {
			return apply_filters( 'g5ere_i18n_localize_script', array(
				'property_print_window' => esc_html__( 'Property Print Window', 'g5-ere' )
			) );
		}

		public function add_profile_localize_script( $localize_script ) {
			$ajax_url = $localize_script['ajax_url'];
			$profile_ajax_upload_url = add_query_arg( 'action', 'ere_profile_image_upload_ajax', $ajax_url );
			$profile_ajax_upload_url = add_query_arg( 'nonce', wp_create_nonce('ere_allow_upload_nonce'), $profile_ajax_upload_url );
			$localize_script['ajax_upload_image_profile_url']             = $profile_ajax_upload_url;
			$localize_script['file_type_title']          = esc_html__( 'Valid file formats', 'g5-ere' );
			$localize_script['ere_site_url']             = site_url();
			$localize_script['confirm_become_agent_msg'] = esc_html__( 'Are you sure you want to become an agent.', 'g5-ere' );
			$localize_script['confirm_leave_agent_msg']  = esc_html__( 'Are you sure you want to leave agent account and comeback normal account.', 'g5-ere' );
			$enable_register_tab = ere_get_option( 'enable_register_tab', 1 );
			$localize_script['enable_register_tab']  = $enable_register_tab;
			return $localize_script;
		}

		public function enqueue_assets() {
			wp_enqueue_style( G5ERE()->assets_handle( 'admin-map' ) );
			wp_enqueue_script( G5ERE()->assets_handle( 'admin-map' ) );

			wp_enqueue_style( G5ERE()->assets_handle( 'property-print' ) );
			wp_enqueue_style( G5ERE()->assets_handle( 'frontend' ) );
			wp_enqueue_script( G5ERE()->assets_handle( 'frontend' ) );

		}

		public function change_assets_google_map( $assets_array ) {

			$assets_array['google_map'] = array(
				'css' => G5ERE()->asset_url( 'assets/shortcode-css/map.min.css' ),
				'js'  => G5ERE()->asset_url( 'assets/shortcode-js/map.js' ),
			);

			return $assets_array;
		}


	}
}