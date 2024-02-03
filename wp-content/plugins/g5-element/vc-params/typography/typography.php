<?php
/**
 * The template for displaying typography.php
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! class_exists( 'G5Element_Vc_Param_Typography' ) ) {
	class G5Element_Vc_Param_Typography {
		public function __construct() {
			add_action( 'vc_load_default_params', array( $this, 'register_param' ) );
			add_action( 'vc_backend_editor_enqueue_js_css', array( $this, 'enqueue_admin_resources' ) );
			add_action( 'vc_frontend_editor_enqueue_js_css', array( $this, 'enqueue_admin_resources' ) );
		}

		public function register_param() {
			vc_add_shortcode_param( 'g5element_typography', array( $this, 'render_param' ),
				G5ELEMENT()->asset_url( 'vc-params/typography/assets/typography.min.js' ) . '?ver=' . G5ELEMENT()->plugin_ver() );
		}

		public function render_param( $settings, $value ) {
			ob_start();
			G5ELEMENT()->get_plugin_template( 'vc-params/typography/templates/typography.tpl.php',
				array( 'settings' => $settings, 'value' => $value ) );

			return ob_get_clean();
		}

		public function enqueue_admin_resources() {
			wp_enqueue_style( G5ELEMENT()->assets_handle( 'vc-typography' ),
				G5ELEMENT()->asset_url( 'vc-params/typography/assets/typography.min.css' ),
				array(),
				G5ELEMENT()->plugin_ver());

			wp_enqueue_style(G5ELEMENT()->assets_handle('vc-button-set'),
				G5ELEMENT()->asset_url('vc-params/button-set/assets/button-set.min.css'),
				array(),
				G5ELEMENT()->plugin_ver());

			wp_enqueue_style('wp-color-picker');
			wp_enqueue_script('wp-color-picker');
			wp_enqueue_script('wp-color-picker-alpha');
		}
	}

	new G5Element_Vc_Param_Typography();
}