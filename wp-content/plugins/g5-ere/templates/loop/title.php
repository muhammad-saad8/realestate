<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $post
 */
?>
<h3 class="g5ere__loop-property-title">
    <a title="<?php g5core_the_title_attribute( array( 'post' => $post ) ) ?>"
       href="<?php echo esc_url( g5ere_get_property_permalink( $post ) ) ?>"><?php g5core_the_title( $post ) ?></a>
</h3>
