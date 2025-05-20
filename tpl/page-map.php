<?php
/*
Template Name: Map
Template Post Type: page
*/
get_header(); ?>

<?php while (have_posts()) : the_post(); ?>
    <main class="main-content">
        <section class="map--container" itemscope="itemscope" itemtype="http://schema.org/Article">
            <header class="page--header">
                <h2 class="block-title" itemprop="headline">
                    <?php the_title(); ?>
                </h2>
            </header>
            <div class="grap" itemprop="articleBody">
                <?php the_content(); ?>
            </div>
        </section>
    </main>
<?php endwhile; ?>



<?php get_footer(); ?>