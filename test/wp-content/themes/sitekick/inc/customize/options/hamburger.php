<?php
add_action( 'customize_register', function($wp_customize) {
  $wp_customize->add_section(
    'hamburger',
    [
      'title' => __( 'Hamburger', 'sitekick' ),
      'priority' => 40,
      'capability' => 'edit_theme_options',
      'panel' => 'options'
    ]
  );

  // Hamburger Animation Style
  $wp_customize->add_setting(
    'hamburger_animation_style',
    array(
      'capability'        => 'edit_theme_options',
      'default'           => '3dx',
    )
  );

  $wp_customize->add_control(
    'hamburger_animation_style',
    [
      'type'     => 'select',
      'section'  => 'hamburger',
      'priority' => 10,
      'label'    => __('Hamburger Animation', 'sitekick' ),
      'description' => __('Choose your hamburger animation style.'),
      'choices'  => array_reduce([
        // Hamburger types
        '3dx',
        '3dy',
        '3dxy',
        'arrow',
        'arrowalt',
        'arrowturn',
        'boring',
        'collapse',
        'elastic',
        'emphatic',
        'minus',
        'slider',
        'spin',
        'spring',
        'stand',
        'squeeze',
        'vortex',
      ], function($result, $slug) {
        return array_merge($result, [
          $slug => __(ucwords($slug), 'sitekick')
        ]);
      }, [])
    ]
  );

   // Hamburger Animation Clockwise
   $wp_customize->add_setting(
    'hamburger_animation_clockwise',
    [
      'capability'        => 'edit_theme_options',
      'default'           => 1,
    ]
  );
  
  $wp_customize->add_control(
    new WP_Customize_Control(
      $wp_customize,
      'hamburger_animation_clockwise',
      array(
        'label'     => __( 'Clockwise', 'sitekick' ),
        'section'   => 'hamburger',
        'settings'  => 'hamburger_animation_clockwise',
        'type'      => 'checkbox',
      )
    )
  );
});
