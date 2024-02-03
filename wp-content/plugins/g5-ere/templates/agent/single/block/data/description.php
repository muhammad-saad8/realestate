<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$agent_description = apply_filters('ere_description',get_post_meta(get_the_ID(), ERE_METABOX_PREFIX . 'agent_description', true)) ;
if(is_author()){
	global $wp_query;
	$curauth              = $wp_query->get_queried_object();
	$agent_description=$curauth->description;
}
echo wp_kses_post($agent_description);