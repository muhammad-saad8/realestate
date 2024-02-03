<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $badge
 * @var $class
 */
$wrapper_classes = array('g5ere__loop-property-badge');
if (isset($class) && !empty($class)) {
	$wrapper_classes[] = $class;
}

$wrapper_class = implode(' ', $wrapper_classes);
?>
<div class="<?php echo esc_attr($wrapper_class)?>">
	<?php foreach ( $badge as $k => $v ): ?>
		<?php echo wp_kses_post($v['content'] ) ?>
	<?php endforeach; ?>
</div>
