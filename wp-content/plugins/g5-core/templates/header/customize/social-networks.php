<?php
$socials = G5CORE()->options()->get_option('social_networks');
$social_css = '';
ob_start();
?>
<?php foreach ($socials as $key => $social): $social_id = $social['social_id']?>
	<?php if (!empty($social['social_link'])): ?>
		<li>
			<a class="social-networks-<?php echo esc_attr($social_id) ?>" href="<?php echo esc_attr($social['social_link']) ?>">
				<i class="<?php echo esc_attr($social['social_icon']) ?>"></i>
			</a>
		</li>
		<?php $social_css .= '.g5core-social-networks a.social-networks-' . $social_id . '{ color:' . $social['social_color'] . '}'; ?>
	<?php endif; ?>
<?php endforeach; ?>
<?php
$social_html = ob_get_clean();
G5CORE()->custom_css()->addCss($social_css, 'g5core-social-networks');
?>
<?php if (!empty($social_html)): ?>
	<ul class="g5core-social-networks">
		<?php echo $social_html ?>
	</ul>
<?php endif; ?>
