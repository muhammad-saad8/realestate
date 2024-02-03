<?php
/**
 * VC Lean map config
 *
 * @package g5element
 * @subpackage list
 * @since 1.0
 */
return array(
    'base' => 'g5element_list',
    'name' => esc_html__('List', 'g5-element'),
    'category' => G5ELEMENT()->shortcode()->get_category_name(),
    'description' => esc_html__('Add a set of multiple icons/text and give some custom style.', 'g5-element'),
    'icon' => 'g5element-vc-icon-list',
    'params' => array(
        array(
            'type' => 'g5element_image_set',
            'heading' => esc_html__('Layout style', 'g5-element'),
            'param_name' => 'layout_style',
            'admin_label' => true,
            'value' => array(
                'style-01' => array(
                    'label' => esc_html__('Style 01', 'g5-element'),
                    'img' => G5ELEMENT()->plugin_url('assets/images/list-style-01.jpg'),
                ),
                'style-02' => array(
                    'label' => esc_html__('Style 02', 'g5-element'),
                    'img' => G5ELEMENT()->plugin_url('assets/images/list-style-02.jpg'),
                ),
                'style-03' => array(
                    'label' => esc_html__('Style 03', 'g5-element'),
                    'img' => G5ELEMENT()->plugin_url('assets/images/list-style-03.jpg'),
                ),
            ),
            'std' => 'style-01',
        ),
        array(
            'type' => 'g5element_button_set',
            'heading' => esc_html__('List Style Type', 'g5-element'),
            'param_name' => 'list_style_type',
            'value' => array(
                esc_html__('Style List', 'g5-element') => 'style_list',
                esc_html__('Icon List', 'g5-element') => 'icon_list',
            ),
            'std' => 'style_list',
            'dependency' => array(
                'element' => 'layout_style',
                'value_not_equal_to' => 'style-03',
            ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Shape bullet', 'g5-element'),
            'param_name' => 'shape_bullet',
            'value' => array(
                esc_html__('Circle List', 'g5-element') => 'circle-type',
                esc_html__('Square', 'g5-element') => 'square-type',
                esc_html__('Number', 'g5-element') => 'number-type',
                esc_html__('Roman Number', 'g5-element') => 'roman-number-type',
                esc_html__('Alpha', 'g5-element') => 'alpha-type',
                esc_html__('None', 'g5-element') => 'none-type',
            ),
            'std' => 'circle-type',
            'description' => esc_html__('Select List Style Type.', 'g5-element'),
            'dependency' => array('element' => 'list_style_type', 'value' => 'style_list'),
            'edit_field_class' => 'vc_col-sm-6 vc_column'
        ),
        array(
            'type' => 'g5element_number',
            'heading' => esc_html__('Start auto number', 'g5-element'),
            'param_name' => 'start_auto_number',
            'std' => esc_html__('1', 'g5-element'),
            'dependency' => array('element' => 'shape_bullet', 'value' =>
                array('number-type', 'roman-number-type', 'alpha-type')),
            'edit_field_class' => 'vc_col-sm-6 vc_column'
        ),
        g5element_vc_map_add_icon_font(array(
            'param_name' => 'icon_style_list',
            'dependency' => array('element' => 'list_style_type', 'value' => 'icon_list'),
            'description' => esc_html__('Customize icon for item.', 'g5-element'),
            'edit_field_class' => 'vc_col-sm-6 vc_column'
        )),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Text Align', 'g5-element'),
            'param_name' => 'text_align',
            'value' => array(
                esc_html__('Left', 'g5-element') => 'align-left',
                esc_html__('Right', 'g5-element') => 'align-right',
                esc_html__('Center', 'g5-element') => 'align-center',
            ),
            'std' => 'align-left',
            'description' => esc_html__('Select Text Align.', 'g5-element'),
            'dependency' => array('element' => 'layout_style', 'value' => 'style-03'),
            'edit_field_class' => 'vc_col-sm-6 vc_column'
        ),
        array(
            'type' => 'g5element_color',
            'heading' => esc_html__('Color Shape bullet', 'g5-element'),
            'param_name' => 'color_list_type',
            'description' => esc_html__('Select button color.', 'g5-element'),
            'std' => 'accent',
            'dependency' => array(
                'element' => 'layout_style',
                'value_not_equal_to' => 'style-03',
            ),
        ),
        array(
            'type' => 'param_group',
            'heading' => esc_html__('Item List', 'g5-element'),
            'param_name' => 'values',
            'params' => array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Items', 'g5-element'),
                    'param_name' => 'items',
                    'value' => '',
                    'std' => esc_html__('Item on List', 'g5-element'),
                    'admin_label' => true,
                ),
                g5element_vc_map_add_icon_font(
                    array(
                        'param_name' => 'icon_style_item',
                        'std' => '',
                        'description' => esc_html__('Customize icon for each item.', 'g5-element'),
                    )
                ),
                array(
                    'type' => 'vc_link',
                    'heading' => esc_html__('Link (url)', 'g5-element'),
                    'param_name' => 'link',
                    'value' => '',
                ),
            ),
        ),
        array(
            'type' => 'g5element_typography',
            'heading' => esc_html__('Item List', 'g5-element'),
            'param_name' => 'item_typography',
            'selector' => '',
            'group' => esc_html__('Item List Options', 'g5-element'),
            'std' => G5ELEMENT()->vc_params()->get_typography_default(),
        ),
        g5element_vc_map_add_extra_class(),
        g5element_vc_map_add_css_animation(),
        g5element_vc_map_add_css_editor(),
        g5element_vc_map_add_responsive(),
        g5element_vc_map_add_animation_duration(),
        g5element_vc_map_add_animation_delay(),
    ));