<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package WordPress
 * @subpackage Rma
 * @since 1.0
 * @version 1.0
 */
get_header();
?>
    <div class="main-container text-center error-404 not-found">
        <div class="container">
            <h1 class="title-404"><?php esc_html_e('404', 'azeroth'); ?></h1>
            <h3 class="title"><?php echo esc_html__('Opps! This page Could Not Be Found!', 'azeroth'); ?></h3>
            <p class="subtitle"><?php echo esc_html__('Sorry bit the page you are looking for does not exist, have been removed or name changed', 'azeroth'); ?></p>
            <!-- .page-content -->
            <a href="<?php echo esc_url(home_url('/')); ?>"
               class="button"><?php echo esc_html__('Back to hompage', 'azeroth'); ?></a>
        </div>
    </div></div>
<?php
get_footer();
