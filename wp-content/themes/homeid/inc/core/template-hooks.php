<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * @see g5ere_template_loop_property_label_featured
 */
add_action( 'g5ere_loop_property_slider_content_layout_01', 'g5ere_template_loop_property_featured', 5 );

/**
 * @see g5ere_template_loop_property_title
 * @see g5ere_template_loop_property_address
 * @see g5ere_template_loop_property_excerpt
 * @see g5ere_template_loop_property_meta
 * @see g5ere_template_loop_property_price
 */
add_action( 'g5ere_loop_property_slider_content_layout_02', 'g5ere_template_loop_property_title', 5 );
add_action( 'g5ere_loop_property_slider_content_layout_02', 'g5ere_template_loop_property_address', 10 );
add_action( 'g5ere_loop_property_slider_content_layout_02', 'g5ere_template_loop_property_excerpt', 15 );
add_action( 'g5ere_loop_property_slider_content_layout_02', 'g5ere_template_loop_property_meta', 20 );

/**
 * @see g5ere_template_loop_property_price
 * @see g5ere_template_loop_property_action
 */
add_action( 'g5ere_loop_property_slider_bottom_layout_02', 'g5ere_template_loop_property_price', 5 );
add_action( 'g5ere_loop_property_slider_bottom_layout_02', 'g5ere_template_loop_property_action', 10 );

/**
 * @see g5ere_template_loop_property_label
 * @see g5ere_template_loop_property_status
 */
add_action( 'g5ere_loop_property_slider_thumbnail_layout_02', 'g5ere_template_loop_property_label', 5 );
add_action( 'g5ere_loop_property_slider_thumbnail_layout_02', 'g5ere_template_loop_property_featured_status', 10 );


/**
 * @see g5ere_template_loop_property_status
 * @see g5ere_template_loop_property_status
 * @see g5ere_template_loop_property_address
 * @see g5ere_template_loop_property_price
 */
add_action( 'g5ere_loop_property_slider_content_layout_03', 'g5ere_template_loop_property_status', 5 );
add_action( 'g5ere_loop_property_slider_content_layout_03', 'g5ere_template_loop_property_title', 10 );
add_action( 'g5ere_loop_property_slider_content_layout_03', 'g5ere_template_loop_property_address', 15 );
add_action( 'g5ere_loop_property_slider_content_layout_03', 'g5ere_template_loop_property_price', 20 );


/**
 * @see g5ere_template_loop_property_title
 * @see g5ere_template_loop_property_address
 * @see g5ere_template_loop_property_meta
 * @see g5ere_template_loop_property_price
 */
add_action( 'g5ere_loop_property_slider_content_layout_04', 'g5ere_template_loop_property_title', 5 );
add_action( 'g5ere_loop_property_slider_content_layout_04', 'g5ere_template_loop_property_address', 10 );
add_action( 'g5ere_loop_property_slider_content_layout_04', 'g5ere_template_loop_property_meta', 15 );

/**
 * @see g5ere_template_loop_property_price
 * @see g5ere_template_loop_property_action
 */
add_action( 'g5ere_loop_property_slider_bottom_layout_04', 'g5ere_template_loop_property_primary_status', 5 );
add_action( 'g5ere_loop_property_slider_bottom_layout_04', 'g5ere_template_loop_property_badge_featured', 10 );
add_action( 'g5ere_loop_property_slider_bottom_layout_04', 'g5ere_template_loop_property_price', 15 );


/**
 * @see g5ere_template_loop_property_title
 * @see g5ere_template_loop_property_address
 * @see g5ere_template_loop_property_excerpt
 * @see g5ere_template_loop_property_meta
 */
add_action( 'g5ere_loop_property_slider_content_layout_05', 'g5ere_template_loop_property_title', 5 );
add_action( 'g5ere_loop_property_slider_content_layout_05', 'g5ere_template_loop_property_address', 10 );
add_action( 'g5ere_loop_property_slider_content_layout_05', 'g5ere_template_loop_property_excerpt', 15 );
add_action( 'g5ere_loop_property_slider_content_layout_05', 'g5ere_template_loop_property_meta', 20 );

/**
 * @see g5ere_template_loop_property_price
 * @see g5ere_template_loop_property_action_favorite
 * @see g5ere_template_loop_property_action_compare
 */
add_action( 'g5ere_loop_property_slider_bottom_layout_05', 'g5ere_template_loop_property_price', 5 );
add_action( 'g5ere_loop_property_slider_bottom_layout_05', 'g5ere_template_loop_property_action_favorite', 10 );
add_action( 'g5ere_loop_property_slider_bottom_layout_05', 'g5ere_template_loop_property_action_compare', 15 );

/**
 * @see g5ere_template_loop_property_title
 * @see g5ere_template_loop_property_address
 * @see g5ere_template_loop_property_meta
 * @see g5ere_template_loop_property_price
 */
add_action( 'g5ere_loop_property_content_skin_02', 'g5ere_template_loop_property_title', 5 );
add_action( 'g5ere_loop_property_content_skin_02', 'g5ere_template_loop_property_address', 10 );
add_action( 'g5ere_loop_property_content_skin_02', 'g5ere_template_loop_property_meta', 15 );

/**
 * @see g5ere_template_loop_property_price
 */
add_action( 'g5ere_loop_property_bottom_price_skin_02', 'g5ere_template_loop_property_price', 5 );

/**
 * @see g5ere_template_loop_property_action_favorite
 * @see g5ere_template_loop_property_action_compare
 */
add_action( 'g5ere_loop_property_bottom_action_skin_02', 'g5ere_template_loop_property_action_favorite', 5 );
add_action( 'g5ere_loop_property_bottom_action_skin_02', 'g5ere_template_loop_property_action_compare', 10 );

/**
 * @hooked g5ere_template_loop_property_badge - 10
 */

add_action( 'g5ere_after_loop_property_thumbnail_skin_02', 'g5ere_template_loop_property_badge', 10 );

/**
 * @hooked g5ere_template_loop_property_action_view_gallery - 5
 */
add_action( 'g5ere_loop_property_action_skin_02', 'g5ere_template_loop_property_action_view_gallery', 5 );


/**
 * @see g5ere_template_loop_property_featured_status
 */
add_action( 'g5ere_after_loop_property_thumbnail_skin_03', 'g5ere_template_loop_property_featured_status', 5 );


/**
 * @see g5ere_template_loop_property_action_favorite
 * @see g5ere_template_loop_property_action_compare
 */
add_action( 'g5ere_loop_property_action_skin_03', 'g5ere_template_loop_property_action_favorite', 5 );
add_action( 'g5ere_loop_property_action_skin_03', 'g5ere_template_loop_property_action_compare', 10 );

/**
 * @see g5ere_template_loop_property_price
 * @see g5ere_template_loop_property_title
 * @see g5ere_template_loop_property_meta
 */
add_action( 'g5ere_loop_property_content_skin_03', 'g5ere_template_loop_property_price', 5 );
add_action( 'g5ere_loop_property_content_skin_03', 'g5ere_template_loop_property_title', 10 );
add_action( 'g5ere_loop_property_content_skin_03', 'g5ere_template_loop_property_meta', 15 );

/**
 * @see g5ere_template_loop_property_title
 * @see g5ere_template_loop_property_address
 * @see g5ere_template_loop_property_price
 */
add_action( 'g5ere_loop_property_content_skin_04', 'g5ere_template_loop_property_title', 5 );
add_action( 'g5ere_loop_property_content_skin_04', 'g5ere_template_loop_property_address', 10 );
add_action( 'g5ere_loop_property_content_skin_04', 'g5ere_template_loop_property_price', 15 );

/**
 * @see g5ere_template_loop_property_badge
 */
add_action( 'g5ere_after_loop_property_thumbnail_skin_04', 'g5ere_template_loop_property_badge', 5 );


/**
 * @see g5ere_template_loop_property_meta
 */
add_action( 'g5ere_after_loop_property_thumbnail_content_skin_04', 'g5ere_template_loop_property_meta', 5 );

/**
 * @see g5ere_template_loop_property_action_favorite
 * @see g5ere_template_loop_property_action_compare
 */
add_action( 'g5ere_after_loop_property_action_skin_04', 'g5ere_template_loop_property_action_favorite', 5 );
add_action( 'g5ere_after_loop_property_action_skin_04', 'g5ere_template_loop_property_action_compare', 10 );

/**
 * @see g5ere_template_loop_property_action
 * @see g5ere_template_loop_property_label
 */
add_action( 'g5ere_after_loop_property_thumbnail_skin_05', 'g5ere_template_loop_property_action', 5 );
add_action( 'g5ere_after_loop_property_thumbnail_skin_05', 'g5ere_template_loop_property_featured_label', 10 );

/**
 * @see g5ere_template_loop_property_price
 * @see g5ere_template_loop_property_primary_status
 */
add_action( 'g5ere_loop_property_content_top_skin_05', 'g5ere_template_loop_property_price', 5 );
add_action( 'g5ere_loop_property_content_top_skin_05', 'g5ere_template_loop_property_primary_status', 10 );

/**
 * @see g5ere_template_loop_property_title
 * @see g5ere_template_loop_property_address
 */
add_action( 'g5ere_loop_property_content_skin_05', 'g5ere_template_loop_property_title', 5 );
add_action( 'g5ere_loop_property_content_skin_05', 'g5ere_template_loop_property_address', 10 );


/**
 * @see g5ere_template_loop_property_meta
 */
add_action( 'g5ere_loop_property_content_bottom_skin_05', 'g5ere_template_loop_property_meta', 5 );


/**
 * @see g5ere_template_loop_property_featured_status
 */
add_action( 'g5ere_after_loop_property_thumbnail_skin_06', 'g5ere_template_loop_property_featured_status', 5 );


/**
 * @see g5ere_template_loop_property_action_favorite
 * @see g5ere_template_loop_property_action_compare
 */
add_action( 'g5ere_loop_property_action_top_skin_06', 'g5ere_template_loop_property_action_favorite', 5 );
add_action( 'g5ere_loop_property_action_top_skin_06', 'g5ere_template_loop_property_action_compare', 10 );


/**
 * @see g5ere_template_loop_property_title
 * @see g5ere_template_loop_property_address
 */
add_action( 'g5ere_loop_property_content_skin_06', 'g5ere_template_loop_property_title', 5 );
add_action( 'g5ere_loop_property_content_skin_06', 'g5ere_template_loop_property_address', 10 );

/**
 * @see g5ere_template_loop_property_price
 * @see g5ere_template_loop_property_meta
 */
add_action( 'g5ere_loop_property_content_bottom_skin_06', 'g5ere_template_loop_property_price', 5 );
add_action( 'g5ere_loop_property_content_bottom_skin_06', 'g5ere_template_loop_property_meta', 10 );

/**
 * @see g5ere_template_loop_property_action
 * @see g5ere_template_loop_property_badge
 */
add_action( 'g5ere_after_loop_property_thumbnail_skin_07', 'g5ere_template_loop_property_action', 5 );
add_action( 'g5ere_after_loop_property_thumbnail_skin_07', 'g5ere_template_loop_property_badge', 10 );

/**
 * @see g5ere_template_loop_property_title
 * @see g5ere_template_loop_property_address
 */
add_action( 'g5ere_before_loop_property_thumbnail_skin_07', 'g5ere_template_loop_property_title', 5 );
add_action( 'g5ere_before_loop_property_thumbnail_skin_07', 'g5ere_template_loop_property_address', 10 );

/**
 * @see g5ere_template_loop_property_price
 * @see g5ere_template_loop_property_status
 */
add_action( 'g5ere_loop_property_content_top_skin_07', 'g5ere_template_loop_property_price', 5 );
add_action( 'g5ere_loop_property_content_top_skin_07', 'g5ere_template_loop_property_primary_status', 10 );


/**
 * @see g5ere_template_loop_property_excerpt
 */
add_action( 'g5ere_loop_property_content_skin_07', 'g5ere_template_loop_property_excerpt', 5 );

/**
 * @see g5ere_template_loop_property_meta
 */
add_action( 'g5ere_loop_property_content_bottom_skin_07', 'g5ere_template_loop_property_meta', 5 );

/**
 * @see g5ere_template_loop_property_title
 * @see g5ere_template_loop_property_address
 * @see g5ere_template_loop_property_price
 * @see g5ere_template_loop_property_meta
 */
add_action( 'g5ere_loop_property_content_skin_08', 'g5ere_template_loop_property_title', 5 );
add_action( 'g5ere_loop_property_content_skin_08', 'g5ere_template_loop_property_address', 10 );
add_action( 'g5ere_loop_property_content_skin_08', 'g5ere_template_loop_property_price', 15 );
add_action( 'g5ere_loop_property_content_skin_08', 'g5ere_template_loop_property_meta', 20 );


/**
 * @see g5ere_template_loop_property_action
 * @see g5ere_template_loop_property_badge
 */
add_action( 'g5ere_after_loop_property_thumbnail_skin_08', 'g5ere_template_loop_property_action', 5 );
add_action( 'g5ere_after_loop_property_thumbnail_skin_08', 'g5ere_template_loop_property_badge', 10 );

/**
 * @see g5ere_template_loop_property_badge
 */
add_action( 'g5ere_after_loop_property_thumbnail_skin_09', 'g5ere_template_loop_property_badge', 10 );

/**
 * @see g5ere_template_loop_property_action_favorite
 * @see g5ere_template_loop_property_action_compare
 */
add_action( 'g5ere_loop_property_action_skin_09', 'g5ere_template_loop_property_action_favorite', 5 );
add_action( 'g5ere_loop_property_action_skin_09', 'g5ere_template_loop_property_action_compare', 10 );

/**
 * @see g5ere_template_loop_property_address
 * @see g5ere_template_loop_property_title
 */
add_action( 'g5ere_loop_property_content_left_skin_09', 'g5ere_template_loop_property_address', 5 );
add_action( 'g5ere_loop_property_content_left_skin_09', 'g5ere_template_loop_property_title', 10 );

/**
 * @see g5ere_template_loop_property_price
 * @see g5ere_template_loop_property_meta
 */
add_action( 'g5ere_loop_property_content_right_skin_09', 'g5ere_template_loop_property_price', 5 );
add_action( 'g5ere_loop_property_content_right_skin_09', 'g5ere_template_loop_property_meta', 10 );

/**
 * @see g5ere_template_loop_property_featured
 */
add_action( 'g5ere_after_loop_property_thumbnail_featured_skin_09', 'g5ere_template_loop_property_featured', 5 );

/**
 * @see g5ere_template_loop_property_badge
 */
add_action( 'g5ere_after_loop_property_thumbnail_skin_10', 'g5ere_template_loop_property_badge', 10 );

/**
 * @see g5ere_template_loop_property_action_favorite
 * @see g5ere_template_loop_property_action_compare
 */
add_action( 'g5ere_loop_property_action_skin_10', 'g5ere_template_loop_property_action_favorite', 5 );
add_action( 'g5ere_loop_property_action_skin_10', 'g5ere_template_loop_property_action_compare', 10 );

/**
 * @see g5ere_template_loop_property_title
 * @see g5ere_template_loop_property_price
 */
add_action( 'g5ere_loop_property_content_skin_10', 'g5ere_template_loop_property_title', 5 );
add_action( 'g5ere_loop_property_content_skin_10', 'g5ere_template_loop_property_price', 10 );

/**
 * @see g5ere_template_loop_property_action_favorite
 * @see g5ere_template_loop_property_action_compare
 */
add_action( 'g5ere_after_loop_property_thumbnail_skin_list_02', 'g5ere_template_loop_property_action_favorite', 5 );
add_action( 'g5ere_after_loop_property_thumbnail_skin_list_02', 'g5ere_template_loop_property_action_compare', 10 );

/**
 * @see g5ere_template_loop_property_title
 * @see g5ere_template_loop_property_address
 * @see g5ere_template_loop_property_price
 * @see g5ere_template_loop_property_excerpt
 */
add_action( 'g5ere_loop_property_content_skin_list_02', 'g5ere_template_loop_property_title', 5 );
add_action( 'g5ere_loop_property_content_skin_list_02', 'g5ere_template_loop_property_address', 10 );
add_action( 'g5ere_loop_property_content_skin_list_02', 'g5ere_template_loop_property_price', 15 );
add_action( 'g5ere_loop_property_content_skin_list_02', 'g5ere_template_loop_property_excerpt', 20 );


/**
 * @see g5ere_template_loop_property_meta
 * @see g5ere_template_loop_property_status
 */
add_action( 'g5ere_loop_property_content_bottom_skin_list_02', 'g5ere_template_loop_property_meta', 5 );
add_action( 'g5ere_loop_property_content_bottom_skin_list_02', 'g5ere_template_loop_property_primary_status', 10 );


/**
 * @see g5ere_template_loop_property_action
 * @see g5ere_template_loop_property_badge
 */
add_action( 'g5ere_after_loop_property_thumbnail_skin_list_03', 'g5ere_template_loop_property_action', 5 );
add_action( 'g5ere_after_loop_property_thumbnail_skin_list_03', 'g5ere_template_loop_property_badge', 10 );

/**
 * @see g5ere_template_loop_property_title
 * @see g5ere_template_loop_property_address
 * @see g5ere_template_loop_property_excerpt
 */
add_action( 'g5ere_loop_property_content_skin_list_03', 'g5ere_template_loop_property_title', 5 );
add_action( 'g5ere_loop_property_content_skin_list_03', 'g5ere_template_loop_property_address', 10 );
add_action( 'g5ere_loop_property_content_skin_list_03', 'g5ere_template_loop_property_excerpt', 15 );

/**
 * @see g5ere_template_loop_property_meta
 * @see g5ere_template_loop_property_price
 */
add_action( 'g5ere_loop_property_content_bottom_skin_list_03', 'g5ere_template_loop_property_meta', 5 );
add_action( 'g5ere_loop_property_content_bottom_skin_list_03', 'g5ere_template_loop_property_price', 10 );

/**
 * @see g5ere_template_loop_property_badge_featured
 */
add_action( 'g5ere_after_loop_property_thumbnail_skin_list_04', 'g5ere_template_loop_property_badge_featured', 5 );

/**
 * @see g5ere_template_loop_property_action_favorite
 * @see g5ere_template_loop_property_action_compare
 */
add_action( 'g5ere_after_loop_property_action_skin_list_04', 'g5ere_template_loop_property_action_favorite', 5 );
add_action( 'g5ere_after_loop_property_action_skin_list_04', 'g5ere_template_loop_property_action_compare', 10 );

/**
 * @see g5ere_template_loop_property_title
 * @see g5ere_template_loop_property_address
 * @see g5ere_template_loop_property_primary_status
 * @see g5ere_template_loop_property_excerpt
 */
add_action( 'g5ere_after_loop_property_content_skin_list_04', 'g5ere_template_loop_property_title', 5 );
add_action( 'g5ere_after_loop_property_content_skin_list_04', 'g5ere_template_loop_property_address', 10 );
add_action( 'g5ere_after_loop_property_content_skin_list_04', 'g5ere_template_loop_property_primary_status', 15 );
add_action( 'g5ere_after_loop_property_content_skin_list_04', 'g5ere_template_loop_property_excerpt', 20 );


/**
 * @see g5ere_template_loop_property_price
 * @see g5ere_template_loop_property_meta
 */
add_action( 'g5ere_after_loop_property_content_bottom_skin_list_04', 'g5ere_template_loop_property_price', 5 );
add_action( 'g5ere_after_loop_property_content_bottom_skin_list_04', 'g5ere_template_loop_property_meta', 10 );

/**
 * @see g5ere_template_loop_property_badge
 */
add_action( 'g5ere_after_loop_property_thumbnail_metro_01', 'g5ere_template_loop_property_badge', 5 );

/**
 * @see g5ere_template_loop_property_action_favorite
 * @see g5ere_template_loop_property_action_compare
 */
add_action( 'g5ere_loop_property_action_skin_metro_01', 'g5ere_template_loop_property_action_favorite', 5 );
add_action( 'g5ere_loop_property_action_skin_metro_01', 'g5ere_template_loop_property_action_compare', 10 );


/**
 * @see g5ere_template_loop_property_title
 * @see g5ere_template_loop_property_address
 */
add_action( 'g5ere_loop_property_content_skin_metro_01', 'g5ere_template_loop_property_title', 5 );
add_action( 'g5ere_loop_property_content_skin_metro_01', 'g5ere_template_loop_property_address', 10 );

/**
 * @see g5ere_template_loop_property_price
 * @see g5ere_template_loop_property_meta
 */
add_action( 'g5ere_loop_property_content_bottom_skin_metro_01', 'g5ere_template_loop_property_price', 5 );
add_action( 'g5ere_loop_property_content_bottom_skin_metro_01', 'g5ere_template_loop_property_meta', 10 );

/**
 * @see g5ere_template_loop_property_badge
 */
add_action( 'g5ere_after_loop_property_thumbnail_metro_03', 'g5ere_template_loop_property_badge', 5 );

/**
 * @see g5ere_template_loop_property_action_favorite
 * @see g5ere_template_loop_property_action_compare
 */
add_action( 'g5ere_loop_property_action_skin_metro_03', 'g5ere_template_loop_property_action_favorite', 5 );
add_action( 'g5ere_loop_property_action_skin_metro_03', 'g5ere_template_loop_property_action_compare', 10 );

/**
 * @see g5ere_template_loop_property_title
 * @see g5ere_template_loop_property_address
 * @see g5ere_template_loop_property_price
 * @see g5ere_template_loop_property_meta
 */
add_action( 'g5ere_loop_property_content_skin_metro_03', 'g5ere_template_loop_property_price', 5 );
add_action( 'g5ere_loop_property_content_skin_metro_03', 'g5ere_template_loop_property_title', 10 );
add_action( 'g5ere_loop_property_content_skin_metro_03', 'g5ere_template_loop_property_address', 15 );
add_action( 'g5ere_loop_property_content_skin_metro_03', 'g5ere_template_loop_property_meta', 20 );

/**
 * @see g5ere_template_loop_agent_title
 * @see g5ere_template_loop_agent_position
 * @see g5ere_template_loop_agent_rating
 * @see g5ere_template_loop_agent_social
 */
add_action( 'g5ere_loop_agent_content_skin_02', 'g5ere_template_loop_agent_title', 5 );
add_action( 'g5ere_loop_agent_content_skin_02', 'g5ere_template_loop_agent_position', 10 );
add_action( 'g5ere_loop_agent_content_skin_02', 'g5ere_template_loop_agent_rating', 15 );
add_action( 'g5ere_loop_agent_content_skin_02', 'g5ere_template_loop_agent_social', 20 );


/**
 * @see g5ere_template_loop_agent_title
 * @see g5ere_template_loop_agent_position
 * @see g5ere_template_loop_agent_social
 * @see g5ere_template_loop_agent_property
 */
add_action( 'g5ere_loop_agent_content_skin_03', 'g5ere_template_loop_agent_title', 5 );
add_action( 'g5ere_loop_agent_content_skin_03', 'g5ere_template_loop_agent_position', 10 );
add_action( 'g5ere_loop_agent_content_skin_03', 'g5ere_template_loop_agent_social', 15 );
add_action( 'g5ere_loop_agent_content_skin_03', 'g5ere_template_loop_agent_property', 20 );


/**
 * @see g5ere_template_loop_agent_title
 * @see g5ere_template_loop_agent_position
 * @see g5ere_template_loop_agent_social
 */
add_action( 'g5ere_loop_agent_content_top_skin_04', 'g5ere_template_loop_agent_title', 5 );
add_action( 'g5ere_loop_agent_content_top_skin_04', 'g5ere_template_loop_agent_position', 10 );
add_action( 'g5ere_loop_agent_content_top_skin_04', 'g5ere_template_loop_agent_social', 15 );


/**
 * @see g5ere_template_loop_agent_email
 * @see g5ere_template_loop_agent_phone
 * @see g5ere_template_loop_agent_rating
 * @see g5ere_template_loop_agent_property
 */
add_action( 'g5ere_loop_agent_content_skin_04', 'g5ere_template_loop_agent_email', 5 );
add_action( 'g5ere_loop_agent_content_skin_04', 'g5ere_template_loop_agent_phone', 10 );
add_action( 'g5ere_loop_agent_content_skin_04', 'g5ere_template_loop_agent_rating', 15 );
add_action( 'g5ere_loop_agent_content_skin_04', 'g5ere_template_loop_agent_property', 20 );


/**
 * @see g5ere_template_loop_agent_title
 * @see g5ere_template_loop_agent_position
 * @see g5ere_template_loop_agent_rating
 */
add_action( 'g5ere_loop_agent_content_top_skin_05', 'g5ere_template_loop_agent_title', 5 );
add_action( 'g5ere_loop_agent_content_top_skin_05', 'g5ere_template_loop_agent_position', 10 );
add_action( 'g5ere_loop_agent_content_top_skin_05', 'g5ere_template_loop_agent_rating', 15 );

/**
 * @see g5ere_template_loop_agent_office_number_has_title
 * @see g5ere_template_loop_agent_phone_has_title
 * @see g5ere_template_loop_agent_fax_has_title
 * @see g5ere_template_loop_agent_email_has_title
 * @see g5ere_template_loop_agent_social_has_title
 */
add_action( 'g5ere_loop_agent_content_skin_05', 'g5ere_template_loop_agent_office_number_has_title', 5 );
add_action( 'g5ere_loop_agent_content_skin_05', 'g5ere_template_loop_agent_phone_has_title', 10 );
add_action( 'g5ere_loop_agent_content_skin_05', 'g5ere_template_loop_agent_fax_has_title', 15 );
add_action( 'g5ere_loop_agent_content_skin_05', 'g5ere_template_loop_agent_email_has_title', 20 );
add_action( 'g5ere_loop_agent_content_skin_05', 'g5ere_template_loop_agent_social_has_title', 25 );

/**
 * @see g5ere_template_loop_agent_title
 * @see g5ere_template_loop_agent_position
 * @see g5ere_template_loop_agent_description
 */
add_action( 'g5ere_loop_agent_content_top_skin_06', 'g5ere_template_loop_agent_title', 5 );
add_action( 'g5ere_loop_agent_content_top_skin_06', 'g5ere_template_loop_agent_position', 10 );
add_action( 'g5ere_loop_agent_content_top_skin_06', 'g5ere_template_loop_agent_description', 15 );

/**
 * @see g5ere_template_loop_agent_social
 * @see g5ere_template_loop_agent_property
 */
add_action( 'g5ere_loop_agent_content_bottom_skin_06', 'g5ere_template_loop_agent_social', 5 );
add_action( 'g5ere_loop_agent_content_bottom_skin_06', 'g5ere_template_loop_agent_property', 10 );

/**
 * @see g5ere_template_loop_agent_property
 */
add_action( 'g5ere_loop_agent_after_thumbnail_skin_list_02', 'g5ere_template_loop_agent_property', 5 );

/**
 * @see g5ere_template_loop_agent_title
 * @see g5ere_template_loop_agent_position
 * @see g5ere_template_loop_agent_description
 * @see g5ere_template_loop_agent_social
 */
add_action( 'g5ere_loop_agent_list_content_skin_list_02', 'g5ere_template_loop_agent_title', 5 );
add_action( 'g5ere_loop_agent_list_content_skin_list_02', 'g5ere_template_loop_agent_position', 10 );
add_action( 'g5ere_loop_agent_list_content_skin_list_02', 'g5ere_template_loop_agent_description', 15 );
add_action( 'g5ere_loop_agent_list_content_skin_list_02', 'g5ere_template_loop_agent_social', 20 );


/**
 * @see g5ere_template_loop_agent_title
 * @see g5ere_template_loop_agent_position
 */
add_action( 'g5ere_loop_agent_content_skin_07', 'g5ere_template_loop_agent_title', 5 );
add_action( 'g5ere_loop_agent_content_skin_07', 'g5ere_template_loop_agent_position', 10 );


/**
 * @see g5ere_template_loop_agent_title
 * @see g5ere_template_loop_agent_position
 * @see g5ere_template_agent_rating
 * @see g5ere_template_loop_agent_email
 * @see g5ere_template_loop_agent_phone
 * @see g5ere_template_loop_agent_social
 */
add_action( 'g5ere_widget_contact_agent_info_agent_layout_02', 'g5ere_template_loop_agent_title', 10 );
add_action( 'g5ere_widget_contact_agent_info_agent_layout_02', 'g5ere_template_loop_agent_position', 15 );
add_action( 'g5ere_widget_contact_agent_info_agent_layout_02', 'g5ere_template_agent_rating', 20 );
add_action( 'g5ere_widget_contact_agent_info_agent_layout_02', 'g5ere_template_loop_agent_email', 25 );
add_action( 'g5ere_widget_contact_agent_info_agent_layout_02', 'g5ere_template_loop_agent_phone', 30 );
add_action( 'g5ere_widget_contact_agent_info_agent_layout_02', 'g5ere_template_loop_agent_social', 35 );

