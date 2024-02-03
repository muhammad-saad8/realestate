<?php
/**
 * VC Lean map config
 *
 * @package g5element
 * @subpackage layout_container
 * @since 1.0
 */
return array(
	'base'                    => 'g5element_layout_container',
	'name'                    => esc_html__( 'Layout Container', 'g5-element' ),
	'category'                => G5ELEMENT()->shortcode()->get_category_name(),
	'description' => esc_html__('Display layout container with any content', 'g5-element'),
	'icon'                    => 'g5element-vc-icon-layout-container',
	'as_parent'               => array( 'only' => 'g5element_layout_section' ),
	'content_element'         => true,
	'show_settings_on_create' => true,
	'js_view'                 => 'G5ElementLayoutContainerView',
	'params'                  => array(
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Layout Style', 'g5-element' ),
			'param_name' => 'layout_style',
			'value'      => array(
				esc_html__('Fix left content size','g5-element') => 'fix_left_content',
				esc_html__('Fix right content size','g5-element') => 'fix_right_content',
			),
			'std'        => 'fix_left_content',
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Set Content Size', 'g5-element'),
			'param_name' => 'content_size',
			'description' => esc_html__('Leave blank to default width (50%).', 'g5-element'),
			'std' => '',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Content Spacing', 'g5-element'),
			'param_name' => 'content_spacing',
			'description' => esc_html__('Leave blank to default spacing (30px).', 'g5-element'),
			'std' => '',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Vertical Alignment', 'g5-element' ),
			'param_name' => 'vertical_alignment',
			'value'      => array(
				esc_html__('Top','g5-element') => 'top',
				esc_html__('Middle','g5-element') => 'middle',
				esc_html__('Bottom','g5-element') => 'bottom',
			),
			'std'        => 'middle',
		),
		array(
			'type'       => 'g5element_button_set',
			'heading'    => esc_html__( 'Left Content Alignment', 'g5-element' ),
			'param_name' => 'left_content_alignment',
			'value'      => array(
				esc_html__('Left','g5-element') => 'left',
				esc_html__('Center','g5-element') => 'center',
				esc_html__('Right','g5-element') => 'right',
			),
			'std'        => 'left',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
		),
		array(
			'type'       => 'g5element_button_set',
			'heading'    => esc_html__( 'Right Content Alignment', 'g5-element' ),
			'param_name' => 'right_content_alignment',
			'value'      => array(
				esc_html__('Left','g5-element') => 'left',
				esc_html__('Center','g5-element') => 'center',
				esc_html__('Right','g5-element') => 'right',
			),
			'std'        => 'left',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Vertical Mode On Device', 'g5-element' ),
			'param_name' => 'vertical_mode_device',
			'value'      => array(
				esc_html__('None','g5-element') => '',
				esc_html__('Mobile Device','g5-element') => 'mobile',
				esc_html__('Tablet Device','g5-element') => 'tablet',
			),
			'std'        => '',
		),
		g5element_vc_map_add_element_id(),
		g5element_vc_map_add_extra_class(),
		g5element_vc_map_add_css_animation(),
		g5element_vc_map_add_animation_duration(),
		g5element_vc_map_add_animation_delay(),
		g5element_vc_map_add_css_editor(),
		g5element_vc_map_add_responsive(),
	),
	'custom_markup' => '
		<div class="gel-layout-container-heading" data-default-title="' . esc_html__('Layout Section Name','g5-element') . '">
		    <h4 class="title"><i class="fal fa-columns"></i> <span>' . esc_html__('Layout Container','g5-element') . '</span></h4>
		    <div class="gel-layout-container-controls">
		        {{editor_controls}}
			</div>
		</div>
		<div class="gel-layout-container-body">
			<div class="{{ container-class }}">
			{{ content }}
			</div>
		</div>',
	'default_content' => '[g5element_layout_section title="' . __( 'Left Content', 'g5-element' ) . '"][/g5element_layout_section][g5element_layout_section title="' . __( 'Right Content', 'g5-element' ) . '"][/g5element_layout_section]',
);