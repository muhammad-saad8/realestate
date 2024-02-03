<?php
/**
 * VC Lean map config
 *
 * @package g5element
 * @subpackage layout_section
 * @since 1.0
 */
return array(
	'base'                    => 'g5element_layout_section',
	'name'                    => esc_html__( 'Layout Section', 'g5-element' ),
	'category'                => G5ELEMENT()->shortcode()->get_category_name(),
	'description'             => __( 'Section for Layout Container', 'g5-element' ),
	'icon'                    => 'g5element-vc-icon-layout-section',
	'as_parent'               => array( 'except' => 'g5element_layout_container' ),
	'as_child' => array(
		'only' => 'g5element_layout_container',
	),
	'allowed_container_element' => 'vc_row',
	'is_container' => true,
	'show_settings_on_create' => false,
	'params'                  => array(
		array(
			'type' => 'textfield',
			'param_name' => 'title',
			'heading' => __( 'Title', 'g5-element' ),
			'description' => __( 'Enter section title (Note: you can leave it empty).', 'g5-element' ),
		),
	),
	'js_view'                 => 'G5ElementLayoutSectionView',
	'custom_markup' => '
		<div class="gel-layout-section-heading" data-default-title="' . esc_html__('Layout Section Name','g5-element') . '">
		    <h4 class="title"><i class="fal fa-check"></i> <span>{{ section_title }}</span></h4>
		    <div class="gel-layout-section-controls bottom-controls">
		        <a href="#" class="gel-layout-section-add" title="' . esc_html__('Add item to this section','g5-element') . '"><i class="vc-composer-icon vc-c-icon-add"></i></a>
			</div>
		</div>
		<div class="gel-layout-section-body">
			<div class="{{ container-class }}">
			{{ content }}
			</div>
		</div>',
);