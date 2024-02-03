<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * @var $isRTL
 * @var $property_id
 */
$the_post = get_post( $property_id );
if ( $the_post->post_type != 'property' ) {
	esc_html_e( 'Posts ineligible to print!', 'g5-ere' );

	return;
}
wp_enqueue_script( 'jquery' );
wp_add_inline_script( 'jquery', 'jQuery(window).load(function(){ print(); });' );
wp_enqueue_style( ERE_PLUGIN_PREFIX . 'property-print' );

if ( $isRTL == 'true' ) {
	wp_enqueue_style( ERE_PLUGIN_PREFIX . 'property-print-rtl' );
}

// Actions
remove_action( 'wp_head', '_wp_render_title_tag', 1 );
remove_action( 'wp_head', 'wp_resource_hints', 2 );
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );
remove_action( 'publish_future_post', 'check_and_publish_future_post', 10 );
remove_action( 'wp_head', 'noindex', 1 );
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'rel_canonical' );
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10 );
remove_action( 'wp_head', 'wp_custom_css_cb', 101 );
remove_action( 'wp_head', 'wp_site_icon', 99 );

add_action( 'wp_enqueue_scripts', 'ere_dequeue_assets_print_property', 9999 );
function ere_dequeue_assets_print_property() {
	foreach ( wp_styles()->registered as $k => $v ) {
		if ( ! in_array( $k, array(
			'bootstrap',
			'font-awesome',
			G5ERE()->assets_handle( 'property-print' ),
			ERE_PLUGIN_PREFIX . 'property-print-rtl'
		) ) ) {
			unset( wp_styles()->registered[ $k ] );
		}
	}
}

$print_logo = ere_get_option( 'print_logo', '' );
$attach_id  = '';
$image_src  = '';
if ( is_array( $print_logo ) && count( $print_logo ) > 0 ) {
	$attach_id = $print_logo['id'];
}
$image_size = ere_get_option( 'print_logo_size', '200x100' );
$width      = '';
$height     = '';
if ( $attach_id ) {
	if ( preg_match( '/\d+x\d+/', $image_size ) ) {
		$image_sizes = explode( 'x', $image_size );
		$image_src   = ere_image_resize_id( $attach_id, $image_sizes[0], $image_sizes[1], true );
	} else {
		if ( ! in_array( $image_size, array( 'full', 'thumbnail' ) ) ) {
			$image_size = 'full';
		}
		$image_src = wp_get_attachment_image_src( $attach_id, $image_size );
		if ( $image_src && ! empty( $image_src[0] ) ) {
			$image_src = $image_src[0];
		}
	}
}

if (empty($image_src) && is_array($print_logo) && isset($print_logo['url'])) {
	$image_src = $print_logo['url'];
}

if ( ! empty( $image_src ) ) {
	list( $width, $height ) = getimagesize( $image_src );
}
$page_name        = get_bloginfo( 'name', '' );
$blocks_arr       = array(
	'featured-image' => '',
	'contact-agent'  => esc_html__( 'Contact Agent', 'g5-ere' ),
	'description'    => esc_html__( 'Description', 'g5-ere' ),
	'overview'       => esc_html__( 'Overview', 'g5-ere' ),
	'details'        => esc_html__( 'Details', 'g5-ere' ),
	'features'       => esc_html__( 'Features', 'g5-ere' ),
	'floors'         => esc_html__( 'Floor Plans', 'g5-ere' ),
	'images'         => esc_html__( 'Images', 'g5-ere' ),

);
$price            = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'property_price', true );
$price_short      = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'property_price_short', true );
$price_unit       = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'property_price_unit', true );
$price_prefix     = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'property_price_prefix', true );
$price_postfix    = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'property_price_postfix', true );
$property_address = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'property_address', true );

?>
<html <?php language_attributes(); ?>>
<head>
	<?php wp_head(); ?>
</head>
<body>
    <div id="property-print-wrap">
        <div class="property-print-inner">
			<?php if ( ! empty( $image_src ) ): ?>
                <div class="home-page-info text-center">
                    <img src="<?php echo esc_url( $image_src ) ?>" alt="<?php echo esc_attr( $page_name ) ?>"
                         width="<?php echo esc_attr( $width ) ?>" height="<?php echo esc_attr( $height ) ?>">
                </div>
			<?php endif; ?>
            <div class="property-print-title">
				<?php do_action( 'g5ere_property_print_header', array(
					'property_id' => $property_id,
					'post'        => $property_id
				) ) ?>
            </div>
            <div class="property-main-info">
				<?php foreach ( $blocks_arr as $k => $v ):
					G5ERE()->get_template( 'single-property/print/' . $k . '.php', array(
						'property_id' => $property_id,
					) );
				endforeach; ?>
            </div>
        </div>
    </div>
	<?php GSF()->helper()->getTemplate( 'core/icons-popup/templates/icons-svg.tpl' ); ?>
    <script>jQuery(document).ready(function () {
		    jQuery('.svg-icon').each(function () {
			    var $this = jQuery(this),
				    _class = $this.attr('class'),
				    id = _class.replace('svg-icon svg-icon-',''),
				    _html = '<svg class="' + _class + '" aria-hidden="true" role="img"> <use href="#'+ id +'" xlink:href="#'+ id +'"></use> </svg>';
			    $this.html(_html);
		    });
	    });</script>
</body>
</html>
