<?php
/**
 * VC Lean map config
 *
 * @package g5element
 * @subpackage banner
 * @since 1.0
 */
return array(
    'base' => 'g5element_banner',
    'name' => esc_html__('Banner', 'g5-element'),
    'category' => G5ELEMENT()->shortcode()->get_category_name(),
    'description' => esc_html__('Displays the banner image with information','g5-element'),
    'icon' => 'g5element-vc-icon-banner',
    'params' => array_merge(
        array(
            array(
                'type' => 'g5element_image_set',
                'heading' => esc_html__('Layout Style', 'g5-element'),
                'param_name' => 'layout_style',
                'value' => array(
                    'style-01' => array(
                        'label' => esc_html__('Style 01', 'g5-element'),
                        'img' => G5ELEMENT()->plugin_url('assets/images/banner-style-01.jpg'),
                    ),
                    'style-02' => array(
                        'label' => esc_html__('Style 02', 'g5-element'),
                        'img' => G5ELEMENT()->plugin_url('assets/images/banner-style-02.jpg'),
                    ),
                    'style-03' => array(
                        'label' => esc_html__('Style 03', 'g5-element'),
                        'img' => G5ELEMENT()->plugin_url('assets/images/banner-style-03.jpg'),
                    ),
                    'style-04' => array(
                        'label' => esc_html__('Style 04', 'g5-element'),
                        'img' => G5ELEMENT()->plugin_url('assets/images/banner-style-04.jpg'),
                    ),
                    'style-05' => array(
                        'label' => esc_html__('Style 05', 'g5-element'),
                        'img' => G5ELEMENT()->plugin_url('assets/images/banner-style-05.jpg'),
                    ),
                    'style-06' => array(
                        'label' => esc_html__('Style 06', 'g5-element'),
                        'img' => G5ELEMENT()->plugin_url('assets/images/banner-style-06.jpg'),
                    ),
                    'style-07' => array(
                        'label' => esc_html__('Style 07', 'g5-element'),
                        'img' => G5ELEMENT()->plugin_url('assets/images/banner-style-07.jpg'),
                    )
                ),
                'std' => 'style-02',
                'admin_label' => true,
            ),
            array(
                'type' => 'attach_image',
                'heading' => esc_html__('Background Image', 'g5-element'),
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'param_name' => 'image'
            ),
            array(
                'type' => 'textarea',
                'heading' => esc_html__('Title', 'g5-element'),
                'param_name' => 'banner_title',
                'admin_label' => true,
                'std' => esc_html__('Title on the Banner','g5-element'),
                'dependency' => array('element' => 'layout_style', 'value_not_equal_to' => array('style-07'))
            ),
            array(
                'type' => 'g5element_typography',
                'heading' => esc_html__('Title', 'g5-element'),
                'param_name' => 'title_typography',
                'selector' => '',
                'std' => G5ELEMENT()->vc_params()->get_typography_default(),
                'group' => esc_html__('Title Options', 'g5-element'),
                'dependency' => array('element' => 'layout_style', 'value_not_equal_to' => array('style-07'))
            ),
            array(
                'type' => 'textarea',
                'heading' => esc_html__('Description', 'g5-element'),
                'param_name' => 'banner_description',
                'std' => esc_html__('Description on the Banner','g5-element'),
                'dependency' => array('element' => 'layout_style', 'value_not_equal_to' => array('style-07')),
            ),
            array(
                'type' => 'g5element_typography',
                'heading' => esc_html__('Description', 'g5-element'),
                'param_name' => 'description_typography',
                'selector' => '',
                'std' => G5ELEMENT()->vc_params()->get_typography_default(),
                'group' => esc_html__('Description Options', 'g5-element'),
                'dependency' => array('element' => 'layout_style', 'value_not_equal_to' => array('style-07'))
            ),
            array(
                'param_name' => 'hover_effect',
                'heading' => esc_html__('Hover Effect', 'g5-element'),
                'type' => 'dropdown',
                'std' => '',
                'value' => array(
                    esc_html__('None', 'g5-element') => '',
	                esc_html__('Symmetry', 'g5-element') => 'symmetry-effect',
                    esc_html__('Suprema', 'g5-element') => 'suprema-effect',
                    esc_html__('Layla', 'g5-element') => 'layla-effect',
                    esc_html__('Bubba', 'g5-element') => 'bubba-effect',
                    esc_html__('Jazz', 'g5-element') => 'jazz-effect',
                    esc_html__('Flash', 'g5-element') => 'flash-effect',
	                esc_html__('Ming', 'g5-element') => 'ming-effect'
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
                'type' => 'dropdown',
                'heading' => esc_html__('Size Mode', 'g5-element'),
                'param_name' => 'size_mode',
                'value' => array(
                    '1:1' => '100',
                    esc_html__('Original', 'g5-element') => 'original',
                    '4:3' => '133.333333333',
                    '3:4' => '75',
                    '16:9' => '177.777777778',
                    '9:16' => '56.25',
                    esc_html__('Custom', 'g5-element') => 'custom'
                ),
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'std' => 'original',
                'description' => esc_html__('Sizing proportions for height and width. Select "Original" to scale image without cropping.', 'g5-element')
            ),
            array(
                'type'             => 'g5element_button_set',
                'heading'          => esc_html__('Show all content before hover over', 'g5-element'),
                'param_name'       => 'hover_mode',
                'value'            => array(
                    esc_html__('Yes', 'g5-element')   => 'show-all',
                    esc_html__('No', 'g5-element') => '',
                ),
                'std'              => '',
                'edit_field_class' => 'vc_col-sm-6 vc_column',
            ),
            array(
                'type' => 'g5element_number_and_unit',
                'heading' => esc_html__('Width', 'g5-element'),
                'param_name' => 'width',
                'value' => '340px',
                'dependency' => array('element' => 'size_mode', 'value' => 'custom'),
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'description' => esc_html__('Enter custom height (include unit)', 'g5-element')
            ),
            array(
                'type' => 'g5element_number_and_unit',
                'heading' => esc_html__('Height', 'g5-element'),
                'param_name' => 'height',
                'value' => '340px',
                'dependency' => array('element' => 'size_mode', 'value' => 'custom'),
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'description' => esc_html__('Enter custom height (include unit)', 'g5-element')
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Button title', 'g5-element'),
                'param_name' => 'banner_btn_title',
                'std' => esc_html__('Text on the button','g5-element'),
                'dependency' => array('element' => 'layout_style', 'value_not_equal_to' => array('style-07'))
            ),
            array(
                'type' => 'vc_link',
                'heading' => esc_html__('Link (URL)', 'g5-element'),
                'param_name' => 'link',
                'dependency' => array('element' => 'layout_style', 'value_not_equal_to' => array('style-07'))
            ),
            array(
                'type' => 'textarea_html',
                'heading' => esc_html__('Content Custom', 'g5-element'),
                'param_name' => 'content',
                'std' => esc_html__('Content on the Banner','g5-element'),
                'dependency' => array('element' => 'layout_style', 'value' => array('style-07'))
            ),
        ),
        G5CORE()->settings()->get_button_config('', esc_html__('Button Options','g5-element')),
        array(
            g5element_vc_map_add_css_animation(),
            g5element_vc_map_add_animation_duration(),
            g5element_vc_map_add_animation_delay(),
            g5element_vc_map_add_extra_class(),
            g5element_vc_map_add_css_editor(),
            g5element_vc_map_add_responsive(),
        )
    ),
);