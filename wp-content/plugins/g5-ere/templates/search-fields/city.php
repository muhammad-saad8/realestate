<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $prefix
 * @var $css_class_field
 */
$value = isset($_REQUEST['city']) ? wp_filter_kses(wp_unslash($_REQUEST['city'] )) : '';
$wrapper_classes = array(
	'form-group',
	'g5ere__search-field',
	'g5ere__sf-city'
);
if (isset($css_class_field)) {
	$wrapper_classes[] = $css_class_field;
}
$wrapper_class = implode(' ', $wrapper_classes);
?>
<div class="<?php echo esc_attr($wrapper_class)?>">
	<label class="g5ere__s-label" for="<?php echo esc_attr($prefix) ?>_city"><?php esc_html_e('City','g5-ere') ?></label>
	<select data-current-value="<?php echo esc_attr($value)?>" id="<?php echo esc_attr($prefix)?>_city" data-toggle="g5ere__select_location_filter" data-hide-disabled="true" data-target=".g5ere__sf-neighborhood" name="city" class="form-control selectpicker" data-live-search="true">
		<option value='' <?php selected($value,'')?>>
			<?php esc_html_e('All Cities', 'g5-ere') ?>
		</option>
	</select>
</div>
