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
                <p class="site-description"><?php echo get_bloginfo('description', 'display'); ?><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path fill="currentColor" fill-rule="evenodd" d="M4.092 11.06a6.95 6.95 0 1 1 13.9 0 6.95 6.95 0 0 1-13.9 0m6.95-8.05a8.05 8.05 0 1 0 5.13 14.26l3.75 3.75a.56.56 0 1 0 .79-.79l-3.73-3.73A8.05 8.05 0 0 0 11.042 3z" clip-rule="evenodd"></path>
                    </svg></p>
            </div>
        </header>