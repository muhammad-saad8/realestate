<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $prefix
 * @var $css_class_field
 */
$wrapper_classes = array(
	'form-group',
	'g5ere__search-field',
	'g5ere__sf-keyword',
	'g5ere__agency-search-field'
);
if ( isset( $css_class_field ) ) {
	$wrapper_classes[] = $css_class_field;
}
$wrapper_class = implode( ' ', $wrapper_classes );
$keyword       = isset( $_REQUEST['key_word'] ) ? $_REQUEST['key_word'] : '';
$agency_page   = g5ere_get_agency_page();
?>
<div class="<?php echo esc_attr( $wrapper_class ) ?>">
    <label class="g5ere__s-label"
           for="<?php echo esc_attr( $prefix ) ?>_keyword"><?php esc_html_e( 'Keyword', 'g5-ere' ) ?></label>
    <div class="input-group w-100">
        <input class="form-control" value="<?php echo esc_attr( $keyword ) ?>" name="key_word" type="text"
               placeholder="<?php esc_attr_e( 'Search by agency’s name...', 'g5-ere' ) ?>">
        <div class="input-group-append">
            <button class="input-group-text g5ere__sf-icon-submit"><i class="fal fa-search"></i></button>
        </div>

    </div>

</div>

