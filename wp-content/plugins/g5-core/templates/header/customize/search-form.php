<?php
$search_ajax_enable = G5CORE()->options()->get_option('search_ajax_enable');
$post_types = G5CORE()->options()->get_option('search_post_types');

$wrapper_classes = array(
    'g5core-search-form'
);

if ($search_ajax_enable === 'on') {
    $wrapper_classes[] = 'g5core-search-ajax';
}
$wrapper_class = implode(' ', $wrapper_classes);

?>
<div class="g5core-search-form-wrapper">
	<form action="<?php echo esc_url(home_url('/')) ?>" method="get" class="<?php echo esc_attr($wrapper_class)?>">
		<input name="s" type="search"
		       placeholder="<?php $search_ajax_enable === 'on' ?  esc_attr_e('Type to search...', 'g5-core') : esc_attr_e('Type and hit enter', 'g5-core') ?>"
		       autocomplete="off">
		<span class="remove" title="<?php echo esc_attr__('Remove search terms','g5-core') ?>"><i class="fal fa-times"></i></span>
		<button type="submit"><i class="fal fa-search"></i></button>
		<div class="result"></div>
        <?php if (($search_ajax_enable !== 'on') && !empty($post_types) && (count($post_types) === 1) && ($post_types[0] !== 'all')): ?>
            <input type="hidden" name="post_type" value="<?php echo esc_attr($post_types[0])?>">
        <?php endif; ?>
        <input type="hidden" name="action" value="g5core_search">
        <input type="hidden" name="_g5core_search_nonce" value="<?php echo esc_attr(wp_create_nonce( 'g5core_search' ) )?>">
	</form>
</div>