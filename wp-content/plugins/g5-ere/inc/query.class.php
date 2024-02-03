<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! class_exists( 'G5ERE_Query' ) ) {
	class G5ERE_Query {
		private static $_instance;
		private $parameters;

        private $data;

		public static function get_instance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init() {
			if ( ! is_admin() ) {
				add_action( 'pre_get_posts', array( $this, 'pre_get_posts' ), 15 );
			}

            add_filter( 'g5ere_property_query_meta_query', array( $this, 'get_meta_query_price' ) );
            add_filter( 'g5ere_property_query_meta_query', array( $this, 'get_meta_query_area' ) );
            add_filter( 'g5ere_property_query_meta_query', array( $this, 'get_meta_query_land_area' ) );
            add_filter( 'g5ere_property_query_meta_query', array( $this, 'get_meta_query_garage' ) );
            add_filter( 'g5ere_property_query_meta_query', array( $this, 'get_meta_query_bedroom' ) );
            add_filter( 'g5ere_property_query_meta_query', array( $this, 'get_meta_query_room' ) );
            add_filter( 'g5ere_property_query_meta_query', array( $this, 'get_meta_query_bathroom' ) );
            add_filter( 'g5ere_property_query_meta_query', array( $this, 'get_meta_query_address' ) );
            add_filter( 'g5ere_property_query_meta_query', array( $this, 'get_meta_query_country' ) );
            add_filter( 'g5ere_property_query_meta_query', array( $this, 'get_meta_query_identity' ) );
            add_filter( 'g5ere_property_query_meta_query', array( $this, 'get_meta_query_custom_fields' ) );

            add_filter( 'g5ere_property_query_tax_query', array( $this, 'get_tax_query_type' ) );
            add_filter( 'g5ere_property_query_tax_query', array( $this, 'get_tax_query_status' ) );
            add_filter( 'g5ere_property_query_tax_query', array( $this, 'get_tax_query_city' ) );
            add_filter( 'g5ere_property_query_tax_query', array( $this, 'get_tax_query_label' ) );
            add_filter( 'g5ere_property_query_tax_query', array( $this, 'get_tax_query_state' ) );
            add_filter( 'g5ere_property_query_tax_query', array( $this, 'get_tax_query_neighborhood' ) );
            add_filter( 'g5ere_property_query_tax_query', array( $this, 'get_tax_query_feature' ) );

            add_action( 'g5ere_property_query', array( $this, 'get_query_search_title' ) );
            add_action( 'g5ere_property_query', array( $this, 'get_query_search_keyword' ) );
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

			// Fix property feeds.
			if ( $q->is_feed() && $q->is_post_type_archive( 'property' ) ) {
				$q->is_comment_feed = false;
			}

			if ( ! $q->is_post_type_archive( 'property' ) && ! $q->is_tax( get_object_taxonomies( 'property' ) ) ) {
				return;
			}

			/*
						if ($q->get('post_type') !== 'property') {
							return;
						}*/


			$this->property_query( $q );
		}

		/**
		 * @param $q WP_Query
		 */
		public function property_query( $q ) {
			if ( ! is_feed() ) {
				$ordering = $this->get_property_ordering_args();
				$q->set( 'orderby', $ordering['orderby'] );
				$q->set( 'order', $ordering['order'] );

				if ( isset( $ordering['meta_key'] ) && ! empty( $ordering['meta_key'] ) ) {
					$q->set( 'meta_key', $ordering['meta_key'] );
				}

				if ( isset( $ordering['ere_orderby_featured'] ) ) {
					$q->set( 'ere_orderby_featured', $ordering['ere_orderby_featured'] );
				}

				if ( isset( $ordering['ere_orderby_viewed'] ) ) {
					$q->set( 'ere_orderby_viewed', $ordering['ere_orderby_viewed'] );
				}

			}

			$q->set( 'post_status', 'publish' );
			// Query vars that affect posts shown.
			$q->set( 'meta_query', $this->get_meta_query( $q->get( 'meta_query' ), true ) );
			$q->set( 'tax_query', $this->get_tax_query( $q->get( 'tax_query' ), true ) );


			// Work out how many listing to query.
			$property_per_page = absint( G5ERE()->options()->get_option( 'property_per_page' ) );
			if ( $property_per_page <= 0 ) {
				$property_per_page = intval( get_option( 'posts_per_page' ) );
			}
			$q->set( 'posts_per_page', apply_filters( 'g5ere_property_per_page', $property_per_page ) );

            $this->init_parameter();
			do_action( 'g5ere_property_query', $q, $this );
		}

		public function get_property_ordering_args( $orderby = '', $order = '' ) {
			// Get ordering from query string unless defined.
			if ( ! $orderby ) {
				$orderby_value = isset( $_GET['orderby'] ) ? ere_clean( (string) wp_unslash( $_GET['orderby'] ) ) : ere_clean( get_query_var( 'orderby' ) ); // WPCS: sanitization ok, input var ok, CSRF ok.

				if ( ! $orderby_value ) {
					if ( is_search() ) {
						$orderby_value = 'relevance';
					} else {
						$orderby_value = apply_filters( 'g5ere_default_property_orderby', G5ERE()->options()->get_option( 'property_sorting', 'menu_order' ) );
					}
				}
				// Get order + orderby args from string.
				$orderby_value = explode( '-', $orderby_value );
				$orderby       = esc_attr( $orderby_value[0] );
				$order         = ! empty( $orderby_value[1] ) ? $orderby_value[1] : '';
			}

			$orderby = strtolower( $orderby );
			$order   = strtoupper( $order );
			$args    = array(
				'orderby'  => $orderby,
				'order'    => ( 'ASC' === $order ) ? 'ASC' : 'DESC',
				'meta_key' => '', // @codingStandardsIgnoreLine
			);
			switch ( $orderby ) {
				case 'id':
					$args['orderby'] = 'ID';
					break;
				case 'menu_order':
					$args['orderby']  = 'menu_order title';
					$featured_toplist = ere_get_option( 'featured_toplist', 1 );
					if ( $featured_toplist == 1 ) {
						$args['ere_orderby_featured'] = true;
					}
					break;
				case 'title':
					$args['orderby'] = 'title';
					$args['order']   = ( 'DESC' === $order ) ? 'DESC' : 'ASC';
					break;
				case 'relevance':
					$args['orderby'] = 'relevance';
					$args['order']   = 'DESC';
					break;
				case 'rand':
					$args['orderby'] = 'rand'; // @codingStandardsIgnoreLine
					break;
				case 'date':
					$args['orderby'] = 'date ID';
					$args['order']   = ( 'ASC' === $order ) ? 'ASC' : 'DESC';
					break;
				case 'price':
					$args['orderby']  = 'meta_value_num';
					$args['meta_key'] = ERE_METABOX_PREFIX . 'property_price';
					$args['order']    = ( 'DESC' === $order ) ? 'DESC' : 'ASC';
					break;
				case 'featured':
					$args['ere_orderby_featured'] = true;
					break;
				case 'viewed':
					$args['ere_orderby_viewed'] = true;
					break;
			}

			return apply_filters( 'g5ere_get_property_ordering_args', $args );
		}

		public function get_meta_query( $meta_query = array(), $main_query = false ) {
			if ( ! is_array( $meta_query ) ) {
				$meta_query = array();
			}

			return array_filter( apply_filters( 'g5ere_property_query_meta_query', $meta_query, $main_query, $this ) );
		}

		public function get_tax_query( $tax_query = array(), $main_query = false ) {
			if ( ! is_array( $tax_query ) ) {
				$tax_query = array(
					'relation' => 'AND',
				);
			}

			return array_filter( apply_filters( 'g5ere_property_query_tax_query', $tax_query, $main_query, $this ) );
		}

		public function get_meta_query_price( $meta_query ) {
			$min_price = isset( $_REQUEST['min-price'] ) ? ere_clean( wp_unslash( $_REQUEST['min-price'] ) ) : '';
			$max_price = isset( $_REQUEST['max-price'] ) ? ere_clean( wp_unslash( $_REQUEST['max-price'] ) ) : '';
			if ( $min_price !== '' && $max_price !== '' ) {
				$min_price = doubleval( ere_clean_double_val( $min_price ) );
				$max_price = doubleval( ere_clean_double_val( $max_price ) );
				if ( $min_price >= 0 && $max_price >= $min_price ) {
					$meta_query[] = array(
						'key'     => ERE_METABOX_PREFIX . 'property_price',
						'value'   => array( $min_price, $max_price ),
						'type'    => 'NUMERIC',
						'compare' => 'BETWEEN',
					);
				}
				$this->set_parameter( sprintf( __( 'Price: <strong>%s - %s</strong>; ', 'g5-ere' ), $min_price, $max_price ) );
                $this->set_data('min-price',$min_price);
                $this->set_data('max-price',$max_price);
			} else if ( ! empty( $min_price ) ) {
				$min_price = doubleval( ere_clean_double_val( $min_price ) );
				if ( $min_price >= 0 ) {
					$meta_query[] = array(
						'key'     => ERE_METABOX_PREFIX . 'property_price',
						'value'   => $min_price,
						'type'    => 'NUMERIC',
						'compare' => '>=',
					);
				}
				$this->set_parameter( sprintf( __( 'Min Price: <strong>%s</strong>; ', 'g5-ere' ), $min_price ) );
                $this->set_data('min-price',$min_price);
			} else if ( ! empty( $max_price ) ) {
				$max_price = doubleval( ere_clean_double_val( $max_price ) );
				if ( $max_price >= 0 ) {
					$meta_query[] = array(
						'key'     => ERE_METABOX_PREFIX . 'property_price',
						'value'   => $max_price,
						'type'    => 'NUMERIC',
						'compare' => '<=',
					);
				}
				$this->set_parameter( sprintf( __( 'Max Price: <strong>%s</strong>; ', 'g5-ere' ), $max_price ) );
                $this->set_data('max-price',$max_price);
			}

			return $meta_query;
		}

		public function get_meta_query_area( $meta_query ) {
			$min_area = isset( $_REQUEST['min-area'] ) ? ere_clean( wp_unslash( $_REQUEST['min-area'] ) ) : '';
			$max_area = isset( $_REQUEST['max-area'] ) ? ere_clean( wp_unslash( $_REQUEST['max-area'] ) ) : '';

			// min and max area logic
			if ( ! empty( $min_area ) && ! empty( $max_area ) ) {
				$min_area = intval( $min_area );
				$max_area = intval( $max_area );

				if ( $min_area >= 0 && $max_area >= $min_area ) {
					$meta_query[] = array(
						'key'     => ERE_METABOX_PREFIX . 'property_size',
						'value'   => array( $min_area, $max_area ),
						'type'    => 'NUMERIC',
						'compare' => 'BETWEEN',
					);
				}
				$this->set_parameter( sprintf( __( 'Size: <strong>%s - %s</strong>; ', 'g5-ere' ), $min_area, $max_area ) );
                $this->set_data('min-area',$min_area);
                $this->set_data('max-area',$max_area);

			} else if ( ! empty( $max_area ) ) {
				$max_area = intval( $max_area );
				if ( $max_area >= 0 ) {
					$meta_query[] = array(
						'key'     => ERE_METABOX_PREFIX . 'property_size',
						'value'   => $max_area,
						'type'    => 'NUMERIC',
						'compare' => '<=',
					);
				}
				$this->set_parameter( sprintf( __( 'Max Area: <strong> %s</strong>; ', 'g5-ere' ), $max_area ) );
                $this->set_data('max-area',$max_area);
			} else if ( ! empty( $min_area ) ) {
				$min_area = intval( $min_area );
				if ( $min_area >= 0 ) {
					$meta_query[] = array(
						'key'     => ERE_METABOX_PREFIX . 'property_size',
						'value'   => $min_area,
						'type'    => 'NUMERIC',
						'compare' => '>=',
					);
				}
				$this->set_parameter( sprintf( __( 'Min Area: <strong> %s</strong>; ', 'g5-ere' ), $min_area ) );
                $this->set_data('min-area',$min_area);
			}

			return $meta_query;
		}

		public function get_meta_query_land_area( $meta_query ) {
			$min_land_area = isset( $_REQUEST['min-land-area'] ) ? ere_clean( wp_unslash( $_REQUEST['min-land-area'] ) ) : '';
			$max_land_area = isset( $_REQUEST['max-land-area'] ) ? ere_clean( wp_unslash( $_REQUEST['max-land-area'] ) ) : '';

			if ( ! empty( $min_land_area ) && ! empty( $max_land_area ) ) {
				$min_land_area = intval( $min_land_area );
				$max_land_area = intval( $max_land_area );

				if ( $min_land_area >= 0 && $max_land_area >= $min_land_area ) {
					$meta_query[] = array(
						'key'     => ERE_METABOX_PREFIX . 'property_land',
						'value'   => array( $min_land_area, $max_land_area ),
						'type'    => 'NUMERIC',
						'compare' => 'BETWEEN',
					);
				}
				$this->set_parameter( sprintf( __( 'Land size: <strong>%s - %s</strong>; ', 'g5-ere' ), $min_land_area, $max_land_area ) );
                $this->set_data('min-land-area',$min_land_area);
                $this->set_data('max-land-area',$max_land_area);

			} else if ( ! empty( $max_land_area ) ) {
				$max_land_area = intval( $max_land_area );
				if ( $max_land_area >= 0 ) {
					$meta_query[] = array(
						'key'     => ERE_METABOX_PREFIX . 'property_land',
						'value'   => $max_land_area,
						'type'    => 'NUMERIC',
						'compare' => '<=',
					);
				}
				$this->set_parameter( sprintf( __( 'Max Land size: <strong>%s</strong>; ', 'g5-ere' ), $max_land_area ) );
                $this->set_data('max-land-area',$max_land_area);
			} else if ( ! empty( $min_land_area ) ) {
				$min_land_area = intval( $min_land_area );
				if ( $min_land_area >= 0 ) {
					$meta_query[] = array(
						'key'     => ERE_METABOX_PREFIX . 'property_land',
						'value'   => $min_land_area,
						'type'    => 'NUMERIC',
						'compare' => '>=',
					);
				}
				$this->set_parameter( sprintf( __( 'Min Land size: <strong>%s</strong>; ', 'g5-ere' ), $min_land_area ) );
                $this->set_data('min-land-area',$min_land_area);
			}

			return $meta_query;
		}

		public function get_meta_query_garage( $meta_query ) {
			$garage = isset( $_REQUEST['garage'] ) ? ere_clean( wp_unslash( $_REQUEST['garage'] ) ) : '';
			if ( ! empty( $garage ) ) {
				$garage       = sanitize_text_field( $garage );
				$meta_query[] = array(
					'key'     => ERE_METABOX_PREFIX . 'property_garage',
					'value'   => $garage,
					'type'    => 'CHAR',
					'compare' => '=',
				);
				$this->set_parameter( sprintf( __( 'Garage: <strong>%s</strong>; ', 'g5-ere' ), $garage ) );
                $this->set_data('garage',$garage);
			}

			return $meta_query;
		}

		public function get_meta_query_bedroom( $meta_query ) {
			$bedrooms = isset( $_REQUEST['bedrooms'] ) ? ere_clean( wp_unslash( $_REQUEST['bedrooms'] ) ) : '';
			if ( ! empty( $bedrooms ) ) {
				$bedrooms     = sanitize_text_field( $bedrooms );
				$meta_query[] = array(
					'key'     => ERE_METABOX_PREFIX . 'property_bedrooms',
					'value'   => $bedrooms,
					'type'    => 'CHAR',
					'compare' => '=',
				);
				$this->set_parameter( sprintf( __( 'Bedroom: <strong>%s</strong>; ', 'g5-ere' ), $bedrooms ) );
                $this->set_data('bedrooms',$bedrooms);
			}


			return $meta_query;
		}

		public function get_meta_query_room( $meta_query ) {
			$rooms = isset( $_REQUEST['rooms'] ) ? ere_clean( wp_unslash( $_REQUEST['rooms'] ) ) : '';
			if ( ! empty( $rooms ) ) {
				$rooms     = sanitize_text_field( $rooms );
				$meta_query[] = array(
					'key'     => ERE_METABOX_PREFIX . 'property_rooms',
					'value'   => $rooms,
					'type'    => 'CHAR',
					'compare' => '=',
				);
				$this->set_parameter( sprintf( __( 'Room: <strong>%s</strong>; ', 'g5-ere' ), $rooms ) );
                $this->set_data('rooms',$rooms);
			}


			return $meta_query;
		}

		public function get_meta_query_bathroom( $meta_query ) {
			$bathrooms = isset( $_REQUEST['bathrooms'] ) ? ere_clean( wp_unslash( $_REQUEST['bathrooms'] ) ) : '';
			if ( ! empty( $bathrooms ) ) {
				$bathrooms    = sanitize_text_field( $bathrooms );
				$meta_query[] = array(
					'key'     => ERE_METABOX_PREFIX . 'property_bathrooms',
					'value'   => $bathrooms,
					'type'    => 'CHAR',
					'compare' => '=',
				);
				$this->set_parameter( sprintf( __( 'Bathroom: <strong>%s</strong>; ', 'g5-ere' ), $bathrooms ) );
                $this->set_data('bathrooms',$bathrooms);
			}

			return $meta_query;
		}

		public function get_meta_query_address( $meta_query ) {
			$address = isset( $_REQUEST['address'] ) ? ere_clean( wp_unslash( $_REQUEST['address'] ) ) : '';
			if ( isset( $address ) ? $address : '' ) {
				$meta_query[] = array(
					'key'     => ERE_METABOX_PREFIX . 'property_address',
					'value'   => $address,
					'type'    => 'CHAR',
					'compare' => 'LIKE',
				);
				$this->set_parameter( sprintf( __( 'Keyword: <strong>%s</strong>; ', 'g5-ere' ), $address ) );
                $this->set_data('address',$address);

			}

			return $meta_query;
		}

		public function get_meta_query_country( $meta_query ) {
			$country = isset( $_REQUEST['country'] ) ?  wp_unslash( $_REQUEST['country'] ) : '';
			if ( ! empty( $country ) ) {
				$meta_query[] = array(
					'key'     => ERE_METABOX_PREFIX . 'property_country',
					'value'   => $country,
					'type'    => 'CHAR',
					'compare' => '=',
				);
				$this->set_parameter( sprintf( __( 'Country: <strong>%s</strong>; ', 'g5-ere' ), $country ) );
                $this->set_data('country',$country);
			}

			return $meta_query;
		}

		public function get_meta_query_identity( $meta_query ) {
			$property_identity = isset( $_REQUEST['property_identity'] ) ? ere_clean( wp_unslash( $_REQUEST['property_identity'] ) ) : '';
			if ( ! empty( $property_identity ) ) {
				$property_identity = sanitize_text_field( $property_identity );
				$meta_query[]      = array(
					'key'     => ERE_METABOX_PREFIX . 'property_identity',
					'value'   => $property_identity,
					'type'    => 'CHAR',
					'compare' => '=',
				);
				$this->set_parameter( sprintf( __( 'Property identity: <strong>%s</strong>; ', 'g5-ere' ), $property_identity ) );
                $this->set_data('property_identity',$property_identity);
			}

			return $meta_query;
		}

		public function get_meta_query_custom_fields($meta_query) {

			$additional_fields = ere_get_search_additional_fields();
			foreach ($additional_fields as $id => $title) {
				$field = ere_get_search_additional_field($id);
				if ($field === false) {
					continue;
				}
				$field_type = isset($field['field_type']) ? $field['field_type'] : 'text';
				$field_value = isset($_REQUEST[$id]) ? ere_clean( wp_unslash( $_REQUEST[$id] ) ) : '';
				if (!empty($field_value)) {
					if ($field_type === 'checkbox_list') {
						$meta_query[]      = array(
							'key'     => ERE_METABOX_PREFIX . $id,
							'value'   => $field_value,
							'type'    => 'CHAR',
							'compare' => 'LIKE',
						);
					} else {
						$meta_query[]      = array(
							'key'     => ERE_METABOX_PREFIX . $id,
							'value'   => $field_value,
							'type'    => 'CHAR',
							'compare' => '=',
						);
					}

					$this->set_parameter( sprintf( __( '%s: <strong>%s</strong>; ', 'g5-ere' ),$title , $field_value ) );
                    $this->set_data($id,$field_value);
				}
			}

			return $meta_query;
		}

		public function get_meta_query_keyword( $keyword ) {
			return array(
				'relation' => 'OR',
				array(
					'key'     => ERE_METABOX_PREFIX . 'property_address',
					'value'   => $keyword,
					'type'    => 'CHAR',
					'compare' => 'LIKE',
				),
				array(
					'key'     => ERE_METABOX_PREFIX . 'property_zip',
					'value'   => $keyword,
					'type'    => 'CHAR',
					'compare' => 'LIKE',
				),
				array(
					'key'     => ERE_METABOX_PREFIX . 'property_identity',
					'value'   => $keyword,
					'type'    => 'CHAR',
					'compare' => '=',
				)
			);
		}


		public function get_tax_query_type( $tax_query ) {
			$type = isset( $_REQUEST['type'] ) ?  wp_unslash( $_REQUEST['type'] )  : '';
			if ( ! empty( $type ) ) {
				$tax_query[] = array(
					'taxonomy' => 'property-type',
					'field'    => 'slug',
					'terms'    => $type
				);
				$this->set_parameter( sprintf( __( 'Type: <strong>%s</strong>; ', 'g5-ere' ), $type ) );
                $this->set_data('type' , $type);
			}

			return $tax_query;
		}

		public function get_tax_query_status( $tax_query ) {
			$status = isset( $_REQUEST['status'] ) ?  wp_unslash( $_REQUEST['status'] )  : '';
			if ( isset( $status ) && ! empty( $status ) ) {
				$tax_query[] = array(
					'taxonomy' => 'property-status',
					'field'    => 'slug',
					'terms'    => $status
				);
				$this->set_parameter( sprintf( __( 'Status: <strong>%s</strong>; ', 'g5-ere' ), $status ) );
                $this->set_data('status' , $status);
			}

			return $tax_query;
		}

		public function get_tax_query_city( $tax_query ) {
			$city = isset( $_REQUEST['city'] ) ?  wp_unslash($_REQUEST['city'])   : '';
			if ( ! empty( $city ) ) {
				$tax_query[] = array(
					'taxonomy' => 'property-city',
					'field'    => 'slug',
					'terms'    => $city
				);
				$this->set_parameter( sprintf( __( 'City: <strong>%s</strong>; ', 'g5-ere' ), $city ) );
                $this->set_data('city' , $city);
			}

			return $tax_query;
		}

		public function get_tax_query_label( $tax_query ) {
			$label = isset( $_REQUEST['label'] ) ?  wp_unslash( $_REQUEST['label'] )  : '';
			if ( isset( $label ) && ! empty( $label ) ) {
				$tax_query[] = array(
					'taxonomy' => 'property-label',
					'field'    => 'slug',
					'terms'    => $label
				);
				$this->set_parameter( sprintf( __( 'Label: <strong>%s</strong>; ', 'g5-ere' ), $label ) );
                $this->set_data('label' , $label);
			}

			return $tax_query;
		}

		public function get_tax_query_state( $tax_query ) {
			$state = isset( $_REQUEST['state'] ) ?  wp_unslash( $_REQUEST['state'] )  : '';
			if ( ! empty( $state ) ) {
				$tax_query[] = array(
					'taxonomy' => 'property-state',
					'field'    => 'slug',
					'terms'    => $state
				);
				$this->set_parameter( sprintf( __( 'State: <strong>%s</strong>; ', 'g5-ere' ), $state ) );
                $this->set_data('state' , $state);
			}

			return $tax_query;
		}

		public function get_tax_query_neighborhood( $tax_query ) {
			$neighborhood = isset( $_REQUEST['neighborhood'] ) ?  wp_unslash( $_REQUEST['neighborhood'] )  : '';
			if ( ! empty( $neighborhood ) ) {
				$tax_query[] = array(
					'taxonomy' => 'property-neighborhood',
					'field'    => 'slug',
					'terms'    => $neighborhood
				);
				$this->set_parameter( sprintf( __( 'Neighborhood: <strong>%s</strong>; ', 'g5-ere' ), $neighborhood ) );
                $this->set_data('neighborhood' , $neighborhood);
			}

			return $tax_query;
		}

		public function get_tax_query_feature( $tax_query ) {
			$features = isset( $_REQUEST['feature'] ) ?  wp_unslash( $_REQUEST['feature'] )  : '';
			if ( ! empty( $features )) {
				$featuresArr = explode(';',$features);
				$tax_query[] = array(
					'taxonomy' => 'property-feature',
					'field'    => 'slug',
					'terms'    => $featuresArr
				);
				$this->set_parameter( sprintf( __( 'Features: <strong>%s</strong>; ', 'g5-ere' ), implode( ', ', $featuresArr ) ) );
                $this->set_data('feature' , $features);
			}

			return $tax_query;
		}

		public function get_tax_query_keyword( $keyword ) {
			$taxlocation[] = sanitize_title( $keyword );

			return array(
				'relation' => 'OR',
				array(
					'taxonomy' => 'property-state',
					'field'    => 'slug',
					'terms'    => $taxlocation
				),
				array(
					'taxonomy' => 'property-city',
					'field'    => 'slug',
					'terms'    => $taxlocation
				),
				array(
					'taxonomy' => 'property-neighborhood',
					'field'    => 'slug',
					'terms'    => $taxlocation
				)
			);
		}

		/**
		 * @param $q WP_Query
		 *
		 */
		public function get_query_search_title( $q ) {
			$title = isset( $_REQUEST['title'] ) ? ere_clean( wp_unslash( $_REQUEST['title'] ) ) : '';
			if ( ! empty( $title ) ) {
				$q->set( 's', $title );

			}
		}

		/**
		 * @param $q WP_Query
		 *
		 */
		public function get_query_search_keyword( $q ) {
			$keyword            = isset( $_REQUEST['keyword'] ) ? ere_clean( wp_unslash( $_REQUEST['keyword'] ) ) : '';
			$keyword_meta_query = '';
			$keyword_tax_query  = '';
			if ( ! empty( $keyword ) ) {
				$this->set_parameter( sprintf( __( 'Keyword: <strong>%s</strong>; ', 'g5-ere' ), $keyword ) );
                $this->set_data('keyword', $keyword);
				$keyword_field = ere_get_option( 'keyword_field', 'prop_address' );
				if ( $keyword_field === 'prop_address' ) {
					$keyword_meta_query = $this->get_meta_query_keyword( $keyword );
				} elseif ( $keyword_field === 'prop_city_state_county' ) {
					$keyword_tax_query = $this->get_tax_query_keyword( $keyword );
				} else {
					$q->set( 's', $keyword );
				}

				if ( ! empty( $keyword_meta_query ) ) {
					$meta_query = $q->get( 'meta_query', array() );
					$meta_query = array(
						'relation' => 'AND',
						$keyword_meta_query,
						array(
							'relation' => 'AND',
							$meta_query
						),
					);
					$q->set( 'meta_query', $meta_query );
				}

				if ( ! empty( $keyword_tax_query ) ) {
					$tax_query = $q->get( 'tax_query', array() );
					$tax_query = array(
						'relation' => 'AND',
						$keyword_tax_query,
						array(
							'relation' => 'AND',
							$tax_query
						),
					);
					$q->set( 'tax_query', $tax_query );
				}
			}
		}


		public function get_similar_property_query() {
			$properties_per_page = intval( G5ERE()->options()->get_option( 'similar_properties_property_per_page', 4 ) );
			$similar_types       = G5ERE()->options()->get_option( 'similar_properties_type', array(
				'property-status',
				'property-type'
			) );
			$tax_query           = array();
			$term_ids            = array();
			foreach ( $similar_types as $similar_type ) {
				$terms = get_the_terms( get_the_ID(), $similar_type );
				if ( ! empty( $terms ) ) {
					$term_ids = wp_list_pluck( $terms, 'term_id' );
				}
				$tax_query[] = array(
					'taxonomy' => $similar_type,
					'field'    => 'id',
					'terms'    => $term_ids,
					'operator' => 'IN'
				);
			}
			$tax_count = count( $tax_query );
			if ( $tax_count > 1 ) {
				$tax_query['relation'] = 'AND';
			}
			$query_args = array(
				'posts_per_page' => $properties_per_page,
				'post_type'      => 'property',
				'post_status'    => 'publish',
				'orderby'        => 'rand',
				'tax_query'      => $tax_query,
				'post__not_in'   => array( get_the_ID() )
			);

			return apply_filters( 'g5ere_similar_property_query_args', $query_args );
		}

		public function get_agent_property_query_args( $args = array() ) {
			$args       = wp_parse_args( $args, array(
				'posts_per_page' => absint( G5ERE()->options()->get_option( 'single_agent_my_property_per_page', 4 ) ),
				'agent_id'       => get_the_ID()
			) );
			$query_args = array(
				'posts_per_page' => $args['posts_per_page'],
				'post_type'      => 'property',
				'post_status'    => 'publish',
			);
			if ( is_author() ) {
				$query_args['author'] = get_queried_object_id();
			} else {
				$query_args['meta_query'] = array(
					'relation' => 'OR',
					array(
						'key'     => ERE_METABOX_PREFIX . 'property_agent',
						'value'   => array( $args['agent_id'] ),
						'compare' => 'IN'
					)
				);
				$agent_user_id            = absint( get_post_meta( $args['agent_id'], ERE_METABOX_PREFIX . 'agent_user_id', true ) );
				if ( $agent_user_id > 0 ) {
					$query_args['meta_query'][] = array(
						'key'     => ERE_METABOX_PREFIX . 'property_author',
						'value'   => array( $agent_user_id ),
						'compare' => 'IN'
					);
				}

			}
			$ordering   = G5ERE()->query()->get_property_ordering_args();
			$query_args = wp_parse_args( $ordering, $query_args );

			return apply_filters( 'g5ere_agent_my_property_query_args', $query_args );
		}

		public function get_agency_property_query_args() {
			global $g5ere_agency;
			if ( ! g5ere_agency_visible( $g5ere_agency ) ) {
				return false;
			}
			$properties_per_page = G5ERE()->options()->get_option( 'single_agency_property_per_page', 9 );
			$agent_args          = array(
				'post_type'   => 'agent',
				'post_status' => 'publish',
				'tax_query'   => array(
					array(
						'taxonomy' => 'agency',
						'field'    => 'slug',
						'terms'    => array( $g5ere_agency->get_slug() ),
						'operator' => 'IN'
					)
				)
			);


			$agent_query = new WP_Query( $agent_args );
			$agent_ids   = array();
			$author_ids  = array();
			if ( $agent_query->have_posts() ) {
				while ( $agent_query->have_posts() ) {
					$agent_query->the_post();
					$agent_ids[]   = get_the_ID();
					$agent_user_id = absint( get_post_meta( get_the_ID(), ERE_METABOX_PREFIX . 'agent_user_id', true ) );
					if ( $agent_user_id > 0 ) {
						$author_ids[] = $agent_user_id;
					}

				}
			}
			wp_reset_query();
			$query_args = array(
				'post_type'      => 'property',
				'post_status'    => 'publish',
				'posts_per_page' => $properties_per_page,
				'meta_query'     => array(
					'relation' => 'OR',
				)
			);

			if ( ! empty( $agent_ids ) ) {
				$query_args['meta_query'][] = array(
					'key'     => ERE_METABOX_PREFIX . 'property_agent',
					'value'   => $agent_ids,
					'compare' => 'IN'
				);
			}

			if ( ! empty( $author_ids ) ) {
				$query_args['meta_query'][] = array(
					'key'     => ERE_METABOX_PREFIX . 'property_author',
					'value'   => $author_ids,
					'compare' => 'IN'
				);
			}


			return apply_filters( 'g5ere_agency_property_query_args', $query_args );
		}


        public function init_parameter() {
            $this->parameters = array();
        }
		public function set_parameter( $parameter ) {
			$this->parameters[] = $parameter;
		}

		public function get_parameters() {
			return $this->parameters;
		}

        public function init_data() {
            $this->data = array();
        }
        public function set_data( $k,$v ) {
            $this->data[$k] = $v;
        }

        public function get_data() {
            return $this->data;
        }




		public function get_property_query_args($args = array()) {
            $this->init_parameter();
			$property_per_page  = absint( G5ERE()->options()->get_option( 'property_per_page' ) );
			$ordering           = $this->get_property_ordering_args();
			$args               = wp_parse_args($args,array(
                'posts_per_page'      => $property_per_page,
                'post_type'           => 'property',
                'orderby'             => $ordering,
                'offset'              => ( max( 1, get_query_var( 'paged' ) ) - 1 ) * $property_per_page,
                'ignore_sticky_posts' => 1,
                'post_status'         => 'publish',
            )) ;
			$keyword            = isset( $_REQUEST['keyword'] ) ? ere_clean( wp_unslash( $_REQUEST['keyword'] ) ) : '';
			$keyword_meta_query = $keyword_tax_query = '';
			$meta_query         = $this->get_meta_query();
			$tax_query          = $this->get_tax_query();
			if ( count( $meta_query ) > 1 ) {
				$meta_query['relation'] = 'AND';
			}
			if ( count( $tax_query ) > 1 ) {
				$tax_query['relation'] = 'AND';
			}
			if ( ! empty( $keyword ) ) {
				$keyword_field = ere_get_option( 'keyword_field', 'prop_address' );
				if ( $keyword_field === 'prop_address' ) {
					$keyword_meta_query = $this->get_meta_query_keyword( $keyword );
				} elseif ( $keyword_field === 'prop_city_state_county' ) {
					$keyword_tax_query = $this->get_tax_query_keyword( $keyword );
				} else {
					$args['s'] = $keyword;
				}
                $this->set_data('keyword', $keyword);
			}
			if ( ! empty( $keyword_meta_query ) ) {
				$args['meta_query'] = array(
					'relation' => 'AND',
					$keyword_meta_query,
					$meta_query,
				);
			} else {
				$args['meta_query'] =
					$meta_query;
			}

			if ( ! empty( $keyword_tax_query ) ) {
				$args['tax_query'] = array(
					'relation' => 'AND',
					$keyword_tax_query,
					$tax_query
				,
				);
			} else {
				$args['tax_query'] = $tax_query;
			}

			return apply_filters( 'g5ere_property_query_args', $args );
		}
	}
}