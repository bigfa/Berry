<?php get_header(); ?>
<section class="container">
    <header class="bTerm--header">
        <?php if (get_term_meta(get_queried_object_id(), '_thumb', true)) : ?>
            <img src="<?php echo get_term_meta(get_queried_object_id(), '_thumb', true); ?>" alt="<?php single_term_title('', true); ?>" class="bTerm--image">
        <?php endif; ?>
        <div class="bTerm--content">
            <h1 class="bTerm--title"><?php single_term_title('', true); ?></h1>
            <?php the_archive_description('<div class="bTerm--description">', '</div>'); ?>
        </div>
    </header>
    <div class="bBlock--list">
        <?php while (have_posts()) : the_post(); ?>
            <?php get_template_part('template-part/post/content', get_post_format()); ?>
        <?php endwhile; ?>
    </div>
    <div class="postsFooterNav">
        <?php the_posts_pagination(array(
            'prev_text' => __('Prev page', 'Berry'),
            'next_text' => __('Next page', 'Berry'),
            'prev_next' => false,
            'before_page_number' => '',
        )); ?>
    </div>
</section>
<?php get_footer(); ?>