<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
if (get_post_type() !== 'attachment') {
    the_post_navigation( array(
        'prev_text' => '<span aria-hidden="true" class="nav-subtitle"><i class="fas fa-angle-left"></i> ' . __( 'Previous', 'g5-blog' ) . '</span><span class="nav-title">%title</span>',
        'next_text' => '<span aria-hidden="true" class="nav-subtitle">' . __( 'Next', 'g5-blog' ) . ' <i class="fas fa-angle-right"></i></span><span class="nav-title">%title</span>',
    ) );
}