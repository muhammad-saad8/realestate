<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $wp_query;
$current_author      = $wp_query->get_queried_object();
$current_author_meta = get_user_meta( $current_author->ID );

$image_arr         = array(
	'image_size'        => 'full',
	'image_ratio'       => '',
	'image_id'          => '',
	'display_permalink' => false,
	'permalink'         => '',
	'image_mode'        => 'image',
	'placeholder'       => '',
);
$author_picture_id = isset( $current_author_meta[ ERE_METABOX_PREFIX . 'author_picture_id' ] ) ? $current_author_meta[ ERE_METABOX_PREFIX . 'author_picture_id' ][0] : '';
if ( $author_picture_id != '' ) {
	$image_arr['image_id'] = $author_picture_id;
}
$wrapper_classes = array(
	'g5ere__single-agent-head',
	'g5ere__sah-layout-01',
	'bg-white'
);
$wrapper_class   = implode( ' ', $wrapper_classes );
?>
<div class="<?php echo esc_attr( $wrapper_class ) ?>">
    <div class="container">
        <div class="row g5ere__sah-inner">
            <div class="col-xl-5 col-lg-6">
                <div class="g5core__post-featured g5ere__agent-featured">
					<?php g5ere_render_agent_thumbnail_markup( $image_arr ); ?>
                </div>
            </div>
            <div class="col-xl-7 col-lg-6">
                <div class="g5ere__agent-summary">
					<?php
					/**
					 * Hook: g5ere_author_info.
					 *
					 * @hooked g5ere_template_author_name - 5
					 * @hooked g5ere_template_loop_author_position - 10
					 * @hooked g5ere_template_author_meta - 15
					 *
					 */
					do_action( 'g5ere_author_info' );
					?>
                    <div class="g5ere__agent-summary-bottom d-flex flex-wrap align-items-center">
						<?php
						/**
						 * Hook: g5ere_author_info_bottom.
						 *
						 * @hooked g5ere_template_author_social - 30
						 *
						 */
						do_action( 'g5ere_author_info_bottom' );
						?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


