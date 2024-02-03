<?php
$header_classes = array(
	'g5core-header-desktop-wrapper',
	'sticky-area'
);

$content_404_block = G5CORE()->options()->get_option('page_404_custom');
$page_menu = '';
if (is_singular() || (is_404() && !empty($content_404_block))) {
	$id     = is_404() ? $content_404_block : get_the_ID();

	$prefix = G5CORE()->meta_prefix;
	$page_menu = get_post_meta($id, "{$prefix}page_menu", true);
}

?>
<div class="<?php echo join( ' ', $header_classes ) ?>">
	<div class="container">
		<div class="g5core-header-inner">
			<?php if (has_nav_menu('primary') || $page_menu): ?>
				<?php G5CORE()->get_template( 'header/desktop/menu.php', array(
					'menu_class' => 'main-menu menu-horizontal content-right width-50',
					'classes' => 'width-100',
					'logo_center' => true,
					'after_menu_classes' => 'content-left',
				) ); ?>
			<?php else: ?>
				<?php G5CORE()->get_template( 'header/customize.php', array(
					'type'     => 'desktop',
					'location' => 'before_menu',
					'classes' => 'content-right width-50'
				) ); ?>
				<?php G5CORE()->get_template( 'header/desktop/logo.php', array(
					'classes' => 'content-center logo-center'
				) ); ?>
				<?php G5CORE()->get_template( 'header/customize.php', array(
					'type'     => 'desktop',
					'location' => 'after_menu',
					'classes' => 'content-left width-50'
				) ); ?>
			<?php endif; ?>

		</div>
	</div>
</div>