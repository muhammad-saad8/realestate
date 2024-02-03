<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * @var $phone
 * @var $property_id
 */
$title                  = get_the_title( $property_id );
$message                = sprintf( esc_html__( 'Hello, I am interested in [%s]', 'g5-ere' ), $title );
$tel = preg_replace( "/\s+/", "", $phone );
$url = 'https://api.whatsapp.com/send?phone=' . $tel . '&text=' . $message;
?>
<div class="g5ere__contact-actions-phone">
	<div class="g5ere__contact-actions-item g5ere__contact-actions-whatsapp">
		<a target="_blank" href="<?php echo esc_url( $url ) ?>"
		   class="btn"><span class="icon mr-2"><i
						class="fab fa-whatsapp"></i></span><?php esc_html_e( 'WhatsApp', 'g5-ere' ) ?>
		</a>
	</div>
</div>
