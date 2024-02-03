<?php
/**
 * The template for displaying 404 content layout
 *
 * @since 1.0
 * @version 1.0
 */
?>
<?php
/**
 * The template for displaying 404 content layout
 *
 * @since 1.0
 * @version 1.0
 */
?>
<div class="content-404-wrapper">
	<img src="<?php echo esc_url(get_parent_theme_file_uri('assets/images/404.png'));  ?>" alt="<?php esc_attr__('404','homeid') ?>">
	<h4><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'homeid' ); ?></h4>
	<p><?php esc_html_e('Sorry, but the page you are looking for is not found. Please, make sure you have typed the current URL.', 'homeid') ?></p>
	<a href="<?php echo esc_url( home_url('/') ); ?>" class="btn"><?php esc_html_e('Go to home page', 'homeid'); ?></a>
</div><!-- .wrap -->
