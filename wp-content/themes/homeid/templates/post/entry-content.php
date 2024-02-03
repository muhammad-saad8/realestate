<?php
$entry_content_class = is_singular() ? 'entry-content' : 'entry-excerpt';
?>
<div class="<?php echo esc_attr($entry_content_class) ?>">
	<?php
	if (is_singular()):
		the_content();

		wp_link_pages( array(
			'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages: ', 'homeid' ) . '</span>',
			'after'  => '</div>',
			'link_before' => '<span class="page-links-text">',
			'link_after' => '</span>',
		) );
	else:
		the_excerpt();
	endif;
	?>
</div><!-- .entry-content -->
