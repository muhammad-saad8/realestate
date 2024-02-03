<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! class_exists( 'G5Core_Listing_Abstract', false ) ) {
	G5CORE()->load_file( G5CORE()->plugin_dir( 'inc/abstract/listing.class.php' ) );
}
if ( ! class_exists( 'G5ERE_Listing_Agency' ) ) {
	class G5ERE_Listing_Agency extends G5Core_Listing_Abstract {
		private static $_instance;

		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		protected $key_layout_settings = 'g5ere_agency_layout_settings';

		public function init() {
			add_action( 'g5core_taxonomy_agency_pagination_ajax_response', array(
				$this,
				'pagination_ajax_response'
			), 10, 2 );
		}

		public function pagination_ajax_response( $settings, $query_args ) {
			$this->render_content( $query_args, $settings );
		}

		public function get_layout_settings_default() {
			return array(
				'post_layout'        => G5ERE()->options()->get_option( 'agency_layout', 'grid' ),
				'item_skin'          => G5ERE()->options()->get_option( 'agency_item_skin', 'skin-01' ),
				'item_custom_class'  => G5ERE()->options()->get_option( 'agency_item_custom_class' ),
				'post_columns'       => array(
					'xl' => intval( G5ERE()->options()->get_option( 'agency_columns_xl' ) ),
					'lg' => intval( G5ERE()->options()->get_option( 'agency_columns_lg' ) ),
					'md' => intval( G5ERE()->options()->get_option( 'agency_columns_md' ) ),
					'sm' => intval( G5ERE()->options()->get_option( 'agency_columns_sm' ) ),
				),
				'columns_gutter'     => intval( G5ERE()->options()->get_option( 'agency_columns_gutter' ) ),
				'image_size'         => G5ERE()->options()->get_option( 'agency_image_size' ),
				'post_paging'        => G5ERE()->options()->get_option( 'agency_paging' ),
				'post_animation'     => G5ERE()->options()->get_option( 'agency_animation' ),
				'itemSelector'       => 'article',
				'noFoundSelector' => '.g5core__not-found',
				'cate_filter_enable' => false,
				'post_type'          => 'taxonomy_agency',
				'taxonomy'           => 'agency',
			);
		}

		public function render_content( $query_args = null, $settings = null ) {
			if ( isset( $_REQUEST['settings'] ) ) {
				$settings = wp_parse_args( array(
					'settingId' => $_REQUEST['settings']['settingId']
				), $settings );
			}

			if ( ! isset( $query_args ) ) {
				$settings['isMainQuery'] = true;
				$query_args              = array();
			}


			$item_amount = G5ERE()->options()->get_option( 'agency_per_page' );
			if (isset($settings['posts_per_page'])) {
				$item_amount = $settings['posts_per_page'];
			}
			if ( absint( $item_amount ) == 0 ) {
				$item_amount = 9;
			}


			$default_args = array(
				'taxonomy'   => 'agency',
				'hide_empty' => false,
				'number'     => $item_amount,
				'offset'     => 0
			);

			if ( isset( $settings ) && is_array( $settings ) && ( count( $settings ) > 0 ) ) {
				$this->set_layout_settings( $settings );
			}

			$query_args    = array_merge( $default_args, $query_args );
			$post_settings = &$this->get_layout_settings();

			if ( isset( $post_settings['post_paging'] ) && $post_settings['post_paging'] != '' ) {
				if ( $item_amount != 0 ) {
					$query_args['offset'] = ( max( 1, get_query_var( 'paged' ) ) - 1 ) * $item_amount;
					if ( isset( $query_args['paged'] ) ) {
						$query_args['offset'] = ( max( 1, $query_args['paged'] ) - 1 ) * $item_amount;
					}
				}

			}
			$query_args = apply_filters( 'g5ere_change_agency_query_arg', $query_args );

			$agencies = get_terms( $query_args );
			if ( isset( $settings['toolbar'] ) ) {
				add_action( 'g5core_before_listing_agency_wrapper', array( $this, 'render_agency_toolbar' ), 10, 2 );
			}
			add_action( 'g5core_after_listing_agency_wrapper', array(
				$this,
				'render_agency_pagination'
			), 10, 2 );

			$this->render_agency_listing( $agencies, $query_args );
			if ( isset( $settings['toolbar'] ) ) {
				remove_action( 'g5core_before_listing_agency_wrapper', array( $this, 'render_agency_toolbar' ) );
			}


			remove_action( 'g5core_after_listing_agency_wrapper', array( $this, 'render_agency_pagination' ) );
			if ( isset( $settings ) && ( sizeof( $settings ) > 0 ) ) {
				$this->unset_layout_settings();
			}

		}

		public function render_agency_listing( $agencies, $query_args ) {
			G5ERE()->get_template( 'agency/listing.php', array(
				'agencies'   => $agencies,
				'query_args' => $query_args
			) );
		}

		public function get_config_layout_matrix() {
			$post_settings = $this->get_layout_settings();
			$item_skin     = isset( $post_settings['item_skin'] ) ? $post_settings['item_skin'] : 'skin-01';
			$data          = apply_filters( 'g5ere_config_layout_matrix', array(
				'grid' => array(
					'layout' => array(
						array( 'template' => $item_skin )
					),
				),
				'list' => array(
					'columns'    => 1,
					'layout'     => array(
						array( 'template' => $item_skin )
					),
					'image_mode' => 'image'
				)
			) );

			return $data;
		}

		public function render_agency_pagination( $settings, $query_args ) {
			$paged = get_query_var( 'paged' ) != 0 ? get_query_var( 'paged' ) : 1;
			if ( isset( $settings['currentPage']['paged'] ) ) {
				$paged = $settings['currentPage']['paged'];
			}

			$post_paging = $settings['post_paging'];
			if ( $post_paging !== '' && $post_paging !== 'none' ) {
				$per_page = $query_args['number'];
				unset( $query_args['number'] );
				unset( $query_args['offset'] );
				$total                      = wp_count_terms( $query_args['taxonomy'], $query_args );
				$settings['posts_per_page'] = $per_page;
				if ( $per_page > 0 ) {
					$max_num_pages = ceil( $total / $per_page );
				} else {
					$max_num_pages = 1;
				}

				$settingId             = isset( $settings['settingId'] ) ? $settings['settingId'] : uniqid();
				$settings['settingId'] = $settingId;
				if ( ( ! isset( $_REQUEST['action'] ) || empty( $_REQUEST['action'] ) ) ) {
					$ajax_query  = G5CORE()->cache()->get( 'g5core_ajax_query', array() );
					$js_variable = array(
						'settings' => $settings,
						'query'    => $query_args
					);
					foreach ( $ajax_query as $k => $v ) {
						$js_variable[ $k ] = $v;
					}

					G5CORE()->assets()->add_js_variable( $js_variable, "g5_ajax_pagination_{$settingId}" );
				}
				if ( ( $max_num_pages > 1 ) ) {
					G5CORE()->get_template("paging/{$post_paging}.php", array(
						'settingId' => $settingId,
						'isMainQuery' => isset($settings['isMainQuery']),
						'paged' => $paged,
						'max_num_pages' => $max_num_pages
					));
				}
			}

		}

		public function render_agency_toolbar( $settings, $query_args ) {
			G5ERE()->get_template( 'agency/loop/toolbar.php', array(
				'setting_args' => $settings,
				'query_args'   => $query_args
			) );
		}


	}
}