<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
?>
<div class="g5blog__single-meta-tag tagcloud">
	<label><?php esc_html_e('Tags:','g5-blog') ?></label>
	<?php the_tags('','',''); ?>
</div>