<?php global $berrySetting; ?>
<article class="block--list" itemscope="itemscope" itemtype="http://schema.org/Article">
    <div class="block-postMetaWrap">
        <?php if (is_sticky()) : ?>
            <span class="sticky--post">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 16 16" class="ao fu">
                    <path fill="currentColor" fill-rule="evenodd" d="M9.788 1.027a.5.5 0 1 0-.707.707l.59.589-3.32 3.319a2.17 2.17 0 0 1-1.346.626l-2.442.21a.833.833 0 0 0-.518 1.42l2.676 2.675-3.418 3.417a.5.5 0 1 0 .707.707l3.418-3.417 2.675 2.675a.833.833 0 0 0 1.42-.518l.209-2.441c.044-.51.266-.986.627-1.347l3.318-3.32.59.59a.5.5 0 0 0 .707-.707l-.943-.943-3.3-3.3zm-3.653 9.546 2.422 2.422.179-2.085c.063-.743.388-1.44.916-1.968l3.318-3.32-2.593-2.592L7.06 6.349a3.17 3.17 0 0 1-1.969.916l-2.084.178 2.422 2.422z" clip-rule="evenodd"></path>
                </svg>
                <?php _e('Sticky', 'Berry'); ?>
            </span>
        <?php endif; ?>
        <div class="">
            <time itemprop="datePublished" datetime="<?php echo get_the_date('c'); ?>" class="humane--time">
                <?php echo get_the_date('m d,Y'); ?>
            </time>
            <span class="sep"></span>
            <?php the_category(',') ?>
        </div>
        <div class="post--meta">
            <?php if (get_post_meta(get_the_ID(), BERRY_POST_LIKE_KEY, true)) : ?>
                <?php echo (int)get_post_meta(get_the_ID(), BERRY_POST_LIKE_KEY, true); ?> Likes
                <span class="sep"></span>
            <?php endif; ?>
            <?php echo (int)get_post_meta(get_the_ID(), BERRY_POST_VIEW_KEY, true); ?> Views
        </div>
    </div>
    <h2 class="block-title" itemprop="headline">
        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" aria-label="<?php the_title(); ?>"><?php the_title(); ?></a>
    </h2>
    <div class="block-snippet block-snippet--subtitle grap">
        <p itemprop="about"><?php echo mb_strimwidth(strip_shortcodes(strip_tags(apply_filters('the_content', $post->post_content))), 0, 380, "...");
                            ?></p>
        <?php if (!$berrySetting->get_setting('hide_home_cover') && berry_get_post_image_count(get_the_ID()) > 0) : ?>
            <div class="block--images">
                <?php $images = berry_get_post_images(get_the_ID(), 3);
                if ($images) {
                    foreach ($images as $image) {
                        echo '<img src="' . $image . '" alt="' . get_the_title() . '" class="block--image" alt="' . get_the_title() . '" aria-label="<?php the_title(); ?>">';
                    }
                }
                ?>
            </div>
        <?php endif; ?>
        <p>
            <a class="more-link" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" aria-label="<?php the_title(); ?>">read more..</a>
        </p>
    </div>
</article>