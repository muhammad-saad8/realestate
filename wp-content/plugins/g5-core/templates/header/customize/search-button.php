<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}
$args = apply_filters('g5core_search_popup_args',array(
    'type' => 'inline',
    'mainClass' => 'mfp-move-from-top mfp-align-top g5core-search-popup-bg',
    'focus' => 'input[type="search"]',
    'closeOnBgClick' => false
));
?>
<div class="g5core-search-button">
	<a data-g5core-mfp="true" href="#g5core_search_popup" data-mfp-options='<?php echo esc_attr(wp_json_encode($args)) ?>'><i class="fal fa-search"></i></a>
</div>
<?php add_action('wp_footer', array(G5CORE()->templates(), 'search_popup'), 10) ?>