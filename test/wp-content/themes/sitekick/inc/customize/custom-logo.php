<?php

add_action( 'after_setup_theme', function() {
  // Add logo support
  add_theme_support( 'custom-logo', array(
    'height'      => 40,
    'width'       => 80,
    'flex-height' => false,
    'flex-width'  => true,
    'header-text' => array(
      'site-title',
      'site-description'
    ),
    'default-image' => sitekick_asset('img/logo.{jpg,png,gif,svg}')
  ));
});
