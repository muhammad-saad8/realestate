<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $excerpt
 */
?>
<div class="property-excerpt">
    <?php echo apply_filters( 'the_excerpt', $excerpt ); ?>
</div>
