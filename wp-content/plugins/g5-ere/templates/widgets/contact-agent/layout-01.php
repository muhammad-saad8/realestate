<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var  $agent_info
 */
$image_arr            = array(
	'image_size'        => '80x80',
	'display_permalink' => false,
	'image_mode'        => '',
);
if ( isset($agent_info['avatar_id']) && !empty($agent_info['avatar_id'])) {
	$image_arr['image_id'] = $agent_info['avatar_id'];
} else {
	$image_arr['image_id']    = '';
	$image_arr['placeholder'] = 'on';
}
if ( isset($agent_info['agent_link']) && !empty($agent_info['agent_link'])) {
	$image_arr['display_permalink'] = true;
	$image_arr['permalink']         = $agent_info['agent_link'];
}
?>
<div class="media g5ere__widget-contact-info-layout-01">
	<?php if ($agent_info['agent_display_option'] != 'other_info'): ?>
		<div class="g5core__post-featured g5ere__agent-featured g5ere__post-featured-circle">
			<?php g5ere_render_agent_thumbnail_markup( $image_arr ); ?>
		</div>
	<?php endif; ?>
	<div class="media-body g5ere__agent-content">
		<?php
		/**
		 * @hooked g5ere_template_loop_agent_title - 5
		 * @hooked g5ere_template_loop_agent_email - 10
		 * @hooked g5ere_template_loop_agent_phone_has_icon - 15
		 */
		do_action( 'g5ere_widget_contact_agent_info_layout_01', $agent_info );
		?>
	</div>
</div>

