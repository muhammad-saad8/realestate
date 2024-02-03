<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $advanced_search_form
 * @var $css_classes
 */

$wrapper_classes = array(
	'g5ere__advanced-search-archive'
);

if ($css_classes !== '') {
	$wrapper_classes[] = $css_classes;
}
$wrapper_class = implode(' ', $wrapper_classes);
?>
<div id="g5ere__advanced_search_archive" class="<?php echo esc_attr($wrapper_class)?>">
	<?php g5ere_template_search_form($advanced_search_form) ?>
</div>
