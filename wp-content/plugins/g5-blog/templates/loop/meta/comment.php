<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
comments_popup_link('<i class="far fa-comments"></i>' . '<span>' . esc_html__( '0 Comments', 'g5-blog' ). '</span>',
    '<i class="far fa-comment"></i>' . '<span>' . esc_html__( '1 Comment', 'g5-blog' ). '</span>',
    '<i class="far fa-comments"></i><span>% '. esc_html__( 'Comments', 'g5-blog' ) .'</span>');