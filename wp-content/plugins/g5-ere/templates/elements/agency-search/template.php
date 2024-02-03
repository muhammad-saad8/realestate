<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}
/**
 * @var $element UBE_Element_G5ERE_Property_Search_Form
 */
$settings = $element->get_settings_for_display();
$wrapper_classes = array(
	'g5element__agency-search',
	'g5ere__search-form'
);

$element->set_render_attribute('wrapper', array(
	'class' => $wrapper_classes
));

$keyword       = isset( $_REQUEST['key_word'] ) ? $_REQUEST['key_word'] : '';
$agency_page   = g5ere_get_agency_page();
$search_fields = array(
	'keyword',
	'submit-button',
);
$prefix        = uniqid();

?>
<div <?php $element->print_render_attribute_string('wrapper') ?>>
	<form method="get" autocomplete="off" action="<?php echo esc_url( get_page_link( $agency_page ) ); ?>">
		<div class="form-inline">
			<?php
			foreach ( $search_fields as $k => $v ) {
				G5ERE()->get_template( "agency/search-fields/{$v}.php", array( 'prefix' => $prefix ) );
			}
			?>
		</div>
		<?php g5ere_query_string_form_fields( null, array(
			'orderby',
			'submit',
			'paged',
			'key_word'
		) ); ?>
	</form>
</div>

