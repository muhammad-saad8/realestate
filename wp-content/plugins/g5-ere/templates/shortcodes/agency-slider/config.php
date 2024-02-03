<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

return array(
	'base'        => 'g5element_agency_slider',
	'name'        => esc_html__( 'Agency Slider', 'g5-ere' ),
	'category'    => G5ERE()->shortcodes()->get_category_name(),
	'icon'        => 'g5element-vc-icon-agency-slider',
	'description' => esc_html__( 'Display list of agency slider', 'g5-ere' ),
	'params'      => array_merge(
		array(
			array(
				'param_name'  => 'item_skin',
				'heading'     => esc_html__( 'Item Skin', 'g5-ere' ),
				'description' => esc_html__( 'Specify your agency item skin', 'g5-ere' ),
				'type'        => 'g5element_image_set',
				'value'       => G5ERE()->settings()->get_agency_skins(),
				'std'         => 'skin-01',
				'admin_label' => true
			),


			array(
				'param_name'  => 'posts_per_page',
				'heading'     => esc_html__( 'Agency Per Page', 'g5-ere' ),
				'description' => esc_html__( 'Enter number of agency per page you want to display. Default 10', 'g5-ere' ),
				'type'        => 'g5element_number',
				'std'         => '',
			),

			array(
				'param_name'       => 'post_animation',
				'heading'          => esc_html__( 'Animation', 'g5-ere' ),
				'description'      => esc_html__( 'Specify your agency animation', 'g5-ere' ),
				'type'             => 'dropdown',
				'value'            => array_flip( G5CORE()->settings()->get_animation() ),
				'std'              => 'none',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),

			array(
				'param_name'       => 'columns_gutter',
				'heading'          => esc_html__( 'Columns Gutter', 'g5-ere' ),
				'description'      => esc_html__( 'Specify your horizontal space between items.', 'g5-ere' ),
				'type'             => 'dropdown',
				'value'            => array_flip( G5CORE()->settings()->get_post_columns_gutter() ),
				'std'              => '30',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),

			array(
				'param_name'  => 'item_custom_class',
				'heading'     => esc_html__( 'Item Css Classes', 'g5-ere' ),
				'description' => esc_html__( 'Add custom css classes to item', 'g5-ere' ),
				'type'        => 'textfield'
			),
			g5element_vc_map_add_element_id(),
			g5element_vc_map_add_extra_class(),
		),
		g5ere_vc_map_agency_add_filter(),
		array(
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Extra Large Devices', 'g5-ere' ),
				'description' => esc_html__( 'Width >= 1200px', 'g5-ere' ),
				'param_name'  => 'columns_xl',
				'value'       => G5CORE()->settings()->get_post_columns(),
				'std'         => '3',
				'group'       => esc_html__( 'Column', 'g5-ere' ),
			),
			array(
				'type'             => 'dropdown',
				'heading'          => esc_html__( 'Large Devices', 'g5-ere' ),
				'param_name'       => 'columns_lg',
				'description'      => esc_html__( 'Width < 1200px', 'g5-ere' ),
				'value'            => G5CORE()->settings()->get_post_columns(),
				'std'              => '3',
				'edit_field_class' => 'vc_col-sm-3 vc_column',
				'group'            => esc_html__( 'Column', 'g5-ere' ),
			),
			array(
				'type'             => 'dropdown',
				'heading'          => esc_html__( 'Medium Devices', 'g5-ere' ),
				'param_name'       => 'columns_md',
				'description'      => esc_html__( 'Width < 992px', 'g5-ere' ),
				'value'            => G5CORE()->settings()->get_post_columns(),
				'std'              => '2',
				'edit_field_class' => 'vc_col-sm-3 vc_column',
				'group'            => esc_html__( 'Column', 'g5-ere' ),
			),
			array(
				'type'             => 'dropdown',
				'heading'          => esc_html__( 'Small Devices', 'g5-ere' ),
				'param_name'       => 'columns_sm',
				'description'      => esc_html__( 'Width < 768px', 'g5-ere' ),
				'value'            => G5CORE()->settings()->get_post_columns(),
				'std'              => '1',
				'edit_field_class' => 'vc_col-sm-3 vc_column',
				'group'            => esc_html__( 'Column', 'g5-ere' ),
			),
			array(
				'type'             => 'dropdown',
				'heading'          => esc_html__( 'Extra Small Devices', 'g5-ere' ),
				'param_name'       => 'columns',
				'description'      => esc_html__( 'Width < 576px', 'g5-ere' ),
				'value'            => G5CORE()->settings()->get_post_columns(),
				'std'              => '1',
				'edit_field_class' => 'vc_col-sm-3 vc_column',
				'group'            => esc_html__( 'Column', 'g5-ere' ),
			)
		),
		g5element_vc_map_add_slider( array(), esc_html__( 'Slider Options', 'g5-ere' ) ),
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