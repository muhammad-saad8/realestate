<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $property_id
 */
?>
<a class="compare-property" href="javascript:void(0)"
   data-property-id="<?php echo esc_attr($property_id) ?>" data-toggle="tooltip"
   title="<?php esc_attr_e('Compare', 'essential-real-estate') ?>">
    <i class="fa fa-plus"></i>
</a>
