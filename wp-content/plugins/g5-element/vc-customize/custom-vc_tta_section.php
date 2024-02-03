<?php
add_action( 'vc_after_init', 'g5element_custom_vc_tta_section_add_param' );
function g5element_custom_vc_tta_section_add_param() {
    $params = array(
        array(
            'type' => 'checkbox',
            'param_name' => 'add_image',
            'heading' => esc_html__( 'Add Image?', 'g5-element' ),
            'description' => esc_html__( 'Add image next to section title.', 'g5-element' ),
        ),
        array(
            'type' => 'dropdown',
            'param_name' => 'image_position',
            'value' => array(
                esc_html__( 'Before title', 'g5-element' ) => 'left',
                esc_html__( 'After title', 'g5-element' ) => 'right',
            ),
            'dependency' => array(
                'element' => 'add_image',
                'value' => 'true',
            ),
            'heading' => esc_html__( 'Image position', 'add_image' ),
            'description' => esc_html__( 'Select icon position.', 'add_image' ),
        ),

        array(
            'type' => 'attach_image',
            'heading' => esc_html__('Upload Image', 'g5-element'),
            'param_name' => 'image',
            'value' => '',
            'description' => esc_html__('Upload the custom image.', 'g5-element'),
            'std' => '',
            'dependency' => array(
                'element' => 'add_image',
                'value' => 'true',
            ),
        ),
    );

    $parent_tag = vc_post_param( 'parent_tag', '' );
    $include_image_params = ( 'vc_tta_pageable' !== $parent_tag );
    if ($include_image_params) {
        $param_el_class               = WPBMap::getParam( 'vc_tta_section', 'el_class' );
        $param_el_class['weight']        = -1;
        vc_update_shortcode_param( 'vc_tta_section', $param_el_class );
        vc_add_params( 'vc_tta_section', $params );
    }
}

add_filter('vc-tta-get-params-tabs-list','g5element_custom_vc_tabs_list', 10, 4);
function g5element_custom_vc_tabs_list($_html, $_atts, $_content, $_this) {
    $isPageEditabe = vc_is_page_editable();
    if ($isPageEditabe) {
        return $_html;
    }
    $html = array();
    $html[] = '<div class="vc_tta-tabs-container">';
    $html[] = '<ul class="vc_tta-tabs-list">';
    if ( ! $isPageEditabe ) {
        $active_section = $_this->getActiveSection( $_atts, false );

        foreach ( WPBakeryShortCode_Vc_Tta_Section::$section_info as $nth => $section ) {
            $classes = array( 'vc_tta-tab' );
            if ( ( $nth + 1 ) === $active_section ) {
                $classes[] = $_this->activeClass;
            }

            $title = '<span class="vc_tta-title-text">' . $section['title'] . '</span>';
            if ( 'true' === $section['add_icon'] ) {
                $icon_html = $_this->constructIcon( $section );
                if ( 'left' === $section['i_position'] ) {
                    $title = $icon_html . $title;
                } else {
                    $title = $title . $icon_html;
                }
            }

            if ('true' === $section['add_image']) {
                $img_id = preg_replace( '/[^\d]/', '', $section['image'] );
                $image_html = wp_get_attachment_image($img_id,'full');
                if ( 'left' === $section['image_position'] ) {
                    $title = $image_html . $title;
                } else {
                    $title = $title . $image_html;
                }
            }


            $a_html = '<a href="#' . $section['tab_id'] . '" data-vc-tabs data-vc-container=".vc_tta">' . $title . '</a>';
            $html[] = '<li class="' . implode( ' ', $classes ) . '" data-vc-tab>' . $a_html . '</li>';
        }
    }

    $html[] = '</ul>';
    $html[] = '</div>';
    return $html;
}