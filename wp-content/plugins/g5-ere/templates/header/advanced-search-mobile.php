<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $advanced_search_form
 * @var $advanced_search_layout
 * @var $advanced_search_sticky
 * @var $css_classes
 */

$wrapper_classes = array(
	'g5ere__advanced-search-header'
);
if ($advanced_search_sticky !== '') {
	$wrapper_classes[] = 'g5ere__ash-sticky g5ere__ash-sticky-' . $advanced_search_sticky;
}
if ($css_classes !== '') {
	$wrapper_classes[] = $css_classes;
}

$wrapper_class = implode(' ', $wrapper_classes);
?>
<div id="g5ere__advanced_search_header_mobile" class="<?php echo esc_attr($wrapper_class)?>">
	<div class="g5ere__ash-sticky-area">
		<div class="<?php echo esc_attr($advanced_search_layout === 'boxed' ? 'container' : 'container-fluid')?>">
			<div class="g5ere__ash-inner">
				<?php g5ere_template_header_search_form_mobile($advanced_search_form) ?>
			</div>
		</div>
	</div>
</div>
