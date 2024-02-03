<?php if ( has_post_thumbnail()) : ?>
	<div class="post-thumbnail">
		<a href="<?php the_permalink(); ?>">
			<?php the_post_thumbnail( 'full' ); ?>
		</a>
	</div><!-- .post-thumbnail -->
<?php endif; ?>