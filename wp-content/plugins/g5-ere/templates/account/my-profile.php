<?php
/**
 * Created by G5Theme.
 * User: trungpq
 * Date: 01/11/16
 * Time: 5:11 PM
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $current_user;
wp_get_current_user();
$user_id             = $current_user->ID;
$user_login          = $current_user->user_login;
$user_firstname      = get_the_author_meta( 'first_name', $user_id );
$user_lastname       = get_the_author_meta( 'last_name', $user_id );
$user_email          = get_the_author_meta( 'user_email', $user_id );
$user_mobile_number  = get_the_author_meta( ERE_METABOX_PREFIX . 'author_mobile_number', $user_id );
$user_fax_number     = get_the_author_meta( ERE_METABOX_PREFIX . 'author_fax_number', $user_id );
$user_company        = get_the_author_meta( ERE_METABOX_PREFIX . 'author_company', $user_id );
$user_licenses       = get_the_author_meta( ERE_METABOX_PREFIX . 'author_licenses', $user_id );
$user_office_number  = get_the_author_meta( ERE_METABOX_PREFIX . 'author_office_number', $user_id );
$user_office_address = get_the_author_meta( ERE_METABOX_PREFIX . 'author_office_address', $user_id );
$user_des            = get_the_author_meta( 'description', $user_id );
$user_facebook_url   = get_the_author_meta( ERE_METABOX_PREFIX . 'author_facebook_url', $user_id );
$user_twitter_url    = get_the_author_meta( ERE_METABOX_PREFIX . 'author_twitter_url', $user_id );
$user_linkedin_url   = get_the_author_meta( ERE_METABOX_PREFIX . 'author_linkedin_url', $user_id );
$user_pinterest_url  = get_the_author_meta( ERE_METABOX_PREFIX . 'author_pinterest_url', $user_id );
$user_instagram_url  = get_the_author_meta( ERE_METABOX_PREFIX . 'author_instagram_url', $user_id );
$user_youtube_url    = get_the_author_meta( ERE_METABOX_PREFIX . 'author_youtube_url', $user_id );
$user_vimeo_url      = get_the_author_meta( ERE_METABOX_PREFIX . 'author_vimeo_url', $user_id );
$user_skype          = get_the_author_meta( ERE_METABOX_PREFIX . 'author_skype', $user_id );
$user_website_url    = get_the_author_meta( 'user_url', $user_id );

$user_position       = get_the_author_meta( ERE_METABOX_PREFIX . 'author_position', $user_id );
$user_custom_picture = get_the_author_meta( ERE_METABOX_PREFIX . 'author_custom_picture', $user_id );
$author_picture_id   = get_the_author_meta( ERE_METABOX_PREFIX . 'author_picture_id', $user_id );
$no_avatar_src       = ERE_PLUGIN_URL . 'public/assets/images/profile-avatar.png';
$width               = get_option( 'thumbnail_size_w' );
$height              = get_option( 'thumbnail_size_h' );
$default_avatar      = ere_get_option( 'default_user_avatar', '' );
if ( $default_avatar != '' ) {
	if ( is_array( $default_avatar ) && $default_avatar['url'] != '' ) {
		$resize = ere_image_resize_url( $default_avatar['url'], $width, $height, true );
		if ( $resize != null && is_array( $resize ) ) {
			$no_avatar_src = $resize['url'];
		}
	}
}
$user_as_agent                       = ere_get_option( 'user_as_agent', 1 );
$enable_submit_property_via_frontend = ere_get_option( 'enable_submit_property_via_frontend', 1 );
$is_agent                            = ere_is_agent();
$is_agent_pending = ere_is_agent_pending();

wp_enqueue_script( 'plupload' );
wp_enqueue_script( G5ERE()->assets_handle( 'profile' ) );
$hide_user_info_fields = ere_get_option( 'hide_user_info_fields', array() );
if ( ! is_array( $hide_user_info_fields ) ) {
	$hide_user_info_fields = array();
}
?>
<div class="ere-my-profile">
    <div class="g5ere__profile-info-wrapper">
        <form action="#" class="ere-update-profile" novalidate>
			<?php
			if ( $enable_submit_property_via_frontend == 1 ) {
				$message = '';
				if ( ! $is_agent ) {
					if ( $user_as_agent == 1 ) {
						if ($is_agent_pending) {
							$message = esc_html__( 'Your account need to be approved by admin to become an agent, if you want to return to normal account, you must click the button below', 'essential-real-estate' );
						} else {
							$become_agent_terms_condition = ere_get_option( 'become_agent_terms_condition' );
							$message                      = sprintf( __( 'If you want to become an agent, please read our <a class="accent-color" target="_blank" href="%s">Terms & Conditions</a> first', 'essential-real-estate' ), get_permalink( $become_agent_terms_condition ) );
						}
					}

				} else {
					$message = esc_html__( 'Your current account type is set to agent, if you want to remove your agent account, and return to normal account, you must click the button below', 'essential-real-estate' );
				}
				if ( $is_agent || $is_agent_pending || $user_as_agent == 1 ):?>
                    <div class="card ere-account-agent mb-4">
                        <div class="card-body">
                            <h4><?php esc_html_e( 'Agent Account', 'g5-ere' ); ?></h4>

                            <p><?php echo wp_kses_post( $message ); ?></p>
							<?php if ( ! $is_agent && !$is_agent_pending ): ?>
								<?php wp_nonce_field( 'ere_become_agent_ajax_nonce', 'ere_security_become_agent' ); ?>
                                <button type="button" class="btn btn-primary"
                                        id="ere_user_as_agent"><?php esc_html_e( 'Become an Agent', 'g5-ere' ); ?></button>

							<?php else: ?>
								<?php wp_nonce_field( 'ere_leave_agent_ajax_nonce', 'ere_security_leave_agent' ); ?>
                                <button type="button" class="btn btn-primary"
                                        id="ere_leave_agent"><?php esc_html_e( 'Remove Agent Account', 'g5-ere' ); ?></button>
							<?php endif; ?>
                        </div>
                    </div>
				<?php endif;
			} ?>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-5 mb-6">
                                    <h3 class="card-title"><?php esc_html_e( 'Photo', 'g5-ere' ); ?></h3>
                                    <p class="card-text mb-4"><?php esc_html_e( 'Upload your profile photo.', 'g5-ere' ); ?></p>
                                </div>
                                <div class="col-sm-7 text-center ere-profile-avatar">
                                    <div id="user-profile-img" class="mb-3">
                                        <div class="profile-thumb mb-3">
											<?php
											if ( ! empty( $author_picture_id ) ) {
												$author_picture_id = intval( $author_picture_id );
												if ( $author_picture_id ) {
													$avatar_src = ere_image_resize_id( $author_picture_id, $width, $height, true );
													?>
                                                    <img width="<?php echo esc_attr( $width ) ?>"
                                                         height="<?php echo esc_attr( $height ) ?>" id="profile-image"
                                                         src="<?php echo esc_url( $avatar_src ); ?>"
                                                         onerror="this.src = '<?php echo esc_url( $no_avatar_src ) ?>';"
                                                         alt="<?php esc_attr_e( 'User Avatar', 'g5-ere' ) ?>">
                                                    <input type="hidden" class="profile-pic-id" id="profile-pic-id"
                                                           name="profile-pic-id"
                                                           value="<?php echo esc_attr( $author_picture_id ); ?>"/>
													<?php
												}
											} else {
												?>
                                                <img width="<?php echo esc_attr( $width ) ?>"
                                                     height="<?php echo esc_attr( $height ) ?>" id="profile-image"
                                                     src="<?php echo esc_url( $user_custom_picture ); ?>"
                                                     onerror="this.src = '<?php echo esc_url( $no_avatar_src ) ?>';"
                                                     alt="<?php esc_attr_e( 'User Avatar', 'g5-ere' ) ?>">
												<?php
											}
											?>
                                        </div>
                                    </div>

                                    <div class="profile-img-controls">
                                        <div id="errors_log"></div>
                                    </div>
                                    <div id="ere_profile_plupload_container">
                                        <button type="button" id="ere_select_profile_image"
                                                class="btn btn-primary"><?php esc_html_e( 'Update Profile Picture', 'g5-ere' ); ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body">
                            <h3 class="card-title"><?php
								esc_html_e( 'Contact information', 'g5-ere' ) ?></h3>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label
                                            for="user_firstname"><?php esc_html_e( 'First Name', 'g5-ere' ); ?></label>
                                    <input type="text" name="user_firstname" id="user_firstname" required
                                           class="form-control"
                                           value="<?php echo esc_attr( $user_firstname ); ?>">
                                    <div class="invalid-feedback"><?php esc_html_e( 'Please enter your first name!', 'g5-ere' ); ?></div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label
                                            for="user_lastname"><?php esc_html_e( 'Last Name', 'g5-ere' ); ?></label>
                                    <input type="text" name="user_lastname" id="user_lastname" required
                                           class="form-control"
                                           value="<?php echo esc_attr( $user_lastname ); ?>">
                                    <div class="invalid-feedback"><?php esc_html_e( 'Please enter your last name!', 'g5-ere' ); ?></div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label
                                            for="user_email"><?php esc_html_e( 'Email', 'g5-ere' ); ?></label>
                                    <input type="text" name="user_email" id="user_email" class="form-control"
                                           value="<?php echo esc_attr( $user_email ); ?>">
                                    <div class="invalid-feedback"><?php esc_html_e( 'Please enter your email!', 'g5-ere' ); ?></div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label
                                            for="user_mobile_number"><?php esc_html_e( 'Mobile', 'g5-ere' ); ?></label>
                                    <input type="text" id="user_mobile_number" name="user_mobile_number" required
                                           class="form-control"
                                           value="<?php echo esc_attr( $user_mobile_number ); ?>">
                                    <div class="invalid-feedback"><?php esc_html_e( 'Please enter your mobile number!', 'g5-ere' ); ?></div>
                                </div>
								<?php if ( ere_is_agent() ): ?>
									<?php if ( ! in_array( "user_company", $hide_user_info_fields ) ): ?>
                                        <div class="col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label
                                                        for="user_company"><?php esc_html_e( 'Company', 'g5-ere' ); ?></label>
                                                <input type="text" id="user_company" name="user_company"
                                                       class="form-control"
                                                       value="<?php echo esc_attr( $user_company ); ?>">
                                            </div>
                                        </div>
									<?php endif; ?>
									<?php if ( ! in_array( "user_position", $hide_user_info_fields ) ): ?>
                                        <div class="col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label
                                                        for="user_position"><?php esc_html_e( 'Position', 'g5-ere' ); ?></label>
                                                <input type="text" id="user_position" name="user_position"
                                                       value="<?php echo esc_attr( $user_position ); ?>"
                                                       class="form-control">
                                            </div>
                                        </div>
									<?php endif; ?>
									<?php if ( ! in_array( "user_office_number", $hide_user_info_fields ) ): ?>
                                        <div class="col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label
                                                        for="user_office_number"><?php esc_html_e( 'Office Number', 'g5-ere' ); ?></label>
                                                <input type="text" id="user_office_number" name="user_office_number"
                                                       class="form-control"
                                                       value="<?php echo esc_attr( $user_office_number ); ?>">
                                            </div>
                                        </div>
									<?php endif; ?>
									<?php if ( ! in_array( "user_office_address", $hide_user_info_fields ) ): ?>
                                        <div class="col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label
                                                        for="user_office_address"><?php esc_html_e( 'Office Address', 'g5-ere' ); ?></label>
                                                <input type="text" id="user_office_address" name="user_office_address"
                                                       class="form-control"
                                                       value="<?php echo esc_attr( $user_office_address ); ?>">
                                            </div>
                                        </div>
									<?php endif; ?>
									<?php if ( ! in_array( "user_licenses", $hide_user_info_fields ) ): ?>
                                        <div class="col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label
                                                        for="user_licenses"><?php esc_html_e( 'Licenses', 'g5-ere' ); ?></label>
                                                <input type="text" id="user_licenses" name="user_licenses"
                                                       class="form-control"
                                                       value="<?php echo esc_attr( $user_licenses ); ?>">
                                            </div>
                                        </div>
									<?php endif; ?>
								<?php endif; ?>
								<?php if ( ! in_array( "user_fax_number", $hide_user_info_fields ) ): ?>
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label
                                                    for="user_fax_number"><?php esc_html_e( 'Fax', 'g5-ere' ); ?></label>
                                            <input type="text" id="user_fax_number" name="user_fax_number"
                                                   class="form-control"
                                                   value="<?php echo esc_attr( $user_fax_number ); ?>">
                                        </div>
                                    </div>
								<?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title"><?php
								esc_html_e( 'User detail', 'g5-ere' ) ?></h3>
                            <div class="row">
								<?php if ( ! in_array( "user_website_url", $hide_user_info_fields ) ): ?>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label
                                                    for="user_website_url"><?php esc_html_e( 'Website URL', 'g5-ere' ); ?></label>
                                            <input type="text" id="user_website_url" name="user_website_url"
                                                   class="form-control"
                                                   value="<?php echo esc_url( $user_website_url ); ?>">
                                        </div>
                                    </div>
								<?php endif; ?>
								<?php if ( ! in_array( "user_skype", $hide_user_info_fields ) ): ?>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label
                                                    for="user_skype"><?php esc_html_e( 'Skype', 'g5-ere' ); ?></label>
                                            <input type="text" id="user_skype" name="user_skype" class="form-control"
                                                   value="<?php echo esc_attr( $user_skype ); ?>">
                                        </div>
                                    </div>
								<?php endif; ?>
								<?php if ( ! in_array( "user_facebook_url", $hide_user_info_fields ) ): ?>
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label
                                                    for="user_facebook_url"><?php esc_html_e( 'Facebook URL', 'g5-ere' ); ?></label>
                                            <input type="text" id="user_facebook_url" name="user_facebook_url"
                                                   value="<?php echo esc_attr( $user_facebook_url ); ?>"
                                                   class="form-control">
                                        </div>
                                    </div>
								<?php endif; ?>
								<?php if ( ! in_array( "user_twitter_url", $hide_user_info_fields ) ): ?>
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label
                                                    for="user_twitter_url"><?php esc_html_e( 'Twitter URL', 'g5-ere' ); ?></label>
                                            <input type="text" id="user_twitter_url" name="user_twitter_url"
                                                   class="form-control"
                                                   value="<?php echo esc_attr( $user_twitter_url ); ?>">
                                        </div>
                                    </div>
								<?php endif; ?>
								<?php if ( ! in_array( "user_linkedin_url", $hide_user_info_fields ) ): ?>
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label
                                                    for="user_linkedin_url"><?php esc_html_e( 'Linkedin URL', 'g5-ere' ); ?></label>
                                            <input type="text" id="user_linkedin_url" name="user_linkedin_url"
                                                   class="form-control"
                                                   value="<?php echo esc_attr( $user_linkedin_url ); ?>">
                                        </div>
                                    </div>
								<?php endif; ?>
								<?php if ( ! in_array( "user_instagram_url", $hide_user_info_fields ) ): ?>
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label
                                                    for="user_instagram_url"><?php esc_html_e( 'Instagram URL', 'g5-ere' ); ?></label>
                                            <input type="text" id="user_instagram_url" name="user_instagram_url"
                                                   class="form-control"
                                                   value="<?php echo esc_attr( $user_instagram_url ); ?>">
                                        </div>
                                    </div>
								<?php endif; ?>
								<?php if ( ! in_array( "user_pinterest_url", $hide_user_info_fields ) ): ?>
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label
                                                    for="user_pinterest_url"><?php esc_html_e( 'Pinterest URL', 'g5-ere' ); ?></label>
                                            <input type="text" id="user_pinterest_url" name="user_pinterest_url"
                                                   class="form-control"
                                                   value="<?php echo esc_attr( $user_pinterest_url ); ?>">
                                        </div>
                                    </div>
								<?php endif; ?>
								<?php if ( ! in_array( "user_youtube_url", $hide_user_info_fields ) ): ?>
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label
                                                    for="user_youtube_url"><?php esc_html_e( 'Youtube URL', 'g5-ere' ); ?></label>
                                            <input type="text" id="user_youtube_url" name="user_youtube_url"
                                                   class="form-control"
                                                   value="<?php echo esc_attr( $user_youtube_url ); ?>">
                                        </div>
                                    </div>
								<?php endif; ?>
								<?php if ( ! in_array( "user_vimeo_url", $hide_user_info_fields ) ): ?>
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label
                                                    for="user_vimeo_url"><?php esc_html_e( 'Vimeo URL', 'g5-ere' ); ?></label>
                                            <input type="text" id="user_vimeo_url" name="user_vimeo_url"
                                                   class="form-control"
                                                   value="<?php echo esc_attr( $user_vimeo_url ); ?>">
                                        </div>
                                    </div>
								<?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-5">
                <div class="card-body">
                    <h3 class="card-title"><?php
						esc_html_e( 'User detail', 'g5-ere' ) ?></h3>
                    <div class="form-group mb-0">
                        <label for="user_des"><?php esc_html_e( 'About me', 'g5-ere' ); ?></label>
                        <textarea id="user_des" name="user_des" class="form-control"
                                  rows="5"><?php echo esc_attr( $user_des ); ?></textarea>
                    </div>
                </div>
            </div>
            <div class="mb-5">
				<?php wp_nonce_field( 'ere_update_profile_ajax_nonce', 'ere_security_update_profile' ); ?>
                <button type="button" class="btn btn-primary" id="ere_update_profile"><?php
					esc_html_e( 'Update Profile', 'g5-ere' ) ?>
                </button>
            </div>
        </form>
    </div>

    <div class="card g5ere__profile-password-wrapper">
        <div class="card-body">
            <h3 class="card-title"><?php
				esc_html_e( 'Change password', 'g5-ere' ) ?></h3>
            <form action="#" class="ere-change-password" novalidate>
                <div id="password_reset_msgs" class="ere_messages message"></div>
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label
                                    for="oldpass"><?php esc_html_e( 'Old Password', 'g5-ere' ); ?></label>
                            <input id="oldpass" value="" class="form-control" name="oldpass" required
                                   type="password">
                            <div class="invalid-feedback"><?php esc_html_e( 'Please enter your old password!', 'g5-ere' ); ?></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label
                                    for="newpass"><?php esc_html_e( 'New Password ', 'g5-ere' ); ?></label>
                            <input id="newpass" value="" class="form-control" name="newpass" required
                                   type="password">
                            <div class="invalid-feedback"><?php esc_html_e( 'Please enter your new password!', 'g5-ere' ); ?></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label
                                    for="confirmpass"><?php esc_html_e( 'Confirm Password', 'g5-ere' ); ?></label>
                            <input id="confirmpass" value="" class="form-control" name="confirmpass" required
                                   type="password">
                            <div class="invalid-feedback"><?php esc_html_e( 'Please enter confirm password!', 'g5-ere' ); ?></div>
                        </div>
                    </div>

                </div>
				<?php wp_nonce_field( 'ere_change_password_ajax_nonce', 'ere_security_change_password' ); ?>
                <button type="button" class="btn btn-primary display-block"
                        id="ere_change_pass"><?php esc_html_e( 'Update Password', 'g5-ere' ); ?></button>
            </form>
        </div>
    </div>
</div>


