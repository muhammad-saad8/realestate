<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $post
 */
global $g5ere_agency;
if ( ! g5ere_agency_visible( $g5ere_agency ) ) {
	return;
}
$link = $g5ere_agency->get_link();
$name = $g5ere_agency->get_name();
?>
<h3 class="g5ere__loop-agency-title">
    <a title="<?php echo esc_attr( $name ) ?>"
       href="<?php echo esc_url( $link ) ?>"><?php echo esc_html( $name ) ?></a>
</h3>