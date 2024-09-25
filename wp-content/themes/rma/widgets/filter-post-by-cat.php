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
        protected function register_controls()
        {

            $this->start_controls_section(
                'content_section',
                [
                    'label' => esc_html__('Content', 'rma'),
                ]
            );
            $this->add_control(
                'background', [
                    'label' => esc_html__('Background', 'rma'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                ]
            );
            $this->add_control(
                'image_over', [
                    'label' => esc_html__('Image Over', 'rma'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                ]
            );
            $this->add_control(
                'title', [
                    'label' => esc_html__('Title', 'rma'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'placeholder' => esc_html__('Enter your title', 'rma'),
                ]
            );
            $this->add_control(
                'desc', [
                    'label' => esc_html__('Description', 'rma'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                    'placeholder' => esc_html__('Enter your description', 'rma'),
                ]
            );
            $this->add_control(
                'text', [
                    'label' => esc_html__('Button Text', 'rma'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'placeholder' => esc_html__('Enter your text', 'rma'),
                ]
            );
            $this->add_control(
                'link', [
                    'label' => esc_html__('Button Link', 'rma'),
                    'type' => \Elementor\Controls_Manager::URL,
                    'placeholder' => esc_html__('https://your-link.com', 'rma'),
                    'show_external' => true,
                    'default' => [
                        'url' => '',
                        'is_external' => false,
                        'nofollow' => false,
                    ],
                    'label_block' => true
                ]
            );
            $this->add_control(
                'image', [
                    'label' => esc_html__('Scroll Down Image', 'rma'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                ]
            );
            $this->add_control(
                'link_id', [
                    'label' => esc_html__('Scroll Down Link ID', 'rma'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'placeholder' => esc_html__('Enter your link', 'rma'),
                ]
            );
            $this->end_controls_section();
        }

        /**
         * Render the widget output on the frontend.
         *
         * Written in PHP and used to generate the final HTML.
         *
         * @since 1.0.0
         *
         * @access protected
         */
        protected function render()
        {
            $atts = $this->get_settings_for_display();
            $css_class = array('rma-banner');
            $link = $atts['link']['url'] ? $atts['link']['url'] : '#';
            $target = $atts['link']['is_external'] ? '_blank' : '_self';
            ?>
            <div class="<?php echo esc_attr(implode(' ', $css_class)); ?>" style="background-image: url('<?php if ($atts['background']['url']): ?><?php echo esc_url($atts['background']['url']);?>')<?php endif; ?>">
                <?php if ($atts['image_over']): ?>
                    <div class="image-over"><?php echo wp_get_attachment_image($atts['image_over']['id'], 'full'); ?></div>
                <?php endif; ?>
                <div class="banner-inner">
                    <?php if ($atts['title']): ?>
                        <h1 class="section-title"><?php echo wp_specialchars_decode($atts['title']); ?></h1>
                    <?php endif; ?>
                    <?php if ($atts['desc']): ?>
                        <div class="desc"><?php echo wp_specialchars_decode($atts['desc']); ?></div>
                    <?php endif; ?>
                    <?php if($atts['text']) { ?>
                        <?php if(is_singular('sfwd-courses')) { ?>
                            <?php if (is_user_logged_in()) { ?>
                                <?php if (in_array(learndash_get_course_id(),learndash_user_get_enrolled_courses(get_current_user_id()))) { 
                                    $ld_curent_lesson_link = ld_curent_lesson_link(learndash_get_course_id(), get_current_user_id());
                                    if($ld_curent_lesson_link){
                                        $url = $ld_curent_lesson_link;
                                    }else{
                                        $url = 'javascript:void(0)';
                                    }
                                    ?>
                                    <a class="button button-blue button-large" href="<?php echo $url;?>">
                                        <?php echo learndash_course_status(learndash_get_course_id()); ?>
                                    </a>
                                <?php } else { ?>
                                    <a class="button button-green button-large" href="<?php echo esc_url(get_home_url() . '/payment/?ld_register_id='. learndash_get_course_id()); ?>">
                                        <?php echo esc_html($atts['text']); ?>
                                    </a>
                                <?php } ?>
                            <?php } else { ?>
                                <a class="button button-green button-large" href="<?php echo esc_url(get_home_url() . '/registration/?ld_register_id='. learndash_get_course_id()); ?>">
                                    <?php echo esc_html($atts['text']); ?>
                                </a>
                            <?php } ?>
                        <?php } elseif ($atts['text'] && $atts['link']['url']) { ?>
                            <a class="button button-green button-large" href="<?php echo esc_url($link); ?>"
                               target="<?php echo esc_attr($target); ?>"><?php echo esc_html($atts['text']); ?></a>
                        <?php } ?>
                    <?php } ?>
                    <?php if ($atts['image'] && $atts['link_id']): ?>
                        <a class="scroll-down" href="<?php echo esc_url($atts['link_id']); ?>"><?php echo wp_get_attachment_image($atts['image']['id'], 'full'); ?></a>
                    <?php endif; ?>
                </div>
            </div>
            <?php
        }
    }
}