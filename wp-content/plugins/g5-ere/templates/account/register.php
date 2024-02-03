<?php
/**
 * Created by G5Theme.
 * User: trungpq
 * Date: 01/11/16
 * Time: 5:11 PM
 * @var $atts
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$redirect = 'login';
extract( shortcode_atts( array(
	'redirect' => 'login'
), $atts ) );
$redirect_url = ere_get_permalink( 'login' );
$login_url = ere_get_permalink( 'login' );
if ( $redirect != 'login' ) {
	$redirect_url = '';
}
$register_terms_condition = ere_get_option( 'register_terms_condition' );
$enable_password          = ere_get_option( 'enable_password', 0 );
wp_enqueue_script( ERE_PLUGIN_PREFIX . 'register' );
?>
<div class="ere-register-wrap g5ere__login card border-0">
    <div class="card-body">
        <div class="ere_messages message"></div>
        <h2 class="card-title g5ere_card-title"><?php esc_html_e( 'Sign Up', 'g5-ere' ); ?></h2>
        <p class="card-text g5ere__card-text"><?php esc_html_e( 'Already have an account?', 'g5-ere' ); ?>
            <a href="<?php echo esc_url( $login_url ) ?>" class="link-signup">
                <u><?php esc_html_e( 'Log in', 'g5-ere' ); ?></u></a></p>
        <form class="form ere-register" method="post" enctype="multipart/form-data">
            <div class="form-group control-username">
                <label><?php esc_html_e( 'Username', 'g5-ere' ); ?></label>
                <input name="user_login" class="form-control control-icon" type="text"
                       placeholder="<?php esc_attr_e( 'Username', 'g5-ere' ); ?>"/>
            </div>
            <div class="form-group control-email">
                <label><?php esc_html_e( 'Email', 'g5-ere' ); ?></label>
                <input name="user_email" type="email" class="form-control control-icon"
                       placeholder="<?php esc_attr_e( 'Email', 'g5-ere' ); ?>"/>
            </div>

			<?php if ( $enable_password ) { ?>
                <div class="form-row">
                    <div class="col-sm-6 form-group control-password">
                        <label><?php esc_html_e( 'Password', 'g5-ere' ); ?></label>
                        <input name="user_password" class="form-control control-icon"
                               placeholder="<?php esc_attr_e( 'Password', 'g5-ere' ); ?>"
                               type="password"/>
                    </div>
                    <div class="col-sm-6 form-group control-ere-password">
                        <label><?php esc_html_e( 'Retype Password', 'g5-ere' ); ?></label>
                        <input name="user_password_retype" class="form-control control-icon"
                               placeholder="<?php esc_attr_e( 'Retype Password', 'g5-ere' ); ?>"
                               type="password"/>
                    </div>
                </div>
			<?php } ?>
	        <?php

	        /**
	         * Fires following the 'Email' field in the user registration form.
	         *
	         * @since 2.1.0
	         */
	        do_action( 'register_form' );

	        ?>

            <div class="form-group control-term-condition">
                <div class="checkbox my-0">
                    <label class="mb-0 checkbox-label">
                        <input name="term_condition" type="checkbox">
						<?php echo sprintf( wp_kses( __( 'I agree with your <a target="_blank" href="%s">Terms & Conditions</a>', 'g5-ere' ), array(
							'a' => array(
								'target' => array(),
								'href'   => array()
							)
						) ), get_permalink( $register_terms_condition ) ); ?>
                    </label>
                </div>
            </div>
			<?php if ( ere_enable_captcha( 'register' ) ) {
				do_action( 'ere_generate_form_recaptcha' );
			} ?>
            <input type="hidden" name="ere_register_security"
                   value="<?php echo wp_create_nonce( 'ere_register_ajax_nonce' ); ?>"/>
            <input type="hidden" name="action" value="ere_register_ajax">
            <button type="submit" data-redirect-url="<?php echo esc_url( $redirect_url ); ?>"
                    class="ere-register-button btn btn-accent btn-block"><?php esc_html_e( 'Register', 'g5-ere' ); ?></button>
        </form>
    </div>
</div>
