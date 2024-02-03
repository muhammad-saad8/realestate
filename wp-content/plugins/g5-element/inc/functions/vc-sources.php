<?php
function g5element_vc_sources_colors() {
	$colors = array(
		esc_html__('Accent', 'g5-element') => 'accent',
		esc_html__('Primary', 'g5-element') => 'primary',
		esc_html__('Secondary', 'g5-element') => 'secondary'
	);

	return apply_filters('g5element_vc_sources_colors', $colors);
}