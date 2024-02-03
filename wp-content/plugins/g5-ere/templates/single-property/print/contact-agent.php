<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * @var $phone
 */
$agent_display_option = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'agent_display_option', true );
$info_arr             = g5ere_get_agent_info_by_property( $property_id );
if ( $info_arr == false ) {
	return;
}
extract( $info_arr );
?>
<div class="g5ere__property-print-block g5ere__property-print-block-contact-agent">
    <h3 class="g5ere__property-print-block-title">
		<?php esc_html_e( 'Contact Information', 'g5-ere' ) ?>
    </h3>
    <div class="g5ere__agent-info media">
		<?php

		$image_arr = array(
			'image_size'        => '150x150',
			'image_ratio'       => '',
			'image_id'          => '',
			'display_permalink' => false,
			'permalink'         => '',
			'image_mode'        => 'image',
			'placeholder'       => '',
		);
		if ( $avatar_id != '' ) {
			$image_arr['image_id'] = $avatar_id;
		} else {
			$image_arr['placeholder'] = 'on';
		}
		if ( ! empty( $agent_link ) ) {
			$image_arr['display_permalink'] = true;
			$image_arr['permalink']         = $agent_link;
		}
		$thumbnail_data = g5ere_get_agent_thumbnail_data( $image_arr );
		?>
		<?php if ( $agent_display_option != 'other_info' && $thumbnail_data['url'] !== '' ): ?>
            <div class="agent-avatar mr-2">
                <div class="g5core__post-featured g5ere__agent-featured">
					<?php g5ere_render_agent_thumbnail_markup( $image_arr ); ?>
                </div>
            </div>
		<?php endif; ?>
        <div class="media-body">
			<?php
			/**
			 * @hooked g5ere_template_loop_agent_title - 5
			 * @hooked g5ere_template_loop_agent_position - 10
			 * @hooked g5ere_template_loop_agent_phone_has_icon - 15
			 * @hooked g5ere_template_loop_agent_email_has_icon - 20
			 * @hooked g5ere_template_loop_agent_website_has_icon - 25
			 * @hooked g5ere_template_contact_agent_button_whatsapp - 30
			 */
			do_action( 'g5ere_single_property_print_contact_agent', $info_arr );
			do_action( 'g5ere_single_property_print_contact_agent_bottom',  $property_id, $phone  ); ?>
        </div>
    </div>
</div>