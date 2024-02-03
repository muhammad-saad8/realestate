<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
return array(
	'base' => 'g5element_properties_locations',
	'name' => esc_html__('Properties Locations', 'g5-ere'),
	'category' => G5ERE()->shortcodes()->get_category_name(),
	'icon'        => 'g5element-vc-icon-properties-locations',
	'description' => esc_html__( 'Display category of properties location', 'g5-ere' ),
	'params' => array_merge(
		array(
			array(
				'param_name' => 'layout',
				'heading' => esc_html__('Property Locations Layout', 'g5-ere'),
				'description' => esc_html__('Specify your properties location layout', 'g5-ere'),
				'type' => 'g5element_image_set',
				'value' => G5ERE()->settings()->get_property_locations_layout(),
				'std' => 'layout-01',
				'admin_label' => true
			),
			array(
				'type' => 'attach_image',
				'heading' => esc_html__('Background Image', 'g5-ere'),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'param_name' => 'image',
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Taxonomy', 'g5-ere'),
				'param_name' => 'filter_taxonomy',
				'value' => array_flip(G5ERE()->settings()->get_property_location_taxonomy_filter()),
				'description' => esc_html__('Select taxonomy property location', 'g5-ere'),
				'std' => 'property-city',
			),
			g5ere_vc_map_add_narrow_state( array(
				'dependency' => array('element' => 'filter_taxonomy', 'value' => 'property-state'),
				'type' => 'dropdown',
			) ),
			g5ere_vc_map_add_narrow_city( array(
				'dependency' => array('element' => 'filter_taxonomy', 'value' => 'property-city'),
				'type' => 'dropdown',
			) ),
			g5ere_vc_map_add_narrow_neighborhood( array(
				'dependency' => array('element' => 'filter_taxonomy', 'value' => 'property-neighborhood'),
				'type' => 'dropdown',
			) ),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Height Mode', 'g5-ere' ),
				'param_name' => 'height_mode',
				'value' => array(
					'1:1' => '100',
					esc_html__( 'Original', 'g5-ere' )=> 'original',
					'4:3' => '133.333333333',
					'3:4' => '75',
					'16:9' => '177.777777778',
					'9:16' => '56.25',
					esc_html__( 'Custom', 'g5-ere' )=> 'custom'
				),
				'std' => 'original',
				'description' => esc_html__( 'Sizing proportions for height and width. Select "Original" to scale image without cropping.', 'g5-ere' )
			),
			array(
				'param_name' => 'width',
				'heading' => esc_html__('Image width', 'g5-ere'),
				'description' => esc_html__('Enter width for image', 'g5-ere'),
				'type' => 'g5element_number',
				'std' => '',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'dependency' => array('element' => 'height_mode', 'value' => 'custom'),
			),
			array(
				'param_name' => 'height',
				'heading' => esc_html__('Image height', 'g5-ere'),
				'description' => esc_html__('Enter height for image', 'g5-ere'),
				'type' => 'g5element_number',
				'std' => '',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'dependency' => array('element' => 'height_mode', 'value' => 'custom'),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__('Hover effect', 'g5-ere'),
				'param_name' => 'hover_effect',
				'std' => '',
				'value'      => array_flip(G5ERE()->settings()->get_hover_effect()),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__('Hover Image effect', 'g5-ere'),
				'param_name' => 'hover_image_effect',
				'std' => '',
				'value'      => array_flip(G5ERE()->settings()->get_hover_effect_image()),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
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