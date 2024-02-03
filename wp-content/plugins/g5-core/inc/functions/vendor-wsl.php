<?php
function g5core_wsl_use_squircles_icons( $provider_id, $provider_name, $authenticate_url )
{
	?>
	<a
		rel           = "nofollow"
		href          = "<?php echo esc_url($authenticate_url); ?>"
		data-provider = "<?php echo esc_attr($provider_id) ?>"
		class         = "wp-social-login-provider wp-social-login-provider-<?php echo esc_attr(strtolower( $provider_id )) ?>"
	>
		<i class="fab fa-<?php echo esc_attr(strtolower( $provider_id )) ?>"></i>
		<span><?php echo esc_html($provider_name)?></span>
	</a>
	<?php
}
if ( $GLOBALS['pagenow'] !== 'wp-login.php' ) {
	add_filter( 'wsl_render_auth_widget_alter_provider_icon_markup', 'g5core_wsl_use_squircles_icons', 10, 3 );
}
