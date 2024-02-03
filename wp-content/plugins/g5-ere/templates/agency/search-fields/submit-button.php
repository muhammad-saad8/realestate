<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$wrapper_classes = array(
	'form-group',
	'g5ere__search-field',
	'g5ere__sf-submit-button',
	'g5ere__agency-search-btn'
);
$wrapper_class   = implode( ' ', $wrapper_classes );
?>
<div class="<?php echo esc_attr( $wrapper_class ) ?>">
    <button class="btn btn-block g5ere__sf-btn-submit px-2"><?php esc_html_e( 'Search', 'g5-ere' ) ?></button>
</div>
