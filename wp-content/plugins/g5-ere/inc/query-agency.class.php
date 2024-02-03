<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! class_exists( 'G5ERE_Query_Agency' ) ) {
	class G5ERE_Query_Agency {
		private static $_instance;

		public static function get_instance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init() {
			add_filter( 'g5ere_change_agency_query_arg', array( $this, 'change_query_args' ) );
		}


		public function get_ordering_args_agency( $orderby = '', $order = '' ) {
			if ( ! $orderby ) {
				$orderby_value = isset( $_GET['orderby'] ) ? ere_clean( (string) wp_unslash( $_GET['orderby'] ) ) : ere_clean( get_query_var( 'orderby' ) ); // WPCS: sanitization ok, input var ok, CSRF ok.

				if ( ! $orderby_value ) {
					$orderby_value = apply_filters( 'g5ere_default_agency_orderby', G5ERE()->options()->get_option( 'agency_sorting', 'name' ) );
				}
				// Get order + orderby args from string.
				$orderby_value = explode( '-', $orderby_value );
				$orderby       = esc_attr( $orderby_value[0] );
				$order         = ! empty( $orderby_value[1] ) ? $orderby_value[1] : '';
			}

			$orderby = strtolower( $orderby );
			$order   = strtoupper( $order );
			$args    = array(
				'orderby' => $orderby,
				'order'   => ( 'ASC' === $order ) ? 'ASC' : 'DESC',
			);


			switch ( $orderby ) {
				case 'name':
					$args['orderby'] = 'name';
					$args['order']   = ( 'DESC' === $order ) ? 'DESC' : 'ASC';
					break;
				case 'date':
					$args['orderby'] = 'date';
					$args['order']   = ( 'DESC' === $order ) ? 'DESC' : 'ASC';
					break;
			}

			return apply_filters( 'g5ere_get_agency_ordering_args', $args );
		}

		public function change_query_args( $query_args ) {
			if ( g5ere_is_agency_page() ) {
				$orderby_arg = G5ERE()->query_agency()->get_ordering_args_agency();
				if ( $orderby_arg['orderby'] != '' ) {
					$query_args['orderby'] = $orderby_arg['orderby'];
					$query_args['order']   = $orderby_arg['order'];
				}


				if ( isset( $_REQUEST['key_word'] ) && $_REQUEST['key_word'] != '' ) {
					$key_word                 = $_REQUEST['key_word'];
					$query_args['name__like'] = $key_word;
				}
			}

			return $query_args;
		}
	}
}