<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$wrapper_classes = array(
	'g5ere__search-form',
	'g5ere__search-form-widget'
);

$wrapper_class   = implode( ' ', $wrapper_classes );
$agency_page     = g5ere_get_agency_page();
$search_fields   = array(
	'keyword',
);
$prefix          = uniqid();
?>
<div class="<?php echo esc_attr( $wrapper_class ) ?>">
    <form method="get" autocomplete="off" action="<?php echo esc_url( get_page_link( $agency_page ) ); ?>">
		<?php
		foreach ( $search_fields as $k => $v ) {
			G5ERE()->get_template( "agency/search-fields/{$v}.php", array( 'prefix' => $prefix ) );
		}
		?>
		<?php g5ere_query_string_form_fields( null, array(
			'orderby',
			'submit',
			'paged',
			'key_word'
		) ); ?>
    </form>
</div>