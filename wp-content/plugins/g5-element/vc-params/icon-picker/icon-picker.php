<?php
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}
if (!class_exists('G5Element_Vc_Param_Icon_Picker')) {
	class G5Element_Vc_Param_Icon_Picker
	{
		public function __construct()
		{
			add_action('vc_load_default_params', array($this, 'register_param'));
			add_action( 'vc_backend_editor_enqueue_js_css', array($this,'enqueue_admin_resources'));
            add_action('vc_frontend_editor_enqueue_js_css',array($this,'enqueue_admin_resources'));
		}

		public function register_param()
		{
			vc_add_shortcode_param('g5element_icon_picker', array($this, 'render_param'),
				G5ELEMENT()->asset_url('vc-params/icon-picker/assets/icon-picker.min.js') . '?ver=' . G5ELEMENT()->plugin_ver());
		}

		public function render_param($settings, $value)
		{
			ob_start();
			G5ELEMENT()->get_plugin_template('vc-params/icon-picker/templates/icon-picker.tpl.php',array('settings' => $settings, 'value' => $value));
			return ob_get_clean();
		}

		public function enqueue_admin_resources() {
			GSF_Core_Icons_Popup::getInstance()->enqueue();
		}
	}

	new G5Element_Vc_Param_Icon_Picker();
}