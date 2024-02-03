<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $css_class_field
 */
$current_min_area = isset($_REQUEST['min-area']) ? ere_clean(wp_unslash($_REQUEST['min-area'] )) : '';
$current_max_area = isset($_REQUEST['max-area']) ? ere_clean(wp_unslash($_REQUEST['max-area'] )) : '';
$min_area = ere_get_option('property_size_slider_min', 0);
$max_area = ere_get_option('property_size_slider_max', 1000);
$measurement_units = ere_get_measurement_units();

$min_area = absint($min_area);
$max_area = absint($max_area);
$current_min_area = $current_min_area === '' ? $min_area : $current_min_area;
$current_max_area = $current_max_area === '' ? $max_area : $current_max_area;

$current_min_area = absint($current_min_area);
$current_max_area = absint($current_max_area);

$range_slider_options = array(
	'min' => $min_area,
	'max' => $max_area,
	'values' => array($current_min_area,$current_max_area)
);


$wrapper_classes = array(
	'form-group',
	'g5ere__search-field',
	'g5ere__sf-area-range'
);
if (isset($css_class_field)) {
	$wrapper_classes[] = $css_class_field;
}
$wrapper_class = implode(' ', $wrapper_classes);
?>
<div class="<?php echo esc_attr($wrapper_class)?>">
	<div class="g5ere__range-slider-wrap" data-toggle="g5ere__range-slider" data-options="<?php echo esc_attr(json_encode($range_slider_options))?>">
		<div class="g5ere__rs-text">
			<input type="hidden" name="min-area" class="g5ere__rsi-min g5ere__rs-input" value="<?php echo esc_attr($current_min_area === $min_area ? '' : $current_min_area) ?>">
			<input type="hidden" name="max-area" class="g5ere__rsi-max g5ere__rs-input" value="<?php echo esc_attr($current_max_area === $max_area ? '' : $current_max_area) ?>">
			<span class="g5ere__rs-title"><?php echo esc_html__('Size Range:','g5-ere'); ?></span> <?php echo esc_html__('from','g5-ere'); ?> <span class="g5ere__rst-min"><?php echo ere_get_format_number($current_min_area) ?></span> <span class="g5ere__rst-prefix"><?php echo wp_kses_post($measurement_units)?></span> <?php echo esc_html__('to','g5-ere'); ?> <span class="g5ere__rst-max"><?php echo ere_get_format_number($current_max_area) ?></span> <span class="g5ere__rst-prefix"><?php echo wp_kses_post($measurement_units)?></span>
		</div>
		<div class="g5ere__rs-slider-wrap">
			<div class="g5ere__rs-slider"></div>
		</div>
	</div>
</div>
