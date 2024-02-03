<?php
add_action( 'vc_after_init', 'g5element_vc_row_parallax_param' );
function g5element_vc_row_parallax_param() {
	$params = array(
		array(
			'type'        => 'g5element_button_set',
			'heading'     => esc_html__( 'Parallax Type', 'g5-element' ),
			'param_name'  => 'custom_parallax_type',
			'description' => esc_html__( 'Specify overlay mode for the background.', 'g5-element' ),
			'value'       => array(
				esc_html__( 'None', 'g5-element' )              => '',
				esc_html__( 'Fixed', 'g5-element' )             => 'fixed',
				esc_html__( 'Vertical Parallax', 'g5-element' ) => 'vertical_parallax',
			),
			'std'         => '',
			'group'       => esc_html__( 'Parallax', 'g5-element' )
		),
		array(
			'type'        => 'attach_image',
			'heading'     => esc_html__( 'Parallax Image', 'g5-element' ),
			'param_name'  => 'custom_parallax_image',
			'description' => esc_html__( 'Specify an image for parallax.', 'g5-element' ),
			'dependency'  => array( 'element' => 'custom_parallax_type', 'not_empty' => true ),
			'group'       => esc_html__( 'Parallax', 'g5-element' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Background Size', 'g5-element' ),
			'param_name' => 'custom_parallax_bg_size',
			'value' => array(
				esc_html__( 'Cover', 'g5-element' ) => 'cover',
				esc_html__( 'Contain', 'g5-element' ) => 'contain',
				esc_html__( 'Initial', 'g5-element' ) => 'initial',
			),
			'std'         => 'cover',
			'description' => esc_html__( 'Set parallax background size.', 'g5-element' ),
			'dependency'  => array( 'element' => 'custom_parallax_type', 'not_empty' => true ),
			'group'       => esc_html__( 'Parallax', 'g5-element' ),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Background Repeat', 'g5-element' ),
			'param_name' => 'custom_parallax_bg_repeat',
			'value' => array(
				esc_html__( 'No Repeat', 'g5-element' ) => 'no-repeat',
				esc_html__( 'Repeat', 'g5-element' ) => 'repeat',
			),
			'std'         => 'cover',
			'description' => esc_html__( 'Set parallax background repeat.', 'g5-element' ),
			'dependency'  => array( 'element' => 'custom_parallax_type', 'not_empty' => true ),
			'group'       => esc_html__( 'Parallax', 'g5-element' ),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
		),
		array(
			'type'        => 'g5element_slider',
			'heading'     => esc_html__( 'Parallax Speed', 'g5-element' ),
			'param_name'  => 'custom_parallax_speed',
			'std'         => '50',
			'js_options'  => array(
				'step' => 1,
				'min'  => 0,
				'max'  => 100
			),
			'description' => esc_html__( 'Specify parallax speed', 'g5-element' ),
			'dependency'  => array( 'element' => 'custom_parallax_type', 'value' => 'vertical_parallax' ),
			'group'       => esc_html__( 'Parallax', 'g5-element' )
		),
	);

	vc_add_params( 'vc_row', $params );
	vc_remove_param( 'vc_row', 'parallax' );
	vc_remove_param( 'vc_row', 'parallax_image' );
	vc_remove_param( 'vc_row', 'parallax_speed_bg' );
}

add_filter( 'g5element_vc_row_before', 'g5element_vc_row_parallax_output', 10, 2 );
function g5element_vc_row_parallax_output( $output, $atts ) {
	$custom_parallax_type = $custom_parallax_image = $custom_parallax_speed  = $custom_parallax_bg_size = $custom_parallax_bg_repeat= '';
	extract( $atts );

	if (empty($custom_parallax_type)) {
		return $output;
	}


	$image_lazy_load_enable = G5CORE()->options()->get_option( 'image_lazy_load_enable' );
	$bg_parallax_attributes = array();
	$bg_parallax_style   = array();
	$bg_parallax_classes = array( 'g5element-bg-parallax', 'g5element-bg-full' );
	$bg_parallax_image_src = wp_get_attachment_image_src( $custom_parallax_image, 'full' );
	if ( ! empty( $bg_parallax_image_src ) ) {
		$bg_parallax_image   = esc_url( $bg_parallax_image_src[0] );
		if ($image_lazy_load_enable === 'on') {
			$bg_parallax_attributes[] = sprintf('data-bg="%s"',$bg_parallax_image);
			$bg_parallax_classes[] = 'g5core__ll-background';
		} else {
			$bg_parallax_style[] = "background-image: url({$bg_parallax_image})";
		}
	}
	$bg_parallax_style[] = "background-size: {$custom_parallax_bg_size}";
	$bg_parallax_style[] = "background-repeat: {$custom_parallax_bg_repeat}";
	switch ( $custom_parallax_type ) {
		case 'fixed':
			$bg_parallax_style[] = "background-attachment: fixed";
			break;
		case 'vertical_parallax':
			$bg_parallax_style[] = "background-attachment: scroll";
			$bg_parallax_classes[] = 'g5element-bg-vparallax';
			break;

	}

	$bg_parallax_attributes[] = sprintf('style="%s"',join( ';', $bg_parallax_style ) );
	$bg_parallax_attributes[] = sprintf('class="%s"',join( ' ', $bg_parallax_classes ));
	if ($custom_parallax_type !== 'fixed') {
		$bg_parallax_attributes[] = sprintf('data-g5element-parallax-speed="%s"',esc_attr( $custom_parallax_speed / 100 ));
	}
	$bg_parallax_html = '<div '. join( ' ', $bg_parallax_attributes ) .'></div>';
	$output .= $bg_parallax_html;
	return $output;
}

add_filter( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'g5element_vc_row_parallax_class', 10, 3);
function g5element_vc_row_parallax_class($css_class, $base, $atts) {
	if ($base === 'vc_row') {
		if (isset($atts['custom_parallax_type']) && (!empty($atts['custom_parallax_type']))) {
			if (strpos($css_class, 'position-relative') === false) {
				$css_class .= ' position-relative';
			}
		}
	}
	return $css_class;
}