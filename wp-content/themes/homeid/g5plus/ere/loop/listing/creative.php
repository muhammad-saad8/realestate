<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $image_size
 * @var $image_mode
 * @var $image_ratio
 * @var $placeholder
 * @var $post_classes
 * @var $post_inner_class
 * @var $columns_gutter
 */
G5CORE()->query()->set_cache('g5core_block_posts_count',3);
$total_block =  G5CORE()->query()->get_total_block();


$wrapper_classes = array(
	'g5core__listing-blocks',
	'row'
);

if ($columns_gutter !== '') {
	$wrapper_classes[] = "g5core__gutter-{$columns_gutter}";
}

$wrapper_class = implode(' ', $wrapper_classes);


?>
<?php for ($i = 0; $i < $total_block; $i++): ?>
	<?php
	G5CORE()->query()->delete_cache('g5core_block_posts_counter');
	if (!G5CORE()->query()->have_posts()) {
		break;
	}
	?>
	<div class="<?php echo esc_attr($wrapper_class)?>">
		<div class="col-xl-6 g5core__modern-grid-col">
			<?php
				if (G5CORE()->query()->have_posts()) {
					G5CORE()->query()->the_post();

					$current_layout = array(
						'template'       => 'skin-09',
					);

					$template = $current_layout['template'];
					$current_image_size = $image_size;

					$template_class = isset($current_layout['template_class']) ? $current_layout['template_class'] : "g5ere__property-{$template}";
					$posts_counter = absint(G5CORE()->query()->get_cache('g5core_block_posts_counter',1)) - 1;
					$current_post_classes = array(
						$template_class,
						"g5ere__property-item-{$posts_counter}"
					);

					$current_post_classes = wp_parse_args($current_post_classes, $post_classes);
					$current_post_class = join(' ', $current_post_classes);

					$post_inner_attributes = array();

					$post_attributes = g5ere_get_property_attributes();

					G5ERE()->get_template( "loop/listing/item/{$template}.php", array(
						'image_size'            => $image_size,
						'image_ratio'           => $image_ratio,
						'post_class'            => $current_post_class,
						'post_inner_class'      => $post_inner_class,
						'post_attributes' => $post_attributes,
						'post_inner_attributes' => $post_inner_attributes,
						'image_mode'            => $image_mode,
						'placeholder'           => $placeholder,
						'template'              => $template
					) );



					$current_layout = array(
						'template'       => 'skin-list-04',
					);

					$template = $current_layout['template'];
					$current_image_size = $image_size;

					$template_class = isset($current_layout['template_class']) ? $current_layout['template_class'] : "g5ere__property-{$template}";
					$posts_counter = absint(G5CORE()->query()->get_cache('g5core_block_posts_counter',1)) - 1;
					$current_post_classes = array(
						$template_class,
						"g5ere__property-item-{$posts_counter}"
					);

					$current_post_classes = wp_parse_args($current_post_classes, $post_classes);
					$current_post_class = join(' ', $current_post_classes);

					$post_inner_attributes = array();
					$post_attributes = g5ere_get_property_attributes();

					G5ERE()->get_template( "loop/listing/item/{$template}.php", array(
						'image_size'            => $image_size,
						'image_ratio'           => $image_ratio,
						'post_class'            => $current_post_class,
						'post_inner_class'      => $post_inner_class,
						'post_attributes' => $post_attributes,
						'post_inner_attributes' => $post_inner_attributes,
						'image_mode'            => $image_mode,
						'placeholder'           => $placeholder,
						'template'              => $template
					) );


				}
			?>
		</div>
		<div class="col-xl-6 g5core__modern-grid-col">
			<?php
				if (G5CORE()->query()->have_posts()) {
					 while (G5CORE()->query()->have_posts()) {
						 G5CORE()->query()->the_post();

						 $current_layout = array(
							 'template'       => 'skin-list-04',
						 );

						 $template = $current_layout['template'];
						 $current_image_size = $image_size;

						 $template_class = isset($current_layout['template_class']) ? $current_layout['template_class'] : "g5ere__property-{$template}";
						 $posts_counter = absint(G5CORE()->query()->get_cache('g5core_block_posts_counter',1)) - 1;
						 $current_post_classes = array(
							 $template_class,
							 "g5ere__property-item-{$posts_counter}"
						 );

						 $current_post_classes = wp_parse_args($current_post_classes, $post_classes);
						 $current_post_class = join(' ', $current_post_classes);

						 $post_inner_attributes = array();
						 $post_attributes = g5ere_get_property_attributes();

						 G5ERE()->get_template( "loop/listing/item/{$template}.php", array(
							 'image_size'            => $image_size,
							 'image_ratio'           => $image_ratio,
							 'post_class'            => $current_post_class,
							 'post_inner_class'      => $post_inner_class,
							 'post_attributes' => $post_attributes,
							 'post_inner_attributes' => $post_inner_attributes,
							 'image_mode'            => $image_mode,
							 'placeholder'           => $placeholder,
							 'template'              => $template
						 ) );
					 }
				}
			?>
		</div>
	</div>
<?php endfor; ?>
