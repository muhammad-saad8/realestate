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
            <h2><?php esc_html_e( 'Property Description', 'g5-ere' ); ?></h2>
        </div>
        <div class="property-fields">
            <div class="form-group">
                <label for="property_title"><?php esc_html_e( 'Title', 'g5-ere' );
					echo ere_required_field( 'property_title' ); ?></label>
                <input type="text" id="property_title" class="form-control" name="property_title"/>
            </div>
        </div>
		<?php if ( ! in_array( "property_des", $hide_property_fields ) ) { ?>
            <div class="property-fields property-description">
                <div class="form-group">
                    <label for="property_des"><?php esc_html_e( 'Description', 'g5-ere' ); ?></label>
					<?php
					$content   = '';
					$editor_id = 'property_des';
					$settings  = array(
						'wpautop'       => true,
						'media_buttons' => false,
						'textarea_name' => $editor_id,
						'textarea_rows' => get_option( 'default_post_edit_rows', 10 ),
						'tabindex'      => '',
						'editor_css'    => '',
						'editor_class'  => '',
						'teeny'         => false,
						'dfw'           => false,
						'tinymce'       => true,
						'quicktags'     => true
					);
					wp_editor( $content, $editor_id, $settings ); ?>
                </div>
            </div>
		<?php } ?>
    </div>
</div>
