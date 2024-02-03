<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
add_action( 'vc_after_init', 'g5element_custom_vc_single_image_add_param' );
function g5element_custom_vc_single_image_add_param() {
    $param_onclick               = WPBMap::getParam( 'vc_single_image', 'onclick' );
    if ($param_onclick) {
	    $param_onclick['value']      = array_merge(  $param_onclick['value'],array(
		    esc_html__( 'Open magnificPopup', 'g5-element' ) => 'magnific',
	    ) );
	    vc_update_shortcode_param( 'vc_single_image', $param_onclick );
    }

}