<?php
function g5element_vc_map_add_extra_class() {
	return array(
		'type'        => 'textfield',
		'heading'     => __( 'Extra class name', 'g5-element' ),
		'param_name'  => 'el_class',
		'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'g5-element' ),
	);
}

function g5element_vc_map_add_element_id() {
	return array(
		'type'        => 'el_id',
		'heading'     => __( 'Element ID', 'g5-element' ),
		'param_name'  => 'el_id',
		'std'         => '',
		'description' => sprintf( __( 'Enter element ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">w3c specification</a>).', 'g5-element' ), 'http://www.w3schools.com/tags/att_global_id.asp' ),
	);
}
function g5element_vc_map_add_icon_image($args = array()){
    $default =  array(
        'type' => 'attach_image',
        'heading' => esc_html__('Upload Image Icon:', 'g5-element'),
        'param_name' => 'icon_image',
        'value' => '',
        'description' => esc_html__('Upload the custom image icon.', 'g5-element'),
	    'std' => '',
    );
    $default = array_merge( $default, $args );
    return $default;

}
function g5element_vc_map_add_icon_font( $args = array() ) {
	$default = array(
		'type'        => 'g5element_icon_picker',
		'heading'     => esc_html__( 'Icon', 'g5-element' ),
		'param_name'  => 'icon_font',
		'description' => esc_html__( 'Select icon from library.', 'g5-element' ),
		'std' => 'fab fa-pagelines'
	);

	$default = array_merge( $default, $args );

	return $default;
}

function g5element_vc_map_add_css_animation( $label = true ) {
	$data = array(
		'type'        => 'animation_style',
		'heading'     => esc_html__( 'CSS Animation', 'g5-element' ),
		'param_name'  => 'css_animation',
		'admin_label' => $label,
		'value'       => '',
		'settings'    => array(
			'type'   => 'in',
			'custom' => array(
				array(
					'label'  => esc_html__( 'Default', 'g5-element' ),
					'values' => array(
						esc_html__( 'Top to bottom', 'g5-element' )      => 'top-to-bottom',
						esc_html__( 'Bottom to top', 'g5-element' )      => 'bottom-to-top',
						esc_html__( 'Left to right', 'g5-element' )      => 'left-to-right',
						esc_html__( 'Right to left', 'g5-element' )      => 'right-to-left',
						esc_html__( 'Appear from center', 'g5-element' ) => 'appear',
					),
				),
			),
		),
		'description' => esc_html__( 'Select type of animation for element to be animated when it enters the browsers viewport (Note: works only in modern browsers).', 'g5-element' ),
		'group'       => esc_html__( 'Animation', 'g5-element' )
	);

	return apply_filters( 'vc_map_add_css_animation', $data, $label );
}

function g5element_vc_map_add_animation_duration() {
	return array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Animation Duration', 'g5-element' ),
		'param_name'  => 'animation_duration',
		'value'       => '',
		'description' => wp_kses_post( __( 'Duration in seconds. You can use decimal points in the value. Use this field to specify the amount of time the animation plays. <em>The default value depends on the animation, leave blank to use the default.</em>', 'g5-element' ) ),
		'group'       => esc_html__( 'Animation', 'g5-element' )
	);
}

function g5element_vc_map_add_animation_delay() {
	return array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Animation Delay', 'g5-element' ),
		'param_name'  => 'animation_delay',
		'value'       => '',
		'description' => esc_html__( 'Delay in seconds. You can use decimal points in the value. Use this field to delay the animation for a few seconds, this is helpful if you want to chain different effects one after another above the fold.', 'g5-element' ),
		'group'       => esc_html__( 'Animation', 'g5-element' )
	);
}

function g5element_vc_map_add_css_editor() {
	return array(
		'type'       => 'css_editor',
		'heading'    => esc_html__( 'CSS box', 'g5-element' ),
		'param_name' => 'css',
		'group'      => esc_html__( 'Design Options', 'g5-element' ),
	);
}

function g5element_vc_map_add_responsive() {
	return array(
		'type' => 'g5element_responsive',
		'heading' => esc_html__('Responsive', 'g5-element'),
		'param_name' => 'responsive',
		'group' => esc_html__('Responsive Options', 'g5-element'),
		'description' => esc_html__('Adjust column for different screen sizes. Control visibility settings.', 'g5-element'),
	);
}

function g5element_vc_map_add_columns($dependency = array(), $group_name = null) {
    $configs = array(
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Extra Large Devices', 'g5-element'),
            'description' => esc_html__('Width >= 1200px', 'g5-element'),
            'param_name' => 'columns_xl',
            'value' => G5CORE()->settings()->get_post_columns(),
            'std' => '4',
            'dependency' => $dependency
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Large Devices', 'g5-element'),
            'param_name' => 'columns_lg',
            'description' => esc_html__('Width < 1200px', 'g5-element'),
            'value' => G5CORE()->settings()->get_post_columns(),
            'std' => '4',
            'dependency' => $dependency,
            'edit_field_class' => 'vc_col-sm-3 vc_column',
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Medium Devices', 'g5-element'),
            'param_name' => 'columns_md',
            'description' => esc_html__('Width < 992px', 'g5-element'),
            'value' => G5CORE()->settings()->get_post_columns(),
            'std' => '3',
            'dependency' => $dependency,
            'edit_field_class' => 'vc_col-sm-3 vc_column',
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Small Devices', 'g5-element'),
            'param_name' => 'columns_sm',
            'description' => esc_html__('Width < 768px', 'g5-element'),
            'value' => G5CORE()->settings()->get_post_columns(),
            'std' => '3',
            'dependency' => $dependency,
            'edit_field_class' => 'vc_col-sm-3 vc_column',
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Extra Small Devices', 'g5-element'),
            'param_name' => 'columns',
            'description' => esc_html__('Width < 576px', 'g5-element'),
            'value' => G5CORE()->settings()->get_post_columns(),
            'std' => '2',
            'dependency' => $dependency,
            'edit_field_class' => 'vc_col-sm-3 vc_column',
        )
    );
	if ($group_name !== null) {
		foreach ($configs as $key => $value) {
			$configs[$key]['group'] = $group_name;
		}
	}
    return $configs;
}

function g5element_vc_map_add_slider($dependency = array(), $group_name = null) {
    $configs = array(
        array(
            'param_name'       => 'slider_rows',
            'heading'          => esc_html__( 'Slide Rows', 'g5-element' ),
            'type'             => 'g5element_number',
            'std'              => '1',
            'dependency' => $dependency,
            'group' => $group_name,
        ),
        array(
            'param_name' => 'slider_pagination_enable',
            'heading' => esc_html__('Show Pagination', 'g5-element'),
            'type' => 'g5element_switch',
            'std' => 'on',
            'dependency' => $dependency,
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'group' => $group_name
        ),
        array(
            'param_name' => 'slider_navigation_enable',
            'heading' => esc_html__('Show Navigation', 'g5-element'),
            'type' => 'g5element_switch',
            'std' => '',
            'dependency' => $dependency,
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'group' => $group_name
        ),
        array(
            'param_name' => 'slider_center_enable',
            'heading' => esc_html__('Center Mode', 'g5-element'),
            'type' => 'g5element_switch',
            'std' => '',
            'dependency' => $dependency,
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'group' => $group_name
        ),
        array(
            'param_name'       => 'slider_center_padding',
            'heading'          => esc_html__( 'Side padding when in center mode (px/%)', 'g5-element' ),
            'type'             => 'textfield',
            'std'              => '',
            'dependency'       => array( 'element' => 'slider_center_enable', 'value' => 'on' ),
            'group' => $group_name,
            'edit_field_class' => 'vc_col-sm-6 vc_column',
        ),
        array(
            'param_name' => 'slider_auto_height_enable',
            'heading' => esc_html__('Auto Height Enable', 'g5-element'),
            'type' => 'g5element_switch',
            'std' => 'on',
            'dependency' => $dependency,
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'group' => $group_name
        ),
        array(
            'param_name' => 'slider_loop_enable',
            'heading' => esc_html__('Loop Mode', 'g5-element'),
            'type' => 'g5element_switch',
            'std' => '',
            'dependency' => $dependency,
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'group' => $group_name
        ),
        array(
            'param_name' => 'slider_autoplay_enable',
            'heading' => esc_html__('Autoplay Enable', 'g5-element'),
            'type' => 'g5element_switch',
            'std' => '',
            'dependency' => $dependency,
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'group' => $group_name
        ),
        array(
            'param_name' => 'slider_autoplay_timeout',
            'heading' => esc_html__('Autoplay Timeout', 'g5-element'),
            'type' => 'g5element_number',
            'std' => '5000',
            'dependency' =>  array('element' => 'slider_autoplay_enable','value' => 'on'),
            'group' => $group_name
        ),
    );
	if ($group_name !== null) {
		foreach ($configs as $key => $value) {
			$configs[$key]['group'] = $group_name;
		}
	}

    return $configs;
}



