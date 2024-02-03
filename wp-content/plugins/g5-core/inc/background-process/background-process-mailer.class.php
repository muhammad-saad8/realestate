<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'G5Core_Background_Process', false ) ) {
	G5CORE()->load_file(G5CORE()->plugin_dir('inc/background-process/background-process.class.php'));
}

class G5Core_Background_Process_Mailer extends G5Core_Background_Process {
	/**
	 * Initiate new background process.
	 */
	public function __construct() {
		// Uses unique prefix per blog so each blog has separate queue.
		$this->prefix = 'wp_' . get_current_blog_id();
		$this->action = 'g5core_mailer';

		// This is needed to prevent timeouts due to threading. See https://core.trac.wordpress.org/ticket/36534.
		//@putenv( 'MAGICK_THREAD_LIMIT=1' ); // @codingStandardsIgnoreLine.
		add_action( 'shutdown', array( $this, 'dispatch_queue' ), 1000 );

		parent::__construct();
	}

	/**
	 * Is job running?
	 *
	 * @return boolean
	 */
	public function is_running() {
		return !$this->is_queue_empty();
	}

	protected function batch_limit_exceeded() {
		return true;
	}

	protected function task( $item ) {
		if ( is_array($item) && isset($item['user_email']) && isset($item['subject']) && isset($item['message'])) {
			try {
				G5CORE()->email()->send_email( $item['user_email'], $item['subject'], $item['message'], isset($item['header']) ? $item['header'] : '' );
			}
			catch ( Exception $e ) {}
		}

		if (is_array($item) && isset($item['user_id'])) {
			wp_new_user_notification($item['user_id'], null, 'both');
		}
		return false;
	}

	public function dispatch_queue() {
		if ( ! empty( $this->data ) ) {
			$this->save()->dispatch();
		}
	}

}