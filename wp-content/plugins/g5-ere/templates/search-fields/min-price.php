<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $prefix
 * @var $css_class_field
 */
$value           = isset( $_REQUEST['min-price'] ) ? ere_clean( wp_unslash( $_REQUEST['min-price'] ) ) : '';
$status          = isset( $_REQUEST['status'] ) ? $_REQUEST['status'] : '';
$wrapper_classes = array(
	'form-group',
	'g5ere__search-field',
	'g5ere__sf-min-price'
);
if ( isset( $css_class_field ) ) {
	$wrapper_classes[] = $css_class_field;
}
$wrapper_class = implode( ' ', $wrapper_classes );
?>
<div class="<?php echo esc_attr( $wrapper_class ) ?>">
	<label class="g5ere__s-label" for="<?php echo esc_attr( $prefix ) ?>_min_price"><?php esc_html_e( 'Min Price', 'g5-ere' ) ?></label>
	<select id="<?php echo esc_attr( $prefix ) ?>_min_price" name="min-price" class="form-control selectpicker" data-live-search="true">
		<option value='' <?php selected( $value, '' ) ?>>
			<?php esc_html_e( 'Min Price', 'g5-ere' ) ?>
		</option>
		<?php
		$property_price_dropdown_min = apply_filters( 'ere_price_dropdown_min_default', ere_get_option( 'property_price_dropdown_min', '0,100,300,500,700,900,1100,1300,1500,1700,1900' ) );
		if ( $status !== '' ) {
			$property_price_dropdown_search_field = ere_get_option( 'property_price_dropdown_search_field', '' );
			if ( $property_price_dropdown_search_field != '' ) {
				foreach ( $property_price_dropdown_search_field as $data ) {
					$term_id = ( isset( $data['property_price_dropdown_property_status'] ) ? $data['property_price_dropdown_property_status'] : '' );
					$term    = get_term_by( 'id', $term_id, 'property-status' );
					if ( $term ) {
						if ( $term->slug === $status ) {
							$property_price_dropdown_min = ( isset( $data['property_price_dropdown_min'] ) ? $data['property_price_dropdown_min'] : $property_price_dropdown_min );
							break;
						}
					}
				}
			}
		}
		$property_price_array = explode( ',', $property_price_dropdown_min );
		if ( is_array( $property_price_array ) && ! empty( $property_price_array ) ) {
			foreach ( $property_price_array as $n ) {
				?>
				<option value="<?php echo esc_attr( $n ) ?>" <?php selected( $n, $value ) ?>>
					<?php echo ere_get_format_money_search_field( $n ) ?>
				</option>
				<?php
			}
		} ?>
	</select>
</div>
