<?php
/**
 * Displays header site branding
 *
 * @package Benignware
 * @subpackage sitekick
 * @since 1.0.0
 */

$blog_info    = get_bloginfo( 'name' );
$description  = get_bloginfo( 'description', 'display' );
$show_title = display_header_text();
$header_class = $show_title ? 'site-title' : 'screen-reader-text';

$show_site_branding = get_theme_mod('custom_header_show_site_branding');
?>
<?php if ($show_site_branding): ?>
	<div
		class="custom-header-content mt-2 mt-lg-4 py-2 py-lg-4<?=
			$has_header_image ? ' position-absolute' : '';
		?>">	
		<div class="site-branding">
			<div class="container d-flex">
				<?php if (has_custom_logo() && ! has_header_image()): ?>
					<div class="site-logo"><?php the_custom_logo(); ?></div>
				<?php else: ?>
					<?php if ( is_front_page() && ! is_paged() ) : ?>
						<h1 class="<?php echo esc_attr( $header_class ); ?>"><?php echo esc_html( $blog_info ); ?></h1>
					<?php elseif ( is_front_page() || is_home() ) : ?>
						<h1 class="<?php echo esc_attr( $header_class ); ?>"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( $blog_info ); ?></a></h1>
					<?php else : ?>
						<p class="<?php echo esc_attr( $header_class ); ?>"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( $blog_info ); ?></a></p>
					<?php endif; ?>
				<?php endif; ?>

				<?php if ( display_header_text() === true ) : ?>
					<p class="site-description">
						<?= get_bloginfo( 'description', 'display' ); ?>
					</p>
				<?php endif; ?>

				<?php
						wp_nav_menu(
							array(
								'theme_location'  => 'quickstart',
								'menu_class'      => 'nav navbar-nav me-auto mb-2 mb-lg-0',
								'container'				=> 'nav',
								'container_class' => 'navbar navbar-dark navbar-expand',
								'items_wrap'      => '<ul id="quickstart-menu-list" class="%2$s">%3$s</ul>',
								'fallback_cb'     => false,
							)
						);
					?>
			</div>
		</div><!-- .site-branding -->
	</div>
<?php endif; ?>
