<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$property_floors = g5ere_get_property_floors( array( 'property_id' => $property_id ) );

if ( is_array( $property_floors ) && count( $property_floors ) > 0 ):?>
    <div class="g5ere__property-print-block g5ere__property-print-block-floors">
        <h3 class="g5ere__property-print-block-title">
			<?php esc_html_e( 'Floor Plans', 'g5-ere' ) ?>
        </h3>

		<?php $index = 0; ?>
		<?php foreach ( $property_floors as $floor ):
			$image_id = $floor[ ERE_METABOX_PREFIX . 'floor_image' ]['id'];
			$image_src = '';
			$get_image_src = wp_get_attachment_image_src( $image_id, 'full' );
			if ( is_array( $get_image_src ) && count( $get_image_src ) > 0 ) {
				$image_src = $get_image_src[0];
			}
			$floor_size          = $floor[ ERE_METABOX_PREFIX . 'floor_size' ];
			$floor_size_postfix  = $floor[ ERE_METABOX_PREFIX . 'floor_size_postfix' ];
			$floor_bathrooms     = $floor[ ERE_METABOX_PREFIX . 'floor_bathrooms' ];
			$floor_price         = $floor[ ERE_METABOX_PREFIX . 'floor_price' ];
			$floor_price_postfix = $floor[ ERE_METABOX_PREFIX . 'floor_price_postfix' ];
			$floor_bedrooms      = $floor[ ERE_METABOX_PREFIX . 'floor_bedrooms' ];
			$floor_description   = $floor[ ERE_METABOX_PREFIX . 'floor_description' ];
			?>
            <div class="card g5ere__property_floors-item">
                <div class="card-header bg-transparent"
                     id="g5ere__floor-title-<?php echo esc_attr( $index ); ?>">
                    <div class="g5ere__property_floors-item-heading d-flex justify-content-between align-items-center">
                        <h3 class="g5ere__property_floors-title mb-0">
							<?php echo ! empty( $floor[ ERE_METABOX_PREFIX . 'floor_name' ] ) ? sanitize_text_field( $floor[ ERE_METABOX_PREFIX . 'floor_name' ] ) : ( esc_html__( 'Floor', 'g5-ere' ) . ' ' . ( $index + 1 ) ) ?>
                        </h3>
                        <ul class="list-inline g5ere__property_floors-details mb-0">
							<?php if ( isset( $floor_size ) && ! empty( $floor_size ) ): ?>
                                <li class="list-inline-item">
                                    <span class="label"><?php esc_html_e( 'Size:', 'g5-ere' ); ?></span>
                                    <span class="value"><?php echo sanitize_text_field( $floor_size ); ?>
										<?php echo ( isset( $floor_size_postfix ) && ! empty( $floor_size_postfix ) ) ? sanitize_text_field( $floor_size_postfix ) : '' ?>
								</span>
                                </li>
							<?php endif; ?>
							<?php if ( isset( $floor_bedrooms ) && ! empty( $floor_bedrooms ) ): ?>
                                <li class="list-inline-item">
                                    <span class="label"><?php esc_html_e( 'Bedrooms:', 'g5-ere' ); ?></span>
                                    <span class="value"><?php echo sanitize_text_field( $floor_bedrooms ); ?></span>
                                </li>
							<?php endif; ?>
							<?php if ( isset( $floor_bathrooms ) && ! empty( $floor_bathrooms ) ): ?>
                                <li class="list-inline-item">
                                    <span class="label"><?php esc_html_e( 'Bathrooms:', 'g5-ere' ); ?></span>
                                    <span class="value"><?php echo sanitize_text_field( $floor_bathrooms ); ?></span>
                                </li>
							<?php endif; ?>

							<?php if ( isset( $floor_price ) && ! empty( $floor_price ) ): ?>
                                <li class="list-inline-item">
                                    <span class="label"><?php esc_html_e( 'Price:', 'g5-ere' ); ?></span>
                                    <span class="value"><?php echo ere_get_format_money( $floor_price ); ?><?php echo ( isset( $floor_price_postfix ) && ! empty( $floor_price_postfix ) ) ? ' / ' . sanitize_text_field( $floor_price_postfix ) : '' ?></span>
                                </li>
							<?php endif; ?>
                        </ul>
                    </div>
                </div>
                <div id="g5ere__floor-<?php echo esc_attr( $index ); ?>">
                    <div class="card-body">
						<?php if ( ! empty( $image_src ) ): ?>
                            <div class="g5ere__property-floor-image">
                                <a class="d-block text-center"
                                   href="<?php echo esc_url( $image_src ) ?>">
                                    <img src="<?php echo esc_url( $image_src ) ?>"
                                         alt="<?php echo esc_attr( the_title_attribute() ) ?>">
                                </a>
                            </div>
						<?php endif; ?>
						<?php if ( isset( $floor_description ) && ! empty( $floor_description ) ): ?>
                            <div class="g5ere__property-floor-description">
                                <p><?php echo esc_html( $floor_description ); ?></p>
                            </div>
						<?php endif; ?>
                    </div>
                </div>
            </div>
			<?php $index ++; ?>
		<?php endforeach; ?>
    </div>
<?php endif; ?>