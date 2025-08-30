<div class="bRelated--item" itemscope="itemscope" itemtype="http://schema.org/Article">
    <a href="<?php the_permalink(); ?>" aria-label="<?php the_title(); ?>">
        <?php if (berry_get_post_image_count(get_the_ID()) > 0) : ?>
            <div class="bRelated--images bRelated--images--<?php echo berry_get_post_image_count(get_the_ID()); ?>">
                <?php $images = berry_get_post_images(get_the_ID(), 3);
                if ($images) {
                    foreach ($images as $image) {
                        echo '<img src="' . $image . '" alt="' . get_the_title() . '" class="bRelated--image">';
                    }
                }
                ?>
            </div>
        <?php endif; ?>
        <div class="bRelated--title">
            <?php the_title(); ?>
        </div>
        <div class="bRelated--meta">
            <time datetime="<?php echo get_the_date('c'); ?>">
                <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) .  __(' ago', 'Berry'); ?>
            </time>
            <span class="sep"></span>
            <?php echo berry_get_post_read_time_text(get_the_ID()); ?>
        </div>
    </a>
</div>