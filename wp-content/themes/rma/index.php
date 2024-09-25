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

if ((is_home() || is_category()) && get_option('page_for_posts')) { ?>
    <div class="blog-banner">
        <?php echo wp_get_attachment_image(get_post_thumbnail_id(get_option('page_for_posts')), 'full'); ?>
    </div>
<?php }
$classes = array('post-item', 'post-grid');
$classes[] = 'col-bg-4';
$classes[] = 'col-lg-4';
$classes[] = 'col-md-4';
$classes[] = 'col-sm-6';
$classes[] = 'col-xs-12';
$classes[] = 'col-ts-12';
?>
<div class="main-container">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 main-content">
                <?php if (is_home()) { ?>
                    <h1 class="page-title"><?php single_post_title() ?></h1>
                <?php } elseif (is_category()) { ?>
                    <h1 class="page-title"><?php echo single_cat_title( '', false ); ?></h1>
                <?php } else { ?>
                    <h1 class="page-title"><?php the_archive_title() ?></h1>
                <?php } ?>
                <?php
                if (have_posts()) : ?>
                    <div class="blog-grid auto-clear content-post row">
                        <?php while (have_posts()) : the_post(); ?>
                            <article <?php post_class($classes); ?>>
                                <div class="post-inner">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="post-thumb">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php $thumb = apply_filters('rma_resize_image', get_post_thumbnail_id(), 440, 190, true, true);
                                                echo wp_specialchars_decode($thumb['img']); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    <div class="post-content">
                                        <div class="post-info">
                                            <?php
                                            rma_post_title();
                                            rma_post_excerpt();
                                            ?>
                                        </div>
                                        <div class="post-meta">
                                            <?php
                                            rma_post_date();
                                            rma_post_readmore();
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        <?php endwhile;
                        wp_reset_postdata(); ?>
                    </div>
                    <div class="page-bottom clearfix">
                        <?php
                            rma_paging_nav();
                        ?>
                    </div>
                <?php else :
                    get_template_part('content', 'none');
                endif; ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
