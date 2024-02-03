<?php
/**
 * The template for displaying site loading
 */
$loading_animation = G5CORE()->options()->get_option('loading_animation');
if (empty($loading_animation)) return;
$logo_loading = G5CORE()->options()->get_option('loading_logo');
?>
<div class="g5core-site-loading">
	<div class="g5core-site-loading-inner">
		<?php if (isset($logo_loading['url']) && !empty($logo_loading['url'])): ?>
			<img class="logo-loading" alt="<?php esc_attr_e('Logo Loading','g5-core') ?>" src="<?php echo esc_url($logo_loading['url']) ?>" />
		<?php endif; ?>
		<?php G5CORE()->get_template("loading/{$loading_animation}.php") ?>
	</div>
</div>