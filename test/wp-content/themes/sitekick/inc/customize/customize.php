<?php

add_action( 'customize_register', function($wp_customize) {
  $wp_customize->add_panel( 'options', 
    array(
      'title' => __( 'Theme Options', 'sitekick' ),
      'description' => __( 'Theme Modifications like color scheme, theme texts and layout preferences can be done here', 'sitekick' ),
      'capability' => 'edit_theme_options',
    )
  );
});