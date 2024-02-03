<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * @var $count
 * @var $rating
 * @var $rating_data
 */
$col_class = 'col-md-6';
$col_class = apply_filters( 'g5ere_single_rating_col_classes', $col_class )
?>
<div class="g5ere__review-rating-wrap">
    <div class="row">
        <div class="<?php echo esc_attr( $col_class ) ?>">
            <div class="g5ere__rating-avarage">
                <h3 class="comments-title g5ere__review-title">
                    <span><?php esc_html_e( 'Avarage User Rating', 'g5-ere' ) ?></span></h3>
                <div class="g5ere__ra-content">
                    <div class="g5ere__ra-number"><strong><?php echo esc_html( $rating ) ?></strong><span>/ 5</span>
                    </div>
					<?php g5ere_template_star_rating( array(
						'rating'       => $rating,
						'count'        => $count,
						'custom_class' => 'g5ere__ra-rating'
					) ); ?>
                </div>
            </div>
        </div>
        <div class="<?php echo esc_attr( $col_class ) ?>">
            <div class="g5ere__rating-breakdown">
                <h3 class="comments-title g5ere__review-title">
                    <span><?php esc_html_e( 'Rating Breakdown', 'g5-ere' ) ?></span></h3>
                <ul class="g5ere__rb-list list-unstyled">
					<?php for ( $i = 5; $i >= 1; $i -- ): ?>
						<?php $percent = $rating_data[ $i ] > 0 && $count > 0 ? ( round( ( $rating_data[ $i ] / $count ) * 100, 2 ) ) : 0; ?>
                        <li class="d-flex align-items-center">
							<?php g5ere_template_star_rating_icon( $i ); ?>
                            <div class="g5ere__rbl-progress progress flex-grow-1 ml-3">
                                <div class="progress-bar bg-warning" role="progressbar"
                                     style="width: <?php echo esc_attr( $percent ) ?>%"
                                     aria-valuenow="<?php echo esc_attr( $percent ) ?>" aria-valuemin="0"
                                     aria-valuemax="100"></div>
                            </div>
                            <span class="g5ere__rbl-label"><?php echo esc_html( $percent ) ?>%</span>
                        </li>
					<?php endfor; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

