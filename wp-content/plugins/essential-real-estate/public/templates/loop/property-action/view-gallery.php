<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $property_id
 * @var $total_image
 */
?>
<a data-toggle="tooltip"
   title="<?php echo esc_attr(sprintf(__('(%s) Photos', 'essential-real-estate'), $total_image)); ?>"
   data-property-id="<?php echo esc_attr($property_id); ?>"
   href="javascript:void(0)" class="property-view-gallery">
    <i class="fa fa-camera"></i>
</a>
