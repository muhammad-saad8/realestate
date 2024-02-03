<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $actions
 */
?>
<ul class="g5ere__property-actions list-inline d-flex align-items-center">
	<?php foreach ( $actions as $k => $v ): ?>
		<li class="<?php echo esc_attr( $k ) ?>">
			<?php if (isset($v['icon'])): ?>
				<?php echo wp_kses_post($v['icon'])?>
			<?php endif; ?>
			<?php echo wp_kses_post($v['content'] ) ?>
		</li>
	<?php endforeach; ?>
</ul>