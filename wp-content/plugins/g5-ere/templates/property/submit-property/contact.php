<?php
/**
 * Created by G5Theme.
 * User: trungpq
 * Date: 10/11/16
 * Time: 1:52 AM
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $hide_property_fields;
?>
<div class="card property-fields-wrap">
    <div class="card-body">
        <div class="card-title property-fields-title">
            <h2><?php esc_html_e( 'Contact Information', 'g5-ere' ); ?></h2>
        </div>
        <div class="property-fields property-contact">
            <p><?php esc_html_e( 'What to display in contact information box?', 'g5-ere' ); ?></p>

			<?php if ( ! in_array( "author_info", $hide_property_fields ) ) : ?>
                <div class="custom-control custom-radio custom-control-inline mb-3">
                    <input id="my_profile_info" value="author_info" type="radio" name="agent_display_option"
                           class="custom-control-input"
                           checked="checked">
                    <label class="custom-control-label"
                           for="my_profile_info"><?php esc_html_e( 'My profile information', 'g5-ere' ); ?>
                    </label>
                </div>
			<?php endif; ?>

			<?php if ( ! in_array( "other_info", $hide_property_fields ) ) : ?>

                <div class="custom-control custom-radio custom-control-inline mb-3">
                    <input id="other_contact" value="other_info" type="radio"
                           name="agent_display_option" class="custom-control-input">
                    <label for="other_contact" class="custom-control-label">
						<?php esc_html_e( 'Other contact', 'g5-ere' ); ?>
                    </label>
                </div>
			<?php endif; ?>

            <div id="property_other_contact" style="display: none">
                <div class="form-group">
                    <label
                            for="property_other_contact_name"><?php esc_html_e( 'Other contact Name', 'g5-ere' ); ?></label>
                    <input type="text" id="property_other_contact_name" class="form-control"
                           name="property_other_contact_name" value="">
                </div>
                <div class="form-row">
                    <div class="col-sm-6 form-group">
                        <label
                                for="property_other_contact_mail"><?php esc_html_e( 'Other contact Email', 'g5-ere' ); ?></label>
                        <input type="text" id="property_other_contact_mail" class="form-control"
                               name="property_other_contact_mail" value="">
                    </div>
                    <div class="col-sm-6 form-group">
                        <label
                                for="property_other_contact_phone"><?php esc_html_e( 'Other contact Phone', 'g5-ere' ); ?></label>
                        <input type="text" id="property_other_contact_phone" class="form-control"
                               name="property_other_contact_phone" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label
                            for="property_other_contact_description"><?php esc_html_e( 'Other contact more info', 'g5-ere' ); ?></label>
                    <textarea rows="3" id="property_other_contact_description" class="form-control"
                              name="property_other_contact_description"></textarea>
                </div>
            </div>
        </div>
    </div>
</div>

