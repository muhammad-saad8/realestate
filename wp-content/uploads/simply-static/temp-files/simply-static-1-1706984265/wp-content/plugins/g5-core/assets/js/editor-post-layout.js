(function ($) {
    "use strict";
    $(document).on('tinymce-editor-init', function () {
        $(document).on('change','.g5core-meta-box-wrap [name*="site_layout"]',function () {
            $("#content_ifr").contents().find("body").attr('data-site_layout',$(this).val());
        }).find('.g5core-meta-box-wrap [name*="site_layout"]:checked').change();
    });
})(jQuery);