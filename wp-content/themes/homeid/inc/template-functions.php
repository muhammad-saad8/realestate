<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

/**
 * Header template
 */
function homeid_template_header()
{
	homeid_get_template('header');
}

add_action('homeid_before_page_wrapper_content', 'homeid_template_header', 10);
/**
 * Footer template
 */
function homeid_template_footer()
{
	homeid_get_template('footer');
}

add_action('homeid_after_page_wrapper_content', 'homeid_template_footer', 10);

/**
 * Content Wrapper Start
 */
function homeid_template_wrapper_start()
{
	homeid_get_template('global/wrapper-start');
}

add_action('homeid_main_wrapper_content_start', 'homeid_template_wrapper_start', 10);

/**
 * Content Wrapper End
 */
function homeid_template_wrapper_end()
{
	homeid_get_template('global/wrapper-end');
}

add_action('homeid_main_wrapper_content_end', 'homeid_template_wrapper_end', 10);

/**
 * Archive content layout
 */
function homeid_template_archive_content()
{
	homeid_get_template('archive/layout');
}

add_action('homeid_archive_content', 'homeid_template_archive_content', 10);

/**
 * Single content layout
 */
function homeid_template_single_content()
{
	homeid_get_template('single/layout');
}

add_action('homeid_single_content', 'homeid_template_single_content', 10);

/**
 * Single content layout
 */
function homeid_template_page_content()
{
	homeid_get_template('page/layout');
}

add_action('homeid_page_content', 'homeid_template_page_content', 10);

/**
 * Search content layout
 */
function homeid_template_search_content()
{
	homeid_get_template('search/layout');
}

add_action('homeid_search_content', 'homeid_template_search_content', 10);

/**
 * 404 content layout
 */
function homeid_template_404_content()
{
	homeid_get_template('404/layout');
}

add_action('homeid_404_content', 'homeid_template_404_content', 10);

function homeid_template_page_title()
{
	homeid_get_template('page-title');
}

add_action('homeid_before_main_content', 'homeid_template_page_title', 10);


add_action('elementor/theme/after_do_header', 'homeid_site_start');
function homeid_site_start() {
    homeid_get_template('global/site-start');
}

add_action('elementor/theme/before_do_footer', 'homeid_site_end');
function homeid_site_end() {
    homeid_get_template('global/site-end');
}