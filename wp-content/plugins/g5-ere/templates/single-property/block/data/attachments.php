<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$attachments = g5ere_get_property_get_attachments();
if ( ! empty( $attachments[0] ) ):
	?>
    <div class="g5ere__property-attachments">
        <div class="row">
			<?php
			foreach ( $attachments as $attach_id ):
				$attach_url = wp_get_attachment_url( $attach_id );
				$file_type = wp_check_filetype( $attach_url );
				$file_type_name = isset( $file_type['ext'] ) ? $file_type['ext'] : '';
				if ( ! empty( $file_type_name ) ):
					$thumb_url = ERE_PLUGIN_URL . 'public/assets/images/attachment/attach-' . $file_type_name . '.png';
					$file_name = pathinfo( $attach_url );
					?>
                    <div class="col-lg-4 col-sm-6 media-thumb-wrap mb-3 mb-md-0">
                        <figure class="media-thumb">
                            <img src="<?php echo esc_url( $thumb_url ); ?>">
                        </figure>
                        <div class="media-info">
                            <p class="mb-0 media-file-name"><?php echo esc_html( $file_name['filename'] ) ?></p>
                            <p class="mb-0 media-file-type"><?php printf( __( '<span class="text-uppercase">%s</span> document', 'g5-ere' ), $file_type_name ); ?></p>
                            <a target="_blank" class="btn btn-light btn-download"
                               href="<?php echo esc_url( $attach_url ); ?>"><?php esc_html_e( 'Download', 'g5-ere' ); ?></a>
                        </div>
                    </div>
				<?php
				endif;
			endforeach;
			?>
        </div>
    </div>
<?php endif; ?>