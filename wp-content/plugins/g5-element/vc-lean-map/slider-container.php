<?php
/**
 * VC Lean map config
 *
 * @package g5element
 * @subpackage slider_container
 * @since 1.0
 */
$slider_items = array(
	'1' => '1',
	'2' => '2',
	'3' => '3',
	'4' => '4',
	'5' => '5',
	'6' => '6',
);
return array(
	'base'                    => 'g5element_slider_container',
	'name'                    => esc_html__( 'Slider Container', 'g5-element' ),
	'category'                => G5ELEMENT()->shortcode()->get_category_name(),
	'description' => esc_html__('Create Slick Slider with any content.','g5-element'),
	'icon'                    => 'g5element-vc-icon-slider-container',
	'as_parent'               => array( 'except' => 'g5element_slider_container' ),
	'content_element'         => true,
	'show_settings_on_create' => true,
	'params'                  => array(
		array(
			'type'       => 'g5element_button_set',
			'heading'    => esc_html__( 'Slider Type', 'g5-element' ),
			'param_name' => 'slider_type',
			'value'      => array(
				esc_html__( 'Horizontal', 'g5-element' ) => 'horizontal',
				esc_html__( 'Vertical', 'g5-element' )   => 'vertical',
			),
			'std'        => 'horizontal',
		),

		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Slides To Show', 'g5-element' ),
			'param_name' => 'slides_to_show',
			'value'      => array(
				'1' => '1',
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'5' => '5',
				'6' => '6',
				'7' => '7',
				'8' => '8',
			),
			'std'        => 4,
		),
		array(
			'type'             => 'dropdown',
			'heading'          => esc_html__( 'Large Devices', 'g5-element' ),
			'param_name'       => 'columns_lg',
			'description'      => esc_html__( 'Width < 1200px', 'g5-element' ),
			'value'            => array(
				esc_html__( 'Default', 'g5-element' ) => '',
				'1'                                   => '1',
				'2'                                   => '2',
				'3'                                   => '3',
				'4'                                   => '4',
				'5'                                   => '5',
				'6'                                   => '6',
				'7' => '7',
				'8' => '8',
			),
			'std'              => '',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
		),
		array(
			'type'             => 'dropdown',
			'heading'          => esc_html__( 'Medium Devices', 'g5-element' ),
			'param_name'       => 'columns_md',
			'description'      => esc_html__( 'Width < 992px', 'g5-element' ),
			'value'            => array(
				esc_html__( 'Default', 'g5-element' ) => '',
				'1'                                   => '1',
				'2'                                   => '2',
				'3'                                   => '3',
				'4'                                   => '4',
				'5'                                   => '5',
				'6'                                   => '6',
				'7' => '7',
				'8' => '8',
			),
			'std'              => '',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
		),
		array(
			'type'             => 'dropdown',
			'heading'          => esc_html__( 'Small Devices', 'g5-element' ),
			'param_name'       => 'columns_sm',
			'description'      => esc_html__( 'Width < 768px', 'g5-element' ),
			'value'            => array(
				esc_html__( 'Default', 'g5-element' ) => '',
				'1'                                   => '1',
				'2'                                   => '2',
				'3'                                   => '3',
				'4'                                   => '4',
				'5'                                   => '5',
				'6'                                   => '6',
				'7' => '7',
				'8' => '8',
			),
			'std'              => '',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
		),
		array(
			'type'             => 'dropdown',
			'heading'          => esc_html__( 'Extra Small Devices', 'g5-element' ),
			'param_name'       => 'columns_xs',
			'description'      => esc_html__( 'Width < 576px', 'g5-element' ),
			'value'            => array(
				esc_html__( 'Default', 'g5-element' ) => '',
				'1'                                   => '1',
				'2'                                   => '2',
				'3'                                   => '3',
				'4'                                   => '4',
				'5'                                   => '5',
				'6'                                   => '6',
				'7' => '7',
				'8' => '8',
			),
			'std'              => '',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
		),

		array(
			'param_name'       => 'navigation_arrow',
			'heading'          => esc_html__( 'Navigation Arrow', 'g5-element' ),
			'type'             => 'g5element_switch',
			'std'              => 'on',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
		),
		array(
			'param_name'       => 'dots_navigation',
			'heading'          => esc_html__( 'Dots Navigation', 'g5-element' ),
			'type'             => 'g5element_switch',
			'std'              => 'on',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
		),
		array(
			'param_name'       => 'center_mode',
			'heading'          => esc_html__( 'Center Mode', 'g5-element' ),
			'type'             => 'g5element_switch',
			'std'              => '0',
		),
		array(
			'param_name'       => 'center_padding',
			'heading'          => esc_html__( 'Side padding when in center mode (px/%)', 'g5-element' ),
			'type'             => 'textfield',
			'std'              => '50px',
			'dependency'       => array( 'element' => 'center_mode', 'value' => 'on' ),
		),

		array(
			'param_name'       => 'autoplay_enable',
			'heading'          => esc_html__( 'Autoplay Slides', 'g5-element' ),
			'type'             => 'g5element_switch',
			'std'              => '0',
		),
		array(
			'param_name'       => 'autoplay_speed',
			'heading'          => esc_html__( 'Autoplay Speed', 'g5-element' ),
			'type'             => 'g5element_number',
			'std'              => '3000',
			'dependency'       => array( 'element' => 'autoplay_enable', 'value' => 'on' ),
		),
		array(
			'param_name'       => 'infinite_loop',
			'heading'          => esc_html__( 'Infinite Loop', 'g5-element' ),
			'type'             => 'g5element_switch',
			'std'              => '0',
		),
		array(
			'param_name'       => 'transition_speed',
			'heading'          => esc_html__( 'Transition Speed', 'g5-element' ),
			'type'             => 'g5element_number',
			'std'              => '300',
		),
		array(
			'type'             => 'g5element_number',
			'param_name'       => 'margin_item',
			'heading'          => esc_html__( 'Space between two items (px)', 'g5-element' ),
			'std'              => '',
			'description'      => esc_html__('Empty to default: 30px','g5-element'),
		),

		array(
			'param_name'       => 'adaptive_height',
			'heading'          => esc_html__( 'Adaptive Height', 'g5-element' ),
			'type'             => 'g5element_switch',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'std'              => '0',
			'group'      => esc_html__( 'Advanced', 'g5-element' ),
		),
		array(
			'type'       => 'g5element_switch',
			'heading'    => esc_html__( 'Pause Autoplay On Hover', 'g5-element' ),
			'param_name' => 'pause_on_hover',
			'std'        => '0',
			'group'      => esc_html__( 'Advanced', 'g5-element' ),
		),
		array(
			'type'             => 'g5element_switch',
			'heading'          => esc_html__( 'Single Slide Scroll', 'g5-element' ),
			'param_name'       => 'single_slide_scroll',
			'std'              => '0',
			'group'      => esc_html__( 'Advanced', 'g5-element' ),
		),
		array(
			'type'       => 'g5element_switch',
			'heading'    => esc_html__( 'Fade animation', 'g5-element' ),
			'param_name' => 'fade_enabled',
			'std'        => '0',
			'group'      => esc_html__( 'Advanced', 'g5-element' ),
		),
		array(
			'type'       => 'g5element_switch',
			'heading'    => esc_html__( 'RTL Mode', 'g5-element' ),
			'param_name' => 'rtl_mode',
			'std'        => '0',
			'group'      => esc_html__( 'Advanced', 'g5-element' ),
		),
		array(
			'type'       => 'g5element_switch',
			'heading'    => esc_html__( 'Slider Syncing', 'g5-element' ),
			'param_name' => 'slider_syncing',
			'std'        => '0',
			'group'      => esc_html__( 'Advanced', 'g5-element' ),
		),
		array(
			'param_name'       => 'slider_syncing_element',
			'heading'          => esc_html__( 'Set the slider syncing', 'g5-element' ),
			'type'             => 'textfield',
			'std'              => '',
			'dependency'       => array( 'element' => 'slider_syncing', 'value' => 'on' ),
			'group'      => esc_html__( 'Advanced', 'g5-element' ),
		),
		array(
			'type'       => 'g5element_switch',
			'heading'    => esc_html__( 'Enable focus on selected element (click)', 'g5-element' ),
			'param_name' => 'focus_on_select',
			'std'        => '0',
			'group'      => esc_html__( 'Advanced', 'g5-element' ),
		),
		array(
			'type'       => 'g5element_switch',
			'heading'    => esc_html__( 'Enabled Grid Mode', 'g5-element' ),
			'param_name' => 'grid_mode',
			'std'        => '0',
			'group'      => esc_html__( 'Advanced', 'g5-element' ),
		),
		array(
			'param_name'       => 'slide_rows',
			'heading'          => esc_html__( 'Slide Rows', 'g5-element' ),
			'type'             => 'g5element_number',
			'std'              => '2',
			'dependency'       => array( 'element' => 'grid_mode', 'value' => 'on' ),
			'group'      => esc_html__( 'Advanced', 'g5-element' ),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Slides Per Row', 'g5-element' ),
			'param_name' => 'slides_per_row',
			'value'      => array(
				'1' => '1',
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'5' => '5',
				'6' => '6',
			),
			'std'        => 2,
			'dependency'       => array( 'element' => 'grid_mode', 'value' => 'on' ),
			'group'      => esc_html__( 'Advanced', 'g5-element' ),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
		),

		g5element_vc_map_add_css_animation(),
		g5element_vc_map_add_animation_duration(),
		g5element_vc_map_add_animation_delay(),
		g5element_vc_map_add_extra_class(),
		g5element_vc_map_add_css_editor(),
		g5element_vc_map_add_responsive(),
	),
	'js_view'                 => 'G5ElementSliderContainerView',
	'custom_markup' => '
		<div class="gel-slider-container-heading">
		    <h4 class="title"><i class="fal fa-window"></i> <span>' . esc_html__('Slider Container','g5-element') . '</span></h4>
		    <div class="gel-slider-container-controls bottom-controls">
		        {{editor_controls}}
			</div>
		</div>
		<div class="gel-slider-container-body">
			<div class="{{ container-class }}">
			{{ content }}
			</div>
		</div>',
);