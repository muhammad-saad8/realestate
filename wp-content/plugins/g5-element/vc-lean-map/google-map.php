<?php
/**
 * VC Lean map config
 *
 * @package g5element
 * @subpackage google_map
 * @since 1.0
 */
return array(
	'base'        => 'g5element_google_map',
	'name'        => esc_html__('Google Map', 'g5-element'),
	'category'    => G5ELEMENT()->shortcode()->get_category_name(),
	'description' => esc_html__('Display Google Maps to indicate your location.', 'g5-element'),
	'icon'        => 'g5element-vc-icon-google-map',
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
					'std'        => 'Title',
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__('Description', 'g5-element'),
					'param_name' => 'description',
					'value'      => '',
					'std'        => 'Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...',
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
			'std'              => 'rgba(38, 38, 38, 0.3)',
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
			'std'              => '#666',
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
			'value'      => apply_filters('g5element_map_style_config',array(
				esc_html__('Standard', 'g5-element')  => 'standard',
				esc_html__('Theme', 'g5-element')     => 'theme',
				esc_html__('Cool Grey', 'g5-element')     => 'cool-grey',
				esc_html__('Light', 'g5-element')     => 'light',
				esc_html__('Sliver', 'g5-element')    => 'sliver',
				esc_html__('Retro', 'g5-element')     => 'retro',
				esc_html__('Dark', 'g5-element')      => 'dark',
				esc_html__('Dark 2', 'g5-element')      => 'dark2',
				esc_html__('Night', 'g5-element')     => 'night',
				esc_html__('Aubergine', 'g5-element') => 'aubergine',
				esc_html__('Light', 'g5-element')     => 'light',
			)),
			'std'        => 'standard',
		),
		g5element_vc_map_add_css_animation(),
		g5element_vc_map_add_animation_duration(),
		g5element_vc_map_add_animation_delay(),
		g5element_vc_map_add_extra_class(),
		g5element_vc_map_add_css_editor(),
		g5element_vc_map_add_responsive(),
	),
);