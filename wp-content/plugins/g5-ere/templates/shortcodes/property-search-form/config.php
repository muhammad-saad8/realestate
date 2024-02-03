<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
return array(
	'base' => 'g5element_property_search_form',
	'name' => esc_html__('Property Search Form', 'g5-ere'),
	'category' => G5ERE()->shortcodes()->get_category_name(),
	'icon'        => 'g5element-vc-icon-property-search-form',
	'description' => esc_html__( 'Display property search form', 'g5-ere' ),
	'params' => array_merge(
		array(
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Search Form', 'g5-ere'),
				'description' => wp_kses_post(sprintf( __('Manager search form at <a href="%s">G5Ere Options</a>','g5-ere'),admin_url('admin.php?page=g5ere_options&section=search_forms'))),
				'param_name' => 'search_form',
				'value' => array_flip(G5ERE()->settings()->get_search_forms()),
				'std' => ''
			),
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