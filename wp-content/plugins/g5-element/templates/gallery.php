<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $images
 * @var $layout
 * @var $columns_gutter
 * @var $post_animation
 * @var $hover_effect
 * @var $hover_image_effect
 * @var $el_id
 * @var $el_class
 * @var $columns_xl
 * @var $columns_lg
 * @var $columns_md
 * @var $columns_sm
 * @var $columns
 * @var $image_size
 * @var $image_width
 * @var $image_ratio_width
 * @var $image_ratio_height
 * @var $justified_row_height
 * @var $justified_row_max_height
 * @var $animation_style
 * @var $animation_duration
 * @var $animation_delay
 * @var $css_editor
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_G5Element_Gallery
 */

$images = $layout = $columns_gutter = $post_animation = $hover_effect = $hover_image_effect =
$el_id = $el_class =
$columns_xl = $columns_lg = $columns_md = $columns_sm = $columns =
$image_size = $image_width = $image_ratio_width = $image_ratio_height =
$justified_row_height = $justified_row_max_height =
$animation_style = $animation_duration = $animation_delay = $css_editor = $responsive = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);
G5ELEMENT()->assets()->enqueue_assets_for_shortcode('gallery');

$images = array_filter(explode(',', $images),'strlen') ;
if (count($images) === 0) return;
$columns_gutter = absint($columns_gutter);
$columns_xl = absint($columns_xl);
$columns_lg = absint($columns_lg);
$columns_md = absint($columns_md);
$columns_sm = absint($columns_sm);
$columns = absint($columns);
$justified_row_height = absint($justified_row_height);
$justified_row_max_height = absint($justified_row_max_height);

$columns = array(
    'xl' => $columns_xl,
    'lg' => $columns_lg,
    'md' => $columns_md,
    'sm' => $columns_sm,
    '' => $columns
);



$justified_options = array();
if ($layout === 'justified') {
    $justified_options = array(
        'rowHeight' => $justified_row_height > 0 ? $justified_row_height : 200,
        'maxRowHeight' => $justified_row_max_height > 0 ? $justified_row_max_height : false,
        'margins' => $columns_gutter,
        'selector' => '.g5element__gallery-item',
        'imgSelector' => '.g5core__entry-thumbnail-image > img'
    );
}


$layout_matrix_config = apply_filters('g5element_gallery_layout_matrix',array(
    'grid' => array(
        'layout' => array(
            array()
        ),
    ),
    'masonry'        => array(
        'layout'         => array(
            array(),
        ),
        'image_mode'         => 'image',
        'isotope'        => array(
            'itemSelector' => '.g5element__gallery-item',
            'layoutMode'   => 'masonry',
        ),
    ),
    'masonry-2' => array(
        'isotope'        => array(
            'itemSelector' => '.g5element__gallery-item',
            'layoutMode'   => 'masonry',
        ),
        'layout' => array(
            array('columns' => g5core_get_bootstrap_columns(array('xl' => 3, 'lg' => 3, 'md' => 3, 'sm' => 2, '' => 1)),  'layout_ratio' => '1x1'),
            array('columns' => g5core_get_bootstrap_columns(array('xl' => 3, 'lg' => 3, 'md' => 3, 'sm' => 2, '' => 1)),  'layout_ratio' => '1x1.55'),
            array('columns' => g5core_get_bootstrap_columns(array('xl' => 3, 'lg' => 3, 'md' => 3, 'sm' => 2, '' => 1)),  'layout_ratio' => '1x1'),
            array('columns' => g5core_get_bootstrap_columns(array('xl' => 3, 'lg' => 3, 'md' => 3, 'sm' => 2, '' => 1)),  'layout_ratio' => '1x1.55'),
            array('columns' => g5core_get_bootstrap_columns(array('xl' => 3, 'lg' => 3, 'md' => 3, 'sm' => 2, '' => 1)),  'layout_ratio' => '1x1.55'),
            array('columns' => g5core_get_bootstrap_columns(array('xl' => 3, 'lg' => 3, 'md' => 3, 'sm' => 2, '' => 1)),  'layout_ratio' => '1x1'),

        )
    ),
    'justified' =>  array(
        'layout'         => array(
            array(),
        ),
        'image_mode'         => 'image',
        'image_size' => 'full',
        'justified' => $justified_options
    )
));

$layout_matrix = isset($layout_matrix_config[$layout]) ? $layout_matrix_config[$layout] : '';
//if (!is_array($layout_matrix) || $layout_matrix === '') return;
$layout_settings = isset($layout_matrix['layout']) ? $layout_matrix['layout'] : '';
$justified = isset($layout_matrix['justified']) ? $layout_matrix['justified'] : '';
$image_mode = isset($layout_matrix['image_mode']) ? $layout_matrix['image_mode'] : '';
$image_size = isset($layout_matrix['image_size']) ? $layout_matrix['image_size'] : $image_size;
$image_lazy_load = g5element_lazy_load_is_active();


if ($layout === 'masonry') {
    $image_width = absint($image_width);
    if ($image_width > 0) {
        $image_size = "{$image_width}x0";
    } else {
        $image_size = '300x0';
    }
}

$image_ratio = '';
if ($image_size === 'full') {
    $_image_ratio_width = absint($image_ratio_width);
    $_image_ratio_height = absint($image_ratio_height);
    if (($_image_ratio_width > 0) && ($_image_ratio_height > 0)) {
        $image_ratio = "{$_image_ratio_width}x{$_image_ratio_height}";
    }
    if ($image_ratio === '') {
        $image_ratio = '1x1';
    }
}



$wrapper_classes = array(
    'g5element__gallery',
    "g5element__gallery-{$layout}",
    $this->getExtraClass($el_class),
    $this->getCSSAnimation($css_animation),
    vc_shortcode_custom_css_class($css)
);


$wrapper_attributes = array();

$inner_attributes = array(
    'data-items-container'
);

$inner_classes = array(
    'g5element__gallery-inner'
);


$post_classes = array(
    'g5core__gutter-item',
    'g5element__gallery-item'
);

if ($justified !== '') {
    $post_classes[] = g5core_get_animation_class($post_animation);
}

$post_inner_classes = array(
    'g5element__gallery-item-inner',
);

if ($justified === '') {
    $post_inner_classes[] = g5core_get_animation_class($post_animation);
}

if ($justified !== '') {
    $inner_classes[] = 'g5core__justified-gallery';
    $inner_attributes[] = "data-justified-options='" . esc_attr(json_encode($justified)) . "'";
	$image_lazy_load = false;
} else {
    if ($layout_settings !== '') {
        $inner_classes[] = 'row';
        if ($columns !== '') {
            if ($columns === 1) {
                $inner_classes[] = 'no-gutters';
            }
        }

        if ($columns_gutter !== '') {
            $inner_classes[] = "g5core__gutter-{$columns_gutter}";
        }

        if (isset($layout_matrix['isotope'])) {
            $inner_classes[] = 'isotope';
            $inner_attributes[] = "data-isotope-options='" . json_encode($layout_matrix['isotope']) . "'";
            $wrapper_attributes[] = 'data-isotope-wrapper="true"';
        }
    }
}

$gallery_id = uniqid();
if (!empty($el_id)) {
    $wrapper_attributes[] = 'id="' . esc_attr($el_id) . '"';
}

$inner_class = join(' ', $inner_classes);
$post_inner_class = join(' ', $post_inner_classes);


$class_to_filter = implode(' ', array_filter($wrapper_classes));
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->getShortcode(), $atts);
?>
<div class="<?php echo esc_attr($css_class) ?>" <?php echo implode(' ', $wrapper_attributes) ?>>
	<?php if ($layout_settings != ''): ?>
		<div <?php echo join(' ', $inner_attributes); ?> class="<?php echo esc_attr($inner_class); ?>">
			<?php
			$index = 0;
			foreach ($images as $image) {
				$index = $index % sizeof($layout_settings);
				$current_layout = $layout_settings[$index];


				$current_post_classes = array();

				if ($justified === '') {
					$current_columns = isset($current_layout['columns']) ? $current_layout['columns'] : $columns;
					if ($current_columns !== '') {
						$current_post_classes[] = is_array($current_columns) ? g5core_get_bootstrap_columns($current_columns) : ($current_columns === 1 ? 'col-12' : $current_columns);
					}
				}

				$current_image_size = isset($current_layout['image_size']) ? $current_layout['image_size'] : $image_size;
				$current_image_ratio = $image_ratio;

				$current_post_classes = wp_parse_args($current_post_classes, $post_classes);
				$current_post_class = join(' ', $current_post_classes);

				$post_inner_attributes = array();

				if (isset($current_layout['layout_ratio'])) {
					$layout_ratio = $current_layout['layout_ratio'];
					if ($image_size !== 'full') {
						$current_image_size = g5core_get_metro_image_size($image_size, $layout_ratio, $columns_gutter);
					} else {
						$current_image_ratio = g5core_get_metro_image_ratio($image_ratio, $layout_ratio);
					}
					$post_inner_attributes[] = 'data-ratio="' . $layout_ratio . '"';
				}

				G5ELEMENT()->get_template('gallery/item.php',array(
					'image' => $image,
					'image_lazy_load' => $image_lazy_load,
					'image_size' => $current_image_size,
					'image_ratio' => $current_image_ratio,
					'image_mode' => $image_mode,
					'hover_effect' => $hover_effect,
					'hover_image_effect' => 		$hover_image_effect,
					'gallery_id' => $gallery_id,
					'item_class' => $current_post_class,
					'item_inner_class' => $post_inner_class,
					'post_inner_attributes' =>  $post_inner_attributes
				));
				$index++;
			}
			?>
		</div>
	<?php else: ?>
		<?php
		G5ELEMENT()->get_template( "gallery/{$layout}.php",array(
			'images' => $images,
			'image_lazy_load' => $image_lazy_load,
			'image_size' => $image_size,
			'image_ratio' => $image_ratio,
			'image_mode' => $image_mode,
			'hover_effect' => $hover_effect,
			'hover_image_effect' => $hover_image_effect,
			'gallery_id' => $gallery_id,
			'item_inner_class' => $post_inner_class,
			'columns_gutter' => $columns_gutter,
			'columns' => $columns,
			'post_classes' => $post_classes
		));
		?>
	<?php endif; ?>
</div>


