<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $start_value
 * @var $end_value
 * @var $decimals
 * @var $durations
 * @var $separator
 * @var $decimal
 * @var $prefix
 * @var $suffix
 * @var $value_typography
 * @var $el_class
 * @var $css
 * Shortcode class
 * @var $this WPBakeryShortCode_G5Element_Heading
 */
$start_value = $end_value = $value_typography = '';
$animation_delay = $el_class = $css = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

G5ELEMENT()->assets()->enqueue_assets_for_shortcode('counter');

if (empty($end_value)) {
	return;
}

$wrapper_classes = array(
	'gel-counter',
	$this->getExtraClass($el_class),
	vc_shortcode_custom_css_class($css),
);
$value_typography = g5element_typography_class($value_typography);
if (!empty($value_typography)) {
	$wrapper_classes[] = $value_typography;
}

$class_to_filter = implode(' ', array_filter($wrapper_classes));
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);
?>
<div class="<?php echo esc_attr($css_class) ?>">
	<?php if (!empty($prefix)): ?>
		<span class="gel-counter-prefix"><?php echo esc_html($prefix) ?></span>
	<?php endif; ?>
	<span class="counterup counter-value" data-start="<?php echo esc_attr($start_value) ?>"
		  data-end="<?php echo esc_attr($end_value) ?>"
		  data-decimals="<?php echo esc_attr($decimals) ?>"
		  data-duration="<?php echo esc_attr($durations) ?>"
		  data-separator="<?php echo esc_attr($separator) ?>"
		  data-decimal="<?php echo esc_attr($decimal) ?>"><?php echo esc_html($end_value); ?></span>
	<?php if (!empty($suffix)): ?>
		<span class="gel-counter-suffix"><?php echo esc_html($suffix) ?></span>
	<?php endif; ?>
</div>

