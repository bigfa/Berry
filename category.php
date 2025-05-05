<?php get_header(); ?>
<section class="container">
    <header class="term--header">
        <?php if (get_term_meta(get_queried_object_id(), '_thumb', true)) : ?>
            <img src="<?php echo get_term_meta(get_queried_object_id(), '_thumb', true); ?>" alt="<?php single_term_title('', true); ?>" class="term--image">
        <?php endif; ?>
        <div class="term--header__content">
            <h1 class="term--title"><?php single_term_title('', true); ?></h1>
            <?php the_archive_description('<div class="term--description">', '</div>'); ?>
        </div>
    </header>
    <?php while (have_posts()) : the_post(); ?>
        <?php get_template_part('template-part/post/content', get_post_format()); ?>
    <?php endwhile; ?>
    <div class="postsFooterNav">
        <?php the_posts_pagination(array(
            'prev_text' => 'Previous page',
            'next_text' => 'Next page',
            'prev_next' => false,
            'before_page_number' => '',
        )); ?>
    </div>
</section>
<?php get_footer(); ?>