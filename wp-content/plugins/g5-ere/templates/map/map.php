<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $directions
 * @var $wrap_class
 * @var $el_class
 * @var $map_address_url
 * @var $location_attributes
 * @var $id
 */
$wrapper_classes = array(
	'g5ere__single-map',
	'position-relative'
);
if (!empty($wrap_class)) {
	$wrapper_classes[] = $wrap_class;
}

$map_classes = array(
	'g5ere__map-canvas'
);

if (!empty($el_class)) {
	$map_classes[] = $el_class;
}

if (!isset($id)) {
	$id  = uniqid('g5ere_single_map');
}

$options = array(
	'_type' => 'single-location'
);

$wrapper_class = implode(' ', $wrapper_classes);
$map_class = implode(' ', $map_classes);
?>
<div class="<?php echo esc_attr($wrapper_class)?>">
	<div id="<?php echo esc_attr($id) ?>" class="<?php echo esc_attr($map_class)?>"  data-location="<?php echo esc_attr(wp_json_encode($location_attributes)) ?>"  data-options="<?php echo esc_attr(wp_json_encode($options)); ?>"></div>
	<?php if ($directions): ?>
		<a class="g5ere__get-directions btn btn-sm btn-dark position-absolute" href="<?php echo esc_url($map_address_url)?>" target="_blank" >
			<i class="fal fa-location-arrow"></i> <span><?php esc_html_e( 'Get Directions', 'g5-ere' ) ?></span>
		</a>
	<?php endif; ?>
</div>
