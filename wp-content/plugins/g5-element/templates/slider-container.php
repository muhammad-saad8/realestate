<?php
/***
 * Shortcode attributes
 * @var $content
 * @var $atts
 * @var $this WPBakeryShortCode_G5Element_Slider_Container
 */
$atts                = vc_map_get_attributes( $this->getShortcode(), $atts );
$el_class            = $slider_type = $slides_to_show = '';
$navigation_arrow    = $dots_navigation = $center_mode = $center_padding = $infinite_loop = $adaptive_height = $transition_speed = '';
$single_slide_scroll = $margin_item = $fade_enabled = $autoplay_enable = $autoplay_speed = $pause_on_hover = $rtl_mode = '';
$slider_syncing      = $slider_syncing_element = $focus_on_select = '';
$grid_mode = $slide_rows = $slides_per_row = '';

$columns_lg = $columns_md = $columns_sm = $columns_xs = '';

extract( $atts );

G5ELEMENT()->assets()->enqueue_assets_for_shortcode('slider_container');

$wrapper_classes = array(
	'gel-slider-container',
	'slick-slider',
	$this->getExtraClass( $el_class ),
	vc_shortcode_custom_css_class( $css )
);

$slick_options = array(
	'vertical'       => $slider_type === 'vertical',
	'slidesToShow'   => intval($slides_to_show),
	'slidesToScroll' => $single_slide_scroll === 'on' ? 1 : intval($slides_to_show),
	'centerMode'     => $center_mode === 'on',
	'centerPadding'  => $center_padding,
	'arrows'         => $navigation_arrow === 'on',
	'dots'           => $dots_navigation === 'on',
	'infinite'       => $infinite_loop === 'on',
	'adaptiveHeight' => $adaptive_height === 'on',
	'speed'          => intval($transition_speed),
	'autoplay'       => $autoplay_enable === 'on',
	'autoplaySpeed'  => intval($autoplay_speed),
	'pauseOnHover'   => $pause_on_hover === 'on',
	'fade'           => $fade_enabled === 'on',
	'rtl'            => $rtl_mode === 'on',
	'responsive'     => array(),
	'focusOnSelect' => $focus_on_select === 'on',
	'draggable' => true,
);

if ($grid_mode === 'on') {
	$slick_options['rows'] = intval($slide_rows);
	$slick_options['slidesPerRow'] = intval($slides_per_row);
}

if (($slider_syncing === 'on') && (!empty($slider_syncing_element))) {
	$slick_options['asNavFor'] = $slider_syncing_element;
}

if ( ! empty( $columns_lg ) ) {
	$slick_options['responsive'][] = array(
		'breakpoint' => 1200,
		'settings'   => array(
			'slidesToShow'   => intval($columns_lg),
			'slidesToScroll' => $single_slide_scroll === 'on' ? 1 : intval($columns_lg),
		)
	);
}
if ( ! empty( $columns_md ) ) {
	$slick_options['responsive'][] = array(
		'breakpoint' => 992,
		'settings'   => array(
			'slidesToShow'   => intval($columns_md),
			'slidesToScroll' => $single_slide_scroll === 'on' ? 1 : intval($columns_md),
		)
	);
}
if ( ! empty( $columns_sm ) ) {
	$slick_options['responsive'][] = array(
		'breakpoint' => 768,
		'settings'   => array(
			'slidesToShow'   => intval($columns_sm),
			'slidesToScroll' => $single_slide_scroll === 'on' ? 1 : intval($columns_sm),
		)
	);
}
if ( ! empty( $columns_xs ) ) {
	$slick_options['responsive'][] = array(
		'breakpoint' => 576,
		'settings'   => array(
			'slidesToShow'   => intval($columns_xs),
			'slidesToScroll' => $single_slide_scroll === 'on' ? 1 : intval($columns_xs),
		)
	);
}

// Custom Slides Gutter
if ($margin_item !== '') {
	$margin_item_2x = $margin_item;
	$margin_item = $margin_item/2;
	$elm_custom_class = 'gel-slider-container-gutter-' . $margin_item;
	$wrapper_classes[] = $elm_custom_class;
	$custom_css = <<<CUSTOM_CSS
	.{$elm_custom_class}.slick-slider {
		margin-left: -{$margin_item}px;
		margin-right: -{$margin_item}px;
	}
	.{$elm_custom_class} .slick-slide > div {
		padding: {$margin_item}px;
	}
CUSTOM_CSS;
	G5CORE()->custom_css()->addCss($custom_css, $elm_custom_class);
}
// Custom Css

$class_to_filter = implode( ' ', array_filter( $wrapper_classes ) );
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' );
$css_class       = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );
?>
<div class="<?php echo esc_attr( $css_class ) ?>"
     data-slick-init="false"
     data-slick-options="<?php echo esc_attr( json_encode( $slick_options ) ) ?>">
	<?php g5element_shortcode_content( $content ); ?>
</div>