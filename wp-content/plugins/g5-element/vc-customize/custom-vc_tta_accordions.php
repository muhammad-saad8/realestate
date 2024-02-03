<?php
add_action( 'vc_after_init', 'g5element_custom_vc_tta_accordions_add_param' );
function g5element_custom_vc_tta_accordions_add_param() {
	$styles               = array(
		esc_html__( 'Underline', 'g5-element' ) => 'underline'
	);
	$param_style          = WPBMap::getParam( 'vc_tta_accordion', 'style' );
	$param_style['value'] = array_merge( $param_style['value'], $styles );
	$param_style['std']   = 'classic';
	vc_update_shortcode_param( 'vc_tta_accordion', $param_style );

	$param_color               = WPBMap::getParam( 'vc_tta_accordion', 'color' );
	$param_color['value']      = array_merge( g5element_vc_sources_colors(), $param_color['value'] );
	$param_color['heading']    = esc_html__( 'Color', 'g5-element' );
	$param_color['std']        = 'accent';
	$param_color['dependency'] = array(
		'element' => 'style',
		'value'   => array( 'classic', 'modern', 'flat', 'outline')
	);
	vc_update_shortcode_param( 'vc_tta_accordion', $param_color );


	$shape               = WPBMap::getParam( 'vc_tta_accordion', 'shape' );
	$shape['dependency'] = array(
		'element' => 'style',
		'value'   => array( 'classic', 'modern', 'flat', 'outline')
	);
	vc_update_shortcode_param( 'vc_tta_accordion', $shape );

	$no_fill               = WPBMap::getParam( 'vc_tta_accordion', 'no_fill' );
	$no_fill['dependency'] = array(
		'element' => 'style',
		'value'   => array( 'classic', 'modern', 'flat', 'outline')
	);
	vc_update_shortcode_param( 'vc_tta_accordion', $no_fill );




}