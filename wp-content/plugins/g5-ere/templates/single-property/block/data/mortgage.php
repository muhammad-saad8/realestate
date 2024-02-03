<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$currency = ere_get_option( 'currency_sign' );
if ( empty( $currency ) ) {
	$currency = esc_html__( '$', 'g5-ere' );
}
add_action( 'wp_footer', 'g5ere_mortgage_calculator_output_template' );
?>
<div class="g5ere__mortgage-calculator">
    <div class="form-row">
        <div class="col-md-6">
            <div class="form-group mc-item mb-3">
                <label for="g5ere_mc_sale_price"
                       class="title-mc-item"><?php esc_html_e( 'Sale Price', 'g5-ere' ); ?></label>
                <input class="form-control" id="g5ere_mc_sale_price" type="text"
                       placeholder="<?php echo esc_attr( $currency ) ?>">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mc-item mb-3">
                <label for="g5ere_mc_down_payment"
                       class="title-mc-item"><?php esc_html_e( 'Down Payment', 'g5-ere' ); ?></label>
                <input class="form-control" id="g5ere_mc_down_payment" type="text"
                       placeholder="<?php echo esc_attr( $currency ) ?>">
            </div>
        </div>
    </div>
    <div class="form-row mb-3">
        <div class="col-md-6">
            <div class="form-group mc-item mb-3">
                <label for="g5ere_mc_term_years"
                       class="title-mc-item"><?php esc_html_e( 'Term[Years]', 'g5-ere' ); ?></label>
                <input class="form-control" id="g5ere_mc_term_years" type="text"
                       placeholder="<?php esc_attr_e( 'Year', 'g5-ere' ); ?>">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mc-item mb-3">
                <label for="g5ere_mc_interest_rate"
                       class="title-mc-item"><?php esc_html_e( 'Interest Rate in %', 'g5-ere' ); ?></label>
                <input class="form-control" id="g5ere_mc_interest_rate" type="text"
                       placeholder="<?php esc_attr_e( '%', 'g5-ere' ); ?>">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <button type="button" id="g5ere_btn_mc"
                    class="btn btn-accent"><?php esc_html_e( 'Calculate', 'g5-ere' ); ?></button>
        </div>
        <div class="col-md-6">
            <div class="g5ere_mc-output">
            </div>
        </div>

    </div>
</div>

