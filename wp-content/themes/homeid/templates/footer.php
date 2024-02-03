<?php
$footer_text = get_theme_mod('footer_text', esc_html__( 'Powered by G5Theme', 'homeid' ));
$enable_private_policy_link = get_theme_mod('enable_private_policy_link', 'on');
$private_link = '';
if (($enable_private_policy_link === 'on') && (function_exists('get_the_privacy_policy_link'))) {
	$private_link = get_the_privacy_policy_link();
}
if (empty($footer_text) && empty($private_link)) {
	return;
}

?>
<footer id="site-footer" class="site-footer">
	<?php do_action('homeid-site-footer') ?>
	<div class="site-footer-bottom">
		<div class="container">
			<div class="site-info">
				<div class="container">
					<?php if (!empty($private_link)): ?>
					<?php echo wp_kses_post($private_link)?>
					<?php endif; ?>
					<?php if (!empty($footer_text)): ?>
						<span class="powered-by"><?php echo do_shortcode(wp_kses_post($footer_text)); ?></span>
					<?php endif; ?>
				</div>
			</div><!-- .site-info -->
		</div><!-- .container -->
	</div>
</footer><!-- #site-footer -->