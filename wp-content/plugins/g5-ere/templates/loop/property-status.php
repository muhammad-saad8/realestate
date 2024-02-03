<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $property_item_status WP_Term[]
 */
?>
<div class="g5ere__loop-property-badge g5ere__lpb-status">
	<?php foreach ($property_item_status as $status): ?>
		<?php $status_color = get_term_meta($status->term_id, 'property_status_color', true);  ?>
		<span style="background-color: <?php echo esc_attr($status_color)?>" class="g5ere__property-badge g5ere__status  <?php echo esc_attr($status->slug)?>">
		<?php echo esc_html($status->name)?>
	</span>
	<?php endforeach; ?>
</div>