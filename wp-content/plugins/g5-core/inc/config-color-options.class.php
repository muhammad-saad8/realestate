<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if ( ! class_exists( 'G5Core_Config_Color_Options' ) ) {
	class G5Core_Config_Color_Options {
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
			add_filter( 'gsf_option_config', array( $this, 'define_options' ), 60 );
			add_filter( 'gsf_meta_box_config', array( $this, 'define_meta_box' ), 60 );
			add_action( 'template_redirect', array( $this, 'change_page_setting' ) );
		}

		public function options_name() {
			return apply_filters('g5core_color_options_name','g5core_color_options');
		}

		public function define_options( $configs ) {
			$configs['g5core_color_options'] = array(
				'layout'      => 'inline',
				'page_title'  => esc_html__( 'Color Options', 'g5-core' ),
				'menu_title'  => esc_html__( 'Color', 'g5-core' ),
				'desc'        => esc_html__( 'You can configure for site color or create preset color to apply for your page', 'g5-core' ),
				'option_name' => G5Core_Config_Color_Options::getInstance()->options_name(),
				'parent_slug' => 'g5core_options',
				'permission'  => 'manage_options',
				'preset'      => true,
				'section'     => $this->config_option(),
			);

			return $configs;
		}

		public function config_option() {
			return array(
				'section_site_background' => $this->section_site_background(),
				'section_general'         => $this->section_general(),
				'section_other'           => $this->section_other(),
			);
		}

		public function section_site_background() {
			return array(
				'id'     => 'section_site_color',
				'title'  => esc_html__( 'Site Color', 'g5-core' ),
				'icon'   => 'dashicons dashicons-admin-site',
				'fields' => array(
					'site_background_color' => array(
						'id'      => 'site_background_color',
						'title'   => esc_html__( 'Site Background Color', 'g5-core' ),
						'desc'    => esc_html__( 'Specify the background color for website', 'g5-core' ),
						'type'    => 'background',
						'default' => G5CORE()->options()->color()->get_default( 'site_background_color' ),
					),
				)
			);
		}


		public function section_general() {
			return array(
				'id'     => 'section_general',
				'title'  => esc_html__( 'General Color', 'g5-core' ),
				'icon'   => 'dashicons dashicons-image-filter',
				'fields' => array(
					'site_text_color'         => array(
						'id'       => 'site_text_color',
						'title'    => esc_html__( 'Site Text Color', 'g5-core' ),
						'subtitle' => esc_html__( 'Specify the site text color', 'g5-core' ),
						'type'     => 'color',
						'alpha'    => true,
						'default'  => G5CORE()->options()->color()->get_default( 'site_text_color' ),
					),
					'accent_color'            => array(
						'id'       => 'accent_color',
						'title'    => esc_html__( 'Accent Color', 'g5-core' ),
						'subtitle' => esc_html__( 'Specify the accent color', 'g5-core' ),
						'type'     => 'color',
						'alpha'    => true,
						'default'  => G5CORE()->options()->color()->get_default( 'accent_color' ),
					),
					'link_color'            => array(
						'id'       => 'link_color',
						'title'    => esc_html__( 'Link Color', 'g5-core' ),
						'subtitle' => esc_html__( 'Specify the link color', 'g5-core' ),
						'type'     => 'color',
						'alpha'    => true,
						'default'  => G5CORE()->options()->color()->get_default( 'link_color' ),
					),
					'border_color'            => array(
						'id'       => 'border_color',
						'title'    => esc_html__( 'Border Color', 'g5-core' ),
						'subtitle' => esc_html__( 'Specify the border color', 'g5-core' ),
						'type'     => 'color',
						'alpha'    => true,
						'default'  => G5CORE()->options()->color()->get_default( 'border_color' ),
					),
					'heading_color'           => array(
						'id'       => 'heading_color',
						'title'    => esc_html__( 'Heading Color', 'g5-core' ),
						'subtitle' => esc_html__( 'Specify the heading color', 'g5-core' ),
						'type'     => 'color',
						'alpha'    => true,
						'default'  => G5CORE()->options()->color()->get_default( 'heading_color' ),
					),
					'caption_color'           => array(
						'id'       => 'caption_color',
						'title'    => esc_html__( 'Muted Color', 'g5-core' ),
						'subtitle' => esc_html__( 'Specify the muted color', 'g5-core' ),
						'type'     => 'color',
						'alpha'    => true,
						'default'  => G5CORE()->options()->color()->get_default( 'caption_color' ),
					),
					'placeholder_color'           => array(
						'id'       => 'placeholder_color',
						'title'    => esc_html__( 'Placeholder Color', 'g5-core' ),
						'subtitle' => esc_html__( 'Specify the placeholder color', 'g5-core' ),
						'type'     => 'color',
						'alpha'    => true,
						'default'  => G5CORE()->options()->color()->get_default( 'placeholder_color' ),
					),
				)
			);
		}

		public function section_other() {
			return array(
				'id'     => 'section_other',
				'title'  => esc_html__( 'Other Color', 'g5-core' ),
				'icon'   => 'dashicons dashicons-admin-customizer',
				'fields' => array(
					'primary_color'         => array(
						'id'       => 'primary_color',
						'title'    => esc_html__( 'Primary Color', 'g5-core' ),
						'subtitle' => esc_html__( 'Specify the primary color', 'g5-core' ),
						'desc'     => esc_html__('Set color for: .primary-text-color, .primary-text-hover-color, .primary-bg-color, .primary-bg-hover-color, .primary-border-color, .primary-border-hover-color','g5-core'),
						'type'     => 'color',
						'alpha'    => true,
						'default'  => G5CORE()->options()->color()->get_default( 'primary_color' ),
					),
					'secondary_color'            => array(
						'id'       => 'secondary_color',
						'title'    => esc_html__( 'Secondary Color', 'g5-core' ),
						'subtitle' => esc_html__( 'Specify the secondary color', 'g5-core' ),
						'desc'     => esc_html__('Set color for: .secondary-text-color, .secondary-text-hover-color, .secondary-bg-color, .secondary-bg-hover-color, .secondary-border-color, .secondary-border-hover-color','g5-core'),
						'type'     => 'color',
						'alpha'    => true,
						'default'  => G5CORE()->options()->color()->get_default( 'secondary_color' ),
					),
					'dark_color' => array(
						'id'       => 'dark_color',
						'title'    => esc_html__( 'Dark Color', 'g5-core' ),
						'subtitle' => esc_html__( 'Specify the dark color', 'g5-core' ),
						'desc'     => esc_html__('Set color for: .dark-text-color, .dark-text-hover-color, .dark-bg-color, .dark-bg-hover-color, .dark-border-color, .dark-border-hover-color','g5-core'),
						'type'     => 'color',
						'alpha'    => true,
						'default'  => G5CORE()->options()->color()->get_default( 'dark_color' ),
					),
					'light_color'            => array(
						'id'       => 'light_color',
						'title'    => esc_html__( 'Light Color', 'g5-core' ),
						'subtitle' => esc_html__( 'Specify the light color', 'g5-core' ),
						'desc'     => esc_html__('Set color for: .light-text-color, .light-text-hover-color, .light-bg-color, .light-bg-hover-color, .light-border-color, .light-border-hover-color','g5-core'),
						'type'     => 'color',
						'alpha'    => true,
						'default'  => G5CORE()->options()->color()->get_default( 'light_color' ),
					),
					'gray_color'           => array(
						'id'       => 'gray_color',
						'title'    => esc_html__( 'Gray Color', 'g5-core' ),
						'subtitle' => esc_html__( 'Specify the gray color', 'g5-core' ),
						'desc'     => esc_html__('Set color for: .gray-text-color, .gray-text-hover-color, .gray-bg-color, .gray-bg-hover-color, .gray-border-color, .gray-border-hover-color','g5-core'),
						'type'     => 'color',
						'alpha'    => true,
						'default'  => G5CORE()->options()->color()->get_default( 'gray_color' ),
					),
				)
			);
		}


		public function define_meta_box( $configs ) {
			$prefix                       = G5CORE()->meta_prefix;
			$configs['g5core_color_meta'] = array(
				'name'      => esc_html__( 'Color Settings', 'g5-core' ),
				'post_type' => array_keys( g5core_post_types_active() ),
				'layout'    => 'inline',
				'fields'    => array(
					"{$prefix}color_preset" => array(
						'id'          => "{$prefix}color_preset",
						'title'       => esc_html__( 'Color Preset', 'g5-core' ),
						'type'        => 'selectize',
						'allow_clear' => true,
						'data'        => 'preset',
						'data-option' => G5Core_Config_Color_Options::getInstance()->options_name(),
						'create_link' => admin_url( 'admin.php?page=g5core_color_options' ),
						'edit_link'   => admin_url( 'admin.php?page=g5core_color_options' ),
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

				$color_preset = get_post_meta( $id, "{$prefix}color_preset", true );

				if ( ! empty( $color_preset ) ) {
					G5CORE()->options()->color()->set_preset( $color_preset );
				}
			}
		}
	}
}