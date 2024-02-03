<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! class_exists( 'G5ERE_Widget_Contact_Agency' ) ) {
	class G5ERE_Widget_Contact_Agency extends GSF_Widget {
		public function __construct() {
			$this->widget_cssclass    = 'g5ere__widget-contact-agency';
			$this->widget_id          = 'g5ere_widget_contact_agency';
			$this->widget_name        = esc_html__( 'G5Plus: Contact Agency', 'g5-ere' );
			$this->widget_description = esc_html__( 'Display a contact agency form', 'g5-ere' );
			$this->settings           = array(
				'fields' => array(
					array(
						'id'      => 'contact_layout',
						'title'   => esc_html__( 'Contact Agency Layout', 'g5-ere' ),
						'type'    => 'image_set',
						'options' => G5ERE()->settings()->get_contact_agency_layout(),
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

			if (!g5ere_is_single_agency()) {
				return;
			}

			extract( $args, EXTR_SKIP );
			$layout = ( ! empty( $instance['contact_layout'] ) ) ? $instance['contact_layout'] : 'layout-01';
			ob_start();
			$this->widget_start( $args, $instance );
			G5ERE()->get_template( 'widgets/contact-agency.php', array( 'layout' => $layout ) );
			$this->widget_end( $args );
			echo $this->cache_widget( $instance, ob_get_clean() ); // WPCS: XSS ok.
		}
	}
}