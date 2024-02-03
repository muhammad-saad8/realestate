<script type="text/html" id="tmpl-gsf-select-popup">
	<div id="gsf-popup-select-target">
		<div class="gsf-popup-select-wrapper g5u-popup-container">
			<div class="g5u-popup gsf-popup-select-content"
			<# if (data.popup_width) { #>
			style="width: {{data.popup_width}}"
			<# } #>>
				<h4 class="g5u-popup-header">
					<strong>{{data.title}}
				
				<div class="g5u-popup-body gsf-popup-select-listing">
					<div class="gsf-row">
						<# for (var item_key in data.options) { #>
						<div class="gsf-col gsf-col-{{12/(data.items)}}">
							<div class="gsf-popup-select-item" data-value="{{item_key}}">
								<img src="{{ data.options[item_key].img}}"
								     data-thumb="{{ data.options[item_key].thumb}}"
								     alt="{{ data.options[item_key].label}}">
								<div class="gsf-popup-select-item-footer">
									<span class="name">{{data.options[item_key].label}}
									<span class="current"><br />
<b>Fatal error:  Uncaught Error: Call to undefined function esc_html_e() in D:\PORTFOLIO\htdocs\realestate\wp-content\plugins\g5-core\lib\smart-framework\fields\select_popup\templates\popup.tpl.php:21
Stack trace:
#0 {main}
  thrown in <b>D:\PORTFOLIO\htdocs\realestate\wp-content\plugins\g5-core\lib\smart-framework\fields\select_popup\templates\popup.tpl.php on line <b>21<br />
</script>