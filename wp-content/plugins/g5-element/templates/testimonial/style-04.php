<?php
/**
 * Shortcode attributes
 * @var $align
 * @var $author_name
 * @var $author_job
 * @var $author_bio
 * @var $author_avatar
 * @var $author_link
 * @var $name_class
 * @var $job_class
 * @var $bio_class
 * Shortcode class
 */
?>
<div class="testimonial-bg">
	<div class="testi-quote">
		<div class="testimonial-content">
			<p class="<?php echo implode(' ', $bio_class); ?>"><?php echo wp_kses_post($author_bio) ?></p>
		</div>
	</div>
	<?php if ($content_bg_color != '') { ?>
		<div class="triangle-down">
		</div>
	<?php } ?>
</div>
<div class="author-info">
	<?php
	if (!empty($author_avatar)) { ?>
		<div class="author-avatar">
			<?php echo wp_kses_post($image_src); ?>
		</div>
	<?php } ?>
	<div class="testi-right">
		<?php if ($rating > 0) { ?>
			<div class="testimonial-rating">
				<?php for ($i = 1; $i <= 5; $i++): ?>
					<?php $icon_class = ($i <= $rating) ? 'fa fa-star' : 'far fa-star'; ?>
					<span class="<?php echo esc_attr($icon_class) ?>"></span>
				<?php endfor; ?>
			</div>
		<?php } ?>
		<div class="author-attr">
			<h4 class="<?php echo implode(' ', $name_class); ?>">
				<a href="<?php echo esc_url($author_link) ?>"
				   title="<?php echo esc_attr($author_name) ?>">
					<?php echo esc_html($author_name) ?>
				</a>
			</h4>
			<?php if ($author_job !== ''): ?>
				<span class="<?php echo implode(' ', $job_class); ?>"> <?php echo esc_html($author_job) ?></span>
			<?php endif; ?>
		</div>
	</div>
</div>
