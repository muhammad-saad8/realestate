<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$address  = '';
$lat      = '';
$lng      = '';
$lock_pin = 'no';
$location = '';
if ( isset( $_REQUEST['tag_ID'] ) ) {
	if ( $_REQUEST['tag_ID'] != '' ) {
		$tagID       = absint( $_REQUEST['tag_ID'] );
		$address_arr = get_term_meta( $tagID, 'agency_map_address', true );
		if ( isset( $address_arr['location'] ) ) {
			$location_array = explode( ',', $address_arr['location'] );
			$lat            = isset( $location_array[0] ) ? $location_array[0] : '';
			$lng            = isset( $location_array[1] ) ? $location_array[1] : '';
			$location       = $address_arr['location'];
		}
		if ( isset( $address_arr['address'] ) ) {
			$address = $address_arr['address'];
		}
		$lock_pin = get_term_meta( $tagID, "g5ere_agency_map_lock_pin", true );
	}

}

?>
<div class="gsf-row">
    <div class="gsf-col gsf-col-12">
        <div class="gsf-col-inner gsf-col-layout-full">
            <div class="gsf-label">
                <div class="gsf-title"><?php esc_html_e( 'Map', 'g5-ere' ) ?></div>
            </div>
            <div class="gsf-field-content">
                <div class="gsf-field-content-inner">
                    <div class="g5ere__input-icon icon-both">
                        <span><i class="dashicons dashicons-search"></i></span>
                        <input class="g5ere__agency_address"
                               placeholder="<?php esc_html_e( 'Enter an address...', 'g5-ere' ) ?>"
                               data-field-control="" type="text" name="real_estate_agency_location[address]"
                               value="<?php echo esc_attr( $address ) ?>">
                        <span class="g5ere__current-location"><i class="dashicons dashicons-location"></i></span>
                    </div>
                </div>
            </div>
        </div><!-- /.gsf-col-inner -->
    </div><!-- /.gsf-col -->
</div><!-- /.gsf-row -->
<div class="gsf-row g5ere__location-actions">
    <div class="gsf-col gsf-col-6 g5ere__lock-pin">
        <input class="g5ere__map-lock-pin" type="checkbox" value="yes" id="lock_pin"
               name="g5ere_agency_map_lock_pin" <?php checked( 'yes', $lock_pin ) ?>>
        <label for="lock_pin" class="locked"><i
                    class="dashicons dashicons-lock"></i><span><?php esc_html_e( 'Unlock Pin Location', 'g5-ere' ) ?></span></label>
        <label for="lock_pin" class="unlocked"><i
                    class="dashicons dashicons-unlock"></i><span><?php esc_html_e( 'Lock Pin Location', 'g5-ere' ) ?></span></label>
    </div>
    <div class="gsf-col gsf-col-6 g5ere__enter-coordinates-toggle">
        <label><?php _e( 'Enter coordinates manually', 'g5-ere' ) ?></label>
    </div>
</div>
<div class="gsf-row g5ere__location-coords hide">
    <input type="hidden" name="real_estate_agency_location[location]"
           value="<?php echo esc_attr( $location ) ?>">
    <div class="gsf-col gsf-col-6">
        <div class="gsf-col-inner gsf-col-layout-full">
            <div class="gsf-label">
                <div class="gsf-title"><?php esc_html_e( 'Latitude', 'g5-ere' ) ?></div>
            </div>
            <div class="gsf-field-content">
                <div class="gsf-field-content-inner">
                    <input required
                           pattern="^(?=.)-?((8[0-5]?)|([0-7]?[0-9]))?(?:\.[0-9]{1,20})?$"
                           data-field-control="" style="width: 100%" type="text" name="real_estate_map_lat"
                           value="<?php echo esc_attr( $lat ) ?>">
                </div>
            </div>
        </div><!-- /.gsf-col-inner -->
    </div>
    <div class="gsf-col gsf-col-6 ">
        <div class="gsf-col-inner gsf-col-layout-full">
            <div class="gsf-label">
                <div class="gsf-title"><?php esc_html_e( 'Longitude', 'g5-ere' ) ?></div>
            </div>
            <div class="gsf-field-content">
                <div class="gsf-field-content-inner">
                    <input required
                           pattern="^(?=.)-?((0?[8-9][0-9])|180|([0-1]?[0-7]?[0-9]))?(?:\.[0-9]{1,20})?$"
                           data-field-control="" style="width: 100%" type="text" name="real_estate_map_lng"
                           value="<?php echo esc_attr( $lng ) ?>">
                </div>
            </div>
        </div><!-- /.gsf-col-inner -->
    </div>
</div>
<div class="gsf-row">
    <div class="gsf-col gsf-col-12">
        <div class="gsf-col-inner gsf-col-layout-full">
            <div class="gsf-field-content">
                <div class="gsf-field-content-inner">
					<?php
					$map_options = array(
						'cluster_markers' => false,
						'position'        => array(
							'lat' => $lat,
							'lng' => $lng
						)
					);
					?>
                    <div id="g5ere__admin_agency_map" class="g5ere__map-canvas" style="height: 400px"
                         data-options="<?php echo esc_attr( wp_json_encode( $map_options ) ) ?>"></div>
                </div>
            </div>
        </div>
    </div>
</div>

