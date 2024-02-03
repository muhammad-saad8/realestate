<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$thumbnail_data = g5ere_get_property_thumbnail_data( array(
	'image_size' => 'full'
) );
if ( $thumbnail_data['url'] !== '' ) {
	$custom_css = <<<CSS
    .g5ere__single-property-featured-container {
        background-image: url("{$thumbnail_data['url']}");
    }
CSS;
	G5CORE()->custom_css()->addCss( $custom_css );

}
$wrapper_classes = array(
	'g5ere__single-property-featured',
	'g5ere__single-featured',
	'position-relative'
);
$wrapper_class   = implode( ' ', $wrapper_classes );
$id              = uniqid( 'g5ere__spg-' );

?>
<div class="<?php echo esc_attr( $wrapper_class ) ?>">
    <div class="tab-content" id="<?php echo esc_attr( $id ) ?>-tabContent">
        <div class="tab-pane fade show active" id="<?php echo esc_attr( $id ) ?>-gallery" role="tabpanel"
             aria-labelledby="<?php echo esc_attr( $id ) ?>-gallery-tab">
            <div class="g5ere__single-property-featured-container">
                <div class="container">
                    <div class="g5ere__single-meta-top">
						<?php
						/**
						 *
						 * @hooked g5ere_template_property_title - 13
						 * @hooked g5ere_template_property_address - 14
						 * @hooked g5ere_template_property_price - 15
						 */
						do_action( 'g5ere_single_property_meta_top_layout_5' );
						?>
                    </div>
                </div>
            </div>
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



