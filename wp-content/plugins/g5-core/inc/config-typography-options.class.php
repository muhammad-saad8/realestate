<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if ( ! class_exists( 'G5Core_Config_Typography_Options' ) ) {
	class G5Core_Config_Typography_Options {
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
			add_filter( 'gsf_option_config', array( $this, 'define_options' ), 70 );
			add_filter( 'gsf_meta_box_config', array( $this, 'define_meta_box' ), 70 );
			add_action( 'template_redirect', array( $this, 'change_page_setting' ) );
		}

		public function options_name() {
			return apply_filters('g5core_typography_options_name','g5core_typography_options');
		}

		public function define_options( $configs ) {
			$configs['g5core_typography_options'] = array(
				'layout'      => 'inline',
				'page_title'  => esc_html__( 'Typography Options', 'g5-core' ),
				'menu_title'  => esc_html__( 'Typography', 'g5-core' ),
				'desc'        => esc_html__( 'You can configure for site typography or create preset typography to apply for your page', 'g5-core' ),
				'option_name' => G5Core_Config_Typography_Options::getInstance()->options_name(),
				'parent_slug' => 'g5core_options',
				'permission'  => 'manage_options',
				'preset'      => true,
				'section'     => $this->config_option(),
			);

			return $configs;
		}

		public function config_option() {
			return array(
				'section_body' =>  $this->section_body(),
				'section_heading' =>  $this->section_heading(),
				'section_display' =>  $this->section_display(),
			);
		}

		public function section_body() {
			return array(
				'id'     => 'section_body',
				'title'  => esc_html__( 'Body', 'g5-core' ),
				'icon'   => 'dashicons dashicons-editor-bold',
				'fields' => array(
					'body_font'     => array(
						'id'             => 'body_font',
						'title'          => esc_html__( 'Body Font', 'g5-core' ),
						'type'           => 'typography',
						'font_size'      => true,
						'font_variants'  => true,
						'letter_spacing' => true,
						'transform'      => true,
						'line_height'      => true,
						'default'        => G5CORE()->options()->typography()->get_default( 'body_font' ),
					),
                    'primary_font'     => array(
                        'id'             => 'primary_font',
                        'title'          => esc_html__( 'Primary Font', 'g5-core' ),
                        'type'           => 'typography',
                        'default'        => G5CORE()->options()->typography()->get_default( 'primary_font' ),
                    ),
				)
			);
		}


		public function section_heading() {
			return array(
				'id'     => 'section_heading',
				'title'  => esc_html__( 'Heading', 'g5-core' ),
				'icon'   => 'dashicons dashicons-editor-textcolor',
				'fields' => array(
					'h1_font'     => array(
						'id'             => 'h1_font',
						'title'          => esc_html__( 'H1', 'g5-core' ),
						'type'           => 'typography',
						'font_size'      => true,
						'font_variants'  => true,
						'letter_spacing' => true,
						'transform'      => true,
						'line_height'      => true,
						'default'        => G5CORE()->options()->typography()->get_default( 'h1_font' ),
					),
					'h2_font'     => array(
						'id'             => 'h2_font',
						'title'          => esc_html__( 'H2', 'g5-core' ),
						'type'           => 'typography',
						'font_size'      => true,
						'font_variants'  => true,
						'letter_spacing' => true,
						'transform'      => true,
						'line_height'      => true,
						'default'        => G5CORE()->options()->typography()->get_default( 'h2_font' ),
					),
					'h3_font'     => array(
						'id'             => 'h3_font',
						'title'          => esc_html__( 'H3', 'g5-core' ),
						'type'           => 'typography',
						'font_size'      => true,
						'font_variants'  => true,
						'letter_spacing' => true,
						'transform'      => true,
						'line_height'      => true,
						'default'        => G5CORE()->options()->typography()->get_default( 'h3_font' ),
					),
					'h4_font'     => array(
						'id'             => 'h4_font',
						'title'          => esc_html__( 'H4', 'g5-core' ),
						'type'           => 'typography',
						'font_size'      => true,
						'font_variants'  => true,
						'letter_spacing' => true,
						'transform'      => true,
						'line_height'      => true,
						'default'        => G5CORE()->options()->typography()->get_default( 'h4_font' ),
					),
					'h5_font'     => array(
						'id'             => 'h5_font',
						'title'          => esc_html__( 'H5', 'g5-core' ),
						'type'           => 'typography',
						'font_size'      => true,
						'font_variants'  => true,
						'letter_spacing' => true,
						'transform'      => true,
						'line_height'      => true,
						'default'        => G5CORE()->options()->typography()->get_default( 'h5_font' ),
					),
					'h6_font'     => array(
						'id'             => 'h6_font',
						'title'          => esc_html__( 'H6', 'g5-core' ),
						'type'           => 'typography',
						'font_size'      => true,
						'font_variants'  => true,
						'letter_spacing' => true,
						'transform'      => true,
						'line_height'      => true,
						'default'        => G5CORE()->options()->typography()->get_default( 'h6_font' ),
					),
				)
			);
		}

		public function section_display() {
			return array(
				'id'     => 'section_display',
				'title'  => esc_html__( 'Display', 'g5-core' ),
				'icon'   => 'dashicons dashicons-admin-customizer',
				'fields' => array(
					'display_1'     => array(
						'id'             => 'display_1',
						'title'          => esc_html__( 'Display 1', 'g5-core' ),
						'subtitle'           => esc_html__('Typography for class .display-1','g5-core'),
						'type'           => 'typography',
						'font_size'      => true,
						'font_variants'  => true,
						'letter_spacing' => true,
						'transform'      => true,
						'default'        => G5CORE()->options()->typography()->get_default( 'display_1' ),
					),
					'display_2'     => array(
						'id'             => 'display_2',
						'title'          => esc_html__( 'Display 2', 'g5-core' ),
						'subtitle'           => esc_html__('Typography for class .display-2','g5-core'),
						'type'           => 'typography',
						'font_size'      => true,
						'font_variants'  => true,
						'letter_spacing' => true,
						'transform'      => true,
						'default'        => G5CORE()->options()->typography()->get_default( 'display_2' ),
					),
					'display_3'     => array(
						'id'             => 'display_3',
						'title'          => esc_html__( 'Display 3', 'g5-core' ),
						'subtitle'           => esc_html__('Typography for class .display-3','g5-core'),
						'type'           => 'typography',
						'font_size'      => true,
						'font_variants'  => true,
						'letter_spacing' => true,
						'transform'      => true,
						'default'        => G5CORE()->options()->typography()->get_default( 'display_3' ),
					),
					'display_4'     => array(
						'id'             => 'display_4',
						'title'          => esc_html__( 'Display 4', 'g5-core' ),
						'subtitle'           => esc_html__('Typography for class .display-4','g5-core'),
						'type'           => 'typography',
						'font_size'      => true,
						'font_variants'  => true,
						'letter_spacing' => true,
						'transform'      => true,
						'default'        => G5CORE()->options()->typography()->get_default( 'display_4' ),
					),
				)
			);
		}

		public function define_meta_box($configs) {
			$prefix                            = G5CORE()->meta_prefix;
			$configs['g5core_typography_meta'] = array(
				'name'      => esc_html__( 'Typography Settings', 'g5-core' ),
				'post_type' => array_keys( g5core_post_types_active() ),
				'layout'    => 'inline',
				'fields'    => array(
					"{$prefix}typography_preset" => array(
						'id'          => "{$prefix}typography_preset",
						'title'       => esc_html__( 'Typography Preset', 'g5-core' ),
						'type'        => 'selectize',
						'allow_clear' => true,
						'data'        => 'preset',
						'data-option' => G5Core_Config_Typography_Options::getInstance()->options_name(),
						'create_link' => admin_url( 'admin.php?page=g5core_typography_options' ),
						'edit_link'   => admin_url( 'admin.php?page=g5core_typography_options' ),
						'placeholder' => esc_html__( 'Select Preset', 'g5-core' ),
						'multiple'    => false,
						'desc'        => esc_html__( 'Optionally you can choose to override the setting that is used on the page', 'g5-core' ),
					),
				)
			);
			return $configs;
		}

		public function change_page_setting() {
			$content_404_block = G5CORE()->options()->get_option( 'page_404_custom' );
			if ( is_singular() || ( is_404() && ! empty( $content_404_block ) ) ) {
				$id = is_404() ? $content_404_block : get_the_ID();

				$prefix = G5CORE()->meta_prefix;

				$typography_preset = get_post_meta( $id, "{$prefix}typography_preset", true );

				if ( ! empty( $typography_preset ) ) {
					G5CORE()->options()->typography()->set_preset( $typography_preset );
				}
			}
		}
	}
}