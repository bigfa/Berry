<?php get_header(); ?>
<?php while (have_posts()) : the_post(); ?>
    <main class="main-content">
        <section class="container" itemscope="itemscope" itemtype="http://schema.org/Article">
            <h2 class="bArticle--title" itemprop="headline">
                <?php the_title(); ?>
            </h2>
            <div class="bGraph bArticle--content min-height-100" itemprop="articleBody">
                <?php the_content(); ?>
            </div>
            <?php wp_link_pages(array(
                'before'      => '<div class="nav-links nav-links__comment">',
                'after'       => '</div>',
                'pagelink'    => '%',
                'separator'   => '<span class="screen-reader-text">, </span>',
            )); ?>
            <?php
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
            ?>
        </section>
    </main>
<?php endwhile; ?>
<?php get_footer(); ?>