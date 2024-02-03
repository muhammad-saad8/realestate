<?php
add_action('vc_after_init', 'g5element_vc_custom_responsive_add_param');
function g5element_vc_custom_responsive_add_param() {
	$shortcodes = apply_filters('g5element_vc_custom_responsive_add_param', array(
		'vc_row',
		'vc_section',
		'vc_row_inner',
		'vc_column_text',
		'vc_separator',
		'vc_text_separator',
		'vc_message',
		'vc_facebook',
		'vc_tweetmeme',
		'vc_googleplus',
		'vc_pinterest',
		'vc_toggle',
		'vc_single_image',
		'vc_gallery',
		'vc_images_carousel',
		'vc_tta_tabs',
		'vc_tta_tour',
		'vc_tta_accordion',
		'vc_custom_heading',
		'vc_cta',
		'vc_posts_slider',
		'vc_video',
		'vc_gmaps',
		'vc_raw_html',
		'vc_raw_js',
		'vc_flickr',
		'vc_progress_bar',
		'vc_pie',
		'vc_round_chart',
		'vc_line_chart',
		'vc_wp_search',
		'vc_wp_meta',
		'vc_wp_recentcomments',
		'vc_wp_calendar',
		'vc_wp_pages',
		'vc_wp_tagcloud',
		'vc_wp_custommenu',
		'vc_wp_text',
		'vc_wp_posts',
		'vc_wp_links',
		'vc_wp_categories',
		'vc_wp_archives',
		'vc_wp_rss',
		'vc_empty_space'
	));

	foreach ($shortcodes as $shortcode) {
		vc_add_param($shortcode, g5element_vc_map_add_responsive());
	}
}

add_filter(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'g5element_vc_custom_animation_add_param_filter_tag', 10, 3);
function g5element_vc_custom_animation_add_param_filter_tag($css_class, $shortcode, $atts) {
	if (isset($atts['responsive']) && !empty($atts['responsive'])) {
		$css_class = $css_class . ' ' . $atts['responsive'];
	}
	return $css_class;
}