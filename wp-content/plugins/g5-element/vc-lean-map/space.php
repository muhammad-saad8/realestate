<?php
/**
 * VC Lean map config
 *
 * @package g5element
 * @subpackage space
 * @since 1.0
 */
return array(
    'base' => 'g5element_space',
    'name' => esc_html__('Space', 'g5-element'),
    'category' => G5ELEMENT()->shortcode()->get_category_name(),
    'description' => esc_html__('Add responsive space element on the page','g5-element'),
    'icon' => 'g5element-vc-icon-space',
    'params' => array(
        array(
            'type' => 'g5element_number',
            'param_name' => 'spacing',
            'heading' => __('Spacing (px)', 'g5-element'),
            'admin_label' => true,
            'std' => '60',
        ),
        array(
            'type' => 'g5element_number',
            'heading' => __('Large Devices', 'g5-element'),
            'description' => esc_html__('Width < 1200px', 'g5-element'),
            'param_name' => 'spacing_lg',
            'admin_label' => true,
            'std' => '',
            'edit_field_class' => 'vc_col-sm-3 vc_column'
        ),
        array(
            'type' => 'g5element_number',
            'heading' => __('Medium Devices', 'g5-element'),
            'description' => esc_html__('Width < 992px', 'g5-element'),
            'param_name' => 'spacing_md',
            'admin_label' => true,
            'std' => '',
            'edit_field_class' => 'vc_col-sm-3 vc_column'
        ),
        array(
            'type' => 'g5element_number',
            'heading' => __('Small Devices', 'g5-element'),
            'description' => esc_html__('Width < 768px', 'g5-element'),
            'param_name' => 'spacing_sm',
            'admin_label' => true,
            'std' => '',
            'edit_field_class' => 'vc_col-sm-3 vc_column'
        ),
        array(
            'type' => 'g5element_number',
            'heading' => __('Extra Small Devices', 'g5-element'),
            'description' => esc_html__('Width < 576px', 'g5-element'),
            'param_name' => 'spacing_xs',
            'admin_label' => true,
            'std' => '',
            'edit_field_class' => 'vc_col-sm-3 vc_column'
        )
    )
);