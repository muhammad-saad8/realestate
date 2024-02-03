<?php
/**
 * VC Lean map config
 *
 * @package g5element
 * @subpackage our_team
 * @since 1.0
 */
return array(
    'base' => 'g5element_our_team',
    'name' => esc_html__('Our Team', 'g5-element'),
    'category' => G5ELEMENT()->shortcode()->get_category_name(),
    'description' => esc_html__('Show your awesome team.', 'g5-element'),
    'icon' => 'g5element-vc-icon-our-team',
    'params' => array(
        array(
            'type' => 'g5element_image_set',
            'heading' => esc_html__('Layout style', 'g5-element'),
            'param_name' => 'layout_style',
            'value' => array(
                'style-01' => array(
                    'label' => esc_html__('Circle', 'g5-element'),
                    'img' => G5ELEMENT()->plugin_url('assets/images/our-team-style-01.jpg'),
                ),
                'style-02' => array(
                    'label' => esc_html__('Rectangle', 'g5-element'),
                    'img' => G5ELEMENT()->plugin_url('assets/images/our-team-style-02.jpg'),
                )
            ),
            'std' => 'style-01',
        ),
        array(
            'type' => 'attach_image',
            'heading' => esc_html__('Avatar', 'g5-element'),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'param_name' => 'avatar'
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Name', 'g5-element'),
            'param_name' => 'name',
            'std' => esc_html__('Name on the Our Team', 'g5-element'),
            'admin_label' => true,
        ),
        array(
            'type' => 'g5element_typography',
            'heading' => esc_html__('Name', 'g5-element'),
            'param_name' => 'name_typography',
            'selector' => '',
            'std' => G5ELEMENT()->vc_params()->get_typography_default(),
            'group' => esc_html__('Name Options', 'g5-element'),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Job Title', 'g5-element'),
            'param_name' => 'job',
            'std' => esc_html__('Job Title on the Our Team', 'g5-element'),
        ),
        array(
            'type' => 'g5element_typography',
            'heading' => esc_html__('Job Title', 'g5-element'),
            'param_name' => 'job_typography',
            'selector' => '',
            'std' => G5ELEMENT()->vc_params()->get_typography_default(),
            'group' => esc_html__('Job Title Options', 'g5-element'),
        ),
        array(
            'type' => 'textarea',
            'heading' => esc_html__('Description', 'g5-element'),
            'param_name' => 'description',
            'std' => esc_html__('Description on the Our Team', 'g5-element'),
        ),
        array(
            'type' => 'g5element_typography',
            'heading' => esc_html__('Description', 'g5-element'),
            'param_name' => 'description_typography',
            'selector' => '',
            'std' => G5ELEMENT()->vc_params()->get_typography_default(),
            'group' => esc_html__('Description Options', 'g5-element'),
        ),
        array(
            'type' => 'vc_link',
            'heading' => esc_html__('Link (URL)', 'g5-element'),
            'param_name' => 'our_team_link',
        ),
        array(
            'type' => 'param_group',
            'heading' => esc_html__('Social', 'g5-element'),
            'param_name' => 'socials',
            'params' => array(
                array(
                    'param_name'  => 'social_icons',
                    'heading'     => esc_html__('Social', 'g5-element'),
                    'type'        => 'dropdown',
                    'value' => array_flip(G5CORE()->settings()->get_social_networks()),
                    'admin_label' => true,
                    'std'         => ''
                ),
                array(
                    'type' => 'vc_link',
                    'heading' => esc_html__('Link (URL)', 'g5-element'),
                    'param_name' => 'social_link',
                ),
            )
        ),
        g5element_vc_map_add_css_animation(),
        g5element_vc_map_add_animation_duration(),
        g5element_vc_map_add_animation_delay(),
        g5element_vc_map_add_extra_class(),
        g5element_vc_map_add_css_editor(),
        g5element_vc_map_add_responsive(),
    ),
);