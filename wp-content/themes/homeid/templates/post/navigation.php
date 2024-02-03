<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$previous_post = get_adjacent_post();
$next_post = get_adjacent_post(false,false,false);
$previous_post_thumb_url = '';
$prev_text = '<i class="fal fa-angle-left"></i><h6 class="nav-title">%title</h6>';
$next_text = '<h6 class="nav-title">%title</h6><i class="fal fa-angle-right"></i>';
if (is_a( $previous_post, 'WP_Post' )) {
	if (has_post_thumbnail($previous_post)) {
		$previous_post_thumb_Id = get_post_thumbnail_id($previous_post);
		$previous_post_thumb = wp_get_attachment_image_src($previous_post_thumb_Id,'full');
		if (is_array($previous_post_thumb) && isset($previous_post_thumb[0])) {
			$previous_post_thumb_url = $previous_post_thumb[0];
			$prev_text .= sprintf("<span class='nav-bg' style='background-image: url(%s)'></span>", esc_url($previous_post_thumb_url));
		}
	}
}

$next_post_thumb_url = '';
if (is_a( $next_post, 'WP_Post' )) {
	if (has_post_thumbnail($next_post)) {
		$next_post_thumb_Id = get_post_thumbnail_id($next_post);
		$next_post_thumb = wp_get_attachment_image_src($next_post_thumb_Id,'full');
		if (is_array($next_post_thumb) && isset($next_post_thumb[0])) {
			$next_post_thumb_url = $next_post_thumb[0];
			$next_text .= sprintf("<span class='nav-bg' style='background-image: url(%s)'></span>", esc_url($next_post_thumb_url));
		}
	}
}



the_post_navigation( array(
	'prev_text' => $prev_text,
	'next_text' => $next_text,
) );

