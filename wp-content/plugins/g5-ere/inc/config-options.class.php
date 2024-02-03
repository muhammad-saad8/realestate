<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if ( ! class_exists( 'G5ERE_Config_Options' ) ) {
	class G5ERE_Config_Options {
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
			add_filter( 'gsf_option_config', array( $this, 'define_options' ), 200 );
			add_filter( 'gsf_meta_box_config', array( $this, 'define_meta_box' ) );
			add_filter( 'g5core_admin_bar_theme_options', array( $this, 'admin_bar_theme_options' ), 200 );

			add_filter( 'g5core_header_options', array( $this, 'define_header_advanced_search_options' ) );

			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );

			add_action( 'template_redirect', array( $this, 'change_header_sticky_setting' ), 5 );

			add_filter( 'g5core_post_types_active', array( $this, 'add_post_type_agency' ) );

			add_filter( 'g5core_post_type_agent_archive_for_setting', array( $this, 'change_setting_agency' ) );
			add_filter( 'g5core_post_type_post_archive_for_setting', array( $this, 'change_setting_author' ) );
			add_filter( 'g5core_post_type__archive_for_setting', array( $this, 'change_setting_author' ) );
			add_filter( 'g5core_post_type_page_single_for_setting', array( $this, 'change_setting_agency_archive' ) );

			add_filter( 'g5core_default_options_' . G5Core_Config_Header_Options::getInstance()->options_name(), array(
				$this,
				'define_header_advanced_default_options'
			) );

			add_action( 'template_redirect', array( $this, 'change_single_property_setting' ) );

			add_filter('gid_options_key_change_theme_options',array($this,'change_options_key_change_theme_options'));

			add_filter('g5dev_option_key_for_setting_file',array($this,'change_option_key_for_setting_file'));

			add_filter('gsf_sorter_value',array($this,'change_search_fields_value'),10,2);

			add_filter('gsf_sorter_value',array($this,'update_search_fields_value_default'),9,2);

			add_filter('ere_register_options_config',array($this,'change_ere_options_enable_rtl_mode_config'));

			add_filter('ere_register_options_config',array($this,'change_ere_options_nearby_places_config'));

			add_filter('ere_register_options_config',array($this,'change_ere_options_ere_property_page_config'));


		}

		/**
		 * @param $field_value
		 * @param $field GSF_Field
		 *
		 * @return mixed
		 */
		public function change_search_fields_value($field_value,$field) {
			if ($field->getID() === 'search_forms_search_fields' ) {
				$additional_fields = ere_get_search_additional_fields();
				$search_fields = array();
				foreach ($additional_fields as $id => $title) {
					$is_exists = false;
					foreach ($field_value as $k => $v) {
						if (array_key_exists($id,$v)) {
							$is_exists = true;
							break;
						}
					}
					if ($is_exists === false) {
						$search_fields[$id] = $title;
					}
				}
				$field_value['disable'] = wp_parse_args($search_fields,$field_value['disable']);

				foreach ($field_value as $k => $v) {
					foreach ($v as $k1 => $v1) {
						if ((strpos($k1,'ere_additional_') === 0) && !array_key_exists($k1,$additional_fields)) {
							unset($field_value[$k][$k1]);
						}
					}
				}
			}
			return $field_value;
		}

		/**
		 * @param $field_value
		 * @param $field GSF_Field
		 *
		 * @return mixed
		 */
		public function update_search_fields_value_default($field_value,$field) {
			if ($field->getID() === 'search_forms_search_fields' ) {
				$additional_fields = array(
					'rooms' => esc_html__('Rooms', 'g5-ere'),
				);
				$search_fields = array();
				foreach ($additional_fields as $id => $title) {
					$is_exists = false;
					foreach ($field_value as $k => $v) {
						if (array_key_exists($id,$v)) {
							$is_exists = true;
							break;
						}
					}
					if ($is_exists === false) {
						$search_fields[$id] = $title;
					}
				}
				$field_value['disable'] = wp_parse_args($search_fields,$field_value['disable']);
			}
			return $field_value;
		}

		public function change_options_key_change_theme_options($option_keys) {
			$option_keys['g5ere_options'] = '=';
			$option_keys['ere_options'] = '=';
			return $option_keys;
		}

		public function change_option_key_for_setting_file($options_key) {
			return wp_parse_args(array(
				'g5ere_options' => '=',
				'ere_options' => '=',
			),$options_key);
		}

		public function enqueue_assets() {
			global $pagenow;
			if ( ( $pagenow === 'admin.php' ) && isset( $_GET['page'] ) && ( $_GET['page'] === 'g5ere_options' ) ) {
				wp_enqueue_script( G5ERE()->assets_handle( 'admin-options' ), G5ERE()->asset_url( 'assets/js/admin/options.min.js' ), array( 'jquery' ), G5ERE()->plugin_ver(), true );
			}
		}

		public function options_name() {
			return apply_filters( 'g5ere_options_name', 'g5ere_options' );
		}

		public function admin_bar_theme_options( $admin_bar_theme_options ) {
			$admin_bar_theme_options['g5ere_options'] = array(
				'title'      => esc_html__( 'ERE', 'g5-ere' ),
				'permission' => 'manage_options',
			);

			return $admin_bar_theme_options;
		}

		public function define_options( $configs ) {
			$configs['g5ere_options'] = array(
				'layout'      => 'inline',
				'page_title'  => esc_html__( 'ERE Options', 'g5-ere' ),
				'menu_title'  => esc_html__( 'ERE', 'g5-ere' ),
				'option_name' => $this->options_name(),
				'parent_slug' => 'g5core_options',
				'permission'  => 'manage_options',
				'section'     => array(
					$this->config_section_general(),
					$this->config_section_map_services(),
					$this->config_section_dashboard(),
					$this->config_section_search_form(),
					$this->config_section_property_archive(),
					$this->config_section_property_single(),
					$this->config_section_agent_archive(),
					$this->config_section_agent_single(),
					$this->config_section_agency_listing(),
					$this->config_section_agency_single(),
				)
			);

			return $configs;
		}


		public function define_meta_box( $configs ) {
			$prefix                                = G5ERE()->meta_prefix;
			$configs['g5ere_single_property_meta'] = array(
				'name'      => esc_html__( 'Property Settings', 'g5-ere' ),
				'post_type' => array( 'property' ),
				'layout'    => 'inline',
				'fields'    => array(
					array(
						'id'       => "{$prefix}single_property_layout",
						'title'    => esc_html__( 'Layout', 'g5-ere' ),
						'subtitle' => esc_html__( 'Specify your single property layout', 'g5-ere' ),
						'type'     => 'image_set',
						'options'  => G5ERE()->settings()->get_single_property_layout( true ),
						'default'  => '',
					),
					array(
						'id'       => "{$prefix}single_property_content_block_style",
						'title'    => esc_html__( 'Content Style', 'g5-ere' ),
						'subtitle' => esc_html__( 'Select the content style', 'g5-ere' ),
						'type'     => 'select',
						'options'  => G5ERE()->settings()->get_single_content_block_style( true ),
						'default'  => '',
					),
					G5CORE()->fields()->get_config_toggle( array(
						'id'       => "{$prefix}single_property_custom_gallery",
						'title'    => esc_html__( 'Custom gallery', 'g5-ere' ),
						'subtitle' => esc_html__( 'Turn Off this option if you want to hide custom gallery on single property', 'g5-ere' ),
						'default'  => G5ERE()->options()->get_option( "{$prefix}single_property_custom_gallery", '' )
					) ),
					array(
						'id'       => "{$prefix}single_property_gallery_group",
						'title'    => esc_html__( 'Gallery', 'g5-ere' ),
						'type'     => 'group',
						'required' => array(
							array( "{$prefix}single_property_layout", '!=', 'layout-10' ),
							array( "{$prefix}single_property_custom_gallery", '=', 'on' )
						),
						'fields'   => array(
							array(
								'id'       => "{$prefix}single_property_gallery_layout",
								'title'    => esc_html__( 'Layout', 'g5-ere' ),
								'subtitle' => esc_html__( 'Specify your single property gallery layout', 'g5-ere' ),
								'type'     => 'image_set',
								'options'  => G5ERE()->settings()->get_single_property_gallery_layout( true ),
								'default'  => '',
							),
							array(
								'id'       => "{$prefix}single_property_gallery_slider_group",
								'title'    => esc_html__( 'Slider Options', 'g5-ere' ),
								'type'     => 'group',
								'required' => array(
									"{$prefix}single_property_gallery_layout",
									'in',
									array( 'carousel', 'slider', 'thumbnail' )
								),
								'fields'   => array(
									array(
										'id'       => "{$prefix}single_property_gallery_slides_to_show_group",
										'title'    => esc_html__( 'Slides To Show', 'g5-ere' ),
										'type'     => 'group',
										'layout'   => 'full',
										'required' => array(
											"{$prefix}single_property_gallery_layout",
											'in',
											array( 'carousel' )
										),
										'fields'   => array(
											array(
												'id'         => "{$prefix}single_property_gallery_slides_to_show",
												'title'      => esc_html__( 'Slides To Show', 'g5-ere' ),
												'desc'       => esc_html__( 'Enter your slides to show', 'g5-ere' ),
												'type'       => 'text',
												'input_type' => 'number',
												'default'    => G5ERE()->options()->get_option( 'single_property_gallery_slides_to_show', 3 ),
												'layout'     => 'full',
											),
											array(
												'id'     => "{$prefix}single_property_gallery_slides_to_show_row",
												'type'   => 'row',
												'col'    => 3,
												'fields' => array(
													array(
														'id'         => "{$prefix}single_property_gallery_slides_to_show_lg",
														'title'      => esc_html__( 'Large Devices', 'g5-ere' ),
														'desc'       => esc_html__( 'Enter your slides to show on large devices (< 1200px). Empty to default', 'g5-ere' ),
														'type'       => 'text',
														'input_type' => 'number',
														'default'    => G5ERE()->options()->get_option( 'single_property_gallery_slides_to_show_lg', '' ),
														'layout'     => 'full',
													),
													array(
														'id'         => "{$prefix}single_property_gallery_slides_to_show_md",
														'title'      => esc_html__( 'Medium Devices', 'g5-ere' ),
														'desc'       => esc_html__( 'Enter your slides to show on medium devices (< 992px).  Empty to default', 'g5-ere' ),
														'type'       => 'text',
														'input_type' => 'number',
														'default'    => G5ERE()->options()->get_option( 'single_property_gallery_slides_to_show_md', '' ),
														'layout'     => 'full',
													),
													array(
														'id'         => "{$prefix}single_property_gallery_slides_to_show_sm",
														'title'      => esc_html__( 'Small Devices', 'g5-ere' ),
														'desc'       => esc_html__( 'Enter your slides to show on small devices (< 768px). Empty to default', 'g5-ere' ),
														'type'       => 'text',
														'input_type' => 'number',
														'default'    => G5ERE()->options()->get_option( 'single_property_gallery_slides_to_show_sm', '' ),
														'layout'     => 'full',
													),
													array(
														'id'         => "{$prefix}single_property_gallery_slides_to_show_xs",
														'title'      => esc_html__( 'Extra Small Devices', 'g5-ere' ),
														'desc'       => esc_html__( 'Enter your slides to show on extra small devices (< 576px). Empty to default', 'g5-ere' ),
														'type'       => 'text',
														'input_type' => 'number',
														'default'    => G5ERE()->options()->get_option( 'single_property_gallery_slides_to_show_xs', '' ),
														'layout'     => 'full',
													),
												)
											)
										)
									),
									array(
										'id'       => "{$prefix}single_property_gallery_image_size",
										'title'    => esc_html__( 'Image size', 'g5-ere' ),
										'subtitle' => esc_html__( 'Enter your image size', 'g5-ere' ),
										'desc'     => esc_html__( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'g5-ere' ),
										'type'     => 'text',
										'default'  => G5ERE()->options()->get_option( 'single_property_gallery_image_size', 'full' ),
									),
									array(
										'id'       => "{$prefix}single_property_gallery_image_ratio",
										'title'    => esc_html__( 'Image Ratio', 'g5-ere' ),
										'subtitle' => esc_html__( 'Enter image ratio', 'g5-ere' ),
										'type'     => 'dimension',
										'required' => array(
											"{$prefix}single_property_gallery_image_size",
											'=',
											'full'
										),
										'default'  => G5ERE()->options()->get_option( 'single_property_gallery_image_ratio', '' ),
									),
									G5CORE()->fields()->get_config_toggle( array(
										'id'       => "{$prefix}single_property_gallery_slider_pagination_enable",
										'title'    => esc_html__( 'Show Pagination', 'g5-ere' ),
										'subtitle' => esc_html__( 'Turn On this option if you want to show pagination', 'g5-ere' ),
										'default'  => G5ERE()->options()->get_option( 'single_property_gallery_slider_pagination_enable', 'on' )
									) ),
									G5CORE()->fields()->get_config_toggle( array(
										'id'       => "{$prefix}single_property_gallery_slider_navigation_enable",
										'title'    => esc_html__( 'Show Navigation', 'g5-ere' ),
										'subtitle' => esc_html__( 'Turn On this option if you want to show navigation', 'g5-ere' ),
										'default'  => G5ERE()->options()->get_option( 'single_property_gallery_slider_navigation_enable', '' )
									) ),
									G5CORE()->fields()->get_config_toggle( array(
										'id'       => "{$prefix}single_property_gallery_slider_autoplay_enable",
										'title'    => esc_html__( 'Autoplay Enable', 'g5-ere' ),
										'subtitle' => esc_html__( 'Turn On this option if you want to enable autoplay mode', 'g5-ere' ),
										'default'  => G5ERE()->options()->get_option( 'single_property_gallery_slider_autoplay_enable', '' )
									) ),
									array(
										'id'       => "{$prefix}single_property_gallery_slider_autoplay_timeout",
										'title'    => esc_html__( 'Autoplay Timeout', 'g5-ere' ),
										'subtitle' => esc_html__( 'Autoplay Speed in milliseconds. Default 3000', 'g5-ere' ),
										'type'     => 'text',
										'default'  => G5ERE()->options()->get_option( 'single_property_gallery_slider_autoplay_timeout', '' ),
										'required' => array(
											"{$prefix}single_property_gallery_slider_autoplay_enable",
											'=',
											'on'
										)

									),
									G5CORE()->fields()->get_config_toggle( array(
										'id'       => "{$prefix}single_property_gallery_slider_center_enable",
										'title'    => esc_html__( 'Center Mode', 'g5-ere' ),
										'subtitle' => esc_html__( 'Turn On this option if you want to enable center mode', 'g5-ere' ),
										'default'  => G5ERE()->options()->get_option( 'single_property_gallery_slider_center_enable', 'on' ),
										'required' => array(
											"{$prefix}single_property_gallery_layout",
											'in',
											array( 'carousel' )
										),

									) ),
									array(
										'id'       => "{$prefix}single_property_gallery_slider_center_padding",
										'title'    => esc_html__( 'Center Padding', 'g5-ere' ),
										'subtitle' => esc_html__( 'Side padding when in center mode (px or %). Default 50px', 'g5-ere' ),
										'type'     => 'text',
										'default'  => G5ERE()->options()->get_option( 'single_property_gallery_slider_center_padding', '' ),
										'required' => array(
											array(
												"{$prefix}single_property_gallery_layout",
												'in',
												array( 'carousel' )
											),
											array( "{$prefix}single_property_gallery_slider_center_enable", '=', 'on' )
										)

									),

								)
							),
							array(
								'id'       => "{$prefix}single_property_gallery_slider_thumb_group",
								'type'     => 'group',
								'title'    => esc_html__( 'Slider Thumb Options', 'g5-ere' ),
								'required' => array(
									"{$prefix}single_property_gallery_layout",
									'in',
									array( 'thumbnail' )
								),
								'fields'   => array(
									array(
										'id'       => "{$prefix}single_property_gallery_thumb_image_size",
										'title'    => esc_html__( 'Image size', 'g5-ere' ),
										'subtitle' => esc_html__( 'Enter your image size', 'g5-ere' ),
										'desc'     => esc_html__( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'g5-ere' ),
										'type'     => 'text',
										'default'  => G5ERE()->options()->get_option( 'single_property_gallery_thumb_image_size', 'thumbnail' ),
									),
									array(
										'id'     => "{$prefix}single_property_gallery_thumb_slides_to_show_group",
										'title'  => esc_html__( 'Slides To Show', 'g5-ere' ),
										'type'   => 'group',
										'layout' => 'full',
										'fields' => array(
											array(
												'id'         => "{$prefix}single_property_gallery_thumb_slides_to_show",
												'title'      => esc_html__( 'Slides To Show', 'g5-ere' ),
												'desc'       => esc_html__( 'Enter your slides to show', 'g5-ere' ),
												'type'       => 'text',
												'input_type' => 'number',
												'default'    => G5ERE()->options()->get_option( 'single_property_gallery_thumb_slides_to_show', 8 ),
												'layout'     => 'full',
											),
											array(
												'id'     => "{$prefix}single_property_gallery_thumb_slides_to_show_row",
												'type'   => 'row',
												'col'    => 3,
												'fields' => array(
													array(
														'id'         => "{$prefix}single_property_gallery_thumb_slides_to_show_lg",
														'title'      => esc_html__( 'Large Devices', 'g5-ere' ),
														'desc'       => esc_html__( 'Enter your slides to show on large devices (< 1200px). Empty to default', 'g5-ere' ),
														'type'       => 'text',
														'input_type' => 'number',
														'default'    => G5ERE()->options()->get_option( 'single_property_gallery_thumb_slides_to_show_lg', '' ),
														'layout'     => 'full',
													),
													array(
														'id'         => "{$prefix}single_property_gallery_thumb_slides_to_show_md",
														'title'      => esc_html__( 'Medium Devices', 'g5-ere' ),
														'desc'       => esc_html__( 'Enter your slides to show on medium devices (< 992px).  Empty to default', 'g5-ere' ),
														'type'       => 'text',
														'input_type' => 'number',
														'default'    => G5ERE()->options()->get_option( 'single_property_gallery_thumb_slides_to_show_md', '' ),
														'layout'     => 'full',
													),
													array(
														'id'         => "{$prefix}single_property_gallery_thumb_slides_to_show_sm",
														'title'      => esc_html__( 'Small Devices', 'g5-ere' ),
														'desc'       => esc_html__( 'Enter your slides to show on small devices (< 768px). Empty to default', 'g5-ere' ),
														'type'       => 'text',
														'input_type' => 'number',
														'default'    => G5ERE()->options()->get_option( 'single_property_gallery_thumb_slides_to_show_sm', '' ),
														'layout'     => 'full',
													),
													array(
														'id'         => "{$prefix}single_property_gallery_thumb_slides_to_show_xs",
														'title'      => esc_html__( 'Extra Small Devices', 'g5-ere' ),
														'desc'       => esc_html__( 'Enter your slides to show on extra small devices (< 576px). Empty to default', 'g5-ere' ),
														'type'       => 'text',
														'input_type' => 'number',
														'default'    => G5ERE()->options()->get_option( 'single_property_gallery_thumb_slides_to_show_xs', '' ),
														'layout'     => 'full',
													),
												)
											)
										)
									),
								)
							),

							array(
								'id'       => "{$prefix}single_property_gallery_metro_group",
								'type'     => 'group',
								'title'    => esc_html__( 'Metro Options', 'g5-ere' ),
								'required' => array(
									"{$prefix}single_property_gallery_layout",
									'in',
									array( 'metro-1', 'metro-2', 'metro-3', 'metro-4' )
								),
								'fields'   => array(
									array(
										'id'       => "{$prefix}single_property_gallery_metro_image_size",
										'title'    => esc_html__( 'Image size', 'g5-ere' ),
										'subtitle' => esc_html__( 'Enter your image size', 'g5-ere' ),
										'desc'     => esc_html__( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'g5-ere' ),
										'type'     => 'text',
										'default'  => G5ERE()->options()->get_option( 'single_property_gallery_metro_image_size', 'full' ),
									),
									array(
										'id'       => "{$prefix}single_property_gallery_metro_image_ratio",
										'title'    => esc_html__( 'Image Ratio', 'g5-ere' ),
										'subtitle' => esc_html__( 'Enter image ratio', 'g5-ere' ),
										'type'     => 'dimension',
										'default'  => G5ERE()->options()->get_option( 'single_property_gallery_metro_image_ratio', array(
											'width'  => 1,
											'height' => 1
										) ),
									),
								)
							),
							array(
								'id'       => "{$prefix}single_property_gallery_columns_gutter",
								'title'    => esc_html__( 'Columns Gutter', 'g5-ere' ),
								'subtitle' => esc_html__( 'Specify your horizontal space between gallery.', 'g5-ere' ),
								'type'     => 'select',
								'options'  => G5CORE()->settings()->get_post_columns_gutter(),
								'default'  => G5ERE()->options()->get_option( 'single_property_gallery_columns_gutter', '30' ),
								'required' => array(
									"{$prefix}single_property_gallery_layout",
									'not in',
									array( 'slider' )
								)
							),
							G5CORE()->fields()->get_config_toggle( array(
								'id'       => "{$prefix}single_property_gallery_map_enable",
								'title'    => esc_html__( 'Switch Map Enable', 'g5-ere' ),
								'subtitle' => esc_html__( 'Enable or disable switch map', 'g5-ere' ),
								'default'  => G5ERE()->options()->get_option( 'single_property_gallery_map_enable', 'on' ),
							) ),
							array(
								'id'       => "{$prefix}single_property_gallery_custom_class",
								'title'    => esc_html__( 'Css Classes', 'g5-ere' ),
								'subtitle' => esc_html__( 'Add custom css classes to gallery', 'g5-ere' ),
								'type'     => 'text',
								'default'  => G5ERE()->options()->get_option( 'single_property_gallery_custom_class', '' ),
							),
						)
					)
				)
			);

			return $configs;
		}

		public function config_section_property_archive() {
			return array(
				'id'     => 'section_property_archive',
				'title'  => esc_html__( 'Property Listing', 'g5-ere' ),
				'icon'   => 'dashicons dashicons-category',
				'fields' => array(
					'map_position'           => array(
						'id'      => 'map_position',
						'title'   => esc_html__( 'Map Position', 'g5-ere' ),
						'type'    => 'button_set',
						'options' => G5ERE()->settings()->get_map_position(),
						'default' => 'none'
					),
					'advanced_search_group'  => array(
						'id'     => 'advanced_search_group',
						'title'  => esc_html__( 'Advanced Search', 'g5-ere' ),
						'type'   => 'group',
						'fields' => array(
							'advanced_search_enable'      => G5CORE()->fields()->get_config_toggle( array(
								'id'       => 'advanced_search_enable',
								'title'    => esc_html__( 'Advanced Search Enable', 'g5-ere' ),
								'subtitle' => esc_html__( 'Enable or disable advanced search', 'g5-ere' ),
								'default'  => '',
							) ),
							'advanced_search_form'        => array(
								'id'       => 'advanced_search_form',
								'title'    => esc_html__( 'Advanced Search Form', 'g5-ere' ),
								'subtitle' => esc_html__( 'Specify your advanced search form', 'g5-ere' ),
								'desc'     => wp_kses_post( sprintf( __( 'Manager search form at <a href="%s">G5Ere Options</a>', 'g5-ere' ), admin_url( 'admin.php?page=g5ere_options&section=search_forms' ) ) ),
								'type'     => 'select',
								'options'  => G5ERE()->settings()->get_search_forms(),
								'default'  => '',
								'required' => array( 'advanced_search_enable', '=', 'on' )
							),
							'advanced_search_css_classes' => array(
								'id'       => 'advanced_search_css_classes',
								'type'     => 'text',
								'title'    => esc_html__( 'Css Classes', 'g5-ere' ),
								'subtitle' => esc_html__( 'Add custom css classes to the search form', 'g5-ere' ),
								'default'  => '',
								'required' => array( 'advanced_search_enable', '=', 'on' ),
							),
						)
					),
					'property_toolbar_group' => array(
						'id'     => 'property_toolbar_group',
						'title'  => esc_html__( 'Toolbar', 'g5-ere' ),
						'type'   => 'group',
						'fields' => array(
							'property_toolbar_layout' => array(
								'id'       => 'property_toolbar_layout',
								'title'    => esc_html__( 'ToolBar Layout', 'g5-ere' ),
								'subtitle' => esc_html__( 'Specify your tool bar layout', 'g5-ere' ),
								'type'     => 'select',
								'options'  => array(
									'boxed'             => esc_html__( 'Boxed Content', 'g5-ere' ),
									'stretched'         => esc_html__( 'Stretched row', 'g5-ere' ),
									'stretched_content' => esc_html__( 'Stretched row and content', 'g5-ere' ),
								),
								'default'  => G5ERE()->options()->get_default( 'property_toolbar_layout', 'boxed' ),
							),
							'property_toolbar'        => array(
								'id'      => 'property_toolbar',
								'title'   => esc_html__( 'ToolBar', 'g5-ere' ),
								'type'    => 'sorter',
								'default' => G5ERE()->options()->get_default( 'property_toolbar', array(
									'left'    => array(
										'result_count' => esc_html__( 'Result Count', 'g5-ere' )
									),
									'right'   => array(
										'save_search'   => esc_html__( 'Save search', 'g5-ere' ),
										'ordering'      => esc_html__( 'Ordering', 'g5-ere' ),
										'switch_layout' => esc_html__( 'Switch Layout', 'g5-ere' ),
									),
									'disable' => array(
										'taxonomy_filter' => esc_html__( 'Taxonomy Filter', 'g5-ere' ),
									)
								) ),
							),
							'property_toolbar_mobile' => array(
								'id'      => 'property_toolbar_mobile',
								'title'   => esc_html__( 'ToolBar Mobile', 'g5-ere' ),
								'type'    => 'sorter',
								'default' => G5ERE()->options()->get_default( 'property_toolbar_mobile', array(
									'left'    => array(
										'result_count' => esc_html__( 'Result Count', 'g5-ere' )
									),
									'right'   => array(
										'save_search' => esc_html__( 'Save search', 'g5-ere' ),
										'ordering'    => esc_html__( 'Ordering', 'g5-ere' ),
									),
									'disable' => array(
										'switch_layout' => esc_html__( 'Switch Layout', 'g5-ere' ),
									)
								) ),
							),
							'taxonomy_filter'         => array(
								'id'       => 'taxonomy_filter',
								'title'    => esc_html__( 'Taxonomy Filter', 'g5-ere' ),
								'type'     => 'select',
								'options'  => G5ERE()->settings()->get_property_taxonomy_filter(),
								'default'  => 'property-status',
								'required' => array(
									array(
										array( 'property_toolbar[left]', 'contain', 'taxonomy_filter' ),
										array( 'property_toolbar[right]', 'contain', 'taxonomy_filter' ),
										array( 'property_toolbar_mobile[left]', 'contain', 'taxonomy_filter' ),
										array( 'property_toolbar_mobile[right]', 'contain', 'taxonomy_filter' ),
									)
								)
							),
						)
					),
					'post_layout'            => array(
						'id'      => 'post_layout',
						'title'   => esc_html__( 'Property Layout', 'g5-ere' ),
						'type'    => 'image_set',
						'options' => G5ERE()->settings()->get_property_layout(),
						'default' => 'grid'
					),
					'layout_grid_group'      => array(
						'id'     => 'layout_grid_group',
						'title'  => esc_html__( 'Layout Grid', 'g5-ere' ),
						'type'   => 'group',
						'fields' => array(
							'item_skin'           => array(
								'id'       => 'item_skin',
								'title'    => esc_html__( 'Item Skin', 'g5-ere' ),
								'subtitle' => esc_html__( 'Specify your property item skin', 'g5-ere' ),
								'type'     => 'image_set',
								'options'  => G5ERE()->settings()->get_property_skins(),
								'default'  => G5ERE()->options()->get_default( 'item_skin', 'skin-01' ),
							),
							'item_custom_class'   => array(
								'id'       => 'item_custom_class',
								'title'    => esc_html__( 'Item Css Classes', 'g5-ere' ),
								'subtitle' => esc_html__( 'Add custom css classes to item', 'g5-ere' ),
								'type'     => 'text'
							),
							'post_columns_gutter' => array(
								'id'       => 'post_columns_gutter',
								'title'    => esc_html__( 'Columns Gutter', 'g5-ere' ),
								'subtitle' => esc_html__( 'Specify your horizontal space between property.', 'g5-ere' ),
								'type'     => 'select',
								'options'  => G5CORE()->settings()->get_post_columns_gutter(),
								'default'  => G5ERE()->options()->get_default( 'post_columns_gutter', '30' ),
							),
							'post_columns_group'  => array(
								'id'     => 'post_columns_group',
								'title'  => esc_html__( 'Property Columns', 'g5-ere' ),
								'type'   => 'group',
								'fields' => array(
									'post_columns_row_1' => array(
										'id'     => 'post_columns_row_1',
										'type'   => 'row',
										'col'    => 3,
										'fields' => array(
											'post_columns_xl' => array(
												'id'      => 'post_columns_xl',
												'title'   => esc_html__( 'Extra Large Devices', 'g5-ere' ),
												'desc'    => esc_html__( 'Specify your property columns on extra large devices (>= 1200px)', 'g5-ere' ),
												'type'    => 'select',
												'options' => G5CORE()->settings()->get_post_columns(),
												'default' => G5ERE()->options()->get_default( 'post_columns_xl', '3' ),
												'layout'  => 'full',
											),
											'post_columns_lg' => array(
												'id'      => 'post_columns_lg',
												'title'   => esc_html__( 'Large Devices', 'g5-ere' ),
												'desc'    => esc_html__( 'Specify your property columns on large devices (>= 992px)', 'g5-ere' ),
												'type'    => 'select',
												'options' => G5CORE()->settings()->get_post_columns(),
												'default' => G5ERE()->options()->get_default( 'post_columns_lg', '3' ),
												'layout'  => 'full',
											),
											'post_columns_md' => array(
												'id'      => 'post_columns_md',
												'title'   => esc_html__( 'Medium Devices', 'g5-ere' ),
												'desc'    => esc_html__( 'Specify your property columns on medium devices (>= 768px)', 'g5-ere' ),
												'type'    => 'select',
												'options' => G5CORE()->settings()->get_post_columns(),
												'default' => G5ERE()->options()->get_default( 'post_columns_md', '2' ),
												'layout'  => 'full',
											),
										)
									),
									'post_columns_row_2' => array(
										'id'     => 'post_columns_row_2',
										'type'   => 'row',
										'col'    => 3,
										'fields' => array(
											'post_columns_sm' => array(
												'id'      => 'post_columns_sm',
												'title'   => esc_html__( 'Small Devices', 'g5-ere' ),
												'desc'    => esc_html__( 'Specify your property columns on small devices (< 768px)', 'g5-ere' ),
												'type'    => 'select',
												'options' => G5CORE()->settings()->get_post_columns(),
												'default' => G5ERE()->options()->get_default( 'post_columns_sm', '2' ),
												'layout'  => 'full',
											),
											'post_columns'    => array(
												'id'      => 'post_columns',
												'title'   => esc_html__( 'Extra Small Devices', 'g5-ere' ),
												'desc'    => esc_html__( 'Specify your property columns on extra small devices (< 576px)', 'g5-ere' ),
												'type'    => 'select',
												'options' => G5CORE()->settings()->get_post_columns(),
												'default' => G5ERE()->options()->get_default( 'post_columns', '1' ),
												'layout'  => 'full',
											)
										)
									)
								)
							),
							'post_image_size'     => array(
								'id'       => 'post_image_size',
								'title'    => esc_html__( 'Image size', 'g5-ere' ),
								'subtitle' => esc_html__( 'Enter your property image size', 'g5-ere' ),
								'desc'     => esc_html__( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'g5-ere' ),
								'type'     => 'text',
								'default'  => G5ERE()->options()->get_default( 'post_image_size', 'full' ),
							),
							'post_image_ratio'    => array(
								'id'       => 'post_image_ratio',
								'title'    => esc_html__( 'Image Ratio', 'g5-ere' ),
								'subtitle' => esc_html__( 'Enter image ratio', 'g5-ere' ),
								'type'     => 'dimension',
								'required' => array(
									array( 'post_image_size', '=', 'full' ),
								)
							),
						)
					),
					'layout_list_group'      => array(
						'id'     => 'layout_list_group',
						'title'  => esc_html__( 'Layout List', 'g5-ere' ),
						'type'   => 'group',
						'fields' => array(
							'list_item_skin'         => array(
								'id'       => 'list_item_skin',
								'title'    => esc_html__( 'List Item Skin', 'g5-ere' ),
								'subtitle' => esc_html__( 'Specify your property list item skin', 'g5-ere' ),
								'type'     => 'image_set',
								'options'  => G5ERE()->settings()->get_property_list_skins(),
								'default'  => G5ERE()->options()->get_default( 'list_item_skin', 'skin-list-01' ),
							),
							'list_item_custom_class' => array(
								'id'       => 'list_item_custom_class',
								'title'    => esc_html__( 'List Item Css Classes', 'g5-ere' ),
								'subtitle' => esc_html__( 'Add custom css classes to item', 'g5-ere' ),
								'type'     => 'text',
							),
							'post_list_image_size'   => array(
								'id'       => 'post_list_image_size',
								'title'    => esc_html__( 'Image size', 'g5-ere' ),
								'subtitle' => esc_html__( 'Enter your property image size', 'g5-ere' ),
								'desc'     => esc_html__( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'g5-ere' ),
								'type'     => 'text',
								'default'  => G5ERE()->options()->get_default( 'post_list_image_size', 'full' ),
							),
							'post_list_image_ratio'  => array(
								'id'       => 'post_list_image_ratio',
								'title'    => esc_html__( 'Image Ratio', 'g5-ere' ),
								'subtitle' => esc_html__( 'Enter image ratio', 'g5-ere' ),
								'type'     => 'dimension',
								'required' => array(
									array( 'post_list_image_size', '=', 'full' ),
								)
							),
						)
					),
					'property_per_page'      => array(
						'id'         => 'property_per_page',
						'type'       => 'text',
						'input_type' => 'number',
						'title'      => esc_html__( 'Property per page', 'g5-ere' ),
						'subtitle'   => esc_html__( 'Set number of property per page', 'g5-ere' ),
						'default'    => '10',
					),
					'property_sorting'       => array(
						'id'      => 'property_sorting',
						'title'   => esc_html__( 'Default property sorting', 'g5-ere' ),
						'type'    => 'select',
						'options' => G5ERE()->settings()->get_property_sorting(),
						'default' => 'menu_order'
					),
					'post_paging'            => array(
						'id'       => 'post_paging',
						'title'    => esc_html__( 'Paging', 'g5-ere' ),
						'subtitle' => esc_html__( 'Specify your paging mode', 'g5-ere' ),
						'type'     => 'select',
						'options'  => G5CORE()->settings()->get_post_paging_mode(),
						'default'  => G5ERE()->options()->get_default( 'post_paging', 'pagination' ),
					),
					'post_animation'         => array(
						'id'       => 'post_animation',
						'title'    => esc_html__( 'Animation', 'g5-ere' ),
						'subtitle' => esc_html__( 'Specify your post animation', 'g5-ere' ),
						'type'     => 'select',
						'options'  => G5CORE()->settings()->get_animation(),
						'default'  => G5ERE()->options()->get_default( 'post_animation', 'none' )
					),

				)
			);
		}

		public function config_section_property_single() {
			return array(
				'id'     => 'section_property_single',
				'title'  => esc_html__( 'Single Property', 'g5-ere' ),
				'icon'   => 'dashicons dashicons-building',
				'fields' => array(
					'single_property_layout'            => array(
						'id'       => 'single_property_layout',
						'title'    => esc_html__( 'Layout', 'g5-ere' ),
						'subtitle' => esc_html__( 'Specify your single property layout', 'g5-ere' ),
						'type'     => 'image_set',
						'options'  => G5ERE()->settings()->get_single_property_layout(),
						'default'  => G5ERE()->options()->get_default( 'single_property_layout', 'layout-1' ),
					),
					'single_property_map_enable'        => G5CORE()->fields()->get_config_toggle( array(
						'id'       => 'single_property_map_enable',
						'title'    => esc_html__( 'Show Full Map', 'g5-ere' ),
						'subtitle' => esc_html__( 'Turn On this option if you want to display map on single property', 'g5-ere' ),
						'default'  => G5ERE()->options()->get_default( 'single_property_map_enable', '' ),
						'required' => array( 'single_property_layout', 'in', array( 'layout-6', 'layout-7' ) )
					) ),
					'single_property_gallery_group'     => $this->config_group_property_single_gallery(),
					'single_property_content_group'     => $this->config_group_property_single_content(),
					'single_property_view_enable'       => G5CORE()->fields()->get_config_toggle( array(
						'id'       => 'single_property_view_enable',
						'title'    => esc_html__( 'Show View Count', 'g5-ere' ),
						'subtitle' => esc_html__( 'Turn Off this option if you want to hide view count on single property', 'g5-ere' ),
						'default'  => G5ERE()->options()->get_default( 'single_property_view_enable', 'on' )
					) ),
					'single_property_date_enable'       => G5CORE()->fields()->get_config_toggle( array(
						'id'       => 'single_property_date_enable',
						'title'    => esc_html__( 'Show Date', 'g5-ere' ),
						'subtitle' => esc_html__( 'Turn Off this option if you want to hide date on single property', 'g5-ere' ),
						'default'  => G5ERE()->options()->get_default( 'single_property_date_enable', 'on' )
					) ),
					'single_property_share_enable'      => G5CORE()->fields()->get_config_toggle( array(
						'id'       => 'single_property_share_enable',
						'title'    => esc_html__( 'Share', 'g5-ere' ),
						'subtitle' => esc_html__( 'Turn Off this option if you want to hide share on single property', 'g5-ere' ),
						'default'  => G5ERE()->options()->get_default( 'single_property_share_enable', 'on' )
					) ),
					'single_property_print_enable'      => G5CORE()->fields()->get_config_toggle( array(
						'id'       => 'single_property_print_enable',
						'title'    => esc_html__( 'Print', 'g5-ere' ),
						'subtitle' => esc_html__( 'Turn Off this option if you want to hide print on single property', 'g5-ere' ),
						'default'  => G5ERE()->options()->get_default( 'single_property_print_enable', 'on' )
					) ),
					'single_property_bottom_bar_mobile' => G5CORE()->fields()->get_config_toggle( array(
						'id'       => 'single_property_bottom_bar_mobile',
						'title'    => esc_html__( 'Bottom Bar Mobile', 'g5-ere' ),
						'subtitle' => esc_html__( 'Turn On bottom bar', 'g5-ere' ),
						'default'  => G5CORE()->options()->layout()->get_default( 'single_property_bottom_bar_mobile', 'on' ),
					) ),
					'single_property_breadcrumb_enable'        => G5CORE()->fields()->get_config_toggle( array(
						'id'       => 'single_property_breadcrumb_enable',
						'title'    => esc_html__( 'Breadcrumb Enable', 'g5-ere' ),
						'subtitle' => esc_html__( 'Turn Off this option if you want to hide breadcrumb (only show when page title hide)', 'g5-ere' ),
						'default'  => 'on',
						'required' => array( 'single_property_layout', 'not in', array( 'layout-10') )
					) ),
					'single_property_feature_link_disable'        => G5CORE()->fields()->get_config_toggle( array(
						'id'       => 'single_property_feature_link_disable',
						'title'    => esc_html__( 'Property Feature Link Disable', 'g5-ere' ),
						'subtitle' => esc_html__( 'Turn On this option if you want to disable property feature link', 'g5-ere' ),
						'default'  => '',
					) ),
				)
			);
		}

		public function config_group_property_single_gallery() {
			return array(
				'id'       => 'single_property_gallery_group',
				'title'    => esc_html__( 'Gallery', 'g5-ere' ),
				'type'     => 'group',
				'required' => array( 'single_property_layout', '!=', 'layout-10' ),
				'fields'   => array(
					'single_property_gallery_layout'             => array(
						'id'       => 'single_property_gallery_layout',
						'title'    => esc_html__( 'Layout', 'g5-ere' ),
						'subtitle' => esc_html__( 'Specify your single property gallery layout', 'g5-ere' ),
						'type'     => 'image_set',
						'options'  => G5ERE()->settings()->get_single_property_gallery_layout(),
						'default'  => G5ERE()->options()->get_default( 'single_property_gallery_layout', 'slider' ),
					),
					'single_property_gallery_slider_group'       => array(
						'id'       => 'single_property_gallery_slider_group',
						'title'    => esc_html__( 'Slider Options', 'g5-ere' ),
						'type'     => 'group',
						'required' => array('single_property_gallery_layout','in',array( 'carousel', 'slider', 'thumbnail' )),
						'fields'   => array(
							'single_property_gallery_slides_to_show_group'     => array(
								'id'       => 'single_property_gallery_slides_to_show_group',
								'title'    => esc_html__( 'Slides To Show', 'g5-ere' ),
								'type'     => 'group',
								'layout'   => 'full',
								'required' => array( 'single_property_gallery_layout', 'in', array( 'carousel' ) ),
								'fields'   => array(
									'single_property_gallery_slides_to_show'     => array(
										'id'         => 'single_property_gallery_slides_to_show',
										'title'      => esc_html__( 'Slides To Show', 'g5-ere' ),
										'desc'       => esc_html__( 'Enter your slides to show', 'g5-ere' ),
										'type'       => 'text',
										'input_type' => 'number',
										'default'    => G5ERE()->options()->get_default( 'single_property_gallery_slides_to_show', 3 ),
										'layout'     => 'full',
									),
									'single_property_gallery_slides_to_show_row' => array(
										'id'     => 'single_property_gallery_slides_to_show_row',
										'type'   => 'row',
										'col'    => 3,
										'fields' => array(
											'single_property_gallery_slides_to_show_lg' => array(
												'id'         => 'single_property_gallery_slides_to_show_lg',
												'title'      => esc_html__( 'Large Devices', 'g5-ere' ),
												'desc'       => esc_html__( 'Enter your slides to show on large devices (< 1200px). Empty to default', 'g5-ere' ),
												'type'       => 'text',
												'input_type' => 'number',
												'default'    => G5ERE()->options()->get_default( 'single_property_gallery_slides_to_show_lg', '' ),
												'layout'     => 'full',
											),
											'single_property_gallery_slides_to_show_md' => array(
												'id'         => 'single_property_gallery_slides_to_show_md',
												'title'      => esc_html__( 'Medium Devices', 'g5-ere' ),
												'desc'       => esc_html__( 'Enter your slides to show on medium devices (< 992px).  Empty to default', 'g5-ere' ),
												'type'       => 'text',
												'input_type' => 'number',
												'default'    => G5ERE()->options()->get_default( 'single_property_gallery_slides_to_show_md', '' ),
												'layout'     => 'full',
											),
											'single_property_gallery_slides_to_show_sm' => array(
												'id'         => 'single_property_gallery_slides_to_show_sm',
												'title'      => esc_html__( 'Small Devices', 'g5-ere' ),
												'desc'       => esc_html__( 'Enter your slides to show on small devices (< 768px). Empty to default', 'g5-ere' ),
												'type'       => 'text',
												'input_type' => 'number',
												'default'    => G5ERE()->options()->get_default( 'single_property_gallery_slides_to_show_sm', '' ),
												'layout'     => 'full',
											),
											'single_property_gallery_slides_to_show_xs' => array(
												'id'         => 'single_property_gallery_slides_to_show_xs',
												'title'      => esc_html__( 'Extra Small Devices', 'g5-ere' ),
												'desc'       => esc_html__( 'Enter your slides to show on extra small devices (< 576px). Empty to default', 'g5-ere' ),
												'type'       => 'text',
												'input_type' => 'number',
												'default'    => G5ERE()->options()->get_default( 'single_property_gallery_slides_to_show_xs', '' ),
												'layout'     => 'full',
											),
										)
									)
								)
							),
							'single_property_gallery_image_size'               => array(
								'id'       => 'single_property_gallery_image_size',
								'title'    => esc_html__( 'Image size', 'g5-ere' ),
								'subtitle' => esc_html__( 'Enter your image size', 'g5-ere' ),
								'desc'     => esc_html__( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'g5-ere' ),
								'type'     => 'text',
								'default'  => G5ERE()->options()->get_default( 'single_property_gallery_image_size', 'full' ),
							),
							'single_property_gallery_image_ratio'              => array(
								'id'       => 'single_property_gallery_image_ratio',
								'title'    => esc_html__( 'Image Ratio', 'g5-ere' ),
								'subtitle' => esc_html__( 'Enter image ratio', 'g5-ere' ),
								'type'     => 'dimension',
								'required' => array( 'single_property_gallery_image_size', '=', 'full' ),
							),
							'single_property_gallery_slider_pagination_enable' => G5CORE()->fields()->get_config_toggle( array(
								'id'       => 'single_property_gallery_slider_pagination_enable',
								'title'    => esc_html__( 'Show Pagination', 'g5-ere' ),
								'subtitle' => esc_html__( 'Turn On this option if you want to show pagination', 'g5-ere' ),
								'default'  => G5ERE()->options()->get_default( 'single_property_gallery_slider_pagination_enable', 'on' )
							) ),
							'single_property_gallery_slider_navigation_enable' => G5CORE()->fields()->get_config_toggle( array(
								'id'       => 'single_property_gallery_slider_navigation_enable',
								'title'    => esc_html__( 'Show Navigation', 'g5-ere' ),
								'subtitle' => esc_html__( 'Turn On this option if you want to show navigation', 'g5-ere' ),
								'default'  => G5ERE()->options()->get_default( 'single_property_gallery_slider_navigation_enable', '' )
							) ),
							'single_property_gallery_slider_autoplay_enable'   => G5CORE()->fields()->get_config_toggle( array(
								'id'       => 'single_property_gallery_slider_autoplay_enable',
								'title'    => esc_html__( 'Autoplay Enable', 'g5-ere' ),
								'subtitle' => esc_html__( 'Turn On this option if you want to enable autoplay mode', 'g5-ere' ),
								'default'  => G5ERE()->options()->get_default( 'single_property_gallery_slider_autoplay_enable', '' )
							) ),
							'single_property_gallery_slider_autoplay_timeout'  => array(
								'id'       => 'single_property_gallery_slider_autoplay_timeout',
								'title'    => esc_html__( 'Autoplay Timeout', 'g5-ere' ),
								'subtitle' => esc_html__( 'Autoplay Speed in milliseconds. Default 3000', 'g5-ere' ),
								'type'     => 'text',
								'default'  => G5ERE()->options()->get_default( 'single_property_gallery_slider_autoplay_timeout', '' ),
								'required' => array( 'single_property_gallery_slider_autoplay_enable', '=', 'on' )

							),
							'single_property_gallery_slider_center_enable'     => G5CORE()->fields()->get_config_toggle( array(
								'id'       => 'single_property_gallery_slider_center_enable',
								'title'    => esc_html__( 'Center Mode', 'g5-ere' ),
								'subtitle' => esc_html__( 'Turn On this option if you want to enable center mode', 'g5-ere' ),
								'default'  => G5ERE()->options()->get_default( 'single_property_gallery_slider_center_enable', 'on' ),
								'required' => array( 'single_property_gallery_layout', 'in', array( 'carousel' ) ),

							) ),
							'single_property_gallery_slider_center_padding'    => array(
								'id'       => 'single_property_gallery_slider_center_padding',
								'title'    => esc_html__( 'Center Padding', 'g5-ere' ),
								'subtitle' => esc_html__( 'Side padding when in center mode (px or %). Default 50px', 'g5-ere' ),
								'type'     => 'text',
								'default'  => G5ERE()->options()->get_default( 'single_property_gallery_slider_center_padding', '' ),
								'required' => array(
									array( 'single_property_gallery_layout', 'in', array( 'carousel' ) ),
									array( 'single_property_gallery_slider_center_enable', '=', 'on' )
								)

							),

						)
					),
					'single_property_gallery_slider_thumb_group' => array(
						'id'       => 'single_property_gallery_slider_thumb_group',
						'type'     => 'group',
						'title'    => esc_html__( 'Slider Thumb Options', 'g5-ere' ),
						'required' => array( 'single_property_gallery_layout', 'in', array( 'thumbnail' ) ),
						'fields'   => array(
							'single_property_gallery_thumb_image_size'           => array(
								'id'       => 'single_property_gallery_thumb_image_size',
								'title'    => esc_html__( 'Image size', 'g5-ere' ),
								'subtitle' => esc_html__( 'Enter your image size', 'g5-ere' ),
								'desc'     => esc_html__( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'g5-ere' ),
								'type'     => 'text',
								'default'  => G5ERE()->options()->get_default( 'single_property_gallery_thumb_image_size', 'thumbnail' ),
							),
							'single_property_gallery_thumb_slides_to_show_group' => array(
								'id'     => 'single_property_gallery_thumb_slides_to_show_group',
								'title'  => esc_html__( 'Slides To Show', 'g5-ere' ),
								'type'   => 'group',
								'layout' => 'full',
								'fields' => array(
									'single_property_gallery_thumb_slides_to_show'     => array(
										'id'         => 'single_property_gallery_thumb_slides_to_show',
										'title'      => esc_html__( 'Slides To Show', 'g5-ere' ),
										'desc'       => esc_html__( 'Enter your slides to show', 'g5-ere' ),
										'type'       => 'text',
										'input_type' => 'number',
										'default'    => G5ERE()->options()->get_default( 'single_property_gallery_thumb_slides_to_show', 8 ),
										'layout'     => 'full',
									),
									'single_property_gallery_thumb_slides_to_show_row' => array(
										'id'     => 'single_property_gallery_thumb_slides_to_show_row',
										'type'   => 'row',
										'col'    => 3,
										'fields' => array(
											'single_property_gallery_thumb_slides_to_show_lg' => array(
												'id'         => 'single_property_gallery_thumb_slides_to_show_lg',
												'title'      => esc_html__( 'Large Devices', 'g5-ere' ),
												'desc'       => esc_html__( 'Enter your slides to show on large devices (< 1200px). Empty to default', 'g5-ere' ),
												'type'       => 'text',
												'input_type' => 'number',
												'default'    => G5ERE()->options()->get_default( 'single_property_gallery_thumb_slides_to_show_lg', '' ),
												'layout'     => 'full',
											),
											'single_property_gallery_thumb_slides_to_show_md' => array(
												'id'         => 'single_property_gallery_thumb_slides_to_show_md',
												'title'      => esc_html__( 'Medium Devices', 'g5-ere' ),
												'desc'       => esc_html__( 'Enter your slides to show on medium devices (< 992px).  Empty to default', 'g5-ere' ),
												'type'       => 'text',
												'input_type' => 'number',
												'default'    => G5ERE()->options()->get_default( 'single_property_gallery_thumb_slides_to_show_md', '' ),
												'layout'     => 'full',
											),
											'single_property_gallery_thumb_slides_to_show_sm' => array(
												'id'         => 'single_property_gallery_thumb_slides_to_show_sm',
												'title'      => esc_html__( 'Small Devices', 'g5-ere' ),
												'desc'       => esc_html__( 'Enter your slides to show on small devices (< 768px). Empty to default', 'g5-ere' ),
												'type'       => 'text',
												'input_type' => 'number',
												'default'    => G5ERE()->options()->get_default( 'single_property_gallery_thumb_slides_to_show_sm', '' ),
												'layout'     => 'full',
											),
											'single_property_gallery_thumb_slides_to_show_xs' => array(
												'id'         => 'single_property_gallery_thumb_slides_to_show_xs',
												'title'      => esc_html__( 'Extra Small Devices', 'g5-ere' ),
												'desc'       => esc_html__( 'Enter your slides to show on extra small devices (< 576px). Empty to default', 'g5-ere' ),
												'type'       => 'text',
												'input_type' => 'number',
												'default'    => G5ERE()->options()->get_default( 'single_property_gallery_thumb_slides_to_show_xs', '' ),
												'layout'     => 'full',
											),
										)
									)
								)
							),
						)
					),

					'single_property_gallery_metro_group' => array(
						'id'       => 'single_property_gallery_metro_group',
						'type'     => 'group',
						'title'    => esc_html__( 'Metro Options', 'g5-ere' ),
						'required' => array(
							'single_property_gallery_layout',
							'in',
							array( 'metro-1', 'metro-2', 'metro-3', 'metro-4' )
						),
						'fields'   => array(
							'single_property_gallery_metro_image_size'  => array(
								'id'       => 'single_property_gallery_metro_image_size',
								'title'    => esc_html__( 'Image size', 'g5-ere' ),
								'subtitle' => esc_html__( 'Enter your image size', 'g5-ere' ),
								'desc'     => esc_html__( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'g5-ere' ),
								'type'     => 'text',
								'default'  => G5ERE()->options()->get_default( 'single_property_gallery_metro_image_size', 'full' ),
							),
							'single_property_gallery_metro_image_ratio' => array(
								'id'       => 'single_property_gallery_metro_image_ratio',
								'title'    => esc_html__( 'Image Ratio', 'g5-ere' ),
								'subtitle' => esc_html__( 'Enter image ratio', 'g5-ere' ),
								'type'     => 'dimension',
								'default'  => G5ERE()->options()->get_default( 'single_property_gallery_metro_image_ratio', array(
									'width'  => 1,
									'height' => 1
								) ),
							),
						)
					),


					'single_property_gallery_columns_gutter' => array(
						'id'       => 'single_property_gallery_columns_gutter',
						'title'    => esc_html__( 'Columns Gutter', 'g5-ere' ),
						'subtitle' => esc_html__( 'Specify your horizontal space between gallery.', 'g5-ere' ),
						'type'     => 'select',
						'options'  => G5CORE()->settings()->get_post_columns_gutter(),
						'default'  => G5ERE()->options()->get_default( 'single_property_gallery_columns_gutter', '30' ),
						'required' => array(
							'single_property_gallery_layout',
							'not in',
							array( 'slider' )
						)
					),
					'single_property_gallery_map_enable'     => G5CORE()->fields()->get_config_toggle( array(
						'id'       => 'single_property_gallery_map_enable',
						'title'    => esc_html__( 'Switch Map Enable', 'g5-ere' ),
						'subtitle' => esc_html__( 'Enable or disable switch map', 'g5-ere' ),
						'default'  => 'on',
					) ),
					'single_property_gallery_custom_class'   => array(
						'id'       => 'single_property_gallery_custom_class',
						'title'    => esc_html__( 'Css Classes', 'g5-ere' ),
						'subtitle' => esc_html__( 'Add custom css classes to gallery', 'g5-ere' ),
						'type'     => 'text'
					),
				)
			);
		}

		public function config_group_property_single_content() {
			return array(
				'id'       => 'single_property_content_group',
				'title'    => esc_html__( 'Property Content', 'g5-ere' ),
				'type'     => 'group',
				'required' => array( 'single_property_layout', '!=', 'layout-10' ),
				'fields'   => array(
					'single_property_content_block_style'        => array(
						'id'       => 'single_property_content_block_style',
						'title'    => esc_html__( 'Content Style', 'g5-ere' ),
						'subtitle' => esc_html__( 'Select the content style', 'g5-ere' ),
						'type'     => 'select',
						'options'  => G5ERE()->settings()->get_single_content_block_style(),
						'default'  => G5ERE()->options()->get_default( 'single_property_content_block_style', 'style-01' ),
					),
					'single_property_content_blocks_row'         => array(
						'id'       => 'single_property_content_blocks_row',
						'title'    => esc_html__( 'Content blocks', 'g5-ere' ),
						'type'     => 'row',
						'col'      => 6,
						'fields'   => array(
							'single_property_content_blocks'      => array(
								'id'      => 'single_property_content_blocks',
								'title'   => esc_html__( 'Content Blocks', 'g5-ere' ),
								'subtitle' => esc_html__('For single property layout 01, 02, 06, 07, the description block always appears after the title','g5-ere'),
								'type'    => 'sorter',
								'default' => G5ERE()->settings()->get_single_property_content_blocks(),
							),
							'single_property_tabs_content_blocks' => array(
								'id'       => 'single_property_tabs_content_blocks',
								'title'    => esc_html__( 'Tabs Content Blocks', 'g5-ere' ),
								'type'     => 'sorter',
								'required' => array( 'single_property_content_blocks[enable]', 'contain', 'tabs' ),
								'default'  => G5ERE()->settings()->get_single_property_tabs_content_blocks(),
							),
						)
					),
					'single_property_similar_property_group'     => $this->config_group_single_property_similar_property(),
					'single_property_contact_agent_group'     => $this->config_group_single_property_contact_agent(),
				)
			);
		}

		public function config_group_single_property_similar_property() {
			return array(
				'id'     => 'single_property_similar_property_group',
				'title'  => esc_html__( 'Similar Properties', 'g5-ere' ),
				'type'   => 'group',
				'toggle_default' =>  false,
				'fields' => array(
					'similar_properties_type'             => array(
						'id'           => 'similar_properties_type',
						'type'         => 'checkbox_list',
						'title'        => esc_html__( 'Similar Type', 'g5-ere' ),
						'subtitle'     => esc_html__( 'Select type for similar properties', 'g5-ere' ),
						'options'      => array(
							'property-status'       => esc_html__( 'Status', 'g5-ere' ),
							'property-type'         => esc_html__( 'Type', 'g5-ere' ),
							'property-city'         => esc_html__( 'City / Town', 'g5-ere' ),
							'property-neighborhood' => esc_html__( 'Neighborhood', 'g5-ere' ),
							'property-label'        => esc_html__( 'Label', 'g5-ere' ),
						),
						'value_inline' => false,
						'default'      => array(
							'property-status',
							'property-type'
						),
					),
					'similar_properties_taxonomy_filter_enable' => G5CORE()->fields()->get_config_toggle( array(
						'id'       => 'similar_properties_taxonomy_filter_enable',
						'title'    => esc_html__( 'Taxonomy Filter Enable', 'g5-ere' ),
						'subtitle' => esc_html__( 'Turn On this option if you want to enable taxonomy filter', 'g5-ere' ),
						'default'  => G5ERE()->options()->get_default( 'similar_properties_taxonomy_filter_enable', '' ),
					) ),
					'similar_properties_taxonomy_filter'        => array(
						'id'       => 'similar_properties_taxonomy_filter',
						'title'    => esc_html__( 'Taxonomy Filter', 'g5-ere' ),
						'type'     => 'select',
						'options'  => G5ERE()->settings()->get_property_taxonomy_filter(),
						'default'  => 'property-status',
						'required' => array( 'similar_properties_taxonomy_filter_enable', '=', 'on' )
					),
					'similar_properties_post_layout'            => array(
						'id'      => 'similar_properties_post_layout',
						'title'   => esc_html__( 'Property Layout', 'g5-ere' ),
						'type'    => 'image_set',
						'options' => G5ERE()->settings()->get_property_layout(),
						'default' => 'grid'
					),
					'similar_properties_layout_grid_group'      => array(
						'id'       => 'similar_properties_layout_grid_group',
						'title'    => esc_html__( 'Layout Grid', 'g5-ere' ),
						'type'     => 'group',
						'required' => array( 'similar_properties_post_layout', '=', 'grid' ),
						'fields'   => array(
							'similar_properties_item_skin'           => array(
								'id'       => 'similar_properties_item_skin',
								'title'    => esc_html__( 'Item Skin', 'g5-ere' ),
								'subtitle' => esc_html__( 'Specify your property item skin', 'g5-ere' ),
								'type'     => 'image_set',
								'options'  => G5ERE()->settings()->get_property_skins(),
								'default'  => G5ERE()->options()->get_default( 'similar_properties_item_skin', 'skin-01' ),
							),
							'similar_properties_item_custom_class'   => array(
								'id'       => 'similar_properties_item_custom_class',
								'title'    => esc_html__( 'Item Css Classes', 'g5-ere' ),
								'subtitle' => esc_html__( 'Add custom css classes to item', 'g5-ere' ),
								'type'     => 'text'
							),
							'similar_properties_post_columns_gutter' => array(
								'id'       => 'similar_properties_post_columns_gutter',
								'title'    => esc_html__( 'Columns Gutter', 'g5-ere' ),
								'subtitle' => esc_html__( 'Specify your horizontal space between property.', 'g5-ere' ),
								'type'     => 'select',
								'options'  => G5CORE()->settings()->get_post_columns_gutter(),
								'default'  => G5ERE()->options()->get_default( 'similar_properties_post_columns_gutter', '30' ),
							),
							'similar_properties_post_columns_group'  => array(
								'id'     => 'similar_properties_post_columns_group',
								'title'  => esc_html__( 'Property Columns', 'g5-ere' ),
								'type'   => 'group',
								'fields' => array(
									'similar_properties_post_columns_row_1' => array(
										'id'     => 'similar_properties_post_columns_row_1',
										'type'   => 'row',
										'col'    => 3,
										'fields' => array(
											'similar_properties_post_columns_xl' => array(
												'id'      => 'similar_properties_post_columns_xl',
												'title'   => esc_html__( 'Extra Large Devices', 'g5-ere' ),
												'desc'    => esc_html__( 'Specify your property columns on extra large devices (>= 1200px)', 'g5-ere' ),
												'type'    => 'select',
												'options' => G5CORE()->settings()->get_post_columns(),
												'default' => G5ERE()->options()->get_default( 'similar_properties_post_columns_xl', '2' ),
												'layout'  => 'full',
											),
											'similar_properties_post_columns_lg' => array(
												'id'      => 'similar_properties_post_columns_lg',
												'title'   => esc_html__( 'Large Devices', 'g5-ere' ),
												'desc'    => esc_html__( 'Specify your property columns on large devices (>= 992px)', 'g5-ere' ),
												'type'    => 'select',
												'options' => G5CORE()->settings()->get_post_columns(),
												'default' => G5ERE()->options()->get_default( 'similar_properties_post_columns_lg', '2' ),
												'layout'  => 'full',
											),
											'similar_properties_post_columns_md' => array(
												'id'      => 'similar_properties_post_columns_md',
												'title'   => esc_html__( 'Medium Devices', 'g5-ere' ),
												'desc'    => esc_html__( 'Specify your property columns on medium devices (>= 768px)', 'g5-ere' ),
												'type'    => 'select',
												'options' => G5CORE()->settings()->get_post_columns(),
												'default' => G5ERE()->options()->get_default( 'similar_properties_post_columns_md', '1' ),
												'layout'  => 'full',
											),
										)
									),
									'similar_properties_post_columns_row_2' => array(
										'id'     => 'similar_properties_post_columns_row_2',
										'type'   => 'row',
										'col'    => 3,
										'fields' => array(
											'similar_properties_post_columns_sm' => array(
												'id'      => 'similar_properties_post_columns_sm',
												'title'   => esc_html__( 'Small Devices', 'g5-ere' ),
												'desc'    => esc_html__( 'Specify your property columns on small devices (< 768px)', 'g5-ere' ),
												'type'    => 'select',
												'options' => G5CORE()->settings()->get_post_columns(),
												'default' => G5ERE()->options()->get_default( 'similar_properties_post_columns_sm', '1' ),
												'layout'  => 'full',
											),
											'similar_properties_post_columns'    => array(
												'id'      => 'similar_properties_post_columns',
												'title'   => esc_html__( 'Extra Small Devices', 'g5-ere' ),
												'desc'    => esc_html__( 'Specify your property columns on extra small devices (< 576px)', 'g5-ere' ),
												'type'    => 'select',
												'options' => G5CORE()->settings()->get_post_columns(),
												'default' => G5ERE()->options()->get_default( 'similar_properties_post_columns', '1' ),
												'layout'  => 'full',
											)
										)
									)
								)
							),
							'similar_properties_post_image_size'     => array(
								'id'       => 'similar_properties_post_image_size',
								'title'    => esc_html__( 'Image size', 'g5-ere' ),
								'subtitle' => esc_html__( 'Enter your property image size', 'g5-ere' ),
								'desc'     => esc_html__( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'g5-ere' ),
								'type'     => 'text',
								'default'  => G5ERE()->options()->get_default( 'similar_properties_post_image_size', 'full' ),
							),
							'similar_properties_post_image_ratio'    => array(
								'id'       => 'similar_properties_post_image_ratio',
								'title'    => esc_html__( 'Image Ratio', 'g5-ere' ),
								'subtitle' => esc_html__( 'Enter image ratio', 'g5-ere' ),
								'type'     => 'dimension',
								'required' => array( 'similar_properties_post_image_size', '=', 'full' )
							),
						)
					),
					'similar_properties_layout_list_group'      => array(
						'id'       => 'similar_properties_layout_list_group',
						'title'    => esc_html__( 'Layout List', 'g5-ere' ),
						'type'     => 'group',
						'required' => array( 'similar_properties_post_layout', '=', 'list' ),
						'fields'   => array(
							'similar_properties_list_item_skin'         => array(
								'id'       => 'similar_properties_list_item_skin',
								'title'    => esc_html__( 'List Item Skin', 'g5-ere' ),
								'subtitle' => esc_html__( 'Specify your property list item skin', 'g5-ere' ),
								'type'     => 'image_set',
								'options'  => G5ERE()->settings()->get_property_list_skins(),
								'default'  => G5ERE()->options()->get_default( 'similar_properties_list_item_skin', 'skin-list-01' ),
							),
							'similar_properties_list_item_custom_class' => array(
								'id'       => 'similar_properties_list_item_custom_class',
								'title'    => esc_html__( 'List Item Css Classes', 'g5-ere' ),
								'subtitle' => esc_html__( 'Add custom css classes to item', 'g5-ere' ),
								'type'     => 'text',
							),
							'similar_properties_post_list_image_size'   => array(
								'id'       => 'similar_properties_post_list_image_size',
								'title'    => esc_html__( 'Image size', 'g5-ere' ),
								'subtitle' => esc_html__( 'Enter your property image size', 'g5-ere' ),
								'desc'     => esc_html__( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'g5-ere' ),
								'type'     => 'text',
								'default'  => G5ERE()->options()->get_default( 'similar_properties_post_list_image_size', 'full' ),
							),
							'similar_properties_post_list_image_ratio'  => array(
								'id'       => 'similar_properties_post_list_image_ratio',
								'title'    => esc_html__( 'Image Ratio', 'g5-ere' ),
								'subtitle' => esc_html__( 'Enter image ratio', 'g5-ere' ),
								'type'     => 'dimension',
								'required' => array(
									array( 'similar_properties_post_list_image_size', '=', 'full' ),
								)
							),
						)
					),
					'similar_properties_property_per_page'      => array(
						'id'         => 'similar_properties_property_per_page',
						'type'       => 'text',
						'input_type' => 'number',
						'title'      => esc_html__( 'Property per page', 'g5-ere' ),
						'subtitle'   => esc_html__( 'Set number of property per page', 'g5-ere' ),
						'default'    => '4',
					),
					'similar_properties_post_paging'            => array(
						'id'       => 'similar_properties_post_paging',
						'title'    => esc_html__( 'Paging', 'g5-ere' ),
						'subtitle' => esc_html__( 'Specify your paging mode', 'g5-ere' ),
						'type'     => 'select',
						'options'  => G5CORE()->settings()->get_post_paging_small_mode(),
						'default'  => G5ERE()->options()->get_default( 'similar_properties_post_paging', 'slider' ),
					),
					'similar_properties_post_animation'         => array(
						'id'       => 'similar_properties_post_animation',
						'title'    => esc_html__( 'Animation', 'g5-ere' ),
						'subtitle' => esc_html__( 'Specify your post animation', 'g5-ere' ),
						'type'     => 'select',
						'options'  => G5CORE()->settings()->get_animation(),
						'default'  => G5ERE()->options()->get_default( 'similar_properties_post_animation', 'none' )
					),
				)
			);
		}
		public function config_group_single_property_contact_agent() {
			return array(
				'id'     => 'single_property_contact_agent_group',
				'title'  => esc_html__( 'Contact Agent', 'g5-ere' ),
				'type'   => 'group',
				'toggle_default' =>  false,
				'fields' => array(
					'contact_agent_whatsapp_button_enable' => G5CORE()->fields()->get_config_toggle( array(
						'id'       => 'contact_agent_whatsapp_button_enable',
						'title'    => esc_html__( 'Whatsapp Button Enable', 'g5-ere' ),
						'subtitle' => esc_html__( 'Turn On this option if you want to enable Whatsapp Button', 'g5-ere' ),
						'default'  => G5ERE()->options()->get_default( 'contact_agent_whatsapp_button_enable', '' ),
					) ),
				)
			);
		}

		public function config_group_single_agent_my_property() {
			return array(
				'id'             => 'single_agent_my_property_group',
				'type'           => 'group',
				'toggle_default' => false,
				'title'          => esc_html__( 'My Properties', 'g5-ere' ),
				'fields'         => array(
					'single_agent_my_property_taxonomy_filter_enable' => G5CORE()->fields()->get_config_toggle( array(
						'id'       => 'single_agent_my_property_taxonomy_filter_enable',
						'title'    => esc_html__( 'Taxonomy Filter Enable', 'g5-ere' ),
						'subtitle' => esc_html__( 'Turn On this option if you want to enable taxonomy filter', 'g5-ere' ),
						'default'  => G5ERE()->options()->get_default( 'single_agent_my_property_taxonomy_filter_enable', '' ),
					) ),
					'single_agent_my_property_taxonomy_filter'        => array(
						'id'       => 'single_agent_my_property_taxonomy_filter',
						'title'    => esc_html__( 'Taxonomy Filter', 'g5-ere' ),
						'type'     => 'select',
						'options'  => G5ERE()->settings()->get_property_taxonomy_filter(),
						'default'  => 'property-status',
						'required' => array( 'single_agent_my_property_taxonomy_filter_enable', '=', 'on' )
					),
					'single_agent_my_property_post_layout'            => array(
						'id'      => 'single_agent_my_property_post_layout',
						'title'   => esc_html__( 'Property Layout', 'g5-ere' ),
						'type'    => 'image_set',
						'options' => G5ERE()->settings()->get_property_layout(),
						'default' => 'grid'
					),
					'single_agent_my_property_layout_grid_group'      => array(
						'id'       => 'single_agent_my_property_layout_grid_group',
						'title'    => esc_html__( 'Layout Grid', 'g5-ere' ),
						'type'     => 'group',
						'required' => array( 'single_agent_my_property_post_layout', '=', 'grid' ),
						'fields'   => array(
							'single_agent_my_property_item_skin'           => array(
								'id'       => 'single_agent_my_property_item_skin',
								'title'    => esc_html__( 'Item Skin', 'g5-ere' ),
								'subtitle' => esc_html__( 'Specify your property item skin', 'g5-ere' ),
								'type'     => 'image_set',
								'options'  => G5ERE()->settings()->get_property_skins(),
								'default'  => G5ERE()->options()->get_default( 'single_agent_my_property_item_skin', 'skin-01' ),
							),
							'single_agent_my_property_item_custom_class'   => array(
								'id'       => 'single_agent_my_property_item_custom_class',
								'title'    => esc_html__( 'Item Css Classes', 'g5-ere' ),
								'subtitle' => esc_html__( 'Add custom css classes to item', 'g5-ere' ),
								'type'     => 'text'
							),
							'single_agent_my_property_post_columns_gutter' => array(
								'id'       => 'single_agent_my_property_post_columns_gutter',
								'title'    => esc_html__( 'Columns Gutter', 'g5-ere' ),
								'subtitle' => esc_html__( 'Specify your horizontal space between property.', 'g5-ere' ),
								'type'     => 'select',
								'options'  => G5CORE()->settings()->get_post_columns_gutter(),
								'default'  => G5ERE()->options()->get_default( 'single_agent_my_property_post_columns_gutter', '30' ),
							),
							'single_agent_my_property_post_columns_group'  => array(
								'id'     => 'single_agent_my_property_post_columns_group',
								'title'  => esc_html__( 'Property Columns', 'g5-ere' ),
								'type'   => 'group',
								'fields' => array(
									'single_agent_my_property_post_columns_row_1' => array(
										'id'     => 'single_agent_my_property_post_columns_row_1',
										'type'   => 'row',
										'col'    => 3,
										'fields' => array(
											'single_agent_my_property_post_columns_xl' => array(
												'id'      => 'single_agent_my_property_post_columns_xl',
												'title'   => esc_html__( 'Extra Large Devices', 'g5-ere' ),
												'desc'    => esc_html__( 'Specify your property columns on extra large devices (>= 1200px)', 'g5-ere' ),
												'type'    => 'select',
												'options' => G5CORE()->settings()->get_post_columns(),
												'default' => G5ERE()->options()->get_default( 'single_agent_my_property_post_columns_xl', '2' ),
												'layout'  => 'full',
											),
											'single_agent_my_property_post_columns_lg' => array(
												'id'      => 'single_agent_my_property_post_columns_lg',
												'title'   => esc_html__( 'Large Devices', 'g5-ere' ),
												'desc'    => esc_html__( 'Specify your property columns on large devices (>= 992px)', 'g5-ere' ),
												'type'    => 'select',
												'options' => G5CORE()->settings()->get_post_columns(),
												'default' => G5ERE()->options()->get_default( 'single_agent_my_property_post_columns_lg', '2' ),
												'layout'  => 'full',
											),
											'single_agent_my_property_post_columns_md' => array(
												'id'      => 'single_agent_my_property_post_columns_md',
												'title'   => esc_html__( 'Medium Devices', 'g5-ere' ),
												'desc'    => esc_html__( 'Specify your property columns on medium devices (>= 768px)', 'g5-ere' ),
												'type'    => 'select',
												'options' => G5CORE()->settings()->get_post_columns(),
												'default' => G5ERE()->options()->get_default( 'single_agent_my_property_post_columns_md', '1' ),
												'layout'  => 'full',
											),
										)
									),
									'single_agent_my_property_post_columns_row_2' => array(
										'id'     => 'single_agent_my_property_post_columns_row_2',
										'type'   => 'row',
										'col'    => 3,
										'fields' => array(
											'single_agent_my_property_post_columns_sm' => array(
												'id'      => 'single_agent_my_property_post_columns_sm',
												'title'   => esc_html__( 'Small Devices', 'g5-ere' ),
												'desc'    => esc_html__( 'Specify your property columns on small devices (< 768px)', 'g5-ere' ),
												'type'    => 'select',
												'options' => G5CORE()->settings()->get_post_columns(),
												'default' => G5ERE()->options()->get_default( 'single_agent_my_property_post_columns_sm', '1' ),
												'layout'  => 'full',
											),
											'single_agent_my_property_post_columns'    => array(
												'id'      => 'single_agent_my_property_post_columns',
												'title'   => esc_html__( 'Extra Small Devices', 'g5-ere' ),
												'desc'    => esc_html__( 'Specify your property columns on extra small devices (< 576px)', 'g5-ere' ),
												'type'    => 'select',
												'options' => G5CORE()->settings()->get_post_columns(),
												'default' => G5ERE()->options()->get_default( 'single_agent_my_property_post_columns', '1' ),
												'layout'  => 'full',
											)
										)
									)
								)
							),
							'single_agent_my_property_post_image_size'     => array(
								'id'       => 'single_agent_my_property_post_image_size',
								'title'    => esc_html__( 'Image size', 'g5-ere' ),
								'subtitle' => esc_html__( 'Enter your property image size', 'g5-ere' ),
								'desc'     => esc_html__( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'g5-ere' ),
								'type'     => 'text',
								'default'  => G5ERE()->options()->get_default( 'single_agent_my_property_post_image_size', 'full' ),
							),
							'single_agent_my_property_post_image_ratio'    => array(
								'id'       => 'single_agent_my_property_post_image_ratio',
								'title'    => esc_html__( 'Image Ratio', 'g5-ere' ),
								'subtitle' => esc_html__( 'Enter image ratio', 'g5-ere' ),
								'type'     => 'dimension',
								'required' => array( 'single_agent_my_property_post_image_size', '=', 'full' )
							),
						)
					),
					'single_agent_my_property_layout_list_group'      => array(
						'id'       => 'single_agent_my_property_layout_list_group',
						'title'    => esc_html__( 'Layout List', 'g5-ere' ),
						'type'     => 'group',
						'required' => array( 'single_agent_my_property_post_layout', '=', 'list' ),
						'fields'   => array(
							'single_agent_my_property_list_item_skin'         => array(
								'id'       => 'single_agent_my_property_list_item_skin',
								'title'    => esc_html__( 'List Item Skin', 'g5-ere' ),
								'subtitle' => esc_html__( 'Specify your property list item skin', 'g5-ere' ),
								'type'     => 'image_set',
								'options'  => G5ERE()->settings()->get_property_list_skins(),
								'default'  => G5ERE()->options()->get_default( 'single_agent_my_property_list_item_skin', 'skin-list-01' ),
							),
							'single_agent_my_property_list_item_custom_class' => array(
								'id'       => 'single_agent_my_property_list_item_custom_class',
								'title'    => esc_html__( 'List Item Css Classes', 'g5-ere' ),
								'subtitle' => esc_html__( 'Add custom css classes to item', 'g5-ere' ),
								'type'     => 'text',
							),
							'single_agent_my_property_post_list_image_size'   => array(
								'id'       => 'single_agent_my_property_post_list_image_size',
								'title'    => esc_html__( 'Image size', 'g5-ere' ),
								'subtitle' => esc_html__( 'Enter your property image size', 'g5-ere' ),
								'desc'     => esc_html__( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'g5-ere' ),
								'type'     => 'text',
								'default'  => G5ERE()->options()->get_default( 'single_agent_my_property_post_list_image_size', 'full' ),
							),
							'single_agent_my_property_post_list_image_ratio'  => array(
								'id'       => 'single_agent_my_property_post_list_image_ratio',
								'title'    => esc_html__( 'Image Ratio', 'g5-ere' ),
								'subtitle' => esc_html__( 'Enter image ratio', 'g5-ere' ),
								'type'     => 'dimension',
								'required' => array(
									array( 'single_agent_my_property_post_list_image_size', '=', 'full' ),
								)
							),
						)
					),
					'single_agent_my_property_per_page'               => array(
						'id'         => 'single_agent_my_property_per_page',
						'type'       => 'text',
						'input_type' => 'number',
						'title'      => esc_html__( 'Property per page', 'g5-ere' ),
						'subtitle'   => esc_html__( 'Set number of property per page', 'g5-ere' ),
						'default'    => '4',
					),
					'single_agent_my_property_post_paging'            => array(
						'id'       => 'single_agent_my_property_post_paging',
						'title'    => esc_html__( 'Paging', 'g5-ere' ),
						'subtitle' => esc_html__( 'Specify your paging mode', 'g5-ere' ),
						'type'     => 'select',
						'options'  => G5CORE()->settings()->get_post_paging_small_mode(),
						'default'  => G5ERE()->options()->get_default( 'single_agent_my_property_post_paging', 'slider' ),
					),
					'single_agent_my_property_post_animation'         => array(
						'id'       => 'single_agent_my_property_post_animation',
						'title'    => esc_html__( 'Animation', 'g5-ere' ),
						'subtitle' => esc_html__( 'Specify your post animation', 'g5-ere' ),
						'type'     => 'select',
						'options'  => G5CORE()->settings()->get_animation(),
						'default'  => G5ERE()->options()->get_default( 'single_agent_my_property_post_animation', 'none' )
					),
				)
			);
		}

		public function config_group_single_agent_other_agent() {
			return array(
				'id'             => 'single_agent_other_agent_group',
				'type'           => 'group',
				'title'          => esc_html__( 'Other Agent', 'g5-ere' ),
				'toggle_default' => false,
				'fields'         => array(
					'other_agent_algorithm'         => array(
						'id'       => 'other_agent_algorithm',
						'title'    => esc_html__( 'Other Agent Algorithm', 'g5-ere' ),
						'subtitle' => esc_html__( 'Specify the algorithm of other agent', 'g5-ere' ),
						'type'     => 'select',
						'options'  => G5ERE()->settings()->get_other_agent_algorithm(),
						'default'  => G5ERE()->options()->get_default( 'other_agent_algorithm', 'agency' ),
					),
					'other_agent_layout'            => array(
						'id'      => 'other_agent_layout',
						'title'   => esc_html__( 'Agent Layout', 'g5-ere' ),
						'type'    => 'image_set',
						'options' => G5ERE()->settings()->get_agent_layout(),
						'default' => 'grid'
					),
					'other_agent_layout_grid_group' => array(
						'id'       => 'other_agent_layout_grid_group',
						'title'    => esc_html__( 'Layout Grid', 'g5-ere' ),
						'type'     => 'group',
						'required' => array( 'other_agent_layout', '=', 'grid' ),
						'fields'   => array(
							'other_agent_item_skin'         => array(
								'id'       => 'other_agent_item_skin',
								'title'    => esc_html__( 'Item Skin', 'g5-ere' ),
								'subtitle' => esc_html__( 'Specify your agent item skin', 'g5-ere' ),
								'type'     => 'image_set',
								'options'  => G5ERE()->settings()->get_agent_skins(),
								'default'  => G5ERE()->options()->get_default( 'other_agent_item_skin', 'skin-01' ),
							),
							'other_agent_item_custom_class' => array(
								'id'       => 'other_agent_item_custom_class',
								'title'    => esc_html__( 'Item Css Classes', 'g5-ere' ),
								'subtitle' => esc_html__( 'Add custom css classes to item', 'g5-ere' ),
								'type'     => 'text'
							),
							'other_agent_columns_gutter'    => array(
								'id'       => 'other_agent_columns_gutter',
								'title'    => esc_html__( 'Columns Gutter', 'g5-ere' ),
								'subtitle' => esc_html__( 'Specify your horizontal space between agent.', 'g5-ere' ),
								'type'     => 'select',
								'options'  => G5CORE()->settings()->get_post_columns_gutter(),
								'default'  => G5ERE()->options()->get_default( 'other_agent_columns_gutter', '30' ),
							),
							'other_agent_columns_group'     => array(
								'id'     => 'other_agent_columns_group',
								'title'  => esc_html__( 'Agent Columns', 'g5-ere' ),
								'type'   => 'group',
								'fields' => array(
									'other_agent_columns_row_1' => array(
										'id'     => 'other_agent_columns_row_1',
										'type'   => 'row',
										'col'    => 3,
										'fields' => array(
											'other_agent_columns_xl' => array(
												'id'      => 'other_agent_columns_xl',
												'title'   => esc_html__( 'Extra Large Devices', 'g5-ere' ),
												'desc'    => esc_html__( 'Specify your agent columns on extra large devices (>= 1200px)', 'g5-ere' ),
												'type'    => 'select',
												'options' => G5CORE()->settings()->get_post_columns(),
												'default' => G5ERE()->options()->get_default( 'other_agent_columns_xl', '2' ),
												'layout'  => 'full',
											),
											'other_agent_columns_lg' => array(
												'id'      => 'other_agent_columns_lg',
												'title'   => esc_html__( 'Large Devices', 'g5-ere' ),
												'desc'    => esc_html__( 'Specify your agent columns on large devices (>= 992px)', 'g5-ere' ),
												'type'    => 'select',
												'options' => G5CORE()->settings()->get_post_columns(),
												'default' => G5ERE()->options()->get_default( 'other_agent_columns_lg', '2' ),
												'layout'  => 'full',
											),
											'other_agent_columns_md' => array(
												'id'      => 'other_agent_columns_md',
												'title'   => esc_html__( 'Medium Devices', 'g5-ere' ),
												'desc'    => esc_html__( 'Specify your agent columns on medium devices (>= 768px)', 'g5-ere' ),
												'type'    => 'select',
												'options' => G5CORE()->settings()->get_post_columns(),
												'default' => G5ERE()->options()->get_default( 'other_agent_columns_md', '1' ),
												'layout'  => 'full',
											),
										)
									),
									'other_agent_columns_row_2' => array(
										'id'     => 'other_agent_columns_row_2',
										'type'   => 'row',
										'col'    => 3,
										'fields' => array(
											'other_agent_columns_sm' => array(
												'id'      => 'other_agent_columns_sm',
												'title'   => esc_html__( 'Small Devices', 'g5-ere' ),
												'desc'    => esc_html__( 'Specify your agent columns on small devices (< 768px)', 'g5-ere' ),
												'type'    => 'select',
												'options' => G5CORE()->settings()->get_post_columns(),
												'default' => G5ERE()->options()->get_default( 'other_agent_columns_sm', '1' ),
												'layout'  => 'full',
											),
											'other_agent_columns'    => array(
												'id'      => 'other_agent_columns',
												'title'   => esc_html__( 'Extra Small Devices', 'g5-ere' ),
												'desc'    => esc_html__( 'Specify your agent columns on extra small devices (< 576px)', 'g5-ere' ),
												'type'    => 'select',
												'options' => G5CORE()->settings()->get_post_columns(),
												'default' => G5ERE()->options()->get_default( 'other_agent_columns', '1' ),
												'layout'  => 'full',
											)
										)
									)
								)
							),
							'other_agent_image_size'        => array(
								'id'       => 'other_agent_image_size',
								'title'    => esc_html__( 'Image size', 'g5-ere' ),
								'subtitle' => esc_html__( 'Enter your agent image size', 'g5-ere' ),
								'desc'     => esc_html__( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'g5-ere' ),
								'type'     => 'text',
								'default'  => G5ERE()->options()->get_default( 'other_agent_image_size', 'full' ),
							),
							'other_agent_image_ratio'       => array(
								'id'       => 'other_agent_image_ratio',
								'title'    => esc_html__( 'Image Ratio', 'g5-ere' ),
								'subtitle' => esc_html__( 'Enter image ratio', 'g5-ere' ),
								'type'     => 'dimension',
								'required' => array( 'other_agent_image_size', '=', 'full' ),
							),
						)
					),
					'other_agent_layout_list_group' => array(
						'id'       => 'other_agent_layout_list_group',
						'title'    => esc_html__( 'Layout List', 'g5-ere' ),
						'type'     => 'group',
						'required' => array( 'other_agent_layout', '=', 'list' ),
						'fields'   => array(
							'other_agent_list_item_skin'         => array(
								'id'       => 'other_agent_list_item_skin',
								'title'    => esc_html__( 'List Item Skin', 'g5-ere' ),
								'subtitle' => esc_html__( 'Specify your agent list item skin', 'g5-ere' ),
								'type'     => 'image_set',
								'options'  => G5ERE()->settings()->get_agent_list_skins(),
								'default'  => G5ERE()->options()->get_default( 'other_agent_list_item_skin', 'skin-list-01' ),
							),
							'other_agent_list_item_custom_class' => array(
								'id'       => 'other_agent_list_item_custom_class',
								'title'    => esc_html__( 'List Item Css Classes', 'g5-ere' ),
								'subtitle' => esc_html__( 'Add custom css classes to item', 'g5-ere' ),
								'type'     => 'text',
							),
							'other_agent_list_image_size'        => array(
								'id'       => 'other_agent_list_image_size',
								'title'    => esc_html__( 'Image size', 'g5-ere' ),
								'subtitle' => esc_html__( 'Enter your agent image size', 'g5-ere' ),
								'desc'     => esc_html__( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'g5-ere' ),
								'type'     => 'text',
								'default'  => G5ERE()->options()->get_default( 'other_agent_list_image_size', 'full' ),
							),
							'other_agent_list_image_ratio'       => array(
								'id'       => 'other_agent_list_image_ratio',
								'title'    => esc_html__( 'Image Ratio', 'g5-ere' ),
								'subtitle' => esc_html__( 'Enter image ratio', 'g5-ere' ),
								'type'     => 'dimension',
								'required' => array( 'other_agent_list_image_ratio', '=', 'full' ),
							),
						)
					),
					'other_agent_per_page'          => array(
						'id'         => 'other_agent_per_page',
						'type'       => 'text',
						'input_type' => 'number',
						'title'      => esc_html__( 'Agent per page', 'g5-ere' ),
						'subtitle'   => esc_html__( 'Set number of agent per page', 'g5-ere' ),
						'default'    => '4',
					),
					'other_agent_paging'            => array(
						'id'       => 'other_agent_paging',
						'title'    => esc_html__( 'Paging', 'g5-ere' ),
						'subtitle' => esc_html__( 'Specify your paging mode', 'g5-ere' ),
						'type'     => 'select',
						'options'  => G5CORE()->settings()->get_post_paging_small_mode(),
						'default'  => G5ERE()->options()->get_default( 'other_agent_paging', 'slider' ),
					),
					'other_agent_animation'         => array(
						'id'       => 'other_agent_animation',
						'title'    => esc_html__( 'Animation', 'g5-ere' ),
						'subtitle' => esc_html__( 'Specify your agent animation', 'g5-ere' ),
						'type'     => 'select',
						'options'  => G5CORE()->settings()->get_animation(),
						'default'  => G5ERE()->options()->get_default( 'other_agent_animation', 'none' )
					)
				)
			);
		}


		public function config_group_property_single_yelp() {
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

			return array(
				'id'     => 'yelp_services',
				'title'  => esc_html__( 'Yelp Nearby Places', 'g5-ere' ),
				'type'   => 'group',
				'fields' => array(
					'yelp_api_key'       => array(
						'id'       => 'yelp_api_key',
						'type'     => 'text',
						'title'    => esc_html__( 'Yelp API Key', 'g5-ere' ),
						'desc'     => wp_kses( __( 'Enter your Yelp API key code. <a target="_blank" href="https://www.yelp.com/developers/v3/manage_app">Get an API code</a>.Note: This service is used for map service Mapbox and Openstreetmap. If map service is Google map, it is used for Nearby Places Service Provider when you choose Yelp service.', 'g5-ere' ), $allowed_html ),
						'subtitle' => esc_html__( 'Enter your Yelp api key', 'g5-ere' ),
						'default'  => '',
					),
					'yelp_categories'    => array(
						'id'       => 'yelp_categories',
						'title'    => esc_html__( 'Yelp Categories', 'g5-ere' ),
						'desc'     => esc_html__( 'Select the Yelp categories that you want to display.', 'g5-ere' ),
						'type'     => 'selectize',
						'multiple' => true,
						'options'  => G5ERE()->settings()->get_yelp_category(),
						'default'  => array(
							'realestate',
							'education',
							'health'
						),
					),
					'yelp_distance_unit' => array(
						'id'       => 'yelp_distance_unit',
						'title'    => esc_html__( 'Yelp Distance Unit', 'g5-ere' ),
						'subtitle' => esc_html__( 'Select the distance unit.', 'g5-ere' ),
						'type'     => 'select',
						'options'  => array(
							'miles'      => esc_html__( 'Miles', 'g5-ere' ),
							'kilometers' => esc_html__( 'Kilometers', 'g5-ere' )
						),
						'default'  => G5ERE()->options()->get_default( 'yelp_distance_unit', 'miles' ),
					),
				),
			);
		}

		public function config_section_map_services() {
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

			return array(
				'id'     => 'map_services',
				'title'  => esc_html__( 'Map Services', 'g5-ere' ),
				'icon'   => 'dashicons dashicons-location-alt',
				'fields' => array(
					array(
						'id'       => 'map_service',
						'title'    => esc_html__( 'Map Service Provider', 'g5-ere' ),
						'subtitle' => esc_html__( 'Choose what service to use for displaying maps, place suggestions, and geocoding.', 'g5-ere' ),
						'type'     => 'select',
						'options'  => G5ERE()->settings()->get_map_services(),
						'default'  => 'google'
					),
					array(
						'id'       => 'google_map_group',
						'title'    => esc_html__( 'Google Maps', 'g5-ere' ),
						'type'     => 'group',
						'required' => array( 'map_service', '=', 'google' ),
						'fields'   => array(
							array(
								'id'       => 'googlemap_api_key',
								'type'     => 'text',
								'title'    => esc_html__( 'Google Maps API Key', 'g5-ere' ),
								'desc'     => wp_kses( __( 'An API key is required to use Google Maps. <a target="_blank" href="https://developers.google.com/maps/documentation/javascript/get-api-key">Click here to learn more</a>.', 'g5-ere' ), $allowed_html ),
								'subtitle' => esc_html__( 'Enter your google maps api key', 'g5-ere' ),
								'default'  => '',
							),
							array(
								'id'      => 'googlemap_autocomplete_types',
								'title'   => esc_html__( 'Autocomplete returns results for', 'g5-ere' ),
								'desc'    => esc_html__( 'Determine what kind of features should be searched by autocomplete.', 'g5-ere' ),
								'type'    => 'select',
								'options' => G5ERE()->settings()->get_google_map_autocomplete_types(),
								'default' => 'geocode'
							),
							array(
								'id'       => 'googlemap_autocomplete_locations',
								'title'    => esc_html__( 'Autocomplete returns results in', 'g5-ere' ),
								'desc'     => esc_html__( 'Limit autocomplete results to one or more countries.', 'g5-ere' ),
								'type'     => 'selectize',
								'multiple' => true,
								'options'  => G5ERE()->settings()->get_countries()
							),
							array(
								'id'       => 'google_map_skin',
								'title'    => esc_html__( 'Google Map Skins', 'g5-ere' ),
								'subtitle' => esc_html__( 'Select skin for google map', 'g5-ere' ),
								'type'     => 'select',
								'options'  => G5ERE()->settings()->get_google_map_skins(),
								'default'  => 'skin1'
							),
							array(
								'id'       => 'google_map_skin_custom',
								'type'     => 'ace_editor',
								'title'    => esc_html__( 'Style for Google Map', 'g5-ere' ),
								'subtitle' => sprintf( __( 'Use %s https://snazzymaps.com/ %s to create styles', 'g5-ere' ),
									'<a href="https://snazzymaps.com/" target="_blank">',
									'</a>'
								),
								'default'  => '',
								'required' => array( 'google_map_skin', '=', 'custom' )
								//'mode' => 'plain'
							),
						)
					),

					array(
						'id'       => 'mapbox_group',
						'title'    => esc_html__( 'Mapbox', 'g5-ere' ),
						'type'     => 'group',
						'required' => array( 'map_service', '=', 'mapbox' ),
						'fields'   => array(
							array(
								'id'       => 'mapbox_api_access_token',
								'type'     => 'text',
								'title'    => esc_html__( 'Mapbox API Access Token', 'g5-ere' ),
								'desc'     => wp_kses( __( 'A Mapbox API Access Token is required to load maps. You can get it in <a target="_blank" href="https://www.mapbox.com/account/">in your Mapbox user dashboard</a>.', 'g5-ere' ), $allowed_html ),
								'subtitle' => esc_html__( 'Enter your mapbox api access token', 'g5-ere' ),
								'default'  => '',
							),
							array(
								'id'       => 'mapbox_autocomplete_types',
								'title'    => esc_html__( 'Autocomplete returns results for', 'g5-ere' ),
								'desc'     => esc_html__( 'Determine what kind of features should be searched by autocomplete. Leave blank to include all.', 'g5-ere' ),
								'type'     => 'selectize',
								'multiple' => true,
								'options'  => G5ERE()->settings()->get_mapbox_autocomplete_types(),
							),
							array(
								'id'       => 'mapbox_autocomplete_locations',
								'title'    => esc_html__( 'Autocomplete returns results in', 'g5-ere' ),
								'desc'     => esc_html__( 'Limit autocomplete results to one or more countries.', 'g5-ere' ),
								'type'     => 'selectize',
								'multiple' => true,
								'options'  => G5ERE()->settings()->get_countries()
							),
							array(
								'id'       => 'mapbox_skin',
								'title'    => esc_html__( 'Mapbox Skins', 'g5-ere' ),
								'subtitle' => esc_html__( 'Select skin for mapbox', 'g5-ere' ),
								'type'     => 'select',
								'options'  => G5ERE()->settings()->get_mapbox_skins(),
								'default'  => 'skin1'
							),
							array(
								'id'       => 'mapbox_skin_custom',
								'type'     => 'ace_editor',
								'title'    => esc_html__( 'Style for Mapbox', 'g5-ere' ),
								'subtitle' => wp_kses_post( __( 'You can create custom map styles in your <a target="_blank" href="https://www.mapbox.com/studio/">Mapbox Studio</a>. Paste the style URL below.', 'g5-ere' ) ),
								'default'  => '',
								'required' => array( 'mapbox_skin', '=', 'custom' )
							),
						)
					),

					array(
						'id'       => 'map_pin_cluster',
						'title'    => esc_html__( 'Pin Cluster', 'g5-ere' ),
						'subtitle' => esc_html__( 'Use pin cluster on map.', 'g5-ere' ),
						'type'     => 'button_set',
						'options'  => array(
							'yes' => esc_html__( 'Yes', 'g5-ere' ),
							'no'  => esc_html__( 'No', 'g5-ere' ),
						),
						'default'  => 'yes',
					),
					array(
						'id'         => 'map_zoom_level',
						'type'       => 'slider',
						'title'      => esc_html__( 'Default Map Zoom', 'g5-ere' ),
						'js_options' => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 20
						),
						'default'    => 12
					),
					array(
						'id'      => 'marker_type',
						'title'   => esc_html__( 'Map Marker Type', 'g5-ere' ),
						'type'    => 'button_set',
						'options' => G5ERE()->settings()->get_map_marker_type(),
						'default' => 'icon',
					),
					array(
						'id'       => 'marker_icon',
						'title'    => esc_html__( 'Marker Icon', 'g5-ere' ),
						'subtitle' => esc_html__( 'Select icon for map marker', 'g5-ere' ),
						'type'     => 'icon',
						'default'  => 'fal fa-map-marker-alt',
						'required' => array( 'marker_type', '=', 'icon' ),
					),
					array(
						'id'       => 'marker_image',
						'type'     => 'image',
						'title'    => esc_html__( 'Marker Image', 'g5-ere' ),
						'subtitle' => esc_html__( 'Select image for map marker', 'g5-ere' ),
						'default'  => '',
						'required' => array( 'marker_type', '=', 'image' ),
					),
					array(
						'id' => 'coordinate_default',
						'type' => 'text',
						'title' => esc_html__('Default Coordinate', 'g5-ere'),
						'desc' => esc_html__('Example: 40.735601,-74.165918', 'g5-ere'),
						'subtitle' => esc_html__('Enter your default coordinate when add new property', 'g5-ere'),
						'default' => '-33.868419,151.193245'
					),
					array(
						'type'   => 'group',
						'title'  => esc_html__( 'Map directions', 'g5-ere' ),
						'fields' => array(
							array(
								'id'      => 'enable_map_directions',
								'title'   => esc_html__( 'Enable Google Map Directions', 'g5-ere' ),
								'type'    => 'button_set',
								'options' => array(
									'yes' => esc_html__( 'Yes', 'g5-ere' ),
									'no'  => esc_html__( 'No', 'g5-ere' ),
								),
								'default' => 'yes',
							),
							array(
								'id'       => 'map_directions_distance_unit',
								'type'     => 'select',
								'title'    => esc_html__( 'Distance Unit', 'g5-ere' ),
								'subtitle' => '',
								'options'  => array(
									'metre'     => esc_html__( 'Metre', 'g5-ere' ),
									'kilometre' => esc_html__( 'Kilometre', 'g5-ere' ),
									'mile'      => esc_html__( 'Mile', 'g5-ere' )
								),
								'default'  => 'kilometre',
								'required' => array( 'enable_map_directions', '=', 'yes' ),
							),
						)
					),
					array(
						'type'   => 'group',
						'title'  => esc_html__( 'Nearby Places', 'g5-ere' ),
						'fields' => array(
							array(
								'id'       => 'nearby_places_service',
								'title'    => esc_html__( 'Nearby Places Service Provider', 'g5-ere' ),
								'subtitle' => esc_html__( 'Choose what service to use for displaying nearby place.', 'g5-ere' ),
								'type'     => 'select',
								'options'  => G5ERE()->settings()->get_nearby_place_services(),
								'default'  => 'google',
								'required' => array(
									array( 'map_service', '=', 'google' ),
								)
							),
							array(
								'id'         => 'nearby_places_result_limit',
								'type'       => 'text',
								'input_type' => 'number',
								'title'      => esc_html__( 'Results Limit', 'g5-ere' ),
								'subtitle'   => esc_html__( 'Enter the number of result that you want to display', 'g5-ere' ),
								'default'    => '3',
							),
							array(
								'id'       => 'nearby_places_map_category',
								'title'    => esc_html__( 'Nearby Places Category', 'g5-ere' ),
								'subtitle' => esc_html__( 'Choose what category to use for search nearby place.', 'g5-ere' ),
								'type'     => 'selectize',
								'multiple' => true,
								'options'  => G5ERE()->settings()->get_nearby_place_map_category(),
								'default'  => array(
									'store',
									'school',
									'real_estate_agency'
								),
								'required' => array(
									array( 'map_service', '=', 'google' ),
									array( 'nearby_places_service', '!=', 'yelp' )
								)
							),
							array(
								'id'       => 'nearby_places_map_rank_by',
								'title'    => esc_html__( 'Rank by', 'g5-ere' ),
								'subtitle' => esc_html__( 'Select options', 'g5-ere' ),
								'type'     => 'select',
								'options'  => array(
									"default"  => esc_html__( 'Prominence', 'g5-ere' ),
									"distance" => esc_html__( 'Distance', 'g5-ere' ),
								),
								'required' => array(
									array( 'map_service', '=', 'google' ),
									array( 'nearby_places_service', '!=', 'yelp' )
								)
							),
							array(
								'id'       => 'nearby_places_map_radius',
								'title'    => esc_html__( 'Radius', 'g5-ere' ),
								'subtitle' => esc_html__( 'Radius', 'g5-ere' ),
								'desc'     => esc_html__( 'Enter radius (meter)', 'g5-ere' ),
								'type'     => 'text',
								'default'  => '5000',
								'required' => array(
									array( 'map_service', '=', 'google' ),
									array( 'nearby_places_service', '!=', 'yelp' ),
									array( 'nearby_places_map_rank_by', '!=', 'distance' )
								)
							),
							'single_property_near_places_yelp' => $this->config_group_property_single_yelp(),
						)
					),
				)

			);
		}

		public function config_section_search_form() {
			return array(
				'id'     => 'search_forms',
				'title'  => esc_html__( 'Search Forms', 'g5-ere' ),
				'icon'   => 'dashicons dashicons-search',
				'fields' => array(

					array(
						'id'          => 'search_forms',
						'title'       => esc_html__( 'Search Form', 'g5-ere' ),
						'type'        => 'panel',
						'panel_title' => 'name',
						'default'     => G5ERE()->settings()->get_search_form_default(),
						'fields'      => array(
							array(
								'id'       => 'name',
								'title'    => esc_html__( 'Name', 'g5-ere' ),
								'type'     => 'text',
								'subtitle' => esc_html__( 'Enter Form Name', 'g5-ere' ),
								'default'  => ''
							),
							array(
								'id'       => 'id',
								'title'    => esc_html__( 'ID', 'g5-ere' ),
								'type'     => 'text',
								'subtitle' => esc_html__( 'Enter Form ID', 'g5-ere' ),
								'desc'     => esc_html__( 'ID values cannot be changed after being set!', 'g5-ere' ),
								'default'  => '',
							),
							'form_builder' => array(
								'id'     => 'form_builder',
								'title'  => esc_html__( 'Form Builder', 'g5-ere' ),
								'type'   => 'group',
								'fields' => array(
									'search_style'           => array(
										'id'       => 'search_style',
										'title'    => esc_html__( 'Search Form Style', 'g5-ere' ),
										'subtitle' => esc_html__( 'Specify your search form style', 'g5-ere' ),
										'type'     => 'select',
										'options'  => G5ERE()->settings()->get_search_form_style(),
										'default'  => 'layout-01',
									),
									'search_fields'          => array(
										'id'      => 'search_fields',
										'title'   => esc_html__( 'Search Fields', 'g5-ere' ),
										'type'    => 'sorter',
										'default' => G5ERE()->settings()->get_search_form_fields()
									),
									'search_tabs'            => array(
										'id'       => 'search_tabs',
										'title'    => esc_html__( 'Search Tabs', 'g5-ere' ),
										'subtitle' => esc_html__( 'This option will display the status tabs on the search bar', 'g5-ere' ),
										'desc'     => esc_html__( 'If enabled, status dropdown fields will not show', 'g5-ere' ),
										'type'     => 'button_set',
										'options'  => array(
											'on'            => esc_html__( 'Enable', 'g5-ere' ),
											'on-all-status' => esc_html__( 'Enable All Status', 'g5-ere' ),
											'off'           => esc_html__( 'Disable', 'g5-ere' )
										),
										'default'  => 'off',
									),
									'price_range_slider'     => array(
										'id'       => 'price_range_slider',
										'title'    => esc_html__( 'Price Range Slider', 'g5-ere' ),
										'desc'     => esc_html__( 'If enabled, min and max price dropdown fields will not show', 'g5-ere' ),
										'subtitle' => esc_html__( 'Enable or disable the price range slider', 'g5-ere' ),
										'type'     => 'button_set',
										'options'  => array(
											'on'  => esc_html__( 'Enable', 'g5-ere' ),
											'off' => esc_html__( 'Disable', 'g5-ere' )
										),
										'default'  => 'on',
									),
									'size_range_slider'      => array(
										'id'       => 'size_range_slider',
										'title'    => esc_html__( 'Size Range Slider', 'g5-ere' ),
										'desc'     => esc_html__( 'If enabled, min and max area dropdown fields will not show', 'g5-ere' ),
										'subtitle' => esc_html__( 'Enable or disable the size range slider', 'g5-ere' ),
										'type'     => 'button_set',
										'options'  => array(
											'on'  => esc_html__( 'Enable', 'g5-ere' ),
											'off' => esc_html__( 'Disable', 'g5-ere' )
										),
										'default'  => 'off',
									),
									'land_area_range_slider' => array(
										'id'       => 'land_area_range_slider',
										'title'    => esc_html__( 'Land Area Range Slider', 'g5-ere' ),
										'desc'     => esc_html__( 'If enabled, min and max land area dropdown fields will not show', 'g5-ere' ),
										'subtitle' => esc_html__( 'Enable or disable the land area range slider', 'g5-ere' ),
										'type'     => 'button_set',
										'options'  => array(
											'on'  => esc_html__( 'Enable', 'g5-ere' ),
											'off' => esc_html__( 'Disable', 'g5-ere' )
										),
										'default'  => 'off',
									),
									'other_features'         => array(
										'id'       => 'other_features',
										'title'    => esc_html__( 'Other Features', 'g5-ere' ),
										'subtitle' => esc_html__( 'Enable or disable other features in searches', 'g5-ere' ),
										'type'     => 'button_set',
										'options'  => array(
											'on'  => esc_html__( 'Enable', 'g5-ere' ),
											'off' => esc_html__( 'Disable', 'g5-ere' )
										),
										'default'  => 'on',
									),
									'advanced_filters'       => array(
										'id'       => 'advanced_filters',
										'title'    => esc_html__( 'Advanced Filters', 'g5-ere' ),
										'subtitle' => esc_html__( 'Enable or disable advanced button in searches', 'g5-ere' ),
										'desc'     => esc_html__( 'Note: If "disable" it will remove advanced button in search and show all filters', 'g5-ere' ),
										'type'     => 'button_set',
										'options'  => array(
											'on'  => esc_html__( 'Enable', 'g5-ere' ),
											'off' => esc_html__( 'Disable', 'g5-ere' )
										),
										'default'  => 'on',
									),
									'submit_button_position' => array(
										'id'       => 'submit_button_position',
										'title'    => esc_html__( 'Submit Button Position', 'g5-ere' ),
										'subtitle' => esc_html__( 'Specify your submit button position', 'g5-ere' ),
										'type'     => 'button_set',
										'options'  => array(
											'top'    => esc_html__( 'Top', 'g5-ere' ),
											'bottom' => esc_html__( 'Bottom', 'g5-ere' )
										),
										'default'  => 'top'

									)
								)
							),
						)
					),
				)
			);
		}

		public function config_section_dashboard() {
			return array(
				'id'     => 'section_dashboard',
				'title'  => esc_html__( 'Dashboard', 'g5-ere' ),
				'icon'   => 'dashicons dashicons-performance',
				'fields' => array(
					'dashboard_logo'            => array(
						'type'   => 'group',
						'title'  => esc_html__( 'Dashboard Logo', 'g5-ere' ),
						'fields' => array(
							'dashboard_logo'       => array(
								'id'       => 'dashboard_logo',
								'title'    => esc_html__( 'Logo', 'g5-ere' ),
								'subtitle' => esc_html__( 'By default, a text-based logo is created using your site title. But you can also upload an image-based logo here.', 'g5-ere' ),
								'type'     => 'image',
							),
							'dashboard_max_height' => array(
								'id'       => 'dashboard_max_height',
								'title'    => esc_html__( 'Logo Max Height', 'g5-ere' ),
								'subtitle' => esc_html__( 'If you would like to override the default logo max height, then you can do so here.', 'g5-ere' ),
								'type'     => 'dimension',
								'width'    => false,
							),
						)
					),
					'dashboard_submit_property' => array(
						'type'   => 'group',
						'title'  => esc_html__( 'Submit Property', 'g5-ere' ),
						'fields' => array(
							array(
								'id'      => 'dashboard_enable_show_all',
								'title'   => esc_html__( 'Enable Show All Fields Button', 'g5-ere' ),
								'type'    => 'button_set',
								'options' => array(
									'yes' => esc_html__( 'Yes', 'g5-ere' ),
									'no'  => esc_html__( 'No', 'g5-ere' ),
								),
								'default' => 'yes',
							),
						)
					)

				)
			);
		}

		public function config_section_agent_archive() {
			return array(
				'id'     => 'section_agent_archive',
				'title'  => esc_html__( 'Agent Listing', 'g5-ere' ),
				'icon'   => 'dashicons dashicons-businessman',
				'fields' => array(
					'agent_toolbar_group'     => array(
						'id'     => 'agent_toolbar_group',
						'title'  => esc_html__( 'Toolbar', 'g5-ere' ),
						'type'   => 'group',
						'fields' => array(
							'agent_toolbar_layout' => array(
								'id'       => 'agent_toolbar_layout',
								'title'    => esc_html__( 'ToolBar Layout', 'g5-ere' ),
								'subtitle' => esc_html__( 'Specify your tool bar layout', 'g5-ere' ),
								'type'     => 'select',
								'options'  => array(
									'boxed'             => esc_html__( 'Boxed Content', 'g5-ere' ),
									'stretched'         => esc_html__( 'Stretched row', 'g5-ere' ),
									'stretched_content' => esc_html__( 'Stretched row and content', 'g5-ere' ),
								),
								'default'  => G5ERE()->options()->get_default( 'agent_toolbar_layout', 'boxed' ),
							),
							'agent_toolbar'        => array(
								'id'      => 'agent_toolbar',
								'title'   => esc_html__( 'ToolBar', 'g5-ere' ),
								'type'    => 'sorter',
								'default' => G5ERE()->options()->get_default( 'agent_toolbar', array(
									'left'    => array(
										'result_count' => esc_html__( 'Result Count', 'g5-ere' )
									),
									'right'   => array(
										'ordering'      => esc_html__( 'Ordering', 'g5-ere' ),
										'switch_layout' => esc_html__( 'Switch Layout', 'g5-ere' ),
									),
									'disable' => array()
								) ),
							),

							'agent_toolbar_mobile' => array(
								'id'      => 'agent_toolbar_mobile',
								'title'   => esc_html__( 'ToolBar Mobile', 'g5-ere' ),
								'type'    => 'sorter',
								'default' => G5ERE()->options()->get_default( 'agent_toolbar_mobile', array(
									'left'    => array(
										'result_count' => esc_html__( 'Result Count', 'g5-ere' )
									),
									'right'   => array(
										'ordering' => esc_html__( 'Ordering', 'g5-ere' ),
									),
									'disable' => array(
										'switch_layout' => esc_html__( 'Switch Layout', 'g5-ere' ),
									)
								) ),
							),
						)
					),
					'agent_layout'            => array(
						'id'      => 'agent_layout',
						'title'   => esc_html__( 'Agent Layout', 'g5-ere' ),
						'type'    => 'image_set',
						'options' => G5ERE()->settings()->get_agent_layout(),
						'default' => 'grid'
					),
					'agent_layout_grid_group' => array(
						'id'     => 'agent_layout_grid_group',
						'title'  => esc_html__( 'Layout Grid', 'g5-ere' ),
						'type'   => 'group',
						'fields' => array(
							'agent_item_skin'         => array(
								'id'       => 'agent_item_skin',
								'title'    => esc_html__( 'Item Skin', 'g5-ere' ),
								'subtitle' => esc_html__( 'Specify your agent item skin', 'g5-ere' ),
								'type'     => 'image_set',
								'options'  => G5ERE()->settings()->get_agent_skins(),
								'default'  => G5ERE()->options()->get_default( 'agent_item_skin', 'skin-01' ),
							),
							'agent_item_custom_class' => array(
								'id'       => 'agent_item_custom_class',
								'title'    => esc_html__( 'Item Css Classes', 'g5-ere' ),
								'subtitle' => esc_html__( 'Add custom css classes to item', 'g5-ere' ),
								'type'     => 'text'
							),
							'agent_columns_gutter'    => array(
								'id'       => 'agent_columns_gutter',
								'title'    => esc_html__( 'Columns Gutter', 'g5-ere' ),
								'subtitle' => esc_html__( 'Specify your horizontal space between agent.', 'g5-ere' ),
								'type'     => 'select',
								'options'  => G5CORE()->settings()->get_post_columns_gutter(),
								'default'  => G5ERE()->options()->get_default( 'agent_columns_gutter', '30' ),
							),
							'agent_columns_group'     => array(
								'id'     => 'agent_columns_group',
								'title'  => esc_html__( 'Agent Columns', 'g5-ere' ),
								'type'   => 'group',
								'fields' => array(
									'agent_columns_row_1' => array(
										'id'     => 'agent_columns_row_1',
										'type'   => 'row',
										'col'    => 3,
										'fields' => array(
											'agent_columns_xl' => array(
												'id'      => 'agent_columns_xl',
												'title'   => esc_html__( 'Extra Large Devices', 'g5-ere' ),
												'desc'    => esc_html__( 'Specify your agent columns on extra large devices (>= 1200px)', 'g5-ere' ),
												'type'    => 'select',
												'options' => G5CORE()->settings()->get_post_columns(),
												'default' => G5ERE()->options()->get_default( 'agent_columns_xl', '3' ),
												'layout'  => 'full',
											),
											'agent_columns_lg' => array(
												'id'      => 'agent_columns_lg',
												'title'   => esc_html__( 'Large Devices', 'g5-ere' ),
												'desc'    => esc_html__( 'Specify your agent columns on large devices (>= 992px)', 'g5-ere' ),
												'type'    => 'select',
												'options' => G5CORE()->settings()->get_post_columns(),
												'default' => G5ERE()->options()->get_default( 'agent_columns_lg', '3' ),
												'layout'  => 'full',
											),
											'agent_columns_md' => array(
												'id'      => 'agent_columns_md',
												'title'   => esc_html__( 'Medium Devices', 'g5-ere' ),
												'desc'    => esc_html__( 'Specify your agent columns on medium devices (>= 768px)', 'g5-ere' ),
												'type'    => 'select',
												'options' => G5CORE()->settings()->get_post_columns(),
												'default' => G5ERE()->options()->get_default( 'agent_columns_md', '2' ),
												'layout'  => 'full',
											),
										)
									),
									'agent_columns_row_2' => array(
										'id'     => 'agent_columns_row_2',
										'type'   => 'row',
										'col'    => 3,
										'fields' => array(
											'agent_columns_sm' => array(
												'id'      => 'agent_columns_sm',
												'title'   => esc_html__( 'Small Devices', 'g5-ere' ),
												'desc'    => esc_html__( 'Specify your agent columns on small devices (< 768px)', 'g5-ere' ),
												'type'    => 'select',
												'options' => G5CORE()->settings()->get_post_columns(),
												'default' => G5ERE()->options()->get_default( 'agent_columns_sm', '2' ),
												'layout'  => 'full',
											),
											'agent_columns'    => array(
												'id'      => 'agent_columns',
												'title'   => esc_html__( 'Extra Small Devices', 'g5-ere' ),
												'desc'    => esc_html__( 'Specify your agent columns on extra small devices (< 576px)', 'g5-ere' ),
												'type'    => 'select',
												'options' => G5CORE()->settings()->get_post_columns(),
												'default' => G5ERE()->options()->get_default( 'agent_columns', '1' ),
												'layout'  => 'full',
											)
										)
									)
								)
							),
							'agent_image_size'        => array(
								'id'       => 'agent_image_size',
								'title'    => esc_html__( 'Image size', 'g5-ere' ),
								'subtitle' => esc_html__( 'Enter your agent image size', 'g5-ere' ),
								'desc'     => esc_html__( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'g5-ere' ),
								'type'     => 'text',
								'default'  => G5ERE()->options()->get_default( 'agent_image_size', 'full' ),
							),
							'agent_image_ratio'       => array(
								'id'       => 'agent_image_ratio',
								'title'    => esc_html__( 'Image Ratio', 'g5-ere' ),
								'subtitle' => esc_html__( 'Enter image ratio', 'g5-ere' ),
								'type'     => 'dimension',
								'required' => array( 'agent_image_size', '=', 'full' ),
							),
						)
					),
					'agent_layout_list_group' => array(
						'id'     => 'agent_layout_list_group',
						'title'  => esc_html__( 'Layout List', 'g5-ere' ),
						'type'   => 'group',
						'fields' => array(
							'agent_list_item_skin'         => array(
								'id'       => 'agent_list_item_skin',
								'title'    => esc_html__( 'List Item Skin', 'g5-ere' ),
								'subtitle' => esc_html__( 'Specify your agent list item skin', 'g5-ere' ),
								'type'     => 'image_set',
								'options'  => G5ERE()->settings()->get_agent_list_skins(),
								'default'  => G5ERE()->options()->get_default( 'agent_list_item_skin', 'skin-list-01' ),
							),
							'agent_list_item_custom_class' => array(
								'id'       => 'agent_list_item_custom_class',
								'title'    => esc_html__( 'List Item Css Classes', 'g5-ere' ),
								'subtitle' => esc_html__( 'Add custom css classes to item', 'g5-ere' ),
								'type'     => 'text',
							),
							'agent_list_image_size'        => array(
								'id'       => 'agent_list_image_size',
								'title'    => esc_html__( 'Image size', 'g5-ere' ),
								'subtitle' => esc_html__( 'Enter your agent image size', 'g5-ere' ),
								'desc'     => esc_html__( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'g5-ere' ),
								'type'     => 'text',
								'default'  => G5ERE()->options()->get_default( 'agent_list_image_size', 'full' ),
							),
							'agent_list_image_ratio'       => array(
								'id'       => 'agent_list_image_ratio',
								'title'    => esc_html__( 'Image Ratio', 'g5-ere' ),
								'subtitle' => esc_html__( 'Enter image ratio', 'g5-ere' ),
								'type'     => 'dimension',
								'required' => array( 'agent_list_image_size', '=', 'full' ),
							),
						)
					),
					'agent_per_page'          => array(
						'id'         => 'agent_per_page',
						'type'       => 'text',
						'input_type' => 'number',
						'title'      => esc_html__( 'Agent per page', 'g5-ere' ),
						'subtitle'   => esc_html__( 'Set number of agent per page', 'g5-ere' ),
						'default'    => '10',
					),
					'agent_sorting'           => array(
						'id'      => 'agent_sorting',
						'title'   => esc_html__( 'Default agent sorting', 'g5-ere' ),
						'type'    => 'select',
						'options' => G5ERE()->settings()->get_agent_sorting(),
						'default' => 'menu_order'
					),
					'agent_paging'            => array(
						'id'       => 'agent_paging',
						'title'    => esc_html__( 'Paging', 'g5-ere' ),
						'subtitle' => esc_html__( 'Specify your paging mode', 'g5-ere' ),
						'type'     => 'select',
						'options'  => G5CORE()->settings()->get_post_paging_mode(),
						'default'  => G5ERE()->options()->get_default( 'agent_paging', 'pagination' ),
					),
					'agent_animation'         => array(
						'id'       => 'agent_animation',
						'title'    => esc_html__( 'Animation', 'g5-ere' ),
						'subtitle' => esc_html__( 'Specify your post animation', 'g5-ere' ),
						'type'     => 'select',
						'options'  => G5CORE()->settings()->get_animation(),
						'default'  => G5ERE()->options()->get_default( 'agent_animation', 'none' )
					)
				)
			);
		}

		public function config_section_agent_single() {
			return array(
				'id'     => 'section_agent_single',
				'title'  => esc_html__( 'Single Agent', 'g5-ere' ),
				'icon'   => 'dashicons dashicons-businessman',
				'fields' => array(
					'single_agent_layout'            => array(
						'id'       => 'single_agent_layout',
						'title'    => esc_html__( 'Layout', 'g5-ere' ),
						'subtitle' => esc_html__( 'Specify your single agent layout', 'g5-ere' ),
						'type'     => 'image_set',
						'options'  => G5ERE()->settings()->get_single_agent_layout(),
						'default'  => G5ERE()->options()->get_default( 'single_agent_layout', 'layout-01' ),
					),
					'single_agent_content'           => array(
						'id'     => 'single_agent_content',
						'title'  => esc_html__( 'Single Agent Content', 'g5-ere' ),
						'type'   => 'group',
						'fields' => array(
							array(
								'id'       => 'single_agent_content_block_style',
								'title'    => esc_html__( 'Content Style', 'g5-ere' ),
								'subtitle' => esc_html__( 'Select the content style', 'g5-ere' ),
								'type'     => 'select',
								'options'  => G5ERE()->settings()->get_single_content_block_style(),
								'default'  => G5ERE()->options()->get_default( 'single_agent_content_block_style', 'style-01' ),
							),
							'single_agent_content_blocks_row' => array(
								'id'     => 'single_agent_content_blocks_row',
								'title'  => esc_html__( 'Content blocks', 'g5-ere' ),
								'type'   => 'row',
								'col'    => 6,
								'fields' => array(
									'single_agent_content_blocks'      => array(
										'id'      => 'single_agent_content_blocks',
										'title'   => esc_html__( 'Content Blocks', 'g5-ere' ),
										'type'    => 'sorter',
										'default' => G5ERE()->settings()->get_single_agent_content_blocks()
									),
									'single_agent_tabs_content_blocks' => array(
										'id'       => 'single_agent_tabs_content_blocks',
										'title'    => esc_html__( 'Tabs Content Blocks', 'g5-ere' ),
										'type'     => 'sorter',
										'required' => array( 'single_agent_content_blocks[enable]', 'contain', 'tabs' ),
										'default'  => G5ERE()->settings()->get_single_agent_tabs_content_blocks(),
									),
								)
							),
							'single_agent_my_property_group'  => $this->config_group_single_agent_my_property(),
							'single_agent_other_agent_group'  => $this->config_group_single_agent_other_agent()
						)
					),
					'single_agent_bottom_bar_mobile' => G5CORE()->fields()->get_config_toggle( array(
						'id'       => 'single_agent_bottom_bar_mobile',
						'title'    => esc_html__( 'Bottom Bar Mobile', 'g5-ere' ),
						'subtitle' => esc_html__( 'Turn On bottom bar', 'g5-ere' ),
						'default'  => G5CORE()->options()->layout()->get_default( 'single_agent_bottom_bar_mobile', 'on' ),
					) ),
					'single_agent_breadcrumb_enable'        => G5CORE()->fields()->get_config_toggle( array(
						'id'       => 'single_agent_breadcrumb_enable',
						'title'    => esc_html__( 'Breadcrumb Enable', 'g5-ere' ),
						'subtitle' => esc_html__( 'Turn Off this option if you want to hide breadcrumb (only show when page title hide)', 'g5-ere' ),
						'default'  => 'on',
					) ),
				)
			);
		}

		public function define_header_advanced_search_options( $configs ) {

			$configs['advanced_search'] = array(
				'id'     => 'section_advanced_search',
				'title'  => esc_html__( 'Advanced Search', 'g5-ere' ),
				'icon'   => 'dashicons dashicons-search',
				'fields' => array(
					'advanced_search_enable' => G5CORE()->fields()->get_config_toggle( array(
						'id'       => 'advanced_search_enable',
						'title'    => esc_html__( 'Advanced Search Enable', 'g5-ere' ),
						'subtitle' => esc_html__( 'Enable or disable advanced search', 'g5-ere' ),
						'default'  => '',
					) ),
					'advanced_search_form'   => array(
						'id'       => 'advanced_search_form',
						'title'    => esc_html__( 'Advanced Search Form', 'g5-ere' ),
						'subtitle' => esc_html__( 'Specify your advanced search form', 'g5-ere' ),
						'desc'     => wp_kses_post( sprintf( __( 'Manager search form at <a href="%s">G5Ere Options</a>', 'g5-ere' ), admin_url( 'admin.php?page=g5ere_options&section=search_forms' ) ) ),
						'type'     => 'select',
						'options'  => G5ERE()->settings()->get_search_forms(),
						'default'  => '',
						'required' => array( 'advanced_search_enable', '=', 'on' )
					),
					'advanced_search_layout' => array(
						'id'       => 'advanced_search_layout',
						'title'    => esc_html__( 'Advanced Search Layout', 'g5-ere' ),
						'type'     => 'select',
						'options'  => G5ERE()->settings()->get_advanced_search_layout(),
						'default'  => 'boxed',
						'required' => array( 'advanced_search_enable', '=', 'on' ),
					),
					'advanced_search_sticky' => array(
						'id'       => 'advanced_search_sticky',
						'title'    => esc_html__( 'Advanced Search Sticky', 'g5-ere' ),
						'subtitle' => esc_html__( 'Enable or disable sticky effect for advanced search.', 'g5-ere' ),
						'type'     => 'button_set',
						'options'  => G5ERE()->settings()->get_advanced_search_sticky(),
						'default'  => '',
						'required' => array( 'advanced_search_enable', '=', 'on' ),
					),

					'advanced_search_css_classes' => array(
						'id'       => 'advanced_search_css_classes',
						'type'     => 'text',
						'title'    => esc_html__( 'Css Classes', 'g5-ere' ),
						'subtitle' => esc_html__( 'Add custom css classes to the search form', 'g5-ere' ),
						'default'  => '',
						'required' => array( 'advanced_search_enable', '=', 'on' ),
					),

					'advanced_search_mobile_info'   => array(
						'id'       => 'advanced_search_mobile_info',
						'title'    => esc_html__( 'Advanced Search Mobile', 'g5-ere' ),
						'type'     => 'info',
						'style'    => 'info',

					),
					'advanced_search_mobile_enable' => G5CORE()->fields()->get_config_toggle( array(
						'id'       => 'advanced_search_mobile_enable',
						'title'    => esc_html__( 'Advanced Search Enable', 'g5-ere' ),
						'subtitle' => esc_html__( 'Enable or disable advanced search', 'g5-ere' ),
						'default'  => '',
					) ),
					'advanced_search_mobile_form'   => array(
						'id'       => 'advanced_search_mobile_form',
						'title'    => esc_html__( 'Advanced Search Form', 'g5-ere' ),
						'subtitle' => esc_html__( 'Specify your advanced search form', 'g5-ere' ),
						'desc'     => wp_kses_post( sprintf( __( 'Manager search form at <a href="%s">G5Ere Options</a>', 'g5-ere' ), admin_url( 'admin.php?page=g5ere_options&section=search_forms' ) ) ),
						'type'     => 'select',
						'options'  => G5ERE()->settings()->get_search_forms(),
						'default'  => '',
						'required' => array( 'advanced_search_mobile_enable', '=', 'on' )
					),
					'advanced_search_mobile_layout' => array(
						'id'       => 'advanced_search_mobile_layout',
						'title'    => esc_html__( 'Advanced Search Layout', 'g5-ere' ),
						'type'     => 'select',
						'options'  => G5ERE()->settings()->get_advanced_search_layout(),
						'default'  => 'boxed',
						'required' => array( 'advanced_search_mobile_enable', '=', 'on' )
					),
					'advanced_search_mobile_sticky' => array(
						'id'       => 'advanced_search_mobile_sticky',
						'title'    => esc_html__( 'Advanced Search Sticky', 'g5-ere' ),
						'subtitle' => esc_html__( 'Enable or disable sticky effect for advanced search.', 'g5-ere' ),
						'type'     => 'button_set',
						'options'  => G5ERE()->settings()->get_advanced_search_sticky(),
						'default'  => '',
						'required' => array( 'advanced_search_mobile_enable', '=', 'on' ),
					),
					'advanced_search_mobile_css_classes' => array(
						'id'       => 'advanced_search_mobile_css_classes',
						'type'     => 'text',
						'title'    => esc_html__( 'Css Classes', 'g5-ere' ),
						'subtitle' => esc_html__( 'Add custom css classes to the search form', 'g5-ere' ),
						'default'  => '',
						'required' => array( 'advanced_search_mobile_enable', '=', 'on' ),
					),
				)
			);

			$config_colors = &g5ere_get_array_by_path( $configs, "section_color/fields" );

			$config_colors['advanced_search_group'] = array(
				'id'             => 'advanced_search_group',
				'title'          => esc_html__( 'Advanced Search', 'g5-ere' ),
				'type'           => 'group',
				'toggle_default' => false,
				'fields'         => array(
					'advanced_search_background_color' => array(
						'id'       => 'advanced_search_background_color',
						'title'    => esc_html__( 'Background Color', 'g5-ere' ),
						'subtitle' => esc_html__( 'Specify the advanced search background color', 'g5-ere' ),
						'type'     => 'color',
						'alpha'    => true,
						'default'  => G5CORE()->options()->header()->get_default( 'advanced_search_background_color' ),
					),
					'advanced_search_text_color'       => array(
						'id'       => 'advanced_search_text_color',
						'title'    => esc_html__( 'Text Color', 'g5-ere' ),
						'subtitle' => esc_html__( 'Specify the advanced search text color', 'g5-ere' ),
						'type'     => 'color',
						'alpha'    => true,
						'default'  => G5CORE()->options()->header()->get_default( 'advanced_search_text_color' ),
					),
					'advanced_search_text_hover_color' => array(
						'id'       => 'advanced_search_text_hover_color',
						'title'    => esc_html__( 'Text Hover Color', 'g5-ere' ),
						'subtitle' => esc_html__( 'Specify the advanced search text hover color', 'g5-ere' ),
						'type'     => 'color',
						'alpha'    => true,
						'default'  => G5CORE()->options()->header()->get_default( 'advanced_search_text_hover_color' ),
					),

					'advanced_search_form_fields_info'            => array(
						'id'    => 'advanced_search_form_fields_info',
						'title' => esc_html__( 'Form Fields', 'g5-ere' ),
						'type'  => 'info',
						'style' => 'info'
					),
					'advanced_search_form_field_background_color' => array(
						'id'       => 'advanced_search_form_field_background_color',
						'title'    => esc_html__( 'Background Color', 'g5-ere' ),
						'subtitle' => esc_html__( 'Specify the advanced search form field background color', 'g5-ere' ),
						'type'     => 'color',
						'alpha'    => true,
						'default'  => G5CORE()->options()->header()->get_default( 'advanced_search_form_field_background_color' ),
					),
					'advanced_search_form_field_text_color'       => array(
						'id'       => 'advanced_search_form_field_text_color',
						'title'    => esc_html__( 'Text Color', 'g5-ere' ),
						'subtitle' => esc_html__( 'Specify the advanced search form field text color', 'g5-ere' ),
						'type'     => 'color',
						'alpha'    => true,
						'default'  => G5CORE()->options()->header()->get_default( 'advanced_search_form_field_text_color' ),
					),

					'advanced_search_form_field_placeholder_text_color' => array(
						'id'       => 'advanced_search_form_field_placeholder_text_color',
						'title'    => esc_html__( 'Placeholder Text Color', 'g5-ere' ),
						'subtitle' => esc_html__( 'Specify the advanced search form field placeholder text color', 'g5-ere' ),
						'type'     => 'color',
						'alpha'    => true,
						'default'  => G5CORE()->options()->header()->get_default( 'advanced_search_form_field_placeholder_text_color' ),
					),

					'advanced_search_form_field_border_color' => array(
						'id'       => 'advanced_search_form_field_border_color',
						'title'    => esc_html__( 'Border Color', 'g5-ere' ),
						'subtitle' => esc_html__( 'Specify the advanced search form field border color', 'g5-ere' ),
						'type'     => 'color',
						'alpha'    => true,
						'default'  => G5CORE()->options()->header()->get_default( 'advanced_search_form_field_border_color' ),
					),

				)
			);

			$config_colors['advanced_search_mobile_group'] = array(
				'id'             => 'advanced_search_mobile_group',
				'title'          => esc_html__( 'Advanced Search Moblie', 'g5-ere' ),
				'type'           => 'group',
				'toggle_default' => false,
				'fields'         => array(
					'advanced_search_mobile_background_color' => array(
						'id'       => 'advanced_search_mobile_background_color',
						'title'    => esc_html__( 'Background Color', 'g5-ere' ),
						'subtitle' => esc_html__( 'Specify the advanced search background color', 'g5-ere' ),
						'type'     => 'color',
						'alpha'    => true,
						'default'  => G5CORE()->options()->header()->get_default( 'advanced_search_mobile_background_color' ),
					),
					'advanced_search_mobile_text_color'       => array(
						'id'       => 'advanced_search_mobile_text_color',
						'title'    => esc_html__( 'Text Color', 'g5-ere' ),
						'subtitle' => esc_html__( 'Specify the advanced search text color', 'g5-ere' ),
						'type'     => 'color',
						'alpha'    => true,
						'default'  => G5CORE()->options()->header()->get_default( 'advanced_search_mobile_text_color' ),
					),
					'advanced_search_mobile_text_hover_color' => array(
						'id'       => 'advanced_search_mobile_text_hover_color',
						'title'    => esc_html__( 'Text Hover Color', 'g5-ere' ),
						'subtitle' => esc_html__( 'Specify the advanced search text hover color', 'g5-ere' ),
						'type'     => 'color',
						'alpha'    => true,
						'default'  => G5CORE()->options()->header()->get_default( 'advanced_search_mobile_text_hover_color' ),
					),

					'advanced_search_mobile_form_fields_info'            => array(
						'id'    => 'advanced_search_mobile_form_fields_info',
						'title' => esc_html__( 'Form Fields', 'g5-ere' ),
						'type'  => 'info',
						'style' => 'info'
					),
					'advanced_search_mobile_form_field_background_color' => array(
						'id'       => 'advanced_search_mobile_form_field_background_color',
						'title'    => esc_html__( 'Background Color', 'g5-ere' ),
						'subtitle' => esc_html__( 'Specify the advanced search form field background color', 'g5-ere' ),
						'type'     => 'color',
						'alpha'    => true,
						'default'  => G5CORE()->options()->header()->get_default( 'advanced_search_mobile_form_field_background_color' ),
					),
					'advanced_search_mobile_form_field_text_color'       => array(
						'id'       => 'advanced_search_mobile_form_field_text_color',
						'title'    => esc_html__( 'Text Color', 'g5-ere' ),
						'subtitle' => esc_html__( 'Specify the advanced search form field text color', 'g5-ere' ),
						'type'     => 'color',
						'alpha'    => true,
						'default'  => G5CORE()->options()->header()->get_default( 'advanced_search_mobile_form_field_text_color' ),
					),

					'advanced_search_mobile_form_field_placeholder_text_color' => array(
						'id'       => 'advanced_search_mobile_form_field_placeholder_text_color',
						'title'    => esc_html__( 'Placeholder Text Color', 'g5-ere' ),
						'subtitle' => esc_html__( 'Specify the advanced search form field placeholder text color', 'g5-ere' ),
						'type'     => 'color',
						'alpha'    => true,
						'default'  => G5CORE()->options()->header()->get_default( 'advanced_search_mobile_form_field_placeholder_text_color' ),
					),

					'advanced_search_mobile_form_field_border_color' => array(
						'id'       => 'advanced_search_mobile_form_field_border_color',
						'title'    => esc_html__( 'Border Color', 'g5-ere' ),
						'subtitle' => esc_html__( 'Specify the advanced search form field border color', 'g5-ere' ),
						'type'     => 'color',
						'alpha'    => true,
						'default'  => G5CORE()->options()->header()->get_default( 'advanced_search_mobile_form_field_border_color' ),
					),

				)
			);

			return $configs;
		}

		public function change_header_sticky_setting() {
			$advanced_search_enable = G5CORE()->options()->header()->get_option( 'advanced_search_enable' );
			if ( $advanced_search_enable === 'on' ) {
				$advanced_search_sticky = G5CORE()->options()->header()->get_option( 'advanced_search_sticky' );
				if ( $advanced_search_sticky !== '' ) {
					G5CORE()->options()->header()->set_option( 'header_sticky', '' );
					$advanced_search_mobile_enable = G5CORE()->options()->header()->get_option( 'advanced_search_mobile_enable' );
					if ( $advanced_search_mobile_enable === 'on' ) {
						$advanced_search_mobile_sticky = G5CORE()->options()->header()->get_option( 'advanced_search_mobile_sticky' );
						if ( $advanced_search_mobile_sticky !== '' ) {
							G5CORE()->options()->header()->set_option( 'mobile_header_sticky', '' );
						}
					}

				}
			}

		}

		public function define_header_advanced_default_options( $default_options ) {
			return wp_parse_args( array(
				'advanced_search_background_color' => '#fff',
				'advanced_search_text_color'       => '#777',
				'advanced_search_text_hover_color' => '#0073aa',

				'advanced_search_form_field_background_color'       => '#fff',
				'advanced_search_form_field_text_color'             => '#777',
				'advanced_search_form_field_placeholder_text_color' => '#ababab',
				'advanced_search_form_field_border_color'           => '#eee',


				'advanced_search_mobile_background_color' => '#fff',
				'advanced_search_mobile_text_color'       => '#777',
				'advanced_search_mobile_text_hover_color' => '#0073aa',

				'advanced_search_mobile_form_field_background_color'       => '#fff',
				'advanced_search_mobile_form_field_text_color'             => '#777',
				'advanced_search_mobile_form_field_placeholder_text_color' => '#ababab',
				'advanced_search_mobile_form_field_border_color'           => '#eee',

			), $default_options );
		}

		public function config_section_agency_listing() {
			return array(
				'id'     => 'section_agency_listing',
				'title'  => esc_html__( 'Agency Listing', 'g5-ere' ),
				'icon'   => 'dashicons dashicons-category',
				'fields' => array(
					'agency_toolbar_group'     => array(
						'id'     => 'agency_toolbar_group',
						'title'  => esc_html__( 'Toolbar', 'g5-ere' ),
						'type'   => 'group',
						'fields' => array(
							'agency_toolbar_layout' => array(
								'id'       => 'agency_toolbar_layout',
								'title'    => esc_html__( 'ToolBar Layout', 'g5-ere' ),
								'subtitle' => esc_html__( 'Specify your tool bar layout', 'g5-ere' ),
								'type'     => 'select',
								'options'  => array(
									'boxed'             => esc_html__( 'Boxed Content', 'g5-ere' ),
									'stretched'         => esc_html__( 'Stretched row', 'g5-ere' ),
									'stretched_content' => esc_html__( 'Stretched row and content', 'g5-ere' ),
								),
								'default'  => G5ERE()->options()->get_default( 'agency_toolbar_layout', 'boxed' ),
							),
							'agency_toolbar'        => array(
								'id'      => 'agency_toolbar',
								'title'   => esc_html__( 'ToolBar', 'g5-ere' ),
								'type'    => 'sorter',
								'default' => G5ERE()->options()->get_default( 'agency_toolbar', array(
									'left'    => array(
										'result_count' => esc_html__( 'Result Count', 'g5-ere' )
									),
									'right'   => array(
										'ordering'      => esc_html__( 'Ordering', 'g5-ere' ),
										'switch_layout' => esc_html__( 'Switch Layout', 'g5-ere' ),
									),
									'disable' => array()
								) ),
							),
							'agency_toolbar_mobile' => array(
								'id'      => 'agency_toolbar_mobile',
								'title'   => esc_html__( 'ToolBar Mobile', 'g5-ere' ),
								'type'    => 'sorter',
								'default' => G5ERE()->options()->get_default( 'agency_toolbar_mobile', array(
									'left'    => array(
										'result_count' => esc_html__( 'Result Count', 'g5-ere' )
									),
									'right'   => array(
										'ordering' => esc_html__( 'Ordering', 'g5-ere' ),
									),
									'disable' => array(
										'switch_layout' => esc_html__( 'Switch Layout', 'g5-ere' ),
									)
								) ),
							),
						)
					),
					'agency_layout'            => array(
						'id'      => 'agency_layout',
						'title'   => esc_html__( 'Agency Layout', 'g5-ere' ),
						'type'    => 'image_set',
						'options' => G5ERE()->settings()->get_agency_layout(),
						'default' => 'grid'
					),
					'agency_layout_grid_group' => array(
						'id'     => 'agency_layout_grid_group',
						'title'  => esc_html__( 'Layout Grid', 'g5-ere' ),
						'type'   => 'group',
						'fields' => array(
							'agency_item_skin'         => array(
								'id'       => 'agency_item_skin',
								'title'    => esc_html__( 'Item Skin', 'g5-ere' ),
								'subtitle' => esc_html__( 'Specify your agency item skin', 'g5-ere' ),
								'type'     => 'image_set',
								'options'  => G5ERE()->settings()->get_agency_skins(),
								'default'  => G5ERE()->options()->get_default( 'item_skin', 'skin-01' ),
							),
							'agency_item_custom_class' => array(
								'id'       => 'agency_item_custom_class',
								'title'    => esc_html__( 'Item Css Classes', 'g5-ere' ),
								'subtitle' => esc_html__( 'Add custom css classes to item', 'g5-ere' ),
								'type'     => 'text'
							),
							'agency_columns_gutter'    => array(
								'id'       => 'agency_columns_gutter',
								'title'    => esc_html__( 'Columns Gutter', 'g5-ere' ),
								'subtitle' => esc_html__( 'Specify your horizontal space between agency.', 'g5-ere' ),
								'type'     => 'select',
								'options'  => G5CORE()->settings()->get_post_columns_gutter(),
								'default'  => G5ERE()->options()->get_default( 'post_columns_gutter', '30' ),
							),
							'agency_columns_group'     => array(
								'id'     => 'agency_columns_group',
								'title'  => esc_html__( 'Agency Columns', 'g5-ere' ),
								'type'   => 'group',
								'fields' => array(
									'agency_columns_row_1' => array(
										'id'     => 'agency_columns_row_1',
										'type'   => 'row',
										'col'    => 3,
										'fields' => array(
											'agency_columns_xl' => array(
												'id'      => 'agency_columns_xl',
												'title'   => esc_html__( 'Extra Large Devices', 'g5-ere' ),
												'desc'    => esc_html__( 'Specify your agency columns on extra large devices (>= 1200px)', 'g5-ere' ),
												'type'    => 'select',
												'options' => G5CORE()->settings()->get_post_columns(),
												'default' => G5ERE()->options()->get_default( 'agency_columns_xl', '2' ),
												'layout'  => 'full',
											),
											'agency_columns_lg' => array(
												'id'      => 'agency_columns_lg',
												'title'   => esc_html__( 'Large Devices', 'g5-ere' ),
												'desc'    => esc_html__( 'Specify your agency columns on large devices (>= 992px)', 'g5-ere' ),
												'type'    => 'select',
												'options' => G5CORE()->settings()->get_post_columns(),
												'default' => G5ERE()->options()->get_default( 'agency_columns_lg', '2' ),
												'layout'  => 'full',
											),
											'agency_columns_md' => array(
												'id'      => 'agency_columns_md',
												'title'   => esc_html__( 'Medium Devices', 'g5-ere' ),
												'desc'    => esc_html__( 'Specify your agency columns on medium devices (>= 768px)', 'g5-ere' ),
												'type'    => 'select',
												'options' => G5CORE()->settings()->get_post_columns(),
												'default' => G5ERE()->options()->get_default( 'agency_columns_md', '2' ),
												'layout'  => 'full',
											),
										)
									),
									'agency_columns_row_2' => array(
										'id'     => 'agency_columns_row_2',
										'type'   => 'row',
										'col'    => 3,
										'fields' => array(
											'agency_columns_sm' => array(
												'id'      => 'agency_columns_sm',
												'title'   => esc_html__( 'Small Devices', 'g5-ere' ),
												'desc'    => esc_html__( 'Specify your agency columns on small devices (< 768px)', 'g5-ere' ),
												'type'    => 'select',
												'options' => G5CORE()->settings()->get_post_columns(),
												'default' => G5ERE()->options()->get_default( 'agency_columns_sm', '2' ),
												'layout'  => 'full',
											),
											'agency_columns'    => array(
												'id'      => 'agency_columns',
												'title'   => esc_html__( 'Extra Small Devices', 'g5-ere' ),
												'desc'    => esc_html__( 'Specify your agency columns on extra small devices (< 576px)', 'g5-ere' ),
												'type'    => 'select',
												'options' => G5CORE()->settings()->get_post_columns(),
												'default' => G5ERE()->options()->get_default( 'agency_columns', '1' ),
												'layout'  => 'full',
											)
										)
									)
								)
							),
							'agency_image_size'        => array(
								'id'       => 'agency_image_size',
								'title'    => esc_html__( 'Image size', 'g5-ere' ),
								'subtitle' => esc_html__( 'Enter your agent image size', 'g5-ere' ),
								'desc'     => esc_html__( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'g5-ere' ),
								'type'     => 'text',
								'default'  => G5ERE()->options()->get_default( 'agency_image_size', 'full' ),
							),
							'agency_image_ratio'       => array(
								'id'       => 'agency_image_ratio',
								'title'    => esc_html__( 'Image Ratio', 'g5-ere' ),
								'subtitle' => esc_html__( 'Enter image ratio', 'g5-ere' ),
								'type'     => 'dimension',
								'required' => array(
									array( 'agency_image_size', '=', 'full' ),
								)
							),
						)
					),
					'agency_layout_list_group' => array(
						'id'     => 'agency_layout_list_group',
						'title'  => esc_html__( 'Layout List', 'g5-ere' ),
						'type'   => 'group',
						'fields' => array(
							'agency_list_item_skin'         => array(
								'id'       => 'agency_list_item_skin',
								'title'    => esc_html__( 'List Item Skin', 'g5-ere' ),
								'subtitle' => esc_html__( 'Specify your agency list item skin', 'g5-ere' ),
								'type'     => 'image_set',
								'options'  => G5ERE()->settings()->get_agency_list_skins(),
								'default'  => G5ERE()->options()->get_default( 'agency_list_item_skin', 'skin-list-01' ),
							),
							'agency_list_item_custom_class' => array(
								'id'       => 'agent_list_item_custom_class',
								'title'    => esc_html__( 'List Item Css Classes', 'g5-ere' ),
								'subtitle' => esc_html__( 'Add custom css classes to item', 'g5-ere' ),
								'type'     => 'text',
							),
							'agency_list_image_size'        => array(
								'id'       => 'agent_list_image_size',
								'title'    => esc_html__( 'Image size', 'g5-ere' ),
								'subtitle' => esc_html__( 'Enter your agent image size', 'g5-ere' ),
								'desc'     => esc_html__( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'g5-ere' ),
								'type'     => 'text',
								'default'  => G5ERE()->options()->get_default( 'agency_list_image_size', 'full' ),
							),
							'agency_list_image_ratio'       => array(
								'id'       => 'agency_list_image_ratio',
								'title'    => esc_html__( 'Image Ratio', 'g5-ere' ),
								'subtitle' => esc_html__( 'Enter image ratio', 'g5-ere' ),
								'type'     => 'dimension',
								'required' => array(
									array( 'agency_list_image_size', '=', 'full' ),
								)
							),
						)
					),
					'agency_per_page'          => array(
						'id'         => 'agency_per_page',
						'type'       => 'text',
						'input_type' => 'number',
						'title'      => esc_html__( 'Agency per page', 'g5-ere' ),
						'subtitle'   => esc_html__( 'Set number of Agency per page', 'g5-ere' ),
						'default'    => '',
					),
					'agency_sorting'           => array(
						'id'      => 'agency_sorting',
						'title'   => esc_html__( 'Default Agency sorting', 'g5-ere' ),
						'type'    => 'select',
						'options' => G5ERE()->settings()->get_agency_sorting(),
						'default' => 'menu_order'
					),
					'agency_paging'            => array(
						'id'       => 'agency_paging',
						'title'    => esc_html__( 'Paging', 'g5-ere' ),
						'subtitle' => esc_html__( 'Specify your paging mode', 'g5-ere' ),
						'type'     => 'select',
						'options'  => G5CORE()->settings()->get_post_paging_mode(),
						'default'  => G5ERE()->options()->get_default( 'agency_paging', 'pagination' ),
					),
					'agency_animation'         => array(
						'id'       => 'agency_animation',
						'title'    => esc_html__( 'Animation', 'g5-ere' ),
						'subtitle' => esc_html__( 'Specify your post animation', 'g5-ere' ),
						'type'     => 'select',
						'options'  => G5CORE()->settings()->get_animation(),
						'default'  => G5ERE()->options()->get_default( 'agency_animation', 'none' )
					),

				)
			);
		}

		public function config_section_agency_single() {
			return array(
				'id'     => 'section_agency_single',
				'title'  => esc_html__( 'Single Agency', 'g5-ere' ),
				'icon'   => 'dashicons dashicons-building',
				'fields' => array(
					'single_agency_layout'                 => array(
						'id'       => 'single_agency_layout',
						'title'    => esc_html__( 'Layout', 'g5-ere' ),
						'subtitle' => esc_html__( 'Specify your single agency layout', 'g5-ere' ),
						'type'     => 'image_set',
						'options'  => G5ERE()->settings()->get_single_agency_layout(),
						'default'  => G5ERE()->options()->get_default( 'single_agency_layout', 'layout-1' ),
					),
					'single_agency_content_group' => $this->config_group_agency_single_content(),
					'single_agency_bottom_bar_mobile'      => G5CORE()->fields()->get_config_toggle( array(
						'id'       => 'single_agency_bottom_bar_mobile',
						'title'    => esc_html__( 'Bottom Bar Mobile', 'g5-ere' ),
						'subtitle' => esc_html__( 'Turn On bottom bar', 'g5-ere' ),
						'default'  => G5CORE()->options()->layout()->get_default( 'single_agency_bottom_bar_mobile', 'on' ),
					) ),
					'single_agency_breadcrumb_enable'        => G5CORE()->fields()->get_config_toggle( array(
						'id'       => 'single_agency_breadcrumb_enable',
						'title'    => esc_html__( 'Breadcrumb Enable', 'g5-ere' ),
						'subtitle' => esc_html__( 'Turn Off this option if you want to hide breadcrumb (only show when page title hide)', 'g5-ere' ),
						'default'  => 'on',
					) ),
				)
			);
		}

		public function config_group_agency_single_content() {
			return array(
				'id'     => 'single_agency_content_group',
				'title'  => esc_html__( 'Agency Content', 'g5-ere' ),
				'type'   => 'group',
				'fields' => array(
					'single_agency_content_block_style' => array(
						'id'       => 'single_agency_content_block_style',
						'title'    => esc_html__( 'Content Style', 'g5-ere' ),
						'subtitle' => esc_html__( 'Select the content style', 'g5-ere' ),
						'type'     => 'select',
						'options'  => G5ERE()->settings()->get_single_content_block_style(),
						'default'  => G5ERE()->options()->get_default( 'single_agency_content_block_style', 'style-01' ),
					),

					'single_agency_content_blocks_row'         => array(
						'id'       => 'single_agency_content_blocks_row',
						'title'    => esc_html__( 'Content blocks', 'g5-ere' ),
						'type'     => 'row',
						'col'      => 6,
						'fields'   => array(
							'single_agency_content_blocks'      => array(
								'id'      => 'single_agency_content_blocks',
								'title'   => esc_html__( 'Content Blocks', 'g5-ere' ),
								'type'    => 'sorter',
								'default' => G5ERE()->settings()->get_single_agency_content_blocks()
							),
							'single_agency_tabs_content_blocks' => array(
								'id'       => 'single_agency_tabs_content_blocks',
								'title'    => esc_html__( 'Tabs Content Blocks', 'g5-ere' ),
								'type'     => 'sorter',
								'required' => array( 'single_agency_content_blocks[enable]', 'contain', 'tabs' ),
								'default'  => G5ERE()->settings()->get_single_agency_tabs_content_blocks(),
							),
						)
					),
					'single_agency_property_listing'    => $this->config_section_property_single_agency(),
					'single_agency_agent_listing'       => $this->config_section_agent_single_agency(),

				)
			);
		}

		public function config_section_property_single_agency() {
			return array(
				'id'       => 'single_agency_property_listing',
				'title'    => esc_html__( 'Property Listing', 'g5-ere' ),
				'type'     => 'group',
				'toggle_default' => false,
				'fields'   => array(
					'single_agency_property_taxonomy_filter_enable' => G5CORE()->fields()->get_config_toggle( array(
						'id'       => 'single_agency_property_taxonomy_filter_enable',
						'title'    => esc_html__( 'Taxonomy Filter Enable', 'g5-ere' ),
						'subtitle' => esc_html__( 'Turn On this option if you want to enable taxonomy filter', 'g5-ere' ),
						'default'  => G5ERE()->options()->get_default( 'single_agency_property_taxonomy_filter_enable', '' ),
					) ),
					'single_agency_property_taxonomy_filter'        => array(
						'id'       => 'single_agency_property_taxonomy_filter',
						'title'    => esc_html__( 'Taxonomy Filter', 'g5-ere' ),
						'type'     => 'select',
						'options'  => G5ERE()->settings()->get_property_taxonomy_filter(),
						'default'  => 'property-status',
						'required' => array( 'single_agency_property_taxonomy_filter_enable', '=', 'on' )
					),
					'single_agency_property_layout'       => array(
						'id'      => 'single_agency_property_layout',
						'title'   => esc_html__( 'Property Layout', 'g5-ere' ),
						'type'    => 'image_set',
						'options' => G5ERE()->settings()->get_property_layout(),
						'default' => 'grid'
					),
					'single_agency_property_layout_grid_group' => array(
						'id'       => 'single_agency_property_layout_grid_group',
						'title'    => esc_html__( 'Layout Grid', 'g5-ere' ),
						'type'     => 'group',
						'required' => array( 'single_agency_property_layout', '=', 'grid' ),
						'fields'   => array(
							'single_agency_property_item_skin'           => array(
								'id'       => 'single_agency_property_item_skin',
								'title'    => esc_html__( 'Item Skin', 'g5-ere' ),
								'subtitle' => esc_html__( 'Specify your property item skin', 'g5-ere' ),
								'type'     => 'image_set',
								'options'  => G5ERE()->settings()->get_property_skins(),
								'default'  => G5ERE()->options()->get_default( 'single_agency_property_item_skin', 'skin-01' ),
							),
							'single_agency_property_item_custom_class'   => array(
								'id'       => 'single_agency_property_item_custom_class',
								'title'    => esc_html__( 'Item Css Classes', 'g5-ere' ),
								'subtitle' => esc_html__( 'Add custom css classes to item', 'g5-ere' ),
								'type'     => 'text'
							),
							'single_agency_property_columns_gutter' => array(
								'id'       => 'single_agency_property_columns_gutter',
								'title'    => esc_html__( 'Columns Gutter', 'g5-ere' ),
								'subtitle' => esc_html__( 'Specify your horizontal space between property.', 'g5-ere' ),
								'type'     => 'select',
								'options'  => G5CORE()->settings()->get_post_columns_gutter(),
								'default'  => G5ERE()->options()->get_default( 'single_agency_property_columns_gutter', '30' ),
							),
							'single_agency_property_columns_group'  => array(
								'id'     => 'single_agency_property_columns_group',
								'title'  => esc_html__( 'Property Columns', 'g5-ere' ),
								'type'   => 'group',
								'fields' => array(
									'single_agency_property_columns_row_1' => array(
										'id'     => 'single_agency_property_columns_row_1',
										'type'   => 'row',
										'col'    => 3,
										'fields' => array(
											'single_agency_property_columns_xl' => array(
												'id'      => 'single_agency_property_columns_xl',
												'title'   => esc_html__( 'Extra Large Devices', 'g5-ere' ),
												'desc'    => esc_html__( 'Specify your property columns on extra large devices (>= 1200px)', 'g5-ere' ),
												'type'    => 'select',
												'options' => G5CORE()->settings()->get_post_columns(),
												'default' => G5ERE()->options()->get_default( 'single_agency_property_columns_xl', '3' ),
												'layout'  => 'full',
											),
											'single_agency_property_columns_lg' => array(
												'id'      => 'single_agency_property_columns_lg',
												'title'   => esc_html__( 'Large Devices', 'g5-ere' ),
												'desc'    => esc_html__( 'Specify your property columns on large devices (>= 992px)', 'g5-ere' ),
												'type'    => 'select',
												'options' => G5CORE()->settings()->get_post_columns(),
												'default' => G5ERE()->options()->get_default( 'single_agency_property_columns_lg', '3' ),
												'layout'  => 'full',
											),
											'single_agency_property_columns_md' => array(
												'id'      => 'single_agency_property_columns_md',
												'title'   => esc_html__( 'Medium Devices', 'g5-ere' ),
												'desc'    => esc_html__( 'Specify your property columns on medium devices (>= 768px)', 'g5-ere' ),
												'type'    => 'select',
												'options' => G5CORE()->settings()->get_post_columns(),
												'default' => G5ERE()->options()->get_default( 'single_agency_property_columns_md', '2' ),
												'layout'  => 'full',
											),
										)
									),
									'single_agency_property_columns_row_2' => array(
										'id'     => 'single_agency_property_columns_row_2',
										'type'   => 'row',
										'col'    => 3,
										'fields' => array(
											'single_agency_property_columns_sm' => array(
												'id'      => 'single_agency_property_columns_sm',
												'title'   => esc_html__( 'Small Devices', 'g5-ere' ),
												'desc'    => esc_html__( 'Specify your property columns on small devices (< 768px)', 'g5-ere' ),
												'type'    => 'select',
												'options' => G5CORE()->settings()->get_post_columns(),
												'default' => G5ERE()->options()->get_default( 'single_agency_property_columns_sm', '2' ),
												'layout'  => 'full',
											),
											'single_agency_property_columns'    => array(
												'id'      => 'single_agency_property_columns',
												'title'   => esc_html__( 'Extra Small Devices', 'g5-ere' ),
												'desc'    => esc_html__( 'Specify your property columns on extra small devices (< 576px)', 'g5-ere' ),
												'type'    => 'select',
												'options' => G5CORE()->settings()->get_post_columns(),
												'default' => G5ERE()->options()->get_default( 'single_agency_property_columns', '1' ),
												'layout'  => 'full',
											)
										)
									)
								)
							),
							'single_agency_property_image_size'     => array(
								'id'       => 'single_agency_property_image_size',
								'title'    => esc_html__( 'Image size', 'g5-ere' ),
								'subtitle' => esc_html__( 'Enter your property image size', 'g5-ere' ),
								'desc'     => esc_html__( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'g5-ere' ),
								'type'     => 'text',
								'default'  => G5ERE()->options()->get_default( 'single_agency_property_image_size', 'full' ),
							),
							'single_agency_property_image_ratio'    => array(
								'id'       => 'single_agency_property_image_ratio',
								'title'    => esc_html__( 'Image Ratio', 'g5-ere' ),
								'subtitle' => esc_html__( 'Enter image ratio', 'g5-ere' ),
								'type'     => 'dimension',
								'required' => array(
									array( 'single_agency_property_image_size', '=', 'full' ),
								)
							),
						)
					),
					'single_agency_property_layout_list_group' => array(
						'id'       => 'single_agency_property_layout_list_group',
						'title'    => esc_html__( 'Layout List', 'g5-ere' ),
						'type'     => 'group',
						'required' => array( 'single_agency_property_layout', '=', 'list' ),
						'fields'   => array(
							'single_agency_property_list_item_skin'         => array(
								'id'       => 'single_agency_property_list_item_skin',
								'title'    => esc_html__( 'List Item Skin', 'g5-ere' ),
								'subtitle' => esc_html__( 'Specify your property list item skin', 'g5-ere' ),
								'type'     => 'image_set',
								'options'  => G5ERE()->settings()->get_property_list_skins(),
								'default'  => G5ERE()->options()->get_default( 'single_agency_property_list_item_skin', 'skin-list-01' ),
							),
							'single_agency_property_list_item_custom_class' => array(
								'id'       => 'single_agency_property_list_item_custom_class',
								'title'    => esc_html__( 'List Item Css Classes', 'g5-ere' ),
								'subtitle' => esc_html__( 'Add custom css classes to item', 'g5-ere' ),
								'type'     => 'text',
							),
							'single_agency_property_list_image_size'   => array(
								'id'       => 'single_agency_property_list_image_size',
								'title'    => esc_html__( 'Image size', 'g5-ere' ),
								'subtitle' => esc_html__( 'Enter your property image size', 'g5-ere' ),
								'desc'     => esc_html__( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'g5-ere' ),
								'type'     => 'text',
								'default'  => G5ERE()->options()->get_default( 'single_agency_property_list_image_size', 'full' ),
							),
							'single_agency_property_list_image_ratio'  => array(
								'id'       => 'single_agency_property_list_image_ratio',
								'title'    => esc_html__( 'Image Ratio', 'g5-ere' ),
								'subtitle' => esc_html__( 'Enter image ratio', 'g5-ere' ),
								'type'     => 'dimension',
								'required' =>array( 'single_agency_property_list_image_size', '=', 'full' ),
							),
						)
					),
					'single_agency_property_per_page' => array(
						'id'         => 'single_agency_property_per_page',
						'type'       => 'text',
						'input_type' => 'number',
						'title'      => esc_html__( 'Property per page', 'g5-ere' ),
						'subtitle'   => esc_html__( 'Set number of property per page', 'g5-ere' ),
						'default'    => '9',
					),
					'single_agency_property_sorting'  => array(
						'id'      => 'single_agency_property_sorting',
						'title'   => esc_html__( 'Default property sorting', 'g5-ere' ),
						'type'    => 'select',
						'options' => G5ERE()->settings()->get_property_sorting(),
						'default' => 'menu_order'
					),
					'single_agency_property_paging'       => array(
						'id'       => 'single_agency_property_paging',
						'title'    => esc_html__( 'Paging', 'g5-ere' ),
						'subtitle' => esc_html__( 'Specify your paging mode', 'g5-ere' ),
						'type'     => 'select',
						'options'  => G5CORE()->settings()->get_post_paging_small_mode(),
						'default'  => G5ERE()->options()->get_default( 'single_agency_property_paging', 'pagination-ajax' ),
					),
					'single_agency_property_animation'    => array(
						'id'       => 'single_agency_property_animation',
						'title'    => esc_html__( 'Animation', 'g5-ere' ),
						'subtitle' => esc_html__( 'Specify your post animation', 'g5-ere' ),
						'type'     => 'select',
						'options'  => G5CORE()->settings()->get_animation(),
						'default'  => G5ERE()->options()->get_default( 'single_agency_property_animation', 'none' )
					),
				)
			);
		}

		public function config_section_agent_single_agency() {
			return array(
				'id'       => 'single_agency_agent_listing',
				'title'    => esc_html__( 'Agent Listing', 'g5-ere' ),
				'type'     => 'group',
				'toggle_default' => false,
				'fields'   => array(
					'single_agency_agent_layout'            => array(
						'id'      => 'single_agency_agent_layout',
						'title'   => esc_html__( 'Agent Layout', 'g5-ere' ),
						'type'    => 'image_set',
						'options' => G5ERE()->settings()->get_agent_layout(),
						'default' => 'grid'
					),
					'single_agency_agent_layout_grid_group' => array(
						'id'       => 'single_agency_agent_layout_grid_group',
						'title'    => esc_html__( 'Layout Grid', 'g5-ere' ),
						'type'     => 'group',
						'required' => array( 'single_agency_agent_layout', '=', 'grid' ),
						'fields'   => array(
							'single_agency_agent_item_skin'         => array(
								'id'       => 'single_agency_agent_item_skin',
								'title'    => esc_html__( 'Item Skin', 'g5-ere' ),
								'subtitle' => esc_html__( 'Specify your agent item skin', 'g5-ere' ),
								'type'     => 'image_set',
								'options'  => G5ERE()->settings()->get_agent_skins(),
								'default'  => G5ERE()->options()->get_default( 'single_agency_agent_item_skin', 'skin-01' ),
							),
							'single_agency_agent_item_custom_class' => array(
								'id'       => 'single_agency_agent_item_custom_class',
								'title'    => esc_html__( 'Item Css Classes', 'g5-ere' ),
								'subtitle' => esc_html__( 'Add custom css classes to item', 'g5-ere' ),
								'type'     => 'text'
							),
							'single_agency_agent_columns_gutter'    => array(
								'id'       => 'single_agency_agent_columns_gutter',
								'title'    => esc_html__( 'Columns Gutter', 'g5-ere' ),
								'subtitle' => esc_html__( 'Specify your horizontal space between agent.', 'g5-ere' ),
								'type'     => 'select',
								'options'  => G5CORE()->settings()->get_post_columns_gutter(),
								'default'  => G5ERE()->options()->get_default( 'single_agency_agent_columns_gutter', '30' ),
							),
							'single_agency_agent_columns_group'     => array(
								'id'     => 'single_agency_agent_columns_group',
								'title'  => esc_html__( 'Agent Columns', 'g5-ere' ),
								'type'   => 'group',
								'fields' => array(
									'single_agency_agent_columns_row_1'  => array(
										'id'     => 'single_agency_agent_columns_row_1',
										'type'   => 'row',
										'col'    => 3,
										'fields' => array(
											'single_agency_agent_columns_xl' => array(
												'id'      => 'single_agency_agent_columns_xl',
												'title'   => esc_html__( 'Extra Large Devices', 'g5-ere' ),
												'desc'    => esc_html__( 'Specify your agent columns on extra large devices (>= 1200px)', 'g5-ere' ),
												'type'    => 'select',
												'options' => G5CORE()->settings()->get_post_columns(),
												'default' => G5ERE()->options()->get_default( 'agent_columns_xl', '3' ),
												'layout'  => 'full',
											),
											'single_agency_agent_columns_lg' => array(
												'id'      => 'single_agency_agent_columns_lg',
												'title'   => esc_html__( 'Large Devices', 'g5-ere' ),
												'desc'    => esc_html__( 'Specify your agent columns on large devices (>= 992px)', 'g5-ere' ),
												'type'    => 'select',
												'options' => G5CORE()->settings()->get_post_columns(),
												'default' => G5ERE()->options()->get_default( 'single_agency_agent_columns_lg', '3' ),
												'layout'  => 'full',
											),
											'single_agency_agent_columns_md' => array(
												'id'      => 'single_agency_agent_columns_md',
												'title'   => esc_html__( 'Medium Devices', 'g5-ere' ),
												'desc'    => esc_html__( 'Specify your agent columns on medium devices (>= 768px)', 'g5-ere' ),
												'type'    => 'select',
												'options' => G5CORE()->settings()->get_post_columns(),
												'default' => G5ERE()->options()->get_default( 'single_agency_agent_columns_md', '2' ),
												'layout'  => 'full',
											),
										)
									),
									'single_agency_agent_columns_row_2' => array(
										'id'     => 'single_agency_agent_columns_row_2',
										'type'   => 'row',
										'col'    => 3,
										'fields' => array(
											'single_agency_agent_columns_sm' => array(
												'id'      => 'single_agency_agent_columns_sm',
												'title'   => esc_html__( 'Small Devices', 'g5-ere' ),
												'desc'    => esc_html__( 'Specify your agent columns on small devices (< 768px)', 'g5-ere' ),
												'type'    => 'select',
												'options' => G5CORE()->settings()->get_post_columns(),
												'default' => G5ERE()->options()->get_default( 'single_agency_agent_columns_sm', '2' ),
												'layout'  => 'full',
											),
											'single_agency_agent_columns'    => array(
												'id'      => 'single_agency_agent_columns',
												'title'   => esc_html__( 'Extra Small Devices', 'g5-ere' ),
												'desc'    => esc_html__( 'Specify your agent columns on extra small devices (< 576px)', 'g5-ere' ),
												'type'    => 'select',
												'options' => G5CORE()->settings()->get_post_columns(),
												'default' => G5ERE()->options()->get_default( 'single_agency_agent_columns', '1' ),
												'layout'  => 'full',
											)
										)
									)
								)
							),
							'single_agency_agent_image_size'        => array(
								'id'       => 'single_agency_agent_image_size',
								'title'    => esc_html__( 'Image size', 'g5-ere' ),
								'subtitle' => esc_html__( 'Enter your agent image size', 'g5-ere' ),
								'desc'     => esc_html__( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'g5-ere' ),
								'type'     => 'text',
								'default'  => G5ERE()->options()->get_default( 'single_agency_agent_image_size', 'full' ),
							),
							'single_agency_agent_image_ratio'       => array(
								'id'       => 'single_agency_agent_image_ratio',
								'title'    => esc_html__( 'Image Ratio', 'g5-ere' ),
								'subtitle' => esc_html__( 'Enter image ratio', 'g5-ere' ),
								'type'     => 'dimension',
								'required' => array( 'single_agency_agent_image_size', '=', 'full' ),
							),
						)
					),
					'single_agency_agent_layout_list_group' => array(
						'id'       => 'single_agency_agent_layout_list_group',
						'title'    => esc_html__( 'Layout List', 'g5-ere' ),
						'type'     => 'group',
						'required' => array( 'single_agency_agent_layout', '=', 'list' ),
						'fields'   => array(
							'single_agency_agent_list_item_skin'         => array(
								'id'       => 'single_agency_agent_list_item_skin',
								'title'    => esc_html__( 'List Item Skin', 'g5-ere' ),
								'subtitle' => esc_html__( 'Specify your agent list item skin', 'g5-ere' ),
								'type'     => 'image_set',
								'options'  => G5ERE()->settings()->get_agent_list_skins(),
								'default'  => G5ERE()->options()->get_default( 'single_agency_agent_list_item_skin', 'skin-list-01' ),
							),
							'single_agency_agent_list_item_custom_class' => array(
								'id'       => 'single_agency_agent_list_item_custom_class',
								'title'    => esc_html__( 'List Item Css Classes', 'g5-ere' ),
								'subtitle' => esc_html__( 'Add custom css classes to item', 'g5-ere' ),
								'type'     => 'text',
							),
							'single_agency_agent_list_image_size'        => array(
								'id'       => 'single_agency_agent_list_image_size',
								'title'    => esc_html__( 'Image size', 'g5-ere' ),
								'subtitle' => esc_html__( 'Enter your agent image size', 'g5-ere' ),
								'desc'     => esc_html__( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'g5-ere' ),
								'type'     => 'text',
								'default'  => G5ERE()->options()->get_default( 'single_agency_agent_list_image_size', 'full' ),
							),
							'single_agency_agent_list_image_ratio'       => array(
								'id'       => 'single_agency_agent_list_image_ratio',
								'title'    => esc_html__( 'Image Ratio', 'g5-ere' ),
								'subtitle' => esc_html__( 'Enter image ratio', 'g5-ere' ),
								'type'     => 'dimension',
								'required' => array(
									array( 'single_agency_agent_list_image_size', '=', 'full' ),
								)
							),
						)
					),
					'single_agency_agent_per_page'          => array(
						'id'         => 'single_agency_agent_per_page',
						'type'       => 'text',
						'input_type' => 'number',
						'title'      => esc_html__( 'Agent per page', 'g5-ere' ),
						'subtitle'   => esc_html__( 'Set number of agent per page', 'g5-ere' ),
						'default'    => '9',
					),
					'single_agency_agent_sorting'           => array(
						'id'      => 'single_agency_agent_sorting',
						'title'   => esc_html__( 'Default agent sorting', 'g5-ere' ),
						'type'    => 'select',
						'options' => G5ERE()->settings()->get_agent_sorting(),
						'default' => 'menu_order'
					),
					'single_agency_agent_paging'            => array(
						'id'       => 'single_agency_agent_paging',
						'title'    => esc_html__( 'Paging', 'g5-ere' ),
						'subtitle' => esc_html__( 'Specify your paging mode', 'g5-ere' ),
						'type'     => 'select',
						'options'  => G5CORE()->settings()->get_post_paging_small_mode(),
						'default'  => G5ERE()->options()->get_default( 'single_agency_agent_paging', 'pagination' ),
					),
					'single_agency_agent_animation'         => array(
						'id'       => 'single_agency_agent_animation',
						'title'    => esc_html__( 'Animation', 'g5-ere' ),
						'subtitle' => esc_html__( 'Specify your post animation', 'g5-ere' ),
						'type'     => 'select',
						'options'  => G5CORE()->settings()->get_animation(),
						'default'  => G5ERE()->options()->get_default( 'single_agency_agent_animation', 'none' )
					),
				)
			);
		}

		public function add_post_type_agency( $post_types ) {
			$post_types['taxonomy_agency'] = array(
				'label' => esc_html__( 'Agency', 'g5-ere' ),
				'icon'  => 'dashicons-businessman',
			);

			return $post_types;

		}

		public function change_setting_agency( $post_type ) {
			if (g5ere_is_single_agency()) {
				$post_type = 'taxonomy_agency_single';
			}
			return $post_type;
		}

		public function change_setting_agency_archive( $post_type ) {
			if ( g5ere_is_agency_page() ) {
				$post_type = 'taxonomy_agency_archive';
			}

			return $post_type;

		}

		public function config_section_general() {
			return array(
				'id'     => 'section_general',
				'title'  => esc_html__( 'General', 'g5-ere' ),
				'icon'   => 'dashicons dashicons-admin-site',
				'fields' => array(
					'property_placeholder_group' => array(
						'id'     => 'property_placeholder_group',
						'title'  => esc_html__( 'Property Default Thumbnail', 'g5-ere' ),
						'type'   => 'group',
						'fields' => array(
							'property_placeholder_enable' => G5CORE()->fields()->get_config_toggle( array(
								'id'      => 'property_placeholder_enable',
								'title'   => esc_html__( 'Enable Property Default Thumbnail', 'g5-ere' ),
								'desc'    => esc_html__( 'You can set default thumbnail for property that haven\' featured image with enabling this option and uploading default image in following field', 'g5-ere' ),
								'default' => 'on'
							) ),
							'property_placeholder_image'  => array(
								'id'       => 'property_placeholder_image',
								'type'     => 'image',
								'title'    => esc_html__( 'Property Default Thumbnail Image', 'g5-ere' ),
								'desc'     => esc_html__( 'By default, the property thumbnail will be shown but when the post haven\'nt thumbnail then this will be replaced', 'g5-ere' ),
								'required' => array( 'property_placeholder_enable', '=', 'on' ),
							),
						)
					),
					'agent_placeholder_group'    => array(
						'id'     => 'agent_placeholder_group',
						'title'  => esc_html__( 'Agent Default Thumbnail', 'g5-ere' ),
						'type'   => 'group',
						'fields' => array(
							'agent_placeholder_enable' => G5CORE()->fields()->get_config_toggle( array(
								'id'      => 'agent_placeholder_enable',
								'title'   => esc_html__( 'Enable Agent Default Thumbnail', 'g5-ere' ),
								'desc'    => esc_html__( 'You can set default thumbnail for agent that haven\' featured image with enabling this option and uploading default image in following field', 'g5-ere' ),
								'default' => 'on'
							) ),
							'agent_placeholder_image'  => array(
								'id'       => 'agent_placeholder_image',
								'type'     => 'image',
								'title'    => esc_html__( 'Agent Default Thumbnail Image', 'g5-ere' ),
								'desc'     => esc_html__( 'By default, the agent thumbnail will be shown but when the post haven\'nt thumbnail then this will be replaced', 'g5-ere' ),
								'required' => array( 'agent_placeholder_enable', '=', 'on' ),
							),
						)
					),
					'agency_placeholder_group'   => array(
						'id'     => 'agency_placeholder_group',
						'title'  => esc_html__( 'Agency Default Thumbnail', 'g5-ere' ),
						'type'   => 'group',
						'fields' => array(
							'agency_placeholder_enable' => G5CORE()->fields()->get_config_toggle( array(
								'id'      => 'agency_placeholder_enable',
								'title'   => esc_html__( 'Enable Agency Default Thumbnail', 'g5-ere' ),
								'desc'    => esc_html__( 'You can set default thumbnail for agency that haven\' featured image with enabling this option and uploading default image in following field', 'g5-ere' ),
								'default' => 'on'
							) ),
							'agency_placeholder_image'  => array(
								'id'       => 'agency_placeholder_image',
								'type'     => 'image',
								'title'    => esc_html__( 'Agency Default Thumbnail Image', 'g5-ere' ),
								'desc'     => esc_html__( 'By default, the agency thumbnail will be shown but when the post haven\'nt thumbnail then this will be replaced', 'g5-ere' ),
								'required' => array( 'agency_placeholder_enable', '=', 'on' ),
							),
						)
					),
				)
			);
		}

		public function change_single_property_setting() {
			if ( is_singular( 'property' ) ) {
				$prefix = G5ERE()->meta_prefix;
				$layout = get_post_meta( get_the_ID(), "{$prefix}single_property_layout", true );
				if ( $layout !== '' ) {
					G5ERE()->options()->set_option( 'single_property_layout', $layout );
				}


				$content_style = get_post_meta( get_the_ID(), "{$prefix}single_property_content_block_style", true );
				if ( $content_style !== '' ) {
					G5ERE()->options()->set_option( 'single_property_content_block_style', $content_style );
				}

				$custom_gallery = get_post_meta( get_the_ID(), "{$prefix}single_property_custom_gallery", true );
				if ( $custom_gallery == 'on' ) {
					$settings = array(
						"single_property_gallery_layout",
						"single_property_gallery_slides_to_show",
						"single_property_gallery_slides_to_show_lg",
						"single_property_gallery_slides_to_show_md",
						"single_property_gallery_slides_to_show_sm",
						"single_property_gallery_slides_to_show_xs",
						"single_property_gallery_image_size",
						"single_property_gallery_image_ratio",
						"single_property_gallery_slider_pagination_enable",
						"single_property_gallery_slider_navigation_enable",
						"single_property_gallery_slider_autoplay_enable",
						"single_property_gallery_slider_autoplay_timeout",
						"single_property_gallery_slider_center_enable",
						"single_property_gallery_slider_center_padding",
						"single_property_gallery_thumb_image_size",
						"single_property_gallery_thumb_slides_to_show",
						"single_property_gallery_thumb_slides_to_show_lg",
						"single_property_gallery_thumb_slides_to_show_md",
						"single_property_gallery_thumb_slides_to_show_sm",
						"single_property_gallery_thumb_slides_to_show_xs",
						"single_property_gallery_metro_image_size",
						"single_property_gallery_metro_image_ratio",
						"single_property_gallery_columns_gutter",
						"single_property_gallery_map_enable",
						"single_property_gallery_custom_class"
					);
					foreach ( $settings as $setting ) {
						$v = get_post_meta( get_the_ID(), "{$prefix}{$setting}", true );
						if ($v !== '') {
							G5ERE()->options()->set_option( $setting, $v );
						}
					}
				}

			}
		}

		public function change_setting_author( $post_type ) {
			if ( is_author() ) {
				$post_type = 'agent_single';
			}

			return $post_type;
		}

		public function change_ere_options_enable_rtl_mode_config($configs) {
			$general_option = &g5ere_get_array_by_path( $configs, "ere_options/section/ere_general_option/fields" );
			foreach ($general_option as $k => &$v) {
				if ($v['id'] === 'ere_other_options') {
					foreach ($v['fields'] as $k1 => $v1) {
						if ($v1['id'] === 'enable_rtl_mode') {
							unset($v['fields'][$k1]);
							return $configs;
						}
					}
				}
			}
			return $configs;

		}

		public function change_ere_options_nearby_places_config($configs) {
			unset($configs['ere_options']['section']['ere_nearby_places_option']);
			unset($configs['ere_options']['section']['ere_google_map_option']);
			unset($configs['ere_options']['section']['ere_archive_agent']);
			unset($configs['ere_options']['section']['ere_agency_page_option']);
			unset($configs['ere_options']['section']['ere_social_share_option']);
			return $configs;
		}

		public function change_ere_options_ere_property_page_config($configs) {
			$property_page_option = &g5ere_get_array_by_path( $configs, "ere_options/section/ere_property_page_option/fields" );
			unset($property_page_option[0]);
			//unset($property_page_option[1]['fields'][1]);
			unset($property_page_option[1]['fields'][2]);
			unset($property_page_option[1]['fields'][3]);
			return $configs;
		}

	}
}