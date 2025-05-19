<?php global $berrySetting; ?>
<article class="block--list" itemscope="itemscope" itemtype="http://schema.org/Article">
    <div class="block-postMetaWrap">
        <?php if (is_sticky() && is_front_page()) : ?>
            <span class="sticky--post">
                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" fill="none" viewBox="0 0 24 24" class="bk">
                    <path fill="#242424" fill-rule="evenodd" d="M12.333 16.993a7.4 7.4 0 0 1-1.686-.12 7.25 7.25 0 1 1 8.047-4.334v.001a7.2 7.2 0 0 1-.632 1.188 7.26 7.26 0 0 1-4.708 3.146l-.07.013q-.466.083-.951.105m.356.979a8.4 8.4 0 0 1-1.377 0l-2.075 5.7a.375.375 0 0 1-.625.13l-2.465-2.604-3.563.41a.375.375 0 0 1-.395-.501l2.645-7.267a8.25 8.25 0 1 1 14.333 0l2.645 7.267a.375.375 0 0 1-.396.5l-3.562-.41-2.465 2.604a.375.375 0 0 1-.625-.13zm5.786-3.109a8.25 8.25 0 0 1-4.775 2.962l1.658 4.554 1.77-1.87.344-.362.496.057 2.558.294zm-12.95 0L3.476 20.5l2.557-.295.497-.057.344.363 1.77 1.87 1.658-4.555a8.25 8.25 0 0 1-4.775-2.961" clip-rule="evenodd"></path>
                </svg>
                <?php _e('Sticky', 'Berry'); ?>
            </span>
        <?php endif; ?>
        <?php do_action('marker_pro_flag'); ?>
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
            <div class="block--images<?php if (berry_get_post_image_count(get_the_ID()) > 3 && $berrySetting->get_setting('home_image_count')) echo ' block--images__withcount'; ?>" data-count="<?php echo berry_get_post_image_count(get_the_ID()); ?>">
                <?php $images = berry_get_post_images(get_the_ID(), 3);
                if ($images) {
                    foreach ($images as $image) {
                        echo '<img src="' . $image . '" alt="' . get_the_title() . '" class="block--image" alt="' . get_the_title() . '" aria-label="' . get_the_title() . '">';
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