<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class News_Grid_Widget extends \Elementor\Widget_Base {

    // Define widget name for internal use
    public function get_name() {
        return 'news_grid_widget';
    }

    // Define widget title displayed in the Elementor panel
    public function get_title() {
        return __( 'News Grid', 'plugin-name' );
    }

    // Set the icon for the widget displayed in Elementor
    public function get_icon() {
        return 'eicon-post-list';
    }

    // Specify the category where the widget will appear in Elementor
    public function get_categories() {
        return [ 'general' ];
    }

    // Register the widget controls (input fields)
    protected function _register_controls() {

        // Start section for main content (heading, content, post list, explore link)
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'plugin-name' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Add a text field for the heading
        $this->add_control(
            'heading',
            [
                'label' => __( 'Heading', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'News Heading', 'plugin-name' ),
            ]
        );

        // Add a WYSIWYG editor for the main content
        $this->add_control(
            'content',
            [
                'label' => __( 'Content', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => __( 'Your content goes here', 'plugin-name' ),
            ]
        );

        // Add a post selector that allows multiple post selections
        $this->add_control(
            'post_list',
            [
                'label' => __( 'List of Posts', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => $this->get_available_posts(),
                'multiple' => true,
                'label_block' => true,
            ]
        );

        // Add a URL field for Explore More link with custom text input
        $this->add_control(
            'explore_link',
            [
                'label' => __( 'Explore More Link', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __( 'https://your-link.com', 'plugin-name' ),
                'options' => [ 'is_external', 'nofollow' ],
            ]
        );

        // Add a custom text field for Explore More link text
        $this->add_control(
            'explore_link_text',
            [
                'label' => __( 'Custom Text for Explore More Link', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __( 'Click here to explore', 'plugin-name' ),
            ]
        );

        // End of main content section
        $this->end_controls_section();

        // Start section for bottom content (image, heading, content, and Link Bottom)
        $this->start_controls_section(
            'bottom_section',
            [
                'label' => __( 'Bottom Section', 'plugin-name' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Add a field to upload an image for the bottom section
        $this->add_control(
            'bottom_image',
            [
                'label' => __( 'Image Bottom', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
            ]
        );

        // Add a text field for the bottom heading
        $this->add_control(
            'bottom_heading',
            [
                'label' => __( 'Heading Bottom', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Bottom Heading', 'plugin-name' ),
            ]
        );

        // Add a WYSIWYG editor for the bottom content
        $this->add_control(
            'bottom_content',
            [
                'label' => __( 'Content Bottom', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => __( 'Your bottom content goes here', 'plugin-name' ),
            ]
        );

        // Add a URL field for Link Bottom with custom text input
        $this->add_control(
            'bottom_link',
            [
                'label' => __( 'Bottom Link', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __( 'https://your-bottom-link.com', 'plugin-name' ),
                'options' => [ 'is_external', 'nofollow' ],
            ]
        );

        // Add a custom text field for Bottom Link text
        $this->add_control(
            'bottom_link_text',
            [
                'label' => __( 'Custom Text for Bottom Link', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __( 'Click here for more', 'plugin-name' ),
            ]
        );

        // End of bottom section
        $this->end_controls_section();
    }

    // Render method to display the widget on the frontend
    protected function render() {
        // Get the settings provided by the user
        $settings = $this->get_settings_for_display();?>
        <div class="news-grid-widget">
            <div clas="container">
                <div class="heading-content">
                    <?php
                    // Display the Heading field if set
                    if ( ! empty( $settings['heading'] ) ) {
                        echo '<div class="entry-title"><h2>' . $settings['heading'] . '</h2></div>';
                    }
    
                    // Display the main content if set (WYSIWYG editor output)
                    if ( ! empty( $settings['content'] ) ) {
                        echo '<div class="news-content">' . $settings['content'] . '</div>';
                    }?>
                </div>

                <div class="list-post">
                    <?php
                    // Display the list of selected posts
                    if ( ! empty( $settings['post_list'] ) ) {
                        echo '<ul class="news-posts">';
                        $post_count = 0; // Initialize post counter
                        foreach ( $settings['post_list'] as $post_id ) {
                            $post = get_post( $post_id );
                            // Check if we're starting a new list item
                            if ($post_count % 2 == 0) {
                                echo '<li>'; // Open <li> for every two posts
                            }
                                echo '<div class="item-post" data-index="' . $post_count . '">';
                                    if ( has_post_thumbnail( $post ) ) {
                                        echo '<div class="post-thumbnail">' . get_the_post_thumbnail( $post, 'full' ) . '</div>';
                                    }
                                    // Display post date in "F j, Y" format (e.g., November 15, 2023)
                                    echo '<div class="post-date">' . get_the_date( 'F j, Y', $post ) . '</div>';
                                    echo '<h3><a href="' . get_permalink( $post ) . '">' . get_the_title( $post ) . '</a></h3>';
                                echo '</div>';

                                echo '<div class="item-sub-post item-sub-post-' . $post_count . '">';
                                    // Display post date in "F j, Y" format (e.g., November 15, 2023)
                                    echo '<div class="post-date">' . get_the_date( 'F j, Y', $post ) . '</div>';
                                    echo '<h3><a href="' . get_permalink( $post ) . '">' . get_the_title( $post ) . '</a></h3>';
                                    // Display post excerpt
                                    echo '<div class="post-excerpt">' . get_the_excerpt( $post ) . '</div>';
                                    // Display featured image if exists
                                echo '</div>';
                            // Close the <li> after every two posts
                            $post_count++;
                            if ($post_count % 2 == 0) {
                                echo '</li>'; // Close <li>
                            }
                        }
                        // If there is an odd number of posts, close the last <li> if it's still open
                        if ($post_count % 2 != 0) {
                            echo '</li>';
                        }
                        echo '</ul>';
                    }

                    // Display the "Explore More" link if the URL is set
                    if ( ! empty( $settings['explore_link']['url'] ) ) {
                        $link_text = ! empty( $settings['explore_link_text'] ) ? $settings['explore_link_text'] : __( 'Explore More', 'plugin-name' );
                        echo '<a class="explore-link" href="' . esc_url( $settings['explore_link']['url'] ) . '" target="' . ( $settings['explore_link']['is_external'] ? '_blank' : '_self' ) . '">' . $link_text . '</a>';
                    }?>
                </div>
                
                <!-- <div class="section-bottom">
                    <div class="col col-left"> -->
                        <?php
                        // // Display the bottom image if provided
                        // if ( ! empty( $settings['bottom_image']['url'] ) ) {
                        //     echo '<img src="' . esc_url( $settings['bottom_image']['url'] ) . '" alt="">';
                        // }?>
                    <!-- </div> -->
                    <!-- <div class="col col-right"> -->
                        <?php
                        // // Display the bottom heading if set
                        // if ( ! empty( $settings['bottom_heading'] ) ) {
                        //     echo '<h3>' . $settings['bottom_heading'] . '</h3>';
                        // }

                        // // Display the bottom content if set (WYSIWYG editor output)
                        // if ( ! empty( $settings['bottom_content'] ) ) {
                        //     echo '<div class="bottom-content">' . $settings['bottom_content'] . '</div>';
                        // }

                        // // Display the "Bottom Link" if the URL is set
                        // if ( ! empty( $settings['bottom_link']['url'] ) ) {
                        //     $bottom_link_text = ! empty( $settings['bottom_link_text'] ) ? $settings['bottom_link_text'] : __( 'Learn More', 'plugin-name' );
                        //     echo '<a class="bottom-link" href="' . esc_url( $settings['bottom_link']['url'] ) . '" target="' . ( $settings['bottom_link']['is_external'] ? '_blank' : '_self' ) . '">' . $bottom_link_text . '</a>';
                        // }?>
                    <!-- </div>
                </div> -->
            </div>
        </div>
        <?php
    }

    // Helper method to get available posts for the post selector field
    private function get_available_posts() {
        // Fetch all posts of type 'post'
        $posts = get_posts( [
            'post_type' => 'post',
            'numberposts' => -1, // Fetch all posts
        ] );

        // Prepare an associative array of post ID => post title
        $options = [];
        foreach ( $posts as $post ) {
            $options[ $post->ID ] = $post->post_title;
        }

        return $options; // Return the post options for the Select2 field
    }
}