<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if (!class_exists('ERE_Shortcode_Property')) {
	/**
	 * Class ERE_Shortcode_Package
	 */
	class ERE_Shortcode_Property
	{
		/**
		 * Package shortcode
		 */
		public static function output( $atts )
		{
            wp_enqueue_style(ERE_PLUGIN_PREFIX . 'property');
            wp_enqueue_script(ERE_PLUGIN_PREFIX . 'owl_carousel');
			return ere_get_template_html('shortcodes/property/property.php', array('atts' => $atts));
		}
	}
}