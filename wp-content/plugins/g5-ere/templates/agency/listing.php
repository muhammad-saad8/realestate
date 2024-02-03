<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $agencies WP_Term[]
 * @var $query_args
 */
$post_settings     = &G5ERE()->listing_agency()->get_layout_settings();
$post_layout       = isset( $post_settings['post_layout'] ) ? $post_settings['post_layout'] : 'grid';
$item_custom_class = isset( $post_settings['item_custom_class'] ) ? $post_settings['item_custom_class'] : '';
$post_paging       = isset( $post_settings['post_paging'] ) ? $post_settings['post_paging'] : 'pagination';
$layout_matrix     = G5ERE()->listing_agency()->get_layout_matrix( $post_layout );
$image_size        = isset( $layout_matrix['image_size'] ) ? $layout_matrix['image_size'] : ( isset( $post_settings['image_size'] ) ? $post_settings['image_size'] : 'full' );
$image_mode        = isset( $layout_matrix['image_mode'] ) ? $layout_matrix['image_mode'] : ( isset( $post_settings['image_mode'] ) ? $post_settings['image_mode'] : '' );
$placeholder       = isset( $layout_matrix['placeholder'] ) ? $layout_matrix['placeholder'] : ( isset( $post_settings['placeholder'] ) ? $post_settings['placeholder'] : '' );
$layout_settings   = isset( $layout_matrix['layout'] ) ? $layout_matrix['layout'] : '';
$columns           = isset( $layout_matrix['columns'] ) ? $layout_matrix['columns'] : ( isset( $post_settings['post_columns'] ) ? $post_settings['post_columns'] : '' );
$columns_gutter    = isset( $layout_matrix['columns_gutter'] ) ? $layout_matrix['columns_gutter'] : ( isset( $post_settings['columns_gutter'] ) ? $post_settings['columns_gutter'] : '' );
$post_index_start  = absint( isset( $post_settings['index'] ) ? $post_settings['index'] : 0 );
$post_animation    = isset( $post_settings['post_animation'] ) ? $post_settings['post_animation'] : '';
$slick             = isset( $post_settings['slick'] ) ? $post_settings['slick'] : ( isset( $layout_matrix['slick'] ) ? $layout_matrix['slick'] : '' );
$slider_rows       = absint( isset( $post_settings['slider_rows'] ) ? $post_settings['slider_rows'] : ( isset( $layout_matrix['slider_rows'] ) ? $layout_matrix['slider_rows'] : 1 ) );
$image_ratio       = '';


if ( $image_size === 'full' ) {
	$image_ratio_custom = isset( $post_settings['image_ratio'] ) ? $post_settings['image_ratio'] : G5ERE()->options()->get_option( 'agency_image_ratio' );
	if ( is_array( $image_ratio_custom ) && $image_ratio_custom['width'] != '' && $image_ratio_custom['height'] != '' ) {
		$image_ratio_custom_width  = intval( $image_ratio_custom['width'] );
		$image_ratio_custom_height = intval( $image_ratio_custom['height'] );
		if ( ( $image_ratio_custom_width > 0 ) && ( $image_ratio_custom_height > 0 ) ) {
			$image_ratio = "{$image_ratio_custom_width}x{$image_ratio_custom_height}";

		}
		$image_mode = 'background';
	} else {
		$image_mode = 'image';
	}
}


$wrapper_classes = array(
	'g5ere__listing-wrap',
	"g5ere__listing-agency-layout-{$post_layout}"
);

$wrapper_attributes = array();

$inner_attributes = array(
	'data-items-container'
);

$inner_classes = array(
	'g5ere__listing-inner',
);

$post_classes       = array(
	'g5core__gutter-item',
	'g5ere__agency-item',
	$item_custom_class
);
$post_inner_classes = array(
	'g5ere__agency-item-inner',
	'g5ere__loop-item-inner',
	g5core_get_animation_class( $post_animation )
);

if ( isset( $post_settings['isMainQuery'] ) ) {
	$wrapper_attributes[] = 'data-archive-wrapper';
}

if ( $slick !== '' ) {
	$inner_classes[]    = 'slick-slider';
	$inner_attributes[] = "data-slick-options='" . esc_attr( json_encode( $slick ) ) . "'";
	if ( $columns_gutter !== '' ) {
		if ( $slider_rows > 1 ) {
			$inner_classes[] = 'slick-slider-rows';
			$inner_classes[] = "g5core__gutter-slider-rows-{$columns_gutter}";
		} else {
			$inner_classes[] = "g5core__gutter-{$columns_gutter}";
		}
	}
} else {
	if ( $layout_settings !== '' ) {
		$inner_classes[] = 'row';
		if ( $columns !== '' ) {
			if ( $columns === 1 ) {
				$inner_classes[] = 'no-gutters';
			}
		}

		if ( $columns_gutter !== '' ) {
			$inner_classes[] = "g5core__gutter-{$columns_gutter}";
		}

	}
}


$settingId                  = isset( $post_settings['settingId'] ) ? $post_settings['settingId'] : uniqid();
$post_settings['settingId'] = $settingId;
$wrapper_attributes[]       = sprintf( 'data-items-wrapper="%s"', $settingId );

$wrapper_class    = join( ' ', $wrapper_classes );
$inner_class      = join( ' ', $inner_classes );
$post_inner_class = join( ' ', $post_inner_classes );
?>
<?php if ( $agencies ):
	?>
    <div <?php echo join( ' ', $wrapper_attributes ); ?> class="<?php echo esc_attr( $wrapper_class ) ?>">
		<?php
		// You can use this for adding codes before the main loop
		do_action( 'g5core_before_listing_agency_wrapper', $post_settings, $query_args );
		?>

        <div <?php echo join( ' ', $inner_attributes ); ?> class="<?php echo esc_attr( $inner_class ); ?>">
			<?php
			if ( is_array( $layout_settings ) ) {
				$index = $post_index_start;
				foreach ( $agencies as $agency ) {
					do_action( 'g5ere_loop_agency', $agency );
					$index          = $index % sizeof( $layout_settings );
					$current_layout = $layout_settings[ $index ];
					$isFirst        = isset( $current_layout['isFirst'] ) ? $current_layout['isFirst'] : false;
					if ( $isFirst && ( $paged > 1 ) && in_array( $post_paging, array(
							'load-more',
							'infinite-scroll'
						) )
					) {
						$k = $index;
						while ( $isFirst ) {
							if ( isset( $layout_settings[ $k + 1 ] ) ) {
								$current_layout = $layout_settings[ $k + 1 ];
								$isFirst        = isset( $current_layout['isFirst'] ) ? $current_layout['isFirst'] : false;
								$k ++;
							} else {
								continue;
							}
						}
					}
					$template = $current_layout['template'];

					$template_class       = isset( $current_layout['template_class'] ) ? $current_layout['template_class'] : "g5ere__agency-{$template}";
					$post_index           = intval( G5CORE()->query()->get_query()->current_post ) + 1;
					$current_post_classes = array(
						$template_class,
						"g5ere__agency-item-{$post_index}"
					);
					if ( $slick === '' ) {
						$current_columns = isset( $current_layout['columns'] ) ? $current_layout['columns'] : $columns;
						if ( $current_columns !== '' ) {
							$current_post_classes[] = is_array( $current_columns ) ? g5core_get_bootstrap_columns( $current_columns ) : ( $current_columns === 1 ? 'col-12' : $current_columns );
						}
					}


					$current_image_size  = isset( $current_layout['image_size'] ) ? $current_layout['image_size'] : $image_size;
					$current_image_ratio = $image_ratio;

					$current_post_classes  = wp_parse_args( $current_post_classes, $post_classes );
					$current_post_class    = join( ' ', $current_post_classes );
					$post_inner_attributes = array();

					do_action( 'g5ere_before_get_template_listing_agency_item', $template );
					G5ERE()->get_template( "agency/loop/listing/item/{$template}.php", array(
						'image_size'            => $current_image_size,
						'image_ratio'           => $current_image_ratio,
						'post_class'            => $current_post_class,
						'post_inner_class'      => $post_inner_class,
						'post_inner_attributes' => $post_inner_attributes,
						'image_mode'            => $image_mode,
						'placeholder'           => $placeholder,
						'template'              => $template,
					) );
					do_action( 'g5ere_after_get_template_listing_agency_item', $template );

					if ( $isFirst ) {
						unset( $layout_settings[ $index ] );
						$layout_settings = array_values( $layout_settings );
					}

					if ( $isFirst && $paged === 1 ) {
						$index = 0;
					} else {
						$index ++;
					}
				}
			} else {
				G5ERE()->get_template( "agency/loop/listing/{$post_layout}.php", array(
					'post_classes'     => $post_classes,
					'post_inner_class' => $post_inner_class,
					'columns_gutter'   => $columns_gutter,
					'image_size'       => $image_size,
					'image_mode'       => $image_mode,
					'image_ratio'      => $image_ratio,
					'placeholder'      => $placeholder,
				) );
			}

			?>
        </div>
		<?php
		// You can use this for adding codes before the main loop
		do_action( 'g5core_after_listing_agency_wrapper', $post_settings, $query_args );
		?>
    </div>
<?php elseif ( isset( $post_settings['isMainQuery'] ) ): ?>
	<?php G5ERE()->get_template( 'agency/loop/content-none.php' ); ?>
<?php endif; ?>
