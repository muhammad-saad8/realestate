<?php
/**
 * VC Lean map config
 *
 * @package g5element
 * @subpackage count down
 * @since 1.0
 */
return array(
    'base' => 'g5element_count_down',
    'name' => esc_html__('Count Down', 'g5-element'),
    'category' => G5ELEMENT()->shortcode()->get_category_name(),
    'description' => esc_html__('Countdown Timer.','g5-element'),
    'icon' => 'g5element-vc-icon-count-down',
    'params' => array(
        array(
            'type' => 'g5element_image_set',
            'heading' => esc_html__('Layout Style', 'g5-element'),
            'param_name' => 'layout_style',
            'value' => array(
                'style-01' => array(
                    'label' => esc_html__('Style 01', 'g5-element'),
                    'img' => G5ELEMENT()->plugin_url('assets/images/count-down-style-01.jpg'),
                ),
                'style-02' => array(
                    'label' => esc_html__('Style 02', 'g5-element'),
                    'img' => G5ELEMENT()->plugin_url('assets/images/count-down-style-02.jpg'),
                ),
                'style-03' => array(
                    'label' => esc_html__('Style 03', 'g5-element'),
                    'img' => G5ELEMENT()->plugin_url('assets/images/count-down-style-03.jpg'),
                )
            ),
            'std' => 'style-01',
            'admin_label' => true,
        ),
        array(
            'type' => 'g5element_datetime_picker',
            'heading' => esc_html__('Time Off', 'g5-element'),
            'param_name' => 'time',
        ),
        array(
            'type' => 'g5element_color',
            'heading' => esc_html__('Circle foreground Color', 'g5-element'),
            'param_name' => 'foreground_color',
            'dependency' => array('element' => 'layout_style', 'value' => 'style-03'),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'std' => 'accent',
        ),
        array(
            'type' => 'g5element_color',
            'heading' => esc_html__('Circle background color', 'g5-element'),
            'param_name' => 'background_color',
            'dependency' => array('element' => 'layout_style', 'value' => 'style-03'),
            'std' => 'gray',
            'edit_field_class' => 'vc_col-sm-6 vc_column'
        ),
        array(
            'type' => 'g5element_typography',
            'heading' => esc_html__('Number', 'g5-element'),
            'param_name' => 'number_typography',
            'selector' => '',
            'std' => G5ELEMENT()->vc_params()->get_typography_default(),
            'group' => esc_html__('Number Options', 'g5-element')
        ),
        array(
            'type' => 'g5element_color',
            'heading' => esc_html__('Background Color', 'g5-element'),
            'param_name' => 'background',
            'std' => '',
            'dependency' => array('element' => 'layout_style', 'value' => 'style-02'),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'group' => esc_html__('Number Options', 'g5-element')
        ),
        array(
            'type' => 'g5element_typography',
            'heading' => esc_html__('Text', 'g5-element'),
            'param_name' => 'text_typography',
            'selector' => '',
            'std' => G5ELEMENT()->vc_params()->get_typography_default(),
            'group' => esc_html__('Text Options', 'g5-element')
        ),
        g5element_vc_map_add_css_animation(),
        g5element_vc_map_add_animation_duration(),
        g5element_vc_map_add_animation_delay(),
        g5element_vc_map_add_extra_class(),
        g5element_vc_map_add_css_editor(),
        g5element_vc_map_add_responsive(),
    )
);