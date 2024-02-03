<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
};
/**
 * @var $classes
 * @var $menu_class
 * @var $logo_center bool
 * @var $after_menu_classes
 * @var $customize_left_classes
 * @var $customize_right_classes
 */
$site_menu_classes = array('g5core-primary-menu', 'site-menu');
if (isset($classes) && !empty($classes)) {
	$site_menu_classes[] = $classes;
}

if (!isset($menu_class) || empty($menu_class)) {
	$menu_class = 'main-menu';
}

$content_404_block = G5CORE()->options()->get_option('page_404_custom');
$page_menu = '';
if (is_singular() || (is_404() && !empty($content_404_block))) {
	$id     = is_404() ? $content_404_block : get_the_ID();

	$prefix = G5CORE()->meta_prefix;
	$page_menu = get_post_meta($id, "{$prefix}page_menu", true);
	$is_one_page = get_post_meta($id, "{$prefix}is_one_page", true);
	if ($is_one_page === 'on') {
		$site_menu_classes[] = 'g5core-menu-one-page';
	}
}

?>
<nav class="<?php echo join(' ', $site_menu_classes)?>" data-xmenu-container-width="<?php echo esc_attr(apply_filters('g5core_xmenu_container_width', 1200)) ?>">
	<?php if (has_nav_menu('primary') || $page_menu): ?>
		<?php
		$arg_menu = array(
			'menu_id' => 'main-menu',
			'container' => '',
			'theme_location' => 'primary',
			'menu_class' => $menu_class,
			'main_menu' => true,
			'after_menu_classes' => isset($after_menu_classes) ? $after_menu_classes : '',
			'customize_left_classes' => isset($customize_left_classes) ? $customize_left_classes : '',
			'customize_right_classes' => isset($customize_right_classes) ? $customize_right_classes : '',
		);
		if (isset($logo_center) && ($logo_center === true)) {
			$arg_menu['logo_center'] = true;
		}
		if (!empty($page_menu)) {
			$arg_menu['menu'] = $page_menu;
		}

		wp_nav_menu($arg_menu);
		?>
	<?php endif; ?>
</nav>