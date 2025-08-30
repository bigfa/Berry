<?php

function berry_get_background_image($post_id, $width = null, $height = null)
{
    if (has_post_thumbnail($post_id)) {
        $timthumb_src = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'full');
        $output       = $timthumb_src[0];
    } elseif (get_post_meta($post_id, '_banner', true)) {
        $output = get_post_meta($post_id, '_banner', true);
    } else {
        $content         = get_post_field('post_content', $post_id);
        $defaltthubmnail = get_template_directory_uri() . '/build/images/default.jpeg';
        preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER);
        $n = count($strResult[1]);
        if ($n > 0) {
            $output = $strResult[1][0];
        } else {
            $output = $defaltthubmnail;
        }
    }
    return $output;
}

function berry_is_has_image($post_id)
{
    static $has_image;
    global $post;
    if (has_post_thumbnail($post_id)) {
        $has_image = true;
    } elseif (get_post_meta($post_id, '_banner', true)) {
        $has_image = true;
    } else {
        $content = get_post_field('post_content', $post_id);
        preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER);
        $n = count($strResult[1]);
        if ($n > 0) {
            $has_image = true;
        } else {
            $has_image = false;
        }
    }

    return $has_image;
}


function berry_get_post_image_count($post_id)
{
    $content = get_post_field('post_content', $post_id);
    $content = apply_filters('the_content', $content);
    preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER);
    return count($strResult[1]);
}

/**
 * Get post images
 *
 * @since Berry 0.2.0
 *
 */


function berry_get_post_images($post_id, $count = 3)
{
    if (! $post_id) {
        $post_id = get_the_ID();
    }

    $post = get_post($post_id);
    $content = apply_filters('the_content', $post->post_content);
    preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER);
    $n = count($strResult[1]);
    $output = array();
    if ($n > 0) {
        $output = array_slice($strResult[1], 0, $count);
    }
    return $output;
}


/**
 * Get link items by categroy id
 *
 * @since Berry 2.0.1
 *
 * @param term id
 * @return link item list
 */

function get_the_link_items($id = null)
{
    $bookmarks = get_bookmarks('orderby=date&category=' . $id);
    $output = '';
    if (!empty($bookmarks)) {
        $output .= '<div class="bLink--list">';
        foreach ($bookmarks as $bookmark) {
            $image = $bookmark->link_image ? '<img src="' . $bookmark->link_image . '" alt="' . $bookmark->link_name . '" class="avatar">' : get_avatar($bookmark->link_notes, 64);
            $output .=  '<a class="bLink--item" href="' . $bookmark->link_url . '" title="' . $bookmark->link_description . '" target="_blank" >
             ' . $image . '
             <strong>' . $bookmark->link_name . '</strong><span class="sitename">' . $bookmark->link_description . '</span></a>';
        }
        $output .= '</div>';
    } else {
        $output = __('No links yet', 'Berry');
    }
    return $output;
}

/**
 * Get link items
 *
 * @since Berry 2.0.1
 *
 * @return link iterms
 */

function get_link_items()
{
    $linkcats = get_terms('link_category');
    $result = '';
    if (!empty($linkcats)) {
        foreach ($linkcats as $linkcat) {
            $result .=  '<h3 class="bLink--title">' . $linkcat->name . '</h3>';
            if ($linkcat->description) $result .= '<div class="bLink--description">' . $linkcat->description . '</div>';
            $result .=  get_the_link_items($linkcat->term_id);
        }
    } else {
        $result = get_the_link_items();
    }
    return $result;
}

function berry_get_post_read_time($post_id)
{
    $content = get_post_field('post_content', $post_id);
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200); // Average reading speed is 200 wpm

    $image_count = berry_get_post_image_count($post_id);
    if ($image_count > 0) {
        $reading_time += ceil($image_count / 10); // Add extra time for images
    }

    return $reading_time;
}

function berry_get_post_read_time_text($post_id)
{
    $reading_time = berry_get_post_read_time($post_id);
    if ($reading_time <= 1) {
        return __('1 min read', 'Berry');
    } else {
        return sprintf(__('%d min read', 'Berry'), $reading_time);
    }
}


function berry_get_post_views($post_id = 0)
{

    $views_number = (int)get_post_meta($post_id, BERRY_POST_VIEW_KEY, true);

    /**
     * Filters the returned views for a post.
     *
     * @since Berry 2.2.1
     */
    return apply_filters('berry_get_post_views', $views_number, $post_id);
}

/**
 * Get post views
 *
 * @since Berry 2.2.1
 *
 * @param post id
 * @return post views
 */

function berry_get_post_views_text($zero = false, $one = false, $more = false, $post = 0, $before = '', $after = '')
{
    $views = berry_get_post_views($post);
    if ($views == 0) {
        return $before . ($zero ? $zero : __('No views yet', 'Berry')) . $after;
    } elseif ($views == 1) {
        return $before . ($one ? $one : __('1 View', 'Berry')) . $after;
    } else { // more than 1 view
        $views = number_format_i18n($views);
        return $before . ($more ? $more : sprintf(__('%d Views', 'Berry'), $views)) . $after;
    }
}

function berry_get_post_likes($post_id = 0)
{

    $likes_number = (int)get_post_meta($post_id, BERRY_POST_LIKE_KEY, true);

    /**
     * Filters the returned likes for a post.
     *
     * @since Berry 2.2.1
     */
    return apply_filters('berry_get_post_likes', $likes_number, $post_id);
}


function berry_get_post_likes_text($zero = false, $one = false, $more = false, $post = 0, $before = '', $after = '')
{
    $likes = berry_get_post_likes($post);
    if ($likes == 0) {
        return false;
    } elseif ($likes == 1) {
        return $before . ($one ? $one : __('1 Like', 'Berry')) . $after;
    } else { // more than 1 like
        $likes = number_format_i18n($likes);
        return $before . ($more ? $more : sprintf(__('%d Likes', 'Berry'), $likes)) . $after;
    }
}
