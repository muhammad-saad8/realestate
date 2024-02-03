<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $property
 */
?>
<?php if ( $property->post_status == 'publish' ) : ?>
    <h4 class="g5ere__loop-property-title">
        <a target="_blank"
           title="<?php echo esc_attr( $property->post_title ); ?>"
           href="<?php echo get_permalink( $property->ID ); ?>"><?php echo esc_html( $property->post_title ); ?></a>
    </h4>
<?php else : ?>
    <h4 class="g5ere__loop-property-title"><?php echo esc_html( $property->post_title ); ?></h4>
<?php endif; ?>
