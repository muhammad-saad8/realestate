<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$virtual_tour = g5ere_get_property_virtual_tour();
if ( $virtual_tour ):
	?>
    <div class="g5ere__property-virtual-tour">
		<?php
		if ( $virtual_tour['property_image_360'] != '' && $virtual_tour['property_virtual_tour_type'] == '0' ) :?>
            <iframe width="100%" height="600" scrolling="no" allowfullscreen
                    src="<?php echo ERE_PLUGIN_URL . "public/assets/packages/vr-view/index.html?image=" . esc_url( $virtual_tour['property_image_360'] ); ?>"></iframe>
		<?php elseif ( $virtual_tour['property_virtual_tour'] != '' && $virtual_tour['property_virtual_tour_type'] == '1' ): ?>
			<?php echo( ! empty( $virtual_tour['property_virtual_tour'] ) ? do_shortcode( $virtual_tour['property_virtual_tour'] ) : '' ) ?>
		<?php endif;
		?>
    </div>
<?php
endif;
