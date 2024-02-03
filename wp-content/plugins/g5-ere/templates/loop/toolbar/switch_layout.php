<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$property_layout = g5ere_get_property_switch_layout();
$paged = G5CORE()->query()->query_var_paged();
$base_link = html_entity_decode( get_pagenum_link($paged) );
?>
<div class="g5ere__switch-layout">
	<a class="<?php echo esc_attr($property_layout === 'list' ? 'active' : '')?>" href="<?php echo esc_url($link = add_query_arg('view','list',$base_link))?>" title="<?php esc_attr_e( 'List View', 'g5-ere' )?>" data-layout="list"><i class="fas fa-list-ul"></i></a>
	<a class="<?php echo esc_attr($property_layout === 'grid' ? 'active' : '')?>" href="<?php echo esc_url($link = add_query_arg('view','grid',$base_link))?>" title="<?php esc_attr_e( 'Grid View', 'g5-ere' )?>" data-layout="grid"><i class="fas fa-th-large"></i></a>
</div>