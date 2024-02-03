<?php
/**
 * VC Lean map config
 *
 * @package g5element
 * @subpackage video
 * @since 1.0
 */
return array(
	'base' => 'g5element_video',
	'name' => esc_html__('Video', 'g5-element'),
	'category' => G5ELEMENT()->shortcode()->get_category_name(),
	'icon' => 'g5element-vc-icon-video',
	'description' => esc_html__('Embed video without sacrificing Page speed.', 'g5-element'),
	'params' => array(
		array(
			'type' => 'g5element_image_set',
			'heading' => esc_html__('Video Layout', 'g5-element'),
			'param_name' => 'layout_style',
			'value' => apply_filters('gsf_video_layout_style', array(
				'classic' => array(
					'label' => esc_html__('Classic', 'g5-element'),
					'img' => G5ELEMENT()->plugin_url('assets/images/video-classic.png'),
				),
				'outline' => array(
					'label' => esc_html__('Outline', 'g5-element'),
					'img' => G5ELEMENT()->plugin_url('assets/images/video-outline.png'),
				),
			)),
			'std' => 'classic',
			'admin_label' => true,
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Video Text', 'g5-element'),
			'param_name' => 'text',
			'std' => '',
		),
		array(
			'param_name'  => 'size',
			'heading'     => esc_html__('Size', 'g5-element'),
			'type'        => 'dropdown',
			'value'       => array(
				esc_html__('Small', 'g5-element')  => 'sm',
				esc_html__('Medium', 'g5-element') => 'md',
				esc_html__('Large', 'g5-element')  => 'lg'
			),
			'admin_label' => true,
			'std'         => 'md',
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Link', 'g5-element'),
			'param_name' => 'link',
			'value' => '',
			'std' => 'https://www.youtube.com/watch?v=6v2L2UGZJAM',
		),
		array(
			'type' => 'g5element_color',
			'heading' => esc_html__('Color', 'g5-element'),
			'param_name' => 'video_color',
			'std' => ''
		),
		array(
			'type' => 'g5element_typography',
			'heading' => esc_html__('Text', 'g5-element'),
			'param_name' => 'text_option',
			'selector' => '',
			'group' => esc_html__('Text Options', 'g5-element'),
			'std' => G5ELEMENT()->vc_params()->get_typography_default(),
			'dependency' => array(
				'element' => 'switch_text',
				'value' => 'on',
			)
		),
		g5element_vc_map_add_extra_class(),
		g5element_vc_map_add_css_animation(),
		g5element_vc_map_add_animation_duration(),
		g5element_vc_map_add_animation_delay(),
		g5element_vc_map_add_css_editor(),
		g5element_vc_map_add_responsive(),
	)

);
