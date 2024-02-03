<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
$single_property_layout         = G5ERE()->options()->get_option( 'single_property_layout', 'layout-1' );
$single_property_content_style         = G5ERE()->options()->get_option( 'single_property_content_block_style', 'style-01' );

$wrapper_classes = array(
	'g5ere__single-content',
	'g5ere__single-property',
	"g5ere__scb-{$single_property_content_style}"
);
?>
<div id="property-<?php the_ID(); ?>" <?php post_class( $wrapper_classes ); ?>>
	<?php if ( $single_property_layout == 'layout-10' ) {
		the_content();
	} else {
		do_action( "g5ere_single_property_summary_{$single_property_layout}" );
	}
	?>
</div>
