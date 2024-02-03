<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
$single_tag_enable = G5BLOG()->options()->get_option('single_post_tag_enable');
$single_share_enable = G5BLOG()->options()->get_option('single_post_share_enable');
?>
<?php if (($single_tag_enable === 'on' && has_tag()) || ($single_share_enable === 'on')): ?>
    <div class="g5blog__single-meta-bottom">
        <?php
        /**
         * @hooked - g5blog_single_meta_tag 10
         * @hooked - g5blog_single_meta_share 20
         */
        do_action('g5blog_single_meta_bottom');
        ?>
    </div>
<?php endif; ?>
