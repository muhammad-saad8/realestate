<?php
add_filter('xmenu_submenu_transition', 'g5core_xmenu_submenu_transition_filter', 20,2);
function g5core_xmenu_submenu_transition_filter($transition, $args) {
	if (isset($args->main_menu)) {
		$transition = G5CORE()->options()->header()->get_option('submenu_transition');
	}
	return $transition;
}

/**
 * @see g5core_template_image_zoom
 * @see g5core_template_metro_link
 * @see g5core_template_metro_content
 * @see g5core_template_metro_more
 */
add_action('g5core_metro_content','g5core_template_image_zoom',5);
add_action('g5core_metro_content','g5core_template_metro_link',10);
add_action('g5core_metro_content','g5core_template_metro_content',15);
add_action('g5core_metro_content','g5core_template_metro_more',20);