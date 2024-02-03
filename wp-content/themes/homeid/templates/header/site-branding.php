<?php
$logo_html = get_custom_logo();
$site_branding_classes = array('site-branding');
$no_logo_prev = sprintf( '<a href="%1$s" class="custom-logo-link" style="display:none;"><img class="custom-logo"/></a>',
	esc_url( home_url( '/' )));
if (!empty($logo_html) && ($no_logo_prev !== $logo_html)) {
	$site_branding_classes[] = 'has-logo';
}
?>
<div class="<?php echo join(' ', $site_branding_classes)?>">
	<?php the_custom_logo(); ?>

	<div class="site-branding-text">
		<?php if ( is_front_page() ) : ?>
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		<?php else : ?>
			<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
		<?php endif; ?>

		<?php $description = get_bloginfo( 'description', 'display' ); ?>
		<?php if ($description || is_customize_preview()): ?>
			<p class="site-description"><?php echo wp_kses_post($description); ?></p>
		<?php endif; ?>
	</div><!-- .site-branding-text -->
</div><!-- .site-branding -->