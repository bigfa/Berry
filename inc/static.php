<?php

function berry_enqueue_scripts()
{
  $timer = @filemtime(TEMPLATEPATH . '/build/css/app.css');
  //$jstimer = @filemtime(TEMPLATEPATH . '/build/js/app.js');
  wp_enqueue_style('berry', get_template_directory_uri() . '/build/css/misc.css', array(), $timer, 'screen');
  // wp_enqueue_script('berry', get_template_directory_uri() . '/build/js/app.js', array(), $jstimer, true);
  // wp_localize_script('berry', 'berry', array(
  //   'ajax_url' => admin_url('admin-ajax.php'),
  // ));

  $custom_css = "";
  wp_add_inline_style('berry', $custom_css);
}
add_action('wp_enqueue_scripts', 'berry_enqueue_scripts');
