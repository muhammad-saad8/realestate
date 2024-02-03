<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $css_class_field
 */
$current_min_price = isset($_REQUEST['min-price']) ? ere_clean(wp_unslash($_REQUEST['min-price'] )) : '';
$current_max_price = isset($_REQUEST['max-price']) ? ere_clean(wp_unslash($_REQUEST['max-price'] )) : '';
$current_status = isset($_REQUEST['status']) ? $_REQUEST['status'] : '';
$min_price = ere_get_option('property_price_slider_min',200);
$max_price = ere_get_option('property_price_slider_max',2500000);
if ($current_status !== '') {
	$property_price_slider_search_field = ere_get_option('property_price_slider_search_field','');
	if ($property_price_slider_search_field != '') {
		foreach ($property_price_slider_search_field as $data) {
			$term_id =(isset($data['property_price_slider_property_status']) ? $data['property_price_slider_property_status'] : '');
			$term = get_term_by('id', $term_id, 'property-status');
			if($term)
			{
				if($term->slug === $current_status)
				{
					$min_price = (isset($data['property_price_slider_min']) && !empty($data['property_price_slider_min']) ? $data['property_price_slider_min'] : $min_price);
					$max_price = (isset($data['property_price_slider_max']) && !empty($data['property_price_slider_max']) ? $data['property_price_slider_max'] : $max_price);
					break;
				}
			}
		}
	}
}
$min_price = absint($min_price);
$max_price = absint($max_price);
$current_min_price = $current_min_price === '' ? $min_price : $current_min_price;
$current_max_price = $current_max_price === '' ? $max_price : $current_max_price;

$current_min_price = absint($current_min_price);
$current_max_price = absint($current_max_price);
$range_slider_options = array(
	'min' => $min_price,
	'max' => $max_price,
	'values' => array($current_min_price,$current_max_price)
);

$wrapper_classes = array(
	'form-group',
	'g5ere__search-field',
	'g5ere__sf-price-range'
);
if (isset($css_class_field)) {
	$wrapper_classes[] = $css_class_field;
}
$wrapper_class = implode(' ', $wrapper_classes);
?>
<div class="<?php echo esc_attr($wrapper_class)?>">
	<div class="g5ere__range-slider-wrap" data-toggle="g5ere__range-slider" data-options="<?php echo esc_attr(json_encode($range_slider_options))?>">
		<div class="g5ere__rs-text">
			<input type="hidden" name="min-price" class="g5ere__rsi-min g5ere__rs-input" value="<?php echo esc_attr($current_min_price === $min_price ? '' : $current_min_price) ?>">
			<input type="hidden" name="max-price" class="g5ere__rsi-max g5ere__rs-input" value="<?php echo esc_attr($current_max_price === $max_price ? '' : $current_max_price)?>">
			<span class="g5ere__rs-title"><?php echo esc_html__('Price Range:','g5-ere'); ?></span> <?php echo esc_html__('from','g5-ere'); ?> <span class="g5ere__rst-min"><?php echo ere_get_format_money($current_min_price) ?></span> <?php echo esc_html__('to','g5-ere'); ?> <span class="g5ere__rst-max"><?php echo ere_get_format_money($current_max_price) ?></span>
		</div>
		<div class="g5ere__rs-slider-wrap">
			<div class="g5ere__rs-slider"></div>
		</div>
	</div>
</div>
