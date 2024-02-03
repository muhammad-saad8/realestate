<?php
/**
 * Created by G5Theme.
 * User: trungpq
 * Date: 01/01/16
 * Time: 5:11 PM
 * @var $atts
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $wp;
$current_url = ere_get_permalink('dashboard');
if ($current_url === false) {
	$current_url = home_url('/');
}
if ( isset( $_GET['redirect_to'] ) && $_GET['redirect_to'] != '' ) {
	$redirect_url = urldecode( $_GET['redirect_to'] );
} else {
	$redirect_url = urldecode( $current_url );
}

$register_url =  ere_get_permalink('register');
wp_enqueue_script( ERE_PLUGIN_PREFIX . 'login' );
?>
<div class="card border-0 ere-login-wrap g5ere__login">
    <div class="card-body">
        <div class="ere_messages message"></div>
        <h2 class="card-title g5ere_card-title"><?php esc_html_e( 'Log In', 'g5-ere' ); ?></h2>
        <p class="card-text g5ere__card-text"><?php esc_html_e( 'Don’t have an account yet?', 'g5-ere' ); ?>
            <a href="<?php echo esc_url( $register_url ) ?>" class="link-signup">
                <u><?php esc_html_e( 'Sign up for free', 'g5-ere' ); ?></u></a></p>
        <form class="form ere-login" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label><?php esc_html_e( 'Username or email address', 'g5-ere' ); ?></label>
                <input name="user_login" class="form-control control-icon login_user_login"
                       placeholder="<?php esc_attr_e( 'Username or email address', 'g5-ere' ); ?>" type="text"/>

            </div>
            <div class="form-group">
                <label><?php esc_html_e( 'Password', 'g5-ere' ); ?></label>
                <div class="input-group input-group-lg">
                    <input name="user_password" class="form-control g5ere-password"
                           placeholder="<?php esc_attr_e( 'Password', 'g5-ere' ); ?>" type="password"/>
                    <div class="input-group-append g5ere-show-password">
                                                <span class="input-group-text border-0">
                                                    <i class="far fa-eye"></i>
                                                </span>
                    </div>
                </div>
            </div>
	        <?php
	        /**
	         * Fires following the 'Password' field in the login form.
	         *
	         * @since 2.1.0
	         */
	        do_action( 'login_form' );
	        ?>
            <div class="d-flex form-group">
                <div class="form-check pl-0">
                    <label class="checkbox-label">
                        <input name="remember" type="checkbox">
						<?php esc_html_e( 'Remember me', 'g5-ere' ); ?>
                    </label>
                </div>
                <a href="javascript:void(0)"
                   class="ere-reset-password ml-auto"><u><?php esc_html_e( 'Lost password', 'g5-ere' ) ?></u></a>
            </div>
            <input type="hidden" name="ere_security_login"
                   value="<?php echo wp_create_nonce( 'ere_login_ajax_nonce' ); ?>"/>
            <input type="hidden" name="action" value="ere_login_ajax">

			<?php if ( ere_enable_captcha( 'login' ) ) {
				do_action( 'ere_generate_form_recaptcha' );
			} ?>
            <button type="submit" data-redirect-url="<?php echo esc_url( $redirect_url ); ?>"
                    class="ere-login-button btn btn-accent btn-block"><?php esc_html_e( 'Login', 'g5-ere' ); ?></button>
        </form>
    </div>
</div>
<div class="ere-reset-password-wrap card border-0 g5ere__login" style="display: none">
    <div class="card-body">
		<?php echo ere_get_template_html( 'account/reset-password.php' ); ?>
        <a href="javascript:void(0)"
           class="ere-back-to-login"><?php esc_html_e( 'Back to Login', 'g5-ere' ) ?></a>
    </div>

</div>