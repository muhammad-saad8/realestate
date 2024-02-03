<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! class_exists( 'HOMEID_CORE_PROPERTY' ) ) {
	class HOMEID_CORE_PROPERTY {
		private static $_instance;

		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init() {
			add_filter( 'g5ere_options_properties_slider_layout', array( $this, 'change_properties_layout' ) );

			add_filter( 'g5ere_options_property_skins', array( $this, 'change_options_properties_skins' ) );

			add_filter( 'g5ere_options_property_list_skins', array( $this, 'change_options_property_list_skins' ) );


			add_action( 'template_redirect', array( $this, 'demo_layout' ), 15 );
			add_action( 'template_redirect', array( $this, 'demo_single_layout' ), 15 );

			add_action( 'pre_get_posts', array( $this, 'post_per_pages' ), 15 );

			add_filter( 'g5ere_shortcode_property_layout', array( $this, 'change_shortcode_property_layout' ) );

			add_filter( 'g5ere_config_layout_matrix', array( $this, 'change_config_layout_matrix' ) );
			add_filter( 'g5ere_property_overview_class', array( $this, 'change_overview_item_class' ) );
			add_filter( 'g5ere_single_rating_col_classes', array( $this, 'change_rating_col_class' ) );

			add_filter( 'g5ere_options_single_content_block_style', array(
				$this,
				'change_options_single_content_block_style'
			) );


		}

		public function change_properties_layout( $layout ) {
			return wp_parse_args( array(
				'layout-02' => esc_html__( 'Layout 02', 'homeid' ),
				'layout-03' => esc_html__( 'Layout 03', 'homeid' ),
				'layout-04' => esc_html__( 'Layout 04', 'homeid' ),
				'layout-05' => esc_html__( 'Layout 05', 'homeid' )
			), $layout );
		}

		public function change_options_properties_skins( $layout ) {
			return wp_parse_args( array(
				'skin-02' => array(
					'label' => esc_html__( 'Skin 02', 'homeid' ),
					'img'   => get_parent_theme_file_uri( 'assets/images/theme-options/grid-skin-02.png' ),
				),
				'skin-03' => array(
					'label' => esc_html__( 'Skin 03', 'homeid' ),
					'img'   => get_parent_theme_file_uri( 'assets/images/theme-options/grid-skin-03.png' ),
				),
				'skin-04' => array(
					'label' => esc_html__( 'Skin 04', 'homeid' ),
					'img'   => get_parent_theme_file_uri( 'assets/images/theme-options/grid-skin-04.png' ),
				),
				'skin-05' => array(
					'label' => esc_html__( 'Skin 05', 'homeid' ),
					'img'   => get_parent_theme_file_uri( 'assets/images/theme-options/grid-skin-05.png' ),
				),
				'skin-06' => array(
					'label' => esc_html__( 'Skin 06', 'homeid' ),
					'img'   => get_parent_theme_file_uri( 'assets/images/theme-options/grid-skin-06.png' ),
				),
				'skin-07' => array(
					'label' => esc_html__( 'Skin 07', 'homeid' ),
					'img'   => get_parent_theme_file_uri( 'assets/images/theme-options/grid-skin-07.png' ),
				),
				'skin-08' => array(
					'label' => esc_html__( 'Skin 08', 'homeid' ),
					'img'   => get_parent_theme_file_uri( 'assets/images/theme-options/grid-skin-08.png' ),
				),
				'skin-09' => array(
					'label' => esc_html__( 'Skin 09', 'homeid' ),
					'img'   => get_parent_theme_file_uri( 'assets/images/theme-options/grid-skin-09.png' ),
				),
				'skin-10' => array(
					'label' => esc_html__( 'Skin 10', 'homeid' ),
					'img'   => get_parent_theme_file_uri( 'assets/images/theme-options/grid-skin-10.png' ),
				),
			), $layout );
		}

		public function change_options_property_list_skins( $layout ) {
			return wp_parse_args( array(
				'skin-list-02' => array(
					'label' => esc_html__( 'Skin 02', 'homeid' ),
					'img'   => get_parent_theme_file_uri( 'assets/images/theme-options/list-skin-02.png' ),
				),
				'skin-list-03' => array(
					'label' => esc_html__( 'Skin 03', 'homeid' ),
					'img'   => get_parent_theme_file_uri( 'assets/images/theme-options/list-skin-03.png' ),
				),
				'skin-list-04' => array(
					'label' => esc_html__( 'Skin 04', 'homeid' ),
					'img'   => get_parent_theme_file_uri( 'assets/images/theme-options/list-skin-04.png' ),
				),
			), $layout );
		}


		public function demo_layout() {
			if ( ! function_exists( 'G5CORE' ) || ! function_exists( 'G5ERE' ) ) {
				return;
			}
			$property_layout = isset( $_REQUEST['property_layout'] ) ? $_REQUEST['property_layout'] : '';
			$view            = isset( $_REQUEST['view'] ) ? $_REQUEST['view'] : '';
			switch ( $property_layout ) {
				case 'full-width-list':
					G5CORE()->options()->layout()->set_option( 'site_layout', 'none' );
					G5ERE()->options()->set_option( 'post_layout', 'list' );
					G5ERE()->options()->set_option( 'list_item_skin', 'skin-list-03' );
					if ( $view === 'grid' ) {
						G5ERE()->options()->set_option( 'post_columns_xl', '3' );
						G5ERE()->options()->set_option( 'post_columns_lg', '3' );
						G5ERE()->options()->set_option( 'post_columns_md', '2' );
						G5ERE()->options()->set_option( 'post_columns_sm', '1' );
						G5ERE()->options()->set_option( 'post_columns', '1' );
						G5ERE()->options()->set_option( 'item_skin', 'skin-08' );
					}
					break;
				case 'left-sidebar-list':
					G5CORE()->options()->layout()->set_option( 'site_layout', 'left' );
					G5ERE()->options()->set_option( 'post_layout', 'list' );
					G5ERE()->options()->set_option( 'list_item_skin', 'skin-list-02' );
					G5CORE()->options()->color()->set_option( 'site_background_color', array(
						'background_color' => '#f8f8f8'
					) );
					if ( $view === 'grid' ) {
						G5ERE()->options()->set_option( 'post_columns_xl', '2' );
						G5ERE()->options()->set_option( 'post_columns_lg', '2' );
						G5ERE()->options()->set_option( 'post_columns_md', '2' );
						G5ERE()->options()->set_option( 'post_columns_sm', '1' );
						G5ERE()->options()->set_option( 'post_columns', '1' );
						G5ERE()->options()->set_option( 'item_skin', 'skin-05' );
					}
					break;
				case 'right-sidebar-list':
					G5CORE()->options()->layout()->set_option( 'site_layout', 'right' );
					G5ERE()->options()->set_option( 'post_layout', 'list' );
					G5ERE()->options()->set_option( 'list_item_skin', 'skin-list-01' );
					if ( $view === 'grid' ) {
						G5ERE()->options()->set_option( 'post_columns_xl', '2' );
						G5ERE()->options()->set_option( 'post_columns_lg', '2' );
						G5ERE()->options()->set_option( 'post_columns_md', '2' );
						G5ERE()->options()->set_option( 'post_columns_sm', '1' );
						G5ERE()->options()->set_option( 'post_columns', '1' );
						G5ERE()->options()->set_option( 'item_skin', 'skin-08' );
					}
					break;
				case 'full-width-grid-1':
					G5CORE()->options()->layout()->set_option( 'site_layout', 'none' );
					G5ERE()->options()->set_option( 'post_layout', 'grid' );
					G5ERE()->options()->set_option( 'item_skin', 'skin-05' );
					G5ERE()->options()->set_option( 'post_columns_xl', '3' );
					G5ERE()->options()->set_option( 'post_columns_lg', '3' );
					G5ERE()->options()->set_option( 'post_columns_md', '2' );
					G5ERE()->options()->set_option( 'post_columns_sm', '1' );
					G5ERE()->options()->set_option( 'post_columns', '1' );
					G5CORE()->options()->color()->set_option( 'site_background_color', array(
						'background_color' => '#f8f8f8'
					) );
					if ( $view === 'list' ) {
						G5ERE()->options()->set_option( 'list_item_skin', 'skin-list-02' );
					}
					break;
				case 'full-width-grid-2':
					G5CORE()->options()->layout()->set_option( 'site_stretched_content', 'on' );
					G5CORE()->options()->layout()->set_option( 'site_layout', 'none' );
					G5ERE()->options()->set_option( 'post_layout', 'grid' );
					G5ERE()->options()->set_option( 'item_skin', 'skin-01' );
					G5ERE()->options()->set_option( 'post_columns_xl', '4' );
					G5ERE()->options()->set_option( 'post_columns_lg', '3' );
					G5ERE()->options()->set_option( 'post_columns_md', '2' );
					G5ERE()->options()->set_option( 'post_columns_sm', '1' );
					G5ERE()->options()->set_option( 'post_columns', '1' );
					if ( $view === 'list' ) {
						G5ERE()->options()->set_option( 'list_item_skin', 'skin-list-01' );
					}
					break;
				case 'full-width-grid-3':
					G5CORE()->options()->layout()->set_option( 'site_layout', 'none' );
					G5ERE()->options()->set_option( 'post_layout', 'grid' );
					G5ERE()->options()->set_option( 'item_skin', 'skin-07' );
					G5ERE()->options()->set_option( 'post_columns_xl', '3' );
					G5ERE()->options()->set_option( 'post_columns_lg', '3' );
					G5ERE()->options()->set_option( 'post_columns_md', '2' );
					G5ERE()->options()->set_option( 'post_columns_sm', '1' );
					G5ERE()->options()->set_option( 'post_columns', '1' );
					if ( $view === 'list' ) {
						G5ERE()->options()->set_option( 'list_item_skin', 'skin-list-03' );
					}
					break;
				case 'left-sidebar-grid':
					G5CORE()->options()->layout()->set_option( 'site_layout', 'left' );
					G5ERE()->options()->set_option( 'post_layout', 'grid' );
					G5ERE()->options()->set_option( 'item_skin', 'skin-08' );
					G5ERE()->options()->set_option( 'post_columns_xl', '2' );
					G5ERE()->options()->set_option( 'post_columns_lg', '2' );
					G5ERE()->options()->set_option( 'post_columns_md', '2' );
					G5ERE()->options()->set_option( 'post_columns_sm', '1' );
					G5ERE()->options()->set_option( 'post_columns', '1' );
					if ( $view === 'list' ) {
						G5ERE()->options()->set_option( 'list_item_skin', 'skin-list-01' );
					}
					break;
				case 'right-sidebar-grid':
					G5CORE()->options()->layout()->set_option( 'site_layout', 'right' );
					G5ERE()->options()->set_option( 'post_layout', 'grid' );
					G5ERE()->options()->set_option( 'item_skin', 'skin-05' );
					G5ERE()->options()->set_option( 'post_columns_xl', '2' );
					G5ERE()->options()->set_option( 'post_columns_lg', '2' );
					G5ERE()->options()->set_option( 'post_columns_md', '2' );
					G5ERE()->options()->set_option( 'post_columns_sm', '1' );
					G5ERE()->options()->set_option( 'post_columns', '1' );
					if ( $view === 'list' ) {
						G5ERE()->options()->set_option( 'list_item_skin', 'skin-list-03' );
					}
					break;
				case 'half-map-list-1':
					G5CORE()->options()->page_title()->set_option( 'page_title_enable', '' );
					G5CORE()->options()->layout()->set_option( 'site_layout', 'none' );
					G5ERE()->options()->set_option( 'post_layout', 'list' );
					G5ERE()->options()->set_option( 'map_position', 'half-map-right' );
					G5ERE()->options()->set_option( 'list_item_skin', 'skin-list-01' );
					if ( $view === 'grid' ) {
						G5ERE()->options()->set_option( 'post_columns_xl', '2' );
						G5ERE()->options()->set_option( 'post_columns_lg', '2' );
						G5ERE()->options()->set_option( 'post_columns_md', '2' );
						G5ERE()->options()->set_option( 'post_columns_sm', '1' );
						G5ERE()->options()->set_option( 'post_columns', '1' );
						G5ERE()->options()->set_option( 'item_skin', 'skin-08' );
					}
					break;
				case 'half-map-list-2':
					G5CORE()->options()->page_title()->set_option( 'page_title_enable', '' );
					G5CORE()->options()->layout()->set_option( 'site_layout', 'none' );
					G5ERE()->options()->set_option( 'post_layout', 'list' );
					G5ERE()->options()->set_option( 'map_position', 'half-map-left' );
					G5ERE()->options()->set_option( 'list_item_skin', 'skin-list-02' );
					if ( $view === 'grid' ) {
						G5ERE()->options()->set_option( 'post_columns_xl', '2' );
						G5ERE()->options()->set_option( 'post_columns_lg', '2' );
						G5ERE()->options()->set_option( 'post_columns_md', '2' );
						G5ERE()->options()->set_option( 'post_columns_sm', '1' );
						G5ERE()->options()->set_option( 'post_columns', '1' );
						G5ERE()->options()->set_option( 'item_skin', 'skin-02' );
					}
					break;
				case 'half-map-grid-1':
					G5CORE()->options()->page_title()->set_option( 'page_title_enable', '' );
					G5CORE()->options()->layout()->set_option( 'site_layout', 'none' );
					G5ERE()->options()->set_option( 'post_layout', 'grid' );
					G5ERE()->options()->set_option( 'map_position', 'half-map-right' );
					G5ERE()->options()->set_option( 'item_skin', 'skin-05' );
					G5ERE()->options()->set_option( 'post_columns_xl', '2' );
					G5ERE()->options()->set_option( 'post_columns_lg', '2' );
					G5ERE()->options()->set_option( 'post_columns_md', '2' );
					G5ERE()->options()->set_option( 'post_columns_sm', '1' );
					G5ERE()->options()->set_option( 'post_columns', '1' );
					if ( $view === 'list' ) {
						G5ERE()->options()->set_option( 'list_item_skin', 'skin-list-03' );
					}
					break;
				case 'half-map-grid-2':
					G5CORE()->options()->page_title()->set_option( 'page_title_enable', '' );
					G5CORE()->options()->layout()->set_option( 'site_layout', 'none' );
					G5ERE()->options()->set_option( 'post_layout', 'grid' );
					G5ERE()->options()->set_option( 'map_position', 'half-map-left' );
					G5ERE()->options()->set_option( 'item_skin', 'skin-04' );
					G5ERE()->options()->set_option( 'post_columns_xl', '2' );
					G5ERE()->options()->set_option( 'post_columns_lg', '2' );
					G5ERE()->options()->set_option( 'post_columns_md', '2' );
					G5ERE()->options()->set_option( 'post_columns_sm', '1' );
					G5ERE()->options()->set_option( 'post_columns', '1' );
					if ( $view === 'list' ) {
						G5ERE()->options()->set_option( 'list_item_skin', 'skin-list-01' );
					}
					break;
				case 'full-map-grid-1':
					G5CORE()->options()->page_title()->set_option( 'page_title_enable', '' );
					G5CORE()->options()->layout()->set_option( 'site_layout', 'none' );
					G5ERE()->options()->set_option( 'post_layout', 'grid' );
					G5ERE()->options()->set_option( 'map_position', 'full-map' );
					G5ERE()->options()->set_option( 'item_skin', 'skin-05' );
					G5ERE()->options()->set_option( 'post_columns_xl', '3' );
					G5ERE()->options()->set_option( 'post_columns_lg', '3' );
					G5ERE()->options()->set_option( 'post_columns_md', '2' );
					G5ERE()->options()->set_option( 'post_columns_sm', '1' );
					G5ERE()->options()->set_option( 'post_columns', '1' );
					if ( $view === 'list' ) {
						G5ERE()->options()->set_option( 'list_item_skin', 'skin-list-03' );
					}
					break;
				case 'full-map-grid-2':
					G5CORE()->options()->layout()->set_option( 'site_stretched_content', 'on' );
					G5CORE()->options()->page_title()->set_option( 'page_title_enable', '' );
					G5CORE()->options()->layout()->set_option( 'site_layout', 'none' );
					G5ERE()->options()->set_option( 'post_layout', 'grid' );
					G5ERE()->options()->set_option( 'map_position', 'full-map' );
					G5ERE()->options()->set_option( 'item_skin', 'skin-03' );
					G5ERE()->options()->set_option( 'post_columns_xl', '3' );
					G5ERE()->options()->set_option( 'post_columns_lg', '3' );
					G5ERE()->options()->set_option( 'post_columns_md', '2' );
					G5ERE()->options()->set_option( 'post_columns_sm', '1' );
					G5ERE()->options()->set_option( 'post_columns', '1' );
					if ( $view === 'list' ) {
						G5ERE()->options()->set_option( 'list_item_skin', 'skin-list-03' );
					}
					break;
				case 'full-map-grid-3':
					G5CORE()->options()->page_title()->set_option( 'page_title_enable', '' );
					G5CORE()->options()->layout()->set_option( 'site_layout', 'right' );
					G5ERE()->options()->set_option( 'post_layout', 'grid' );
					G5ERE()->options()->set_option( 'map_position', 'full-map' );
					G5ERE()->options()->set_option( 'item_skin', 'skin-08' );
					G5ERE()->options()->set_option( 'post_columns_xl', '2' );
					G5ERE()->options()->set_option( 'post_columns_lg', '2' );
					G5ERE()->options()->set_option( 'post_columns_md', '2' );
					G5ERE()->options()->set_option( 'post_columns_sm', '1' );
					G5ERE()->options()->set_option( 'post_columns', '1' );
					if ( $view === 'list' ) {
						G5ERE()->options()->set_option( 'list_item_skin', 'skin-list-03' );
					}
					break;

			}

			if ( $property_layout !== '' ) {
				$item_skin      = G5ERE()->options()->get_option( 'item_skin' );
				$list_item_skin = G5ERE()->options()->get_option( 'list_item_skin' );
				$post_layout    = G5ERE()->options()->get_option( 'post_layout' );
				if ( $post_layout === 'grid' ) {
					switch ( $item_skin ) {
						case 'skin-01':
							G5ERE()->options()->set_option( 'post_image_size', '510x289' );
							break;
						case 'skin-02':
							G5ERE()->options()->set_option( 'post_image_size', '510x282' );
							break;
						case 'skin-03':
							G5ERE()->options()->set_option( 'post_image_size', '510x357' );
							break;
						case 'skin-04':
							G5ERE()->options()->set_option( 'post_image_size', '510x602' );
							break;
						case 'skin-05':
							G5ERE()->options()->set_option( 'post_image_size', '510x282' );
							break;
						case 'skin-07':
							G5ERE()->options()->set_option( 'post_image_size', '468x305' );
							break;
						case 'skin-08':
							G5ERE()->options()->set_option( 'post_image_size', '510x282' );
							break;
					}
				}

				if ( $post_layout === 'list' ) {
					switch ( $list_item_skin ) {
						case 'skin-list-01':
							G5ERE()->options()->set_option( 'post_list_image_size', '468x280' );
							break;
						case 'skin-list-02':
							G5ERE()->options()->set_option( 'post_list_image_size', '468x468' );
							break;
						case 'skin-list-03':
							G5ERE()->options()->set_option( 'post_list_image_size', '468x280' );
							break;
					}
				}

			}

		}

		public function post_per_pages( $query ) {
			if ( ! function_exists( 'G5CORE' ) || ! function_exists( 'G5ERE' ) ) {
				return;
			}

			if ( ! is_admin() && $query->is_main_query() ) {
				$property_layout = isset( $_REQUEST['property_layout'] ) ? $_REQUEST['property_layout'] : '';
				$view            = isset( $_REQUEST['view'] ) ? $_REQUEST['view'] : '';
				switch ( $property_layout ) {
					case 'full-width-list':
						$query->set( 'posts_per_page', 9 );
						break;
					case 'left-sidebar-list':
						$query->set( 'posts_per_page', 10 );
						break;
					case 'right-sidebar-list':
						$query->set( 'posts_per_page', 10 );
						break;
					case 'full-width-grid-1':
						$query->set( 'posts_per_page', 9 );
						break;
					case 'full-width-grid-2':
						$query->set( 'posts_per_page', 12 );
						break;
					case 'full-width-grid-3':
						$query->set( 'posts_per_page', 9 );
						break;
					case 'left-sidebar-grid':
						$query->set( 'posts_per_page', 10 );
						break;
					case 'right-sidebar-grid':
						$query->set( 'posts_per_page', 10 );
						break;
					case 'half-map-list-1':
						$query->set( 'posts_per_page', 8 );
						break;
					case 'half-map-list-2':
						$query->set( 'posts_per_page', 8 );
						break;
					case 'half-map-grid-1':
						$query->set( 'posts_per_page', 8 );
						break;
					case 'half-map-grid-2':
						$query->set( 'posts_per_page', 8 );
						break;
					case 'full-map-grid-1':
						$query->set( 'posts_per_page', 9 );
						break;
					case 'full-map-grid-2':
						$query->set( 'posts_per_page', 9 );
						break;
					case 'full-map-grid-3':
						$query->set( 'posts_per_page', 8 );
						break;

				}

			}

		}

		public function change_shortcode_property_layout( $config ) {
			return wp_parse_args( array(
				'creative' => array(
					'label' => esc_html__( 'Creative', 'homeid' ),
					'img'   => get_parent_theme_file_uri( 'assets/images/theme-options/skin-creative.png' ),
				),
				'metro'    => array(
					'label' => esc_html__( 'Metro 01', 'homeid' ),
					'img'   => get_parent_theme_file_uri( 'assets/images/theme-options/skin-metro-01.png' ),
				),
				'metro-2'    => array(
					'label' => esc_html__( 'Metro 02', 'homeid' ),
					'img'   => get_parent_theme_file_uri( 'assets/images/theme-options/skin-metro-02.png' ),
				),
				'metro-3'    => array(
					'label' => esc_html__( 'Metro 03', 'homeid' ),
					'img'   => get_parent_theme_file_uri( 'assets/images/theme-options/skin-metro-03.png' ),
				),
			), $config );
		}

		public function change_config_layout_matrix( $config ) {
			$item_skin_metro = 'skin-metro-01';
			$item_skin_metro_03 = 'skin-metro-03';
			return wp_parse_args( array(
				'creative' => array( 'itemSelector' => '.g5core__listing-blocks' ),
				'metro' => array(
					'placeholder' => 'on',
					'isotope' => array(
						'itemSelector' => 'article',
						'layoutMode' => 'masonry',
						'percentPosition' => true,
						'masonry' => array(
							'columnWidth' => '.g5core__col-base',
						),
						'metro' => true
					),
					'layout' => array(
						array('columns' => g5core_get_bootstrap_columns(array('xl' => 3, 'lg' => 2, 'md' => 1, 'sm' => 1, '' => 1)), 'template' => $item_skin_metro, 'layout_ratio' => '1x1'),
						array('columns' => g5core_get_bootstrap_columns(array('xl' => 3, 'lg' => 2, 'md' => 1, 'sm' => 1, '' => 1)), 'template' => $item_skin_metro, 'layout_ratio' => '1x1'),
						array('columns' => g5core_get_bootstrap_columns(array('xl' => 3, 'lg' => 1, 'md' => 1, 'sm' => 1, '' => 1)), 'template' => $item_skin_metro, 'layout_ratio' => '1x2'),
						array('columns' => g5core_get_bootstrap_columns(array('xl' => 3, 'lg' => 2, 'md' => 1, 'sm' => 1, '' => 1)), 'template' => $item_skin_metro, 'layout_ratio' => '1x1'),
						array('columns' => g5core_get_bootstrap_columns(array('xl' => 3, 'lg' => 2, 'md' => 1, 'sm' => 1, '' => 1)), 'template' => $item_skin_metro, 'layout_ratio' => '1x1'),
					)
				),
				'metro-2' => array(
					'placeholder' => 'on',
					'isotope' => array(
						'itemSelector' => 'article',
						'layoutMode' => 'masonry',
						'percentPosition' => true,
						'masonry' => array(
							'columnWidth' => '.g5core__col-base',
						),
						'metro' => true
					),
					'layout' => array(
						array('columns' => g5core_get_bootstrap_columns(array('xl' => 2, 'lg' => 1, 'md' => 1, 'sm' => 1, '' => 1)), 'template' => $item_skin_metro, 'layout_ratio' => '2x1'),
						array('columns' => g5core_get_bootstrap_columns(array('xl' => 4, 'lg' => 2, 'md' => 2, 'sm' => 1, '' => 1)), 'template' => $item_skin_metro, 'layout_ratio' => '1x1'),
						array('columns' => g5core_get_bootstrap_columns(array('xl' => 4, 'lg' => 2, 'md' => 2, 'sm' => 1, '' => 1)), 'template' => $item_skin_metro, 'layout_ratio' => '1x1'),
						array('columns' => g5core_get_bootstrap_columns(array('xl' => 4, 'lg' => 2, 'md' => 2, 'sm' => 1, '' => 1)), 'template' => $item_skin_metro, 'layout_ratio' => '1x1'),
						array('columns' => g5core_get_bootstrap_columns(array('xl' => 4, 'lg' => 2, 'md' => 2, 'sm' => 1, '' => 1)), 'template' => $item_skin_metro, 'layout_ratio' => '1x1'),
						array('columns' => g5core_get_bootstrap_columns(array('xl' => 2, 'lg' => 1, 'md' => 1, 'sm' => 1, '' => 1)), 'template' => $item_skin_metro, 'layout_ratio' => '2x1'),
					)
				),
				'metro-3' => array(
					'placeholder' => 'on',
					'isotope' => array(
						'itemSelector' => 'article',
						'layoutMode' => 'masonry',
						'percentPosition' => true,
						'masonry' => array(
							'columnWidth' => '.g5core__col-base',
						),
						'metro' => true
					),
					'layout' => array(
						array('columns' => g5core_get_bootstrap_columns(array('xl' => 3, 'lg' => 2, 'md' => 2, 'sm' => 1, '' => 1)), 'template' => $item_skin_metro_03, 'layout_ratio' => '1x1'),
						array('columns' => g5core_get_bootstrap_columns(array('xl' => 3, 'lg' => 2, 'md' => 2, 'sm' => 1, '' => 1)), 'template' => $item_skin_metro_03, 'layout_ratio' => '1x2'),
						array('columns' => g5core_get_bootstrap_columns(array('xl' => 3, 'lg' => 2, 'md' => 2, 'sm' => 1, '' => 1)), 'template' => $item_skin_metro_03, 'layout_ratio' => '1x1'),
						array('columns' => g5core_get_bootstrap_columns(array('xl' => 3, 'lg' => 2, 'md' => 2, 'sm' => 1, '' => 1)), 'template' => $item_skin_metro_03, 'layout_ratio' => '1x1'),
						array('columns' => g5core_get_bootstrap_columns(array('xl' => 3, 'lg' => 2, 'md' => 2, 'sm' => 1, '' => 1)), 'template' => $item_skin_metro_03, 'layout_ratio' => '1x1'),
					)
				),
			), $config );
		}

		public function change_options_single_content_block_style( $config ) {
			return wp_parse_args( array(
				'style-02' => esc_html__( 'Style 02', 'homeid' ),
				'style-03' => esc_html__( 'Style 03', 'homeid' ),
			), $config );
		}

		public function demo_single_layout() {
			if ( ! function_exists( 'G5CORE' ) || ! function_exists( 'G5ERE' ) ) {
				return;
			}
			$layout = isset( $_GET['single_property_layout'] ) ? $_GET['single_property_layout'] : '';
			if ( ! is_singular( 'property' ) ) {
				return;
			}
			if ( $layout == 'layout_01' ) {
				G5CORE()->options()->color()->set_option( 'site_background_color', array(
					'background_color' => '#fff'
				) );
				G5CORE()->options()->header()->set_option('advanced_search_enable','off');
				G5ERE()->options()->set_option( 'single_property_layout', 'layout-2' );
				G5ERE()->options()->set_option( 'single_property_gallery_layout', 'metro-1' );
				G5ERE()->options()->set_option( 'single_property_gallery_columns_gutter', '10' );
				G5ERE()->options()->set_option( 'single_property_gallery_metro_image_ratio',
					array(
						'width'  => 4,
						'height' => 3
					) );
				G5ERE()->options()->set_option( 'single_property_content_block_style', 'style-01' );
			}
			if ( $layout == 'layout_02' ) {
				G5CORE()->options()->color()->set_option( 'site_background_color', array(
					'background_color' => '#f8f8f8'
				) );
				G5ERE()->options()->set_option( 'single_property_layout', 'layout-1' );
				G5ERE()->options()->set_option( 'single_property_gallery_layout', 'thumbnail' );
				G5ERE()->options()->set_option( 'single_property_gallery_thumb_slides_to_show', '6' );
				G5ERE()->options()->set_option( 'single_property_gallery_thumb_slides_to_show_lg', '4' );
				G5ERE()->options()->set_option( 'single_property_gallery_thumb_slides_to_show_sm', '3' );
				G5ERE()->options()->set_option( 'single_property_gallery_slider_pagination_enable', 'off' );
				G5ERE()->options()->set_option( 'single_property_gallery_slider_navigation_enable', 'on' );
				G5ERE()->options()->set_option( 'single_property_gallery_image_size', 'full' );
				G5ERE()->options()->set_option( 'single_property_gallery_thumb_image_size', '374x240' );
				G5ERE()->options()->set_option( 'single_property_content_block_style', 'style-02' );
				G5ERE()->options()->set_option( 'single_property_gallery_image_ratio',
					array(
						'width'  => 2,
						'height' => 1
					) );
			}
			if ( $layout == 'layout_03' ) {
				G5CORE()->options()->color()->set_option( 'site_background_color', array(
					'background_color' => '#f8f8f8'
				) );
				G5ERE()->options()->set_option( 'single_property_layout', 'layout-3' );
				G5ERE()->options()->set_option( 'single_property_gallery_layout', 'slider' );
				G5ERE()->options()->set_option( 'single_property_gallery_slider_pagination_enable', 'on' );
				G5ERE()->options()->set_option( 'single_property_gallery_slider_navigation_enable', 'on' );
				G5ERE()->options()->set_option( 'single_property_gallery_image_size', 'full' );
				G5ERE()->options()->set_option( 'single_property_content_block_style', 'style-02' );
				G5ERE()->options()->set_option( 'single_property_gallery_image_ratio',
					array(
						'width'  => 2,
						'height' => 1
					) );
			}
			if ( $layout == 'layout_04' ) {
				G5CORE()->options()->color()->set_option( 'site_background_color', array(
					'background_color' => '#fff'
				) );
				G5ERE()->options()->set_option( 'single_property_content_block_style', 'style-01' );
				G5ERE()->options()->set_option( 'single_property_layout', 'layout-7' );
				G5ERE()->options()->set_option( 'single_property_map_enable', 'on' );
				G5ERE()->options()->set_option( 'single_property_gallery_layout', 'thumbnail' );
				G5ERE()->options()->set_option( 'single_property_gallery_thumb_slides_to_show', '5' );
				G5ERE()->options()->set_option( 'single_property_gallery_thumb_slides_to_show_lg', '4' );
				G5ERE()->options()->set_option( 'single_property_gallery_thumb_slides_to_show_sm', '3' );
				G5ERE()->options()->set_option( 'single_property_gallery_slider_pagination_enable', 'off' );
				G5ERE()->options()->set_option( 'single_property_gallery_slider_navigation_enable', 'on' );
				G5ERE()->options()->set_option( 'single_property_gallery_image_size', 'full' );
				G5ERE()->options()->set_option( 'single_property_gallery_thumb_image_size', '374x240' );
				G5ERE()->options()->set_option( 'single_property_gallery_image_ratio',
					array(
						'width'  => 2,
						'height' => 1
					) );
			}
			if ( $layout == 'layout_05' ) {
				G5CORE()->options()->color()->set_option( 'site_background_color', array(
					'background_color' => '#fff'
				) );
				G5ERE()->options()->set_option( 'single_property_content_block_style', 'style-01' );
				G5CORE()->options()->header()->set_option('advanced_search_enable','off');
				G5ERE()->options()->set_option( 'single_property_layout', 'layout-5' );
				G5ERE()->options()->set_option( 'single_property_gallery_layout', 'metro-2' );
				G5ERE()->options()->set_option( 'single_property_gallery_image_size', 'full' );
				G5ERE()->options()->set_option( 'single_property_gallery_metro_image_ratio',
					array(
						'width'  => 4,
						'height' => 3
					) );

				G5CORE()->options()->layout()->set_option( 'site_layout', 'none' );
				G5ERE()->options()->set_option( 'single_property_content_blocks', array(
					'enable'  => array(
						'description'        => esc_html__( 'Description', 'homeid' ),
						'overview'           => esc_html__( 'Overview', 'homeid' ),
						'address'            => esc_html__( 'Address', 'homeid' ),
						'details'            => esc_html__( 'Details', 'homeid' ),
						'features'           => esc_html__( 'Features', 'homeid' ),
						'gallery'            => esc_html__( 'Gallery', 'homeid' ),
						'floor-plans'        => esc_html__( 'Floor Plans', 'homeid' ),
						'video'              => esc_html__( 'Video', 'homeid' ),
						'virtual-tour'       => esc_html__( '360° Virtual Tour', 'homeid' ),
						'attachments'        => esc_html__( 'Attachments', 'homeid' ),
						'nearby-places'      => esc_html__( 'Nearby Places', 'homeid' ),
						'walk-score'         => esc_html__( 'Walk Score', 'homeid' ),
						'contact-agent'      => esc_html__( 'Contact Agent', 'homeid' ),
						'review'             => esc_html__( 'Reviews', 'homeid' ),
						'similar-properties' => esc_html__( 'Similar Listings', 'homeid' ),
					),
					'disable' => array(
						'tabs' => esc_html__( 'Tabs Content', 'homeid' ),
					)
				) );
				G5ERE()->options()->set_option( 'similar_properties_post_columns_xl', '3' );
				G5ERE()->options()->set_option( 'similar_properties_post_columns_lg', '3' );
				G5ERE()->options()->set_option( 'similar_properties_post_columns_md', '2' );
			}
			if ( $layout == 'layout_06' ) {
				G5CORE()->options()->color()->set_option( 'site_background_color', array(
					'background_color' => '#f8f8f8'
				) );
				G5ERE()->options()->set_option( 'single_property_layout', 'layout-6' );
				G5ERE()->options()->set_option( 'single_property_gallery_layout', 'thumbnail' );
				G5ERE()->options()->set_option( 'single_property_gallery_thumb_slides_to_show', '5' );
				G5ERE()->options()->set_option( 'single_property_gallery_thumb_slides_to_show_lg', '4' );
				G5ERE()->options()->set_option( 'single_property_gallery_thumb_slides_to_show_sm', '3' );
				G5ERE()->options()->set_option( 'single_property_gallery_slider_pagination_enable', 'off' );
				G5ERE()->options()->set_option( 'single_property_gallery_slider_navigation_enable', 'off' );
				G5ERE()->options()->set_option( 'single_property_gallery_image_size', 'full' );
				G5ERE()->options()->set_option( 'single_property_gallery_thumb_image_size', '374x240' );
				G5ERE()->options()->set_option( 'single_property_content_block_style', 'style-02' );
				G5ERE()->options()->set_option( 'single_property_gallery_image_ratio',
					array(
						'width'  => 2,
						'height' => 1
					) );
			}
			if ( $layout == 'layout_07' ) {
				G5CORE()->options()->color()->set_option( 'site_background_color', array(
					'background_color' => '#f8f8f8'
				) );
				G5ERE()->options()->set_option( 'single_property_layout', 'layout-3' );
				G5ERE()->options()->set_option( 'single_property_gallery_layout', 'metro-4' );
				G5ERE()->options()->set_option( 'single_property_gallery_columns_gutter', '10' );
				G5ERE()->options()->set_option( 'single_property_gallery_metro_image_size', 'full' );
				G5ERE()->options()->set_option( 'single_property_content_block_style', 'style-02' );
				G5ERE()->options()->set_option( 'single_property_gallery_metro_image_ratio',
					array(
						'width'  => 1,
						'height' => 1
					) );
			}
			if ( $layout == 'layout_08' ) {
				G5CORE()->options()->header()->set_option('advanced_search_enable','off');
				G5CORE()->options()->color()->set_option( 'site_background_color', array(
					'background_color' => '#f8f8f8'
				) );
				G5ERE()->options()->set_option( 'single_property_layout', 'layout-9' );
				G5CORE()->options()->layout()->set_option( 'site_layout', 'none' );
				G5ERE()->options()->set_option( 'single_property_content_block_style', 'style-02' );
			}
			if ( $layout == 'layout_09' ) {
				G5CORE()->options()->color()->set_option( 'site_background_color', array(
					'background_color' => '#f8f8f8'
				) );
				G5ERE()->options()->set_option( 'single_property_layout', 'layout-4' );
				G5ERE()->options()->set_option( 'single_property_content_block_style', 'style-03' );
				G5ERE()->options()->set_option( 'single_property_gallery_layout', 'carousel' );
				G5ERE()->options()->set_option( 'single_property_gallery_slides_to_show', '1' );
				G5ERE()->options()->set_option( 'single_property_gallery_slides_to_show_lg', '1' );
				G5ERE()->options()->set_option( 'single_property_gallery_slider_pagination_enable', 'on' );
				G5ERE()->options()->set_option( 'single_property_gallery_slider_navigation_enable', 'on' );
				G5ERE()->options()->set_option( 'single_property_gallery_slider_center_enable', 'on' );
				G5ERE()->options()->set_option( 'single_property_gallery_slider_center_padding', '350px' );
				G5ERE()->options()->set_option( 'single_property_gallery_image_size', 'full' );
				G5ERE()->options()->set_option( 'single_property_gallery_image_ratio',
					array(
						'width'  => 2,
						'height' => 1
					) );

				G5ERE()->options()->set_option( 'single_property_content_blocks', array(
					'enable'  => array(
						'tabs' => esc_html__( 'Tabs Content', 'homeid' ),
					),
					'disable' => array(
						'description'        => esc_html__( 'Description', 'homeid' ),
						'overview'           => esc_html__( 'Overview', 'homeid' ),
						'address'            => esc_html__( 'Address', 'homeid' ),
						'details'            => esc_html__( 'Details', 'homeid' ),
						'features'           => esc_html__( 'Features', 'homeid' ),
						'gallery'            => esc_html__( 'Gallery', 'homeid' ),
						'floor-plans'        => esc_html__( 'Floor Plans', 'homeid' ),
						'video'              => esc_html__( 'Video', 'homeid' ),
						'virtual-tour'       => esc_html__( '360° Virtual Tour', 'homeid' ),
						'attachments'        => esc_html__( 'Attachments', 'homeid' ),
						'nearby-places'      => esc_html__( 'Nearby Places', 'homeid' ),
						'walk-score'         => esc_html__( 'Walk Score', 'homeid' ),
						'contact-agent'      => esc_html__( 'Contact Agent', 'homeid' ),
						'review'             => esc_html__( 'Reviews', 'homeid' ),
						'similar-properties' => esc_html__( 'Similar Listings', 'homeid' ),
					)
				) );
				G5ERE()->options()->set_option( 'single_property_tabs_content_blocks', array(
					'enable'  => array(
						'description'   => esc_html__( 'Description', 'homeid' ),
						'details'       => esc_html__( 'Details', 'homeid' ),
						'virtual-tour'  => esc_html__( '360° Virtual Tour', 'homeid' ),
						'features'      => esc_html__( 'Features', 'homeid' ),
						'floor-plans'   => esc_html__( 'Floor Plans', 'homeid' ),
						'nearby-places' => esc_html__( 'Nearby Places', 'homeid' ),
					),
					'disable' => array(
						'video'   => esc_html__( 'Video', 'homeid' ),
						'address' => esc_html__( 'Address', 'homeid' ),
					),
				) );
			}

			if ( in_array( $layout, array(
				'layout_01',
				'layout_02',
				'layout_03',
				'layout_04',
				'layout_06',
				'layout_07'
			) ) ) {
				G5ERE()->options()->set_option( 'single_property_content_blocks', array(
					'enable'  => array(
						'description'        => esc_html__( 'Description', 'homeid' ),
						'overview'           => esc_html__( 'Overview', 'homeid' ),
						'address'            => esc_html__( 'Address', 'homeid' ),
						'details'            => esc_html__( 'Details', 'homeid' ),
						'features'           => esc_html__( 'Features', 'homeid' ),
						'floor-plans'        => esc_html__( 'Floor Plans', 'homeid' ),
						'video'              => esc_html__( 'Video', 'homeid' ),
						'virtual-tour'       => esc_html__( '360° Virtual Tour', 'homeid' ),
						'attachments'        => esc_html__( 'Attachments', 'homeid' ),
						'nearby-places'      => esc_html__( 'Nearby Places', 'homeid' ),
						'walk-score'         => esc_html__( 'Walk Score', 'homeid' ),
						'review'             => esc_html__( 'Reviews', 'homeid' ),
						'similar-properties' => esc_html__( 'Similar Listings', 'homeid' ),

					),
					'disable' => array(
						'tabs'          => esc_html__( 'Tabs Content', 'homeid' ),
						'contact-agent' => esc_html__( 'Contact Agent', 'homeid' ),
					)
				) );
			}

		}

		public function change_overview_item_class( $class ) {
			$layout = isset( $_GET['single_property_layout'] ) ? $_GET['single_property_layout'] : '';
			if ( $layout == 'layout_08' ) {
				return 'col-sm-6 col-12';
			}

			return $class;
		}

		public function change_rating_col_class( $class ) {
			$layout = isset( $_GET['single_property_layout'] ) ? $_GET['single_property_layout'] : '';
			if ( $layout == 'layout_08' ) {
				return 'col-12';
			}

			return $class;
		}
	}
}