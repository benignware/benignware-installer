<?php

$theme_palette = array(
  array(
    'name'  => esc_attr__( 'strong magenta', 'sitekick' ),
    'slug'  => 'strong-magenta',
    'color' => '#a156b4',
  ),
  array(
    'name'  => esc_attr__( 'light grayish magenta', 'sitekick' ),
    'slug'  => 'light-grayish-magenta',
    'color' => '#d0a5db',
  ),
  array(
    'name'  => esc_attr__( 'very light gray', 'sitekick' ),
    'slug'  => 'very-light-gray',
    'color' => '#eee',
  ),
  array(
    'name'  => esc_attr__( 'very dark gray', 'sitekick' ),
    'slug'  => 'very-dark-gray',
    'color' => '#444',
  ),
);

$theme_colors = ['primary', 'secondary', 'success', 'info', 'danger', 'warning', 'light', 'dark'];

add_action('customize_register', function($wp_customize) use ($theme_colors) {
  $theme_vars = get_theme_vars();

  // echo '<pre>';
  // echo var_dump($theme_vars);
  // echo '</pre>';
  // exit;

  $wp_customize->add_section( 'theme_colors' , array(
    'title' => 'Theme Colors',
    'priority' => 100
  ));

  foreach ($theme_colors as $name) {
    $setting = $name . '_color';
    // 'rgb(' . $theme_vars[$name . '-r'] . ',' . $theme_vars[$name . '-g'], $theme_vars[$name . '-b'] . ')',
    list($r, $g, $b) = array_map(function($key) use ($name, $theme_vars) {
      $obj = $theme_vars[$name . '-' . $key];

      return $obj->value ? $obj->value : $obj->default;
    }, ['r', 'g', 'b']);

    // $r = $theme_vars[$name . '-r']->value;
    // $g = $theme_vars[$name . '-g']->value;
    // $b = $theme_vars[$name . '-b']->value;

    $rgb = [$r, $g, $b];
    $value = 'rgb(' . implode(', ', $rgb) . ')';

    $hex = sprintf("#%02x%02x%02x", $rgb[0], $rgb[1], $rgb[2]);

    // echo 'NAME: ' . $name;
    // echo '<br/>';
    // echo 'VALUE: ' . $hex;
    // echo '<br/>';
    // echo '<br/>';

    $wp_customize->add_setting(
      $setting,
      array(
        'default'	=> $hex
        // 'transport'		=> 'postMessage'
      )
    );

    $wp_customize->add_control(
      new WP_Customize_Color_Control(
        $wp_customize,
        $setting,
        array(
          'label' => __($name . ' Color', 'sitekick'),
          'section' => 'theme_colors',
          'description' => 'Specify ' . $name . ' color',
          'settings' => $setting,
          'priority' => 10
        )
      )
    );
  }

  // Body Background Color
  $body_background_color = $theme_vars['body-background-color']->default;

	$wp_customize->add_setting(
		'body_background_color',
		array(
			'default'	=> $body_background_color,
			// 'transport'		=> 'postMessage'
		)
	);

  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize,
      'body_background_color',
      array(
        'label' => __('Body Background Color', 'sitekick'),
        'section' => 'theme_colors',
        'description' => 'Specify body background color',
        'settings' => 'body_background_color',
        'priority' => 10
      )
    )
  );

  // Body Text Color
  $body_text_color = $theme_vars['body-text-color']->default;

	$wp_customize->add_setting(
		'body_text_color',
		array(
			'default'	=> $body_text_color,
			// 'transport'		=> 'postMessage'
		)
	);

  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize,
      'body_text_color',
      array(
        'label' => __('Body Text Color', 'sitekick'),
        'section' => 'theme_colors',
        'description' => 'Specify body text color',
        'settings' => 'body_text_color',
        'priority' => 10
      )
    )
  );

  // foreach ($theme_colors as $color_slug => $color_setting) {
  //   $wp_customize->add_setting(
  //     $color_slug, array(
  //       'default' => $color_setting['default'],
  //       // 'type' => 'option',
  //       // 'capability' =>  'edit_theme_options'
  //     )
  //   );

    // $wp_customize->add_control(
    //   new WP_Customize_Color_Control(
    //     $wp_customize,
    //     $color_slug,
    //     array(
    //       'label' => $color_setting['label'],
    //       'section' => 'theme_colors',
    //       'settings' => $color_slug,
    //       'priority' => 10
    //     )
    //   )
    // );
  // }
}, 10);

add_filter('theme_variables', function($array) use ($theme_colors) {
  // print_r($theme_colors);

  $color_vars = array_reduce($theme_colors, function ($result, $name) {
    $setting = $name . '_color';

    $hex = get_theme_mod($setting);

    list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");

    // echo $name;
    // echo $hex;
    // print_r([$r, $g, $b]);
    // echo '<br/>';
    // echo '<br/>';
    // exit;

    return array_merge(
      $result,
      array(
        $name . '-r' => $r,
        $name . '-g' => $g,
        $name . '-b' => $b,
      )
    );
  }, []);

  // print_r($color_vars);

  // exit;
   
  return array_merge($array, [
    'body-background-color' => get_theme_mod('body_background_color'),
    'body-text-color' => get_theme_mod('body_text_color')
  ], $color_vars);
});