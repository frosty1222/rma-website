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
                'order' => 'ASC',
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
                    $first_category_slug = '';
                    if ( ! empty( $categories ) ) {
                        $i = 1;
                        $first_count = 1; ?>
                        <div class="filters">
                            <?php
                            foreach ( $categories as $term ) {
                                if($first_count == 1) { ?>
                                    <div class="label-mb" <?= get_category_partner_color(term_id: $term->term_id); ?>><span><?= $term->name; ?></span></div>
                                <?php
                                }
                            $first_count++;
                            }
                            ?>
                            <div class="category-filter">
                                <?php
                                foreach ( $categories as $term ) {
                                    if($i == 1) {
                                        $first_category_slug = $term->slug;
                                        echo '<div class="item active"><a href="#" '.get_category_partner_color(term_id: $term->term_id).' data-taxonomy="'.$taxonomy_name.'" data-category="'.$term->slug.'">'.$term->name.'</a></div>';
                                    }else{
                                        echo '<div class="item"><a href="#" '.get_category_partner_color(term_id: $term->term_id).' data-taxonomy="'.$taxonomy_name.'" data-category="'.$term->slug.'">'.$term->name.'</a></div>';
                                    }
                                $i++;
                                }
                                ?>
                            </div>
                        </div>
                    <?php }
                    if ($post_type === 'post') {
                        $arg_post = [
                            'post_type' => $post_type,
                            'category_name' => $first_category_slug,
                            'posts_per_page' => -1,
                            'orderby' => 'date',
                            'order' => 'DESC',
                            'post_status' => 'publish'
                        ];
                    } else {
                        $arg_post = [
                            'post_type' => $post_type,
                            'posts_per_page' => -1,
                            'orderby' => 'date',
                            'order' => 'ASC',
                            'post_status' => 'publish',
                            'tax_query' => [
                                [
                                    'taxonomy' => $taxonomy_name,
                                    'field' => 'slug',
                                    'terms' => $first_category_slug,
                                ],
                            ],
                        ];
                    }
                    $query_post = new WP_Query( $arg_post ); ?>
                    <div class="post-list">
                        <div class="swiper mySwiper">
                            <div class="swiper-wrapper">
                                <?php
                                while ($query_post->have_posts()) {
                                    $query_post->the_post();
                                    ?>
                                    <div class="logo-item swiper-slide">
                                        <?php
                                        if (get_post_thumbnail_id()) {
                                            echo wp_get_attachment_image(get_post_thumbnail_id(), 'full');
                                        } else {
                                            echo '<img src="' . get_stylesheet_directory_uri() . '/assets/images/default-img.svg" width="auto" height="auto" alt="' . get_the_title() . '"/>';
                                        } ?>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="swiper-control">
                            <div class="swiper-button swiper-button-prev">
                                <svg width="33" height="10" viewBox="0 0 33 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4.52123 9.19065L0.505146 5.17455C0.2587 4.92811 0.2587 4.52853 0.505146 4.28209L4.52123 0.265991C4.76768 0.0195432 5.16725 0.0195432 5.4137 0.265991C5.66014 0.512438 5.66014 0.91201 5.4137 1.15846L2.4749 4.09725L31.468 4.09725C31.8166 4.09725 32.0991 4.37979 32.0991 4.72832C32.0991 5.07685 31.8166 5.35939 31.468 5.35939L2.4749 5.35939L5.4137 8.29818C5.66014 8.54463 5.66014 8.9442 5.4137 9.19065C5.16725 9.4371 4.76768 9.4371 4.52123 9.19065Z" fill="currentColor"/>
                                </svg>
                            </div>
                            <div class="swiper-pagination"></div>
                            <div class="swiper-button swiper-button-next">
                                <svg width="33" height="10" viewBox="0 0 33 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M28.1 9.19059L32.1161 5.17449C32.3625 4.92804 32.3625 4.52847 32.1161 4.28203L28.1 0.26593C27.8535 0.0194821 27.454 0.0194822 27.2075 0.26593C26.9611 0.512377 26.9611 0.911949 27.2075 1.1584L30.1463 4.09719L1.15317 4.09719C0.804636 4.09719 0.522097 4.37973 0.522097 4.72826C0.522097 5.07679 0.804636 5.35933 1.15317 5.35933L30.1463 5.35933L27.2075 8.29812C26.9611 8.54457 26.9611 8.94414 27.2075 9.19059C27.454 9.43704 27.8535 9.43704 28.1 9.19059Z" fill="currentColor"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <script>
                        jQuery(document).ready(function ($) {

                            // $('.filter-post-by-cat-<?= $widget_id; ?> .category-filter .item:first-child a').click();

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
                                                    rows: 4,
                                                }
                                            },
                                            1025: {
                                                slidesPerView: 4,
                                                grid: {
                                                    rows: 3,
                                                }
                                            },
                                            1200: {
                                                slidesPerView: 5,
                                                grid: {
                                                    rows: 3,
                                                }
                                            },
                                        }
                                    });
                                }
                            }
            
                            // Call initializeSwiper on page load
                            initializeSwiper();
            
                            // Add click event listener for category buttons
                            $('.filter-post-by-cat-<?= $widget_id; ?> .category-filter a').on('click', function (e) {
                                e.preventDefault();
                                $('.filter-post-by-cat-<?= $widget_id; ?> .category-filter>div').removeClass('active');
                                $(this).parent().addClass('active');
                                $('.filter-post-by-cat-<?= $widget_id; ?> .post-list').addClass('loading');
                                const category = $(this).data('category');
                                const taxonomy = $(this).data('taxonomy');
                                const post_type = '<?= $post_type ?>';
                                var text = $(this).text();
                                $('.filter-post-by-cat-<?= $widget_id; ?> .filters .label-mb span').text(text);
                                $('.filter-post-by-cat-<?= $widget_id; ?> .filters .label-mb').attr('style', $(this).attr('style'));
                                $('.filter-post-by-cat-<?= $widget_id; ?> .category-filter').slideToggle();
                                $('.filter-post-by-cat-<?= $widget_id; ?> .label-mb').toggleClass('open');
                                fetchPosts(post_type, taxonomy, category);
                            });

                            $('.filter-post-by-cat-<?= $widget_id; ?> .label-mb').on('click', function(e){
                                e.preventDefault();
                                $(this).toggleClass('open');
                                $('.filter-post-by-cat-<?= $widget_id; ?> .category-filter').slideToggle();
                            })
            
                            $(document).click(function(event) {
                                if (!$(event.target).closest(".filter-post-by-cat-<?= $widget_id; ?> .filters").length) {
                                    $(".filter-post-by-cat-<?= $widget_id; ?> .category-filter").slideUp();
                                    $('.filter-post-by-cat-<?= $widget_id; ?> .label-mb').toggleClass('open');
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
                                        $('.filter-post-by-cat-<?= $widget_id; ?> .post-list').removeClass('loading');
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
                                        ${post.image}
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