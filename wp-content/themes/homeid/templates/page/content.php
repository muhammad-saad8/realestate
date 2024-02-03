<article id="post-<?php the_ID(); ?>" <?php post_class('article-post'); ?>>
	<div class="entry-content">
		<?php
		the_content();

		wp_link_pages( array(
			'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'homeid' ) . '</span>',
			'after'  => '</div>',
			'link_before' => '<span class="page-links-text">',
			'link_after' => '</span>',
		) );
		?>
	</div>
</article><!-- #post-## -->