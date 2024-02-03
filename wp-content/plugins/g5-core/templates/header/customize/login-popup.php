<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}
$users_can_register = get_option('users_can_register');
$social_login_count = g5core_social_login_count();
?>
<div id="g5core_login_popup" class="g5core__popup g5core-login-popup mfp-hide mfp-with-anim">
	<a href="#" class="back"><i class="fas fa-arrow-left"></i></a>

    <div class="g5core-login-popup-inner popup-login-wrap">
        <div class="popup-login-header">
            <h5 class="popup-login-title"><?php esc_html_e('Sign in','g5-core') ?></h5>
            <div class="popup-login-desc sm-text"><?php esc_html_e('Welcome, Login to your account','g5-core') ?></div>
        </div>
        <div class="popup-login-error"></div>
        <div class="popup-login-body">
            <form data-parsley-validate="" method="post" action="<?php echo esc_url(admin_url('admin-ajax.php') . '?action=g5core-login') ?>">
                <?php wp_nonce_field('g5core_login_nonce','g5core_login_nonce'); ?>
                <div class="form-group">
                    <input type="text" class="form-control" name="log" id="user_login"
                           placeholder="<?php esc_attr_e('Username or Email...','g5-core') ?>"
                           data-parsley-trigger="change"
                           required data-parsley-required-message="<?php esc_attr_e('Please enter a username or email address','g5-core') ?>">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="pwd" id="user_pass" placeholder="<?php  esc_attr_e('Password','g5-core')?>"
                           data-parsley-trigger="change"
                           required data-parsley-required-message="<?php esc_attr_e('Please enter a password','g5-core') ?>">
                </div>
                <div class="form-group form-row align-items-center sm-text">
                    <div class="col-auto mr-auto">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="rememberme" name="rememberme">
                            <label class="custom-control-label" for="rememberme"><?php esc_html_e('Remember me','g5-core') ?></label>
                        </div>
                    </div>
                    <div class="col-auto">
                        <a href="#" class="forgot-pass-link"><?php esc_html_e('Forget password?','g5-core') ?></a>
                    </div>
                </div>
                <div class="form-group login-submit">
                    <button data-style="zoom-out" type="submit" class="btn btn-block btn-primary btn-login"><?php esc_html_e('Login','g5-core') ?></button>
                </div>
                <?php if ($social_login_count): ?>
                    <div class="g5core-social-login-count-<?php echo esc_attr($social_login_count % 2 === 0 ? 'even' : 'odd') ?>">
                        <?php do_action('login_form') ?>
                    </div>
                <?php endif; ?>

                <?php if ($users_can_register): ?>
                    <div class="form-group text-center sm-text">
                        <?php esc_html_e('Don’t have an account?','g5-core') ?> <a class="popup-btn-register fw-bold" href="#"><?php esc_html_e('Sign up now','g5-core') ?></a>
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <?php if ($users_can_register): ?>
        <div class="g5core-login-popup-inner popup-register-wrap">
            <div class="popup-login-header">
                <h5 class="popup-login-title"><?php esc_html_e('Register','g5-core') ?></h5>
                <div class="popup-login-desc sm-text"><?php esc_html_e('Create New Account!','g5-core') ?></div>
            </div>
            <div class="popup-login-error"></div>
            <div class="popup-login-body">
                <form data-parsley-validate="" action="<?php echo esc_url(admin_url('admin-ajax.php') . '?action=g5core-register') ?>">
                    <?php wp_nonce_field('g5core_register_nonce','g5core_register_nonce'); ?>
                    <div class="form-group">
                        <input type="text" class="form-control" name="user_register" id="user_register" placeholder="<?php esc_attr_e('Username','g5-core') ?>" required data-parsley-required-message="<?php esc_attr_e('Please enter a username','g5-core') ?>">
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="user_email" id="user_email" placeholder="<?php  esc_attr_e('Email','g5-core')?>" required data-parsley-required-message="<?php esc_attr_e('Please enter a valid email address','g5-core') ?>">
                    </div>
                    <div class="form-group login-submit">
                        <button data-style="zoom-out" type="submit" class="btn btn-block btn-primary btn-register"><?php esc_html_e('Register','g5-core') ?></button>
                    </div>
                    <?php if ($social_login_count): ?>
                        <div class="g5core-social-login-count-<?php echo esc_attr($social_login_count % 2 === 0 ? 'even' : 'odd') ?>">
                            <?php do_action('register_form') ?>
                        </div>
                    <?php endif; ?>
                    <div class="form-group text-center sm-text">
                        <?php esc_html_e('A password will be e-mailed to you.','g5-core') ?>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <div class="g5core-login-popup-inner popup-forgot-wrap">
        <div class="popup-login-header">
            <h5 class="popup-login-title"><?php esc_html_e('Password Recovery','g5-core') ?></h5>
            <div class="popup-login-desc sm-text"><?php esc_html_e('Recover your password','g5-core') ?></div>
        </div>
        <div class="popup-login-error">
        </div>
        <div class="popup-login-body">
            <form data-parsley-validate="" action="<?php echo esc_url(admin_url('admin-ajax.php') . '?action=g5core-recovery-password') ?>">
                <?php wp_nonce_field('g5core_recovery_password_nonce','g5core_recovery_password_nonce'); ?>
                <div class="form-group">
                    <input type="text" class="form-control" name="user_recovery" id="user_recovery" placeholder="<?php esc_attr_e('Username or Email...','g5-core') ?>"
                           required data-parsley-required-message="<?php esc_attr_e('Please enter a username or email address','g5-core') ?>">
                </div>
                <div class="form-group login-submit">
                    <button data-style="zoom-out" type="submit" class="btn btn-block btn-primary btn-forgot"><?php esc_html_e('Get New Password','g5-core') ?></button>
                </div>
                <div class="form-group text-center sm-text">
                    <?php esc_html_e('A password will be e-mailed to you.','g5-core') ?>
                </div>
            </form>
        </div>
    </div>

</div>