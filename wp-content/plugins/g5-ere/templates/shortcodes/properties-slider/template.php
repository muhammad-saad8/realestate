<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * Shortcode attributes
 * @var $atts
 * @var $layout

 * @var $posts_per_page
 * @var $offset

 * @var $el_id
 * @var $el_class

 * @var $show
 * @var $property_type
 * @var $property_status
 * @var $property_feature
 * @var $property_label
 * @var $property_state
 * @var $property_city
 * @var $property_neighborhood
 * @var $ids
 * @var $sorting
 *
 * @var $height_mode
 * @var $height
 * @var $height_mode_lg
 * @var $height_lg
 * @var $height_mode_md
 * @var $height_md
 * @var $height_mode_sm
 * @var $height_sm
 * @var $height_mode_xs
 * @var $height_xs
 *
 * @var $slider_pagination_enable
 * @var $slider_navigation_enable
 * @var $slider_auto_height_enable
 * @var $slider_loop_enable
 * @var $slider_fade_enable
 * @var $slider_autoplay_enable
 * @var $slider_autoplay_timeout
 * @var $post_image_size
 * @var $post_image_ratio_width
 * @var $post_image_ratio_height
 * @var $animation_style
 * @var $animation_duration
 * @var $animation_delay
 * @var $css_editor
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_G5Element_Properties_Slider
 */
$layout =
$posts_per_page = $offset =
$el_id = $el_class =
$show = $property_type = $property_status = $property_feature = $property_label = $property_state = $property_city = $property_neighborhood = $ids = $sorting =
$height_mode = 	$height = $height_mode_lg = $height_lg = $height_mode_md = $height_md = $height_mode_sm = $height_sm = $height_mode_xs = $height_xs =
$slider_pagination_enable = $slider_navigation_enable = $slider_auto_height_enable = $slider_fade_enable = $slider_loop_enable = $slider_autoplay_enable = $slider_autoplay_timeout =
$post_image_size = $post_image_ratio_width = $post_image_ratio_height =
$animation_style = $animation_duration = $animation_delay = $css_editor = $responsive = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);
$wrapper_classes = array(
	'g5element__properties-slider',
	$this->getExtraClass($el_class),
	$this->getCSSAnimation($css_animation),
	vc_shortcode_custom_css_class($css),
	$layout
);
$query_args = array(
	'post_type' => 'property',
);

$image_ratio = '';
$image_ratio_width = absint($post_image_ratio_width);
$image_ratio_height = absint($post_image_ratio_height);

if (($image_ratio_width > 0) && ($image_ratio_height > 0)) {
	$image_ratio = "{$image_ratio_width}x{$image_ratio_height}";
}

$settings = array(
	'image_size' => $post_image_size,
	'image_ratio' => $image_ratio,
);

$height_options = array(
	'height_mode' => $height_mode,
	'height' => $height,
	'responsive' => array(
	)
);


if ($height_mode_lg !== '') {
	$height_options['responsive'][] = array(
		'breakpoint' => 1200,
		'settings'   => array(
			'height_mode'   => $height_mode_lg,
			'height' => $height_lg
		)
	);
}

if ($height_mode_md !== '') {
	$height_options['responsive'][] = array(
		'breakpoint' => 992,
		'settings'   => array(
			'height_mode'   => $height_mode_md,
			'height' => $height_md
		)
	);
}

if ($height_mode_sm !== '') {
	$height_options['responsive'][] = array(
		'breakpoint' => 768,
		'settings'   => array(
			'height_mode'   => $height_mode_sm,
			'height' => $height_sm
		)
	);
}

if ($height_mode_xs !== '') {
	$height_options['responsive'][] = array(
		'breakpoint' => 576,
		'settings'   => array(
			'height_mode'   => $height_mode_xs,
			'height' => $height_xs
		)
	);
}

$atts['slider'] = true;
$this->prepare_display($atts, $query_args, $settings);
$class_to_filter = implode(' ', array_filter($wrapper_classes));
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->getShortcode(), $atts);
$wrapper_attributes = array();
if (!empty($el_id)) {
	$wrapper_attributes[] = 'id="' . esc_attr($el_id) . '"';
}
$the_query = new WP_Query($this->_query_args);
$slick_options = array(
	'slidesToShow'   => 1,
	'slidesToScroll' => 1,
	'arrows'         => $slider_navigation_enable === 'on',
	'dots'           => $slider_pagination_enable === 'on',
	'infinite'       => $slider_loop_enable === 'on',
	'fade'       => $slider_fade_enable === 'on',
	'adaptiveHeight' => $slider_auto_height_enable === 'on',
	'autoplay'       => $slider_autoplay_enable === 'on',
	'autoplaySpeed'  => absint($slider_autoplay_timeout),
	'draggable' => true,
);

?>
<div class="<?php echo esc_attr($css_class) ?>" <?php echo implode(' ', $wrapper_attributes) ?>>
	<?php if ($the_query->have_posts()): ?>
		<div id="<?php echo esc_attr(uniqid('g5ere__psi'))?>" data-toggle="g5ere__psh" data-g5ere__psh-options="<?php echo esc_attr(json_encode($height_options))?>" class="g5element__properties-slider-inner g5core__gutter-0 slick-slider" data-slick-options="<?php echo esc_attr(json_encode($slick_options))?>">
			<?php while ($the_query->have_posts()): $the_query->the_post(); ?>
				<?php G5ERE()->get_template("shortcodes/properties-slider/layout/{$layout}.php",$settings) ?>
			<?php endwhile; ?>
		</div>
	<?php endif; ?>
	<?php wp_reset_postdata(); ?>
</div>
