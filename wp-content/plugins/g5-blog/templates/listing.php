<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
$post_settings = &G5BLOG()->listing()->get_layout_settings();
$post_layout = isset($post_settings['post_layout']) ? $post_settings['post_layout'] : 'large-image';
$item_custom_class = isset($post_settings['item_custom_class']) ? $post_settings['item_custom_class'] : '';
$post_paging = isset($post_settings['post_paging']) ? $post_settings['post_paging'] : 'pagination';
$layout_matrix = G5BLOG()->listing()->get_layout_matrix($post_layout);
$image_size = isset($layout_matrix['image_size']) ? $layout_matrix['image_size'] : (isset($post_settings['image_size']) ? $post_settings['image_size'] : 'full') ;
$image_mode = isset($layout_matrix['image_mode']) ? $layout_matrix['image_mode'] : (isset($post_settings['image_mode']) ? $post_settings['image_mode'] : '') ;
$placeholder = isset($layout_matrix['placeholder']) ? $layout_matrix['placeholder'] : (isset($post_settings['placeholder']) ? $post_settings['placeholder'] : '');

$slick = isset($post_settings['slick']) ? $post_settings['slick'] : (isset($layout_matrix['slick']) ? $layout_matrix['slick'] : '');
$slider_rows = absint(isset($post_settings['slider_rows']) ? $post_settings['slider_rows'] :  (isset($layout_matrix['slider_rows']) ? $layout_matrix['slider_rows'] : 1));
$excerpt_enable = isset($post_settings['excerpt_enable']) ? $post_settings['excerpt_enable'] : G5BLOG()->options()->get_option('excerpt_enable');

$layout_settings = isset($layout_matrix['layout']) ? $layout_matrix['layout'] : '';
$columns = isset($layout_matrix['columns']) ? $layout_matrix['columns'] : (isset($post_settings['post_columns']) ? $post_settings['post_columns'] : '');
$columns_gutter = isset($layout_matrix['columns_gutter']) ? $layout_matrix['columns_gutter'] : (isset($post_settings['columns_gutter']) ? $post_settings['columns_gutter'] : '');
$post_index_start = absint(isset($post_settings['index']) ? $post_settings['index'] : 0);
$post_animation = isset($post_settings['post_animation']) ? $post_settings['post_animation'] : '';
if ($post_layout === 'masonry') {
    $image_width = isset($post_settings['image_width']) ?  $post_settings['image_width'] : G5BLOG()->options()->get_option('post_image_width');

    if (is_array($image_width) && isset($image_width['width'])) {
        $image_width = intval($image_width['width']);
    } else {
        $image_width = 400;
    }

    if ($image_width <= 0) {
        $image_width = 400;
    }
    $image_size = "{$image_width}x0";
}

$image_ratio = '';
if ($image_size === 'full' && $post_layout !== 'large-image') {
    $image_ratio_custom = isset($post_settings['image_ratio']) ? $post_settings['image_ratio'] : G5BLOG()->options()->get_option('post_image_ratio');
    if (is_array($image_ratio_custom) && isset($image_ratio_custom['width']) && isset($image_ratio_custom['height'])) {
        $image_ratio_custom_width = intval($image_ratio_custom['width']);
        $image_ratio_custom_height = intval($image_ratio_custom['height']);
        if (($image_ratio_custom_width > 0) && ($image_ratio_custom_height > 0)) {
            $image_ratio = "{$image_ratio_custom_width}x{$image_ratio_custom_height}";
        }
    }

    if ($image_ratio === '') {
        $image_ratio = '1x1';
    }
}


$wrapper_classes = array(
    'g5blog__listing-wrap',
    "g5blog__layout-{$post_layout}"
);

$wrapper_attributes = array();

$inner_attributes = array(
    'data-items-container'
);

$inner_classes = array(
    'g5blog__listing-inner',
);

$post_classes = array(
    'g5core__gutter-item',
    'g5blog__post-default',
	$item_custom_class
);
$post_inner_classes = array(
    'g5blog__post-inner',
    g5core_get_animation_class($post_animation)
);

if (isset($post_settings['isMainQuery']))  {
    $wrapper_attributes[] = 'data-archive-wrapper';
}

if ($slick !== '') {
    $inner_classes[] = 'slick-slider';
    $inner_attributes[] = "data-slick-options='" . esc_attr(json_encode($slick)) . "'";
    if ($columns_gutter !== '') {
        if ($slider_rows > 1) {
            $inner_classes[] = 'slick-slider-rows';
            $inner_classes[] = "g5core__gutter-slider-rows-{$columns_gutter}";
        } else {
            $inner_classes[] = "g5core__gutter-{$columns_gutter}";
        }
    }
} else {
    if ($layout_settings !== '') {
        $inner_classes[] = 'row';
        if ($columns !== '') {
            if ($columns === 1) {
                $inner_classes[] = 'no-gutters';
            }
            //$post_classes[] = is_array($columns) ? g5core_get_bootstrap_columns($columns) : ($columns === 1 ? 'col-12' : $columns);
        }

        if ($columns_gutter !== '') {
            $inner_classes[] = "g5core__gutter-{$columns_gutter}";
        }

        if (isset($layout_matrix['isotope'])) {
            $inner_classes[] = 'isotope';
            $inner_attributes[] = "data-isotope-options='" . json_encode($layout_matrix['isotope']) . "'";
            $wrapper_attributes[] = 'data-isotope-wrapper="true"';
            if (isset($layout_matrix['isotope']['metro'])) {
                if ($image_size === 'full') {
                    $inner_attributes[] = "data-image-size-base='" . $image_ratio . "'";
                } else {
                    $image_size_dimension = g5core_get_image_dimension($image_size);
                    if ($image_size_dimension) {
                        $inner_attributes[] = "data-image-size-base='" . $image_size_dimension['width'] . 'x' . $image_size_dimension['height'] . "'";
                    }
                }
            }
        }

    }
}

$settingId = isset($post_settings['settingId']) ? $post_settings['settingId'] : uniqid();
$post_settings['settingId'] = $settingId;
$wrapper_attributes[] = sprintf('data-items-wrapper="%s"',$settingId) ;

$paged = G5CORE()->query()->query_var_paged();
$wrapper_class = join(' ', $wrapper_classes);
$inner_class = join(' ', $inner_classes);
$post_inner_class = join(' ', $post_inner_classes);
?>
<?php if (G5CORE()->query()->have_posts()): ?>
    <div <?php echo join(' ', $wrapper_attributes); ?> class="<?php echo esc_attr($wrapper_class) ?>">
        <?php
        // You can use this for adding codes before the main loop
        do_action('g5core_before_listing_wrapper');
        ?>
        <div <?php echo join(' ', $inner_attributes); ?> class="<?php echo esc_attr($inner_class); ?>">
            <?php
            if ($layout_settings !== '') {
                $index = $post_index_start;
                while (G5CORE()->query()->have_posts()) {
                    G5CORE()->query()->the_post();
                    $index = $index % sizeof($layout_settings);
                    $current_layout = $layout_settings[$index];

                    $isFirst = isset( $current_layout['isFirst'] ) ? $current_layout['isFirst'] : false;
                    if ( $isFirst && ( $paged > 1 ) && in_array( $post_paging, array( 'load-more', 'infinite-scroll' ) ) ) {
                        $k = $index;
                        while ($isFirst) {
                            if ( isset( $layout_settings[$k + 1] ) ) {
                                $current_layout = $layout_settings[$k + 1];
                                $isFirst = isset( $current_layout['isFirst'] ) ? $current_layout['isFirst'] : false;
                                $k++;
                            } else {
                                continue;
                            }
                        }
                    }

                    $template = $current_layout['template'];
                    $template_class = isset($current_layout['template_class']) ? $current_layout['template_class'] : "g5blog__post-{$template}";
                    $post_index = intval(G5CORE()->query()->get_query()->current_post) +1;
                    $current_post_classes = array(
                        $template_class,
                        "g5blog__post-item-{$post_index}"
                    );


                    if ($slick === '') {
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


                    G5BLOG()->get_template("loop/listing/item/{$template}.php",array(
                        'image_size' => $current_image_size,
                        'image_ratio' => $current_image_ratio,
                        'placeholder' => $placeholder,
                        'post_class' => $current_post_class,
                        'post_inner_class' => $post_inner_class,
                        'post_inner_attributes' => $post_inner_attributes,
                        'image_mode' => $image_mode,
                        'excerpt_enable' => $excerpt_enable === 'on',
	                    'post_layout' => $post_layout
                    ));

                    if ( $isFirst ) {
                        unset( $layout_settings[$index] );
                        $layout_settings = array_values( $layout_settings );
                    }

                    if ( $isFirst && $paged === 1 ) {
                        $index = 0;
                    } else {
                        $index++;
                    }
                }
            } else {
                G5BLOG()->get_template( "loop/listing/{$post_layout}.php",array('post_classes' => $post_classes, 'post_inner_class' => $post_inner_class));
            }
            ?>
        </div>
        <?php
        // You can use this for adding codes before the main loop
        do_action('g5core_after_listing_wrapper');
        ?>
    </div>
<?php elseif (isset($post_settings['isMainQuery'])): ?>
    <?php G5BLOG()->get_template( 'loop/content-none.php' ); ?>
<?php endif; ?>



