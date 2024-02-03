<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if ( ! class_exists( 'G5Core_Config_Page_Title_Options' ) ) {
	class G5Core_Config_Page_Title_Options {
		/*
		 * loader instances
		 */
		private static $_instance;

		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init() {
			// Defined Options
			add_filter( 'gsf_option_config', array( $this, 'define_options' ), 50 );
			add_filter( 'gsf_meta_box_config', array( $this, 'define_post_meta' ), 50 );
			add_filter( 'gsf_term_meta_config', array( $this, 'define_term_meta' ) );

			add_action( 'template_redirect', array( $this, 'change_page_setting' ) );


			add_action('init',array($this,'change_page_title'));

			add_filter('ube_page_title',array($this,'change_ube_page_title'));

			add_filter('ube_page_subtitle',array($this,'change_ube_page_subtitle'));


		}

		public function change_page_title() {
			remove_action( G5CORE_CURRENT_THEME . '_before_main_content', G5CORE_CURRENT_THEME . '_template_page_title', 10 );
			add_action( G5CORE_CURRENT_THEME . '_before_main_content', array( $this, 'page_title_template' ), 10 );
		}

		public function options_name() {
			return apply_filters('g5core_page_title_options_name','g5core_page_title_options');
		}

		public function define_options( $configs ) {
			$configs['g5core_page_title_options'] = array(
				'layout'      => 'inline',
				'page_title'  => esc_html__( 'Page Title Options', 'g5-core' ),
				'menu_title'  => esc_html__( 'Page Title', 'g5-core' ),
				'option_name' => G5Core_Config_Page_Title_Options::getInstance()->options_name(),
				'parent_slug' => 'g5core_options',
				'permission'  => 'manage_options',
				'fields'     => $this->config_option()
			);

			return $configs;
		}

		public function config_option() {
			return array(
				'page_title_enable' => G5CORE()->fields()->get_config_toggle( array(
					'id'       => 'page_title_enable',
					'title'    => esc_html__( 'Page Title Enable', 'g5-core' ),
					'subtitle' => esc_html__( 'Turn Off this option if you want to hide page title', 'g5-core' ),
					'default'  => 'on',
				) ),

				'page_title_layout'                => array(
					'id'       => 'page_title_layout',
					'title'    => esc_html__( 'Page Title Layout', 'g5-core' ),
					'subtitle' => esc_html__( 'Specify the layout to use as a page title.', 'g5-core' ),
					'type'     => 'select',
					'options'  => G5CORE()->settings()->get_page_title_layout(),
					'default'  => G5CORE()->options()->page_title()->get_default( 'page_title_layout' ),
					'required' => array( 'page_title_enable', '=', 'on' ),
				),

				'page_title_content_block' => g5core_config_content_block( array(
					'id'       => 'page_title_content_block',
					'subtitle' => esc_html__( 'Specify the Content Block to use as a page title.', 'g5-core' ),
					'default'  => '',
					'data_args'   => array(
						'numberposts' => - 1,
						'meta_key' => G5CORE()->meta_prefix . 'content_block_type',
						'meta_value' => 'page_title',
						'meta_compare' => '='
					),
					'required' => array( 'page_title_enable', '=', 'on' ),
				) ),

				'page_title_divide'        => array(
					'type'  => 'divide',
					'style' => 'large'
				),
				'breadcrumb_enable'        => G5CORE()->fields()->get_config_toggle( array(
					'id'       => 'breadcrumb_enable',
					'title'    => esc_html__( 'Breadcrumb Enable', 'g5-core' ),
					'subtitle' => esc_html__( 'Turn Off this option if you want to hide breadcrumb', 'g5-core' ),
					'default'  => 'on',
					'required' => array( 'page_title_enable', '=', 'on' ),
				) ),

				'breadcrumb_show_categories' => G5CORE()->fields()->get_config_toggle( array(
					'id'       => 'breadcrumb_show_categories',
					'title'    => esc_html__( 'Show Post Categories in Breadcrumb', 'g5-core' ),
					'subtitle' => esc_html__( 'Turn on to display the post categories in the breadcrumbs path', 'g5-core' ),
					'default'  => 'on',
					'required' => array(
						array( 'breadcrumb_enable', '=', 'on' ),
						array( 'page_title_enable', '=', 'on' ),
					),
				) ),
				'breadcrumb_show_post_type_archive' => G5CORE()->fields()->get_config_toggle( array(
					'id'       => 'breadcrumb_show_post_type_archive',
					'title'    => esc_html__( 'Show Post Type Archives in Breadcrumb', 'g5-core' ),
					'subtitle' => esc_html__( 'Turn on to display post type archives in the breadcrumbs path.', 'g5-core' ),
					'default'  => '',
					'required' => array(
						array( 'breadcrumb_enable', '=', 'on' ),
						array( 'page_title_enable', '=', 'on' ),
					),
				) ),
			);
		}

		public function define_post_meta($configs) {
			$prefix                            = G5CORE()->meta_prefix;
			$configs['g5core_page_title_meta'] = array(
				'name'      => esc_html__( 'Page Title Settings', 'g5-core' ),
				'post_type' => array_keys( g5core_post_types_active() ),
				'layout'    => 'inline',
				'fields'    => array(
					"{$prefix}page_title_enable" => G5CORE()->fields()->get_config_toggle( array(
						'id'       => "{$prefix}page_title_enable",
						'title'    => esc_html__( 'Page Title Enable', 'g5-core' ),
						'subtitle' => esc_html__( 'Turn Off this option if you want to hide page title', 'g5-core' ),
						'default'  => ''
					), true ),

					"{$prefix}page_title_content_block" => g5core_config_content_block( array(
						'id'       => "{$prefix}page_title_content_block",
						'subtitle' => esc_html__( 'Specify the Content Block to use as a page title.', 'g5-core' ),
						'default'  => '',
						'data_args'   => array(
							'numberposts' => - 1,
							'meta_key' => G5CORE()->meta_prefix . 'content_block_type',
							'meta_value' => 'page_title',
							'meta_compare' => '='
						),
						'required' => array( "{$prefix}page_title_enable", '!=', 'off' ),
					) ),
					"{$prefix}page_title_custom"                                  => array(
						'id' => "{$prefix}page_title_custom",
						'type' => 'text',
						'title' => esc_html__('Page Title Custom','g5-core'),
						'default'  => '',
						'required' => array( "{$prefix}page_title_enable", '!=', 'off' ),
					),
					"{$prefix}page_subtitle_custom"                                  => array(
						'id' => "{$prefix}page_subtitle_custom",
						'type' => 'text',
						'title' => esc_html__('Page Subtitle Custom','g5-core'),
						'default'  => '',
						'required' => array( "{$prefix}page_title_enable", '!=', 'off' ),
					),
					"{$prefix}breadcrumb_enable"        => G5CORE()->fields()->get_config_toggle( array(
						'id'       => "{$prefix}breadcrumb_enable",
						'title'    => esc_html__( 'Breadcrumb Enable', 'g5-core' ),
						'subtitle' => esc_html__( 'Turn Off this option if you want to hide breadcrumb', 'g5-core' ),
						'default'  => '',
						'required' => array( "{$prefix}page_title_enable", '!=', 'off' ),
					), true ),
				)
			);
			return $configs;
		}

		public function define_term_meta($configs) {
			$prefix                            = G5CORE()->meta_prefix;
			$configs['g5core_page_title_meta'] = array(
				'name'      => esc_html__( 'Page Title Settings', 'g5-core' ),
				'taxonomy'  => g5core_get_taxonomy_for_term_meta(),
				'layout'    => 'inline',
				'fields'    => array(
					"{$prefix}page_title_enable" => G5CORE()->fields()->get_config_toggle( array(
						'id'       => "{$prefix}page_title_enable",
						'title'    => esc_html__( 'Page Title Enable', 'g5-core' ),
						'subtitle' => esc_html__( 'Turn Off this option if you want to hide page title', 'g5-core' ),
						'default'  => '',
					), true ),

					"{$prefix}page_title_content_block" => g5core_config_content_block( array(
						'id'       => "{$prefix}page_title_content_block",
						'subtitle' => esc_html__( 'Specify the Content Block to use as a page title.', 'g5-core' ),
						'default'  => '',
						'required' => array( "{$prefix}page_title_enable", '!=', 'off' ),
					) ),
					"{$prefix}breadcrumb_enable"        => G5CORE()->fields()->get_config_toggle( array(
						'id'       => "{$prefix}breadcrumb_enable",
						'title'    => esc_html__( 'Breadcrumb Enable', 'g5-core' ),
						'subtitle' => esc_html__( 'Turn Off this option if you want to hide breadcrumb', 'g5-core' ),
						'default'  => '',
						'required' => array( "{$prefix}page_title_enable", '!=', 'off' ),
					), true ),
				)
			);
			return $configs;
		}


		public function page_title_template() {
			G5CORE()->get_template( 'page-title.php' );
		}

		public function change_page_setting() {
			$content_404_block = G5CORE()->options()->get_option('page_404_custom');
			if ( is_singular() || (is_404() && !empty($content_404_block)) ) {
				$id     = is_404() ? $content_404_block : get_the_ID();

				$prefix = G5CORE()->meta_prefix;

				$page_title_enable     = get_post_meta( $id, "{$prefix}page_title_enable", true );
				$page_title_content_block     = get_post_meta( $id, "{$prefix}page_title_content_block", true );
				$breadcrumb_enable         = get_post_meta( $id, "{$prefix}breadcrumb_enable", true );

				if ( ! empty( $page_title_enable ) ) {
					G5CORE()->options()->page_title()->set_option( 'page_title_enable', $page_title_enable );
				}

				if ( ! empty( $page_title_content_block ) ) {
					G5CORE()->options()->page_title()->set_option( 'page_title_content_block', $page_title_content_block );
				}

				if ( ! empty( $breadcrumb_enable ) ) {
					G5CORE()->options()->page_title()->set_option( 'breadcrumb_enable', $breadcrumb_enable );
				}
			}

			if (is_archive()) {
				$queried_object = get_queried_object();
				if (($queried_object !== null) && (isset($queried_object->term_id))) {
					$id = $queried_object->term_id;
					$prefix = G5CORE()->meta_prefix;

					$page_title_enable     = get_term_meta( $id, "{$prefix}page_title_enable", true );
					$page_title_content_block     = get_term_meta( $id, "{$prefix}page_title_content_block", true );
					$breadcrumb_enable         = get_term_meta( $id, "{$prefix}breadcrumb_enable", true );

					if ( ! empty( $page_title_enable ) ) {
						G5CORE()->options()->page_title()->set_option( 'page_title_enable', $page_title_enable );
					}

					if ( ! empty( $page_title_content_block ) ) {
						G5CORE()->options()->page_title()->set_option( 'page_title_content_block', $page_title_content_block );
					}

					if ( ! empty( $breadcrumb_enable ) ) {
						G5CORE()->options()->page_title()->set_option( 'breadcrumb_enable', $breadcrumb_enable );
					}
				}
			}

			if (is_singular('g5core_content')) {
				$content_type = get_post_meta(get_the_ID(),'g5core_content_block_type',true);
				if ($content_type === 'page_title') {
					G5CORE()->options()->page_title()->set_option('page_title_content_block',get_the_ID());
				}
			}

		}

		public function change_ube_page_title($page_title) {

			if (is_category() || is_tax()) {
				$term = get_queried_object();
				if ($term && property_exists($term, 'term_id')) {
					$page_title_content = get_term_meta($term->term_id, G5CORE()->meta_prefix . 'page_title_custom', true);

					if ($page_title_content !== '') {
						$page_title = $page_title_content;
					}
				}
			}

			if (is_singular()) {
				$page_title_content = get_post_meta( get_the_ID(), G5CORE()->meta_prefix . 'page_title_custom', true);
				if ($page_title_content !== '') {
					$page_title = $page_title_content;
				}
			}

			return $page_title;
		}

		public function change_ube_page_subtitle($page_subtitle) {
			if (is_singular()) {
				$page_subtitle_content = get_post_meta( get_the_ID(), G5CORE()->meta_prefix . 'page_subtitle_custom', true);
				if ($page_subtitle_content !== '') {
					$page_subtitle = $page_subtitle_content;
				}
			}
			return $page_subtitle;
		}
	}
}