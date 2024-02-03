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
	'g5element__agent-search',
	'g5ere__search-form'
);

$element->set_render_attribute('wrapper', array(
	'class' => $wrapper_classes
));

$prefix = uniqid();
$search_fields = array(
	'agency',
	'keyword',
	'submit-button',
);

?>
<div <?php $element->print_render_attribute_string('wrapper') ?>>
    <form method="get" autocomplete="off" action="<?php echo esc_url(home_url('/')); ?>">
        <div class="g5ere__asf-top g5ere__sf-top form-inline">
			<?php
			foreach ($search_fields as $k => $v) {
				G5ERE()->get_template("agent/search-fields/{$v}.php", array('prefix' => $prefix));
			}
			?>
            <input type="hidden" name="post_type" value="agent">
			<?php g5ere_query_string_form_fields(null, array(
				'orderby',
				'submit',
				'paged',
				'company',
				'q',
				'post_type',
				's'
			)); ?>
        </div>
    </form>
</div>

