<!DOCTYPE html>
<?php global $berrySetting; ?>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="initial-scale=1.0,minimal-ui">
    <?php wp_head(); ?>
    <link type="image/vnd.microsoft.icon" href="<?php echo ($berrySetting->get_setting('favicon') ? $berrySetting->get_setting('favicon') :  get_template_directory_uri() . '/build/images/favicon.png'); ?>" rel="shortcut icon">
</head>

<body <?php body_class(); ?>>
    <?php
    global $berrySetting;
    if ($berrySetting->get_setting('darkmode')) : ?>
        <script>
            window.DEFAULT_THEME = "auto";
            if (localStorage.getItem("theme") == null) {
                localStorage.setItem("theme", window.DEFAULT_THEME);
            }
            if (localStorage.getItem("theme") == "dark") {
                document.querySelector("body").classList.add("dark");
            }
            if (localStorage.getItem("theme") == "auto") {
                document.querySelector("body").classList.add("auto");
            }
        </script>
    <?php endif; ?>
    <div class="surface-content">
        <header class="site-header">
            <?php if (has_nav_menu('berry')) : ?>
                <div class="topNav">
                    <?php wp_nav_menu(array('theme_location' => 'berry', 'menu_class' => 'subnav-ul', 'container' => 'ul')); ?>
                </div>
            <?php endif; ?>
            <div class="container">
                <h1 class="site-title">
                    <a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a>
                </h1>
                <p class="site-description"><?php echo get_bloginfo('description', 'display'); ?></p>
            </div>
        </header>