<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
?>
<div class="g5blog__single-wrap">
    <article id="post-<?php the_ID(); ?>" <?php post_class('g5blog__single'); ?>>
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
        <div class="entry-content clearfix">
            <?php
            the_content();
            g5blog_template_link_pages();
            ?>
        </div>
        <?php
        /**
         * @hooked - g5blog_single_meta_bottom - 10
         */
        do_action('g5blog_after_single_content');
        ?>
    </article>
    <?php
    /**
     * @hooked - g5blog_template_single_navigation - 10
     * @hooked - g5blog_template_author_info - 15
     * @hooked - g5blog_template_single_related - 20
     * @hooked - g5blog_template_single_comment - 25
     */
    do_action('g5blog_after_single');
    ?>
</div>