<div id="g5core_off_canvas_sidebar" class="g5core-off-canvas-wrapper from-right">
	<div class="off-canvas-close">
		<i class="fal fa-times"></i>
	</div>
	<div class="off-canvas-overlay"></div>
	<div class="g5core-off-canvas-inner">
		<?php if (is_dynamic_sidebar('g5core-off-canvas')): ?>
			<?php dynamic_sidebar('g5core-off-canvas') ?>
		<?php endif; ?>
	</div>
</div>