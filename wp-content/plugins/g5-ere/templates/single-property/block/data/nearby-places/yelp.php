<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$api_key = G5ERE()->options()->get_option( 'yelp_api_key' );

if ( empty( $api_key ) && ! current_user_can( 'administrator' ) ) {
	return;
}
$property_id   = get_the_ID();
$location      = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'property_location', true );
$prop_location = '';
if ( ! empty( $location ) ) {
	$prop_location = $location['location'];
	list( $lat, $lng ) = explode( ',', $location['location'] );
	$data_location = json_encode( array( 'lat' => $lat, 'lng' => $lng ) );
}
if ( empty( $prop_location ) ) {
	return;
}
$yelp_data      = G5ERE()->options()->get_option( 'yelp_categories' );
$yelp_dist_unit = G5ERE()->options()->get_option( 'yelp_distance_unit' );
$yelp_category  = G5ERE()->settings()->get_yelp_category();

$dist_unit = 1.1515;
$unit_text = 'mi';
if ( $yelp_dist_unit == 'kilometers' ) {
	$dist_unit = 1.609344;
	$unit_text = 'km';
}
$placeholder_image = g5ere_get_property_placeholder_image();
?>
<div class="g5ere__what-nearby">
	<?php
	if ( empty( $api_key ) ) :?>
        <div class="g5ere__what-nearby-empty-api-key alert alert-warning" role="alert">
			<?php echo sprintf( wp_kses_post( __( 'Please supply your API key <a class="alert-link" target="_blank" href="%s">Click Here</a>', 'g5-ere' ) ), admin_url( 'admin.php?page=g5ere_options&section=section_property_single' ) ); ?>
        </div>
	<?php
	else :
		foreach ( $yelp_data as $value ) :
			$term_id = $value;
			$term_name = $yelp_category[ $value ];
			$response = g5ere_yelp_query_api( $term_id, $prop_location );
			// Check for yelp api error
			if ( isset( $response->error ) ) :
				$output = '';
				$error  = '';
				if ( ! empty( $response->error->code ) ) {
					$error .= $response->error->code . ': ';
				}
				if ( ! empty( $response->error->description ) ) {
					$error .= $response->error->description;
				}
				echo '<div class="g5ere__api-error alert alert-danger">' . esc_html( $error ) . '</div>';

			else :

				if ( isset( $response->businesses ) ) {
					$businesses = $response->businesses;
				} else {
					$businesses = array( $response );
				}

				if ( ! count( $businesses ) ) {
					continue;
				}

				$distance    = false;
				$current_lat = '';
				$current_lng = '';

				if ( isset( $response->region->center ) ) {

					$current_lat = $response->region->center->latitude;
					$current_lng = $response->region->center->longitude;
					$distance    = true;
				}

				if ( sizeof( $businesses ) != 0 ) :
					?>

                    <div class="g5ere__cat-block">
                        <h3 class="g5ere__cat-block-title"><?php echo esc_html( $term_name ) ?></h3>

						<?php
						foreach ( $businesses as $data ) :
							$miles = 0;
							if ( $distance && isset( $data->coordinates ) ) {

								$location_lat = $data->coordinates->latitude;
								$location_lng = $data->coordinates->longitude;
								$theta        = $current_lng - $location_lng;
								$dist         = sin( deg2rad( $current_lat ) ) * sin( deg2rad( $location_lat ) ) + cos( deg2rad( $current_lat ) ) * cos( deg2rad( $location_lat ) ) * cos( deg2rad( $theta ) );
								$dist         = acos( $dist );
								$dist         = rad2deg( $dist );
								$miles        = $dist * 60 * $dist_unit;
							}
							$address = '';
							if ( is_array( $data->location->display_address ) ) {
								$numItems = count( $data->location->display_address );
								$i        = 0;
								foreach ( $data->location->display_address as $item ) {
									if ( ++ $i !== $numItems ) {
										$address .= $item . ',';
									} else {
										$address .= $item;
									}

								}
							}
							$image_url = $placeholder_image;
							if ( $data->image_url != '' ) {
								$image_url = $data->image_url;
							}
							$rating = ceil( $data->rating );
							?>
                            <div class="g5ere__cat-block-items">
                                <div class="g5ere__cat-block-item">
                                    <div class="media">
                                        <a href="<?php echo esc_url( $data->url ) ?>"
                                           class="g5ere__cat-block-item-thumb"
                                           style="background-image: url(<?php echo esc_url( $image_url ) ?>);">
                                        </a>
                                        <div class="media-body">
                                            <div class="g5ere__cat-block-content">
                                                <h4 class="g5ere__cat-block-item-title">
                                                    <a href="<?php echo esc_url( $data->url ) ?>"><?php echo esc_html( $data->name ) ?></a>
	                                                <?php if ($miles > 0): ?>
		                                                <span>(<?php echo esc_html(round($miles*100)/100) . ' ' . $unit_text ?>)</span>
													<?php endif; ?>
                                                </h4>
                                                <p class="g5ere__cat-block-item-address mb-0">
													<?php echo esc_html( $address ) ?>
                                                </p>
                                            </div>
                                            <div class="g5ere__cat-block-item-review g5ere__rating-review">
                                                <p class="g5ere__cat-block-item-review-number mb-0"><?php printf( __( '%s Reviews', 'g5-ere' ), $data->review_count ); ?></p>
                                                <div class="g5ere__cat-block-item-rating">
                                                    <div class="rating-wrap">
														<?php
														g5ere_template_star_rating_icon( $rating );
														?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
						<?php endforeach; ?>

                    </div>

				<?php
				endif;
			endif;

		endforeach;
	endif;
	?>
</div>

