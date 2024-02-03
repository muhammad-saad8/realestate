<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * Shortcode attributes
 * @var $atts
 * @var $el_id
 * @var $el_class
 * @var $animation_style
 * @var $animation_duration
 * @var $animation_delay
 * @var $css_editor
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_G5Element_Property_Search_Form
 */

$el_id = $el_class =
$animation_style = $animation_duration = $animation_delay = $css_editor = $responsive = '';
$atts  = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$wrapper_classes    = array(
	'g5element__agency-search',
	'g5ere__search-form',
	$this->getExtraClass( $el_class ),
	$this->getCSSAnimation( $css_animation ),
	vc_shortcode_custom_css_class( $css )
);
$class_to_filter    = implode( ' ', array_filter( $wrapper_classes ) );
$css_class          = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->getShortcode(), $atts );
$wrapper_attributes = array();
if ( ! empty( $el_id ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}
$keyword       = isset( $_REQUEST['key_word'] ) ? $_REQUEST['key_word'] : '';
$agency_page   = g5ere_get_agency_page();
$search_fields = array(
	'keyword',
	'submit-button',
);
$prefix        = uniqid();
?>
<div class="<?php echo esc_attr( $css_class ) ?>" <?php echo implode( ' ', $wrapper_attributes ) ?>>
    <form method="get" autocomplete="off" action="<?php echo esc_url( get_page_link( $agency_page ) ); ?>">
        <div class="form-inline">
			<?php
			foreach ( $search_fields as $k => $v ) {
				G5ERE()->get_template( "agency/search-fields/{$v}.php", array( 'prefix' => $prefix ) );
			}
			?>
        </div>
	    <?php g5ere_query_string_form_fields( null, array(
		    'orderby',
		    'submit',
		    'paged',
		    'key_word'
	    ) ); ?>
    </form>
</div>

