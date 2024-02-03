<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if ( ! class_exists( 'G5Core_Config_Options' ) ) {
	class G5Core_Config_Options {
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
			add_filter( 'gsf_option_config', array( $this, 'define_theme_options' ), 10 );

			add_action( 'init', array( $this, 'page_404_process' ) );
			add_action( 'init', array( $this, 'custom_css_js' ) );
			add_action( 'wp_footer', array( $this, 'back_to_top_template' ) );
			add_action( 'template_redirect', array( $this, 'maintenance_mode' ) );
			add_action( 'body_class', array( $this, 'body_class' ) );
			add_action( G5CORE_CURRENT_THEME . '_before_page_wrapper', array( $this, 'site_loading' ), 5 );

			add_action( 'template_redirect', array( $this, 'change_page_setting' ), 5 );

            add_action('pre_get_posts', array($this, 'pre_get_posts'));
		}

		public function define_theme_options( $configs ) {
			$configs['g5core_options'] = array(
				'layout'      => 'inline',
				'page_title'  => esc_html__( 'Settings', 'g5-core' ),
				'menu_title'  => esc_html__( 'Settings', 'g5-core' ),
				'option_name' => G5CORE()->options_name(),
				'permission'  => 'manage_options',
				'parent_slug' => 'g5core_options',
				'preset'      => get_theme_support( 'g5core_options_preset' ),
				'section'     => $this->config(),
			);

			return $configs;
		}

		public function config() {
			return array_merge( array(
				$this->section_general(),
				$this->section_connections(),
				$this->section_code()
			), $this->section_post_type() );
		}

		public function section_general() {
			$allowed_html = array(
				'i'    => array(
					'class' => array()
				),
				'span' => array(
					'class' => array()
				),
				'a'    => array(
					'href'   => array(),
					'title'  => array(),
					'target' => array()
				)
			);
			$configs = array(
				'id'     => 'section_general',
				'title'  => esc_html__( 'General', 'g5-core' ),
				'icon'   => 'dashicons dashicons-admin-site',
				'fields' => array(
					'section_general_group_general' => array(
						'id'     => 'section_general_group_general',
						'title'  => esc_html__( 'General', 'g5-core' ),
						'type'   => 'group',
						'fields' => array(
							'back_to_top' => G5CORE()->fields()->get_config_toggle( array(
								'id'       => 'back_to_top',
								'title'    => esc_html__( 'Back To Top', 'g5-core' ),
								'subtitle' => esc_html__( 'Turn Off this option if you want to disable back to top', 'g5-core' ),
								'default'  => 'on'
							) ),
							'image_lazy_load_enable' => G5CORE()->fields()->get_config_toggle( array(
								'id'       => 'image_lazy_load_enable',
								'title'    => esc_html__( 'Image Lazy Load?', 'g5-core' ),
								'subtitle' => esc_html__( 'Turn on to make images load on scroll.', 'g5-core' ),
								'default'  => ''
							) ),
							'google_map_api_key' => array(
								'id'      => 'google_map_api_key',
								'type'    => 'text',
								'title'   => esc_html__( 'Google Map API Key', 'g5-core' ),
								'desc'    => sprintf( __( 'Note: you must create personal <a href="%s">Google Map API key</a> for accurate and long-term use', 'g5-core' ), 'Note: you must create personal' ),
								'default' => 'AIzaSyB_RmOPuQi5SzCecy6SyHn8M0HJtxvs2gY',
							),
							'mapbox_api_access_token' => array(
								'id' => 'mapbox_api_access_token',
								'type'     => 'text',
								'title'    => esc_html__( 'Mapbox API Access Token', 'g5-core' ),
								'desc'     => wp_kses( __( 'A Mapbox API Access Token is required to load maps. You can get it in <a target="_blank" href="https://www.mapbox.com/account/">in your Mapbox user dashboard</a>.', 'g5-core' ), $allowed_html ),
								'subtitle' => esc_html__( 'Enter your mapbox api access token', 'g5-core' ),
								'default'  => '',
							),
						)
					),
					'post_default_thumbnail_group' => array(
						'id'             => 'post_default_thumbnail_group',
						'title'          => esc_html__( 'Post Default Thumbnail', 'g5-core' ),
						'type'           => 'group',
						'toggle_default' => false,
						'fields'         => array(
							'default_thumbnail_placeholder_enable' => G5CORE()->fields()->get_config_toggle( array(
								'id'      => 'default_thumbnail_placeholder_enable',
								'title'   => esc_html__( 'Enable Default Thumbnail Placeholder', 'g5-core' ),
								'desc'    => esc_html__( 'You can set default thumbnail for post that haven\' featured image with enabling this option and uploading default image in following field', 'g5-core' ),
								'default' => ''
							) ),
							'default_thumbnail_image'              => array(
								'id'       => 'default_thumbnail_image',
								'type'     => 'image',
								'title'    => esc_html__( 'Default Thumbnail Image', 'g5-core' ),
								'desc'     => esc_html__( 'By default, the post thumbnail will be shown but when the post haven\'nt thumbnail then this will be replaced', 'g5-core' ),
								'required' => array( 'default_thumbnail_placeholder_enable', '=', 'on' ),
							),
							'first_image_as_post_thumbnail'        => G5CORE()->fields()->get_config_toggle( array(
								'id'      => 'first_image_as_post_thumbnail',
								'title'   => esc_html__( 'First Image as Post Thumbnail', 'g5-core' ),
								'desc'    => esc_html__( 'With enabling this options if any post have not thumbnail then theme will shows first content image as post thumbnail.', 'g5-core' ),
								'default' => '',
							) )
						)
					),
					'section_general_group_search' => array(
						'id'             => 'section_general_group_search',
						'title'          => esc_html__( 'Search', 'g5-core' ),
						'type'           => 'group',
						'toggle_default' => false,
						'fields'         => array(
							'search_post_types' => array(
								'id'           => 'search_post_types',
								'title'        => esc_html__( 'Search Post Types', 'g5-core' ),
								'type'         => 'checkbox_list',
								'value_inline' => false,
								'default'      => array( 'all' ),
								'options'      => G5CORE()->settings()->post_types_for_search(),
							),
							'search_ajax_enable' => G5CORE()->fields()->get_config_toggle( array(
								'id'       => 'search_ajax_enable',
								'title'    => esc_html__( 'Search Ajax Enable', 'g5-core' ),
								'subtitle' => esc_html__( 'Turn On this option if you want to search ajax enable', 'g5-core' ),
							) ),
							'search_popup_result_amount' => array(
								'id'         => 'search_popup_result_amount',
								'type'       => 'text',
								'input_type' => 'number',
								'title'      => esc_html__( 'Amount Of Search Result', 'g5-core' ),
								'required'   => array( 'search_ajax_enable', '=', 'on' ),
								'default'    => 8,
							),
						)
					),
					'section_general_group_maintenance' => array(
						'id'             => 'section_general_group_maintenance',
						'title'          => esc_html__( 'Maintenance', 'g5-core' ),
						'type'           => 'group',
						'toggle_default' => false,
						'fields'         => array(
							'maintenance_mode' => array(
								'id'      => 'maintenance_mode',
								'type'    => 'button_set',
								'title'   => esc_html__( 'Maintenance Mode', 'g5-core' ),
								'options' => G5CORE()->settings()->get_maintenance_mode(),
								'default' => 'off'
							),
							'maintenance_mode_page' => array(
								'id'          => 'maintenance_mode_page',
								'title'       => esc_html__( 'Maintenance Mode Page', 'g5-core' ),
								'subtitle'    => esc_html__( 'Select the page that is your maintenance page, if you would like to show a custom page instead of the standard WordPress message. You should use the Holding Page template for this page.', 'g5-core' ),
								'type'        => 'selectize',
								'placeholder' => esc_html__( 'Select Page', 'g5-core' ),
								'data'        => 'page',
								'data_args'   => array(
									'numberposts' => - 1
								),
								'edit_link'   => true,
								'allow_clear' => true,
								'default'     => '',
								'required'    => array( 'maintenance_mode', '=', 'custom' ),

							),
						)
					),
					'section_general_group_page_loading' => array(
						'id'             => 'section_general_group_page_loading',
						'title'          => esc_html__( 'Page Loading', 'g5-core' ),
						'type'           => 'group',
						'toggle_default' => false,
						'fields'         => array(
							'loading_animation' => array(
								'id'       => 'loading_animation',
								'type'     => 'select',
								'title'    => esc_html__( 'Loading Animation', 'g5-core' ),
								'subtitle' => esc_html__( 'Select type of pre load animation', 'g5-core' ),
								'options'  => G5CORE()->settings()->get_loading_animation(),
								'default'  => ''
							),
							'loading_logo' => array(
								'id'       => 'loading_logo',
								'type'     => 'image',
								'title'    => esc_html__( 'Logo Loading', 'g5-core' ),
								'required' => array( 'loading_animation', '!=', '' ),
							),

							'loading_animation_bg_color' => array(
								'id'       => 'loading_animation_bg_color',
								'title'    => esc_html__( 'Loading Background Color', 'g5-core' ),
								'type'     => 'color',
								'alpha'    => true,
								'default'  => '#fff',
								'required' => array( 'loading_animation', '!=', '' ),
							),

							'spinner_color' => array(
								'id'       => 'spinner_color',
								'title'    => esc_html__( 'Spinner color', 'g5-core' ),
								'type'     => 'color',
								'default'  => '',
								'required' => array( 'loading_animation', '!=', '' ),
							),

						)
					),
					'section_general_group_404' => array(
						'id'             => 'section_general_group_404',
						'title'          => esc_html__( '404 Page', 'g5-core' ),
						'type'           => 'group',
						'toggle_default' => false,
						'fields'         => array(
							'page_404_custom' => array(
								'id'          => 'page_404_custom',
								'title'       => esc_html__( 'Custom 404 Page', 'g5-core' ),
								'type'        => 'selectize',
								'placeholder' => esc_html__( 'Select Page', 'g5-core' ),
								'data'        => 'page',
								'data_args'   => array(
									'numberposts' => - 1
								),
								'allow_clear' => true,
								'edit_link'   => true,
								'default'     => '',
							)
						)
					),
					'section_social_share' =>  array(
						'id'             => 'section_social_share',
						'title'          => esc_html__( 'Social Share', 'g5-core' ),
						'type'           => 'group',
						'toggle_default' => false,
						'fields' =>  array(
							'single_social_share' => array(
								'id'       => 'single_social_share',
								'title'    => esc_html__('Social Share', 'g5-core'),
								'subtitle' => esc_html__('Select active social share links and sort them', 'g5-core'),
								'type'     => 'sortable',
								'options'  => G5CORE()->settings()->get_social_share(),
								'default'  => G5CORE()->options()->get_default( 'single_social_share', array(
									'facebook'  => 'facebook',
									'twitter'   => 'twitter',
									'linkedin'  => 'linkedin',
									'tumblr'    => 'tumblr',
									'pinterest' => 'pinterest'
								) ),
							),
						)
					)
				)
			);

			return $configs;
		}

		public function section_code() {
			return array(
				'id'              => 'section_code',
				'title'           => esc_html__( 'Css & Javascript', 'g5-core' ),
				'icon'            => 'dashicons dashicons-editor-code',
				'general_options' => true,
				'fields'          => array(
					'custom_css' => array(
						'id'       => 'custom_css',
						'title'    => esc_html__( 'Custom Css', 'g5-core' ),
						'subtitle' => esc_html__( 'Enter here your custom CSS. Please do not include any style tags.', 'g5-core' ),
						'type'     => 'ace_editor',
						'mode'     => 'css',
						'min_line' => 20
					),
					'custom_js' => array(
						'id'       => 'custom_js',
						'title'    => esc_html__( 'Custom Javascript', 'g5-core' ),
						'subtitle' => esc_html__( 'Enter here your custom javascript code. Please do not include any script tags.', 'g5-core' ),
						'type'     => 'ace_editor',
						'mode'     => 'javascript',
						'min_line' => 20
					),
				)
			);
		}

		public function section_connections() {
			return array(
				'id'              => 'section_connections',
				'title'           => esc_html__( 'Connections', 'g5-core' ),
				'icon'            => 'dashicons dashicons-share',
				'general_options' => true,
				'fields'          => array(
					'social_networks' => array(
						'id'             => 'social_networks',
						'title'          => esc_html__( 'Social Networks', 'g5-core' ),
						'desc'           => esc_html__( 'Define here all the social networks you will need.', 'g5-core' ),
						'type'           => 'panel',
						'toggle_default' => false,
						'default'        => G5CORE()->settings()->get_social_networks_default(),
						'panel_title'    => 'social_name',
						'fields'         => array(
							array(
								'id'       => 'social_name',
								'title'    => esc_html__( 'Title', 'g5-core' ),
								'subtitle' => esc_html__( 'Enter your social network name', 'g5-core' ),
								'type'     => 'text',
							),
							array(
								'id'         => 'social_id',
								'title'      => esc_html__( 'Unique Social Id', 'g5-core' ),
								'subtitle'   => esc_html__( 'This value is created automatically and it shouldn\'t be edited unless you know what you are doing.', 'g5-core' ),
								'type'       => 'text',
								'input_type' => 'unique_id',
								'default'    => 'social-'
							),
							array(
								'id'       => 'social_icon',
								'title'    => esc_html__( 'Social Network Icon', 'g5-core' ),
								'subtitle' => esc_html__( 'Specify the social network icon', 'g5-core' ),
								'type'     => 'icon',
							),
							array(
								'id'       => 'social_link',
								'title'    => esc_html__( 'Social Network Link', 'g5-core' ),
								'subtitle' => esc_html__( 'Enter your social network link', 'g5-core' ),
								'type'     => 'text',
							),
							array(
								'id'       => 'social_color',
								'title'    => esc_html__( 'Social Network Color', 'g5-core' ),
								'subtitle' => sprintf( wp_kses_post( __( 'Specify the social network color. Reference in <a target="_blank" href="%s">brandcolors.net</a>', 'g5-core' ) ), 'https://brandcolors.net/' ),
								'type'     => 'color'
							)
						)
					)
				)
			);
		}

		public function section_post_type() {
			$sections = array();

			foreach ( g5core_post_types_active() as $pt_name => $pt ) {
				if ( $pt_name === 'page' ) {
					continue;
				}
				$sections["section__{$pt_name}"] = array(
					'id'              => "section_post_type_{$pt_name}",
					'title'           => $pt['label'],
					'icon'            => 'dashicons dashicons-admin-post',
					'general_options' => true,
					'fields'          => array(
						"{$pt_name}__info"              => array(
							'type'  => 'info',
							'style' => 'heading',
							'title' => esc_html__( 'Custom setting for ', 'g5-core' ) . $pt['label'],
							'desc' => sprintf(__('You can overwrite custom setting on %s page','g5-core'), $pt['label']),
						),
						"section_post_type_{$pt_name}_single"  => array(
							'id'     => "section_post_type_{$pt_name}_single",
							'title'  => esc_html__( 'Single setting', 'g5-core' ),
							'type'   => 'group',
							'fields' => array(
								$this->header_config( $pt_name, 'single' ),
								$this->page_title_config( $pt_name, 'single' ),
								$this->layout_config( $pt_name, 'single' ),
								$this->footer_config( $pt_name, 'single' ),
								$this->color_config( $pt_name, 'single' ),
								$this->typography_config( $pt_name, 'single' )
							)
						),
						"section_post_type_{$pt_name}_archive" => array(
							'id'             => "section_post_type_{$pt_name}_archive",
							'title'          => esc_html__( 'Archive setting', 'g5-core' ),
							'type'           => 'group',
							'toggle_default' => false,
							'fields'         => array(
								$this->header_config( $pt_name, 'archive' ),
								$this->page_title_config( $pt_name, 'archive' ),
								$this->layout_config( $pt_name, 'archive' ),
								$this->footer_config( $pt_name, 'archive' ),
								$this->color_config( $pt_name, 'archive' ),
								$this->typography_config( $pt_name, 'archive' )
							)
						),
					)
				);
			}

			return $sections;
		}

		public function header_config( $pt_name, $type ) {
			return array(
				'id'             => "section_post_type_{$pt_name}_{$type}__header_group",
				'title'          => esc_html__( 'Header', 'g5-core' ),
				'type'           => 'group',
				'toggle_default' => false,
				'fields'         => array(
					"{$pt_name}_{$type}__header_preset" => array(
						'id'          => "{$pt_name}_{$type}__header_preset",
						'title'       => esc_html__( 'Header Preset', 'g5-core' ),
						'type'        => 'selectize',
						'allow_clear' => true,
						'data'        => 'preset',
						'data-option' => G5Core_Config_Header_Options::getInstance()->options_name(),
						'create_link' => admin_url( 'admin.php?page=g5core_header_options' ),
						'edit_link'   => admin_url( 'admin.php?page=g5core_header_options' ),
						'placeholder' => esc_html__( 'Select Preset', 'g5-core' ),
						'multiple'    => false,
						'desc'        => esc_html__( 'Optionally you can choose to override header default.', 'g5-core' ),
						'default'  => G5CORE()->options()->get_default( "{$pt_name}_{$type}__header_preset", '' ),
					),
					"{$pt_name}_{$type}__header_layout" => array(
						'id'       => "{$pt_name}_{$type}__header_layout" ,
						'title'    => esc_html__( 'Header Layout', 'g5-core' ),
						'type'     => 'select',
						'options'  => G5CORE()->settings()->get_header_layout(true),
						'default'  => '',
					),
				)
			);
		}

		public function color_config( $pt_name, $type ) {
			return array(
				'id'             => "section_post_type_{$pt_name}_{$type}__color_group",
				'title'          => esc_html__( 'Color', 'g5-core' ),
				'type'           => 'group',
				'toggle_default' => false,
				'fields'         => array(
					"{$pt_name}_{$type}__color_preset" => array(
						'id'          => "{$pt_name}_{$type}__color_preset",
						'title'       => esc_html__( 'Color Preset', 'g5-core' ),
						'type'        => 'selectize',
						'allow_clear' => true,
						'data'        => 'preset',
						'data-option' => G5Core_Config_Color_Options::getInstance()->options_name(),
						'create_link' => admin_url( 'admin.php?page=g5core_color_options' ),
						'edit_link'   => admin_url( 'admin.php?page=g5core_color_options' ),
						'placeholder' => esc_html__( 'Select Preset', 'g5-core' ),
						'multiple'    => false,
						'desc'        => esc_html__( 'Optionally you can choose to override colors default', 'g5-core' ),
						'default'  => G5CORE()->options()->get_default( "{$pt_name}_{$type}__color_preset", '' ),
					),
				)
			);
		}

		public function typography_config( $pt_name, $type ) {
			return array(
				'id'             => "section_post_type_{$pt_name}_{$type}__typography_group",
				'title'          => esc_html__( 'Typography', 'g5-core' ),
				'type'           => 'group',
				'toggle_default' => false,
				'fields'         => array(
					"{$pt_name}_{$type}__typography_preset" => array(
						'id'          => "{$pt_name}_{$type}__typography_preset",
						'title'       => esc_html__( 'Typography Preset', 'g5-core' ),
						'type'        => 'selectize',
						'allow_clear' => true,
						'data'        => 'preset',
						'data-option' => G5Core_Config_Typography_Options::getInstance()->options_name(),
						'create_link' => admin_url( 'admin.php?page=g5core_typography_options' ),
						'edit_link'   => admin_url( 'admin.php?page=g5core_typography_options' ),
						'placeholder' => esc_html__( 'Select Preset', 'g5-core' ),
						'multiple'    => false,
						'desc'        => esc_html__( 'Optionally you can choose to override typography default', 'g5-core' ),
						'default'  => G5CORE()->options()->get_default( "{$pt_name}_{$type}__typography_preset", '' ),
					),
				)
			);
		}

		public function page_title_config( $pt_name, $type ) {
			return array(
				'id'             => "section_post_type_{$pt_name}_{$type}__page_title_group",
				'title'          => esc_html__( 'Page Title', 'g5-core' ),
				'type'           => 'group',
				'toggle_default' => false,
				'fields'         => array(
					"{$pt_name}_{$type}__page_title_enable" => G5CORE()->fields()->get_config_toggle( array(
						'id'       => "{$pt_name}_{$type}__page_title_enable",
						'title'    => esc_html__( 'Page Title Enable', 'g5-core' ),
						'default'  => G5CORE()->options()->get_default( "{$pt_name}_{$type}__page_title_enable", '' ),
						'subtitle' => esc_html__( 'Turn Off this option if you want to hide page title', 'g5-core' ),
					), true ),

					"{$pt_name}_{$type}__page_title_layout"  => array(
						'id'       => "{$pt_name}_{$type}__page_title_layout",
						'title'    => esc_html__( 'Page Title Layout', 'g5-core' ),
						'type'     => 'select',
						'options'  => G5CORE()->settings()->get_page_title_layout(true),
						'default'  => G5CORE()->options()->get_default( "{$pt_name}_{$type}page_title_layout", '' ),
						'required' => array( "{$pt_name}_{$type}__page_title_enable", '!=', 'off' ),
					),


					"{$pt_name}_{$type}__page_title_content_block" => g5core_config_content_block( array(
						'id'       => "{$pt_name}_{$type}__page_title_content_block",
						'subtitle' => esc_html__( 'Specify the Content Block to use as a page title.', 'g5-core' ),
						'default'  => G5CORE()->options()->get_default( "{$pt_name}_{$type}__page_title_content_block", '' ),
						'data_args'   => array(
							'numberposts' => - 1,
							'meta_key' => G5CORE()->meta_prefix . 'content_block_type',
							'meta_value' => 'page_title',
							'meta_compare' => '='
						),
						'required' => array( "{$pt_name}_{$type}__page_title_enable", '!=', 'off' ),
					) ),
					"{$pt_name}_{$type}__breadcrumb_enable"        => G5CORE()->fields()->get_config_toggle( array(
						'id'       => "{$pt_name}_{$type}__breadcrumb_enable",
						'title'    => esc_html__( 'Breadcrumb Enable', 'g5-core' ),
						'subtitle' => esc_html__( 'Turn Off this option if you want to hide breadcrumb', 'g5-core' ),
						'default'  => G5CORE()->options()->get_default( "{$pt_name}_{$type}__breadcrumb_enable", '' ),
						'required' => array( "{$pt_name}_{$type}__page_title_enable", '!=', 'off' ),
					), true ),
				)
			);
		}

		public function layout_config( $pt_name, $type ) {
			return array(
				'id'             => "section_post_type_{$pt_name}_{$type}__layout_group",
				'title'          => esc_html__( 'Layout', 'g5-core' ),
				'type'           => 'group',
				'toggle_default' => false,
				'fields'         => array(
					"{$pt_name}_{$type}__site_layout"            => G5CORE()->fields()->get_config_site_layout(
						array(
							'id'      => "{$pt_name}_{$type}__site_layout",
							'default' => G5CORE()->options()->get_default( "{$pt_name}_{$type}__site_layout" ),
						), true ),
					"{$pt_name}_{$type}__sidebar"                => G5CORE()->fields()->get_config_sidebar( array(
						'id'       => "{$pt_name}_{$type}__sidebar",
						'default'  => G5CORE()->options()->get_default( "{$pt_name}_{$type}__sidebar" ),
						'required' => array( "{$pt_name}_{$type}__site_layout", '!=', 'none' )
					) ),

					"{$pt_name}_{$type}__site_stretched_content" => G5CORE()->fields()->get_config_toggle( array(
						'id'       => "{$pt_name}_{$type}__site_stretched_content",
						'title'    => esc_html__( 'Stretched Content', 'g5-core' ),
						'subtitle' => esc_html__( 'Turn On this option if you want to enable site stretched content', 'g5-core' ),
						'default'  => G5CORE()->options()->get_default( "{$pt_name}_{$type}__site_stretched_content" ),
					), true ),


					"{$pt_name}_{$type}__content_padding" => array(
						'id'       => "{$pt_name}_{$type}__content_padding",
						'title'    => esc_html__( 'Content Padding', 'g5-core' ),
						'subtitle' => esc_html__( 'Set content padding', 'g5-core' ),
						'type'     => 'spacing',
						'left'     => false,
						'right'    => false,
						'default'  => G5CORE()->options()->get_default( "{$pt_name}_{$type}__content_padding",
							array(
								'top'    => '',
								'bottom' => ''
							) ),
					),

					"{$pt_name}_{$type}__mobile_content_padding" => array(
						'id'       => "{$pt_name}_{$type}__mobile_content_padding",
						'title'    => esc_html__( 'Mobile Content Padding', 'g5-core' ),
						'subtitle' => esc_html__( 'Set mobile content padding', 'g5-core' ),
						'type'     => 'spacing',
						'left'     => false,
						'right'    => false,
						'default'  => G5CORE()->options()->get_default( "{$pt_name}_{$type}__mobile_content_padding",
							array(
								'top'    => '',
								'bottom' => ''
							) ),
					),

					"{$pt_name}_{$type}__custom_css"        => array(
						'id'       => "{$pt_name}_{$type}__custom_css",
						'title'    => esc_html__( 'Custom Css', 'g5-core' ),
						'subtitle' => esc_html__( 'Enter custom css to body', 'g5-core' ),
						'type'     => 'text',
					),
				)
			);
		}

		public function footer_config( $pt_name, $type ) {
			return array(
				'id'             => "section_post_type_{$pt_name}_{$type}__footer_group",
				'title'          => esc_html__( 'Footer', 'g5-core' ),
				'type'           => 'group',
				'toggle_default' => false,
				'fields'         => array(
					"{$pt_name}_{$type}__footer_enable"        => G5CORE()->fields()->get_config_toggle( array(
						'id'       => "{$pt_name}_{$type}__footer_enable",
						'title'    => esc_html__( 'Footer Enable', 'g5-core' ),
						'subtitle' => esc_html__( 'Turn Off this option if you want to disable footer', 'g5-core' ),
						'default'  => G5CORE()->options()->get_default( "{$pt_name}_{$type}__footer_enable", '' ),
					), true ),

					"{$pt_name}_{$type}__footer_layout"  => array(
						'id'       => "{$pt_name}_{$type}__footer_layout",
						'title'    => esc_html__( 'Footer Layout', 'g5-core' ),
						'type'     => 'select',
						'options'  => G5CORE()->settings()->get_footer_layout(true),
						'default'  => G5CORE()->options()->get_default( "{$pt_name}_{$type}footer_layout", '' ),
						'required' => array( "{$pt_name}_{$type}__footer_enable", '!=', 'off' ),
					),


					"{$pt_name}_{$type}__footer_content_block" => g5core_config_content_block( array(
						'id'       => "{$pt_name}_{$type}__footer_content_block",
						'subtitle' => esc_html__( 'Specify the Content Block to use as a footer content.', 'g5-core' ),
						'default'  => G5CORE()->options()->get_default( "{$pt_name}_{$type}__footer_content_block", '' ),
						'data_args'   => array(
							'numberposts' => - 1,
							'meta_key' => G5CORE()->meta_prefix . 'content_block_type',
							'meta_value' => 'footer',
							'meta_compare' => '='
						),
						'required' => array( "{$pt_name}_{$type}__footer_enable", '!=', 'off' ),
					), true ),
					"{$pt_name}_{$type}__footer_fixed_enable"  => G5CORE()->fields()->get_config_toggle( array(
						'id'       => "{$pt_name}_{$type}__footer_fixed_enable",
						'title'    => esc_html__( 'Footer Fixed', 'g5-core' ),
						'default'  => G5CORE()->options()->get_default( "{$pt_name}_{$type}__footer_fixed_enable", '' ),
						'required' => array( "{$pt_name}_{$type}__footer_enable", '!=', 'off' ),
					), true ),
				)
			);
		}

		public function back_to_top_template() {
			G5CORE()->get_template( 'back-to-top.php' );
		}

		public function maintenance_mode() {
			if ( is_user_logged_in() && current_user_can( 'edit_themes' ) ) {
				return;
			}

			$maintenance_mode = G5CORE()->options()->get_option( 'maintenance_mode' );

			switch ( $maintenance_mode ) {
				case 'standard' :
					wp_die( '<p style="text-align:center">' . esc_html__( 'We are currently in maintenance mode, please check back shortly.', 'g5-core' ) . '</p>', get_bloginfo( 'name' ) );
					break;
				case 'custom':
					$maintenance_mode_page = G5CORE()->options()->get_option( 'maintenance_mode_page' );
					if ( empty( $maintenance_mode_page ) ) {
						wp_die( '<p style="text-align:center">' . esc_html__( 'We are currently in maintenance mode, please check back shortly.', 'g5-core' ) . '</p>', get_bloginfo( 'name' ) );
					} else {
						$maintenance_mode_page_url = get_permalink( $maintenance_mode_page );
						if ( is_page() ) {
							$page_id = get_the_ID();
							if ( $page_id != $maintenance_mode_page ) {
								wp_redirect( $maintenance_mode_page_url );
							}
						} else {
							wp_redirect( $maintenance_mode_page_url );
						}
					}
					break;
			}
		}

		public function page_404_process() {
			$page_404_custom = G5CORE()->options()->get_option( 'page_404_custom' );
			if ( ! empty( $page_404_custom ) ) {
				remove_action( G5CORE_CURRENT_THEME . '_404_content', G5CORE_CURRENT_THEME . '_template_404_content', 10 );
				add_action( G5CORE_CURRENT_THEME . '_404_content', array( $this, 'page_404_template' ) );
			}
		}

		public function page_404_template() {
			$page_404_custom = G5CORE()->options()->get_option( 'page_404_custom' );
			echo g5core_get_content_block( $page_404_custom );
		}

		public function body_class( $classes ) {
			/**
			 * Page Loading
			 */
			$loading_animation = G5CORE()->options()->get_option( 'loading_animation' );
			if ( ! empty( $loading_animation ) ) {
				$classes[] = 'g5core-page-loading';
			}

			return $classes;
		}

		public function site_loading() {
			G5CORE()->get_template( 'site-loading.php' );
		}

		public function custom_css_js() {
			$custom_css = G5CORE()->options()->get_option( 'custom_css' );
			$custom_js  = G5CORE()->options()->get_option( 'custom_js' );

			if ( ! empty( $custom_css ) ) {
				G5CORE()->custom_css()->addCss( $custom_css, 'theme_custom_css' );
			}
			if ( ! empty( $custom_js ) ) {
				wp_add_inline_script( G5CORE()->assets_handle( 'frontend' ), $custom_js );
			}
		}

		public function change_page_setting() {
			$current_post_type = g5core_get_current_post_type();
			if ( ! empty( $current_post_type ) && ( $current_post_type !== 'page_single' ) ) {
				/**
				 * Set Preset
				 */
				$header_preset     = G5CORE()->options()->get_option( $current_post_type . '__header_preset' );
				$header_layout     = G5CORE()->options()->get_option( $current_post_type . '__header_layout' );

				$typography_preset = G5CORE()->options()->get_option( $current_post_type . '__typography_preset' );
				$color_preset      = G5CORE()->options()->get_option( $current_post_type . '__color_preset' );

				if ( ! empty( $header_preset ) ) {
					G5CORE()->options()->header()->set_preset( $header_preset );
				}

				if ( ! empty( $header_layout ) ) {
					G5CORE()->options()->header()->set_option('header_layout', $header_layout );
				}

				if ( ! empty( $typography_preset ) ) {
					G5CORE()->options()->typography()->set_preset( $typography_preset );
				}

				if ( ! empty( $color_preset ) ) {
					G5CORE()->options()->color()->set_preset( $color_preset );
				}

				/**
				 * Page Title
				 */
				$page_title_enable        = G5CORE()->options()->get_option( "{$current_post_type}__page_title_enable" );
				$page_title_layout        = G5CORE()->options()->get_option( "{$current_post_type}__page_title_layout" );
				$page_title_content_block = G5CORE()->options()->get_option( "{$current_post_type}__page_title_content_block" );
				$breadcrumb_enable        = G5CORE()->options()->get_option( "{$current_post_type}__breadcrumb_enable" );
				if ( ! empty( $page_title_enable ) ) {
					G5CORE()->options()->page_title()->set_option( 'page_title_enable', $page_title_enable );
				}

				if ( ! empty( $page_title_layout ) ) {
					G5CORE()->options()->page_title()->set_option( 'page_title_layout', $page_title_layout );
				}

				if ( ! empty( $page_title_content_block ) ) {
					G5CORE()->options()->page_title()->set_option( 'page_title_content_block', $page_title_content_block );
				}

				if ( ! empty( $breadcrumb_enable ) ) {
					G5CORE()->options()->page_title()->set_option( 'breadcrumb_enable', $breadcrumb_enable );
				}

				/**
				 * Layout
				 */

				$site_layout            = G5CORE()->options()->get_option( "{$current_post_type}__site_layout" );
				$sidebar                = G5CORE()->options()->get_option( "{$current_post_type}__sidebar" );
				$site_stretched_content = G5CORE()->options()->get_option( "{$current_post_type}__site_stretched_content" );
				$content_padding        = G5CORE()->options()->get_option( "{$current_post_type}__content_padding" );
				$mobile_content_padding        = G5CORE()->options()->get_option( "{$current_post_type}__mobile_content_padding" );
				$custom_css        = G5CORE()->options()->get_option( "{$current_post_type}__custom_css" );

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

				/**
				 * Footer
				 */
				$footer_enable        = G5CORE()->options()->get_option( "{$current_post_type}__footer_enable" );
				$footer_layout = G5CORE()->options()->get_option( "{$current_post_type}__footer_layout" );
				$footer_content_block = G5CORE()->options()->get_option( "{$current_post_type}__footer_content_block" );
				$footer_fixed_enable        = G5CORE()->options()->get_option( "{$current_post_type}__footer_fixed_enable" );

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
		}

        public function pre_get_posts($query)
        {
            if (!is_admin() && $query->is_main_query()) {
                if ($query->is_main_query() && !isset($_REQUEST['post_type'])) {
                    if (is_search()) {
                        $search_post_types = G5CORE()->options()->get_option('search_post_types');
                        if (is_array($search_post_types) && !in_array('all', $search_post_types)) {
                            $query->set('post_type', $search_post_types);
                        }
                    }
                }
            }
        }
	}
}