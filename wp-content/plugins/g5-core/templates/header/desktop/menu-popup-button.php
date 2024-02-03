<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}
$args = array(
	'type' => 'inline',
	'mainClass' => 'mfp-move-from-top g5core-menu-popup-wrapper',
);
?>
<a class="g5core-menu-popup-button" href="#g5core_menu_popup" data-g5core-mfp="true" data-mfp-options='<?php echo json_encode($args) ?>'>
	<div class="toggle-icon"><span></span></div>
</a>
<?php add_action('wp_footer', array(G5CORE()->templates(), 'menu_popup'), 10) ?>