<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $author_Id
 * @var $author_name
 */
?>
<a href="<?php echo get_author_posts_url( $author_Id ); ?>" title="<?php esc_attr_e('Browse Author Articles','homeid') ?>">
	<img alt="<?php the_author() ?>" src="<?php echo esc_url(get_avatar_url(get_the_author_meta('ID'),array('size' => 32))) ?>"><span><?php echo esc_html($author_name); ?></span>
</a>