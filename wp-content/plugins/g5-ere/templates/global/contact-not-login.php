<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<p class="g5ere__account-sign-in"><?php esc_html_e( 'Please login or register to view contact information for this agent/owner', 'g5-ere' ); ?>
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#ere_signin_modal">
		<?php esc_html_e( 'Login', 'g5-ere' ); ?>
    </button>
</p>
