<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * @see g5ere_template_loop_agency_title
 * @see g5ere_template_loop_agency_address
 * @see g5ere_template_loop_agency_meta
 */
add_action( 'g5ere_loop_agency_content_skin_01', 'g5ere_template_loop_agency_title', 15 );
add_action( 'g5ere_loop_agency_content_skin_01', 'g5ere_template_loop_agency_address', 20 );
add_action('g5ere_loop_agency_content_skin_01','g5ere_template_loop_agency_meta',25);


/**
 * @see g5ere_template_loop_agency_title
 * @see g5ere_template_loop_agency_address
 * @see g5ere_template_loop_agency_meta
 */
add_action( 'g5ere_loop_agency_content_skin_list_01', 'g5ere_template_loop_agency_title', 15 );
add_action( 'g5ere_loop_agency_content_skin_list_01', 'g5ere_template_loop_agency_address', 20 );
add_action( 'g5ere_loop_agency_content_skin_list_01', 'g5ere_template_loop_agency_meta', 25 );

/**
 * @see g5ere_template_single_agency_content_block
 */
add_action( 'g5ere_single_agency_summary', 'g5ere_template_single_agency_head_layout_02', 5 );
add_action( 'g5ere_single_agency_summary', 'g5ere_template_single_agency_content_block', 10 );


/**
 * @see g5ere_template_single_agency_head
 */
add_action( G5CORE_CURRENT_THEME . '_before_main_content', 'g5ere_template_single_agency_head', 12 );

/**
 * @see g5ere_template_breadcrumbs_single_agency
 */
add_action( G5CORE_CURRENT_THEME . '_before_main_content', 'g5ere_template_breadcrumbs_single_agency', 11 );


/**
 * @see g5ere_template_agency_title
 * @see g5ere_template_loop_agency_address
 * @see g5ere_template_loop_agency_description
 * @see g5ere_template_agency_meta
 * @see g5ere_template_loop_agency_social
 */
add_action('g5ere_single_agency_head_layout_1','g5ere_template_agency_title',5);
add_action('g5ere_single_agency_head_layout_1','g5ere_template_loop_agency_address',10);
add_action( 'g5ere_single_agency_head_layout_1', 'g5ere_template_loop_agency_description', 15 );
add_action('g5ere_single_agency_head_layout_1','g5ere_template_agency_meta',20);
add_action('g5ere_single_agency_head_layout_1','g5ere_template_loop_agency_social',25);


/**
 * @see g5ere_template_agency_title
 * @see g5ere_template_loop_agency_address
 * @see g5ere_template_agency_meta
 * @see g5ere_template_loop_agency_social_has_title
 */
add_action('g5ere_single_agency_head_layout_2','g5ere_template_agency_title',5);
add_action('g5ere_single_agency_head_layout_2','g5ere_template_loop_agency_address',10);
add_action('g5ere_single_agency_head_layout_2','g5ere_template_agency_meta',20);
add_action('g5ere_single_agency_head_layout_2','g5ere_template_loop_agency_social_has_title',25);



/**
 * @see g5ere_template_loop_agency_title
 * @see g5ere_template_loop_agency_email
 * @see g5ere_template_loop_agency_phone_has_icon
 */
add_action( 'g5ere_widget_contact_agency_info_layout_01', 'g5ere_template_loop_agency_title', 5 );
add_action( 'g5ere_widget_contact_agency_info_layout_01', 'g5ere_template_loop_agency_email', 10 );
add_action( 'g5ere_widget_contact_agency_info_layout_01', 'g5ere_template_loop_agency_phone_has_icon', 15 );


/**
 * @see g5ere_template_single_agency_bottom_bar
 */
add_action( 'wp_footer', 'g5ere_template_single_agency_bottom_bar' );
