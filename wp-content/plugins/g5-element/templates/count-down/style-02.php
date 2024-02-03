<?php
/**
 * @var $number_class
 * @var $text_class
 */
?>
<div class="gel-countdown-section">
    <span class="<?php echo esc_attr($number_class); ?> gel-countdown-day">00</span>
    <span class="<?php echo esc_attr($text_class); ?>"><?php esc_html_e('Days', 'g5-element'); ?></span>
</div>
<div class="gel-countdown-section">
    <span class="<?php echo esc_attr($number_class); ?> gel-countdown-hours">00</span>
    <span class="<?php echo esc_attr($text_class); ?>"><?php esc_html_e('Hours', 'g5-element'); ?></span>
</div>
<div class="gel-countdown-section">
    <span class="<?php echo esc_attr($number_class); ?> gel-countdown-minutes">00</span>
    <span class="<?php echo esc_attr($text_class); ?>"><?php esc_html_e('Minutes', 'g5-element'); ?></span>
</div>
<div class="gel-countdown-section">
    <span class="<?php echo esc_attr($number_class); ?> gel-countdown-seconds">00</span>
    <span class="<?php echo esc_attr($text_class); ?>"><?php esc_html_e('Seconds', 'g5-element'); ?></span>
</div>