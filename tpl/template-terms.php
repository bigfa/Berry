<?php
/*
Template Name: Terms
*/
get_header(); ?>

<div class="container">
    <?php while (have_posts()) : the_post(); ?>
        <article class="bArticle">
            <h2 class="bArticle--title" itemprop="headline"><?php the_title(); ?></h2>
            <div class="bCategory--list">
                <?php $categories = get_terms([
                    'taxonomy' => 'category',
                    'hide_empty' => false,
                    'order' => 'DESC',
                ]);
                foreach ($categories as $category) {
                    $link = get_term_link($category, 'category')
                ?>
                    <a class="bCategory--item" title="<?php echo $category->name; ?>" aria-label="<?php echo $category->name; ?>" href="<?php echo $link; ?>" data-count="<?php echo $category->count; ?>">
                        <?php if (get_term_meta($category->term_id, '_thumb', true)) : ?>
                            <img class="bCategory--image" alt="<?php echo $category->name; ?>" aria-label="<?php echo $category->name; ?>" src="<?php echo get_term_meta($category->term_id, '_thumb', true); ?>">
                        <?php endif ?>
                        <div class="bCategory--meta">
                            <div class="bCategory--title"><?php echo $category->name; ?></div>
                            <div class="bCategory--description"><?php echo $category->description; ?></div>
                        </div>
                    </a>
                <?php } ?>
            </div>
        </article>
    <?php endwhile; ?>
</div>

<?php get_footer(); ?>