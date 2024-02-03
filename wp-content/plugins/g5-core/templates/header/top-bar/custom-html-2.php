<?php
/**
 * @var $type desktop|mobile
 */
?>
<?php echo do_shortcode(G5CORE()->options()->header()->get_option("top_bar_{$type}_items_custom_html_2")) ?>