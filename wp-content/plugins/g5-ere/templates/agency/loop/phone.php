<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $phone
 * @var $title
 * @var $icon
 */

$title = isset( $title ) ? $title : false;
$icon  = isset( $icon ) ? $icon : false;
$tel   = 'tel:' . preg_replace( '/\s/', '', $phone );

$wrapper_classes = array(
	'g5ere__loop-agency-meta',
	'g5ere__loop-agency-phone'
);
if ( $title ) {
	$wrapper_classes[] = 'g5ere__lam-has-title';
}

if ( $icon ) {
	$wrapper_classes[] = 'g5ere__lam-has-icon';
}
$wrapper_class = implode( ' ', $wrapper_classes );
if ( $phone != '' ):
	?>
    <div class="<?php echo esc_attr( $wrapper_class ) ?>">
		<?php if ( $title ) : ?>
            <span class="g5ere__lam-label mr-1"><?php esc_html_e( 'Mobile', 'g5-ere' ) ?></span>
		<?php endif; ?>
		<?php if ( $icon ) : ?>
            <span class="g5ere__lam-icon mr-1"><i class="fal fa-phone"></i></span>
		<?php endif; ?>
        <span class="g5ere__lam-content">
		<a href="<?php echo esc_attr( $tel ) ?>"><?php echo esc_html( $phone ) ?></a>
	</span>
    </div>
<?php endif; ?>