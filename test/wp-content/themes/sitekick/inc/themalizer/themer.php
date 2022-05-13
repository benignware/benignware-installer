<?php

require_once 'helpers.php';
require_once 'functions.php';
require_once 'actions.php';
require_once 'customizer.php';
require_once 'custom-css.php';

// function enqueue_theme_custom_css() {
//   if (wp_doing_ajax() && $_GET['action'] === 'theme_resources') {
//     return;
//   }

//   $css = get_theme_custom_css();

//   wp_register_style('theme-vars', false );
//   wp_enqueue_style('theme-vars');
//   wp_add_inline_style('theme-vars', $css );
// }

// add_action( 'wp_enqueue_scripts', 'enqueue_theme_custom_css', 100);
// add_action( 'enqueue_block_editor_assets', 'enqueue_theme_custom_css', 100);
