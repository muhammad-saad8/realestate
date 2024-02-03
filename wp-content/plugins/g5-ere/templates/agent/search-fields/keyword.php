<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $prefix
 * @var $css_class_field
 */
$value = isset($_REQUEST['s']) ? $_REQUEST['s'] : '';
$wrapper_classes = array(
	'form-group',
	'g5ere__search-field',
	'g5ere__sf-keyword'
);
if (isset($css_class_field)) {
	$wrapper_classes[] = $css_class_field;
}
$wrapper_class = implode(' ', $wrapper_classes);
?>
<div class="<?php echo esc_attr($wrapper_class)?>">
	<label class="g5ere__s-label" for="<?php echo esc_attr($prefix)?>_keyword"><?php esc_html_e('Keyword','g5-ere') ?></label>
	<div class="input-group w-100">
		<div class="input-group-prepend">
			<button class="input-group-text g5ere__sf-icon-submit"><i class="fal fa-search"></i></button>
		</div>
		<input id="<?php echo esc_attr($prefix)?>_keyword" class="form-control" value="<?php echo esc_attr($value)?>" name="s" type="text" placeholder="<?php echo esc_attr__('Enter Keyword...','g5-ere')?>">

	</div>

</div>

