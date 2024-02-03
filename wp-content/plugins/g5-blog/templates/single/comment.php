<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
if ( comments_open() || get_comments_number() ) {
    comments_template();
}