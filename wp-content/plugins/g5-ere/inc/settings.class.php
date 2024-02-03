<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! class_exists( 'G5ERE_Settings' ) ) {
	class G5ERE_Settings {
		private static $_instance;

		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function get_property_list_skins( $inherit = false ) {
			$config = apply_filters( 'g5ere_options_property_list_skins', array(
				'skin-list-01' => array(
					'label' => esc_html__( 'Skin 01', 'g5-ere' ),
					'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/list-skin-01.png' ),
				),
			) );
			if ( $inherit ) {
				$config = array(
					          '' => array(
						          'label' => esc_html__( 'Inherit', 'g5-ere' ),
						          'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/default.png' ),
					          ),
				          ) + $config;
			}

			return $config;
		}

		public function get_property_skins( $inherit = false ) {
			$config = apply_filters( 'g5ere_options_property_skins', array(
				'skin-01' => array(
					'label' => esc_html__( 'Skin 01', 'g5-ere' ),
					'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/grid-skin-01.png' ),
				),
			) );
			if ( $inherit ) {
				$config = array(
					          '' => array(
						          'label' => esc_html__( 'Inherit', 'g5-ere' ),
						          'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/default.png' ),
					          ),
				          ) + $config;
			}

			return $config;
		}

		public function get_agent_list_skins( $inherit = false ) {
			$config = apply_filters( 'g5ere_options_agent_list_skins', array(
				'skin-list-01' => array(
					'label' => esc_html__( 'Skin 01', 'g5-ere' ),
					'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/agent-list-skin-01.png' ),
				),
			) );
			if ( $inherit ) {
				$config = array(
					          '' => array(
						          'label' => esc_html__( 'Inherit', 'g5-ere' ),
						          'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/default.png' ),
					          ),
				          ) + $config;
			}

			return $config;
		}

		public function get_widget_property_skins( $inherit = false ) {
			$config = apply_filters( 'g5ere_widget_property_skins', array(
				'skin-01' => array(
					'label' => esc_html__( 'Skin 01', 'g5-ere' ),
					'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/widget-property-skin-01.png' ),
				),
				'skin-02' => array(
					'label' => esc_html__( 'Skin 02', 'g5-ere' ),
					'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/widget-property-skin-02.png' ),
				),
			) );
			if ( $inherit ) {
				$config = array(
					          '' => array(
						          'label' => esc_html__( 'Inherit', 'g5-ere' ),
						          'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/default.png' ),
					          ),
				          ) + $config;
			}

			return $config;
		}

		public function get_agency_list_skins( $inherit = false ) {
			$config = apply_filters( 'g5ere_options_agency_list_skins', array(
				'skin-list-01' => array(
					'label' => esc_html__( 'Skin 01', 'g5-ere' ),
					'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/list-skin-01.png' ),
				),
			) );
			if ( $inherit ) {
				$config = array(
					          '' => array(
						          'label' => esc_html__( 'Inherit', 'g5-ere' ),
						          'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/default.png' ),
					          ),
				          ) + $config;
			}

			return $config;
		}

		public function get_agent_skins( $inherit = false ) {
			$config = apply_filters( 'g5ere_options_agent_skins', array(
				'skin-01' => array(
					'label' => esc_html__( 'Skin 01', 'g5-ere' ),
					'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/agent-grid-skin-01.png' ),
				),
			) );
			if ( $inherit ) {
				$config = array(
					          '' => array(
						          'label' => esc_html__( 'Inherit', 'g5-ere' ),
						          'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/default.png' ),
					          ),
				          ) + $config;
			}

			return $config;
		}

		public function get_agency_skins( $inherit = false ) {
			$config = apply_filters( 'g5ere_options_agency_skins', array(
				'skin-01' => array(
					'label' => esc_html__( 'Skin 01', 'g5-ere' ),
					'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/grid-skin-01.png' ),
				),
			) );
			if ( $inherit ) {
				$config = array(
					          '' => array(
						          'label' => esc_html__( 'Inherit', 'g5-ere' ),
						          'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/default.png' ),
					          ),
				          ) + $config;
			}

			return $config;
		}

		public function get_agent_layout( $inherit = false ) {
			$config = apply_filters( 'g5ere_options_agent_layout', array(
				'grid' => array(
					'label' => esc_html__( 'Grid', 'g5-ere' ),
					'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/layout-grid.png' ),
				),
				'list' => array(
					'label' => esc_html__( 'List', 'g5-ere' ),
					'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/layout-list.png' ),
				),
			) );
			if ( $inherit ) {
				$config = array(
					          '' => array(
						          'label' => esc_html__( 'Inherit', 'g5-ere' ),
						          'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/default.png' ),
					          ),
				          ) + $config;
			}

			return $config;
		}

		public function get_shortcode_agent_layout( $inherit = false ) {
			$config = apply_filters( 'g5ere_shortcode_agent_layout', array(
				'grid' => array(
					'label' => esc_html__( 'Grid', 'g5-ere' ),
					'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/layout-grid.png' ),
				),
				'list' => array(
					'label' => esc_html__( 'List', 'g5-ere' ),
					'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/layout-list.png' ),
				),
			) );
			if ( $inherit ) {
				$config = array(
					          '' => array(
						          'label' => esc_html__( 'Inherit', 'g5-ere' ),
						          'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/default.png' ),
					          ),
				          ) + $config;
			}

			return $config;
		}

		public function get_agent_singular_layout() {
			return apply_filters( 'g5ere_options_agent_singular_layout', array(
				'layout-01' => esc_html__( 'Layout 01', 'g5-ere' )
			) );
		}

		public function get_agency_layout( $inherit = false ) {
			$config = apply_filters( 'g5ere_options_agency_layout', array(
				'grid' => array(
					'label' => esc_html__( 'Grid', 'g5-ere' ),
					'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/layout-grid.png' ),
				),
				'list' => array(
					'label' => esc_html__( 'List', 'g5-ere' ),
					'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/layout-list.png' ),
				),
			) );
			if ( $inherit ) {
				$config = array(
					          '' => array(
						          'label' => esc_html__( 'Inherit', 'g5-ere' ),
						          'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/default.png' ),
					          ),
				          ) + $config;
			}

			return $config;
		}

		public function get_agent_slider_layout() {
			return apply_filters( 'g5ere_options_agent_slider_layout', array(
				'layout-01' => esc_html__( 'Layout 01', 'g5-ere' )
			) );
		}

		public function get_single_agent_layout( $inherit = false ) {
			$config = apply_filters( 'g5ere_options_single_agent_layout', array(
				'layout-01' => array(
					'label' => esc_html__( 'Layout 01', 'g5-ere' ),
					'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/single-agent-1.png' )
				),
				'layout-02' => array(
					'label' => esc_html__( 'Layout 02', 'g5-ere' ),
					'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/single-agent-2.png' )
				),
			) );
			if ( $inherit ) {
				$config = array(
					          '' => array(
						          'label' => esc_html__( 'Inherit', 'g5-ere' ),
						          'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/default.png' ),
					          ),
				          ) + $config;
			}

			return $config;
		}

		public function get_properties_slider_layout() {
			return apply_filters( 'g5ere_options_properties_slider_layout', array(
				'layout-01' => esc_html__( 'Layout 01', 'g5-ere' )
			) );
		}

		public function get_property_layout( $inherit = false ) {
			$config = apply_filters( 'g5ere_options_property_layout', array(
				'grid' => array(
					'label' => esc_html__( 'Grid', 'g5-ere' ),
					'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/layout-grid.png' ),
				),
				'list' => array(
					'label' => esc_html__( 'List', 'g5-ere' ),
					'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/layout-list.png' ),
				),
			) );
			if ( $inherit ) {
				$config = array(
					          '' => array(
						          'label' => esc_html__( 'Inherit', 'g5-ere' ),
						          'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/default.png' ),
					          ),
				          ) + $config;
			}

			return $config;
		}

		public function get_shortcode_property_layout( $inherit = false ) {
			$config = apply_filters( 'g5ere_shortcode_property_layout', array(
				'grid' => array(
					'label' => esc_html__( 'Grid', 'g5-ere' ),
					'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/layout-grid.png' ),
				),
				'list' => array(
					'label' => esc_html__( 'List', 'g5-ere' ),
					'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/layout-list.png' ),
				),
			) );
			if ( $inherit ) {
				$config = array(
					          '' => array(
						          'label' => esc_html__( 'Inherit', 'g5-ere' ),
						          'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/default.png' ),
					          ),
				          ) + $config;
			}

			return $config;
		}


		public function get_property_locations_layout( $inherit = false ) {
			$config = apply_filters( 'g5ere_options_property_locations_layout', array(
				'layout-01' => array(
					'label' => esc_html__( 'Layout 01', 'g5-ere' ),
					'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/grid-skin-01.png' ),
				),
				'layout-02' => array(
					'label' => esc_html__( 'Layout 02', 'g5-ere' ),
					'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/location-layout-02.png' ),
				),
			) );
			if ( $inherit ) {
				$config = array(
					          '' => array(
						          'label' => esc_html__( 'Inherit', 'g5-ere' ),
						          'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/default.png' ),
					          ),
				          ) + $config;
			}

			return $config;
		}

		public function get_property_contact_layout( $inherit = false ) {
			$config = apply_filters( 'g5ere_widget_contact_agent_layout', array(
				'layout-01' => array(
					'label' => esc_html__( 'Layout 01', 'g5-ere' ),
					'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/agent-contact-skin-1.png' ),
				),
			) );
			if ( $inherit ) {
				$config = array(
					          '' => array(
						          'label' => esc_html__( 'Inherit', 'g5-ere' ),
						          'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/default.png' ),
					          ),
				          ) + $config;
			}

			return $config;
		}

		public function get_contact_agency_layout( $inherit = false ) {
			$config = apply_filters( 'g5ere_widget_contact_agency_layout', array(
				'layout-01' => array(
					'label' => esc_html__( 'Layout 01', 'g5-ere' ),
					'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/agent-contact-skin-1.png' ),
				),
			) );
			if ( $inherit ) {
				$config = array(
					          '' => array(
						          'label' => esc_html__( 'Inherit', 'g5-ere' ),
						          'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/default.png' ),
					          ),
				          ) + $config;
			}

			return $config;
		}

		public function get_property_location_taxonomy_filter() {
			return apply_filters( 'g5ere_property_location_taxonomy_filter', array(
				'property-state'        => esc_html__( 'Province / State', 'g5-ere' ),
				'property-city'         => esc_html__( 'City / Town', 'g5-ere' ),
				'property-neighborhood' => esc_html__( 'Neighborhood', 'g5-ere' )
			) );
		}

		public function get_map_marker_type( $inherit = false ) {
			$config = array(
				'image' => esc_html__( 'Image', 'g5-ere' ),
				'icon'  => esc_html__( 'Icon', 'g5-ere' ),
			);
			if ( $inherit ) {
				$config = array(
					          '' => esc_html__( 'Inherit', 'g5-ere' )
				          ) + $config;
			}

			return $config;
		}

		public function get_agent_sorting() {
			return apply_filters( 'g5ere_agent_sorting', array(
				'menu_order'      => esc_html__( 'Default sorting', 'g5-ere' ),
				'post_title'      => esc_html__( 'Name (A to Z)', 'g5-ere' ),
				'post_title-desc' => esc_html__( 'Name (Z to A)', 'g5-ere' ),
				'date'            => esc_html__( 'Date (Old to New)', 'g5-ere' ),
				'date-desc'       => esc_html__( 'Date (New to Old)', 'g5-ere' ),
				'rand'            => esc_html__( 'Random', 'g5-ere' ),
			) );
		}

		public function get_agency_sorting() {
			return apply_filters( 'g5ere_agency_sorting', array(
				'menu_order' => esc_html__( 'Default sorting', 'g5-ere' ),
				'name'       => esc_html__( 'Name (A to Z)', 'g5-ere' ),
				'name-desc'  => esc_html__( 'Name (Z to A)', 'g5-ere' ),
				'date'       => esc_html__( 'Date (Old to New)', 'g5-ere' ),
				'date-desc'  => esc_html__( 'Date (New to Old)', 'g5-ere' ),
			) );
		}

		public function get_property_sorting() {
			return apply_filters( 'g5ere_property_sorting', array(
				'menu_order' => esc_html__( 'Default sorting', 'g5-ere' ),
				'featured'   => esc_html__( 'Sort by featured First', 'g5-ere' ),
				'date'       => esc_html__( 'Sort by latest', 'g5-ere' ),
				'price'      => esc_html__( 'Sort by price: low to high', 'g5-ere' ),
				'price-desc' => esc_html__( 'Sort by price: high to low', 'g5-ere' ),
				'viewed'     => esc_html__( 'Sort by most Viewed', 'g5-ere' )
			) );
		}

		public function get_property_taxonomy_filter() {
			return apply_filters( 'g5ere_property_taxonomy_filter', array(
				'property-status' => esc_html__( 'Property Status', 'g5-ere' ),
				'property-type'   => esc_html__( 'Property Type', 'g5-ere' ),
				'property-label'  => esc_html__( 'Property Label', 'g5-ere' )
			) );
		}

		public function get_search_form_style() {
			return apply_filters( 'g5ere_search_form_style', array(
				'layout-01' => esc_html__( 'Style 01', 'g5-ere' ),
			) );
		}

		public function get_search_form_fields() {
			$configs = array(
				'top'     => array(
					'keyword' => esc_html__( 'Keyword', 'g5-ere' ),
					'type'    => esc_html__( 'Type', 'g5-ere' ),
					'status'  => esc_html__( 'Status', 'g5-ere' ),
				),
				'bottom'  => array(
					'bedrooms'     => esc_html__( 'Bedrooms', 'g5-ere' ),
					'bathrooms'    => esc_html__( 'Bathrooms', 'g5-ere' ),
					'min-size'     => esc_html__( 'Min Area', 'g5-ere' ),
					'max-size'     => esc_html__( 'Max Area', 'g5-ere' ),
					'city'         => esc_html__( 'City / Town', 'g5-ere' ),
					'neighborhood' => esc_html__( 'Neighborhood', 'g5-ere' ),
					'identity'     => esc_html__( 'Property ID', 'g5-ere' ),
				),
				'disable' => array(
					'country'   => esc_html__( 'Country', 'g5-ere' ),
					'state'     => esc_html__( 'Province / State', 'g5-ere' ),
					'min-price' => esc_html__( 'Min Price', 'g5-ere' ),
					'max-price' => esc_html__( 'Max Price', 'g5-ere' ),
					'min-land'  => esc_html__( 'Min Land Area', 'g5-ere' ),
					'max-land'  => esc_html__( 'Max Land Area', 'g5-ere' ),
					'label'     => esc_html__( 'Label', 'g5-ere' ),
					'garage'    => esc_html__( 'Garage', 'g5-ere' ),
				),
			);
			$additional_fields = ere_get_search_additional_fields();
			$configs['disable'] = wp_parse_args($additional_fields,$configs['disable']);
			return apply_filters('g5ere_search_form_fields',$configs);
		}

		public function get_widget_search_form_fields() {
			$config = array(
				'keyword' => esc_html__( 'Keyword', 'g5-ere' ),
				'type'    => esc_html__( 'Type', 'g5-ere' ),
				'status'  => esc_html__( 'Status', 'g5-ere' ),
				'bedrooms'     => esc_html__( 'Bedrooms', 'g5-ere' ),
				'rooms'     => esc_html__( 'Rooms', 'g5-ere' ),
				'bathrooms'    => esc_html__( 'Bathrooms', 'g5-ere' ),
				'min-price'  => esc_html__( 'Min Price', 'g5-ere' ),
				'max-price'  => esc_html__( 'Max Price', 'g5-ere' ),
				'min-size'     => esc_html__( 'Min Area', 'g5-ere' ),
				'max-size'     => esc_html__( 'Max Area', 'g5-ere' ),
				'city'         => esc_html__( 'City / Town', 'g5-ere' ),
				'neighborhood' => esc_html__( 'Neighborhood', 'g5-ere' ),
				'identity'     => esc_html__( 'Property ID', 'g5-ere' ),
				'country'    => esc_html__( 'Country', 'g5-ere' ),
				'state'      => esc_html__( 'Province / State', 'g5-ere' ),
				'min-land'   => esc_html__( 'Min Land Area', 'g5-ere' ),
				'max-land'   => esc_html__( 'Max Land Area', 'g5-ere' ),
				'label'      => esc_html__( 'Label', 'g5-ere' ),
				'garage'     => esc_html__( 'Garage', 'g5-ere' ),
			);
			$additional_fields = ere_get_search_additional_fields();
			$config = wp_parse_args($additional_fields,$config);
			return apply_filters('g5ere_widget_search_form_fields',$config);

		}

		public function get_advanced_search_layout() {
			return apply_filters( 'g5ere_advanced_search_layout', array(
				'boxed'     => esc_html__( 'Boxed Content', 'g5-ere' ),
				'stretched' => esc_html__( 'Stretched Content', 'g5-ere' ),
			) );
		}

		public function get_advanced_search_sticky() {
			return apply_filters( 'g5ere_advanced_search_sticky', array(
				''       => esc_html__( 'No Sticky', 'g5-ere' ),
				'simple' => esc_html__( 'Always Show', 'g5-ere' ),
				'smart'  => esc_html__( 'Show On Scroll Up', 'g5-ere' ),
			) );
		}

		public function get_map_position() {
			return apply_filters( 'g5ere_map_position', array(
				'none'           => esc_html__( 'Hide Map', 'g5-ere' ),
				'full-map'       => esc_html__( 'Full Map', 'g5-ere' ),
				'half-map-left'  => esc_html__( 'Half Map Left', 'g5-ere' ),
				'half-map-right' => esc_html__( 'Half Map Right', 'g5-ere' )
			) );
		}


		public function get_search_forms() {
			$search_forms = G5ERE()->options()->get_option( 'search_forms' );
			$config       = array(
				'' => esc_html__( 'Select Search Form', 'g5-ere' )
			);

			if ( is_array( $search_forms ) ) {
				foreach ( $search_forms as $search_form ) {
					$config[ $search_form['id'] ] = $search_form['name'];
				}
			}

			return $config;
		}

		public function get_single_property_layout( $inherit = false ) {
			$config = apply_filters( 'g5ere_options_single_property_layout', array(
				'layout-1'  => array(
					'label' => esc_html__( 'Layout 01', 'g5-ere' ),
					'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/single-property-1.png' )
				),
				'layout-2'  => array(
					'label' => esc_html__( 'Layout 02', 'g5-ere' ),
					'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/single-property-2.png' )
				),
				'layout-3'  => array(
					'label' => esc_html__( 'Layout 03', 'g5-ere' ),
					'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/single-property-3.png' )
				),
				'layout-4'  => array(
					'label' => esc_html__( 'Layout 04', 'g5-ere' ),
					'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/single-property-4.png' )
				),
				'layout-5'  => array(
					'label' => esc_html__( 'Layout 05', 'g5-ere' ),
					'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/single-property-5.png' )
				),
				'layout-6'  => array(
					'label' => esc_html__( 'Layout 06', 'g5-ere' ),
					'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/single-property-6.png' )
				),
				'layout-7'  => array(
					'label' => esc_html__( 'Layout 07', 'g5-ere' ),
					'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/single-property-7.png' )
				),
				'layout-8'  => array(
					'label' => esc_html__( 'Layout 08', 'g5-ere' ),
					'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/single-property-8.png' )
				),
				'layout-9'  => array(
					'label' => esc_html__( 'Layout 09', 'g5-ere' ),
					'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/single-property-9.png' )
				),
				'layout-10' => array(
					'label' => esc_html__( 'Layout 10', 'g5-ere' ),
					'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/single-property-10.png' )
				),
			) );
			if ( $inherit ) {
				$config = array(
					          '' => array(
						          'label' => esc_html__( 'Inherit', 'g5-ere' ),
						          'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/default.png' ),
					          ),
				          ) + $config;
			}

			return $config;
		}


		public function get_single_property_gallery_layout( $inherit = false ) {
			$config = apply_filters( 'g5ere_options_single_property_gallery_layout', array(
				'slider'    => array(
					'label' => esc_html__( 'Slider', 'g5-ere' ),
					'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/gallery-slider.png' ),
				),
				'carousel'  => array(
					'label' => esc_html__( 'Carousel', 'g5-ere' ),
					'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/gallery-carousel.png' ),
				),
				'thumbnail' => array(
					'label' => esc_html__( 'Gallery', 'g5-ere' ),
					'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/gallery-thumbnail.png' ),
				),
				'metro-1'   => array(
					'label' => esc_html__( 'Metro 01', 'g5-ere' ),
					'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/gallery-metro-1.png' ),
				),
				'metro-2'   => array(
					'label' => esc_html__( 'Metro 02', 'g5-ere' ),
					'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/gallery-metro-2.png' ),
				),
				'metro-3'   => array(
					'label' => esc_html__( 'Metro 03', 'g5-ere' ),
					'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/gallery-metro-3.png' ),
				),
				'metro-4'   => array(
					'label' => esc_html__( 'Metro 04', 'g5-ere' ),
					'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/gallery-metro-4.png' ),
				),
			) );
			if ( $inherit ) {
				$config = array(
					          '' => array(
						          'label' => esc_html__( 'Inherit', 'g5-ere' ),
						          'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/default.png' ),
					          ),
				          ) + $config;
			}

			return $config;
		}


		public function get_search_form_default() {
			return array(
				array(
					'name'                   => esc_html__( 'Advanced Search', 'g5-ere' ),
					'id'                     => 'advanced-search',
					'search_style'           => 'layout-01',
					'search_fields'          => array(
						'top'     => array(
							'keyword' => esc_html__( 'Keyword', 'g5-ere' ),
							'type'    => esc_html__( 'Type', 'g5-ere' ),
							'status'  => esc_html__( 'Status', 'g5-ere' ),
						),
						'bottom'  => array(
							'bedrooms'     => esc_html__( 'Bedrooms', 'g5-ere' ),
							'bathrooms'    => esc_html__( 'Bathrooms', 'g5-ere' ),
							'min-size'     => esc_html__( 'Min Area', 'g5-ere' ),
							'max-size'     => esc_html__( 'Max Area', 'g5-ere' ),
							'city'         => esc_html__( 'City / Town', 'g5-ere' ),
							'neighborhood' => esc_html__( 'Neighborhood', 'g5-ere' ),
							'identity'     => esc_html__( 'Property ID', 'g5-ere' ),
						),
						'disable' => array(
							'country'    => esc_html__( 'Country', 'g5-ere' ),
							'state'      => esc_html__( 'Province / State', 'g5-ere' ),
							'land-range' => esc_html__( 'Land Area Range Slider', 'g5-ere' ),
							'size-range' => esc_html__( 'Area Range Slider', 'g5-ere' ),
							'min-price'  => esc_html__( 'Min Price', 'g5-ere' ),
							'max-price'  => esc_html__( 'Max Price', 'g5-ere' ),
							'min-land'   => esc_html__( 'Min Land Area', 'g5-ere' ),
							'max-land'   => esc_html__( 'Max Land Area', 'g5-ere' ),
							'label'      => esc_html__( 'Label', 'g5-ere' ),
							'garage'     => esc_html__( 'Garage', 'g5-ere' ),
						),
					),
					'search_tabs'            => 'off',
					'price_range_slider'     => 'on',
					'size_range_slider'      => 'off',
					'land_area_range_slider' => 'off',
					'other_features'         => 'on',
					'advanced_filters'       => 'on',
					'submit_button_position' => 'top'
				),
			);
		}

		public function get_map_services() {
			return apply_filters( 'g5ere_map_services', array(
				'google' => esc_html__( 'Google Maps', 'g5-ere' ),
				'mapbox' => esc_html__( 'Mapbox', 'g5-ere' ),
				'osm'    => esc_html__( 'OpenStreetMap', 'g5-ere' )
			) );
		}

		public function get_nearby_place_services() {
			return apply_filters( 'g5ere_nearby_place_services', array(
				'google' => esc_html__( 'Google', 'g5-ere' ),
				'yelp'   => esc_html__( 'Yelp', 'g5-ere' ),
			) );
		}

		public function get_nearby_place_map_category() {
			return apply_filters( 'g5ere_nearby_place_map_category', array(
				"accounting"              => esc_html__( 'Accounting', 'g5-ere' ),
				"airport"                 => esc_html__( 'Airport', 'g5-ere' ),
				"amusement_park"          => esc_html__( 'Amusement Park', 'g5-ere' ),
				"aquarium"                => esc_html__( 'Aquarium', 'g5-ere' ),
				"art_gallery"             => esc_html__( 'Art Gallery', 'g5-ere' ),
				"atm"                     => esc_html__( 'Atm', 'g5-ere' ),
				"bakery"                  => esc_html__( 'Bakery', 'g5-ere' ),
				"bank"                    => esc_html__( 'Bank', 'g5-ere' ),
				"bar"                     => esc_html__( 'Bar', 'g5-ere' ),
				"beauty_salon"            => esc_html__( 'Beauty Salon', 'g5-ere' ),
				"bicycle_store"           => esc_html__( 'Bicycle Store', 'g5-ere' ),
				"book_store"              => esc_html__( 'Book Store', 'g5-ere' ),
				"bowling_alley"           => esc_html__( 'Bowling Alley', 'g5-ere' ),
				"bus_station"             => esc_html__( 'Bus Station', 'g5-ere' ),
				"cafe"                    => esc_html__( 'Cafe', 'g5-ere' ),
				"campground"              => esc_html__( 'Campground', 'g5-ere' ),
				"car_dealer"              => esc_html__( 'Car Dealer', 'g5-ere' ),
				"car_rental"              => esc_html__( 'Car Rental', 'g5-ere' ),
				"car_repair"              => esc_html__( 'Car Repair', 'g5-ere' ),
				"car_wash"                => esc_html__( 'Car Wash', 'g5-ere' ),
				"casino"                  => esc_html__( 'Casino', 'g5-ere' ),
				"cemetery"                => esc_html__( 'Cemetery', 'g5-ere' ),
				"church"                  => esc_html__( 'Church', 'g5-ere' ),
				"city_hall"               => esc_html__( 'City Center', 'g5-ere' ),
				"clothing_store"          => esc_html__( 'Clothing Store', 'g5-ere' ),
				"convenience_store"       => esc_html__( 'Convenience Store', 'g5-ere' ),
				"courthouse"              => esc_html__( 'Courthouse', 'g5-ere' ),
				"dentist"                 => esc_html__( 'Dentist', 'g5-ere' ),
				"department_store"        => esc_html__( 'Department Store', 'g5-ere' ),
				"doctor"                  => esc_html__( 'Doctor', 'g5-ere' ),
				"electrician"             => esc_html__( 'Electrician', 'g5-ere' ),
				"electronics_store"       => esc_html__( 'Electronics Store', 'g5-ere' ),
				"embassy"                 => esc_html__( 'Embassy', 'g5-ere' ),
				"fire_station"            => esc_html__( 'Fire Station', 'g5-ere' ),
				"florist"                 => esc_html__( 'Florist', 'g5-ere' ),
				"funeral_home"            => esc_html__( 'Funeral Home', 'g5-ere' ),
				"furniture_store"         => esc_html__( 'Furniture Store', 'g5-ere' ),
				"gas_station"             => esc_html__( 'Gas Station', 'g5-ere' ),
				"gym"                     => esc_html__( 'Gym', 'g5-ere' ),
				"hair_care"               => esc_html__( 'Hair Care', 'g5-ere' ),
				"hardware_store"          => esc_html__( 'Hardware Store', 'g5-ere' ),
				"hindu_temple"            => esc_html__( 'Hindu Temple', 'g5-ere' ),
				"home_goods_store"        => esc_html__( 'Home Goods Store', 'g5-ere' ),
				"hospital"                => esc_html__( 'Hospital', 'g5-ere' ),
				"insurance_agency"        => esc_html__( 'Insurance Agency', 'g5-ere' ),
				"jewelry_store"           => esc_html__( 'Jewelry Store', 'g5-ere' ),
				"laundry"                 => esc_html__( 'Laundry', 'g5-ere' ),
				"lawyer"                  => esc_html__( 'Lawyer', 'g5-ere' ),
				"library"                 => esc_html__( 'Library', 'g5-ere' ),
				"light_rail_station"      => esc_html__( 'Light Rail Station', 'g5-ere' ),
				"liquor_store"            => esc_html__( 'Liquor Store', 'g5-ere' ),
				"local_government_office" => esc_html__( 'Local Government Office', 'g5-ere' ),
				"locksmith"               => esc_html__( 'Locksmith', 'g5-ere' ),
				"lodging"                 => esc_html__( 'Lodging', 'g5-ere' ),
				"meal_delivery"           => esc_html__( 'Meal Delivery', 'g5-ere' ),
				"meal_takeaway"           => esc_html__( 'Meal Takeaway', 'g5-ere' ),
				"movie_theater"           => esc_html__( 'Movie Theater', 'g5-ere' ),
				"movie_rental"            => esc_html__( 'Movie Rental', 'g5-ere' ),
				"mosque"                  => esc_html__( 'Mosque', 'g5-ere' ),
				"moving_company"          => esc_html__( 'Moving Company', 'g5-ere' ),
				"night_club"              => esc_html__( 'Night Club', 'g5-ere' ),
				"painter"                 => esc_html__( 'Painter', 'g5-ere' ),
				"park"                    => esc_html__( 'Park', 'g5-ere' ),
				"parking"                 => esc_html__( 'Park', 'g5-ere' ),
				"pet_store"               => esc_html__( 'Pet Store', 'g5-ere' ),
				"pharmacy"                => esc_html__( 'Pharmacy', 'g5-ere' ),
				"physiotherapist"         => esc_html__( 'Physiotherapist', 'g5-ere' ),
				"plumber"                 => esc_html__( 'Plumber', 'g5-ere' ),
				"police"                  => esc_html__( 'Police', 'g5-ere' ),
				"post_office"             => esc_html__( 'Post Office', 'g5-ere' ),
				"primary_school"          => esc_html__( 'Post Office', 'g5-ere' ),
				"real_estate_agency"      => esc_html__( 'Real Estate Agency', 'g5-ere' ),
				"restaurant"              => esc_html__( 'Restaurant', 'g5-ere' ),
				"roofing_contractor"      => esc_html__( 'Roofing Contractor', 'g5-ere' ),
				"rv_park"                 => esc_html__( 'Rv Park', 'g5-ere' ),
				"school"                  => esc_html__( 'School', 'g5-ere' ),
				"secondary_school"        => esc_html__( 'Secondary School', 'g5-ere' ),
				"shoe_store"              => esc_html__( 'Shoe Store', 'g5-ere' ),
				"shopping_mall"           => esc_html__( 'Shopping Mall', 'g5-ere' ),
				"spa"                     => esc_html__( 'Spa', 'g5-ere' ),
				"stadium"                 => esc_html__( 'Stadium', 'g5-ere' ),
				"storage"                 => esc_html__( 'Storage', 'g5-ere' ),
				"store"                   => esc_html__( 'Store', 'g5-ere' ),
				"subway_station"          => esc_html__( 'Subway Station', 'g5-ere' ),
				"supermarket"             => esc_html__( 'Supermarket', 'g5-ere' ),
				"synagogue"               => esc_html__( 'Synagogue', 'g5-ere' ),
				"taxi_stand"              => esc_html__( 'Taxi Stand', 'g5-ere' ),
				"train_station"           => esc_html__( 'Train Station', 'g5-ere' ),
				"transit_station"         => esc_html__( 'Transit Station', 'g5-ere' ),
				"travel_agency"           => esc_html__( 'Travel Agency', 'g5-ere' ),
				"veterinary_care"         => esc_html__( 'Veterinary Care', 'g5-ere' ),
				"zoo"                     => esc_html__( 'Zoo', 'g5-ere' ),
			) );
		}

		public function get_google_map_autocomplete_types() {
			return apply_filters( 'g5ere_google_map_autocomplete_types', array(
				'geocode'       => esc_html__( 'Geocode', 'g5-ere' ),
				'address'       => esc_html__( 'Address', 'g5-ere' ),
				'establishment' => esc_html__( 'Establishment', 'g5-ere' ),
				'(regions)'     => esc_html__( 'Regions', 'g5-ere' ),
				'(cities)'      => esc_html__( 'Cities', 'g5-ere' )
			) );
		}

		public function get_countries() {
			return apply_filters( 'g5ere_countries', array(
				'AF' => 'Afghanistan',
				'AX' => 'Aland Islands',
				'AL' => 'Albania',
				'DZ' => 'Algeria',
				'AS' => 'American Samoa',
				'AD' => 'Andorra',
				'AO' => 'Angola',
				'AI' => 'Anguilla',
				'AQ' => 'Antarctica',
				'AG' => 'Antigua and Barbuda',
				'AR' => 'Argentina',
				'AM' => 'Armenia',
				'AW' => 'Aruba',
				'AU' => 'Australia',
				'AT' => 'Austria',
				'AZ' => 'Azerbaijan',
				'BS' => 'Bahamas',
				'BH' => 'Bahrain',
				'BD' => 'Bangladesh',
				'BB' => 'Barbados',
				'BY' => 'Belarus',
				'BE' => 'Belgium',
				'BZ' => 'Belize',
				'BJ' => 'Benin',
				'BM' => 'Bermuda',
				'BT' => 'Bhutan',
				'BO' => 'Bolivia',
				'BA' => 'Bosnia and Herzegovina',
				'BW' => 'Botswana',
				'BV' => 'Bouvet Island (Bouvetoya)',
				'BR' => 'Brazil',
				'IO' => 'British Indian Ocean Territory (Chagos Archipelago)',
				'VG' => 'British Virgin Islands',
				'BN' => 'Brunei Darussalam',
				'BG' => 'Bulgaria',
				'BF' => 'Burkina Faso',
				'BI' => 'Burundi',
				'KH' => 'Cambodia',
				'CM' => 'Cameroon',
				'CA' => 'Canada',
				'CV' => 'Cape Verde',
				'KY' => 'Cayman Islands',
				'CF' => 'Central African Republic',
				'TD' => 'Chad',
				'CL' => 'Chile',
				'CN' => 'China',
				'CX' => 'Christmas Island',
				'CC' => 'Cocos (Keeling) Islands',
				'CO' => 'Colombia',
				'KM' => 'Comoros the',
				'CD' => 'Congo',
				'CG' => 'Congo the',
				'CK' => 'Cook Islands',
				'CR' => 'Costa Rica',
				'CI' => "Côte d'Ivoire",
				'HR' => 'Croatia',
				'CU' => 'Cuba',
				'CY' => 'Cyprus',
				'CZ' => 'Czech Republic',
				'DK' => 'Denmark',
				'DJ' => 'Djibouti',
				'DM' => 'Dominica',
				'DO' => 'Dominican Republic',
				'EC' => 'Ecuador',
				'EG' => 'Egypt',
				'SV' => 'El Salvador',
				'GQ' => 'Equatorial Guinea',
				'ER' => 'Eritrea',
				'EE' => 'Estonia',
				'ET' => 'Ethiopia',
				'FO' => 'Faroe Islands',
				'FK' => 'Falkland Islands (Malvinas)',
				'FJ' => 'Fiji the Fiji Islands',
				'FI' => 'Finland',
				'FR' => 'France',
				'GF' => 'French Guiana',
				'PF' => 'French Polynesia',
				'TF' => 'French Southern Territories',
				'GA' => 'Gabon',
				'GM' => 'Gambia the',
				'GE' => 'Georgia',
				'DE' => 'Germany',
				'GH' => 'Ghana',
				'GI' => 'Gibraltar',
				'GR' => 'Greece',
				'GL' => 'Greenland',
				'GD' => 'Grenada',
				'GP' => 'Guadeloupe',
				'GU' => 'Guam',
				'GT' => 'Guatemala',
				'GG' => 'Guernsey',
				'GN' => 'Guinea',
				'GW' => 'Guinea-Bissau',
				'GY' => 'Guyana',
				'HT' => 'Haiti',
				'HM' => 'Heard Island and McDonald Islands',
				'VA' => 'Holy See (Vatican City State)',
				'HN' => 'Honduras',
				'HK' => 'Hong Kong',
				'HU' => 'Hungary',
				'IS' => 'Iceland',
				'IN' => 'India',
				'ID' => 'Indonesia',
				'IR' => 'Iran',
				'IQ' => 'Iraq',
				'IE' => 'Ireland',
				'IM' => 'Isle of Man',
				'IL' => 'Israel',
				'IT' => 'Italy',
				'JM' => 'Jamaica',
				'JP' => 'Japan',
				'JE' => 'Jersey',
				'JO' => 'Jordan',
				'KZ' => 'Kazakhstan',
				'KE' => 'Kenya',
				'KI' => 'Kiribati',
				'KP' => 'Korea',
				'KR' => 'Korea',
				'KW' => 'Kuwait',
				'KG' => 'Kyrgyz Republic',
				'LA' => 'Lao',
				'LV' => 'Latvia',
				'LB' => 'Lebanon',
				'LS' => 'Lesotho',
				'LR' => 'Liberia',
				'LY' => 'Libyan Arab Jamahiriya',
				'LI' => 'Liechtenstein',
				'LT' => 'Lithuania',
				'LU' => 'Luxembourg',
				'MO' => 'Macao',
				'MK' => 'Macedonia',
				'MG' => 'Madagascar',
				'MW' => 'Malawi',
				'MY' => 'Malaysia',
				'MV' => 'Maldives',
				'ML' => 'Mali',
				'MT' => 'Malta',
				'MH' => 'Marshall Islands',
				'MQ' => 'Martinique',
				'MR' => 'Mauritania',
				'MU' => 'Mauritius',
				'YT' => 'Mayotte',
				'MX' => 'Mexico',
				'FM' => 'Micronesia',
				'MD' => 'Moldova',
				'MC' => 'Monaco',
				'MN' => 'Mongolia',
				'ME' => 'Montenegro',
				'MS' => 'Montserrat',
				'MA' => 'Morocco',
				'MZ' => 'Mozambique',
				'MM' => 'Myanmar',
				'NA' => 'Namibia',
				'NR' => 'Nauru',
				'NP' => 'Nepal',
				'AN' => 'Netherlands Antilles',
				'NL' => 'Netherlands the',
				'NC' => 'New Caledonia',
				'NZ' => 'New Zealand',
				'NI' => 'Nicaragua',
				'NE' => 'Niger',
				'NG' => 'Nigeria',
				'NU' => 'Niue',
				'NF' => 'Norfolk Island',
				'MP' => 'Northern Mariana Islands',
				'NO' => 'Norway',
				'OM' => 'Oman',
				'PK' => 'Pakistan',
				'PW' => 'Palau',
				'PS' => 'Palestinian Territory',
				'PA' => 'Panama',
				'PG' => 'Papua New Guinea',
				'PY' => 'Paraguay',
				'PE' => 'Peru',
				'PH' => 'Philippines',
				'PN' => 'Pitcairn Islands',
				'PL' => 'Poland',
				'PT' => 'Portugal, Portuguese Republic',
				'PR' => 'Puerto Rico',
				'QA' => 'Qatar',
				'RE' => 'Reunion',
				'RO' => 'Romania',
				'RU' => 'Russian Federation',
				'RW' => 'Rwanda',
				'BL' => 'Saint Barthelemy',
				'SH' => 'Saint Helena',
				'KN' => 'Saint Kitts and Nevis',
				'LC' => 'Saint Lucia',
				'MF' => 'Saint Martin',
				'PM' => 'Saint Pierre and Miquelon',
				'VC' => 'Saint Vincent and the Grenadines',
				'WS' => 'Samoa',
				'SM' => 'San Marino',
				'ST' => 'Sao Tome and Principe',
				'SA' => 'Saudi Arabia',
				'SN' => 'Senegal',
				'RS' => 'Serbia',
				'SC' => 'Seychelles',
				'SL' => 'Sierra Leone',
				'SG' => 'Singapore',
				'SK' => 'Slovakia (Slovak Republic)',
				'SI' => 'Slovenia',
				'SB' => 'Solomon Islands',
				'SO' => 'Somalia, Somali Republic',
				'ZA' => 'South Africa',
				'GS' => 'South Georgia and the South Sandwich Islands',
				'ES' => 'Spain',
				'LK' => 'Sri Lanka',
				'SD' => 'Sudan',
				'SR' => 'Suriname',
				'SJ' => 'Svalbard & Jan Mayen Islands',
				'SZ' => 'Swaziland',
				'SE' => 'Sweden',
				'CH' => 'Switzerland, Swiss Confederation',
				'SY' => 'Syrian Arab Republic',
				'TW' => 'Taiwan',
				'TJ' => 'Tajikistan',
				'TZ' => 'Tanzania',
				'TH' => 'Thailand',
				'TL' => 'Timor-Leste',
				'TG' => 'Togo',
				'TK' => 'Tokelau',
				'TO' => 'Tonga',
				'TT' => 'Trinidad and Tobago',
				'TN' => 'Tunisia',
				'TR' => 'Turkey',
				'TM' => 'Turkmenistan',
				'TC' => 'Turks and Caicos Islands',
				'TV' => 'Tuvalu',
				'UG' => 'Uganda',
				'UA' => 'Ukraine',
				'AE' => 'United Arab Emirates',
				'GB' => 'United Kingdom',
				'US' => 'United States',
				'UM' => 'United States Minor Outlying Islands',
				'VI' => 'United States Virgin Islands',
				'UY' => 'Uruguay, Eastern Republic of',
				'UZ' => 'Uzbekistan',
				'VU' => 'Vanuatu',
				'VE' => 'Venezuela',
				'VN' => 'Vietnam',
				'WF' => 'Wallis and Futuna',
				'EH' => 'Western Sahara',
				'YE' => 'Yemen',
				'ZM' => 'Zambia',
				'ZW' => 'Zimbabwe',
			) );
		}

		public function get_google_map_skins() {
			return apply_filters( 'g5ere_google_map_skins', array(
				'skin1'  => _x( 'Vanilla', 'Google Maps Skin', 'g5-ere' ),
				'skin2'  => _x( 'Midnight', 'Google Maps Skin', 'g5-ere' ),
				'skin3'  => _x( 'Grayscale', 'Google Maps Skin', 'g5-ere' ),
				'skin4'  => _x( 'Blue Water', 'Google Maps Skin', 'g5-ere' ),
				'skin5'  => _x( 'Nature', 'Google Maps Skin', 'g5-ere' ),
				'skin6'  => _x( 'Light', 'Google Maps Skin', 'g5-ere' ),
				'skin7'  => _x( 'Teal', 'Google Maps Skin', 'g5-ere' ),
				'skin8'  => _x( 'Iceberg', 'Google Maps Skin', 'g5-ere' ),
				'skin9'  => _x( 'Violet', 'Google Maps Skin', 'g5-ere' ),
				'skin10' => _x( 'Ocean', 'Google Maps Skin', 'g5-ere' ),
				'skin11' => _x( 'Dark', 'Google Maps Skin', 'g5-ere' ),
				'skin12' => _x( 'Standard', 'Google Maps Skin', 'g5-ere' ),
				'custom' => _x( 'Custom', 'Google Maps Skin', 'g5-ere' )
			) );
		}

		public function get_mapbox_autocomplete_types() {
			return apply_filters( 'g5ere_mapbox_autocomplete_types', array(
				'country'      => esc_html__( 'Countries', 'g5-ere' ),
				'region'       => esc_html__( 'Regions', 'g5-ere' ),
				'postcode'     => esc_html__( 'Postcodes', 'g5-ere' ),
				'district'     => esc_html__( 'Districts', 'g5-ere' ),
				'place'        => esc_html__( 'Places', 'g5-ere' ),
				'locality'     => esc_html__( 'Localities', 'g5-ere' ),
				'neighborhood' => esc_html__( 'Neighborhoods', 'g5-ere' ),
				'address'      => esc_html__( 'Addresses', 'g5-ere' ),
				'poi'          => esc_html__( 'Points of interest', 'g5-ere' ),
			) );
		}

		public function get_mapbox_skins() {
			return apply_filters( 'g5ere_mapbox_skins', array(
				'skin1'  => _x( 'Streets', 'Mapbox Skin', 'g5-ere' ),
				'skin2'  => _x( 'Outdoors', 'Mapbox Skin', 'g5-ere' ),
				'skin3'  => _x( 'Light', 'Mapbox Skin', 'g5-ere' ),
				'skin4'  => _x( 'Dark', 'Mapbox Skin', 'g5-ere' ),
				//'skin5' => _x('Nature', 'Google Skin', 'g5-ere'),
				'skin6'  => _x( 'Satellite', 'Mapbox Skin', 'g5-ere' ),
				'skin7'  => _x( 'Nav Day', 'Mapbox Skin', 'g5-ere' ),
				'skin8'  => _x( 'Nav Night', 'Mapbox Skin', 'g5-ere' ),
				'skin9'  => _x( 'Guide Day', 'Mapbox Skin', 'g5-ere' ),
				'skin10' => _x( 'Guide Day', 'Mapbox Skin', 'g5-ere' ),
				//'skin11' => _x('Dark', 'Google Skin', 'g5-ere'),
				'skin12' => _x( 'Standard', 'Mapbox Skin', 'g5-ere' ),
				'custom' => _x( 'Custom', 'Mapbox Skin', 'g5-ere' )
			) );
		}

		public function get_single_agency_layout( $inherit = false ) {
			$config = apply_filters( 'g5ere_options_single_agency_layout', array(
				'layout-1' => array(
					'label' => esc_html__( 'Layout 01', 'g5-ere' ),
					'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/single-agency-1.png' )
				),
				'layout-2' => array(
					'label' => esc_html__( 'Layout 02', 'g5-ere' ),
					'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/single-agency-2.png' )
				),
			) );
			if ( $inherit ) {
				$config = array(
					          '' => array(
						          'label' => esc_html__( 'Inherit', 'g5-ere' ),
						          'img'   => G5ERE()->plugin_url( 'assets/images/theme-options/default.png' ),
					          ),
				          ) + $config;
			}

			return $config;
		}

		public function get_single_property_content_blocks() {
			return apply_filters( 'g5ere_options_single_property_content_blocks', array(
				'enable'  => array(
					'description'        => esc_html__( 'Description', 'g5-ere' ),
					'overview'           => esc_html__( 'Overview', 'g5-ere' ),
					'address'            => esc_html__( 'Address', 'g5-ere' ),
					'details'            => esc_html__( 'Details', 'g5-ere' ),
					'features'           => esc_html__( 'Features', 'g5-ere' ),
					'floor-plans'        => esc_html__( 'Floor Plans', 'g5-ere' ),
					'video'              => esc_html__( 'Video', 'g5-ere' ),
					'virtual-tour'       => esc_html__( '360° Virtual Tour', 'g5-ere' ),
					'map'                => esc_html__( 'Map', 'g5-ere' ),
					'mortgage'           => esc_html__( 'Mortgage Calculator', 'g5-ere' ),
					'attachments'        => esc_html__( 'Attachments', 'g5-ere' ),
					'nearby-places'      => esc_html__( 'Nearby Places', 'g5-ere' ),
					'walk-score'         => esc_html__( 'Walk Score', 'g5-ere' ),
					'contact-agent'      => esc_html__( 'Contact Agent', 'g5-ere' ),
					'review'             => esc_html__( 'Reviews', 'g5-ere' ),
					'similar-properties' => esc_html__( 'Similar Listings', 'g5-ere' ),
				),
				'disable' => array(
					'tabs'    => esc_html__( 'Tabs Content', 'g5-ere' ),
					'gallery' => esc_html__( 'Gallery', 'g5-ere' )
				)
			) );
		}

		public function get_single_property_tabs_content_blocks() {
			return apply_filters( 'g5ere_options_single_property_tabs_content_blocks', array(
				'enable'  => array(
					'description'   => esc_html__( 'Description', 'g5-ere' ),
					'address'       => esc_html__( 'Address', 'g5-ere' ),
					'details'       => esc_html__( 'Details', 'g5-ere' ),
					'features'      => esc_html__( 'Features', 'g5-ere' ),
					'floor-plans'   => esc_html__( 'Floor Plans', 'g5-ere' ),
					'video'         => esc_html__( 'Video', 'g5-ere' ),
					'map'           => esc_html__( 'Map', 'g5-ere' ),
					'mortgage'      => esc_html__( 'Mortgage Calculator', 'g5-ere' ),
					'nearby-places' => esc_html__( 'Nearby Places', 'g5-ere' ),
				),
				'disable' => array(
					'virtual-tour' => esc_html__( '360° Virtual Tour', 'g5-ere' ),
				),
			) );
		}


		public function get_yelp_category() {
			return apply_filters( 'g5ere_yelp_category', array(
				'active'             => esc_html__( 'Active Life', 'g5-ere' ),
				'arts'               => esc_html__( 'Arts & Entertainment', 'g5-ere' ),
				'auto'               => esc_html__( 'Automotive', 'g5-ere' ),
				'beautysvc'          => esc_html__( 'Beauty & Spas', 'g5-ere' ),
				'education'          => esc_html__( 'Education', 'g5-ere' ),
				'eventservices'      => esc_html__( 'Event Planning & Services', 'g5-ere' ),
				'financialservices'  => esc_html__( 'Financial Services', 'g5-ere' ),
				'food'               => esc_html__( 'Food', 'g5-ere' ),
				'health'             => esc_html__( 'Health & Medical', 'g5-ere' ),
				'homeservices'       => esc_html__( 'Home Services ', 'g5-ere' ),
				'hotelstravel'       => esc_html__( 'Hotels & Travel', 'g5-ere' ),
				'localflavor'        => esc_html__( 'Local Flavor', 'g5-ere' ),
				'localservices'      => esc_html__( 'Local Services', 'g5-ere' ),
				'massmedia'          => esc_html__( 'Mass Media', 'g5-ere' ),
				'nightlife'          => esc_html__( 'Nightlife', 'g5-ere' ),
				'pets'               => esc_html__( 'Pets', 'g5-ere' ),
				'professional'       => esc_html__( 'Professional Services', 'g5-ere' ),
				'publicservicesgovt' => esc_html__( 'Public Services & Government', 'g5-ere' ),
				'realestate'         => esc_html__( 'Real Estate', 'g5-ere' ),
				'religiousorgs'      => esc_html__( 'Religious Organizations', 'g5-ere' ),
				'restaurants'        => esc_html__( 'Restaurants', 'g5-ere' ),
				'shopping'           => esc_html__( 'Shopping', 'g5-ere' ),
				'transport'          => esc_html__( 'Transportation', 'g5-ere' ),

			) );
		}

		public function get_here_category() {
			return apply_filters( 'g5ere_here_categories', array(
				''                               => esc_html__( 'Default', 'g5-ere' ),
				'restaurant'                     => esc_html__( 'Restaurant', 'g5-ere' ),
				'coffee-tea'                     => esc_html__( 'Coffee & Tea', 'g5-ere' ),
				'snacks-fast-food'               => esc_html__( 'Fast Food', 'g5-ere' ),
				'going-out'                      => esc_html__( 'Going Out', 'g5-ere' ),
				'sights-museums'                 => esc_html__( 'Sights Museums', 'g5-ere' ),
				'airport'                        => esc_html__( 'Airport', 'g5-ere' ),
				'accommodation'                  => esc_html__( 'Accommodation', 'g5-ere' ),
				'shopping'                       => esc_html__( 'Shopping', 'g5-ere' ),
				'leisure-outdoor'                => esc_html__( 'Leisure outdoor ', 'g5-ere' ),
				'administrative-areas-buildings' => esc_html__( 'Administrative areas buildings', 'g5-ere' ),
				'natural-geographical'           => esc_html__( 'Natural geographical', 'g5-ere' ),
				'petrol-station'                 => esc_html__( 'Petrol station', 'g5-ere' ),
				'atm-bank-exchange'              => esc_html__( 'ATM bank exchange', 'g5-ere' ),
				'toilet-rest-area'               => esc_html__( 'Toilet rest area', 'g5-ere' ),
				'hospital-health-care-facility'  => esc_html__( 'Hospital health care facility', 'g5-ere' )

			) );
		}

		public function get_single_agent_content_blocks() {
			return apply_filters( 'g5ere_options_single_agent_content_blocks', array(
				'enable'  => array(
					'my-properties' => esc_html__( 'My Properties', 'g5-ere' ),
					'review'        => esc_html__( 'Reviews', 'g5-ere' ),
					'other-agent'   => esc_html__( 'Other Agent', 'g5-ere' )
				),
				'disable' => array(
					'tabs'        => esc_html__( 'Tabs Content', 'g5-ere' ),
					'description' => esc_html__( 'Description', 'g5-ere' ),
				)
			) );
		}

		public function get_single_agent_tabs_content_blocks() {
			return apply_filters( 'g5ere_options_single_agent_tabs_content_blocks', array(
				'enable'  => array(
					'my-properties' => esc_html__( 'My Properties', 'g5-ere' ),
					'review'        => esc_html__( 'Reviews', 'g5-ere' ),
					'other-agent'   => esc_html__( 'Other Agent', 'g5-ere' )
				),
				'disable' => array(
					'description' => esc_html__( 'Description', 'g5-ere' ),
				),
			) );
		}

		public function get_single_agency_tabs_content_blocks() {
			return apply_filters( 'g5ere_options_single_agency_tabs_content_blocks', array(
				'enable'  => array(
					'overview' => esc_html__( 'Overview', 'g5-ere' ),
					'listing'  => esc_html__( 'Listing', 'g5-ere' ),
					'agents'   => esc_html__( 'Agents', 'g5-ere' ),
					'map'      => esc_html__( 'Map', 'g5-ere' ),
				),
				'disable' => array(),
			) );
		}

		public function get_single_agency_content_blocks() {
			return apply_filters( 'g5ere_options_single_agency_content_blocks', array(
				'enable'  => array(
					'listing' => esc_html__( 'Listing', 'g5-ere' ),
					'agents'  => esc_html__( 'Agents', 'g5-ere' ),
					'map'     => esc_html__( 'Map', 'g5-ere' ),
				),
				'disable' => array(
					'tabs'     => esc_html__( 'Tabs content', 'g5-ere' ),
					'overview' => esc_html__( 'Overview', 'g5-ere' )
				),
			) );
		}

		public function get_other_agent_algorithm() {
			$config = apply_filters( 'g5ere_options_other_agent_algorithm', array(
				''       => esc_html__( 'All', 'g5-ere' ),
				'agency' => esc_html__( 'by Agency', 'g5-ere' ),
			) );

			return $config;

		}

		public function get_single_content_block_style( $inherit = false ) {
			$config = apply_filters( 'g5ere_options_single_content_block_style', array(
				'style-01' => esc_html__( 'Style 01', 'g5-ere' ),
			) );

			if ( $inherit ) {
				$config = array(
					          '' => esc_html__( 'Inherit', 'g5-ere' )
				          ) + $config;
			}

			return $config;
		}

		public function get_widget_agent_info_layout() {
			return apply_filters( 'g5ere_widget_agent_info_layout', array(
				'layout-01' => esc_html__( 'Layout 01', 'g5-ere' )
			) );
		}

		public function get_hover_effect() {
			return apply_filters('g5ere_image_hover_effect',array(
				'' => esc_html__('None', 'g5-ere'),
				'symmetry' => esc_html__('Symmetry', 'g5-ere'),
				'suprema' => esc_html__('Suprema', 'g5-ere'),
				'layla' => esc_html__('Layla', 'g5-ere'),
				'bubba' => esc_html__('Bubba', 'g5-ere'),
				'jazz' => esc_html__('Jazz', 'g5-ere'),
				'flash' => esc_html__('Flash', 'g5-ere'),
				'ming' => esc_html__('Ming', 'g5-ere'),
			));
		}

		public function get_hover_effect_image() {
			return apply_filters('g5ere_image_hover_effect_image',array(
				'' => esc_html__('None', 'g5-ere'),
				'zoom-in' => esc_html__('Zoom In', 'g5-ere'),
				'zoom-out' => esc_html__('Zoom Out', 'g5-ere'),
				'slide-left' => esc_html__('Slide Left', 'g5-ere'),
				'slide-right' => esc_html__('Slide Right', 'g5-ere'),
				'slide-top' => esc_html__('Slide Top', 'g5-ere'),
				'slide-bottom' => esc_html__('Slide Bottom', 'g5-ere'),
				'rotate' => esc_html__('Rotate', 'g5-ere'),
			));
		}

	}
}