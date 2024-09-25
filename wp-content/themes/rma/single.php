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
                    <article <?php post_class('post-item post-single'); ?>>
                        <div class="single-post-banner">
                            <div class="single-post-info">
                                <?php
                                rma_post_title();
                                rma_post_date();
                                ?>
                            </div>
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="post-thumb">
                                    <?php $thumb = apply_filters('rma_resize_image', get_post_thumbnail_id(), 691, 298, true, true);
                                    echo wp_specialchars_decode($thumb['img']); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php rma_post_full_content(); ?>
                    </article>
                </div>
            </div>
        </div>
    </div>
<?php get_footer(); ?>