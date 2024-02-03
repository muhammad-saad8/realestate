<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $values
 * @var $address
 * @var $title
 * @var $description
 * @var $map_height
 * @var $map_height_lg
 * @var $map_height_md
 * @var $map_height_sm
 * @var $map_height_xs
 * @var $image
 * @var $image_marker
 * @var $map_zoom
 * @var $zoom_mouse_wheel
 * @var $marker_effect
 * @var $color_effect1
 * @var $color_effect2
 * @var $map_style
 * @var $el_class
 * @var $css
 * Shortcode class
 * @var $this WPBakeryShortCode_G5Element_Heading
 */
$address   = $title = $description = $image = $image_marker = $map_zoom = $zoom_mouse_wheel = $marker_effect = '';
$map_style = $image_size = $icon_type = $icon = $image = $image_marker = $color_effect1 = $color_effect2 = '';
$values    = $map_height = $map_height_lg = $map_height_md = $map_height_sm = $map_height_xs = $el_class = $css = '';
$atts      = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

G5ELEMENT()->assets()->enqueue_assets_for_shortcode( 'google_map' );

$wrapper_classes  = array(
	'g5ere__map-canvas',
	$this->getExtraClass( $el_class ),
	vc_shortcode_custom_css_class( $css ),
);
$wrapper_class    = implode( ' ', array_filter( $wrapper_classes ) );
$google_map_class = 'gel' . uniqid();
$google_map_css   = '';
if ( $map_height !== '' ) {
	$google_map_css .= <<<CSS
	.{$google_map_class}{
		height: {$map_height}px;
	}
CSS;
}
if ( $map_height_lg !== '' ) {
	$google_map_css .= <<<CSS
	    @media (max-width: 1199px) {
	        .{$google_map_class}{
				height: {$map_height_lg}px;
			}
	    }
CSS;
}
if ( $map_height_md !== '' ) {
	$google_map_css .= <<<CSS
		@media (max-width: 991px) {
			.{$google_map_class}{
				height: {$map_height_md}px;
			}
		}
CSS;
}
if ( $map_height_sm !== '' ) {
	$google_map_css .= <<<CSS
		@media (max-width: 767px) {
			.{$google_map_class}{
				height: {$map_height_sm}px;
			}
        }
CSS;
}

if ( $map_height_xs !== '' ) {
	$google_map_css .= <<<CSS
		@media (max-width: 575px) {
			.{$google_map_class}{
				height: {$map_height_xs}px;
			}
		}
CSS;
}

if ( $marker_effect == 'on' && $color_effect1 != '' ):
	if ( ! g5core_is_color( $color_effect1 ) ) {
		$color_effect1 = g5core_get_color_from_option( $color_effect1 );
	}
	$google_map_css .= <<<CSS
	.{$google_map_class} .g5ere__pin-wrap::before{
		-webkit-box-shadow: inset 0 0 35px 10px $color_effect1;
		box-shadow: inset 0 0 35px 10px $color_effect1;
	}
CSS;
endif;
if ( $marker_effect == 'on' && $color_effect2 != '' ):
	if ( ! g5core_is_color( $color_effect2 ) ) {
		$color_effect2 = g5core_get_color_from_option( $color_effect2 );
	}
	$google_map_css .= <<<CSS
	.{$google_map_class} .g5ere__pin-wrap::after{
		-webkit-box-shadow: inset 0 0 35px 10px $color_effect2;
		box-shadow: inset 0 0 35px 10px $color_effect2;
	}
CSS;
endif;

if ( $google_map_css != '' ):
	$wrapper_classes[] = $google_map_class;
	G5Core()->custom_css()->addCss( $google_map_css );
endif;

$map_style_snippet = $map_style;
$values            = (array) vc_param_group_parse_atts( $values );

$options = array(
	'zoom'        => intval( $map_zoom ),
	'scrollwheel' => $zoom_mouse_wheel == 'on' ? 'true' : 'false',
    'cluster_markers'=>true
);
if ( $map_style != '0' ) {
	$options['skin'] = $map_style;
}

$array_marker  = array();
$array_overlay = array();

foreach ( $values as $value ) {
	$address     = isset( $value['address'] ) ? esc_html( $value['address'] ) : '';
	$description = isset( $value['description'] ) ? '<div class="g5ere__map-popup-address">' . esc_html( $value['description'] ) . '</div>' : '';
	$title       = isset( $value['title'] ) ? '<h5 class="g5ere__map-popup-title">' . esc_html( $value['title'] ) . '</h5>' : '';

	$image_html = '';
	if ( ! empty( $value['image'] ) ):
		$image_src  = '';
		$image_src  = g5core_get_url_by_attachment_id( $value['image'] );
		$image_html = sprintf( '<img class="gel-map-marker-image" src="%s"%s>',
			esc_url( $image_src ),
			empty( $value['title'] ) ? '' : sprintf( ' alt="%s"', esc_attr( $value['title'] ) ) );

	endif;
	$_data = "0";
	if ( ( $title !== '' ) || ( $description !== '' ) || ( $image_html !== '' ) ) {
		$_data = sprintf( '<div class="g5ere__map-popup">%s<div class="g5ere__map-popup-content">%s%s</div></div>',
			$image_html,
			$title,
			$description );
	}
	$image_src   = ! empty( $value['image_marker'] ) ? g5core_get_url_by_attachment_id( $value['image_marker'] ) : '';
	$html_marker = '';
	if ( $image_src != '' ) {
		$marker_type = 'image';
		$html_marker = $image_src;
	} else {
		$marker_type = 'icon';
		$marker_icon = G5ERE()->options()->get_option( 'marker_icon', 'fal fa-map-marker-alt' );
		if ( ! empty( $marker_icon ) ) {
			$html_marker = sprintf( '<i class="%s"></i>', esc_attr( $marker_icon ) );
		}
	}
	$array_marker[] = array(
		'address' => $address,
		'data'    => $_data,
		'options' => array(
			'type' => $marker_type,
			'html' => $html_marker
		)
	);
}

$class_to_filter = implode( ' ', array_filter( $wrapper_classes ) );
$css_class       = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );
$id              = 'g5ere_map_shortcode_' . uniqid();
?>
<div id="<?php echo esc_attr($id)?>" class="<?php echo esc_attr( $css_class ) ?>"
     data-marker='<?php echo esc_attr( json_encode( $array_marker ) ) ?>'
     data-options='<?php echo esc_attr( json_encode( $options ) ) ?>'>
</div>


