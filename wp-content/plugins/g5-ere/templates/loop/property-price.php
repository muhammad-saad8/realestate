<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $price
 * @var $price_short
 * @var $price_unit
 * @var $price_prefix
 * @var $price_postfix
 * @var $empty_price_text
 */
?>
<?php if ($price !== ''): ?>
	<span class="g5ere__loop-property-price">
		<?php if ($price_prefix !== ''): ?>
			<span class="g5ere__lpp-postfix"><?php echo esc_html($price_prefix)?></span>
		<?php endif; ?>
		<span class="g5ere__lpp-price"><?php echo ere_get_format_money($price_short,$price_unit) ?></span>
		<?php if ($price_postfix !== ''): ?>
			<span class="g5ere__lpp-postfix">/ <?php echo esc_html($price_postfix)?></span>
		<?php endif; ?>
	</span>
<?php elseif ($empty_price_text !== ''): ?>
	<span class="g5ere__loop-property-price">
		<?php echo esc_html($empty_price_text);?>
	</span>
<?php endif; ?>
