<?php
$post_class = is_singular() ? 'article-post article-single-post' : 'article-post article-archive-post';
?>
<article id="post-<?php the_ID(); ?>" <?php post_class($post_class); ?>>
	<?php homeid_get_template('post/entry-thumbnail') ?>
	<header class="entry-header">
		<?php if (is_singular()): ?>
			<?php homeid_get_template('post/entry-cat') ?>
			<?php homeid_get_template('post/entry-title') ?>
			<?php homeid_get_template('post/entry-meta') ?>
		<?php else: ?>
			<?php homeid_get_template('post/entry-meta') ?>
			<?php homeid_get_template('post/entry-title') ?>
		<?php endif; ?>
	</header><!-- .entry-header -->
	<?php homeid_get_template('post/entry-content') ?>
	<?php if (is_singular()): ?>
		<?php homeid_get_template('post/entry-tags') ?>
	<?php else: ?>
		<?php homeid_get_template('post/read-more') ?>
	<?php endif; ?>
</article><!-- #post-## -->