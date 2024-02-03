<?php
/**
 *    Plugin Name: G5 Element
 *    Plugin URI: http://g5plus.net
 *    Description: The G5 Element plugin.
 *    Version: 1.2.7
 *    Author: G5
 *    Author URI: http://g5plus.net
 *
 *    Text Domain: g5-element
 *    Domain Path: /languages/
 *
 **/
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if ( ! defined( 'G5CORE_CURRENT_THEME' ) ) {
	define( 'G5CORE_CURRENT_THEME', basename( get_template_directory() ) );
}

if ( ! class_exists( 'G5Element' ) ) {
	class G5Element {
		private static $_instance;

		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public $meta_prefix = 'g5element_';

		public function __construct() {
			/*Auto load file*/
			spl_autoload_register( array( $this, 'auto_load' ) );
			add_action( 'plugins_loaded', array( $this, 'load_text_domain' ) );

			add_action( 'g5core_init', array( $this, 'init' ) );
		}

		public function init() {
			if (!class_exists('Vc_Manager')) {
				return;
			}
			$this->init_modules();
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
			$this->assets()->init();

			$this->template()->init();
			$this->customize()->init();
			$this->vc_params()->init();
			$this->shortcode()->init();
			do_action('g5element_init');
		}

		public function includes() {
			$this->load_file( $this->plugin_dir( 'inc/functions/function.php' ) );
			$this->load_file( $this->plugin_dir( 'inc/shortcode-base.class.php' ) );
			$this->load_file( $this->plugin_dir( 'vc-customize/vc-customize.php' ) );
			$this->load_file( $this->plugin_dir( 'vc-params/vc-params.class.php' ) );
		}

		public function load_text_domain() {
			load_plugin_textdomain( 'g5-element', false, $this->plugin_dir( 'languages' ) );
		}

		public function auto_load( $class ) {
			$file_name = preg_replace( '/^G5Element_/', '', $class );
			if ( $file_name !== $class ) {
				$path = '';
				if ( 0 === strpos( $class, 'G5Element_VC' ) ) {
					if ( preg_match( '/^G5Element_VC_/', $class ) ) {
						$file_name = preg_replace( '/^G5Element_VC_/', '', $class );
					}
					$path = 'vc/';
				}
				$file_name = strtolower( $file_name );
				$file_name = str_replace( '_', '-', $file_name );
				$this->load_file( $this->plugin_dir( "inc/{$path}{$file_name}.class.php" ) );
			}
		}

		public function assets_handle( $handle = '' ) {
			return apply_filters( 'g5element_assets_prefix', $this->meta_prefix ) . $handle;
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
					_doing_it_wrong( __FUNCTION__, __( 'action_args should not be overwritten when calling get_plugin_template.', 'g5-element' ), $this->plugin_ver() );
					unset( $args['action_args'] );
				}
				extract( $args ); // @codingStandardsIgnoreLine
			}

			include( $action_args['located']);

			return $action_args['located'];
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
					_doing_it_wrong( __FUNCTION__, __( 'action_args should not be overwritten when calling get_template.', 'g5-element' ), $this->plugin_ver() );
					unset( $args['action_args'] );
				}
				extract( $args ); // @codingStandardsIgnoreLine
			}
			if ( $action_args['located'] !== '' ) {
				do_action( 'g5element_before_template_part', $action_args['template_name'], $action_args['located'] ,$action_args['args']);
				include( $action_args['located'] );
				do_action( 'g5element_after_template_part', $action_args['template_name'], $action_args['located'] ,$action_args['args'] );
			}
		}


		public function template_path() {
			return apply_filters('g5element_template_path', 'g5plus/element/');
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

			$located = apply_filters( 'g5element_locate_template', $located, $template_name, $args );

			if ( ! file_exists( $located ) ) {
				return '';
			}

			// Return what we found.
			return $located;
		}

		public function plugin_ver() {
			if ( G5CORE()->cache()->exists( 'g5element_plugin_version' ) ) {
				return G5CORE()->cache()->get( 'g5element_plugin_version' );
			}
			if ( ! function_exists( 'get_plugin_data' ) ) {
				require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			}
			$plugin_data = get_plugin_data( __FILE__ );
			$plugin_ver  = isset( $plugin_data['Version'] ) ? $plugin_data['Version'] : '1.2.6';
			if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG === true ) {
				$plugin_ver = mt_rand() . '';
			}

			G5CORE()->cache()->set( 'g5element_plugin_version', $plugin_ver );

			return $plugin_ver;
		}

		/**
		 * @return G5Element_Assets
		 */
		public function assets() {
			return G5Element_Assets::getInstance();
		}

		/**
		 * @return G5Element_Template
		 */
		public function template() {
			return G5Element_Template::getInstance();
		}

		/**
		 * @return G5Element_Customize
		 */
		public function customize() {
			return G5Element_Customize::getInstance();
		}

        /**
         * @return G5Element_Settings
         */
		public function settings() {
		    return G5Element_Settings::getInstance();
        }

		/**
		 * @return G5Element_Vc_Params
		 */
		public function vc_params() {
			return G5Element_Vc_Params::getInstance();
		}

		public function shortcode() {
			return G5Element_ShortCode::getInstance();
		}
	}

	function G5ELEMENT() {
		return G5Element::getInstance();
	}

	G5ELEMENT();
}