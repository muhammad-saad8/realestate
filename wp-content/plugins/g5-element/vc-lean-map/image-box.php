<?php
/**
 * VC Lean map config
 *
 * @package g5element
 * @subpackage image_box
 * @since 1.0
 */
return array(
    'base' => 'g5element_image_box',
    'name' => esc_html__('Image Box', 'g5-element'),
    'category' => G5ELEMENT()->shortcode()->get_category_name(),
    'description' => esc_html__('Display info box with image', 'g5-element'),
    'icon' => 'g5element-vc-icon-image-box',
    'params' => array_merge(
        array(
            array(
            'type' => 'g5element_image_set',
            'heading' => esc_html__('Layout style', 'g5-element'),
            'param_name' => 'layout_style',
            'value' => apply_filters('g5element_settings_image_box_layout',array(
                'style-01' => array(
                    'label' => esc_html__('Style 01', 'g5-element'),
                    'img' => G5ELEMENT()->plugin_url('assets/images/image-box-style-01.jpg'),
                ),
                'style-02' => array(
                    'label' => esc_html__('Style 02', 'g5-element'),
                    'img' => G5ELEMENT()->plugin_url('assets/images/image-box-style-02.jpg'),
                ),
                'style-03' => array(
                    'label' => esc_html__('Style 03', 'g5-element'),
                    'img' => G5ELEMENT()->plugin_url('assets/images/image-box-style-03.jpg'),
                ),
                'style-04' => array(
                    'label' => esc_html__('Style 04', 'g5-element'),
                    'img' => G5ELEMENT()->plugin_url('assets/images/image-box-style-04.jpg'),
                ),
                'style-05' => array(
                    'label' => esc_html__('Style 05', 'g5-element'),
                    'img' => G5ELEMENT()->plugin_url('assets/images/image-box-style-05.jpg'),
                ),
                'style-06' => array(
                    'label' => esc_html__('Style 06', 'g5-element'),
                    'img' => G5ELEMENT()->plugin_url('assets/images/image-box-style-06.jpg'),
                ),
                'style-07' => array(
                    'label' => esc_html__('Style 07', 'g5-element'),
                    'img' => G5ELEMENT()->plugin_url('assets/images/image-box-style-07.jpg'),
                ),
            )),
            'std' => 'style-01',
        ),
        g5element_vc_map_add_icon_image(),
	    g5element_vc_map_add_icon_image(array(
	    	'heading' => esc_html__('Hover Images','g5-element'),
	    	'param_name' => 'icon_image_hover'
	    )),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Image style', 'g5-element'),
            'param_name' => 'img_style',
            'value' => array(
                esc_html__('Circle', 'g5-element') => 'border-img img-circle',
                esc_html__('Circle (no border)', 'g5-element') => 'img-circle',
                esc_html__('Square', 'g5-element') => 'border-img img-square',
                esc_html__('Square (no border)', 'g5-element') => 'img-square',
                esc_html__('Default', 'g5-element') => 'img-default',
            ),
            'std' => 'img-circle',
            'description' => esc_html__('Select Image style.', 'g5-element')
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Image Width', 'g5-element'),
            'param_name' => 'img_size',
            'value' => array(
                esc_html__('Small (60px)', 'g5-element') => 'img-size-sm',
                esc_html__('Medium (80px)', 'g5-element') => 'img-size-md',
                esc_html__('Large (120px)', 'g5-element') => 'img-size-lg',
                esc_html__('Origin image', 'g5-element') => 'img-size-origin',
                esc_html__('Custom width', 'g5-element') => 'custom',
            ),
            'std' => 'img-size-md',
            'description' => esc_html__('Select image width', 'g5-element')
        ),
        array(
	        'type'             => 'g5element_number',
	        'heading'          => esc_html__('Image Width', 'g5-element'),
	        'param_name'       => 'img_width',
	        'std'              => '',
	        'dependency' => array('element' => 'img_size', 'value' => 'custom'),
        ),
        array(
	        'param_name' => 'hover_effect',
	        'heading' => esc_html__('Hover Effect', 'g5-element'),
	        'type' => 'dropdown',
	        'std' => '',
	        'value' => array(
		        esc_html__('None', 'g5-element') => '',
		        esc_html__('Gray Scale', 'g5-element') => 'gray-scale',
		        esc_html__('Opacity', 'g5-element') => 'opacity',
		        esc_html__('Shine', 'g5-element') => 'shine',
		        esc_html__('Circle', 'g5-element') => 'circle',
		        esc_html__('Flash', 'g5-element') => 'flash',
	        ),
	        'edit_field_class' => 'vc_col-sm-6 vc_column',
        ),
        array(
	        'type'       => 'dropdown',
	        'heading'    => esc_html__('Hover Image effect', 'g5-element'),
	        'param_name' => 'hover_image_effect',
	        'std' => 'default',
	        'value'      => array_flip(G5ELEMENT()->settings()->get_hover_effect_image()),
	        'edit_field_class' => 'vc_col-sm-6 vc_column',
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Title', 'g5-element'),
            'param_name' => 'title',
            'value' => '',
            'admin_label' => true,
            'std' => esc_html__('Title on the Image Box','g5-element'),
        ),
        array(
	        'type' => 'textarea_html',
	        'heading' => esc_html__('Description', 'g5-element'),
	        'param_name' => 'content',
            'value' => '',
            'description' => esc_html__('Provide the description for this element.', 'g5-element'),
	        'std' => '',
        ),
        array(
            'type' => 'vc_link',
            'heading' => esc_html__('Link (url)', 'g5-element'),
            'param_name' => 'link',
            'value' => '',
        ),
        array(
            'type' => 'g5element_switch',
            'heading' => esc_html__('Show Button', 'g5-element'),
            'description' => esc_html__('Operation when link are available', 'g5-element'),
            'param_name' => 'switch_show_button',
            'std' => 'off'
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Text Button', 'g5-element'),
            'param_name' => 'text_button',
            'std' => esc_html__('Click','g5-element'),
            'dependency' => array('element' => 'switch_show_button', 'value' => 'on'),
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
            'type' => 'g5element_typography',
            'heading' => esc_html__('Description', 'g5-element'),
            'param_name' => 'description_typography',
            'selector' => '',
            'group' => esc_html__('Description Options', 'g5-element'),
            'std' => G5ELEMENT()->vc_params()->get_typography_default(),
        ),
        ),
        G5CORE()->settings()->get_button_config('', esc_html__('Button Options', 'g5-element')),
        array(
            g5element_vc_map_add_extra_class(),
            g5element_vc_map_add_css_editor(),
            g5element_vc_map_add_css_animation(),
            g5element_vc_map_add_responsive(),
            g5element_vc_map_add_animation_duration(),
            g5element_vc_map_add_animation_delay(),
        )
    ),
);