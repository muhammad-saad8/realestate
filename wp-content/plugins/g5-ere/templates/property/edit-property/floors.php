<?php
/**
 * Created by G5Theme.
 * User: trungpq
 * Date: 09/11/16
 * Time: 11:52 PM
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $property_data, $property_meta_data;
$floors        = get_post_meta( $property_data->ID, ERE_METABOX_PREFIX . 'floors', true );
$floors_enable = get_post_meta( $property_data->ID, ERE_METABOX_PREFIX . 'floors_enable', true );
?>
<div class="card property-fields-wrap">
    <div class="card-body">
        <div class="card-title property-fields-title">
            <h2><?php esc_html_e( 'Floor Plans', 'g5-ere' ); ?></h2>
        </div>
        <div class="property-fields">
            <div class="property-floors-control mb-3">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="floors_enable" name="floors_enable" class="custom-control-input"
                           value="1" <?php checked( $floors_enable, '1' ); ?>>
                    <label class="custom-control-label"
                           for="floors_enable"><?php esc_html_e( 'Enable', 'g5-ere' ); ?></label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="floors_disable" name="floors_enable" class="custom-control-input"
                           value="0" <?php checked( $floors_enable, '0' ); ?>>
                    <label class="custom-control-label"
                           for="floors_disable"><?php esc_html_e( 'Disable', 'g5-ere' ); ?></label>
                </div>
            </div>
            <div class="property-floors-data">
                <table class="add-sort-table">
                    <tbody id="ere_floors">
						<?php
						$row_num = 0;
						if ( ! empty( $floors ) ) {
							foreach ( $floors as $floor ): ?>
                                <tr>
                                    <td class="row-sort">
                                        <span class="sort-floors-row sort"><i class="fal fa-sort"></i></span>
                                    </td>
                                    <td class="sort-middle">
                                        <div class="sort-inner-block">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label
                                                                for="<?php echo ERE_METABOX_PREFIX ?>floor_name_<?php echo intval( $row_num ); ?>"><?php esc_html_e( 'Floor Name', 'g5-ere' ); ?></label>
                                                        <input
                                                                name="<?php echo ERE_METABOX_PREFIX ?>floors[<?php echo intval( $row_num ); ?>][<?php echo ERE_METABOX_PREFIX ?>floor_name]"
                                                                type="text"
                                                                id="<?php echo ERE_METABOX_PREFIX ?>floor_name_<?php echo intval( $row_num ); ?>"
                                                                class="form-control"
                                                                value="<?php echo esc_attr( $floor[ ERE_METABOX_PREFIX . 'floor_name' ] ); ?>">
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label
                                                                for="<?php echo ERE_METABOX_PREFIX ?>floor_price_<?php echo intval( $row_num ); ?>"><?php esc_html_e( 'Floor Price (Only digits)', 'g5-ere' ); ?></label>
                                                        <input
                                                                name="<?php echo ERE_METABOX_PREFIX ?>floors[<?php echo intval( $row_num ); ?>][<?php echo ERE_METABOX_PREFIX ?>floor_price]"
                                                                type="number"
                                                                id="<?php echo ERE_METABOX_PREFIX ?>floor_price_<?php echo intval( $row_num ); ?>"
                                                                class="form-control"
                                                                value="<?php echo esc_attr( $floor[ ERE_METABOX_PREFIX . 'floor_price' ] ); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label
                                                                for="<?php echo ERE_METABOX_PREFIX ?>floor_price_postfix_<?php echo intval( $row_num ); ?>"><?php esc_html_e( 'Price Postfix', 'g5-ere' ); ?></label>
                                                        <input
                                                                name="<?php echo ERE_METABOX_PREFIX ?>floors[<?php echo intval( $row_num ); ?>][<?php echo ERE_METABOX_PREFIX ?>floor_price_postfix]"
                                                                type="text"
                                                                id="<?php echo ERE_METABOX_PREFIX ?>floor_price_postfix_<?php echo intval( $row_num ); ?>"
                                                                class="form-control"
                                                                value="<?php echo esc_attr( $floor[ ERE_METABOX_PREFIX . 'floor_price_postfix' ] ); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label
                                                                for="<?php echo ERE_METABOX_PREFIX ?>floor_size_<?php echo intval( $row_num ); ?>"><?php esc_html_e( 'Floor Size (Only digits)', 'g5-ere' ); ?></label>
                                                        <input
                                                                name="<?php echo ERE_METABOX_PREFIX ?>floors[<?php echo intval( $row_num ); ?>][<?php echo ERE_METABOX_PREFIX ?>floor_size]"
                                                                type="number"
                                                                id="<?php echo ERE_METABOX_PREFIX ?>floor_size_<?php echo intval( $row_num ); ?>"
                                                                class="form-control"
                                                                value="<?php echo esc_attr( $floor[ ERE_METABOX_PREFIX . 'floor_size' ] ); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label
                                                                for="<?php echo ERE_METABOX_PREFIX ?>floor_size_postfix_<?php echo intval( $row_num ); ?>"><?php esc_html_e( 'Size Postfix', 'g5-ere' ); ?></label>
                                                        <input
                                                                name="<?php echo ERE_METABOX_PREFIX ?>floors[<?php echo intval( $row_num ); ?>][<?php echo ERE_METABOX_PREFIX ?>floor_size_postfix]"
                                                                type="text"
                                                                id="<?php echo ERE_METABOX_PREFIX ?>floor_size_postfix_<?php echo intval( $row_num ); ?>"
                                                                class="form-control"
                                                                value="<?php echo esc_attr( $floor[ ERE_METABOX_PREFIX . 'floor_size_postfix' ] ); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label
                                                                for="<?php echo ERE_METABOX_PREFIX ?>floor_bedrooms_<?php echo intval( $row_num ); ?>"><?php esc_html_e( 'Bedrooms', 'g5-ere' ); ?></label>
                                                        <input
                                                                name="<?php echo ERE_METABOX_PREFIX ?>floors[<?php echo intval( $row_num ); ?>][<?php echo ERE_METABOX_PREFIX ?>floor_bedrooms]"
                                                                type="number"
                                                                id="<?php echo ERE_METABOX_PREFIX ?>floor_bedrooms_<?php echo intval( $row_num ); ?>"
                                                                class="form-control"
                                                                value="<?php echo esc_attr( $floor[ ERE_METABOX_PREFIX . 'floor_bedrooms' ] ); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label
                                                                for="<?php echo ERE_METABOX_PREFIX ?>floor_bathrooms_<?php echo intval( $row_num ); ?>"><?php esc_html_e( 'Bathrooms', 'g5-ere' ); ?></label>
                                                        <input
                                                                name="<?php echo ERE_METABOX_PREFIX ?>floors[<?php echo intval( $row_num ); ?>][<?php echo ERE_METABOX_PREFIX ?>floor_bathrooms]"
                                                                type="number"
                                                                id="<?php echo ERE_METABOX_PREFIX ?>floor_bathrooms_<?php echo intval( $row_num ); ?>"
                                                                class="form-control"
                                                                value="<?php echo esc_attr( $floor[ ERE_METABOX_PREFIX . 'floor_bathrooms' ] ); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label
                                                                for="<?php echo ERE_METABOX_PREFIX ?>floor_image_url_<?php echo intval( $row_num ); ?>"><?php esc_html_e( 'Floor Image', 'g5-ere' ); ?></label>

                                                        <div id="ere-floor-plupload-container-<?php echo intval( $row_num ); ?>"
                                                             class="file-upload-block">
                                                            <input
                                                                    name="<?php echo ERE_METABOX_PREFIX ?>floors[<?php echo intval( $row_num ); ?>][<?php echo ERE_METABOX_PREFIX ?>floor_image][url]"
                                                                    type="text"
                                                                    id="<?php echo ERE_METABOX_PREFIX ?>floor_image_url_<?php echo intval( $row_num ); ?>"
                                                                    class="ere_floor_image_url form-control"
                                                                    value="<?php echo esc_attr( $floor[ ERE_METABOX_PREFIX . 'floor_image' ]['url'] ); ?>">
                                                            <input type="hidden" class="ere_floor_image_id"
                                                                   name="<?php echo ERE_METABOX_PREFIX ?>floors[<?php echo intval( $row_num ); ?>][<?php echo ERE_METABOX_PREFIX ?>floor_image][id]"
                                                                   value="<?php echo esc_attr( $floor[ ERE_METABOX_PREFIX . 'floor_image' ]['id'] ); ?>"
                                                                   id="<?php echo ERE_METABOX_PREFIX ?>floor_image_id_<?php echo intval( $row_num ); ?>"/>
                                                            <button type="button"
                                                                    id="ere-floor-<?php echo intval( $row_num ); ?>"
                                                                    style="position: absolute"
                                                                    title="<?php esc_attr_e( 'Choose image', 'g5-ere' ) ?>"
                                                                    class="ere_floorsImg"><i
                                                                        class="fa fa-file-image-o"></i></button>
                                                        </div>
                                                        <div id="ere-floor-errors-log-<?php echo intval( $row_num ); ?>"></div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label
                                                            for="<?php echo ERE_METABOX_PREFIX ?>floor_description_<?php echo intval( $row_num ); ?>"><?php esc_html_e( 'Plan Description', 'g5-ere' ); ?></label>
                                                    <textarea
                                                            name="<?php echo ERE_METABOX_PREFIX ?>floors[<?php echo intval( $row_num ); ?>][<?php echo ERE_METABOX_PREFIX ?>floor_description]"
                                                            rows="4"
                                                            id="<?php echo ERE_METABOX_PREFIX ?>floor_description_<?php echo intval( $row_num ); ?>"
                                                            class="form-control"><?php echo esc_attr( $floor[ ERE_METABOX_PREFIX . 'floor_description' ] ); ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="row-remove">
                                    <span data-remove="<?php echo esc_attr( $row_num - 1 ); ?>"
                                          class="remove-floors-row remove"><i class="fa fa-remove"></i></span>
                                    </td>
                                </tr>
								<?php $row_num ++; ?>
							<?php endforeach;
						}
						?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3">
                                <div class="row">
                                    <div class="col-sm-12 text-center">
                                        <button type="button" id="add-floors-row"
                                                data-increment="<?php echo esc_attr( $row_num - 1 ); ?>"
                                                class="btn btn-primary"><i
                                                    class="fa fa-plus"></i> <?php esc_html_e( 'Add More', 'g5-ere' ); ?>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>