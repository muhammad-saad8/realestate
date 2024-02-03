<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$single_agency_layout        = G5ERE()->options()->get_option( 'single_agency_layout', 'layout-1' );
$single_agency_content_style = G5ERE()->options()->get_option( 'single_agency_content_block_style', 'style-01' );
$content_classes = array(
	'g5ere__single-content',
	'g5ere__single-agency',
	"g5ere__single-agency-$single_agency_layout",
	"g5ere__scb-{$single_agency_content_style}"
);
$content_class = implode( ' ', apply_filters( 'g5ere_single_agency_content_classes', $content_classes ) );
?>
<div <?php post_class( $content_classes ); ?>>
	<?php
	/**
	 * Hook: g5ere_single_agency_summary
	 *
	 * @see g5ere_template_single_agency_content_block
	 */
	do_action( "g5ere_single_agency_summary" );
	?>
</div>