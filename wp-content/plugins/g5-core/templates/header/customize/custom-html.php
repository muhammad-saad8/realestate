<?php
/**
 * @var $location before_menu | after_menu | before_logo | after_logo | header_mobile
 */
?>
<?php echo do_shortcode(G5CORE()->options()->header()->get_option("{$location}_customize_custom_html")) ?>