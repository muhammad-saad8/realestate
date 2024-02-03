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
 * @var $post_attributes
 * @var $template
 * @var $image_mode
 * @var $placeholder
 * @var $logo_id
 * @var $g5ere_agency G5ERE_Agency
 */
global $g5ere_agency;
if ( ! g5ere_agency_visible( $g5ere_agency ) ) {
	return;
}
$thumbnail_data = $g5ere_agency->get_thumbnail_data( array(
	'image_size'  => $image_size,
	'placeholder' => $placeholder
) );
if ( $thumbnail_data['url'] !== '' ) {
	$post_class .= ' g5ere__has-image-featured';
}

$image_data       = array(
	'image_size'        => $image_size,
	'image_ratio'       => $image_ratio,
	'image_mode'        => $image_mode,
	'display_permalink' => true,
);
$post_class .= ' g5ere__loop-skin-medium-image';
?>
<article class=" <?php echo esc_attr( $post_class ) ?>">
    <div <?php echo join( ' ', $post_inner_attributes ) ?> class="<?php echo esc_attr( $post_inner_class ); ?>">
		<?php if ( $thumbnail_data['url'] !== '' ): ?>
            <div class="g5core__post-featured g5ere__agency-featured">
				<?php $image_data = array(
					'image_size'        => $image_size,
					'image_ratio'       => $image_ratio,
					'image_mode'        => $image_mode,
					'placeholder'       => $placeholder,
					'display_permalink' => true,
				);
				$g5ere_agency->render_thumbnail_markup( $image_data );
				do_action( 'g5ere_after_loop_agency_thumbnail_skin_list_01' );
				?>
            </div>
		<?php endif; ?>
        <div class="g5ere__agency-content g5ere__loop-content">
			<?php
			/**
			 * Hook: g5ere_loop_agency_content_skin_list_01.
			 *
			 * @hooked g5ere_template_loop_agency_title - 15
			 * @hooked g5ere_template_loop_agency_address - 20
			 * @hooked g5ere_template_loop_agency_meta - 25
			 *
			 */
			do_action( 'g5ere_loop_agency_content_skin_list_01' );
			?>
        </div>
    </div>
</article>
