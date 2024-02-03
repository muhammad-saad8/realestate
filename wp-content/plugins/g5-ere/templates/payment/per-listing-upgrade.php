<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$property_id          = isset( $_GET['property_id'] ) ? absint( wp_unslash( $_GET['property_id'] ) ) : 0;
$terms_conditions     = ere_get_option( 'payment_terms_condition' );
$enable_paypal        = ere_get_option( 'enable_paypal', 1 );
$enable_stripe        = ere_get_option( 'enable_stripe', 1 );
$enable_wire_transfer = ere_get_option( 'enable_wire_transfer', 1 );

$price_featured_listing = ere_get_option( 'price_featured_listing', 0 );
?>
<div class="row">
    <div class="col-md-5 col-lg-4 mb-5 mb-md-0">
        <div class="ere-payment-for card border-0">
            <div class="card-body p-0">
                <div class="ere-package-title g5ere__sidebar-title text-left"><?php esc_html_e( 'Choose Option', 'g5-ere' ); ?></div>
                <ul class="list-unstyled g5ere__package-details">
                    <li class="d-flex align-items-center">
                        <div class="custom-control custom-radio">
                            <input type="radio" class="ere_payment_for custom-control-input" id="ere_payment_for"
                                   name="ere_payment_for" value="3" checked>
                            <label for="ere_payment_for" class="custom-control-label">
								<?php esc_html_e( 'Upgrade to Featured', 'g5-ere' ); ?>
                            </label>
                        </div>
                        <div
                                class="ml-auto value"><?php echo ere_get_format_money( $price_featured_listing ); ?></div>
                    </li>
                </ul>
            </div>

        </div>
    </div>
    <div class="col-md-7 offset-lg-1">
        <div class="ere-payment-method-wrap">
            <div class="ere-heading g5ere__dashboard-heading">
                <h2><?php esc_html_e( 'Payment Method', 'g5-ere' ); ?></h2>
            </div>
			<?php if ( $enable_paypal != 0 ) : ?>
                <div class="custom-control custom-radio">
                    <input type="radio" class="payment-paypal custom-control-input" id="payment-paypal"
                           name="ere_payment_method" value="paypal" checked>
                    <label for="payment-paypal" class="custom-control-label">
                        <i class="fab fa-paypal"></i>
						<?php esc_html_e( 'Pay With Paypal', 'g5-ere' ); ?>
                    </label>
                </div>
			<?php endif; ?>

			<?php if ( $enable_stripe != 0 ) : ?>
                <div class="custom-control custom-radio">
                    <input type="radio" class="payment-stripe custom-control-input" id="payment-stripe"
                           name="ere_payment_method" value="stripe">
                    <label for="payment-stripe" class="custom-control-label">
                        <i class="fa fa-credit-card"></i> <?php esc_html_e( 'Pay with Credit Card', 'g5-ere' ); ?>
                    </label>
					<?php
					$ere_payment = new ERE_Payment();
					$ere_payment->stripe_payment_upgrade_listing( $property_id, $price_featured_listing );
					?>
                </div>
			<?php endif; ?>

			<?php if ( $enable_wire_transfer != 0 ) : ?>
                <div class="custom-control custom-radio">
                    <input type="radio" name="ere_payment_method" id="wire_transfer" value="wire_transfer"
                           class="custom-control-input">
                    <label for="wire_transfer" class="custom-control-label">
                        <i class="fa fa-send-o"></i> <?php esc_html_e( 'Wire transfer', 'g5-ere' ); ?>
                    </label>
                </div>
                <div class="ere-wire-transfer-info">
					<?php
					$html_info = ere_get_option( 'wire_transfer_info', '' );
					echo wpautop( $html_info ); ?>
                </div>
			<?php endif; ?>
			<?php do_action( 'ere_select_payment_method', 3 ) ?>
        </div>
        <input type="hidden" id="ere_property_id" name="ere_property_id"
               value="<?php echo esc_attr( $property_id ); ?>">
        <p class="terms-conditions g5ere__terms-conditions"
           role="alert"><?php echo wp_kses_post( sprintf( __( 'Please read <a target="_blank" href="%s"><strong>Terms & Conditions</strong></a> before click "Pay Now"', 'g5-ere' ), get_permalink( $terms_conditions ) ) ); ?></p>
        <button id="ere_upgrade_listing" type="button"
                class="btn btn-accent btn-submit g5ere__package-button-pay"> <?php esc_html_e( 'Pay Now', 'g5-ere' ); ?> </button>
    </div>
</div>