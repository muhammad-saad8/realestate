<?php
/**
 * @var $classes
 */
$menu_toggle_classes = array('menu-mobile-toggle');
if (isset($classes) && !empty($classes)) {
	$menu_toggle_classes[] = $classes;
}
?>
<div data-off-canvas-target="#g5core_menu_mobile" class="<?php echo join(' ', $menu_toggle_classes)?>">
	<div class="toggle-icon"><span></span></div>
</div>