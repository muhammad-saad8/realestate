<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! class_exists( 'G5ERE_Widget_Agent_Info' ) ) {
	class G5ERE_Widget_Agent_Info extends GSF_Widget {
		public function __construct() {
			$this->widget_cssclass    = 'g5ere__widget-agent-info';
			$this->widget_id          = 'g5ere_widget_agent_info';
			$this->widget_name        = esc_html__( 'G5Plus: Agent Info', 'g5-ere' );
			$this->widget_description = esc_html__( 'Display agent information', 'g5-ere' );
			$this->settings           = array(
				'fields' => array(
					array(
						'id'      => 'layout',
						'title'   => esc_html__( 'Layout', 'g5-ere' ),
						'type'    => 'select',
						'options' => G5ERE()->settings()->get_widget_agent_info_layout(),
						'default' => 'layout-01'
					)
				)
			);
			parent::__construct();
		}
		function widget( $args, $instance ) {
			if ( $this->get_cached_widget( $instance ) ) {
				return;
			}
			if (!is_singular('agent')) {
				return;
			}

			extract( $args, EXTR_SKIP );
			$layout = ( ! empty( $instance['layout'] ) ) ? $instance['layout'] : 'layout-01';
			ob_start();
			$this->widget_start( $args, $instance );
			G5ERE()->get_template( "widgets/agent-info/{$layout}.php" );
			$this->widget_end( $args );
			echo $this->cache_widget( $instance, ob_get_clean() ); // WPCS: XSS ok.
		}
	}
}