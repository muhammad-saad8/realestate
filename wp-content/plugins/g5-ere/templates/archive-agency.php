<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
defined( 'ABSPATH' ) || exit;

get_header( 'ere' );

/**
 * ere_before_main_content hook.
 *
 * @hooked ere_output_content_wrapper_start - 10 (outputs opening divs for the content)
 */
do_action( 'ere_before_main_content' );


$settings      = array( 'toolbar' => true );
G5ERE()->listing_agency()->render_content( null, $settings );

/**
 * ere_after_main_content hook.
 *
 * @hooked ere_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'ere_after_main_content' );
get_footer( 'ere' );