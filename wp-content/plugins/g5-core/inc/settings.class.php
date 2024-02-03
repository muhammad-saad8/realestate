<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! class_exists( 'G5Core_Settings' ) ) {
	class G5Core_Settings {
		private static $_instance;

		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function get_toggle( $inherit = false ) {
			$config = array(
				'on'  => esc_html__( 'On', 'g5-core' ),
				'off' => esc_html__( 'Off', 'g5-core' )
			);

			if ( $inherit ) {
				$config = array( '' => esc_html__( 'Default', 'g5-core' ) ) + $config;
			}

			return $config;
		}

		public function get_maintenance_mode() {
			return apply_filters( 'g5core_options_maintenance_mode', array(
				'custom' => 'On (Custom Page)',
				'standard' => 'On (Standard)',
				'off' => 'Off',
			) );
		}

		public function get_loading_animation() {
			return apply_filters( 'g5core_options_loading_animation', array(
				''              => esc_html__( 'None', 'g5-core' ),
				'chasing-dots'  => esc_html__( 'Chasing Dots', 'g5-core' ),
				'circle'        => esc_html__( 'Circle', 'g5-core' ),
				'cube'          => esc_html__( 'Cube', 'g5-core' ),
				'double-bounce' => esc_html__( 'Double Bounce', 'g5-core' ),
				'fading-circle' => esc_html__( 'Fading Circle', 'g5-core' ),
				'folding-cube'  => esc_html__( 'Folding Cube', 'g5-core' ),
				'pulse'         => esc_html__( 'Pulse', 'g5-core' ),
				'three-bounce'  => esc_html__( 'Three Bounce', 'g5-core' ),
				'wave'          => esc_html__( 'Wave', 'g5-core' ),
			) );
		}

		public function get_menu_transition() {
			return apply_filters( 'g5core_options_menu_transition', array(
				'none'          => esc_html__( 'None', 'g5-core' ),
				'x-fadeIn'      => esc_html__( 'Fade In', 'g5-core' ),
				'x-fadeInUp'    => esc_html__( 'Fade In Up', 'g5-core' ),
				'x-fadeInDown'  => esc_html__( 'Fade In Down', 'g5-core' ),
				'x-fadeInLeft'  => esc_html__( 'Fade In Left', 'g5-core' ),
				'x-fadeInRight' => esc_html__( 'Fade In Right', 'g5-core' ),
				'x-flipInX'     => esc_html__( 'Flip In X', 'g5-core' ),
				'x-slideInUp'   => esc_html__( 'Slide In Up', 'g5-core' )
			) );
		}

		public function get_site_style( $default = false ) {
			$defaults = array();
			if ( $default ) {
				$defaults[''] = array(
					'label' => esc_html__( 'Inherit', 'g5-core' ),
					'img'   => G5CORE()->plugin_url( 'assets/images/theme-options/default.png' ),
				);
			}
			$config = apply_filters( 'g5core_options_site_style', array(
				'wide'     => array(
					'label' => esc_html__( 'Wide', 'g5-core' ),
					'img'   => G5CORE()->plugin_url( 'assets/images/theme-options/layout-wide.png' ),
				),
				'boxed'    => array(
					'label' => esc_html__( 'Boxed', 'g5-core' ),
					'img'   => G5CORE()->plugin_url( 'assets/images/theme-options/layout-boxed.png' ),
				),
				'bordered' => array(
					'label' => esc_html__( 'Bordered', 'g5-core' ),
					'img'   => G5CORE()->plugin_url( 'assets/images/theme-options/layout-bordered.png' ),
				)
			) );

			$config = wp_parse_args( $config, $defaults );

			return $config;
		}

		public function get_site_layout( $inherit = false ) {
			$config = apply_filters( 'g5core_options_site_layout', array(
				'none'  => array(
					'label' => esc_html__( 'Full Width', 'g5-core' ),
					'img'   => G5CORE()->plugin_url( 'assets/images/theme-options/sidebar-none.png' ),
				),
				'left'  => array(
					'label' => esc_html__( 'Left Sidebar', 'g5-core' ),
					'img'   => G5CORE()->plugin_url( 'assets/images/theme-options/sidebar-left.png' ),
				),
				'right' => array(
					'label' => esc_html__( 'Right Sidebar', 'g5-core' ),
					'img'   => G5CORE()->plugin_url( 'assets/images/theme-options/sidebar-right.png' ),
				)
			) );

			if ( $inherit ) {
				$config = array(
					          '' => array(
						          'label' => esc_html__( 'Default', 'g5-core' ),
						          'img'   => G5CORE()->plugin_url( 'assets/images/theme-options/default.png' ),
					          )
				          ) + $config;
			}

			return $config;
		}

		public function get_header_layout($inherit = false) {
			$config =  apply_filters( 'g5core_options_header_layout', array(
				'boxed' => esc_html__( 'Boxed Content', 'g5-core' ),
				'stretched'  => esc_html__( 'Stretched Content', 'g5-core' ),
			) );

			if ( $inherit ) {
				$config = array(
					          '' => esc_html__('Default','g5-core')
				          ) + $config;
			}

			return $config;
		}

		public function get_footer_layout( $inherit = false ) {
			$config =  apply_filters( 'g5core_options_footer_layout', array(
				'boxed' => esc_html__( 'Boxed Content', 'g5-core' ),
				'stretched'  => esc_html__( 'Stretched Content', 'g5-core' ),
				'full_width'  => esc_html__( 'Full Width', 'g5-core' ),
			) );

			if ( $inherit ) {
				$config = array(
					          '' => esc_html__('Default','g5-core')
				          ) + $config;
			}

			return $config;

		}


		public function get_header_style() {
			return apply_filters( 'g5core_options_header_style', array(
				'layout-01' => array(
					'img'   => G5CORE()->plugin_url( 'assets/images/theme-options/header-01.png' ),
					'label' => esc_html__( 'Header 1', 'g5-core' )
				),
				'layout-02' => array(
					'img'   => G5CORE()->plugin_url( 'assets/images/theme-options/header-02.png' ),
					'label' => esc_html__( 'Header 2', 'g5-core' )
				),
				'layout-03' => array(
					'img'   => G5CORE()->plugin_url( 'assets/images/theme-options/header-03.png' ),
					'label' => esc_html__( 'Header 3', 'g5-core' )
				),
				'layout-04' => array(
					'img'   => G5CORE()->plugin_url( 'assets/images/theme-options/header-04.png' ),
					'label' => esc_html__( 'Header 4', 'g5-core' )
				),
				'layout-05' => array(
					'img'   => G5CORE()->plugin_url( 'assets/images/theme-options/header-05.png' ),
					'label' => esc_html__( 'Header 5', 'g5-core' )
				),
				'layout-06' => array(
					'img'   => G5CORE()->plugin_url( 'assets/images/theme-options/header-06.png' ),
					'label' => esc_html__( 'Header 6', 'g5-core' )
				),
				'layout-07' => array(
					'img'   => G5CORE()->plugin_url( 'assets/images/theme-options/header-07.png' ),
					'label' => esc_html__( 'Header 7', 'g5-core' )
				),
				'layout-08' => array(
					'img'   => G5CORE()->plugin_url( 'assets/images/theme-options/header-08.png' ),
					'label' => esc_html__( 'Header 8', 'g5-core' )
				),
				'layout-09' => array(
					'img'   => G5CORE()->plugin_url( 'assets/images/theme-options/header-09.png' ),
					'label' => esc_html__( 'Header 9', 'g5-core' )
				),
				'layout-10' => array(
					'img'   => G5CORE()->plugin_url( 'assets/images/theme-options/header-10.png' ),
					'label' => esc_html__( 'Header 10', 'g5-core' )
				),
				'layout-11' => array(
					'img'   => G5CORE()->plugin_url( 'assets/images/theme-options/header-11.png' ),
					'label' => esc_html__( 'Header 11', 'g5-core' )
				),
				'layout-12' => array(
					'img'   => G5CORE()->plugin_url( 'assets/images/theme-options/header-12.png' ),
					'label' => esc_html__( 'Header 12', 'g5-core' )
				),
				'layout-13' => array(
					'img'   => G5CORE()->plugin_url( 'assets/images/theme-options/header-13.png' ),
					'label' => esc_html__( 'Header 13', 'g5-core' )
				),
				'layout-14' => array(
					'img'   => G5CORE()->plugin_url( 'assets/images/theme-options/header-14.png' ),
					'label' => esc_html__( 'Header 14', 'g5-core' )
				),
				'layout-15' => array(
					'img'   => G5CORE()->plugin_url( 'assets/images/theme-options/header-15.png' ),
					'label' => esc_html__( 'Header 15', 'g5-core' )
				),
				'layout-16' => array(
					'img'   => G5CORE()->plugin_url( 'assets/images/theme-options/header-16.png' ),
					'label' => esc_html__( 'Header 16', 'g5-core' )
				),
				'layout-17' => array(
					'img'   => G5CORE()->plugin_url( 'assets/images/theme-options/header-17.png' ),
					'label' => esc_html__( 'Header 17', 'g5-core' )
				),
				'layout-18' => array(
					'img'   => G5CORE()->plugin_url( 'assets/images/theme-options/header-18.png' ),
					'label' => esc_html__( 'Header 18', 'g5-core' )
				),
				'layout-19' => array(
					'img'   => G5CORE()->plugin_url( 'assets/images/theme-options/header-19.png' ),
					'label' => esc_html__( 'Header 19', 'g5-core' )
				),
				'layout-20' => array(
					'img'   => G5CORE()->plugin_url( 'assets/images/theme-options/header-20.png' ),
					'label' => esc_html__( 'Header 20', 'g5-core' )
				),
				'layout-21' => array(
					'img'   => G5CORE()->plugin_url( 'assets/images/theme-options/header-21.png' ),
					'label' => esc_html__( 'Header 21', 'g5-core' )
				),
				'layout-22' => array(
					'img'   => G5CORE()->plugin_url( 'assets/images/theme-options/header-22.png' ),
					'label' => esc_html__( 'Header 22', 'g5-core' )
				),
				'layout-23' => array(
					'img'   => G5CORE()->plugin_url( 'assets/images/theme-options/header-23.png' ),
					'label' => esc_html__( 'Header 23', 'g5-core' )
				),
				'layout-24' => array(
					'img'   => G5CORE()->plugin_url( 'assets/images/theme-options/header-24.png' ),
					'label' => esc_html__( 'Header 24', 'g5-core' )
				),
				'layout-25' => array(
					'img'   => G5CORE()->plugin_url( 'assets/images/theme-options/header-25.png' ),
					'label' => esc_html__( 'Header 25', 'g5-core' )
				),
				'layout-26' => array(
					'img'   => G5CORE()->plugin_url( 'assets/images/theme-options/header-26.png' ),
					'label' => esc_html__( 'Header 26', 'g5-core' )
				),
				'layout-27' => array(
					'img'   => G5CORE()->plugin_url( 'assets/images/theme-options/header-27.png' ),
					'label' => esc_html__( 'Header 27', 'g5-core' )
				),
				'layout-28' => array(
					'img'   => G5CORE()->plugin_url( 'assets/images/theme-options/header-28.png' ),
					'label' => esc_html__( 'Header 28', 'g5-core' )
				),
				'layout-29' => array(
					'img'   => G5CORE()->plugin_url( 'assets/images/theme-options/header-29.png' ),
					'label' => esc_html__( 'Header 29', 'g5-core' )
				),
				'layout-30' => array(
					'img'   => G5CORE()->plugin_url( 'assets/images/theme-options/header-30.png' ),
					'label' => esc_html__( 'Header 30', 'g5-core' )
				),
			) );
		}

		public function get_header_mobile_layout() {
			return apply_filters( 'g5core_options_header_mobile_style', array(
				'layout-01' => array(
					'img'   => G5CORE()->plugin_url( 'assets/images/theme-options/header-mobile-01.png' ),
					'label' => esc_html__( 'Header Style 1', 'g5-core' )
				),
				'layout-02' => array(
					'img'   => G5CORE()->plugin_url( 'assets/images/theme-options/header-mobile-02.png' ),
					'label' => esc_html__( 'Header Style 2', 'g5-core' )
				),
				'layout-03' => array(
					'img'   => G5CORE()->plugin_url( 'assets/images/theme-options/header-mobile-03.png' ),
					'label' => esc_html__( 'Header Style 3', 'g5-core' )
				),
			) );
		}

		public function get_header_customize() {
			return apply_filters( 'g5core_options_header_customize', array(
				'search-button'         => esc_html__( 'Search Button', 'g5-core' ),
				'search-box'            => esc_html__( 'Search Box', 'g5-core' ),
				'social-networks'       => esc_html__( 'Social Networks', 'g5-core' ),
				'login'                 => esc_html__( 'Login', 'g5-core' ),
				'canvas-sidebar-button' => esc_html__( 'Canvas Sidebar', 'g5-core' ),
				'custom-html'           => esc_html__( 'Custom Html', 'g5-core' ),
			) );
		}

		public function get_header_mobile_customize() {
			return apply_filters( 'g5core_options_header_mobile_customize', array(
				'search-button'         => esc_html__( 'Search Button', 'g5-core' ),
				'social-networks'       => esc_html__( 'Social Networks', 'g5-core' ),
				'login'                 => esc_html__( 'Login', 'g5-core' ),
				'canvas-sidebar-button' => esc_html__( 'Canvas Sidebar', 'g5-core' ),
				'custom-html'           => esc_html__( 'Custom Html', 'g5-core' ),
			) );
		}

		public function get_search_layout() {
			return apply_filters( 'g5core_options_search_layout', array(
				'layout-1' => esc_html__( 'Full Menu', 'g5-core' ),
				'layout-2' => esc_html__( 'After Menu', 'g5-core' ),
			) );
		}

		public function get_header_sticky() {
			return apply_filters( 'g5core_options_header_sticky', array(
				''       => esc_html__( 'No Sticky', 'g5-core' ),
				'simple' => esc_html__( 'Always Show', 'g5-core' ),
				'smart'  => esc_html__( 'Show On Scroll Up', 'g5-core' ),
			) );
		}

		public function get_social_share() {
			return apply_filters( 'g5core_options_social_share', array(
				'facebook'  => esc_html__( 'Facebook', 'g5-core' ),
				'twitter'   => esc_html__( 'Twitter', 'g5-core' ),
				'linkedin'  => esc_html__( 'Linkedin', 'g5-core' ),
				'tumblr'    => esc_html__( 'Tumblr', 'g5-core' ),
				'pinterest' => esc_html__( 'Pinterest', 'g5-core' ),
				'email'     => esc_html__( 'Email', 'g5-core' ),
				'telegram'  => esc_html__( 'Telegram', 'g5-core' ),
				'whatsapp'  => esc_html__( 'WhatsApp (Only Mobiles)', 'g5-core' ),
			) );
		}



		public function get_social_networks() {
			$social_networks = G5CORE()->options()->get_option('social_networks');
			$options         = array();
			if ( is_array( $social_networks ) ) {
				foreach ( $social_networks as $social_network ) {
					$options[ $social_network['social_id'] ] = $social_network['social_name'];
				}
			}

			return $options;
		}

		public function get_social_networks_default() {
			$social_networks = array(
				array(
					'social_name'  => esc_html__( 'Facebook', 'g5-core' ),
					'social_id'    => 'social-facebook',
					'social_icon'  => 'fab fa-facebook-f',
					'social_link'  => '',
					'social_color' => '#3b5998'
				),
				array(
					'social_name'  => esc_html__( 'Twitter', 'g5-core' ),
					'social_id'    => 'social-twitter',
					'social_icon'  => 'fab fa-twitter',
					'social_link'  => '',
					'social_color' => '#1da1f2'
				),
				array(
					'social_name'  => esc_html__( 'Pinterest', 'g5-core' ),
					'social_id'    => 'social-pinterest',
					'social_icon'  => 'fab fa-pinterest',
					'social_link'  => '',
					'social_color' => '#bd081c'
				),
				array(
					'social_name'  => esc_html__( 'Dribbble', 'g5-core' ),
					'social_id'    => 'social-dribbble',
					'social_icon'  => 'fab fa-dribbble',
					'social_link'  => '',
					'social_color' => '#00b6e3'
				),
				array(
					'social_name'  => esc_html__( 'LinkedIn', 'g5-core' ),
					'social_id'    => 'social-linkedin',
					'social_icon'  => 'fab fa-linkedin',
					'social_link'  => '',
					'social_color' => '#0077b5'
				),
				array(
					'social_name'  => esc_html__( 'Vimeo', 'g5-core' ),
					'social_id'    => 'social-vimeo',
					'social_icon'  => 'fab fa-vimeo',
					'social_link'  => '',
					'social_color' => '#1ab7ea'
				),
				array(
					'social_name'  => esc_html__( 'Tumblr', 'g5-core' ),
					'social_id'    => 'social-tumblr',
					'social_icon'  => 'fab fa-tumblr',
					'social_link'  => '',
					'social_color' => '#35465c'
				),
				array(
					'social_name'  => esc_html__( 'Skype', 'g5-core' ),
					'social_id'    => 'social-skype',
					'social_icon'  => 'fab fa-skype',
					'social_link'  => '',
					'social_color' => '#00aff0'
				),
				array(
					'social_name'  => esc_html__( 'Flickr', 'g5-core' ),
					'social_id'    => 'social-flickr',
					'social_icon'  => 'fab fa-flickr',
					'social_link'  => '',
					'social_color' => '#ff0084'
				),
				array(
					'social_name'  => esc_html__( 'YouTube', 'g5-core' ),
					'social_id'    => 'social-youTube',
					'social_icon'  => 'fab fa-youtube',
					'social_link'  => '',
					'social_color' => '#cd201f'
				),
				array(
					'social_name'  => esc_html__( 'Instagram', 'g5-core' ),
					'social_id'    => 'social-instagram',
					'social_icon'  => 'fab fa-instagram',
					'social_link'  => '',
					'social_color' => '#405de6'
				),
				array(
					'social_name'  => esc_html__( 'GitHub', 'g5-core' ),
					'social_id'    => 'social-gitHub',
					'social_icon'  => 'fab fa-github',
					'social_link'  => '',
					'social_color' => '#4078c0'
				),
				array(
					'social_name'  => esc_html__( 'Behance', 'g5-core' ),
					'social_id'    => 'social-behance',
					'social_icon'  => 'fab fa-behance',
					'social_link'  => '',
					'social_color' => '#1769ff'
				),
				array(
					'social_name'  => esc_html__( 'Tiktok', 'g5-core' ),
					'social_id'    => 'social-tiktok',
					'social_icon'  => 'fab fa-tiktok',
					'social_link'  => '',
					'social_color' => '#fe2c55'
				),
				array(
					'social_name'  => esc_html__( 'Snapchat', 'g5-core' ),
					'social_id'    => 'social-snapchat',
					'social_icon'  => 'fab fa-snapchat',
					'social_link'  => '',
					'social_color' => '#FFFC00'
				),
				array(
					'social_name'  => esc_html__( 'Email', 'g5-core' ),
					'social_id'    => 'social-email',
					'social_icon'  => 'fa fa-envelope',
					'social_link'  => '',
					'social_color' => '#464646'
				),

			);

			return $social_networks;
		}

		public function header_vertical_style($layout = null) {
			$all_layout = apply_filters( 'g5core_header_vertical_style', array(
				'layout-23' => array(
					'location' => 'left',
					'size'     => 'large'
				),
				'layout-24' => array(
					'location' => 'right',
					'size'     => 'large'
				),
				'layout-25'=> array(
					'location' => 'left',
					'size'     => 'mini'
				),
				'layout-26'=> array(
					'location' => 'right',
					'size'     => 'mini'
				)
			) );

			if ($layout === null) {
				return $all_layout;
			}
			return isset($all_layout[$layout]) ? $all_layout[$layout] : false;
		}

		public function post_types_for_search() {
			$search_pt = array(
				'all' => esc_html__('All','g5-core')
			);
			foreach (g5core_post_types_active() as $key => $pt) {
				$search_pt[$key] = $pt['label'];
			}

			return $search_pt;
		}

		public function top_bar_customize_items() {
			return array(
				'left'    =>
					array(),
				'right'   =>
					array(),
				'disable' =>
					apply_filters('g5core_top_bar_customize_items',array(
						'login'           => esc_html__( 'Login', 'g5-core' ),
						'menu'            => esc_html__( 'Menu', 'g5-core' ),
						'social-networks' => esc_html__( 'Social Networks', 'g5-core' ),
						'custom-html-1' => esc_html__( 'Custom Html 1', 'g5-core' ),
						'custom-html-2' => esc_html__( 'Custom Html 2', 'g5-core' ),
					))
			);
		}

        public function get_post_columns($inherit = false)
        {
            $config = apply_filters('g5core_options_post_columns', array(
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6'
            ));

            if ($inherit) {
                $config = array(
                        '' => esc_html__('Inherit', 'g5-core')
                    ) + $config;
            }

            return $config;
        }


        public function get_post_paging_small_mode($inherit = false)
        {
            $config = apply_filters('g5core_options_post_paging_small_mode', array(
                'none' => esc_html__('None', 'g5-core'),
                'slider' => esc_html__('Carousel Slider', 'g5-core'),
                'pagination-ajax' => esc_html__('Ajax - Pagination', 'g5-core'),
                'next-prev' => esc_html__('Ajax - Next Prev', 'g5-core'),
                'load-more' => esc_html__('Ajax - Load More', 'g5-core'),
            ));

            if ($inherit) {
                $config = array(
                        '' => esc_html__('Inherit', 'g5-core')
                    ) + $config;
            }

            return $config;
        }



        public function get_post_paging_mode($inherit = false)
        {
            $config = apply_filters('g5core_options_post_paging_mode', array(
                'pagination' => esc_html__('Pagination', 'g5-core'),
                'pagination-ajax' => esc_html__('Ajax - Pagination', 'g5-core'),
                'next-prev' => esc_html__('Ajax - Next Prev', 'g5-core'),
                'load-more' => esc_html__('Ajax - Load More', 'g5-core'),
                'infinite-scroll' => esc_html__('Ajax - Infinite Scroll', 'g5-core')
            ));

            if ($inherit) {
                $config = array(
                        '' => esc_html__('Inherit', 'g5-core')
                    ) + $config;
            }

            return $config;
        }

		public function get_shortcode_post_paging($inherit = false)
		{
			$config = apply_filters('g5core_shortcode_post_paging', array(
				'none' => esc_html__('None', 'g5-core'),
				'pagination-ajax' => esc_html__('Ajax - Pagination', 'g5-core'),
				'next-prev' => esc_html__('Ajax - Next Prev', 'g5-core'),
				'load-more' => esc_html__('Ajax - Load More', 'g5-core'),
			));

			if ($inherit) {
				$config = array(
					          '' => esc_html__('Inherit', 'g5-core')
				          ) + $config;
			}

			return $config;
		}

        public function get_post_columns_gutter($inherit = false)
        {
            $config = apply_filters('g5core_options_post_columns_gutter', array(
                'none' => esc_html__('None', 'g5-core'),
                '5' => '5px',
                '10' => '10px',
                '20' => '20px',
                '30' => '30px',
                '40' => '40px',
            ));

            if ($inherit) {
                $config = array(
                        '' => esc_html__('Inherit', 'g5-core')
                    ) + $config;
            }

            return $config;
        }

        public function get_color_list() {
			return apply_filters('g5core_color_list', array(
				'' => esc_html__('Default','g5-core'),
				'accent' => esc_html__('Accent','g5-core'),
				'primary' => esc_html__('Primary','g5-core'),
				'secondary' => esc_html__('Secondary','g5-core'),
				'light' => esc_html__('Light','g5-core'),
				'dark' => esc_html__('Dark','g5-core'),
				'gray' => esc_html__('Gray','g5-core'),
				'custom' => esc_html__('Custom','g5-core'),
			));
        }

		/**
		 * Get Options Config
		 *
		 * @param string $prefix
		 *
		 * @return array
		 */
        public function get_button_config($prefix = '', $group = '') {
			return array(
				array(
					'type' => 'dropdown',
					'heading' => esc_html__('Style', 'g5-core'),
					'description' => esc_html__('Select button display style.', 'g5-core'),
					'param_name' => $prefix . 'button_style',
					'value' => array(
						esc_html__('Classic', 'g5-core') => 'classic',
						esc_html__('Outline', 'g5-core') => 'outline',
						esc_html__('Link', 'g5-core') => 'link'
					),
					'std' => 'classic',
					'group' => $group,
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__('Shape', 'g5-core'),
					'description' => esc_html__('Select button shape.', 'g5-core'),
					'param_name' => $prefix . 'button_shape',
					'value' => array(
						esc_html__('Rounded', 'g5-core') => 'rounded',
						esc_html__('Square', 'g5-core') => 'square',
						esc_html__('Round', 'g5-core') => 'round',
					),
					'dependency' => array(
						'element' => $prefix . 'button_style',
						'value_not_equal_to' => array('link'),
					),
					'std' => 'square',
					'group' => $group,
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__('Size', 'g5-core'),
					'param_name' => $prefix . 'button_size',
					'description' => esc_html__('Select button display size.', 'g5-core'),
					'std' => 'md',
					'value' => array(
						esc_html__('Small', 'g5-core') => 'sm',
						esc_html__('Normal', 'g5-core') => 'md',
						esc_html__('Large', 'g5-core') => 'lg',
						esc_html__('Extra Large', 'g5-core') => 'xl',
					),
					'group' => $group,
				),
				array(
					'type' => 'g5element_color',
					'heading' => esc_html__('Color', 'g5-core'),
					'param_name' => $prefix . 'button_color',
					'description' => esc_html__('Select button color.', 'g5-core'),
					'std' => 'accent',
					'group' => $group,
				),
				array(
					'type' => 'g5element_switch',
					'heading' => esc_html__('Button 3D?', 'g5-core'),
					'param_name' => $prefix . 'button_is_3d',
					'std' => '',
					'dependency'       => array('element' => $prefix . 'button_style', 'value' => 'classic'),
					'group' => $group,
				),
			);
        }

        public function get_animation($inherit = false)
        {
            $config = apply_filters('g5core_options_animation', array(
                'none' => esc_html__('None', 'g5-core'),
                'ttb' => esc_html__('Top to bottom', 'g5-core'),
                'btt' => esc_html__('Bottom to top', 'g5-core'),
                'ltr' => esc_html__('Left to right', 'g5-core'),
                'rtl' => esc_html__('Right to left', 'g5-core'),
                'appear' => esc_html__('Appear from center', 'g5-core')
            ));

            if ($inherit) {
                $config = array(
                        '' => esc_html__('Inherit', 'g5-core')
                    ) + $config;
            }

            return $config;
        }

        public function get_content_block_type() {
        	return apply_filters('g5core_content_block_type', array(
		        'page_title' => esc_html__('Page Title','g5-core'),
		        'footer' => esc_html__('Footer','g5-core'),
		        'other' => esc_html__('Other','g5-core'),
	        ));
        }

		public function get_category_filter_align() {
			return apply_filters('g5core_category_filter_align',array(
				'' => esc_html__('Left','g5-core'),
				'center' => esc_html__('Center','g5-core'),
				'right' => esc_html__('Right','g5-core'),
			));
		}

		public function get_page_title_layout( $inherit = false ) {
			$config =  apply_filters( 'g5core_options_page_title_layout', array(
				'boxed' => esc_html__( 'Boxed Content', 'g5-core' ),
				'stretched'  => esc_html__( 'Stretched Content', 'g5-core' ),
				'full_width'  => esc_html__( 'Full Width', 'g5-core' ),
			) );

			if ( $inherit ) {
				$config = array(
					          '' => esc_html__('Default','g5-core')
				          ) + $config;
			}

			return $config;

		}




	}
}