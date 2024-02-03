<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $image_size
 * @var $image_ratio
 *
 */
$wrapper_classes = array(
	'g5ere__property-slider-item',
	'd-flex',
	'flex-column'

);
$thumbnail_data = g5ere_get_property_thumbnail_data( array(
	'image_size'  => 'full',
	'placeholder' => 'on'
) );

$post_inner_classes = array(
	'g5ere__psi-inner',
	'g5ere__psi-hero',
	'position-relative',
	'text-light',
	'd-flex',
	'align-items-center'
);

$post_inner_attributes = array();

if ( $thumbnail_data['url'] !== '' ) {
	$post_inner_attributes[] = sprintf( 'style="background-image:url(%s)"', esc_url( $thumbnail_data['url'] ) );
}

$post_inner_class = implode( ' ', $post_inner_classes );
$wrapper_class    = implode( ' ', $wrapper_classes );

$gallery_classes = array(
	'g5ere__psi-gallery',
	'g5core__post-featured',
	'slick-slider',
	'g5core__gutter-0'
);

$gallery_class = implode( ' ', $gallery_classes );
$slick_options = apply_filters('g5ere_property_slider_gallery_layout_03',array(
	'dots'   => true,
	'arrows' => false,
	'slidesToScroll' => 1,
	'slidesToShow' =>  1
));
$gallery_id = uniqid();
?>
<article <?php post_class( $wrapper_class ) ?>>
	<div <?php echo join( ' ', $post_inner_attributes ) ?> class="<?php echo esc_attr( $post_inner_class ) ?>">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-4 ">
					<div class="<?php echo esc_attr( $gallery_class ) ?>" data-slick-options="<?php echo esc_attr( json_encode( $slick_options ) ) ?>">
						<?php
						$property_gallery = get_post_meta( get_the_ID(), ERE_METABOX_PREFIX . 'property_images', true );
						if ( $property_gallery !== '' ) {
							$property_gallery = explode( '|', $property_gallery );
							foreach ($property_gallery as $image) {
								g5ere_render_single_thumbnail_markup( array(
									'image_size'  => $image_size,
									'image_ratio' => $image_ratio,
									'image_id' => $image,
									'gallery_id' => $gallery_id,
								) );
							}
						} elseif (has_post_thumbnail()) {
							g5ere_render_single_thumbnail_markup( array(
								'image_size'  => $image_size,
								'image_ratio' => $image_ratio,
							) );
						}
						?>
					</div>
				</div>
				<div class="col-lg-7 offset-lg-1">
					<div class="g5ere__psi-content position-relative">
						<?php
						/**
						 * Hook: g5ere_loop_property_slider_content_layout_03.
						 *
						 * @hooked g5ere_template_loop_property_status - 5
						 * @hooked g5ere_template_loop_property_title - 10
						 * @hooked g5ere_template_loop_property_address - 15
						 * @hooked g5ere_template_loop_property_price - 20
						 */
						do_action( 'g5ere_loop_property_slider_content_layout_03' );
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</article>