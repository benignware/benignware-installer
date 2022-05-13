<?php

add_action( 'customize_register', function($wp_customize) {
  $wp_customize->add_section(
    'layout',
    [
      'title' => __( 'Layout', 'sitekick' ),
      'priority' => 40,
      'capability' => 'edit_theme_options',
      'panel' => 'options'
    ]
  );

  // Blog content
  $wp_customize->add_setting(
    'blog_content',
    array(
      'capability'        => 'edit_theme_options',
      'default'           => 'content',
    )
  );

  $wp_customize->add_control(
    'blog_content',
    array(
      'type'     => 'radio',
      'section'  => 'layout',
      'priority' => 10,
      'label'    => __( 'On archive pages, posts show:', 'twentytwenty' ),
      'choices'  => array(
        'content'    => __( 'Full text', 'twentytwenty' ),
        'excerpt' => __( 'Excerpt', 'twentytwenty' ),
      ),
    )
  );

  // Blog sidebar
  $wp_customize->add_setting(
    'blog_sidebar',
    array(
      'capability'        => 'edit_theme_options',
      'default'           => '1',
    )
  );
  
  $wp_customize->add_control(
    new WP_Customize_Control(
      $wp_customize,
      'blog_sidebar',
      array(
        'label'     => __( 'On archive pages, show sidebar', 'twentytwenty' ),
        'section'   => 'layout',
        'settings'  => 'blog_sidebar',
        'type'      => 'checkbox',
      )
    )
  );

  // Blog columns
  $wp_customize->add_setting(
    'blog_columns',
    array(
      'capability'        => 'edit_theme_options',
      'default'           => '',
    )
  );
  
  $wp_customize->add_control(
    new WP_Customize_Control(
      $wp_customize,
      'blog_columns',
      array(
        'label'     => __( 'On archive pages, show column layout', 'twentytwenty' ),
        'section'   => 'layout',
        'settings'  => 'blog_columns',
        'type'      => 'checkbox',
      )
    )
  );
});