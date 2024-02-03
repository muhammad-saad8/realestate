<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if ( ! class_exists( 'G5Core_Config_Footer_Options' ) ) {
	class G5Core_Config_Footer_Options {
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
			add_filter( 'gsf_option_config', array( $this, 'define_options' ), 30 );
			add_filter( 'gsf_meta_box_config', array( $this, 'define_meta_box' ), 30 );
			add_action( 'template_redirect', array( $this, 'change_page_setting' ) );
		}

		public function options_name() {
			return apply_filters('g5core_footer_options_name','g5core_footer_options');
		}

		public function define_options( $configs ) {
			$configs['g5core_footer_options'] = array(
				'layout'      => 'inline',
				'page_title'  => esc_html__( 'Footer Options', 'g5-core' ),
				'menu_title'  => esc_html__( 'Footer', 'g5-core' ),
				'option_name' => G5Core_Config_Footer_Options::getInstance()->options_name(),
				'parent_slug' => 'g5core_options',
				'permission'  => 'manage_options',
				'fields'     => $this->config_option(),
			);

			return $configs;
		}

		public function config_option() {
			return array(
				'footer_enable' => G5CORE()->fields()->get_config_toggle(array(
					'id'       => 'footer_enable',
					'title'    => esc_html__('Footer Enable', 'g5-core'),
					'subtitle' => esc_html__('Turn Off this option if you want to disable footer', 'g5-core'),
					'default'  => G5CORE()->options()->footer()->get_default('footer_enable', 'on'),
				)),
				'footer_layout'                => array(
					'id'       => 'footer_layout',
					'title'    => esc_html__( 'Footer Layout', 'g5-core' ),
					'type'     => 'select',
					'options'  => G5CORE()->settings()->get_footer_layout(),
					'default'  => G5CORE()->options()->footer()->get_default( 'footer_layout','boxed' ),
					'required' => array( "footer_enable", '=', 'on' ),
				),

				'footer_content_block' => g5core_config_content_block(array(
					'id'       => 'footer_content_block',
					'subtitle' => esc_html__('Specify the Content Block to use as a footer content.', 'g5-core'),
					'required' => array('footer_enable', '=', 'on'),
					'data_args'   => array(
						'numberposts' => - 1,
						'meta_key' => G5CORE()->meta_prefix . 'content_block_type',
						'meta_value' => 'footer',
						'meta_compare' => '='
					),
					'default'  => G5CORE()->options()->footer()->get_default('footer_content_block', ''),
				)),
				'footer_fixed_enable' => G5CORE()->fields()->get_config_toggle(array(
					'id'       => 'footer_fixed_enable',
					'title'    => esc_html__('Footer Fixed', 'g5-core'),
					'default'  => G5CORE()->options()->footer()->get_default('footer_fixed_enable', 'off'),
					'required' => array('footer_enable', '=', 'on'),
				)),
			);
		}

		public function define_meta_box($configs) {
			$prefix                            = G5CORE()->meta_prefix;
			$configs['g5core_footer_meta'] = array(
				'name'      => esc_html__( 'Footer Settings', 'g5-core' ),
				'post_type' => apply_filters('g5core_meta_box_footer_post_types',array_keys( g5core_post_types_active() )) ,
				'layout'    => 'inline',
				'fields'    => array(
					"{$prefix}footer_enable" => G5CORE()->fields()->get_config_toggle(array(
						'id'       => "{$prefix}footer_enable",
						'title'    => esc_html__('Footer Enable', 'g5-core'),
						'subtitle' => esc_html__('Turn Off this option if you want to disable footer', 'g5-core'),
						'default'  => ''
					), true),
					"{$prefix}footer_layout" => array(
						'id'       => "{$prefix}footer_layout",
						'title'    => esc_html__( 'Footer Layout', 'g5-core' ),
						'type'     => 'select',
						'options'  => G5CORE()->settings()->get_footer_layout(true),
						'default'  => '',
						'required' => array("{$prefix}footer_enable", '!=', 'off')
					),
					"{$prefix}footer_content_block" => g5core_config_content_block(array(
						'id'       => "{$prefix}footer_content_block",
						'subtitle' => esc_html__('Specify the Content Block to use as a footer content.', 'g5-core'),
						'default'  => '',
						'data_args'   => array(
							'numberposts' => - 1,
							'meta_key' => G5CORE()->meta_prefix . 'content_block_type',
							'meta_value' => 'footer',
							'meta_compare' => '='
						),
						'required' => array("{$prefix}footer_enable", '!=', 'off')
					), true),
					"{$prefix}footer_fixed_enable" => G5CORE()->fields()->get_config_toggle(array(
						'id'       => "{$prefix}footer_fixed_enable",
						'title'    => esc_html__('Footer Fixed', 'g5-core'),
						'default'  => '',
						'required' => array("{$prefix}footer_enable", '!=', 'off'),
					), true),
				)
			);
			return $configs;
		}

		public function footer_template() {
			G5CORE()->get_template( 'footer.php' );
		}

		public function change_page_setting() {
			$content_404_block = G5CORE()->options()->get_option('page_404_custom');
			if ( is_singular() || (is_404() && !empty($content_404_block)) ) {
				$id     = is_404() ? $content_404_block : get_the_ID();

				$prefix = G5CORE()->meta_prefix;

				$footer_enable     = get_post_meta( $id, "{$prefix}footer_enable", true );
				$footer_content_block     = get_post_meta( $id, "{$prefix}footer_content_block", true );
				$footer_layout     = get_post_meta( $id, "{$prefix}footer_layout", true );
				$footer_fixed_enable         = get_post_meta( $id, "{$prefix}footer_fixed_enable", true );

				if ( ! empty( $footer_enable ) ) {
					G5CORE()->options()->footer()->set_option( 'footer_enable', $footer_enable );
				}

				if ( ! empty( $footer_layout ) ) {
					G5CORE()->options()->footer()->set_option( 'footer_layout', $footer_layout );
				}

				if ( ! empty( $footer_content_block ) ) {
					G5CORE()->options()->footer()->set_option( 'footer_content_block', $footer_content_block );
				}

				if ( ! empty( $footer_fixed_enable ) ) {
					G5CORE()->options()->footer()->set_option( 'footer_fixed_enable', $footer_fixed_enable );
				}
			}

			if (is_singular('g5core_content')) {
				$content_type = get_post_meta(get_the_ID(),'g5core_content_block_type',true);
				if ($content_type === 'footer') {
					G5CORE()->options()->footer()->set_option('footer_content_block',get_the_ID());
				}
			}

			if (G5CORE()->options()->footer()->get_option('footer_enable') !== 'on') {
				remove_action( G5CORE_CURRENT_THEME . '_after_page_wrapper_content', G5CORE_CURRENT_THEME . '_template_footer', 10 );
			}

			if (G5CORE()->options()->footer()->get_option('footer_content_block') !== '') {
				remove_action( G5CORE_CURRENT_THEME . '_after_page_wrapper_content', G5CORE_CURRENT_THEME . '_template_footer', 10 );
				add_action( G5CORE_CURRENT_THEME . '_after_page_wrapper_content', array( $this, 'footer_template' ), 10 );
			}
		}
	}
}