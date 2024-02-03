<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * @see g5blog_template_single_title
 * @see g5blog_template_single_meta
 */
add_action('g5blog_single_meta_top','g5blog_template_single_title',5);
add_action('g5blog_single_meta_top','g5blog_template_single_meta',10);

/**
 * @see g5blog_single_meta_bottom
 */
add_action('g5blog_after_single_content','g5blog_single_meta_bottom',10);

/**
 * @see g5blog_template_single_navigation
 * @see g5blog_template_author_info
 * @see g5blog_template_single_related
 * @see g5blog_template_single_comment
 */
add_action('g5blog_after_single','g5blog_template_single_navigation',10);
add_action('g5blog_after_single','g5blog_template_author_info',15);
add_action('g5blog_after_single','g5blog_template_single_related',20);
add_action('g5blog_after_single','g5blog_template_single_comment',25);


/**
 * @see g5blog_template_single_title
 * @see g5blog_template_single_image
 * @see g5blog_template_single_meta
 */
add_action('g5blog_before_single_content','g5blog_template_single_title',5);
add_action('g5blog_before_single_content','g5blog_template_single_image',10);
add_action('g5blog_before_single_content','g5blog_template_single_meta',15);


/**
 * @see g5blog_template_post_title
 * @see g5blog_template_widget_post_meta
 */
add_action('g5blog_widget_post_content','g5blog_template_post_title',5);
add_action('g5blog_widget_post_content','g5blog_template_widget_post_meta',10);

/**
 * @see g5blog_template_post_title
 * @see g5blog_template_loop_post_meta
 * @see g5blog_template_loop_excerpt
 */
add_action('g5blog_loop_post_content','g5blog_template_post_title',5);
add_action('g5blog_loop_post_content','g5blog_template_loop_post_meta',10);
add_action('g5blog_loop_post_content','g5blog_template_loop_excerpt',15);

/**
 * @see g5blog_single_meta_tag
 * @see g5blog_single_meta_share
 */
add_action('g5blog_single_meta_bottom','g5blog_single_meta_tag',10);
add_action('g5blog_single_meta_bottom','g5blog_single_meta_share',20);
