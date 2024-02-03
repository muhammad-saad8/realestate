<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
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

$wrapper_classes = array(
	'gel-map-box',
	$this->getExtraClass( $el_class ),
	vc_shortcode_custom_css_class( $css ),
);

if ($marker_effect === 'on') {
	$wrapper_classes[] = 'gel-map-box-effect';
}

$custom_class = 'gel' . uniqid();
$custom_css = '';


if ($map_height !== '') {
	$custom_css .= <<<CSS
	.{$custom_class}{
		height: {$map_height}px;
	}
CSS;
}

if ($map_height_lg !== '') {
	$custom_css .= <<<CSS
	    @media (max-width: 1199px) {
	        .{$custom_class}{
				height: {$map_height_lg}px;
			}
	    }
CSS;
}

if ($map_height_md !== '') {
	$custom_css .= <<<CSS
		@media (max-width: 991px) {
			.{$custom_class}{
				height: {$map_height_md}px;
			}
		}
CSS;
}

if ($map_height_sm !== '') {
	$custom_css .= <<<CSS
		@media (max-width: 767px) {
			.{$custom_class}{
				height: {$map_height_sm}px;
			}
        }
CSS;
}


if ($map_height_xs !== '') {
	$custom_css .= <<<CSS
		@media (max-width: 575px) {
			.{$custom_class}{
				height: {$map_height_xs}px;
			}
		}
CSS;
}

if ($marker_effect === 'on') {
	if ($color_effect1 !== '') {
		if (!g5core_is_color($color_effect1)) {
			$color_effect1 = g5core_get_color_from_option($color_effect1);
		}


		$custom_css .= <<<CSS
	.{$custom_class} .mapboxgl-marker::before{
		-webkit-box-shadow: inset 0 0 35px 10px $color_effect1;
		box-shadow: inset 0 0 35px 10px $color_effect1;
	}
CSS;
	}

	if ($color_effect2 !== '') {
		if (!g5core_is_color($color_effect2)) {
			$color_effect2 = g5core_get_color_from_option($color_effect2);
		}

		$custom_css .= <<<CSS
	.{$custom_class} .mapboxgl-marker::after{
		-webkit-box-shadow: inset 0 0 35px 10px $color_effect2;
		box-shadow: inset 0 0 35px 10px $color_effect2;
	}
CSS;
	}
}

$wrapper_classes[] = $custom_class;
G5Core()->custom_css()->addCss($custom_css);

$options = array(
	'zoom'        => $map_zoom,
	'scrollwheel' => $zoom_mouse_wheel === 'on',
	'skin'        => $map_style
);

$values  = (array) vc_param_group_parse_atts( $values );
$markers = array();
foreach ( $values as $value ) {
	$address     = isset( $value['address'] ) ? ( $value['address'] ) : '';
	$position = false;
	if ( !empty($address) && strpos($address,',') > 0 ) {
		$address_arr = explode( ',', $address);
		$position =  array(
			'lat' => $address_arr[0],
			'lng' => $address_arr[1]
		);
	}

	$description = isset( $value['description'] ) ? '<div class="gel-map-marker-description">' . esc_html( $value['description'] ) . '</div>' : '';
	$title       = isset( $value['title'] ) ? '<h5 class="gel-map-marker-title">' . esc_html( $value['title'] ) . '</h5>' : '';
	$image_html  = '';
	if ( ! empty( $value['image'] ) ) {
		$image_src  = '';
		$image_src  = g5core_get_url_by_attachment_id( $value['image'] );
		$image_html = sprintf( '<img class="gel-map-marker-image" src="%s"%s>',
			esc_url( $image_src ),
			empty( $value['title'] ) ? '' : sprintf( ' alt="%s"', esc_attr( $value['title'] ) ) );
	}

	$popup_html = '';
	if ( ( $title !== '' ) || ( $description !== '' ) || ( $image_html !== '' ) ) {
		$popup_html = sprintf( '<div class="gel-map-marker-wrap">%s%s%s</div>',
			$image_html,
			$title,
			$description );
	}

	$marker_html = '';
	if (!empty($value['image_marker'])) {
		$marker_html =  wp_get_attachment_image($value['image_marker'], 'full');
	}
	$markers[] = array(
		'position' => $position,
		'marker'   => $marker_html,
		'popup'    => $popup_html
	);
}
$class_to_filter = implode( ' ', array_filter( $wrapper_classes ) );
$css_class       = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );
?>
<div class="<?php echo esc_attr( $css_class ) ?>" data-options="<?php echo esc_attr( json_encode( $options ) ) ?>"
     data-markers="<?php echo esc_attr( json_encode( $markers ) ) ?>">
</div>

