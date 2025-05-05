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
 * @since Hera 0.2.0
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
        $output .= '<div class="link-items">';
        foreach ($bookmarks as $bookmark) {
            $image = $bookmark->link_image ? '<img src="' . $bookmark->link_image . '" alt="' . $bookmark->link_name . '" class="avatar">' : get_avatar($bookmark->link_notes, 64);
            $output .=  '<a class="link-item" href="' . $bookmark->link_url . '" title="' . $bookmark->link_description . '" target="_blank" >
             ' . $image . '
             <strong>' . $bookmark->link_name . '</strong><span class="sitename">' . $bookmark->link_description . '</span></a>';
        }
        $output .= '</div>';
    } else {
        $output = __('No links yet', 'Hera');
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
            $result .=  '<h3 class="link-title">' . $linkcat->name . '</h3>';
            if ($linkcat->description) $result .= '<div class="link-description">' . $linkcat->description . '</div>';
            $result .=  get_the_link_items($linkcat->term_id);
        }
    } else {
        $result = get_the_link_items();
    }
    return $result;
}
