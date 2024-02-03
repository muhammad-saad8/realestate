<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $meta
 */
?>
<ul class="g5ere__loop-agency-meta list-unstyled mb-0">
	<?php foreach ( $meta as $k => $v ): ?>
		<li class="<?php echo esc_attr( $k ) ?>">
			<?php if (isset($v['icon'])): ?>
				<?php echo wp_kses_post($v['icon']) ?>
			<?php endif; ?>
			<?php echo wp_kses_post($v['content'] )  ?>
		</li>
	<?php endforeach; ?>
</ul>
