<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Rma
 */
?>
<?php
get_header();
?>
<div class="main-container">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 main-content">
                <h1 class="page-title text-center">
                    <?php echo esc_html__('Search Results', 'rma'); ?>
                </h1>
                <div class="search-wrap">
                    <div class="search-count">
                        <?php
                        global $wp_query;
                        echo $wp_query->found_posts == 1 ? $wp_query->found_posts . ' result found' : $wp_query->found_posts . ' results found'; ?>
                    </div>
                    <?php
                    if (have_posts()) : ?>
                        <div class="search-results">
                            <?php while (have_posts()) : the_post(); ?>
                                <article class="search-result">
                                    <?php rma_post_title(); ?>
                                </article>
                            <?php endwhile;
                            wp_reset_postdata(); ?>
                        </div>
                        <?php rma_paging_nav(); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
