<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $current_user;
wp_get_current_user();
$user_id = $current_user->ID;
$package_remaining_listings = get_the_author_meta(ERE_METABOX_PREFIX . 'package_number_listings', $user_id);
$package_featured_remaining_listings = get_the_author_meta(ERE_METABOX_PREFIX . 'package_number_featured', $user_id);
$package_id = get_the_author_meta(ERE_METABOX_PREFIX . 'package_id', $user_id);
$packages_link = ere_get_permalink('packages');
if ($package_remaining_listings == -1) {
    $package_remaining_listings = esc_html__('Unlimited', 'g5-ere');
}
if (ere_package_is_visible($package_id)) :
    $package_title = get_the_title($package_id);
    $package_listings = get_post_meta($package_id, ERE_METABOX_PREFIX . 'package_number_listings', true);
    $package_unlimited_listing = get_post_meta($package_id, ERE_METABOX_PREFIX . 'package_unlimited_listing', true);
    $package_featured_listings = get_post_meta($package_id, ERE_METABOX_PREFIX . 'package_number_featured', true);
    $ere_package = new ERE_Package();
    $expired_date = $ere_package->get_expired_date($package_id, $user_id);
    ?>
    <ul class="list-group ere-my-package g5ere__package-details">
        <li class="list-group-item d-flex align-items-center">
            <label class="label mr-auto mb-0">
	            <?php esc_html_e('Package Name ', 'g5-ere') ?>
            </label>
            <span
                class="value"><?php echo esc_html($package_title) ?></span>

        </li>
        <li class="list-group-item d-flex align-items-center">
            <label class="label mr-auto mb-0">
	            <?php esc_html_e('Listings Included ', 'g5-ere') ?>
            </label>
            <span class="value"><?php if ($package_unlimited_listing == 1) {
                    echo wp_kses_post($package_remaining_listings);
                } else {
                    echo esc_html($package_listings);
                }
                ?>
            </span></li>
        <li class="list-group-item d-flex align-items-center">
            <label class="label mr-auto mb-0">
	            <?php esc_html_e('Listings Remaining ', 'g5-ere') ?>
            </label>
            <span
                class="value"><?php echo wp_kses_post($package_remaining_listings); ?></span>
        </li>

        <li class="list-group-item d-flex align-items-center">
            <label class="label mr-auto mb-0">
	            <?php esc_html_e('Featured Included ', 'g5-ere') ?>
            </label>
            <span
                class="value"><?php echo esc_html($package_featured_listings) ?></span>

        </li>

        <li class="list-group-item d-flex align-items-center">
            <label class="label mr-auto mb-0">
	            <?php esc_html_e('Featured Remaining ', 'g5-ere') ?>
            </label>
            <span
                class="value"><?php echo esc_html($package_featured_remaining_listings) ?></span>
        </li>
	    <?php do_action('g5ere_after_my_package_detail', $user_id) ?>

        <li class="list-group-item d-flex align-items-center">
            <label class="label mr-auto mb-0">
	            <?php esc_html_e('End Date ', 'g5-ere') ?>
            </label>
            <span
                class="value"><?php echo esc_html($expired_date) ?></span>
        </li>
        <li class="list-group-item">
            <a href="<?php echo esc_url($packages_link); ?>"
               class="btn btn-primary btn-block"><?php esc_html_e('Change new package', 'g5-ere'); ?></a>
        </li>
    </ul>
<?php else: ?>
    <div class="panel-body">
    <p class="ere-message alert alert-success"
       role="alert"><?php esc_html_e('Before you can list properties on our site, you must subscribe to a package. Currently, you don\'t have a package. So, to select a new package, please click the button below', 'g5-ere'); ?></p>
    <a href="<?php echo esc_url($packages_link); ?>"
       class="btn btn-primary btn-block"><?php esc_html_e('Subscribe to a package', 'g5-ere'); ?></a>
    </div>
<?php endif; ?>