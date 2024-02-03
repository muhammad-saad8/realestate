<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<script id="g5ere__message_template" type="text/template">
	<div class="g5ere__message alert alert-{{type}} alert-dismissible fade show" role="alert">
		{{message}}
		<a href="#" class="close" data-dismiss="alert" aria-label="<?php echo esc_attr__('Close','g5-ere')?>">
			<span aria-hidden="true">&times;</span>
		</a>
	</div>
</script>
