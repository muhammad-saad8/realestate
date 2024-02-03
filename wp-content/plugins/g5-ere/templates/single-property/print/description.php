<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$content = get_the_content( null, false, $property_id );
if ( ! empty( $content ) ):
	?>
    <div class="g5ere__property-print-block g5ere__property-print-block-description ">
        <h3 class="g5ere__property-print-block-title">
			<?php esc_html_e( 'Description', 'g5-ere' ) ?>
        </h3>
        <div class="g5ere__property-print-block-body">
			<?php echo wp_kses_post( $content ); ?>
        </div>
    </div>
<?php endif; ?>