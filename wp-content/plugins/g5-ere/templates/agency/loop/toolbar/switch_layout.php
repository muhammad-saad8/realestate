<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$agency_layout = g5ere_get_agency_switch_layout();
$post_settings     = G5ERE()->listing_agency()->get_layout_settings();
$paged = get_query_var( 'paged' ) != 0 ? get_query_var( 'paged' ) : 1;
if ( isset( $post_settings['currentPage']['paged'] ) ) {
	$paged = $post_settings['currentPage']['paged'];
}
$base_link = html_entity_decode( get_pagenum_link($paged) );
?>
<div class="g5ere__switch-layout">
    <a class="<?php echo esc_attr( $agency_layout === 'list' ? 'active' : '' ) ?>"
       href="<?php echo esc_url( $link = add_query_arg( 'view', 'list', $base_link ) ) ?>"
       title="<?php esc_attr_e( 'List View', 'g5-ere' ) ?>" data-layout="list"><i class="fas fa-list-ul"></i></a>
    <a class="<?php echo esc_attr( $agency_layout === 'grid' ? 'active' : '' ) ?>"
       href="<?php echo esc_url( $link = add_query_arg( 'view', 'grid', $base_link ) ) ?>"
       title="<?php esc_attr_e( 'Grid View', 'g5-ere' ) ?>" data-layout="grid"><i class="fas fa-th-large"></i></a>
</div>