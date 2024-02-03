<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! class_exists( 'G5ERE_Widget_Contact_Agent' ) ) {
	class G5ERE_Widget_Contact_Agent extends GSF_Widget {
		public function __construct() {
			$this->widget_cssclass    = 'g5ere__widget-contact-agent';
			$this->widget_id          = 'g5ere_widget_contact_agent';
			$this->widget_name        = esc_html__( 'G5Plus: Contact Agent', 'g5-ere' );
			$this->widget_description = esc_html__( 'Display a contact agent form', 'g5-ere' );
			$this->settings           = array(
				'fields' => array(
					array(
						'id'      => 'contact_layout',
						'title'   => esc_html__( 'Layout', 'g5-ere' ),
						'type'    => 'image_set',
						'options' => G5ERE()->settings()->get_property_contact_layout(),
						'default' => 'layout-01'
					),
				)
			);
			parent::__construct();
		}

		function widget( $args, $instance ) {
			if ( $this->get_cached_widget( $instance ) ) {
				return;
			}
			if (!is_singular('property') && !is_singular('agent')) {
				return;
			}

			$agent_info = false;
			if (is_singular('property')) {
				$agent_info       = g5ere_get_agent_info_by_property();
			} elseif (is_singular('agent')) {
				$agent_info = g5ere_get_agent_info_by_id();
			}
			if ($agent_info === false) {
				return;
			}
			extract( $args, EXTR_SKIP );
			$layout = ( ! empty( $instance['contact_layout'] ) ) ? $instance['contact_layout'] : 'layout-01';
			ob_start();
			$this->widget_start( $args, $instance );
			$hide_contact_information_if_not_login = absint(ere_get_option( 'hide_contact_information_if_not_login', 0 )) ;
			if (is_singular('property') && ($hide_contact_information_if_not_login === 1) && !is_user_logged_in()) {
				G5ERE()->get_template( 'global/contact-not-login.php' );
			} else {
				G5ERE()->get_template( 'widgets/contact-agent.php', array( 'layout' => $layout, 'agent_info' => $agent_info ) );
			}
			$this->widget_end( $args );
			echo $this->cache_widget( $instance, ob_get_clean() ); // WPCS: XSS ok.
		}
	}
}