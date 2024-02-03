<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
if (!class_exists('G5Blog_Widget_Post')) {
    class G5Blog_Widget_Post extends GSF_Widget {
        public function __construct()
        {
            $this->widget_cssclass = 'g5blog__widget-post';
            $this->widget_id = 'g5blog__post';
            $this->widget_name = esc_html__('G5Plus: Post', 'g5-blog');
            $this->settings = array(
                'fields' => array(
                    array(
                        'id'      => 'title',
                        'title'   => esc_html__('Title', 'g5-blog'),
                        'type'    => 'text',
                        'default' => esc_html__( 'Recent Post', 'g5-blog' ),
                    ),
                    array(
                        'id'      => 'source',
                        'type'    => 'select',
                        'title'   => esc_html__('Source', 'g5-blog'),
                        'default' => 'recent',
                        'options' => array(
                            'random'   => esc_html__('Random', 'g5-blog'),
                            'popular'  => esc_html__('Popular', 'g5-blog'),
                            'recent'   => esc_html__('Recent', 'g5-blog'),
                            'oldest'   => esc_html__('Oldest', 'g5-blog'),
                        )
                    ),
                    array(
                        'id'         => 'posts_per_page',
                        'type'       => 'text',
                        'input_type' => 'number',
                        'title'      => esc_html__('Number of posts to show:', 'g5-blog'),
                        'default'    => '4',
                    ),
                )
            );
            parent::__construct();
        }

        function widget($args, $instance)
        {
            if ($this->get_cached_widget($instance)) {
                return;
            }
            extract($args, EXTR_SKIP);
            $source = (!empty($instance['source'])) ? $instance['source'] : 'recent';
            $posts_per_page = (!empty($instance['posts_per_page'])) ? absint($instance['posts_per_page']) : 4;

            $query_args = array(
                'posts_per_page'      => $posts_per_page,
                'no_found_rows'       => true,
                'post_status'         => 'publish',
                'ignore_sticky_posts' => true,
                'post_type'           => 'post',
            );

            $query_order_args = array();
            switch ($source) {
                case 'random' :
                    $query_order_args = array(
                        'orderby' => 'rand',
                        'order'   => 'DESC',
                    );
                    break;
                case 'popular':
                    $query_order_args = array(
                        'orderby' => 'comment_count',
                        'order'   => 'DESC',
                    );
                    break;
                case 'recent':
                    $query_order_args = array(
                        'orderby' => 'post_date',
                        'order'   => 'DESC',
                    );
                    break;
                case 'oldest':
                    $query_order_args = array(
                        'orderby' => 'post_date',
                        'order'   => 'ASC',
                    );
                    break;
            }
            $query_args = array_merge($query_args, $query_order_args);
            G5CORE()->query()->query_posts($query_args);
            ob_start();
            if (G5CORE()->query()->have_posts()) {
                $this->widget_start($args,$instance);
                echo wp_kses_post( apply_filters( 'g5blog_before_widget_post_list', '<div class="g5blog__widget-post-list">' ) );
                while (G5CORE()->query()->have_posts()) {
                    G5CORE()->query()->the_post();
                    G5BLOG()->get_template('content-widget.php');
                }
                echo wp_kses_post( apply_filters( 'g5blog_after_widget_post_list', '</div>' ) );
                $this->widget_end($args);
            }
            G5CORE()->query()->reset_query();
            echo $this->cache_widget( $args, ob_get_clean() ); // WPCS: XSS ok.
        }
    }
}