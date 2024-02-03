<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
return array(
	'base' => 'g5element_properties_slider',
	'name' => esc_html__('Properties Slider', 'g5-ere'),
	'category' => G5ERE()->shortcodes()->get_category_name(),
	'icon'        => 'g5element-vc-icon-properties-slider',
	'description' => esc_html__( 'Display slider of properties', 'g5-ere' ),
	'params' => array_merge(
		array(
			array(
				'param_name' => 'layout',
				'heading' => esc_html__('Layout', 'g5-ere'),
				'description' => esc_html__('Specify your property slider layout', 'g5-ere'),
				'type' => 'dropdown',
				'value' => array_flip(G5ERE()->settings()->get_properties_slider_layout()) ,
				'std' => 'layout-01',
				'admin_label' => true
			),
			array(
				'param_name' => 'posts_per_page',
				'heading' => esc_html__('Property Per Page', 'g5-ere'),
				'description' => esc_html__('Enter number of property per page you want to display. Default 10', 'g5-ere'),
				'type' => 'g5element_number',
				'std' => '3',
			),
			array(
				'param_name' => 'offset',
				'heading' => esc_html__('Offset posts', 'g5-ere'),
				'description' => esc_html__('Start the count with an offset. If you have a block that shows 4 property before this one, you can make this one start from the 5\'th property (by using offset 4)', 'g5-ere'),
				'type' => 'g5element_number',
				'std' => '',
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Height Mode', 'g5-ere'),
				'description' => esc_html__('Specify your property slider height mode', 'g5-ere'),
				'param_name' => 'height_mode',
				'value' => array(
					esc_html__('Full Screen','g5-ere') => 'full-screen',
					esc_html__('Custom','g5-ere') => 'custom'
				),
				'std' => 'custom',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Height', 'g5-ere'),
				'param_name' => 'height',
				'value' => '',
				'dependency' => array('element' => 'height_mode', 'value' => 'custom'),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'description' => esc_html__('Enter custom height (include unit)', 'g5-ere'),
			),
			array(
				'type'             => 'dropdown',
				'heading'          => esc_html__( 'Height Large Devices', 'g5-ere' ),
				'param_name'       => 'height_mode_lg',
				'description'      => esc_html__( 'Width < 1200px', 'g5-ere' ),
				'value'            => array(
					esc_html__( 'Default', 'g5-ere' ) => '',
					esc_html__('Full Screen','g5-ere') => 'full-screen',
					esc_html__('Custom','g5-ere') => 'custom'
				),
				'std'              => '',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),

			array(
				'type' => 'textfield',
				'heading' => esc_html__('Height Large Devices', 'g5-ere'),
				'param_name' => 'height_lg',
				'value' => '',
				'dependency' => array('element' => 'height_mode_lg', 'value' => 'custom'),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'description' => esc_html__('Enter custom height (include unit)', 'g5-ere'),
			),
			array(
				'type'             => 'dropdown',
				'heading'          => esc_html__( 'Height Medium Devices', 'g5-ere' ),
				'param_name'       => 'height_mode_md',
				'description'      => esc_html__( 'Width < 992px', 'g5-ere' ),
				'value'            => array(
					esc_html__( 'Default', 'g5-ere' ) => '',
					esc_html__('Full Screen','g5-ere') => 'full-screen',
					esc_html__('Custom','g5-ere') => 'custom'
				),
				'std'              => '',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Height Medium Devices', 'g5-ere'),
				'param_name' => 'height_md',
				'value' => '',
				'dependency' => array('element' => 'height_mode_md', 'value' => 'custom'),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'description' => esc_html__('Enter custom height (include unit)', 'g5-ere'),
			),
			array(
				'type'             => 'dropdown',
				'heading'          => esc_html__( 'Height Small Devices', 'g5-ere' ),
				'param_name'       => 'height_mode_sm',
				'description'      => esc_html__( 'Width < 768px', 'g5-ere' ),
				'value'            => array(
					esc_html__( 'Default', 'g5-ere' ) => '',
					esc_html__('Full Screen','g5-ere') => 'full-screen',
					esc_html__('Custom','g5-ere') => 'custom'
				),
				'std'              => '',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Height Small Devices', 'g5-ere'),
				'param_name' => 'height_sm',
				'value' => '',
				'dependency' => array('element' => 'height_mode_sm', 'value' => 'custom'),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'description' => esc_html__('Enter custom height (include unit)', 'g5-ere'),
			),
			array(
				'type'             => 'dropdown',
				'heading'          => esc_html__( 'Height Extra Small Devices', 'g5-ere' ),
				'param_name'       => 'height_mode_xs',
				'description'      => esc_html__( 'Width < 576px', 'g5-ere' ),
				'value'            => array(
					esc_html__( 'Default', 'g5-ere' ) => '',
					esc_html__('Full Screen','g5-ere') => 'full-screen',
					esc_html__('Custom','g5-ere') => 'custom'
				),
				'std'              => '',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Height Extra Small Devices', 'g5-ere'),
				'param_name' => 'height_xs',
				'value' => '',
				'dependency' => array('element' => 'height_mode_xs', 'value' => 'custom'),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'description' => esc_html__('Enter custom height (include unit)', 'g5-ere'),
			),
			g5element_vc_map_add_element_id(),
			g5element_vc_map_add_extra_class(),
		),
		g5ere_vc_map_add_filter(),
		array(
			array(
				'param_name' => 'slider_pagination_enable',
				'heading' => esc_html__('Show Pagination', 'g5-ere'),
				'type' => 'g5element_switch',
				'std' => 'on',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'group' => esc_html__('Slider Options', 'g5-ere')
			),
			array(
				'param_name' => 'slider_navigation_enable',
				'heading' => esc_html__('Show Navigation', 'g5-ere'),
				'type' => 'g5element_switch',
				'std' => '',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'group' => esc_html__('Slider Options', 'g5-ere')
			),
			array(
				'param_name' => 'slider_auto_height_enable',
				'heading' => esc_html__('Auto Height Enable', 'g5-ere'),
				'type' => 'g5element_switch',
				'std' => 'on',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'group' => esc_html__('Slider Options', 'g5-ere')
			),
			array(
				'param_name' => 'slider_loop_enable',
				'heading' => esc_html__('Loop Mode', 'g5-ere'),
				'type' => 'g5element_switch',
				'std' => '',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'group' => esc_html__('Slider Options', 'g5-ere')
			),
			array(
				'param_name' => 'slider_fade_enable',
				'heading' => esc_html__('Fade Mode', 'g5-ere'),
				'type' => 'g5element_switch',
				'std' => '',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'group' => esc_html__('Slider Options', 'g5-ere')
			),
			array(
				'param_name' => 'slider_autoplay_enable',
				'heading' => esc_html__('Autoplay Enable', 'g5-ere'),
				'type' => 'g5element_switch',
				'std' => '',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'group' => esc_html__('Slider Options', 'g5-ere')
			),
			array(
				'param_name' => 'slider_autoplay_timeout',
				'heading' => esc_html__('Autoplay Timeout', 'g5-ere'),
				'type' => 'g5element_number',
				'std' => '5000',
				'dependency' =>  array('element' => 'slider_autoplay_enable','value' => 'on'),
				'group' => esc_html__('Slider Options', 'g5-ere')
			),

		),
		array(
			array(
				'param_name' => 'post_image_size',
				'heading' => esc_html__('Image size', 'g5-ere'),
				'description' => esc_html__( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'g5-ere' ),
				'type' => 'textfield',
				'std' => 'full',
				'group' => esc_html__('Image Size', 'g5-ere'),
			),
			array(
				'param_name' => 'post_image_ratio_width',
				'heading' => esc_html__('Image ratio width', 'g5-ere'),
				'description' => esc_html__('Enter width for image ratio', 'g5-ere'),
				'type' => 'g5element_number',
				'std' => '',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'dependency' => array('element' => 'post_image_size', 'value' => 'full'),
				'group' => esc_html__('Image Size', 'g5-ere'),
			),
			array(
				'param_name' => 'post_image_ratio_height',
				'heading' => esc_html__('Image ratio height', 'g5-ere'),
				'description' => esc_html__('Enter height for image ratio', 'g5-ere'),
				'type' => 'g5element_number',
				'std' => '',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'dependency' => array('element' => 'post_image_size', 'value' => 'full'),
				'group' => esc_html__('Image Size', 'g5-ere'),
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