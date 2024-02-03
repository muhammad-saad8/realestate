<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$enable_register_tab = ere_get_option( 'enable_register_tab', 1 );

if ( is_user_logged_in() ):
	global $current_user;
	wp_get_current_user();
	$user_login = $current_user->display_name;
	$menus      = g5ere_get_dashboard_menu();

	?>
    <div class="dropdown g5ere__user-dropdown" data-transition="x-fadeInUp">
        <a href="#" class="dropdown-toggle g5ere__user-display-name" data-toggle="dropdown" aria-haspopup="true"
           aria-expanded="false"><i class="far fa-user"></i><span
                    class="d-inline-block ml-2 user-name"><?php echo esc_html( $user_login ); ?></span></a>
        <ul class="g5ere__user-dropdown-menu dropdown-menu dropdown-menu-right x-animated x-fadeInUp">
			<?php foreach ( $menus as $menu ): ?>
                <li class="dropdown-item d-flex align-items-center">
                    <a href="<?php echo esc_url( $menu['url'] ); ?>">
						<?php echo wp_kses_post( $menu['icon'] );
						echo esc_html( $menu['label'] ); ?>
                    </a>
                </li>
			<?php
			endforeach; ?>
			<?php do_action( 'ere_dashboard_navbar', 'login_menu' ); ?>
        </ul>
    </div>
<?php else: ?>
    <div class="g5ere__login-button">
        <a href="#ere_signin_modal"
           title="<?php esc_attr_e( 'Sign in', 'g5-ere' ) ?>"
           data-toggle="modal">
            <i class="far fa-user-circle"></i>
            <span><?php esc_html_e( 'Sign in', 'g5-ere' ) ?></span>
        </a>
    </div>
<?php endif; ?>