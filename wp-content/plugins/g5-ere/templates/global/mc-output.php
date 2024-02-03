<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$currency = ere_get_option( 'currency_sign' );
if ( empty( $currency ) ) {
	$currency = esc_html__( '$', 'g5-ere' );
}
$currency_position = ere_get_option( 'currency_position', 'before' );
?>
<script id="g5ere__mortgage_calculator_output" type="text/template">
    <div class="g5ere__mc-output-container">
        <dl class="d-flex mb-0 justify-content-between py-2">
            <dt><?php esc_html_e( 'Loan Amount', 'g5-ere' ) ?></dt>
            <dd class='mc-years mb-0'>
				<?php
				if ( $currency_position == 'before' ) {
					echo esc_html( $currency ) ?>{{loan_amount}}
				<?php } else {
					?>{{loan_amount}}<?php echo esc_html( $currency ) ?>
				<?php }
				?>
            </dd>
        </dl>
        <dl class="d-flex mb-0 justify-content-between border-top py-2">
            <dt><?php esc_html_e( 'Year', 'g5-ere' ) ?></dt>
            <dd class="mc-monthly mb-0">{{term_years}}</dd>
        </dl>
        <dl class="d-flex mb-0 justify-content-between border-top py-2">
            <dt><?php esc_html_e( 'Monthly', 'g5-ere' ) ?></dt>
            <dd class="mc-monthly mb-0">
	            <?php
	            if ( $currency_position == 'before' ) {
		            echo esc_html( $currency ) ?>{{monthly_payment}}
	            <?php } else {
		            ?>{{monthly_payment}}<?php echo esc_html( $currency ) ?>
	            <?php }
	            ?>
            </dd>
        </dl>
        <dl class="d-flex mb-0 justify-content-between border-top py-2">
            <dt><?php esc_html_e( 'Bi Weekly', 'g5-ere' ) ?></dt>
            <dd class="mc-bi-weekly mb-0">
	            <?php
	            if ( $currency_position == 'before' ) {
		            echo esc_html( $currency ) ?>{{bi_weekly_payment}}
	            <?php } else {
		            ?>{{bi_weekly_payment}}<?php echo esc_html( $currency ) ?>
	            <?php }
	            ?>
            </dd>
        </dl>
        <dl class="d-flex mb-0 justify-content-between border-top py-2">
            <dt><?php esc_html_e( 'Weekly', 'g5-ere' ) ?></dt>
            <dd class="mc-weekly mb-0">
	            <?php
	            if ( $currency_position == 'before' ) {
		            echo esc_html( $currency ) ?>{{weekly_payment}}
	            <?php } else {
		            ?>{{weekly_payment}}<?php echo esc_html( $currency ) ?>
	            <?php }
	            ?>
        </dl>
    </div>
</script>
