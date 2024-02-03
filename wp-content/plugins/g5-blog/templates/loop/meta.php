<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $cat
 * @var $author
 * @var $date
 * @var $comment
 * @var $edit
 * @var $view
 * @var $like
 */
?>
<ul class="g5blog__post-meta">
    <?php if ($author): ?>
        <li class="meta-author">
            <?php
            global $post;
            $author_Id = $post->post_author;
            $author_name = get_the_author_meta( 'display_name',$author_Id );
            G5BLOG()->get_template('loop/meta/author.php',array(
                 'author_Id' => $author_Id,
                 'author_name' => $author_name
            ));
            ?>
        </li>
    <?php endif; ?>
    <?php if ($date): ?>
        <li class="meta-date">
            <?php G5BLOG()->get_template('loop/meta/date.php');  ?>
        </li>
    <?php endif; ?>
    <?php if ($comment && (comments_open() || get_comments_number())) : ?>
        <li class="meta-comment">
            <?php G5BLOG()->get_template('loop/meta/comment.php'); ?>
        </li>
    <?php endif; ?>
    <?php if ($cat) : ?>
        <li class="cat-meta">
            <?php G5BLOG()->get_template('loop/meta/cat.php'); ?>
        </li>
    <?php endif; ?>
    <?php if ($view) {g5blog_template_post_view();}  ?>
    <?php if ($like) {g5blog_template_post_like();}  ?>
    <?php if ($edit) {edit_post_link(esc_html__('Edit', 'g5-blog'), '<li class="edit-link"><i class="far fa-pencil"></i>', '</li>');}?>
</ul>
