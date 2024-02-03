<?php
/**
 * VC Lean map config
 *
 * @package g5element
 * @subpackage heading
 * @since 1.0
 */
return array(
	'base'        => 'g5element_heading',
	'name'        => esc_html__('Heading', 'g5-element'),
	'category'    => G5ELEMENT()->shortcode()->get_category_name(),
	'description' => esc_html__('Awesome heading styles.', 'g5-element'),
	'icon'        => 'g5element-vc-icon-heading',
	'params'      => array(
		array(
			'type'       => 'g5element_image_set',
			'heading'    => esc_html__('Layout Style', 'g5-element'),
			'param_name' => 'layout_style',
			'value'      => array(
				'style-01' => array(
					'label' => esc_html__('Style Left', 'g5-element'),
					'img'   => G5ELEMENT()->plugin_url('assets/images/heading-style-01.jpg'),
				),
				'style-02' => array(
					'label' => esc_html__('Style Center', 'g5-element'),
					'img'   => G5ELEMENT()->plugin_url('assets/images/heading-style-02.jpg'),
				),
				'style-03' => array(
					'label' => esc_html__('Style Right', 'g5-element'),
					'img'   => G5ELEMENT()->plugin_url('assets/images/heading-style-03.jpg'),
				),
			),
			'std'        => 'style-01',
		),
		array(
			'type'        => 'textarea',
			'heading'     => esc_html__('Title', 'g5-element'),
			'param_name'  => 'title',
			'std'         => '',
			'admin_label' => true,
		),
		array(
			'type'        => 'textarea',
			'heading'     => esc_html__('SubTitle', 'g5-element'),
			'param_name'  => 'subtitle',
			'std'         => '',
			'admin_label' => true,
		),
		array(
			'type'        => 'textarea',
			'heading'     => esc_html__('Description', 'g5-element'),
			'param_name'  => 'description',
			'std'         => '',
			'admin_label' => true,
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__('Tag HTML', 'g5-element'),
			'description' => esc_html__('Select tag for title.', 'g5-element'),
			'param_name'  => 'tag_html',
			'value'       => array(
				esc_html__('H1', 'g5-element') => '1',
				esc_html__('H2', 'g5-element') => '2',
				esc_html__('H3', 'g5-element') => '3',
				esc_html__('H4', 'g5-element') => '4',
				esc_html__('H5', 'g5-element') => '5',
				esc_html__('H6', 'g5-element') => '6',
			),
			'std'         => '2',
		),
		array(
			'type'        => 'g5element_switch',
			'heading'     => esc_html__('Line Separate', 'g5-element'),
			'description' => esc_html__('Turn on Line separator', 'g5-element'),
			'param_name'  => 'switch_line_field',
			'std'         => ''
		),
		array(
			'type'       => 'g5element_color',
			'heading'    => esc_html__('Color line separator', 'g5-element'),
			'param_name' => 'line_separate_color',
			'std'        => '',
			'dependency' => array('element' => 'switch_line_field', 'value' => 'on'),
		),

        array(
            'type'        => 'g5element_number',
            'heading'     => esc_html__('Limit Width (px)', 'g5-element'),
            'param_name'  => 'limit_width',
            'std'         => ''
        ),

		array(
			'type'       => 'g5element_typography',
			'heading'    => esc_html__('Title', 'g5-element'),
			'param_name' => 'title_typography',
			'std'        => G5ELEMENT()->vc_params()->get_typography_default(),
			'selector'   => '',
			'group'      => esc_html__('Typography Option', 'g5-element'),
		),
		array(
			'type'       => 'g5element_typography',
			'heading'    => esc_html__('SubTitle', 'g5-element'),
			'param_name' => 'subtitle_typography',
			'std'        => G5ELEMENT()->vc_params()->get_typography_default(),
			'selector'   => '',
			'group'      => esc_html__('Typography Option', 'g5-element'),
		),
		array(
			'type'       => 'g5element_typography',
			'heading'    => esc_html__('Description', 'g5-element'),
			'param_name' => 'description_typography',
			'std'        => G5ELEMENT()->vc_params()->get_typography_default(),
			'selector'   => '',
			'group'      => esc_html__('Typography Option', 'g5-element'),
		),

		g5element_vc_map_add_css_animation(),
		g5element_vc_map_add_animation_duration(),
		g5element_vc_map_add_animation_delay(),
		g5element_vc_map_add_extra_class(),
		g5element_vc_map_add_element_id(),
		g5element_vc_map_add_css_editor(),
		g5element_vc_map_add_responsive(),
	)
);