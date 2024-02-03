<?php
/**
 * Created by G5Theme.
 * User: trungpq
 * Date: 29/08/17
 * Time: 11:20 AM
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
?>
<div class="card property-fields-wrap">
    <div class="card-body">
        <div class="card-title property-fields-title">
            <h2><?php esc_html_e( 'Private Note', 'g5-ere' ); ?></h2>
        </div>
        <div class="property-fields property-private-note">
            <div class="form-group">
                <label for="private_note"><?php esc_html_e('Create a private note for this property, it will not be displayed to public', 'g5-ere'); ?></label>
                <textarea
                        name="private_note"
                        rows="4"
                        id="private_note"
                        class="form-control"></textarea>
            </div>
        </div>
    </div>
</div>
