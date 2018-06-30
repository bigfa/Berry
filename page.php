<?php get_header();?>
<?php while ( have_posts() ) : the_post();?>
    <main class="main-content">
        <section class="container">
            <h2 class="block-title">
                <?php the_title();?>
            </h2>
            <div class="grap">
                <?php the_content();?>
            </div>
            <?php
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;
            ?>
        </section>
    </main>
<?php endwhile; ?>
<?php get_footer(); ?>