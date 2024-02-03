<?php
/**
 * Function for Theme Addons
 */

/**
 * Change image template directory
 */
add_filter('g5element_template_image_dir', 'gta_template_image_dir');
function gta_template_image_dir($template_image_path) {
	return array(
		'dir' => GTA()->plugin_dir("assets/vc-templates/"),
		'url' => GTA()->plugin_url("assets/vc-templates/")
	);
}

/**
 * Change xmenu container width default
 */
add_filter( 'g5core_xmenu_container_width', 'gta_change_xmenu_container_width');
function gta_change_xmenu_container_width($width) {
	return 940;
}