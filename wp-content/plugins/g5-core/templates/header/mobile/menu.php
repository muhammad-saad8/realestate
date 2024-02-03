<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
};
$theme_location = has_nav_menu('mobile') ? 'mobile' : 'primary';

$menu_mobile_class = array('g5core-menu-mobile', 'g5core-off-canvas-wrapper', 'from-left');
$menu_mobile_class[] = G5CORE()->options()->header()->get_option('mobile_navigation_skin');

$content_404_block = G5CORE()->options()->get_option('page_404_custom');
$page_menu = '';
if (is_singular() || (is_404() && !empty($content_404_block))) {
	$id     = is_404() ? $content_404_block : get_the_ID();

	$prefix = G5CORE()->meta_prefix;
	$page_menu = get_post_meta($id, "{$prefix}page_mobile_menu", true);
	if (empty($page_menu)) {
		$page_menu = get_post_meta($id, "{$prefix}page_menu", true);
	}
	$is_one_page = get_post_meta($id, "{$prefix}is_one_page", true);
	if ($is_one_page === 'on') {
		$menu_mobile_class[] = 'g5core-menu-one-page';
	}
}

?>
<div id="g5core_menu_mobile" class="<?php echo join(' ', $menu_mobile_class) ?>">
	<div class="off-canvas-close">
		<i class="fal fa-times"></i>
	</div>
	<div class="off-canvas-overlay"></div>
	<div class="g5core-off-canvas-inner">
		<?php G5CORE()->get_template( 'header/customize/search-form.php' ); ?>
		<?php if (has_nav_menu($theme_location) || $page_menu): ?>
			<?php
			$arg_menu = array(
				'container_class' => 'main-menu-wrapper',
				'theme_location' => $theme_location,
				'menu_class' => 'main-menu',
				'main_menu' => true,
			);

			if (!empty($page_menu)) {
				$arg_menu['menu'] = $page_menu;
			}

			wp_nav_menu($arg_menu);
			?>
		<?php endif; ?>
	</div>
</div>