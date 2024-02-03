<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
if ( ! class_exists( 'G5Core_Background_Process_Mailer', false ) ) {
	G5CORE()->load_file(G5CORE()->plugin_dir('inc/background-process/background-process-mailer.class.php'));
}

if (!class_exists('G5Core_Email')) {
	class G5Core_Email {
		private static $_instance;

		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * @var G5Core_Background_Process_Mailer
		 */
		public static $_background_mailer = null;

		public function init() {
			self::$_background_mailer = new G5Core_Background_Process_Mailer();
		}


		public function replace_email_template($content, $replaces) {
			foreach ($replaces as $key => $value) {
				$content = str_replace("{{$key}}", $value, $content);
			}
			return $content;
		}

		public function send_email($user_email, $subject, $message, $header = '') {
			if (!wp_mail( $user_email, wp_specialchars_decode( $subject ), $message, $header )) {
				return false;
			}
			return true;
		}

		public function background_send_mail($user_email, $subject, $message, $header = '') {
			self::$_background_mailer->data(array(
				array(
					'user_email' => $user_email,
					'subject' => $subject,
					'message' => $message,
					'header' => $header
				)
			))->save()->dispatch();
		}

		public function background_new_user_send_mail($user_id) {
			self::$_background_mailer->data(array(
				array(
					'user_id' => $user_id,
				)
			))->save()->dispatch();
		}
	}
}