<article class="block block--inset block--list">
    <div class="block-postMetaWrap">
        <time><?php echo get_the_date('m d,Y'); ?></time><span class="sep"></span><?php the_category(',') ?>
    </div>
    <h2 class="block-title">
        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </h2>
    <div class="block-snippet block-snippet--subtitle grap">
        <p><?php echo mb_strimwidth(strip_shortcodes(strip_tags(apply_filters('the_content', $post->post_content))), 0, 380, "...");
            ?></p>
        <p>
        <p>
            <a class="more-link" href="<?php the_permalink(); ?>">read more..</a>
        </p>
    </div>
</article>