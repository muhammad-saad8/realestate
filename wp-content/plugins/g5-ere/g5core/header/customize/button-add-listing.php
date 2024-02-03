<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

?>
<a href="<?php echo esc_url( ere_get_permalink( 'submit_property' ) ) ?>" class="btn btn-outline btn-listing"
   title="<?php esc_attr_e( 'Add Listing', 'g5-ere' ) ?>">
    <span><?php esc_html_e( 'Add listing', 'g5-ere' ) ?></span>
    <i class="far fa-home"></i>
</a>