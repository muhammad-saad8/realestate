<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $property_term_label WP_Term[]
 */
?>
<div class="g5ere__loop-property-badge g5ere__lpb-label">
	<?php foreach ($property_term_label as $item): ?>
		<?php $label_color = get_term_meta( $item->term_id, 'property_label_color', true ); ?>
		<span style="background-color: <?php echo esc_attr($label_color)?>" class="g5ere__property-badge g5ere__term-label"><?php echo esc_html($item->name)?></span>
	<?php endforeach; ?>
</div>
