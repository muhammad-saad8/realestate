<?php
/**
 * @var $atts
 * @var $layout_style
 * @var $link
 * @var $text
 * @var $size
 * @var $video_color
 * @var $icon_bg_color_hover
 * @var $icon_color_hover
 * @var $css
 * @var $el_class
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * Shortcode class
 * @var $this WPBakeryShortCode_G5Element_Video
 */

$layout_style = $text = $link = $size = $video_color = $text_option = '';
$css_animation = $animation_duration = $animation_delay = $el_class = $css = '';

$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

G5ELEMENT()->assets()->enqueue_assets_for_shortcode('video');

$wrapper_classes = array(
	'gel-video',
	'gel-video-' . $layout_style,
	'gel-video-' . $size,
	$this->getExtraClass($el_class),
	$this->getCSSAnimation($css_animation),
	vc_shortcode_custom_css_class($css),
);

$video_text_classes = array('gel-video-text');

$text_typography_class = g5element_typography_class($text_option);
if ($text_typography_class !== '') {
	$video_text_classes[] = $text_typography_class;
}

$video_class = 'gel-' . uniqid();
$video_css = '';

if ($video_color !== '') {
	if (!g5core_is_color($video_color)) {
		$video_color = g5core_get_color_from_option($video_color);
	}

	if ($video_color !== '') {
		$video_color_contract = g5core_color_contrast($video_color);
		$video_color_icon = g5core_color_darken($video_color, '10%');
		$video_color_icon_hover = g5core_color_contrast($video_color_icon);

		$video_css = <<<CSS
		.{$video_class} .view-video {
            color: {$video_color};
        }
        .{$video_class} .view-video:hover {
            color: $video_color_icon;
        }
		.{$video_class} .view-video i {
			color: {$video_color_contract};
		}
		.{$video_class} .view-video:hover i {
			color: {$video_color_icon_hover};
		}
		
		.{$video_class}.gel-video-outline .view-video:hover {
			color: {$video_color};
		}
		.{$video_class}.gel-video-outline .view-video:hover i {
			color: {$video_color_contract};
		}
CSS;
		G5Core()->custom_css()->addCss($video_css);
	}
}

$args = array(
	'type' => 'iframe',
	'mainClass' => 'mfp-fade'
);
$wrapper_classes[] = $video_class;
$class_to_filter = implode(' ', array_filter($wrapper_classes));
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);

?>
<div class="<?php echo esc_attr($css_class); ?>">
	<a data-g5core-mfp="true" data-mfp-options='<?php echo esc_attr(json_encode($args)) ?>' class="view-video"
	   href="<?php echo esc_url($link) ?>">
		<i class="fas fa-play"></i>
	</a>
	<?php if ($text !== ''): ?>
		<div class="<?php echo esc_attr(join(' ', $video_text_classes)) ?>"><?php echo esc_html($text) ?></div>
	<?php endif; ?>
</div>