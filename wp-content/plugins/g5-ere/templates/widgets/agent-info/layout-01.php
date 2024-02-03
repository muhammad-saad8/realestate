<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<div class="g5ere__widget-agent-info-inner g5ere__widget-agent-info-layout-01">
	<div class="g5core__post-featured g5ere__agent-featured g5ere__post-featured-circle">
		<?php g5ere_render_agent_thumbnail_markup(array(
			'image_size' => '140x140',
			'placeholder' => 'on'
		)); ?>
	</div>
	<div class="g5ere__agent-content">
		<div class="g5ere__ac-top text-center">
			<?php
			/**
			 *
			 * @see g5ere_template_agent_title
			 * @see g5ere_template_loop_agent_position
			 * @see g5ere_template_agent_rating
			 */
			 do_action('g5ere_widget_agent_info_content_top_layout_01');
			?>
		</div>
		<div class="g5ere__ac-bottom">
			<?php
			/**
			 *
			 * @see g5ere_template_agent_meta
			 * @see g5ere_template_loop_agent_social_has_title
			 * @see g5ere_template_contact_agent_button
			 */
			do_action('g5ere_widget_agent_info_content_layout_01');
			?>
		</div>
	</div>
</div>
