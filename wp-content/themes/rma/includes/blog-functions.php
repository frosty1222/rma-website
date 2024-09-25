<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
/**
 *
 * HOOK TEMPLATE
 */
if (!function_exists('rma_paging_nav')) {
    function rma_paging_nav()
    {
        global $wp_query;
        $max = $wp_query->max_num_pages;
        $page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
        $text = '<span>' .$page . esc_html__(' of ','rma') . $max . '</span>';
        // Don't print empty markup if there's only one page.
        if ($max >= 2) {
            echo get_the_posts_pagination(
                array(
                    'screen_reader_text' => '&nbsp;',
                    'before_page_number' => $text,
                    'prev_text' => esc_html__('Prev','rma'),
                    'next_text' => esc_html__('Next','rma'),
                )
            );
        }
    }
}
if (!function_exists('rma_post_author')) {
    function rma_post_author()
    {
        ?>
        <div class="post-author">
            <?php echo esc_html__('By:', 'rma'); ?><a
                href="<?php echo get_author_posts_url(get_the_author_meta('ID'), get_the_author_meta('user_nicename')); ?>">
                <?php the_author(); ?>
            </a>
        </div>
        <?php
    }
}
if (!function_exists('rma_post_comment')) {
    function rma_post_comment()
    {
        ?>
        <div class="post-comment">
            <a href="<?php the_permalink(); ?>">
                <?php
                comments_number(
                    esc_html__('0 Comments', 'rma'),
                    esc_html__('1 Comment', 'rma'),
                    esc_html__('% Comments', 'rma')
                );
                ?>
            </a>
        </div>
        <?php
    }
}
if (!function_exists('rma_post_comment_icon')) {
    function rma_post_comment_icon()
    {
        ?>
        <div class="post-comment-icon">
            <a href="<?php the_permalink(); ?>">
                <?php
                comments_number(
                    esc_html__('0', 'rma'),
                    esc_html__('1', 'rma'),
                    esc_html__('%', 'rma')
                );
                ?>
            </a>
        </div>
        <?php
    }
}
if (!function_exists('rma_callback_comment')) {
    /**
     * Rma comment template
     *
     * @param array $comment the comment array.
     * @param array $args the comment args.
     * @param int $depth the comment depth.
     *
     * @since 1.0.0
     */
    function rma_callback_comment($comment, $args, $depth)
    {
        if ('div' == $args['style']) {
            $tag = 'div ';
            $add_below = 'comment';
        } else {
            $tag = 'li ';
            $add_below = 'div-comment';
        }
        ?>
        <<?php echo esc_attr($tag); ?><?php comment_class(empty($args['has_children']) ? '' : 'parent') ?> id="comment-<?php echo get_comment_ID(); ?>">
        <div class="comment_container">
            <div class="comment-avatar">
                <?php echo get_avatar($comment, 120); ?>
            </div>
            <div class="comment-text commentmetadata">
                <strong class="comment-author vcard">
                    <?php printf(wp_kses_post('%s', 'rma'), get_comment_author_link()); ?>
                </strong>
                <?php if ('0' == $comment->comment_approved) : ?>
                    <em class="comment-awaiting-moderation"><?php esc_attr_e('Your comment is awaiting moderation.', 'rma'); ?></em>
                    <br/>
                <?php endif; ?>
                <a href="<?php echo esc_url(htmlspecialchars(get_comment_link(get_comment_ID()))); ?>"
                   class="comment-date">
                    <?php echo '<time datetime="' . get_comment_date('c') . '">' . get_comment_date() . '</time>'; ?>
                </a>
                <?php edit_comment_link(__('Edit', 'rma'), '  ', ''); ?>
                <?php comment_reply_link(array_merge($args, array(
                    'add_below' => $add_below,
                    'depth' => $depth,
                    'max_depth' => $args['max_depth']
                ))); ?>
                <?php echo ('div' != $args['style']) ? '<div id="div-comment-' . get_comment_ID() . '" class="comment-content">' : '' ?>
                <?php comment_text(); ?>
                <?php echo 'div' != $args['style'] ? '</div>' : ''; ?>
            </div>
        </div>
        <?php
    }
}
if (!function_exists('rma_post_title')) {
    function rma_post_title()
    {
        ?>
        <h4 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
        <?php
    }
}
if (!function_exists('rma_post_readmore')) {
    function rma_post_readmore()
    {
        ?>
        <a href="<?php the_permalink(); ?>"
           class="button"><?php echo esc_html__('Read more', 'rma'); ?></a>
        <?php
    }
}
if (!function_exists('rma_post_excerpt')) {
    function rma_post_excerpt()
    {
        ?>
        <div class="post-excerpt">
            <?php echo wp_trim_words(apply_filters('the_excerpt', get_the_excerpt()), 23, '...'); ?>
        </div>
        <?php
    }
}
if (!function_exists('rma_post_full_content')) {
    function rma_post_full_content()
    {
        ?>
        <div class="post-content">
            <?php
            /* translators: %s: Name of current post */
            the_content(sprintf(
                    esc_html__('Continue reading %s', 'rma'),
                    the_title('<span class="screen-reader-text">', '</span>', false)
                )
            );
            wp_link_pages(array(
                    'before' => '<div class="post-pagination"><span class="title">' . esc_html__('Pages:', 'rma') . '</span>',
                    'after' => '</div>',
                    'link_before' => '<span>',
                    'link_after' => '</span>',
                )
            );
            ?>
        </div>
        <?php
    }
}
if (!function_exists('rma_post_date')) {
    function rma_post_date()
    {
        ?>
        <div class="date">
            <a href="<?php the_permalink(); ?>">
                <?php echo get_the_date(); ?>
            </a>
        </div>
        <?php
    }
}

if (!function_exists('rma_post_tags')) {
    function rma_post_tags()
    {
        if (!empty(get_the_terms(get_the_ID(), 'post_tag'))) : ?>
            <div class="tags"><?php $tags_list = get_the_tag_list('', ', ');
                if ($tags_list) {
                    printf(esc_html__('%1$s', 'rma'), $tags_list);
                } ?></div>
        <?php endif;
    }
}
if (!function_exists('rma_post_category')) {
    function rma_post_category()
    {
        $items = array();
        $taxonomy_names = get_post_taxonomies();
        if (isset($taxonomy_names[0]) && !empty($taxonomy_names)) {
            $get_terms = get_the_terms(get_the_ID(), $taxonomy_names[0]);
        } else {
            $get_terms = array();
        }
        if (!is_wp_error($get_terms) && !empty($get_terms)) : ?>
            <div class="categories">
                <span><?php echo esc_html__('Categories: ', 'rma') ?></span>
                <?php
                foreach ($get_terms as $term) {
                    $link = get_term_link($term->term_id, $taxonomy_names[0]);
                    $items[] = '<a href="' . esc_url($link) . '">' . esc_html($term->name) . '</a>';
                }
                echo join(', ', $items);
                ?>
            </div>
        <?php endif;
    }
}