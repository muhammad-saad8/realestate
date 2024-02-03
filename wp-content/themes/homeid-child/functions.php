<?php
add_action( 'wp_enqueue_scripts', 'homeid_child_theme_enqueue_styles', 100 );
function homeid_child_theme_enqueue_styles() {
	wp_enqueue_style( 'homeid-child-style', get_stylesheet_directory_uri() . '/style.css', array( basename(get_template_directory()) . '-style' ) );
}

add_action( 'after_setup_theme', 'homeid_child_theme_setup');
function homeid_child_theme_setup(){
	$language_path = get_stylesheet_directory() .'/languages';
	if(is_dir($language_path)){
		load_child_theme_textdomain('homeid-child', $language_path );
	}
}
add_action( 'after_switch_theme', 'homeid_child_after_switch_theme',1 );
function homeid_child_after_switch_theme() {
	$sidebars_widgets =  get_theme_mod('sidebars_widgets');
	foreach ($sidebars_widgets['data'] as $k => $v) {
		if (!is_array($v)) {
			unset($sidebars_widgets['data'][$k]);
		}
	}
	set_theme_mod('sidebars_widgets', $sidebars_widgets);
}

