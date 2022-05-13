<?php

add_action( 'customize_register', function($wp_customize) {
  $wp_customize->add_panel( 'colors', 
    array(
      'title' => __( 'Color Settings', 'sitekick' ),
      'description' => __( 'Theme Color Settings', 'sitekick' ),
      'capability' => 'edit_theme_options',
    )
  );
});
