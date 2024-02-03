<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$paid_submission_type = ere_get_option( 'paid_submission_type', 'no' );
$allow_submit = ere_allow_submit();
if ( ( ! $allow_submit ) || ( $paid_submission_type != 'per_package' ) ) {
	echo ere_get_template_html( 'global/access-denied.php', array( 'type' => 'not_permission' ) );

	return;
}
?>
<div class="ere-package-wrap">
    <div class="ere-heading g5ere__dashboard-heading">
        <h2><?php esc_html_e( 'Choose the packages that’s right for your business', 'g5-ere' ) ?></h2>
        <p><?php esc_html_e( 'Please select a listing package', 'g5-ere' ) ?></p>
    </div>
    <div class="row">
		<?php
		$args          = array(
			'post_type'      => 'package',
			'posts_per_page' => - 1,
			'orderby'        => 'meta_value_num',
			'meta_key'       => ERE_METABOX_PREFIX . 'package_order_display',
			'order'          => 'ASC',
			'meta_query'     => array(
				array(
					'key'     => ERE_METABOX_PREFIX . 'package_visible',
					'value'   => '1',
					'compare' => '=',
				)
			)
		);
		$data          = new WP_Query( $args );
		$total_records = $data->found_posts;
		if ( $total_records == 4 ) {
			$css_class = 'col-md-3 col-sm-6';
		} else if ( $total_records == 3 ) {
			$css_class = 'col-md-4 col-sm-6';
		} else if ( $total_records == 2 ) {
			$css_class = 'col-md-4 col-sm-6';
		} else if ( $total_records == 1 ) {
			$css_class = 'col-md-4 col-sm-12';
		} else {
			$css_class = 'col-md-3 col-sm-6';
		}
		while ( $data->have_posts() ): $data->the_post();
			$package_id             = get_the_ID();
			$package_time_unit      = get_post_meta( $package_id, ERE_METABOX_PREFIX . 'package_time_unit', true );
			$package_period         = get_post_meta( $package_id, ERE_METABOX_PREFIX . 'package_period', true );
			$package_num_properties = get_post_meta( $package_id, ERE_METABOX_PREFIX . 'package_number_listings', true );
			$package_free           = get_post_meta( $package_id, ERE_METABOX_PREFIX . 'package_free', true );
			if ( $package_free == 1 ) {
				$package_price = 0;
			} else {
				$package_price = get_post_meta( $package_id, ERE_METABOX_PREFIX . 'package_price', true );
			}
			$package_unlimited_listing     = get_post_meta( $package_id, ERE_METABOX_PREFIX . 'package_unlimited_listing', true );
			$package_unlimited_time        = get_post_meta( $package_id, ERE_METABOX_PREFIX . 'package_unlimited_time', true );
			$package_num_featured_listings = get_post_meta( $package_id, ERE_METABOX_PREFIX . 'package_number_featured', true );
			$package_featured              = get_post_meta( $package_id, ERE_METABOX_PREFIX . 'package_featured', true );

			if ( $package_period > 1 ) {
				$package_time_unit .= 's';
			}
			if ( $package_featured == 1 ) {
				$is_featured = ' active';
			} else {
				$is_featured = '';
			}
			$payment_link         = ere_get_permalink( 'payment' );
			$payment_process_link = add_query_arg( 'package_id', $package_id, $payment_link );
			?>
            <div class="<?php echo esc_attr( $css_class ); ?>">
                <div class="card ere-package-item g5ere__package <?php echo esc_attr( $is_featured ); ?>">
                    <div class="card-header bg-transparent p-0">
						<?php if ( $package_featured == 1 ): ?>
                            <span class="text-white text-uppercase custom-packages"><?php esc_html_e( 'Popular', 'g5-ere' ); ?></span>
						<?php endif; ?>
                        <div class="ere-package-title">
                            <strong><?php the_title(); ?></strong> <?php esc_html_e( 'pack', 'g5-ere' ) ?>
                        </div>
                        <h2 class="ere-package-price">
							<?php
							if ( $package_price > 0 ) {
								echo ere_get_format_money( $package_price, '', 0, true );
							} else {
								esc_html_e( 'Free', 'g5-ere' );
							}
							?>
                        </h2>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-unstyled g5ere__package-details">
	                        <?php do_action('g5ere_before_package_details', $package_id) ?>
                            <li class="d-flex align-items-center">
                                <label class="mr-auto label">
									<?php esc_html_e( 'Expiration Date', 'g5-ere' ); ?>
                                </label>
                                <span class="value">
                                <?php if ( $package_unlimited_time == 1 ) {
	                                esc_html_e( 'Never Expires', 'g5-ere' );
                                } else {
	                                echo esc_html( $package_period ) . ' ' . ERE_Package::get_time_unit( $package_time_unit );
                                }
                                ?>
                            </span>
                            </li>
                            <li class="d-flex align-items-center">
                                <label class="mr-auto label"><?php esc_html_e( 'Property Listing', 'g5-ere' ); ?></label>
                                <span class="value">
                                    <?php if ( $package_unlimited_listing == 1 ) {
	                                    esc_html_e( 'Unlimited', 'g5-ere' );
                                    } else {
	                                    echo esc_html( $package_num_properties );
                                    } ?>
                                </span>
                            </li>
                            <li class="d-flex align-items-center">
                                <label class="mr-auto label"><?php esc_html_e( 'Featured Listings', 'g5-ere' ); ?></label>
                                <span
                                        class="value"><?php echo esc_html( $package_num_featured_listings ); ?></span>
                            </li>
	                        <?php do_action('g5ere_after_package_details', $package_id) ?>
                        </ul>
                        <div class="ere-package-choose">
                            <a href="<?php echo esc_url( $payment_process_link ); ?>"
                               class="btn btn-accent btn-block d-flex justify-content-between align-items-center"><?php esc_html_e( 'Choose this pack', 'g5-ere' ); ?>
                                <i class="far fa-arrow-right ml-auto"></i>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
		<?php endwhile; ?>
		<?php wp_reset_postdata(); ?>
    </div>
</div>