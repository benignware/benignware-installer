<?php
/**
 * Displays the site navigation.
 *
 * @package Benignware
 * @subpackage sitekick
 * @since 1.0.0
 */

	$show_site_branding = get_theme_mod('custom_header_show_site_branding');
	// $show_custom_logo_in_navbar = has_custom_logo() && !$show_site_branding && !display_header_text();
	$show_custom_logo_in_navbar = false;

?>

<nav class="navbar navbar-expand-lg navbar-<?= get_theme_mod('colorscheme', 'light') ?> bg-<?= get_theme_mod('colorscheme', 'light') ?> border-bottom" aria-label="Main navigation">
	<div class="container">
		<?php get_template_part( 'template-parts/header/navbar-brand' ); ?>
		<button
			class="navbar-toggler collapsed p-0 border-0 hamburger hamburger--<?= get_theme_mod('hamburger_animation_style', '3dx'); ?><?= !get_theme_mod('hamburger_animation_clockwise', 1) ? '-r' : ''; ?>"
			type="button"
			data-bs-toggle="collapse"
			data-bs-target="#navbarCollapse"
			aria-label="Toggle navigation"
		>
			<span class="hamburger-box">
				<span class="hamburger-inner"></span>
			</span>
		</button>

		<div class="navbar-collapse collapse flex-grow-1" id="navbarCollapse">
			<?php
				wp_nav_menu(
					array(
						'theme_location'  => 'primary',
						'menu_class'      => 'menu-wrapper navbar-nav me-auto mb-2 mb-lg-0 align-items-center',
						'container' => false,
						'items_wrap'      => '<ul id="primary-menu-list" class="%2$s">%3$s</ul>',
						'fallback_cb'     => false,
					)
				);
			?>
			<?php
				wp_nav_menu(
					array(
						'theme_location'  => 'secondary',
						'menu_class'      => 'menu-wrapper navbar-nav ms-auto mb-2 mb-lg-0 align-items-center',
						'container' => false,
						'items_wrap'      => '<ul id="secondary-menu-list" class="%2$s">%3$s</ul>',
						'fallback_cb'     => false,
					)
				);
			?>
		</div>
	</div>
</nav>
