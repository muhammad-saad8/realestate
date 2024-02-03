<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $rating
 * @var $count
 * @var $show_count
 * @var $custom_class
 * @var $label
 */
$wrapper_classes = array(
	'g5ere__rating-stars'
);

if ($show_count) {
	$wrapper_classes = array(
		'g5ere__rating'
	);
}
if (!empty($custom_class)) {
	$wrapper_classes[] = $custom_class;
}
$wrapper_class = implode(' ', $wrapper_classes);
?>
<div class="<?php echo esc_attr($wrapper_class)?>" aria-label="<?php echo esc_attr($label)?>">
	<?php if ($show_count): ?>
		<div class="g5ere__rating-stars">
	<?php endif; ?>
	<span class="g5ere__empty-stars">
		<span class="g5ere__star"><i class="far fa-star"></i></span>
		<span class="g5ere__star"><i class="far fa-star"></i></span>
		<span class="g5ere__star"><i class="far fa-star"></i></span>
		<span class="g5ere__star"><i class="far fa-star"></i></span>
		<span class="g5ere__star"><i class="far fa-star"></i></span>
	</span>
	<span class="g5ere__filled-stars" style="width: <?php echo esc_attr( ( ( $rating / 5 ) * 100 ) ) ?>%;">
			<span class="g5ere__star"><i class="fa fa-star"></i></span>
			<span class="g5ere__star"><i class="fa fa-star"></i></span>
			<span class="g5ere__star"><i class="fa fa-star"></i></span>
			<span class="g5ere__star"><i class="fa fa-star"></i></span>
			<span class="g5ere__star"><i class="fa fa-star"></i></span>
	</span>
	<?php if ($show_count): ?>
		</div>
		<span class="g5ere__rating-count ml-1"><?php echo sprintf( _n( '(%s review)', '(%s reviews)', $count,'g5-ere' ), number_format_i18n( $count ) ) ?></span>
	<?php endif; ?>
</div>
