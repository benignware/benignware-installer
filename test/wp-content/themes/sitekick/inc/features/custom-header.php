<?php
add_action( 'after_setup_theme', function() {
  // Add header image support
  // add_theme_support('custom-header', array(
  //   'width'         => 1680,
  //   'height'        => 600,
  //   'flex-width'    => true,
  //   'flex-height'   => true,
  //   'default-image' => sitekick_asset('img/header.{jpg,png,gif,svg}')
  // ));
});

// Custom header support
add_action( 'wp_enqueue_scripts', function() {
  // Get custom header meta from customizer with defaults.
  // $default_header_meta = array(
	// 	'background_position' => 'left',
	// 	'background_size'     => 'cover'
  // );
  // $header_meta = get_option( 'custom_header_meta', $default_header_meta );

  // // Render header meta as CSS parameters.
  // $header_styles = '';
  // foreach ( $header_meta as $key => $val ) {
  //   $header_styles .= str_replace( '_', '-', $key ) . ':' . $val . ';';
  // }

	// $header_image = get_header_image();

  // // Render header image as CSS parameters.
  // if ( $header_image ) {
	// 	$header_styles .= 'background-image: url(' . $header_image->url . ');';
	// 	$header_styles .= 'width:' . (string) $header_image->width . 'px;';
	// 	$header_styles .= 'height:' . (string) $header_image->height . 'px;';
	// 	$header_styles .= 'object-fit:' . $header_meta['background_size'] . ';';
	// 	$header_styles .= 'height: 100%;';
  // }

  // Finally render CSS selector with parameters.
  // $custom_css = ".wp-custom-header img { $header_styles }";

  $properties = array_filter(
    array(
      'background-color' => get_theme_mod('custom_header_background_color'),
      'background-image' => get_theme_mod('custom_header_background_image') ? 'url(' . get_theme_mod('custom_header_background_image') . ')' : '',
    )
  );

  $custom_header_css = implode(';', array_values(array_map(
    function($key, $value) { 
      return "$key: $value;\n";
    },
    array_keys($properties),
    $properties
  )));

  $custom_css =  <<< EOT
.custom-header {
  $custom_header_css
}
EOT;

  wp_register_style( 'sitekick-custom-header-inline-style', false );
  wp_enqueue_style( 'sitekick-custom-header-inline-style' );
  wp_add_inline_style('sitekick-custom-header-inline-style', $custom_css );
});

add_action( 'customize_register', function($wp_customize) {
  $theme_vars = get_theme_vars();

  // Show Site Branding
  $wp_customize->add_setting('custom_header_show_site_branding', array(
    'default' => 0,
  ));
  
  $wp_customize->add_control(
    new WP_Customize_Control(
      $wp_customize,
      'custom_header_show_site_branding',
      array(
          'label'     => __('Show Site Branding', 'sitekick'),
          'section'   => 'header_image',
          'settings'  => 'custom_header_show_site_branding',
          'type'      => 'checkbox',
      )
    )
  );

  // Image Full Width
  $wp_customize->add_setting('custom_header_image_full_width', array(
    'default' => '1',
  ));

  $wp_customize->add_control(
    new WP_Customize_Control(
      $wp_customize,
      'custom_header_image_full_width',
      array(
          'label'     => __('Full Width', 'sitekick'),
          'section'   => 'header_image',
          'settings'  => 'custom_header_image_full_width',
          'type'      => 'checkbox',
      )
    )
  );

  // Header Background Color
  $wp_customize->add_setting('custom_header_background_color', array(
    // 'default' => '#'
  ));

  $wp_customize->add_control(
    new WP_Customize_Control(
      $wp_customize,
      'custom_header_background_color',
      array(
          'label'     => __('Header Background Color', 'sitekick'),
          'section'   => 'header_image',
          'settings'  => 'custom_header_background_color',
          'type'      => 'color',
      )
    )
  );

  // Header Background Image
  $wp_customize->add_setting('custom_header_background_image', array(
    // 'default' => $theme_vars['']
  ));

  $wp_customize->add_control(
    new WP_Customize_Image_Control(
        $wp_customize,
        'logo',
        array(
            'label'      => __( 'Header Background Image', 'theme_name' ),
            'section'    => 'header_image',
            'settings'   => 'custom_header_background_image'
        )
    )
  );
});
