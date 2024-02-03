<?php
add_action( 'vc_after_init', 'g5element_custom_vc_tta_tabs_add_param' );
function g5element_custom_vc_tta_tabs_add_param() {
	$param_color               = WPBMap::getParam( 'vc_tta_tabs', 'color' );
	$param_color['value']      = array_merge( g5element_vc_sources_colors(), $param_color['value'] );
	$param_color['std']        = 'accent';
	vc_update_shortcode_param( 'vc_tta_tabs', $param_color );
}