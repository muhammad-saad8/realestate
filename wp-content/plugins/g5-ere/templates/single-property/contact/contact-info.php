<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * @var $$agent_info
 */
$image_arr = array(
	'image_size'        => 'full',
	'image_ratio'       => '240x240',
	'image_id'          => '',
	'display_permalink' => false,
	'permalink'         => '',
	'image_mode'        => '',
	'placeholder'       => '',
);
if ( isset($agent_info['avatar_id']) && !empty($agent_info['avatar_id'])) {
	$image_arr['image_id'] = $agent_info['avatar_id'];
} else {
	$image_arr['placeholder'] = 'on';
}
if ( isset($agent_info['agent_link']) && ! empty( $agent_info['agent_link'] ) ) {
	$image_arr['display_permalink'] = true;
	$image_arr['permalink']         = $agent_info['agent_link'];
}
$post_class     = 'g5ere__contact-agent-info g5ere__loop-skin-medium-image';
$post_inner_class = 'g5ere__loop-item-inner';
?>
<div class="<?php echo esc_attr( $post_class ) ?>">
	<div class="<?php echo esc_attr( $post_inner_class ); ?>">
		<?php if ($agent_info['agent_display_option'] != 'other_info'): ?>
			<div class="g5core__post-featured g5ere__agent-featured">
				<?php g5ere_render_agent_thumbnail_markup( $image_arr ); ?>
			</div>
		<?php endif; ?>
		<div class="g5ere__agent-content g5ere__loop-content">
			<?php
			/**
			 * Hook: g5ere_single_property_contact_agent.
			 *
			 * @see g5ere_template_loop_agent_title
			 * @see g5ere_template_loop_agent_position
			 * @see g5ere_template_loop_agent_phone_has_icon
			 * @see g5ere_template_loop_agent_email_has_icon
			 * @see g5ere_template_loop_agent_address_has_icon
			 * @see g5ere_template_loop_agent_social
			 *
			 */
			do_action( 'g5ere_single_property_contact_agent_content', $agent_info );
			?>
		</div>
	</div>
</div>

