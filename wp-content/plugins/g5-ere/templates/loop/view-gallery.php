<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $property_gallery
 * @var $property_gallery_count
 */
?>
<a data-toggle="tooltip" title="<?php echo esc_attr(sprintf( __( '(%s) Photos', 'g5-ere' ), $property_gallery_count)) ; ?>" class="g5ere__view-gallery" data-g5core-mfp data-gallery="<?php echo esc_attr(json_encode($property_gallery))?>" href="#"><i class="fal fa-images"></i></a>
