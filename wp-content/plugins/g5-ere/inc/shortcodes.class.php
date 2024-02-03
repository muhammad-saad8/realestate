<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! class_exists( 'G5ERE_Shortcodes' ) ) {
	class G5ERE_Shortcodes {
		private static $_instance;

		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init() {
			add_filter( 'g5element_shortcodes_list', array( $this, 'add_shortcodes_list' ) );
			add_action( 'vc_after_mapping', array( $this, 'auto_complete' ) );
			add_action( 'vc_after_mapping', array( $this, 'agent_auto_complete' ) );
			add_filter( 'g5element_vc_lean_map_config', array( $this, 'vc_lean_map_config' ), 10, 2 );
			add_filter( 'g5element_autoload_class_path', array( $this, 'change_autoload_class_path' ), 10, 3 );
			add_filter( 'g5element_shortcode_template', array( $this, 'change_shortcode_template' ), 10, 2 );
			add_filter( 'g5element_shortcode_listing_query_args', array( $this, 'set_query_args' ), 10, 2 );
			add_filter( 'g5element_shortcode_listing_query_args', array( $this, 'set_query_agent_args' ), 10, 2 );
			add_filter( 'g5element_shortcode_listing_query_args', array( $this, 'set_query_agency_args' ), 10, 2 );
			add_filter( 'g5element_shortcode_assets', array( $this, 'shortcode_assets' ) );
			add_filter( 'g5element_map_style_config', array( $this, 'change_config_shortcode_map' ) );
			add_shortcode('g5element_ere_dashboards',array($this,'g5element_ere_dashboards_callback'));
			add_shortcode('g5element_ere_reviews',array($this,'g5element_ere_reviews_callback'));
			add_action( 'vc_before_init', array($this,'g5element_ere_dashboards_integrateWithVC' ));
			add_action('wp_enqueue_scripts',array($this,'enqueue_assets_for_shortcode'));
		}

		public function add_shortcodes_list( $shortcodes ) {
			return wp_parse_args( $this->get_shortcodes(), $shortcodes );
		}

		public function get_shortcodes() {
			return apply_filters( 'g5ere_shortcodes', array(
				'property_search_form',
				'properties',
				'properties_slider',
				'properties_carousel',
				'agent',
				'agent_slider',
				'agency',
				'agency_slider',
				'properties_locations',
				'agent_search',
				'agent_singular',
				'agency_search',
			) );
		}

		public function get_auto_complete_fields() {
			return apply_filters( 'g5ere_auto_complete_fields', array(
				'g5element_pproperties_locations_ids',
				'g5element_properties_ids',
				'g5element_properties_slider_ids',
				'g5element_properties_carousel_ids'
			) );
		}

		public function auto_complete() {
			$auto_complete_fields = $this->get_auto_complete_fields();
			foreach ( $auto_complete_fields as $auto_complete_field ) {
				//Filters For autocomplete param:
				add_filter( "vc_autocomplete_{$auto_complete_field}_callback", array(
					&$this,
					'post_search',
				), 10, 1 ); // Get suggestion(find). Must return an array
				add_filter( "vc_autocomplete_{$auto_complete_field}_render", array(
					&$this,
					'post_render',
				), 10, 1 ); // Render exact product. Must return an array (label,value)
			}
		}

		public function post_search( $search_string ) {
			$query                           = $search_string;
			$data                            = array();
			$args                            = array(
				's'         => $query,
				'post_type' => 'property',
			);
			$args['vc_search_by_title_only'] = true;
			$args['numberposts']             = - 1;
			if ( 0 === strlen( $args['s'] ) ) {
				unset( $args['s'] );
			}
			add_filter( 'posts_search', 'vc_search_by_title_only', 500, 2 );
			$posts = get_posts( $args );
			if ( is_array( $posts ) && ! empty( $posts ) ) {
				foreach ( $posts as $post ) {
					$data[] = array(
						'value' => $post->ID,
						'label' => $post->post_title,
						'group' => $post->post_type,
					);
				}
			}

			return $data;
		}

		public function post_render( $value ) {
			$post = get_post( $value['value'] );

			return is_null( $post ) ? false : array(
				'label' => $post->post_title,
				'value' => $post->ID
			);
		}

		public function get_agent_auto_complete_fields() {
			return apply_filters( 'g5ere_agent_auto_complete_fields', array(
				'g5element_agent_ids',
				'g5element_agent_slider_ids',
				'g5element_agent_singular_id',
			) );
		}

		public function agent_auto_complete() {
			$auto_complete_fields = $this->get_agent_auto_complete_fields();
			foreach ( $auto_complete_fields as $auto_complete_field ) {
				//Filters For autocomplete param:
				add_filter( "vc_autocomplete_{$auto_complete_field}_callback", array(
					&$this,
					'agent_search',
				), 10, 1 ); // Get suggestion(find). Must return an array
				add_filter( "vc_autocomplete_{$auto_complete_field}_render", array(
					&$this,
					'agent_render',
				), 10, 1 ); // Render exact product. Must return an array (label,value)
			}
		}

		public function agent_search( $search_string ) {
			$query                           = $search_string;
			$data                            = array();
			$args                            = array(
				's'         => $query,
				'post_type' => 'agent',
			);
			$args['vc_search_by_title_only'] = true;
			$args['numberposts']             = - 1;
			if ( 0 === strlen( $args['s'] ) ) {
				unset( $args['s'] );
			}
			add_filter( 'posts_search', 'vc_search_by_title_only', 500, 2 );
			$posts = get_posts( $args );
			if ( is_array( $posts ) && ! empty( $posts ) ) {
				foreach ( $posts as $post ) {
					$data[] = array(
						'value' => $post->ID,
						'label' => $post->post_title,
						'group' => $post->post_type,
					);
				}
			}

			return $data;
		}

		public function agent_render( $value ) {
			$post = get_post( $value['value'] );

			return is_null( $post ) ? false : array(
				'label' => $post->post_title,
				'value' => $post->ID
			);
		}

		public function vc_lean_map_config( $vc_map_config, $key ) {
			if ( in_array( $key, $this->get_shortcodes() ) ) {
				$file_name     = str_replace( '_', '-', $key );
				$vc_map_config = G5ERE()->locate_template( "shortcodes/{$file_name}/config.php" );
			}

			return $vc_map_config;
		}

		public function change_autoload_class_path( $path, $shortcode, $file_name ) {
			if ( in_array( $shortcode, $this->get_shortcodes() ) ) {
				$path = G5ERE()->locate_template( "shortcodes/{$file_name}/{$file_name}.php" );
			}

			return $path;
		}

		public function change_shortcode_template( $template, $template_name ) {
			if ( in_array( $template_name, $this->get_shortcodes() ) ) {
				$template_name = str_replace( '_', '-', $template_name );
				$template      = G5ERE()->locate_template( "shortcodes/{$template_name}/template.php" );
			}

			return $template;
		}

		public function set_query_args( $query_args, $atts ) {
			if ( $query_args['post_type'] === 'property' ) {

				$query_args['meta_query'] = array();

				$query_args['tax_query'] = array(
					'relation' => 'AND',
				);

				if ( isset( $atts['sorting'] ) ) {
					$orderby_value = explode( '-', $atts['sorting'] );
					$orderby       = esc_attr( $orderby_value[0] );
					$order         = ! empty( $orderby_value[1] ) ? $orderby_value[1] : '';

					$ordering = G5ERE()->query()->get_property_ordering_args( $orderby, $order );

					$query_args['orderby'] = $ordering['orderby'];
					$query_args['order']   = $ordering['order'];


					if ( isset( $ordering['meta_key'] ) && ! empty( $ordering['meta_key'] ) ) {
						$query_args['meta_key'] = $ordering['meta_key'];
					}

					if ( isset( $ordering['ere_orderby_featured'] ) ) {
						$query_args['ere_orderby_featured'] = $ordering['ere_orderby_featured'];
					}

					if ( isset( $ordering['ere_orderby_viewed'] ) ) {
						$query_args['ere_orderby_viewed'] = $ordering['ere_orderby_viewed'];
					}
				}


				if ( ! isset( $atts['show'] ) ) {
					$atts['show'] = '';
				}

				switch ( $atts['show'] ) {
					case 'featured':
						$query_args['meta_query'][] = array(
							'key'     => ERE_METABOX_PREFIX . 'property_featured',
							'value'   => 1,
							'compare' => '=',
						);
						break;
					case 'new-in':
						$query_args['orderby'] = 'date ID';
						$query_args['order']   = 'DESC';
						break;
					case 'property':
						$query_args['post__in']       = array_filter( explode( ',', $atts['ids'] ), 'absint' );
						$query_args['posts_per_page'] = - 1;
						$query_args['orderby']        = 'post__in';
						break;
				}

				if ( $atts['show'] !== 'property' ) {
					$taxonomy_narrow = array(
						'property_type'         => 'property-type',
						'property_status'       => 'property-status',
						'property_feature'      => 'property-feature',
						'property_label'        => 'property-label',
						'property_state'        => 'property-state',
						'property_city'         => 'property-city',
						'property_neighborhood' => 'property-neighborhood',
					);

					foreach ( $taxonomy_narrow as $k => $v ) {
						if ( ! empty( $atts[ $k ] ) ) {
							$query_args['tax_query'][] = array(
								'taxonomy' => $v,
								'terms'    => array_filter( explode( ',', $atts[ $k ] ), 'absint' ),
								'field'    => 'id',
								'operator' => 'IN'
							);
						}
					}

				}
			}

			return $query_args;
		}

		public function set_query_agent_args( $query_args, $atts ) {
			if ( $query_args['post_type'] === 'agent' ) {

				if ( isset( $atts['sorting'] ) ) {
					$orderby_value = explode( '-', $atts['sorting'] );
					$orderby       = esc_attr( $orderby_value[0] );
					$order         = ! empty( $orderby_value[1] ) ? $orderby_value[1] : '';

					$ordering = G5ERE()->query_agent()->get_agent_ordering_args( $orderby, $order );

					$query_args['orderby'] = $ordering['orderby'];
					$query_args['order']   = $ordering['order'];
				}

				switch ( $atts['show'] ) {
					case 'new-in':
						$query_args['orderby'] = 'date';
						$query_args['order']   = 'DESC';
						break;
					case 'agent':
						$query_args['post__in']       = array_filter( explode( ',', $atts['ids'] ), 'absint' );
						$query_args['posts_per_page'] = - 1;
						$query_args['orderby']        = 'post__in';
						break;
				}


				if ( ! empty( $atts['agency'] ) ) {
					$query_args['tax_query'][] = array(
						'taxonomy' => 'agency',
						'terms'    => array_filter( explode( ',', $atts['agency'] ), 'absint' ),
						'field'    => 'id',
						'operator' => 'IN'
					);
				}

			}

			return $query_args;
		}

		public function set_query_agency_args( $query_args, $atts ) {
			if ( isset( $query_args['taxonomy'] ) && $query_args['taxonomy'] === 'agency' ) {
				unset( $query_args['post_type'] );
				unset( $query_args['post_status'] );
				unset( $query_args['ignore_sticky_posts'] );
				unset( $query_args['posts_per_page'] );
				unset( $query_args['no_found_rows'] );
				$query_args['number'] = $atts['posts_per_page'];
				if ( ! empty( $atts['posts_per_page'] ) ) {
					$query_args['number'] = absint( $atts['posts_per_page'] );
				}
				if ( ! empty( $atts['offset'] ) ) {
					$query_args['offset'] = absint( $atts['offset'] );
				}
				if ( isset( $atts['sorting'] ) ) {
					$orderby_value = explode( '-', $atts['sorting'] );
					$orderby       = esc_attr( $orderby_value[0] );
					$order         = ! empty( $orderby_value[1] ) ? $orderby_value[1] : '';

					$ordering = G5ERE()->query_agency()->get_ordering_args_agency( $orderby, $order );

					$query_args['orderby'] = $ordering['orderby'];
					$query_args['order']   = $ordering['order'];
				}

				if ( ! empty( $atts['agency'] ) ) {
					$query_args['term_taxonomy_id'] = ( explode( ',', $atts['agency'] ) );
					$query_args['number']           = '';
				}

			}

			return $query_args;
		}

		public function shortcode_assets( $assets ) {
			return wp_parse_args( array(
				'properties_slider'    => array(
					'js'  => G5ERE()->asset_url( 'assets/shortcode-js/properties-slider.min.js' ),
				),
			), $assets );
		}

		public function change_config_shortcode_map( $configs ) {
			$map_services = G5ERE()->options()->get_option( 'map_service', 'google' );
			if ( $map_services == 'google' ) {
				$configs = array_flip( G5ERE()->settings()->get_google_map_skins() );
			} elseif ( $map_services == 'mapbox' ) {
				$configs = array_flip( G5ERE()->settings()->get_mapbox_skins() );
			}
			array_unshift( $configs, esc_html__( 'Default', 'g5-ere' ) );

			return $configs;
		}

		public function g5element_ere_dashboards_callback($atts) {
			if(!is_user_logged_in()){
				return ere_get_template_html('global/access-denied.php',array('type'=>'not_login'));
			}
			ob_start();
				G5ERE()->get_template('shortcodes/dashboard.php',$atts);
			return ob_get_clean();
		}

		public function g5element_ere_reviews_callback($atts = array()) {
			if(!is_user_logged_in()){
				return ere_get_template_html('global/access-denied.php',array('type'=>'not_login'));
			}
			ob_start();
				$atts = wp_parse_args($atts,array(
					'reviews_per_page' => ''
				));
				G5ERE()->get_template('shortcodes/reviews.php',$atts);
			return ob_get_clean();
		}

		public function g5element_ere_dashboards_integrateWithVC() {
			vc_map(
				array(
					'base'        => 'g5element_ere_dashboards',
					'name'        => esc_html__( 'ERE Dashboards', 'g5-ere' ),
					'category'    => G5ERE()->shortcodes()->get_category_name(),
					'icon'        => 'g5element-vc-icon-dashboards',
					'description' => esc_html__( 'Display ere dashboards', 'g5-ere' ),
					'params'      => array(
					)
				)
			);

			vc_map(
				array(
					'base'        => 'g5element_ere_reviews',
					'name'        => esc_html__( 'ERE Reviews', 'g5-ere' ),
					'category'    => G5ERE()->shortcodes()->get_category_name(),
					'icon'        => 'g5element-vc-icon-review',
					'description' => esc_html__( 'Display reviews', 'g5-ere' ),
					'params'      => 		array(
						array(
							'param_name'  => 'reviews_per_page',
							'heading'     => esc_html__( 'Review Per Page', 'g5-ere' ),
							'description' => esc_html__( 'Enter number of review per page you want to display. Default 5', 'g5-ere' ),
							'type'        => 'g5element_number',
							'std'         => '',
						)
					),
				)
			);
		}

		public function enqueue_assets_for_shortcode() {
			if (g5ere_is_dashboard()) {
				wp_enqueue_style('ere_dashboards',G5ERE()->asset_url( 'assets/shortcode-css/ere-dashboards.min.css'),array(),G5ERE()->plugin_ver());
			}
		}

		public function get_category_name()
		{
			return esc_html__('G5 ERE','g5-ere');
		}

	}
}