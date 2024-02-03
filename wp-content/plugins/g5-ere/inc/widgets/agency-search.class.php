<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! class_exists( 'G5ERE_Widget_Agency_Search' ) ) {
	class G5ERE_Widget_Agency_Search extends GSF_Widget {
		public function __construct() {
			$this->widget_cssclass    = 'g5ere__widget-agency-search';
			$this->widget_id          = 'g5ere_widget_agency_search';
			$this->widget_name        = esc_html__( 'G5Plus: Agency Search', 'g5-ere' );
			$this->widget_description = esc_html__( 'Display an agency search form', 'g5-ere' );
			$this->settings           = array(
				'fields' => array(
					array(
						'id'      => 'title',
						'title'   => esc_html__( 'Title', 'g5-ere' ),
						'type'    => 'text',
						'default' => esc_html__( 'Agency Search', 'g5-ere' ),
					),
				)
			);
			parent::__construct();
		}

		function widget( $args, $instance ) {
			if ( $this->get_cached_widget( $instance ) ) {
				return;
			}
			extract( $args, EXTR_SKIP );
			ob_start();
			$this->widget_start( $args, $instance );
			G5ERE()->get_template( 'widgets/agency-search.php' );
			$this->widget_end( $args );
			echo $this->cache_widget( $instance, ob_get_clean() ); // WPCS: XSS ok.
		}
	}
}