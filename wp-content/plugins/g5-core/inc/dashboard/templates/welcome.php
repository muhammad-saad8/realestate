<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
$current_theme = wp_get_theme();
$features = G5CORE()->dashboard()->welcome()->get_features();
?>
<div class="g5core-message-box">
    <h1 class="welcome"><?php esc_html_e('Welcome to', 'g5-core') ?> <span
                class="g5core-theme-name"><?php echo esc_html($current_theme['Name']) ?></span> <span
                class="g5core-theme-version">v<?php echo esc_html($current_theme['Version']) ?></span></h1>
    <p class="about"><?php esc_html_e('Thank you for choosing the best theme we have ever build! we did a lot of pressure to release this great product and we will offer our 5 star support to this theme for fixing all the issues and adding more features.', 'g5-core'); ?></p>
</div>

<div class="g5core-message-box" style="border-bottom: none;">
    <h3 class="welcome" style="font-size: 28px;"><?php esc_html_e('Quick Start','g5-core') ?></h3>
    <p><?php echo wp_kses_post(sprintf(__('You can start using theme simply by installing Visual Composer plugin. Also there is more plugins for social counter, post views, ads manager ... that you can install them from our <a href="%s">plugin installer</a>.','g5-core'),admin_url('admin.php?page=g5core_plugins'))) ?></p>
</div>
<div class="g5core-feature-section g5core-row">
    <?php foreach($features as $feature): ?>
        <div class="g5core-feature-box g5core-col-6">
            <div class="g5core-box">
                <div class="g5core-box-head">
                    <?php if (isset($feature['icon']) && !empty($feature['icon'])): ?>
                        <i class="<?php echo esc_attr($feature['icon']) ?>"></i>
                    <?php endif; ?>
                    <span><?php echo esc_html($feature['label'])?></span>
                </div>
                <div class="g5core-box-body">
                    <?php echo esc_html($feature['description']); ?>
                </div>
                <div class="g5core-box-footer">
                    <a href="<?php echo esc_url($feature['button_url']) ?>" class="button button-large button-primary" target="_blank"><?php echo esc_html($feature['button_text'])?></a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
