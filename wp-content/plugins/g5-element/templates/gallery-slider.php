<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $images
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
 * @var $slider_rows
 * @var $slider_pagination_enable
 * @var $slider_navigation_enable
 * @var $slider_center_enable
 * @var $slider_center_padding
 * @var $slider_auto_height_enable
 * @var $slider_loop_enable
 * @var $slider_autoplay_enable
 * @var $slider_autoplay_timeout
 * @var $image_size
 * @var $image_ratio_width
 * @var $image_ratio_height
 * @var $animation_style
 * @var $animation_duration
 * @var $animation_delay
 * @var $css_editor
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_G5Element_Gallery
 */

$images = $columns_gutter = $post_animation = $hover_effect = $hover_image_effect =
$el_id = $el_class =
$columns_xl = $columns_lg = $columns_md = $columns_sm = $columns =
$slider_rows = $slider_pagination_enable = $slider_navigation_enable = $slider_center_enable = $slider_center_padding = $slider_auto_height_enable = $slider_loop_enable = $slider_autoplay_enable = $slider_autoplay_timeout =
$image_size = $image_ratio_width = $image_ratio_height =
$animation_style = $animation_duration = $animation_delay = $css_editor = $responsive = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

G5ELEMENT()->assets()->enqueue_assets_for_shortcode('gallery_slider');

$images = array_filter(explode(',', $images),'strlen') ;
if (count($images) === 0) return;


$columns_gutter = absint($columns_gutter);
$columns_xl = absint($columns_xl);
$columns_lg = absint($columns_lg);
$columns_md = absint($columns_md);
$columns_sm = absint($columns_sm);
$columns = absint($columns);
$slider_rows = absint($slider_rows);

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

$slick_options = array(
    'slidesToShow'   => $columns_xl,
    'slidesToScroll' => $columns_xl,
    'centerMode'     => $slider_center_enable === 'on',
    'centerPadding'  => $slider_center_padding,
    'arrows'         => $slider_navigation_enable === 'on',
    'dots'           => $slider_pagination_enable === 'on',
    'infinite'       => $slider_center_enable === 'on' ? true :  $slider_loop_enable === 'on',
    'adaptiveHeight' => $slider_auto_height_enable === 'on',
    'autoplay'       => $slider_autoplay_enable === 'on',
    'autoplaySpeed'  => absint($slider_autoplay_timeout),
    'draggable' => true,
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
    ),
);

if ($slider_rows > 1) {
    $slick_options['rows'] = $slider_rows;
    $slick_options['slidesPerRow']  = $columns_xl;
    $slick_options['slidesToShow'] = 1;
    $slick_options['slidesToScroll'] = 1;

    $slick_options['responsive'] = array(
        array(
            'breakpoint' => 1200,
            'settings'   => array(
                'slidesPerRow'  => $columns_lg,
                'slidesToShow'   => 1,
                'slidesToScroll' => 1,
            )
        ),
        array(
            'breakpoint' => 992,
            'settings'   => array(
                'slidesPerRow'  => $columns_md,
                'slidesToShow'   => 1,
                'slidesToScroll' => 1,
            )
        ),
        array(
            'breakpoint' => 768,
            'settings'   => array(
                'slidesPerRow'  => $columns_sm,
                'slidesToShow'   => 1,
                'slidesToScroll' => 1,
            )
        ),
        array(
            'breakpoint' => 576,
            'settings'   => array(
                'slidesPerRow'  => $columns,
                'slidesToShow'   => 1,
                'slidesToScroll' => 1,
            )
        )
    );
}




$wrapper_classes = array(
    'g5element__gallery-slider',
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


$post_inner_classes = array(
    'g5element__gallery-item-inner',
    g5core_get_animation_class($post_animation)
);

$inner_classes[] = 'slick-slider';
$inner_attributes[] = "data-slick-options='" . esc_attr(json_encode($slick_options)) . "'";
if ($columns_gutter !== '') {
    if ($slider_rows > 1) {
        $inner_classes[] = 'slick-slider-rows';
        $inner_classes[] = "g5core__gutter-slider-rows-{$columns_gutter}";
    } else {
        $inner_classes[] = "g5core__gutter-{$columns_gutter}";
    }
}

$gallery_id = uniqid();
if (!empty($el_id)) {
    $wrapper_attributes[] = 'id="' . esc_attr($el_id) . '"';
}
$post_class = join(' ', $post_classes);
$inner_class = join(' ', $inner_classes);
$post_inner_class = join(' ', $post_inner_classes);


$class_to_filter = implode(' ', array_filter($wrapper_classes));
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->getShortcode(), $atts);
?>
<div class="<?php echo esc_attr($css_class) ?>" <?php echo implode(' ', $wrapper_attributes) ?>>
    <div <?php echo join(' ', $inner_attributes); ?> class="<?php echo esc_attr($inner_class); ?>">
        <?php
        foreach ($images as $image) {
            G5ELEMENT()->get_template('gallery/item.php',array(
                'image' => $image,
                'image_size' => $image_size,
                'image_ratio' => $image_ratio,
                'image_mode' => '',
                'hover_effect' => $hover_effect,
                'hover_image_effect' => $hover_image_effect,
                'gallery_id' => $gallery_id,
                'item_class' => $post_class,
                'item_inner_class' => $post_inner_class
            ));
        }
        ?>
    </div>
</div>
