<?php
define('BERRY_VERSION', wp_get_theme()->get('Version'));
define('BERRY_SETTING_KEY', 'berry_setting');
define('BERRY_ARCHIVE_VIEW_KEY', 'berry_archive_view');
define('BERRY_POST_LIKE_KEY', 'berry_post_like');
define('BERRY_POST_VIEW_KEY', 'berry_post_view');

add_action('after_setup_theme', 'berry_setup');
function berry_setup()
{
    load_theme_textdomain('Berry', get_template_directory() . '/languages');
}

require('inc/setting.php');
require('inc/setup.php');
require('inc/comment.php');
require('inc/base.php');
