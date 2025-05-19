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
                <div class="site-description"><?php echo get_bloginfo('description', 'display'); ?></div>
                <div class="bar">
                    <form class="searchForm" action="<?php echo esc_url(home_url('/')); ?>" method="get">
                        <label class="metabar-predictiveSearch inputGroup">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path fill="currentColor" fill-rule="evenodd" d="M4.092 11.06a6.95 6.95 0 1 1 13.9 0 6.95 6.95 0 0 1-13.9 0m6.95-8.05a8.05 8.05 0 1 0 5.13 14.26l3.75 3.75a.56.56 0 1 0 .79-.79l-3.73-3.73A8.05 8.05 0 0 0 11.042 3z" clip-rule="evenodd"></path>
                            </svg>
                            <input class="textInput" type="search" name="s" placeholder="Search" required="true">
                        </label>
                    </form>
                    <?php if ($berrySetting->get_setting('rss')) : ?>
                        <svg class="svgIcon-use" width="25" height="25" fill="none">
                            <path d="M14.215 11.3l5.764-6.7h-1.366l-5.005 5.818L9.611 4.6H5l6.045 8.798L5 20.424h1.366l5.286-6.144 4.221 6.144h4.61L14.216 11.3zm-1.871 2.175l-.612-.876-4.874-6.97h2.098l3.933 5.625.613.876 5.112 7.312h-2.098l-4.172-5.966z" fill="currentColor"></path>
                        </svg>
                    <?php endif; ?>
                    <?php if ($berrySetting->get_setting('rss')) : ?>
                        <svg width="25" height="25" viewBox="0 0 256 256">
                            <path d="M228.646,34.7676a11.96514,11.96514,0,0,0-12.21778-2.0752L31.87109,105.19729a11.99915,11.99915,0,0,0,2.03467,22.93457L84,138.15139v61.833a11.8137,11.8137,0,0,0,7.40771,11.08593,12.17148,12.17148,0,0,0,4.66846.94434,11.83219,11.83219,0,0,0,8.40918-3.5459l28.59619-28.59619L175.2749,217.003a11.89844,11.89844,0,0,0,7.88819,3.00195,12.112,12.112,0,0,0,3.72265-.59082,11.89762,11.89762,0,0,0,8.01319-8.73925L232.5127,46.542A11.97177,11.97177,0,0,0,228.646,34.7676ZM32.2749,116.71877a3.86572,3.86572,0,0,1,2.522-4.07617L203.97217,46.18044,87.07227,130.60769,35.47461,120.28811A3.86618,3.86618,0,0,1,32.2749,116.71877Zm66.55322,86.09375A3.99976,3.99976,0,0,1,92,199.9844V143.72048l35.064,30.85669ZM224.71484,44.7549,187.10107,208.88772a4.0003,4.0003,0,0,1-6.5415,2.10937l-86.1543-75.8164,129.66309-93.645A3.80732,3.80732,0,0,1,224.71484,44.7549Z" fill="currentColor" />
                        </svg>
                    <?php endif; ?>
                    <?php if ($berrySetting->get_setting('rss')) : ?>
                        <a href="<?php echo get_feed_link() ?>" target="_blank" style="margin-left:auto;">
                            <svg viewBox="0 0 512 512" width="22" height="22">
                                <rect
                                    width="512" height="512"
                                    rx="15%"
                                    fill="#f80" />
                                <circle cx="145" cy="367" r="35" fill="#ffffff" />
                                <path fill="none" stroke="#ffffff" stroke-width="60" d="M109 241c89 0 162 73 162 162m114 0c0-152-124-276-276-276" />
                            </svg>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </header>