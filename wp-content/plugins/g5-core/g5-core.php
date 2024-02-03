<?php
/**
 *    Plugin Name: G5 Core
 *    Plugin URI: http://g5plus.net
 *    Description: The G5 Core plugin.
 *    Version: 1.8.1
 *    Author: G5
 *    Author URI: http://g5plus.net
 *
 *    Text Domain: g5-core
 *    Domain Path: /languages/
 *
 * @package G5 Core
 * @category Core
 * @author G5
 *
 **/
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
if (!defined('G5CORE_CURRENT_THEME')) {
	define('G5CORE_CURRENT_THEME', basename(get_template_directory()));
}
if (!class_exists('G5Core')) {
	class G5Core {
		private static $_instance;

		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public $meta_prefix = 'g5core_';

		public function pre_init()
		{
			add_filter( 'gsf_loader_framework', array( $this, 'loader_framework' ) );
			$this->load_file($this->plugin_dir('lib/smart-framework/init.php'));
			add_action('gsf_after_setup_framework',array($this,'init'));
			add_action( 'after_setup_theme', array($this, 'register_nav_menus'), 20 );
		}
		function register_nav_menus() {
			register_nav_menus( array(
				'mobile'    => __( 'Mobile Menu', 'g5-core' ),
				'top-menu'    => __( 'Top Bar Menu', 'g5-core' ),
				'bottom-menu'    => __( 'Bottom Bar Menu', 'g5-core' ),
			) );
		}

		public function init() {
			/*Auto load file*/
			spl_autoload_register(array($this, 'auto_load'));
			add_action('after_setup_theme',array($this,'init_modules'),20);
			add_action( 'plugins_loaded', array($this,'load_text_domain'));


		}

		public function load_file($path) {
			if ( $path && is_readable($path) ) {
				include_once $path;
				return true;
			}
			return false;
		}

		public function options_name() {
			return apply_filters('g5core_options_name','g5core_options') ;
		}

		public function plugin_dir($path = '') {
			return plugin_dir_path(__FILE__) . $path;
		}

		public function plugin_url($path = '') {
			return trailingslashit(plugins_url(basename(__DIR__))) . $path;
		}

		public function theme_dir($path = '')
		{
			return trailingslashit(get_template_directory()) . $path;
		}

		public function theme_url($path = '')
		{
			return trailingslashit(get_template_directory_uri()) . $path;
		}

		public function loader_framework($frameworks) {
			$frameworks[] = array(
				'version' => '3.1.1',
				'path' => $this->plugin_dir('lib/smart-framework/'),
				'uri' => $this->plugin_url('lib/smart-framework/'),
				'plugin_file' => __FILE__,
			);
			return $frameworks;
		}

		public function init_modules() {
			$this->includes();
			$this->setup()->init();
			$this->cpt()->init();
			$this->assets()->init();
			$this->dashboard()->init();
			$this->config_options()->init();
			$this->config_header_options()->init();
			$this->config_footer_options()->init();
			$this->config_layout_options()->init();
			$this->config_page_title_options()->init();
			$this->config_typography_options()->init();
			$this->config_color_options()->init();
			$this->editor()->init();
			$this->xmenu()->init();
			$this->widget_areas()->init();
			$this->templates()->init();
			$this->ajax()->init();
			$this->custom_css()->init();
			$this->email()->init();
			$this->image_resize()->init();
			$this->widget()->init();
			$this->cache()->init();
			$this->lazy_load()->init();


			/**
			 * Remove enqueue font style in theme
			 */
			remove_filter( 'editor_stylesheets', G5CORE_CURRENT_THEME . '_custom_editor_styles', 100 );
			remove_action( 'enqueue_block_editor_assets', G5CORE_CURRENT_THEME . '_scripts_font', 100 );
			remove_action( 'wp_enqueue_scripts', G5CORE_CURRENT_THEME . '_scripts_font', 100 );

			do_action('g5core_init');
		}

		public function includes() {
			$this->load_file($this->plugin_dir('inc/functions/function.php'));
		}

		public function load_text_domain() {
			load_plugin_textdomain( 'g5-core', false, $this->plugin_dir('languages'));
		}

		public function auto_load($class){
			$file_name = preg_replace('/^G5Core_/', '', $class);
			if ($file_name !== $class) {
				$path  = '';
				if ( 0 === strpos( $class, 'G5Core_Widget_Areas' )  ) {
					$path = 'widget-areas/';
				} elseif ( 0 === strpos( $class, 'G5P_Widget' )  ) {
					if (preg_match('/^G5P_Widget_/',$class)) {
						$file_name = preg_replace('/^G5P_Widget_/', '', $class);
					}
					$path = 'widgets/';
				} elseif ( 0 === strpos( $class, 'G5P_Core' )  ) {
					$path = 'core/';
				} elseif ( 0 === strpos( $class, 'G5Core_Dashboard' )  ) {
					if (preg_match('/^G5Core_Dashboard_/',$class)) {
						$file_name = preg_replace('/^G5Core_Dashboard_/', '', $class);
					}
					$path = 'dashboard/';
				} elseif ( 0 === strpos( $class, 'G5Core_XMenu' )  ) {
					$path = 'xmenu/';
				} elseif (0 === strpos( $class, 'G5Core_Editor' )) {
					if (preg_match('/^G5Core_Editor_/',$class)) {
						$file_name = preg_replace('/^G5Core_Editor_/', '', $class);
					}
					$path = 'editor/';
				}
				$file_name = strtolower($file_name);
				$file_name = str_replace('_', '-', $file_name);
				$this->load_file($this->plugin_dir("inc/{$path}{$file_name}.class.php"));

			}
		}

		public function assets_handle($handle = '') {
			return apply_filters('g5core_assets_prefix', 'g5core_') . $handle;
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
					_doing_it_wrong( __FUNCTION__, __( 'action_args should not be overwritten when calling get_plugin_template.', 'g5-core' ), $this->plugin_ver() );
					unset( $args['action_args'] );
				}
				extract( $args ); // @codingStandardsIgnoreLine
			}

			include( $action_args['located']);

			return $action_args['located'];
		}


		public function template_path() {
			return apply_filters('g5core_template_path', 'g5plus/core/');
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
					_doing_it_wrong( __FUNCTION__, __( 'action_args should not be overwritten when calling get_template.', 'g5-core' ), $this->plugin_ver() );
					unset( $args['action_args'] );
				}
				extract( $args ); // @codingStandardsIgnoreLine
			}

			if ($action_args['located'] !== '') {
				do_action( 'g5core_before_template_part', $action_args['template_name'], $action_args['located'], $action_args['args'] );
				include( $action_args['located'] );
				do_action( 'g5core_after_template_part', $action_args['template_name'], $action_args['located'], $action_args['args'] );
			}
		}

		public function locate_template($template_name, $args = array()) {
			$located = '';

			// Theme or child theme template
			$template = trailingslashit(get_stylesheet_directory()) . $this->template_path() . $template_name;
			if (file_exists($template)) {
				$located = $template;
			} else {
				$template = trailingslashit(get_template_directory()) . $this->template_path() . $template_name;
				if (file_exists($template)) {
					$located = $template;
				}
			}

			// Plugin template
			if (! $located) {
				$located = $this->plugin_dir() . 'templates/' . $template_name;
			}

			$located = apply_filters( 'g5core_locate_template', $located, $template_name, $args);

			if (!file_exists($located)) {
				_doing_it_wrong(__FUNCTION__, sprintf('<code>%s</code> does not exist.', $located), $this->plugin_ver());
				return '';
			}

			// Return what we found.
			return $located;
		}

		public function plugin_ver() {
			if (G5CORE()->cache()->exists('g5core_plugin_version')) {
				return G5CORE()->cache()->get('g5core_plugin_version');
			}
			if (!function_exists('get_plugin_data')) {
				require_once(ABSPATH . 'wp-admin/includes/plugin.php');
			}
			$plugin_data = get_plugin_data( __FILE__ );
			$plugin_ver = isset($plugin_data['Version']) ? $plugin_data['Version'] : '1.7.3';
			if (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG === true) {
				$plugin_ver = mt_rand() . '';
			}

			G5CORE()->cache()->set('g5core_plugin_version', $plugin_ver);
			return $plugin_ver;
		}

		public function is_dev(){
			return function_exists('G5Core_DEV');
		}

		/**
		 * @return G5Core_File
		 */
		public function file(){
			return G5Core_File::getInstance();
		}

		/**
		 * @return G5Core_Dashboard
		 */
		public function dashboard(){
			return G5Core_Dashboard::getInstance();
		}

		/**
		 * @return G5Core_Assets
		 */
		public function assets(){
			return G5Core_Assets::getInstance();
		}

		/**
		 * @return G5Core_Editor
		 */
		public function editor(){
			return G5Core_Editor::getInstance();
		}


		/**
		 * @return G5Core_Widget_Areas
		 */
		public function widget_areas(){
			return G5Core_Widget_Areas::getInstance();
		}

		/**
		 * @return G5Core_XMenu
		 */
		public function xmenu(){
			return G5Core_XMenu::getInstance();
		}

		public function theme_info() {
			return  apply_filters( 'g5core_theme_info', array(
				'support' => 'http://sp.g5plus.net/',
				'docs'    => '#',
				'knowledgeBase' => 'https://g5plus.net/knowledge-base/',
				'video_tutorials_url' => '#',
				'changelog' => '#',
			) );
		}


		/**
		 * @return G5Core_Settings
		 */
		public function settings() {
			return G5Core_Settings::getInstance();
		}

		/**
		 * @return G5Core_Fields
		 */
		public function fields() {
			return G5Core_Fields::getInstance();
		}

		/**
		 * @return G5Core_Options
		 */
		public function options() {
			return G5Core_Options::getInstance();
		}

		/**
		 * @return G5Core_Post_Type
		 */
		public function cpt() {
			return G5Core_Post_Type::getInstance();
		}

		/**
		 * @return G5Core_Setup
		 */
		public function setup() {
			return G5Core_Setup::getInstance();
		}

		/**
		 * @return G5Core_Templates
		 */
		public function templates() {
			return G5Core_Templates::getInstance();
		}

		public function ajax() {
			return G5Core_Ajax::getInstance();
		}

		/**
		 * @return G5Core_Custom_Css
		 */
		public function custom_css() {
			return G5Core_Custom_Css::getInstance();
		}

		/**
		 * @return G5Core_Email
		 */
		public function email() {
			return G5Core_Email::getInstance();
		}

		/**
		 * @return G5Core_Breadcrumbs
		 */
		public function breadcrumbs() {
			return G5Core_Breadcrumbs::getInstance();
		}

		/**
		 * @return G5Core_Config_Options
		 */
		public function config_options() {
			return G5Core_Config_Options::getInstance();
		}

		/**
		 * @return G5Core_Config_Header_Options
		 */
		public function config_header_options() {
			return G5Core_Config_Header_Options::getInstance();
		}

		/**
		 * @return G5Core_Config_Footer_Options
		 */
		public function config_footer_options() {
			return G5Core_Config_Footer_Options::getInstance();
		}

		/**
		 * @return G5Core_Config_Layout_Options
		 */
		public function config_layout_options() {
			return G5Core_Config_Layout_Options::getInstance();
		}

		/**
		 * @return G5Core_Config_Page_Title_Options
		 */
		public function config_page_title_options() {
			return G5Core_Config_Page_Title_Options::getInstance();
		}

		/**
		 * @return G5Core_Config_Typography_Options
		 */
		public function config_typography_options() {
			return G5Core_Config_Typography_Options::getInstance();
		}

		/**
		 * @return G5Core_Config_Color_Options
		 */
		public function config_color_options() {
			return G5Core_Config_Color_Options::getInstance();
		}

		/**
		 * @return G5Core_Cache
		 */
		public function cache() {
			return G5Core_Cache::getInstance();
		}

        /**
         * @return G5Core_Query
         */
		public function query() {
		    return G5Core_Query::getInstance();
        }

        /**
         * @return G5Core_Image_Resize
         */
        public function image_resize() {
		    return G5Core_Image_Resize::getInstance();
        }

        /**
         * @return G5Core_Widget
         */
        public function widget() {
            return G5Core_Widget::getInstance();
        }

		/**
		 * @return G5Core_Lazy_Load
		 */
		public function lazy_load() {
			return G5Core_Lazy_Load::getInstance();
		}

	}

	function G5CORE() {
		return G5Core::getInstance();
	}

	G5CORE()->pre_init();
}
