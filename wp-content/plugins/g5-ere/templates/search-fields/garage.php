<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $prefix
 * @var $css_class_field
 */
$value = isset($_REQUEST['garage']) ? ere_clean(wp_unslash($_REQUEST['garage'] )) : '';
$measurement_units = ere_get_measurement_units();
$wrapper_classes = array(
	'form-group',
	'g5ere__search-field',
	'g5ere__sf-garage'
);
if (isset($css_class_field)) {
	$wrapper_classes[] = $css_class_field;
}
$wrapper_class = implode(' ', $wrapper_classes);
?>
<div class="<?php echo esc_attr($wrapper_class)?>">
	<label class="g5ere__s-label" for="<?php echo esc_attr($prefix)?>_garages"><?php esc_html_e('Garages','g5-ere') ?></label>
	<select id="<?php echo esc_attr($prefix)?>_garages" name="garage" class="form-control selectpicker" data-live-search="true">
		<option value='' <?php selected($value,'')?>>
			<?php esc_html_e('Any Garages', 'g5-ere') ?>
		</option>
		<?php
		$garage_list = ere_get_option('garage_list','1,2,3,4,5,6,7,8,9,10');
		$garage_array = explode( ',', $garage_list );
		if (is_array($garage_array) && !empty($garage_array)) {
			foreach ($garage_array as $n) {
				?>
				<option value="<?php echo esc_attr($n) ?>" <?php selected($n,$value)?>>
					<?php echo esc_attr($n); ?>
				</option>
				<?php
			}
		} ?>
	</select>
</div>
