<?php
add_action( 'vc_after_init', 'g5element_custom_vc_toggle_add_param' );
function g5element_custom_vc_toggle_add_param() {
	$param_color          = WPBMap::getParam( 'vc_toggle', 'color' );
	$param_color['value'] = array_merge( g5element_vc_sources_colors(), $param_color['value'] );
	$param_color['std']   = 'accent';

	vc_update_shortcode_param( 'vc_toggle', $param_color );
}