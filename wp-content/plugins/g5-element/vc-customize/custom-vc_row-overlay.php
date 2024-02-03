<?php
add_action( 'vc_after_init', 'g5element_vc_row_overlay_param' );
function g5element_vc_row_overlay_param() {
	$params = array(
		array(
			'type'        => 'g5element_button_set',
			'heading'     => esc_html__( 'Background Overlay', 'g5-element' ),
			'param_name'  => 'bg_overlay_mode',
			'description' => esc_html__( 'Specify overlay mode for the background.', 'g5-element' ),
			'value'       => array(
				esc_html__( 'Hide', 'g5-element' )           => '',
				esc_html__( 'Color', 'g5-element' )          => 'color',
				esc_html__( 'Gradient Color', 'g5-element' ) => 'gradient',
				esc_html__( 'Image', 'g5-element' )          => 'image',
			),
			'std'         => '',
			'group'       => esc_html__( 'Overlay', 'g5-element' )
		),
		array(
			'type'             => 'colorpicker',
			'heading'          => esc_html__( 'From Color', 'g5-element' ),
			'param_name'       => 'gradient_from_color',
			'description'      => esc_html__( 'Specify an from color for the gradient.', 'g5-element' ),
			'dependency'       => array( 'element' => 'bg_overlay_mode', 'value' => 'gradient' ),
			'group'            => esc_html__( 'Overlay', 'g5-element' ),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
		),
		array(
			'type'             => 'colorpicker',
			'heading'          => esc_html__( 'To Color', 'g5-element' ),
			'param_name'       => 'gradient_to_color',
			'description'      => esc_html__( 'Specify an to color for the gradient.', 'g5-element' ),
			'dependency'       => array( 'element' => 'bg_overlay_mode', 'value' => 'gradient' ),
			'group'            => esc_html__( 'Overlay', 'g5-element' ),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
		),
		array(
			'type'        => 'colorpicker',
			'heading'     => esc_html__( 'Background Color', 'g5-element' ),
			'param_name'  => 'bg_overlay_color',
			'description' => esc_html__( 'Specify an overlay color for the background.', 'g5-element' ),
			'dependency'  => array( 'element' => 'bg_overlay_mode', 'value' => 'color' ),
			'group'       => esc_html__( 'Overlay', 'g5-element' )
		),
		array(
			'type'        => 'attach_image',
			'heading'     => esc_html__( 'Overlay Image', 'g5-element' ),
			'param_name'  => 'bg_overlay_image',
			'description' => esc_html__( 'Specify an overlay image for the background.', 'g5-element' ),
			'dependency'  => array( 'element' => 'bg_overlay_mode', 'value' => 'image' ),
			'group'       => esc_html__( 'Overlay', 'g5-element' )
		),
		array(
			'type'        => 'g5element_slider',
			'heading'     => esc_html__( 'Overlay Opacity', 'g5-element' ),
			'param_name'  => 'bg_overlay_opacity',
			'std'         => '50',
			'js_options'  => array(
				'step' => 1,
				'min'  => 0,
				'max'  => 100
			),
			'description' => esc_html__( 'Specify overlay opacity for the overlay background.', 'g5-element' ),
			'dependency'  => array( 'element' => 'bg_overlay_mode', 'not_empty' => true ),
			'group'       => esc_html__( 'Overlay', 'g5-element' )
		),
	);

	vc_add_params( 'vc_row', $params );
}

add_filter( 'g5element_vc_row_before', 'g5element_vc_row_overlay_output', 20, 2 );
function g5element_vc_row_overlay_output( $output, $atts ) {
	$bg_overlay_mode = $bg_overlay_color = $gradient_from_color = $gradient_to_color = $bg_overlay_image = $bg_overlay_opacity = '';
	extract( $atts );

	$image_lazy_load_enable = G5CORE()->options()->get_option( 'image_lazy_load_enable' );
	$bg_overlay_attributes = array();
	$bg_overlay_style = array();
	switch ($bg_overlay_mode) {
		case 'color':
			$bg_overlay_style[] = "background-color: {$bg_overlay_color}";
			break;
		case 'gradient':
			$bg_overlay_style[] = "background: -webkit-linear-gradient(to right, {$gradient_from_color}, {$gradient_to_color})";
			$bg_overlay_style[] = "background: linear-gradient(to right, {$gradient_from_color}, {$gradient_to_color})";
			break;
		case 'image':
			$bg_overlay_image_src = wp_get_attachment_image_src( $bg_overlay_image, 'full' );
			if (!empty($bg_overlay_image_src)) {
				$bg_overlay_image = esc_url($bg_overlay_image_src[0]);
				if ($image_lazy_load_enable === 'on') {
					$bg_overlay_attributes[] = sprintf('data-bg="%s"',$bg_overlay_image);
				} else {
					$bg_overlay_style[] = "background-image: url({$bg_overlay_image})";
				}
			}
			break;

	}

	$bg_overlay_html = '';
	if (!empty($bg_overlay_style) || !empty($bg_overlay_attributes)) {
		$bg_overlay_opacity = intval($bg_overlay_opacity)/100;
		$bg_overlay_style[] = "opacity: {$bg_overlay_opacity}";
		$bg_overlay_classes = apply_filters('g5element_vc_row_overlay_classes', array(
			'g5element-bg-overlay',
			'g5element-bg-full'
		));

		if ($image_lazy_load_enable === 'on') {
			$bg_overlay_classes[] = 'g5core__ll-background';
		}


		$bg_overlay_attributes[] = sprintf('class="%s"',join(' ', $bg_overlay_classes));
		$bg_overlay_attributes[] = sprintf('style="%s"',join(';', $bg_overlay_style));

		$bg_overlay_html = '<div '. join(' ', $bg_overlay_attributes) .'></div>';
	}

	$output .= $bg_overlay_html;

	return $output;
}

add_filter( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'g5element_vc_row_overlay_class', 10, 3);
function g5element_vc_row_overlay_class($css_class, $base, $atts) {
	if ($base === 'vc_row') {
		if (isset($atts['bg_overlay_mode']) && (!empty($atts['bg_overlay_mode']))) {
			if (strpos($css_class, 'position-relative') === false) {
				$css_class .= ' position-relative';
			}
		}
	}
	return $css_class;
}