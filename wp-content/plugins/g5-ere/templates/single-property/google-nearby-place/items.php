<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<script id="g5ere__google_nearby_place_block_template" type="text/template">
    <div class="g5ere__cat-block"><h3 class="g5ere__cat-block-title">{{category}}</h3>
        <div class="cat-block-content"></div>
    </div>
</script>
<script id="g5ere__google_nearby_place_star_template" type="text/template">
    <i class="{{class}} fa-star"></i>
</script>
<script id="g5ere__google_nearby_place_rating_template" type="text/template">
    <div class="g5ere__cat-block-item-review g5ere__rating-review">
        <p class="g5ere__cat-block-item-review-number mb-0">
            {{total_review}} <?php esc_html_e( 'Reviews', 'g5-ere' ) ?></p>
        <div class="g5ere__cat-block-item-rating">
            <div class="rating-wrap">
                <div class="g5ere__rating-icon-stars">
                    {{rating}}
                </div>
            </div>
        </div>
    </div>
</script>
<script id="g5ere__google_nearby_place_items_template" type="text/template">
	<div class="g5ere__cat-block-items">
		<div class="g5ere__cat-block-item">
			<div class="media">
				<a href="{{link}}" class="g5ere__cat-block-item-thumb"
				   style="background-image: url('{{image_url}}')">
				</a>
				<div class="media-body">
					<div class="g5ere__cat-block-content">
						<h4 class="g5ere__cat-block-item-title">
							<a href="{{link}}" target='_blank'>{{name}}</a>
							<span>({{distance}})</span>
						</h4>
						<p class="g5ere__cat-block-item-address mb-0">
							{{address}}
						</p>
					</div>
					{{html_rating}}
				</div>
			</div>
		</div>
	</div>
</script>