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
?>
<div class="card property-fields-wrap">
    <div class="card-body">
        <div class="card-title property-fields-title">
            <h2><?php esc_html_e( 'Property Type', 'g5-ere' ); ?></h2>
        </div>
        <div class="property-fields property-type row">
			<?php if ( ! in_array( "property_type", $hide_property_fields ) ) { ?>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="property_type"><?php esc_html_e( 'Type', 'g5-ere' );
							echo ere_required_field( 'property_type' ); ?></label>
                        <select name="property_type[]" id="property_type" class="form-control" multiple>
							<?php ere_get_taxonomy( 'property-type', false, false ); ?>
                        </select>
                    </div>
                </div>
			<?php } ?>
			<?php if ( ! in_array( "property_status", $hide_property_fields ) ) { ?>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="property_status"><?php esc_html_e( 'Status', 'g5-ere' ); ?><?php echo ere_required_field( 'property_status' ); ?></label>
                        <select name="property_status[]" id="property_status" class="form-control" multiple>
							<?php ere_get_taxonomy( 'property-status', false, false ); ?>
                        </select>
                    </div>
                </div>
			<?php } ?>

			<?php if ( ! in_array( "property_label", $hide_property_fields ) ) { ?>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="property_label"><?php esc_html_e( 'Label', 'g5-ere' );
							echo ere_required_field( 'property_label' ); ?></label>
                        <select name="property_label[]" id="property_label" class="form-control" multiple>
							<?php ere_get_taxonomy( 'property-label', false, false ); ?>
                        </select>
                    </div>
                </div>
			<?php } ?>
        </div>
    </div>
</div>

