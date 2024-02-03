<script type="text/html" id="tmpl-gsf-standard-fonts">
    <div class="gsf-font-container" id="standard_fonts">
        <div class="gsf-font-items">
            <# _.each(data.fonts.items, function(item, index) { #>
                <div class="gsf-font-item" data-name="{{item.family}}">
                    <div class="gsf-font-item-name">{{item.name}}
                    <div class="gsf-font-item-action">
                        <#if (item.using) {#>
                            <a href="#" class="gsf-font-item-action-add" data-type="standard"
                               title="<br />
<b>Fatal error:  Uncaught Error: Call to undefined function esc_attr_e() in D:\PORTFOLIO\htdocs\realestate\wp-content\plugins\g5-core\lib\smart-framework\core\fonts\templates\standard.tpl.php:10
Stack trace:
#0 {main}
  thrown in <b>D:\PORTFOLIO\htdocs\realestate\wp-content\plugins\g5-core\lib\smart-framework\core\fonts\templates\standard.tpl.php on line <b>10<br />
</script>