<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $property_id
 */
?>
<div class="property-action block-center">
    <div class="block-center-inner">
        <?php
        /**
         * ere_property_action hook.
         *
         * @hooked property_social_share - 5
         * @hooked property_favorite - 10
         * @hooked property_compare - 15
         */
        do_action( 'ere_loop_property_action', $property_id ); ?>
    </div>
    <?php
    /**
     * ere_after_loop_property_action hook.
     *
     * @hooked ere_template_loop_property_link - 10
     */
    do_action('ere_after_loop_property_action', $property_id);
    ?>
</div>
