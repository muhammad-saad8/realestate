<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
return array(
    'base'        => 'g5element_gallery_slider',
    'name'        => esc_html__('Image Slider', 'g5-element'),
    'category'    => G5ELEMENT()->shortcode()->get_category_name(),
    'description' => esc_html__( 'Display slider with images', 'g5-element' ),
    'icon'        => 'g5element-vc-icon-gallery-slider',
    'params'      => array_merge(
        array(
            array(
                'type' => 'attach_images',
                'heading' => esc_html__('Images', 'g5-element'),
                'param_name' => 'images'
            ),
            array(
                'param_name' => 'columns_gutter',
                'heading' => esc_html__('Columns Gutter', 'g5-element'),
                'description' => esc_html__('Specify your horizontal space between image.', 'g5-element'),
                'type' => 'dropdown',
                'value' => array_flip(G5CORE()->settings()->get_post_columns_gutter()),
                'std' => '30',
            ),
            array(
                'param_name' => 'post_animation',
                'heading' => esc_html__('Animation', 'g5-element'),
                'description' => esc_html__('Specify your image animation', 'g5-element'),
                'type' => 'dropdown',
                'value' => array_flip(G5CORE()->settings()->get_animation()),
                'std' => 'none'
            ),
            array(
                'type'       => 'dropdown',
                'heading'    => esc_html__('Hover effect', 'g5-element'),
                'param_name' => 'hover_effect',
                'std' => '',
                'value'      => array_flip(G5ELEMENT()->settings()->get_hover_effect()),
                'edit_field_class' => 'vc_col-sm-6 vc_column',
            ),
	        array(
		        'type'       => 'dropdown',
		        'heading'    => esc_html__('Hover Image effect', 'g5-element'),
		        'param_name' => 'hover_image_effect',
		        'std' => '',
		        'value'      => array_flip(G5ELEMENT()->settings()->get_hover_effect_image()),
		        'edit_field_class' => 'vc_col-sm-6 vc_column',
	        ),
            g5element_vc_map_add_element_id(),
            g5element_vc_map_add_extra_class(),
        ),
        g5element_vc_map_add_columns(array(), esc_html__('Columns', 'g5-element')),
        g5element_vc_map_add_slider(array(), esc_html__('Slider Options', 'g5-element')),
        array(
            array(
                'param_name' => 'image_size',
                'heading' => esc_html__('Image size', 'g5-element'),
                'description' => esc_html__('Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 300x400).', 'g5-element'),
                'type' => 'textfield',
                'std' => 'medium',
                'dependency' => array('element' => 'layout', 'value_not_equal_to' => array('masonry','justified')),
                'group' => esc_html__('Image Size', 'g5-element'),
            ),
            array(
                'param_name' => 'image_ratio_width',
                'heading' => esc_html__('Image ratio width', 'g5-element'),
                'description' => esc_html__('Enter width for image ratio', 'g5-element'),
                'type' => 'g5element_number',
                'std' => '',
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'dependency' => array('element' => 'image_size', 'value' => 'full'),
                'group' => esc_html__('Image Size', 'g5-element'),
            ),
            array(
                'param_name' => 'image_ratio_height',
                'heading' => esc_html__('Image ratio height', 'g5-element'),
                'description' => esc_html__('Enter height for image ratio', 'g5-element'),
                'type' => 'g5element_number',
                'std' => '',
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'dependency' => array('element' => 'image_size', 'value' => 'full'),
                'group' => esc_html__('Image Size', 'g5-element'),
            ),
        ),
        array(
            g5element_vc_map_add_css_animation(),
            g5element_vc_map_add_animation_duration(),
            g5element_vc_map_add_animation_delay(),
            g5element_vc_map_add_css_editor(),
            g5element_vc_map_add_responsive(),
        )


    )
);