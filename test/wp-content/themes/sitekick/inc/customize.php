<?php
add_action( 'customize_register', function( $wp_customize ) {
  /**
	 * Add 'Background Image' Section.
	 */
	$wp_customize->add_section(
		// $id
		'background_image',
		// $args
		array(
			'title'			=> __( 'Background Image', 'sitekick' ),
			// 'description'	=> __( 'Some description for the options in the Home Top section', 'theme-slug' ),
			// 'active_callback' => 'is_front_page',
		)
	);

  /**
	 * Add 'Home Top Background Image' Setting.
	 */
	$wp_customize->add_setting(
		// $id
		'background_image',
		// $args
		array(
			'default'		=> sitekick_asset('img/bg.jpg'),
			'sanitize_callback'	=> 'esc_url_raw',
			'transport'		=> 'postMessage'
		)
	);

  /**
	 * Add 'Background Image' image upload Control.
	 */
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			// $wp_customize object
			$wp_customize,
			// $id
			'background_image',
			// $args
			array(
				'settings'		=> 'background_image',
				'section'		=> 'background_image',
				'label'			=> __( 'Background Image', 'sitekick' ),
				'description'	=> __( 'Select the image to be used as background.', 'sitekick' )
			)
		)
	);
});