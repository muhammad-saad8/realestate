<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$ere_ayment     = new ERE_Payment();
$payment_method = isset( $_GET['payment_method'] ) ? absint( wp_unslash( $_GET['payment_method'] ) ) : - 1;
if ( $payment_method == 1 ) {
	$ere_ayment->paypal_payment_completed();
} elseif ( $payment_method == 2 ) {
	$ere_ayment->stripe_payment_completed();
}
?>
<div class="ere-payment-completed-wrap">
	<?php
	do_action( 'ere_before_payment_completed' );
	if ( isset( $_GET['order_id'] ) && $_GET['order_id'] != '' ):
		$order_id = absint( wp_unslash( $_GET['order_id'] ) );
		$ere_invoice = new ERE_Invoice();
		$invoice_meta = $ere_invoice->get_invoice_meta( $order_id );
		?>
        <div class="row">
            <div class="col-md-5 col-lg-4 mb-5 mb-md-0">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title g5ere__sidebar-title"><?php esc_html_e( 'My Order', 'g5-ere' ); ?></h2>
                        <ul class="list-unstyled g5ere__package-details py-0">
                            <li class="d-flex align-items-center">
                                <label class="mb-0 mr-auto label">
									<?php esc_html_e( 'Order Number', 'g5-ere' ); ?>
                                </label>
                                <span class="value"><?php echo esc_html( $order_id ); ?></span>
                            </li>
                            <li class="d-flex align-items-center">
                                <label class="mb-0 mr-auto label">
									<?php esc_html_e( 'Date', 'g5-ere' ); ?>
                                </label>
                                <span class="value"><?php echo get_the_date( '', $order_id ); ?></span></li>
                            <li class="d-flex align-items-center">
                                <label class="mb-0 mr-auto label">
									<?php esc_html_e( 'Total', 'g5-ere' ); ?>
                                </label>
                                <span class="value"><?php echo ere_get_format_money( $invoice_meta['invoice_item_price'] ); ?></span>
                            </li>
                            <li class="d-flex align-items-center">
                                <label class="mb-0 mr-auto label">
									<?php esc_html_e( 'Payment Method', 'g5-ere' ); ?>
                                </label>
                                <span class="value">
									<?php echo ERE_Invoice::get_invoice_payment_method( $invoice_meta['invoice_payment_method'] ); ?>
                                </span>
                            </li>
                            <li class="d-flex align-items-center">
                                <label class="mb-0 mr-auto label">
									<?php esc_html_e( 'Payment Type', 'g5-ere' ); ?>
                                </label>
                                <span class="value">
									<?php echo ERE_Invoice::get_invoice_payment_type( $invoice_meta['invoice_payment_type'] ); ?>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-7 offset-lg-1">
                <div class="ere-heading g5ere__dashboard-heading">
                    <h2><?php echo ere_get_option( 'thankyou_title_wire_transfer', '' ); ?></h2>
                </div>
                <div class="ere-thankyou-content">
					<?php
					$html_info = ere_get_option( 'thankyou_content_wire_transfer', '' );
					echo wpautop( $html_info ); ?>
                </div>
                <a href="<?php echo ere_get_permalink( 'dashboard' ); ?>"
                   class="btn btn-accent"> <?php esc_html_e( 'Go to Dashboard', 'g5-ere' ); ?> </a>
            </div>
        </div>
	<?php else: ?>
        <div class="ere-heading g5ere__dashboard-heading">
            <h2><?php echo ere_get_option( 'thankyou_title', '' ); ?></h2>
        </div>
        <div class="ere-thankyou-content">
			<?php
			$html_info = ere_get_option( 'thankyou_content', '' );
			echo wpautop( $html_info ); ?>
        </div>
        <a href="<?php echo ere_get_permalink( 'dashboard' ); ?>"
           class="btn btn-accent"> <?php esc_html_e( 'Go to Dashboard', 'g5-ere' ); ?> </a>
	<?php endif;
	do_action( 'ere_after_payment_completed' );
	?>
</div>