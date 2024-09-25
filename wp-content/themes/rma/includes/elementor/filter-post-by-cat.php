<?php
if (!class_exists('Rma_Elementor_Filter_Post_By_Cat')) {
    class Rma_Elementor_Filter_Post_By_Cat extends Rma_Elementor
    {
        public $name = 'rma-filter-post-by-cat';
        public $title = 'Filter Post By Cat';
        public $icon = 'eicon-filter';

         // Register widget style and script dependencies
         public function get_style_depends() {
            return ['swiper-bundle-min-css', 'rma-filter-post-by-cat-css'];
        }

        public function get_script_depends() {
            return ['swiper-bundle-min-js', 'rma-filter-post-by-cat-js'];
        }

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
            $widget_id = $this->get_id();
            $args = [
                'post_type' => $post_type,
                'posts_per_page' => -1,
                'orderby' => 'date',
                'order' => 'DESC',
                'post_status' => 'publish'
            ];
    
            $query = new WP_Query( $args );
            $categories = array();
            $taxonomy_name = '';
    
            if ($query->have_posts()) {
                ?>
                <div class="filter-post-by-cat filter-post-by-cat-<?= $widget_id; ?>">
                    <?php
                    while ( $query->have_posts() ) {
                        $query->the_post();
                        $taxonomies = get_object_taxonomies(get_post_type(), 'objects');
                        foreach ($taxonomies as $taxonomy) {
                            if ($taxonomy->hierarchical) {
                                $taxonomy_name = $taxonomy->name;
                                $post_categories = wp_get_post_terms(get_the_ID(), $taxonomy->name);

                                foreach ( $post_categories as $category ) {
                                    if (!array_key_exists($category->term_id, $categories)) {
                                        $categories[$category->term_id] = $category;
                                    }
                                }
                            }
                        }
                    }
                    if ( ! empty( $categories ) ) { ?>
                        <div class="filters">
                            <div class="category-filter">
                                <?php
                                foreach ( $categories as $term ) {
                                    echo '<div class="item"><a href="#" data-taxonomy="'.$taxonomy_name.'" data-category="'.$term->slug.'">'.$term->name.'</a></div>';
                                }
                                ?>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="post-list">
                        <div class="swiper">
                            <div class="swiper-wrapper">
                                <?php
                                while ($query->have_posts()) {
                                    $query->the_post();
                                    ?>
                                    <div class="logo-item swiper-slide">
                                        <div class="logo-inner">
                                            <div class="logo">
                                                <?php
                                                if (get_post_thumbnail_id()) {
                                                    echo wp_get_attachment_image(get_post_thumbnail_id(), 'full');
                                                } else {
                                                    echo '<img src="' . get_stylesheet_directory_uri() . '/assets/images/default-img.svg" width="auto" height="auto" alt="' . get_the_title() . '"/>';
                                                } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-pagination"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                    <script>
                        jQuery(document).ready(function ($) {

                            $('.filter-post-by-cat-<?= $widget_id; ?> .category-filter .item:first-child a').click();

                            // Initialize Swiper
                            var latestNews;
            
                            function initializeSwiper() {
                                if ($('.filter-post-by-cat-<?= $widget_id; ?> .swiper').length) {
                                    latestNews = new Swiper('.filter-post-by-cat-<?= $widget_id; ?> .swiper', {
                                        slidesPerView: 2,
                                        grid: {
                                            rows: 6,
                                        },
                                        spaceBetween: 20,
                                        autoplay: {
                                            delay: 5000,
                                            disableOnInteraction: false,
                                        },
                                        pagination: {
                                            el: '.filter-post-by-cat-<?= $widget_id; ?> .swiper-pagination',
                                            clickable: true,
                                        },
                                        navigation: {
                                            nextEl: '.filter-post-by-cat-<?= $widget_id; ?> .swiper-button-next',
                                            prevEl: '.filter-post-by-cat-<?= $widget_id; ?> .swiper-button-prev',
                                        },
                                        breakpoints: {
                                            768: {
                                                slidesPerView: 3,
                                                grid: {
                                                    rows: 3,
                                                }
                                            },
                                        },
                                        loop: true,
                                        loopFillGroupWithBlank: true
                                    });
                                }
                            }
            
                            // Call initializeSwiper on page load
                            initializeSwiper();
            
                            // Add click event listener for category buttons
                            $('.filter-post-by-cat-<?= $widget_id; ?> .category-filter a').on('click', function (e) {
                                e.preventDefault();
                                $('.filter-post-by-cat-<?= $widget_id; ?> .category-filter a').removeClass('active');
                                $('.filter-post-by-cat-<?= $widget_id; ?> .category-filter>div').removeClass('active');
                                $(this).addClass('active').parent().addClass('active');
                                $('.filter-post-by-cat-<?= $widget_id; ?> .post-list').addClass('loading');
                                const category = $(this).data('category');
                                const taxonomy = $(this).data('taxonomy');
                                const post_type = '<?= $post_type ?>';
                                var text = $(this).text();
                                $('.filter-post-by-cat-<?= $widget_id; ?> .filters .label-mb span').text(text);
                                $('.filter-post-by-cat-<?= $widget_id; ?> .category-filter').slideToggle();
                                fetchPosts(post_type, taxonomy, category);
                            });
            
                            $(document).click(function(event) {
                                if (!$(event.target).closest(".filter-post-by-cat-<?= $widget_id; ?> .filters").length) {
                                    $(".filter-post-by-cat-<?= $widget_id; ?> .category-filter").slideUp();
                                }
                            });
            
                            // Function to fetch posts based on category
                            function fetchPosts(post_type, taxonomy, category) {
                                const ajaxUrl = '<?php echo admin_url('admin-ajax.php'); ?>';
            
                                $.ajax({
                                    url: ajaxUrl,
                                    method: 'GET',
                                    data: {
                                        action: 'filter_posts_by_cat',
                                        category: category,
                                        post_type: post_type,
                                        taxonomy_name: taxonomy,
                                    },
                                    dataType: 'json',
                                    success: function (data) {
                                        updateSlider(data.posts);
                                    },
                                    error: function (error) {
                                        console.error('Error fetching posts:', error);
                                    },
                                });
                            }
            
                            // Function to update Swiper with new posts
                            function updateSlider(posts) {
                                if (latestNews) {
                                    latestNews.destroy(true, true);
                                }
            
                                const swiperWrapper = $('.filter-post-by-cat-<?= $widget_id; ?> .swiper-wrapper');
                                swiperWrapper.empty();
            
                                $.each(posts, function (index, post) {
                                    const slide = $('<div>').addClass('logo-item swiper-slide').html(`
                                        <div class="logo-inner">
                                            <div class="logo">
                                                ${post.image}
                                            </div>
                                        </div>
                                    `);
                                    swiperWrapper.append(slide);
                                });
            
                                // Reinitialize Swiper after updating the slides
                                initializeSwiper();
                            }
                        });
                    </script>
                </div>
                <?php
            }
            wp_reset_postdata();
        }
    }
}