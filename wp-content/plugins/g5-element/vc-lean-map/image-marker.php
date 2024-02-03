<?php
/**
 * VC Lean map config
 *
 * @package g5element
 * @subpackage image_marker
 * @since 1.0
 */
return array(
	'base'        => 'g5element_image_marker',
	'name'        => esc_html__( 'Image Marker', 'g5-element' ),
	'category'    => G5ELEMENT()->shortcode()->get_category_name(),
	'description' => esc_html__( 'Display image with markers', 'g5-element' ),
	'icon'        => 'g5element-vc-icon-image-marker',
	'params'      => array(
		array(
			'type'        => 'attach_image',
			'heading'     => esc_html__( 'Image', 'g5-element' ),
			'param_name'  => 'image',
			'value'       => '',
			'description' => esc_html__( 'Select image from media library.', 'g5-element' )
		),
		array(
			'type'       => 'param_group',
			'heading'    => esc_html__( 'Markers', 'g5-element' ),
			'param_name' => 'values',
			'params'     => array(
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Title', 'g5-element' ),
					'param_name' => 'title',
					'value'      => '',
					'std'        => 'Title',
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Description', 'g5-element' ),
					'param_name' => 'description',
					'value'      => '',
					'std'        => 'Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...',
				),
				array(
					'type'       => 'g5element_number',
					'heading'    => esc_html__( 'X Position', 'g5-element' ),
					'param_name' => 'x_position',
					'std'        => '50',
				),
				array(
					'type'       => 'g5element_number',
					'heading'    => esc_html__( 'Y Position', 'g5-element' ),
					'param_name' => 'y_position',
					'std'        => '50',
				),
				array(
					'type'       => 'vc_link',
					'heading'    => esc_html__( 'Link (url)', 'g5-element' ),
					'param_name' => 'link',
					'value'      => '',
				),

			),
		),
		array(
			'type'       => 'g5element_switch',
			'heading'    => esc_html__( 'Icon Animation', 'g5-element' ),
			'param_name' => 'switch_icon_animation',
			'std'        => 'off',
			'group'      => esc_html__( 'Icon Options', 'g5-element' ),
		),
		array(
			'type'        => 'g5element_color',
			'heading'     => esc_html__( 'Color Icon', 'g5-element' ),
			'param_name'  => 'color_icon',
			'description' => esc_html__( 'Select color for icon.', 'g5-element' ),
			'std'         => 'default',
			'group'       => esc_html__( 'Icon Options', 'g5-element' ),
		),
		array(
			'type' => 'g5element_typography',
			'heading' => esc_html__('Title', 'g5-element'),
			'param_name' => 'title_typography',
			'selector' => '',
			'group' => esc_html__('Title Options', 'g5-element'),
			'std' => G5ELEMENT()->vc_params()->get_typography_default(),
		),
		array(
			'type'             => 'g5element_number',
			'heading'          => esc_html__('Spacing', 'g5-element'),
			'param_name'       => 'title_spacing',
			'group' => esc_html__('Title Options', 'g5-element'),
		),
		array(
			'type' => 'g5element_typography',
			'heading' => esc_html__('Description', 'g5-element'),
			'param_name' => 'description_typography',
			'selector' => '',
			'group' => esc_html__('Description Options', 'g5-element'),
			'std' => G5ELEMENT()->vc_params()->get_typography_default(),
		),
		array(
			'type'       => 'g5element_switch',
			'heading'    => esc_html__( 'Show Tooltip Arrow', 'g5-element' ),
			'param_name' => 'switch_show_tooltip_arrow',
			'std'        => 'off',
			'group'       => esc_html__( 'Tooltip Options', 'g5-element' ),
		),
		array(
			'type'        => 'g5element_color',
			'heading'     => esc_html__( 'Background Color', 'g5-element' ),
			'param_name'  => 'background_color',
			'description' => esc_html__( 'Select color background.', 'g5-element' ),
			'std'         => 'default',
			'group'       => esc_html__( 'Tooltip Options', 'g5-element' ),
		),
		array(
			'type'             => 'g5element_number',
			'heading'          => esc_html__('Padding', 'g5-element'),
			'param_name'       => 'tooltip_padding',
		),
		g5element_vc_map_add_css_animation(),
		g5element_vc_map_add_animation_duration(),
		g5element_vc_map_add_animation_delay(),
		g5element_vc_map_add_extra_class(),
		g5element_vc_map_add_css_editor(),
		g5element_vc_map_add_responsive(),
	),
);