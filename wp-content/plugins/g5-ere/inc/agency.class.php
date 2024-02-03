<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class G5ERE_Agency {
	/**
	 * @var int
	 */
	public $id = 0;


	public $agency = null;


	/**
	 * G5ERE_Agency constructor.
	 *
	 * @param $the_agency
	 */
	public function __construct( $the_agency ) {
		if ( is_numeric( $the_agency ) ) {
			$this->id     = absint( $the_agency );
			$this->agency = get_term( $this->id );
		} elseif ( $the_agency instanceof G5ERE_Agency ) {
			$this->id     = absint( $the_agency->id );
			$this->agency = $the_agency->agency;
		} elseif ( isset( $the_agency->term_id ) ) {
			$this->id     = absint( $the_agency->term_id );
			$this->agency = $the_agency;
		}
	}


	//////////////////////////////////////////////////////////////////////////////
	// Basic listing fields
	//////////////////////////////////////////////////////////////////////////////

	public function get_link() {

		return get_term_link( $this->agency->slug, 'agency' );

	}

	public function get_id() {
		return $this->id;
	}

	public function get_name() {
		return $this->agency->name;
	}

	public function get_slug() {
		return $this->agency->slug;
	}


	public function get_image_url() {
		$logo_src = get_term_meta( $this->id, 'agency_logo', true );
		$logo_url = '';
		if ( ! empty( $logo_src ) && is_array( $logo_src ) ) {
			if ( ! empty( $logo_src['url'] ) ) {
				$logo_url = $logo_src['url'];
			}
		}

		return apply_filters( 'g5ere_agency_get_image_url', $logo_url );
	}

	/**
	 * @return bool|mixed
	 */
	public function get_image_id() {
		$logo_src = get_term_meta( $this->id, 'agency_logo', true );
		if ( ! empty( $logo_src ) && is_array( $logo_src ) ) {
			if ( ! empty( $logo_src['id'] ) ) {
				return $logo_src['id'];
			}
		}

		return false;
	}


	public function get_description() {
		return $this->agency->description;
	}

	public function get_content() {
		return get_term_meta( $this->id, 'agency_des', true );
	}

	public function get_address() {
		return get_term_meta( $this->id, 'agency_address', true );
	}

	public function get_map_address() {
		return get_term_meta( $this->id, 'agency_map_address', true );
	}

	public function get_location() {
		$address = $this->get_map_address();
		if ( is_array( $address ) && isset( $address['location'] ) && ! empty( $address['location'] ) ) {
			$location = explode( ',', $address['location'] );
			return array(
				'lat' => $location[0],
				'lng' => $location[1]
			);
		}
		return false;
	}

	public function get_data_location_attributes() {
		$location   = $this->get_location();
		if ( $location ) {
			$thumb      = wp_get_attachment_image_url($this->get_image_id());
			$address    = $this->get_address();
			$attributes = array(
				'id'       => $this->get_id(),
				'title'    => $this->get_name(),
				'position' => $location,
				'url'      => $this->get_link(),
				'thumb'    => $thumb,
				'address'  => $address,
			);
			return apply_filters( 'g5ere_agency_location_data_attributes', $attributes );
		}
		return false;
	}



	public function get_map_address_url(  ) {
		$address  = $this->get_address();
		$location = $this->get_map_address();
		if ( $location ) {
			$google_map_address_url = "//maps.google.com/?q=" . $location['address'];
		} else {
			$google_map_address_url = "//maps.google.com/?q=" . $address;
		}
		return $google_map_address_url;
	}

	public function get_email() {
		return get_term_meta( $this->id, 'agency_email', true );
	}

	public function get_mobile() {
		return get_term_meta( $this->id, 'agency_mobile_number', true );
	}

	public function get_website_url() {
		return get_term_meta( $this->id, 'agency_website_url', true );
	}

	public function get_fax_number() {
		return get_term_meta( $this->id, 'agency_fax_number', true );
	}

	public function get_licenses() {
		return get_term_meta( $this->id, 'agency_licenses', true );
	}

	public function get_office_number() {
		return get_term_meta( $this->id, 'agency_office_number', true );
	}

	public function get_vimeo_url() {
		return get_term_meta( $this->id, 'agency_vimeo_url', true );
	}


	public function get_social() {
		$agency_facebook_url  = get_term_meta( $this->id, 'agency_facebook_url', true );
		$agency_twitter_url   = get_term_meta( $this->id, 'agency_twitter_url', true );
		$agency_linkedin_url  = get_term_meta( $this->id, 'agency_linkedin_url', true );
		$agency_pinterest_url = get_term_meta( $this->id, 'agency_pinterest_url', true );
		$agency_instagram_url = get_term_meta( $this->id, 'agency_instagram_url', true );
		$agency_skype         = get_term_meta( $this->id, 'agency_skype', true );
		$agency_youtube_url   = get_term_meta( $this->id, 'agency_youtube_url', true );
		$agency_vimeo_url   = get_term_meta( $this->id, 'agency_vimeo_url', true );
		$social               = array();
		if ( ! empty( $agency_twitter_url ) ) {
			$social['twitter'] = array(
				'title'    => esc_html__( 'Twitter', 'g5-ere' ),
				'content'  => $agency_twitter_url,
				'icon'     => '<i class="fab fa-twitter"></i>',
				'priority' => 1
			);
		}
		if ( ! empty( $agency_facebook_url ) ) {
			$social['facebook'] = array(
				'title'    => esc_html__( 'Facebook', 'g5-ere' ),
				'content'  => $agency_facebook_url,
				'icon'     => '<i class="fab fa-facebook-f"></i>',
				'priority' => 2
			);
		}
		if ( ! empty( $agency_instagram_url ) ) {
			$social['instagram'] = array(
				'title'    => esc_html__( 'Instagram', 'g5-ere' ),
				'content'  => $agency_instagram_url,
				'icon'     => '<i class="fab fa-instagram"></i>',
				'priority' => 3
			);
		}
		if ( ! empty( $agency_linkedin_url ) ) {
			$social['linkin'] = array(
				'title'    => esc_html__( 'Linkin', 'g5-ere' ),
				'content'  => $agency_linkedin_url,
				'icon'     => '<i class="fab fa-linkedin-in"></i>',
				'priority' => 4
			);
		}
		if ( ! empty( $agency_pinterest_url ) ) {
			$social['pinterest'] = array(
				'title'    => esc_html__( 'Pinterest', 'g5-ere' ),
				'content'  => $agency_pinterest_url,
				'icon'     => '<i class="fab fa-pinterest-p"></i>',
				'priority' => 5
			);
		}
		if ( ! empty( $agency_skype ) ) {
			$social['skype'] = array(
				'title'    => esc_html__( 'Skype', 'g5-ere' ),
				'content'  => $agency_skype,
				'icon'     => '<i class="fab fa-skype"></i>',
				'priority' => 6
			);
		}
		if ( ! empty( $agency_youtube_url ) ) {
			$social['youtube'] = array(
				'title'    => esc_html__( 'Youtube', 'g5-ere' ),
				'content'  => $agency_youtube_url,
				'icon'     => '<i class="fab fa-youtube"></i>',
				'priority' => 7
			);
		}

		if ( ! empty( $agency_vimeo_url ) ) {
			$social['vimeo'] = array(
				'title'    => esc_html__( 'Vimeo', 'g5-ere' ),
				'content'  => $agency_vimeo_url,
				'icon'     => '<i class="fab fa-vimeo"></i>',
				'priority' => 8
			);
		}

		$social = apply_filters( 'g5ere_loop_agency_social', $social );

		uasort( $social, 'g5ere_sort_by_order_callback' );

		return $social;
	}

	public function get_thumbnail_data( $args = array() ) {
		$args = wp_parse_args( $args, array(
			'image_size'         => 'thumbnail',
			'animated_thumbnail' => true,
			'placeholder'        => '',
		) );


		$thumbnail_id = $this->get_image_id();
		$cache_id     = "thumbnail_{$thumbnail_id}_{$args['image_size']}";
		if ( ! empty( $thumbnail_id ) ) {
			$data = G5CORE()->cache()->get_cache_listing( $cache_id );
			if ( ! is_null( $data ) ) {
				return $data;
			}
		}

		$thumbnail = array(
			'id'              => '',
			'url'             => '',
			'width'           => '',
			'height'          => '',
			'alt'             => '',
			'caption'         => '',
			'description'     => '',
			'title'           => g5core_the_title_attribute( array( 'echo' => false ) ),
			'skip_smart_lazy' => false
		);


		if ( ! empty( $thumbnail_id ) ) {
			$thumbnail = g5core_get_image_data( array(
				'image_id'           => $thumbnail_id,
				'image_size'         => $args['image_size'],
				'animated_thumbnail' => $args['animated_thumbnail']
			) );

			if ( empty( $thumbnail['alt'] ) ) {
				$thumbnail['alt'] = g5core_the_title_attribute( array( 'echo' => false ) );
			}

			G5CORE()->cache()->set_cache_listing( $cache_id, $thumbnail );

			return $thumbnail;
		}

		$placeholder = $args['placeholder'] !== '' ? $args['placeholder'] : G5ERE()->options()->get_option( 'agency_placeholder_enable' );
		if ( $placeholder === 'on' ) {
			$placeholder_img    = G5ERE()->options()->get_option( 'agency_placeholder_image' );
			$placeholder_img_id = isset( $placeholder_img['id'] ) ? $placeholder_img['id'] : '';
			if ( ! empty( $placeholder_img_id ) ) {
				$thumbnail = g5core_get_image_data( array(
					'image_id'           => $placeholder_img_id,
					'image_size'         => $args['image_size'],
					'animated_thumbnail' => $args['animated_thumbnail']
				) );
				G5CORE()->cache()->set_cache_listing( $cache_id, $thumbnail );

				return $thumbnail;
			}
			$thumbnail['url'] = G5ERE()->plugin_url( 'assets/images/no-image.png' );
			if ( preg_match( '/x/', $args['image_size'] ) ) {
				$image_size          = preg_split( '/x/', $args['image_size'] );
				$image_width         = $image_size[0];
				$image_height        = $image_size[1];
				$thumbnail['width']  = $image_width;
				$thumbnail['height'] = $image_height;
			}

		}

		if ( ! empty( $thumbnail_id ) ) {
			G5CORE()->cache()->set_cache_listing( $cache_id, $thumbnail );
		}

		return $thumbnail;
	}

	public function render_thumbnail_markup( $args = array() ) {
		$args = wp_parse_args( $args, array(
			'image_id'           => '',
			'image_size'         => 'thumbnail',
			'image_ratio'        => '',
			'animated_thumbnail' => true,
			'display_permalink'  => false,
			'image_mode'         => '',
			'placeholder'        => '',
			'placeholder_url'    => G5ERE()->plugin_url( 'assets/images/no-image.png' ),
		) );

		if ( $this->get_image_id() != false ) {
			$args['image_id'] = $this->get_image_id();
		}
		if ( $args['display_permalink'] == true ) {
			$args['permalink'] = $this->get_link();
		}

		$placeholder = $args['placeholder'] !== '' ? $args['placeholder'] : G5ERE()->options()->get_option( 'agency_placeholder_enable', 'on' );
		if ( $placeholder === 'on' ) {
			$args['placeholder']    = 'on';
			$placeholder_img        = G5ERE()->options()->get_option( 'agency_placeholder_image' );
			$placeholder_img_id     = isset( $placeholder_img['id'] ) ? $placeholder_img['id'] : '';
			$args['placeholder_id'] = $placeholder_img_id;
		}
		g5ere_render_thumbnail_markup( $args );
	}

}