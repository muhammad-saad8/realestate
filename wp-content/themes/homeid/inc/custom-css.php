<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
add_filter('g5core_site_variables', 'homeid_change_site_variables');
function homeid_change_site_variables($variables) {
	$accent_color            = G5CORE()->options()->color()->get_option( 'accent_color' );
	$variables[] = sprintf('--g5-color-menu-hover: %s', $accent_color);
	$variables[] = sprintf('--g5ere-map-pin-color: %s', $accent_color);
	return $variables;
}