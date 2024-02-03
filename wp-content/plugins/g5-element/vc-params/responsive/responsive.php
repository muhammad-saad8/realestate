<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! class_exists( 'G5Element_Vc_Param_Responsive' ) ) {
	class G5Element_Vc_Param_Responsive {

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
			vc_add_shortcode_param( 'g5element_responsive', array(
				$this,
				'render_param'
			), G5ELEMENT()->asset_url( 'vc-params/responsive/assets/responsive.min.js' ) . '?ver=' . G5ELEMENT()->plugin_ver() );
		}

		public function render_param( $settings, $value ) {
			ob_start();
			G5ELEMENT()->get_plugin_template( 'vc-params/responsive/templates/responsive.tpl.php', array(
				'settings' => $settings,
				'value' => $value,
				'size_types' => $this->size_types
			) );

			return ob_get_clean();
		}

		public function enqueue_admin_resources() {
		}
	}

	new G5Element_Vc_Param_Responsive();
}