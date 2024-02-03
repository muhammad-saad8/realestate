<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
$single_property_content_style         = G5ERE()->options()->get_option( 'single_agent_content_block_style', 'style-01' );
$wrapper_classes = array(
	'g5ere__single-content',
	'g5ere__single-agent',
	"g5ere__scb-{$single_property_content_style}"
);
?>
<div id="agent-<?php the_ID(); ?>" <?php post_class( $wrapper_classes ); ?>>
	<?php
	/**
	 * Hook: g5ere_single_agent_summary
	 * @see g5ere_template_single_agent_content_block
	 */
	do_action('g5ere_single_agent_summary')
	?>
</div>
