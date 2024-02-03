<?php
/**
 *    Plugin Name: HomeId Addons
 *    Plugin URI: http://g5plus.net
 *    Description: Addons For HomeId Theme
 *    Version: 1.1.3
 *    Author: G5
 *    Author URI: http://g5plus.net
 *
 *    Text Domain: homeId-addons
 *    Domain Path: /languages/
 *
 * @author G5
 *
 **/
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
if (!defined('G5CORE_CURRENT_THEME')) {
	define('G5CORE_CURRENT_THEME', basename(get_template_directory()));
}

if (!class_exists('G5ThemeAddons')) {
	class G5ThemeAddons {
		private static $_instance;

		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public $meta_prefix = 'gta_';

		public function __construct()
		{
			/*Auto load file*/
			spl_autoload_register( array( $this, 'auto_load' ) );
			add_action( 'plugins_loaded', array( $this, 'load_text_domain' ) );
			add_action( 'g5core_init', array( $this, 'init' ) );
            add_action( 'admin_notices', array( $this, 'admin_notices' ) );
		}

		public function init() {
            remove_action( 'admin_notices', array( $this, 'admin_notices' ) );
			$this->init_modules();
			$this->setup_theme_data()->init();
			$this->setup_install_demo()->init();
		}

        public function admin_notices() {
            ?>
            <div class="error">
                <p><?php esc_html_e('HomeId Addons is enabled but not effective. It requires G5 Core in order to work.','homeId-addons'); ?></p>
            </div>
            <?php
        }

		public function load_file( $path ) {
			if ( $path && is_readable( $path ) ) {
				include_once $path;

				return true;
			}

			return false;
		}

		public function plugin_dir( $path = '' ) {
			return plugin_dir_path( __FILE__ ) . $path;
		}

		public function plugin_url( $path = '' ) {
			return trailingslashit( plugins_url( basename( __DIR__ ) ) ) . $path;
		}

		public function init_modules() {
			$this->includes();
		}

		public function includes() {
			$this->load_file($this->plugin_dir('inc/functions/functions.php'));
			$this->load_file($this->plugin_dir('inc/functions/elementor.php'));
		}

		public function load_text_domain() {
			load_plugin_textdomain( 'homeId-addons', false, $this->plugin_dir('languages'));
		}

		public function auto_load($class){
			$file_name = preg_replace('/^G5ThemeAddons_/', '', $class);
			if ($file_name !== $class) {
				$path  = '';
				$file_name = strtolower($file_name);
				$file_name = str_replace('_', '-', $file_name);
				$this->load_file($this->plugin_dir("inc/{$path}{$file_name}.class.php"));

			}
		}

		public function assets_handle($handle = '') {
			return $this->meta_prefix . $handle;
		}


		public function asset_url($file) {
			if (!file_exists($this->plugin_dir($file)) || (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG)) {
				$ext = explode('.', $file);
				$ext = end($ext);
				$normal_file = preg_replace('/((\.min\.css)|(\.min\.js))$/', '', $file);
				if ($normal_file != $file) {
					$normal_file = untrailingslashit($normal_file) . ".{$ext}";
					if (file_exists($this->plugin_dir($normal_file))) {
						return $this->plugin_url(untrailingslashit($normal_file));
					}
				}
			}
			return $this->plugin_url(untrailingslashit($file));
		}

		public function get_plugin_template($slug, $args = array()) {
			if ($args && is_array($args)) {
				extract($args);
			}
			$located = $this->plugin_dir($slug );
			if (!file_exists($located)) {
				return '';
			}
			include($located);

			return $located;
		}

        public function get_template( $template_name, $args = array() ) {
            $located = $this->locate_template( $template_name, $args );
            $action_args = array(
                'template_name' => $template_name,
                'located'       => $located,
                'args'          => $args,
            );

            if ( ! empty( $args ) && is_array( $args ) ) {
                if ( isset( $args['action_args'] ) ) {
                    unset( $args['action_args'] );
                }
                extract( $args ); // @codingStandardsIgnoreLine
            }
            if ( $action_args['located'] !== '' ) {
                do_action( 'gta_before_template_part', $action_args['template_name'], $action_args['located'] ,$action_args['args']);
                include( $action_args['located'] );
                do_action( 'gta_after_template_part', $action_args['template_name'], $action_args['located'] ,$action_args['args'] );
            }
        }

		public function locate_template($template_name, $args = array()) {
			$located = '';

			// Theme or child theme template
			$template = trailingslashit(get_stylesheet_directory()) . 'g5plus/gta/' . $template_name;
			if (file_exists($template)) {
				$located = $template;
			} else {
				$template = trailingslashit(get_template_directory()) . 'g5plus/gta/' . $template_name;
				if (file_exists($template)) {
					$located = $template;
				}
			}

			// Plugin template
			if (! $located) {
				$located = $this->plugin_dir() . 'templates/' . $template_name;
			}

			$located = apply_filters( 'gta_locate_template', $located, $template_name, $args);

			if (!file_exists($located)) {
				return '';
			}

			// Return what we found.
			return $located;
		}

		public function plugin_ver() {
			if (G5CORE()->cache()->exists('gta_plugin_version')) {
				return G5CORE()->cache()->get('gta_plugin_version');
			}
			if (!function_exists('get_plugin_data')) {
				require_once(ABSPATH . 'wp-admin/includes/plugin.php');
			}
			$plugin_data = get_plugin_data( __FILE__ );
			$plugin_ver = isset($plugin_data['Version']) ? $plugin_data['Version'] : '1.1.3';
			if (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG === true) {
				$plugin_ver = mt_rand() . '';
			}

			G5CORE()->cache()->set('gta_plugin_version', $plugin_ver);
			return $plugin_ver;
		}



		/**
		 * @return G5ThemeAddons_Setup_Theme_Data
		 */
		public function setup_theme_data() {
			return G5ThemeAddons_Setup_Theme_Data::getInstance();
		}


		/**
		 * @return G5ThemeAddons_Setup_Install_Demo
		 */
		public function setup_install_demo() {
			return G5ThemeAddons_Setup_Install_Demo::getInstance();
		}


	}

	function GTA() {
		return G5ThemeAddons::getInstance();
	}

	GTA();
}
