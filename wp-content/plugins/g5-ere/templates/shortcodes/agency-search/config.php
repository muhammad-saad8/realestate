<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
return array(
	'base'        => 'g5element_agency_search',
	'name'        => esc_html__( 'Agency Search', 'g5-ere' ),
	'category'    => G5ERE()->shortcodes()->get_category_name(),
	'icon'        => 'g5element-vc-icon-agency-search',
	'description' => esc_html__( 'Display agency search form', 'g5-ere' ),
	'params'      => array_merge(
		array(
			g5element_vc_map_add_element_id(),
			g5element_vc_map_add_extra_class(),
		),
		array(
			g5element_vc_map_add_css_animation(),
			g5element_vc_map_add_animation_duration(),
			g5element_vc_map_add_animation_delay(),
			g5element_vc_map_add_css_editor(),
			g5element_vc_map_add_responsive(),
		)
	)
);