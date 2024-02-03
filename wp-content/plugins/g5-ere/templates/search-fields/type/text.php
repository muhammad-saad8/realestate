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
	<input id="<?php echo esc_attr($id)?>" class="form-control" value="<?php echo esc_attr($value)?>" name="<?php echo esc_attr($name)?>" type="text" placeholder="<?php echo esc_attr($label)?>">
</div>
