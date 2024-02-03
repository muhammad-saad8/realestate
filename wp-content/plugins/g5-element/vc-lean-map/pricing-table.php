<?php
return array(
	'base'     => 'g5element_pricing_table',
	'name'     => esc_html__('Pricing Tables', 'g5-element'),
	'category' => G5ELEMENT()->shortcode()->get_category_name(),
	'description' => esc_html__('Create nice looking pricing tables.','g5-element'),
	'icon'     => 'g5element-vc-icon-pricing-table',
	'params'   => array_merge(
		array(
			array(
				'param_name'  => 'layout_style',
				'heading'     => esc_html__('Layout Style', 'g5-element'),
				'description' => esc_html__('Specify your layout style', 'g5-element'),
				'type'        => 'g5element_image_set',
				'value'       => array(
					'style-1' => array(
						'label' => esc_html__('Style 1', 'g5-element'),
						'img'   => G5ELEMENT()->plugin_url('assets/images/pricing-style1.jpg'),
					),
					'style-2' => array(
						'label' => esc_html__('Style 2', 'g5-element'),
						'img'   => G5ELEMENT()->plugin_url('assets/images/pricing-style2.jpg'),
					),
					'style-3' => array(
						'label' => esc_html__('Style 3', 'g5-element'),
						'img'   => G5ELEMENT()->plugin_url('assets/images/pricing-style3.jpg'),
					),
					'style-4' => array(
						'label' => esc_html__('Style 4', 'g5-element'),
						'img'   => G5ELEMENT()->plugin_url('assets/images/pricing-style4.jpg'),
					),
					'style-5' => array(
						'label' => esc_html__('Style 5', 'g5-element'),
						'img'   => G5ELEMENT()->plugin_url('assets/images/pricing-style5.jpg'),
					),
				),
				'std'         => 'style-1',
				'admin_label' => true
			),
			array(
				'param_name'  => 'image',
				'type'        => 'attach_image',
				'heading'     => esc_html__('Images', 'g5-element'),
				'value'       => '',
				'description' => esc_html__('Select images from media library.', 'g5-element'),
				'dependency'  => array(
					'element' => 'layout_style',
					'value'   => array('style-1', 'style-2', 'style-3', 'style-4')
				),
			),
			array(
				'type'             => 'textfield',
				'heading'          => esc_html__('Name', 'g5-element'),
				'param_name'       => 'name',
				'admin_label'      => true,
				'std'              => 'Name',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'param_name'       => 'price',
				'type'             => 'g5element_number',
				'heading'          => esc_html__('Price', 'g5-element'),
				'admin_label'      => true,
				'std'              => '10',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'param_name'       => 'currency_code',
				'type'             => 'textfield',
				'heading'          => esc_html__('Currency Code', 'g5-element'),
				'description'      => esc_html__('Enter Currency Code. Ex: $, £, €, ₫ ...', 'g5-element'),
				'std'              => '$',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'param_name'       => 'duration',
				'type'             => 'textfield',
				'heading'          => esc_html__('Duration', 'g5-element'),
				'description'      => esc_html__('Enter duration. Ex: day, month or year', 'g5-element'),
				'std'              => 'year',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'param_name'       => 'background',
				'type'             => 'g5element_color',
				'heading'          => esc_html__('Background', 'g5-element'),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'param_name'       => 'border_color',
				'type'             => 'g5element_color',
				'heading'          => esc_html__('Border Color', 'g5-element'),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'type'        => 'vc_link',
				'heading'     => esc_html__('URL (Link)', 'g5-element'),
				'param_name'  => 'link',
				'description' => esc_html__('Add link to button.', 'g5-element'),
			),
			array(
				'param_name'       => 'is_featured',
				'type'             => 'g5element_switch',
				'heading'          => esc_html__('Is Featured?', 'g5-element'),
				'admin_label'      => true,
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'param_name' => 'set_name_typography',
				'type'       => 'g5element_switch',
				'heading'    => esc_html__('Set name typography', 'g5-element'),
				'group'      => esc_html__('Typography', 'g5-element'),
				'std'        => G5ELEMENT()->vc_params()->get_typography_default()
			),
			array(
				'param_name' => 'name_typography',
				'type'       => 'g5element_typography',
				'heading'    => esc_html__('Name Typography', 'g5-element'),
				'dependency' => array('element' => 'set_name_typography', 'value' => array('on')),
				'group'      => esc_html__('Typography', 'g5-element'),
				'std'        => G5ELEMENT()->vc_params()->get_typography_default()
			),
			array(
				'param_name' => 'set_price_typography',
				'type'       => 'g5element_switch',
				'heading'    => esc_html__('Set price typography', 'g5-element'),
				'group'      => esc_html__('Typography', 'g5-element'),
				'std'        => G5ELEMENT()->vc_params()->get_typography_default()
			),
			array(
				'param_name' => 'price_typography',
				'type'       => 'g5element_typography',
				'heading'    => esc_html__('Price Typography', 'g5-element'),
				'dependency' => array('element' => 'set_price_typography', 'value' => array('on')),
				'group'      => esc_html__('Typography', 'g5-element'),
				'std'        => G5ELEMENT()->vc_params()->get_typography_default()
			),
			array(
				'param_name' => 'set_currency_typography',
				'type'       => 'g5element_switch',
				'heading'    => esc_html__('Set currency typography', 'g5-element'),
				'group'      => esc_html__('Typography', 'g5-element'),
				'std'        => G5ELEMENT()->vc_params()->get_typography_default()
			),
			array(
				'param_name' => 'currency_code_typography',
				'type'       => 'g5element_typography',
				'heading'    => esc_html__('Currency Code Typography', 'g5-element'),
				'dependency' => array('element' => 'set_currency_typography', 'value' => array('on')),
				'group'      => esc_html__('Typography', 'g5-element'),
				'std'        => G5ELEMENT()->vc_params()->get_typography_default()
			),
			array(
				'param_name' => 'set_duration_typography',
				'type'       => 'g5element_switch',
				'heading'    => esc_html__('Set duration typography', 'g5-element'),
				'group'      => esc_html__('Typography', 'g5-element'),
				'std'        => G5ELEMENT()->vc_params()->get_typography_default()
			),
			array(
				'param_name' => 'duration_typography',
				'type'       => 'g5element_typography',
				'heading'    => esc_html__('Duration Typography', 'g5-element'),
				'dependency' => array('element' => 'set_duration_typography', 'value' => array('on')),
				'group'      => esc_html__('Typography', 'g5-element'),
				'std'        => G5ELEMENT()->vc_params()->get_typography_default()
			),
			array(
				'param_name' => 'featured_text',
				'type'       => 'textfield',
				'heading'    => esc_html__('Featured Caption', 'g5-element'),
				'dependency' => array('element' => 'is_featured', 'value' => array('on')),
				'group'      => esc_html__('Featured', 'g5-element'),
				'std'        => 'Popular choice',
			),
			array(
				'param_name'       => 'featured_item_color',
				'type'             => 'g5element_color',
				'heading'          => esc_html__('Featured item color', 'g5-element'),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'dependency'       => array('element' => 'is_featured', 'value' => array('on')),
				'group'            => esc_html__('Featured', 'g5-element')
			),
			array(
				'param_name'       => 'featured_text_color',
				'type'             => 'g5element_color',
				'heading'          => esc_html__('Featured text color', 'g5-element'),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'dependency'       => array('element' => 'is_featured', 'value' => array('on')),
				'group'            => esc_html__('Featured', 'g5-element')
			),

			//list
			array(
				'param_name' => 'list_style',
				'heading'    => esc_html__('List Description Style', 'g5-element'),
				'type'       => 'dropdown',
				'value'      => array(
					esc_html__('None', 'g5-element')   => '',
					esc_html__('Number', 'g5-element') => 'list-number',
					esc_html__('Icon', 'g5-element')   => 'list-icon',
				),
				'std'        => '',
				'group'      => esc_html__('Description', 'g5-element')
			),
			array(
				'param_name'       => 'list_align',
				'type'             => 'g5element_button_set',
				'heading'          => esc_html__('Description Align', 'g5-element'),
				'value'            => array(
					esc_html__('Left', 'g5-element')   => 'left',
					esc_html__('Center', 'g5-element') => 'center',
					esc_html__('Right', 'g5-element')  => 'right',
				),
				'std'              => 'center',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'group'            => esc_html__('Description', 'g5-element')
			),
			array(
				'param_name'       => 'list_padding_bottom',
				'type'             => 'g5element_number',
				'heading'          => esc_html__('Description Padding Bottom (px)', 'g5-element'),
				'std'              => '0',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'group'            => esc_html__('Description', 'g5-element'),
			),
			array(
				'param_name'       => 'list_icon',
				'type'             => 'g5element_icon_picker',
				'heading'          => esc_html__('Icon', 'g5-element'),
				'value'            => '',
				'description'      => esc_html__('Select icon from library.', 'g5-element'),
				'dependency'       => array('element' => 'list_style', 'value' => array('list-icon')),
				'std'              => 'fas fa-check',
				'edit_field_class' => 'vc_col-sm-4 vc_column',
				'group'            => esc_html__('Description', 'g5-element'),
			),
			array(
				'param_name'       => 'prefix_list_desc_size',
				'type'             => 'g5element_number_and_unit',
				'heading'          => esc_html__('Prefix description size', 'g5-element'),
				'dependency'       => array('element' => 'list_style', 'value' => array('list-icon', 'list-number')),
				'edit_field_class' => 'vc_col-sm-4 vc_column',
				'group'            => esc_html__('Description', 'g5-element')
			),
			array(
				'param_name'       => 'prefix_list_desc_color',
				'type'             => 'g5element_color',
				'heading'          => esc_html__('Prefix description color', 'g5-element'),
				'dependency'       => array('element' => 'list_style', 'value' => array('list-icon', 'list-number')),
				'edit_field_class' => 'vc_col-sm-4 vc_column',
				'group'            => esc_html__('Description', 'g5-element')
			),
			array(
				'param_name'       => 'set_desc_typography',
				'type'             => 'g5element_switch',
				'heading'          => esc_html__('Set description text typography', 'g5-element'),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'group'            => esc_html__('Description', 'g5-element'),
				'std'              => G5ELEMENT()->vc_params()->get_typography_default()
			),
			array(
				'param_name' => 'desc_typography',
				'type'       => 'g5element_typography',
				'heading'    => esc_html__('Description text typography', 'g5-element'),
				'dependency' => array('element' => 'set_desc_typography', 'value' => array('on')),
				'group'      => esc_html__('Description', 'g5-element'),
				'std'        => G5ELEMENT()->vc_params()->get_typography_default()
			),
			array(
				'param_name' => 'list_features',
				'type'       => 'param_group',
				'heading'    => esc_html__('Values', 'g5-element'),
				'value'      => '',
				'params'     => array(
					array(
						'param_name'       => 'prefix_feature',
						'type'             => 'g5element_icon_picker',
						'heading'          => esc_html__('Icon', 'g5-element'),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'param_name'       => 'list_disable',
						'type'             => 'g5element_switch',
						'heading'          => esc_html__('Disable Feature', 'g5-element'),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'param_name'  => 'feature',
						'type'        => 'textarea',
						'heading'     => esc_html__('Feature', 'g5-element'),
						'admin_label' => true,
						'std'         => esc_html__(
							'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt',
							'g5-element')

					),
				),
				'group'      => esc_html__('Description', 'g5-element'),
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__('Text on the button', 'g5-element'),
				'param_name'  => 'button_title',
				'admin_label' => true,
				'std'         => esc_html__('Buy Now', 'g5-element'),
				'group'       => 'Button Options'
			),
		),
		G5CORE()->settings()->get_button_config('', esc_html__('Button Options', 'g5-element')),
		array(
			g5element_vc_map_add_element_id(),
			g5element_vc_map_add_extra_class(),
			g5element_vc_map_add_css_animation(),
			g5element_vc_map_add_animation_duration(),
			g5element_vc_map_add_animation_delay(),
			g5element_vc_map_add_css_editor(),
			g5element_vc_map_add_responsive(),
		)
	)
);