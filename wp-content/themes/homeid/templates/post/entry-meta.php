<ul class="entry-meta d-inline-flex align-items-center flex-wrap">
	<li class="meta-author">
		<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) ?>">
			<img alt="<?php the_author() ?>" src="<?php echo esc_url(get_avatar_url(get_the_author_meta('ID'),array('size' => 32))) ?>"><span><?php the_author() ?></span>
		</a>
	</li>

	<li class="meta-date">
		<a href="<?php echo esc_url( get_permalink() ) ?>"><i class="far fa-calendar"></i> <span><?php echo get_the_time( get_option( 'date_format' ) ) ?></span></a>
	</li>
	<?php if (comments_open() || get_comments_number()): ?>
		<li class="meta-comment">
			<?php comments_popup_link( wp_kses_post(__('<i class="far fa-comments"></i> <span>0 Comments</span>','homeid')) ,wp_kses_post(__('<i class="far fa-comment"></i> <span>1 Comment</span>','homeid')),wp_kses_post( __('<i class="far fa-comments"></i> <span>% Comments</span>','homeid'))) ?>
		</li>
	<?php endif; ?>
</ul>