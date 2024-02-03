<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $rating
 */
?>
<div class="g5ere__rating-icon-stars">
	<?php for ($i = 1; $i <= 5; $i ++): ?>
		<?php $icon_class = ( $i <= $rating ) ? 'fa fa-star' : 'far fa-star'; ?>
		<span class="<?php echo esc_attr($icon_class)?>"></span>
	<?php endfor; ?>
</div>
