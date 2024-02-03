<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $prefix
 * @var $css_class_field
 */
$value = isset($_REQUEST['rooms']) ? ere_clean(wp_unslash($_REQUEST['rooms'] )) : '';
$wrapper_classes = array(
	'form-group',
	'g5ere__search-field',
	'g5ere__sf-room'
);
if (isset($css_class_field)) {
	$wrapper_classes[] = $css_class_field;
}
$wrapper_class = implode(' ', $wrapper_classes);
?>
<div class="<?php echo esc_attr($wrapper_class)?>">
	<label class="g5ere__s-label" for="<?php echo esc_attr($prefix)?>_rooms"><?php esc_html_e('Rooms','g5-ere') ?></label>
	<select id="<?php echo esc_attr($prefix) ?>_rooms" name="rooms" class="form-control selectpicker" data-live-search="true">
		<option value='' <?php selected($value,'')?>>
			<?php esc_html_e('Any Rooms', 'g5-ere') ?>
		</option>
		<?php
		$rooms_list = ere_get_option('rooms_list','1,2,3,4,5,6,7,8,9,10');
		$rooms_array = explode( ',', $rooms_list );
		if( is_array( $rooms_array ) && !empty( $rooms_array ) ) {
			foreach( $rooms_array as $n ) {
				?>
				<option value="<?php echo esc_attr($n) ?>" <?php selected($n,$value)?>>
					<?php echo esc_attr($n); ?>
				</option>
				<?php
			}
		}?>
	</select>
</div>
