<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$enable_register_tab = ere_get_option( 'enable_register_tab', 1 );
?>
<div class="modal modal-login fade g5ere__login-register-modal" id="ere_signin_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content p-0">
            <div class="modal-header align-items-center <?php
			if ( $enable_register_tab == 1 ) {
				echo 'p-0 border-0 g5ere__modal-header-has-register';
			} else {
				echo 'g5ere__modal-header-no-register';
			}
			?>">
				<?php
				if ( $enable_register_tab == 0 ):
					?>
                    <h4 class="modal-title"><?php esc_html_e( 'Log in', 'g5-ere' ); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
				<?php
				else:
					?>
                    <div class="nav nav-tabs order-1 row no-gutters w-100">
                        <a id="ere_login_modal_tab" href="#login" class="nav-link active col col-sm-auto nav-item"
                           data-toggle="tab"><?php esc_html_e( 'Log in', 'g5-ere' ); ?></a>
                        <a id="ere_register_modal_tab" href="#register" class="nav-item col col-sm-auto nav-link"
                           data-toggle="tab"><?php esc_html_e( 'Register', 'g5-ere' ); ?></a>
                        <div class="nav-item col col-sm-auto">
                            <button type="button" class="close nav-link" data-dismiss="modal"
                                    aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                        </div>
                    </div>
				<?php endif; ?>
            </div>
            <div class="modal-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="login">
						<?php echo do_shortcode( '[ere_login redirect="current_page"]' ); ?>
                    </div>
					<?php if ( $enable_register_tab == 1 ): ?>
                        <div class="tab-pane" id="register">
							<?php echo do_shortcode( '[ere_register redirect="login_tab"]' ); ?>
                        </div>
					<?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
