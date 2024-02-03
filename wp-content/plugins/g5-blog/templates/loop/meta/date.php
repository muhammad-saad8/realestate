<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
?>
<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><i class="far fa-calendar"></i><span><?php echo get_the_date(get_option('date_format')); ?></span></a>
