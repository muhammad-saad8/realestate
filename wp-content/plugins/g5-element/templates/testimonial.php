<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $layout_style
 * @var $rating
 * @var $align
 * @var $content_background
 * @var $show_main_content
 * @var $main_content
 * @var $content_bg_color
 * @var $author_name
 * @var $author_job
 * @var $author_bio
 * @var $author_avatar
 * @var $img_style
 * @var $img_size
 * @var $author_link
 * @var $name_typography
 * @var $job_typography
 * @var $content_typography
 * @var $main_content_typography
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $responsive
 * @var $category
 * @var $content_quote
 * Shortcode class
 * @var $this WPBakeryShortCode_GSF_Testimonials
 */

$layout_style = $rating = $align = $content_quote = $content_background =
$content_bg_color = $author_name = $author_job = $author_bio = $main_content =
$author_avatar = $img_style = $img_size = $author_link = $dots = $nav = $nav_position =
$nav_style = $name_typography = $job_typography = $content_typography = $autoplay =
$autoplay_timeout = $css_animation = $animation_duration = $main_content_typography =
$show_main_content = $animation_delay = $el_class = $css = $responsive = '';

$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

G5ELEMENT()->assets()->enqueue_assets_for_shortcode('testimonial');

$image_html = '';
$image_width = '';
if (!empty($author_avatar)) {
	$image_id = preg_replace('/[^\d]/', '', $author_avatar);
	$image_html = wp_get_attachment_image($image_id,'full');
	if ($img_size === 'img-size-origin') {
		$image_attr =  wp_get_attachment_image_src($image_id,'full');
		list( $image_src, $image_width, $image_height ) = $image_attr;
	}

}

$author_link = trim($author_link);
$testimonial_class = 'gel-' . uniqid();
$testimonial_css = '';
if (!empty($image_width)) {
	$testimonial_css = <<<CSS
	.{$testimonial_class} {
		--gel-testimonial-image-size: {$image_width}px;
	}
CSS;
	G5Core()->custom_css()->addCss($testimonial_css);
}



if ($content_bg_color != '') {
	if (!g5core_is_color($content_bg_color)) {
		$content_bg_color = g5core_get_color_from_option($content_bg_color);
	}
	$content_text_color = g5core_color_contrast($content_bg_color);
	$testimonial_css = <<<CSS
		.{$testimonial_class} .testi-quote {
		    padding-left: 1.625rem;
		    padding-right: 1.625rem;
		    background-color: $content_bg_color;
			color: $content_text_color;
		}
		.{$testimonial_class} .triangle-up{
			border-bottom:10px solid $content_bg_color;
			margin-top: 1.25rem;
		}
		.{$testimonial_class} .triangle-down{
			border-top:10px solid $content_bg_color;
			margin-bottom: 1.25rem;
		}
CSS;
	G5Core()->custom_css()->addCss($testimonial_css);

	if ($layout_style === 'style-01') {
		$testimonial_css = <<<CSS
		.testimonial-style-01.{$testimonial_class} .author-info  {
		    padding-left: 1.625rem;
		    padding-right: 1.625rem;
		    padding-bottom: 0;
		}
CSS;
		G5Core()->custom_css()->addCss($testimonial_css);
	}

	if ($layout_style === 'style-03') {
		$testimonial_css = <<<CSS
		.testimonial-style-03.{$testimonial_class} .author-info  {
		    padding-left: 1.625rem;
		    padding-right: 1.625rem;
		}
CSS;
		G5Core()->custom_css()->addCss($testimonial_css);
	}

	if ($layout_style === 'style-01' || $layout_style === 'style-03') {
		$testimonial_css = <<<CSS
		.{$testimonial_class} .testi-quote {
			padding-top: 30px;
			padding-bottom: 33px;
		}
CSS;
		G5Core()->custom_css()->addCss($testimonial_css);
	}

	if ($layout_style === 'style-04' || $layout_style === 'style-02') {
		$testimonial_css = <<<CSS
			.{$testimonial_class} .testi-quote {
				padding-top: 31px;
			}
CSS;
		G5Core()->custom_css()->addCss($testimonial_css);
	}

	if ($layout_style === 'style-02') {
		$testimonial_css = <<<CSS
			.testimonial-style-02.{$testimonial_class}  .author-info {
				padding-left: 1.625rem;
		        padding-right: 1.625rem;
			}
CSS;
		G5Core()->custom_css()->addCss($testimonial_css);
	}

	if ($layout_style === 'style-04') {
		$testimonial_css = <<<CSS
			.testimonial-style-04.{$testimonial_class} .author-info {
				padding-left: 1.625rem;
		        padding-right: 1.625rem;
			}
CSS;
		G5Core()->custom_css()->addCss($testimonial_css);
	}

	if ($layout_style === 'style-05') {
		$testimonial_css = <<<CSS
			.{$testimonial_class} .testi-quote {
				padding-bottom: 2rem;
				padding-top: 1.875rem;
			}
			.testimonial-style-05.{$testimonial_class} .author-avatar{
				margin-left: 1.5625rem;
		        margin-right: 1.5625rem;
		        padding-bottom: 0;
			}
CSS;
		G5Core()->custom_css()->addCss($testimonial_css);
	}
}

$name_class = array(
	'gel-testimonial-name',
);
$name_typography = g5element_typography_class($name_typography);
if ($name_typography !== '') {
	$name_class[] = $name_typography;
}

$job_class = array(
	'gel-testimonial-job',
);
$job_typography = g5element_typography_class($job_typography);
if ($job_typography !== '') {
	$job_class[] = $job_typography;
}

$content_typography = g5element_typography_class($content_typography);
if ($content_quote === 'on') {
	if ($content_typography !== '') {
		$bio_class = array($content_typography, 'gel-testimonial-bio', 'content-quote');
	} else {
		$bio_class = array('gel-testimonial-bio', 'content-quote');
	}
} else {
	if ($content_typography !== '') {
		$bio_class = array($content_typography, 'gel-testimonial-bio');
	} else {
		$bio_class = array(
			'gel-testimonial-bio',
		);
	}
}

$content_main_class = array(
	'gel-testimonial-main-content',
);
$main_content_typography = g5element_typography_class($main_content_typography);
if ($main_content_typography !== '') {
	$content_main_class[] = $main_content_typography;
}

$wrapper_classes = array(
	'gel-testimonial',
	'testimonial-' . $layout_style,
	$img_style,
	$img_size,
	'align-' . $align,
	$testimonial_class,
	$this->getExtraClass($el_class),
	$this->getCSSAnimation($css_animation),
	vc_shortcode_custom_css_class($css),
	$responsive
);

$class_to_filter = implode(' ', array_filter($wrapper_classes));
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);
?>
<div class="<?php echo esc_attr($css_class) ?>">
	<?php G5ELEMENT()->get_template('testimonial/' . $layout_style . '.php', array(
		'align' => $align,
		'testimonial_class' => $testimonial_class,
		'rating' => $rating,
		'author_name' => $author_name,
		'author_job' => $author_job,
		'author_bio' => $author_bio,
		'show_main_content' => $show_main_content,
		'main_content' => $main_content,
		'author_avatar' => $author_avatar,
		'author_link' => $author_link,
		'name_class' => $name_class,
		'job_class' => $job_class,
		'image_src' => $image_html,
		'bio_class' => $bio_class,
		'content_main_class' => $content_main_class,
		'content_bg_color' => $content_bg_color,
	)); ?>
</div>
