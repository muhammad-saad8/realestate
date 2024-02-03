<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$data       = g5ere_get_single_property_block_details_data( array( 'property_id' => $property_id ) );
$item_class = apply_filters( 'g5ere_property_detail_class', 'col-sm-6 col-12' );
?>
<div class="g5ere__property-print-block g5ere__property-print-block-details">
    <h3 class="g5ere__property-print-block-title">
		<?php esc_html_e( 'Details', 'g5-ere' ) ?>
    </h3>
    <ul class="list-unstyled row g5ere__property-details-list">
		<?php foreach ( $data as $k => $v ): ?>
            <li class="<?php echo esc_attr( $item_class ) ?> <?php echo esc_attr( $k ) ?>">
                <div class="d-flex g5ere__property-detail-item">
                    <strong class="mr-2"><?php echo wp_kses_post($v['label']) ?></strong>
					<?php echo wp_kses_post($v['content'])  ?>
                </div>
            </li>
		<?php endforeach; ?>
    </ul>

</div>

