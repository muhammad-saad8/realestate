<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var  $agent_info
 */
$image_arr            = array(
	'image_size'        => '140x140',
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
<div class="g5ere__widget-contact-info-layout-02 text-center">
	<?php if ($agent_info['agent_display_option'] != 'other_info'): ?>
		<div class="g5core__post-featured g5ere__agent-featured g5ere__post-featured-circle">
			<?php g5ere_render_agent_thumbnail_markup( $image_arr ); ?>
		</div>
	<?php endif; ?>
	<div class="g5ere__agent-content g5ere__loop-agent-social-circle">
		<?php
		/**
		 * @hooked g5ere_template_loop_agent_title - 10
		 * @hooked g5ere_template_loop_agent_position - 15
		 * @hooked g5ere_template_agent_rating - 20
		 * @hooked g5ere_template_loop_agent_email - 25
		 * @hooked g5ere_template_loop_agent_phone - 30
		 * @hooked g5ere_template_loop_agent_social - 35
		 */
		do_action( 'g5ere_widget_contact_agent_info_agent_layout_02', $agent_info );
		?>
	</div>
</div>
