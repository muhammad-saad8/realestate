<?php
/**
 * VC Lean map config
 *
 * @package g5element
 * @subpackage map_box
 * @since 1.0
 */
return array(
	'base'        => 'g5element_map_box',
	'name'        => esc_html__('Map Box', 'g5-element'),
	'category'    => G5ELEMENT()->shortcode()->get_category_name(),
	'description' => esc_html__('Display Map Box to indicate your location.', 'g5-element'),
	'icon'        => 'g5element-vc-icon-map-box',
	'params'      => array(
		array(
			'type'       => 'param_group',
			'heading'    => esc_html__('Markers', 'g5-element'),
			'param_name' => 'values',
			'params'     => array(
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__('Address', 'g5-element'),
					'description' => esc_html__('Enter address or coordinate. Example: 40.735601,-74.165918', 'g5-element'),
					'param_name'  => 'address',
					'value'       => '',
					'std'         => '40.735601,-74.165918',
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__('Title', 'g5-element'),
					'param_name' => 'title',
					'value'      => '',
					'std'        => esc_html__('Title','g5-element') ,
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__('Description', 'g5-element'),
					'param_name' => 'description',
					'value'      => '',
					'std'        => esc_html__('Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...','g5-element'),
				),
				array(
					'type'        => 'attach_image',
					'heading'     => esc_html__('Images', 'g5-element'),
					'param_name'  => 'image',
					'value'       => '',
					'description' => esc_html__('Select images from media library.', 'g5-element'),
				),
				array(
					'type'        => 'attach_image',
					'heading'     => esc_html__('Images Marker', 'g5-element'),
					'param_name'  => 'image_marker',
					'value'       => '',
					'description' => esc_html__('Select images from media library.', 'g5-element'),
				),

			),
		),
		array(
			'type'             => 'g5element_number',
			'heading'          => esc_html__('Map height', 'g5-element'),
			'param_name'       => 'map_height',
			'std'              => '400',
		),
		array(
			'type'             => 'g5element_number',
			'heading'          => esc_html__('Map height Large Device', 'g5-element'),
			'param_name'       => 'map_height_lg',
			'description' => esc_html__('Width < 1200px', 'g5-element'),
			'std'              => '',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
		),
		array(
			'type'             => 'g5element_number',
			'heading'          => esc_html__('Map height Medium Device', 'g5-element'),
			'param_name'       => 'map_height_md',
			'description' => esc_html__('Width < 992px', 'g5-element'),
			'std'              => '',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
		),
		array(
			'type'             => 'g5element_number',
			'heading'          => esc_html__('Map height Small Device', 'g5-element'),
			'param_name'       => 'map_height_sm',
			'description' => esc_html__('Width < 768px', 'g5-element'),
			'std'              => '',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
		),
		array(
			'type'             => 'g5element_number',
			'heading'          => esc_html__('Map height Extra Small Device', 'g5-element'),
			'param_name'       => 'map_height_xs',
			'description' => esc_html__('Width < 576px', 'g5-element'),
			'std'              => '',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
		),
		array(
			'type'             => 'g5element_number',
			'heading'          => esc_html__('Map Zoom', 'g5-element'),
			'param_name'       => 'map_zoom',
			'std'              => '13',
		),
		array(
			'type'             => 'g5element_switch',
			'heading'          => esc_html__('Zoom by MouseWheel', 'g5-element'),
			'param_name'       => 'zoom_mouse_wheel',
			'std'              => 'on',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
		),
		array(
			'type'             => 'g5element_switch',
			'heading'          => esc_html__('Marker Effect', 'g5-element'),
			'description'      => esc_html__('Marker has Effection', 'g5-element'),
			'param_name'       => 'marker_effect',
			'std'              => 'on',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
		),
		array(
			'type'             => 'g5element_color',
			'heading'          => esc_html__('Color effect circle 1', 'g5-element'),
			'param_name'       => 'color_effect1',
			'std'              => '',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'dependency'       => array(
				'element' => 'marker_effect',
				'value'   => 'on',
			),
		),
		array(
			'type'             => 'g5element_color',
			'heading'          => esc_html__('Color effect circle 2', 'g5-element'),
			'param_name'       => 'color_effect2',
			'std'              => '',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'dependency'       => array(
				'element' => 'marker_effect',
				'value'   => 'on',
			),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__('Map Style', 'g5-element'),
			'param_name' => 'map_style',
			'value'      => apply_filters('g5element_map_box_style_config',array(
				_x( 'Streets', 'Mapbox Skin', 'g5-element' ) => 'skin1',
				_x( 'Outdoors', 'Mapbox Skin', 'g5-element' ) => 'skin2',
				_x( 'Light', 'Mapbox Skin', 'g5-element' ) => 'skin3' ,
				_x( 'Dark', 'Mapbox Skin', 'g5-element' ) => 'skin4',
				//'skin5' => _x('Nature', 'Google Skin', 'g5-ere'),
				_x( 'Satellite', 'Mapbox Skin', 'g5-element' ) => 'skin6',
				_x( 'Nav Day', 'Mapbox Skin', 'g5-element' ) => 'skin7',
				_x( 'Nav Night', 'Mapbox Skin', 'g5-element' ) => 'skin8',
				_x( 'Guide Day', 'Mapbox Skin', 'g5-element' ) => 'skin9',
				_x( 'Guide Night', 'Mapbox Skin', 'g5-element' ) => 'skin10',
				//'skin11' => _x('Dark', 'Google Skin', 'g5-ere'),
				_x( 'Standard', 'Mapbox Skin', 'g5-element' ) => 'skin12',
			)),
			'std'        => 'skin1',
		),
		g5element_vc_map_add_css_animation(),
		g5element_vc_map_add_animation_duration(),
		g5element_vc_map_add_animation_delay(),
		g5element_vc_map_add_extra_class(),
		g5element_vc_map_add_css_editor(),
		g5element_vc_map_add_responsive(),
	),
);