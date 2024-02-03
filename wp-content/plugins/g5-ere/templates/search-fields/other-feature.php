<?php
/**
 * @var $prefix
 * @var $css_class_field
 */
?>
<div class="g5ere__features-list-wrap">
	<a class="g5ere__btn-features-list" data-toggle="collapse" href="#<?php echo esc_attr($prefix)?>_features_list">
		<i class="fal fa-plus-square"></i> <?php echo esc_html__('Other Features','g5-ere'); ?>
	</a><!-- btn-features-list -->
	<div id="<?php echo esc_attr($prefix)?>_features_list" class="collapse">
		<?php G5ERE()->get_template('/search-fields/feature.php',array('css_class_field' =>  $css_class_field , 'prefix' => $prefix))?>
	</div><!-- collapse -->
</div><!-- features-list-wrap -->