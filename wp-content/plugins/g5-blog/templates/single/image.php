<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
ob_start();
$single_post_layout = G5BLOG()->options()->get_option('single_post_layout');
$image_mode = 'image';
$image_size = 'blog-single';
$hasThumb = false;

if (in_array($single_post_layout, array('layout-6', 'layout-7'))) {
    $image_mode = 'background';
    $image_size = 'full';
}
if (function_exists(G5CORE_CURRENT_THEME . '_has_sidebar')) {
    $has_sidebar = call_user_func(G5CORE_CURRENT_THEME . '_has_sidebar');
    if (!$has_sidebar) {
        $image_size = 'blog-single-full';
    }
}


$post_id = get_the_ID();
$prefix = G5BLOG()->meta_prefix;
?>
<?php if (has_post_format('gallery')): ?>
    <?php
    $gallery_images = get_post_meta($post_id, "{$prefix}format_gallery_images", true);
    ?>
    <?php if (!empty($gallery_images)): ?>
        <?php
        $gallery_images = preg_split('/\|/', $gallery_images);
        $slick_args = array(
            'slidesToShow' => 1,
            'dots' => false,
            'arrows' => true
        );
        $gallery_id = uniqid();
        $hasThumb = true;
        ?>
        <div class="g5core__post-featured g5blog__single-featured g5blog__single-featured-gallery slick-slider"
             data-slick-options="<?php echo esc_attr(json_encode($slick_args)); ?>">
            <?php
            foreach ($gallery_images as $image_id) {
                g5core_render_thumbnail_markup(array(
                    'post_id' => $post_id,
                    'image_id' => $image_id,
                    'image_size' => $image_size,
                    'display_permalink' => false,
                    'image_mode' => $image_mode,
                    'gallery_id' => $gallery_id,
                ));
            }

            ?>
        </div>
    <?php endif; ?>
<?php elseif (has_post_format('video')): ?>
    <?php $video_embed = get_post_meta($post_id, "{$prefix}format_video_embed", true); ?>
    <?php if ($video_embed !== ''): ?>
        <div class="g5core__post-featured g5blog__single-featured g5blog__single-featured-video">
            <div class="g5core__embed-responsive g5core__image-size-16x9">
                <?php
                $hasThumb = true;
                if (wp_oembed_get($video_embed)) {
                    echo wp_oembed_get($video_embed, array('wmode' => 'transparent'));
                } else {
                    echo $video_embed;
                }
                ?>
            </div>
        </div>
    <?php endif; ?>
<?php elseif (has_post_format('audio')): ?>
    <?php $audio_embed = get_post_meta($post_id, "{$prefix}format_audio_embed", true); ?>
    <?php if ($audio_embed !== ''): ?>
        <div class="g5core__post-featured g5blog__single-featured g5blog__single-featured-audio">
            <div class="g5core__embed-responsive g5core__image-size-16x9">
                <?php
                $hasThumb = true;
                if (wp_oembed_get($audio_embed)) {
                    echo wp_oembed_get($audio_embed);
                } else {
                    echo $audio_embed;
                }
                ?>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>
<?php if (!$hasThumb && has_post_thumbnail($post_id)): ?>
    <?php
    $thumbnail_data = g5core_get_thumbnail_data(array(
        'image_size' => 'full',
        'image_id' => get_post_thumbnail_id($post_id),
    ));
    ?>
    <?php if ($thumbnail_data['url'] !== ''): ?>
        <div class="g5core__post-featured g5blog__single-featured">
            <?php g5core_render_thumbnail_markup(array(
                'post_id' => $post_id,
                'image_id' => get_post_thumbnail_id($post_id),
                'image_size' => 'full',
                'display_permalink' => false,
                'image_mode' => $image_mode
            )) ?>
        </div>
    <?php endif; ?>
<?php endif; ?>
<?php
$thumbnail_markup = ob_get_clean();
if (empty($thumbnail_markup)) return;
printf('%s', $thumbnail_markup);


