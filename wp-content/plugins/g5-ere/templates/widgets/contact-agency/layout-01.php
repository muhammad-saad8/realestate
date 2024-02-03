<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
global $g5ere_agency;
if ( ! g5ere_agency_visible( $g5ere_agency ) ) {
	return;
}
?>
<div class="media g5ere__widget-contact-info-layout-01">
	<div class="g5core__post-featured g5ere__agency-featured g5ere__post-featured-circle">
		<?php $g5ere_agency->render_thumbnail_markup(array(
			'image_size'        => '80x80',
			'display_permalink' => false,
			'image_mode'        => '',
			'placeholder' => 'on',
			'image_id' => $g5ere_agency->get_image_id()
		) ); ?>
	</div>
	<div class="media-body g5ere__agency-content">
		<?php
		/**
		 * @hooked g5ere_template_loop_agency_title - 5
		 * @hooked g5ere_template_loop_agency_email_no_title - 10
		 * @hooked g5ere_template_loop_agency_phone_has_icon - 15
		 */
		do_action( 'g5ere_widget_contact_agency_info_layout_01' );

		?>
	</div>
</div>
