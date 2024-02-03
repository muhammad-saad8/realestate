<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$image = get_post_thumbnail_id( $property_id );

?>
<div class="g5ere__single-property-featured-image card border-0 <?php if ( $image ) {
	echo 'has-image';
} ?>">
	<?php
	if ( $image ):
		g5ere_render_thumbnail_markup( array(
			'image_size'        => 'full',
			'image_ratio'       => '',
			'image_mode'        => 'image',
			'image_id'          => $image,
			'display_permalink' => false
		) );
	endif; ?>
    <div class="property-link-api">
        <img class="qr-image"
             src="https://chart.googleapis.com/chart?chs=100x100&cht=qr&chl=<?php echo esc_url( get_permalink( $property_id ) ); ?>&choe=UTF-8"
             title="<?php echo esc_attr( get_the_title( $property_id ) ); ?>"/>
    </div>
</div>



