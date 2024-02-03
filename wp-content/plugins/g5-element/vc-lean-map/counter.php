<?php
/**
 * VC Lean map config
 *
 * @package g5element
 * @subpackage counter
 * @since 1.0
 */
return array(
	'base'        => 'g5element_counter',
	'name'        => esc_html__('Counter', 'g5-element'),
	'category'    => G5ELEMENT()->shortcode()->get_category_name(),
	'description' => esc_html__('Your milestones, achievements, etc.', 'g5-element'),
	'icon'        => 'g5element-vc-icon-counter',
	'params'      => array(
		array(
			'type'       => 'g5element_typography',
			'heading'    => esc_html__('Value', 'g5-element'),
			'param_name' => 'value_typography',
			'std'        => G5ELEMENT()->vc_params()->get_typography_default(),
			'selector'   => '',
			'group'      => esc_html__('Value Options', 'g5-element'),
		),
		array(
			'type'             => 'textfield',
			'heading'          => esc_html__('Start Value', 'g5-element'),
			'param_name'       => 'start_value',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'std'              => 0,
			'group'            => esc_html__('Value Options', 'g5-element'),
		),
		array(
			'type'             => 'textfield',
			'heading'          => esc_html__('Start Value', 'g5-element'),
			'param_name'       => 'end_value',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'std'              => 1000,
			'group'            => esc_html__('Value Options', 'g5-element'),
		),
		array(
			'type'             => 'textfield',
			'heading'          => esc_html__('Decimals', 'g5-element'),
			'param_name'       => 'decimals',
			'std'              => 0,
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'group'            => esc_html__('Value Options', 'g5-element'),
		),
		array(
			'type'             => 'textfield',
			'heading'          => esc_html__('Durations', 'g5-element'),
			'param_name'       => 'durations',
			'std'              => 0,
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'group'            => esc_html__('Value Options', 'g5-element'),
		),
		array(
			'type'             => 'textfield',
			'heading'          => esc_html__('Separator', 'g5-element'),
			'param_name'       => 'separator',
			'std'              => '',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'group'            => esc_html__('Value Options', 'g5-element'),
		),
		array(
			'type'             => 'textfield',
			'heading'          => esc_html__('Decimal', 'g5-element'),
			'param_name'       => 'decimal',
			'std'              => ',',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'group'            => esc_html__('Value Options', 'g5-element'),
		),
		array(
			'type'             => 'textfield',
			'heading'          => esc_html__('Prefix', 'g5-element'),
			'param_name'       => 'prefix',
			'std'              => '',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'group'            => esc_html__('Value Options', 'g5-element'),
		),
		array(
			'type'             => 'textfield',
			'heading'          => esc_html__('Suffix', 'g5-element'),
			'param_name'       => 'suffix',
			'std'              => '',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'group'            => esc_html__('Value Options', 'g5-element'),
		),
		
		g5element_vc_map_add_css_animation(),
		g5element_vc_map_add_animation_duration(),
		g5element_vc_map_add_animation_delay(),
		g5element_vc_map_add_extra_class(),
		g5element_vc_map_add_css_editor(),
		g5element_vc_map_add_responsive(),
	)
);