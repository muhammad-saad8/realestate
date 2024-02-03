<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
if (!class_exists('G5Core_Options_Abstract')) {
	abstract class G5Core_Options_Abstract {
		protected $option_name = '';

		private $_preset = '';
		public function set_preset($preset_name) {
			$this->_preset = $preset_name;
		}
		public function get_preset() {
			return $this->_preset;
		}

		public function get_option_name() {
			return $this->option_name;
		}

		public function get_option($key, $default = '') {
			$options = &GSF()->adminThemeOption()->getOptions($this->option_name, $this->_preset);
			if (isset($options[$key])) {
				return $options[$key];
			}

            $_options = GSF()->adminThemeOption()->getOptions($this->option_name, $this->_preset,false);

			foreach ( $this->get_default_options() as $k => $v ) {
				if (!isset($options[$k])) {
					$options[$k] = $v;
				}

				if (!isset($_options[$k])) {
				    $_options[$k] = $v;
                }
			}

			$options_key = GSF()->adminThemeOption()->get_current_option_key($this->option_name, $this->_preset);

			update_option($options_key, $_options);

			if (isset($options[$key])) {
				return $options[$key];
			}

			$options[$key] = $default;

			// Update Options Key by default value
			$_options[$key] = $default;
			update_option($options_key, $_options);

			return $default;
		}

		public function set_option($key, $value) {
			$options = &GSF()->adminThemeOption()->getOptions($this->option_name, $this->_preset);
			$options[$key] = $value;
		}

		/**
		 * @return array
		 */
		public abstract function init_default();

		public function get_default($key, $default = '') {
			if (isset($GLOBALS["g5core_default_options_{$this->option_name}"])) {
				return isset($GLOBALS["g5core_default_options_{$this->option_name}"][$key]) ? $GLOBALS["g5core_default_options_{$this->option_name}"][$key] : $default;
			}
			$GLOBALS["g5core_default_options_{$this->option_name}"] = $this->get_default_options();
			return isset($GLOBALS["g5core_default_options_{$this->option_name}"][$key]) ? $GLOBALS["g5core_default_options_{$this->option_name}"][$key] : $default;
		}

		private function get_default_options() {
			$default_options = apply_filters("g5core_default_options_{$this->option_name}", $this->init_default());
			return $default_options;
		}
	}
}