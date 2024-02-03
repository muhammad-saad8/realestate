<?php
add_action('vc_after_init', 'g5element_custom_vc_progress_bar_add_param');
function g5element_custom_vc_progress_bar_add_param()
{
	$vc_progress_bar = WPBMap::getShortCode('vc_progress_bar');
	$vc_progress_bar_params = $vc_progress_bar['params'];
	$index = 100;
	$background_overlay_index = 0;
	foreach ($vc_progress_bar_params as $key => $param) {
		$param['weight'] = $index;
		if ($param['param_name'] == 'bgcolor') {
			$background_overlay_index = $index - 1;
			$index = $index - 1;
		}
		vc_update_shortcode_param('vc_progress_bar', $param);
		$index--;
	}

	$child_params = WPBMap::getParam('vc_progress_bar', 'values');
	foreach ( $child_params['params'] as $key => $param ) {
		if (isset($param['param_name']) && ($param['param_name'] === 'color')) {
			$child_params['params'][$key]['value'] = array_merge(array_splice($param['value'], 0 , 1), g5element_vc_sources_colors(), $param['value']);
			break;
		}
	}
	vc_update_shortcode_param('vc_progress_bar', $child_params);

	$params = array(
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Layout Style', 'g5-element'),
			'param_name' => 'layout_style',
			'value' => array(
				esc_html__('Default', 'g5-element') => '',
				esc_html__('Value move', 'g5-element') => 'prb_value_move',
				esc_html__('Label above', 'g5-element') => 'prb_label_above',
				esc_html__('Label bellow', 'g5-element') => 'prb_label_bellow',
			),
			'admin_label' => true,
			'description' => esc_html__('Select Layout Style.', 'g5-element'),
			'weight' => ($background_overlay_index + $background_overlay_index),
		),

	);
	$param_color = WPBMap::getParam('vc_progress_bar', 'bgcolor');
	$param_color['value'] = array_merge(g5element_vc_sources_colors(), $param_color['value']);
	$param_color['heading'] = esc_html__('Color', 'g5-element');
	$param_color['std'] = 'accent';
	vc_update_shortcode_param('vc_progress_bar', $param_color);
	vc_add_params('vc_progress_bar', $params);
}