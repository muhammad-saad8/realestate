<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $property_garage
 */
?>
<div class="ere__loop-property-info-item property-garages" data-toggle="tooltip" title="<?php printf(_n('%s Garage', '%s Garages', $property_garage, 'essential-real-estate'), $property_garage); ?>">
    <i class="fa fa-car"></i>
    <div class="ere__lpi-content">
        <span class="ere__lpi-value"><?php echo esc_html( $property_garage ) ?></span>
        <span class="ere__lpi-label"><?php echo _n( 'Garage', 'Garages', $property_garage, 'essential-real-estate' )?></span>
    </div>
</div>