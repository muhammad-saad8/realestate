<?php
/**
 * VC Lean map config
 *
 * @package g5element
 * @subpackage icon_box
 * @since 1.0
 */
return array(
    'base' => 'g5element_icon_box',
    'name' => esc_html__('Icon Box', 'g5-element'),
    'category' => G5ELEMENT()->shortcode()->get_category_name(),
    'description' => esc_html__('Display info box with font icon', 'g5-element'),
    'icon' => 'g5element-vc-icon-icon-box',
    'params' => array_merge(
        array(
            array(
                'type' => 'g5element_image_set',
                'heading' => esc_html__('Layout style', 'g5-element'),
                'param_name' => 'layout_style',
                'value' => apply_filters('g5element_settings_icon_box_layout',array(
	                'style-01' => array(
		                'label' => esc_html__('Style 01', 'g5-element'),
		                'img' => G5ELEMENT()->plugin_url('assets/images/icon-box-style-01.jpg'),
	                ),
	                'style-02' => array(
		                'label' => esc_html__('Style 02', 'g5-element'),
		                'img' => G5ELEMENT()->plugin_url('assets/images/icon-box-style-02.jpg'),
	                ),
	                'style-03' => array(
		                'label' => esc_html__('Style 03', 'g5-element'),
		                'img' => G5ELEMENT()->plugin_url('assets/images/icon-box-style-03.jpg'),
	                ),
	                'style-04' => array(
		                'label' => esc_html__('Style 04', 'g5-element'),
		                'img' => G5ELEMENT()->plugin_url('assets/images/icon-box-style-04.jpg'),
	                ),
	                'style-05' => array(
		                'label' => esc_html__('Style 05', 'g5-element'),
		                'img' => G5ELEMENT()->plugin_url('assets/images/icon-box-style-05.jpg'),
	                ),
	                'style-06' => array(
		                'label' => esc_html__('Style 06', 'g5-element'),
		                'img' => G5ELEMENT()->plugin_url('assets/images/icon-box-style-06.jpg'),
	                ),
	                'style-07' => array(
		                'label' => esc_html__('Style 07', 'g5-element'),
		                'img' => G5ELEMENT()->plugin_url('assets/images/icon-box-style-07.jpg'),
	                ),
                )),
                'std' => 'style-01',
            ),
	        array(
		        'type' => 'dropdown',
		        'heading' => esc_html__('Icon Type', 'g5-element'),
		        'param_name' => 'icon_type',
		        'value' => array(
			        esc_html__('Icon Library', 'g5-element') => 'icon-library',
			        esc_html__('Icon Svg', 'g5-element') => 'icon-svg',
		        ),
		        'std' => 'icon-library',
		        'edit_field_class' => 'vc_col-sm-6 vc_column',
		        'description' => esc_html__('Select icon type', 'g5-element'),
	        ),
	        g5element_vc_map_add_icon_font(
		        array(
			        'dependency' => array('element' => 'icon_type', 'value' => 'icon-library'),
		        )
	        ),
	        array(
		        'param_name'  => 'svg_icon',
		        'type'        => 'attach_image',
		        'heading'     => esc_html__('Upload SVG', 'g5-element'),
		        'value'       => '',
		        'description' => esc_html__('You can upload your SVG from this option', 'g5-element'),
		        'dependency'  => array(
			        'element' =>  'icon_type',
			        'value'   =>  'icon-svg',
		        ),
		        'dependency' => array('element' => 'icon_type', 'value' => 'icon-svg'),
	        ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Shape Background Icon', 'g5-element'),
                'param_name' => 'shape_bg_icon',
                'value' => array(
                    esc_html__('Default', 'g5-element') => 'shape-default',
                    esc_html__('Circle', 'g5-element') => 'shape-icon background-icon shape-circle',
                    esc_html__('Circle (Outline)', 'g5-element') => 'shape-icon shape-circle border-not-bg-icon',
                    esc_html__('Square', 'g5-element') => 'shape-icon background-icon shape-square',
                    esc_html__('Square  (Outline)', 'g5-element') => 'shape-icon shape-square border-not-bg-icon',
                ),
                'std' => 'shape-default',
                'description' => esc_html__('Select background icon', 'g5-element'),
                'edit_field_class' => 'vc_col-sm-12 vc_column',
                'group' => esc_html__('Icon Options', 'g5-element'),
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Icon Size', 'g5-element'),
                'param_name' => 'icon_size',
                'value' => array(
                    esc_html__('Small', 'g5-element') => 'gel-icon-box-size-sm',
                    esc_html__('Medium', 'g5-element') => 'gel-icon-box-size-md',
                    esc_html__('Large', 'g5-element') => 'gel-icon-box-size-lg',
                ),
                'std' => 'gel-icon-box-size-md',
                'edit_field_class' => 'vc_col-sm-12 vc_column',
                'description' => esc_html__('Select icon size', 'g5-element'),
                'group' => esc_html__('Icon Options', 'g5-element'),
            ),
            array(
                'type' => 'g5element_color',
                'heading' => esc_html__('Color Icon', 'g5-element'),
                'param_name' => 'color_icon',
                'description' => esc_html__('Select color for icon.', 'g5-element'),
                'std' => 'accent',
                'edit_field_class' => 'vc_col-sm-12 vc_column',
                'group' => esc_html__('Icon Options', 'g5-element'),
            ),
	        array(
		        'type' => 'g5element_color',
		        'heading' => esc_html__('Color Icon Hover', 'g5-element'),
		        'param_name' => 'color_icon_hover',
		        'description' => esc_html__('Select color hover for icon.', 'g5-element'),
		        'std' => '',
		        'edit_field_class' => 'vc_col-sm-12 vc_column',
		        'group' => esc_html__('Icon Options', 'g5-element'),
	        ),
	        array(
		        'type'             => 'g5element_button_set',
		        'heading'          => esc_html__('Show SVG Animate', 'g5-element'),
		        'param_name'       => 'icon_svg_animate',
		        'value'            => array(
			        esc_html__('Yes', 'g5-element')   => 'show',
			        esc_html__('No', 'g5-element') => '',
		        ),
		        'std'              => 'show',
		        'edit_field_class' => 'vc_col-sm-6 vc_column',
		        'group' => esc_html__('Icon Options', 'g5-element'),
		        'dependency' => array('element' => 'icon_type', 'value' => 'icon-svg'),
	        ),
	        array(
		        'type'             => 'g5element_button_set',
		        'heading'          => esc_html__('Play on hover', 'g5-element'),
		        'param_name'       => 'icon_svg_animate_play_on_hover',
		        'value'            => array(
			        esc_html__('Yes', 'g5-element')   => 'show',
			        esc_html__('No', 'g5-element') => '',
		        ),
		        'std'              => 'show',
		        'edit_field_class' => 'vc_col-sm-6 vc_column',
		        'group' => esc_html__('Icon Options', 'g5-element'),
		        'dependency' => array('element' => 'icon_svg_animate', 'value' => 'show'),
	        ),
	        array(
		        'type' => 'dropdown',
		        'heading' => esc_html__('Type', 'g5-element'),
		        'param_name' => 'icon_svg_animate_type',
		        'value' => array(
			        esc_html__('Delayed', 'g5-element') => 'delayed',
			        esc_html__('Sync', 'g5-element') => 'sync',
			        esc_html__('One By One', 'g5-element') => 'oneByOne',
		        ),
		        'std' => 'delayed',
		        'edit_field_class' => 'vc_col-sm-6 vc_column',
		        'group' => esc_html__('Icon Options', 'g5-element'),
		        'dependency' => array('element' => 'icon_svg_animate', 'value' => 'show'),
	        ),
	        array(
		        'type'             => 'g5element_number',
		        'heading'          => esc_html__('Transition Duration', 'g5-element'),
		        'param_name'       => 'icon_svg_animate_duration',
		        'std'              => '',
		        'edit_field_class' => 'vc_col-sm-6 vc_column',
		        'group' => esc_html__('Icon Options', 'g5-element'),
		        'dependency' => array('element' => 'icon_svg_animate', 'value' => 'show'),
	        ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Title', 'g5-element'),
                'param_name' => 'title',
                'value' => '',
                'admin_label' => true,
                'std' => esc_html__('Title on the Icon Box', 'g5-element'),
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
                'std' => esc_html__('Click', 'g5-element'),
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