<?php if (get_post_format(get_the_ID()) == 'status') : ?>
    <div class="articleRelated__status">
        <a href="<?php the_permalink(); ?>" aria-label="<?php the_title(); ?>">
            <?php the_excerpt(); ?>
            <div class="bRelated--meta">
                <svg class="icon" viewBox="0 0 1024 1024" width="16" height="16">
                    <path d="M512 97.52381c228.912762 0 414.47619 185.563429 414.47619 414.47619s-185.563429 414.47619-414.47619 414.47619S97.52381 740.912762 97.52381 512 283.087238 97.52381 512 97.52381z m0 73.142857C323.486476 170.666667 170.666667 323.486476 170.666667 512s152.81981 341.333333 341.333333 341.333333 341.333333-152.81981 341.333333-341.333333S700.513524 170.666667 512 170.666667z m36.571429 89.697523v229.86362h160.865523v73.142857H512a36.571429 36.571429 0 0 1-36.571429-36.571429V260.388571h73.142858z"></path>
                </svg>
                <time itemprop="datePublished" datetime="<?php echo get_the_date('c'); ?>">
                    <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) .  __(' ago', 'Berry'); ?>
                </time>
                <span class="sep"></span>
                <?php echo berry_get_post_read_time_text(get_the_ID()); ?>
            </div>
        </a>
    </div>
<?php else : ?>
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
<?php endif; ?>