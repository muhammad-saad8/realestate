<?php
get_header();
while (have_posts()) : the_post(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class('page'); ?>>
		<div class="g5core-vc-template-entry-content clearfix">
			<?php the_content(); ?>
		</div>
	</article>
<?php
endwhile;
get_footer();