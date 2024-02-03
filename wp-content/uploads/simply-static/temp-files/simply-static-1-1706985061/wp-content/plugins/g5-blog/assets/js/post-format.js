var G5Blog_PostFormat = G5Blog_PostFormat || {};
(function ($) {
    "use strict";
    G5Blog_PostFormat = {
        init : function(){
            var _that = this;
            setTimeout(function () {
                $('.editor-post-format select').trigger('change');
                $('[name="post_format"]:checked').trigger('change')
            },1000);

            $(document).on('change','.editor-post-format select',function (event) {
                _that.switch_post_format_content($(this).val());
            });

            $('[name="post_format"]').on('change',function(){
                _that.switch_post_format_content($(this).val());
            });
        },
        switch_post_format_content: function ($post_format) {
            $('#g5blog_format_video_embed,#g5blog_format_audio_embed,#g5blog_format_gallery_images,#g5blog_format_link_url').hide();
            switch ($post_format) {
                case 'video':
                    $('#g5blog_format_video_embed').show();
                    break;
                case 'audio':
                    $('#g5blog_format_audio_embed').show();
                    break;
                case 'gallery':
                    $('#g5blog_format_gallery_images').show();
                    break;
                case 'link':
                    $('#g5blog_format_link_url').show();
            }
        }
    };
    $(document).ready(function () {
        G5Blog_PostFormat.init();
    });
})(jQuery);