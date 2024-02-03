<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
?>
<div class="site-search-results-not-found">
    <h2><?php esc_html_e('Nothing found','g5-blog') ?></h2>
    <p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'g5-blog' ); ?></p>
    <?php get_search_form(); ?>
</div>
