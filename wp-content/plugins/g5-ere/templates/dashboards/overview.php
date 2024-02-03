<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$ere_property               = new ERE_Property();
$total_properties_published = $ere_property->get_total_my_properties( array(
	'publish'
) );
$total_properties_pending   = $ere_property->get_total_my_properties( array( 'pending' ) );
$total_favorite             = $ere_property->get_total_favorite();
$current_user_id            = get_current_user_id();
$total_review               = g5ere_get_user_comments_count( $current_user_id );
$my_properties_page_link    = ere_get_permalink( 'my_properties' );
$my_favourite_link          = ere_get_permalink( 'my_favorites' );
$my_review_link             = ere_get_permalink( 'review' );
?>
<div class="g5ere__dashboards-overview">
    <div class="row">
        <div class="col-sm-6 col-xl-3">
            <a href="<?php echo esc_url( $my_properties_page_link . '?post_status=publish' ) ?>"
               class="card item publish">
                <div class="card-body row align-items-center">
                    <div class="col-5">
                            <span class="d-flex align-items-center justify-content-center icon">
                               <?php echo g5ere_get_icon_svg( 'house' ); ?>
                            </span>
                    </div>
                    <div class="col-7 text-center">
                        <p class="mb-0 number"><?php echo esc_html( $total_properties_published ) ?></p>
                        <p class="text mb-0"><?php esc_html_e( 'Publish', 'g5-ere' ) ?></p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-xl-3">
            <a href="<?php echo esc_url( $my_properties_page_link . '?post_status=pending' ) ?>"
               class="card item pending">
                <div class="card-body row align-items-center">
                    <div class="col-5">
                            <span class="d-flex align-items-center justify-content-center icon text-warning">
                             <?php echo g5ere_get_icon_svg( 'house' ); ?>
                            </span>
                    </div>
                    <div class="col-7 text-center">
                        <p class="mb-0 number"><?php echo esc_html( $total_properties_pending ) ?></p>
                        <p class="text mb-0"><?php esc_html_e( 'Pending', 'g5-ere' ) ?></p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-xl-3">
            <a href="<?php echo esc_url( $my_review_link ) ?>" class="card item review">
                <div class="card-body row align-items-center">
                    <div class="col-4">
                            <span class="d-flex align-items-center justify-content-center icon">
                               <?php echo g5ere_get_icon_svg( 'review' ); ?>
                            </span>
                    </div>
                    <div class="col-8 text-center">
                        <p class="mb-0 number"><?php echo esc_html( $total_review ) ?></p>
                        <p class="text mb-0"><?php esc_html_e( 'Reviews', 'g5-ere' ) ?></p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-xl-3">
            <a href="<?php echo esc_url( $my_favourite_link ) ?>" class="card item favourites">
                <div class="card-body row align-items-center">
                    <div class="col-5">
                            <span class="d-flex align-items-center justify-content-center icon">
                             <?php echo g5ere_get_icon_svg( 'heart' ); ?>
                            </span>
                    </div>
                    <div class="col-7 text-center">
                        <p class="mb-0 number"><?php echo esc_html( $total_favorite ) ?></p>
                        <p class="text mb-0"><?php esc_html_e( 'Favorites', 'g5-ere' ) ?></p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
