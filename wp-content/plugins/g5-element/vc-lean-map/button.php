<?php
/**
 * VC Lean map config
 *
 * @package g5element
 * @subpackage button
 * @since 1.0
 */
return array(
    'base' => 'g5element_button',
    'name' => esc_html__('Button', 'g5-element'),
    'category' => G5ELEMENT()->shortcode()->get_category_name(),
    'description' => esc_html__('Eye catching button', 'g5-element'),
    'icon'        => 'g5element-vc-icon-button',
    'params' => array(
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Text', 'g5-element'),
            'param_name' => 'title',
            'value' => esc_html__('Text on the button', 'g5-element'),
            'admin_label' => true,
        ),
        array(
            'type' => 'vc_link',
            'heading' => esc_html__('URL (Link)', 'g5-element'),
            'param_name' => 'link',
            'description' => esc_html__('Add link to button.', 'g5-element'),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Style', 'g5-element'),
            'description' => esc_html__('Select button display style.', 'g5-element'),
            'param_name' => 'style',
            'value' => array(
                esc_html__('Classic', 'g5-element') => 'classic',
                esc_html__('Outline', 'g5-element') => 'outline',
                esc_html__('Link', 'g5-element') => 'link'
            ),
            'std' => 'classic',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Shape', 'g5-element'),
            'description' => esc_html__('Select button shape.', 'g5-element'),
            'param_name' => 'shape',
            'value' => array(
                esc_html__('Rounded', 'g5-element') => 'rounded',
                esc_html__('Square', 'g5-element') => 'square',
                esc_html__('Round', 'g5-element') => 'round',
            ),
            'dependency' => array(
                'element' => 'style',
                'value_not_equal_to' => array('link'),
            ),
            'std' => 'square',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
        ),
	    array(
		    'type' => 'g5element_color',
		    'heading' => esc_html__('Color', 'g5-element'),
		    'param_name' => 'color',
		    'description' => esc_html__('Select button color.', 'g5-element'),
		    'std' => 'accent',
		    'edit_field_class' => 'vc_col-sm-6 vc_column',
	    ),
	    array(
		    'type' => 'dropdown',
		    'heading' => esc_html__('Size', 'g5-element'),
		    'param_name' => 'size',
		    'description' => esc_html__('Select button display size.', 'g5-element'),
		    'std' => 'md',
		    'value' => array(
			    esc_html__('Small', 'g5-element') => 'sm',
			    esc_html__('Normal', 'g5-element') => 'md',
			    esc_html__('Large', 'g5-element') => 'lg',
			    esc_html__('Extra Large', 'g5-element') => 'xl',
		    ),
		    'edit_field_class' => 'vc_col-sm-6 vc_column',
	    ),

	    array(
		    'type' => 'dropdown',
		    'heading' => esc_html__('Alignment', 'g5-element'),
		    'param_name' => 'align',
		    'description' => esc_html__('Select button alignment.', 'g5-element'),
		    'value' => array(
			    esc_html__('Inline', 'g5-element') => 'inline',
			    esc_html__('Left', 'g5-element') => 'left',
			    esc_html__('Right', 'g5-element') => 'right',
			    esc_html__('Center', 'g5-element') => 'center',
		    ),
		    'std' => 'inline',
	    ),

	    g5element_vc_map_add_icon_font(array('std' => '')),

	    array(
		    'type' => 'g5element_button_set',
		    'heading' => esc_html__('Icon Alignment', 'g5-element'),
		    'description' => esc_html__('Select icon alignment.', 'g5-element'),
		    'param_name' => 'icon_align',
		    'value' => array(
			    esc_html__('Left', 'g5-element') => 'left',
			    esc_html__('Right', 'g5-element') => 'right',
		    ),
		    'dependency' => array(
			    'element' => 'icon_font',
			    'value_not_equal_to' => array(''),
		    ),
		    'std' => 'left',
	    ),
	    array(
		    'type' => 'g5element_switch',
		    'heading' => esc_html__('Button 3D?', 'g5-element'),
		    'param_name' => 'is_button_3d',
		    'std' => '',
		    'dependency'       => array('element' => 'style', 'value' => 'classic'),
	    ),
	    array(
		    'type' => 'g5element_switch',
		    'heading' => esc_html__('Set full width button?', 'g5-element'),
		    'param_name' => 'is_button_full_width',
		    'std' => '',
	    ),
        array(
            'type' => 'g5element_switch',
            'heading' => esc_html__('Advanced on click action', 'g5-element'),
            'param_name' => 'custom_onclick',
            'std' => '',
            'description' => esc_html__('Insert inline onclick javascript action.', 'g5-element'),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('On click code', 'g5-element'),
            'param_name' => 'custom_onclick_code',
            'description' => esc_html__('Enter onclick action code.', 'g5-element'),
            'dependency' => array(
                'element' => 'custom_onclick',
                'value' => 'on',
            ),
        ),

	    array(
		    'type'       => 'g5element_typography',
		    'heading'    => esc_html__('Typography', 'g5-element'),
		    'param_name' => 'button_typography',
		    'std'        => G5ELEMENT()->vc_params()->get_typography_default(),
		    'selector'   => '',
		    'group'      => esc_html__('Customize', 'g5-element'),
	    ),

	    array(
		    'type' => 'g5element_number',
		    'heading' => esc_html__('Padding Top - Bottom (px)', 'g5-element'),
		    'param_name' => 'padding_top_bottom',
		    'std' => '',
		    'group'      => esc_html__('Customize', 'g5-element'),
		    'edit_field_class' => 'vc_col-sm-6 vc_column',
	    ),
	    array(
		    'type' => 'g5element_number',
		    'heading' => esc_html__('Padding Left - Right (px)', 'g5-element'),
		    'param_name' => 'padding_left_right',
		    'std' => '',
		    'group'      => esc_html__('Customize', 'g5-element'),
		    'edit_field_class' => 'vc_col-sm-6 vc_column',
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