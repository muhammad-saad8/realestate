<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $prefix
 * @var $css_class_field
 */
$value = isset($_REQUEST['label']) ? wp_filter_kses(wp_unslash($_REQUEST['label'] )) : '';
$wrapper_classes = array(
	'form-group',
	'g5ere__search-field',
	'g5ere__sf-label'
);
if (isset($css_class_field)) {
	$wrapper_classes[] = $css_class_field;
}
$wrapper_class = implode(' ', $wrapper_classes);
?>
<div class="<?php echo esc_attr($wrapper_class)?>">
	<label class="g5ere__s-label" for="<?php echo esc_attr($prefix)?>_label"><?php esc_html_e('Label','g5-ere')?></label>
	<select id="<?php echo esc_attr($prefix)?>_label" name="label" class="form-control selectpicker" data-live-search="true">
		<option value='' <?php selected($value,'')?>>
			<?php esc_html_e('All Labels', 'g5-ere') ?>
		</option>
		<?php ere_get_taxonomy_slug('property-label', $value); ?>
	</select>
</div>
