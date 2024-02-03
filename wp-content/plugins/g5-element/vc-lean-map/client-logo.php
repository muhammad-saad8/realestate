<?php
/**
 * VC Lean map config
 *
 * @package g5element
 * @subpackage client_logo
 * @since 1.0
 */
return array(
    'base' => 'g5element_client_logo',
    'name' => esc_html__('Client Logo', 'g5-element'),
    'category' => G5ELEMENT()->shortcode()->get_category_name(),
    'description' => esc_html__('Display your partner\'s logo', 'g5-element'),
    'icon' => 'g5element-vc-icon-client-logo',
    'params' => array(
        array(
            'param_name' => 'logo_effect',
            'heading' => esc_html__('Logo Effect', 'g5-element'),
            'type' => 'dropdown',
            'std' => 'faded-effect',
            'admin_label' => true,
            'value' => array(
                esc_html__('Faded', 'g5-element') => 'faded-effect',
                esc_html__('Scale Up', 'g5-element') => 'scaleup-effect',
                esc_html__('Move Up', 'g5-element') => 'moveup-effect',
            )

        ),
        array(
            'type' => 'attach_image',
            'heading' => esc_html__('Images', 'g5-element'),
            'param_name' => 'image',
            'value' => '',
            'description' => esc_html__('Select images from media library.', 'g5-element')
        ),
        array(
            'type' => 'attach_image',
            'heading' => esc_html__('Hover Images', 'g5-element'),
            'param_name' => 'image_hover',
            'value' => '',
            'description' => esc_html__('Select images from media library.', 'g5-element'),
            'dependency' => array(
                'element' => 'logo_effect',
                'value' => array('scaleup-effect', 'moveup-effect')
            ),
        ),
        array(
            'type' => 'vc_link',
            'heading' => esc_html__('URL (Link)', 'g5-element'),
            'param_name' => 'link',
            'description' => esc_html__('Add link .', 'g5-element'),
        ),
        array(
            'type' => 'g5element_slider',
            'heading' => esc_html__('Images effect value', 'g5-element'),
            'param_name' => 'opacity',
            'args' => array(
                'min' => 1,
                'max' => 100,
                'step' => 1
            ),
            'std' => 70,
            'dependency' => array('element' => 'logo_effect', 'value' => 'faded-effect'),
        ),
        array(
            'type' => 'g5element_slider',
            'heading' => esc_html__('Images effect value when hover', 'g5-element'),
            'param_name' => 'opacity_hover',
            'args' => array(
                'min' => 1,
                'max' => 100,
                'step' => 1
            ),
            'std' => 100,
            'dependency' => array('element' => 'logo_effect', 'value' => 'faded-effect'),
        ),
        g5element_vc_map_add_element_id(),
        g5element_vc_map_add_extra_class(),
        g5element_vc_map_add_css_animation(),
        g5element_vc_map_add_animation_duration(),
        g5element_vc_map_add_animation_delay(),
        g5element_vc_map_add_css_editor(),
	    g5element_vc_map_add_responsive(),
    )
);

