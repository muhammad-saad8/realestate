<?php
/**
 * Created by G5Theme.
 * User: trungpq
 * Date: 18/11/16
 * Time: 5:46 PM
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $property_data;
?>
<div class="card property-fields-wrap">
    <div class="card-body">
	    <div class="card-title property-fields-title">
		    <h2><?php esc_html_e( 'Property Features', 'g5-ere' ) ?></h2>
	    </div>
		<?php
		$features                             = g5ere_get_property_features( array( 'property_id' => $property_data->ID ) );
		$single_property_feature_link_disable = G5ERE()->options()->get_option( 'single_property_feature_link_disable' );
		$features_terms_id                    = array();
		if($features){
			foreach ( $features as $feature ) {
				$features_terms_id[] = intval( $feature->term_id );
			}
        }

		$parent_features = get_categories( array(
			'taxonomy'   => 'property-feature',
			'parent'     => 0,
			'hide_empty' => false
		) );
		if ( count( $parent_features ) === 0 ) {
			return;
		}
		$parent_features_has_child = array();
		?>
		<?php foreach ( $parent_features as $parent_feature ): ?>
			<?php
			$args = array(
				'taxonomy'   => 'property-feature',
				'parent'     => $parent_feature->term_id,
				'hide_empty' => false
			);
			$child_features = get_categories( $args );
			if ( $child_features ):
				$parent_features_has_child[] = $parent_feature->term_id;
				?>
                <div class="card-title property-fields-title">
                    <h5><?php echo esc_html( $parent_feature->name ) ?></h5>
                </div>

                <div class="property-fields property-feature row">
					<?php foreach ( $child_features as $child_feature ): ?>
                        <div class="col-sm-3">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" name="property_feature[]"
                                       id="property_feature_<?php echo esc_html( $child_feature->term_id ) ?>"
                                       value="<?php echo esc_html( $child_feature->term_id ) ?>"
									<?php if ( in_array( $child_feature->term_id, $features_terms_id ) ) {
										echo 'checked';
									} ?>
                                />
                                <label class="custom-control-label"
                                       for="property_feature_<?php echo esc_html( $child_feature->term_id ) ?>">
									<?php echo esc_html( $child_feature->name ) ?>
                                </label>

                            </div>
                        </div>
					<?php endforeach; ?>
                </div>
			<?php endif;
		endforeach;
		?>

		<?php
		if ( count( $parent_features_has_child ) > 0 ): ?>
			<?php
			$parent_features = get_categories( array(
				'taxonomy'   => 'property-feature',
				'parent'     => 0,
				'hide_empty' => false,
				'exclude'    => $parent_features_has_child
			) );
		endif; ?>

		<?php if ( count( $parent_features ) > 0 ): ?>
			<?php if ( count( $parent_features_has_child ) > 0 ): ?>
                <div class="card-title property-fields-title">
                    <h5><?php esc_html_e( 'Other', 'g5-ere' ) ?></h5>
                </div>
			<?php endif; ?>
            <div class="property-fields property-feature row">
				<?php foreach ( $parent_features as $child_feature ): ?>
                    <div class="col-sm-3">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="property_feature[]"
                                   id="property_feature_<?php echo esc_html( $child_feature->term_id ) ?>"
                                   value="<?php echo esc_html( $child_feature->term_id ) ?>"
								<?php if ( in_array( $child_feature->term_id, $features_terms_id ) ) {
									echo 'checked';
								} ?>
                            />
                            <label class="custom-control-label"
                                   for="property_feature_<?php echo esc_html( $child_feature->term_id ) ?>">
								<?php echo esc_html( $child_feature->name ); ?>
                            </label>

                        </div>
                    </div>
				<?php endforeach; ?>
            </div>
		<?php endif; ?>
    </div>
</div>