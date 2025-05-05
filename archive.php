<?php get_header(); ?>
<section class="container">
    <header class="archive-header u-textAlignCenter">
        <?php
        the_archive_title('<h3 class="page-title">', '</h3>');
        the_archive_description('<div class="taxonomy-description">', '</div>');
        ?>
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