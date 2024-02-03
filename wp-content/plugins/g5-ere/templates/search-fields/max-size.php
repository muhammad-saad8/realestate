<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $prefix
 * @var $css_class_field
 */
$value = isset($_REQUEST['max-area']) ? ere_clean(wp_unslash($_REQUEST['max-area'] )) : '';
$measurement_units = ere_get_measurement_units();
$wrapper_classes = array(
	'form-group',
	'g5ere__search-field',
	'g5ere__sf-max-area'
);
if (isset($css_class_field)) {
	$wrapper_classes[] = $css_class_field;
}
$wrapper_class = implode(' ', $wrapper_classes);
?>
<div class="<?php echo esc_attr($wrapper_class)?>">
	<label class="g5ere__s-label" for="<?php echo esc_attr($prefix)?>_max_size"><?php esc_html_e('Max Size','g5-ere') ?></label>
	<select id="<?php echo esc_attr($prefix)?>_max_size" name="max-area" class="form-control selectpicker" data-live-search="true">
		<option value='' <?php selected($value,'')?>>
			<?php esc_html_e('Max Size', 'g5-ere') ?>
		</option>
		<?php
		$property_size_dropdown_max = ere_get_option('property_size_dropdown_max', '200,400,600,800,1000,1200,1400,1600,1800,2000');
		$property_size_array = explode(',', $property_size_dropdown_max);
		if (is_array($property_size_array) && !empty($property_size_array)) {
			foreach ($property_size_array as $n) {
				?>
				<option value="<?php echo esc_attr($n) ?>" <?php selected($n,$value)?>>
					<?php echo wp_kses_post(sprintf('%s %s',ere_get_format_number($n), $measurement_units)); ?>
				</option>
				<?php
			}
		} ?>
	</select>
</div>
