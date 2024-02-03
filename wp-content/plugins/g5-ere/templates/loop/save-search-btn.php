<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$data_target = '#ere_save_search_modal';
if ( ! is_user_logged_in() ) {
	$data_target = '#ere_signin_modal';
}
?>
<button type="button" class="btn btn-outline btn-dark" data-toggle="modal"
        data-target="<?php echo esc_attr( $data_target ); ?>">
    <span class="mr-2"><i class="fal fa-bell"></i></span>
	<?php esc_html_e( 'Save Search', 'g5-ere' ) ?>
</button>
