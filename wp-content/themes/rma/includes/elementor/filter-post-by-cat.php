<?php
if (!class_exists('Rma_Elementor_Filter_Post_By_Cat')) {
    class Rma_Elementor_Filter_Post_By_Cat extends Rma_Elementor
    {
        public $name = 'rma-filter-post-by-cat';
        public $title = 'Filter Post By Cat';
        public $icon = 'eicon-filter';

        /**
         * Register the widget controls.
         *
         * Adds different input fields to allow the user to change and customize the widget settings.
         *
         * @since 1.0.0
         *
         * @access protected
         */
        protected function _register_controls() {
            $this->start_controls_section(
                'content_section',
                [
                    'label' => __( 'Content', 'rma' ),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
            );
    
            $this->add_control(
                'post_type',
                [
                    'label' => __( 'Post Type', 'rma' ),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => $this->get_post_types(),
                    'default' => 'post',
                ]
            );
    
            $this->end_controls_section();
        }
    
        protected function get_post_types() {
            $post_types = get_post_types( [ 'public' => true ], 'objects' );
            $options = [];
            foreach ( $post_types as $post_type ) {
                $options[ $post_type->name ] = $post_type->label;
            }
            return $options;
        }
    
        protected function render() {
            $settings = $this->get_settings_for_display();
            $post_type = $settings['post_type'];
    
            $args = [
                'post_type' => $post_type,
            ];
    
            $query = new \WP_Query( $args );
    
            if ( $query->have_posts() ) {
                echo '<div class="custom-post-type-widget">';
                while ( $query->have_posts() ) {
                    $query->the_post();
                    echo '<div class="post-item">';
                    echo '<h3>' . get_the_title() . '</h3>';
                    echo '</div>';
                }
                echo '</div>';
            } else {
                echo __( 'No posts found.', 'rma' );
            }
            wp_reset_postdata();
        }
    }
}