<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @see ere_template_single_property_gallery
 * @see ere_template_single_property_floor
 * @see ere_template_single_property_features
 */
add_action( 'ere_single_property_summary', 'ere_template_single_property_gallery', 10 );
add_action( 'ere_single_property_summary', 'ere_template_single_property_features', 25 );
add_action('ere_single_property_summary','ere_template_single_property_floor',30);

/**
 * @see ere_template_loop_property_action_view_gallery
 * @see ere_template_loop_property_action_favorite
 * @see ere_template_loop_property_action_compare
 */
add_action('ere_loop_property_action','ere_template_loop_property_action_view_gallery',5);
add_action('ere_loop_property_action','ere_template_loop_property_action_favorite',10);
add_action('ere_loop_property_action','ere_template_loop_property_action_compare',15);

/**
 * @see ere_template_loop_property_action
 * @see ere_template_loop_property_featured_label
 * @see ere_template_loop_property_term_status
 */
add_action('ere_after_loop_property_thumbnail','ere_template_loop_property_action',5);
add_action('ere_after_loop_property_thumbnail','ere_template_loop_property_featured_label',10);
add_action('ere_after_loop_property_thumbnail','ere_template_loop_property_term_status',15);

/**
 * @see ere_template_loop_property_link
 */
add_action('ere_after_loop_property_action','ere_template_loop_property_link',10);

/**
 * @see ere_template_loop_property_title
 * @see ere_template_loop_property_price
 */
add_action('ere_loop_property_heading','ere_template_loop_property_title',5);
add_action('ere_loop_property_heading','ere_template_loop_property_price',10);

/**
 * @see ere_template_loop_property_location
 * @see ere_template_loop_property_meta
 * @see ere_template_loop_property_excerpt
 * @see ere_template_loop_property_info
 */
add_action('ere_after_loop_property_heading','ere_template_loop_property_location',5);
add_action('ere_after_loop_property_heading','ere_template_loop_property_meta',10);
add_action('ere_after_loop_property_heading','ere_template_loop_property_excerpt',15);
add_action('ere_after_loop_property_heading','ere_template_loop_property_info',20);

/**
 * @see ere_template_loop_property_type
 * @see ere_template_loop_property_agent
 * @see ere_template_loop_property_date
 */
add_action('ere_loop_property_meta','ere_template_loop_property_type',5);
add_action('ere_loop_property_meta','ere_template_loop_property_agent',10);
add_action('ere_loop_property_meta','ere_template_loop_property_date',15);

/**
 * @see ere_template_loop_property_size
 * @see ere_template_loop_property_bedrooms
 * @see ere_template_loop_property_bathrooms
 */
add_action('ere_loop_property_info','ere_template_loop_property_size',5);
add_action('ere_loop_property_info','ere_template_loop_property_bedrooms',10);
add_action('ere_loop_property_info','ere_template_loop_property_bathrooms',15);

/**
 * @see ere_template_archive_property_heading
 * @see ere_template_archive_property_action
 */
add_action('ere_before_archive_property','ere_template_archive_property_heading',10,4);
add_action('ere_before_archive_property','ere_template_archive_property_action',15);

/**
 * @see ere_template_archive_property_action_status
 * @see ere_template_archive_property_action_orderby
 * @see ere_template_archive_property_action_switch_layout
 */
add_action('ere_archive_property_actions','ere_template_archive_property_action_status',5);
add_action('ere_archive_property_actions','ere_template_archive_property_action_orderby',10);
add_action('ere_archive_property_actions','ere_template_archive_property_action_switch_layout',15);

/**
 * @see ere_template_property_advanced_search_form
 */
add_action('ere_before_advanced_search','ere_template_property_advanced_search_form', 10,2);

/**
 * @see ere_template_loop_property_title
 * @see ere_template_loop_property_price
 * @see ere_template_loop_property_location
 */
add_action('ere_sc_property_gallery_loop_property_content','ere_template_loop_property_title',5);
add_action('ere_sc_property_gallery_loop_property_content','ere_template_loop_property_price',10);
add_action('ere_sc_property_gallery_loop_property_content','ere_template_loop_property_location',15);

/**
 * @@see ere_template_loop_property_link
 */
add_action('ere_sc_property_gallery_after_loop_property_content','ere_template_loop_property_link',5);

/**
 * @see ere_template_loop_property_title
 * @see ere_template_loop_property_price
 * @see ere_template_loop_property_term_status
 * @see ere_template_loop_property_location
 */
add_action('ere_sc_property_gallery_layout_navigation_middle_loop_property_heading','ere_template_loop_property_price',10);
add_action('ere_sc_property_gallery_layout_navigation_middle_loop_property_heading','ere_template_loop_property_term_status',15);
add_action('ere_sc_property_gallery_layout_navigation_middle_loop_property_heading','ere_template_loop_property_location',20);

/**
 * @see ere_template_loop_property_title
 */
add_action('ere_before_sc_property_gallery_layout_navigation_middle_loop_property_heading','ere_template_loop_property_title', 5);

/**
 * @see ere_template_loop_property_info_layout_2
 */
add_action('ere_after_sc_property_gallery_layout_navigation_middle_loop_property_content','ere_template_loop_property_info_layout_2',5);

/**
 * @see ere_template_loop_property_location
 * @see ere_template_loop_property_title
 * @see ere_template_loop_property_price
 */
add_action('ere_sc_property_gallery_layout_pagination_image_loop_property_heading','ere_template_loop_property_location',5);
add_action('ere_sc_property_gallery_layout_pagination_image_loop_property_heading','ere_template_loop_property_title',10);
add_action('ere_sc_property_gallery_layout_pagination_image_loop_property_heading','ere_template_loop_property_price',15);

/**
 * @see ere_template_loop_property_info_layout_2
 */
add_action('ere_after_sc_property_gallery_layout_pagination_image_loop_property_content','ere_template_loop_property_info_layout_2',5);

