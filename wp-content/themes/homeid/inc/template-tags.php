<?php
function homeid_comment_form_args() {
	$commenter = wp_get_current_commenter();
	$req = get_option('require_name_email');
	$html_req = ($req ? " required='required'" : '');

	$fields = array(
		'author'  => '<p class="comment-form-author">' . '<input id="author" name="author" type="text" placeholder="' . esc_attr__( 'Fullname', 'homeid' ) . '" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" maxlength="245"' . $html_req . ' /></p>',
		'email'   => '<p class="comment-form-email">' . '<input id="email" name="email" placeholder="' . esc_attr__( 'Email address', 'homeid' )  . '" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" maxlength="100" aria-describedby="email-notes"' . $html_req . ' /></p>',
		'url'     => '<p class="comment-form-url">' . '<input id="url" name="url" placeholder="' . esc_attr__( 'Website', 'homeid' ) . '" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" maxlength="200" /></p>',
	);

	$defaults = array(
		'format'               => 'html5',
		'comment_field'      => '<p class="comment-form-comment"><textarea placeholder="' . esc_attr__('Comment', 'homeid') . '" id="comment" name="comment" cols="45" rows="2" maxlength="65525" required="required"></textarea></p>',
		'fields'             => $fields,
		'class_submit'       => 'btn',
		'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title"><span>',
		'title_reply_after'    => '</span></h3>',
	);

	return $defaults;
}


add_filter('widget_categories_args', 'homeid_widget_categories_args');
function homeid_widget_categories_args($cat_args)
{
	$cat_args['taxonomy'] = 'category';
	return $cat_args;
}

function homeid_cat_count_span($links, $args)
{
	if (isset($args['taxonomy']) && ($args['taxonomy'] == 'category')) {
		$links = str_replace('(', '<span class="count">', $links);
		$links = str_replace(')', '</span>', $links);
	}

	return $links;
}
add_filter('wp_list_categories', 'homeid_cat_count_span',15,2);

function homeid_archive_count_span($links, $url, $text, $format)
{
	if ($format === 'option') {
		return $links;
	}
	$links = str_replace( '</a>&nbsp;(', ' <span class="count">', $links );
	$links = str_replace( ')', '</span></a>', $links );
	return $links;
}
add_filter('get_archives_link', 'homeid_archive_count_span', 10, 4);
