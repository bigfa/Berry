<?php get_header();
global $berrySetting;
?>
<?php while (have_posts()) : the_post(); ?>
    <section class="container u-relative" itemscope="itemscope" itemtype="http://schema.org/Article">
        <?php if ($berrySetting->get_setting('bio')) : ?>
            <div class="author--card">
                <div class="author--card__avatar">
                    <?php echo get_avatar(get_the_author_meta('ID'), 64); ?>
                </div>
                <div class="author--card__info">
                    <h4 class="author--card__name">
                        <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" class="link link--primary"><?php the_author(); ?></a>
                    </h4>
                    <p class="author--card__desc">
                        <?php echo get_the_author_meta('description', get_the_author_meta('ID')); ?>
                    </p>
                </div>
            </div>
        <?php endif; ?>
        <div class="bArticle--header">
            <?php do_action('marker_pro_flag'); ?>
            <div class="">
                <time itemprop="datePublished" datetime="<?php echo get_the_date('c'); ?>">
                    <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) .  __(' ago', 'Berry'); ?>
                </time>
                <span class="sep"></span>
                <?php the_category(',') ?>
                <span class="sep"></span>
                <?php echo berry_get_post_read_time_text(get_the_ID()); ?>
            </div>
            <div class="post--meta">
                <?php if (get_post_meta(get_the_ID(), BERRY_POST_LIKE_KEY, true)) : ?>
                    <?php echo (int)get_post_meta(get_the_ID(), BERRY_POST_LIKE_KEY, true); ?> Likes
                    <span class="sep"></span>
                <?php endif; ?>
                <?php echo (int)get_post_meta(get_the_ID(), BERRY_POST_VIEW_KEY, true); ?> Views
            </div>
        </div>
        <h2 class="bArticle--title" itemprop="headline">
            <?php the_title(); ?>
        </h2>
        <div class="bGraph bArticle--content" itemprop="articleBody">
            <?php the_content(); ?>
        </div>
        <?php wp_link_pages(array(
            'before'      => '<div class="nav-links comments-pagination">',
            'after'       => '</div>',
            'pagelink'    => '%',
            'separator'   => '<span class="screen-reader-text">, </span>',
        )); ?>
        <?php
        $tags = get_the_tags();
        if ($tags) {
            echo '<div class="bArticle--tags">';
            foreach ($tags as $tag) {
                echo '<a href="' . get_tag_link($tag->term_id) . '"><svg viewBox="0 0 24 24" width="24" height="24">
            <g fill="none"  stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                <path d="M6.5 7.5a1 1 0 1 0 2 0a1 1 0 1 0-2 0" />
                <path d="M3 6v5.172a2 2 0 0 0 .586 1.414l7.71 7.71a2.41 2.41 0 0 0 3.408 0l5.592-5.592a2.41 2.41 0 0 0 0-3.408l-7.71-7.71A2 2 0 0 0 11.172 3H6a3 3 0 0 0-3 3" />
            </g>
        </svg>'  . $tag->name . '</a>';
            }
            echo '</div>';
        } ?>
        <div class="bArticle--footer">
            <div class="bArticle--actions">
                <?php if ($berrySetting->get_setting('postlike')) : ?>
                    <button class="button--like like-btn" aria-label="like the post">
                        <svg class="icon--active" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" aria-label="clap">
                            <path fill-rule="evenodd" d="M11.37.828 12 3.282l.63-2.454zM15.421 1.84l-1.185-.388-.338 2.5zM9.757 1.452l-1.184.389 1.523 2.112zM20.253 11.84 17.75 7.438c-.238-.353-.57-.584-.93-.643a.96.96 0 0 0-.753.183 1.13 1.13 0 0 0-.443.695c.014.019.03.033.044.053l2.352 4.138c1.614 2.95 1.1 5.771-1.525 8.395a7 7 0 0 1-.454.415c.997-.13 1.927-.61 2.773-1.457 2.705-2.704 2.517-5.585 1.438-7.377M12.066 9.01c-.129-.687.08-1.299.573-1.773l-2.062-2.063a1.123 1.123 0 0 0-1.555 0 1.1 1.1 0 0 0-.273.521z" clip-rule="evenodd"></path>
                            <path fill-rule="evenodd" d="M14.741 8.309c-.18-.267-.446-.455-.728-.502a.67.67 0 0 0-.533.127c-.146.113-.59.458-.199 1.296l1.184 2.503a.448.448 0 0 1-.236.755.445.445 0 0 1-.483-.248L7.614 6.106A.816.816 0 1 0 6.459 7.26l3.643 3.644a.446.446 0 1 1-.631.63L5.83 7.896l-1.03-1.03a.82.82 0 0 0-1.395.577.81.81 0 0 0 .24.576l1.027 1.028 3.643 3.643a.444.444 0 0 1-.144.728.44.44 0 0 1-.486-.098l-3.64-3.64a.82.82 0 0 0-1.335.263.81.81 0 0 0 .178.89l1.535 1.534 2.287 2.288a.445.445 0 0 1-.63.63l-2.287-2.288a.813.813 0 0 0-1.393.578c0 .216.086.424.238.577l4.403 4.403c2.79 2.79 5.495 4.119 8.681.931 2.269-2.271 2.708-4.588 1.342-7.086z" clip-rule="evenodd"></path>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" aria-label="clap" class="icon--default">
                            <path fill-rule="evenodd" d="M11.37.828 12 3.282l.63-2.454zM13.916 3.953l1.523-2.112-1.184-.39zM8.589 1.84l1.522 2.112-.337-2.501zM18.523 18.92c-.86.86-1.75 1.246-2.62 1.33a6 6 0 0 0 .407-.372c2.388-2.389 2.86-4.951 1.399-7.623l-.912-1.603-.79-1.672c-.26-.56-.194-.98.203-1.288a.7.7 0 0 1 .546-.132c.283.046.546.231.728.5l2.363 4.157c.976 1.624 1.141 4.237-1.324 6.702m-10.999-.438L3.37 14.328a.828.828 0 0 1 .585-1.408.83.83 0 0 1 .585.242l2.158 2.157a.365.365 0 0 0 .516-.516l-2.157-2.158-1.449-1.449a.826.826 0 0 1 1.167-1.17l3.438 3.44a.363.363 0 0 0 .516 0 .364.364 0 0 0 0-.516L5.293 9.513l-.97-.97a.826.826 0 0 1 0-1.166.84.84 0 0 1 1.167 0l.97.968 3.437 3.436a.36.36 0 0 0 .517 0 .366.366 0 0 0 0-.516L6.977 7.83a.82.82 0 0 1-.241-.584.82.82 0 0 1 .824-.826c.219 0 .43.087.584.242l5.787 5.787a.366.366 0 0 0 .587-.415l-1.117-2.363c-.26-.56-.194-.98.204-1.289a.7.7 0 0 1 .546-.132c.283.046.545.232.727.501l2.193 3.86c1.302 2.38.883 4.59-1.277 6.75-1.156 1.156-2.602 1.627-4.19 1.367-1.418-.236-2.866-1.033-4.079-2.246M10.75 5.971l2.12 2.12c-.41.502-.465 1.17-.128 1.89l.22.465-3.523-3.523a.8.8 0 0 1-.097-.368c0-.22.086-.428.241-.584a.847.847 0 0 1 1.167 0m7.355 1.705c-.31-.461-.746-.758-1.23-.837a1.44 1.44 0 0 0-1.11.275c-.312.24-.505.543-.59.881a1.74 1.74 0 0 0-.906-.465 1.47 1.47 0 0 0-.82.106l-2.182-2.182a1.56 1.56 0 0 0-2.2 0 1.54 1.54 0 0 0-.396.701 1.56 1.56 0 0 0-2.21-.01 1.55 1.55 0 0 0-.416.753c-.624-.624-1.649-.624-2.237-.037a1.557 1.557 0 0 0 0 2.2c-.239.1-.501.238-.715.453a1.56 1.56 0 0 0 0 2.2l.516.515a1.556 1.556 0 0 0-.753 2.615L7.01 19c1.32 1.319 2.909 2.189 4.475 2.449q.482.08.971.08c.85 0 1.653-.198 2.393-.579.231.033.46.054.686.054 1.266 0 2.457-.52 3.505-1.567 2.763-2.763 2.552-5.734 1.439-7.586z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                <?php endif; ?>
                <?php if ($berrySetting->get_setting('show_copylink')) : ?>
                    <button class="button--share post--share" aria-label="share the post">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path fill="currentColor" fill-rule="evenodd" d="M15.218 4.931a.4.4 0 0 1-.118.132l.012.006a.45.45 0 0 1-.292.074.5.5 0 0 1-.3-.13l-2.02-2.02v7.07c0 .28-.23.5-.5.5s-.5-.22-.5-.5v-7.04l-2 2a.45.45 0 0 1-.57.04h-.02a.4.4 0 0 1-.16-.3.4.4 0 0 1 .1-.32l2.8-2.8a.5.5 0 0 1 .7 0l2.8 2.79a.42.42 0 0 1 .068.498m-.106.138.008.004v-.01zM16 7.063h1.5a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-11c-1.1 0-2-.9-2-2v-10a2 2 0 0 1 2-2H8a.5.5 0 0 1 .35.15.5.5 0 0 1 .15.35.5.5 0 0 1-.15.35.5.5 0 0 1-.35.15H6.4c-.5 0-.9.4-.9.9v10.2a.9.9 0 0 0 .9.9h11.2c.5 0 .9-.4.9-.9v-10.2c0-.5-.4-.9-.9-.9H16a.5.5 0 0 1 0-1" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                <?php endif; ?>
            </div>
        </div>
        <?php if ($berrySetting->get_setting('post_navigation')) get_template_part('template-part/post', 'navigation'); ?>
        <?php
        if (comments_open() || get_comments_number()) :
            comments_template();
        endif;
        ?>
        <?php if ($berrySetting->get_setting('related')) get_template_part('template-part/single', 'related'); ?>
    </section>
<?php endwhile; ?>
<?php get_footer(); ?>