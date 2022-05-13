<?php

function _theme_resources_action() {
  global $wp_styles;

  WP_Screen::get('front')->set_current_screen();

  ob_start();
  wp_head();
  ob_end_clean();

  $resources = _load_theme_resources();
  // $resources = $wp_styles;

  $output = json_encode($resources, JSON_PRETTY_PRINT);

  header('Content-Type: application/json');

  echo $output;

  wp_die();
};

add_action('wp_ajax_nopriv_theme_resources', '_theme_resources_action');
add_action('wp_ajax_theme_resource', '_theme_resources_action');