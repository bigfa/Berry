<?php get_header(); ?>
    <main class="main-content">
        <section class="container">
            <?php while ( have_posts() ) : the_post(); ?>
                <?php get_template_part('template-part/post/content');?>
            <?php endwhile; ?>
            <div class="postsFooterNav">
                <?php the_posts_pagination( array(
                    'prev_text' => 'Previous page',
                    'next_text' => 'Next page',
                    'prev_next' => false,
                    'before_page_number' => '',
                ) );?>
            </div>
        </section>
    </main>
<?php get_footer(); ?>