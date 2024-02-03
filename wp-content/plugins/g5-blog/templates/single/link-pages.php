<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
wp_link_pages( array(
    'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'g5-blog' ) . '</span>',
    'after'  => '</div>',
    'link_before' => '<span class="page-links-text">',
    'link_after' => '</span>',
) );