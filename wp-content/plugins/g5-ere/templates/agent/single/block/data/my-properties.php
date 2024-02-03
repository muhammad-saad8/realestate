<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$listing_layout       = G5ERE()->options()->get_option( 'single_agent_my_property_post_layout', 'grid' );
$skin_item            = G5ERE()->options()->get_option( 'single_agent_my_property_item_skin', 'skin-01' );
$columns_xl           = absint( G5ERE()->options()->get_option( 'single_agent_my_property_post_columns_xl', '2' ) );
$columns_lg           = absint( G5ERE()->options()->get_option( 'single_agent_my_property_post_columns_lg', '2' ) );
$columns_md           = absint( G5ERE()->options()->get_option( 'single_agent_my_property_post_columns_md', '1' ) );
$columns_sm           = absint( G5ERE()->options()->get_option( 'single_agent_my_property_post_columns_sm', '1' ) );
$columns              = absint( G5ERE()->options()->get_option( 'single_agent_my_property_post_columns', '1' ) );
$columns_gutter       = absint(G5ERE()->options()->get_option( 'single_agent_my_property_post_columns_gutter', '30' ));
$image_size           = G5ERE()->options()->get_option( 'single_agent_my_property_post_image_size', 'full' );
$image_ratio          = G5ERE()->options()->get_option( 'single_agent_my_property_post_image_ratio', '' );
$properties_per_page  = absint( G5ERE()->options()->get_option( 'single_agent_my_property_per_page', 4 ) );
$properties_paging    = G5ERE()->options()->get_option( 'single_agent_my_property_post_paging', 'none' );
$properties_animation = G5ERE()->options()->get_option( 'single_agent_my_property_post_animation' );
$item_custom_class    = G5ERE()->options()->get_option( 'single_agent_my_property_item_custom_class' );

$query_args = $query_args = G5ERE()->query()->get_agent_property_query_args();
if ($listing_layout === 'list') {
	$skin_item            = G5ERE()->options()->get_option( 'single_agent_my_property_list_item_skin', 'skin-list-01' );
	$columns_xl           = 1;
	$columns_lg           = 1;
	$columns_md           = 1;
	$columns_sm           = 1;
	$columns              = 1;
	$image_size           = G5ERE()->options()->get_option( 'single_agent_my_property_post_list_image_size', 'full' );
	$image_ratio          = G5ERE()->options()->get_option( 'single_agent_my_property_post_list_image_ratio', '' );
	$item_custom_class    = G5ERE()->options()->get_option( 'single_agent_my_property_list_item_custom_class' );
}

$settings             = array(
	'post_layout'        => $listing_layout,
	'item_skin'          => $skin_item,
	'item_custom_class'  => $item_custom_class,
	'columns_gutter'     => $columns_gutter,
	'image_size'         => $image_size,
	'image_ratio'        => $image_ratio,
	'post_paging'        => $properties_paging,
	'post_animation'     => $properties_animation,
);
$taxonomy_filter_enable = G5ERE()->options()->get_option('single_agent_my_property_taxonomy_filter_enable');
if ($taxonomy_filter_enable === 'on') {
	$taxonomy_filter = G5ERE()->options()->get_option('single_agent_my_property_taxonomy_filter','property-status');
	$settings['cate_filter_enable'] = true;
	$settings['taxonomy'] = $taxonomy_filter;
}
if ( $properties_paging !== 'slider' ) {
	$settings['post_columns'] = array(
		'xl' => $columns_xl,
		'lg' => $columns_lg,
		'md' => $columns_md,
		'sm' => $columns_sm,
		''   => $columns
	);
} else {
	$settings['post_paging'] = '';
	$settings['slick']       = array(
		'arrows'         => false,
		'dots'           => true,
		'slidesToShow'   => $columns_xl,
		'slidesToScroll' => $columns_xl,
		'autoplay'       => false,
		'responsive'     => array(
			array(
				'breakpoint' => 1200,
				'settings'   => array(
					'slidesToShow'   => $columns_lg,
					'slidesToScroll' => $columns_lg,
				)
			),
			array(
				'breakpoint' => 992,
				'settings'   => array(
					'slidesToShow'   => $columns_md,
					'slidesToScroll' => $columns_md,
				)
			),
			array(
				'breakpoint' => 768,
				'settings'   => array(
					'slidesToShow'   => $columns_sm,
					'slidesToScroll' => $columns_sm,
				)
			),
			array(
				'breakpoint' => 576,
				'settings'   => array(
					'slidesToShow'   => $columns,
					'slidesToScroll' => $columns,
				)
			)
		)
	);
}
?>
<div class="g5ere__agent-my-properties">
	<?php G5ERE()->listing()->render_content( $query_args, $settings ); ?>
</div>

