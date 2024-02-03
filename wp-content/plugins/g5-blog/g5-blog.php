<?php
/**
 *    Plugin Name: G5 Blog
 *    Plugin URI: http://g5plus.net
 *    Description: The G5 Blog plugin.
 *    Version: 1.1.8
 *    Author: G5
 *    Author URI: http://g5plus.net
 *
 *    Text Domain: g5-blog
 *    Domain Path: /languages/
 *
 **/
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! class_exists( 'G5BLOG' ) ) {
	class G5BLOG {
		private static $_instance;

		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public $meta_prefix = 'g5blog_';

		public function __construct() {
			add_action( 'g5core_init', array( $this, 'init' ) );
			add_action( 'plugins_loaded', array( $this, 'load_text_domain' ) );
			spl_autoload_register( array( $this, 'auto_load' ) );
			add_action( 'admin_notices', array( $this, 'admin_notices' ) );
		}

		public function init() {
			remove_action( 'admin_notices', array( $this, 'admin_notices' ) );
			G5Blog_Elementor::getInstance()->init();
			$this->includes();
			$this->assets()->init();
			$this->config_options()->init();
			$this->templates()->init();
			$this->widget()->init();
			$this->listing()->init();
			$this->shortcodes()->init();
			G5Blog_Post_Views_Counter::getInstance()->init();
			do_action( 'g5blog_init' );
		}


		public function admin_notices() {
			?>
			<div class="error">
				<p><?php esc_html_e( 'G5 Blog is enabled but not effective. It requires G5 Core in order to work.', 'g5-blog' ); ?></p>
			</div>
			<?php
		}

		public function includes() {
			$this->load_file( $this->plugin_dir( 'inc/functions/function.php' ) );
		}


		public function load_file( $path ) {
			if ( $path && is_readable( $path ) ) {
				include_once $path;

				return true;
			}

			return false;
		}

		public function load_text_domain() {
			load_plugin_textdomain( 'g5-blog', false, $this->plugin_dir( 'languages' ) );
		}

		public function plugin_dir( $path = '' ) {
			return plugin_dir_path( __FILE__ ) . $path;
		}

		public function plugin_url( $path = '' ) {
			return trailingslashit( plugins_url( '/', __FILE__ ) ) . $path;
		}


		public function auto_load($class) {
			$file_name = preg_replace('/^G5Blog_/', '', $class);
			if ($file_name !== $class) {
				$path  = '';
				if ( 0 === strpos( $class, 'G5Blog_Widget' )  ) {
					if (preg_match('/^G5Blog_Widget_/',$class)) {
						$file_name = preg_replace('/^G5Blog_Widget_/', '', $class);
					}
					$path = 'widgets/';
				}

				$file_name = strtolower($file_name);
				$file_name = str_replace('_', '-', $file_name);
				$this->load_file($this->plugin_dir("inc/{$path}{$file_name}.class.php"));
			}
		}

		public function assets_handle( $handle = '' ) {
			return apply_filters( 'g5blog_assets_prefix', 'g5blog_' ) . $handle;
		}

		public function asset_url( $file ) {
			if ( ! file_exists( $this->plugin_dir( $file ) ) || ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ) {
				$ext         = explode( '.', $file );
				$ext         = end( $ext );
				$normal_file = preg_replace( '/((\.min\.css)|(\.min\.js))$/', '', $file );
				if ( $normal_file != $file ) {
					$normal_file = untrailingslashit( $normal_file ) . ".{$ext}";
					if ( file_exists( $this->plugin_dir( $normal_file ) ) ) {
						return $this->plugin_url( untrailingslashit( $normal_file ) );
					}
				}
			}

			return $this->plugin_url( untrailingslashit( $file ) );
		}

		public function get_plugin_template( $slug, $args = array() ) {
			$located = $this->plugin_dir( $slug );

			$action_args = array(
				'located'       => $located,
			);

			if ( ! file_exists( $action_args['located'] ) ) {
				_doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $slug ), $this->plugin_ver() );
				return '';
			}

			if ( ! empty( $args ) && is_array( $args ) ) {
				if ( isset( $args['action_args'] ) ) {
					_doing_it_wrong( __FUNCTION__, __( 'action_args should not be overwritten when calling get_plugin_template.', 'g5-blog' ), $this->plugin_ver() );
					unset( $args['action_args'] );
				}
				extract( $args ); // @codingStandardsIgnoreLine
			}

			include( $action_args['located']);

			return $action_args['located'];
		}

		public function get_template( $template_name, $args = array() ) {
			$located = $this->locate_template($template_name, $args);
			$action_args = array(
				'template_name' => $template_name,
				'located'       => $located,
				'args'          => $args,
			);

			if ( ! empty( $args ) && is_array( $args ) ) {
				if ( isset( $args['action_args'] ) ) {
					_doing_it_wrong( __FUNCTION__, __( 'action_args should not be overwritten when calling get_template.', 'g5-blog' ), $this->plugin_ver() );
					unset( $args['action_args'] );
				}
				extract( $args ); // @codingStandardsIgnoreLine
			}

			if ($action_args['located'] !== '') {
				do_action( 'g5blog_before_template_part', $action_args['template_name'], $action_args['located'], $action_args['args'] );
				include( $action_args['located'] );
				do_action( 'g5blog_after_template_part', $action_args['template_name'], $action_args['located'], $action_args['args'] );
			}
		}

		public function template_path() {
			return apply_filters( 'g5blog_template_path', 'g5plus/blog/' );
		}

		public function locate_template( $template_name, $args = array() ) {
			$located = '';

			// Theme or child theme template
			$template = trailingslashit( get_stylesheet_directory() ) . $this->template_path() . $template_name;
			if ( file_exists( $template ) ) {
				$located = $template;
			} else {
				$template = trailingslashit( get_template_directory() ) . $this->template_path() . $template_name;
				if ( file_exists( $template ) ) {
					$located = $template;
				}
			}

			// Plugin template
			if ( ! $located ) {
				$located = $this->plugin_dir() . 'templates/' . $template_name;
			}

			$located = apply_filters( 'g5blog_locate_template', $located, $template_name, $args );

			if ( ! file_exists( $located ) ) {
				_doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $located ), $this->plugin_ver() );

				return '';
			}

			// Return what we found.
			return $located;
		}

		public function plugin_ver() {
			if ( G5CORE()->cache()->exists( 'g5blog_plugin_version' ) ) {
				return G5CORE()->cache()->get( 'g5blog_plugin_version' );
			}

			if ( ! function_exists( 'get_plugin_data' ) ) {
				require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			}
			$plugin_data = get_plugin_data( __FILE__ );
			$plugin_ver  = isset( $plugin_data['Version'] ) ? $plugin_data['Version'] : '1.1.5';
			if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG === true ) {
				$plugin_ver = mt_rand() . '';
			}

			G5CORE()->cache()->set( 'g5blog_plugin_version', $plugin_ver );

			return $plugin_ver;
		}

		/**
		 * @return G5Blog_Assets
		 */
		public function assets() {
			return G5Blog_Assets::getInstance();
		}

		/**
		 * @return G5Blog_Options
		 */
		public function options() {
			return G5Blog_Options::getInstance();
		}


		/**
		 * @return G5Blog_Config_Options
		 */
		public function config_options() {
			return G5Blog_Config_Options::getInstance();
		}

		/**
		 * @return G5Blog_Settings
		 */
		public function settings() {
			return G5Blog_Settings::getInstance();
		}


		/**
		 * @return G5Blog_Templates
		 */
		public function templates() {
			return G5Blog_Templates::getInstance();
		}

		/**
		 * @return G5Blog_Listing
		 */
		public function listing() {
			return G5Blog_Listing::getInstance();
		}

		/**
		 * @return G5Blog_Widget
		 */
		public function widget() {
			return G5Blog_Widget::getInstance();
		}

		/**
		 * @return G5Blog_ShortCodes
		 */
		public function shortcodes() {
			return G5Blog_ShortCodes::getInstance();
		}

	}

	function G5BLOG() {
		return G5BLOG::getInstance();
	}

	G5BLOG();
}