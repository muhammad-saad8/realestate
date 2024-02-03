<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $title
 * @var $social
 */
$title  = isset( $title ) ? $title : false;

$wrapper_classes = array(
	'g5ere__loop-agency-meta',
	'g5ere__loop-agency-social'
);
if ( $title ) {
	$wrapper_classes[] = 'g5ere__lam-has-title';
}
$wrapper_class = implode( ' ', $wrapper_classes );
?>
<div class="<?php echo esc_attr( $wrapper_class ) ?>">
	<?php if ( $title ) : ?>
		<span class="g5ere__lam-label mr-1"><?php esc_html_e( 'Social', 'g5-ere' ) ?></span>
	<?php endif; ?>
	<ul class="g5ere__agency-social-list list-inline mb-0">
		<?php foreach ( $social as $k => $v ): ?>
			<li class="list-inline-item">
				<a href="<?php echo esc_url( $v['content'] ) ?>" title="<?php echo esc_attr( $v['title'] ) ?>">
					<?php echo wp_kses_post($v['icon'])  ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</div>