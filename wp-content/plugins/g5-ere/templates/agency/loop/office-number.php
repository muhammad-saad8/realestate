<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
/**
 * @var $office_number
 * @var $title
 * @var $icon
 */
$title = isset( $title ) ? $title : false;
$icon  = isset( $icon ) ? $icon : false;
$tel   = 'tel:' .  preg_replace('/\s/', '', $office_number);

$wrapper_classes = array(
	'g5ere__loop-agency-meta',
	'g5ere__loop-agency-office-number'
);
if ( $title ) {
	$wrapper_classes[] = 'g5ere__lam-has-title';
}
if ($icon) {
	$wrapper_classes[] = 'g5ere__lam-has-icon';
}

$wrapper_class = implode( ' ', $wrapper_classes );
?>
<div class="<?php echo esc_attr( $wrapper_class ) ?>">
	<?php if ( $title === true ) : ?>
		<span class="g5ere__lam-label mr-1"><?php esc_html_e( 'Office', 'g5-ere' ) ?></span>
	<?php endif; ?>
	<?php if ( $icon === true ) : ?>
		<span class="g5ere__lam-icon mr-1"><i class="fal fa-phone-office"></i></span>
	<?php endif; ?>
	<span class="g5ere__lam-content">
			<a href="<?php echo esc_url( $tel ) ?>"><?php echo esc_html( $office_number ) ?></a>
	</span>
</div>