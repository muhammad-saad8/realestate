<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

?>

<a class="g5ere__btn-my-favourite position-relative" title="<?php  esc_attr_e( 'My Favourite','g5-ere' ) ?>"
   href="<?php echo esc_url( ere_get_permalink( 'my_favorites' ) ) ?>">
    <i class="fal fa-heart"></i>
	<?php if ( is_user_logged_in() ):
		$ere_property = new ERE_Property();
		$total_favorite = $ere_property->get_total_favorite();
		?>
        <span class="badge position-absolute"><?php echo esc_html( $total_favorite ) ?></span>
	<?php endif; ?>
</a>