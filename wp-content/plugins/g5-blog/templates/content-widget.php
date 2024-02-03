<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
$image_size = 'blog-widget';
$thumbnail_data = g5core_get_thumbnail_data( array(
    'image_size'  => $image_size
));
$post_classes = array(
    'g5blog__post-widget'
);
if ($thumbnail_data['url'] !== '') {
    $post_classes[] = 'g5blog__has-post-featured';
}
$post_class = implode(' ', $post_classes);
?>
<article <?php post_class( $post_class ) ?>>
    <div class="g5blog__post-inner">
        <?php if ( $thumbnail_data['url'] !== '' ): ?>
            <div class="g5core__post-featured g5blog__post-featured">
                <?php g5core_render_thumbnail_markup( array(
                    'image_size'         => $image_size,
	                'image_mode' => 'image'
                ) ); ?>
                <?php do_action('g5blog_after_widget_post_thumbnail'); ?>
            </div>
        <?php endif; ?>
        <div class="g5blog__post-content">
	        <?php
            /**
             * Hook: g5blog_widget_post_content.
             *
             * @hooked g5blog_template_post_title - 5
             * @hooked g5blog_template_widget_post_meta - 10
             */
            do_action('g5blog_widget_post_content');
            ?>

        </div>
    </div>
</article>