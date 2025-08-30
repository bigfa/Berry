<h3 class="bRelated--heroTitle"><?php _e('Related Posts', 'Berry'); ?></h3>
<div class="bRelated--list">
    <?php
    // get same format related posts
    $the_query = new WP_Query(array(
        'post_type' => 'post',
        'post__not_in' => array(get_the_ID()),
        'orderby' => 'rand',
        'ignore_sticky_posts' => true,
        'posts_per_page' => 4,
        'category__in' => wp_get_post_categories(get_the_ID())
    ));
    while ($the_query->have_posts()) : $the_query->the_post(); ?>
        <?php get_template_part('template-part/post/content', 'card'); ?>
    <?php endwhile;
    wp_reset_postdata(); ?>
</div>