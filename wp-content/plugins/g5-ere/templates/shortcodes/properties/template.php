<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * Shortcode attributes
 * @var $atts
 * @var $taxonomy_filter_enable
 * @var $taxonomy_filter
 * @var $taxonomy_filter_align
 * @var $append_tabs

 * @var $post_layout
 * @var $item_skin
 * @var $list_item_skin
 * @var $item_custom_class
 *
 * @var $columns_gutter
 * @var $posts_per_page
 * @var $offset
 * @var $post_paging
 * @var $post_animation

 * @var $el_id
 * @var $el_class

 * @var $show
 * @var $property_type
 * @var $property_status
 * @var $property_feature
 * @var $property_label
 * @var $property_state
 * @var $property_city
 * @var $property_neighborhood
 * @var $ids
 * @var $sorting
 * @var $columns_xl
 * @var $columns_lg
 * @var $columns_md
 * @var $columns_sm
 * @var $columns
 * @var $post_image_size
 * @var $post_image_ratio_width
 * @var $post_image_ratio_height
 * @var $animation_style
 * @var $animation_duration
 * @var $animation_delay
 * @var $css_editor
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_G5Element_Properties
 */
$taxonomy_filter_enable = $taxonomy_filter = $taxonomy_filter_align = $append_tabs =
$post_layout = $item_skin = $list_item_skin = $item_custom_class  =
$columns_gutter = $posts_per_page = $offset = $post_paging = $post_animation =
$el_id = $el_class =
$show = $property_type = $property_status = $property_feature = $property_label = $property_state = $property_city = $property_neighborhood = $ids = $sorting =
$columns_xl = $columns_lg = $columns_md = $columns_sm = $columns =
$post_image_size = $post_image_ratio_width = $post_image_ratio_height =
$animation_style = $animation_duration = $animation_delay = $css_editor = $responsive = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);
$wrapper_classes = array(
	'g5element__properties',
	$this->getExtraClass($el_class),
	$this->getCSSAnimation($css_animation),
	vc_shortcode_custom_css_class($css)
);
$query_args = array(
	'post_type' => 'property',
);

$settings = array(
	'image_size' => $post_image_size,
	'image_ratio' => array(
		'width' => absint($post_image_ratio_width),
		'height' => absint($post_image_ratio_height)
	),
	'cate_filter_enable' =>    $taxonomy_filter_enable === 'on',
	'cate_filter_align' => $taxonomy_filter_align,
	'taxonomy' => $taxonomy_filter
);

if ($taxonomy_filter_enable === 'on') {
	if (($taxonomy_filter === 'property-status') && !empty($property_status)) {
		$settings['cate'] = array_filter(explode(',',$property_status),'absint');
	}

	if (($taxonomy_filter === 'property-type') && !empty($property_type)) {
		$settings['cate'] = array_filter(explode(',',$property_type),'absint');
	}

	if (($taxonomy_filter === 'property-label') && !empty($property_label)) {
		$settings['cate'] = array_filter(explode(',',$property_label),'absint');
	}
}

if ($post_layout === 'list') {
	$settings['item_skin'] = $list_item_skin;
}

$this->prepare_display($atts, $query_args, $settings);
$class_to_filter = implode(' ', array_filter($wrapper_classes));
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->getShortcode(), $atts);
$wrapper_attributes = array();
if (!empty($el_id)) {
	$wrapper_attributes[] = 'id="' . esc_attr($el_id) . '"';
}
?>
<div class="<?php echo esc_attr($css_class) ?>" <?php echo implode(' ', $wrapper_attributes) ?>>
	<?php G5ERE()->listing()->render_content($this->_query_args, $this->_settings); ?>
</div>
