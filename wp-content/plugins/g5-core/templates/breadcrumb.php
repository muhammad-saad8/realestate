<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * $wrapper_class
 */
?>
<div class="g5core__single-breadcrumbs <?php echo esc_attr($wrapper_class)?>">
    <div class="container">
        <?php G5CORE()->breadcrumbs()->get_breadcrumbs(); ?>
    </div>
</div>
