<?php get_header(); ?>
<section class="container">
    <div class="bBlock--list">
        <?php while (have_posts()) : the_post(); ?>
            <?php get_template_part('template-part/post/content', get_post_format()); ?>
        <?php endwhile; ?>
    </div>
    <?php the_posts_pagination(array(
        'prev_text' => __('Prev page', 'Berry'),
        'next_text' => __('Next page', 'Berry'),
        'prev_next' => false,
        'before_page_number' => '',
    )); ?>
</section>
<?php get_footer(); ?>