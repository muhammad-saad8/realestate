<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}
/**
 * @var $social_share
 */
$page_permalink = get_permalink();
$page_title = get_the_title();
$post_type = get_post_type();

$wrapper_classes = array(
	'g5core__social-share',
	$post_type
);

$wrapper_class = implode(' ', $wrapper_classes);

?>
<div class="<?php echo esc_attr($wrapper_class)?>">
	<label class="g5core__share-label"><?php esc_html_e( 'Share:', 'g5-core' ) ?></label>
	<ul class="g5core__share-list">
		<?php
		foreach((array)$social_share as $key => $value) {
			$link = '';
			$icon = '';
			$title = '';
			$attributes = array();
			switch ($key) {
				case 'facebook':
					$link = "https://www.facebook.com/sharer.php?u=" . urlencode($page_permalink);
					$icon = 'fab fa-facebook-f';
					$title = esc_html__('Facebook', 'g5-core');
					break;
				case 'twitter':
					//$link  = "javascript: window.open('http://twitter.com/share?text=" . $page_title . "&url=" . $page_permalink . "','_blank', 'width=900, height=450');";
					$link  = "https://twitter.com/share?text=" . $page_title . "&url=" . urlencode($page_permalink);
					$icon = 'fab fa-twitter';
					$title = esc_html__('Twitter', 'g5-core');
					break;
				case 'linkedin':
					//$link  = "javascript: window.open('http://www.linkedin.com/shareArticle?mini=true&url=" . $page_permalink . "&title=" . $page_title . "','_blank', 'width=500, height=450');";
					$link = "http://www.linkedin.com/shareArticle?mini=true&url=" . urlencode($page_permalink) . "&title=" . $page_title;
					$icon = 'fab fa-linkedin-in';
					$title = esc_html__('LinkedIn', 'g5-core');
					break;
				case 'tumblr':
					//$link  = "javascript: window.open('http://www.tumblr.com/share/link?url=" . $page_permalink . "&name=" . $page_title . "','_blank', 'width=500, height=450');";
					$link = "http://www.tumblr.com/share/link?url=" . urlencode($page_permalink) . "&name=" . $page_title;
					$icon = 'fab fa-tumblr';
					$title = esc_html__('Tumblr', 'g5-core');
					break;
				case 'pinterest':
					$_img_src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
					//$link     = "javascript: window.open('http://pinterest.com/pin/create/button/?url=" . $page_permalink . '&media=' . (($_img_src === false) ? '' :  $_img_src[0]) . "&description=" . $page_title . "','_blank', 'width=900, height=450');";
					$link = "http://pinterest.com/pin/create/button/?url=" . urlencode($page_permalink) . '&media=' . (($_img_src === false) ? '' :  $_img_src[0]) . "&description=" . $page_title;
					$icon = 'fab fa-pinterest-p';
					$title = esc_html__('Pinterest', 'g5-core');
					break;
				case 'email':
					$link  = "mailto:?subject=" . $page_title . "&body=" . esc_url( $page_permalink );
					$icon = 'fal fa-envelope';
					$title = esc_html__('Email', 'g5-core');
					$attributes[] = 'target="_blank"';
					break;
				case 'telegram':
					//$link  = "javascript: window.open('https://telegram.me/share/url?url=" . esc_url( $page_permalink ) . "&text=" . $page_title . "','_blank', 'width=900, height=450');";
					$link = "https://telegram.me/share/url?url=" . esc_url( $page_permalink ) . "&text=" . $page_title;
					$icon = 'fab fa-telegram-plane';
					break;
				case 'whatsapp':
					$link  = "https://api.whatsapp.com/send?text=" . esc_attr( $page_title . "  \n\n" . esc_url( $page_permalink ) );
					$icon = 'fab fa-whatsapp';
					$title = esc_html__('Whats App', 'g5-core');
					$attributes[] = 'target="_blank"';
					break;
			}


			$args = apply_filters('g5core_social_share_'. $key .'_args',array(
				'link' => $link,
				'icon' => $icon,
				'title' => $title
			));

			$attributes[] = sprintf( 'href="%s"', $args['link'] );
			$attributes[] = sprintf( 'title="%s"', esc_attr($args['title']));
			$attributes[] = 'rel="nofollow"';
			$attributes[] = 'data-delay="1"';
			$attributes[] = 'data-toggle="tooltip"';
			$attributes[] = 'target="_blank"';
			?>
			<li class="<?php echo esc_attr($key);?>">
				<?php
					G5CORE()->get_template('share-item.php',array(
						'attributes' => $attributes,
						'icon' => $args['icon'],
						'title' => $args['title']
					));
				?>
			</li>
			<?php
		}
		?>
	</ul>
</div>
