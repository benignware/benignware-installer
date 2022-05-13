<?php

add_action( 'customize_register', function($wp_customize) {
  $wp_customize->add_section( 'color-scheme' , array(
    'title' => __('Color Scheme', 'sitekick'),
    'priority' => 100,
    'panel' => 'colors'
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
    'section'  => 'color-scheme',
    'priority' => 1,
  ) );
});



