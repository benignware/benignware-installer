<?php

add_action( 'customize_register', function($wp_customize) {
  $palette = [
    [
      'name'  => esc_attr__( 'Primary', 'sitekick' ),
      'slug'  => 'primary',
      'color' => '#0d6efd'
    ],
    [
      'name'  => esc_attr__( 'Secondary', 'sitekick' ),
      'slug'  => 'secondary',
      'color' => '#6c757d'
    ],
    [
      'name'  => esc_attr__( 'Success', 'sitekick' ),
      'slug'  => 'success',
      'color' => '#198754'
    ],
    [
      'name'  => esc_attr__( 'Info', 'sitekick' ),
      'slug'  => 'info',
      'color' => '#0dcaf0'
    ],
    [
      'name'  => esc_attr__( 'Warning', 'sitekick' ),
      'slug'  => 'warning',
      'color' => '#ffc107'
    ],
    [
      'name'  => esc_attr__( 'Danger', 'sitekick' ),
      'slug'  => 'danger',
      'color' => '#dc3545'
    ],
    [
      'name'  => esc_attr__( 'Light', 'sitekick' ),
      'slug'  => 'light',
      'color' => '#f8f9fa'
    ],
    [
      'name'  => esc_attr__( 'Dark', 'sitekick' ),
      'slug'  => 'dark',
      'color' => '#212529'
    ]
  ];

  $wp_customize->add_section( 'palette' , array(
    'title' => __('Theme Colors', 'sitekick'),
    'priority' => 1,
    'panel' => 'colors'
  ));

  foreach ($palette as $color) {
    $wp_customize->add_setting( $color['slug'], array(
      'default' => $color['color'],
    ) );

    $wp_customize->add_control( $color['slug'], array(
      'type'    => 'color',
      'label'    => __( $color['name'], 'sitekick' ),
      'section'  => 'palette',
      'priority' => 10,
    ) );
  }
});



