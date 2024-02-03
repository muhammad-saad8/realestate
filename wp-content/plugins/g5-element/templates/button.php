<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $link
 * @var $style
 * @var $shape
 * @var $size
 * @var $align
 * @var $icon_font
 * @var $icon_align
 * @var $color
 * @var $is_button_3d
 * @var $css_animation
 * @var $is_button_full_width
 * @var $custom_onclick
 * @var $custom_onclick_code
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_id
 * @var $el_class
 * @var $css
 * @var $responsive
 *
 * Shortcode class
 * @var $this WPBakeryShortCode_G5Element_Button
 */

/**
 * Set shortcode params default
 */
$title    = $link = $style = $shape = $size = $align = $icon_font = $icon_align = '';
$color    = $is_button_3d = $is_button_full_width = $custom_onclick = $custom_onclick_code = '';
$button_typography = $padding_top_bottom = $padding_left_right = '';
$el_class = $el_id = $css = $css_animation = $animation_duration = $animation_delay = $responsive = '';

/**
 * Extract params variable
 */
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

G5ELEMENT()->assets()->enqueue_assets_for_shortcode('button');

/**
 * Wrapper shortcode class
 */
$wrapper_classes = array(
	'gel-btn',
	"gel-btn-{$align}",
	$this->getExtraClass( $el_class ),
	$this->getCSSAnimation( $css_animation ),
	vc_shortcode_custom_css_class( $css ),
	$responsive
);

$button_classes = array(
	'btn',
	"btn-{$size}"
);

if ( $style !== 'classic' ) {
	$button_classes[] = "btn-{$style}";
}
if (  $style !== 'link' ) {
	$button_classes[] = "btn-{$shape}";
}

if ( ( $is_button_3d === 'on' ) && ( $style === 'classic' ) ) {
	$button_classes[] = 'btn-3d';
}

if ( $is_button_full_width === 'on' ) {
	$button_classes[] = 'btn-block';
}

/**
 * Set button custom css
 */
if ($color !== '') {
	if (!g5core_is_color($color)) {
		$button_classes[] = "btn-{$color}";
	}
	else {
		$custom_color = $color;

		$custom_color_class_name = 'gel-button-' . md5( "{$style}_{$custom_color}" );

		if ( ! G5CORE()->custom_css()->existsCssKey( $custom_color_class_name ) ) {
			$button_custom_css     = '';
			$custom_color_contract = g5core_color_contrast( $custom_color );
			$custom_color_hover    = g5core_color_darken( $custom_color, '10%' );

			if ( $style === 'classic' ) {
				$button_custom_css = <<<CSS
				.btn.{$custom_color_class_name} {
					background-color: {$custom_color};
					border-color: {$custom_color};
					color: {$custom_color_contract};
				}
				.btn.{$custom_color_class_name}:hover,
				.btn.{$custom_color_class_name}:focus,
				.btn.{$custom_color_class_name}:active{
					background-color: {$custom_color_hover};
					border-color: {$custom_color_hover};
					color: {$custom_color_contract};
				}
CSS;
			}

			if ( $style === 'outline' ) {
				$button_custom_css .= <<<CSS
				.btn.btn-outline.{$custom_color_class_name} {
					background-color: transparent;
					color: $custom_color;
					border-color: {$custom_color};
				}
				.btn.btn-outline.{$custom_color_class_name}:hover,
				.btn.btn-outline.{$custom_color_class_name}:focus,
				.btn.btn-outline.{$custom_color_class_name}:active {
					background-color: {$custom_color};
					border-color: {$custom_color};
					color: {$custom_color_contract};
				}
CSS;
			}
			if ( $style === 'link' ) {
				$button_custom_css .= <<<CSS
				.btn.btn-link.{$custom_color_class_name} {
					color: $custom_color;
				}
CSS;
			}

			if ( ! empty( $button_custom_css ) ) {
				$button_classes[] = $custom_color_class_name;
				G5CORE()->custom_css()->addCss( $button_custom_css, $custom_color_class_name );
			}
		} else {
			$button_classes[] = $custom_color_class_name;
		}
	}
}

$button_typography = g5element_typography_class($button_typography);
if ($button_typography !== '') {
	$button_classes[] = $button_typography;
}

if (($padding_top_bottom !== '') || ($padding_left_right !== '')) {
	$button_unique_class = 'gel-button-' . md5("{$padding_top_bottom}###{$padding_left_right}");

	if (G5CORE()->custom_css()->existsCssKey($button_unique_class)) {
		$button_classes[] = $button_unique_class;
	}
	else {
		$button_custom_css = '';

		if ($padding_top_bottom !== '') {
			$button_custom_css .= "padding-top: {$padding_top_bottom}px!important;";
			$button_custom_css .= "padding-bottom: {$padding_top_bottom}px!important;";
		}
		if ($padding_left_right !== '') {
			$button_custom_css .= "padding-left: {$padding_left_right}px!important;";
			$button_custom_css .= "padding-right: {$padding_left_right}px!important;";
		}

		if ($button_custom_css !== '') {
			$button_custom_css .= "height: auto!important;";
			$button_custom_css = ".{$button_unique_class}{{$button_custom_css}}";

			$button_classes[] = $button_unique_class;
			G5CORE()->custom_css()->addCss($button_custom_css, $button_unique_class);
		}
	}
}


$button_html = $title;
if ( '' !== $icon_font ) {
    $button_classes[] = 'btn-icon';
    $button_classes[] = 'btn-icon-' . $icon_align;
    if ( $icon_align === 'left' ) {
        $button_html = '<i class="' . esc_attr( $icon_font ) . '"></i> ' . $title;
    } else {
        $button_html = $title . ' <i class="' . esc_attr( $icon_font ) . '"></i>';
    }
}


$button_class = implode( ' ', array_filter( $button_classes ) );

$button_attributes = array(
	'class' => $button_class,
	'title' => esc_attr( $title ),
	'href'  => '#'
);

if ( 'on' === $custom_onclick && $custom_onclick_code ) {
	$button_attributes['onclick'] = esc_attr( $custom_onclick_code );
}



$button_link = g5element_build_link( $link, $button_attributes );

$class_to_filter = implode( ' ', array_filter( $wrapper_classes ) );
$css_class       = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

$el_attributes = array();
if (!empty($el_id)) {
	$el_attributes[] = 'id="' . esc_attr($el_id) . '"';
}
$el_attributes[] = 'class="' . esc_attr($css_class) . '"';
?>
<div <?php echo join(' ', $el_attributes)?>>
	<?php echo $button_link['before'] ?>
	<?php echo wp_kses_post( $button_html ); ?>
	<?php echo $button_link['after'] ?>
</div>
