<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$video = g5ere_get_property_video();
if ( ! $video ) {
	return;
}
$property_video       = $video['video_url'];
$property_video_image = $video['video_image'];
$image_url            = '';
if ( ! empty( $property_video_image ) ) {
	$image_src = wp_get_attachment_image_src( $property_video_image, 'full' );
	if ( isset( $image_src[0] ) && ! empty( $image_src[0] ) ) {
		$image_url = $image_src[0];
	}
}
$args = array(
	'type'      => 'iframe',
	'mainClass' => 'mfp-fade'
);

?>

<div class="g5ere__property-video">
	<?php if ( wp_oembed_get( $property_video ) ) : ?>
		<?php if ( $image_url != '' ): ?>
            <div class="card border-0">
                <img src="<?php echo esc_url( $image_url ) ?>" class="card-img"
                     alt="<?php echo esc_attr( the_title() ) ?>">
                <a data-g5core-mfp="true" data-mfp-options='<?php echo esc_attr( json_encode( $args ) ) ?>'
                   class="view-video card-img-overlay d-flex align-items-center justify-content-center"
                   href="<?php echo esc_url( $property_video ) ?>">
                        <span class="video-icon">
                           <i class="fas fa-play"></i>
                        </span>
                </a>
            </div>
		<?php else: ?>
            <div class="embed-responsive embed-responsive-16by9 embed-responsive-full">
				<?php echo wp_oembed_get( $property_video, array( 'wmode' => 'transparent' ) ); ?>
            </div>
		<?php endif; ?>
	<?php else : ?>
        <div class="embed-responsive embed-responsive-16by9 embed-responsive-full">
			<?php echo wp_kses_post( $property_video ); ?>
        </div>
	<?php endif; ?>
</div>
