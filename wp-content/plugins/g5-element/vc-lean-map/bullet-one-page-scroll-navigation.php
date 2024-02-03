<?php
/**
 * VC Lean map config
 *
 * @package g5element
 * @subpackage image_marker
 * @since 1.0
 */
return array(
	'base'        => 'g5element_bullet_one_page_scroll_navigation',
	'name'        => esc_html__( 'Bullet One Page Scroll Navigation', 'g5-element' ),
	'category'    => G5ELEMENT()->shortcode()->get_category_name(),
	'description' => esc_html__( 'Scrollspy of section base on Bootstrap', 'g5-element' ),
	'icon'        => 'g5element-vc-icon-bullet-one-page-scroll-navigation',
	'params'      => array(
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Dots Position', 'g5-element' ),
			'param_name' => 'dots_position',
			'std'        => 'right',
			'value'      => array(
				esc_html__( 'Left', 'g5-element' )  => 'left',
				esc_html__( 'Right', 'g5-element' ) => 'right',
			),
		),
		array(
			'type'       => 'param_group',
			'heading'    => esc_html__( 'Section id', 'g5-element' ),
			'param_name' => 'values',
			'params'     => array(
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Section id', 'g5-element' ),
					'param_name'  => 'section_id',
					'value'       => '',
					'std'         => '',
					'description' => esc_html__( 'Enter id of section', 'g5-element' )
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Section Title', 'g5-element' ),
					'param_name'  => 'section_title',
					'value'       => '',
					'std'         => '',
					'description' => esc_html__( 'Enter Title of section', 'g5-element' )
				),
				array(
					'type'       => 'g5element_button_set',
					'heading'    => esc_html__( 'Skin of Dots', 'g5-element' ),
					'param_name' => 'skin',
					'value'      => array(
						esc_html__( 'Light', 'g5-element' ) => 'light',
						esc_html__( 'Dark', 'g5-element' )  => 'dark',
					),
					'std'        => 'dark',
				),
			),
		),

	),
);