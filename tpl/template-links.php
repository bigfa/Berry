<?php
/*
Template Name: Links
Template Post Type: page
*/
get_header();
?>


<main class="container">
    <article class="bArticle" itemscope="itemscope" itemtype="http://schema.org/Article">
        <?php while (have_posts()) : the_post(); ?>
            <h2 class="bArticle--title" itemprop="headline"><?php the_title(); ?></h2>
            <?php echo get_link_items(); ?>
        <?php endwhile; ?>
    </article>
</main>

<?php get_footer(); ?>