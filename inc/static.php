<?php

function coffin_enqueue_scripts() {
    global $wp_styles,$pagenow,$wp_query;;

    $timer = @filemtime(TEMPLATEPATH .'/build/css/app.css');
    $jstimer = @filemtime(TEMPLATEPATH .'/build/js/app.js');
    wp_enqueue_style('coffin', get_template_directory_uri() . '/build/css/app.css' , array(), $timer , 'screen');
    //wp_enqueue_script( 'coffin', get_template_directory_uri() . '/build/js/app.js' , array(), $jstimer , true );

    $custom_css = "";
    wp_add_inline_style( 'coffin', $custom_css );

    $this_user = wp_get_current_user();

    wp_localize_script('coffin', 'obvInit', array(
        'api' => get_rest_url(),
        'nonce' =>wp_create_nonce('wp_rest'),
    ));

}
add_action( 'wp_enqueue_scripts', 'coffin_enqueue_scripts' );