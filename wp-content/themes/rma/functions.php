<?php
if (!isset($content_width)) $content_width = 900;
if (!class_exists('Rma_Functions')) {
    class Rma_Functions
    {
        /**
         * @var Rma_Functions The one true Rma_Functions
         * @since 1.0
         */
        private static $instance;

        public static function instance()
        {
            if (!isset(self::$instance) && !(self::$instance instanceof Rma_Functions)) {
                self::$instance = new Rma_Functions;
            }
            add_action('after_setup_theme', array(self::$instance, 'rma_setup'));
            add_action('widgets_init', array(self::$instance, 'rma_widgets_init'));
            add_action('wp_enqueue_scripts', array(self::$instance, 'rma_enqueue_scripts'));
            add_filter('get_default_comment_status', array(self::$instance, 'rma_open_default_comments_for_page'), 10, 3);
            add_filter('comment_form_fields', array(self::$instance, 'rma_move_comment_field_to_bottom'), 10, 3);
            add_action('upload_mimes', array(self::$instance, 'rma_add_file_types_to_uploads'));
            self::rma_includes();

            return self::$instance;
        }

        public function rma_setup()
        {
            load_theme_textdomain('rma', get_template_directory() . '/languages');
            add_theme_support('custom-logo');
            add_theme_support('automatic-feed-links');
            add_theme_support('title-tag');
            add_theme_support('post-thumbnails');
            add_theme_support('custom-background');
            add_theme_support('customize-selective-refresh-widgets');
            /*This theme uses wp_nav_menu() in two locations.*/
            register_nav_menus(array(
                    'primary' => esc_html__('Primary Menu', 'rma'),
                )
            );
            add_theme_support('html5', array(
                    'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
                )
            );
        }

        public function rma_move_comment_field_to_bottom($fields)
        {
            $comment_field = $fields['comment'];
            unset($fields['comment']);
            $fields['comment'] = $comment_field;

            return $fields;
        }

        /**
         * Register widget area.
         *
         * @since rma 1.0
         *
         * @link https://codex.wordpress.org/Function_Reference/register_sidebar
         */
        function rma_widgets_init()
        {
            register_sidebar(array(
                    'name' => esc_html__('Widget Blog', 'rma'),
                    'id' => 'widget-blog',
                    'description' => esc_html__('Add widgets here to appear in your blog.', 'rma'),
                    'before_widget' => '<div id="%1$s" class="widget %2$s">',
                    'after_widget' => '</div>',
                    'before_title' => '<h2 class="widgettitle">',
                    'after_title' => '<span class="arrow"></span></h2>',
                )
            );
        }

        /**
         * Register custom fonts.
         */
        function rma_fonts_url()
        {
            /**
             * Translators: If there are characters in your language that are not
             * supported by Montserrat, translate this to 'off'. Do not translate
             * into your own language.
             */

            $fonts_url = 'https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap';

            return $fonts_url;
        }

        /**
         * Enqueue scripts and styles.
         *
         * @since rma 1.0
         */
        function rma_enqueue_scripts()
        { 
            // Add custom fonts, used in the main stylesheet.
            wp_enqueue_style('rma-fonts', self::rma_fonts_url(), array(), null);
            /* Theme stylesheet. */
            wp_enqueue_style('bootstrap', get_theme_file_uri('/assets/css/bootstrap.css'), array(), '3.3.7');
            wp_enqueue_style('style-css', get_theme_file_uri('/assets/css/style.css'), array(), '1.0');
            wp_enqueue_style('rma-main-style', get_stylesheet_uri());
            if (is_singular() && comments_open() && get_option('thread_comments')) {
                wp_enqueue_script('comment-reply');
            }
            /* SCRIPTS */
            wp_enqueue_script('bootstrap', get_theme_file_uri('/assets/js/bootstrap.min.js'), array('jquery'), '3.3.7', true);
            wp_enqueue_script('rma-script', get_theme_file_uri('/assets/js/functions.js'), array('jquery'), '1.0', true);
        }

        public static function rma_get_option($option_name, $default = '')
        {
            $get_value = isset($_GET[$option_name]) ? $_GET[$option_name] : '';
            $cs_option = null;
            if (defined('CS_VERSION')) {
                $cs_option = get_option(CS_OPTION);
            }
            if (isset($_GET[$option_name])) {
                $cs_option = $get_value;
                $default = $get_value;
            }
            $options = apply_filters('cs_get_option', $cs_option, $option_name, $default);
            if (!empty($option_name) && !empty($options[$option_name])) {
                $option = $options[$option_name];
                if (is_array($option) && isset($option['multilang']) && $option['multilang'] == true) {
                    if (defined('ICL_LANGUAGE_CODE')) {
                        if (isset($option[ICL_LANGUAGE_CODE])) {
                            return $option[ICL_LANGUAGE_CODE];
                        }
                    }
                }

                return $option;
            } else {
                return (!empty($default)) ? $default : null;
            }
        }

        /**
         * Filter whether comments are open for a given post type.
         *
         * @param string $status Default status for the given post type,
         *                             either 'open' or 'closed'.
         * @param string $post_type Post type. Default is `post`.
         * @param string $comment_type Type of comment. Default is `comment`.
         * @return string (Maybe) filtered default status for the given post type.
         */
        function rma_open_default_comments_for_page($status, $post_type, $comment_type)
        {
            if ('page' == $post_type) {
                return 'open';
            }

            return $status;
        }

        function rma_add_file_types_to_uploads($file_types)
        {
            $new_filetypes = array();
            $new_filetypes['svg'] = 'image/svg+xml';
            $file_types = array_merge($file_types, $new_filetypes);
            return $file_types;
        }
        
        public static function rma_includes()
        {
            require_once get_parent_theme_file_path('/includes/breadcrumbs.php');
            require_once get_parent_theme_file_path('/includes/blog-functions.php');
            if (class_exists('Elementor\Plugin')) {
                require_once get_template_directory() . '/includes/elementor-plugin.php';
            }
            defined('CS_ACTIVE_FRAMEWORK') or define('CS_ACTIVE_FRAMEWORK', true);
            defined('CS_ACTIVE_METABOX') or define('CS_ACTIVE_METABOX', true);
            defined('CS_ACTIVE_TAXONOMY') or define('CS_ACTIVE_TAXONOMY', false);
            defined('CS_ACTIVE_SHORTCODE') or define('CS_ACTIVE_SHORTCODE', false);
            defined('CS_ACTIVE_CUSTOMIZE') or define('CS_ACTIVE_CUSTOMIZE', false);
        }

    }
}
if (!function_exists('Rma_Functions')) {
    function Rma_Functions()
    {
        return Rma_Functions::instance();
    }

    Rma_Functions();
}

add_action('admin_head', 'rma_admin_css');
function rma_admin_css()
{
    echo '<style>
    body.upload-php {
        display: block !important;
    }
  </style>';
}
