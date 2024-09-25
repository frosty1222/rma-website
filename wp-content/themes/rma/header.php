<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link       https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package    WordPress
 * @subpackage Appliances
 * @since      1.0
 * @version    1.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header id="header" class="header">
    <div class="header-middle">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-3">
                    <div class="logo">
                        <?php
                        $logo_url = get_theme_file_uri('/assets/images/logo.png');
                        if (has_custom_logo()) {
                            $custom_logo_id = get_theme_mod('custom_logo');
                            $custom_logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                            $logo_url = $custom_logo[0];
                        }
                        $html = '<a class="logo-link" href="' . esc_url(home_url('/')) . '"><img style="width:176px" alt="' . esc_attr(get_bloginfo('name')) . '" src="' . esc_url($logo_url) . '"/></a>';
                        echo apply_filters('rma_site_logo', $html);
                        ?>
                    </div>
                </div>
                <div class="col-sm-6 col-md-9">
                    <?php if (has_nav_menu('primary')) : ?>
                        <div class="box-header-nav">
                            <?php
                            wp_nav_menu(array(
                                    'menu' => 'primary',
                                    'theme_location' => 'primary',
                                    'depth' => 3,
                                    'container' => '',
                                    'container_class' => '',
                                    'container_id' => '',
                                    'menu_class' => 'rma-nav main-menu',
                                )
                            );
                            ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</header>