<?php
/**
 * Created by G5Theme.
 * User: trungpq
 * Date: 18/11/16
 * Time: 5:46 PM
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $hide_property_fields;
$dec_point = ere_get_option('decimal_separator', '.');
$property_price_short_format = '^[0-9]+([' . $dec_point . '][0-9]+)?$';
?>
<div class="card property-fields-wrap">
    <div class="card-body">
        <div class="card-title property-fields-title">
            <h2><?php esc_html_e( 'Property Price', 'g5-ere' ); ?></h2>
        </div>
        <div class="property-fields property-price row">
			<?php
			if ( ! in_array( "property_price", $hide_property_fields ) ) {
				$enable_price_unit = ere_get_option( 'enable_price_unit', '1' );
				?>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="property_price_short"> <?php esc_html_e( 'Price', 'g5-ere' );
							echo ere_required_field( 'property_price' );
							echo esc_html( ere_get_option( 'currency_sign', '' ) ) . ' '; ?>  </label>
                        <input pattern="<?php echo esc_attr($property_price_short_format)?>" type="text" id="property_price_short" class="form-control"
                               name="property_price_short" value="">
	                    <small class="form-text text-muted"><?php echo sprintf(esc_html__('Example Value: 12345%s05','g5-ere'),$dec_point)  ?></small>
                    </div>
                </div>
				<?php if ( $enable_price_unit == '1' ) { ?>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="property_price_unit"><?php esc_html_e( 'Unit', 'g5-ere' );
								echo ere_required_field( 'property_price_unit' ); ?></label>
                            <select name="property_price_unit" id="property_price_unit" class="form-control">
                                <option value="1"><?php esc_html_e( 'None', 'g5-ere' ); ?></option>
                                <option value="1000"><?php esc_html_e( 'Thousand', 'g5-ere' ); ?></option>
                                <option value="1000000"><?php esc_html_e( 'Million', 'g5-ere' ); ?></option>
                                <option value="1000000000"><?php esc_html_e( 'Billion', 'g5-ere' ); ?></option>
                            </select>
                        </div>
                    </div>
				<?php } ?>
			<?php } ?>
			<?php
			if ( ! in_array( "property_price_prefix", $hide_property_fields ) ) {
				?>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="property_price_prefix"><?php esc_html_e( 'Before Price Label (ex: Start From)', 'g5-ere' );
							echo ere_required_field( 'property_price_prefix' ); ?></label>
                        <input type="text" id="property_price_prefix" class="form-control"
                               name="property_price_prefix">
                    </div>
                </div>
			<?php } ?>
			<?php
			if ( ! in_array( "property_price_postfix", $hide_property_fields ) ) {
				?>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="property_price_postfix"><?php esc_html_e( 'After Price Label (ex: Per Month)', 'g5-ere' );
							echo ere_required_field( 'property_price_postfix' ); ?></label>
                        <input type="text" id="property_price_postfix" class="form-control"
                               name="property_price_postfix">
                    </div>
                </div>
			<?php } ?>
			<?php
			if ( ! in_array( "property_price_on_call", $hide_property_fields ) ) { ?>
                <div class="col-sm-12">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox checkbox">
                            <input type="checkbox" id="property_price_on_call" class="custom-control-input"
                                   name="property_price_on_call">
                            <label class="custom-control-label" for="property_price_on_call">
								<?php esc_html_e( 'Price on Call', 'g5-ere' );
								echo ere_required_field( 'property_price_on_call' ); ?>
                            </label>
                        </div>
                    </div>
                </div>
			<?php } ?>
        </div>
    </div>
</div>

