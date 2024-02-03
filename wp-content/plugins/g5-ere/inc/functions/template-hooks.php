<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * @see g5ere_body_class
 */
add_filter( 'body_class', 'g5ere_body_class' );


/**
 * @see g5ere_template_agent_modal_messenger
 */
add_action( 'wp_footer', 'g5ere_template_modal_messenger' );
add_action( 'wp_footer', 'g5ere_template_modal_save_search' );
add_action( 'wp_footer', 'g5ere_template_message' );

/**
 * @see g5ere_template_single_property_bottom_bar
 */
add_action( 'wp_footer', 'g5ere_template_single_property_bottom_bar' );


/**
 * @see g5ere_template_loop_property_title
 * @see g5ere_template_loop_property_address
 * @see g5ere_template_loop_property_price
 */
add_action( 'g5ere_loop_property_content_skin_01', 'g5ere_template_loop_property_title', 5 );
add_action( 'g5ere_loop_property_content_skin_01', 'g5ere_template_loop_property_address', 10 );
add_action( 'g5ere_loop_property_content_skin_01', 'g5ere_template_loop_property_price', 15 );
add_action( 'g5ere_loop_property_content_skin_01', 'g5ere_template_loop_property_meta', 20 );







/**
 * @see g5ere_template_loop_property_action
 * @see g5ere_template_loop_property_badge
 */
add_action( 'g5ere_after_loop_property_thumbnail_skin_01', 'g5ere_template_loop_property_action', 5 );
add_action( 'g5ere_after_loop_property_thumbnail_skin_01', 'g5ere_template_loop_property_badge', 10 );

/**
 * @see g5ere_template_loop_property_title
 * @see g5ere_template_loop_property_address
 * @see g5ere_template_loop_property_excerpt
 * @see g5ere_template_loop_property_price
 */
add_action( 'g5ere_loop_property_content_skin_list_01', 'g5ere_template_loop_property_title', 5 );
add_action( 'g5ere_loop_property_content_skin_list_01', 'g5ere_template_loop_property_address', 10 );
add_action( 'g5ere_loop_property_content_skin_list_01', 'g5ere_template_loop_property_excerpt', 15 );
add_action( 'g5ere_loop_property_content_skin_list_01', 'g5ere_template_loop_property_price', 20 );
add_action( 'g5ere_loop_property_content_skin_list_01', 'g5ere_template_loop_property_meta', 25 );


/**
 * @see g5ere_template_loop_property_action_view_gallery
 * @see g5ere_template_loop_property_action_favorite
 * @see g5ere_template_loop_property_action_compare
 */
add_action( 'g5ere_loop_property_action', 'g5ere_template_loop_property_action_view_gallery', 5 );
add_action( 'g5ere_loop_property_action', 'g5ere_template_loop_property_action_favorite', 10 );
add_action( 'g5ere_loop_property_action', 'g5ere_template_loop_property_action_compare', 15 );


/**
 * @see g5ere_template_loop_property_action
 * @see g5ere_template_loop_property_badge
 */
add_action( 'g5ere_after_loop_property_thumbnail_skin_list_01', 'g5ere_template_loop_property_action', 5 );
add_action( 'g5ere_after_loop_property_thumbnail_skin_list_01', 'g5ere_template_loop_property_badge', 10 );


/**
 * @see g5ere_template_loop_property_map
 * @see g5ere_template_loop_begin_property_map
 */
//add_action( G5CORE_CURRENT_THEME . '_before_main_content', 'g5ere_template_loop_begin_property_map', 99 );
//add_action( G5CORE_CURRENT_THEME . '_before_main_content', 'g5ere_template_loop_property_map', 100 );

add_action('ere_before_main_content','g5ere_template_loop_begin_property_map',8);
add_action('ere_before_main_content','g5ere_template_loop_property_map',9);



/**
 * @see g5ere_template_loop_end_property_map
 */
//add_action( G5CORE_CURRENT_THEME . '_after_main_content', 'g5ere_template_loop_end_property_map', 1 );

add_action( 'ere_after_main_content', 'g5ere_template_loop_end_property_map', 11 );

/**
 * @see g5ere_template_header_advanced_search
 */
add_action( G5CORE_CURRENT_THEME . '_before_page_wrapper_content', 'g5ere_template_header_advanced_search', 15 );
add_action( G5CORE_CURRENT_THEME . '_before_page_wrapper_content', 'g5ere_template_header_advanced_search_mobile', 16 );

/**
 * @see g5ere_template_archive_advanced_search
 */
add_action( 'g5core_before_listing_wrapper', 'g5ere_template_archive_advanced_search', 5 );


/**
 * @see g5ere_template_loop_property_title
 * @see g5ere_template_loop_property_address
 * @see g5ere_template_loop_property_status
 * @see g5ere_template_loop_property_price
 * @see g5ere_template_loop_property_meta
 */
add_action( 'g5ere_loop_property_slider_content_layout_01', 'g5ere_template_loop_property_title', 5 );
add_action( 'g5ere_loop_property_slider_content_layout_01', 'g5ere_template_loop_property_address', 10 );
add_action( 'g5ere_loop_property_slider_content_layout_01', 'g5ere_template_loop_property_primary_status', 15 );
add_action( 'g5ere_loop_property_slider_content_layout_01', 'g5ere_template_loop_property_price', 20 );
add_action( 'g5ere_loop_property_slider_content_layout_01', 'g5ere_template_loop_property_meta', 25 );

/**
 * @see g5ere_template_single_property_head
 */
add_action( G5CORE_CURRENT_THEME . '_before_main_content', 'g5ere_template_single_property_head', 12 );


/**
 * @see g5ere_template_single_property_gallery
 */
add_action( 'g5ere_single_property_head_layout_1', 'g5ere_template_single_property_gallery', 10 );


/**
 * @see g5ere_template_single_property_gallery
 */
add_action( 'g5ere_single_property_head_layout_2', 'g5ere_template_single_property_gallery', 10 );

/**
 * @see g5ere_template_breadcrumbs
 */
add_action( G5CORE_CURRENT_THEME . '_before_main_content', 'g5ere_template_breadcrumbs', 12 );


add_action( G5CORE_CURRENT_THEME . '_before_main_content', 'g5ere_template_single_property_full_map', 11 );

/**
 * @see g5ere_template_single_property_block_header
 * @see g5ere_template_single_property_content_block
 */
add_action( 'g5ere_single_property_summary_layout-1', 'g5ere_template_single_property_block_header', 10 );
add_action( 'g5ere_single_property_summary_layout-1', 'g5ere_template_single_property_content_block', 20 );

/**
 * @see g5ere_template_single_property_block_header
 * @see g5ere_template_single_property_content_block
 */
add_action( 'g5ere_single_property_summary_layout-2', 'g5ere_template_single_property_block_header', 10 );
add_action( 'g5ere_single_property_summary_layout-2', 'g5ere_template_single_property_content_block', 20 );

/**
 * @see g5ere_template_single_property_block_header
 * @see g5ere_template_single_property_gallery
 * @see g5ere_template_single_property_content_block
 *
 */
add_action( 'g5ere_single_property_head_layout_3', 'g5ere_template_single_property_block_header', 10 );
add_action( 'g5ere_single_property_head_layout_3', 'g5ere_template_single_property_gallery', 20 );
add_action( 'g5ere_single_property_summary_layout-3', 'g5ere_template_single_property_content_block', 30 );

/**
 * @see g5ere_template_single_property_block_header
 * @see g5ere_template_single_property_gallery
 * @see g5ere_template_single_property_content_block
 *
 */
add_action( 'g5ere_single_property_head_layout_4', 'g5ere_template_single_property_block_header', 10 );
add_action( 'g5ere_single_property_gallery_layout_4', 'g5ere_template_single_property_gallery', 20 );
add_action( 'g5ere_single_property_summary_layout-4', 'g5ere_template_single_property_content_block', 30 );


/**
 * @see g5ere_template_property_action_meta_open
 * @see g5ere_template_property_action
 * @see g5ere_template_property_meta
 * @see g5ere_template_tag_div_close
 *
 */
add_action( 'g5ere_single_property_head_layout_5', 'g5ere_template_property_action_meta_open', 4 );
add_action( 'g5ere_single_property_head_layout_5', 'g5ere_template_property_action', 5 );
add_action( 'g5ere_single_property_head_layout_5', 'g5ere_template_property_meta', 10 );
add_action( 'g5ere_single_property_head_layout_5', 'g5ere_template_tag_div_close', 11 );

/**
 * @see g5ere_template_single_property_content_block
 */
add_action( 'g5ere_single_property_summary_layout-5', 'g5ere_template_single_property_content_block', 30 );

/**
 * @see g5ere_template_property_title
 * @see g5ere_template_property_address
 * @see g5ere_template_property_price
 */
add_action( 'g5ere_single_property_meta_top_layout_5', 'g5ere_template_property_title', 13 );
add_action( 'g5ere_single_property_meta_top_layout_5', 'g5ere_template_property_address', 14 );
add_action( 'g5ere_single_property_meta_top_layout_5', 'g5ere_template_property_price', 15 );

/**
 * @see g5ere_template_loop_property_title
 * @see g5ere_template_loop_property_address
 * @see g5ere_template_loop_property_price
 */
add_action( 'g5ere_my_favourite_property_content', 'g5ere_template_loop_property_title', 5 );
add_action( 'g5ere_my_favourite_property_content', 'g5ere_template_loop_property_address', 10 );;
add_action( 'g5ere_my_favourite_property_content', 'g5ere_template_loop_property_price', 20 );
/**
 * @see g5ere_template_single_property_block_header
 * @see g5ere_template_single_property_gallery
 * @see g5ere_template_single_property_content_block
 *
 */
add_action( 'g5ere_single_property_summary_layout-6', 'g5ere_template_single_property_gallery', 10 );
add_action( 'g5ere_single_property_summary_layout-6', 'g5ere_template_single_property_block_header', 20 );
add_action( 'g5ere_single_property_summary_layout-6', 'g5ere_template_single_property_content_block', 30 );


/**
 * @see g5ere_template_single_property_block_header
 * @see g5ere_template_single_property_gallery
 * @see g5ere_template_single_property_content_block
 *
 */
add_action( 'g5ere_single_property_summary_layout-7', 'g5ere_template_single_property_block_header', 10 );
//add_action( 'g5ere_single_property_summary_layout-7', 'g5ere_template_single_property_gallery', 20 );
add_action( 'g5ere_single_property_summary_layout-7', 'g5ere_template_single_property_content_block', 30 );


/**
 * @see g5ere_template_single_property_block_header
 * @see g5ere_template_single_property_gallery
 * @see g5ere_template_single_property_content_block
 *
 */
add_action( 'g5ere_single_property_head_layout_8', 'g5ere_template_single_property_block_header', 10 );
add_action( 'g5ere_single_property_summary_layout-8', 'g5ere_template_single_property_gallery', 20 );
add_action( 'g5ere_single_property_summary_layout-8', 'g5ere_template_single_property_content_block', 30 );

/**
 * @see g5ere_template_single_property_content_block_two_columns
 */
add_action( 'g5ere_single_property_summary_layout-9', 'g5ere_template_single_property_content_block_two_columns', 30 );


/**
 * @see g5ere_template_property_action_meta_open
 * @see g5ere_template_property_meta
 * @see g5ere_template_property_action
 * @see g5ere_template_property_title
 * @see g5ere_template_property_price
 * @see g5ere_template_property_address
 * @see g5ere_template_tag_div_close
 * @see g5ere_template_property_title_price_open
 * @see g5ere_template_property_title_address_open
 * @see g5ere_template_property_title
 * @see g5ere_template_property_title
 */
add_action( 'g5ere_single_property_block_header', 'g5ere_template_property_action_meta_open', 4 );
add_action( 'g5ere_single_property_block_header', 'g5ere_template_property_action', 5 );
add_action( 'g5ere_single_property_block_header', 'g5ere_template_property_meta', 10 );
add_action( 'g5ere_single_property_block_header', 'g5ere_template_tag_div_close', 11 );
add_action( 'g5ere_single_property_block_header', 'g5ere_template_property_title_price_open', 13 );
add_action( 'g5ere_single_property_block_header', 'g5ere_template_property_title_address_open', 14 );
add_action( 'g5ere_single_property_block_header', 'g5ere_template_property_title', 15 );
add_action( 'g5ere_single_property_block_header', 'g5ere_template_property_address', 20 );
add_action( 'g5ere_single_property_block_header', 'g5ere_template_tag_div_close', 21 );
add_action( 'g5ere_single_property_block_header', 'g5ere_template_property_price', 25 );
add_action( 'g5ere_single_property_block_header', 'g5ere_template_tag_div_close', 26 );
add_action( 'g5ere_single_property_block_header', 'g5ere_template_single_property_block_gallery', 30 );
add_action( 'g5ere_single_property_block_header', 'g5ere_single_property_block_description', 35 );


/**
 * @see g5ere_template_loop_agency_social
 */

add_action( 'g5ere_agency_header_layout_1_bottom', 'g5ere_template_loop_agency_social', 5 );

/**
 * @see g5ere_template_loop_property_title
 * @see g5ere_template_loop_property_price
 */
add_action( 'g5ere_widget_property_content_skin_01', 'g5ere_template_loop_property_title', 5 );
add_action( 'g5ere_widget_property_content_skin_01', 'g5ere_template_loop_property_price', 10 );


/**
 * @see g5ere_template_loop_property_title
 * @see g5ere_template_loop_property_price
 */
add_action( 'g5ere_widget_property_content_skin_02', 'g5ere_template_loop_property_title', 5 );
add_action( 'g5ere_widget_property_content_skin_02', 'g5ere_template_loop_property_price', 10 );

/**
 * @see g5ere_template_loop_property_featured_status
 */
add_action( 'g5ere_widget_property_after_thumbnail_skin_02', 'g5ere_template_loop_property_featured_status', 15 );

/**
 * @see g5ere_template_single_property_contact_info
 */
add_action( 'g5ere_single_property_contact_agent', 'g5ere_template_single_property_contact_info', 5 );

/**
 * @see g5ere_template_loop_agent_title
 * @see g5ere_template_loop_agent_position
 * @see g5ere_template_loop_agent_social
 * @see g5ere_template_loop_agent_address_has_icon
 * @see g5ere_template_loop_agent_phone_has_icon
 * @see g5ere_template_loop_agent_email_has_icon
 * @see g5ere_template_loop_agent_website_has_icon
 * @see g5ere_template_single_property_agent_other_property
 */
/*add_action('g5ere_single_property_contact_agent_content','g5ere_template_loop_agent_title',5);
add_action('g5ere_single_property_contact_agent_content', 'g5ere_template_loop_agent_position', 10 );
add_action('g5ere_single_property_contact_agent_content', 'g5ere_template_loop_agent_social', 15 );
add_action('g5ere_single_property_contact_agent_content', 'g5ere_template_loop_agent_address_has_icon', 20 );
add_action('g5ere_single_property_contact_agent_content', 'g5ere_template_loop_agent_phone_has_icon', 25 );
add_action('g5ere_single_property_contact_agent_content', 'g5ere_template_loop_agent_email_has_icon', 30 );
add_action('g5ere_single_property_contact_agent_content', 'g5ere_template_loop_agent_website_has_icon', 35 );
add_action('g5ere_single_property_contact_agent_content', 'g5ere_template_loop_agent_description', 40 );
add_action('g5ere_single_property_contact_agent_content', 'g5ere_template_single_property_agent_other_property', 45 );*/


/**
 * @see g5ere_template_loop_agent_title
 * @see g5ere_template_loop_agent_position
 * @see g5ere_template_loop_agent_phone_has_icon
 * @see g5ere_template_loop_agent_email_has_icon
 * @see g5ere_template_loop_agent_address_has_icon
 * @see g5ere_template_loop_agent_social
 */
add_action( 'g5ere_single_property_contact_agent_content', 'g5ere_template_loop_agent_title', 5 );
add_action( 'g5ere_single_property_contact_agent_content', 'g5ere_template_loop_agent_position', 10 );
add_action( 'g5ere_single_property_contact_agent_content', 'g5ere_template_loop_agent_phone_has_icon', 15 );
add_action( 'g5ere_single_property_contact_agent_content', 'g5ere_template_loop_agent_email_has_icon', 20 );
add_action( 'g5ere_single_property_contact_agent_content', 'g5ere_template_loop_agent_address_has_icon', 25 );
add_action( 'g5ere_single_property_contact_agent_content', 'g5ere_template_loop_agent_social', 30 );


/**
 * @see g5ere_template_loop_agent_title
 * @see g5ere_template_loop_agent_position
 */
add_action( 'g5ere_single_property_bottom_bar_agent_content', 'g5ere_template_loop_agent_title', 5 );
add_action( 'g5ere_single_property_bottom_bar_agent_content', 'g5ere_template_loop_agent_position', 10 );


/**
 * @see g5ere_template_loop_agent_title
 * @see g5ere_template_loop_agent_position
 * @see g5ere_template_loop_agent_phone_has_icon
 * @see g5ere_template_loop_agent_email_has_icon
 * @see g5ere_template_loop_agent_website_has_icon
 * @see g5ere_template_contact_agent_button_whatsapp
 */
add_action( 'g5ere_single_property_print_contact_agent', 'g5ere_template_loop_agent_title', 5 );
add_action( 'g5ere_single_property_print_contact_agent', 'g5ere_template_loop_agent_position', 10 );
add_action( 'g5ere_single_property_print_contact_agent', 'g5ere_template_loop_agent_phone_has_icon', 15 );
add_action( 'g5ere_single_property_print_contact_agent', 'g5ere_template_loop_agent_email_has_icon', 20 );
add_action( 'g5ere_single_property_print_contact_agent', 'g5ere_template_loop_agent_website_has_icon', 25 );
add_action( 'g5ere_single_property_print_contact_agent_bottom', 'g5ere_template_contact_agent_button_whatsapp',30,2 );


/**
 * @see g5ere_template_property_title_price_open
 * @see g5ere_template_property_title_address_open
 * @see g5ere_template_property_title
 * @see g5ere_template_property_address
 * @see g5ere_template_tag_div_close
 * @see g5ere_template_property_price
 * @see g5ere_template_tag_div_close
 */
add_action( 'g5ere_property_print_header', 'g5ere_template_property_title_price_open', 13 );
add_action( 'g5ere_property_print_header', 'g5ere_template_property_title_address_open', 14 );
add_action( 'g5ere_property_print_header', 'g5ere_template_property_title_print', 15 );
add_action( 'g5ere_property_print_header', 'g5ere_template_property_address', 20 );
add_action( 'g5ere_property_print_header', 'g5ere_template_tag_div_close', 21 );
add_action( 'g5ere_property_print_header', 'g5ere_template_property_price', 25 );
add_action( 'g5ere_property_print_header', 'g5ere_template_tag_div_close', 26 );

/**
 * @see g5ere_template_loop_my_property_title
 * @see g5ere_template_loop_property_address
 * @see g5ere_template_loop_property_price
 */
add_action( 'g5ere_my_property_content', 'g5ere_template_loop_property_title', 5 );
add_action( 'g5ere_my_property_content', 'g5ere_template_loop_property_address', 10 );;
add_action( 'g5ere_my_property_content', 'g5ere_template_loop_property_price', 20 );

/**
 * @see g5ere_template_dashboard_section_overview
 * @see g5ere_template_dashboard_section_review
 * @see g5ere_template_dashboard_section_package
 */
add_action( 'g5ere_dashboard_section_before', 'g5ere_template_dashboard_section_overview' );


add_action( 'g5ere_loop_property_content_auto_complete_search', 'g5ere_template_loop_property_title', 5 );
add_action( 'g5ere_loop_property_content_auto_complete_search', 'g5ere_template_loop_property_address', 10 );
//add_action( 'g5ere_loop_property_content_auto_complete_search', 'g5ere_template_loop_property_price', 15 );
//add_action( 'g5ere_loop_property_content_auto_complete_search', 'g5ere_template_loop_property_meta', 20 );


