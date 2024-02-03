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
?>
<article <?php post_class( $post_class ) ?>>
	<div <?php echo join( ' ', $post_inner_attributes ) ?> class="<?php echo esc_attr( $post_inner_class ); ?>">
		<?php g5blog_template_post_title(); ?>
	</div>
</article>
