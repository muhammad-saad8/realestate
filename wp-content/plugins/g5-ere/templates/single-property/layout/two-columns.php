<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $content_blocks array
 */
$content_blocks_length = count($content_blocks);
$content_blocks_half = round($content_blocks_length / 2);
$left_contents  = array_slice($content_blocks,0,$content_blocks_half);
$right_contents = array_slice($content_blocks,$content_blocks_half,$content_blocks_length);
?>
<div class="row g5ere__property-layout-two-columns">
	<?php if ( $left_contents ): ?>
        <div class="col-xl-6">
			<?php
			foreach ( $left_contents as $key => $value ) {
				G5ERE()->get_template( "single-property/block/{$key}.php" );
			}
			?>
        </div>
	<?php endif; ?>
	<?php if ( $right_contents ): ?>
        <div class="col-xl-6">
			<?php
			foreach ( $right_contents as $key => $value ) {
				G5ERE()->get_template( "single-property/block/{$key}.php" );
			}
			?>
        </div>
	<?php endif; ?>
</div>

