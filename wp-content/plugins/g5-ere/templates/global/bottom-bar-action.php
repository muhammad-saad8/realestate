<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * @var $email
 * @var $phone
 * @var $css
 */
$wrapper_classes = array(
	'g5ere__single-bottom-bar',
	'position-fixed',
	'fixed-bottom',
	'bg-white'
);

if ( ! empty( $css ) ) {
	$wrapper_classes[] = $css;
}
$wrapper_class = implode( ' ', $wrapper_classes );
$tel           = preg_replace( "/\s+/", "", $phone );
?>
<div class="<?php echo esc_attr( $wrapper_class ) ?>">
	<div class="row no-gutters p-2 g5ere__sbb-inner">
		<?php if ( isset( $email ) && ! empty( $email ) ): ?>
			<div class="col-6 g5ere__sbb-item">
				<a href="#" class="btn btn-block" data-toggle="modal"
				   data-target="#g5ere__modal_messenger"><i class="fal fa-comment"></i><span><?php echo esc_html__( 'Send Message', 'g5-ere' ) ?></span></a>
			</div>
		<?php endif; ?>
		<?php if ( isset( $phone ) && ! empty( $phone ) ): ?>
			<?php
			$tel     = preg_replace( "/\s+/", "", $phone );
			$tel_url = 'tel:' . $tel;
			?>
			<div class="col-6 g5ere__sbb-item">
				<a href="<?php echo esc_url($tel_url)?>" class="btn btn-block"><i class="fal fa-phone"></i><span><?php echo esc_html__('Call','g5-ere')?></span></a>
			</div>
		<?php endif; ?>
	</div>
</div>