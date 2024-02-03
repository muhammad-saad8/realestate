<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $email
 * @var $phone
 * @var $agent_link
 * @var $agent_name
 * @var $avatar_id
 * @var $position
 */

$image_arr = array(
	'image_size'        => '50x50',
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


?>
<div class="g5ere__single-bottom-bar g5ere__single-property-bottom-bar-mobile position-fixed fixed-bottom">
	<div class="d-flex g5ere__single-property-bottom-bar p-2 justify-content-between">
		<div class="media align-items-center">
			<?php g5ere_render_thumbnail_markup( $image_arr ); ?>
			<div class="media-body">
				<?php
				do_action( 'g5ere_single_property_bottom_bar_agent_content', array(
						'agent_link' => $agent_link,
						'agent_name' =>$agent_name,
						'position' => $position
				)) ?>
			</div>
		</div>
		<div class="g5ere__single-property-bottom-bar-actions d-flex align-items-center flex-shrink-0">
			<div class="row mx-n1">
				<?php if ( isset( $email ) && ! empty( $email ) ): ?>
					<div class="col-6 px-1">
						<button type="button" class="btn btn-accent btn-block" data-toggle="modal"
						        data-target="#g5ere__modal_messenger"><i class="fal fa-comment"></i></button>
					</div>
				<?php endif; ?>
				<?php if ( isset( $phone ) && ! empty( $phone ) ): ?>
					<?php
					$tel     = preg_replace( "/\s+/", "", $phone );
					$tel_url = 'tel:' . $tel;
					?>
					<div class="col-6 px-1">
						<a href="<?php echo esc_attr( $tel_url ) ?>" class="btn btn-accent btn-block" target="_blank"><i
									class="fal fa-phone"></i></a>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
