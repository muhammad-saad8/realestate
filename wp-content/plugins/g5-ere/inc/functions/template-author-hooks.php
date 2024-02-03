<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 *
 * @see g5ere_template_author_name - 5
 * @see g5ere_template_loop_author_position - 10
 * @see g5ere_template_author_meta - 15
 *
 */
add_action( 'g5ere_author_info', 'g5ere_template_author_name', 5 );
add_action( 'g5ere_author_info', 'g5ere_template_loop_author_position', 10 );
add_action( 'g5ere_author_info', 'g5ere_template_author_meta', 15 );
/**
 *
 * @see g5ere_template_author_social - 5
 *
 */
add_action( 'g5ere_author_info_bottom', 'g5ere_template_author_social', 30 );
