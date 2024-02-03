<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $image_size
 * @var $image_ratio
 * @var $post_class
 * @var $post_inner_class
 * @var $placeholder
 * @var $post_inner_attributes
 * @var $image_mode
 * @var $excerpt_enable
 * @var $post_layout
 */
$thumbnail_data = g5core_get_thumbnail_data( array(
    'image_size'  => $image_size,
    'placeholder' => $placeholder
));
if ($thumbnail_data['url'] !== '') {
    $post_class .= ' g5blog__has-post-featured';
}
?>
<article <?php post_class( $post_class ) ?>>
    <div <?php echo join( ' ', $post_inner_attributes ) ?> class="<?php echo esc_attr( $post_inner_class ); ?>">
	    <div class="g5core__post-featured g5blog__post-featured g5core__post-featured-bg-gradient">
		    <?php g5core_render_thumbnail_markup( array(
			    'image_size'         => $image_size,
			    'image_ratio' => $image_ratio,
			    'image_mode' => $image_mode,
			    'placeholder' => $placeholder
		    ) ); ?>
		    <?php do_action('g5blog_after_loop_post_thumbnail', $post_layout); ?>

		    <div class="g5blog__post-content g5core__loop-content">
			    <?php
			    /**
			     * Hook: g5blog_after_loop_post_thumbnail_content_grid_4.
			     *
			     * @hooked g5blog_template_loop_post_meta - 5
			     * @hooked g5blog_template_post_title - 10
			     */
			    do_action('g5blog_after_loop_post_thumbnail_content_grid_4',$post_layout)
			    ?>
		    </div>

	    </div>
        <div class="g5blog__post-content">
	        <?php
	        /**
	         * Hook: g5blog_loop_post_content_grid_04.
	         *
	         * @hooked g5blog_template_loop_excerpt - 15
	         */
	        do_action('g5blog_loop_post_content', $post_layout);
	        ?>
        </div>
    </div>
</article>
