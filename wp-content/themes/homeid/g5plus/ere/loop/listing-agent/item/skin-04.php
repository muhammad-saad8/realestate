<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $image_size
 * @var $image_ratio
 * @var $post_class
 * @var $post_inner_class
 * @var $post_inner_attributes
 * @var $image_mode
 * @var $template
 * @var $placeholder
 */
$thumbnail_data = g5ere_get_agent_thumbnail_data( array(
	'image_size'  => $image_size,
	'placeholder' => $placeholder
));
if ( $thumbnail_data['url'] !== '' ) {
	$post_class .= ' g5ere__has-image-featured';
}

if ( $image_ratio === '' && $image_size = "full" ) {
	$image_mode  = 'background';
	$image_ratio = '1x1';
}

?>
<article <?php post_class( $post_class ) ?>>
	<div <?php echo join( ' ', $post_inner_attributes ) ?> class="<?php echo esc_attr( $post_inner_class ); ?>">
		<div class="g5ere__agent-top">
			<?php if ( $thumbnail_data['url'] !== '' ): ?>
				<div class="g5ere__agent-thumbnail">
					<?php g5ere_render_agent_thumbnail_markup( array(
						'image_size'         => $image_size,
						'image_ratio' => $image_ratio,
						'image_mode' => $image_mode,
						'placeholder' => $placeholder
					) ); ?>
				</div>
			<?php endif; ?>
			<?php
			/**
			 * Hook: g5ere_loop__agent_top_skin_04.
			 *
			 * @see g5ere_template_loop_agent_title - 5
			 * @see g5ere_template_loop_agent_position - 10
			 * @see g5ere_template_loop_agent_social - 15
			 */
			do_action( 'g5ere_loop__agent_top_skin_04' );
			?>
		</div>
		<div class="g5ere__agent-content">
			<?php
			/**
			 * Hook: g5ere_loop__agent_content_skin_04.
			 *
			 * @see g5ere_template_loop_agent_email - 5
			 * @see g5ere_template_loop_agent_phone - 10
			 * @see g5ere_template_loop_agent_rating_has_total_reviews - 15
			 */
			do_action( 'g5ere_loop__agent_content_skin_04' );
			?>
		</div>
		<?php
		/**
		 * Hook: g5ere_loop__agent_btn_load_more_skin_04.
		 *
		 * @see g5ere_template_loop__agent_button_load_more - 5
		 */
		do_action( 'g5ere_loop__agent_btn_load_more_skin_04' );
		?>
	</div>
</article>
