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
	'g5ere__spg-slider-center',
	'slick-slider',
	'g5ere__slick-dots-absolute',
	'g5ere__slick-arrows-absolute',
	"g5core__gutter-0"
);

if ($custom_class !== '') {
	$wrapper_classes[] = $custom_class;
}
$gallery_id = uniqid();
$wrapper_class = implode(' ', $wrapper_classes);
?>
<div class="<?php echo esc_attr($wrapper_class)?>" data-slick-options="<?php echo esc_attr(json_encode($slick_options)) ?>">
	<?php foreach ($property_gallery as $image) {
		g5ere_render_single_thumbnail_markup( array(
			'image_size'  => $image_size,
			'image_ratio' => $image_ratio,
			'image_mode'  => $image_mode,
			'image_id' => $image,
			'gallery_id' => $gallery_id,
		) );
	} ?>
</div>
