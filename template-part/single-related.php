<h3 class="related--posts__title"><?php _e('Related Posts', 'Farallon'); ?></h3>
<div class="articleRelated">
    <?php
    // get same format related posts
    $the_query = new WP_Query(array(
        'post_type' => 'post',
        'post__not_in' => array(get_the_ID()),
        'orderby' => 'rand',
        'ignore_sticky_posts' => true,
        'posts_per_page' => 2,
        'category__in' => wp_get_post_categories(get_the_ID()),
        'tax_query' => get_post_format(get_the_ID()) ? array( // same post format
            array(
                'taxonomy' => 'post_format',
                'field' => 'slug',
                'terms' => array('post-format-' . get_post_format(get_the_ID())),
                'operator' => 'IN'
            )
        ) : array()
    ));
    while ($the_query->have_posts()) : $the_query->the_post(); ?>
        <?php get_template_part('template-part/post/content', 'card'); ?>
    <?php endwhile;
    wp_reset_postdata(); ?>
</div>