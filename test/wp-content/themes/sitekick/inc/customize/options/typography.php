<?php

add_action( 'customize_register', function( $wp_customize ) {
  $fonts = [
    'Arial',
    'Times New Roman',
    'Courier New'
  ];

  // Add section 
  $wp_customize->add_section(
		'typography',
		array(
			'title'			=> __( 'Typography', 'sitekick' ),
			'description'	=> __( 'Customize text properties', 'sitekick' ),
      'panel' => 'options'
		)
	);

  // Font Family Base
	$wp_customize->add_setting(
		'font_family_base',
		array(
			'default'	=> $fonts[0]
		)
	);

  $wp_customize->add_control('font_family_base', array(
    'type' => 'select',
    'section' => 'typography',
    'label' => __('Font Family Base', 'sitekick'),
    'description' => 'Customize base font',
    'choices' => array_reduce($fonts, function($result, $current) {
      return array_merge($result, array(
        $current => __( $current ),
      ));
    }, array())
  ));

  // Headings Font Family
	$wp_customize->add_setting(
		'headings_font_family',
		array(
			'default'	=> $fonts[0]
		)
	);

  $wp_customize->add_control('headings_font_family', array(
    'type' => 'select',
    'section' => 'typography',
    'label' => __('Headings Font Family', 'sitekick'),
    'description' => 'Customize headings font',
    'choices' => array_reduce($fonts, function($result, $current) {
      return array_merge($result, array(
        $current => __( $current ),
      ));
    }, array())
  ));

  // Display Font Family
	$wp_customize->add_setting(
		'display_font_family',
		array(
			'default'	=> $fonts[0]
		)
	);

  $wp_customize->add_control('display_font_family', array(
    'type' => 'select',
    'section' => 'typography',
    'label' => __('Display Font Family', 'sitekick'),
    'description' => 'Customize display font',
    'choices' => array_reduce($fonts, function($result, $current) {
      return array_merge($result, array(
        $current => __( $current ),
      ));
    }, array())
  ));
});
