<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $search_fields array
 * @var $other_features
 * @var $price_range_slider
 * @var $size_range_slider
 * @var $land_area_range_slider
 * @var $data G5ERE_Search_Form
 * @var $prefix
 */
$fields = g5ere_get_search_builtIn_fields();
$wrapper_classes = array(
	'g5ere__search-form',
	'g5ere__search-form-mobile'
);
$wrapper_class = implode(' ', apply_filters('g5ere_search_form_mobile_wrapper_classes',$wrapper_classes));
?>
<div data-prefix="<?php echo esc_attr($prefix)?>" class="<?php echo esc_attr($wrapper_class)?>">
	<form data-url="<?php echo esc_url(wp_nonce_url(admin_url('admin-ajax.php?action=g5ere_get_auto_complete_search'), 'g5ere_get_auto_complete_search')) ?>" method="get" autocomplete="off" action="<?php echo esc_url( get_post_type_archive_link('property') ); ?>">
		<div class="g5ere__sf-top form-inline">
			<?php G5ERE()->get_template("search-fields/keyword-mobile.php",array('prefix' => $prefix)) ?>
		</div>
		<?php if (is_array($search_fields) && !empty($search_fields)): ?>
			<div id="<?php echo esc_attr($prefix)?>_bottom" class="g5ere__sf-bottom-wrap collapse">
				<div class="g5ere__sf-bottom">
					<div class="g5ere__sf-bottom-inner row">
						<?php foreach ($search_fields as $k => $v) {
							if (in_array($k,$fields)) {
								G5ERE()->get_template("search-fields/{$k}.php",array('prefix' => $prefix,'css_class_field' => 'col col-md-6 col-12'));
							} else {
								g5ere_template_custom_search_field($k,array('prefix' => $prefix,'css_class_field' => 'col col-md-6 col-12'));
							}
						} ?>
					</div>
					<div class="g5ere__sf-bottom-slider row">
						<?php
							if ($price_range_slider === 'on') {
								G5ERE()->get_template('search-fields/price-range.php', array('css_class_field' => 'col col-md-6 col-12'));
							}

							if ($size_range_slider === 'on') {
								G5ERE()->get_template('search-fields/size-range.php', array('css_class_field' => 'col col-md-6 col-12'));
							}

							if ($land_area_range_slider === 'on') {
								G5ERE()->get_template('search-fields/land-range.php', array('css_class_field' => 'col col-md-6 col-12'));
							}
						?>
					</div>
					<?php
						if ($other_features === 'on') {
							G5ERE()->get_template('search-fields/other-feature.php',array('prefix' => $prefix, 'css_class_field' => 'col col-md-4 col-6'));
						}

						G5ERE()->get_template( 'search-fields/submit-button.php' );
					?>
				</div>
			</div>
		<?php endif; ?>
		<input type="hidden" name="post_type" value="property">
		<input type="hidden" name="s" value="">
		<?php g5ere_query_string_search_form_fields(); ?>
	</form>
</div>
