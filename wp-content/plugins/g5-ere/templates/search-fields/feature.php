<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $css_class_field
 * @var $prefix
 */
$value           = isset( $_GET['feature'] ) ? wp_filter_kses( wp_unslash( $_GET['feature'] ) ) : '';
$value = explode(';',$value);
$wrapper_classes = array(
	'form-group',
	'g5ere__search-field',
	'g5ere__sf-feature'
);
if ( isset( $css_class_field ) ) {
	$wrapper_classes[] = $css_class_field;
}
$wrapper_class = implode( ' ', $wrapper_classes );

$property_features = get_terms( array(
	'taxonomy'   => 'property-feature',
	'hide_empty' => 0,
	'orderby'    => 'term_id',
	'order'      => 'ASC'
) );

?>
<div class="g5ere__features-list row">
	<?php foreach ( $property_features as $feature ): ?>
		<div class="<?php echo esc_attr( $wrapper_class ) ?>">
			<?php $feature_id = $prefix . $feature->slug ?>
			<div class="custom-control custom-checkbox">
				<?php if ( is_array( $value ) && in_array( $feature->slug, $value ) ): ?>
					<input type="checkbox" name="feature" id="<?php echo esc_attr( $feature_id ) ?>"
					       class="custom-control-input" value="<?php echo esc_attr( $feature->slug ) ?>" checked="checked">
				<?php else: ?>
					<input type="checkbox" name="feature" id="<?php echo esc_attr( $feature_id ) ?>"
					       class="custom-control-input" value="<?php echo esc_attr( $feature->slug ) ?>">
				<?php endif; ?>
				<label class="custom-control-label" for="<?php echo esc_attr( $feature_id ) ?>"><?php echo esc_html( $feature->name ) ?></label>
			</div>
		</div>
	<?php endforeach; ?>
</div>