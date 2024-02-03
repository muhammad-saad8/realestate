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
?>
<div class="card property-fields-wrap">
    <div class="card-body">
        <div class="card-title property-fields-title">
            <h2><?php esc_html_e('Floor Plans', 'g5-ere'); ?></h2>
        </div>
        <div class="property-fields">
            <div class="property-floors-control mb-3">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="floors_enable" name="floors_enable" class="custom-control-input" value="1">
                    <label class="custom-control-label" for="floors_enable"><?php esc_html_e('Enable', 'g5-ere'); ?></label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="floors_disable" name="floors_enable" checked="checked" class="custom-control-input" value="0">
                    <label class="custom-control-label" for="floors_disable"><?php esc_html_e('Disable', 'g5-ere'); ?></label>
                </div>
            </div>
            <div class="property-floors-data">
                <table class="add-sort-table">
                    <tbody id="ere_floors">
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
                                                        for="<?php echo ERE_METABOX_PREFIX ?>floor_name_0"><?php esc_html_e('Floor Name', 'g5-ere'); ?></label>
                                                <input
                                                        name="<?php echo ERE_METABOX_PREFIX ?>floors[0][<?php echo ERE_METABOX_PREFIX ?>floor_name]"
                                                        type="text"
                                                        id="<?php echo ERE_METABOX_PREFIX ?>floor_name_0" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label
                                                        for="<?php echo ERE_METABOX_PREFIX ?>floor_price_0"><?php esc_html_e('Floor Price (Only digits)', 'g5-ere'); ?></label>
                                                <input
                                                        name="<?php echo ERE_METABOX_PREFIX ?>floors[0][<?php echo ERE_METABOX_PREFIX ?>floor_price]"
                                                        type="number"
                                                        id="<?php echo ERE_METABOX_PREFIX ?>floor_price_0" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label
                                                        for="<?php echo ERE_METABOX_PREFIX ?>floor_price_postfix_0"><?php esc_html_e('Price Postfix', 'g5-ere'); ?></label>
                                                <input
                                                        name="<?php echo ERE_METABOX_PREFIX ?>floors[0][<?php echo ERE_METABOX_PREFIX ?>floor_price_postfix]"
                                                        type="text"
                                                        id="<?php echo ERE_METABOX_PREFIX ?>floor_price_postfix_0"
                                                        class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label
                                                        for="<?php echo ERE_METABOX_PREFIX ?>floor_size_0"><?php esc_html_e('Floor Size (Only digits)', 'g5-ere'); ?></label>
                                                <input
                                                        name="<?php echo ERE_METABOX_PREFIX ?>floors[0][<?php echo ERE_METABOX_PREFIX ?>floor_size]"
                                                        type="number"
                                                        id="<?php echo ERE_METABOX_PREFIX ?>floor_size_0" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label
                                                        for="<?php echo ERE_METABOX_PREFIX ?>floor_size_postfix_0"><?php esc_html_e('Size Postfix', 'g5-ere'); ?></label>
                                                <input
                                                        name="<?php echo ERE_METABOX_PREFIX ?>floors[0][<?php echo ERE_METABOX_PREFIX ?>floor_size_postfix]"
                                                        type="text"
                                                        id="<?php echo ERE_METABOX_PREFIX ?>floor_size_postfix_0"
                                                        class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label
                                                        for="<?php echo ERE_METABOX_PREFIX ?>floor_bedrooms_0"><?php esc_html_e('Bedrooms', 'g5-ere'); ?></label>
                                                <input
                                                        name="<?php echo ERE_METABOX_PREFIX ?>floors[0][<?php echo ERE_METABOX_PREFIX ?>floor_bedrooms]"
                                                        type="number"
                                                        id="<?php echo ERE_METABOX_PREFIX ?>floor_bedrooms_0"
                                                        class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label
                                                        for="<?php echo ERE_METABOX_PREFIX ?>floor_bathrooms_0"><?php esc_html_e('Bathrooms', 'g5-ere'); ?></label>
                                                <input
                                                        name="<?php echo ERE_METABOX_PREFIX ?>floors[0][<?php echo ERE_METABOX_PREFIX ?>floor_bathrooms]"
                                                        type="number"
                                                        id="<?php echo ERE_METABOX_PREFIX ?>floor_bathrooms_0" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label
                                                        for="<?php echo ERE_METABOX_PREFIX ?>floor_image_url_0"><?php esc_html_e('Floor Image', 'g5-ere'); ?></label>

                                                <div id="ere-floor-plupload-container-0" class="file-upload-block">
                                                    <input
                                                            name="<?php echo ERE_METABOX_PREFIX ?>floors[0][<?php echo ERE_METABOX_PREFIX ?>floor_image][url]"
                                                            type="text"
                                                            id="<?php echo ERE_METABOX_PREFIX ?>floor_image_url_0"
                                                            class="ere_floor_image_url form-control">
                                                    <input type="hidden" class="ere_floor_image_id"
                                                           name="<?php echo ERE_METABOX_PREFIX ?>floors[0][<?php echo ERE_METABOX_PREFIX ?>floor_image][id]"
                                                           value="" id="<?php echo ERE_METABOX_PREFIX ?>floor_image_id_0"/>
                                                    <button type="button" id="ere-floor-0" style="position: absolute" title="<?php esc_attr_e('Choose image','g5-ere') ?>" class="ere_floorsImg"><i class="fa fa-file-image-o"></i></button>
                                                </div>
                                                <div id="ere-floor-errors-log-0"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label
                                                    for="<?php echo ERE_METABOX_PREFIX ?>floor_description_0"><?php esc_html_e('Plan Description', 'g5-ere'); ?></label>
                                            <textarea
                                                    name="<?php echo ERE_METABOX_PREFIX ?>floors[0][<?php echo ERE_METABOX_PREFIX ?>floor_description]"
                                                    rows="4"
                                                    id="<?php echo ERE_METABOX_PREFIX ?>floor_description_0"
                                                    class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="row-remove">
                                <span data-remove="0" class="remove-floors-row remove"><i class="fa fa-remove"></i></span>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3">
                                <div class="row">
                                    <div class="col-sm-12 text-center">
                                        <button type="button" id="add-floors-row" data-increment="0" class="btn btn-primary"><i
                                                    class="fa fa-plus"></i> <?php esc_html_e('Add More', 'g5-ere'); ?>
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
