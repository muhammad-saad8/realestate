<script type="text/html" id="tmpl-gsf-google-fonts">
    <div class="gsf-font-container" id="google_fonts" style="display: block">
        <ul class="gsf-font-categories gsf-clearfix">
            <# _.each(data.fonts.categories, function(item, index) { #>
                <# if (index == 0) {#>
                    <li class="active" data-ref="{{item.name}}"><a href="#">{{item.name}} ({{item.count}})
                    <#} else { #>
                        <li data-ref="{{item.name}}"><a href="#">{{item.name}} ({{item.count}})
                        <#}#>
                            <# }); #>
        
        <div class="gsf-font-items">
            <# _.each(data.fonts.items, function(item, index) { #>
                <div class="gsf-font-item" data-category="{{item.category}}" data-name="{{item.family}}" style="display: none">
                    <div class="gsf-font-item-name">{{item.family}}
                    <div class="gsf-font-item-action">
                        <a href="https://www.google.com/fonts/specimen/{{item.family.replace(' ','+')}}" target="_blank"
                           title="<br />
<b>Fatal error:  Uncaught Error: Call to undefined function esc_attr_e() in D:\PORTFOLIO\htdocs\realestate\wp-content\plugins\g5-core\lib\smart-framework\core\fonts\templates\google.tpl.php:18
Stack trace:
#0 {main}
  thrown in <b>D:\PORTFOLIO\htdocs\realestate\wp-content\plugins\g5-core\lib\smart-framework\core\fonts\templates\google.tpl.php on line <b>18<br />
</script>