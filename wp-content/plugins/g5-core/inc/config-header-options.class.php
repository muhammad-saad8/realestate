<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if ( ! class_exists( 'G5Core_Config_Header_Options' ) ) {
	class G5Core_Config_Header_Options {
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
			add_filter( 'gsf_option_config', array( $this, 'define_header_options' ), 20 );

			add_filter( 'gsf_meta_box_config', array( $this, 'define_meta_box' ), 20 );

			add_action( 'template_redirect', array( $this, 'change_page_setting' ) );
		}

		public function options_name() {
			return apply_filters('g5core_header_options_name','g5core_header_options');
		}

		public function define_header_options( $configs ) {
			$configs['g5core_header_options'] = array(
				'layout'      => 'inline',
				'page_title'  => esc_html__( 'Header Options', 'g5-core' ),
				'menu_title'  => esc_html__( 'Header', 'g5-core' ),
				'desc'        => esc_html__( 'You can configure for site header or create preset header to apply for your page', 'g5-core' ),
				'option_name' => G5Core_Config_Header_Options::getInstance()->options_name(),
				'permission'  => 'manage_options',
				'parent_slug' => 'g5core_options',
				'preset'      => true,
				'section'     => apply_filters( 'g5core_header_options', $this->config() )
			);

			return $configs;
		}

		public function config() {
			return array(
				'section_general' => $this->section_general(),
				'section_top_bar' => $this->section_top_bar(),
				'section_logo'    => $this->section_logo(),
				'before_logo'     => $this->section_customize( array(
					'id'    => 'before_logo',
					'title' => esc_html__( 'Before Logo', 'g5-core' ),
				) ),
				'after_logo'      => $this->section_customize( array(
					'id'    => 'after_logo',
					'title' => esc_html__( 'After Logo', 'g5-core' ),
				) ),

				'section_navigation' => $this->section_navigation(),
				'before_menu'        => $this->section_customize( array(
					'id'    => 'before_menu',
					'title' => esc_html__( 'Before Menu', 'g5-core' ),
				) ),
				'after_menu'         => $this->section_customize( array(
					'id'    => 'after_menu',
					'title' => esc_html__( 'After Menu', 'g5-core' ),
				) ),
				'section_typography' => $this->section_typography(),
				'section_color'      => $this->section_color(),
				'section_mobile'     => $this->section_mobile(),
			);
		}

		public function section_general() {
			$configs = array(
				'id'     => 'section_general',
				'title'  => esc_html__( 'General', 'g5-core' ),
				'icon'   => 'dashicons dashicons-admin-site',
				'fields' => array(
					'header_enable'                => G5CORE()->fields()->get_config_toggle( array(
						'id'       => 'header_enable',
						'title'    => esc_html__( 'Header Enable', 'g5-core' ),
						'subtitle' => esc_html__( 'Turn Off this option if you want to hide header', 'g5-core' ),
						'default'  => G5CORE()->options()->header()->get_default( 'header_enable' ),
					) ),
					'header_responsive_breakpoint' => array(
						'id'       => 'header_responsive_breakpoint',
						'type'     => 'select',
						'title'    => esc_html__( 'Header Responsive Breakpoint', 'g5-core' ),
						'options'  => array(
							'1199' => esc_html__( 'Large Devices: < 1200px', 'g5-core' ),
							'991'  => esc_html__( 'Medium Devices: < 992px', 'g5-core' ),
							'767'  => esc_html__( 'Tablet Portrait: < 768px', 'g5-core' ),
						),
						'default'  => G5CORE()->options()->header()->get_default( 'header_responsive_breakpoint' ),
						'required' => array( "header_enable", '=', 'on' ),
					),
					'header_style'                 => array(
						'id'          => 'header_style',
						'title'       => esc_html__( 'Header Style', 'g5-core' ),
						'type'        => 'select_popup',
						'style'       => 'box',
						'items'       => 3,
						'popup_width' => '936px',
						'options'     => G5CORE()->settings()->get_header_style(),
						'default'     => G5CORE()->options()->header()->get_default( 'header_style' ),
						'required'    => array( "header_enable", '=', 'on' ),
					),
					'header_layout'                => array(
						'id'       => 'header_layout',
						'title'    => esc_html__( 'Header Layout', 'g5-core' ),
						'type'     => 'select',
						'options'  => G5CORE()->settings()->get_header_layout(),
						'default'  => G5CORE()->options()->header()->get_default( 'header_layout' ),
						'required' => array( "header_enable", '=', 'on' ),
					),

					'header_sticky' => array(
						'id'       => 'header_sticky',
						'title'    => esc_html__( 'Header Sticky', 'g5-core' ),
						'subtitle' => esc_html__( 'Enable or disable sticky effect for header.', 'g5-core' ),
						'type'     => 'button_set',
						'options'  => G5CORE()->settings()->get_header_sticky(),
						'default'  => G5CORE()->options()->header()->get_default( 'header_sticky' ),
						'required' => array( "header_enable", '=', 'on' ),
					),

					'header_float'         => G5CORE()->fields()->get_config_toggle( array(
						'id'       => 'header_float',
						'title'    => esc_html__( 'Header Float Enable?', 'g5-core' ),
						'subtitle' => esc_html__( 'Turn On this option if you want to float header', 'g5-core' ),
						'default'  => G5CORE()->options()->header()->get_default( 'header_float' ),
						'required' => array( "header_enable", '=', 'on' ),
					) ),
					'header_border_enable' => G5CORE()->fields()->get_config_toggle( array(
						'id'       => 'header_border_enable',
						'title'    => esc_html__( 'Header Border Enable?', 'g5-core' ),
						'subtitle' => esc_html__( 'Turn On this option if you want to show header border', 'g5-core' ),
						'default'  => G5CORE()->options()->header()->get_default( 'header_border_enable' ),
						'required' => array( "header_enable", '=', 'on' ),
					) ),
					'header_css_classes'   => array(
						'id'       => 'header_css_classes',
						'type'     => 'text',
						'title'    => esc_html__( 'Css Classes', 'g5-core' ),
						'subtitle' => esc_html__( 'Add custom css classes to the Header', 'g5-core' ),
						'default'  => G5CORE()->options()->header()->get_default( 'header_css_classes' ),
						'required' => array( "header_enable", '=', 'on' ),
					),
				),
			);

			return $configs;
		}


		public function section_logo() {
			return array(
				'id'     => 'section_logo',
				'title'  => esc_html__( 'Logo', 'g5-core' ),
				'icon'   => 'dashicons dashicons-image-filter',
				'fields' => array(
					'logo'            => array(
						'id'       => 'logo',
						'title'    => esc_html__( 'Logo', 'g5-core' ),
						'subtitle' => esc_html__( 'By default, a text-based logo is created using your site title. But you can also upload an image-based logo here.', 'g5-core' ),
						'type'     => 'image',
						'default'  => G5CORE()->options()->header()->get_default( 'logo' ),
					),
					'logo_sticky'     => array(
						'id'      => 'logo_sticky',
						'title'   => esc_html__( 'Logo sticky', 'g5-core' ),
						'type'    => 'image',
						'default' => G5CORE()->options()->header()->get_default( 'logo_sticky' ),
					),
					'logo_max_height' => array(
						'id'       => 'logo_max_height',
						'title'    => esc_html__( 'Logo Max Height', 'g5-core' ),
						'subtitle' => esc_html__( 'If you would like to override the default logo max height, then you can do so here.', 'g5-core' ),
						'type'     => 'dimension',
						'width'    => false,
						'default'  => G5CORE()->options()->header()->get_default( 'logo_max_height' ),
					),
                    'logo_sticky_max_height' => array(
                        'id'       => 'logo_sticky_max_height',
                        'title'    => esc_html__( 'Logo Sticky Max Height', 'g5-core' ),
                        'subtitle' => esc_html__( 'If you would like to override the default logo sticky max height, then you can do so here.', 'g5-core' ),
                        'type'     => 'dimension',
                        'width'    => false,
                        'default'  => G5CORE()->options()->header()->get_default( 'logo_sticky_max_height' ),
                    ),
				)
			);
		}

		public function section_customize( $args ) {
			return array(
				'id'     => "section_{$args['id']}_customize",
				'title'  => $args['title'],
				'icon'   => 'dashicons dashicons-admin-customizer',
				'fields' => array(
					"{$args['id']}_customize" => array(
						'id'      => "{$args['id']}_customize",
						'title'   => esc_html__( 'Items', 'g5-core' ),
						'type'    => 'sortable',
						'options' => G5CORE()->settings()->get_header_customize(),
						'default' => G5CORE()->options()->header()->get_default( "{$args['id']}_customize" ),
					),

					"{$args['id']}_customize_custom_html" => array(
						'id'       => "{$args['id']}_customize_custom_html",
						'title'    => esc_html__( 'Custom Html Content', 'g5-core' ),
						'type'     => 'ace_editor',
						'mode'     => 'html',
						'default'  => G5CORE()->options()->header()->get_default( "{$args['id']}_customize_custom_html" ),
						'required' => array( "{$args['id']}_customize", 'contain', 'custom-html' )
					),
				)
			);
		}

		public function section_navigation() {
			return array(
				'id'     => 'section_navigation',
				'title'  => esc_html__( 'Navigation', 'g5-core' ),
				'icon'   => 'dashicons dashicons-welcome-widgets-menus',
				'fields' => array(
					'navigation_border_enable' => G5CORE()->fields()->get_config_toggle( array(
						'id'       => 'navigation_border_enable',
						'title'    => esc_html__( 'Navigation Border Enable?', 'g5-core' ),
						'subtitle' => esc_html__( 'Turn On this option if you want to show navigation border', 'g5-core' ),
						'default'  => G5CORE()->options()->header()->get_default( 'navigation_border_enable' ),
						'required' => array( "header_enable", '=', 'on' ),

					) ),
					'menu_spacing'             => array(
						'id'       => 'menu_spacing',
						'title'    => esc_html__( 'Menu Item Spacing', 'g5-core' ),
						'subtitle' => esc_html__( 'If you would like to override the default menu item spacing, then you can do so here.', 'g5-core' ),
						'type'     => 'dimension',
						'height'   => false,
						'default'  => G5CORE()->options()->header()->get_default( 'menu_spacing' ),
					),
					'submenu_transition'       => array(
						'id'      => 'submenu_transition',
						'type'    => 'select',
						'title'   => esc_html__( 'Submenu Transition', 'g5-core' ),
						'options' => G5CORE()->settings()->get_menu_transition(),
						'default' => G5CORE()->options()->header()->get_default( 'submenu_transition' ),
					),
				)
			);
		}

		public function section_top_bar() {
			return array(
				'id'     => 'section_top_bar',
				'title'  => esc_html__( 'Top Bar', 'g5-core' ),
				'icon'   => 'dashicons dashicons-archive',
				'fields' => array(
					'top_bar_desktop_enable'              => G5CORE()->fields()->get_config_toggle( array(
						'id'       => 'top_bar_desktop_enable',
						'title'    => esc_html__( 'Top Bar Enable', 'g5-core' ),
						'subtitle' => esc_html__( 'Turn On this option if you want to enable top bar', 'g5-core' ),
						'default'  => G5CORE()->options()->header()->get_default( 'top_bar_desktop_enable' ),
					) ),
					'top_bar_desktop_items'               => array(
						'id'       => 'top_bar_desktop_items',
						'title'    => esc_html__( 'Top Bar Items', 'g5-core' ),
						'type'     => 'sorter',
						'required' => array( 'top_bar_desktop_enable', '=', 'on' ),
						'default'  => G5CORE()->options()->header()->get_default( 'top_bar_desktop_items' ),
					),
					'top_bar_desktop_items_custom_html_1' => array(
						'id'       => 'top_bar_desktop_items_custom_html_1',
						'title'    => esc_html__( 'Custom Html 1', 'g5-core' ),
						'type'     => 'ace_editor',
						'mode'     => 'html',
						'default'  => G5CORE()->options()->header()->get_default( 'top_bar_desktop_items_custom_html_1' ),
						'required' => array(
							array( 'top_bar_desktop_enable', '=', 'on' ),
							array( 'top_bar_desktop_items[disable]', 'not contain', 'custom-html-1' )
						)
					),
					'top_bar_desktop_items_custom_html_2' => array(
						'id'       => 'top_bar_desktop_items_custom_html_2',
						'title'    => esc_html__( 'Custom Html 2', 'g5-core' ),
						'type'     => 'ace_editor',
						'mode'     => 'html',
						'default'  => G5CORE()->options()->header()->get_default( 'top_bar_desktop_items_custom_html_2' ),
						'required' => array(
							array( 'top_bar_desktop_enable', '=', 'on' ),
							array( 'top_bar_desktop_items[disable]', 'not contain', 'custom-html-2' )
						)
					),
					'top_bar_desktop_border_bottom'       => G5CORE()->fields()->get_config_toggle( array(
						'id'       => 'top_bar_desktop_border_bottom',
						'title'    => esc_html__( 'Border Bottom Enable?', 'g5-core' ),
						'subtitle' => esc_html__( 'Turn On this option if you want to show top bar border bottom', 'g5-core' ),
						'default'  => G5CORE()->options()->header()->get_default( 'top_bar_desktop_border_bottom' ),
						'required' => array( "top_bar_desktop_enable", '=', 'on' ),
					) ),
				)
			);
		}

		public function section_typography() {
			return array(
				'id'     => 'section_typography',
				'title'  => esc_html__( 'Typography', 'g5-core' ),
				'icon'   => 'dashicons dashicons-editor-textcolor',
				'fields' => array(
					'logo_font'     => array(
						'id'             => 'logo_font',
						'title'          => esc_html__( 'Logo Font', 'g5-core' ),
						'subtitle'       => esc_html__( 'Set Logo text font', 'g5-core' ),
						'type'           => 'typography',
						'font_size'      => true,
						'font_variants'  => true,
						'letter_spacing' => true,
						'transform'      => true,
						'default'        => G5CORE()->options()->header()->get_default( 'logo_font' ),
					),
					'top_bar_font'  => array(
						'id'             => 'top_bar_font',
						'title'          => esc_html__( 'Top Bar Font', 'g5-core' ),
						'subtitle'       => esc_html__( 'Specify the top bar font.', 'g5-core' ),
						'type'           => 'typography',
						'font_size'      => true,
						'font_variants'  => true,
						'letter_spacing' => true,
						'transform'      => true,
						'default'        => G5CORE()->options()->header()->get_default( 'top_bar_font' ),
					),
					'menu_font'     => array(
						'id'             => 'menu_font',
						'title'          => esc_html__( 'Menu Font', 'g5-core' ),
						'subtitle'       => esc_html__( 'Specify the menu font.', 'g5-core' ),
						'type'           => 'typography',
						'font_size'      => true,
						'font_variants'  => true,
						'letter_spacing' => true,
						'transform'      => true,
						'default'        => G5CORE()->options()->header()->get_default( 'menu_font' ),
					),
					'sub_menu_font' => array(
						'id'             => 'sub_menu_font',
						'title'          => esc_html__( 'Sub Menu Font', 'g5-core' ),
						'subtitle'       => esc_html__( 'Specify the sub menu font.', 'g5-core' ),
						'type'           => 'typography',
						'font_size'      => true,
						'font_variants'  => true,
						'letter_spacing' => true,
						'transform'      => true,
						'default'        => G5CORE()->options()->header()->get_default( 'sub_menu_font' ),
					),

				)
			);
		}

		public function section_color() {
			return array(
				'id'     => 'section_color',
				'title'  => esc_html__( 'Colors', 'g5-core' ),
				'icon'   => 'dashicons dashicons-art',
				'fields' => array(
					'header_desktop_color_group' => array(
						'id'             => 'header_desktop_color_group',
						'title'          => esc_html__( 'Header Desktop', 'g5-core' ),
						'type'           => 'group',
						'toggle_default' => true,
						'fields'         => array(
							'header_scheme' => array(
								'id'      => 'header_scheme',
								'title'   => esc_html__( 'Header Scheme', 'g5-core' ),
								'type'    => 'button_set',
								'options' => array(
									'light' => esc_html__( 'Light', 'g5-core' ),
									'dark'  => esc_html__( 'Dark', 'g5-core' )
								),
								'default' => G5CORE()->options()->header()->get_default( 'header_scheme' ),

								'preset' => array(
									array(
										'op'     => '=',
										'value'  => 'light',
										'fields' => array(
                                            array( 'header_background_color', '#fff' ),
                                            array( 'header_text_color', '#1b1b1b' ),
                                            array( 'header_text_hover_color', '#999' ),
                                            array( 'header_border_color', '#ececec' ),
                                            array( 'header_disable_color', '#888' ),
										)
									),
									array(
										'op'     => '=',
										'value'  => 'dark',
										'fields' => array(
                                            array( 'header_background_color', '#1b1b1b' ),
                                            array( 'header_text_color', '#ccc' ),
                                            array( 'header_text_hover_color', '#fff' ),
                                            array( 'header_border_color', '#3f3f3f' ),
                                            array( 'header_disable_color', '#888' ),

										)
									),
								)
							),

							'header_background_color' => array(
								'id'       => 'header_background_color',
								'title'    => esc_html__( 'Background Color', 'g5-core' ),
								'subtitle' => esc_html__( 'Specify the header background color', 'g5-core' ),
								'type'     => 'color',
								'alpha'    => true,
								'default'  => G5CORE()->options()->header()->get_default( 'header_background_color' ),
							),

							'header_text_color' => array(
								'id'       => 'header_text_color',
								'title'    => esc_html__( 'Text Color', 'g5-core' ),
								'subtitle' => esc_html__( 'Specify the header text color', 'g5-core' ),
								'type'     => 'color',
								'default'  => G5CORE()->options()->header()->get_default( 'header_text_color' ),
							),

							'header_text_hover_color' => array(
								'id'       => 'header_text_hover_color',
								'title'    => esc_html__( 'Text Hover Color', 'g5-core' ),
								'subtitle' => esc_html__( 'Specify the header text hover color', 'g5-core' ),
								'type'     => 'color',
								'default'  => G5CORE()->options()->header()->get_default( 'header_text_hover_color' ),
							),

							'header_border_color' => array(
								'id'       => 'header_border_color',
								'title'    => esc_html__( 'Border Color', 'g5-core' ),
								'subtitle' => esc_html__( 'Specify the header border color', 'g5-core' ),
								'type'     => 'color',
								'alpha'    => true,
								'default'  => G5CORE()->options()->header()->get_default( 'header_border_color' ),
							),

							'header_disable_color' => array(
								'id'       => 'header_disable_color',
								'title'    => esc_html__( 'Disable Color', 'g5-core' ),
								'subtitle' => esc_html__( 'Specify the header disable color', 'g5-core' ),
								'type'     => 'color',
								'default'  => G5CORE()->options()->header()->get_default( 'header_disable_color' ),
							),

							'header_sticky_info' => array(
								'id'    => 'header_sticky_info',
								'title' => esc_html__( 'Header Sticky', 'g5-core' ),
								'type'  => 'info',
								'style' => 'info'
							),

							'header_sticky_scheme' => array(
								'id'      => 'header_sticky_scheme',
								'title'   => esc_html__( 'Scheme Color', 'g5-core' ),
								'type'    => 'button_set',
								'options' => array(
									'light' => esc_html__( 'Light', 'g5-core' ),
									'dark'  => esc_html__( 'Dark', 'g5-core' )
								),
								'default' => G5CORE()->options()->header()->get_default( 'header_sticky_scheme' ),

								'preset' => array(
									array(
										'op'     => '=',
										'value'  => 'light',
										'fields' => array(
                                            array( 'header_sticky_background_color', '#fff' ),
                                            array( 'header_sticky_text_color', '#1b1b1b' ),
                                            array( 'header_sticky_text_hover_color', '#999' ),
                                            array( 'header_sticky_border_color', '#ececec' ),
                                            array( 'header_sticky_disable_color', '#888' ),
										)
									),
									array(
										'op'     => '=',
										'value'  => 'dark',
										'fields' => array(
                                            array( 'header_sticky_background_color', '#1b1b1b' ),
                                            array( 'header_sticky_text_color', '#ccc' ),
                                            array( 'header_sticky_text_hover_color', '#fff' ),
                                            array( 'header_sticky_border_color', '#3f3f3f' ),
                                            array( 'header_sticky_disable_color', '#888' ),
										)
									),
								)
							),

							'header_sticky_background_color' => array(
								'id'       => 'header_sticky_background_color',
								'title'    => esc_html__( 'Background Color', 'g5-core' ),
								'subtitle' => esc_html__( 'Specify the header background color', 'g5-core' ),
								'type'     => 'color',
								'alpha'    => true,
								'default'  => G5CORE()->options()->header()->get_default( 'header_sticky_background_color' ),
							),

							'header_sticky_text_color' => array(
								'id'       => 'header_sticky_text_color',
								'title'    => esc_html__( 'Text Color', 'g5-core' ),
								'subtitle' => esc_html__( 'Specify the header text color', 'g5-core' ),
								'type'     => 'color',
								'default'  => G5CORE()->options()->header()->get_default( 'header_sticky_text_color' ),
							),

							'header_sticky_text_hover_color' => array(
								'id'       => 'header_sticky_text_hover_color',
								'title'    => esc_html__( 'Text Hover Color', 'g5-core' ),
								'subtitle' => esc_html__( 'Specify the header text hover color', 'g5-core' ),
								'type'     => 'color',
								'default'  => G5CORE()->options()->header()->get_default( 'header_sticky_text_hover_color' ),
							),

							'header_sticky_border_color' => array(
								'id'       => 'header_sticky_border_color',
								'title'    => esc_html__( 'Border Color', 'g5-core' ),
								'subtitle' => esc_html__( 'Specify the header border color', 'g5-core' ),
								'type'     => 'color',
								'alpha'    => true,
								'default'  => G5CORE()->options()->header()->get_default( 'header_sticky_border_color' ),
							),

							'header_sticky_disable_color' => array(
								'id'       => 'header_sticky_disable_color',
								'title'    => esc_html__( 'Disable Color', 'g5-core' ),
								'subtitle' => esc_html__( 'Specify the header disable color', 'g5-core' ),
								'type'     => 'color',
								'default'  => G5CORE()->options()->header()->get_default( 'header_sticky_disable_color' ),
							),

						)
					),

					'top_bar_group' => array(
						'id'             => 'top_bar_group',
						'title'          => esc_html__( 'Top Bar', 'g5-core' ),
						'type'           => 'group',
						'toggle_default' => false,
						'fields'         => array(
							'top_bar_scheme' => array(
								'id'      => 'top_bar_scheme',
								'title'   => esc_html__( 'Top Bar Scheme', 'g5-core' ),
								'type'    => 'button_set',
								'options' => array(
									'light' => esc_html__( 'Light', 'g5-core' ),
									'dark'  => esc_html__( 'Dark', 'g5-core' )
								),
								'default' => G5CORE()->options()->header()->get_default( 'top_bar_scheme' ),
								'preset'  => array(
									array(
										'op'     => '=',
										'value'  => 'light',
										'fields' => array(
                                            array( 'top_bar_background_color', '#f6f6f6' ),
                                            array( 'top_bar_text_color', '#1b1b1b' ),
                                            array( 'top_bar_text_hover_color', '#999' ),
                                            array( 'top_bar_border_color', '#ececec' ),
										)
									),
									array(
										'op'     => '=',
										'value'  => 'dark',
										'fields' => array(
                                            array( 'top_bar_background_color', '#1b1b1b' ),
                                            array( 'top_bar_text_color', '#ccc' ),
                                            array( 'top_bar_text_hover_color', '#fff' ),
                                            array( 'top_bar_border_color', '#373737' ),
										)
									),
								)
							),

							'top_bar_background_color' => array(
								'id'       => 'top_bar_background_color',
								'title'    => esc_html__( 'Background Color', 'g5-core' ),
								'subtitle' => esc_html__( 'Specify the Top Bar background color', 'g5-core' ),
								'type'     => 'color',
								'alpha'    => true,
								'default'  => G5CORE()->options()->header()->get_default( 'top_bar_background_color' ),
							),
							'top_bar_text_color'       => array(
								'id'       => 'top_bar_text_color',
								'title'    => esc_html__( 'Text Color', 'g5-core' ),
								'subtitle' => esc_html__( 'Specify the Top Bar text color', 'g5-core' ),
								'type'     => 'color',
								'default'  => G5CORE()->options()->header()->get_default( 'top_bar_text_color' ),
							),
							'top_bar_text_hover_color' => array(
								'id'       => 'top_bar_text_hover_color',
								'title'    => esc_html__( 'Text Hover Color', 'g5-core' ),
								'subtitle' => esc_html__( 'Specify the Top Bar text hover color', 'g5-core' ),
								'type'     => 'color',
								'default'  => G5CORE()->options()->header()->get_default( 'top_bar_text_hover_color' ),
							),
							'top_bar_border_color'     => array(
								'id'       => 'top_bar_border_color',
								'title'    => esc_html__( 'Border Color', 'g5-core' ),
								'subtitle' => esc_html__( 'Specify the menu border color', 'g5-core' ),
								'type'     => 'color',
								'alpha'    => true,
								'default'  => G5CORE()->options()->header()->get_default( 'top_bar_border_color' ),
							),
						),
					),

					'navigation_color_group' => array(
						'id'             => 'navigation_color_group',
						'title'          => esc_html__( 'Navigation', 'g5-core' ),
						'type'           => 'group',
						'toggle_default' => false,
						'fields'         => array(
							'navigation_scheme'           => array(
								'id'      => 'navigation_scheme',
								'title'   => esc_html__( 'Navigation Scheme Color', 'g5-core' ),
								'type'    => 'button_set',
								'options' => array(
									'light' => esc_html__( 'Light', 'g5-core' ),
									'dark'  => esc_html__( 'Dark', 'g5-core' )
								),
								'default' => G5CORE()->options()->header()->get_default( 'navigation_scheme' ),

								'preset' => array(
									array(
										'op'     => '=',
										'value'  => 'light',
										'fields' => array(
                                            array( 'navigation_background_color', '#fff' ),
                                            array( 'navigation_text_color', '#1b1b1b' ),
                                            array( 'navigation_text_hover_color', '#999' ),
                                            array( 'navigation_border_color', '#ececec' ),
                                            array( 'navigation_disable_color', '#888' ),

										)
									),
									array(
										'op'     => '=',
										'value'  => 'dark',
										'fields' => array(
                                            array( 'navigation_background_color', '#1b1b1b' ),
                                            array( 'navigation_text_color', '#ccc' ),
                                            array( 'navigation_text_hover_color', '#fff' ),
                                            array( 'navigation_border_color', '#333' ),
                                            array( 'navigation_disable_color', '#aaa' ),
										)
									),
								)
							),
							'navigation_background_color' => array(
								'id'       => 'navigation_background_color',
								'title'    => esc_html__( 'Background Color', 'g5-core' ),
								'subtitle' => esc_html__( 'Specify the navigation background color', 'g5-core' ),
								'type'     => 'color',
								'alpha'    => true,
								'default'  => G5CORE()->options()->header()->get_default( 'navigation_background_color' ),
							),
							'navigation_text_color'       => array(
								'id'       => 'navigation_text_color',
								'title'    => esc_html__( 'Text Color', 'g5-core' ),
								'subtitle' => esc_html__( 'Specify the navigation text color', 'g5-core' ),
								'type'     => 'color',
								'default'  => G5CORE()->options()->header()->get_default( 'navigation_text_color' ),
							),
							'navigation_text_hover_color' => array(
								'id'       => 'navigation_text_hover_color',
								'title'    => esc_html__( 'Text Hover Color', 'g5-core' ),
								'subtitle' => esc_html__( 'Specify the navigation text hover color', 'g5-core' ),
								'type'     => 'color',
								'default'  => G5CORE()->options()->header()->get_default( 'navigation_text_hover_color' ),
							),
							'navigation_border_color'     => array(
								'id'       => 'navigation_border_color',
								'title'    => esc_html__( 'Border Color', 'g5-core' ),
								'subtitle' => esc_html__( 'Specify the navigation border color', 'g5-core' ),
								'type'     => 'color',
								'alpha'    => true,
								'default'  => G5CORE()->options()->header()->get_default( 'navigation_border_color' ),
							),
							'navigation_disable_color'    => array(
								'id'       => 'navigation_disable_color',
								'title'    => esc_html__( 'Disable Color', 'g5-core' ),
								'subtitle' => esc_html__( 'Specify the navigation disable color', 'g5-core' ),
								'type'     => 'color',
								'default'  => G5CORE()->options()->header()->get_default( 'navigation_disable_color' ),
							),
						),
					),

					'menu_color_group' => array(
						'id'             => 'menu_color_group',
						'title'          => esc_html__( 'Menu', 'g5-core' ),
						'type'           => 'group',
						'toggle_default' => false,
						'fields'         => array(
							'submenu_scheme'           => array(
								'id'      => 'submenu_scheme',
								'title'   => esc_html__( 'Submenu Scheme Color', 'g5-core' ),
								'type'    => 'button_set',
								'options' => array(
									'light' => esc_html__( 'Light', 'g5-core' ),
									'dark'  => esc_html__( 'Dark', 'g5-core' )
								),
								'default' => G5CORE()->options()->header()->get_default( 'submenu_scheme' ),
								'preset'  => array(
									array(
										'op'     => '=',
										'value'  => 'light',
										'fields' => array(
											array( 'submenu_background_color', '#fff' ),
											array( 'submenu_heading_color', '#222' ),
											array( 'submenu_item_bg_hover_color', 'transparent' ),
											array( 'submenu_text_color', '#1b1b1b' ),
											array( 'submenu_text_hover_color', '#999' ),
											array( 'submenu_border_color', '#eee' ),
										)
									),
									array(
										'op'     => '=',
										'value'  => 'dark',
										'fields' => array(
											array( 'submenu_background_color', '#000' ),
											array( 'submenu_heading_color', '#ccc' ),
											array( 'submenu_item_bg_hover_color', 'transparent' ),
											array( 'submenu_text_color', '#aaa' ),
											array( 'submenu_text_hover_color', '#fff' ),
											array( 'submenu_border_color', '#272727' ),
										)
									),
								)
							),
							'submenu_background_color' => array(
								'id'       => 'submenu_background_color',
								'title'    => esc_html__( 'Submenu Background Color', 'g5-core' ),
								'subtitle' => esc_html__( 'Specify the submenu background color', 'g5-core' ),
								'type'     => 'color',
								'alpha'    => true,
								'default'  => G5CORE()->options()->header()->get_default( 'submenu_background_color' ),
							),
							'submenu_heading_color'    => array(
								'id'       => 'submenu_heading_color',
								'title'    => esc_html__( 'Submenu Heading Color', 'g5-core' ),
								'subtitle' => esc_html__( 'Specify the submenu heading color', 'g5-core' ),
								'type'     => 'color',
								'default'  => G5CORE()->options()->header()->get_default( 'submenu_heading_color' ),
							),
							'submenu_text_color'       => array(
								'id'       => 'submenu_text_color',
								'title'    => esc_html__( 'Submenu Text Color', 'g5-core' ),
								'subtitle' => esc_html__( 'Specify the submenu text color', 'g5-core' ),
								'type'     => 'color',
								'default'  => G5CORE()->options()->header()->get_default( 'submenu_text_color' ),
							),
							'submenu_item_bg_hover_color'       => array(
								'id'       => 'submenu_item_bg_hover_color',
								'title'    => esc_html__( 'Submenu Item Background Hover Color', 'g5-core' ),
								'subtitle' => esc_html__( 'Specify the submenu item background hover color', 'g5-core' ),
								'type'     => 'color',
								'default'  => G5CORE()->options()->header()->get_default( 'submenu_item_bg_hover_color' ),
							),
							'submenu_text_hover_color' => array(
								'id'       => 'submenu_text_hover_color',
								'title'    => esc_html__( 'Submenu Text Hover Color', 'g5-core' ),
								'subtitle' => esc_html__( 'Specify the submenu text hover color', 'g5-core' ),
								'type'     => 'color',
								'default'  => G5CORE()->options()->header()->get_default( 'submenu_text_hover_color' ),
							),
							'submenu_border_color'     => array(
								'id'       => 'submenu_border_color',
								'title'    => esc_html__( 'Submenu Border Color', 'g5-core' ),
								'subtitle' => esc_html__( 'Specify the submenu border color', 'g5-core' ),
								'type'     => 'color',
								'alpha'    => true,
								'default'  => G5CORE()->options()->header()->get_default( 'submenu_border_color' ),
							),
						)
					),

					'header_mobile_group' => array(
						'id'             => 'header_mobile_group',
						'title'          => esc_html__( 'Header Mobile', 'g5-core' ),
						'type'           => 'group',
						'toggle_default' => false,
						'fields'         => array(
							'top_bar_info'                           => array(
								'id'    => 'top_bar_info',
								'title' => esc_html__( 'Top Bar', 'g5-core' ),
								'type'  => 'info',
								'style' => 'info'
							),
							'header_mobile_top_bar_color_scheme'     => array(
								'id'      => 'header_mobile_top_bar_color_scheme',
								'title'   => esc_html__( 'Color Scheme', 'g5-core' ),
								'type'    => 'button_set',
								'options' => array(
									'light' => esc_html__( 'Light', 'g5-core' ),
									'dark'  => esc_html__( 'Dark', 'g5-core' )
								),
								'default' => G5CORE()->options()->header()->get_default( 'header_mobile_top_bar_color_scheme' ),
								'preset'  => array(
									array(
										'op'     => '=',
										'value'  => 'light',
										'fields' => array(
                                            array( 'header_mobile_top_bar_background_color', '#f6f6f6' ),
                                            array( 'header_mobile_top_bar_text_color', '#1b1b1b' ),
                                            array( 'header_mobile_top_bar_text_hover_color', '#999' ),
                                            array( 'header_mobile_top_bar_border_color', '#ececec' ),
										)
									),
									array(
										'op'     => '=',
										'value'  => 'dark',
										'fields' => array(
                                            array( 'header_mobile_top_bar_background_color', '#1b1b1b' ),
                                            array( 'header_mobile_top_bar_text_color', '#ccc' ),
                                            array( 'header_mobile_top_bar_text_hover_color', '#fff' ),
                                            array( 'header_mobile_top_bar_border_color', '#2f2f2f' ),
										)
									),
								)
							),
							'header_mobile_top_bar_background_color' => array(
								'id'      => 'header_mobile_top_bar_background_color',
								'title'   => esc_html__( 'Background Color', 'g5-core' ),
								'type'    => 'color',
								'alpha'   => true,
								'default' => G5CORE()->options()->header()->get_default( 'header_mobile_top_bar_background_color' ),
							),
							'header_mobile_top_bar_text_color'       => array(
								'id'      => 'header_mobile_top_bar_text_color',
								'title'   => esc_html__( 'Top Bar Text Color', 'g5-core' ),
								'type'    => 'color',
								'default' => G5CORE()->options()->header()->get_default( 'header_mobile_top_bar_text_color' ),
							),
							'header_mobile_top_bar_text_hover_color' => array(
								'id'      => 'header_mobile_top_bar_text_hover_color',
								'title'   => esc_html__( 'Top Bar Hover Color', 'g5-core' ),
								'type'    => 'color',
								'default' => G5CORE()->options()->header()->get_default( 'header_mobile_top_bar_text_hover_color' ),
							),
							'header_mobile_top_bar_border_color'     => array(
								'id'      => 'header_mobile_top_bar_border_color',
								'title'   => esc_html__( 'Top Bar Border Color', 'g5-core' ),
								'type'    => 'color',
								'alpha'    => true,
								'default' => G5CORE()->options()->header()->get_default( 'header_mobile_top_bar_border_color' ),
							),

							'header_info'                    => array(
								'id'    => 'header_info',
								'title' => esc_html__( 'Header', 'g5-core' ),
								'type'  => 'info',
								'style' => 'info'
							),
							'header_mobile_color_scheme'     => array(
								'id'      => 'header_mobile_color_scheme',
								'title'   => esc_html__( 'Color Scheme', 'g5-core' ),
								'type'    => 'button_set',
								'options' => array(
									'light' => esc_html__( 'Light', 'g5-core' ),
									'dark'  => esc_html__( 'Dark', 'g5-core' )
								),
								'default' => G5CORE()->options()->header()->get_default( 'header_mobile_color_scheme' ),
								'preset'  => array(
									array(
										'op'     => '=',
										'value'  => 'light',
										'fields' => array(
                                            array( 'header_mobile_background_color', '#fff' ),
                                            array( 'header_mobile_text_color', '#1b1b1b' ),
                                            array( 'header_mobile_text_hover_color', '#999' ),
                                            array( 'header_mobile_border_color', '#ececec' ),
										)
									),
									array(
										'op'     => '=',
										'value'  => 'dark',
										'fields' => array(
                                            array( 'header_mobile_background_color', '#1b1b1b' ),
                                            array( 'header_mobile_text_color', '#ccc' ),
                                            array( 'header_mobile_text_hover_color', '#fff' ),
                                            array( 'header_mobile_border_color', '#2f2f2f' ),
										)
									),
								)
							),
							'header_mobile_background_color' => array(
								'id'      => 'header_mobile_background_color',
								'title'   => esc_html__( 'Background Color', 'g5-core' ),
								'type'    => 'color',
								'alpha'   => true,
								'default' => G5CORE()->options()->header()->get_default( 'header_mobile_background_color' ),
							),
							'header_mobile_text_color'       => array(
								'id'      => 'header_mobile_text_color',
								'title'   => esc_html__( 'Text Color', 'g5-core' ),
								'type'    => 'color',
								'default' => G5CORE()->options()->header()->get_default( 'header_mobile_text_color' ),
							),
							'header_mobile_text_hover_color' => array(
								'id'      => 'header_mobile_text_hover_color',
								'title'   => esc_html__( 'Text Hover Color', 'g5-core' ),
								'type'    => 'color',
								'default' => G5CORE()->options()->header()->get_default( 'header_mobile_text_hover_color' ),
							),
							'header_mobile_border_color'     => array(
								'id'      => 'header_mobile_border_color',
								'title'   => esc_html__( 'Border Color', 'g5-core' ),
								'type'    => 'color',
								'alpha'    => true,
								'default' => G5CORE()->options()->header()->get_default( 'header_mobile_border_color' ),
							),

							'header_sticky_info'                    => array(
								'id'    => 'header_sticky_info',
								'title' => esc_html__( 'Header Sticky', 'g5-core' ),
								'type'  => 'info',
								'style' => 'info'
							),
							'header_mobile_sticky_color_scheme'     => array(
								'id'      => 'header_mobile_sticky_color_scheme',
								'title'   => esc_html__( 'Color Scheme', 'g5-core' ),
								'type'    => 'button_set',
								'options' => array(
									'light' => esc_html__( 'Light', 'g5-core' ),
									'dark'  => esc_html__( 'Dark', 'g5-core' )
								),
								'default' => G5CORE()->options()->header()->get_default( 'header_mobile_sticky_color_scheme' ),
								'preset'  => array(
									array(
										'op'     => '=',
										'value'  => 'light',
										'fields' => array(
                                            array( 'header_mobile_sticky_background_color', '#fff' ),
                                            array( 'header_mobile_sticky_text_color', '#1b1b1b' ),
                                            array( 'header_mobile_sticky_text_hover_color', '#999' ),
                                            array( 'header_mobile_sticky_border_color', '#ececec' ),
										)
									),
									array(
										'op'     => '=',
										'value'  => 'dark',
										'fields' => array(
                                            array( 'header_mobile_sticky_background_color', '#1b1b1b' ),
                                            array( 'header_mobile_sticky_text_color', '#ccc' ),
                                            array( 'header_mobile_sticky_text_hover_color', '#fff' ),
                                            array( 'header_mobile_sticky_border_color', '#2f2f2f' ),
										)
									),
								)
							),
							'header_mobile_sticky_background_color' => array(
								'id'      => 'header_mobile_sticky_background_color',
								'title'   => esc_html__( 'Background Color', 'g5-core' ),
								'type'    => 'color',
								'alpha'   => true,
								'default' => G5CORE()->options()->header()->get_default( 'header_mobile_sticky_background_color' ),
							),
							'header_mobile_sticky_text_color'       => array(
								'id'      => 'header_mobile_sticky_text_color',
								'title'   => esc_html__( 'Text Color', 'g5-core' ),
								'type'    => 'color',
								'default' => G5CORE()->options()->header()->get_default( 'header_mobile_sticky_text_color' ),
							),
							'header_mobile_sticky_text_hover_color' => array(
								'id'      => 'header_mobile_sticky_text_hover_color',
								'title'   => esc_html__( 'Text Hover Color', 'g5-core' ),
								'type'    => 'color',
								'default' => G5CORE()->options()->header()->get_default( 'header_mobile_sticky_text_hover_color' ),
							),
							'header_mobile_sticky_border_color'     => array(
								'id'      => 'header_mobile_sticky_border_color',
								'title'   => esc_html__( 'Border Color', 'g5-core' ),
								'type'    => 'color',
								'alpha'    => true,
								'default' => G5CORE()->options()->header()->get_default( 'header_mobile_sticky_border_color' ),
							),
						),
					),
				)
			);
		}

		public function section_mobile() {
			return array(
				'id'     => 'section_mobile',
				'title'  => esc_html__( 'Mobile', 'g5-core' ),
				'icon'   => 'dashicons dashicons-tablet',
				'fields' => array(
					'mobile_header_style' => array(
						'id'          => 'mobile_header_style',
						'title'       => esc_html__( 'Header Style', 'g5-core' ),
						'type'        => 'select_popup',
						'style'       => 'box',
						'popup_width' => '512px',
						'options'     => G5CORE()->settings()->get_header_mobile_layout(),
						'default'     => G5CORE()->options()->header()->get_default( 'mobile_header_style' ),
					),

					'mobile_navigation_skin' => array(
						'id'      => 'mobile_navigation_skin',
						'title'   => esc_html__( 'Navigation Skin', 'g5-core' ),
						'type'    => 'button_set',
						'options' => array(
							'dark'  => esc_html__( 'Dark', 'g5-core' ),
							'light' => esc_html__( 'Light', 'g5-core' ),
						),
						'default' => G5CORE()->options()->header()->get_default( 'mobile_navigation_skin' ),
					),

					'mobile_header_float_enable' => G5CORE()->fields()->get_config_toggle( array(
						'id'       => 'mobile_header_float_enable',
						'title'    => esc_html__( 'Header Float', 'g5-core' ),
						'subtitle' => esc_html__( 'Turn On this option if you want to enable header float', 'g5-core' ),
						'default'  => G5CORE()->options()->header()->get_default( 'mobile_header_float_enable' ),
					) ),

					'mobile_header_sticky' => array(
						'id'      => 'mobile_header_sticky',
						'title'   => esc_html__( 'Header Sticky', 'g5-core' ),
						'type'    => 'button_set',
						'options' => G5CORE()->settings()->get_header_sticky(),
						'default' => G5CORE()->options()->header()->get_default( 'mobile_header_sticky' ),
					),

					'mobile_logo' => array(
						'id'       => 'mobile_logo',
						'title'    => esc_html__( 'Logo Mobile', 'g5-core' ),
						'subtitle' => esc_html__( 'By default, use the logo setting', 'g5-core' ),
						'type'     => 'image',
						'default'  => G5CORE()->options()->header()->get_default( 'mobile_logo' ),
					),

					'mobile_sticky_logo' => array(
						'id'       => 'mobile_sticky_logo',
						'title'    => esc_html__( 'Sticky Logo Mobile', 'g5-core' ),
						'subtitle' => esc_html__( 'By default, use the logo setting', 'g5-core' ),
						'type'     => 'image',
						'default'  => G5CORE()->options()->header()->get_default( 'mobile_sticky_logo' ),
					),
					array(
						'id'       => 'mobile_logo_max_height',
						'title'    => esc_html__( 'Logo Max Height', 'g5-core' ),
						'subtitle' => esc_html__( 'If you would like to override the default logo max height, then you can do so here.', 'g5-core' ),
						'type'     => 'dimension',
						'width'    => false,
						'default'  => G5CORE()->options()->header()->get_default( 'mobile_logo_max_height' ),
					),
                    'mobile_logo_sticky_max_height' => array(
                        'id'       => 'mobile_logo_sticky_max_height',
                        'title'    => esc_html__( 'Logo Sticky Max Height', 'g5-core' ),
                        'subtitle' => esc_html__( 'If you would like to override the default logo sticky max height, then you can do so here.', 'g5-core' ),
                        'type'     => 'dimension',
                        'width'    => false,
                        'default'  => G5CORE()->options()->header()->get_default( 'mobile_logo_sticky_max_height' ),
                    ),

					'group_header_mobile_top_bar' => array(
						'id'     => 'group_header_mobile_top_bar',
						'title'  => esc_html__( 'Top Bar', 'g5-core' ),
						'type'   => 'group',
						'fields' => array(
							'top_bar_mobile_enable' => G5CORE()->fields()->get_config_toggle( array(
								'id'       => 'top_bar_mobile_enable',
								'title'    => esc_html__( 'Top Bar Enable', 'g5-core' ),
								'subtitle' => esc_html__( 'Turn On this option if you want to enable top bar', 'g5-core' ),
								'default'  => G5CORE()->options()->header()->get_default( 'top_bar_mobile_enable' ),
							) ),
							'top_bar_mobile_border_bottom' => G5CORE()->fields()->get_config_toggle( array(
								'id'       => 'top_bar_mobile_border_bottom',
								'title'    => esc_html__( 'Header Border Bottom Enable?', 'g5-core' ),
								'subtitle' => esc_html__( 'Turn On this option if you want to show header border bottom', 'g5-core' ),
								'default'  => G5CORE()->options()->header()->get_default( 'top_bar_mobile_border_bottom' ),
								'required' => array( 'top_bar_mobile_enable', '=', 'on' ),
							) ),
							'top_bar_mobile_items' => array(
								'id'       => 'top_bar_mobile_items',
								'title'    => esc_html__( 'Top Bar Items', 'g5-core' ),
								'type'     => 'sorter',
								'required' => array( 'top_bar_mobile_enable', '=', 'on' ),
								'default'  => G5CORE()->options()->header()->get_default( 'top_bar_mobile_items' ),
							),
							'top_bar_mobile_items_custom_html_1' => array(
								'id'       => 'top_bar_mobile_items_custom_html_1',
								'title'    => esc_html__( 'Custom Html 1', 'g5-core' ),
								'type'     => 'ace_editor',
								'mode'     => 'html',
								'default'  => G5CORE()->options()->header()->get_default( 'top_bar_mobile_items_custom_html_1' ),
								'required' => array(
									array( 'top_bar_mobile_enable', '=', 'on' ),
									array( 'top_bar_mobile_items[disable]', 'not contain', 'custom-html-1' )
								)
							),
							'top_bar_mobile_items_custom_html_2' => array(
								'id'       => 'top_bar_mobile_items_custom_html_2',
								'title'    => esc_html__( 'Custom Html 2', 'g5-core' ),
								'type'     => 'ace_editor',
								'mode'     => 'html',
								'default'  => G5CORE()->options()->header()->get_default( 'top_bar_mobile_items_custom_html_2' ),
								'required' => array(
									array( 'top_bar_mobile_enable', '=', 'on' ),
									array( 'top_bar_mobile_items[disable]', 'not contain', 'custom-html-2' )
								)
							),
						)
					),

					'group_header_mobile_customize' => array(
						'id'     => 'group_header_mobile_customize',
						'title'  => esc_html__( 'Customize', 'g5-core' ),
						'type'   => 'group',
						'fields' => array(
							'header_mobile_customize' => array(
								'id'      => 'header_mobile_customize',
								'title'   => esc_html__( 'Items', 'g5-core' ),
								'type'    => 'sortable',
								'options' => G5CORE()->settings()->get_header_mobile_customize(),
								'default' => G5CORE()->options()->header()->get_default( 'header_mobile_customize' ),
							),

							'header_mobile_customize_custom_html' => array(
								'id'       => 'header_mobile_customize_custom_html',
								'title'    => esc_html__( 'Custom Html Content', 'g5-core' ),
								'type'     => 'ace_editor',
								'mode'     => 'html',
								'required' => array( 'header_mobile_customize', 'contain', 'custom-html' ),
								'default'  => G5CORE()->options()->header()->get_default( 'header_mobile_customize_custom_html' ),
							),
						)
					),

					'mobile_header_css_classes' => array(
						'id'       => 'mobile_header_css_classes',
						'type'     => 'text',
						'title'    => esc_html__( 'Css Classes', 'g5-core' ),
						'subtitle' => esc_html__( 'Add custom css classes to the Mobile Header', 'g5-core' ),
						'default'  => G5CORE()->options()->header()->get_default( 'mobile_header_css_classes' ),
						'required' => array( "header_enable", '=', 'on' ),
					),
				)
			);
		}

		// Metabox
		public function define_meta_box( $configs ) {
			$prefix                           = G5CORE()->meta_prefix;
			$configs['g5core_header_options'] = array(
				'name'      => esc_html__( 'Header Settings', 'g5-core' ),
				'post_type' => apply_filters('g5core_meta_box_header_post_types',array_keys( g5core_post_types_active() )) ,
				'layout'    => 'inline',
				'fields'    => array(
					"{$prefix}header_preset" => array(
						'id'          => "{$prefix}header_preset",
						'title'       => esc_html__( 'Header Preset', 'g5-core' ),
						'type'        => 'selectize',
						'allow_clear' => true,
						'data'        => 'preset',
						'data-option' => G5Core_Config_Header_Options::getInstance()->options_name(),
						'create_link' => admin_url( 'admin.php?page=g5core_header_options' ),
						'edit_link'   => admin_url( 'admin.php?page=g5core_header_options' ),
						'placeholder' => esc_html__( 'Select Preset', 'g5-core' ),
						'multiple'    => false,
						'desc'        => esc_html__( 'Optionally you can choose to override the setting that is used on the page', 'g5-core' ),
					),

					"{$prefix}page_menu"        => array(
						'id'          => "{$prefix}page_menu",
						'title'       => esc_html__( 'Page Menu', 'g5-core' ),
						'type'        => 'selectize',
						'allow_clear' => true,
						'placeholder' => esc_html__( 'Select Menu', 'g5-core' ),
						'desc'        => esc_html__( 'Optionally you can choose to override the menu that is used on the page', 'g5-core' ),
						'data'        => 'menu'
					),
					"{$prefix}page_mobile_menu" => array(
						'id'          => "{$prefix}page_mobile_menu",
						'title'       => esc_html__( 'Page Mobile Menu', 'g5-core' ),
						'type'        => 'selectize',
						'allow_clear' => true,
						'placeholder' => esc_html__( 'Select Menu', 'g5-core' ),
						'desc'        => esc_html__( 'Optionally you can choose to override the menu mobile that is used on the page', 'g5-core' ),
						'data'        => 'menu'
					),
					"{$prefix}is_one_page"      => G5CORE()->fields()->get_config_toggle( array(
						'id'    => "{$prefix}is_one_page",
						'title' => esc_html__( 'Is One Page', 'g5-core' ),
						'desc'  => esc_html__( 'Set page style is One Page', 'g5-core' ),
					) ),
					"{$prefix}header_layout" => array(
						'id'       => "{$prefix}header_layout",
						'title'    => esc_html__( 'Header Layout', 'g5-core' ),
						'type'     => 'select',
						'options'  => G5CORE()->settings()->get_header_layout(true),
						'default'  => '',
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

				$header_preset = get_post_meta( $id, "{$prefix}header_preset", true );
				$header_layout = get_post_meta( $id, "{$prefix}header_layout", true );


				if ( ! empty( $header_preset ) ) {
					G5CORE()->options()->header()->set_preset( $header_preset );
				}

				if ( ! empty( $header_layout ) ) {
					G5CORE()->options()->header()->set_option( 'header_layout',$header_layout);
				}
			}
		}
	}
}