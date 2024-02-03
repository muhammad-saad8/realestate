<?php
/**
 * Class Ajax
 *
 */
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}
if (!class_exists('G5Core_Ajax')) {
	class G5Core_Ajax
	{
		private static $_instance;
		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function init() {
			add_action('wp_ajax_nopriv_g5core_search', array($this,'search_result'));
			add_action('wp_ajax_g5core_search', array($this,'search_result'));

			add_action('wp_ajax_nopriv_g5core-login', array($this,'login'));
			add_action('wp_ajax_g5core-login', array($this,'login'));

			add_action('wp_ajax_nopriv_g5core-register', array($this,'register'));
			add_action('wp_ajax_g5core-register', array($this,'register'));

			add_action('wp_ajax_nopriv_g5core-recovery-password', array($this,'recovery_password'));
			add_action('wp_ajax_g5core-recovery-password', array($this,'recovery_password'));

            /**
             * Load Posts
             * *******************************************************
             */
            add_action('wp_ajax_nopriv_pagination_ajax', array($this,'pagination_ajax_response'));
            add_action('wp_ajax_pagination_ajax', array($this,'pagination_ajax_response'));

			if (class_exists('WPBMap')) {
				add_action( 'wp_ajax_nopriv_pagination_ajax', array('WPBMap', 'addAllMappedShortcodes'),1);
				add_action( 'wp_ajax_pagination_ajax', array('WPBMap', 'addAllMappedShortcodes'),1);
			}

		}

		/**
		 * Search Result
		 */
		public function search_result()
		{
            check_ajax_referer('g5core_search','_g5core_search_nonce');
			global $wpdb;
			$keyword = isset($_REQUEST['s']) ? $_REQUEST['s'] : '';
			if (empty($keyword)) {
				wp_send_json_error();
			}

			$keyword = $wpdb->esc_like($keyword);
			$search_popup_post_type = G5CORE()->options()->get_option('search_post_types');
			$search_popup_result_amount = G5CORE()->options()->get_option('search_popup_result_amount');
			if (empty($search_popup_result_amount)) {
				$search_popup_result_amount = 8;
			}

			$args = array(
				's' => $keyword,
				'post_status' => 'publish',
				'ignore_sticky_posts' => true,
				'orderby' => 'date',
				'order' => 'DESC',
				'posts_per_page' => $search_popup_result_amount
			);
			if (is_array($search_popup_post_type) && !in_array('all', $search_popup_post_type)) {
				$args['post_type'] = $search_popup_post_type;
			}

            $args = apply_filters('g5core_search_args',$args);

			$query = new WP_Query($args);
			?>
			<ul>
				<?php if ($query->have_posts()): ?>
					<?php
					while ($query->have_posts()) {
						$query->the_post();
						G5CORE()->get_template('header/customize/search-item.php');
					}
					?>
				<?php else: ?>
					<li class="nothing"><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with different keywords.', 'g5-core'); ?></li>
				<?php endif; ?>
			</ul>
			<?php
			wp_reset_postdata();
			wp_die();
		}

		/**
		 * Login Popup
		 */
		public function login() {
			check_ajax_referer('g5core_login_nonce','g5core_login_nonce');
			$user = wp_signon();
			if (is_wp_error($user)) {
				wp_send_json_error(esc_html__('User or password incorrect!','g5-core'));
			} else {
				wp_send_json_success(esc_html__('Login your account success!','g5-core'));
			}
			die();
		}

		/**
		 * Register Popup
		 */
		public function register() {
			check_ajax_referer('g5core_register_nonce','g5core_register_nonce');
			$users_can_register = get_option('users_can_register');
			if (empty($users_can_register) ) {
				wp_send_json_error(esc_html__('Don\'t create account','g5-core'));
				die();
			}

			$user_name = isset($_POST['user_register']) ? $_POST['user_register'] : '';
			$user_email = isset($_POST['user_email']) ? $_POST['user_email'] : '';
			if (empty($user_name)
			    || empty($user_email)
			    || !is_email($user_email)) {
				wp_send_json_error(esc_html__('Email or username incorrect!','g5-core'));
				die();
			}

			if (username_exists($user_name) || email_exists($user_email)) {
				wp_send_json_error(esc_html__('User or email already exists!','g5-core'));
				die();
			}

			$user_password = wp_generate_password(12,false,false);
			$user = wp_create_user($user_name, $user_password, $user_email);
			if (is_wp_error($user)) {
				wp_send_json_error(esc_html__('User could not be created','g5-core'));
			} else {
				G5CORE()->email()->background_new_user_send_mail($user);

				wp_send_json_success(esc_html__('Please check your email (index or spam folder), the password was sent there.','g5-core'));
			}

			die();
		}

		/**
		 * Recovery Password Popup
		 */
		public function recovery_password() {
			check_ajax_referer('g5core_recovery_password_nonce','g5core_recovery_password_nonce');
			$user_login = isset($_POST['user_recovery']) ? $_POST['user_recovery'] : '';

			if (empty($user_login)) {
				wp_send_json_error(esc_html__('User or email incorrect!','g5-core'));
				die();
			}


			if (is_email($user_login)) {
				$user_data = get_user_by( 'email', trim( $user_login ) );

			} else {
				$user_data = get_user_by('login', $user_login);
			}

			if (!$user_data) {
				wp_send_json_error(esc_html__('User or email not found!','g5-core'));
				die();
			}

			$user_login = $user_data->user_login;
			$user_email = $user_data->user_email;
			$key = get_password_reset_key( $user_data );

			if (is_wp_error($key)) {
				wp_send_json_error(esc_html__('Password reset key on fail','g5-core'));
				die();
			}

			$message = esc_html__('Someone has requested a password reset for the following account:', 'g5-core' ) . "\r\n\r\n";
			$message .= network_home_url( '/' ) . "\r\n\r\n";
			$message .= sprintf(esc_html__('Username: %s', 'g5-core'), $user_login) . "\r\n\r\n";
			$message .= esc_html__('If this was a mistake, just ignore this email and nothing will happen.', 'g5-core') . "\r\n\r\n";
			$message .= esc_html__('To reset your password, visit the following address:', 'g5-core') . "\r\n\r\n";
			$message .= '<' . network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . ">\r\n";


			$title = sprintf( esc_html__('[%s] Password Reset', 'g5-core'), g5core_site_name() );
			$title = apply_filters( 'retrieve_password_title', $title, $user_login, $user_data );

			$message = apply_filters( 'g5plus_magpro_retrieve_password_message', $message, $key, $user_login, $user_data );

			G5CORE()->email()->background_send_mail($user_email, $title, $message);

			wp_send_json_success(esc_html__('Your password is reset, check your email.','g5-core'));
			die();
		}

		public function pagination_ajax_response() {
            ob_start();
            $query_args = isset($_REQUEST['query']) ? $_REQUEST['query'] : array();
            $settings = isset($_REQUEST['settings']) ? $_REQUEST['settings'] : array();
            $postType = isset($settings['post_type']) ? $settings['post_type'] : 'post';
            $query_args = G5CORE()->query()->parse_ajax_query($query_args);
            do_action('g5core_' . $postType . '_pagination_ajax_response',$settings,$query_args);
            echo ob_get_clean();
            wp_die();
        }
	}
}