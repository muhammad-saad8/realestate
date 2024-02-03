<?php
/**
 * Get all content block for field
 *
 * @param array $args
 *
 * @return array
 */
function g5core_config_content_block($args = array()) {
	$defaults = array(
		'title'       => esc_html__( 'Content Block', 'g5-core' ),
		'placeholder' => esc_html__( 'Select Content Block', 'g5-core' ),
		'type'        => 'selectize',
		'allow_clear' => true,
		'data'        => G5CORE()->cpt()->get_content_block_post_type(),
		'data_args'   => array(
			'numberposts' => - 1,
		)
	);

	$defaults = wp_parse_args( $args, $defaults );
	return $defaults;
}

/**
 * Get Site Layout
 *
 * @param array $args
 * @param bool $inherit
 *
 * @return array
 */
function g5core_config_site_layout( $args = array(), $inherit = false ) {
	$defaults = array(
		'title'   => esc_html__( 'Site Layout', 'g5-core' ),
		'type'    => 'image_set',
		'options' => G5CORE()->settings()->get_site_layout( $inherit ),
		'default' => $inherit ? '' : 'right'
	);

	$defaults = wp_parse_args( $args, $defaults );

	return $defaults;
}

/**
 * Get sidebar for field config
 *
 * @param array $args
 *
 * @return array
 */
function g5core_config_config_sidebar( $args = array() ) {
	$defaults = array(
		'title'       => esc_html__( 'Sidebar', 'g5-core' ),
		'type'        => 'selectize',
		'placeholder' => esc_html__( 'Select Sidebar', 'g5-core' ),
		'data'        => 'sidebar',
		'allow_clear' => true,
		'default'     => ''
	);

	$defaults = wp_parse_args( $args, $defaults );

	return $defaults;
}