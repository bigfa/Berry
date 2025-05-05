<?php get_header(); ?>
<main class="container">
    <section class="error-404 not-found">
        404
    </section>
    <h3 class="related--posts__title"><?php _e('Random Posts', 'Farallon'); ?></h3>
    <div class="articleRelated">
        <?php
        $the_query = new WP_Query(array(
            'post_type' => 'post',
            'orderby' => 'rand',
            'ignore_sticky_posts' => true,
            'posts_per_page' => 6,
        ));
        while ($the_query->have_posts()) : $the_query->the_post(); ?>
            <?php get_template_part('template-part/post/content', 'card'); ?>
        <?php endwhile;
        wp_reset_postdata(); ?>
    </div>
</main>
<?php get_footer(); ?>