<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}
/**
 * @var $sorting array
 * @var $orderby
 */
?>
<form class="g5ere__ordering" method="get">
	<select name="orderby" class="g5ere__orderby selectpicker" data-live-search="true">
		<?php foreach ($sorting as $id => $name ) : ?>
			<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
		<?php endforeach; ?>
	</select>
	<input type="hidden" name="paged" value="1" />
	<?php g5ere_query_string_form_fields( null, array( 'orderby', 'submit', 'paged') ); ?>
</form>
