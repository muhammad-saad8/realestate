<?php
/**
 * @var $taxonomy_name
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$current_url = sanitize_url($_SERVER['REQUEST_URI']);
?>
<div class="archive-property-action ere__archive-property-actions">
	<?php /*if ( $taxonomy_name != 'property-status' ): */?><!--
		<div class="archive-property-action-item">
			<div class="property-status property-filter">
				<ul>
					<li class="active"><a data-status="all" href="<?php
/*						$pot_link_status = add_query_arg( 'status', 'all', $current_url );
						echo esc_url( $pot_link_status ) */?>"
					                      title="<?php /*esc_attr_e( 'All', 'essential-real-estate' ); */?>"><?php /*esc_html_e( 'All', 'essential-real-estate' ); */?></a>
					</li>
					<?php
/*					$property_status = ere_get_property_status_search();
					if ( $property_status ) :
						foreach ( $property_status as $status ):*/?>
							<li><a data-status="<?php /*echo esc_attr( $status->slug ) */?>" href="<?php
/*								$pot_link_status = add_query_arg( 'status', $status->slug, $current_url );
								echo esc_url( $pot_link_status ) */?>"
							       title="<?php /*echo esc_attr( $status->name ) */?>"><?php /*echo esc_html( $status->name ) */?></a>
							</li>
						<?php /*endforeach;
					endif;
					*/?>
				</ul>
			</div>
		</div>
	<?php /*endif; */?>
    --><?php /*ere_template_archive_property_orderby(); */?>
    <?php
    /**
     * Hook: ere_archive_property_actions.
     *
     * @hooked ere_template_archive_property_action_status - 5
     * @hooked ere_template_archive_property_action_orderby - 10
     * @hooked ere_template_archive_property_action_switch_layout - 15
     */
    do_action('ere_archive_property_actions');
    ?>
</div>
