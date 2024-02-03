<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $prefix
 * @var $css_class_field
 * @var $auto_complete_enable
 */
$value = isset($_REQUEST['keyword']) ? ere_clean(wp_unslash($_REQUEST['keyword'] )) : '';
$auto_complete_enable = isset($auto_complete_enable) ? $auto_complete_enable : false;


$keyword_field = ere_get_option('keyword_field','prop_address');

if( $keyword_field == 'prop_title' ) {
	$keyword_placeholder = esc_html__('Enter Keyword...','g5-ere');

} else if( $keyword_field == 'prop_city_state_county' ) {
	$keyword_placeholder = esc_html__('Search City, State or Area','g5-ere');

} else if( $keyword_field == 'prop_address' ) {
	$keyword_placeholder = esc_html__('Enter an address, zip or property ID','g5-ere');

} else {
	$keyword_placeholder = esc_html__('Enter Keyword...','g5-ere');
}

$wrapper_classes = array(
	'form-group',
	'g5ere__search-field',
	'g5ere__sf-keyword'
);

if ($auto_complete_enable) {
	$wrapper_classes[] = 'g5ere__sf-auto-complete';
}


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
		<input id="<?php echo esc_attr($prefix)?>_keyword" class="form-control" value="<?php echo esc_attr($value)?>" name="keyword" type="text" placeholder="<?php echo esc_attr($keyword_placeholder)?>">
		<?php if ($auto_complete_enable): ?>
			<div class="g5ere__sf-auto-complete-result dropdown-menu"></div>
		<?php endif; ?>
	</div>
</div>

