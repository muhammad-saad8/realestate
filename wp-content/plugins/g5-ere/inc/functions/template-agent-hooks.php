<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * @see g5ere_template_loop_agent_phone_has_icon
 * @see g5ere_template_loop_agent_email_has_icon
 */
add_action( 'g5ere_after_loop_agent_thumbnail_skin_01', 'g5ere_template_loop_agent_phone_has_icon', 5 );
add_action( 'g5ere_after_loop_agent_thumbnail_skin_01', 'g5ere_template_loop_agent_email_has_icon', 10 );


/**
 * @see g5ere_template_loop_agent_title
 * @see g5ere_template_loop_agent_agency_has_title
 * @see g5ere_template_loop_agent_social
 */
add_action( 'g5ere_loop_agent_content_skin_01', 'g5ere_template_loop_agent_title', 5 );
add_action( 'g5ere_loop_agent_content_skin_01', 'g5ere_template_loop_agent_agency_has_title', 10 );
add_action( 'g5ere_loop_agent_content_skin_01', 'g5ere_template_loop_agent_social', 15 );

/**
 * @see g5ere_template_loop_agent_title
 * @see g5ere_template_loop_agent_agency_has_title
 * @see g5ere_template_loop_agent_phone_has_icon
 * @see g5ere_template_loop_agent_email_has_icon
 * @see g5ere_template_loop_agent_address_has_icon
 * @see g5ere_template_loop_agent_social
 */
add_action( 'g5ere_loop_agent_list_content_skin_list_01', 'g5ere_template_loop_agent_title', 5 );
add_action( 'g5ere_loop_agent_list_content_skin_list_01', 'g5ere_template_loop_agent_agency_has_title', 10 );
add_action( 'g5ere_loop_agent_list_content_skin_list_01', 'g5ere_template_loop_agent_phone_has_icon', 15 );
add_action( 'g5ere_loop_agent_list_content_skin_list_01', 'g5ere_template_loop_agent_email_has_icon', 20 );
add_action( 'g5ere_loop_agent_list_content_skin_list_01', 'g5ere_template_loop_agent_address_has_icon', 25 );
add_action( 'g5ere_loop_agent_list_content_skin_list_01', 'g5ere_template_loop_agent_social', 30 );


/**
 * @see g5ere_template_agent_title
 * @see g5ere_template_loop_agent_position
 * @see g5ere_template_agent_rating
 *
 */
add_action( 'g5ere_widget_agent_info_content_top_layout_01', 'g5ere_template_agent_title', 5 );
add_action( 'g5ere_widget_agent_info_content_top_layout_01', 'g5ere_template_loop_agent_position', 10 );
add_action( 'g5ere_widget_agent_info_content_top_layout_01', 'g5ere_template_agent_rating', 15 );


/**
 * @see g5ere_template_agent_meta
 * @see g5ere_template_loop_agent_social_has_title
 * @see g5ere_template_contact_agent_button
 */
add_action( 'g5ere_widget_agent_info_content_layout_01', 'g5ere_template_agent_meta', 5 );
add_action( 'g5ere_widget_agent_info_content_layout_01', 'g5ere_template_loop_agent_social_has_title', 10 );
add_action( 'g5ere_widget_agent_info_content_layout_01', 'g5ere_template_contact_agent_button', 15 );


/**
 * @see g5ere_template_loop_agent_title
 * @see g5ere_template_loop_agent_position
 * @see g5ere_template_loop_agent_agency_has_title
 * @see g5ere_template_loop_agent_description
 */
add_action( 'g5ere_agent_singular_summary_overview', 'g5ere_template_loop_agent_title', 5 );
add_action( 'g5ere_agent_singular_summary_overview', 'g5ere_template_loop_agent_position', 10 );
add_action( 'g5ere_agent_singular_summary_overview', 'g5ere_template_loop_agent_agency_has_title', 15 );
add_action( 'g5ere_agent_singular_summary_overview', 'g5ere_template_loop_agent_description', 20 );

/**
 * @see g5ere_template_loop_agent_phone_has_title
 * @see g5ere_template_loop_agent_office_number_has_title
 * @see g5ere_template_loop_agent_email_has_title
 * @see g5ere_template_loop_agent_website_has_title
 */
add_action( 'g5ere_agent_singular_summary_info', 'g5ere_template_loop_agent_phone_has_title', 5 );
add_action( 'g5ere_agent_singular_summary_info', 'g5ere_template_loop_agent_office_number_has_title', 10 );
add_action( 'g5ere_agent_singular_summary_info', 'g5ere_template_loop_agent_email_has_title', 15 );
add_action( 'g5ere_agent_singular_summary_info', 'g5ere_template_loop_agent_website_has_title', 20 );

/**
 * @see g5ere_template_agent_rating
 * @see g5ere_template_loop_agent_social
 */
add_action( 'g5ere_agent_singular_summary_bottom', 'g5ere_template_agent_rating', 5 );
add_action( 'g5ere_agent_singular_summary_bottom', 'g5ere_template_loop_agent_social', 10 );


/**
 * @see g5ere_template_single_agent_head
 */
add_action( G5CORE_CURRENT_THEME . '_before_main_content', 'g5ere_template_single_agent_head', 22 );

/**
 * @see g5ere_template_agent_breadcrumbs
 */
add_action( G5CORE_CURRENT_THEME . '_before_main_content', 'g5ere_template_agent_breadcrumbs', 11 );


/**
 * @see g5ere_template_single_agent_bottom_bar
 */
add_action( 'wp_footer', 'g5ere_template_single_agent_bottom_bar' );

/**
 * @see g5ere_template_single_agent_content_block
 */
add_action( 'g5ere_single_agent_summary', 'g5ere_template_single_agent_content_block', 5 );


/**
 * @see g5ere_template_loop_agent_title
 * @see g5ere_template_loop_agent_email
 * @see g5ere_template_loop_agent_phone_has_icon
 */

add_action( 'g5ere_widget_contact_agent_info_layout_01', 'g5ere_template_loop_agent_title', 5 );
add_action( 'g5ere_widget_contact_agent_info_layout_01', 'g5ere_template_loop_agent_email', 10 );
add_action( 'g5ere_widget_contact_agent_info_layout_01', 'g5ere_template_loop_agent_phone_has_icon', 15 );


/**
 * @see g5ere_template_agent_title
 * @see g5ere_template_loop_agent_position
 * @see g5ere_template_loop_agent_agency_has_title
 * @see g5ere_template_loop_agent_description
 * @see g5ere_template_agent_meta
 */
add_action( 'g5ere_single_agent_head_layout_01', 'g5ere_template_agent_title', 5 );
add_action( 'g5ere_single_agent_head_layout_01', 'g5ere_template_loop_agent_position', 10 );
add_action( 'g5ere_single_agent_head_layout_01', 'g5ere_template_loop_agent_agency_has_title', 15 );
add_action( 'g5ere_single_agent_head_layout_01', 'g5ere_template_loop_agent_description', 20 );
add_action( 'g5ere_single_agent_head_layout_01', 'g5ere_template_agent_meta', 25 );

/**
 * @see g5ere_template_agent_rating
 * @see g5ere_template_loop_agent_social
 */
add_action( 'g5ere_single_agent_head_bottom_layout_01', 'g5ere_template_agent_rating', 5 );
add_action( 'g5ere_single_agent_head_bottom_layout_01', 'g5ere_template_loop_agent_social', 10 );


