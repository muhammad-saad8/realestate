<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}
/**
 * @var $social_share array
 */
$page_permalink = get_permalink();
$page_title = get_the_title();
$wrapper_classes = array(
	'g5ere__single-property-social-share',
	'dropdown'
);
$wrapper_class = implode(' ', $wrapper_classes);
?>

<div class="<?php echo esc_attr($wrapper_class)?>" data-toggle="tooltip" title="<?php echo esc_attr__('Share','g5-ere')?>">
	<a href="#" class="g5ere__sps-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<i class="far fa-share-alt"></i>
	</a>
	<div class="dropdown-menu g5ere__sps-list dropdown-menu-right">
		<?php foreach ($social_share as $key => $value): ?>
			<?php
			$link = '';
			$icon = '';
			$title = '';
			$attributes = array();
			switch ($key) {
				case 'facebook':
					$link = "https://www.facebook.com/sharer.php?u=" . urlencode($page_permalink);
					$icon = 'fab fa-facebook-f';
					$title = esc_html__('Facebook', 'g5-ere');
					break;
				case 'twitter':
					$link  = "https://twitter.com/share?text=" . $page_title . "&url=" . urlencode($page_permalink) . "";
					$icon = 'fab fa-twitter';
					$title = esc_html__('Twitter', 'g5-ere');
					break;
				case 'linkedin':
					//$link  = "javascript: window.open('http://www.linkedin.com/shareArticle?mini=true&url=" . urlencode($page_permalink) . "&title=" . $page_title . "','_blank', 'width=500, height=450');";
					$link = "http://www.linkedin.com/shareArticle?mini=true&url=" . urlencode($page_permalink) . "&title=" . $page_title;
					$icon = 'fab fa-linkedin-in';
					$title = esc_html__('LinkedIn', 'g5-ere');
					break;
				case 'tumblr':
					//$link  = "javascript: window.open('http://www.tumblr.com/share/link?url=" . urlencode($page_permalink) . "&name=" . $page_title . "','_blank', 'width=500, height=450');";
					$link = "http://www.tumblr.com/share/link?url=" . urlencode($page_permalink) . "&name=" . $page_title;
					$icon = 'fab fa-tumblr';
					$title = esc_html__('Tumblr', 'g5-ere');
					break;
				case 'pinterest':
					$_img_src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
					//$link     = "javascript: window.open('http://pinterest.com/pin/create/button/?url=" . urlencode($page_permalink) . '&media=' . (($_img_src === false) ? '' :  $_img_src[0]) . "&description=" . $page_title . "','_blank', 'width=900, height=450');";
					$link = "http://pinterest.com/pin/create/button/?url=" . urlencode($page_permalink) . '&media=' . (($_img_src === false) ? '' :  $_img_src[0]) . "&description=" . $page_title;
					$icon = 'fab fa-pinterest-p';
					$title = esc_html__('Pinterest', 'g5-ere');
					break;
				case 'email':
					$link  = "mailto:?subject=" . $page_title . "&body=" . esc_url( $page_permalink );
					$icon = 'fal fa-envelope';
					$title = esc_html__('Email', 'g5-ere');
					$attributes[] = 'target="_blank"';
					break;
				case 'telegram':
					//$link  = "javascript: window.open('https://telegram.me/share/url?url=" . esc_url( $page_permalink ) . "&text=" . $page_title . "','_blank', 'width=900, height=450');";
					$link = "https://telegram.me/share/url?url=" . esc_url( $page_permalink ) . "&text=" . $page_title;
					$icon = 'fab fa-telegram-plane';
					$title = esc_html__('Telegram', 'g5-ere');
					break;
				case 'whatsapp':
					$link  = "https://api.whatsapp.com/send?text=" . esc_attr( $page_title . "  \n\n" . esc_url( $page_permalink ) );
					$icon = 'fab fa-whatsapp';
					$title = esc_html__('Whats App', 'g5-ere');
					$attributes[] = 'target="_blank"';
					break;
			}
			$args = apply_filters('g5ere_social_share_'. $key .'_args',array(
				'link' => $link,
				'icon' => $icon,
				'title' => $title
			));

			$attributes[] = sprintf( 'href="%s"', esc_url($args['link']));
			$attributes[] = sprintf( 'title="%s"', esc_attr($args['title']));
			$attributes[] = 'rel="nofollow"';
			$attributes[] = 'target="_blank"';
			?>
			<a class="dropdown-item <?php echo esc_attr($key);?>" <?php echo join(' ', $attributes)?>>
				<i class="<?php echo esc_attr($args['icon']); ?>"></i> <span><?php echo esc_html($args['title']) ?></span>
			</a>
		<?php endforeach; ?>
	</div>
</div>