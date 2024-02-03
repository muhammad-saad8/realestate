<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

function g5core_get_icon_svg() {
	$icons = apply_filters('g5core_get_icon_svg_config' , array());
	$total = 0;
	foreach ($icons as $icon) {
		$total = count($icon['icons']);
	}
	return array(
		'label' => esc_html__('SVG Icon', 'g5-core'),
		'total' => $total,
		'iconGroup' => $icons
	);
}

add_filter('gsf_font_icon_config', 'g5core_icon_svg_for_smart_framework');
function g5core_icon_svg_for_smart_framework($font_list) {
	$icons = g5core_get_icon_svg();
	if (absint($icons['total']) > 0) {
		$font_list['svg'] = $icons;
	}
	return $font_list;
}