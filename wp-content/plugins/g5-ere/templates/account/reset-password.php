<?php
/**
 * Created by G5Theme.
 * User: trungpq
 * Date: 01/11/16
 * Time: 5:11 PM
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$register_url =  ere_get_permalink('register');
wp_enqueue_script( ERE_PLUGIN_PREFIX . 'login' );
?>
<div class="ere-resset-password-wrap">
    <div class="ere_messages message ere_messages_reset_password"></div>
    <h2 class="card-title"><?php esc_html_e( 'Forgot your password?', 'g5-ere' ); ?></h2>
    <p class="card-text"><?php esc_html_e( 'Don’t have an account yet?', 'g5-ere' ); ?>
        <a href="<?php echo esc_url( $register_url ) ?>" class="link-signup">
            <u><?php esc_html_e( 'Sign up for free', 'g5-ere' ); ?></u></a></p>
    <form method="post" enctype="multipart/form-data">
        <div class="form-group control-username">
            <input name="user_login" class="form-control control-icon reset_password_user_login"
                   placeholder="<?php esc_attr_e( 'Enter your username or email', 'g5-ere' ); ?>">
            <input type="hidden" name="ere_security_reset_password"
                   value="<?php echo wp_create_nonce( 'ere_reset_password_ajax_nonce' ); ?>"/>
            <input type="hidden" name="action" value="ere_reset_password_ajax">
			<?php if ( ere_enable_captcha( 'reset_password' ) ) {
				do_action( 'ere_generate_form_recaptcha' );
			} ?>
        </div>
	    <?php

	    /**
	     * Fires inside the lostpassword form tags, before the hidden fields.
	     *
	     * @since 2.1.0
	     */
	    do_action( 'lostpassword_form' );

	    ?>
        <button type="submit" class="btn btn-accent btn-block ere_forgetpass"><?php esc_html_e( 'Get new password', 'g5-ere' ); ?></button>

    </form>
</div>

