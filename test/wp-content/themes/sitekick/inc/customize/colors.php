<?php

add_action( 'customize_register', function($wp_customize) {
  // $palette = current(get_theme_support('editor-color-palette'));

  $wp_customize->add_section( 'colors' , array(
    'title' => __('Colors', 'sitekick'),
    'priority' => 100
  ));

  $wp_customize->add_setting( 'colorscheme', array(
		'default' => 'light',
	) );

  $wp_customize->add_control( 'colorscheme', array(
    'type'    => 'radio',
    'label'    => __( 'Color Scheme', 'sitekick' ),
    'choices'  => array(
      'light'  => __( 'Light', 'sitekick' ),
      'dark'   => __( 'Dark', 'sitekick' )
    ),
    'section'  => 'colors',
    'priority' => 1,
  ) );

  $wp_customize->add_setting( 'textcolor', array(
		'default' => '#000000',
	) );

  $wp_customize->add_control( 'textcolor', array(
    'type'    => 'color',
    'label'    => __( 'Text Color', 'sitekick' ),
    'section'  => 'colors',
    'priority' => 1,
  ) );
});



