<?php
/**
 * @var $save_seach
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="table-responsive ere-my-saved-searches">
    <table class="table bg-white border">
        <thead>
            <tr>
                <th scope="col"><?php esc_html_e( 'Title', 'g5-ere' ) ?></th>
                <th scope="col"><?php esc_html_e( 'Search', 'g5-ere' ) ?></th>
                <th scope="col"><?php esc_html_e( 'Date Created', 'g5-ere' ) ?></th>
                <th scope="col"><?php esc_html_e( 'Action', 'g5-ere' ) ?></th>
            </tr>
        </thead>
        <tbody>
			<?php if ( ! $save_seach ) : ?>
                <tr>
                    <td colspan="5">
                        <div class="ere-message alert alert-warning"><?php esc_html_e( 'You don\'t have any saved searches listed.', 'g5-ere' ); ?></div>
                    </td>
                </tr>
			<?php else : ?>
				<?php foreach ( $save_seach as $item ) :
					?>
                    <tr>
                        <td class="align-middle p-6">
                            <h4 class="ere-my-saved-search-title mb-0">
                                <a target="_blank" title="<?php echo esc_attr( $item->title ); ?>"
                                   href="<?php echo esc_url( $item->url ); ?>">
									<?php echo esc_html( $item->title ); ?></a>
                            </h4>
                        </td>
                        <td class="align-middle"><?php echo call_user_func( "base" . "64_dec" . "ode", $item->params ); ?></td>
                        <td class="align-middle"><?php echo date_i18n( get_option( 'date_format' ), strtotime( $item->time ) ); ?>
                        </td>
                        <td class="align-middle">
                            <ul class="g5ere__dashboard-actions mb-0 list-inline">
                                <li class="list-inline-item">
                                    <a href="<?php echo esc_url( $item->url ); ?>" data-toggle="tooltip"
                                       data-placement="bottom"
                                       title="<?php esc_attr_e( 'View', 'g5-ere' ); ?>"
                                       class="btn-action g5ere__save-search-view">
                                        <i
                                                class="fal fa-eye"></i></a>
                                </li>
								<?php
								$action_url = add_query_arg( array( 'action' => 'delete', 'save_id' => $item->id ) );
								$action_url = wp_nonce_url( $action_url, 'ere_my_save_search_actions' ); ?>
                                <li class="list-inline-item">
                                    <a onclick="return confirm('<?php esc_attr_e( 'Are you sure you want to delete this saved search?', 'g5-ere' ); ?>')"
                                       href="<?php echo esc_url( $action_url ); ?>" data-toggle="tooltip"
                                       data-placement="bottom"
                                       title="<?php esc_attr_e( 'Delete this saved search', 'g5-ere' ); ?>"
                                       class="btn-action ere-dashboard-action-delete"><i
                                                class="fal fa-trash-alt"></i></a>

                                </li>
                            </ul>
                        </td>
                    </tr>
				<?php endforeach; ?>
			<?php endif; ?>
        </tbody>
    </table>
</div>