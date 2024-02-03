<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

function g5ere_sort_by_order_callback( $a, $b ) {
	if ( ! isset( $a['priority'] ) ) {
		$a['priority'] = 100;
	}
	if ( ! isset( $b['priority'] ) ) {
		$b['priority'] = 100;
	}

	return $a['priority'] === $b['priority'] ? 0 : ( $a['priority'] > $b['priority'] ? 1 : - 1 );
}

function g5ere_content_callback( $k ) {
	if ( isset( $k['callback'] ) ) {
		ob_start();
		call_user_func( $k['callback'], $k );
		$content      = ob_get_clean();
		$k['content'] = $content;
	}

	return $k;
}

function g5ere_filter_content_callback( $k ) {
	return isset( $k['content'] ) && ! empty( $k['content'] );
}

function g5ere_get_icon_svg( $icon ) {
	return G5ERE_Icon::get_instance()->get_svg( $icon );
}


function g5ere_query_string_form_fields( $values = null, $exclude = array(), $current_key = '', $return = false ) {
	if ( is_null( $values ) ) {
		$values = $_GET; // WPCS: input var ok, CSRF ok.
	} elseif ( is_string( $values ) ) {
		$url_parts = wp_parse_url( $values );
		$values    = array();

		if ( ! empty( $url_parts['query'] ) ) {
			parse_str( $url_parts['query'], $values );
		}
	}
	$html = '';

	foreach ( $values as $key => $value ) {
		if ( in_array( $key, $exclude, true ) ) {
			continue;
		}
		if ( $current_key ) {
			$key = $current_key . '[' . $key . ']';
		}
		if ( is_array( $value ) ) {
			$html .= g5ere_query_string_form_fields( $value, $exclude, $key, true );
		} else {
			$html .= '<input type="hidden" name="' . esc_attr( $key ) . '" value="' . esc_attr( wp_unslash( $value ) ) . '" />';
		}
	}

	if ( $return ) {
		return $html;
	}

	echo $html; // WPCS: XSS ok.
}

if ( ! function_exists( 'g5ere_get_array_by_path' ) ) {
	/**
	 * Get config by path
	 *
	 * @param $arr array
	 * @param $path string - Example: root/key1/key2
	 *
	 * @return array
	 */
	function &g5ere_get_array_by_path( &$arr, $path ) {
		if ( $path == '' ) {
			return $arr;
		}

		$result = &$arr;
		$path   = explode( '/', $path );

		foreach ( $path as $key ) {
			if ( ! isset( $result[ $key ] ) ) {
				return null;
			}
			$result = &$result[ $key ];
		}

		return $result;
	}
}

if ( ! function_exists( 'g5ere_append_array' ) ) {
	/**
	 * Append array into array
	 *
	 * @param $arr
	 * @param $path
	 * @param $insert_value
	 *
	 * @return array
	 */
	function &g5ere_append_array( &$arr, $path, $insert_value ) {
		$found_element = &g5ere_get_array_by_path( $arr, $path );
		if ( $found_element === null ) {
			return $arr;
		}
		$found_element = array_merge( $found_element, $insert_value );

		return $arr;
	}
}

if ( ! function_exists( 'g5ere_prepend_array' ) ) {
	/**
	 * Prepend array into array
	 *
	 * @param $arr
	 * @param $path
	 * @param $insert_value
	 *
	 * @return array
	 */
	function &g5ere_prepend_array( &$arr, $path, $insert_value ) {
		$found_element = &g5ere_get_array_by_path( $arr, $path );
		if ( $found_element === null ) {
			return $arr;
		}
		$found_element = array_merge( $insert_value, $found_element );

		return $arr;
	}
}

if ( ! function_exists( 'g5ere_insert_array' ) ) {
	/**
	 * Insert a array into another array
	 *
	 * @param $arr
	 * @param $path
	 * @param $insert_value
	 * @param bool $after
	 *
	 * @return array
	 */
	function &g5ere_insert_array( &$arr, $path, $insert_value, $after = false ) {
		$path_arr = explode( '/', $path );

		$last_key = array_pop( $path_arr );
		$path     = join( '/', $path_arr );

		$found_element = &g5ere_get_array_by_path( $arr, $path );


		if ( $found_element === null ) {
			return $arr;
		}

		$pos = g5ere_get_position_array_key( $found_element, $last_key );

		if ( $pos === null ) {
			if ( $after ) {
				$found_element = array_merge( $found_element, $insert_value );
			} else {
				$found_element = array_merge( $insert_value, $found_element );
			}
		} else {
			if ( $after ) {
				$found_element = array_merge(
					array_slice( $found_element, 0, $pos + 1, true ),
					$insert_value,
					array_slice( $found_element, $pos + 1, count( $found_element ), true ) );
			} else {
				$found_element = array_merge(
					array_slice( $found_element, 0, $pos, true ),
					$insert_value,
					array_slice( $found_element, $pos, count( $found_element ), true ) );
			}
		}

		return $arr;
	}
}

if ( ! function_exists( 'g5ere_get_position_array_key' ) ) {
	/**
	 * Get index of array key in the array
	 *
	 * @param $arr
	 * @param $key
	 *
	 * @return int|null
	 */
	function g5ere_get_position_array_key( &$arr, $key ) {
		if ( ! isset( $arr[ $key ] ) ) {
			return null;
		}
		$pos = 0;
		foreach ( $arr as $k => $v ) {
			if ( $k === $key ) {
				return $pos;
			}
			$pos ++;
		}

		return null;
	}
}

function g5ere_lazy_load_is_active() {
	return class_exists('G5Core_Lazy_Load') && G5Core_Lazy_Load::getInstance()->is_active();
}

