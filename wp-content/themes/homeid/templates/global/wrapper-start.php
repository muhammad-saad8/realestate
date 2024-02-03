<?php
/**
 * The template for displaying wrapper-start
 *
 * @since 1.0
 * @version 1.0
 */

$wrapper_class = apply_filters('homeid_content_wrapper_classes', array());

$inner_class = apply_filters('homeid_content_inner_classes', array('col'));

/**
 * @hooked homeid_template_page_title - 10
 */
do_action('homeid_before_main_content');
?>
<!-- Primary Content Wrapper -->
<div id="primary-content" class="<?php echo esc_attr(join(' ', $wrapper_class))?>">
	<!-- Primary Content Container -->
	<div class="container">
		<!-- Primary Content Row -->
		<div class="row">
			<!-- Primary Content Inner -->
			<div id="main-content" class="<?php echo esc_attr(join(' ', $inner_class)); ?>">


