<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $property_gallery_layout
 * @var $property_gallery
 * @var $image_size
 * @var $image_ratio
 * @var $image_mode
 * @var $columns_gutter
 * @var $custom_class
 * @var $slick_options
 *
 */
$wrapper_classes = array(
	'g5ere__single-property-galleries',
	"g5ere__spg-wrap-$property_gallery_layout",
	'position-relative'
);

if ($custom_class !== '') {
	$wrapper_classes[] = $custom_class;
}


$wrapper_class   = implode( ' ', $wrapper_classes );
$id              = uniqid( 'g5ere__spg-' );
?>
<div class="<?php echo esc_attr( $wrapper_class ) ?>">
    <div class="tab-content" id="<?php echo esc_attr( $id ) ?>-tabContent">
        <div class="tab-pane fade show active" id="<?php echo esc_attr( $id ) ?>-gallery" role="tabpanel"
             aria-labelledby="<?php echo esc_attr( $id ) ?>-gallery-tab">
			<?php
			G5ERE()->get_template( "single-property/gallery/{$property_gallery_layout}.php", array(
				'property_gallery' => $property_gallery,
				'image_size'       => $image_size,
				'image_ratio'      => $image_ratio,
				'image_mode'       => $image_mode,
				'columns_gutter'   => $columns_gutter,
				'custom_class'     => '',
				'slick_options'    => $slick_options
			) );
			?>
        </div>
        <div class="tab-pane fade" id="<?php echo esc_attr( $id ) ?>-map" role="tabpanel"
             aria-labelledby="<?php echo esc_attr( $id ) ?>-map-tab">
			<?php g5ere_template_single_property_map() ?>
        </div>
    </div>
    <ul class="nav nav-pills position-absolute g5ere__spg-nav" id="<?php echo esc_attr( $id ) ?>" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="<?php echo esc_attr( $id ) ?>-gallery-tab" data-toggle="pill"
               href="#<?php echo esc_attr( $id ) ?>-gallery" role="tab"
               aria-controls="<?php echo esc_attr( $id ) ?>-gallery" aria-selected="true"><i class="fal fa-camera"></i></a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="<?php echo esc_attr( $id ) ?>-map-tab" data-toggle="pill"
               href="#<?php echo esc_attr( $id ) ?>-map" role="tab" aria-controls="<?php echo esc_attr( $id ) ?>-map"
               aria-selected="false"><i class="fal fa-map-marked-alt"></i></a>
        </li>
    </ul>
</div>

