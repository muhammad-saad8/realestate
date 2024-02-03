<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $search_tabs
 * @var $prefix
 * @var $css_class_field
 */
$terms_status = ere_get_property_status_search();

if ( empty( $terms_status ) ) {
	return;
}
$first_status    = current( $terms_status );
$status_default  = $search_tabs === 'on-all-status' ? '' : $first_status->slug;
$value           = isset( $_REQUEST['status'] ) ? $_REQUEST['status'] : $status_default;
$wrapper_classes = array(
	'g5ere__search-tabs',
	'nav',
	'nav-pills'
);
if ( isset( $css_class_field ) ) {
	$wrapper_classes[] = $css_class_field;
}
$wrapper_class = implode( ' ', $wrapper_classes );


?>
<input type="hidden" name="status" value="<?php echo esc_attr( $value ) ?>">
<ul class="<?php echo esc_attr( $wrapper_class ) ?>" role="tablist" data-toggle="buttons">
	<?php if ( $search_tabs === 'on-all-status' ): ?>
        <li class="nav-item">
            <a data-val="" class="nav-link <?php echo esc_attr( $value === '' ? 'active' : '' ) ?>" href="#"
               data-toggle="pill"><?php esc_html_e( 'All Status', 'g5-ere' ) ?></a>
        </li>
	<?php endif; ?>
	<?php $index = 0; ?>
	<?php foreach ( $terms_status as $status ): ?>
        <li class="nav-item">
            <a data-val="<?php echo esc_attr( $status->slug ) ?>"
               class="nav-link <?php echo esc_attr( ( $value === $status->slug ) || ( $value == - 1 && $index == 0 ) ? 'active' : '' ) ?>"
               href="#" data-toggle="pill"><?php echo esc_html( $status->name ) ?></a>
        </li>
		<?php $index ++; ?>
	<?php endforeach; ?>
</ul>