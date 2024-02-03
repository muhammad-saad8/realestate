<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $prefix
 */
$wrapper_classes = array(
	'form-group',
	'g5ere__search-field',
	'g5ere__sf-advanced-button'
);
$wrapper_class = implode(' ', $wrapper_classes);
?>
<div class="<?php echo esc_attr($wrapper_class)?>">
	<a class="btn btn-block g5ere__sf-btn-advanced collapsed" href="#<?php echo esc_attr($prefix)?>_bottom" data-toggle="collapse"><i class="fal fa-cog"></i> <?php esc_html_e('Advanced','g5-ere') ?></a>
</div>
