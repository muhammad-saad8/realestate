<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $current_user;
$current_user    = wp_get_current_user();
$user_id         = $current_user->ID;
$package_id      = isset( $_GET['package_id'] ) ? $_GET['package_id'] : '';
$user_package_id = get_the_author_meta( ERE_METABOX_PREFIX . 'package_id', $user_id );
$ere_profile     = new ERE_Profile();
$check_package   = $ere_profile->user_package_available( $user_id );

$package_free = get_post_meta( $package_id, ERE_METABOX_PREFIX . 'package_free', true );
if ( $package_free == 1 ) {
	$package_price = 0;
} else {
	$package_price = get_post_meta( $package_id, ERE_METABOX_PREFIX . 'package_price', true );
}

$package_listings          = get_post_meta( $package_id, ERE_METABOX_PREFIX . 'package_number_listings', true );
$package_featured_listings = get_post_meta( $package_id, ERE_METABOX_PREFIX . 'package_number_featured', true );
$package_unlimited_listing = get_post_meta( $package_id, ERE_METABOX_PREFIX . 'package_unlimited_listing', true );
$package_unlimited_time    = get_post_meta( $package_id, ERE_METABOX_PREFIX . 'package_unlimited_time', true );
$package_time_unit         = get_post_meta( $package_id, ERE_METABOX_PREFIX . 'package_time_unit', true );
$package_title             = get_the_title( $package_id );
$package_billing_frquency  = get_post_meta( $package_id, ERE_METABOX_PREFIX . 'package_period', true );

if ( $package_billing_frquency > 1 ) {
	$package_time_unit .= 's';
}
$terms_conditions     = ere_get_option( 'payment_terms_condition' );
$allowed_html         = array(
	'a'      => array(
		'href'   => array(),
		'title'  => array(),
		'target' => array()
	),
	'strong' => array()
);
$enable_paypal        = ere_get_option( 'enable_paypal', 1 );
$enable_stripe        = ere_get_option( 'enable_stripe', 1 );
$enable_wire_transfer = ere_get_option( 'enable_wire_transfer', 1 );
$select_packages_link = ere_get_permalink( 'packages' );
?>
<div class="row g5ere__per-package">
    <div class="col-md-5 col-lg-4">
        <div class="ere-payment-for g5ere__package card">
            <div class="card-header bg-transparent p-0">
                <h2
                        class="card-title g5ere__sidebar-title"><?php esc_html_e( 'Selected Package', 'g5-ere' ); ?></h2>

                <div class="d-flex align-items-center flex-wrap">
                    <div class="ere-package-title mr-auto mb-3">
                        <strong><?php echo get_the_title( $package_id ); ?></strong> <?php esc_html_e( 'Pack', 'g5-ere' ) ?>
                    </div>
                    <a class="btn btn-outline btn-accent g5ere__package-change mb-3"
                       href="<?php echo esc_url( $select_packages_link ); ?>"><?php esc_html_e( 'Change Package', 'g5-ere' ); ?></a>
                </div>
            </div>
            <div class="card-body p-0">
                <ul class="list-unstyled g5ere__package-details">
                    <li class="d-flex align-items-center">
                        <label class="label mr-auto">
							<?php esc_html_e( 'Package Time:', 'g5-ere' ); ?>
                        </label>
                        <span
                                class="value"><?php if ( $package_unlimited_time == 1 ) {
								esc_html_e( 'Unlimited', 'g5-ere' );
							} else {
								echo esc_html( $package_billing_frquency ) . ' ' . ERE_Package::get_time_unit( $package_time_unit );
							}
							?></span>

                    </li>
                    <li class="d-flex align-items-center">
                        <label class="label mr-auto">
							<?php esc_html_e( 'Listing Included:', 'g5-ere' ); ?>
                        </label>
                        <span class="value"><?php if ( $package_unlimited_listing == 1 ) {
								esc_html_e( 'Unlimited', 'g5-ere' );
							} else {
								echo esc_html( $package_listings );
							} ?></span>


                    </li>
                    <li class="d-flex align-items-center">
                        <label class="label mr-auto">
							<?php esc_html_e( 'Featured Listing Included:', 'g5-ere' ); ?>
                        </label>
                        <span
                                class="value"> <?php echo esc_html( $package_featured_listings ); ?></span>

                    </li>
                </ul>
            </div>
            <div class="card-footer bg-transparent px-0 d-flex align-items-center g5ere__package-total-price">
                <label class="label mr-auto mb-0">
					<?php esc_html_e( 'Total Price:', 'g5-ere' ); ?>
                </label>
                <span
                        class="value ere-package-price"><?php echo ere_get_format_money( $package_price ); ?></span>
            </div>

        </div>
    </div>
    <div class="col-md-7 offset-lg-1">
		<?php if ( ( $package_id == $user_package_id ) && $check_package == 1 ): ?>
            <div class="alert alert-warning"
                 role="alert"><?php echo sprintf( __( 'You currently have "%s" package. The package hasn\'t expired yet, so you cannot buy it at this time. If you would like, you can buy another package.', 'g5-ere' ), $package_title ); ?></div>
		<?php else: ?>
			<?php if ( $package_price > 0 ): ?>
                <div class="ere-payment-method-wrap">
                    <div class="ere-heading g5ere__dashboard-heading">
                        <h2><?php esc_html_e( 'Choose Payment Methods', 'g5-ere' ); ?></h2>
                    </div>
					<?php if ( $enable_paypal != 0 ) : ?>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="paypal" class="payment-paypal custom-control-input"
                                   name="ere_payment_method" value="paypal"
                                   checked>
                            <label for="paypal" class="custom-control-label">
                                <i class="fab fa-paypal"></i>
								<?php esc_html_e( 'Pay With Paypal', 'g5-ere' ); ?>
                            </label>
                        </div>
					<?php endif; ?>

					<?php if ( $enable_stripe != 0 ): ?>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="stripe" class="payment-stripe custom-control-input"
                                   name="ere_payment_method" value="stripe">
                            <label for="stripe" class="custom-control-label">
                                <i class="fa fa-credit-card"></i> <?php esc_html_e( 'Pay with Credit Card', 'g5-ere' ); ?>
                            </label>
							<?php
							$ere_payment = new ERE_Payment();
							$ere_payment->stripe_payment_per_package( $package_id ); ?>
                        </div>
					<?php endif; ?>

					<?php if ( $enable_wire_transfer != 0 ) : ?>
                        <div class="custom-control custom-radio">
                            <input type="radio" name="ere_payment_method" class="custom-control-input"
                                   id="wire_transfer" value="wire_transfer">
                            <label for="wire_transfer" class="custom-control-label">
                                <i class="fa fa-send-o"></i> <?php esc_html_e( 'Wire Transfer', 'g5-ere' ); ?>
                            </label>
                        </div>
                        <div class="ere-wire-transfer-info">
							<?php
							$html_info = ere_get_option( 'wire_transfer_info', '' );
							echo wpautop( $html_info ); ?>
                        </div>
					<?php endif; ?>
					<?php do_action( 'ere_select_payment_method', 0 ) ?>
                </div>
			<?php endif; ?>
            <input type="hidden" name="ere_package_id" value="<?php echo esc_attr( $package_id ); ?>">

            <p class="terms-conditions g5ere__terms-conditions"><?php echo sprintf( wp_kses( __( 'Please read <a target="_blank" href="%s"><strong>Terms & Conditions</strong></a> first', 'g5-ere' ), $allowed_html ), get_permalink( $terms_conditions ) ); ?>
            </p>
			<?php if ( $package_price > 0 ): ?>
                <button id="ere_payment_package" type="submit"
                        class="btn btn-submit g5ere__package-button-pay"> <?php esc_html_e( 'Pay Now', 'g5-ere' ); ?> </button>
			<?php else:
				$user_free_package = get_the_author_meta( ERE_METABOX_PREFIX . 'free_package', $user_id );
				if ( $user_free_package == 'yes' ):?>
                    <div class="ere-message alert alert-warning"
                         role="alert"><?php esc_html_e( 'You have already used your first free package, please choose different package.', 'g5-ere' ); ?></div>
				<?php else: ?>
                    <button id="ere_free_package" type="submit"
                            class="btn btn-success btn-submit"> <?php esc_html_e( 'Get Free Listing Package', 'g5-ere' ); ?> </button>
				<?php endif; ?>
			<?php endif; ?>
		<?php endif; ?>
    </div>
</div>
