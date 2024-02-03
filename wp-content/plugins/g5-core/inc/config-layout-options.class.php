<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if ( ! class_exists( 'G5Core_Config_Layout_Options' ) ) {
	class G5Core_Config_Layout_Options {
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
			add_filter( 'gsf_option_config', array( $this, 'define_options' ), 40 );
			add_filter( 'gsf_meta_box_config', array( $this, 'define_meta_box' ), 40 );

			add_filter( G5CORE_CURRENT_THEME . '_sidebar_classes', array( $this, 'sidebar_class_filter' ) );
			add_filter( G5CORE_CURRENT_THEME . '_sidebar_name', array( $this, 'sidebar_name_filter' ) );
			add_filter( G5CORE_CURRENT_THEME . '_has_sidebar', array( $this, 'has_sidebar_filter' ) );

			//add_filter(G5CORE_CURRENT_THEME. '_content_wrapper_classes', array($this,'site_stretched_content'));

			add_filter( 'body_class', array( $this, 'body_class' ) );
			add_action( 'template_redirect', array( $this, 'change_page_setting' ) );
			add_action( 'template_redirect', array( $this, 'change_layout' ), 11 );
			add_action( 'wp_footer', array( $this, 'site_style_bordered_html' ) );

		}

		public function options_name() {
			return apply_filters('g5core_layout_options_name','g5core_layout_options');
		}

		public function define_options( $configs ) {
			$configs['g5core_layout_options'] = array(
				'layout'      => 'inline',
				'page_title'  => esc_html__( 'Layout Options', 'g5-core' ),
				'menu_title'  => esc_html__( 'Layout', 'g5-core' ),
				'option_name' => G5Core_Config_Layout_Options::getInstance()->options_name(),
				'parent_slug' => 'g5core_options',
				'permission'  => 'manage_options',
				'fields'      => $this->config_option(),
			);

			return $configs;
		}

		public function config_option() {
			return array(
				'site_style'             => array(
					'id'      => 'site_style',
					'title'   => esc_html__( 'Site Style', 'g5-core' ),
					'type'    => 'image_set',
					'options' => G5CORE()->settings()->get_site_style(),
					'default' => G5CORE()->options()->layout()->get_default( 'site_style', 'wide' ),
				),
				'boxed_background_color' => array(
					'id'       => 'boxed_background_color',
					'title'    => esc_html__( 'Boxed Background Color', 'g5-core' ),
					'desc'     => esc_html__( 'Specify the background color for boxed style', 'g5-core' ),
					'type'     => 'background',
					'default'  => G5CORE()->options()->layout()->get_default( 'boxed_background_color', array(
						'background_color' => '#eee'
					) ),
					'required' => array( 'site_style', '=', 'boxed' )
				),
				'bordered_color'         => array(
					'id'       => 'bordered_color',
					'title'    => esc_html__( 'Site Border Color', 'g5-core' ),
					'desc'     => esc_html__( 'Specify the site color for bordered style', 'g5-core' ),
					'type'     => 'color',
					'default'  => G5CORE()->options()->layout()->get_default( 'bordered_color', '#eee' ),
					'required' => array( 'site_style', '=', 'bordered' )
				),
				'bordered_width'         => array(
					'id'       => 'bordered_width',
					'title'    => esc_html__( 'Site Border Width', 'g5-core' ),
					'type'     => 'dimension',
					'height'   => false,
					'default'  => G5CORE()->options()->layout()->get_default( 'bordered_width', array(
						'width' => 30,
					) ),
					'required' => array( 'site_style', '=', 'bordered' )
				),
				'site_layout'            => G5CORE()->fields()->get_config_site_layout( array(
					'id'      => 'site_layout',
					'default' => G5CORE()->options()->layout()->get_default( 'site_layout', 'right' )
				) ),
				'sidebar'                => G5CORE()->fields()->get_config_sidebar( array(
					'id'       => 'sidebar',
					'default'  => G5CORE()->options()->layout()->get_default( 'sidebar', 'sidebar-blog' ),
					'required' => array( 'site_layout', '!=', 'none' )
				) ),
				'content_padding'        => array(
					'id'       => 'content_padding',
					'title'    => esc_html__( 'Content Padding', 'g5-core' ),
					'subtitle' => esc_html__( 'Set content padding', 'g5-core' ),
					'type'     => 'spacing',
					'left'     => false,
					'right'    => false,
					'default'  => G5CORE()->options()->layout()->get_default( 'content_padding', array(
						'top'    => 50,
						'bottom' => 50
					) ),
				),
				'mobile_content_padding'        => array(
					'id'       => 'mobile_content_padding',
					'title'    => esc_html__( 'Mobile Content Padding', 'g5-core' ),
					'subtitle' => esc_html__( 'Set mobile content padding', 'g5-core' ),
					'type'     => 'spacing',
					'left'     => false,
					'right'    => false,
					'default'  => G5CORE()->options()->layout()->get_default( 'mobile_content_padding', array(
						'top'    => '',
						'bottom' => ''
					) ),
				),
				'site_stretched_content' => G5CORE()->fields()->get_config_toggle( array(
					'id'       => 'site_stretched_content',
					'title'    => esc_html__( 'Stretched Content', 'g5-core' ),
					'subtitle' => esc_html__( 'Turn On this option if you want to enable site stretched content', 'g5-core' ),
					'default'  => G5CORE()->options()->layout()->get_default( 'site_stretched_content' ),
				) ),
				'sidebar_sticky_enable'  => G5CORE()->fields()->get_config_toggle( array(
					'id'       => 'sidebar_sticky_enable',
					'title'    => esc_html__( 'Sidebar Sticky', 'g5-core' ),
					'subtitle' => esc_html__( 'Turn On this option if you want to enable sidebar sticky', 'g5-core' ),
					'default'  => G5CORE()->options()->layout()->get_default( 'sidebar_sticky_enable' ),
					'required' => array( 'site_layout', '!=', 'none' ),
				) ),
				'mobile_sidebar_enable'  => G5CORE()->fields()->get_config_toggle( array(
					'id'       => 'mobile_sidebar_enable',
					'title'    => esc_html__( 'Sidebar Mobile Disable', 'g5-core' ),
					'subtitle' => esc_html__( 'Turn On this option if you want to disable sidebar on mobile', 'g5-core' ),
					'default'  => G5CORE()->options()->layout()->get_default( 'mobile_sidebar_enable', 'on' ),
					'required' => array( 'site_layout', '!=', 'none' ),
				) ),
				'custom_css'        => array(
					'id'       => 'custom_css',
					'title'    => esc_html__( 'Custom Css', 'g5-core' ),
					'subtitle' => esc_html__( 'Enter custom css to body', 'g5-core' ),
					'type'     => 'text',
				),
			);
		}

		public function define_meta_box( $configs ) {
			$prefix                        = G5CORE()->meta_prefix;
			$configs['g5core_layout_meta'] = array(
				'name'      => esc_html__( 'Layout Settings', 'g5-core' ),
				'post_type' => apply_filters('g5core_meta_box_layout_post_types',array_keys( g5core_post_types_active())) ,
				'layout'    => 'inline',
				'fields'    => array(
					"{$prefix}site_style"             => array(
						'id'      => "{$prefix}site_style",
						'title'   => esc_html__( 'Site Style', 'g5-core' ),
						'type'    => 'image_set',
						'options' => G5CORE()->settings()->get_site_style( true ),
						'default' => '',
					),

					"{$prefix}bordered_color"         => array(
						'id'       => "{$prefix}bordered_color",
						'title'    => esc_html__( 'Site Border Color', 'g5-core' ),
						'desc'     => esc_html__( 'Specify the site color for bordered style', 'g5-core' ),
						'type'     => 'color',
						'default'  => G5CORE()->options()->layout()->get_default( 'bordered_color', '#eee' ),
						'required' => array( "{$prefix}site_style" , '=', 'bordered' )
					),
					"{$prefix}bordered_width"         => array(
						'id'       => "{$prefix}bordered_width",
						'title'    => esc_html__( 'Site Border Width', 'g5-core' ),
						'type'     => 'dimension',
						'height'   => false,
						'default'  => G5CORE()->options()->layout()->get_default( 'bordered_width', array(
							'width' => 30,
						) ),
						'required' => array( "{$prefix}site_style" , '=', 'bordered' )
					),

					"{$prefix}site_layout"            => G5CORE()->fields()->get_config_site_layout( array( 'id' => "{$prefix}site_layout" ), true ),
					"{$prefix}sidebar"                => G5CORE()->fields()->get_config_sidebar( array(
						'id'       => "{$prefix}sidebar",
						'default'  => '',
						'required' => array( "{$prefix}site_layout", '!=', 'none' )
					) ),
					"{$prefix}site_stretched_content" => G5CORE()->fields()->get_config_toggle( array(
						'id'       => "{$prefix}site_stretched_content",
						'title'    => esc_html__( 'Stretched Content', 'g5-core' ),
						'subtitle' => esc_html__( 'Turn On this option if you want to enable site stretched content', 'g5-core' ),
						'default'  => '',
					), true ),
					"{$prefix}content_padding"        => array(
						'id'       => "{$prefix}content_padding",
						'title'    => esc_html__( 'Content Padding', 'g5-core' ),
						'subtitle' => esc_html__( 'Set content padding', 'g5-core' ),
						'type'     => 'spacing',
						'left'     => false,
						'right'    => false,
						'default'  => array( 'top' => '', 'bottom' => '' ),
					),
					"{$prefix}mobile_content_padding"        => array(
						'id'       => "{$prefix}mobile_content_padding",
						'title'    => esc_html__( 'Mobile Content Padding', 'g5-core' ),
						'subtitle' => esc_html__( 'Set mobile content padding', 'g5-core' ),
						'type'     => 'spacing',
						'left'     => false,
						'right'    => false,
						'default'  => array( 'top' => '', 'bottom' => '' ),
					),
					"{$prefix}custom_css"        => array(
						'id'       => "{$prefix}custom_css",
						'title'    => esc_html__( 'Custom Css', 'g5-core' ),
						'subtitle' => esc_html__( 'Enter custom css to page', 'g5-core' ),
						'type'     => 'text',
					),

				)
			);

			return $configs;
		}

		public function sidebar_class_filter( $classes ) {
			$site_layout = G5CORE()->options()->layout()->get_option( 'site_layout' );
			if ( $site_layout === 'left' ) {
				$classes[] = 'order-lg-first';
			}

			$sidebar_sticky_enable = G5CORE()->options()->layout()->get_option( 'sidebar_sticky_enable' );
			if ( $sidebar_sticky_enable === 'on' ) {
				$classes[] = 'sidebar-sticky';
			}

			$mobile_sidebar_enable = G5CORE()->options()->layout()->get_option( 'mobile_sidebar_enable' );

			if ( $mobile_sidebar_enable === 'on' ) {
				$classes[] = 'sidebar-mobile-hide';
			}

			return $classes;
		}

		public function sidebar_name_filter( $sidebar_name ) {
			return G5CORE()->options()->layout()->get_option( 'sidebar' );
		}

		public function has_sidebar_filter( $has_sidebar ) {
			$site_layout = G5CORE()->options()->layout()->get_option( 'site_layout' );
			if ( $site_layout === 'none' ) {
				return false;
			}

			return $has_sidebar;
		}

		public function change_page_setting() {

			$current_post_type = g5core_get_current_post_type();
			if ( in_array( $current_post_type, array( 'g5core_content_single', 'g5core_vc_template_single','g5core_xmenu_mega_single','elementor_library_single' ) ) ) {
				G5CORE()->options()->layout()->set_option( 'site_style', 'wide' );
				G5CORE()->options()->layout()->set_option( 'site_layout', 'none' );
				G5CORE()->options()->layout()->set_option( 'sidebar', '' );
				G5CORE()->options()->layout()->set_option( 'site_stretched_content', 'off' );
				G5CORE()->options()->layout()->set_option( 'content_padding', array(
					'left'   => '0',
					'right'  => '0',
					'top'    => '0',
					'bottom' => '0',
				) );
			}



			$content_404_block = G5CORE()->options()->get_option( 'page_404_custom' );
			if ( is_singular() || ( is_404() && ! empty( $content_404_block ) ) ) {
				$id = is_404() ? $content_404_block : get_the_ID();

				$prefix = G5CORE()->meta_prefix;

				$site_style             = get_post_meta( $id, "{$prefix}site_style", true );
				$site_layout            = get_post_meta( $id, "{$prefix}site_layout", true );
				$sidebar                = get_post_meta( $id, "{$prefix}sidebar", true );
				$site_stretched_content = get_post_meta( $id, "{$prefix}site_stretched_content", true );

				$content_padding = get_post_meta( $id, "{$prefix}content_padding", true );
				$mobile_content_padding = get_post_meta( $id, "{$prefix}mobile_content_padding", true );

				if ($site_style === 'bordered') {
					$bordered_color = get_post_meta( $id, "{$prefix}bordered_color", TRUE );
					$bordered_width = get_post_meta( $id, "{$prefix}bordered_width", TRUE );
					if (!empty($bordered_color)) {
						G5CORE()->options()->layout()->set_option( 'bordered_color', $bordered_color );
					}

					if (is_array($bordered_width) && isset($bordered_width['width']) && !empty($bordered_width['width'])) {
						G5CORE()->options()->layout()->set_option( 'bordered_width', $bordered_width );
					}
				}
				$custom_css                = get_post_meta( $id, "{$prefix}custom_css", true );



				if ( ! empty( $site_style ) ) {
					G5CORE()->options()->layout()->set_option( 'site_style', $site_style );
				}
				if ( ! empty( $site_layout ) ) {
					G5CORE()->options()->layout()->set_option( 'site_layout', $site_layout );
				}

				if ( ! empty( $sidebar ) ) {
					G5CORE()->options()->layout()->set_option( 'sidebar', $sidebar );
				}

				if ( ! empty( $site_stretched_content ) ) {
					G5CORE()->options()->layout()->set_option( 'site_stretched_content', $site_stretched_content );
				}

				if ( is_array( $content_padding ) && ( ( $content_padding['top'] !== '' ) || ( $content_padding['bottom'] !== '' ) ) ) {
					G5CORE()->options()->layout()->set_option( 'content_padding', $content_padding );
				}

				if ( is_array( $mobile_content_padding ) && ( ( $mobile_content_padding['top'] !== '' ) || ( $mobile_content_padding['bottom'] !== '' ) ) ) {
					G5CORE()->options()->layout()->set_option( 'mobile_content_padding', $mobile_content_padding );
				}

				if ( ! empty( $custom_css ) ) {
					G5CORE()->options()->layout()->set_option( 'custom_css', $custom_css );
				}
			}
		}

		public function change_site_style( $classes ) {
			$site_style = G5CORE()->options()->layout()->get_option( 'site_style' );
			$classes[]  = 'site-style-' . $site_style;

			return $classes;
		}

		public function body_class($classes) {
			$custom_css = G5CORE()->options()->layout()->get_option('custom_css');
			if (!empty($custom_css)) {
				$classes[] = $custom_css;
			}

			$site_style = G5CORE()->options()->layout()->get_option( 'site_style' );
			$classes[]  = 'site-style-' . $site_style;

			$site_stretched_content = G5CORE()->options()->layout()->get_option( 'site_stretched_content' );
			if ( $site_stretched_content === 'on' ) {
				$classes[] = 'g5core__stretched_content';
			}

			return $classes;
		}

		public function site_style_bordered_html() {
			$site_style = G5CORE()->options()->layout()->get_option( 'site_style' );
			?>
			<?php if ( $site_style === 'bordered' ): ?>
				<div class="g5core-site-bordered-top"></div>
				<div class="g5core-site-bordered-bottom"></div>
			<?php endif; ?>
			<?php
		}



		public function change_layout() {
			$site_layout = isset( $_REQUEST['site_layout'] ) ? $_REQUEST['site_layout'] : '';
			if ( ! empty( $site_layout ) ) {
				$ajax_query                = G5CORE()->cache()->get( 'g5core_ajax_query', array() );
				$ajax_query['site_layout'] = $site_layout;
				G5CORE()->cache()->set( 'g5core_ajax_query', $ajax_query );
				G5CORE()->options()->layout()->set_option( 'site_layout', $site_layout );
			}
		}
	}
}