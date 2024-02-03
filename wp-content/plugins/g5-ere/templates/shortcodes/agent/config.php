<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
return array(
	'base'        => 'g5element_agent',
	'name'        => esc_html__( 'Agent', 'g5-ere' ),
	'category'    => G5ERE()->shortcodes()->get_category_name(),
	'icon'        => 'g5element-vc-icon-agent',
	'description' => esc_html__( 'Display list of agent', 'g5-ere' ),
	'params'      => array_merge(
		array(
			array(
				'param_name'  => 'post_layout',
				'heading'     => esc_html__( 'Agent Layout', 'g5-ere' ),
				'description' => esc_html__( 'Specify your agent layout', 'g5-ere' ),
				'type'        => 'g5element_image_set',
				'value'       => G5ERE()->settings()->get_shortcode_agent_layout(),
				'std'         => 'grid',
				'admin_label' => true
			),
			array(
				'param_name'  => 'item_skin',
				'heading'     => esc_html__( 'Item Skin', 'g5-ere' ),
				'description' => esc_html__( 'Specify your agent item skin', 'g5-ere' ),
				'type'        => 'g5element_image_set',
				'value'       => G5ERE()->settings()->get_agent_skins(),
				'std'         => 'skin-01',
				'admin_label' => true,
				'dependency'  => array( 'element' => 'post_layout', 'value' => 'grid' ),
			),
			array(
				'param_name'  => 'list_item_skin',
				'heading'     => esc_html__( 'Item Skin', 'g5-ere' ),
				'description' => esc_html__( 'Specify your agent item skin', 'g5-ere' ),
				'type'        => 'g5element_image_set',
				'value'       => G5ERE()->settings()->get_agent_list_skins(),
				'std'         => 'skin-list-01',
				'admin_label' => true,
				'dependency'  => array( 'element' => 'post_layout', 'value' => 'list' ),
			),
			array(
				'param_name'  => 'item_custom_class',
				'heading'     => esc_html__( 'Item Css Classes', 'g5-ere' ),
				'description' => esc_html__( 'Add custom css classes to item', 'g5-ere' ),
				'type'        => 'textfield'
			),

			array(
				'param_name'  => 'posts_per_page',
				'heading'     => esc_html__( 'Agent Per Page', 'g5-ere' ),
				'description' => esc_html__( 'Enter number of agent per page you want to display. Default 10', 'g5-ere' ),
				'type'        => 'g5element_number',
				'std'         => '',
			),

			array(
				'param_name' => 'offset',
				'heading' => esc_html__('Offset posts', 'g5-ere'),
				'description' => esc_html__('Start the count with an offset. If you have a block that shows 4 property before this one, you can make this one start from the 5\'th property (by using offset 4)', 'g5-ere'),
				'type' => 'g5element_number',
				'std' => '',
			),

			array(
				'param_name'       => 'columns_gutter',
				'heading'          => esc_html__( 'Agent Columns Gutter', 'g5-ere' ),
				'description'      => esc_html__( 'Specify your horizontal space between agent.', 'g5-ere' ),
				'type'             => 'dropdown',
				'value'            => array_flip( G5CORE()->settings()->get_post_columns_gutter() ),
				'std'              => '30',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'dependency'       => array( 'element' => 'post_layout', 'value' => 'grid' ),
			),

			array(
				'param_name'       => 'post_paging',
				'heading'          => esc_html__( 'Paging', 'g5-ere' ),
				'description'      => esc_html__( 'Specify your agent paging mode', 'g5-ere' ),
				'type'             => 'dropdown',
				'value'            => array_flip( G5CORE()->settings()->get_shortcode_post_paging() ),
				'std'              => 'none',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'param_name'       => 'post_animation',
				'heading'          => esc_html__( 'Animation', 'g5-ere' ),
				'description'      => esc_html__( 'Specify your agent animation', 'g5-ere' ),
				'type'             => 'dropdown',
				'value'            => array_flip( G5CORE()->settings()->get_animation() ),
				'std'              => 'none',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			g5element_vc_map_add_element_id(),
			g5element_vc_map_add_extra_class(),
		),
		g5ere_vc_map_agent_add_filter(),
		g5element_vc_map_add_columns( array(
			'element' => 'post_layout',
			'value'   => 'grid'
		), esc_html__( 'Columns', 'g5-ere' ) ),
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