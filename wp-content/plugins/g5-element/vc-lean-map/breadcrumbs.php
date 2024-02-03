<?php
/**
 * VC Lean map config
 *
 * @package g5element
 * @subpackage breadcrumbs
 * @since 1.0
 */
return array(
    'base' => 'g5element_breadcrumbs',
    'name' => esc_html__('Breadcrumbs', 'g5-element'),
    'category' => G5ELEMENT()->shortcode()->get_category_name(),
    'description' => esc_html__('Displays your site breadcrumbs.','g5-element'),
    'icon' => 'g5element-vc-icon-breadcrumbs',
    'params' => array(
        array(
            'type' => 'g5element_button_set',
            'heading' => esc_html__('Layout Style', 'g5-element'),
            'param_name' => 'layout_style',
            'value' => array(
                esc_html__('Alignment Left', 'g5-element') => 'left',
                esc_html__('Alignment Center', 'g5-element') => 'center',
                esc_html__('Alignment Right', 'g5-element') => 'right',
            ),
            'std' => 'left',
            'admin_label' => true,
        ),
	    array(
		    'type'       => 'g5element_typography',
		    'heading'    => esc_html__('Typography', 'g5-element'),
		    'param_name' => 'breadcrumbs_typography',
		    'std'        => G5ELEMENT()->vc_params()->get_typography_default(),
		    'selector'   => '',
		    'group'      => esc_html__('Typography', 'g5-element'),
	    ),
        g5element_vc_map_add_css_animation(),
        g5element_vc_map_add_animation_duration(),
        g5element_vc_map_add_animation_delay(),
        g5element_vc_map_add_extra_class(),
        g5element_vc_map_add_css_editor(),
        g5element_vc_map_add_responsive(),
    )
);