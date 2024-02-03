<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$data = g5ere_get_single_property_block_address_data();
$item_class = apply_filters('g5ere_property_detail_class','col-sm-6 col-12');
?>
<ul class="list-unstyled row g5ere__property-address-list">
	<?php foreach ($data as $k => $v): ?>
		<li class="<?php echo esc_attr($item_class)?> <?php echo esc_attr($k)?>">
			<div class="d-flex g5ere__property-address-item">
				<strong class="mr-2"><?php echo wp_kses_post($v['label'])?></strong>
				<span><?php echo wp_kses_post($v['content'])?></span>
			</div>
		</li>
	<?php endforeach; ?>
</ul>
