<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$data       = g5ere_get_single_property_block_overview_data(array( 'property_id' => $property_id ));
$item_class = apply_filters( 'g5ere_property_overview_class', 'col-md-3 col-sm-6 col-12' );
?>

<div class="g5ere__property-print-block g5ere__property-print-block-overview">
    <h3 class="g5ere__property-print-block-title">
		<?php esc_html_e( 'Overview', 'g5-ere' ) ?>
    </h3>
    <ul class="row list-unstyled g5ere__property-overview-list">
		<?php foreach ( $data as $k => $v ): ?>
            <li class="<?php echo esc_attr( $item_class ) ?> <?php echo esc_attr( $k ) ?>">
                <div class="media g5ere__property-overview-item">
					<?php if ( isset( $v['icon'] ) ): ?>
                        <div class="media-icon mr-2">
							<?php echo wp_kses_post( $v['icon'] ) ?>
                        </div>
					<?php endif; ?>
                    <div class="media-body d-flex flex-column">
                        <span><?php echo wp_kses_post( $v['label'] ) ?></span>
                        <strong><?php echo wp_kses_post( $v['content'] ) ?></strong>
                    </div>
                </div>
            </li>
		<?php endforeach; ?>
    </ul>
</div>