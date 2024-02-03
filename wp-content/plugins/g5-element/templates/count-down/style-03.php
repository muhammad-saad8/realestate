<?php
/**
 * @var $number_class
 * @var $text_class
 * @var $foreground_color
 * @var $background_color
 */
?>
<div class="gel-countdown-section">
    <input id="days" class="days" data-thickness=".05" value="0" data-readOnly="true"
           data-fgcolor="<?php echo esc_attr($foreground_color); ?>" data-bgcolor="<?php echo esc_attr($background_color); ?>">
    <div class="gel-countdown-section-inner">
        <span class="<?php echo esc_attr($number_class); ?> gel-countdown-day">00</span>
        <span class="<?php echo esc_attr($text_class); ?>"><?php esc_html_e('Days', 'g5-element'); ?></span>
    </div>
</div>
<div class="gel-countdown-section">
    <input id="hours" class="hours" data-max="23" data-thickness=".05" value="0" data-readOnly="true"
           data-fgcolor="<?php echo esc_attr($foreground_color); ?>" data-bgcolor="<?php echo esc_attr($background_color); ?>">
    <div class="gel-countdown-section-inner">
        <span class="<?php echo esc_attr($number_class); ?> gel-countdown-hours">00</span>
        <span class="<?php echo esc_attr($text_class); ?>"><?php esc_html_e('Hours', 'g5-element'); ?></span>
    </div>
</div>
<div class="gel-countdown-section">
    <input id="minutes" class="minutes" data-max="59" data-thickness=".05" value="0" data-readOnly="true"
           data-fgcolor="<?php echo esc_attr($foreground_color); ?>" data-bgcolor="<?php echo esc_attr($background_color); ?>">
    <div class="gel-countdown-section-inner">
        <span class="<?php echo esc_attr($number_class); ?> gel-countdown-minutes">00</span>
        <span class="<?php echo esc_attr($text_class); ?>"><?php esc_html_e('Minutes', 'g5-element'); ?></span>
    </div>
</div>
<div class="gel-countdown-section">
    <input id="seconds" class="seconds" data-max="59" data-thickness=".05" value="0" data-readOnly="true"
           data-fgcolor="<?php echo esc_attr($foreground_color); ?>" data-bgcolor="<?php echo esc_attr($background_color); ?>">
    <div class="gel-countdown-section-inner">
        <span class="<?php echo esc_attr($number_class); ?> gel-countdown-seconds">00</span>
        <span class="<?php echo esc_attr($text_class); ?>"><?php esc_html_e('Seconds', 'g5-element'); ?></span>
    </div>
</div>