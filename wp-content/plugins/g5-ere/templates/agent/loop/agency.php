<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $title
 */
$title    = isset( $title ) ? $title : false;
if ($title) {
	echo get_the_term_list(get_the_ID(),'agency','<div class="g5ere__loop-agent-meta g5ere__lam-has-title g5ere__loop-agent-agency"><span class="g5ere__laa-label mr-1">'. esc_html__('Company Agent at','g5-ere') .'</span> <span class="g5ere__laa-content">',', ', '</span></div>');
} else {
	echo get_the_term_list(get_the_ID(),'agency','<div class="g5ere__loop-agent-meta g5ere__loop-agent-agency">',', ', '</div>');
}

