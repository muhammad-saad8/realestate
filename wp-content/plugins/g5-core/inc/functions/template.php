<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
function g5core_get_the_title( $post = 0 ) {
    $data = G5CORE()->cache()->get_cache_listing( 'title' );
    if ( ! is_null( $data ) ) {
        return $data;
    }
    $data = get_the_title( $post );
    G5CORE()->cache()->set_cache_listing( 'title', $data );
    return $data;
}

function g5core_the_title_attribute( $args = '' ) {
    $args = wp_parse_args( $args, array(
        'before' => '',
        'after' => '',
        'echo' => true,
	    'post' => 0
    ) );

    $title = g5core_get_the_title($args['post']);

    if ( strlen( $title ) == 0 ) {
        return '';
    }

    $title = $args['before'] . $title . $args['after'];

    if ( $args['echo'] ) {
        echo esc_attr( strip_tags( $title ) );
    } else {
        return esc_attr( strip_tags( $title ) );
    }
}

function g5core_the_title( $post = 0, $before = '', $after = '', $echo = true, $length = -1 ) {
    $title = g5core_get_the_title( $post );

    if ( strlen( $title ) == 0 ) {
        return;
    }

    if ($length > 0) {
        $title = g5core_truncate_text($title,$length);
    }

    $title = $before . $title . $after;

    if ( $echo ) {
        echo esc_html( $title );
    } else {
        return $title;
    }
}

function g5core_the_permalink( $post = 0 ) {
    echo g5core_get_permalink( $post );
}

function g5core_get_permalink( $post = 0 ) {

    $cache_key = 'permalink';
    $data      = G5CORE()->cache()->get_cache_listing( $cache_key );

    if ( ! is_null( $data ) ) {
        return $data;
    }
    $data = get_permalink( $post );
    G5CORE()->cache()->set_cache_listing( $cache_key, $data );
    return $data;
}

function g5core_template_breadcrumbs($wrapper_class = '') {
    if (G5CORE()->cache()->get('g5core_breadcrumb_enable')) {
        return;
    }
    G5CORE()->get_template('breadcrumb.php', array('wrapper_class' => $wrapper_class));
}

function g5core_template_social_share() {
	$social_share = g5core_get_social_share();
	if (!$social_share) return;
	G5CORE()->get_template('share.php',array('social_share' => $social_share));
}



function g5core_template_metro_link($args) {
	if (isset($args['display_permalink']) && ($args['display_permalink'])) {
	?>
		<a class="g5core__metro-link" href="<?php g5core_the_permalink() ?>"></a>
	<?php
	}
}

function g5core_template_metro_content($args) {
	if (isset($args['content']) && ($args['content'])) {
		echo $args['content'];
	}
}

function g5core_template_metro_more($args) {
	if (isset($args['view_more'])) {
		$image_full_url  = '';
		$zoom_attributes = array();
		$image_full      = wp_get_attachment_image_src( $args['image_id'], 'full' );
		if ( is_array( $image_full ) && isset( $image_full[0] ) ) {
			$image_full_url = $image_full[0];
		}
		if (!empty($args['gallery_id'])) {
			$zoom_attributes[] = sprintf( 'data-gallery-id="%s"', esc_attr( $args['gallery_id'] ) );
		}
		$zoom_attributes[] = sprintf( 'href="%s"', esc_url( $image_full_url ) );
		?>
		<a data-g5core-mfp <?php echo join( ' ', $zoom_attributes ) ?>
		   class="g5core__metro-more text-white d-flex flex-column align-items-center justify-content-center card-img-overlay">
			<span class="g5core__metro-more-number"><?php echo sprintf( '+ %s', $args['view_more'] ) ?></span>
			<span class="g5core__metro-more-label"><?php esc_html_e( 'View More', 'g5-core' ) ?></span></a>
		<?php
	}
}