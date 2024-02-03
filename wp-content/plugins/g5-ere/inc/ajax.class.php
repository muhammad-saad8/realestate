<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! class_exists( 'G5ERE_Ajax' ) ) {
	class G5ERE_Ajax {
		private static $_instance;

		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init() {
			add_action( 'wp_ajax_g5ere_get_price_on_status_change', array( $this, 'get_price_on_status_change' ) );
			add_action( 'wp_ajax_nopriv_g5ere_get_price_on_status_change', array($this,'get_price_on_status_change') );

			add_action('wp_ajax_g5ere_get_auto_complete_search',array($this,'get_auto_complete_search'));
			add_action('wp_ajax_nopriv_g5ere_get_auto_complete_search',array($this,'get_auto_complete_search'));

			add_action('wp_ajax_g5ere_get_location_data',array($this,'g5ere_get_location_data'));
			add_action('wp_ajax_nopriv_g5ere_get_location_data',array($this,'g5ere_get_location_data'));



		}

		public function get_price_on_status_change() {
			$price_is_slider         = isset( $_POST['price_is_slider'] ) ? ere_clean( wp_unslash( $_POST['price_is_slider'] ) ) : '';
			$price_slider_range_html = '';
			$max_price_html          = '';
			$min_price_html          = '';
			if ( $price_is_slider === 'true' ) {
				ob_start();
				G5ERE()->get_template( 'search-fields/price-range.php' );
				$price_slider_range_html = ob_get_clean();
			} else {
				ob_start();
				G5ERE()->get_template( 'search-fields/max-price.php' );
				$max_price_html = ob_get_clean();
				ob_start();
				G5ERE()->get_template( 'search-fields/min-price.php' );
				$min_price_html = ob_get_clean();
			}

			wp_send_json( array(
				'price_slider_range_html' => $price_slider_range_html,
				'min_price_html'          => $min_price_html,
				'max_price_html'          => $max_price_html
			) );
			die();
		}

		public function get_auto_complete_search() {
            check_ajax_referer('g5ere_get_auto_complete_search');
			$keyword = isset($_REQUEST['keyword']) ? $_REQUEST['keyword'] : '';
			if (empty($keyword)) {
				wp_send_json_error();
			}

            $args = G5ERE()->query()->get_property_query_args(array (
                'posts_per_page'      => 6,
            ));
            $parameter = G5ERE()->query()->get_data();
            $parameter = wp_parse_args($parameter,array(
                's' => '',
                'post_type' => 'property'
            ));

            $view_all_link = get_post_type_archive_link('property') ;
            $view_all_link = add_query_arg($parameter,$view_all_link);
			$args = apply_filters('g5ere_auto_complete_search_args',$args);
			$query = new WP_Query($args);
			?>
				<?php if ($query->have_posts()): ?>
					<ul class="g5ere__sf-auto-complete-list p-0 m-0">
						<?php while ($query->have_posts()): $query->the_post(); ?>
							<li class="dropdown-item">
								<div class="g5ere__property-auto-complete-item d-flex align-items-center media">
									<div class="g5core__post-featured g5ere__property-featured">
										<?php g5ere_render_property_thumbnail_markup( array(
											'image_size'     => 'thumbnail',
										) ); ?>
									</div>
									<div class="g5ere__property-content media-body">
										<?php
										/**
										 * Hook: g5ere_loop_property_content_auto_complete_search.
										 *
										 * @hooked g5ere_template_loop_property_title - 5
										 * @hooked g5ere_template_loop_property_address - 10
										 */
										do_action('g5ere_loop_property_content_auto_complete_search');
										?>
									</div>
								</div>

							</li>
						<?php endwhile; ?>
						</ul>
					<div class="g5ere__sf-auto-complete-footer d-flex flex-wrap align-items-center justify-content-between">
						<span class="g5ere__sf-auto-complete-count"><i class="fal fa-map-marker-alt mr-1"></i> <?php echo sprintf(esc_html__('%d Listings found','g5-ere'),$query->found_posts)  ?> </span>
						<a class="g5ere__sf-auto-complete-view" target="_blank" href="<?php echo esc_url($view_all_link)?>" ><?php echo esc_html__('View All Results','g5-ere') ?></a>
					</div>
				<?php else: ?>
				<ul class="g5ere__sf-auto-complete-list p-0 m-0">
					<li class="dropdown-item nothing"><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with different keywords.', 'g5-ere'); ?></li>
				</ul>
				<?php endif; ?>
			<?php
			wp_reset_postdata();
			wp_die();

		}


		public function g5ere_get_location_data() {
			$type = isset($_GET['type']) ? ere_clean(wp_unslash($_GET['type'])) : 'state';
			$taxonomy = '';
			$all_label = '';
			if ($type === 'state') {
				$taxonomy = 'property-state';
				$all_label = esc_html__('All States', 'g5-ere');
			} elseif ($type === 'city') {
				$taxonomy = 'property-city';
				$all_label = esc_html__('All Cities', 'g5-ere');
			} elseif ($type === 'neighborhood') {
				$taxonomy = 'property-neighborhood';
				$all_label = esc_html__('All Neighborhoods', 'g5-ere');
			} elseif ($type === 'country') {
				$all_label = esc_html__('All Countries', 'g5-ere');
			}

			$data = [];
			if ($type === 'country') {
				$countries = ere_get_selected_countries();
				foreach ($countries as $k => $v) {
					$data[] = [
						'value' => $k,
						'label' => $v,
						'belong' => '',
						'subtext' => ''
					];
				}

			} else {
				$prop_terms = get_terms(array(
						'taxonomy' => $taxonomy,
						'orderby' => 'name',
						'order' => 'ASC',
						'hide_empty' => false,
						'parent' => 0
					)
				);

				$data =  g5ere_hirarchical_options_data($taxonomy, $prop_terms);
			}

			$data = wp_parse_args($data,[[
				'value' => '',
				'label' => $all_label,
				'belong' => '',
				'subtext' => ''
			]]);
			wp_send_json_success($data);
		}
	}
}