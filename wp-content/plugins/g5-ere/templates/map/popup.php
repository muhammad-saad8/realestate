<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
?>
<script id="tmpl-g5ere__map_popup_template" type="text/template">
	<div class="g5ere__map-popup">
		<div class="g5ere__map-popup-thumb">
			<a href="{{{data.url}}}" target="_blank" style="background-image: url('{{{data.thumb}}}')">
			</a>
		</div>
		<div class="g5ere__map-popup-content">
			<h5 class="g5ere__map-popup-title">
				<a href="{{{data.url}}}" title="{{{data.title}}}" target="_blank">{{{data.title}}}</a>
			</h5>
			<span class="g5ere__map-popup-address">
                <i class="fal fa-map-marker-alt"></i> {{{data.address}}}
            </span>
		</div>
	</div>
</script>
