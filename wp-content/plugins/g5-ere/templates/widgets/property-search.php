<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $search_fields
 * @var $price_range_slider
 * @var $size_range_slider
 * @var $land_area_range_slider
 * @var $other_features
 * @var $prefix
 */
$fields = g5ere_get_search_builtIn_fields();
$wrapper_classes = array(
	'g5ere__search-form',
	'g5ere__search-form-widget'
);
$wrapper_class   = implode( ' ', $wrapper_classes );
?>
<div data-prefix="<?php echo esc_attr( $prefix ) ?>" class="<?php echo esc_attr( $wrapper_class ) ?>">
	<form method="get" autocomplete="off" action="<?php echo esc_url( get_post_type_archive_link( 'property' ) ); ?>">
		<div class="row">
			<?php
			$css_class_field = 'col-12';
			foreach ( $search_fields as $k => $v ) {
				if ( in_array( $k, array(
					'min-price',
					'max-price',
					'min-size',
					'max-size',
					'min-land',
					'max-land'
				) ) ) {
					$css_class_field = 'col-6';
				} else {
					$css_class_field = 'col-12';
				}

				if (in_array($k,$fields)) {
					G5ERE()->get_template( "search-fields/{$k}.php", array(
						'prefix'          => $prefix,
						'css_class_field' => $css_class_field
					) );
				} else {
					g5ere_template_custom_search_field($k,array('prefix' => $prefix, 'css_class_field' => $css_class_field));
				}
			}
			?>
		</div>
		<?php if ( $other_features ): ?>
			<?php G5ERE()->get_template( 'search-fields/other-feature.php', array(
				'prefix'          => $prefix,
				'css_class_field' => 'col-12'
			) ) ?>
		<?php endif; ?>
		<?php G5ERE()->get_template( 'search-fields/submit-button.php' ) ?>
		<input type="hidden" name="post_type" value="property">
		<input type="hidden" name="s" value="">
		<?php g5ere_query_string_search_form_fields(); ?>
	</form>
</div>

