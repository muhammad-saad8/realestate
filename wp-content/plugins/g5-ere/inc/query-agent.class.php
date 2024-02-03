<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! class_exists( 'G5ERE_Query_Agent' ) ) {
	class G5ERE_Query_Agent {
		private static $_instance;

		public static function get_instance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init() {
			if ( ! is_admin() ) {
				add_action( 'pre_get_posts', array( $this, 'pre_get_posts' ), 15 );
				add_filter('g5ere_agent_query_tax_query',array($this,'get_tax_query_agency'));
			}
		}

		/**
		 * @param $q WP_Query
		 *
		 */
		public function pre_get_posts( $q ) {
			// We only want to affect the main query.
			if ( ! $q->is_main_query() ) {
				return;
			}

			// Fix agent feeds.
			if ( $q->is_feed() && $q->is_post_type_archive( 'agent' ) ) {
				$q->is_comment_feed = false;
			}

			if ( ! $q->is_post_type_archive( 'agent' ) && ! $q->is_tax( get_object_taxonomies( 'agent' ) ) ) {
				return;
			}

			$this->agent_query( $q );
		}

		/**
		 * @param $q WP_Query
		 */
		public function agent_query( $q ) {
			if ( ! is_feed() ) {
				$ordering = $this->get_agent_ordering_args();
				$q->set( 'orderby', $ordering['orderby'] );
				$q->set( 'order', $ordering['order'] );
			}

			$q->set( 'post_status', 'publish' );
			// Query vars that affect posts shown.

			$q->set( 'tax_query', $this->get_tax_query( $q->get( 'tax_query' ), true ) );

			// Work out how many listing to query.
			$agent_per_page = absint( G5ERE()->options()->get_option( 'agent_per_page' ) );
			if ( $agent_per_page <= 0 ) {
				$agent_per_page = intval( get_option( 'posts_per_page' ) );
			}
			$q->set( 'posts_per_page', apply_filters( 'g5ere_agent_per_page', $agent_per_page ) );
		}

		public function get_tax_query( $tax_query = array(),$main_query = false) {
			if ( ! is_array( $tax_query ) ) {
				$tax_query = array(
					'relation' => 'AND',
				);
			}
			return array_filter( apply_filters( 'g5ere_agent_query_tax_query', $tax_query, $main_query, $this ) );
		}

		public function get_agent_ordering_args( $orderby = '', $order = '' ) {
			// Get ordering from query string unless defined.
			if ( ! $orderby ) {
				$orderby_value = isset( $_GET['orderby'] ) ? ere_clean( (string) wp_unslash( $_GET['orderby'] ) ) : ere_clean( get_query_var( 'orderby' ) ); // WPCS: sanitization ok, input var ok, CSRF ok.

				if ( ! $orderby_value ) {
					if ( is_search() ) {
						$orderby_value = 'relevance';
					} else {
						$orderby_value = apply_filters( 'g5ere_default_agent_orderby', G5ERE()->options()->get_option( 'agent_sorting', 'menu_order' ) );
					}
				}
				// Get order + orderby args from string.
				$orderby_value = explode( '-', $orderby_value );
				$orderby       = esc_attr( $orderby_value[0] );
				$order         = ! empty( $orderby_value[1] ) ? $orderby_value[1] : '';
			}

			$orderby = strtolower( $orderby );
			$order   = strtoupper( $order );

			$args = array(
				'orderby'  => $orderby,
				'order'    => ( 'ASC' === $order ) ? 'ASC' : 'DESC',
				'meta_key' => '',
			);
			switch ( $orderby ) {
				case 'menu_order':
					$args['orderby'] = 'menu_order date';
					break;

				case 'post_title':
					$args['orderby'] = 'post_title';
					$args['order']   = ( 'DESC' === $order ) ? 'DESC' : 'ASC';
					break;

				case 'relevance':
					$args['orderby'] = 'relevance';
					$args['order']   = 'DESC';
					break;

				case 'rand':
					$args['orderby'] = 'rand';
					break;
				case 'date':
					$args['orderby'] = 'date';
					$args['order']   = ( 'DESC' === $order ) ? 'DESC' : 'ASC';
					break;
			}

			return apply_filters( 'g5ere_get_agent_ordering_args', $args );
		}

		public function get_tax_query_agency($tax_query) {
			$agency = isset( $_GET['company'] ) ?  wp_unslash( $_GET['company'] )  : '';
			if (!empty($agency)) {
				$tax_query[] = array(
					'taxonomy' => 'agency',
					'field' => 'slug',
					'terms' => $agency,
					'operator' => 'IN'
				);
			}
			return $tax_query;
		}

		public function get_my_property_query_args() {
			$posts_per_page = absint(G5ERE()->options()->get_option('single_agent_my_property_per_page',4));
			$query_args = array(
				'posts_per_page' => $posts_per_page,
				'post_type'      => 'property',
				'post_status'    => 'publish',
				'meta_query' => array(
					array(
						'key' => ERE_METABOX_PREFIX . 'property_agent',
						'value' => array(get_the_ID()),
						'compare' => 'IN'
					)
				)
			);
			$ordering = G5ERE()->query()->get_property_ordering_args();
			$query_args = wp_parse_args($ordering,$query_args);
			return apply_filters('g5ere_agent_my_property_query_args',$query_args) ;
		}

		public function get_other_agent_query_args($args = array()) {
			$args = wp_parse_args($args,array(
				'posts_per_page' => absint(G5ERE()->options()->get_option('other_agent_per_page',4)),
				'agent_id' => get_the_ID(),
				'algorithm' => 'agency'
			));

			$tax_query            = array();
			$term_ids             = array();
			if ($args['algorithm'] === 'agency') {
				$terms = get_the_terms( $args['agent_id'], 'agency' );
				if ( ! empty( $terms ) ) {
					$term_ids = wp_list_pluck( $terms, 'term_id' );
				}
				$tax_query[] = array(
					'taxonomy' => 'agency',
					'field'    => 'id',
					'terms'    => $term_ids,
					'operator' => 'IN'
				);
			}
			$query_args = array(
				'posts_per_page' => $args['posts_per_page'],
				'post_type'      => 'agent',
				'post_status'    => 'publish',
				'post__not_in'   => array( $args['agent_id'] ),
				'tax_query'      => $tax_query
			);
			$ordering = $this->get_agent_ordering_args();
			$query_args = wp_parse_args($ordering,$query_args);
			return apply_filters('g5ere_other_agent_query_args',$query_args) ;
		}

		public function get_agency_agent_query_args() {
			global $g5ere_agency;
			if ( ! g5ere_agency_visible( $g5ere_agency ) ) {
				return false;
			}
			$order_by        = G5ERE()->options()->get_option( 'single_agency_agent_sorting', 'menu_order' );
			$order_by_args   = $this->get_agent_ordering_args( $order_by );
			$agent_per_page  = absint( G5ERE()->options()->get_option( 'single_agency_agent_per_page' ) );
			$args            = array(
				'post_type'      => 'agent',
				'posts_per_page' => $agent_per_page,
				'post_status'    => 'publish',
				'tax_query'      => array(
					array(
						'taxonomy' => 'agency',
						'field'    => 'slug',
						'terms'    => array( $g5ere_agency->get_slug() ),
						'operator' => 'IN'
					)
				)
			);
			$args['orderby'] = $order_by_args['orderby'];
			$args['order']   = $order_by_args['order'];

			return apply_filters( 'g5ere_agency_agent_query_args', $args );
		}

	}
}