<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$features   = g5ere_get_property_features( array( 'property_id' => $property_id ) );
$single_property_feature_link_disable = G5ERE()->options()->get_option('single_property_feature_link_disable');
$features_terms_id = array();
foreach ($features as $feature) {
	$features_terms_id[] = intval($feature->term_id);
}
$hide_empty_features = ere_get_option('hide_empty_features', 1);
$item_class = apply_filters('g5ere_property_feature_class','col-md-4 col-sm-6 col-12');

$parent_features = get_categories(array(
	'taxonomy' => 'property-feature',
	'parent' => 0,
	'hide_empty' => false
));
if (count($parent_features) === 0) {
	return;
}
$parent_features_has_child = array();
?>
<?php foreach ($parent_features as $parent_feature): ?>
	<?php
	$args = array(
		'taxonomy' => 'property-feature',
		'parent' => $parent_feature->term_id,
		'hide_empty' => false
	);
	if ($hide_empty_features == 1) {
		$args['include'] = $features_terms_id;
	}
	$child_features = get_categories($args);
	if (count($child_features) == 0) {
		continue;
	}
	$parent_features_has_child[] = $parent_feature->term_id;
	?>
    <h5 class="g5ere__property-feature-title"><?php echo esc_html($parent_feature->name)?></h5>
    <ul class="list-unstyled row g5ere__property-feature-list">
		<?php foreach ($child_features as $child_feature): ?>
            <li class="<?php echo esc_attr($item_class)?> <?php echo esc_attr($child_feature->slug)?>">
                <div class="d-flex align-items-center g5ere__property-feature-item">
					<?php if (in_array($child_feature->term_id, $features_terms_id)): ?>
						<?php if ($single_property_feature_link_disable === 'on'): ?>
                            <i class="far fa-check mr-2"></i><span><?php echo esc_html($child_feature->name)?></span>
						<?php else: ?>
                            <i class="far fa-check mr-2"></i><a href="<?php echo esc_url(get_term_link($child_feature,'property-feature'))  ?>"><?php echo esc_html($child_feature->name)?></a>
						<?php endif; ?>
					<?php else: ?>
						<?php if ($single_property_feature_link_disable === 'on'): ?>
                            <i class="far fa-times mr-2 text-danger"></i><span><?php echo esc_html($child_feature->name)?></span>
						<?php else: ?>
                            <i class="far fa-times mr-2 text-danger"></i><a href="<?php echo esc_url(get_term_link($child_feature,'property-feature'))  ?>"><?php echo esc_html($child_feature->name)?></a>
						<?php endif; ?>
					<?php endif; ?>

                </div>
            </li>
		<?php endforeach; ?>
    </ul>
<?php endforeach; ?>

<?php if (count($parent_features_has_child) > 0): ?>
	<?php
	$parent_features = get_categories(array(
		'taxonomy' => 'property-feature',
		'parent' => 0,
		'hide_empty' => false,
		'exclude' => $parent_features_has_child
	));
	?>

<?php endif; ?>

<?php if (count($parent_features) > 0): ?>
	<?php if (count($parent_features_has_child) > 0): ?>
        <h5 class="g5ere__property-feature-title"><?php echo esc_html__('Other','g5-ere')?></h5>
	<?php endif; ?>
    <ul class="list-unstyled row g5ere__property-feature-list">
		<?php foreach ($parent_features as $child_feature): ?>
			<?php
			if (!in_array($child_feature->term_id, $features_terms_id ) && ($hide_empty_features == 1)) {
				continue;
			}
			?>
            <li class="<?php echo esc_attr($item_class)?> <?php echo esc_attr($child_feature->slug)?>">
                <div class="d-flex align-items-center g5ere__property-feature-item">
					<?php if (in_array($child_feature->term_id, $features_terms_id)): ?>
						<?php if ($single_property_feature_link_disable === 'on'): ?>
                            <i class="far fa-check mr-2"></i><span><?php echo esc_html($child_feature->name)?></span>
						<?php else: ?>
                            <i class="far fa-check mr-2"></i><a href="<?php echo esc_url(get_term_link($child_feature,'property-feature'))  ?>"><?php echo esc_html($child_feature->name)?></a>
						<?php endif; ?>
					<?php else: ?>
						<?php if ($single_property_feature_link_disable === 'on'): ?>
                            <i class="far fa-times mr-2 text-danger"></i><span><?php echo esc_html($child_feature->name)?></span>
						<?php else: ?>
                            <i class="far fa-times mr-2 text-danger"></i><a href="<?php echo esc_url(get_term_link($child_feature,'property-feature'))  ?>"><?php echo esc_html($child_feature->name)?></a>
						<?php endif; ?>
					<?php endif; ?>
                </div>
            </li>
		<?php endforeach; ?>
    </ul>
<?php endif; ?>
