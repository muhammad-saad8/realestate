<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $licenses
 * @var $title
 * @var $icon
 */
$title = isset( $title ) ? $title : false;
$icon  = isset( $icon ) ? $icon : false;
$wrapper_classes = array(
	'g5ere__loop-agent-meta',
	'g5ere__loop-agent-licenses'
);
if ($title) {
	$wrapper_classes[] = 'g5ere__lam-has-title';
}

if ($icon) {
	$wrapper_classes[] = 'g5ere__lam-has-icon';
}
$wrapper_class = implode(' ', $wrapper_classes);

?>
<div class="<?php echo esc_attr($wrapper_class)?>">
	<?php if ($title) : ?>
		<span class="g5ere__lam-label mr-1"><?php esc_html_e( 'Licenses', 'g5-ere' ) ?></span>
	<?php endif; ?>
	<?php if ($icon) : ?>
		<span class="g5ere__lam-icon mr-1"><i class="fal fa-certificate"></i></span>
	<?php endif; ?>
	<span class="g5ere__lam-content">
		<?php echo esc_html( $licenses ) ?>
	</span>
</div>