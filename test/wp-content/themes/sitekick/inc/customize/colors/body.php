<?php

add_action( 'customize_register', function($wp_customize) {
  $wp_customize->add_section( 'colors' , array(
    'title' => __('Basic Colors', 'sitekick'),
    'priority' => 1,
    'panel' => 'colors'
  ));

  $wp_customize->add_setting( 'textcolor', array(
		'default' => '#000000',
	) );

  $wp_customize->add_control( 'textcolor', array(
    'type'    => 'color',
    'label'    => __( 'Text Color', 'sitekick' ),
    'section'  => 'colors',
    'priority' => 10,
  ) );

  $wp_customize->add_setting( 'link-color', array(
		'default' => '#000000',
	) );

  $wp_customize->add_control( 'link-color', array(
    'type'    => 'color',
    'label'    => __( 'Link Color', 'sitekick' ),
    'section'  => 'colors',
    'priority' => 10,
  ) );

  $wp_customize->add_setting( 'border-color', array(
		'default' => '#aaaaaa',
	) );

  $wp_customize->add_control( 'border-color', array(
    'type'    => 'color',
    'label'    => __( 'Border Color', 'sitekick' ),
    'section'  => 'colors',
    'priority' => 10,
  ) );
});



