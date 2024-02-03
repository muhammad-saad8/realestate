<?php
if (!class_exists('G5Element_Vc_Param_Number')) {
	class G5Element_Vc_Param_Number {
		public function __construct(){
            add_action('vc_load_default_params', array($this, 'register_param'));
            add_action( 'vc_backend_editor_enqueue_js_css', array($this,'enqueue_admin_resources'));
            add_action('vc_frontend_editor_enqueue_js_css',array($this,'enqueue_admin_resources'));
		}

		public function register_param(){
			vc_add_shortcode_param( 'g5element_number', array($this, 'render_param'));
		}

        public function render_param($settings, $value)
        {
            ob_start();
	        G5ELEMENT()->get_plugin_template('vc-params/number/templates/number.tpl.php',array('settings' => $settings, 'value' => $value));
            return ob_get_clean();
        }

        public function enqueue_admin_resources() {
        }
	}
	new G5Element_Vc_Param_Number();
}