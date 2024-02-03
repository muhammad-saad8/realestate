<?php
/**
 * The template for displaying post-view.php
 *
 */
if (in_array('post-views-counter/post-views-counter.php', apply_filters('active_plugins', get_option('active_plugins')))) {
        ?>
        <li class="meta-view">
            <?php
            echo do_shortcode('[post-views]');
            ?>
        </li>
<?php
}

