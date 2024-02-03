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
G5CORE()->query()->set_cache('g5core_block_posts_count',5);
$total_block =  G5CORE()->query()->get_total_block();


$wrapper_classes = array(
	'g5core__listing-blocks'
);

if ($columns_gutter !== '') {
	$wrapper_classes[] = "g5core__metro-gutter-{$columns_gutter}";
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
		<div class="row no-gutters">
			<div class="col-xl-8">
				<div class="row no-gutters">
					<?php for ($i = 0; $i < 4; $i++): ?>
						<?php if (G5CORE()->query()->have_posts()): ?>
							<?php G5CORE()->query()->the_post();?>
							<div class="col-lg-6">
								<?php
								ob_start();
								$current_layout = array(
									'template'       => 'skin-metro-01',
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


								$content  = ob_get_clean();


								g5core_render_metro_image_markup( array(
									'image_size'     => $image_size,
									'image_ratio'    => $image_ratio,
									'columns_gutter' => $columns_gutter,
									'layout_ratio'   => '1x1',
									'display_zoom' => false,
									'content' => $content,
									'custom_class' => 'g5ere__property-featured g5ere__post-featured-bg-gradient'
								) );
								?>
							</div>
						<?php endif; ?>
					<?php endfor; ?>
				</div>
			</div>
			<div class="col-xl-4">
				<?php
				if (G5CORE()->query()->have_posts()) {
					G5CORE()->query()->the_post();

					ob_start();
					$current_layout = array(
						'template'       => 'skin-metro-01',
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
						'template'              => $template,
					) );


					$content  = ob_get_clean();


					g5core_render_metro_image_markup( array(
						'image_size'     => $image_size,
						'image_ratio'    => $image_ratio,
						'columns_gutter' => $columns_gutter,
						'layout_ratio'   => '1x2',
						'display_zoom' => false,
						'content' => $content,
						'custom_class' => 'g5ere__property-featured g5ere__post-featured-bg-gradient'
					) );

				}
				?>
			</div>
		</div>
	</div>
<?php endfor; ?>
