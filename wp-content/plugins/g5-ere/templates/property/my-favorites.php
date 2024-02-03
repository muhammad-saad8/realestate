<?php
/**
 * @var $favorites
 * @var $max_num_pages
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$ere_property = new ERE_Property();
?>
<div class="panel panel-default ere-my-favorite">
    <div class="panel-body">
		<?php
		if ( isset( $_REQUEST['result'] ) && isset( $_REQUEST['property_id'] ) ):
			$property_id = $_REQUEST['property_id'];
			$property = get_post( $property_id );
			if ( $_REQUEST['result'] === 'success' ):
				?>
                <div class="ere-message alert alert-success" role="alert">
                    <strong><?php esc_html_e( 'Success!', 'g5-ere' ) ?></strong> <?php printf( __( '%s has been removed', 'g5-ere' ), $property->post_title ); ?>
                </div>
			<?php
			else:
				?>
                <div class="ere-message alert alert-danger" role="alert">
                    <strong><?php esc_html_e( 'Error!', 'g5-ere' ) ?></strong> <?php printf( __( '%s has not been removed', 'g5-ere' ), $property->post_title ); ?>
                </div>
			<?php
			endif;
		endif;
		?>
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
							<?php esc_html_e( 'View', 'g5-ere' ) ?>
                        </th>
                        <th scope="col">
							<?php esc_html_e( 'Action', 'g5-ere' ) ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
					<?php if ( ! $favorites->have_posts() ) :
						?>
                        <tr>
                            <td colspan="5">
                                <div class="ere-message alert alert-warning"><?php esc_html_e( 'You don\'t have any properties listed.', 'g5-ere' ); ?></div>
                            </td>
                        </tr>
					<?php else :
						?>
						<?php
						while ( $favorites->have_posts() ):$favorites->the_post();
							$property_id = get_the_ID();
							?>
                            <tr class="ere-my-favorite-item">
                                <td class="align-middle pt-6 pb-4 px-6">
                                    <div class="media g5ere__my-property">
                                        <div class="position-relative mr-3">
											<?php
											$thumbnail_data = g5ere_get_property_thumbnail_data( array(
												'image_size' => '120x85',
											) );
											?>
											<?php if ( $thumbnail_data['url'] !== '' ): ?>
												<?php g5ere_render_property_thumbnail_markup( array(
													'image_size' => '120x85',
													'image_mode' => 'image',
												) ); ?>
											<?php endif; ?>
                                        </div>
                                        <div class="media-body">
											<?php
											/**
											 * @hooked g5ere_template_loop_property_title
											 * @hooked g5ere_template_loop_property_address
											 * @hooked g5ere_template_loop_property_price
											 */
											do_action( 'g5ere_my_favourite_property_content' ) ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle"> <?php echo date_i18n( get_option( 'date_format' ), strtotime( get_the_date() ) ); ?></td>
                                <td class="align-middle"> <?php
									$total_views = $ere_property->get_total_views( $property_id );
									echo esc_html( $total_views );
									?></td>
                                <td class="align-middle">
                                    <a href="javascript:void(0)" class="g5ere__property-my-favorite"
                                       data-property-id="<?php echo intval( $property_id ) ?>"
                                       data-toggle="tooltip"
                                       title="<?php esc_attr_e( 'Remove', 'g5-ere' ) ?>"><i
                                                class="fal fa-trash-alt"></i></a>
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