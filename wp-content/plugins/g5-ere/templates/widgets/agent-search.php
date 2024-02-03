<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $prefix
 */
$wrapper_classes = array(
	'g5ere__search-form',
	'g5ere__search-form-widget'
);
$wrapper_class = implode(' ', $wrapper_classes);
$search_fields = array(
	'agency',
	'keyword',
	'submit-button',
)
?>
<div class="<?php echo esc_attr( $wrapper_class ) ?>">
	<form method="get" autocomplete="off" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<?php
		foreach ( $search_fields as $k => $v ) {
			G5ERE()->get_template( "agent/search-fields/{$v}.php" ,array('prefix' => $prefix));
		}
		?>
		<input type="hidden" name="post_type" value="agent">
		<?php g5ere_query_string_form_fields( null, array(
			'orderby',
			'submit',
			'paged',
			'company',
			'q',
			'post_type',
			's'
		) ); ?>
	</form>
</div>