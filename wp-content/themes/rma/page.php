<?php
get_header();
?>
    <main class="site-main main-container">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 main-content">
                    <?php
                    if (have_posts()) {
                        while (have_posts()) {
                            the_post();
                            ?>
                            <div class="page-main-content">
                                <?php
                                the_content();
                                wp_link_pages(array(
                                        'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__('Pages:', 'azeroth') . '</span>',
                                        'after' => '</div>',
                                        'link_before' => '<span>',
                                        'link_after' => '</span>',
                                        'pagelink' => '<span class="screen-reader-text">' . esc_html__('Page', 'azeroth') . ' </span>%',
                                        'separator' => '<span class="screen-reader-text">, </span>',
                                    )
                                );
                                ?>
                            </div>
                            <?php
                            // If comments are open or we have at least one comment, load up the comment template.
                            if (comments_open() || get_comments_number()) :
                                comments_template();
                            endif;
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </main>
<?php get_footer();