<?php
/**
 * @var $properties
 * @var $max_num_pages
 * @var $post_status
 * @var $title
 * @var $property_identity
 * @var $property_status
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$allow_submit = ere_allow_submit();
if ( ! $allow_submit ) {
	echo ere_get_template_html( 'global/access-denied.php', array( 'type' => 'not_permission' ) );

	return;
}
$request_new_id = isset( $_GET['new_id'] ) ? ere_clean( wp_unslash( $_GET['new_id'] ) ) : '';
if ( ! empty( $request_new_id ) ) {
	ere_get_template( 'property/property-submitted.php', array(
		'property' => get_post( $request_new_id ),
		'action'   => 'new'
	) );
}
$request_edit_id = isset( $_GET['edit_id'] ) ? ere_clean( wp_unslash( $_GET['edit_id'] ) ) : '';
if ( ! empty( $request_edit_id ) ) {
	ere_get_template( 'property/property-submitted.php', array(
		'property' => get_post( $request_edit_id ),
		'action'   => 'edit'
	) );
}
$my_properties_page_link = ere_get_permalink( 'my_properties' );
$ere_property            = new ERE_Property();
$total_properties        = $ere_property->get_total_my_properties( array( 'publish', 'pending', 'expired', 'hidden' ) );
$post_status_approved    = remove_query_arg( array(
	'new_id',
	'edit_id'
), add_query_arg( array( 'post_status' => 'publish' ), $my_properties_page_link ) );
$total_approved          = $ere_property->get_total_my_properties( 'publish' );
$post_status_pending     = remove_query_arg( array(
	'new_id',
	'edit_id'
), add_query_arg( array( 'post_status' => 'pending' ), $my_properties_page_link ) );
$total_pending           = $ere_property->get_total_my_properties( 'pending' );
$post_status_expired     = remove_query_arg( array(
	'new_id',
	'edit_id'
), add_query_arg( array( 'post_status' => 'expired' ), $my_properties_page_link ) );
$total_expired           = $ere_property->get_total_my_properties( 'expired' );

$post_status_hidden = remove_query_arg( array(
	'new_id',
	'edit_id'
), add_query_arg( array( 'post_status' => 'hidden' ), $my_properties_page_link ) );
$total_hidden       = $ere_property->get_total_my_properties( 'hidden' );

$paid_submission_type = ere_get_option( 'paid_submission_type', 'no' );
$ere_profile          = new ERE_Profile();
global $current_user;
wp_get_current_user();
$user_id = $current_user->ID;
?>
<div class="panel panel-default ere-my-properties">
    <div class="panel-body">
        <form method="get" action="<?php echo get_page_link(); ?>" class="ere-my-properties-search">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <div class="input-group bg-white border">
                            <div class="input-group-prepend">
                                <button class="btn bg-transparent pr-0 shadow-none border-0 text-muted"
                                        type="submit"><i
                                            class="far fa-search"></i>
                                </button>
                            </div>
                            <input type="text" value="<?php echo esc_attr( $title ); ?>"
                                   class="form-control bg-transparent border-0 shadow-none text-body"
                                   placeholder="<?php esc_attr_e( 'Search listing', 'g5-ere' ); ?>"
                                   name="title">
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 text-sm-right">
                    <div class="dropdown g5ere__dropdown-status mb-3">
                        <button class="btn btn-outline dropdown-toggle text-capitalize" type="button"
                                id="dropdownMenuStatus"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<?php
							if ( ! empty( $_REQUEST['post_status'] ) ) {
								$post_status = sanitize_title( wp_unslash( $_REQUEST['post_status'] ) );
								if ( $post_status == 'publish' ) {
									printf( __( 'Approved (%s)', 'g5-ere' ), $total_approved );
								} elseif ( $post_status == 'pending' ) {
									printf( __( 'Pending (%s)', 'g5-ere' ), $total_pending );
								} elseif ( $post_status == 'expired' ) {
									printf( __( 'Expired (%s)', 'g5-ere' ), $total_expired );
								} elseif ( $post_status == 'hidden' ) {
									printf( __( 'Hidden (%s)', 'g5-ere' ), $total_hidden );
								}
							} else {
								printf( __( 'All (%s)', 'g5-ere' ), $total_properties );
							}

							?>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuStatus">
                            <a class="dropdown-item <?php if ( is_array( $post_status ) )
								echo ' active' ?>"
                               href="<?php echo esc_url( $my_properties_page_link ); ?>">
								<?php printf( __( 'All (%s)', 'g5-ere' ), $total_properties ); ?>
                            </a>
                            <a class="dropdown-item <?php if ( $post_status == 'publish' )
								echo ' active' ?>"
                               href="<?php echo esc_url( $post_status_approved ); ?>">
								<?php printf( __( 'Approved (%s)', 'g5-ere' ), $total_approved ); ?>
                            </a>
                            <a class="dropdown-item <?php if ( $post_status == 'pending' )
								echo ' active' ?>" href="<?php echo esc_url( $post_status_pending ); ?>">
								<?php printf( __( 'Pending (%s)', 'g5-ere' ), $total_pending ); ?>
                            </a>
                            <a class="dropdown-item<?php if ( $post_status == 'expired' )
								echo ' active' ?>" href="<?php echo esc_url( $post_status_expired ); ?>">
								<?php printf( __( 'Expired (%s)', 'g5-ere' ), $total_expired ); ?>
                            </a>
                            <a class="dropdown-item<?php if ( $post_status == 'hidden' )
								echo ' active' ?>" href="<?php echo esc_url( $post_status_hidden ); ?>">
								<?php printf( __( 'Hidden (%s)', 'g5-ere' ), $total_hidden ); ?>
                            </a>
                        </div>
                    </div>
					<?php
					if ( ! empty( $_REQUEST['post_status'] ) ):
						$post_status = sanitize_title( wp_unslash( $_REQUEST['post_status'] ) ); ?>
                        <input type="hidden" name="post_status"
                               value="<?php echo esc_attr( $post_status ); ?>"/>
					<?php endif; ?>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table ere-dashboard-table-property bg-white">
                <thead class="thead-sm">
                    <tr>
                        <th scope="col">
							<?php esc_html_e( 'Listing title', 'g5-ere' ) ?>
                        </th>
                        <th scope="col">
							<?php esc_html_e( 'Date Published', 'g5-ere' ) ?>
                        </th>
                        <th scope="col">
							<?php esc_html_e( 'Status', 'g5-ere' ) ?>
                        </th>
                        <th scope="col">
							<?php esc_html_e( 'View', 'g5-ere' ) ?>
                        </th>
                        <th scope="col">
							<?php esc_html_e( 'Feature', 'g5-ere' ) ?>
                        </th>
                        <th scope="col">
							<?php esc_html_e( 'Action', 'g5-ere' ) ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
					<?php if ( ! $properties ): ?>
                        <tr>
                            <td colspan="6">
                                <div class="ere-message alert alert-warning"><?php esc_html_e( 'You don\'t have any properties listed.', 'g5-ere' ); ?></div>
                            </td>
                        </tr>
					<?php else: ?>
						<?php
						while ( $the_query->have_posts() ):$the_query->the_post();
							$property = get_post();
							?>
                            <tr class="">
                                <td class="align-middle pt-6 pb-4 px-6">
                                    <div class="media g5ere__my-property">
                                        <div class="position-relative mr-3">
											<?php
											$attach_id = get_post_thumbnail_id( $property );
											$image_arr = array(
												'image_size' => '120x85',
												'image_mode' => 'image',
												'post'       => $property,
												'permalink'  => g5ere_get_property_permalink( $property )
											);
											if ( $attach_id != '' ) {
												$image_arr['image_id'] = $attach_id;
											} else {
												$image_arr['image_id'] = '';
											}
											$thumbnail_data = g5ere_get_property_thumbnail_data( $image_arr );
											?>
											<?php if ( $thumbnail_data['url'] !== '' ): ?>
												<?php g5ere_render_property_thumbnail_markup( $image_arr ); ?>
											<?php endif; ?>
                                        </div>
                                        <div class="media-body">
											<?php
											/**
											 * @hooked g5ere_template_loop_property_title
											 * @hooked g5ere_template_loop_property_address
											 * @hooked g5ere_template_loop_property_price
											 */
											do_action( 'g5ere_my_property_content' ) ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle"> <?php echo date_i18n( get_option( 'date_format' ), strtotime( $property->post_date ) ); ?></td>
                                <td class="align-middle">
									<?php
									switch ( $property->post_status ) {
										case 'publish':
											?>
                                            <span class="badge badge-info"> <?php esc_html_e( 'Published', 'g5-ere' ) ?> </span>
											<?php
											break;
										case 'expired':
											?>
                                            <span class="badge badge-danger"> <?php esc_html_e( 'Expired', 'g5-ere' ) ?> </span>
											<?php
											break;
										case 'pending':
											?>
                                            <span class="badge badge-warning"> <?php esc_html_e( 'Pending', 'g5-ere' ) ?> </span>
											<?php
											break;
										case 'hidden':
											?>
                                            <span class="badge badge-secondary"> <?php esc_html_e( 'Hidden', 'g5-ere' ) ?> </span>
											<?php
											break;
										default:
											?>
                                            <span class="badge badge-primary"> <?php echo esc_html( $property->post_status ) ?> </span>
										<?php
									} ?>
									<?php
									$listing_expire = ere_get_option( 'per_listing_expire_days' );
									if ( $paid_submission_type == 'per_listing' && $listing_expire == 1 ) :
										$number_expire_days = ere_get_option( 'number_expire_days' );
										$property_date      = $property->post_date;
										$timestamp          = strtotime( $property_date ) + intval( $number_expire_days ) * 24 * 60 * 60;
										$expired_date       = date( 'Y-m-d H:i:s', $timestamp );
										$expired_date       = new DateTime( $expired_date );

										$now      = new DateTime();
										$interval = $now->diff( $expired_date );
										$days     = $interval->days;
										$hours    = $interval->h;
										$invert   = $interval->invert;

										if ( $invert == 0 ) {
											if ( $days > 0 ) {
												echo '<span class="ere-my-property-date-expire badge">' . sprintf( __( 'Expire: %s days %s hours', 'g5-ere' ), $days, $hours ) . '</span>';
											} else {
												echo '<span class="ere-my-property-date-expire badge">' . sprintf( __( 'Expire: %s hours', 'g5-ere' ), $hours ) . '</span>';
											}
										} else {
											$expired_date = date_i18n( get_option( 'date_format' ), $timestamp );
											echo '<span class="ere-my-property-date-expire badge badge-expired">' . sprintf( __( 'Expired: %s', 'g5-ere' ), $expired_date ) . '</span>';
										}
									endif; ?>
									<?php do_action( 'ere_my_property_before_actions', $property->ID ) ?>
                                </td>
                                <td class="align-middle"> <?php
									$total_views = $ere_property->get_total_views( $property->ID );
									echo esc_html( $total_views );
									?></td>
                                <td class="align-middle">
									<?php
									$prop_featured = get_post_meta( $property->ID, ERE_METABOX_PREFIX . 'property_featured', true );
									if ( $prop_featured == 1 ):?>
                                        <span class="badge badge-success"><?php esc_html_e( 'Yes', 'g5-ere' ) ?></span>
									<?php else:
										?>
                                        <span class="badge badge-secondary"><?php esc_html_e( 'No', 'g5-ere' ) ?></span>
									<?php endif;
									?>
                                </td>
                                <td class="align-middle">
                                    <ul class="ere-dashboard-actions list-inline mb-0">
										<?php
										$actions        = array();
										$payment_status = get_post_meta( $property->ID, ERE_METABOX_PREFIX . 'payment_status', true );
										switch ( $property->post_status ) {
											case 'publish' :
												$prop_featured = get_post_meta( $property->ID, ERE_METABOX_PREFIX . 'property_featured', true );
												if ( $paid_submission_type == 'per_package' ) {
													$current_package_key  = get_the_author_meta( ERE_METABOX_PREFIX . 'package_key', $user_id );
													$property_package_key = get_post_meta( $property->ID, ERE_METABOX_PREFIX . 'package_key', true );

													$check_package = $ere_profile->user_package_available( $user_id );
													if ( ! empty( $property_package_key ) && $current_package_key == $property_package_key ) {
														if ( $check_package != - 1 && $check_package != 0 ) {
															$actions['edit'] = array(
																'label'   => __( 'Edit', 'g5-ere' ),
																'tooltip' => __( 'Edit property', 'g5-ere' ),
																'nonce'   => false,
																'confirm' => ''
															);
														}
														$package_num_featured_listings = get_the_author_meta( ERE_METABOX_PREFIX . 'package_number_featured', $user_id );
														if ( $package_num_featured_listings > 0 && ( $prop_featured != 1 ) && ( $check_package != - 1 ) && ( $check_package != 0 ) ) {
															$actions['mark_featured'] = array(
																'label'   => __( 'Mark featured', 'g5-ere' ),
																'tooltip' => __( 'Make this a Featured Property', 'g5-ere' ),
																'nonce'   => true,
																'confirm' => esc_html__( 'Are you sure you want to mark this property as Featured?', 'g5-ere' )
															);
														}
													} elseif ( $current_package_key != $property_package_key && $check_package == 1 ) {
														$actions['allow_edit'] = array(
															'label'   => __( 'Allow Editing', 'g5-ere' ),
															'tooltip' => __( 'This property listing belongs to an expired Package therefore if you wish to edit it, it will be charged as a new listing from your current Package.', 'g5-ere' ),
															'nonce'   => true,
															'confirm' => esc_html__( 'Are you sure you want to allow editing this property listing?', 'g5-ere' )
														);
													}
												} else {
													if ( $paid_submission_type != 'no' && $prop_featured != 1 ) {
														$actions['mark_featured'] = array(
															'label'   => __( 'Mark featured', 'g5-ere' ),
															'tooltip' => __( 'Make this a Featured Property', 'g5-ere' ),
															'nonce'   => true,
															'confirm' => esc_html__( 'Are you sure you want to mark this property as Featured?', 'g5-ere' )
														);
													}
													$actions['edit'] = array(
														'label'   => __( 'Edit', 'g5-ere' ),
														'tooltip' => __( 'Edit Property', 'g5-ere' ),
														'nonce'   => false,
														'confirm' => ''
													);
												}

												if ($prop_featured == 1) {
													$actions['remove_featured'] = array('label' => __('Remove featured', 'g5-ere'), 'tooltip' => __('Remove Featured of Property', 'g5-ere'), 'nonce' => true, 'confirm' => esc_html__('Are you sure you want to remove featured of property?', 'g5-ere'));
												}



												break;
											case 'expired' :
												if ( $paid_submission_type == 'per_package' ) {
													$check_package = $ere_profile->user_package_available( $user_id );
													if ( $check_package == 1 ) {
														$actions['relist_per_package'] = array(
															'label'   => __( 'Reactivate Listing', 'g5-ere' ),
															'tooltip' => __( 'Reactivate Listing', 'g5-ere' ),
															'nonce'   => true,
															'confirm' => esc_html__( 'Are you sure you want to reactivate this property?', 'g5-ere' )
														);
													}
												}
												if ( $paid_submission_type == 'per_listing' && $payment_status == 'paid' ) {
													$price_per_listing = ere_get_option( 'price_per_listing', 0 );
													if ( $price_per_listing <= 0 || $payment_status == 'paid' ) {
														$actions['relist_per_listing'] = array(
															'label'   => __( 'Resend this Listing for Approval', 'g5-ere' ),
															'tooltip' => __( 'Resend this Listing for Approval', 'g5-ere' ),
															'nonce'   => true,
															'confirm' => esc_html__( 'Are you sure you want to resend this property for approval?', 'g5-ere' )
														);
													}
												}
												break;
											case 'pending' :
												$actions['edit'] = array(
													'label'   => __( 'Edit', 'g5-ere' ),
													'tooltip' => __( 'Edit Property', 'g5-ere' ),
													'nonce'   => false,
													'confirm' => ''
												);
												break;
											case 'hidden' :
												$actions['show'] = array(
													'label'   => __( 'Show', 'g5-ere' ),
													'tooltip' => __( 'Show Property', 'g5-ere' ),
													'nonce'   => true,
													'confirm' => esc_html__( 'Are you sure you want to show this property?', 'g5-ere' )
												);
												break;
										}
										$actions['delete'] = array(
											'label'   => __( 'Delete', 'g5-ere' ),
											'tooltip' => __( 'Delete Property', 'g5-ere' ),
											'nonce'   => true,
											'confirm' => esc_html__( 'Are you sure you want to delete this property?', 'g5-ere' )
										);
										if ( $property->post_status == 'publish' ) {
											$actions['hidden'] = array(
												'label'   => __( 'Hide', 'g5-ere' ),
												'tooltip' => __( 'Hide Property', 'g5-ere' ),
												'nonce'   => true,
												'confirm' => esc_html__( 'Are you sure you want to hide this property?', 'g5-ere' )
											);
										}

										if ( $paid_submission_type == 'per_listing' && $payment_status != 'paid' && $property->post_status != 'hidden' ) {
											$price_per_listing = ere_get_option( 'price_per_listing', 0 );
											if ( $price_per_listing > 0 ) {
												$actions['payment_listing'] = array(
													'label'   => __( 'Pay Now', 'g5-ere' ),
													'tooltip' => __( 'Pay for this property listing', 'g5-ere' ),
													'nonce'   => true,
													'confirm' => esc_html__( 'Are you sure you want to pay for this listing?', 'g5-ere' )
												);
											}
										}

										$actions = apply_filters( 'ere_my_properties_actions', $actions, $property );
										foreach ( $actions as $action => $value ) {
											$my_properties_page_link = ere_get_permalink( 'my_properties' );
											$action_url              = add_query_arg( array(
												'action'      => $action,
												'property_id' => $property->ID
											), $my_properties_page_link );
											if ( $value['nonce'] ) {
												$action_url = wp_nonce_url( $action_url, 'ere_my_properties_actions' );
											}
											?>
                                            <li class="list-inline-item">
                                                <a <?php if ( ! empty( $value['confirm'] ) ): ?> onclick="return confirm('<?php echo esc_html( $value['confirm'] ); ?>')" <?php endif; ?>
                                                        href="<?php echo esc_url( $action_url ); ?>"
                                                        data-toggle="tooltip"
                                                        data-placement="bottom"
                                                        title="<?php echo esc_attr( $value['tooltip'] ); ?>"
                                                        class="btn-action ere-dashboard-action-<?php echo esc_attr( $action ); ?>"><?php echo esc_html( $value['label'] ); ?></a>
                                            </li>
											<?php
										}
										?>
                                    </ul>
                                </td>
                            </tr>
						<?php endwhile; ?>
					<?php endif; ?>
                </tbody>
            </table>
        </div>
		<?php ere_get_template( 'global/pagination.php', array( 'max_num_pages' => $max_num_pages ) ); ?>
    </div>
</div>
