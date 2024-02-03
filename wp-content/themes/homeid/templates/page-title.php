<div class="page-header">
	<div class="container">
		<div class="page-header-inner">
			<?php homeid_the_breadcrumbs(); ?>
			<?php if ( ( is_home() && ! is_front_page() ) || ( is_page() ) ): ?>
				<div class="page-main-title"><?php echo homeid_get_page_title() ?></div>
			<?php else: ?>
				<h1 class="page-main-title"><?php echo homeid_get_page_title() ?></h1>
			<?php endif; ?>
			<?php if ( is_archive() ): ?>
				<?php the_archive_description( '<div class="page-sub-title">', '</div>' ); ?>
			<?php endif; ?>
		</div>
	</div>
</div>
