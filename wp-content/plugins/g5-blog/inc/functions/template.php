<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
function g5blog_get_image_sizes($image_sizes)
{
    $image_sizes = wp_parse_args(apply_filters('g5blog_image_sizes',array(
        'blog-widget' => '100x100',
        'blog-single' => '840x470',
        'blog-single-full' => '1170x620',
    )),$image_sizes);
    return $image_sizes;
}
add_filter('g5core_image_sizes','g5blog_get_image_sizes');



function g5blog_template_post_title($args = array() ) {
    $args = wp_parse_args( $args, array(
        'post'   => null
    ) );
    G5BLOG()->get_template('loop/title.php', $args );
}

function g5blog_template_post_meta($args = array() ) {
    $args = wp_parse_args( $args, array(
        'cat'  => false,
        'author'  => false,
        'date'    => false,
        'comment' => false,
        'view' => false,
        'like' => false,
        'edit'    => false
    ) );
    G5BLOG()->get_template( 'loop/meta.php', $args );
}

function g5blog_template_widget_post_meta() {
	g5blog_template_post_meta( apply_filters('g5blog_widget_posts_post_meta_args',array(
		'date'    => true
	)) );
}

function g5blog_template_loop_excerpt() {
	$post_settings = &G5BLOG()->listing()->get_layout_settings();
	$excerpt_enable = isset($post_settings['excerpt_enable']) ? $post_settings['excerpt_enable'] : G5BLOG()->options()->get_option('excerpt_enable');
	if ($excerpt_enable === 'on') {
		G5BLOG()->get_template('loop/post-excerpt.php');
	}
}

function g5blog_template_loop_post_meta($post_layout) {
	global $post;
	if ($post->post_type !== 'post') {
		return;
	}
	$post_meta = array();
	switch ($post_layout) {
		case 'large-image':
			$post_meta = array(
				'author'  => true,
				'date'    => true,
				'comment' => true,
				'view' => true,
				'like' => true,
			);
			break;
		case 'grid':
			$post_meta = array(
				'date'    => true,
				'author'    => true
			);
			break;
		case 'medium-image':
			$post_meta = array(
				'date'    => true,
				'author'    => true
			);
			break;
	}
	g5blog_template_post_meta(apply_filters('g5blog_loop_post_meta_args',$post_meta,$post_layout));
}


function g5blog_template_post_view() {
    G5BLOG()->get_template('loop/post-view.php');
}
function g5blog_template_post_like() {
    G5BLOG()->get_template('loop/post-like.php');
}

function g5blog_template_single_image() {
    G5BLOG()->get_template('single/image.php');
}

function g5blog_template_single_media() {
    G5BLOG()->get_template('single/media.php');
}

function g5blog_template_single_title() {
    G5BLOG()->get_template('single/title.php');
}

function g5blog_template_link_pages() {
    G5BLOG()->get_template('single/link-pages.php');
}

function g5blog_template_single_meta($layout) {
    g5blog_template_post_meta(apply_filters('g5blog_single_meta_args', array(
	    'author'  => true,
	    'date'    => true,
	    'comment' => true,
	    'view' => true,
	    'like' => true
    ),$layout));
}

function g5blog_single_meta_bottom() {
    G5BLOG()->get_template('single/meta-bottom.php');
}

function g5blog_single_meta_tag() {
    $single_tag_enable = G5BLOG()->options()->get_option('single_post_tag_enable');
    if ($single_tag_enable !== 'on' || !has_tag()) return;
    G5BLOG()->get_template('single/meta/tag.php');
}


function g5blog_single_meta_share() {
    $single_share_enable = G5BLOG()->options()->get_option('single_post_share_enable');
    if ($single_share_enable !== 'on') return;
	g5core_template_social_share();
}


function g5blog_template_single_navigation() {
    $single_navigation = G5BLOG()->options()->get_option('single_post_navigation_enable');
    if ($single_navigation !== 'on') return;
    G5BLOG()->get_template('single/navigation.php');
}


function g5blog_template_author_info() {
    $author_info_enable = G5BLOG()->options()->get_option('single_post_author_info_enable');
    if ($author_info_enable !== 'on') return;
    G5BLOG()->get_template('single/author-info.php');
}


function g5blog_template_single_related() {
    if (!is_singular('post')) return;
    $related_enable = G5BLOG()->options()->get_option('single_post_related_enable');
    if ($related_enable !== 'on') return;
    G5BLOG()->get_template('single/related.php');
}


function  g5blog_template_single_comment() {
    G5BLOG()->get_template('single/comment.php');
}

function g5blog_template_breadcrumbs() {
    g5core_template_breadcrumbs('g5blog__single-breadcrumbs');
}