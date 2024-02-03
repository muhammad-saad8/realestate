<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
if ( ! class_exists( 'G5Core_Widget' ) ) {
    class G5Core_Widget
    {
        private static $_instance;
        public static function getInstance()
        {
            if (self::$_instance == NULL) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        public function init() {
            add_action('widgets_init', array($this, 'register_sidebar'));
            add_action( 'in_widget_form', array($this,'custom_css_form'), 10, 3 );
            add_filter( 'widget_update_callback', array($this,'custom_css_update'), 10, 2 );

            add_action( 'wp_loaded', array($this,'custom_css_frontend_hook') );
        }

        public function register_sidebar() {
            $sidebars = apply_filters('g5core_sidebars', array(
                array(
                    'name' => esc_html__("Off Canvas", 'g5-core'),
                    'id' => 'g5core-off-canvas',
                ),
            ));

            foreach ($sidebars as $sidebar) {
                register_sidebar(array(
                    'name' => $sidebar['name'],
                    'id' => $sidebar['id'],
                    'description' => isset($sidebar['description']) ? $sidebar['description'] : sprintf(esc_html__('Add widgets here to appear in %s sidebar', 'g5-core'), $sidebar['name']),
                    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                    'after_widget' => '</aside>',
                    'before_title' => '<h4 class="widget-title"><span>',
                    'after_title' => '</span></h4>',
                ));
            }
        }

        public function custom_css_form($widget, $return, $instance) {
            if ( !isset( $instance['css_class'] ) ) $instance['css_class'] = null;
            ?>
            <p>
                <label for="<?php echo esc_attr($widget->get_field_id( 'css_class' )); ?>"><?php esc_html_e( 'Custom Css', 'g5-core' ) ?></label>
                <input class="widefat" id="<?php echo esc_attr( $widget->get_field_id( 'css_class' )); ?>" name="<?php echo esc_attr($widget->get_field_name( 'css_class' )); ?>" type="text" value="<?php echo esc_attr( $instance['css_class'] ); ?>" />
            </p>

            <?php
        }

        public function custom_css_update($instance, $new_instance){
            $instance['css_class'] = array_key_exists('css_class',$new_instance) ? $new_instance['css_class'] : '';
            return $instance;
        }

        public function custom_css_frontend_hook() {
            if ( !is_admin() ) {
                add_filter( 'dynamic_sidebar_params', array($this,'custom_css_frontend') );
            }
        }

        public function custom_css_frontend($params) {
            global $wp_registered_widgets, $widget_number;

            $widget_id              = $params[0]['widget_id'];
            $sidebar_id              = $params[0]['id'];
            $widget_obj             = $wp_registered_widgets[$widget_id];
            $widget_num             = $widget_obj['params'][0]['number'];
            $widget_opt             = null;

            // if Widget Logic plugin is enabled, use it's callback
            if ( in_array( 'widget-logic/widget_logic.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
                $widget_logic_options = get_option( 'widget_logic' );
                if ( isset( $widget_logic_options['widget_logic-options-filter'] ) && 'checked' == $widget_logic_options['widget_logic-options-filter'] ) {
                    $widget_opt = get_option( $widget_obj['callback_wl_redirect'][0]->option_name );
                } else {
                    $widget_opt = get_option( $widget_obj['callback'][0]->option_name );
                }

                // if Widget Context plugin is enabled, use it's callback
            } elseif ( in_array( 'widget-context/widget-context.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
                $callback = isset($widget_obj['callback_original_wc']) ? $widget_obj['callback_original_wc'] : null;
                $callback = !$callback && isset($widget_obj['callback']) ? $widget_obj['callback'] : null;

                if ($callback && is_array($widget_obj['callback'])) {
                    $widget_opt = get_option( $callback[0]->option_name );
                }
            }
            // Default callback
            else {
                // Check if WP Page Widget is in use
                global $post;
                $id = ( isset( $post->ID ) ? get_the_ID() : NULL );
                if ( isset( $id ) && get_post_meta( $id, '_customize_sidebars' ) ) {
                    $custom_sidebarcheck = get_post_meta( $id, '_customize_sidebars' );
                }
                if ( isset( $custom_sidebarcheck[0] ) && ( $custom_sidebarcheck[0] == 'yes' ) ) {
                    $widget_opt = get_option( 'widget_'.$id.'_'.substr($widget_obj['callback'][0]->option_name, 7) );
                } elseif ( isset( $widget_obj['callback'][0]->option_name ) ) {
                    $widget_opt = get_option( $widget_obj['callback'][0]->option_name );
                }
            }


            if ( isset( $widget_opt[$widget_num]['css_class']) ) {
                $custom_css = $widget_opt[$widget_num]['css_class'];
                $params[0]['before_widget'] = preg_replace( '/class="/', "class=\"{$custom_css} ", $params[0]['before_widget'], 1 );
            }

            /*if ($sidebar_id === 'woocommerce-filter') {
                $custom_css = G5P()->helper()->get_bootstrap_columns(array(
                    'xl' => G5P()->options()->get_filter_columns(),
                    'lg' => G5P()->options()->get_filter_columns_md(),
                    'md' => G5P()->options()->get_filter_columns_sm(),
                    'sm' => G5P()->options()->get_filter_columns_xs(),
                    '' => G5P()->options()->get_filter_columns_mb()
                ));
                $params[0]['before_widget'] = preg_replace( '/class="/', "class=\"{$custom_css} ", $params[0]['before_widget'], 1 );

            }*/

            $params[0]['before_widget'] = apply_filters('g5core_before_widget',$params[0]['before_widget'],$sidebar_id,$widget_num,  $widget_opt);
            return $params;
        }


    }
}