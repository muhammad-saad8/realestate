<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}
return array(
    'base'        => 'g5element_agent_singular',
    'name'        => esc_html__( 'Agent Singular', 'g5-ere' ),
    'category'    => G5ERE()->shortcodes()->get_category_name(),
    'icon'        => 'g5element-vc-icon-agent-singular',
    'description' => esc_html__( 'Display agent info', 'g5-ere' ),
    'params'      => array_merge(
        array(
	        array(
		        'param_name' => 'layout',
		        'heading' => esc_html__('Layout', 'g5-ere'),
		        'description' => esc_html__('Specify your agent singular layout', 'g5-ere'),
		        'type' => 'dropdown',
		        'value' => array_flip(G5ERE()->settings()->get_agent_singular_layout()) ,
		        'std' => 'layout-01',
		        'admin_label' => true
	        ),
            array(
                'type'        => 'autocomplete',
                'heading'     => esc_html__( 'Narrow Agent', 'g5-ere' ),
                'param_name'  => 'id',
                'settings'    => array(
                    'multiple' => false,
                    'sortable' => true,
                    'unique_values' => true,
                ),
                'save_always' => true,
                'description' => esc_html__( 'Enter the agent you want to display', 'g5-ere' ),
            ),

            g5element_vc_map_add_element_id(),
            g5element_vc_map_add_extra_class(),
        ),
        array(
            array(
                'param_name'  => 'post_image_size',
                'heading'     => esc_html__( 'Image size', 'g5-ere' ),
                'description' => esc_html__( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'g5-ere' ),
                'type'        => 'textfield',
                'std'         => 'full',
                'group'       => esc_html__( 'Image Size', 'g5-ere' ),
            ),
            array(
                'param_name'       => 'post_image_ratio_width',
                'heading'          => esc_html__( 'Image ratio width', 'g5-ere' ),
                'description'      => esc_html__( 'Enter width for image ratio', 'g5-ere' ),
                'type'             => 'g5element_number',
                'std'              => '',
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'dependency'       => array( 'element' => 'post_image_size', 'value' => 'full' ),
                'group'            => esc_html__( 'Image Size', 'g5-ere' ),
            ),
            array(
                'param_name'       => 'post_image_ratio_height',
                'heading'          => esc_html__( 'Image ratio height', 'g5-ere' ),
                'description'      => esc_html__( 'Enter height for image ratio', 'g5-ere' ),
                'type'             => 'g5element_number',
                'std'              => '',
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'dependency'       => array( 'element' => 'post_image_size', 'value' => 'full' ),
                'group'            => esc_html__( 'Image Size', 'g5-ere' ),
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