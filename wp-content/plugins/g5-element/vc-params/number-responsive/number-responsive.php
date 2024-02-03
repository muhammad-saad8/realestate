<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! class_exists( 'G5Element_Vc_Param_Number_Responsive' ) ) {
	class G5Element_Vc_Param_Number_Responsive {
		public $size_types = array(
			'lg' => 'Large',
			'md' => 'Medium',
			'sm' => 'Small',
			'xs' => 'Extra small',
		);

		public function __construct() {
			add_action( 'vc_load_default_params', array( $this, 'register_param' ) );
			add_action( 'vc_backend_editor_enqueue_js_css', array( $this, 'enqueue_admin_resources' ) );
			add_action( 'vc_frontend_editor_enqueue_js_css', array( $this, 'enqueue_admin_resources' ) );
		}

		public function register_param() {
			vc_add_shortcode_param( 'g5element_number_responsive', array(
				$this,
				'render_param'
			), G5ELEMENT()->asset_url( 'vc-params/number-responsive/assets/number-responsive.min.js' ) );
		}

		public function render_param( $settings, $value ) {
			ob_start();
			G5ELEMENT()->get_plugin_template( 'vc-params/number-responsive/templates/number-responsive.tpl.php', array(
				'settings' => $settings,
				'value' => $value,
				'size_types' => $this->size_types
			) );

			return ob_get_clean();
		}

		public function enqueue_admin_resources() {
			wp_enqueue_style( G5ELEMENT()->assets_handle( 'vc-number-responsive' ),
				G5ELEMENT()->asset_url( 'vc-params/number-responsive/assets/number-responsive.min.css' ),
				array(),
				G5ELEMENT()->plugin_ver());
		}
	}

	new G5Element_Vc_Param_Number_Responsive();
}