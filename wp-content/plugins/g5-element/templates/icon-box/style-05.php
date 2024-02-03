<?php
/**
 * @var $icon_html
 * @var $title
 * @var $content
 * @var $switch_show_button
 * @var $text_button
 * @var $title_class
 * @var $description_class
 * @var $button_is_3d
 * @var $button_color
 * @var $button_size
 * @var $button_shape
 * @var $button_style
 * @var $link
 */
?>
    <div class="content-box">
        <?php if (!empty($title)): ?>
            <h4 class="<?php echo implode(' ', $title_class); ?>">
                <?php echo $icon_box_link['before'] ?>
                <?php echo wp_kses_post($title); ?>
                <?php echo $icon_box_link['after'] ?>
            </h4>
        <?php endif; ?>
        <?php if (!empty($content)): ?>
            <div class="<?php echo implode(' ', $description_class); ?>">
	            <?php echo wpb_js_remove_wpautop($content, true); ?>
            </div>
        <?php endif; ?>
        <?php if (($icon_box_link['before']) && ($switch_show_button === 'on') && ($text_button !== '')): ?>
            <div class="btn-box">
                <?php g5element_render_button($text_button, $link, $button_style, $button_shape, $button_size, $button_color, $button_is_3d); ?>
            </div>
        <?php endif; ?>
    </div>
<?php if ($icon_html !== ''): ?>
	<div class="icon">
		<?php echo $icon_box_link['before'] ?>
		<?php echo $icon_html; ?>
		<?php echo $icon_box_link['after'] ?>
	</div>
<?php endif; ?>