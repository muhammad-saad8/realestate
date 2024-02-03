<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $address
 * @var $google_map_address_url
 * @var $title
 * @var $icon
 */
$wrapper_classes = array(
	'g5ere__loop-agency-meta',
	'g5ere__loop-agency-address'
);
if ($title) {
	$wrapper_classes[] = 'g5ere__lam-has-title';
}

if ($icon) {
	$wrapper_classes[] = 'g5ere__lam-has-icon';
}
$wrapper_class = implode(' ', $wrapper_classes);
$wrapper_class   = implode( ' ', $wrapper_classes );
?>
<div class="<?php echo esc_attr( $wrapper_class ) ?>">
	<?php if ($title) : ?>
		<span class="g5ere__lam-label mr-1"><?php esc_html_e( 'Address', 'g5-ere' ) ?></span>
	<?php endif; ?>
	<?php if ($icon) : ?>
		<span class="g5ere__lam-icon mr-1"><i class="fal fa-map-marker-alt"></i></span>
	<?php endif; ?>
	<span class="g5ere__lam-content">
		<a title="<?php echo esc_attr($address) ?>" target="_blank" href="<?php echo esc_url($google_map_address_url); ?>"><?php echo esc_html($address) ?></a>
	</span>
</div>