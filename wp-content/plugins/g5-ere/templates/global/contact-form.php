<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $email
 * @var $phone
 */
if ( $email == '' ) {
	return;
}
$message = '';
if ( is_singular( 'property' ) ) {
	$title   = get_the_title();
	$message = sprintf( esc_html__( 'Hello, I am interested in [%s]', 'g5-ere' ), $title );
}
?>
<div class="g5ere__contact-form-wrapper">
    <form action="#" method="POST" class="g5ere__contact-form" novalidate>
        <input type="hidden" name="target_email" value="<?php echo esc_attr( $email ); ?>">
		<?php if ( is_singular( 'property' ) ): ?>
            <input type="hidden" name="property_url" value="<?php echo get_permalink(); ?>">
		<?php endif; ?>
        <div class="g5ere__contact-form-fields">
            <div class="form-group form-group-name">
                <input required class="form-control" name="sender_name" type="text"
                       placeholder="<?php esc_attr_e( 'Full Name', 'g5-ere' ); ?> *">
                <div class="invalid-feedback"><?php esc_html_e( 'Please enter your Name!', 'g5-ere' ); ?></div>
            </div>
            <div class="form-group form-group-phone">
                <input required class="form-control" name="sender_phone" type="text"
                       placeholder="<?php esc_attr_e( 'Phone Number', 'g5-ere' ); ?> *">
                <div class="invalid-feedback"><?php esc_html_e( 'Please enter your Phone!', 'g5-ere' ); ?></div>
            </div>
            <div class="form-group form-group-email">
                <input required class="form-control" name="sender_email" type="email"
                       placeholder="<?php esc_attr_e( 'Email Address', 'g5-ere' ); ?> *">
                <div class="invalid-feedback"><?php esc_html_e( 'Please enter your valid Email!', 'g5-ere' ); ?></div>
            </div>
            <div class="form-group form-group-message">
                <textarea required class="form-control" name="sender_msg" rows="4"
                          placeholder="<?php esc_attr_e( 'Message', 'g5-ere' ); ?> *"><?php echo esc_textarea( $message ) ?></textarea>
                <div class="invalid-feedback"><?php esc_html_e( 'Please enter your Message!', 'g5-ere' ); ?></div>
            </div>
        </div>
        <input type="hidden" name="action" value="ere_contact_agent_ajax">
        <input type="hidden" name="ere_security_contact_agent"
               value="<?php echo esc_attr( wp_create_nonce( 'ere_contact_agent_ajax_nonce' ) ) ?>">
	    <?php $enable_whatsapp_button = G5ERE()->options()->get_option( 'contact_agent_whatsapp_button_enable', '' );
	    if ( $enable_whatsapp_button === 'on' ) {
		    $action_classes = 'g5ere__contact-actions g5ere__contact-actions-col';
	    } else {
		    $action_classes = 'g5ere__contact-actions';
	    }?>
        <div class="<?php echo esc_attr($action_classes)?>">
			<?php
			if ( is_singular( 'property' ) || is_singular( 'agent' ) ) {
				if ( ere_enable_captcha( 'contact_agent' ) ) {
					do_action( 'ere_generate_form_recaptcha' );
				}
			} else {
				if ( ere_enable_captcha( 'contact_agency' ) ) {
					do_action( 'ere_generate_form_recaptcha' );
				}
			}
			?>
            <div class="g5ere__contact-actions-item g5ere__contact-actions-send-message">
                <button type="submit"
                        class="g5ere__submit-contact-agent btn btn-accent btn-block"><?php esc_html_e( 'Send message', 'g5-ere' ); ?></button>
            </div>
			<?php if ( isset( $phone ) && $phone != '' ):
				$tel = preg_replace( "/\s+/", "", $phone );
				$url = 'https://api.whatsapp.com/send?phone=' . $tel . '&text=' . $message;
				?>
                <div class="g5ere__contact-actions-phone">
					<?php if ( $enable_whatsapp_button !== '' ): ?>
                        <div class="g5ere__contact-actions-item g5ere__contact-actions-whatsapp">
                            <a target="_blank" href="<?php echo esc_url( $url ) ?>"
                               class="btn btn-outline btn-accent btn-block"><span class="icon mr-2"><i
                                            class="fab fa-whatsapp"></i></span><?php esc_html_e( 'WhatsApp', 'g5-ere' ) ?>
                            </a>
                        </div>
					<?php endif; ?>
                    <div class="g5ere__contact-actions-item g5ere__contact-actions-call">
                        <a target="_blank" href="tel:<?php echo esc_attr( $tel ) ?>"
                           class="btn btn-outline btn-accent btn-block"><span class="icon mr-2"><i
                                        class="fal fa-phone"></i></span><?php esc_html_e( 'Call', 'g5-ere' ) ?></a>
                    </div>
                </div>
			<?php endif; ?>
        </div>
        <div class="g5ere__contact-form-messages"></div>
    </form>
</div>

