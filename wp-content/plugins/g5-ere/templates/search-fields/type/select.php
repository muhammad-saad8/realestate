<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $field
 * @var $prefix
 * @var $css_class_field
 */
$name = isset($field['id']) ? $field['id'] : '';
if (empty($name)) {
	return;
}
$value = isset($_REQUEST[$name]) ? wp_filter_kses(wp_unslash($_REQUEST[$name] )) : '';
$id = "{$prefix}_{$name}";
$label = isset($field['label']) ? $field['label'] : '';
$type = isset($field['type']) ? $field['type'] : 'text';

$options_arr = isset($field['select_choices']) ? $field['select_choices'] : '';
$options_arr = str_replace("\r\n", "\n", $options_arr);
$options_arr = str_replace("\r", "\n", $options_arr);
$options_arr = explode("\n", $options_arr);
if (!is_array($options_arr) || empty($options_arr)) {
	return;
}
$wrapper_classes = array(
	'form-group',
	'g5ere__search-field',
	"g5ere__sf-{$name}",
	"g5ere__sf-{$type}"
);
if (isset($css_class_field)) {
	$wrapper_classes[] = $css_class_field;
}
$wrapper_class = implode(' ', $wrapper_classes);
?>
<div class="<?php echo esc_attr($wrapper_class)?>">
	<label class="g5ere__s-label" for="<?php echo esc_attr($id)?>"><?php echo esc_html($label)?></label>
	<select id="<?php echo esc_attr($id)?>" name="<?php echo esc_attr($name)?>" class="form-control selectpicker" data-live-search="true">
		<option <?php selected($value,'') ?> value=""><?php echo esc_attr($label)?></option>
		<?php foreach ($options_arr as $k => $v): ?>
			<option <?php selected($value,$v) ?> value="<?php echo esc_attr($v)?>"><?php echo esc_attr($v)?></option>
		<?php endforeach; ?>
	</select>
</div>
