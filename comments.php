<?php
if (post_password_required())
    return;
?>
<div id="comments" class="bComment-area">
    <h2 class="bComment--heroTitle">
        <?php printf(_nx('One comment', '%1$s comments', get_comments_number(), 'comments title', 'Berry'), number_format_i18n(get_comments_number())); ?>
    </h2>
    <?php if (have_comments()) : ?>
        <ol class="bComment--list">
            <?php
            wp_list_comments(array(
                'style'       => 'ol',
                'short_ping'  => true,
                'reply_text'  => __('Reply', 'Berry'),
                'avatar_size' => 42,
                'format'      => 'html5'
            ));
            ?>
        </ol>
        <?php the_comments_pagination(array(
            'prev_text' => __('Prev', 'Berry'),
            'next_text' => __('Next', 'Berry'),
            'prev_next' => false,
        )); ?>
    <?php else : ?>
        <ol class="bComment--list">
            <li class="no-comments"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" class="rl uc aob aoc aod aoe aof">
                    <path d="m13.293 13.9.146-7.076h-1.78l.15 7.075h1.48zm-.733 1.427c-.68 0-1.134.447-1.134 1.128 0 .666.454 1.113 1.135 1.113.68 0 1.13-.447 1.13-1.113 0-.68-.44-1.128-1.12-1.128"></path>
                    <path d="M12.5 21a8.5 8.5 0 1 0-.001-17.001A8.5 8.5 0 0 0 12.5 21m0 1C7.253 22 3 17.747 3 12.5S7.253 3 12.5 3 22 7.253 22 12.5 17.747 22 12.5 22"></path>
                </svg><?php _e('No comment.', 'Berry'); ?></li>
        </ol>
    <?php endif; ?>
    <?php comment_form(); ?>
</div>