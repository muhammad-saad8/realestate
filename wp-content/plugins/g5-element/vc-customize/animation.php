<?php
add_action('vc_after_init', 'g5element_vc_custom_animation_add_param');
function g5element_vc_custom_animation_add_param() {
	$shortcodes = apply_filters('g5element_vc_custom_animation_add_param', array(
		'vc_row',
		'vc_section',
		'vc_column',
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
		'vc_video',
		'vc_gmaps',
		'vc_flickr',
		'vc_progress_bar',
		'vc_pie',
		'vc_round_chart',
		'vc_line_chart'
	));

	foreach ($shortcodes as $shortcode) {
		vc_remove_param($shortcode, 'css_animation');
		$params = array(
			g5element_vc_map_add_css_animation(),
			g5element_vc_map_add_animation_duration(),
			g5element_vc_map_add_animation_delay(),
		);
		vc_add_params($shortcode, $params);
	}
}

add_filter(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'g5element_vc_custom_animation_filter_tag', 10, 3);
function g5element_vc_custom_animation_filter_tag($css_class, $shortcode, $atts) {
	if (isset($atts['css_animation']) && isset($atts['animation_duration']) && isset($atts['animation_delay']) && ('' !== $atts['css_animation']) && ('none' !== $atts['css_animation'])) {
		$animation_class = g5element_vc_custom_animation_get_class($atts['animation_duration'], $atts['animation_delay']);
		$css_class = $css_class . ' ' . $animation_class;
	}
	return $css_class;
}

/**
 * Get Animation custom class
 *
 * @param $animation_duration
 * @param $animation_delay
 *
 * @return string
 */
function g5element_vc_custom_animation_get_class($animation_duration, $animation_delay)
{
	$animation_attributes = array();
	if ($animation_duration != '0' && !empty($animation_duration)) {
		$animation_duration = (float)trim($animation_duration, "\n\ts");
		$animation_attributes[] = "-webkit-animation-duration: {$animation_duration}s !important";
		$animation_attributes[] = "-moz-animation-duration: {$animation_duration}s !important";
		$animation_attributes[] = "-ms-animation-duration: {$animation_duration}s !important";
		$animation_attributes[] = "-o-animation-duration: {$animation_duration}s !important";
		$animation_attributes[] = "animation-duration: {$animation_duration}s !important";
	}
	if ($animation_delay != '0' && !empty($animation_delay)) {
		$animation_delay = (float)trim($animation_delay, "\n\ts");
		$animation_attributes[] = "-webkit-animation-delay: {$animation_delay}s !important";
		$animation_attributes[] = "-moz-animation-delay: {$animation_delay}s !important";
		$animation_attributes[] = "-ms-animation-delay: {$animation_delay}s !important";
		$animation_attributes[] = "-o-animation-delay: {$animation_delay}s !important";
		$animation_attributes[] = "animation-delay: {$animation_delay}s !important";
	}

	$animation_class = '';
	if ($animation_attributes) {
		$animation_css = implode('; ', array_filter($animation_attributes));


		$animation_class = 'g5element-animation-' .  hash('md5', "{$animation_duration}-{$animation_delay}");
		$custom_css = <<<CSS
				.{$animation_class} {
					{$animation_css}
				}
CSS;
		G5CORE()->custom_css()->addCss($custom_css, $animation_class);
	}
	return $animation_class;
}