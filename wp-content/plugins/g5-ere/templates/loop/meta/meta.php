<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $meta
 * @var $separate
 */
$index           = 0;
$length          = count( $meta );
?>
<ul class="g5ere__loop-property-meta">
	<?php foreach ( $meta as $k => $v ): ?>
		<li class="<?php echo esc_attr( $k ) ?>" data-toggle="tooltip" title="<?php echo esc_attr($v['title'])?>">
			<?php if (isset($v['icon'])): ?>
				<?php echo wp_kses_post($v['icon'])?>
			<?php endif; ?>
			<?php echo wp_kses_post($v['content'] ) ?>
		</li>
		<?php if ( $separate && $index < $length - 1 ): ?>
			<li class="g5ere-divider"></li>
		<?php endif; ?>
		<?php $index ++; ?>
	<?php endforeach; ?>
</ul>
