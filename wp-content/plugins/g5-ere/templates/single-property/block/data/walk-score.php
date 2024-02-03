<?php
/**
 * @var $property_id
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$response = g5ere_get_property_get_walk_score();
if ( $response != '' ) :
	?>
    <div class="g5ere__property-walkscore">
        <div class="walkscore-logo">
            <a href="https://www.walkscore.com" target="_blank">
                <img src="https://cdn.walk.sc/images/api-logo.png"
                     alt="<?php esc_attr_e( 'Walk Scores', 'g5-ere' ); ?>">
            </a>
        </div>
        <ul class="walkscore-list list-unstyled">
			<?php if ( isset( $response['status'] ) && $response['status'] == 1 ) : ?>
				<?php if ( isset( $response['walkscore'] ) ) : ?>
                    <li class="walkscore-list-item d-flex align-items-center">
                        <div
                                class="walkscore-score"><?php echo esc_html( $response['walkscore'] ); ?></div>
                        <div class="walkscore-info">
                            <a href="<?php echo esc_url( $response['ws_link'] ); ?>"
                               class="walkscore-type"><strong><?php esc_html_e( 'Walk Scores', 'g5-ere' ); ?></strong></a>
                            <p class="walkscore-description">
								<?php echo wp_kses_post( $response['description'] ); ?>
                            </p>
                        </div>
                        <a href="<?php echo esc_url( $response['ws_link'] ); ?>"
                           class="walk-score-more-detail"><?php esc_html_e( 'View more', 'g5-ere' ); ?></a>
                    </li>
				<?php endif; ?>
				<?php if ( isset( $response['transit'] ) && ! empty( $response['transit']['score'] ) ) : ?>
                    <li class="walkscore-list-item d-flex align-items-center">
                        <div
                                class="walkscore-score"><?php echo wp_kses_post( $response['transit']['score'] ); ?></div>
                        <div class="walkscore-info">
                            <a href="<?php echo esc_url( $response['ws_link'] ); ?>"
                               class="walkscore-type"><strong><?php esc_html_e( 'Transit Score', 'g5-ere' ); ?></strong></a>
                            <p class="walkscore-description">
								<?php echo wp_kses_post( $response['transit']['description'] ); ?>
                            </p>
                        </div>
                        <a href="<?php echo esc_url( $response['ws_link'] ); ?>"
                           class="walk-score-more-detail"><?php esc_html_e( 'View more', 'g5-ere' ); ?></a>
                    </li>
				<?php endif; ?>

				<?php if ( isset( $response['bike'] ) && ! empty( $response['bike']['score'] ) ) : ?>
                    <li class="walkscore-list-item d-flex align-items-center">
                        <div class="walkscore-score"><?php echo wp_kses_post( $response['bike']['score'] ); ?></div>
                        <div class="walkscore-info">
                            <a href="<?php echo esc_url( $response['ws_link'] ); ?>"
                               class="walkscore-type"><strong><?php esc_html_e( 'Bike Score', 'g5-ere' ); ?></strong></a>
                            <p class="walkscore-description">
								<?php echo wp_kses_post( $response['bike']['description'] ); ?>
                            </p>
                        </div>
                        <a href="<?php echo esc_url( $response['ws_link'] ); ?>"
                           class="walk-score-more-detail"><?php esc_html_e( 'View more', 'g5-ere' ); ?></a>
                    </li>
				<?php endif; ?>

			<?php else: ?>
                <li>
					<?php esc_html_e( 'An error occurred while fetching walk scores.', 'g5-ere' ); ?>
                </li>
			<?php endif; ?>
        </ul>
    </div>
<?php
endif;