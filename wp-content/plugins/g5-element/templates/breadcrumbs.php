<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $layout_style
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_G5Element_Breadcrumbs
 */

$layout_style = $breadcrumbs_typography = $css_animation = $animation_duration = $animation_delay = $el_class = $css = $responsive = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

G5ELEMENT()->assets()->enqueue_assets_for_shortcode('breadcrumbs');

$wrapper_classes = array(
    'gel-breadcrumbs',
    'gel-breadcrumbs-' . $layout_style,
    $this->getExtraClass($el_class),
    $this->getCSSAnimation($css_animation),
    vc_shortcode_custom_css_class($css)
);

$breadcrumb_typo_class = g5element_typography_class($breadcrumbs_typography,$typography_arr);

$breadcrumb_classes = array('g5core-breadcrumbs');
if ($breadcrumb_typo_class !== '') {
	$breadcrumb_classes[] = $breadcrumb_typo_class;

	if ( $typography_arr['color'] !== '' ) {
		$custom_css = '';

		$color = $typography_arr['color'];
		if ( ! g5core_is_color( $color ) ) {
			$color = g5core_get_color_from_option( $color );
		}
		if ( $color !== '' ) {
			$custom_css .= ".{$breadcrumb_typo_class}.g5core-breadcrumbs > li { color: {$color}; }";
		}

		$hover_color = $typography_arr['hover_color'];
		if ( ! g5core_is_color( $hover_color ) ) {
			$hover_color = g5core_get_color_from_option( $hover_color );
		}
		if ( $hover_color !== '' ) {
			$custom_css .= ".{$breadcrumb_typo_class}.g5core-breadcrumbs > li a:hover, .{$breadcrumb_typo_class}.g5core-breadcrumbs .breadcrumb-leaf { color: {$hover_color}; }";
		}

		if (($custom_css !== '') && !G5CORE()->custom_css()->existsCssKey("{$breadcrumb_typo_class}_hover")) {
			G5CORE()->custom_css()->addCss($custom_css, "{$breadcrumb_typo_class}_hover");
		}
	}
}

$class_to_filter = implode(' ', array_filter($wrapper_classes));
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);

?>
<div class="<?php echo esc_attr($css_class) ?>">
    <?php if (function_exists('G5CORE')) {
        G5CORE()->breadcrumbs()->get_breadcrumbs($breadcrumb_classes);
    } ?>
</div>

