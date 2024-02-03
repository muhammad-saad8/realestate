<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $layout
 */
$thumbnail_data = g5core_get_thumbnail_data( array(
    'image_size'  => 'full'
));

if ($thumbnail_data['url'] !== '') {
    $custom_css =<<<CSS
    .g5blog__single-featured-container {
        background-image: url("{$thumbnail_data['url']}");
    }
CSS;
    G5CORE()->custom_css()->addCss($custom_css);

}


?>
<div class="g5core__post-featured g5blog__single-featured">
    <div class="container">
        <div class="g5blog__single-featured-container">
            <div class="g5blog__single-meta-top">
                <?php
                /**
                 * Hook: g5blog_loop_post_content.
                 *
                 * @hooked g5blog_template_single_title - 5
                 * @hooked g5blog_template_single_meta - 10
                 */
                do_action('g5blog_single_meta_top', $layout);
                ?>
            </div>
        </div>
    </div>
</div>
