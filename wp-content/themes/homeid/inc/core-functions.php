<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

function homeid_setup()
{
	/*
	 * Make theme available for translation.
	 */
	load_theme_textdomain('homeid', get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support('title-tag');

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support('post-thumbnails');


	// Set the default content width.
	$GLOBALS['content_width'] = 768;

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus(array(
		'primary' =>esc_html__('Main Menu', 'homeid'),
	));

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support('html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	));

	add_theme_support("custom-header");
	add_theme_support("custom-background");


	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support('post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'audio',
	));

	// Add theme support for Custom Logo.
	add_theme_support('custom-logo', array(
		'width'      => 240,
		'height'     => 80,
		'flex-width' => true,
	));

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	add_theme_support('wp-block-styles');

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, and column width.
 	 */

	/**
	 * Editor style
	 */
	add_editor_style(get_parent_theme_file_uri('assets/css/editor-style.css') . '?v=' . uniqid());

	add_theme_support('editor-styles');

	add_theme_support('responsive-embeds');
	add_theme_support('align-wide');

}

add_action('after_setup_theme', 'homeid_setup');


function homeid_enqueue_block_editor_assets()
{
	wp_enqueue_style('block-editor', get_parent_theme_file_uri('assets/css/editor-blocks.css?v=' . uniqid()));
}

add_action('enqueue_block_editor_assets', 'homeid_enqueue_block_editor_assets');

/**
 * Add preconnect for Google Fonts.
 *
 * @param array $urls URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed.
 *
 * @return array $urls           URLs to print for resource hints.
 */
function homeid_resource_hints($urls, $relation_type)
{
	if (wp_style_is('homeid-fonts', 'queue') && 'preconnect' === $relation_type) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}

add_filter('wp_resource_hints', 'homeid_resource_hints', 10, 2);

/**
 * Register widget area.
 *
 */
function homeid_widgets_init()
{
	register_sidebar(array(
		'name'          => esc_html__('Blog Sidebar', 'homeid'),
		'id'            => 'sidebar-blog',
		'description'   => esc_html__('Add widgets here to appear in your sidebar on blog posts and archive pages.', 'homeid'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title"><span>',
		'after_title'   => '</span></h4>',
	));
}

add_action('widgets_init', 'homeid_widgets_init');

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function homeid_pingback_header()
{
	if (is_singular() && pings_open()) {
		printf('<link rel="pingback" href="%s">' . "\n", get_bloginfo('pingback_url'));
	}
}

add_action('wp_head', 'homeid_pingback_header');

/**
 * Use front-page.php when Front page displays is set to a static page.
 *
 * @param string $template front-page.php.
 *
 * @return string The template to be used: blank if is_home() is true (defaults to index.php), else $template.
 */
function homeid_front_page_template($template)
{
	return is_home() ? '' : $template;
}

add_filter('frontpage_template', 'homeid_front_page_template');



/**
 * Enqueue scripts and styles.
 */
function homeid_scripts()
{

	wp_enqueue_style('bootstrap');
	wp_enqueue_script('bootstrap');

	wp_enqueue_style('font-awesome');

	// Theme stylesheet.
	wp_enqueue_style( HOMEID_FILE_HANDLER . 'style', get_template_directory_uri() . '/style.css', array(), HOMEID_VERSION );

	wp_enqueue_script( 'jparallax', get_theme_file_uri('/assets/vendors/jparallax/TweenMax.min.js'), array('jquery'), '2.1.3', true);

	wp_enqueue_script(HOMEID_FILE_HANDLER . 'app', get_theme_file_uri('/assets/js/app.min.js'), array('jquery','jparallax'), HOMEID_VERSION, true);




	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}

add_action('wp_enqueue_scripts', 'homeid_scripts', 20);
function home_register_assets() {
	wp_register_style('bootstrap',get_theme_file_uri('assets/vendors/bootstrap/css/bootstrap.min.css'),array(),'4.6.0');
	wp_register_script('bootstrap',get_theme_file_uri('assets/vendors/bootstrap/js/bootstrap.bundle.min.js'),array('jquery'),'4.6.0',true);
	wp_register_style('font-awesome', get_theme_file_uri('assets/vendors/font-awesome/css/all.min.css'), array(), '5.15.4');
}
add_action('init','home_register_assets',2);


/**
 * Register custom fonts.
 */
function homeid_fonts_url()
{
	/*
	 * Translators: If there are characters in your language that are not
	 * supported by Libre Franklin, translate this to 'off'. Do not translate
	 * into your own language.
	 */

	$google_fonts = array();
	$fonts        = array();
	foreach (homeid_font_default() as $font) {
		switch ($font['kind']) {
			case 'webfonts#webfont':
				$variants = isset($font['variants']) ? $font['variants'] : array();
				$variants = str_replace('italic','i',join(',',$variants)) ;
				$google_fonts[] = "{$font['family']}:{$variants}";
				break;
			case 'custom':
				$fonts['dukaken-custom-font-' . sanitize_key($font['family'])] = $font['css_url'];
				break;
		}
	}

	if (!empty($google_fonts)) {
		$query_args = array(
			'family' => urlencode(implode('|', $google_fonts)),
			'subset' => urlencode('latin,latin-ext'),
		);

		$google_fonts_url              = add_query_arg($query_args, 'https://fonts.googleapis.com/css');
		$fonts['google-fonts'] = $google_fonts_url;
	}

	return $fonts;
}

function homeid_get_template_path($slug)
{
	$template_name = "templates/{$slug}.php";
	$located       = trailingslashit(get_stylesheet_directory()) . $template_name;
	if (!file_exists($located)) {
		$located = trailingslashit(get_template_directory()) . $template_name;
	}

	if (!file_exists($located)) {
		_doing_it_wrong(__FUNCTION__, sprintf('<code>%s</code> does not exist.', $template_name), '1.0');
		return '';
	}

	return $located;
}

function homeid_get_template($slug, $args = array())
{
	if ($args && is_array($args)) {
		extract($args);
	}
	$located = homeid_get_template_path($slug);
	if (!empty($located)) {
		include($located);
	}

}

function homeid_get_page_title()
{
	$page_title = '';
	if ( ( is_home() && ! is_front_page() ) || ( is_page() ) ) {
		$page_title = single_post_title( '', false );
	} elseif (is_singular('post')) {
		$page_title = esc_html__('Blog','homeid');
	} elseif ( is_singular() ) {
		$page_title = get_the_title();
	} elseif ( is_search() ) {
		$page_title = sprintf( esc_html__( 'Search Results For: %s', 'homeid' ), get_search_query() );
	} elseif ( is_404() ) {
		$page_title = esc_html__( 'Page Not Found', 'homeid' );
	} elseif (is_home()) {
		$page_title = esc_html__('Blog','homeid');
	} elseif (is_post_type_archive('product') && (function_exists('wc_get_page_id')) ) {
		$shop_page_id = wc_get_page_id( 'shop' );
		$page_title   = get_the_title( $shop_page_id );

	} else {
		$page_title = get_the_archive_title();
	}

	return $page_title;
}

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function homeid_content_width()
{
	/**
	 * Filter content width of the theme.
	 *
	 * @param int $content_width Content width in pixels.
	 */
	$GLOBALS['content_width'] = apply_filters('homeid_content_width', $GLOBALS['content_width']);
}

add_action('template_redirect', 'homeid_content_width', 0);

/**
 * Checks to see if we're on the homepage or not.
 */
function homeid_is_frontpage()
{
	return (is_front_page() && !is_home());
}

function homeid_sidebar_primary()
{
	return apply_filters('homeid_sidebar_name', 'sidebar-blog');
}

function homeid_has_sidebar()
{
	return apply_filters('homeid_has_sidebar', is_active_sidebar(homeid_sidebar_primary()) && !is_404());
}

function homeid_body_class($classes)
{
	global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
	if ($is_lynx) {
		$classes[] = 'lynx';
	} elseif ($is_gecko) {
		$classes[] = 'gecko';
	} elseif ($is_opera) {
		$classes[] = 'opera';
	} elseif ($is_NS4) {
		$classes[] = 'ns4';
	} elseif ($is_safari) {
		$classes[] = 'safari';
	} elseif ($is_chrome) {
		$classes[] = 'chrome';
	} elseif ($is_IE) {
		$classes[] = 'ie';
	} else {
		$classes[] = 'unknown';
	}
	if ($is_iphone) {
		$classes[] = 'iphone';
	}

	if (!homeid_has_sidebar()) {
		$classes[] = 'no-sidebar';
	} else {
		$classes[] = 'has-sidebar';
	}

	return $classes;
}

add_filter('body_class', 'homeid_body_class');

function homeid_admin_body_class($classes)
{
	if (!homeid_has_sidebar()) {
		$classes .= ' no-sidebar';
	} else {
		$classes .= ' has-sidebar';
	}

	return $classes;
}

add_filter('admin_body_class', 'homeid_admin_body_class');

function homeid_nav_menu_item_title($title, $item, $args, $depth)
{
	if ($args->theme_location !== 'primary') {
		return $title;
	}

	if (in_array('menu-item-has-children', $item->classes)) {
		return $title . sprintf('<span class="caret"></span>');
	}

	return $title;

}

add_filter('nav_menu_item_title', 'homeid_nav_menu_item_title', 10, 4);

/**
 * Add font url to editor style
 *
 * @param $stylesheets
 *
 * @return array
 */
function homeid_custom_editor_styles($stylesheets)
{
	foreach (homeid_fonts_url() as $url) {
		$stylesheets[] = $url;
	}

	return $stylesheets;
}

function homeid_scripts_font()
{
	foreach (homeid_fonts_url() as $handler => $url) {
		wp_enqueue_style($handler, $url);
	}
}

add_filter('editor_stylesheets', 'homeid_custom_editor_styles', 100);
add_action('enqueue_block_editor_assets', 'homeid_scripts_font', 100);
add_action('wp_enqueue_scripts', 'homeid_scripts_font', 100);

