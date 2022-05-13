<?php
require get_template_directory() . '/inc/template-functions/get-asset.php';

use function benignware\bootstrap_hooks\get_markup;
use function benignware\sitekick\get_asset;

@ini_set( 'upload_max_size' , '128M' );
@ini_set( 'post_max_size', '128M');
@ini_set( 'max_execution_time', '300' );
/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Benignware
 * @subpackage sitekick
 * @since 1.0.0
 */

// This theme requires WordPress 5.3 or later.
if ( version_compare( $GLOBALS['wp_version'], '5.3', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

// Environment
$inc_env = sprintf('%s/inc/env/env-%s.php', get_template_directory(), wp_get_environment_type());

if (file_exists($inc_env)) {
	require $inc_env;
}

// Helpers
require get_template_directory() . '/inc/helpers.php';



// Template functions


require get_template_directory() . '/inc/template-functions/get-icon.php';
require get_template_directory() . '/inc/template-functions/get-login-form.php';
require get_template_directory() . '/inc/template-functions/get-submenu.php';

require get_template_directory() . '/inc/template-functions/is-active-link.php';
require get_template_directory() . '/inc/template-functions/widget-class.php';
require get_template_directory() . '/inc/template-functions/post-title-class.php';


// Integration
require get_template_directory() . '/inc/integration/bootstrap-hooks/bootstrap-hooks.php';
require get_template_directory() . '/inc/integration/woocommerce/woocommerce.php';
require get_template_directory() . '/inc/integration/wc-memberships/wc-memberships.php';
require get_template_directory() . '/inc/integration/bbpress/bbpress.php';
require get_template_directory() . '/inc/integration/wordpress-seo/wordpress-seo.php';
require get_template_directory() . '/inc/integration/raudio/raudio.php';

// Features
require get_template_directory() . '/inc/themalizer/themer.php';
//
require get_template_directory() . '/inc/features/avatar.php';
require get_template_directory() . '/inc/features/turbo.php';
require get_template_directory() . '/inc/features/account.php';
require get_template_directory() . '/inc/features/widgets.php';
require get_template_directory() . '/inc/features/custom-logo.php';
require get_template_directory() . '/inc/features/gallery/gallery.php';
require get_template_directory() . '/inc/features/block-query.php';

// Customize
require get_template_directory() . '/inc/customize/custom-header.php';
require get_template_directory() . '/inc/customize/custom-logo.php';
// require get_template_directory() . '/inc/customize/colors.php';

require get_template_directory() . '/inc/customize/options/panel.php';
require get_template_directory() . '/inc/customize/options/layout.php';
require get_template_directory() . '/inc/customize/options/typography.php';
require get_template_directory() . '/inc/customize/options/hamburger.php';
require get_template_directory() . '/inc/customize/colors/panel.php';
require get_template_directory() . '/inc/customize/colors/scheme.php';
require get_template_directory() . '/inc/customize/colors/body.php';
require get_template_directory() . '/inc/customize/colors/palette.php';
// require get_template_directory() . '/inc/customize/theme-options.php';
// require get_template_directory() . '/inc/customize/colors.php';
// require get_template_directory() . '/inc/customize/typography.php';
// require get_template_directory() . '/inc/customize/twentytwentyone.php';

add_action( 'wp_enqueue_scripts', function() {
	wp_enqueue_style( 'sitekick', get_template_directory_uri() . '/public/main.css', array(), wp_get_theme()->get( 'Version' ) );
	wp_enqueue_script('sitekick-vendor', get_template_directory_uri() . '/public/vendor.js', '', wp_get_theme()->get( 'Version' ));
	wp_enqueue_script('sitekick-main', get_template_directory_uri() . '/public/main.js', array('sitekick-vendor'), wp_get_theme()->get( 'Version' ));

	// $theme_mods = get_theme_mods();
	// $theme_vars = array_filter($theme_mods, 'is_string');

	// $custom_css = sprintf(":root {\n%s\n}", implode("\n", array_map(function($key, $value) {
	// 	return sprintf("\t--%s: %s;", str_replace('_', '-', $key), $value);
	// }, array_keys($theme_vars), array_values($theme_vars))));
	// wp_register_style( 'sitekick-custom', false );
  // wp_enqueue_style( 'sitekick-custom' );
  // wp_add_inline_style('sitekick-custom', $custom_css);
});

// Theme setup
if ( ! function_exists( 'sitekick_setup' ) ) {
	function sitekick_setup() {
		load_theme_textdomain( 'sitekick', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * This theme does not use a hard-coded <title> tag in the document head,
		 * WordPress will provide it for us.
		 */
		add_theme_support( 'title-tag' );

		add_post_type_support('page', 'excerpt');

		/**
		 * Add post-formats support.
		 */
		add_theme_support(
			'post-formats',
			array(
				'link',
				'aside',
				'gallery',
				'image',
				'quote',
				'status',
				'video',
				'audio',
				'chat',
			)
		);

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 1440, 480, true );

		add_image_size( 'post-thumbnail-md', 768, 480, true );
		add_image_size( 'post-thumbnail-sm', 480, 520, true );

		add_theme_support( 'responsive-thumbnails', [
			'post-thumbnail' => [
				480 => 'post-thumbnail-sm',
				768 => 'post-thumbnail-md'
			]
		] );

		//add_image_size( 'thumbnail', 335, 230, true );
		update_option( 'thumbnail_size_w', 230 );
		update_option( 'thumbnail_size_h', 230 );
		update_option( 'thumbnail_crop', 1 );

		//add_image_size( 'medium', 700, 500, true );
		update_option( 'medium_size_w', 540 );
		update_option( 'medium_size_h', 320 );
		update_option( 'medium_crop', 1 );

		//add_image_size( 'large', 1062, 500, true );
		update_option( 'large_size_w', 795 );
		update_option( 'large_size_h', 495 );
		update_option( 'large_crop', 1 );

		// if (function_exists('add_responsive_thumbnail')) {
		// 	add_responsive_thumbnail('post-thumbnail', array(
		// 		480 => 'post-thumbnail-sm',
		// 		768 => 'post-thumbnail-md'
		// 	));
		// }

		register_nav_menus(
			array(
				'primary' => esc_html__( 'Primary Menu', 'sitekick' ),
				'secondary'  => __( 'Secondary Menu', 'sitekick' ),
				'social'  => __( 'Social Menu', 'sitekick' ),
				'footer'  => __( 'Footer Menu', 'sitekick' )
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
				'navigation-widgets',
			)
		);

		// Add custom logo support
		add_theme_support( 'custom-logo', array(
			'height'      => 40,
			'width'       => 80,
			'flex-height' => false,
			'flex-width'  => true,
			'header-text' => array(
				'site-title',
				'site-description'
			)
		));
	
		// Add header image support
		add_theme_support('custom-header', array(
			'width'         => 1680,
			'height'        => 600,
			'flex-width'    => true,
			'flex-height'   => true,
			'default-image' => get_asset('img/header.{jpg,png,gif,svg}')
		));


		// Custom background support
		add_theme_support( 'custom-background', [
			'default-color'          => '#ffffff',
			'default-image'          => get_asset('img/bg.{jpg,png,gif,svg}'),
			'default-repeat'         => 'repeat',
			'default-position-x'     => 'left',
			'default-position-y'     => 'top',
			'default-size'           => 'auto',
			'default-attachment'     => 'scroll',
			// 'wp-head-callback'       => '_custom_background_cb',
			'admin-head-callback'    => '',
			'admin-preview-callback' => ''
		] );
		

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );
		$background_color = get_theme_mod( 'background_color', 'D1E4DD' );

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		// Add support for custom line height controls.
		add_theme_support( 'custom-line-height' );

		// Add support for experimental link color control.
		add_theme_support( 'experimental-link-color' );

		// Add support for experimental cover block spacing.
		add_theme_support( 'custom-spacing' );

		// Add support for custom units.
		// This was removed in WordPress 5.6 but is still required to properly support WP 5.5.
		add_theme_support( 'custom-units' );

		// Add support for Bootstrap
		add_theme_support( 'bootstrap' );

		// Editor Theme Palette
		add_theme_support( 'editor-color-palette', array(
			array(
					'name'  => esc_attr__( 'Primary', 'sitekick' ),
					'slug'  => 'primary',
					'color' => get_theme_mod('primary', '#0d6efd')
			),
			array(
					'name'  => esc_attr__( 'Secondary', 'sitekick' ),
					'slug'  => 'secondary',
					'color' => get_theme_mod('secondary', '#6c757d'),
			),
			array(
				'name'  => esc_attr__( 'Success', 'sitekick' ),
				'slug'  => 'success',
				'color' => get_theme_mod('success', '#198754'),
			),
			array(
					'name'  => esc_attr__( 'Info', 'sitekick' ),
					'slug'  => 'info',
					'color' => get_theme_mod('info', '#0dcaf0'),
			),
			array(
				'name'  => esc_attr__( 'Warning', 'sitekick' ),
				'slug'  => 'warning',
				'color' => get_theme_mod('warning', '#ffc107'),
			),
			array(
					'name'  => esc_attr__( 'Danger', 'sitekick' ),
					'slug'  => 'danger',
					'color' => get_theme_mod('danger', '#dc3545'),
			),
			array(
					'name'  => esc_attr__( 'Light', 'sitekick' ),
					'slug'  => 'light',
					'color' => get_theme_mod('light', '#f8f9fa'),
			),
			array(
					'name'  => esc_attr__( 'Dark', 'sitekick' ),
					'slug'  => 'dark',
					'color' => get_theme_mod('dark', '#212529'),
			),
		));

		add_theme_support( 'disable-custom-colors' );
		add_theme_support( 'disable-custom-gradients' );

		// Starter content
		// add_theme_support( 'starter-content', array(
		// 	// Content Section for Widgets
		// 	'widgets' => array(
		// 		// Place three core-defined widgets in the sidebar area.
		// 		'sidebar-1' => array(
		// 			'text_business_info',
		// 			'search',
		// 			'text_about',
		// 		),
		// 	)
		// ));
	}
}
add_action( 'after_setup_theme', 'sitekick_setup' );


/**
 * Register widget area.
 *
 * @since 1.0.0
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 *
 * @return void
 */
function sitekick_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Blog Sidebar', 'twentyseventeen' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar', 'twentyseventeen' ),
		'before_sidebar' => '<div class="sidebar row g-4">',
		'after_sidebar' => '</div>',
		'before_widget' => '<div class="col-sm-12 col-md-6 col-lg-12"><div id="%1$s" class="card %2$s">',
		'after_widget' 	=> '</div></div>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer', 'twentyseventeen' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Add widgets here to appear in your footer.', 'twentyseventeen' ),
	) );
}
add_action( 'widgets_init', 'sitekick_widgets_init' );

/**
 * Enqueue scripts and styles.
 *
 * @since 1.0.0
 *
 * @return void
 */


add_action('get_header', function() {
	remove_action('wp_head', '_admin_bar_bump_cb');
});

add_filter('is_active_sidebar', function($is_active, $id) {
	if (is_search()) {
		return $is_active;
	}

	if (get_post_type() !== 'post') {
		return false;
	}

	return (is_post_type_archive() || !is_singular()) ? get_theme_mod( 'blog_sidebar', $is_active ) : $is_active;
}, 10, 2);

add_filter('excerpt_more', function ($more) {
  global $post;

  return ' <a class="readmore stretched-link" href="'. get_permalink($post->ID) . '">' . __('Read more') . ' »</a>';
}, 11);

add_filter('the_excerpt', function($excerpt) {
	$excerpt_more = apply_filters('excerpt_more', ' ' . '[&hellip;]' );
	$excerpt = str_replace($excerpt_more, '', $excerpt);

	$style = "display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;  
  overflow: hidden;";

	return "<span style=\"$style\">$excerpt</span>" . $excerpt_more;
}, 15);

add_filter( 'excerpt_length', function( $length ) {
  return 40;
}, 1000 );


/** Turbo */
add_filter('turbo_eval', function($eval, $url) {
	return strpos($url, 'main.js') === FALSE;
}, 10, 2);


// add_action( 'wp_mail_failed', function( $error ) {
// 	die( '<pre>' . var_dump($error) );
// } );

add_filter( 'get_the_archive_title', function ($title, $original_title) {
	return $original_title;
}, 10, 2);

// Remove Edit post link
add_filter( 'edit_post_link', '__return_false' );


// Account menu
add_filter ( 'woocommerce_account_menu_items', function() {
	$myorder = array(
		'profile'						 => __( 'Profile', 'sitekick' ),
		'edit-account'       => __( 'Edit Account', 'sitekick' ),
		'dashboard'          => __( 'Dashboard', 'sitekick' ),
		'orders'             => __( 'Orders', 'sitekick' ),
		'downloads'          => __( 'Downloads', 'sitekick' ),
		'edit-address'       => __( 'Addresses', 'sitekick' ),
		'payment-methods'    => __( 'Payment Methods', 'sitekick' ),
		'customer-logout'    => __( 'Logout', 'sitekick' ),
	);

	return $myorder;
} );

// Remove block styles
add_action( 'wp_enqueue_scripts', function() {
	wp_dequeue_style( 'wp-block-library' );
});


add_filter( 'nav_menu_submenu_css_class', function( $classes, $args = [], $depth = 0 ) {
	if (in_array('dropdown-menu', $classes)) {
		$classes[] = 'dropdown-menu-' . get_theme_mod('colorscheme', 'light');
		$classes[] = 'dropdown-menu-lg-end'; // TODO: Account for menus not being at right end
	}

	return $classes;
}, 10, 3);

// Widget Cards
add_filter( 'sitekick_widget_class', function($classes) {
	$colorscheme = get_theme_mod('colorscheme', 'light');

	return in_array('card', $classes)
		? array_merge($classes, [
			sprintf('bg-%s text-%s text-auto', $colorscheme, $colorscheme !== 'light' ? 'light' : 'dark')
		]) : $classes;
});

// Sidebar Columns
// add_filter( 'sitekick_widget_class', function($classes, $class, $widget_id, $params) {
// 	$colorscheme = get_theme_mod('colorscheme', 'light');

// 	$widget_area = current($params);

// 	return $widget_area['id'] === 'sidebar-1'
// 		? array_merge($classes, [
// 			'col-sm-12 col-md-4 col-lg-12'
// 		]) : $classes;
// }, 10, 4);

add_filter( 'post_class', function($classes) {
	if (in_array('card', $classes)) {
		$colorscheme = get_theme_mod('colorscheme', 'light');
		return array_merge($classes, [
			sprintf('bg-%s text-%s text-auto', $colorscheme, $colorscheme !== 'light' ? 'light' : 'dark')
		]);
	}

	return $classes;
});

add_filter( 'sitekick_product_thumbnail_class', function($classes) {
	$classes[] = 'card-img-top';

	return $classes;
});

add_filter( 'sitekick_product_sale_flash_class', function($classes) {
	$classes[] = 'badge bg-primary position-absolute m-3';

	return $classes;
});

add_action( 'woocommerce_before_shop_loop_item_title', function() {
	echo '<div class="card-body">';
});

add_action( 'woocommerce_after_shop_loop_item', function() {
	echo '</div>';
});

add_filter( 'sitekick_product_add_to_card_link_class', function($classes) {
	$classes[] = 'btn btn-primary';

	return $classes;
});

add_filter( 'sitekick_product_loop_title_class', function($classes) {
	$classes[] = 'card-title h4';

	return $classes;
});

add_filter( 'sitekick_product_loop_link_class', function($classes) {
	$classes[] = 'stretched-link text-decoration-none';

	return $classes;
});

add_filter( 'sitekick_product_result_count_ordering_wrapper_class', function($classes) {
	$classes[] = 'clearfix d-flex justify-content-between align-items-center my-4';

	return $classes;
});

add_filter( 'nav_menu_link_attributes', function($atts, $menu_item, $args, $depth) {
  $classes = !empty($atts['class']) ? explode(' ', $atts['class']) : [];
  $classes = apply_filters('sitekick_nav_menu_link_class', $classes, $menu_item, $args, $depth);

  return array_merge($atts, [
    'class' => implode(' ', $classes)
  ]);
}, 10, 4);

add_filter('sitekick_avatar_class', function($classes) {
	return array_merge(
		$classes,
		['rounded-circle border bg-light']
	);
});
