<?php
/**
 * Created by G5Theme.
 * User: trungpq
 * Date: 18/11/16
 * Time: 5:44 PM
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $hide_property_fields;
?>
<div class="card property-fields-wrap">
    <div class="card-body">
        <div class="card-title property-fields-title">
            <h2><?php esc_html_e( 'Property Media', 'g5-ere' ); ?></h2>
        </div>
        <div class="property-fields property-media">
            <div class="ere-property-gallery">
                <label class="media-gallery-title"><?php esc_html_e( 'Photo Gallery', 'g5-ere' ); ?></label>
                <div class="media-gallery">
                    <div id="property_gallery_thumbs_container" class="row">
                    </div>
                </div>
                <div id="ere_gallery_plupload_container" class="media-drag-drop">
                    <div class="media-drag-drop-icon"><i class="fa fa-cloud-upload"></i></div>
                    <h4>
						<?php esc_html_e( 'Drag and drop file here or', 'g5-ere' ); ?>
                    </h4>
                    <button type="button" id="ere_select_gallery_images"
                            class="btn btn-secondary"><?php esc_html_e( 'Select Images', 'g5-ere' ); ?></button>
                </div>
                <div id="ere_gallery_errors_log"></div>
            </div>
			<?php if ( ! in_array( "property_attachments", $hide_property_fields ) ): ?>
                <label class="media-attachments-title"><?php esc_html_e( 'File Attachments', 'g5-ere' ); ?></label>
                <div class="ere-property-attachments">
                    <div class="media-attachments">
                        <div id="property_attachments_thumbs_container" class="row">
                        </div>
                    </div>
                    <div id="ere_attachments_plupload_container" class="media-drag-drop">
                        <div class="media-drag-drop-icon"><i class="fa fa-cloud-upload"></i></div>
                        <h4><?php esc_html_e( 'Drag and drop file here or', 'g5-ere' ); ?>
                        </h4>
                        <button type="button" id="ere_select_file_attachments"
                                class="btn btn-secondary"><?php esc_html_e( 'Select Files', 'g5-ere' ); ?></button>
                        <p><?php
							$attachment_file_type = ere_get_option( 'attachment_file_type', 'pdf,txt,doc,docx' );
							echo wp_kses_post( sprintf( __( 'Allowed Extensions: <span class="attachment-file-type">%s</span>', 'g5-ere' ), $attachment_file_type ) );
							?></p>
                    </div>
                    <div id="ere_attachments_errors_log"></div>
                </div>
			<?php endif; ?>
            <div class="property-media-other row">
				<?php if ( ! in_array( "property_video_url", $hide_property_fields ) ): ?>
                    <div class="property-video-url col-sm-6 form-group">
                        <label for="property_video_url"><?php esc_html_e( 'Video URL', 'g5-ere' ); ?></label>
                        <input type="text" class="form-control" name="property_video_url" id="property_video_url"
                               placeholder="<?php esc_attr_e( 'YouTube, Vimeo, SWF File, MOV File', 'g5-ere' ); ?>">
                    </div>
				<?php endif; ?>
				<?php if ( ! in_array( "property_image_360", $hide_property_fields ) ) : ?>
                    <div class="property-image-360 col-sm-6 form-group">
                        <label for="image_360_url"><?php esc_html_e( 'Image 360', 'g5-ere' ); ?></label>
                        <div id="ere_image_360_plupload_container" class="file-upload-block">
                            <div class="input-group">
                                <input
                                        name="property_image_360_url"
                                        type="text"
                                        id="image_360_url"
                                        class="ere_image_360_url form-control" value="">
                                <div class="input-group-append">
                                    <span id="ere_select_images_360"
                                          title="<?php esc_attr_e( 'Choose image', 'g5-ere' ) ?>"
                                          class="ere_image360 input-group-text"><i class="fal fa-file-image"></i></span>
                                </div>
                            </div>
                            <input type="hidden" class="ere_image_360_id"
                                   name="property_image_360_id"
                                   value="" id="ere_image_360_id"/>
                        </div>

                        <div id="ere_image_360_errors_log" class="mt-3"></div>
                        <div id="ere_property_image_360_view" class="mt-3"
                             data-plugin-url="<?php echo esc_url( ERE_PLUGIN_URL ); ?>">
                        </div>
                    </div>
				<?php endif; ?>
            </div>
        </div>
    </div>
</div>
