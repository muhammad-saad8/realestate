<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $property_gallery
 * @var $image_size
 * @var $image_ratio
 * @var $image_mode
 * @var $slick_options
 * @var $custom_class
 */

$wrapper_classes = array(
	'g5ere__single-property-gallery',
	'g5ere__spg-thumbnail',
);
if ($custom_class !== '') {
	$wrapper_classes[] = $custom_class;
}
$gallery_id = uniqid();

$slider_main_classes = array(
	'slick-slider',
	'g5ere__spg-slider-main',
	'g5ere__slick-dots-absolute',
	'g5ere__slick-arrows-absolute',
	'g5core__gutter-0'
);

$slider_thumb_classes = array(
	'slick-slider',
	'g5ere__spg-slider-thumb',
	'g5ere__slick-arrows-absolute',
	'g5core__gutter-10'
);

$slick_options['asNavFor'] = '.g5ere__spg-slider-thumb';
$slick_options['fade'] =  true;

$slider_thumb_image_size = G5ERE()->options()->get_option('single_property_gallery_thumb_image_size','thumbnail');
$slider_thumb_slides_to_show = absint(G5ERE()->options()->get_option('single_property_gallery_thumb_slides_to_show',8));
$slider_thumb_slides_to_show_lg = absint(G5ERE()->options()->get_option('single_property_gallery_thumb_slides_to_show_lg'));
$slider_thumb_slides_to_show_md = absint(G5ERE()->options()->get_option('single_property_gallery_thumb_slides_to_show_md'));
$slider_thumb_slides_to_show_sm = absint(G5ERE()->options()->get_option('single_property_gallery_thumb_slides_to_show_sm'));
$slider_thumb_slides_to_show_xs = absint(G5ERE()->options()->get_option('single_property_gallery_thumb_slides_to_show_xs'));
$slick_thumb_options = array(
	'slidesToShow' => $slider_thumb_slides_to_show,
	'slidesToScroll' => $slider_thumb_slides_to_show,
	'arrows' => true,
	'dots' => false,
	'focusOnSelect' => true,
	'asNavFor' => '.g5ere__spg-slider-main',
	'responsive' => array(
	),
);

if ($slider_thumb_slides_to_show_lg > 0) {
	$slick_thumb_options['responsive'][] = array(
		'breakpoint' => 1200,
		'settings' => array(
			'slidesToShow' => $slider_thumb_slides_to_show_lg,
			'slidesToScroll' => $slider_thumb_slides_to_show_lg
		)
	);
}

if ($slider_thumb_slides_to_show_md > 0) {
	$slick_thumb_options['responsive'][] = array(
		'breakpoint' => 992,
		'settings' => array(
			'slidesToShow' => $slider_thumb_slides_to_show_md,
			'slidesToScroll' => $slider_thumb_slides_to_show_md
		)
	);
}

if ($slider_thumb_slides_to_show_sm > 0) {
	$slick_thumb_options['responsive'][] = array(
		'breakpoint' => 768,
		'settings' => array(
			'slidesToShow' => $slider_thumb_slides_to_show_sm,
			'slidesToScroll' => $slider_thumb_slides_to_show_sm
		)
	);
}

if ($slider_thumb_slides_to_show_xs > 0) {
	$slick_thumb_options['responsive'][] = array(
		'breakpoint' => 576,
		'settings' => array(
			'slidesToShow' => $slider_thumb_slides_to_show_xs,
			'slidesToScroll' => $slider_thumb_slides_to_show_xs
		)
	);
}


$slider_main_class = implode(' ', $slider_main_classes);

$slider_thumb_class = implode(' ', $slider_thumb_classes);
$wrapper_class = implode(' ', $wrapper_classes);
?>
<div class="<?php echo esc_attr($wrapper_class)?>">
	<div class="<?php echo esc_attr($slider_main_class)?>" data-slick-options="<?php echo esc_attr(json_encode($slick_options))?>">
		<?php foreach ($property_gallery as $image) {
			g5ere_render_single_thumbnail_markup( array(
				'image_size'  => $image_size,
				'image_ratio' => $image_ratio,
				'image_mode'  => $image_mode,
				'image_id' => $image,
				'gallery_id' => $gallery_id,
			) );
		}?>
	</div>

	<div class="<?php echo esc_attr($slider_thumb_class)?>" data-slick-options="<?php echo esc_attr(json_encode($slick_thumb_options))?>">
		<?php
		$image_size = $slider_thumb_image_size;
		$image_ratio = '';
		$image_mode = 'image';
		foreach ($property_gallery as $image) {
			g5ere_render_thumbnail_markup( array(
				'image_size'  => $image_size,
				'image_ratio' => $image_ratio,
				'image_mode'  => $image_mode,
				'image_id' => $image,
				'display_permalink' => false
			) );
		}?>
	</div>
</div>
