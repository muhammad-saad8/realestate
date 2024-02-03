<?php
/**
 * @var $invoices
 * @var $max_num_pages
 * @var $start_date
 * @var $end_date
 * @var $invoice_type
 * @var $invoice_status
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$allow_submit = ere_allow_submit();
if ( ! $allow_submit ) {
	echo ere_get_template_html( 'global/access-denied.php', array( 'type' => 'not_permission' ) );

	return;
}
wp_enqueue_style( 'bootstrap-datepicker' );
wp_enqueue_script( 'bootstrap-datepicker' );
$ere_date_language = esc_html( ere_get_option( 'date_language', 'en-GB' ) );
if ( function_exists( 'icl_translate' ) ) {
	$ere_date_language = ICL_LANGUAGE_CODE;
}
if ( ! empty( $ere_date_language ) ) {
	wp_enqueue_script( "bootstrap-datepicker." . $ere_date_language, G5ERE()->asset_url( 'assets/vendors/bootstrap-datepicker/locales/bootstrap-datepicker.' . $ere_date_language . '.js' ), array( 'jquery' ), '1.0', true );
}

if ( isset( $_GET['invoice_id'] ) && $_GET['invoice_id'] != '' ) :
	$min_suffix_js = ere_get_option( 'enable_min_js', 0 ) == 1 ? '.min' : '';
	wp_enqueue_script( ERE_PLUGIN_PREFIX . 'ere-invoice', ERE_PLUGIN_URL . 'public/assets/js/invoice/ere-invoice' . $min_suffix_js . '.js', array( 'jquery' ), ERE_PLUGIN_VER, true );
	$invoice_id   = $_GET['invoice_id'];
	$ere_invoice  = new ERE_Invoice();
	$invoice_meta = $ere_invoice->get_invoice_meta( $invoice_id );
	$invoice_date = $invoice_meta['invoice_purchase_date'];
	$user_id      = $invoice_meta['invoice_user_id'];
	global $current_user;
	wp_get_current_user();
	if ( $user_id != $current_user->ID ) {
		esc_html_e( 'You can\'t view this invoice', 'g5-ere' );

		return;
	}
	$agent_id     = get_the_author_meta( ERE_METABOX_PREFIX . 'author_agent_id', $user_id );
	$agent_status = get_post_status( $agent_id );
	if ( $agent_status == 'publish' ) {
		$agent_email = get_post_meta( $agent_id, ERE_METABOX_PREFIX . 'agent_email', true );
		$agent_name  = get_the_title( $agent_id );
	} else {
		$user_firstname = get_the_author_meta( 'first_name', $user_id );
		$user_lastname  = get_the_author_meta( 'last_name', $user_id );
		$user_email     = get_the_author_meta( 'user_email', $user_id );
		if ( empty( $user_firstname ) && empty( $user_lastname ) ) {
			$agent_name = get_the_author_meta( 'user_login', $user_id );
		} else {
			$agent_name = $user_firstname . ' ' . $user_lastname;
		}
		$agent_email = $user_email;
	}
	$print_logo = ere_get_option( 'print_logo', '' );
	$attach_id  = '';
	if ( is_array( $print_logo ) && count( $print_logo ) > 0 ) {
		$attach_id = $print_logo['id'];
	}
	$image_size = ere_get_option( 'print_logo_size', '200x100' );
	$image_src  = '';
	$width      = '';
	$height     = '';
	if ( $attach_id ) {
		if ( preg_match( '/\d+x\d+/', $image_size ) ) {
			$image_sizes = explode( 'x', $image_size );
			$image_src   = ere_image_resize_id( $attach_id, $image_sizes[0], $image_sizes[1], true );
		} else {
			if ( ! in_array( $image_size, array( 'full', 'thumbnail' ) ) ) {
				$image_size = 'full';
			}
			$image_src = wp_get_attachment_image_src( $attach_id, $image_size );
			if ( $image_src && ! empty( $image_src[0] ) ) {
				$image_src = $image_src[0];
			}
		}
		if ( ! empty( $image_src ) ) {
			list( $width, $height ) = getimagesize( $image_src );
		}
	}

	$page_name       = get_bloginfo( 'name', '' );
	$company_address = ere_get_option( 'company_address', '' );
	$company_name    = ere_get_option( 'company_name', '' );
	$company_phone   = ere_get_option( 'company_phone', '' );
	$item_name       = get_the_title( $invoice_meta['invoice_item_id'] );
	$payment_type    = ERE_Invoice::get_invoice_payment_type( $invoice_meta['invoice_payment_type'] );
	$payment_method  = ERE_Invoice::get_invoice_payment_method( $invoice_meta['invoice_payment_method'] );
	$total_price     = ere_get_format_money( $invoice_meta['invoice_item_price'] );
	?>
    <div class="single-invoice-wrap g5ere__invoice-details">
        <div class="g5ere__invoice-details-header border-bottom">
            <div class="row align-items-center">
                <div class="col-md-6 mb-4 mb-md-0">
					<?php if ( intval( $invoice_meta['invoice_item_price'] ) > 0 ) :
						?>
                        <span class="g5ere__invoice-pre-title text-uppercase">
	                    <?php esc_html_e( 'payments', 'g5-ere' ); ?>
                        </span>
					<?php
					endif; ?>
                    <h1 class="g5ere__invoice-title">
						<?php printf( __( 'Invoice #%s', 'g5-ere' ), $invoice_id ); ?>
                    </h1>
                </div>
                <div class="single-invoice-action text-left text-md-right col-md-6">
					<?php if ( ere_get_option( 'enable_print_invoice', '1' ) == '1' ): ?>
                        <a href="<?php echo esc_url( ere_get_permalink( 'my_invoices' ) ); ?>" data-toggle="tooltip"
                           class="btn bg-white btn-outline btn-secondary"
                           title="<?php esc_attr_e( 'Back to My Invoices', 'g5-ere' ) ?>">
							<?php esc_html_e( 'Back to My Invoices', 'g5-ere' ) ?>
                        </a>
                        <a href="javascript:void(0)" id="invoice-print" data-toggle="tooltip" class="btn btn-accent"
                           title="<?php esc_attr_e( 'Print', 'g5-ere' ); ?>"
                           data-invoice-id="<?php echo esc_attr( $invoice_id ); ?>"
                           data-ajax-url="<?php echo ERE_AJAX_URL; ?>">
							<?php esc_html_e( 'Print', 'g5-ere' ) ?>
                        </a>
					<?php endif; ?>

                </div>
            </div>
        </div>
        <div class="card card-body g5ere__invoice-details-body">
            <div class="g5ere__page-info mb-2 text-center">
				<?php if ( ! empty( $image_src ) ): ?>
                    <img src="<?php echo esc_url( $image_src ) ?>" alt="<?php echo esc_attr( $page_name ) ?>"
                         width="<?php echo esc_attr( $width ) ?>" height="<?php echo esc_attr( $height ) ?>">
				<?php endif; ?>
                <div class="invoice-info mb-4">
                    <h3 class="invoice-title">
						<?php printf( __( 'Invoice  from %s', 'g5-ere' ), get_bloginfo( 'name', 'display' ) ); ?>
                    </h3>
                    <p class="invoice-id">
						<?php printf( __( 'Invoice #%s', 'g5-ere' ), $invoice_id ); ?>
                    </p>
                </div>
            </div>
            <!-- Begin Agent Info -->
            <div class="g5ere__single-invoice-info row mb-4">
                <div class="agent-company-info col-md-6 mb-4 mb-md-0">
                    <p class="invoice-info-label"><?php esc_html_e( 'Invoice from', 'g5-ere' ) ?></p>
					<?php if ( ! empty( $company_name ) ): ?>
                        <div class="invoice-name">
							<?php echo esc_html( $company_name ); ?>
                        </div>
					<?php endif; ?>
					<?php if ( ! empty( $company_address ) ): ?>
                        <div class="invoice-details company-address">
							<?php echo esc_html( $company_address ); ?>
                        </div>
					<?php endif; ?>
					<?php if ( ! empty( $company_phone ) ): ?>
                        <div class="invoice-details company-phone">
							<?php echo esc_html( $company_phone ); ?>
                        </div>
					<?php endif; ?>


                </div>
                <div class="agent-main-info col-md-6 text-md-right">
                    <p class="invoice-info-label"><?php esc_html_e( 'Invoice to', 'g5-ere' ) ?></p>
					<?php if ( ! empty( $agent_name ) ): ?>
                        <div class="invoice-name">
							<?php echo esc_html( $agent_name ); ?>
                        </div>
					<?php endif; ?>
					<?php if ( ! empty( $agent_email ) ): ?>
                        <div class="invoice-details agent-email">
							<?php echo esc_html( $agent_email ); ?>
                        </div>
					<?php endif; ?>

                </div>
            </div>
            <div class="g5ere__single-invoice-info row mb-5">
                <div class="col-md-6">
                    <p class="invoice-info-label"><?php esc_html_e( 'Invoice id', 'g5-ere' ) ?></p>
                    <p><?php echo esc_html( $invoice_id ) ?></p>

                </div>
                <div class="col-md-6 text-md-right">
                    <p class="invoice-info-label"><?php esc_html_e( 'Date', 'g5-ere' ) ?></p>
                    <p><?php echo date_i18n( get_option( 'date_format' ), strtotime( $invoice_date ) ); ?></p>
                </div>

            </div>
            <!-- End Agent Info -->
            <div class="billing-info">
                <table class="table bg-white">
                    <tbody>
                        <tr>
                            <th><?php esc_html_e( 'Item Name:', 'g5-ere' ); ?></th>
                            <td><?php echo esc_html( $item_name ); ?></td>
                        </tr>
                        <tr>
                            <th><?php esc_html_e( 'Payment Type:', 'g5-ere' ); ?></th>
                            <td><?php echo esc_html( $payment_type ); ?></td>
                        </tr>
                        <tr>
                            <th><?php esc_html_e( 'Payment Method:', 'g5-ere' ); ?></th>
                            <td><?php echo esc_html( $payment_method ); ?></td>
                        </tr>
                        <tr>
                            <th><?php esc_html_e( 'Total Price:', 'g5-ere' ); ?></th>
                            <td><?php echo esc_html( $total_price ); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php
else:
	$my_invoices_columns = apply_filters( 'ere_my_invoices_columns', array(
		'id'        => esc_html__( 'Order ID', 'g5-ere' ),
		'date'      => esc_html__( 'Purchase Date', 'g5-ere' ),
		'type'      => esc_html__( 'Type', 'g5-ere' ),
		'item_name' => esc_html__( 'Item Name', 'g5-ere' ),
		'status'    => esc_html__( 'Status', 'g5-ere' ),
		'total'     => esc_html__( 'Total', 'g5-ere' ),
		'view'      => esc_html__( 'Action', 'g5-ere' ),
	) );
	?>
    <div class="panel panel-default ere-my-invoices">
        <div class="panel-body">
            <form method="get" action="<?php echo get_page_link(); ?>">
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label class="sr-only"
                                   for="start_date"><?php esc_html_e( 'After Date', 'g5-ere' ); ?></label>
                            <input type="text" id="start_date" value="<?php echo esc_attr( $start_date ); ?>"
                                   name="start_date"
                                   placeholder="<?php esc_attr_e( 'After Date', 'g5-ere' ); ?>"
                                   class="form-control input_date">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label class="sr-only"
                                   for="end_date"><?php esc_html_e( 'Before Date', 'g5-ere' ); ?></label>
                            <input type="text" id="end_date" value="<?php echo esc_attr( $end_date ); ?>"
                                   name="end_date"
                                   placeholder="<?php esc_attr_e( 'Before Date', 'g5-ere' ); ?>"
                                   class="form-control input_date">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label class="sr-only"
                                   for="invoice_type"><?php esc_html_e( 'Invoice Type', 'g5-ere' ); ?></label>
                            <select class="selectpicker form-control" id="invoice_type" name="invoice_type">
                                <option
                                        value="" <?php if ( $invoice_type == '' )
									echo ' selected' ?>><?php esc_html_e( 'All Invoice Type', 'g5-ere' ); ?></option>
                                <option
                                        value="Package" <?php if ( $invoice_type == 'Package' )
									echo ' selected' ?>><?php esc_html_e( 'Package', 'g5-ere' ); ?></option>
                                <option
                                        value="Listing" <?php if ( $invoice_type == 'Listing' )
									echo ' selected' ?>><?php esc_html_e( 'Listing', 'g5-ere' ); ?></option>
                                <option
                                        value="Upgrade_To_Featured"<?php if ( $invoice_type == 'Upgrade_To_Featured' )
									echo ' selected' ?>><?php esc_html_e( 'Upgrade to Featured', 'g5-ere' ); ?></option>
                                <option
                                        value="Listing_With_Featured"<?php if ( $invoice_type == 'Listing_With_Featured' )
									echo ' selected' ?>><?php esc_html_e( 'Listing with Featured', 'g5-ere' ); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label class="sr-only"
                                   for="invoice_status"><?php esc_html_e( 'Payment Status', 'g5-ere' ); ?></label>
                            <select class="selectpicker form-control" id="invoice_status" name="invoice_status">
                                <option
                                        value="" <?php if ( $invoice_status == '' )
									echo ' selected' ?>><?php esc_html_e( 'All Payment Status', 'g5-ere' ); ?></option>
                                <option
                                        value="1" <?php if ( $invoice_status == '1' )
									echo ' selected' ?>><?php esc_html_e( 'Paid', 'g5-ere' ); ?></option>
                                <option
                                        value="0" <?php if ( $invoice_status == '0' )
									echo ' selected' ?>><?php esc_html_e( 'Not Paid', 'g5-ere' ); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <input id="search_invoice" type="submit" class="btn btn-accent btn-block"
                                   value="<?php esc_attr_e( 'Search', 'g5-ere' ); ?>">
                        </div>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table bg-white">
                    <thead>
                        <tr>
							<?php foreach ( $my_invoices_columns as $key => $column ) : ?>
                                <th class="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $column ); ?></th>
							<?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
						<?php if ( ! $invoices ) : ?>
                            <tr>
                                <td colspan="7"
                                    data-title="<?php esc_attr_e( 'Results', 'g5-ere' ); ?>"><?php esc_html_e( 'You don\'t have any invoices listed.', 'g5-ere' ); ?></td>
                            </tr>
						<?php else : ?>
							<?php foreach ( $invoices as $invoice ) :
								$ere_invoice = new ERE_Invoice();
								$invoice_meta = $ere_invoice->get_invoice_meta( $invoice->ID );
								?>
                                <tr>
									<?php foreach ( $my_invoices_columns as $key => $column ) : ?>
                                        <td class="<?php echo esc_attr( $key ); ?>"
                                            data-title="<?php echo esc_attr( $column ); ?>">
											<?php if ( 'id' === $key ): ?>
                                                <a href="<?php echo esc_url( ere_get_permalink( 'my_invoices' ) . '?invoice_id=' . $invoice->ID ); ?>"><?php echo esc_html( $invoice->ID ); ?></a>
											<?php
                                            elseif ( 'date' === $key ) :
												echo date_i18n( get_option( 'date_format' ), strtotime( $invoice->post_date ) );
                                            elseif ( 'type' === $key ):
												echo ERE_Invoice::get_invoice_payment_type( $invoice_meta['invoice_payment_type'] );
                                            elseif ( 'item_name' === $key ):
												$item_name = get_the_title( $invoice_meta['invoice_item_id'] );
												echo esc_html( $item_name );
                                            elseif ( 'status' === $key ):
												$invoice_status = get_post_meta( $invoice->ID, ERE_METABOX_PREFIX . 'invoice_payment_status', true );
												if ( $invoice_status == 1 ) {
													esc_html_e( 'Paid', 'g5-ere' );
												} else {
													esc_html_e( 'Not Paid', 'g5-ere' );
												}
                                            elseif ( 'total' === $key ):
												echo ere_get_format_money( $invoice_meta['invoice_item_price'] );
												do_action( 'ere_my_invoices_item_price', $invoice_meta );
                                            elseif ( 'view' === $key ):?>
                                                <a class="btn-action" data-toggle="tooltip"
                                                   data-placement="bottom"
                                                   title="<?php esc_attr_e( 'View Invoice', 'g5-ere' ); ?>"
                                                   href="<?php echo esc_url( ere_get_permalink( 'my_invoices' ) . '?invoice_id=' . $invoice->ID ); ?>">
                                                    <i class="fal fa-eye"></i></a>
											<?php endif; ?>
                                        </td>
									<?php endforeach; ?>
                                </tr>
							<?php endforeach; ?>
						<?php endif; ?>
                    </tbody>
                </table>
            </div>
			<?php ere_get_template( 'global/pagination.php', array( 'max_num_pages' => $max_num_pages ) ); ?>
            <script>
				jQuery(document).ready(function ($) {
					if ($('.input_date').length > 0) {
						$('.input_date').datepicker({
							language: '<?php echo esc_js( $ere_date_language ); ?>',
							orientation: 'bottom',
							container: '.g5ere__page-dashboard-wrapper'
						});
					}
				});
            </script>
        </div>
    </div>
<?php endif;


?>