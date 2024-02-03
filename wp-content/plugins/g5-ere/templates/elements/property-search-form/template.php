<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $element UBE_Element_G5ERE_Property_Search_Form
 */
$settings        = $element->get_settings_for_display();
$wrapper_classes = array(
	'g5element__property-search-form'
);

$search_form = isset($settings['search_form']) ? $settings['search_form'] : '';

$element->set_render_attribute( 'wrapper', array(
	'class' => $wrapper_classes
) );
?>
<div <?php $element->print_render_attribute_string('wrapper') ?>>
	<?php g5ere_template_search_form($search_form) ?>
</div>

