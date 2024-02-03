<?php
$content_block_enable = g5ere_get_single_property_tabs_content_blocks();
if ( ! $content_block_enable ) {
	return;
}
?>
<div class="g5ere__single-block g5ere__single-block-tabs g5ere__property-block g5ere__single-property-tabs">
    <div class="g5ere__tabs-container">
        <ul class="nav nav-tabs" role="tablist">
			<?php $index = 0; ?>
			<?php foreach ( $content_block_enable as $key => $tab ) : ?>
                <li class="nav-item">
                    <a class="tab-<?php echo esc_attr( $key ); ?> nav-link <?php echo esc_attr( $index === 0 ? 'active' : '' ) ?>"
                       id="<?php echo esc_attr( $key ); ?>-tab"
                       data-toggle="tab"
                       href="#tab-<?php echo esc_attr( $key ); ?>"
                       role="tab"
                       aria-controls="tab-<?php echo esc_attr( $key ); ?>"
                       aria-selected="<?php echo esc_attr( $index === 0 ? 'true' : 'false' ) ?>">
						<?php echo esc_html( $tab ) ?>

                    </a>
                </li>
				<?php $index ++; ?>
			<?php endforeach; ?>
        </ul>
    </div>
    <div class="tab-content g5ere__panels-container">
		<?php $index = 0; ?>
		<?php foreach ( $content_block_enable as $key => $tab ) : ?>
            <div class="tab-pane fade <?php echo esc_attr( $index === 0 ? 'show active' : '' ) ?>"
                 id="tab-<?php echo esc_attr( $key ); ?>" role="tabpanel"
                 aria-labelledby="<?php echo esc_attr( $key ); ?>-tab">
                <div class="g5ere__tab-panel card g5ere__single-block g5ere__property-block g5ere__property-block-<?php echo esc_attr($key)?>">
                    <div class="g5ere__panel-heading card-header">
                        <h2 data-toggle="collapse" data-target="#collapse-<?php echo esc_attr( $key ); ?>"
                            aria-expanded="<?php echo esc_attr( $index === 0 ? 'true' : 'false' ) ?>"
                            aria-controls="collapse-<?php echo esc_attr( $key ); ?>">
							<?php echo esc_html( $tab ) ?>
                        </h2>
                    </div>
                    <div id="collapse-<?php echo esc_attr( $key ); ?>"
                         class="collapse <?php echo esc_attr( $index === 0 ? 'show' : '' ) ?>"
                         data-parent=".g5ere__panels-container">
                        <div class="g5ere__panel-body card-body">
	                        <?php if ($key === 'review') {
	                        	comments_template();
	                        } else {
		                        G5ERE()->get_template( "single-property/block/data/{$key}.php", array( 'block_name' => $tab ) );
	                        } ?>
                        </div>
                    </div>
                </div>
            </div>
			<?php $index ++; ?>
		<?php endforeach; ?>
    </div>
</div>
