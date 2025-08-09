<?php

/**
 * The template for displaying posts in the Status post format
 *
 * @package Bigfa
 * @subpackage Berry
 * @since Berry 2.0.2
 */

$previou_post = get_previous_post();
$next_post = get_next_post();
?>
<nav class="navigation post-navigation" aria-label="<?php _e('Post', 'Berry'); ?>">
    <?php if ($previou_post) : ?>
        <div class="nav-previous">
            <a href="<?php echo get_permalink($previou_post->ID) ?>" rel="prev">
                <span class="meta-nav"><?php _e('Previous', 'Berry'); ?></span>
                <span class="post-title">
                    <?php echo get_the_title($previou_post->ID) ?>
                </span>
            </a>
        </div>
    <?php endif ?>
    <?php if ($next_post) : ?>
        <div class="nav-next">
            <a href="<?php echo get_permalink($next_post->ID) ?>" rel="next">
                <span class="meta-nav"><?php _e('Next', 'Berry'); ?></span>
                <span class="post-title">
                    <?php echo get_the_title($next_post->ID) ?>
                </span>
            </a>
        </div>
    <?php endif ?>
</nav>