<?php
/**
 * Customizer For Theme
 *
 * @since 1.0
 * @version 1.0
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function homeid_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'custom_logo' )->transport = 'refresh';

	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector'        => '.site-title a',
		'render_callback' => 'homeid_customize_partial_blogname',
	) );
	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector'        => '.site-description',
		'render_callback' => 'homeid_customize_partial_blogdescription',
	) );


	$wp_customize->add_section( 'homeid_footer_section', array(
		'title'    => esc_html__( 'Footer', 'homeid' ),
		'priority' => 120,
	) );
	$wp_customize->add_setting( 'footer_text', array(
		'default'   => esc_html__( 'Powered by G5Theme', 'homeid' ),
		'transport' => 'refresh',
		'sanitize_callback'  => 'wp_kses_post'
	) );
	$wp_customize->add_control( 'footer_text',
		array(
			'label'    => esc_html__( 'Footer Text', 'homeid' ),
			'type'     => 'textarea',
			'section'  => 'homeid_footer_section',
			'settings' => 'footer_text',
		) );
	$wp_customize->add_setting( 'enable_private_policy_link', array(
		'default'   => 'on',
		'transport' => 'refresh',
		'sanitize_callback' => 'esc_attr'
	) );
	$wp_customize->add_control( 'enable_private_policy_link',
		array(
			'label'    => esc_html__( 'Private Policy Link', 'homeid' ),
			'type'     => 'radio',
			'section'  => 'homeid_footer_section',
			'settings' => 'enable_private_policy_link',
			'choices'  => array(
				'on'   => esc_html__('Show private policy link','homeid'),
				'off'   => esc_html__('Hide private policy link','homeid'),
			)
		) );

}

add_action( 'customize_register', 'homeid_customize_register' );

function homeid_customize_partial_blogname() {
	bloginfo( 'name' );
}

function homeid_customize_partial_blogdescription() {
	bloginfo( 'description' );
}