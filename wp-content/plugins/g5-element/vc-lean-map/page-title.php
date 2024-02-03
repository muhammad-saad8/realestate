<?php
/**
 * VC Lean map config
 *
 * @package g5element
 * @subpackage image_box
 * @since 1.0
 */
return array(
    'base' => 'g5element_page_title',
    'name' => esc_html__('Page Title', 'g5-element'),
    'category' => G5ELEMENT()->shortcode()->get_category_name(),
    'description' => esc_html__('Display current page title', 'g5-element'),
    'icon'        => 'g5element-vc-icon-page-title',
    'params' => array(
        array(
            'type'       => 'g5element_image_set',
            'heading'    => esc_html__( 'Layout style', 'g5-element' ),
            'param_name' => 'layout_style',
            'value'      => array(
                'style-01' => array(
                    'label' => esc_html__( 'Style 01', 'g5-element' ),
                    'img'   => G5ELEMENT()->plugin_url( 'assets/images/page-title-style-01.jpg' ),
                ),
                'style-02' => array(
                    'label' => esc_html__( 'Style 02', 'g5-element' ),
                    'img'   => G5ELEMENT()->plugin_url( 'assets/images/page-title-style-02.jpg' ),
                ),
                'style-03' => array(
                    'label' => esc_html__( 'Style 03', 'g5-element' ),
                    'img'   => G5ELEMENT()->plugin_url( 'assets/images/page-title-style-03.jpg' ),
                ),
            ),
            'std'        => 'style-01',
        ),
        array(
            'type' => 'g5element_typography',
            'heading' => esc_html__('Title Page', 'g5-element'),
            'param_name' => 'title_typography',
            'selector' => '',
            'group' => esc_html__('Title Page Options', 'g5-element'),
            'std' => G5ELEMENT()->vc_params()->get_typography_default(),
        ),
        array(
            'type' => 'g5element_typography',
            'heading' => esc_html__('Sub Title Page', 'g5-element'),
            'param_name' => 'sub_title_typography',
            'selector' => '',
            'group' => esc_html__('Sub Title Page Options', 'g5-element'),
            'std' => G5ELEMENT()->vc_params()->get_typography_default(),
        ),
        g5element_vc_map_add_extra_class(),
        g5element_vc_map_add_css_animation(),
        g5element_vc_map_add_css_editor(),
        g5element_vc_map_add_responsive(),
        g5element_vc_map_add_animation_duration(),
        g5element_vc_map_add_animation_delay(),
    ));