<?php
if (post_password_required())
    return;
?>
<div id="comments" class="comments-area">
    <?php if (have_comments()) : ?>
        <h2 class="comments-title">
            <?php printf(_nx('One comment', '%1$s comments', get_comments_number(), 'comments title', 'Berry'), number_format_i18n(get_comments_number())); ?>
        </h2>
        <ol class="comment-list commentlist">
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
    <?php endif; ?>
    <?php comment_form(); ?>
</div>