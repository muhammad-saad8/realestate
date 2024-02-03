<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $email
 * @var $phone
 */
?>
<div class="modal fade modal-messenger" id="g5ere__modal_messenger" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo esc_html__( 'Contact Form','g5-ere' ) ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
				<?php G5ERE()->get_template( "global/contact-form.php", array(
					'email' => $email,
					'phone' => $phone
				) );
				?>
            </div>
        </div>
    </div>
</div>
