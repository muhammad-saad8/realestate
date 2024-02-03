<?php
/**
 * VC Lean map config
 *
 * @package g5element
 * @subpackage testimonial
 * @since 1.0
 */
return array(
	'base' => 'g5element_testimonial',
	'name' => esc_html__('Testimonial', 'g5-element'),
	'category' => G5ELEMENT()->shortcode()->get_category_name(),
	'description' => esc_html__('Show customer testimonials', 'g5-element'),
	'icon' => 'g5element-vc-icon-testimonial',
	'params' => array(
		array(
			'type' => 'g5element_image_set',
			'heading' => esc_html__('Testimonials Layout', 'g5-element'),
			'description' => esc_html__('Select our testimonial layout.', 'g5-element'),
			'param_name' => 'layout_style',
			'value' => apply_filters('gsf_testimonials_layout_style', array(
				'style-01' => array(
					'label' => esc_html__('Style 01', 'g5-element'),
					'img' => G5ELEMENT()->plugin_url('assets/images/testimonial-01.png'),
				),
				'style-02' => array(
					'label' => esc_html__('Style 02', 'g5-element'),
					'img' => G5ELEMENT()->plugin_url('assets/images/testimonial-02.png'),
				),
				'style-03' => array(
					'label' => esc_html__('Style 03', 'g5-element'),
					'img' => G5ELEMENT()->plugin_url('assets/images/testimonial-03.png'),
				),
				'style-04' => array(
					'label' => esc_html__('Style 04', 'g5-element'),
					'img' => G5ELEMENT()->plugin_url('assets/images/testimonial-04.png'),
				),
				'style-05' => array(
					'label' => esc_html__('Style 05', 'g5-element'),
					'img' => G5ELEMENT()->plugin_url('assets/images/testimonial-05.png'),
				),
				'style-06' => array(
					'label' => esc_html__('Style 06', 'g5-element'),
					'img' => G5ELEMENT()->plugin_url('assets/images/testimonial-06.png'),
				),
				'style-07' => array(
					'label' => esc_html__('Style 07', 'g5-element'),
					'img' => G5ELEMENT()->plugin_url('assets/images/testimonial-07.png'),
				)
			)),
			'std' => 'style-02',
			'admin_label' => true,
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Rating', 'g5-element'),
			'param_name' => 'rating',
			'value' => array(
				esc_html__('None', 'g5-element') => 'none',
				esc_html__('1 Star', 'g5-element') => '1',
				esc_html__('2 Star', 'g5-element') => '2',
				esc_html__('3 Star', 'g5-element') => '3',
				esc_html__('4 Star', 'g5-element') => '4',
				esc_html__('5 Star', 'g5-element') => '5',
			),
			'std' => '5',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Align', 'g5-element'),
			'param_name' => 'align',
			'value' => array(
				esc_html__('Left', 'g5-element') => 'left',
				esc_html__('Right', 'g5-element') => 'right',
				esc_html__('Center', 'g5-element') => 'center',
			),
			'std' => 'left',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
		),
		array(
			'type' => 'attach_image',
			'heading' => esc_html__('Upload Avatar:', 'g5-element'),
			'param_name' => 'author_avatar',
			'value' => '',
			'description' => esc_html__('Upload avatar for author.', 'g5-element'),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Image style', 'g5-element'),
			'param_name' => 'img_style',
			'value' => array(
				esc_html__('Circle', 'g5-element') => 'img-circle',
				esc_html__('Default', 'g5-element') => 'img-default',
			),
			'std' => 'img-circle',
			'description' => esc_html__('Select Image style.', 'g5-element')
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Image Size', 'g5-element'),
			'param_name' => 'img_size',
			'value' => array(
				esc_html__('Small', 'g5-element') => 'img-size-sm',
				esc_html__('Medium', 'g5-element') => 'img-size-md',
				esc_html__('Large', 'g5-element') => 'img-size-lg',
				esc_html__('Origin image', 'g5-element') => 'img-size-origin',
			),
			'std' => 'img-size-md',
			'description' => esc_html__('Select icon size', 'g5-element')
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Author Name', 'g5-element'),
			'param_name' => 'author_name',
			'admin_label' => true,
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'std' => esc_html__('Edna Watson', 'g5-element'),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Author Job', 'g5-element'),
			'param_name' => 'author_job',
			'admin_label' => true,
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'std' => esc_html__('Design', 'g5-element'),
		),
		array(
			'type' => 'textarea',
			'heading' => esc_html__('Content testimonials of the author', 'g5-element'),
			'param_name' => 'author_bio',
			'std' => esc_html__('Thanks for building Crown & for your support. Nice work @crownframework team!', 'g5-element'),
		),
		array(
			'type' => 'g5element_switch',
			'heading' => esc_html__('Show Main Content', 'g5-element'),
			'param_name' => 'show_main_content',
			'std' => '',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'dependency' => array(
				'element' => 'layout_style',
				'value' => array('style-02'),
			),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Main Content', 'g5-element'),
			'param_name' => 'main_content',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'dependency' => array(
				'element' => 'show_main_content',
				'value' => array('on'),
			),
			'std' => esc_html__('Awesome Design', 'g5-element')
		),
		array(
			'type' => 'g5element_switch',
			'heading' => esc_html__('Content Quote', 'g5-element'),
			'param_name' => 'content_quote',
			'std' => '',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
		),
		array(
			'type' => 'g5element_switch',
			'heading' => esc_html__('Content Background', 'g5-element'),
			'param_name' => 'content_background',
			'std' => '',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'dependency' => array(
				'element' => 'layout_style',
				'value' => array('style-01', 'style-02', 'style-03', 'style-04', 'style-05'),
			),
		),
		array(
			'type' => 'g5element_color',
			'heading' => esc_html__('Content Background Color', 'g5-element'),
			'param_name' => 'content_bg_color',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'std' => '',
			'dependency' => array(
				'element' => 'content_background',
				'value' => 'on',
			),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Author Link', 'g5-element'),
			'param_name' => 'author_link',
			'std' => 'http://pepper.g5plus.net/our-clients/',
		),
		array(
			'type' => 'g5element_typography',
			'heading' => esc_html__('Name Testimonial', 'g5-element'),
			'param_name' => 'name_typography',
			'selector' => '',
			'group' => esc_html__('Name Options', 'g5-element'),
			'std' => G5ELEMENT()->vc_params()->get_typography_default()
		),
		array(
			'type' => 'g5element_typography',
			'heading' => esc_html__('Job Testimonial', 'g5-element'),
			'param_name' => 'job_typography',
			'selector' => '',
			'group' => esc_html__('Job Options', 'g5-element'),
			'std' => G5ELEMENT()->vc_params()->get_typography_default()
		),
		array(
			'type' => 'g5element_typography',
			'heading' => esc_html__('Content Testimonial', 'g5-element'),
			'param_name' => 'content_typography',
			'selector' => '',
			'group' => esc_html__('Content Options', 'g5-element'),
			'std' => G5ELEMENT()->vc_params()->get_typography_default()
		),
		array(
			'type' => 'g5element_typography',
			'heading' => esc_html__('Main Content', 'g5-element'),
			'param_name' => 'main_content_typography',
			'selector' => '',
			'group' => esc_html__('Main Content Options', 'g5-element'),
			'std' => G5ELEMENT()->vc_params()->get_typography_default(),
			'dependency' => array(
				'element' => 'show_main_content',
				'value' => 'on',
			),
		),

		g5element_vc_map_add_extra_class(),
		g5element_vc_map_add_css_animation(),
		g5element_vc_map_add_animation_duration(),
		g5element_vc_map_add_animation_delay(),
		g5element_vc_map_add_css_editor(),
		g5element_vc_map_add_responsive(),
	)

);