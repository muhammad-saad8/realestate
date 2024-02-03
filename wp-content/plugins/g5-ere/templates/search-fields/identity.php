<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $prefix
 * @var $css_class_field
 */
$value = isset($_REQUEST['property_identity']) ? ere_clean(wp_unslash($_REQUEST['property_identity'] )) : '';
$wrapper_classes = array(
	'form-group',
	'g5ere__search-field',
	'g5ere__sf-identity'
);
if (isset($css_class_field)) {
	$wrapper_classes[] = $css_class_field;
}
$wrapper_class = implode(' ', $wrapper_classes);
?>
<div class="<?php echo esc_attr($wrapper_class)?>">
	<label class="g5ere__s-label" for="<?php echo esc_attr($prefix)?>_identity"><?php esc_html_e('Property ID','g5-ere') ?></label>
	<input id="<?php echo esc_attr($prefix)?>_identity" class="form-control" value="<?php echo esc_attr($value)?>" name="property_identity" type="text" placeholder="<?php echo esc_attr__('Property ID','g5-ere') ?>">
</div>

