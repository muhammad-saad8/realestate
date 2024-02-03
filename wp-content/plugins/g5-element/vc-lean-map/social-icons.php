<?php
return array(
	'base'     => 'g5element_social_icons',
	'name'     => esc_html__('Social Icons', 'g5-element'),
	'icon'     => 'g5element-vc-icon-social-icon',
	'description' => esc_html__('Add a set of multiple social profile icons','g5-element'),
	'category' => G5ELEMENT()->shortcode()->get_category_name(),
	'params'   => array(
		array(
			'param_name'  => 'social_shape',
			'heading'     => esc_html__('Shape', 'g5-element'),
			'type'        => 'dropdown',
			'value'       => array(
				esc_html__('Classic', 'g5-element')        => 'classic',
				esc_html__('Text', 'g5-element')           => 'text',
				esc_html__('Circle Fill', 'g5-element')    => 'circle',
				esc_html__('Circle Outline', 'g5-element') => 'circle-outline',
				esc_html__('Square Fill', 'g5-element')    => 'square',
				esc_html__('Square Outline', 'g5-element') => 'square-outline',
			),
			'admin_label' => true,
			'std'         => 'classic'
		),
		array(
			'param_name'  => 'social_size',
			'heading'     => esc_html__('Size', 'g5-element'),
			'type'        => 'dropdown',
			'value'       => array(
				esc_html__('Small', 'g5-element')  => 'small',
				esc_html__('Normal', 'g5-element') => 'normal',
				esc_html__('Large', 'g5-element')  => 'large'
			),
			'admin_label' => true,
			'std'         => 'normal'
		),
		array(
			'param_name'  => 'social_align',
			'heading'     => esc_html__('Align', 'g5-element'),
			'type'        => 'dropdown',
			'value'       => array(
				esc_html__('Left', 'g5-element')   => 'left',
				esc_html__('Center', 'g5-element') => 'center',
				esc_html__('Right', 'g5-element')  => 'right'
			),
			'admin_label' => true,
			'std'         => 'center'
		),
		array(
			'param_name' => 'icon_color',
			'type'       => 'g5element_color',
			'heading'    => esc_html__('Icon Color', 'g5-element'),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
		),
		array(
			'param_name' => 'icon_hover_color',
			'type'       => 'g5element_color',
			'heading'    => esc_html__('Icon Hover color', 'g5-element'),
			'dependency'  => array('element' => 'icon_color', 'not_empty' => true),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
		),
		g5element_vc_map_add_element_id(),
		g5element_vc_map_add_extra_class(),
		g5element_vc_map_add_css_animation(),
		g5element_vc_map_add_animation_duration(),
		g5element_vc_map_add_animation_delay(),
		g5element_vc_map_add_css_editor(),
		g5element_vc_map_add_responsive(),
	),
);