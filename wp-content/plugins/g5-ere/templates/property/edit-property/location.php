<?php
/**
 * Created by G5Theme.
 * User: trungpq
 * Date: 18/11/16
 * Time: 5:45 PM
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $property_meta_data, $property_data, $hide_property_fields;
$location_dropdowns   = ere_get_option( 'location_dropdowns', 1 );
$property_map_address = get_post_meta( $property_data->ID, ERE_METABOX_PREFIX . 'property_address', true );
wp_enqueue_style( 'select2_css' );
wp_enqueue_script( 'select2_js' );
?>
<div class="row">
    <div class="col-lg-6">
        <div class="card property-fields-wrap">
            <div class="card-body">
                <div class="card-title property-fields-title">
                    <h2><?php esc_html_e( 'Property Location', 'g5-ere' ); ?></h2>
                </div>
                <div class="property-fields property-location row">
					<?php if ( ! in_array( "property_map_address", $hide_property_fields ) ) { ?>
                        <div class="col-12">
                            <div class="form-group">
                                <label
                                        for="address1"><?php echo esc_html__( 'Address', 'g5-ere' ) . ere_required_field( 'property_map_address' ); ?></label>
                                <input type="text" autocomplete="off" class="form-control" name="property_map_address"
                                       id="address1"
                                       value="<?php echo esc_attr( $property_map_address ); ?>"
                                       placeholder="<?php esc_attr_e( 'Enter property address', 'g5-ere' ); ?>">
                            </div>
                        </div>
					<?php } ?>
					<?php if ( ! in_array( "country", $hide_property_fields ) ) { ?>
                        <div class="col-sm-6 submit_country_field">
                            <div class="form-group ere-loading-ajax-wrap">
                                <label for="country"><?php echo esc_html__( 'Country', 'g5-ere' ) . ere_required_field('country'); ?></label>
								<?php if ( $location_dropdowns == 1 ) { ?>
                                    <select name="property_country" id="country"
                                            class="ere-property-country-ajax form-control">
										<?php
										$countries = ere_get_selected_countries();
										foreach ( $countries as $key => $country ):
											echo '<option ' . selected( $property_meta_data[ ERE_METABOX_PREFIX . 'property_country' ][0], $key, false ) . ' value="' . $key . '">' . $country . '</option>';
										endforeach;
										?>
                                    </select>
								<?php } else { ?>
                                    <input type="text" class="form-control" name="country"
                                           value="<?php echo ere_get_country_by_code( $property_meta_data[ ERE_METABOX_PREFIX . 'property_country' ][0] ); ?>"
                                           id="country">
                                    <input name="country_short" type="hidden"
                                           value="<?php echo esc_attr( $property_meta_data[ ERE_METABOX_PREFIX . 'property_country' ][0] ); ?>">
								<?php } ?>
                            </div>
                        </div>
					<?php } ?>
					<?php if ( ! in_array( "state", $hide_property_fields ) ) { ?>
                        <div class="col-sm-6">
                            <div class="form-group ere-loading-ajax-wrap">
                                <label for="state"><?php echo esc_html__( 'Province / State', 'g5-ere' ) . ere_required_field('state'); ?></label>
								<?php if ( $location_dropdowns == 1 ) { ?>
                                    <select name="property_state" id="state"
                                            class="ere-property-state-ajax form-control"
                                            data-selected="<?php echo ere_get_taxonomy_slug_by_post_id( $property_data->ID, 'property-state' ); ?>">
										<?php ere_get_taxonomy_by_post_id( $property_data->ID, 'property-state', true ); ?>
                                    </select>
								<?php } else { ?>
                                    <input type="text" class="form-control"
                                           value="<?php echo esc_attr( ere_get_taxonomy_name_by_post_id( $property_data->ID, 'property-state' ) ); ?>"
                                           name="administrative_area_level_1" id="state">
								<?php } ?>
                            </div>
                        </div>
					<?php } ?>
					<?php if ( ! in_array( "city", $hide_property_fields ) ) { ?>
                        <div class="col-sm-6">
                            <div class="form-group ere-loading-ajax-wrap">
                                <label for="city"><?php echo esc_html__( 'City / Town', 'g5-ere' ) . ere_required_field('city'); ?></label>
								<?php if ( $location_dropdowns == 1 ) { ?>
                                    <select name="property_city" id="city" class="ere-property-city-ajax form-control"
                                            data-selected="<?php echo ere_get_taxonomy_slug_by_post_id( $property_data->ID, 'property-city' ); ?>">
										<?php ere_get_taxonomy_by_post_id( $property_data->ID, 'property-city', true ); ?>
                                    </select>
								<?php } else { ?>
                                    <input type="text" class="form-control"
                                           value="<?php echo esc_attr( ere_get_taxonomy_name_by_post_id( $property_data->ID, 'property-city' ) ); ?>"
                                           name="locality" id="city">
								<?php } ?>
                            </div>
                        </div>
					<?php } ?>
					<?php if ( ! in_array( "neighborhood", $hide_property_fields ) ) { ?>
                        <div class="col-sm-6">
                            <div class="form-group ere-loading-ajax-wrap">
                                <label for="neighborhood"><?php echo esc_html__( 'Neighborhood', 'g5-ere' ) . ere_required_field('neighborhood'); ?></label>
								<?php if ( $location_dropdowns == 1 ) { ?>
                                    <select name="property_neighborhood" id="neighborhood"
                                            class="ere-property-neighborhood-ajax form-control"
                                            data-selected="<?php echo ere_get_taxonomy_slug_by_post_id( $property_data->ID, 'property-neighborhood' ); ?>">
										<?php ere_get_taxonomy_by_post_id( $property_data->ID, 'property-neighborhood', true ); ?>
                                    </select>
								<?php } else { ?>
                                    <input type="text" class="form-control" name="neighborhood"
                                           value="<?php echo esc_attr( ere_get_taxonomy_name_by_post_id( $property_data->ID, 'property_area' ) ); ?>"
                                           id="neighborhood">
								<?php } ?>
                            </div>
                        </div>
					<?php } ?>
					<?php if ( ! in_array( "postal_code", $hide_property_fields ) ) { ?>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="zip"><?php echo esc_html__( 'Postal Code / Zip', 'g5-ere' ) . ere_required_field('postal_code'); ?></label>
                                <input type="text" class="form-control" name="postal_code"
                                       value="<?php if ( isset( $property_meta_data[ ERE_METABOX_PREFIX . 'property_zip' ][0] ) ) {
									       echo esc_attr( $property_meta_data[ ERE_METABOX_PREFIX . 'property_zip' ][0] );
								       } ?>" id="zip">
                            </div>
                        </div>
					<?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card property-fields-wrap">
            <div class="card-body">
				<?php
				$property_location = get_post_meta( $property_data->ID, ERE_METABOX_PREFIX . "property_location", true );
				$location          = isset( $property_location['location'] ) ? $property_location['location'] : '';
				$location_array    = explode( ',', $location );
				$lat               = isset( $location_array[0] ) ? $location_array[0] : '';
				$lng               = isset( $location_array[1] ) ? $location_array[1] : '';
				$address           = isset( $property_location['address'] ) ? $property_location['address'] : '';
				$lock_pin          = get_post_meta( get_the_ID(), ERE_METABOX_PREFIX . "map_lock_pin", true );
				?>
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="card-title property-fields-title">
                            <h2><?php esc_html_e( 'Map', 'g5-ere' ); ?></h2>
                        </div>
                        <div class="input-group">
                            <input class="g5ere__property_address form-control"
                                   placeholder="<?php esc_html_e( 'Enter an address...', 'g5-ere' ) ?>"
                                   data-field-control="" type="text"
                                   name="property_search_address"
                                   value="<?php echo esc_attr( $address ) ?>">
                            <div class="input-group-append">
                            <span class="g5ere__current-location input-group-text"><i
                                        class="dashicons dashicons-location"></i></span>
                            </div>
                        </div>
                    </div><!-- /.gsf-col -->
                </div><!-- /.gsf-row -->
                <div class="mb-3 g5ere__lock-pin">
                    <input class="g5ere__map-lock-pin" type="checkbox" value="yes" id="lock_pin"
                           name="<?php echo esc_attr( ERE_METABOX_PREFIX . "map_lock_pin" ) ?>" <?php checked( 'yes', $lock_pin ) ?>>
                    <label for="lock_pin" class="locked"><i
                                class="dashicons dashicons-lock"></i><span><?php esc_html_e( 'Unlock Pin Location', 'g5-ere' ) ?></span></label>
                    <label for="lock_pin" class="unlocked"><i
                                class="dashicons dashicons-unlock"></i><span><?php esc_html_e( 'Lock Pin Location', 'g5-ere' ) ?></span></label>
                </div>

                <div class="row mb-3">
                    <div class="col-12">
						<?php
						$map_options = array(
							'cluster_markers' => false,
							'position'        => array(
								'lat' => $lat,
								'lng' => $lng
							)
						);
						?>
                        <div id="g5ere__admin_property_map" class="g5ere__map-canvas" style="height: 250px;"
                             data-options="<?php echo esc_attr( wp_json_encode( $map_options ) ) ?>"></div>

                    </div>
                </div>
                <div class="g5ere__enter-coordinates-toggle text-left ">
                    <label><?php _e( 'Enter coordinates manually', 'g5-ere' ) ?></label>
                </div>
                <div class="row g5ere__location-coords hide">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="lat"><?php esc_html_e( 'Latitude', 'g5-ere' ) ?></label>
                            <input required id="lat"
                                   pattern="^(?=.)-?((8[0-5]?)|([0-7]?[0-9]))?(?:\.[0-9]{1,20})?$"
                                   data-field-control="" style="width: 100%" type="text"
                                   name="<?php echo esc_attr( ERE_METABOX_PREFIX . 'map_lat' ) ?>"
                                   value="<?php echo esc_attr( $lat ) ?>">
                            <input type="hidden" name="lat" id="latitude">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="lng"><?php esc_html_e( 'Longitude', 'g5-ere' ) ?></label>
                            <input required id="lng"
                                   pattern="^(?=.)-?((0?[8-9][0-9])|180|([0-1]?[0-7]?[0-9]))?(?:\.[0-9]{1,20})?$"
                                   data-field-control="" style="width: 100%" type="text"
                                   name="<?php echo esc_attr( ERE_METABOX_PREFIX . 'map_lng' ) ?>"
                                   value="<?php echo esc_attr( $lng ) ?>">
                            <input type="hidden" name="lng" id="longitude">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

