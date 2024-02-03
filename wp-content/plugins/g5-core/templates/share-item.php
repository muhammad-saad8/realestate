<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $attributes
 * @var $icon
 * @var $title
 */
?>
<a <?php echo join(' ', $attributes)?>>
	<i class="<?php echo esc_attr($icon); ?>"></i>
</a>
