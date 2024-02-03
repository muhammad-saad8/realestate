<?php
/**
 * Render content with shortcode
 *
 * @param $content
 * @param bool $echo
 *
 * @return mixed|void
 */
function g5element_shortcode_content( $content, $echo = true ) {
	//$content = apply_filters( 'the_content', $content );
	$content = do_shortcode($content);
	$content = str_replace( ']]>', ']]&gt;', $content );
	if ( ! $echo ) {
		return $content;
	}
	printf( '%s', $content );
}

/**
 * Render checked attribute
 *
 * @param $select_value
 * @param $current_value
 */
function g5element_attr_the_checked( $select_value, $current_value ) {
	echo ( ( is_array( $current_value ) && in_array( $select_value, $current_value ) )
	       || ( ! is_array( $current_value ) && ( $select_value == $current_value ) ) )
		? 'checked="checked"' : '';
}

/**
 * Render selected attribute
 *
 * @param $select_value
 * @param $current_value
 */
function g5element_attr_the_selected( $select_value, $current_value ) {
	echo ( ( is_array( $current_value ) && in_array( $select_value, $current_value ) )
	       || ( ! is_array( $current_value ) && ( $select_value == $current_value ) ) )
		? 'selected="selected"' : '';
}

function g5element_typography_class( $value, &$typography_arr = null, $auto_add_css = true) {
	$class_name = 'gel-' . hash( 'md5', $value );

	if ( G5CORE()->cache()->get( $class_name ) !== null ) {
		return $class_name;
	}

	$value = json_decode( urldecode( $value ), true );
	if ( ! is_array( $value ) ) {
		$value = array();
	}
	$value = wp_parse_args( $value, array(
		'font_family'    => '',
		'font_weight'    => '',
		'font_style'     => '',
		'font_size_lg'   => '',
		'font_size_md'   => '',
		'font_size_sm'   => '',
		'font_size_xs'   => '',
		'align'          => '',
		'text_transform' => '',
		'line_height'    => '',
		'letter_spacing' => '',
		'color'          => '',
		'hover_color'    => ''
	) );
	$typography_arr = $value;

	$style_css = [];
	if ( $value['font_family'] !== '' ) {
		$style_css[] = "font-family: {$value['font_family']}!important";
	}
	if ( $value['font_weight'] !== '' ) {
		$style_css[] = "font-weight: {$value['font_weight']}!important";
	}
	if ( $value['font_style'] !== '' ) {
		$style_css[] = "font-style: {$value['font_style']}!important";
	}
	if ( $value['font_size_lg'] !== '' ) {
		$style_css[] = "font-size: {$value['font_size_lg']}px!important";
	}
	if ( $value['align'] !== '' ) {
		$style_css[] = "text-align: {$value['align']}!important";
	}
	if ( $value['text_transform'] !== '' ) {
		$style_css[] = "text-transform: {$value['text_transform']}!important";
	}
	if ( $value['line_height'] !== '' ) {
		$style_css[] = "line-height: {$value['line_height']}!important";
	}
	if ( $value['letter_spacing'] !== '' ) {
		$style_css[] = "letter-spacing: {$value['letter_spacing']}!important";
	}

	if ( $value['color'] !== '' ) {
		$color = $value['color'];
		if ( ! g5core_is_color( $color ) ) {
			$color = g5core_get_color_from_option( $color );
		}
		if ( $color !== '' ) {
			$style_css[] = "color: {$color}!important";
		}
	}

	$css = '';
	if ( ! empty( $style_css ) ) {
		$css .= sprintf( '.%s{%s}', $class_name, join( ';', $style_css ) );
	}

	if ( $value['hover_color'] !== '' ) {
		$hover_color = $value['hover_color'];
		if ( ! g5core_is_color( $hover_color ) ) {
			$hover_color = g5core_get_color_from_option( $hover_color );
		}

		if ( $hover_color !== '' ) {
			$css .= sprintf( '.%s:hover{%s}', $class_name, "color:{$hover_color}!important" );
			$css .= sprintf( '.%s >a:hover{%s}', $class_name, "color:{$hover_color}!important" );
		}
	}

	// Responsive font-size
	if ( $value['font_size_md'] !== '' ) {
		$css .= sprintf( '@media (max-width: 1199px) {.%s{%s}}', $class_name, "font-size: {$value['font_size_md']}px!important" );
	}
	if ( $value['font_size_sm'] !== '' ) {
		$css .= sprintf( '@media (max-width: 991px) {.%s{%s}}', $class_name, "font-size: {$value['font_size_sm']}px!important" );
	}
	if ( $value['font_size_xs'] !== '' ) {
		$css .= sprintf( '@media (max-width: 767px) {.%s{%s}}', $class_name, "font-size: {$value['font_size_xs']}px!important" );
	}

	if ( empty( $css ) ) {
		return '';
	}

	if ($auto_add_css) {
		G5CORE()->custom_css()->addCss( $css, $class_name );
		G5CORE()->cache()->set( $class_name, true );
	}

	return $class_name;
}

/**
 * Build Link
 *
 * @param $link
 * @param array $link_attr
 *
 * @return array
 */
function g5element_build_link( $link, $link_attr = array() ) {
	$res_link    = array(
		'before' => '',
		'after'  => ''
	);
	$before_link = array();

	if ( ($link !== '') && ($link !== '|') && ($link !== '||') && ($link !== '|||') ) {
		$link = vc_build_link( $link );

		if ($link['url'] !== '') {
			$before_link['href'] = esc_url($link['url']);

			if ( $link['title'] ) {
				$before_link['title'] = esc_attr( $link['title'] );
			}

			if ( $link['target'] ) {
				$before_link['target'] = esc_attr( $link['target'] );
			}

			if ( $link['rel'] ) {
				$before_link['rel'] = esc_attr( $link['rel'] );
			}
		}
	}

	foreach ( $link_attr as $key => $value ) {
		if ( isset( $before_link[ $key ] ) ) {
			continue;
		}
		$before_link[ $key ] = $value;
	}

	if ( isset( $before_link['href'] ) && ( $before_link['href'] !== '' ) ) {
		$link_attr = array();
		foreach ( $before_link as $link_key => $link_value ) {
			$link_attr[] = "{$link_key}=\"{$link_value}\"";
		}

		$res_link['before'] = sprintf( '<a %s>', join( ' ', $link_attr ) );
		$res_link['after']  = '</a>';
	}

	return $res_link;
}

/**
 * Render button
 *
 * @param $link_param
 */
function g5element_render_button(
	$title, $link = '', $style = 'classic', $shape = 'outline', $size = 'md',
	$color = 'accent', $is_button_3d = '', $icon_font = '', $icon_align = 'left'
) {
	if ( $title === '' ) {
		return;
	}

	$btn_attrs = array();

	$btn_attrs[] = sprintf( 'title="%s"', $title );
	$btn_attrs[] = sprintf( 'link="%s"', $link );
	$btn_attrs[] = sprintf( 'style="%s"', $style );
	$btn_attrs[] = sprintf( 'shape="%s"', $shape );
	$btn_attrs[] = sprintf( 'size="%s"', $size );
	$btn_attrs[] = sprintf( 'color="%s"', $color );
	$btn_attrs[] = sprintf( 'is_button_3d="%s"', $is_button_3d );
	$btn_attrs[] = sprintf( 'icon_font="%s"', $icon_font );
	$btn_attrs[] = sprintf( 'icon_align="%s"', $icon_align );

	g5element_shortcode_content( sprintf( '[g5element_button %s]', join( ' ', $btn_attrs ) ) );
}


function g5element_shortcode_exists($shortcode,$content) {
    return strpos($content,'['.$shortcode) !== false;
}

function g5element_lazy_load_is_active() {
	return class_exists('G5Core_Lazy_Load') && G5Core_Lazy_Load::getInstance()->is_active();
}