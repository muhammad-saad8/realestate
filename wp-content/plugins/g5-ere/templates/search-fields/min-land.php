<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $prefix
 * @var $css_class_field
 */
$value = isset($_REQUEST['min-land-area']) ? ere_clean(wp_unslash($_REQUEST['min-land-area'] )) : '';
$measurement_units_land_area=ere_get_measurement_units_land_area();
$wrapper_classes = array(
	'form-group',
	'g5ere__search-field',
	'g5ere__sf-min-land-area'
);
if (isset($css_class_field)) {
	$wrapper_classes[] = $css_class_field;
}
$wrapper_class = implode(' ', $wrapper_classes);
?>
<div class="<?php echo esc_attr($wrapper_class)?>">
	<label class="g5ere__s-label" for="<?php echo esc_attr($prefix)?>_min_land_area"><?php esc_html_e('Min Land Area','g5-ere') ?></label>
	<select id="<?php echo esc_attr($prefix)?>_min_land_area" name="min-land-area" class="form-control selectpicker" data-live-search="true">
		<option value='' <?php selected($value,'')?>>
			<?php esc_html_e('Min Land Area', 'g5-ere') ?>
		</option>
		<?php
		$property_land_dropdown_min = ere_get_option('property_land_dropdown_min', '0,100,300,500,700,900,1100,1300,1500,1700,1900');
		$property_land_array = explode(',', $property_land_dropdown_min);
		if (is_array($property_land_array) && !empty($property_land_array)) {
			foreach ($property_land_array as $n) {
				?>
				<option value="<?php echo esc_attr($n) ?>" <?php selected($n,$value)?>>
					<?php echo sprintf('%s %s',ere_get_format_number($n), $measurement_units_land_area); ?>
				</option>
				<?php
			}
		} ?>
	</select>
</div>
