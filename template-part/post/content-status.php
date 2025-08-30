<article class="bStatus--item" itemtype="http://schema.org/Article" itemscope="itemscope">
    <header class="bStatus--header">
        <?php echo get_avatar(get_the_author_meta('ID'), 48); ?>
        <time itemprop="datePublished" datetime="<?php echo get_the_date('c'); ?>"><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) .  __(' ago', 'Berry'); ?></time>
    </header>
    <?php if (get_the_excerpt()) : ?>
        <div class="bStatus--snippet" itemprop="about"><?php the_excerpt(); ?></div>
    <?php endif; ?>
    <div class="bBlock--footer">
        <a class="more-link" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" aria-label="<?php the_title(); ?>">read more..</a>
    </div>
</article>