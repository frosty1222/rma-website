<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Elementor_Custom_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'custom-widget';
    }

    public function get_title() {
        return __( 'Custom Widget', 'elementor-custom-widget' );
    }

    public function get_icon() {
        return 'eicon-list-ul';
    }

    public function get_categories() {
        return [ 'general' ];
    }

    protected function register_controls() {
        // Background Image and Title Section
        $this->start_controls_section(
            'background_section',
            [
                'label' => __( 'Background & Titles', 'elementor-custom-widget' ),
            ]
        );

        $this->add_control(
            'background_image',
            [
                'label' => __( 'Background Image', 'elementor-custom-widget' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'main_title',
            [
                'label' => __( 'Main Title', 'elementor-custom-widget' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'RMA Around The World', 'elementor-custom-widget' ),
            ]
        );

        $this->add_control(
            'subtitle',
            [
                'label' => __( 'Subtitle', 'elementor-custom-widget' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'An expansive range of businesses, strategically located for maximum access', 'elementor-custom-widget' ),
            ]
        );

        $this->end_controls_section();

        // Section for Continent and Country Input
        $this->start_controls_section(
            'continents_countries_section',
            [
                'label' => __( 'Continents & Countries', 'elementor-custom-widget' ),
            ]
        );

        // Repeater for Continents
        $continents_repeater = new \Elementor\Repeater();

        $continents_repeater->add_control(
            'continent_name',
            [
                'label' => __( 'Continent Name', 'elementor-custom-widget' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Asia', 'elementor-custom-widget' ),
            ]
        );

        // Nested Repeater for Countries within each Continent
        $countries_repeater = new \Elementor\Repeater();

        $countries_repeater->add_control(
            'country_name',
            [
                'label' => __( 'Country Name', 'elementor-custom-widget' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Thailand', 'elementor-custom-widget' ),
            ]
        );

        $countries_repeater->add_control(
            'country_services',
            [
                'label' => __( 'Country Services', 'elementor-custom-widget' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'service_icon',
                        'label' => __( 'Service Icon', 'elementor-custom-widget' ),
                        'type' => \Elementor\Controls_Manager::MEDIA,
                    ],
                    [
                        'name' => 'service_name',
                        'label' => __( 'Service Name', 'elementor-custom-widget' ),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => __( 'Automotive', 'elementor-custom-widget' ),
                    ],
                ],
                'title_field' => '{{{ service_name }}}',
            ]
        );

        $countries_repeater->add_control(
            'explore_link_text',
            [
                'label' => __( 'Explore Link Text', 'elementor-custom-widget' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Explore More', 'elementor-custom-widget' ),
            ]
        );

        $continents_repeater->add_control(
            'countries',
            [
                'label' => __( 'Countries', 'elementor-custom-widget' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $countries_repeater->get_controls(),
                'title_field' => '{{{ country_name }}}',
            ]
        );

        $this->add_control(
            'continent_list',
            [
                'label' => __( 'Continents List', 'elementor-custom-widget' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $continents_repeater->get_controls(),
                'title_field' => '{{{ continent_name }}}',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $background_image = $settings['background_image']['url'];
    
        ?>
        <style>
            .advanced-list-widget {
                width: 100vw;
                height: 100vh;
                max-height: 1080px;
                background-image: url('<?php echo esc_url( $background_image ); ?>');
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                position: relative;
                overflow: hidden;
                display: flex;
                color: white;
                font-family: Arial, sans-serif;
            }
    
            .continent-list {
                width: 350px;
                background: rgba(0, 0, 0, 0.7);
                padding: 20px;
                position: absolute;
                top: 100px;
                left: 30px;
                z-index: 3;
            }
    
            .continent-item {
                padding: 10px;
                cursor: pointer;
                border-bottom: 1px solid #fff;
            }
    
            .country-list {
                display: none;
                padding-left: 20px;
            }
    
            .country-item {
                padding: 5px;
                cursor: pointer;
                color: #f0f0f0;
            }
    
            .country-services {
                display: flex;
                gap: 15px;
                margin-bottom: 15px;
            }
    
            .country-services img {
                width: 100px;
                height: 100px;
                border: 1px solid red;
                display: inline-block !important;
            }
    
            .explore-more {
                font-weight: bold;
                text-decoration: underline;
                cursor: pointer;
                margin-top: 15px;
                display: none;
            }
    
            .widget-right {
                position: absolute;
                top: 50px;
                right: 50px;
                z-index: 3;
                max-width: 300px;
                text-align: right;
            }
    
            .bottom-left-text {
                position: absolute;
                bottom: 30px;
                left: 50px;
                font-size: 60px;
                font-weight: bold;
                opacity: 0.1;
                color: #fff;
                z-index: 1;
            }
        </style>
        <div class="advanced-list-widget">
            <div class="continent-list">
                <?php foreach ( $settings['continent_list'] as $continent_index => $continent ) : ?>
                    <div class="continent-item" data-continent-index="<?php echo $continent_index; ?>">
                        <?php echo esc_html( $continent['continent_name'] ); ?>
                        <div class="country-list">
                            <?php foreach ( $continent['countries'] as $country_index => $country ) : ?>
                                <div class="country-item" 
                                    data-country-index="<?php echo $country_index; ?>"
                                    data-country-name="<?php echo esc_attr( $country['country_name'] ); ?>"
                                    data-explore-link="<?php echo esc_html( $country['explore_link_text'] ); ?>">
                                    <?php echo esc_html( $country['country_name'] ); ?>
                                    <div class="country-services">
                                        <?php 
                                        if (!empty($country['country_services']) && is_array($country['country_services'])) {
                                            foreach ( $country['country_services'] as $service ) {
                                                if ( isset( $service['service_icon']['url'] ) && !empty( $service['service_icon']['url'] ) ) {
                                                    ?>
                                                    <div class="service-item">
                                                        <img src="<?php echo esc_url( $service['service_icon']['url'] ); ?>" alt="<?php echo esc_attr( $service['service_name'] ); ?>">
                                                        <p><?php echo esc_html( $service['service_name'] ); ?></p>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
    
            <div class="widget-right">
                <h2><?php echo esc_html( $settings['main_title'] ); ?></h2>
                <p><?php echo esc_html( $settings['subtitle'] ); ?></p>
            </div>
    
            <div class="bottom-left-text" id="bottom-left-text">Thailand</div>
            <div class="explore-more" id="explore-more-link">Explore More</div>
        </div>
    
        <script>
        jQuery(document).ready(function($) {
            $('.continent-item').on('click', function() {
                $(this).find('.country-list').slideToggle();
            });
    
            $('.country-item').on('click', function() {
                var countryName = $(this).data('country-name');
                var exploreLinkText = $(this).data('explore-link');
    
                $('#bottom-left-text').text(countryName);
                $('#explore-more-link').text(exploreLinkText);
                $('#explore-more-link').fadeIn();
            });
        });
        </script>
        <?php
    }
}
